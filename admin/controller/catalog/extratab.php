<?php
class ControllerCatalogExtratab extends Controller {
	private $error = array();
 
	public function index() {
		$this->language->load('catalog/extratab');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/extratab');
		
		$this->getList();
	} 

	public function update() {
		$this->language->load('catalog/extratab');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/extratab');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_extratab->editExtratab($this->request->get['extra_tab_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->response->redirect($this->url->link('catalog/extratab', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
	
	public function insert() {
		$this->language->load('catalog/extratab');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/extratab');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_extratab->addExtratab($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->response->redirect($this->url->link('catalog/extratab', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
	
	public function delete() { 
		$this->language->load('catalog/extratab');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/extratab');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $extra_tab_id) {
				$this->model_catalog_extratab->deleteExtratab($extra_tab_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->response->redirect($this->url->link('catalog/extratab', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
			
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'date_added';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		$url = '';
					
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
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/extratab', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);
							
		$data['insert'] = $this->url->link('catalog/extratab/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/extratab/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$data['extratabs'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$extratab_total = $this->model_catalog_extratab->getTotalExtratabs($filter_data);
		
		$results = $this->model_catalog_extratab->getExtratabs($filter_data);
    	
		foreach ($results as $result) {

			$data['extratabs'][] = array(
				'extra_tab_id'  => $result['extra_tab_id'],
				'name'     => $result['name'],
				'status'     => $result['status'],
				'sort_order'     => $result['sort_order'],				
				'status_text'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),		
				'selected'   => isset($this->request->post['selected']) && in_array($result['extra_tab_id'], $this->request->post['selected']),
				'edit'		=> $this->url->link('catalog/extratab/update', 'token=' . $this->session->data['token'] . '&extra_tab_id=' . $result['extra_tab_id'] . $url, 'SSL')
			);
		}	
	
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_edit'] = $this->language->get('button_edit');		
 
 		$data['token'] = $this->session->data['token'];
		
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

		$url = '';
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_name'] = $this->url->link('catalog/extratab', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');		
		$data['sort_sort_order'] = $this->url->link('catalog/extratab', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('catalog/extratab', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $extratab_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/extratab', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($extratab_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($extratab_total - $this->config->get('config_limit_admin'))) ? $extratab_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $extratab_total, ceil($extratab_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/extratab_list.tpl', $data));		
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');		

		$data['column_from'] = $this->language->get('column_from');
		$data['column_text'] = $this->language->get('column_text');
		$data['column_subject'] = $this->language->get('column_subject');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['text_wait'] = $this->language->get('text_wait');
		$data['text_guests'] = $this->language->get('text_guests');		
		$data['text_before0'] = $this->language->get('text_before0');			
		$data['text_before1'] = $this->language->get('text_before1');	
		$data['text_before2'] = $this->language->get('text_before2');	
		$data['text_before3'] = $this->language->get('text_before3');	
		$data['text_before4'] = $this->language->get('text_before4');			
		$data['text_overwrite'] = $this->language->get('text_overwrite');	

		$data['text_skip'] = $this->language->get('text_skip');					
		$data['text_confirm_operation'] = $this->language->get('text_confirm_operation');			
		$data['text_select_all'] = $this->language->get('text_select_all');	
		$data['text_deselect_all'] = $this->language->get('text_deselect_all');			
		$data['tab_general'] = $this->language->get('tab_general');		
		$data['tab_products'] = $this->language->get('tab_products');				
		$data['tab_products_remove'] = $this->language->get('tab_products_remove');			
	
		$data['entry_assign'] = $this->language->get('entry_assign');		
		$data['entry_position'] = $this->language->get('entry_position');		
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_title'] = $this->language->get('entry_title');		
		$data['entry_store'] = $this->language->get('entry_store');		
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');		
		$data['entry_select_categories'] = $this->language->get('entry_select_categories');		
		$data['entry_select_categories_remove'] = $this->language->get('entry_select_categories_remove');					
		$data['entry_select_option'] = $this->language->get('entry_select_option');				
		$data['entry_select_option_general'] = $this->language->get('entry_select_option_general');	
		$data['entry_select_option_content'] = $this->language->get('entry_select_option_content');	
		
		$data['text_default'] = $this->language->get('text_default');
		$data['text_answered'] = $this->language->get('text_answered');
		$data['text_not_answered'] = $this->language->get('text_not_answered');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');		
		
		$data['button_send'] = $this->language->get('button_send');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['extratabs_overwrite_general'] = $this->config->get('extratabs_overwrite_general');
		$data['extratabs_overwrite_content'] = $this->config->get('extratabs_overwrite_content');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
 		
 		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		$url = '';
	
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
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/extratab', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);
										
		if (!isset($this->request->get['extra_tab_id'])) { 
			$data['action'] = $this->url->link('catalog/extratab/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/extratab/update', 'token=' . $this->session->data['token'] . '&extra_tab_id=' . $this->request->get['extra_tab_id'] . $url, 'SSL');
		}
		
		$data['cancel'] = $this->url->link('catalog/extratab', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['extra_tab_id'] ='0';
		
		if (isset($this->request->get['extra_tab_id'])){// && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$extratab_info = $this->model_catalog_extratab->getExtratab($this->request->get['extra_tab_id']);
						
			$data['extra_tab_id'] = $extratab_info['extra_tab_id'];			
		}


		$data['token'] = $this->session->data['token'];
		$data['categories2'] = array();
		$data['products_assigned'] = array();
		if ($this->config->get('extratabs_tree_type')==1) {	
		
			if (isset($this->request->get['extra_tab_id']))	{	
				$data['categories2'] = $this->model_catalog_extratab->getExtratabCategories($this->request->get['extra_tab_id']);			
				$categories_to_change = $this->model_catalog_extratab->getCategoriesToChange($this->request->get['extra_tab_id']);			
				$data['products_assigned'] = $this->get_assigned($categories_to_change); 
				$data['tree'] = $this->get_tree($data['categories2']);
				}
			else {
				$data['categories2'] = $this->model_catalog_extratab->getExtratabCategories(0);
				$data['products_assigned'] = "";
				$data['tree'] = $this->get_tree($data['categories2'],null);
			}
		} else {
			
			if (isset($this->request->get['extra_tab_id']))	{
				$data['categories2'] = $this->model_catalog_extratab->getExtratabCategoriesOnly($this->request->get['extra_tab_id']);					
				$data['products_assigned'] = $this->get_assigned_categories($data['categories2']); 
				$data['tree'] = $this->get_tree($data['categories2'],null);
				}
			else {
				$data['categories2'] = $this->model_catalog_extratab->getExtratabCategoriesOnly(0);
				$data['products_assigned'] = "";
				$data['tree'] = $this->get_tree($data['categories2'],null);
			}		
		}
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($extratab_info)) {
			$data['name'] = $extratab_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($extratab_info)) {
			$data['status'] = $extratab_info['status'];
		} else {
			$data['status'] = '1';
		}
		$this->load->model('catalog/category');		
		$data['all_categories'] = $this->model_catalog_category->getCategories(array());
		
		$this->load->model('setting/store');		
		$data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['tab_stores'])) {
			$data['tab_stores'] = $this->request->post['tab_stores'];
		} elseif (isset($this->request->get['extra_tab_id'])) {
			$data['tab_stores'] = $extratab_info['tab_stores'];
		} else {
			$data['tab_stores'] = array('0');
		}	
		
		$customer_group_file = DIR_APPLICATION . 'model/sale/customer_group.php';
		if (file_exists($customer_group_file)) {		
			$this->load->model('sale/customer_group');		
			$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		} else {
			$this->load->model('customer/customer_group');		
			$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();			
		}
		if (isset($this->request->post['tab_customer_groups'])) {
			$data['tab_customer_groups'] = $this->request->post['tab_customer_groups'];
		} elseif (isset($this->request->get['extra_tab_id'])) {
			$data['tab_customer_groups'] = $extratab_info['tab_customer_groups'];
		} else {
			$data['tab_customer_groups'] = array('0');
		}
		
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($extratab_info)) {
			$data['sort_order'] = $extratab_info['sort_order'];
		} else {
			$data['sort_order'] = '0';
		}		
		if (isset($this->request->post['position'])) {
			$data['position'] = $this->request->post['position'];
		} elseif (!empty($extratab_info)) {
			$data['position'] = $extratab_info['position'];
		} else {
			$data['position'] = '0';
		}		
		$this->load->model('localisation/language');
		$data['languages']=$this->model_localisation_language->getLanguages();
		
		$data['descriptions'] = array();
		foreach ($data['languages'] as $language){
			$data['descriptions'][$language['language_id']] = array();
			if (isset($this->request->post['descriptions'][$language['language_id']]['extra_tab_title'])) {
				$data['descriptions'][$language['language_id']]['extra_tab_title'] = $this->request->post['descriptions'][$language['language_id']]['extra_tab_title'];
			} elseif (!empty($extratab_info['descriptions'][$language['language_id']]['extra_tab_title'])) {
				$data['descriptions'][$language['language_id']]['extra_tab_title'] = $extratab_info['descriptions'][$language['language_id']]['extra_tab_title'];
			} else {
				$data['descriptions'][$language['language_id']]['extra_tab_title'] = '';
			}	
			if (isset($this->request->post['descriptions'][$language['language_id']]['extra_tab_text'])) {
				$data['descriptions'][$language['language_id']]['extra_tab_text'] = $this->request->post['descriptions'][$language['language_id']]['extra_tab_text'];
			} elseif (!empty($extratab_info['descriptions'][$language['language_id']]['extra_tab_text'])) {
				$data['descriptions'][$language['language_id']]['extra_tab_text'] = $extratab_info['descriptions'][$language['language_id']]['extra_tab_text'];
			} else {
				$data['descriptions'][$language['language_id']]['extra_tab_text'] = '';
			}
			if (isset($this->request->post['descriptions'][$language['language_id']]['language_id'])) {
				$data['descriptions'][$language['language_id']]['language_id'] = $this->request->post['descriptions'][$language['language_id']]['language_id'];
			} elseif (!empty($extratab_info['descriptions'][$language['language_id']]['language_id'])) {
				$data['descriptions'][$language['language_id']]['language_id'] = $extratab_info['descriptions'][$language['language_id']]['language_id'];
			} else {
				$data['descriptions'][$language['language_id']]['language_id'] = '';
			}				
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/extratab_form.tpl', $data));			
	}
	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/extratab')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		$version=(int)str_replace('.', '', VERSION);
		while($version>1000) {
			$version=(int)$version/10;}
		if ($version<152) {
			if ((strlen(utf8_decode($this->request->post['name'])) < 1) || (strlen(utf8_decode($this->request->post['name'])) > 96)) {
				$this->error['name'] = $this->language->get('error_name');
			}
		}
		else {
			if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 96)) {
				$this->error['name'] = $this->language->get('error_name');
			}
		}
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}			
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/extratab')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	
	public function getextratab() {
		$this->load->model('catalog/extratab');
		$extratab_data = $this->model_catalog_extratab->getExtratab($this->request->get['extra_tab_id']);			
		
		$this->response->setOutput(json_encode($extratab_data));
	}		
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/product');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_name'  => $filter_name,				
				'start'        => 0,
				'limit'        => $limit
			);
			
