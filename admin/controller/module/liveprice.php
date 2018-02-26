<?php
//  Live Price / Живая цена (Динамическое обновление цены)
//  Support: support@liveopencart.com / Поддержка: help@liveopencart.ru

class ControllerModuleLivePrice extends Controller {
	
	private $error = array(); 
	
	private function getLinks() {
		
		$data = array();
		
		if (VERSION >= '2.3.0.0') {
			$routeHomePage 				= 'common/dashboard';
			$routeExtensions			= 'extension/extension';
			$routeExtensionsType 	= '&type=module';
			$routeModule 					= 'extension/module/liveprice';
		} else { // OLDER OC
			$routeHomePage 				= 'common/home';
			$routeExtensions			= 'extension/module';
			$routeExtensionsType 	= '';
			$routeModule 					= 'module/liveprice';
		}
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link($routeHomePage, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link($routeExtensions, 'token=' . $this->session->data['token'].$routeExtensionsType, 'SSL'),
			'separator' => ' :: '
		);
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('module_name'),
			'href'      => $this->url->link($routeModule, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		
		$data['action'] = $this->url->link($routeModule, 'token=' . $this->session->data['token'], 'SSL');
	
		$data['cancel'] = $this->url->link($routeExtensions, 'token=' . $this->session->data['token'].$routeExtensionsType, 'SSL');
		
		$data['redirect'] = $this->url->link($routeModule, 'token=' . $this->session->data['token'], 'SSL');
		
		return $data;
	}
	
	public function index() {
		
		$this->load->language('catalog/product');
		$lp_lang = $this->load->language('module/liveprice');
		
		$links = $this->getLinks();

		$this->document->setTitle($this->language->get('module_name'));
		//$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('module/liveprice');		
		
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$post_to_save = $this->model_module_liveprice->saveDBSettings($this->request->post);
			$this->model_setting_setting->editSetting('liveprice', $post_to_save);		
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($links['redirect']);
		}
			
		foreach ( $lp_lang as $key => $val ) {
			$data[$key] = $val;
		}
		
		$this->model_module_liveprice->check_tables();
		$data['module_version'] = $this->model_module_liveprice->current_version();
		
		$data['config_admin_language'] = $this->config->get('config_admin_language');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
      $data['success'] = $this->session->data['success'];
      unset($this->session->data['success']);
    }
		
		$data['token'] = $this->session->data['token'];

		$data['breadcrumbs'] 		= $links['breadcrumbs'];
		$data['action'] 				= $links['action'];
		$data['cancel'] 				= $links['cancel'];

		$data['liveprice_settings'] = array('discount_quantity'=>0);
		if (isset($this->request->post['liveprice_settings'])) {
			$data['liveprice_settings'] = $this->request->post['liveprice_settings'];
		} elseif ($this->config->get('liveprice_settings')) { 
			$data['liveprice_settings'] = $this->config->get('liveprice_settings');
		}
		$data['liveprice_settings'] = $this->model_module_liveprice->readDBSettings($data['liveprice_settings']);
		
		$this->load->model('catalog/category');
		$categories = $this->model_catalog_category->getCategories();
		$categories_names = array();
		foreach ( $categories as $category ) {
			$categories_names[$category['category_id']] = $category['name'];
		}
		
		$this->load->model('catalog/manufacturer');
		$manufacturers = $this->model_catalog_manufacturer->getManufacturers();
		$manufacturers_names = array();
		foreach ( $manufacturers as $manufacturer ) {
			$manufacturers_names[$manufacturer['manufacturer_id']] = $manufacturer['name'];
		}
		
		if ( isset($data['liveprice_settings']['discounts']) ) {
			foreach ($data['liveprice_settings']['discounts'] as &$discount) {
				if ( isset($discount['category_id']) && isset($categories_names[$discount['category_id']]) ) {
					$discount['category'] = $categories_names[$discount['category_id']];
				}
				if ( isset($discount['manufacturer_id']) && isset($manufacturers_names[$discount['manufacturer_id']]) ) {
					$discount['manufacturer'] = $manufacturers_names[$discount['manufacturer_id']];
				}
			}
			unset($discount);
		}
		
