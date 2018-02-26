<?php
class ModelExtensionModulemkenqpro extends Model {
	private $modpath = 'module/mkenqpro';
 	private $modname = 'mkenqpro';
	private $modssl = 'SSL';
	private $modgrpid = 0;
	private $modlangid = 0;
	private $modstoreid = 0;
 	
	public function __construct($registry) {
		parent::__construct($registry);
		
		$this->modgrpid = $this->config->get('config_customer_group_id');
		$this->modlangid = (int)$this->config->get('config_language_id');
		$this->modstoreid = (int)$this->config->get('config_store_id');
		
		if(substr(VERSION,0,3)>='3.0') { 
			$this->modname = 'module_mkenqpro';
		} 
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') { 
			$this->modssl = true;
		}
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') { 
			$this->modpath = 'extension/module/mkenqpro';
		} 
 	}
	
	public function index() {
		$data = $this->load->language($this->modpath);
 		$data['mkenqpro_status'] = $this->setvalue($this->modname.'_status');
 	}  
	
	public function getmkenqpro($product_id) {
		$data = $this->load->language($this->modpath);
  		$data['mkenqpro_status'] = $this->setvalue($this->modname.'_status');
		$mkenqpro_setting = false;
		if($data['mkenqpro_status']) {  
			$mkenqpro_setting = $this->setvalue($this->modname.'_setting');
			$mkenqpro_setting['flag'] = false;
			$mkenqpro_setting['btntext'] = isset($mkenqpro_setting['btntext'][$this->modlangid]) ? $mkenqpro_setting['btntext'][$this->modlangid] : $data['btntext'];
			$mkenqpro_setting['btntype'] = isset($mkenqpro_setting['btntype']) ? $mkenqpro_setting['btntype'] : 1;
			$mkenqpro_setting['captcha_type'] = isset($mkenqpro_setting['captcha_type']) ? $mkenqpro_setting['captcha_type'] : 1;
 			$mkenqpro_setting['btnhideprodbox'] = isset($mkenqpro_setting['btnhideprodbox']) ? $mkenqpro_setting['btnhideprodbox'] : 1;
			$mkenqpro_setting['btnhideprodpage'] = isset($mkenqpro_setting['btnhideprodpage']) ? $mkenqpro_setting['btnhideprodpage'] : 1;
			$mkenqpro_setting['prodoption'] = isset($mkenqpro_setting['prodoption']) ? $mkenqpro_setting['prodoption'] : 1;
		$mkenqpro_setting['redirectenquiry'] = isset($mkenqpro_setting['redirectenquiry']) ? $mkenqpro_setting['redirectenquiry'] : 1;
 			$mkenqpro_setting['stockzero'] = isset($mkenqpro_setting['stockzero']) ? $mkenqpro_setting['stockzero'] : 0;
 			$mkenqpro_setting['pricezero'] = isset($mkenqpro_setting['pricezero']) ? $mkenqpro_setting['pricezero'] : 0;
 			
 			if( (isset($mkenqpro_setting['store']) && in_array($this->modstoreid,$mkenqpro_setting['store'])) && (isset($mkenqpro_setting['customer_group']) && in_array($this->modgrpid,$mkenqpro_setting['customer_group'])) ) {	
				if(isset($mkenqpro_setting['product']) && $mkenqpro_setting['product'] && in_array($product_id, $mkenqpro_setting['product'])) {
					$mkenqpro_setting['flag'] = true;
				}
				if(isset($mkenqpro_setting['category']) && $mkenqpro_setting['category']) {
					$mkenqpro_category_str = implode(",",$mkenqpro_setting['category']);
					$query = $this->db->query("SELECT count(category_id) as mkenqprottl FROM " . DB_PREFIX . "product_to_category where 1 and product_id = '".(int)$product_id."' and FIND_IN_SET(category_id , '".$mkenqpro_category_str."') ");
					if($query->row['mkenqprottl']) {	
						$mkenqpro_setting['flag'] = true;
					}
				}
				if($mkenqpro_setting['manufacturer']) {
					$mkenqpro_manufacturer_str = implode(",",$mkenqpro_setting['manufacturer']);
					$query = $this->db->query("SELECT count(product_id) as mkenqprottl FROM " . DB_PREFIX . "product  where 1 and product_id = '".(int)$product_id."' and FIND_IN_SET(manufacturer_id , '".$mkenqpro_manufacturer_str."') ");
					if($query->row['mkenqprottl']) {	
						$mkenqpro_setting['flag'] = true;
					}
				}
				
				if(! ((isset($mkenqpro_setting['product']) && $mkenqpro_setting['product']) || (isset($mkenqpro_setting['category']) && $mkenqpro_setting['category']) || (isset($mkenqpro_setting['manufacturer']) && $mkenqpro_setting['manufacturer'])) ) {
					$mkenqpro_setting['flag'] = true;
				}
			} 
		}
		return $mkenqpro_setting; 
	} 
	
	
	public function getenquirycartProducts() {
		$product_data = array();

		$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "mkenqproenquirycart WHERE session_id = '" . $this->db->escape($this->session->getId()) . "'");

		foreach ($cart_query->rows as $cart) {
			$stock = true;

			$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store p2s LEFT JOIN " . DB_PREFIX . "product p ON (p2s.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p2s.product_id = '" . (int)$cart['product_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

			if ($product_query->num_rows && ($cart['quantity'] > 0)) {
				$option_price = 0;
				$option_points = 0;
				$option_weight = 0;

				$option_data = array();
				
				foreach (json_decode($cart['option']) as $product_option_id => $value) {
					$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$cart['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

					if ($option_query->num_rows) {
						if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio') {
							$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

							if ($option_value_query->num_rows) {
								if ($option_value_query->row['price_prefix'] == '+') {
									$option_price += $option_value_query->row['price'];
								} elseif ($option_value_query->row['price_prefix'] == '-') {
									$option_price -= $option_value_query->row['price'];
								}

								if ($option_value_query->row['points_prefix'] == '+') {
									$option_points += $option_value_query->row['points'];
								} elseif ($option_value_query->row['points_prefix'] == '-') {
									$option_points -= $option_value_query->row['points'];
								}

								if ($option_value_query->row['weight_prefix'] == '+') {
									$option_weight += $option_value_query->row['weight'];
								} elseif ($option_value_query->row['weight_prefix'] == '-') {
									$option_weight -= $option_value_query->row['weight'];
								}

								if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
									$stock = false;
								}

								$option_data[] = array(
									'product_option_id'       => $product_option_id,
									'product_option_value_id' => $value,
									'option_id'               => $option_query->row['option_id'],
									'option_value_id'         => $option_value_query->row['option_value_id'],
									'name'                    => $option_query->row['name'],
									'value'                   => $option_value_query->row['name'],
									'type'                    => $option_query->row['type'],
									'quantity'                => $option_value_query->row['quantity'],
									'subtract'                => $option_value_query->row['subtract'],
									'price'                   => $option_value_query->row['price'],
									'price_prefix'            => $option_value_query->row['price_prefix'],
									'points'                  => $option_value_query->row['points'],
									'points_prefix'           => $option_value_query->row['points_prefix'],
									'weight'                  => $option_value_query->row['weight'],
									'weight_prefix'           => $option_value_query->row['weight_prefix']
								);
							}
						} elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
							foreach ($value as $product_option_value_id) {
								$option_value_query = $this->db->query("SELECT pov.option_value_id, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix, ovd.name FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

								if ($option_value_query->num_rows) {
									if ($option_value_query->row['price_prefix'] == '+') {
										$option_price += $option_value_query->row['price'];
									} elseif ($option_value_query->row['price_prefix'] == '-') {
										$option_price -= $option_value_query->row['price'];
									}

									if ($option_value_query->row['points_prefix'] == '+') {
										$option_points += $option_value_query->row['points'];
									} elseif ($option_value_query->row['points_prefix'] == '-') {
										$option_points -= $option_value_query->row['points'];
									}

									if ($option_value_query->row['weight_prefix'] == '+') {
										$option_weight += $option_value_query->row['weight'];
									} elseif ($option_value_query->row['weight_prefix'] == '-') {
										$option_weight -= $option_value_query->row['weight'];
									}

									if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
										$stock = false;
									}

									$option_data[] = array(
										'product_option_id'       => $product_option_id,
										'product_option_value_id' => $product_option_value_id,
										'option_id'               => $option_query->row['option_id'],
										'option_value_id'         => $option_value_query->row['option_value_id'],
										'name'                    => $option_query->row['name'],
										'value'                   => $option_value_query->row['name'],
										'type'                    => $option_query->row['type'],
										'quantity'                => $option_value_query->row['quantity'],
										'subtract'                => $option_value_query->row['subtract'],
										'price'                   => $option_value_query->row['price'],
										'price_prefix'            => $option_value_query->row['price_prefix'],
										'points'                  => $option_value_query->row['points'],
										'points_prefix'           => $option_value_query->row['points_prefix'],
										'weight'                  => $option_value_query->row['weight'],
										'weight_prefix'           => $option_value_query->row['weight_prefix']
									);
								}
							}
						} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
							$option_data[] = array(
								'product_option_id'       => $product_option_id,
								'product_option_value_id' => '',
								'option_id'               => $option_query->row['option_id'],
								'option_value_id'         => '',
								'name'                    => $option_query->row['name'],
								'value'                   => $value,
								'type'                    => $option_query->row['type'],
								'quantity'                => '',
								'subtract'                => '',
								'price'                   => '',
								'price_prefix'            => '',
								'points'                  => '',
								'points_prefix'           => '',
								'weight'                  => '',
								'weight_prefix'           => ''
							);
						}
					}
				}
				
 				$price = $product_query->row['price'];

				// Product Discounts
				$discount_quantity = 0;
 				foreach ($cart_query->rows as $cart_2) {
					if ($cart_2['product_id'] == $cart['product_id']) {
						$discount_quantity += $cart_2['quantity'];
					}
				}

				$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

				if ($product_discount_query->num_rows) {
					$price = $product_discount_query->row['price'];
				}

				// Product Specials
				$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

				if ($product_special_query->num_rows) {
					$price = $product_special_query->row['price'];
				}

				// Reward Points
				$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

				if ($product_reward_query->num_rows) {
					$reward = $product_reward_query->row['points'];
				} else {
					$reward = 0;
				}

				// Stock
				if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $cart['quantity'])) {
					$stock = false;
				}

				$recurring = false;

				$product_data[] = array(
					'cart_id'         => $cart['cart_id'],
					'product_id'      => $product_query->row['product_id'],
					'name'            => $product_query->row['name'],
					'model'           => $product_query->row['model'],
					'quantity'           => $product_query->row['quantity'],
					'shipping'        => $product_query->row['shipping'],
					'image'           => $product_query->row['image'],
					'option'          => $option_data,
 					'quantity'        => $cart['quantity'],
					'minimum'         => $product_query->row['minimum'],
					'subtract'        => $product_query->row['subtract'],
					'stock'           => $stock,
					'price'           => ($price),
					'total'           => ($price) * $cart['quantity'],
					'reward'          => $reward * $cart['quantity'],
					'points'          => ($product_query->row['points'] ? ($product_query->row['points']) * $cart['quantity'] : 0),
					'tax_class_id'    => $product_query->row['tax_class_id'],
					'weight'          => ($product_query->row['weight'] ) * $cart['quantity'],
					'weight_class_id' => $product_query->row['weight_class_id'],
					'length'          => $product_query->row['length'],
					'width'           => $product_query->row['width'],
					'height'          => $product_query->row['height'],
					'length_class_id' => $product_query->row['length_class_id'],
					'recurring'       => $recurring
				);
			} else {
				$this->enquirycartremove($cart['cart_id']);
			}
		}

		return $product_data;
	}
	
	public function enquirycartadd($product_id, $quantity = 1, $option = array()) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "mkenqproenquirycart WHERE session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int)$product_id . "' AND `option` = '" . $this->db->escape(json_encode($option)) . "' ");

		if (!$query->row['total']) {
			$this->db->query("INSERT " . DB_PREFIX . "mkenqproenquirycart SET session_id = '" . $this->db->escape($this->session->getId()) . "', product_id = '" . (int)$product_id . "', `option` = '" . $this->db->escape(json_encode($option)) . "', quantity = '" . (int)$quantity . "', date_added = NOW()");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "mkenqproenquirycart SET quantity = (quantity + " . (int)$quantity . ") WHERE session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int)$product_id . "' AND `option` = '" . $this->db->escape(json_encode($option)) . "' ");
		}
	}
	
	public function enquirycartupdate($cart_id, $quantity) {
		$this->db->query("UPDATE " . DB_PREFIX . "mkenqproenquirycart SET quantity = '" . (int)$quantity . "' WHERE cart_id = '" . (int)$cart_id . "' AND  session_id = '" . $this->db->escape($this->session->getId()) . "'");
	} 
	
	public function enquirycartremove($cart_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "mkenqproenquirycart WHERE cart_id = '" . (int)$cart_id . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	} 
	
	public function enquirycartclear() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "mkenqproenquirycart WHERE session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}
	
	public function enquirycarthasProducts() {
		return count($this->getenquirycartProducts());
	}
	
	protected function setvalue($postfield) {
		return $this->config->get($postfield);
	}
}