<?php 

class Admin_model extends CI_Model{
	public function findByCategoryId($category_id, $table){
		return $this->db->get_where($table, array('category_id' => $category_id));
	}

	public function findByUsernameAndPassword($username, $password){
		return $this->db->get_where("management", array('username' => $username, 'password' => $password, 'is_deleted' => FALSE));
	}

	public function findByUsername($username){
		return $this->db->get_where("management", array('username' => $username));
	}

	// ==================================================
	// ORDERS
	// ==================================================
	public function new_incoming_orders(){
		return $this->db->query("SELECT customers.full_name, order_item.order_id, transaction_history.transaction_time,
			products.name, products.selling_price, products.image, order_item.quantity FROM orders 
			JOIN order_item ON order_item.order_id=orders.id 
			JOIN customers ON customers.id=orders.customer_id
			JOIN transaction_history ON transaction_history.order_id=orders.id
			JOIN products ON products.id=order_item.product_id
			WHERE orders.status_order = 'waiting approval' 
			LIMIT 10");
	}
	public function findOrderSuccess(){
		return $this->db->query("SELECT * FROM orders WHERE status_order = 'success' AND is_deleted = FALSE  ");
	}

	public function findOrderOnDelivery(){
		return $this->db->query("SELECT * FROM orders WHERE status_order = 'on delivery' AND is_deleted = FALSE  ");
	}

	public function findOrderWaitingApproval(){
		return $this->db->query("SELECT * FROM orders WHERE status_order = 'waiting approval' AND is_deleted = FALSE  ");
	}

	public function detail_order_customer($customer_id, $order_id){
		if($customer_id == NULL){
			return $this->db->query("SELECT * FROM orders JOIN order_item ON order_item.order_id=orders.id JOIN transaction_history on transaction_history.order_id=orders.id JOIN customers ON customers.id=orders.customer_id WHERE orders.id = '$order_id'  GROUP BY orders.id");
		}else{
			return $this->db->query("SELECT * FROM orders JOIN order_item ON order_item.order_id=orders.id JOIN transaction_history on transaction_history.order_id=orders.id JOIN customers ON customers.id=orders.customer_id WHERE customers.id = '$customer_id' AND orders.id = '$order_id'  GROUP BY orders.id");
		}
		
	}

	public function detail_products($customer_id, $order_id){
		if($customer_id == NULL){
			return $this->db->query("SELECT * FROM orders 
				JOIN order_item ON order_item.order_id=orders.id 
				JOIN transaction_history on transaction_history.order_id=orders.id 
				JOIN products ON products.id=order_item.product_id
				JOIN customers ON customers.id=orders.customer_id 
				WHERE orders.id = '$order_id' ");
		}else{
			return $this->db->query("SELECT * FROM orders 
				JOIN order_item ON order_item.order_id=orders.id 
				JOIN transaction_history on transaction_history.order_id=orders.id 
				JOIN products ON products.id=order_item.product_id
				JOIN customers ON customers.id=orders.customer_id 
				WHERE customers.id = '$customer_id' AND orders.id = '$order_id' ");
		}
	}

	// ==================================================
	// CHART
	// ==================================================

	public function product_sale(){
		return $this->db->query("SELECT products.name, SUM(order_item.quantity) AS total FROM orders
			JOIN order_item ON order_item.order_id=orders.id
			JOIN products ON products.id=order_item.product_id
			JOIN transaction_history ON transaction_history.order_id=orders.id
			WHERE transaction_history.transaction_status = 'settlement'
			GROUP BY products.id");
	}

	public function transactions_this_month($year, $month){
		return $this->db->query("SELECT products.name, SUM(order_item.quantity) AS total FROM orders
			JOIN order_item ON order_item.order_id=orders.id
			JOIN products ON products.id=order_item.product_id
			JOIN transaction_history ON transaction_history.order_id=orders.id
			WHERE transaction_history.transaction_status = 'settlement' AND YEAR(transaction_history.transaction_time)='$year' AND MONTH(transaction_history.transaction_time)='$month'
			GROUP BY products.id");
	}

	public function transactions_this_year_by_month($start, $end){
		$dml = "SELECT m.MONTH, IFNULL(n.TOTAL,0) TOTAL FROM 
		(SELECT 'January' AS MONTH
			UNION 
			SELECT 'February' AS MONTH
			UNION 
			SELECT 'March' AS MONTH
			UNION 
			SELECT 'April' AS MONTH
			UNION 
			SELECT 'May' AS MONTH
			UNION 
			SELECT 'June' AS MONTH
			UNION 
			SELECT 'July' AS MONTH
			UNION 
			SELECT 'August' AS MONTH
			UNION 
			SELECT 'September' AS MONTH
			UNION 
			SELECT 'October' AS MONTH
			UNION 
			SELECT 'November' AS MONTH
			UNION 
			SELECT 'December' AS MONTH
			) m LEFT JOIN
		(SELECT MONTHNAME(transaction_history.transaction_time) AS MONTH, 
			SUM(order_item.quantity) AS TOTAL 
			FROM transaction_history 
			JOIN orders ON orders.id=transaction_history.order_id
			JOIN order_item ON orders.id=order_item.order_id
			JOIN products ON products.id=order_item.product_id
			WHERE transaction_history.transaction_time BETWEEN '$start' AND '$end' AND transaction_history.transaction_status = 'settlement' 
			GROUP BY MONTHNAME(transaction_history.transaction_time),MONTH(transaction_history.transaction_time)
			ORDER BY MONTH(transaction_history.transaction_time)) n ON m.MONTH=n.MONTH";

		return $this->db->query($dml);
	}

	public function product_by_category(){
		return $this->db->query("SELECT categories.name, COUNT(products.id) AS jumlah 
			FROM products 
			JOIN categories ON categories.id=products.category_id 
			GROUP BY category_id");
	}

	public function count_product_sale(){
		return $this->db->query("SELECT products.name, SUM(order_item.quantity) AS jumlah, products.image
			FROM orders
			JOIN order_item ON order_item.order_id=orders.id
			JOIN products ON products.id=order_item.product_id
			JOIN transaction_history ON transaction_history.order_id=orders.id
			WHERE transaction_history.transaction_status = 'settlement'
			GROUP BY products.id");
	}

	// REPORT
	public function report_between_date($start_date, $end_date){
		$dml = "SELECT * FROM orders
		JOIN order_item ON order_item.order_id=orders.id
		JOIN products ON products.id=order_item.product_id
		JOIN transaction_history ON transaction_history.order_id=orders.id
		JOIN customers ON customers.id=orders.customer_id
		WHERE transaction_history.transaction_status = 'settlement'
		AND transaction_time BETWEEN '$start_date' AND '$end_date'
		GROUP BY orders.id";

		return $this->db->query($dml);
	}

	public function report_by_status($status_order){
		$dml = "SELECT * FROM orders
		JOIN order_item ON order_item.order_id=orders.id
		JOIN products ON products.id=order_item.product_id
		JOIN transaction_history ON transaction_history.order_id=orders.id
		JOIN customers ON customers.id=orders.customer_id
		WHERE orders.status_order = '$status_order'
		GROUP BY orders.id";

		return $this->db->query($dml);
	}

	public function getItemProduct($order_id){
		return $this->db->query("SELECT order_item.product_id, order_item.quantity FROM orders 
			JOIN order_item ON order_item.order_id=orders.id
			WHERE orders.id = '$order_id' ");
	}

	public function product_report(){
		return $this->db->query("SELECT order_item.product_id, products.name, products.purchase_price, products.selling_price, categories.name AS category_name,  SUM(order_item.quantity) AS jumlah, products.image, products.stock
			FROM orders
			JOIN order_item ON order_item.order_id=orders.id
			JOIN products ON products.id=order_item.product_id
			JOIN categories ON categories.id=products.category_id
			JOIN transaction_history ON transaction_history.order_id=orders.id
			WHERE transaction_history.transaction_status = 'settlement'
			GROUP BY products.id");
	}

	public function penjualan_bulan_lalu(){
		$last_month = date('m', strtotime('-1 month', strtotime(date('m'))));
		$this_year = date('Y');

		$dml = "SELECT products.id,  SUM(order_item.quantity) AS jumlah_bulan_lalu
		FROM orders
		JOIN order_item ON order_item.order_id=orders.id
		JOIN products ON products.id=order_item.product_id
		JOIN categories ON categories.id=products.category_id
		JOIN transaction_history ON transaction_history.order_id=orders.id
		WHERE transaction_history.transaction_status = 'settlement' AND MONTH(transaction_history.transaction_time) = '$last_month' AND YEAR(transaction_history.transaction_time) = '$this_year'
		GROUP BY products.id";

		return $this->db->query($dml);
	}

	public function penjualan_bulan_ini(){
		$this_month = date('m');
		$this_year = date('Y');

		$dml = "SELECT products.id,  SUM(order_item.quantity) AS jumlah_bulan_lalu
		FROM orders
		JOIN order_item ON order_item.order_id=orders.id
		JOIN products ON products.id=order_item.product_id
		JOIN categories ON categories.id=products.category_id
		JOIN transaction_history ON transaction_history.order_id=orders.id
		WHERE transaction_history.transaction_status = 'settlement' AND MONTH(transaction_history.transaction_time) = '$this_month' AND YEAR(transaction_history.transaction_time) = '$this_year'
		GROUP BY products.id";

		return $this->db->query($dml);
	}
}