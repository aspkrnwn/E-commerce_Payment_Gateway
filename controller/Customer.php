<?php 

class Customer extends CI_Controller{

	public function __construct(){
		parent::__construct();
		
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$this->load->model('Global_model', 'Query');
		$this->load->model('customer/Customer_model', 'CustomerModel');
		date_default_timezone_set('Asia/Jakarta');
	}

	var $tblCustomers = "customers"; // set as role in session too

	// Template for web view
	public function template_web($url_view, $data){
		$this->load->view('public/templates/header', $data);
		$this->load->view($url_view);
		$this->load->view('public/templates/footer');
	}

	public function getUserData(){
		$username = $this->session->userdata('username');

		return $this->CustomerModel->findByUsername($username)->row();
	}

	public function login_action(){
		$username = $this->input->post("username");
		$password = md5($this->input->post("password"));

		$find = $this->CustomerModel->findByUsernameAndPassword($username, $password)->row();
		if(isset($find)){
			$this->set_session($find->id, $find->username, $this->tblCustomers);
			$this->session->set_flashdata('alert_success_login','Success Login');
			$this->update_last_login($find->id);
			redirect(base_url());
		}else{
			$this->session->set_flashdata('alert_failed_login','Invalid credentials');
			redirect("web/login");
		}
	}

	public function update_last_login($id){
		$today = Date('Y-m-d H:i:s');
		$this->Query->update($id, $this->tblCustomers, ["last_login" => $today]);
	}

	public function set_session($id, $username, $role){
		$data = ["id" => $id,"username" => $username, "role" => $role];

		$this->session->sess_expiration = 500;
		$this->session->set_userdata($data);
	}

	public function logout(){
		$this->destroy_session();
		echo "Success logout";
	}

	public function destroy_session(){
		$this->session->sess_destroy();
	}

	public function setting(){
		if($this->session->userdata('username') != NULL){
			$data['customer'] = $this->getUserData();
			$this->template_web("public/setting", $data);

		}else{
			echo "false";
		}
	}

	public function save_changes(){
		$today = Date('Y-m-d H:i:s');

		$data = [
			'username' => $this->input->post("username"),
			'email'		=> $this->input->post("email"),
			'full_name'	=> $this->input->post("full_name"),
			'updated_at'=> $today
		];

		$this->Query->update($this->input->post("id"), $this->tblCustomers, $data);

		// $this->destroy_session();
		$this->set_session($this->input->post("id"), $this->input->post("username"), $this->tblCustomers);

		redirect("customer/setting");
	}

	public function change_password(){
		$today = Date('Y-m-d H:i:s');
		$id = $this->input->post("id");
		$this->load->library('form_validation');

		$cek = $this->Query->findByIdResultRow($id, "customers");

		if($cek->password == md5($this->input->post("old_password"))){

			$this->form_validation->set_rules('old_password', 'Password Lama', 'required');
			$this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[5]');

		//set global message
			$this->form_validation->set_message('min_length', '{field} terlalu pendek!');

			if($this->form_validation->run() == TRUE){
				$data = [
					'password' => md5($this->input->post("new_password")),
					'updated_at'=> $today
				];

				$this->Query->update($id, $this->tblCustomers, $data);
				$this->session->set_flashdata('alert_success','Password Berhasil diubah');
			}else{
				$this->session->set_flashdata('alert_failed','Password Gagal diubah');
			}

		}else{
			$this->session->set_flashdata('alert_failed','Password lama salah');
		}

		redirect("customer/setting");
	}

	public function get_ip_address(){
		$data = json_decode(file_get_contents("http://ipinfo.io/"));

		return $data->ip;
	}

	public function checkLogin(){
		if($this->session->userdata('username') != NULL){
			return true;

		}else{
			return false;
		}
	}

	public function dateNow(){
		return Date('Y-m-d H:i:s');
	}

