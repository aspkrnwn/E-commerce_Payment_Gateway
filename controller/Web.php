<?php 

class Web extends CI_Controller{
	public function __construct(){
		parent::__construct();

		$this->load->model('Global_model', 'Query');
		$this->load->model('customer/Customer_model', 'Customer');
	}

	// ===========================================================================
	// Constant
	var $tblProducts = "products";
	var $tblCategories = "categories";
	var $tblCart = "cart";
	var $api_key = "ac7036a106dc34391fa0c38ffdfd5934";
	// ===========================================================================

	// Template for web view
	public function template_web($url_view, $data){
		$data["store"] = $this->db->get_where("store_setting", ["is_deleted" => FALSE])->row();
		
		$this->load->view('public/templates/header', $data);
		$this->load->view($url_view);
		$this->load->view('public/templates/footer');
	}

	public function login(){
		$this->load->view("public/login");
	}

	public function register(){
		$this->load->view("public/register");
	}

	public function register_rules(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[customers.email]');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[customers.username]');
		$this->form_validation->set_rules('no_hp', 'Nomor HP', 'required|min_length[11]|max_length[15]');
		$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required');
		$this->form_validation->set_rules('password1', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('password2', 'Password', 'required|min_length[5]|matches[password1]');

		//set global message
		$this->form_validation->set_message('required', '{field} masih kosong, harap diisi!');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar!');
		$this->form_validation->set_message('matches', 'Password tidak cocok!');
		$this->form_validation->set_message('min_length', '{field} terlalu pendek!');
		$this->form_validation->set_message('max_length', '{field} terlalu panjang!');
	}

	public function register_action(){
		$email = $this->input->post("email");
		$username = $this->input->post("username");
		$no_hp = $this->input->post("no_hp");
		$full_name = $this->input->post("full_name");
		$password = $this->input->post("password1");
		$created_at = $this->input->post("created_at");
		$updated_at = NULL;
		$updated_by = NULL;
		$last_login = NULL;
		$is_deleted = FALSE;
		$profile_picture = "";
		$status = '1';


		// OTP
		$today = date('Y-m-d H:i:s');
		$real_otp = random_string('numeric', 6);
		$otp = md5($real_otp);
		$otp_time = date('Y-m-d H:i:s', strtotime('+2 minutes', strtotime($today)));
		$token_register = random_string('alnum', 35);


		$this->register_rules();

		if($this->form_validation->run() == FALSE):
			return $this->register();
		else:
			$data = [
				'full_name' => $full_name,
				'username' => $username,
				'password' => md5($password),
				'email' => $email,
				'no_hp' => $no_hp,
				'created_at' => $created_at,
				'updated_at' => $updated_at,
				'updated_by' => $updated_by,
				'is_deleted' => $is_deleted,
				'last_login' => $last_login,
				'profile_picture' => $profile_picture,
				'otp' => $otp,
				'otp_time' => $otp_time,
				'token_register' => $token_register,
				'status' => $status
			];

			$regis = [
				'regis_username'  => $username,
				'regis_email'     => $email
			];

			$this->session->set_tempdata($regis, NULL, 120); //2menit
			$this->Query->save("customers", $data);

			// Send email
			$this->send_simple_email($email, "Kode OTP", $real_otp);

			redirect("web/verification_register/".$token_register);
		endif;
	}

	public function send_simple_email($customer_email, $subject, $message){
		$this->load->library('mailer');

		$sendmail = array(
			'email_penerima'=>$customer_email,      
			'subjek'=> $subject,      
			'content'=>$message
		);

		$send = $this->mailer->send($sendmail); 
	}

	public function verification_register($token_register){
		// Cek token ke DB
		$cek_token = $this->Query->findByField(array('token_register' => $token_register), "customers");
		if(isset($cek_token)):
			if($this->cek_otp_time($cek_token->otp_time) == TRUE){
				if($_SESSION['regis_email'] == $cek_token->email){
					$data['customer'] = $cek_token;

					$this->load->view("public/verification_register", $data);
				}else{
					echo "OTP Tidak valid";
				}
			}else{
				echo "Otp exp";
			}
		else:
			echo "false";
		endif;
	}