		if ( isset($data['liveprice_settings']['specials']) ) {
			foreach ($data['liveprice_settings']['specials'] as &$special) {
				if ( isset($special['category_id']) && isset($categories_names[$special['category_id']]) ) {
					$special['category'] = $categories_names[$special['category_id']];
				}
				if ( isset($special['manufacturer_id']) && isset($manufacturers_names[$special['manufacturer_id']]) ) {
					$special['manufacturer'] = $manufacturers_names[$special['manufacturer_id']];
				}
			}
			unset($special);
		}
		
		
		if ( VERSION >= '2.1.0.1' ) {
			$this->load->model('customer/customer_group');
			$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		} else {
			$this->load->model('sale/customer_group');
			$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		}
		
		$this->load->model('catalog/category');
		$categories = $this->model_catalog_category->getCategories(array('sort'  => 'name'));
		
		$this->load->model('catalog/manufacturer');
		$manufacturers = $this->model_catalog_manufacturer->getManufacturers();
		
		$this->load->model('catalog/product');
		
		if (!empty($data['liveprice_settings']['discount_quantity_customize']) && !empty($data['liveprice_settings']['dqc'])) {
			foreach ($data['liveprice_settings']['dqc'] as &$dqc) {
				$new_dqc = array('discount_quantity'=>$dqc['discount_quantity'], 'categories'=>array(), 'manufacturers'=>array(), 'products'=>array());
				if (!empty($dqc['categories'])) {
					foreach ($categories as $category) {
						if ( in_array($category['category_id'], $dqc['categories']) )  {
							$new_dqc['categories'][] = $category;
						}
					}
				}
				if (!empty($dqc['manufacturers'])) {
					foreach ($manufacturers as $manufacturer) {
						if ( in_array($manufacturer['manufacturer_id'], $dqc['manufacturers']) )  {
							$new_dqc['manufacturers'][] = $manufacturer;
						}
					}
				}
				if (!empty($dqc['products'])) {
					foreach ( $dqc['products'] as $product_id ) {
						$product = $this->model_catalog_product->getProduct($product_id);
						if ( $product ) {
							$new_dqc['products'][] = $product;
						}
					}
				}
				$dqc = $new_dqc;
			}
			unset($dqc);
			
		}
		
		// << old script compatibility
		$product_categories = array();
		if ( !empty($data['liveprice_settings']['categories']) ) {
			foreach ($categories as $category) {
				if ( in_array($category['category_id'], $data['liveprice_settings']['categories']) )  {
					$product_categories[] = $category;
				}
			}
		}
		$data['product_categories'] = $product_categories;
		
		$product_manufacturers = array();
		if ( !empty($data['liveprice_settings']['manufacturers']) ) {
			foreach ($manufacturers as $manufacturer) {
				if ( in_array($manufacturer['manufacturer_id'], $data['liveprice_settings']['manufacturers']) )  {
					$product_manufacturers[] = $manufacturer;
				}
			}
		}
		$data['product_manufacturers'] = $product_manufacturers;
		
		$product_relateds = array();
		if ( !empty($data['liveprice_settings']['products']) ) {
			foreach ( $data['liveprice_settings']['products'] as $product_id ) {
				$product = $this->model_catalog_product->getProduct($product_id);
				if ( $product ) {
					$product_relateds[] = $product;
				}
			}
		}
		$data['product_relateds'] = $product_relateds;
		// >> old script compatibility
		
		
		$data['extension_code'] = $this->model_module_liveprice->getExtensionCode();
		$data['version_pro'] = $this->model_module_liveprice->versionPRO();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		$this->response->setOutput($this->load->view('module/liveprice.tpl', $data));
	}
	
	private function standardSettings($post=false) {
		if (!$post || is_array($post)) {
			$post = array();
		}
		
		$post['liveprice_module'] = Array ();
		
		return $post;
	}
	
	public function install() {
		
		$post = $this->standardSettings();
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('liveprice', $post);
		
		$this->load->model('module/liveprice');
		$this->model_module_liveprice->check_tables();
		
	}
	
	public function uninstall() {
    $this->load->model('module/liveprice');
    $this->model_module_liveprice->uninstall();
  }
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/liveprice') && !$this->user->hasPermission('modify', 'extension/module/liveprice')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