			$results = $this->model_catalog_product->getProducts($data);
			
			foreach ($results as $result) {
					
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}	
	public function get_tree($data) {
		$result="<div id=\"page-wrap\">";
        $result.="<ul><li><img src=\"view/image/collapse.png\" alt=\"1\" onclick='if ($(this).attr(\"alt\")==0)";
		$result.="&#123;$(\"#allcat\")";
		$result.=".css(\"display\",\"table-row\");";
		$result.="	$(this).attr(\"alt\",\"1\"); $(this).attr(\"src\",\"view/image/collapse.png\");&#125; else";
		$result.="		&#123;$(\"#allcat\").css(\"display\",\"none\");$(this).attr(\"alt\",\"0\");$(this).attr(\"src\",\"view/image/expand.png\");&#125;'>";
        $result.="    <input type=\"checkbox\" name=\"tall\" id=\"all_cat\">";
        $result.="    <label for=\"all_cat\">All Categories</label>";
        $result.="    <div id=\"allcat\" style=\"display: table-row;\"> ";				

		 $result.="<ul><div>";		

		if ($this->config->get('extratabs_tree_type')==0) {
			foreach ($data as $key=>$category) {
				if ($category['parent']==0)
					$result .= $this->build_cat_only($data,$key);
			}
		} else {
			foreach ($data as $key=>$category) {
				if ($category['parent']==0)
					$result .= $this->build_cat($data,$key);
			}
		}
		$result.="</div></ul></div></li></ul></div>";
		return $result;		
	}
	public function build_cat_only($data,$cat_id) {			
			
		$result="";
			if (!empty($data[$cat_id]['categories'])) {

				$temp_result="";
				foreach ($data[$cat_id]['categories'] as $category) {
						$temp_result .= $this->build_cat_only($data,$category);
				}		
				if ($temp_result=="") {

						$result.="<li><img src=\"view/image/clear.png\" >";
						$result.="<input type=\"checkbox\" name=\"categories[]\" id=\"cat_name". $cat_id ."\" value=\"".$cat_id."\"><img src=\"view/image/cat.png\">";
						$result.="    <label for=\"cat_name". $cat_id ."\"><b>".$data[$cat_id]['name']."</b></label>";
						$result.="    <div id=\"cat". $cat_id ."\" style=\"display: none;\"> ";		
						$result.="		<ul><div>";
	
				} else {
					$result.="<li><img src=\"view/image/expand.png\" alt=\"0\" onclick='if ($(this).attr(\"alt\")==0)";
					$result.="&#123;$(\"#cat". $cat_id ."\")";
					$result.=".css(\"display\",\"table-row\");";
					$result.="	$(this).attr(\"alt\",\"1\"); $(this).attr(\"src\",\"view/image/collapse.png\");&#125; else";
					$result.="		&#123;$(\"#cat". $cat_id."\").css(\"display\",\"none\");$(this).attr(\"alt\",\"0\");$(this).attr(\"src\",\"view/image/expand.png\");&#125;'>";					
					
					if ($data[$cat_id]['has_products']==0) {
						$result.="<input type=\"checkbox\" name=\"categories[]\" id=\"cat_name". $cat_id ."\" value=\"".$cat_id."\"><img src=\"view/image/cat.png\">";
						$result.="    <label for=\"cat_name". $cat_id ."\"><b>".$data[$cat_id]['name']."</b></label>";
						$result.="    <div id=\"cat". $cat_id ."\" style=\"display: none;\"> ";		
						$result.="		<ul><div>";										
					} else {
						$result.="<input type=\"checkbox\" name=\"tall\" id=\"cat_name_fake". $cat_id ."\"><img src=\"view/image/cat.png\">";
						$result.="    <label for=\"cat_name_fake". $cat_id ."\"><b>".$data[$cat_id]['name']."</b></label>";
						$result.="    <div id=\"cat". $cat_id ."\" style=\"display: none;\"> ";		
						$result.="		<ul><div>";				
						
						$temp_result.="<li><img src=\"view/image/clear.png\"><input type=\"checkbox\" name=\"categories[]\" id=\"cat_name".$cat_id."\" value=\"".$cat_id."\"><img src=\"view/image/pro.png\"> <label for=\"cat_name".$cat_id."\">Products(".$data[$cat_id]['has_products'].")</label></li>";						
					}
				}
				
				$result.=$temp_result."</div></ul></div></li>";
			} else {
				$result.="<li><img src=\"view/image/clear.png\"></img>";		

				$result.="<input type=\"checkbox\" name=\"categories[]\" id=\"cat_name". $cat_id ."\" value=\"".$cat_id."\"><img src=\"view/image/cat.png\">";
					
				$result.="    <label for=\"cat_name". $cat_id ."\"><b>".$data[$cat_id]['name']."</b></label>";	
				$result.= "</li>";			
			}

			return $result;		
	}		
	public function build_cat($data,$cat_id) {

		$temp_result="";
		foreach ($data[$cat_id]['categories'] as $category) {
				$temp_result .= $this->build_cat($data,$category);
		}
		$temp_result .= $this->build_pro($data,$cat_id);		
		if ($temp_result=="") {
			$result="";		
			$result.="<li><img src=\"view/image/clear.png\" >";
		} else {
			$result="";
			$result.="<li><img src=\"view/image/expand.png\" alt=\"0\" onclick='if ($(this).attr(\"alt\")==0)";
			$result.="&#123;$(\"#cat". $cat_id ."\")";
			$result.=".css(\"display\",\"table-row\");";
			$result.="	$(this).attr(\"alt\",\"1\"); $(this).attr(\"src\",\"view/image/collapse.png\");&#125; else";
			$result.="		&#123;$(\"#cat". $cat_id."\").css(\"display\",\"none\");$(this).attr(\"alt\",\"0\");$(this).attr(\"src\",\"view/image/expand.png\");&#125;'>";		
		}
		if ($data[$cat_id]['enabled'])
		$result.="<input type=\"checkbox\" checked=\"checked\" name=\"categories[]\" id=\"cat_name". $cat_id ."\" value=\"".$cat_id."\"><img src=\"view/image/cat.png\">";
		else
		$result.="<input type=\"checkbox\" name=\"categories[]\" id=\"cat_name". $cat_id ."\" value=\"".$cat_id."\"><img src=\"view/image/cat.png\">";
		$result.="    <label for=\"cat_name". $cat_id ."\"><b>".$data[$cat_id]['name']."</b></label>";
		$result.="    <div id=\"cat". $cat_id ."\" style=\"display: none;\"> ";		
		$result.="		<ul><div>";	

		$result.=$temp_result."</div></ul></div></li>";
		return $result;
	}	
	public function build_pro($data,$cat_id) {
		$result="";		
		foreach ($data[$cat_id]['products'] as $key=>$product) {
			if ($product['enabled'])
			//if ($category['has_tab'])
			$result.="<li><img src=\"view/image/clear.png\"><input type=\"checkbox\" checked=\"checked\" name=\"products[]\" id=\"pro".$product['product_id']."_".$cat_id."\" value=\"".$product['product_id']."\"><img src=\"view/image/pro.png\"> <label for=\"pro".$product['product_id']."_".$cat_id."\">".$product['name']."</label></li>";		
			else
			$result.="<li><img src=\"view/image/clear.png\"><input type=\"checkbox\" name=\"products[]\" id=\"pro".$product['product_id']."_".$cat_id."\" value=\"".$product['product_id']."\"><img src=\"view/image/pro.png\"> <label for=\"pro".$product['product_id']."_".$cat_id."\">".$product['name']."</label></li>";		
		}

		return $result;
	}		
	public function get_assigned($data) {
		$result="";		
		foreach ($data as $category) {
			//$result.="	$('#pro".$category['product_id']."_".$category['category_id']."').click();\n";		
			$result.="	$('#pro".$category['product_id']."_".$category['category_id']."').change();\n";		
		}

		return $result;
	}
	public function get_assigned_categories($data) {
		$result="";		
		foreach ($data as $category_id => $category) {
			$parent = false;
			if ($category['parent']!=0)
				if (($data[$category['parent']]['enabled']))
					$parent = true;
			if ((($category['enabled'])&&(!$parent)) || ((!$category['enabled'])&&($parent)))
				if (($category['has_products']) &&(count($category['categories'])>0))
					$result.="	$('#cat_name_fake".$category_id."').click();\n";		
				else 
					$result.="	$('#cat_name".$category_id."').click();\n";		
		}

		return $result;
	}	
}
