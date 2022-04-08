<?php 

class Owner_model extends CI_Model{
	public function findByUsername($username){
		return $this->db->get_where("management", array('username' => $username));
	}

	public function findAllAdmin(){
		return $this->db->get_where("management", array('role' => 'admin', 'is_deleted' => FALSE));
	}
}