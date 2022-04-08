<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('Global_model', 'Query');
		$this->load->model('owner/Owner_model', 'OwnerModel');
		$this->load->model('admin/Admin_model', 'AdminModel');
		if($this->session->userdata('role') != 'owner'){
			redirect("owner/err", 'refresh');
		}
		
	}

	// Template for web view
	public function template_web($url_view, $data){
		$this->load->view('owner/templates/header', $data);
		$this->load->view('owner/templates/navbar');
		$this->load->view('owner/templates/sidebar');
		$this->load->view($url_view);
		$this->load->view('owner/templates/footer');
	}

	public function getUserData(){
		$username = $this->session->userdata('username');

		return $this->OwnerModel->findByUsername($username)->row();
	}
	public function index(){
		$data['user'] = $this->getUserData();
		$data['title'] = "Dashboard";

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

		$this->template_web("owner/index", $data);
	}

	public function admin(){
		$data['user'] = $this->getUserData();
		$data['title'] = "admin";
		$data['admins'] = $this->OwnerModel->findAllAdmin()->result();

		$this->template_web("owner/admin", $data);
	}

	public function delete(){
		$id = $this->input->post('id');
		$table = $this->input->post('table');

		switch ($table){

			case 'management':
			$this->Query->softDelete($id, $table);
			$error = 0;
			echo $error;
			break;
		}


	}

	public function add($param){
		$data['title'] = $param;
		$data['user'] = $this->getUserData();

		switch (strtolower($param)){
			case 'admin':
			$this->template_web("owner/forms/add_admin", $data);
			break;

			default:
			echo "Oppss 404 not found!";
			break;
		}
	}

	public function rules_admin(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[management.username]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[management.email]');

		//set global message
		$this->form_validation->set_message('required', '{field} masih kosong, harap diisi!');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar!');
	}

	public function save_admin(){
		$fullname = $this->input->post("fullname");
		$username = $this->input->post("username");
		$email = $this->input->post("email");
		$password = strtoupper(random_string('alnum', 6));

		$this->rules_admin();
		if($this->form_validation->run() == TRUE){
			$data = [
				'username' => $username,
				'password' => $password,
				'fullname' => $fullname,
				'created_at' => $this->today(),
				'email' => $email,
				'role' => 'admin',
				'image' => '',
				'is_deleted' => FALSE
			];

			$this->Query->save("management", $data);
			$this->session->set_flashdata('alert','Category saved');
			redirect("owner/pages/admin");
		}else{
			return $this->add("admin");
		}
	}

	public function today(){
		return Date('Y-m-d H:i:s');
	}

	public function report(){
		$data['user'] = $this->getUserData();
		$data['title'] = "Report";

					// Khusus laporan product
		$data['products'] = $this->AdminModel->product_report()->result();
		$data['penjualan_bulan_lalu'] = $this->AdminModel->penjualan_bulan_lalu()->result();
		$data['penjualan_bulan_ini'] = $this->AdminModel->penjualan_bulan_ini()->result();

		$this->template_web("owner/reports", $data);
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
				$this->template_web("owner/result", $data);
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
				$this->template_web("owner/result", $data);
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

		$this->template_web("owner/forms/details", $data);
	}

	// Download PDF Files
	public function download_pdf($id, $table, $customer_id){

		// Populate the Data

		$data["detail_order"] = $this->AdminModel->detail_order_customer($customer_id, $id)->result();
		$data["detail_products"] = $this->AdminModel->detail_products($customer_id, $id)->result();

		// Generate menjadi PDF
		$this->load->library('mypdf');
		$this->mypdf->generate("admin/pdf/invoice", $data);
	}

	public function store_setting(){
		$data['user'] = $this->getUserData();
		$data['title'] = "Store Setting";
		$data['row'] = $this->db->get_where("store_setting", ["is_deleted" => FALSE])->row();
		
		$this->template_web("owner/store_setting", $data);
	}

	public function update_store_setting($param){
		$id = $this->input->post("id");
		$data = array($param => $this->input->post($param), "updated_at" => $this->today());
		$this->Query->update($id, "store_setting", $data);

		redirect("owner/pages/store_setting", 'refresh');
	}

	public function updatedAt(){
		return Date('Y-m-d H:i:s');
	}

	public function save_logo(){
		if(!empty($_FILES['file']['name'])){
			$config['upload_path'] = 'upload/images/owner/store_setting';	
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size']    = '5000'; 
			$config['file_name'] = "store_profile_".random_string('numeric', 5);;

			$this->load->library('upload',$config);			

			if($this->upload->do_upload('file')){

				$uploadData = $this->upload->data();

				$data = [
					'logo' => $uploadData["file_name"],
					'updated_at' => $this->updatedAt()
				];

				$this->Query->update($this->input->post('id'), "store_setting", $data);
			}
		}

		redirect("owner/pages/store_setting");
	}
}