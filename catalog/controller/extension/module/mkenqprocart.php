<?php
class ControllerExtensionModuleMkenqprocart extends Controller {
	private $modpath = 'module/mkenqpro';
	private $modpathcart = 'module/mkenqprocart';
	private $modtpl = 'default/template/module/mkenqprocart.tpl';
	private $modpopuptpl = 'default/template/module/mkenqpropopupcart.tpl';
	private $modmailtpl = 'default/template/module/mkenqpromail.tpl';
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
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') { 
			$this->modpath = 'extension/module/mkenqpro';
			$this->modpathcart = 'extension/module/mkenqprocart';
			
			$this->modtpl = 'extension/module/mkenqprocart';
			$this->modpopuptpl = 'extension/module/mkenqpropopupcart';
			$this->modmailtpl = 'extension/module/mkenqpromail';			
 		
		} else if(substr(VERSION,0,3)=='2.2') {
 			
			$this->modtpl = 'module/mkenqprocart';
			$this->modpopuptpl = 'module/mkenqpropopupcart';
			$this->modmailtpl = 'module/mkenqpromail';	
		}  
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') { 
			$this->modssl = true;
		}
 	}
	
	public function index() {
		$this->load->language('checkout/cart');
		$this->load->model($this->modpath);
 		
		$data = $this->load->language($this->modpath);
		$data['rand1'] = rand(1,20);
		$data['rand2'] = rand(1,20);
		$data['captch_str'] = $data['rand1'] . ' + ' . $data['rand2'] . ' = ? ';
		
		$data['modpathcart'] = $this->modpathcart;
		
		$mkenqpro_setting = $this->setvalue($this->modname.'_setting');
		$data['captcha_type'] = isset($mkenqpro_setting['captcha_type']) ? $mkenqpro_setting['captcha_type'] : 1;
		$data['captcha_google_key'] = isset($mkenqpro_setting['captcha_google_key']) ? $mkenqpro_setting['captcha_google_key'] : '';
   		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home'),
			'text' => $this->language->get('text_home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('checkout/cart'),
			'text' => $this->language->get('heading_title')
		);
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') {
			$hasproduct = $this->model_extension_module_mkenqpro->enquirycarthasProducts();
		} else {
			$hasproduct = $this->model_module_mkenqpro->enquirycarthasProducts();
		}
		
		if ($hasproduct) {
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_recurring_item'] = $this->language->get('text_recurring_item');
			$data['text_next'] = $this->language->get('text_next');
			$data['text_next_choice'] = $this->language->get('text_next_choice');

			$data['column_image'] = $this->language->get('column_image');
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$data['button_update'] = $this->language->get('button_update');
			$data['button_remove'] = $this->language->get('button_remove');
			$data['button_shopping'] = $this->language->get('button_shopping');
			$data['button_checkout'] = $this->language->get('button_checkout');
  
			$data['action'] = $this->url->link('checkout/cart/edit', '', true);
			$data['continue_btn_href'] = $this->url->link('common/home');
 
			$this->load->model('tool/image');
			$this->load->model('tool/upload');

			$data['products'] = array();
			
			if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') {
				$products = $this->model_extension_module_mkenqpro->getenquirycartProducts();
			} else {
				$products = $this->model_module_mkenqpro->getenquirycartProducts();
			}

			foreach ($products as $product) { 
				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], 80, 80);
				} else {
					$image = '';
				}
				
				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}
  
				$data['products'][] = array(
					'cart_id'   => $product['cart_id'],
					'thumb'     => $image,
					'name'      => $product['name'],
					'model'     => $product['model'],
					'option'    => $option_data,
					'quantity'     => $product['quantity'],
 					'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);
			}
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

 			$this->response->setOutput($this->load->view($this->modtpl, $data));
		} else {
			
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_error'] = $this->language->get('text_empty');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			unset($this->session->data['success']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') { 
				$this->response->setOutput($this->load->view('error/not_found', $data));
			} else { 
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
				} 
			}			
		}
	} 
	
	public function getpopup() {
		$this->load->language('checkout/cart');
		$this->load->model($this->modpath);

		$data = $this->load->language($this->modpath);
		$data['rand1'] = rand(1,20);
		$data['rand2'] = rand(1,20);
		$data['captch_str'] = $data['rand1'] . ' + ' . $data['rand2'] . ' = ? ';
		
		$data['modpathcart'] = $this->modpathcart;
		
		$mkenqpro_setting = $this->setvalue($this->modname.'_setting');
		$data['captcha_type'] = isset($mkenqpro_setting['captcha_type']) ? $mkenqpro_setting['captcha_type'] : 1;
		$data['captcha_google_key'] = isset($mkenqpro_setting['captcha_google_key']) ? $mkenqpro_setting['captcha_google_key'] : '';
   		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home'),
			'text' => $this->language->get('text_home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('checkout/cart'),
			'text' => $this->language->get('heading_title')
		);
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') {
			$hasproduct = $this->model_extension_module_mkenqpro->enquirycarthasProducts();
		} else {
			$hasproduct = $this->model_module_mkenqpro->enquirycarthasProducts();
		}
		
		if ($hasproduct) {
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_recurring_item'] = $this->language->get('text_recurring_item');
			$data['text_next'] = $this->language->get('text_next');
			$data['text_next_choice'] = $this->language->get('text_next_choice');

			$data['column_image'] = $this->language->get('column_image');
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$data['button_update'] = $this->language->get('button_update');
			$data['button_remove'] = $this->language->get('button_remove');
			$data['button_shopping'] = $this->language->get('button_shopping');
			$data['button_checkout'] = $this->language->get('button_checkout');
  
			$data['action'] = $this->url->link('checkout/cart/edit', '', true);
			$data['continue_btn_href'] = $this->url->link('common/home');
 
			$this->load->model('tool/image');
			$this->load->model('tool/upload');

			$data['products'] = array();
			
			if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') {
				$products = $this->model_extension_module_mkenqpro->getenquirycartProducts();
			} else {
				$products = $this->model_module_mkenqpro->getenquirycartProducts();
			}

			foreach ($products as $product) { 
				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], 80, 80);
				} else {
					$image = '';
				}
				
				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}
  
				$data['products'][] = array(
					'cart_id'   => $product['cart_id'],
					'thumb'     => $image,
					'name'      => $product['name'],
					'model'     => $product['model'],
					'option'    => $option_data,
					'quantity'     => $product['quantity'],
 					'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);
			}
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

 			$this->response->setOutput($this->load->view($this->modpopuptpl, $data));
		} else {
			
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_error'] = $this->language->get('text_empty');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			unset($this->session->data['success']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') { 
				$this->response->setOutput($this->load->view('error/not_found', $data));
			} else { 
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
				} 
			}			
		}
	} 
	
	public function add() {
		$this->load->language('checkout/cart');
		$this->load->language($this->modpath);
		$this->load->model($this->modpath);
		
		$mkenqpro_setting = $this->setvalue($this->modname.'_setting');
		$mkenqpro_setting['prodoption'] = isset($mkenqpro_setting['prodoption']) ? $mkenqpro_setting['prodoption'] : 1;
		$mkenqpro_setting['redirectenquiry'] = isset($mkenqpro_setting['redirectenquiry']) ? $mkenqpro_setting['redirectenquiry'] : 1;
		$mkenqpro_setting['popenquiry'] = isset($mkenqpro_setting['popenquiry']) ? $mkenqpro_setting['popenquiry'] : 1;

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
		} else {
			$product_id = 0;
		} 

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) { 
			if (isset($this->request->post['quantity']) && ((int)$this->request->post['quantity'] >= $product_info['minimum'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = $product_info['minimum'] ? $product_info['minimum'] : 1;
			}
			
 			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();
			}
				
			if($mkenqpro_setting['prodoption']) {

				$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);
		
				foreach ($product_options as $product_option) {
					if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
						$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
					}
				}
			
			} else {
				$option = array();
			}
			
			if (!$json) {
			
				if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') {
					$this->model_extension_module_mkenqpro->enquirycartadd($this->request->post['product_id'], $quantity, $option);
				} else {
					$this->model_module_mkenqpro->enquirycartadd($this->request->post['product_id'], $quantity, $option);
				}
	
				if($mkenqpro_setting['redirectenquiry']) {
					$json['redirectenquiry'] = str_replace('&amp;', '&', $this->url->link($this->modpathcart));
				} 
				
				$json['popenquiry'] = $mkenqpro_setting['popenquiry'];
	
				$json['success'] = sprintf($this->language->get('text_enquiry_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link($this->modpathcart));

			} else {
			
				if($mkenqpro_setting['prodoption']) {
					$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
				}
				
			}
 		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function remove() {
		$this->load->language('checkout/cart');
		$this->load->model($this->modpath);

		$json = array();

		// Remove
		if (isset($this->request->post['key'])) {
			if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') {
				$this->model_extension_module_mkenqpro->enquirycartremove($this->request->post['key']);
			} else {
				$this->model_module_mkenqpro->enquirycartremove($this->request->post['key']);
			}
 			$json['success'] = $this->language->get('text_remove');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function checkouteditqty() {
		$this->load->model($this->modpath);
		$this->load->language('checkout/cart');

		$json = array();

		// Update
		if (!empty($this->request->post['quantity'])) {
			if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') {
				$this->model_extension_module_mkenqpro->enquirycartupdate($this->request->post['key'], $this->request->post['quantity']);
			} else {
				$this->model_module_mkenqpro->enquirycartupdate($this->request->post['key'], $this->request->post['quantity']);
			} 

			$json['success'] = $this->language->get('text_remove');
  		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function submitmkenqpro() {
		$this->load->model($this->modpath);
		
 		$json = array();
		$data = $this->load->language($this->modpath);			
		$this->db->query("INSERT INTO " . DB_PREFIX . "mkenqpro SET  name = '" . $this->db->escape($this->request->post['customer_name']) . "',  email = '" . $this->db->escape($this->request->post['customer_email']) . "',  phnum = '" . $this->db->escape($this->request->post['customer_phonenum']) . "',   address = '" . $this->db->escape($this->request->post['customer_address']) . "',  comments = '" . $this->db->escape($this->request->post['comment']) . "', store_id = '" . $this->modstoreid . "', date_added = NOW()");
		
		$mkenqpro_id = $this->db->getLastId();
		
		$this->db->query("insert into `" . DB_PREFIX . "mkenqprocart` (`mkenqpro_id`, `product_id`, `option`, `quantity`, `store_id`, `date_added`) SELECT '".$mkenqpro_id."', `product_id`, `option`, `quantity`, '".$this->modstoreid."', now() FROM `" . DB_PREFIX . "mkenqproenquirycart` WHERE 1 and session_id = '" . $this->db->escape($this->session->getId()) . "' ");
		
 		$json['response'] = '<div class="alert alert-success"> '.$data['txt_response_success'].' </div>';
 		
		$this->sendadminemail($this->request->post, $mkenqpro_id);
		$this->sendcustomeremail($this->request->post, $mkenqpro_id);
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') {
			$this->model_extension_module_mkenqpro->enquirycartclear();
		} else {
			$this->model_module_mkenqpro->enquirycartclear();
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));		
	}
	
	public function sendadminemail($postdata, $mkenqpro_id) {
 		$this->load->language('checkout/cart');
		$data = $this->load->language($this->modpath);	
		
		$subject = sprintf($data['txt_admin_subject'], html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
 		$data['title'] = $data['heading_title'];
		$data['store_url'] = HTTP_SERVER;
		$data['store_name'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
		$data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
		$data['text_greeting'] = $data['txt_admin_greeting'];
		$data['mkenqpro_id'] = $mkenqpro_id;
		$data['enquiry_date'] = date("Y-m-d");
		$data['postdata'] = $postdata;
		$data['ip'] = $this->request->server['REMOTE_ADDR'];
		$data['comment'] = html_entity_decode($postdata['comment'], ENT_QUOTES, 'UTF-8');
		
		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity'); 		
		
		$this->load->model('tool/image');
		$this->load->model('tool/upload');

		$data['products'] = array();

		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') {
			$products = $this->model_extension_module_mkenqpro->getenquirycartProducts();
		} else {
			$products = $this->model_module_mkenqpro->getenquirycartProducts();
		}

		foreach ($products as $product) {
			 
			$image = '';
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], 80, 80);
			}  
			
			$option_data = array();

			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['value'];
				} else {
					$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

					if ($upload_info) {
						$value = $upload_info['name'];
					} else {
						$value = '';
					}
				}

				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
				);
			}
 			
			$data['products'][] = array(
				'cart_id'   => $product['cart_id'],
				'thumb'     => $image,
				'name'      => $product['name'],
				'model'     => $product['model'],
				'option'    => $option_data,
				'quantity'     => $product['quantity'],
  				'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
			);
		}
		
		//echo $this->load->view($this->modmailtpl, $data); exit;
 		
		if(substr(VERSION,0,3)>='3.0') {
 			$mail = new Mail($this->config->get('config_mail_engine'));
			$admin_emails = explode(',', $this->config->get('config_mail_alert_email'));
 		} else {
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			if(substr(VERSION,0,3)>='2.3') {
				$admin_emails = explode(',', $this->config->get('config_mail_alert_email'));
			} else {
				$admin_emails = explode(',', $this->config->get('config_mail_alert'));
			}
  		}
		
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
 		
		//$mail->setTo($postdata['customer_email']);
		$mail->setTo($this->config->get('config_email'));
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setHtml($this->load->view($this->modmailtpl, $data));
 		$mail->send();
		
		// admin additional email notification
 		if($admin_emails) {
			foreach ($admin_emails as $email) {
				if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}
	}
	
	public function sendcustomeremail($postdata, $mkenqpro_id) {
 		$this->load->language('checkout/cart');
		$data = $this->load->language($this->modpath);	
		
		$subject = sprintf($data['txt_customer_subject'], html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
 		$data['title'] = $data['heading_title'];
		$data['store_url'] = HTTP_SERVER;
		$data['store_name'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
		$data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
		$data['text_greeting'] = $data['txt_customer_greeting'];
		$data['mkenqpro_id'] = $mkenqpro_id;
		$data['enquiry_date'] = date("Y-m-d");
		$data['postdata'] = $postdata;
		$data['ip'] = $this->request->server['REMOTE_ADDR'];
		$data['comment'] = html_entity_decode($postdata['comment'], ENT_QUOTES, 'UTF-8');
		
		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
 		
 		$this->load->model('tool/image');
		$this->load->model('tool/upload');

		$data['products'] = array();

		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') {
			$products = $this->model_extension_module_mkenqpro->getenquirycartProducts();
		} else {
			$products = $this->model_module_mkenqpro->getenquirycartProducts();
		}

		foreach ($products as $product) {
 			$image = '';
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], 80, 80);
			}  
			
			$option_data = array();

			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['value'];
				} else {
					$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

					if ($upload_info) {
						$value = $upload_info['name'];
					} else {
						$value = '';
					}
				}

				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
				);
			}
			
			$data['products'][] = array(
				'cart_id'   => $product['cart_id'],
				'thumb'     => $image,
				'name'      => $product['name'],
				'model'     => $product['model'],
				'option'    => $option_data,
				'quantity'     => $product['quantity'],
  				'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
			);
		}
		
		//echo $this->load->view($this->modmailtpl, $data); exit;
 		
		if(substr(VERSION,0,3)>='3.0') {
 			$mail = new Mail($this->config->get('config_mail_engine'));
 		} else {
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
  		}
		
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

		$mail->setTo($postdata['customer_email']);
		//$mail->setTo($this->config->get('config_email'));
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setHtml($this->load->view($this->modmailtpl, $data));
 		$mail->send();
	}
	
	protected function setvalue($postfield) {
		return $this->config->get($postfield);
	}
}
