<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vtweb extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
	{
		parent::__construct();
		$params = array('server_key' => 'SB-Mid-server-61yosnu5NZPT-QCEd-wzios0', 'production' => false);
		$this->load->library('veritrans');
		$this->veritrans->config($params);
		$this->load->helper('url');

		$this->load->model('Global_model', 'Query');
		$this->load->model('customer/Customer_model', 'Customer');
		$this->load->model('admin/Admin_model', 'AdminModel');
		
	}

	public function getUserData(){
		$username = $this->session->userdata('username');

		return $this->Customer->findByUsername($username)->row();
	}

	public function vtweb_checkout()
	{
		// Tangkap Inputan data dari form checkout
		$customer_id = $this->input->post("customer_id");
		$order_id = $this->input->post("order_id");
		$shipping_address = $this->input->post("shipping_address");
		$shipping_cost = $this->input->post("shipping_cost");
		$delivery_service = $this->input->post("delivery_service");

		// Update table order for ongkir 
		$update_order = array(
			"shipping_cost" => $shipping_cost,
			"shipping_address" => $shipping_address,
			"delivery_service" => $delivery_service
		);
		$this->Query->update($order_id, "orders", $update_order);

		// Query to Database get orders details
		$show_field = "orders.*, order_item.product_id, order_item.quantity, order_item.note, products.name, products.selling_price, products.id AS product_id";
		$fields = "orders.id = order_item.order_id";

		$orders = $this->Query->getDataOrders("orders", "order_item", $fields, $show_field, $order_id)->result();
		$total = $this->Query->getDataOrders("orders", "order_item", $fields, $show_field, $order_id)->row();

		$transaction_details = array(
			'order_id' 			=> $order_id,
			'gross_amount' 	=> $total->total_pay + $shipping_cost
		);

		// Populate items
		$items = array();
		foreach($orders as $item){
			$items[] = array(
				'id' => $item->product_id,
				'price' => $item->selling_price,
				'quantity' => $item->quantity,
				'name' => $item->name
			);
		}

		// Tambahan Data untuk ongkir
		$items[] = array(
			'id' => 'Kurir',
			'price' => $shipping_cost,
			'quantity' => 1,
			'name' => strtoupper($delivery_service)
		);

		// Populate customer's billing address
		$user_data = $this->getUserData();
		
		$billing_address = array(
			'first_name' 		=> $user_data->full_name,
			'last_name' 		=> "",
			'address' 			=> $shipping_address,
			'city' 				=> "",
			'postal_code' 	=> "",
			'phone' 				=> $user_data->no_hp,
			'country_code'	=> 'IDN'
		);

		// Populate customer's shipping address
		$shipping_address = array(
			'first_name' 	=> $user_data->full_name,
			'last_name' 	=> "",
			'address' 		=> $shipping_address,
			'city' 			=> "",
			'postal_code' => "",
			'phone' 			=> $user_data->no_hp,
			'country_code'=> 'IDN'
		);

		// Populate customer's Info
		$customer_details = array(
			'first_name' 			=> $user_data->full_name,
			'last_name' 			=> "",
			'email' 					=> $user_data->email,
			'phone' 					=> $user_data->no_hp,
			'billing_address' => $billing_address,
			'shipping_address'=> $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		// Uncomment 'credit_card_3d_secure' => true jika transaksi ingin diproses dengan 3DSecure.
		$transaction_data = array(
			'payment_type' 			=> 'vtweb', 
			'vtweb' 						=> array(
				//'enabled_payments' 	=> ['credit_card'],
				'credit_card_3d_secure' => true
			),
			'transaction_details'=> $transaction_details,
			'item_details' 			 => $items,
			'customer_details' 	 => $customer_details
		);

		try
		{
			$vtweb_url = $this->veritrans->vtweb_charge($transaction_data);
			header('Location: ' . $vtweb_url);
		} 
		catch (Exception $e) 
		{
			echo $e->getMessage();	
		}
		
	}

	public function finish_transaction(){
		$curl = curl_init();
		$order_id = $this->input->get('order_id');
		$bank_name;
		$va_number;

		// Query to Database get orders details
		$show_field = "order_item.product_id";
		$fields = "orders.id = order_item.order_id";
		$orders = $this->Query->getDataOrders("orders", "order_item", $fields, $show_field, $order_id)->result();
		$user_data = $this->getUserData();
		$customer_id = $user_data->id;

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/" . $order_id . "/status",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/json",
				"accept : application/json", 
				"authorization: Basic U0ItTWlkLXNlcnZlci02MXlvc251NU5aUFQtUUNFZC13emlvczA="
			),
		));

		$response = curl_exec($curl);
		$transaction_data = json_decode($response);

		// For BCA VA Number
		foreach ($transaction_data->va_numbers as $key ) {
			$va_number = $key->va_number;
			$bank_name = $key->bank;
		}

		$store_transaction = array(
			"transaction_id" => $transaction_data->transaction_id,
			"transaction_time" => $transaction_data->transaction_time,
			"gross_amount" => $transaction_data->gross_amount,
			"currency" => $transaction_data->currency,
			"order_id" => $transaction_data->order_id,
			"payment_type" => $transaction_data->payment_type,
			"status_code" => $transaction_data->status_code,
			"transaction_status" => $transaction_data->transaction_status,
			"merchant_id" => $transaction_data->merchant_id,
			"bank_name" => $bank_name,
			"va_number" => $va_number
		);

		$this->Query->save("transaction_history", $store_transaction);

		// Delete data in cart
		$this->bulk_delete_cart($orders, $customer_id);

		// Update Stok
		$item_products = $this->AdminModel->getItemProduct($order_id)->result();
		if (count($item_products) > 0 AND $item_products != NULL) {
			for($i = 0; $i < count($item_products); $i++ ){
				$product = $this->Query->findByIdResultRow($item_products[$i]->product_id, "products");

				$update_stok = [
					"stock" => $product->stock - $item_products[$i]->quantity
				];

				$this->Query->update($item_products[$i]->product_id, "products", $update_stok);
			}
		}
		

		// Redirect to show the invoice
		$this->session->set_flashdata('success_order','Order berhasil dibuat, silahkan lakukan pembayaran.');
		redirect("vtweb/invoice/".$order_id);
	}

	public function bulk_delete_cart($orders, $customer_id){
		$products = array();
		foreach($orders as $order){
			$products[] = $order->product_id;
		}

		$this->Query->bulk_delete_cart($products, $customer_id, "cart");
	}

	public function invoice($order_id){
		$user_data = $this->getUserData();

		$data["orders"] = $this->Customer->getInvoice($order_id, $user_data->id)->result();
		$data["order"] = $this->Customer->getInvoice($order_id, $user_data->id)->row();
		$data["customer_details"] = $user_data;

		$this->load->view('public/templates/header', $data);
		$this->load->view('public/invoice');
		$this->load->view('public/templates/footer');
	}

	public function notification()
	{
		echo 'test notification handler';
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);

		if($result){
			$notif = $this->veritrans->status($result->order_id);
		}

		error_log(print_r($result,TRUE));

		//notification handler sample

		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;

		if ($transaction == 'capture') {
		  // For credit card transaction, we need to check whether transaction is challenge by FDS or not
			if ($type == 'credit_card'){
				if($fraud == 'challenge'){
		      // TODO set payment status in merchant's database to 'Challenge by FDS'
		      // TODO merchant should decide whether this transaction is authorized or not in MAP
					echo "Transaction order_id: " . $order_id ." is challenged by FDS";
				} 
				else {
		      // TODO set payment status in merchant's database to 'Success'
					echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
				}
			}
		}
		else if ($transaction == 'settlement'){
		  // TODO set payment status in merchant's database to 'Settlement'
			echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
		} 
		else if($transaction == 'pending'){
		  // TODO set payment status in merchant's database to 'Pending'
			echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
		} 
		else if ($transaction == 'deny') {
		  // TODO set payment status in merchant's database to 'Denied'
			echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
		}

	}

	public function auto_update(){
		$all_data = $this->Customer->get_trx_for_update()->result();
		$update_transaction_history = array();

		if($all_data != NULL || count($all_data) > 0){
			for($i = 0; $i < count($all_data); $i++){
				$new_status = $this->veritrans->status($all_data[$i]->order_id);

				$update_transaction_history[] = array(
					'order_id' => $all_data[$i]->order_id,
					'transaction_status' => $new_status->transaction_status
				);

				if($new_status->transaction_status == 'settlement'){
					$update_orders = array(
						'id' => $all_data[$i]->order_id,
						'status_order' => 'waiting approval'
					);

					$this->Query->update($all_data[$i]->order_id, "orders", $update_orders);
				}else if($new_status->transaction_status == 'expire'){
					$update_orders = array(
						'id' => $all_data[$i]->order_id,
						'status_order' => 'expire'
					);

					$this->Query->update($all_data[$i]->order_id, "orders", $update_orders);
				}else if($new_status->transaction_status == 'pending'){
					$update_orders = array(
						'id' => $all_data[$i]->order_id,
						'status_order' => 'pending'
					);

					$this->Query->update($all_data[$i]->order_id, "orders", $update_orders);
				}else{
					$update_orders = array(
						'id' => $all_data[$i]->order_id,
						'status_order' => 'failed'
					);

					$this->Query->update($all_data[$i]->order_id, "orders", $update_orders);
				}
			}

			$this->db->update_batch('transaction_history', $update_transaction_history, 'order_id');
		}

		$msg = array(
			'status' => 'Auto update status is running'
		);

		echo json_encode($msg);
	}
}
