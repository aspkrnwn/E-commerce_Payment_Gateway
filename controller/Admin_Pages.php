<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('Global_model', 'Query');
		$this->load->model('admin/Admin_model', 'AdminModel');
		if($this->session->userdata('role') != 'admin'){
			redirect("admin/login/err", 'refresh');
		}
		
	}

	// ===========================================================================
	// Variables for table name
	var $tblProducts = "products";
	var $tblCategories = "categories";
	var $tblManagement = "management";
	var $tblOrders = "orders";
	var $tblCustomers = "customers";
	// ===========================================================================

	// Download PDF Files
	public function download_pdf($id, $table, $customer_id){

		// Populate the Data

		$data["detail_order"] = $this->AdminModel->detail_order_customer($customer_id, $id)->result();
		$data["detail_products"] = $this->AdminModel->detail_products($customer_id, $id)->result();

		// Generate menjadi PDF
		$this->load->library('mypdf');
		$this->mypdf->generate("admin/pdf/invoice", $data);
	}

	// Template for web view
	public function template_web($url_view, $data){
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/navbar');
		$this->load->view('admin/templates/sidebar');
		$this->load->view($url_view);
		$this->load->view('admin/templates/footer');
	}

	// Controller 
	public function getUserData(){
		$username = $this->session->userdata('username');

		return $this->AdminModel->findByUsername($username)->row();
	}
	public function index(){
		$data['user'] = $this->getUserData();
		$data['categories'] = $this->Query->coundDataInTable($this->tblCategories);
		$data['products'] = $this->Query->coundDataInTable($this->tblProducts);
		$data['customers'] = $this->Query->coundDataInTable($this->tblCustomers);
		$data['incoming'] = $this->AdminModel->new_incoming_orders()->result();
		$data['count_incoming'] = $this->AdminModel->new_incoming_orders()->num_rows();

		$this->template_web("admin/index", $data);
	}

	public function products(){
		$data['user'] = $this->getUserData();
		$data['title'] = "Products";
		$data['products'] = $this->Query->findAll($this->tblProducts);

		$this->template_web("admin/products", $data);
	}

	public function analysis(){
		$data['user'] = $this->getUserData();
		$data['title'] = "Analysis";

		// Chart Metadata
		$month = date('m');
		$year = date('Y');
		$start = date('Y-01-01');
		$end = date('Y-12-31');

		// Chart Model
		$data['product_sale'] = $this->AdminModel->product_sale()->result();
		$data['transactions_this_month'] = $this->AdminModel->transactions_this_month($year, $month)->result();
		$data['transactions_this_year_by_month'] = $this->AdminModel->transactions_this_year_by_month($start, $end)->result();
		$data['product_by_category'] = $this->AdminModel->product_by_category()->result();
		$data['count_product_sale'] = $this->AdminModel->count_product_sale()->result();

		$this->template_web("admin/analysis", $data);
	}

	public function categories(){
		$data['user'] = $this->getUserData();
		$data['title'] = "Categories";
		$data['categories'] = $this->Query->findAll($this->tblCategories);

		$this->template_web("admin/categories", $data);
	}

	public function delete(){
		$id = $this->input->post('id');
		$table = $this->input->post('table');

		switch ($table){
			case 'categories':
			$categoryInProducts = $this->AdminModel->findByCategoryId($id, $this->tblProducts)->num_rows();
			if($categoryInProducts > 0){
				$error = 1;
				echo $error;
			}else{
				$this->Query->softDelete($id, $table);
				$error = 0;
				echo $error;
			}
			break;

			case 'products':
			$this->Query->softDelete($id, $table);
			$error = 0;
			echo $error;
			break;
		}


	}

	public function updatedAt(){
		return Date('Y-m-d H:i:s');
	}

	public function add($param){
		$data['title'] = $param;
		$data['user'] = $this->getUserData();

		switch (strtolower($param)){
			case 'categories':
			$this->template_web("admin/forms/add_categories", $data);
			break;

			case 'products':
			$data['categories'] = $this->Query->findAll($this->tblCategories);
			$this->template_web("admin/forms/add_products", $data);
			break;

			default:
			echo "Oppss 404 not found!";
			break;
		}
	}

	public function edit($param, $id){
		$data['user'] = $this->getUserData();
		$data['title'] = $param;

		switch (strtolower($param)){
			case 'categories':
			$data['categories'] = $this->Query->findById($id, $this->tblCategories);
			$this->template_web("admin/forms/edit_categories", $data);
			break;

			case 'products':
			$data['categories'] = $this->Query->findAll($this->tblCategories);
			$data['products'] = $this->Query->findById($id, $this->tblProducts);
			$this->template_web("admin/forms/edit_products", $data);
			break;

			default:
			echo "Oppss 404 not found!";
			break;
		}
	}

	public function save_category(){
		$data = [
			'name' => $this->input->post("name"),
			'unit' => $this->input->post("unit"),
			'is_deleted' => FALSE
		];

		$this->Query->save($this->tblCategories, $data);
		$this->session->set_flashdata('alert','Category saved');
		redirect("admin/pages/categories");
	}

	public function update_category(){
		$id = $this->input->post("id");

		$data = [
			'name' => $this->input->post("name"),
			'unit' => $this->input->post("unit"),
			'is_deleted' => FALSE,
			'updated_at' => $this->updatedAt(),

		];

		$this->Query->update($id, $this->tblCategories, $data);
		$this->session->set_flashdata('alert','Category updated');
		redirect("admin/pages/categories");
	}

	public function save_product(){
		// NOTE : Handle jika tidak upload foto belum ada.

		if(!empty($_FILES['file']['name'])){

			// Set preference
			$config['upload_path'] = 'upload/images/products/';	
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size']    = '5000'; // max_size in kb
					$config['file_name'] = "products_".random_string('numeric', 5);

			//Load upload library
					$this->load->library('upload',$config);			

			// File upload
					if($this->upload->do_upload('file')){

				// Get data about the file
						$uploadData = $this->upload->data();

						$data = [
							'category_id' => $this->input->post("category_id"),
							'name' => $this->input->post("name"),
							'purchase_price' => $this->input->post("purchase_price"),
							'selling_price' => $this->input->post("selling_price"),
							'stock' => $this->input->post("stock"),
							'image' => $uploadData["file_name"],
							'is_deleted' => FALSE
						];

						$this->Query->save($this->tblProducts, $data);
						$this->session->set_flashdata('alert','Products saved');
					}
				}

				redirect("admin/pages/products");
			}

			public function update_product(){
				if(!empty($_FILES['file']['name'])){

			// Set preference
					$config['upload_path'] = 'upload/images/products/';	
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size']    = '5000'; // max_size in kb
					$config['file_name'] = "products_".random_string('numeric', 5);;

			//Load upload library
					$this->load->library('upload',$config);			

			// File upload
					if($this->upload->do_upload('file')){

				// Get data about the file
						$uploadData = $this->upload->data();

						$data = [
							'category_id' => $this->input->post("category_id"),
							'name' => $this->input->post("name"),
							'purchase_price' => $this->input->post("purchase_price"),
							'selling_price' => $this->input->post("selling_price"),
							'stock' => $this->input->post("stock"),
							'image' => $uploadData["file_name"],
							'is_deleted' => FALSE,
							'updated_at' => $this->updatedAt(),
						];

						$this->Query->update($this->input->post("id"), $this->tblProducts, $data);
					}
				}else{

			// If not update image
					$data = [
						'category_id' => $this->input->post("category_id"),
						'name' => $this->input->post("name"),
						'purchase_price' => $this->input->post("purchase_price"),
						'selling_price' => $this->input->post("selling_price"),
						'stock' => $this->input->post("stock"),
						'is_deleted' => FALSE,
						'updated_at' => $this->updatedAt(),
					];

					$this->Query->update($this->input->post("id"), $this->tblProducts, $data);
				}

				$this->session->set_flashdata('alert','Products updated');
				redirect("admin/pages/products");
			}

			public function change_profile_image(){
				if(!empty($_FILES['file']['name'])){
			// Set preference
					$config['upload_path'] = 'upload/images/admin/';	
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
						$config['max_size']    = '5000'; // max_size in kb
						$config['file_name'] = "admin_profile_".random_string('numeric', 5);;

			//Load upload library
						$this->load->library('upload',$config);			

			// File upload
						if($this->upload->do_upload('file')){

				// Get data about the file
							$uploadData = $this->upload->data();

							$data = [
								'image' => $uploadData["file_name"],
								'updated_at' => $this->updatedAt(),
								'updated_by' => 'admin'
							];

							$this->Query->update($this->session->userdata('id'), $this->tblManagement, $data);
						}
					}

					redirect("admin/pages");
				}

	// ============================================================================================
	// Pages Order
	// ============================================================================================
				public function orders(){
					$data['user'] = $this->getUserData();
					$data['title'] = "Orders";
					$show_field = "orders.*, customers.full_name";
					$fields = "orders.customer_id = customers.id";

					// Additional data
					$data['all_orders'] = $this->Query->join2Table($this->tblOrders, $this->tblCustomers, $fields, $show_field)->num_rows();
					$data['success_orders'] = $this->AdminModel->findOrderSuccess()->num_rows();
					$data['on_delivery'] = $this->AdminModel->findOrderOnDelivery()->num_rows();
					$data['waiting_approval'] = $this->AdminModel->findOrderWaitingApproval()->num_rows();

					$data['orders'] = $this->Query->join2Table($this->tblOrders, $this->tblCustomers, $fields, $show_field)->result();
					$data['orders_to_processed'] = $this->Query->orderNeedToProcess($this->tblOrders, $this->tblCustomers, $fields, $show_field)->result();

					$this->template_web("admin/orders", $data);
				}

				public function count_data_in_orders_table(){
					
				}

				public function update_status_order(){
					$id = $this->input->post('id');
					$status = $this->input->post('status');

					switch ($status){
						case 'accept':
						$data = ["status_order" => "on process", "is_deleted" => TRUE];
						$this->Query->update($id, $this->tblOrders, $data);
						$error = 0;
						echo $error;
						break;
					}


				}

				public function process_order($order_id, $customer_id){
					$data['user'] = $this->getUserData();

					$data['title'] = "Orders";
					$data["detail_order"] = $this->AdminModel->detail_order_customer($customer_id, $order_id)->result();
					$data["detail_products"] = $this->AdminModel->detail_products($customer_id, $order_id)->result();

					$this->template_web("admin/forms/processed_order", $data);
				}

				public function save_processed_order(){
					$id = $this->input->post("id");
					$email = $this->input->post("email");
					$full_name = $this->input->post("full_name");
					$delivery_service = $this->input->post("delivery_service");
					$total = $this->input->post("total");
					$receipt_number = $this->input->post("receipt_number");


					$data = [
						'status_order' => 'on delivery',
						'receipt_number' => $receipt_number,
						'updated_at' => date('Y-m-d H:i:s'),
						'is_deleted' => FALSE
					];

					// Preparing Send Email
					$subject = "Nomor Resi STP Store";
					$url_content = "admin/forms/email_resi";
					$email_data["d"] = [
						"order_id" => $id, 
						"full_name" => $full_name, 
						"delivery_service" => $delivery_service, 
						"total" => $total, 
						"receipt_number" => $receipt_number, 
					];
					$this->send_email($email, $subject, $url_content, $email_data);

					$this->Query->update($id, $this->tblOrders, $data);
					$this->session->set_flashdata('alert','This order updated');
					redirect("admin/pages/orders");
				}

				public function send_email($customer_email, $subject, $url_content, $email_data){
					$this->load->library('mailer');
					$content=$this->load->view($url_content, $email_data, true);

					$sendmail = array(
						'email_penerima'=>$customer_email,      
						'subjek'=> $subject,      
						'content'=>$content
					);

					$send = $this->mailer->send($sendmail); 
				}

				// ==================================
				// REPORT
				// ==================================

				public function report(){
					$data['user'] = $this->getUserData();
					$data['title'] = "Report";

					// Khusus laporan product
					$data['products'] = $this->AdminModel->product_report()->result();
					$data['penjualan_bulan_lalu'] = $this->AdminModel->penjualan_bulan_lalu()->result();
					$data['penjualan_bulan_ini'] = $this->AdminModel->penjualan_bulan_ini()->result();

					$this->template_web("admin/reports", $data);
				}

				public function result($param){

					switch ($param){
						case 'range':
						$data['user'] = $this->getUserData();
						$start_date = $this->input->post("start_date");
						$end_date = $this->input->post("end_date");

						if($start_date == NULL && $end_date == NULL):
							$this->template_web("err_page", $data);
						else:
							$data['report'] = $this->AdminModel->report_between_date($start_date, $end_date)->result();
							$this->template_web("admin/result", $data);
							break;
						endif;
						break;

						case 'status_order':
						$data['user'] = $this->getUserData();
						$status_order = $this->input->post("status_order");
						if($status_order == NULL || $status_order == ""):
							$this->template_web("err_page", $data);
						else:
							$data['report'] = $this->AdminModel->report_by_status($status_order)->result();
							$this->template_web("admin/result", $data);
							break;
						endif;
						break;

						default:
						echo "Parameter tidak di temukan";
						break;

					}
				}

				public function details($order_id){
					$data['user'] = $this->getUserData();

					$data['title'] = "Details";
					$data["detail_order"] = $this->AdminModel->detail_order_customer(NULL, $order_id)->result();
					$data["detail_products"] = $this->AdminModel->detail_products(NULL, $order_id)->result();

					$this->template_web("admin/forms/details", $data);
				}

				public function terima_barang($order_id){
					$user_data = $this->getUserData();

					$order_update = [
						"updated_at" => $this->updatedAt(),
						"status_order" => "delivered"
					];
					$this->Query->update($order_id, "orders", $order_update);

					$this->session->set_flashdata('delivered_alert','Konfirmasi barang diterima berhasil !');
					redirect("admin/pages/orders");
				}

			}