	public function generateRandomString($length = 4) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return strtoupper($randomString);
	}	

	// CHECKOUT================
	public function checkout(){
		$this->load->helper('string');
		$ip = $this->get_ip_address();
		$order_id = "STP" . $this->generateRandomString() .  Date('YmdHis');
		$data_user = $this->getUserData();
		$weight_total = 0;

		if($this->checkLogin()){
			$save_order_item = array();
			$data_cart = $this->CustomerModel->getCart($ip);
			$total = $this->CustomerModel->subtotalCart($ip);

			foreach($data_cart as $cart){
				$cek_berat = $this->Query->findByIdResultRow($cart->product_id, "products");
				$weight_total = $weight_total + ($cek_berat->weight * $cart->quantity);

				array_push($save_order_item, array(
					'order_id' => $order_id,
					'product_id' => $cart->product_id,
					'quantity' => $cart->quantity,
					'note' => ""
				));
			}

			$data_order = array(
				'id' => $order_id,
				'customer_id' => $data_user->id,
				'created_at' => $this->dateNow(),
				'updated_at' => "",
				'status_order' => "pending",
				'total_pay' => $total->result,
				'shipping_cost' => "",
				'note' => "",
				'receipt_number' => "",
				'delivery_service' => "",
				'is_deleted' => FALSE,
				'weight_total' => $weight_total
			);

			$this->Query->save('orders', $data_order);
			$this->db->insert_batch('order_item', $save_order_item); 

			redirect("web/checkout/".$order_id);
		}else{
			$this->session->set_flashdata('alert','Silahkan login dulu untuk melakukan order');
			echo "Anda belum login";
		}
	}

	public function myorder(){
		if($this->session->userdata('username') != NULL){
			$user_data = $this->getUserData();
			$data['customer'] = $user_data;
			$data['myorder'] = $this->CustomerModel->getMyOrder($user_data->id)->result();

			$this->template_web("public/myorder", $data);

		}else{
			echo "false";
		}
	}

	public function orders(){
		if($this->session->userdata('username') != NULL){
			$user_data = $this->getUserData();
			$data['customer'] = $user_data;
			$data['myorder'] = $this->CustomerModel->getMyOrder($user_data->id)->result();

			$this->template_web("public/orders", $data);

		}else{
			echo "false";
		}
	}

	// Live Search 
	public function fetch(){
		$user_data = $this->getUserData();
		$output = '';
		$query = '';

		if($this->input->post('query'))
		{
			$query = $this->input->post('query');
		}

		$data = $this->CustomerModel->fetch_data($query, $user_data->id);

		if ($data->num_rows() > 0) {
			foreach($data->result() as $row){
				$output .= '
				<div class="col-lg-12 col-md-12">
				<div class="single-latest-news">
				<div class="news-text-box">
				<h3><a href="single-news.html">Order ID : '. $row->order_id . '</a></h3>
				<p class="blog-meta">
				<span class="date"><i class="fas fa-calendar"></i>' . date("d F Y - H:i", strtotime($row->transaction_time)) . '</span>
				<span class="badge badge-pill badge-success">Transaksi Berhasil</span>
				</p>
				<a href="'.base_url("vtweb/invoice/".$row->order_id).'" class="read-more-btn">Invoice <i class="fas fa-angle-right"></i></a>
				</div>
				</div>
				</div>
				';
			}
		}

		echo $output;
	}

	public function updatedAt(){
		return Date('Y-m-d H:i:s');
	}

	public function terima_barang($order_id){
		$user_data = $this->getUserData();

		$order_update = [
			"updated_at" => $this->updatedAt(),
			"status_order" => "delivered"
		];
		$this->Query->update($order_id, "orders", $order_update);

		$this->session->set_flashdata('delivered_alert','Konfirmasi barang diterima berhasil !');
		redirect("customer/orders");
	}

	public function send_question(){
		// Preparing Send Email
		$subject = $this->input->post("subject");
		$nama_pengirim = $this->input->post("full_name");
		$email_pengirim = $this->input->post("email");
		$message = $this->input->post("message");
		$no_hp = $this->input->post("no_hp");
		$email_stp = "asepkurniawan093@gmail.com";


		$url_content = "public/question";
		$email_data["d"] = [
			"message" => $message
		];
		$this->send_email($email_stp, $subject, $url_content, $email_data, $email_pengirim, $nama_pengirim);
		$this->session->set_flashdata('alert','This order updated');
		redirect("web/contact/");
	}

	public function send_email($email_stp, $subject, $url_content, $email_data, $email_pengirim, $nama_pengirim){
		$this->load->library('mailer');
		$content=$this->load->view($url_content, $email_data, true);

		$sendmail = array(
			'email_penerima'=>$email_stp,      
			'subjek'=> $subject,      
			'content'=>$content
		);

		$send = $this->mailer->send_from_customer($sendmail, $email_pengirim, $nama_pengirim); 
	}
}