	public function cek_otp_time($otp_time){
		$today = date('Y-m-d H:i:s');

		if($otp_time < $today){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function otp_validation(){
		$email = $this->input->post("email");
		$otp = md5($this->input->post("otp"));

		$cek = $this->Query->findByField(['email' => $email, 'otp' => $otp], "customers");
		if(isset($cek)){
			$update_data = [
				'updated_at' => date('Y-m-d H:i:s'),
				'updated_by' => "System",
				'otp' => NULL,
				'otp_time' => NULL,
				'token_register' => NULL,
				'status' => '0'
			];

			$this->Query->update($cek->id, "customers", $update_data);
			redirect("web/login");
		}else{
			echo "token tidak valid";
		}
	}


	public function index(){
		$data["categories"] = $this->Query->findAll($this->tblCategories);
		$data["products"] = $this->Query->getRandomData($this->tblProducts, 3);

		$this->template_web("public/index", $data);
	}

	public function contact(){
		$user = NULL;
		if($this->session->userdata('username') != ''){
			$user = $this->getUserData();
		}
		
		$data["customer"] = NULL;

		if($user != NULL){
			$data["customer"] = $this->Customer->findByUsername($user->username)->row();
		}

		$this->template_web("public/contact", $data);
	}

	public function shop(){
		$show_field = "categories.id, products.*";
		$fields = "categories.id = products.category_id";

		$data['categories']	= $this->Query->findAll($this->tblCategories);
		$data['products']	= $this->Query->join2Table($this->tblCategories, $this->tblProducts, $fields, $show_field)->result();

		$this->template_web("public/shop", $data);
	}

	public function add_to_cart(){
		$product_id = $this->input->post("product_id");
		$quantity = $this->input->post("qty");
		if($quantity == 0){
			$quantity+=1;
		}

		$cek = $this->Customer->getCartByProductId($this->get_ip_address(), $product_id)->row();
		$cek_stok = $this->db->query("SELECT stock FROM products WHERE products.id = '$product_id' ")->row();


		if(isset($cek)){
			$stock_total = $cek_stok->stock+$cek->quantity;
			$quantity_total =$quantity+$cek->quantity;

			if($quantity_total > $stock_total){
				echo "failed";
			}else{
				$update = [
					'quantity' => $quantity_total
				];

				$this->Query->update($cek->id, $this->tblCart, $update);
				echo "success";
			}
		}else{
			if($quantity > $cek_stok->stock){
				echo "failed";
			}else{
				$data = [
					'customer_id' => $this->session->userdata('id'),
					'ip_address' => $this->get_ip_address(),
					'product_id' => $this->input->post("product_id"),
					'quantity' => $quantity
				];

				$this->Query->save($this->tblCart, $data);

				echo "success";
			}
		}
	}

	public function get_ip_address(){
		$data = json_decode(file_get_contents("http://ipinfo.io/"));

		return $data->ip;
	}

	public function count_cart(){
		$data = $this->Customer->getCart($this->get_ip_address());

		echo count($data);
	}

	public function cart(){
		$data['cart'] = $this->Customer->getCart($this->get_ip_address());
		$data['subtotal'] = $this->Customer->subtotalCart($this->get_ip_address());

		$this->template_web("public/cart", $data);
	}

	public function update_cart(){
		$id = $this->input->post("id");
		$quantity = $this->input->post("quantity");
		$product_id = $this->input->post("product_id");

		$data = array();

		$i = 0;
		foreach($id as $dataId){
			$pId = $product_id[$i];

			$cek_stok = $this->db->query("SELECT stock FROM products WHERE products.id = '$pId' ")->row();
			if($quantity[$i] > $cek_stok->stock){
				array_push($data, array(
					'id' => $dataId
				));
			}else{
				$dataUpdate = array(
					'id' => $dataId,
					'quantity' => $quantity[$i]
				);

				$this->Query->update($dataId, 'cart', $dataUpdate); 
				$this->session->set_flashdata('alert','Cart berhasil diupdate');
			}

			
			$i++;
		}

		
		redirect("web/cart");
	}

	public function delete_cart(){
		$id = $this->input->post("id");
		$this->Query->delete($id, $this->tblCart);
		echo "success";
	}

	public function getUserData(){
		$username = $this->session->userdata('username');

		return $this->Customer->findByUsername($username)->row();
	}

	public function checkout($order_id){
		$show_field = "orders.*, order_item.product_id, order_item.quantity, order_item.note, products.name, products.selling_price";
		$fields = "orders.id = order_item.order_id";

		$data['orders'] = $this->Query->getDataOrders("orders", "order_item", $fields, $show_field, $order_id)->result();
		$data['total'] = $this->Query->getDataOrders("orders", "order_item", $fields, $show_field, $order_id)->row();
		$data['user'] = $this->getUserData();
		$data['order_id'] = $order_id;
		$data['prod'] = $this->Query->findByIdResultRow($order_id, "orders");

		// Get Provinsi
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: " . $this->api_key
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		$data['prov'] = json_decode($response, true);

		$this->template_web("public/checkout", $data);
	}

	// ===========RAJA ONGKIR API INTEGRATIONS===============================================================================
	// ======================================================================================================================

	public function get_city($province_id){
		$kota = null;

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.rajaongkir.com/starter/city?&province=" . $province_id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: " . $this->api_key
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$city =  json_decode($response, true);

		if($city['rajaongkir']['status']['code'] == 200){
			foreach($city['rajaongkir']['results'] as $city){
				echo "<option value='$city[city_id]'>$city[city_name]</option>";
			}
		}
	}

	public function get_province_to(){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: " . $this->api_key
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$prov_to =  json_decode($response, true);

		if($prov_to['rajaongkir']['status']['code'] == 200){
			foreach($prov_to['rajaongkir']['results'] as $prov_to){
				echo "<option value='$prov_to[province_id]'>$prov_to[province]</option>";
			}
		}
	}

	public function get_cost($city_to, $berat, $kurir){
		$curl = curl_init();
		$city = 419;

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "origin=".$city."&destination=".$city_to."&weight=".$berat."&courier=" . $kurir,
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"key: ac7036a106dc34391fa0c38ffdfd5934"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$ongkir =  json_decode($response, true);
		}

		if($ongkir['rajaongkir']['status']['code'] == 200){
			foreach($ongkir['rajaongkir']['results'][0]['costs'] as $ong){


				if($ongkir['rajaongkir']['results'][0]['code'] == "jne"){
					$backg = "bg-jne";
				}else if($ongkir['rajaongkir']['results'][0]['code'] == "tiki"){
					$backg = "bg-tiki";
				}else{
					$backg = "bg-pos";
				}

				echo '
				<div class="row">
				<div class="col-lg-6 col-md-6">
				<div class="single-latest-news">
				<a href="#"><div class="latest-news-bg '.$backg.'"></div></a>
				<div class="news-text-box">
				<h4>'.number_format($ong['cost'][0]['value'],0,',','.').' - '.$ong['service'].'</h4>
				<p class="blog-meta">
				<span class="author"><i class="fas fa-user"></i> '.strtoupper($ongkir['rajaongkir']['results'][0]['code']).'</span>
				<span class="date"><i class="fas fa-calendar"></i> '.$ong['cost'][0]['etd'].' Hari</span>
				</p>
				<a class="boxed-btn"
				data-kurir="'.$ongkir['rajaongkir']['results'][0]['code'].'" 
				data-ongkir="'.$ong['cost'][0]['value'].'"
				data-service="'.$ong['service'].'"
				data-etd="'.$ong['cost'][0]['etd'].'"
				data-bg="'.$backg.'"
				onclick="pilihEkspedisi(this)">
				Pilih  <i class="fas fa-angle-right"></i></a>
				</div>
				</div>
				</div>
				</div>';
			}
		}

	}

	public function test($province_id = 5){
		$kota = null;

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.rajaongkir.com/starter/city?&province=" . $province_id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: " . $this->api_key
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$city =  json_decode($response, true);

		print_r($city);
	}

	public function single_product($product_id, $category_id){
		$data['product'] = $this->Query->detail_product($product_id);
		$terjual = $this->Query->count_terjual($product_id);
		$data['releated'] = $this->Query->releated_product($category_id);

		$terjual = 0;
		if($terjual->jumlah == 0 || $terjual->jumlah == NULL){
			$terjual += 0;
		}else{
			$terjual = $terjual->jumlah;
		}

		$data['terjual'] = $terjual;

		$this->template_web("public/single_product", $data);
	}

}