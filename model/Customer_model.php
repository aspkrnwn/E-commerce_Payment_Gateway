<?php 

class Customer_model extends CI_Model{

	public function findByUsernameAndPassword($username, $password){
		return $this->db->get_where("customers", array('username' => $username, 'password' => $password, "is_deleted" => FALSE));
	}

	public function findByUsername($username){
		return $this->db->get_where("customers", array('username' => $username, "is_deleted" => FALSE));
	}

	public function getCart($ip){
		return	$this->db->query("SELECT cart.*, products.name, products.selling_price, products.image, products.weight FROM cart
			JOIN products ON products.id=cart.product_id
			WHERE ip_address = '$ip'  ")->result();
	}

	public function subtotalCart($ip){
		return $this->db->query("SELECT SUM(products.selling_price*cart.quantity) AS result FROM cart
			JOIN products ON products.id=cart.product_id
			WHERE ip_address = '$ip' ")->row();
	}

	public function getCartByProductId($ip_address, $product_id){
		return $this->db->get_where("cart", array('ip_address' => $ip_address, 'product_id' => $product_id));
	}

	public function getInvoice($order_id, $customer_id){
		return $this->db->query("SELECT * FROM orders o
			JOIN order_item oi ON oi.order_id=o.id 
			JOIN products p ON p.id=oi.product_id
			JOIN transaction_history th ON th.order_id=o.id
			WHERE o.id = '$order_id' AND o.customer_id = '$customer_id' ");
	}

	public function getMyOrder($customer_id){
		return $this->db->query("SELECT * FROM orders o
			JOIN order_item oi ON oi.order_id=o.id 
			JOIN products p ON p.id=oi.product_id
			JOIN transaction_history th ON th.order_id=o.id
			WHERE o.customer_id = '$customer_id'
			GROUP BY o.id
			ORDER BY th.transaction_time DESC ");
	}

	function fetch_data($query, $customer_id)
	{
		$this->db->select("*");
		$this->db->from("transaction_history");
		$this->db->join("orders", "orders.id = transaction_history.order_id");
		$this->db->join("order_item", "order_item.order_id = orders.id");
		$this->db->join("products", "products.id = order_item.product_id");	

		if($query != '')
		{
			$this->db->like('transaction_history.order_id', $query);
			$this->db->or_like('name', $query);
		}

		$this->db->where("orders.customer_id", $customer_id);
		$this->db->group_by("transaction_history.order_id");
		$this->db->order_by('transaction_time', 'DESC');
		return $this->db->get();
	}

	public function get_trx_for_update(){
		return $this->db->query("SELECT * FROM transaction_history WHERE transaction_status != 'settlement' ");
	}

}