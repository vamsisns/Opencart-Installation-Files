<?php 
class ControllerExtensionMkenqprolist extends Controller {
	private $error = array();  
	private $modpath = 'extension/mkenqprolist';
	private $modtpl_list = 'extension/mkenqprolist_list.tpl';
	private $modtpl_view = 'extension/mkenqprolist_viewquote.tpl';	
	private $modtpl_mail = 'extension/mkenqprolist_sendquotemail.tpl';	
	private $modssl = 'SSL';
	private $token_str = '';
	
	private function checktablemkenqpro() {
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
	}
	
	public function __construct($registry) {
		parent::__construct($registry);
 		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') { 
 			$this->modpath = 'extension/mkenqprolist';
			
			$this->modtpl_list = 'extension/mkenqprolist_list';
			$this->modtpl_view = 'extension/mkenqprolist_viewquote';	 
			$this->modtpl_mail = 'extension/mkenqprolist_sendquotemail';
			
		} else if(substr(VERSION,0,3)=='2.2') {
 			$this->modtpl_list = 'extension/mkenqprolist_list';
			$this->modtpl_view = 'extension/mkenqprolist_viewquote';	 
			$this->modtpl_mail = 'extension/mkenqprolist_sendquotemail';	
		} 
		 
		if(substr(VERSION,0,3)>='3.0') { 
 			$this->token_str = 'user_token=' . $this->session->data['user_token'];
		} else {
			$this->token_str = 'token=' . $this->session->data['token'];
		}
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') { 
			$this->modssl = true;
		} 
 	} 

	public function index() {
		$this->checktablemkenqpro();
		
		$data = $this->load->language($this->modpath);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model($this->modpath);

		$this->getList();
	}

  	public function updaterepliedenquiry() {
 		if(isset($this->request->post['mkenqpro_id']) && $this->request->post['mkenqpro_id']) {
 			$this->db->query("UPDATE " . DB_PREFIX . "mkenqpro SET replied_enquiry = '".$this->request->post['chkval']."' WHERE mkenqpro_id = '" . (int)$this->request->post['mkenqpro_id'] . "'");
		}
	}
	
	public function delete() {
		$this->load->language($this->modpath);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model($this->modpath);

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $mkenqpro_id) {
				$this->model_extension_mkenqprolist->deletemkenqpro($mkenqpro_id);
			}

			$this->session->data['success'] = $this->language->get('text_enquiry_success');

			$url = '';

 			if (isset($this->request->get['filter_mkenqpro_id'])) {
				$url .= '&filter_mkenqpro_id=' . urlencode(html_entity_decode($this->request->get['filter_mkenqpro_id'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_store_id'])) {
				$url .= '&filter_store_id=' . urlencode(html_entity_decode($this->request->get['filter_store_id'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_phnum'])) {
				$url .= '&filter_phnum=' . urlencode(html_entity_decode($this->request->get['filter_phnum'], ENT_QUOTES, 'UTF-8'));
			}

 			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link($this->modpath, $this->token_str . $url, $this->modssl));
		}

		$this->getList();
	}
 
	protected function getList() {
		$data = $this->load->language($this->modpath);
		
 		if (isset($this->request->get['filter_mkenqpro_id'])) {
			$filter_mkenqpro_id = $this->request->get['filter_mkenqpro_id'];
		} else {
			$filter_mkenqpro_id = null;
		} 
		
		if (isset($this->request->get['filter_store_id'])) {
			$filter_store_id = $this->request->get['filter_store_id'];
		} else {
			$filter_store_id = '*';
		} 
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		} 
		
		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		} 
		
		if (isset($this->request->get['filter_phnum'])) {
			$filter_phnum = $this->request->get['filter_phnum'];
		} else {
			$filter_phnum = null;
		} 
  
 		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'mkenqpro_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
		
		if (isset($this->request->get['filter_mkenqpro_id'])) {
			$url .= '&filter_mkenqpro_id=' . urlencode(html_entity_decode($this->request->get['filter_mkenqpro_id'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . urlencode(html_entity_decode($this->request->get['filter_store_id'], ENT_QUOTES, 'UTF-8'));
		}
 
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_phnum'])) {
			$url .= '&filter_phnum=' . urlencode(html_entity_decode($this->request->get['filter_phnum'], ENT_QUOTES, 'UTF-8'));
		}
   
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $this->token_str, $this->modssl)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->modpath, $this->token_str . $url, $this->modssl)
		);

		$data['add'] = $this->url->link($this->modpath.'/add', $this->token_str . $url, $this->modssl);
		$data['delete'] = $this->url->link($this->modpath.'/delete', $this->token_str . $url, $this->modssl);
		
		if(substr(VERSION,0,3)>='3.0') { 
			$data['user_token'] = $this->session->data['user_token'];
		} else {
			$data['token'] = $this->session->data['token'];
		}
		
		$data['modpath'] = $this->modpath;

		$data['mkenqpros'] = array();

		$filter_data = array(
 			'filter_store_id' 			=> $filter_store_id,
			'filter_mkenqpro_id' 			=> $filter_mkenqpro_id,
			'filter_name'             	=> $filter_name,
			'filter_email'             => $filter_email,
			'filter_phnum'             => $filter_phnum,
 			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);
		
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$this->load->model('setting/store');
 		$data['stores'] = $this->model_setting_store->getStores();

 		$enquiry_total = $this->model_extension_mkenqprolist->getTotalmkenqpros($filter_data);
		$results = $this->model_extension_mkenqprolist->getmkenqpros($filter_data);
 
 		foreach ($results as $result) {
			$store_name = $this->model_setting_store->getStore($result['store_id']); 
			
   			$data['mkenqpros'][] = array(
				'mkenqpro_id'    => $result['mkenqpro_id'],
 				'name'          => $result['name'],
				'email'          => $result['email'],
				'phnum'          => $result['phnum'],
				'address'          => $result['address'],
				'replied_enquiry'          => $result['replied_enquiry'],
				'store_name'          => (isset($store_name['name']) && $store_name['name']) ? $store_name['name'] : $this->language->get('text_default'),
   				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
 			);
		}
 
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

 		$data['column_mkenqpro_id'] = $this->language->get('column_mkenqpro_id');
		$data['column_store'] = $this->language->get('column_store');
		$data['column_customer_name'] = $this->language->get('column_customer_name');
		$data['column_email'] = $this->language->get('column_email');
 		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

 		$data['entry_customer_name'] = $this->language->get('entry_customer_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_phnum'] = $this->language->get('entry_phnum');
 		$data['entry_date_added'] = $this->language->get('entry_date_added');

		$data['button_approve'] = $this->language->get('button_approve');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_login'] = $this->language->get('button_login');
		$data['button_unlock'] = $this->language->get('button_unlock');

		if(substr(VERSION,0,3)>='3.0') { 
			$data['user_token'] = $this->session->data['user_token'];
		} else {
			$data['token'] = $this->session->data['token'];
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';
		
		if (isset($this->request->get['filter_mkenqpro_id'])) {
			$url .= '&filter_mkenqpro_id=' . urlencode(html_entity_decode($this->request->get['filter_mkenqpro_id'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . urlencode(html_entity_decode($this->request->get['filter_store_id'], ENT_QUOTES, 'UTF-8'));
		}

 		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_phnum'])) {
			$url .= '&filter_phnum=' . urlencode(html_entity_decode($this->request->get['filter_phnum'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

 		$data['sort_mkenqpro_id'] = $this->url->link($this->modpath, $this->token_str . '&sort=mkenqpro_id' . $url, $this->modssl);
		$data['sort_store_id'] = $this->url->link($this->modpath, $this->token_str . '&sort=store_id' . $url, $this->modssl);
		$data['sort_name'] = $this->url->link($this->modpath, $this->token_str . '&sort=name' . $url, $this->modssl);
		$data['sort_email'] = $this->url->link($this->modpath, $this->token_str . '&sort=email' . $url, $this->modssl);
		$data['sort_phnum'] = $this->url->link($this->modpath, $this->token_str . '&sort=phnum' . $url, $this->modssl);
		$data['sort_replied_enquiry'] = $this->url->link($this->modpath, $this->token_str . '&sort=replied_enquiry' . $url, $this->modssl);
		$data['sort_date_added'] = $this->url->link($this->modpath, $this->token_str . '&sort=date_added' . $url, $this->modssl);
 
		$url = '';
		
		if (isset($this->request->get['filter_mkenqpro_id'])) {
			$url .= '&filter_mkenqpro_id=' . urlencode(html_entity_decode($this->request->get['filter_mkenqpro_id'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . urlencode(html_entity_decode($this->request->get['filter_store_id'], ENT_QUOTES, 'UTF-8'));
		}
 
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_phnum'])) {
			$url .= '&filter_phnum=' . urlencode(html_entity_decode($this->request->get['filter_phnum'], ENT_QUOTES, 'UTF-8'));
		}
 
 		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $enquiry_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link($this->modpath, $this->token_str . $url . '&page={page}', $this->modssl);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($enquiry_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($enquiry_total - $this->config->get('config_limit_admin'))) ? $enquiry_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $enquiry_total, ceil($enquiry_total / $this->config->get('config_limit_admin')));

 		$data['filter_mkenqpro_id'] = $filter_mkenqpro_id;
		$data['filter_store_id'] = $filter_store_id;
		$data['filter_name'] = $filter_name;		
		$data['filter_email'] = $filter_email;
		$data['filter_phnum'] = $filter_phnum;
    
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->modtpl_list, $data));
	}
	
	public function viewenquiry() {
		$data = $this->load->language($this->modpath);
		
		if(isset($this->request->get['mkenqpro_id']) && $this->request->get['mkenqpro_id']) {
			$this->load->model($this->modpath);
			
			$mkenqpro_data = $this->model_extension_mkenqprolist->getmkenqpro($this->request->get['mkenqpro_id']);
			
 			$data['comments'] = html_entity_decode($mkenqpro_data['comments'], ENT_QUOTES, 'UTF-8');
 			
 			$product_data = array();
 			$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "mkenqprocart WHERE mkenqpro_id = '" . (int)$this->request->get['mkenqpro_id']. "' ");
			
			foreach ($cart_query->rows as $cart) {
			
 				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store p2s LEFT JOIN " . DB_PREFIX . "product p ON (p2s.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p2s.store_id = '" . (int)$cart['store_id'] . "' AND p2s.product_id = '" . (int)$cart['product_id'] . "' AND p.date_available <= NOW() AND p.status = '1'");
				if ($product_query->num_rows) {
				
					$option_price = 0;
					$option_points = 0;
					$option_weight = 0;
				
					$option_data = array();
					if($cart['option']) { 
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
					}

 					$product_data[] = array(
						'cart_id'         => $cart['cart_id'],
						'product_id'      => $product_query->row['product_id'],
						'name'            => $product_query->row['name'],
						'model'           => $product_query->row['model'],
						'option'          => $option_data,
						'quantity'        => $product_query->row['quantity'],
						'image'           => $product_query->row['image'],
						'quantity'        => $cart['quantity'],
					);
				}
			}
			
			if ($product_data) {
 				$data['column_image'] = $this->language->get('column_image');
				$data['column_product_name'] = $this->language->get('column_product_name');
				$data['column_model'] = $this->language->get('column_model');
				$data['column_quantity'] = $this->language->get('column_quantity');
				
				$this->load->model('tool/image');
				
				foreach ($product_data as $product) {
					$product_total = 0;
 	 
					$image = '';
					if ($product['image']) {
						$image = $this->model_tool_image->resize($product['image'], 50, 50);
					} 
					  
					$data['products'][] = array(
						'cart_id'   => $product['cart_id'],
						'thumb'     => $image,
						'name'      => $product['name'],
						'model'     => $product['model'],
						'option' 	=> $product['option'],
						'quantity'  => $product['quantity'],
 						'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
					);
				} 
				$this->response->setOutput($this->load->view($this->modtpl_view, $data));			
			} 
		}
	}
	
	public function sendenquirymail() {
		if(isset($this->request->get['mkenqpro_id']) && $this->request->get['mkenqpro_id']) {
			$data = $this->load->language($this->modpath);
			
			$this->load->model($this->modpath);
			
			$mkenqpro_data = $this->model_extension_mkenqprolist->getmkenqpro($this->request->get['mkenqpro_id']);
 			
			$data['mkenqpro_data'] = $mkenqpro_data;
 	
			$this->document->setTitle($this->language->get('enquiry_email_heading'));
	
			$data['enquiry_email_heading'] = $this->language->get('enquiry_email_heading');
	
			$data['text_default'] = $this->language->get('text_default');
			$data['text_loading'] = $this->language->get('text_loading');
	
			$data['entry_store'] = $this->language->get('entry_store');
			$data['entry_from'] = $this->language->get('entry_from');
			$data['entry_to'] = $this->language->get('entry_to');
			$data['entry_subject'] = $this->language->get('entry_subject');
			$data['entry_message'] = $this->language->get('entry_message');
			$data['entry_attachmentfile'] = $this->language->get('entry_attachmentfile');
	  
			$data['btn_sendmail'] = $this->language->get('btn_sendmail');
			$data['button_cancel'] = $this->language->get('button_cancel');
	
			if(substr(VERSION,0,3)>='3.0') { 
				$data['user_token'] = $this->session->data['user_token'];
			} else {
				$data['token'] = $this->session->data['token'];
			}
	
			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', $this->token_str, $this->modssl)
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link($this->modpath, $this->token_str, $this->modssl)
			);
			
			$data['modpath'] = $this->modpath;
	
			$data['cancel'] = $this->url->link($this->modpath, $this->token_str, $this->modssl);
			
			$data['toemail'] = isset($mkenqpro_data['email']) ? $mkenqpro_data['email'] : '';
	
			$this->load->model('setting/store');
	
			$data['stores'] = $this->model_setting_store->getStores();
	
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
	
			$this->response->setOutput($this->load->view($this->modtpl_mail, $data));
		}
	}
	
	public function upload() {
		$this->session->data['target_attachment_file'] = false;
		//print_r($_FILES["attachmentfile"]);exit;
		if(isset($_FILES["attachmentfile"])) {
			$attach = true;
			$target_attachment_file = DIR_IMAGE . '/catalog/sendquotemail_upload/' . basename($_FILES["attachmentfile"]["name"]);
			$this->session->data['target_attachment_file'] = $target_attachment_file;
			move_uploaded_file($_FILES["attachmentfile"]["tmp_name"], $target_attachment_file);
		}
	}

	public function sendmail() {
		$this->load->language($this->modpath);

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', $this->modpath)) {
				$json['error']['warning'] = $this->language->get('error_permission_email');
			}
			
			if (!$this->request->post['toemail']) {
				$json['error']['toemail'] = $this->language->get('error_toemail');
			}
			
			if (!$this->request->post['subject']) {
				$json['error']['subject'] = $this->language->get('error_subject');
			}

			if (!$this->request->post['message']) {
				$json['error']['message'] = $this->language->get('error_message');
			}
			 
			if (!$json) {
				$this->load->model('setting/store');

				$store_info = $this->model_setting_store->getStore($this->request->post['store_id']);

				if ($store_info) {
					$store_name = $store_info['name'];
				} else {
					$store_name = $this->config->get('config_name');
				}
				
				$this->load->model('setting/setting');
				$setting = $this->model_setting_setting->getSetting('config', $this->request->post['store_id']);

				$email_total = 0;

 				$Toemails[] = $this->request->post['toemail'];
				$Fromemails = $this->config->get('config_email');
 				
 				if ($Toemails) {
					$json['success'] = $this->language->get('text_success_email');
    
					$json['next'] = ''; 
					 
 					$message  = '<html dir="ltr" lang="en">' . "\n";
					$message .= '  <head>' . "\n";
					$message .= '    <title>' . $this->request->post['subject'] . '</title>' . "\n";
					$message .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
					$message .= '  </head>' . "\n";
					$message .= '  <body>' . html_entity_decode($this->request->post['message'], ENT_QUOTES, 'UTF-8') . '</body>' . "\n";
					$message .= '</html>' . "\n";

					foreach ($Toemails as $email) {
						if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
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

							$mail->setTo($email);
							$mail->setFrom($Fromemails);
							$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
							$mail->setSubject(html_entity_decode($this->request->post['subject'], ENT_QUOTES, 'UTF-8'));
							$mail->setHtml($message);
							if(isset($this->session->data['target_attachment_file']) && $this->session->data['target_attachment_file']) { 
								$mail->addAttachment($this->session->data['target_attachment_file']);	
							}							
							$mail->send();
							
							// set send mail = true
							$this->db->query("UPDATE " . DB_PREFIX . "mkenqpro SET replied_enquiry = 1 WHERE mkenqpro_id = '" . (int)$this->request->post['mkenqpro_id'] . "'");
						}
					}
				} else {
					$json['error']['email'] = $this->language->get('error_email');
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

 	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', $this->modpath)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}