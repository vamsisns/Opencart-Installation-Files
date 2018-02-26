<?php
class ControllerExtensionModulemkenqpro extends Controller {	
	private $error = array();
	private $modpath = 'module/mkenqpro'; 
	private $modtpl = 'module/mkenqpro.tpl';
	private $modname = 'mkenqpro';
	private $modtext = 'Make An Enquiry Instead of Add To Cart';
	private $modid = '21745';
	private $modssl = 'SSL';
	private $modemail = 'opencarttools@gmail.com';
	private $token_str = '';
	private $modurl = 'extension/module';
	private $modurltext = '';

	public function __construct($registry) {
		parent::__construct($registry);
 		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') { 
			$this->modtpl = 'extension/module/mkenqpro';
			$this->modpath = 'extension/module/mkenqpro';
		} else if(substr(VERSION,0,3)=='2.2') {
			$this->modtpl = 'module/mkenqpro';
		} 
		
		if(substr(VERSION,0,3)>='3.0') { 
			$this->modname = 'module_mkenqpro';
			$this->modurl = 'marketplace/extension'; 
			$this->token_str = 'user_token=' . $this->session->data['user_token'] . '&type=module';
		} else if(substr(VERSION,0,3)=='2.3') {
			$this->modurl = 'extension/extension';
			$this->token_str = 'token=' . $this->session->data['token'] . '&type=module';
		} else {
			$this->token_str = 'token=' . $this->session->data['token'];
		}
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') { 
			$this->modssl = true;
		} 
 	} 
	
	public function index() {
		$data = $this->load->language($this->modpath);
		$this->modurltext = $this->language->get('text_extension');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($this->modname, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_enquiry_success');

			if(! (isset($this->request->post['svsty']) && $this->request->post['svsty'] == 1)) {
				$this->response->redirect($this->url->link($this->modurl, $this->token_str, $this->modssl));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
 		$data['entry_status'] = $this->language->get('entry_status');
  		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $this->token_str, $this->modssl)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->modurltext,
			'href' => $this->url->link($this->modurl, $this->token_str, $this->modssl)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->modpath, $this->token_str, $this->modssl)
		);

		$data['action'] = $this->url->link($this->modpath, $this->token_str, $this->modssl);
		
		$data['cancel'] = $this->url->link($this->modurl, $this->token_str , $this->modssl); 
		
		if(substr(VERSION,0,3)>='3.0') { 
			$data['user_token'] = $this->session->data['user_token'];
		} else {
			$data['token'] = $this->session->data['token'];
		}
		
		$data['customer_group'] = $this->getCustomerGroups();
		
		$this->load->model('setting/store');
 		$data['stores'] = $this->model_setting_store->getStores();
		
		$this->load->model('localisation/language');
  		$languages = $this->model_localisation_language->getLanguages();
		foreach($languages as $language) {
			if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') {
				$imgsrc = "language/".$language['code']."/".$language['code'].".png";
			} else {
				$imgsrc = "view/image/flags/".$language['image'];
			}
			$data['languages'][] = array("language_id" => $language['language_id'], "name" => $language['name'], "imgsrc" => $imgsrc);
		}
		
		$this->load->model('tool/image');
 		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data[$this->modname.'_status'] = $this->setvalue($this->modname.'_status');	
		$data[$this->modname.'_setting'] = $this->setvalue($this->modname.'_setting');
		if($data[$this->modname.'_setting']) { 
			$stng = $data[$this->modname.'_setting'];
			$data[$this->modname.'_setting']['product'] = $this->getprouct(isset($stng['product']) ? $stng['product'] : array() );
 			$data[$this->modname.'_setting']['category'] = $this->getcategory(isset($stng['category']) ? $stng['category'] : array() );
 			$data[$this->modname.'_setting']['manufacturer'] = $this->getmanufacturer(isset($stng['manufacturer']) ? $stng['manufacturer'] : array());	 
		}
		
  		$data['modname'] = $this->modname;
		$data['modemail'] = $this->modemail;
  		  
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->modtpl, $data));
	}
	
	protected function setvalue($postfield) {
		if (isset($this->request->post[$postfield])) {
			$postfield_value = $this->request->post[$postfield];
		} else {
			$postfield_value = $this->config->get($postfield);
		} 	
 		return $postfield_value;
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', $this->modpath)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function getCustomerGroups($data = array()) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cgd.name ASC"); 
		return $query->rows;
	}
	
	public function getprouct($setting_product) {
		$this->load->model('catalog/product');
		$products = array();
  				
		if($setting_product) {
			foreach ($setting_product as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);
 				if ($product_info) {
					$products[] = array(
						'product_id' => $product_info['product_id'],
						'name'       => $product_info['name']
					);
				}
			}
 		}
		return $products;
	}
	
	public function getcategory($setting_category) {
		$this->load->model('catalog/category');
 		$categories = array();
 		if($setting_category) {
			foreach ($setting_category as $category_id) {
				$category_info = $this->model_catalog_category->getCategory($category_id);
 				if ($category_info) {
					$categories[] = array(
						'category_id' => $category_info['category_id'],
						'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
					);
				}
			}
 		}
		return $categories;
	}
	
	public function getmanufacturer($setting_manufacturer) {
		$this->load->model('catalog/manufacturer');
 		$manufacturers = array();
 		if($setting_manufacturer) {
			foreach ($setting_manufacturer as $manufacturer_id) {
				$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);
 				if ($manufacturer_info) {
					$manufacturers[] = array(
						'manufacturer_id' => $manufacturer_info['manufacturer_id'],
						'name'       => $manufacturer_info['name']
					);
				}
			}
 		}  
		return $manufacturers;
	}
	
	public function install() {
		// create table 
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mkenqpro` (
			`mkenqpro_id` int(11) unsigned NOT NULL auto_increment,
  			`name` varchar(255) NOT NULL default '',
			`email` varchar(255) NOT NULL default '',
			`phnum` varchar(50) NOT NULL default '',
			`address` TEXT,
			`comments` TEXT,
			`store_id` int(5),
			`replied_enquiry` tinyint(1),
			`date_added` datetime ,
 			PRIMARY KEY (`mkenqpro_id`)
		)");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mkenqprocart` (
			`cart_id` int(11) unsigned NOT NULL auto_increment,
			`mkenqpro_id` int(11),
 			`product_id` int(11),
			`store_id` int(5),
 			`quantity` int(5), 
			`option` text, 
			`date_added` datetime,
 			PRIMARY KEY (`cart_id`)
		)");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mkenqproenquirycart` (
			`cart_id` int(11) unsigned NOT NULL auto_increment,
			`session_id` varchar(32) NOT NULL default '',
 			`product_id` int(11),
  			`quantity` int(5), 
			`option` text, 
			`date_added` datetime,
 			PRIMARY KEY (`cart_id`)
		)");
		
		@mail($this->modemail,
		"Extension Installed",
		"Hello!" . "\r\n" .  
		"Extension Name :  ".$this->modtext."" ."\r\n". 
		"Extension ID : ".$this->modid ."\r\n". 
		"Version : " . VERSION. "\r\n". 
		"Installed At : " .HTTP_CATALOG ."\r\n". 
		"Licence Start Date : " .date("Y-m-d") ."\r\n".  
		"Licence Expiry Date : " .date("Y-m-d", strtotime('+1 year'))."\r\n". 
		"From: ".$this->config->get('config_email'),
		"From: ".$this->config->get('config_email'));      
	}
	
	public function uninstall() { 
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "mkenqpro`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "mkenqprocart`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "mkenqproenquirycart`");
		
		@mail($this->modemail,
		"Extension Uninstalled",
		"Hello!" . "\r\n" .  
		"Extension Name :  ".$this->modtext."" ."\r\n". 
		"Extension ID : ".$this->modid ."\r\n". 
		"Version : " . VERSION. "\r\n". 
		"Installed At : " .HTTP_CATALOG ."\r\n". 
		"Licence Start Date : " .date("Y-m-d") ."\r\n".  
		"Licence Expiry Date : " .date("Y-m-d", strtotime('+1 year'))."\r\n". 
		"From: ".$this->config->get('config_email'),
		"From: ".$this->config->get('config_email'));        
	}
}