<?php 

class Login extends CI_Controller{
	public function __construct(){
		parent::__construct();
		
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$this->load->model('Global_model', 'Query');
		$this->load->model('admin/Admin_model', 'AdminModel');
		
	}


	public function index(){
		$this->load->view("admin/forms/login");
	}

	public function login_action(){

		$username = $this->input->post("username");
		$password = md5($this->input->post("password"));

		$find = $this->AdminModel->findByUsernameAndPassword($username, $password)->row();
		if(isset($find)){
			$this->set_session($find->id, $find->username, $find->role);
			$this->session->set_flashdata('alert_success_login','Success Login');

			if($find->role == "admin"){
				redirect("admin/pages");
			}else{
				redirect("owner/pages");
			}
		}else{
			$this->session->set_flashdata('alert_failed_login','Invalid credentials');
			redirect("admin/login");
		}
	}

	public function set_session($id, $username, $role){
		$data = ["id" => $id,"username" => $username, "role" => $role];

		$this->session->sess_expiration = 500;
		$this->session->set_userdata($data);
	}

	public function reset_session(){
		$username = $this->session->userdata('username'); 
		$role = $this->session->userdata('role');

		$this->destroy_session();
		$this->set_session($username, $role);
	}

	public function destroy_session(){
		$this->session->sess_destroy();
	}

	public function logout(){
		$username = $this->session->userdata('username');
		$this->destroy_session();
		echo "Success logout";

		redirect("admin/login");
	}

	public function err(){
		$this->load->view("err_page");
	}
} 