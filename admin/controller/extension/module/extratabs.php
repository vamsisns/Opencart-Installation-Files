<?php
class ControllerExtensionModuleExtratabs extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('extension/module/extratabs');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {			
			$this->model_setting_setting->editSetting('extratabs', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_title'] = $this->language->get('text_title');		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_products'] = $this->language->get('text_products');
		$data['text_categories'] = $this->language->get('text_categories');		
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_overwrite'] = $this->language->get('text_overwrite');
		$data['text_skip'] = $this->language->get('text_skip');
		$data['text_general'] = $this->language->get('text_general');
		$data['text_template_form'] = $this->language->get('text_template_form');		
		$data['text_upgrade'] = $this->language->get('text_upgrade');			
		$data['text_success_upgrade'] = $this->language->get('text_success_upgrade');				

		$data['help_tree_type'] = $this->language->get('help_tree_type');
		$data['help_auto_assign'] = $this->language->get('help_auto_assign');
		$data['help_status'] = $this->language->get('help_status');
		$data['help_option_general'] = $this->language->get('help_option_general');
		$data['help_option_content'] = $this->language->get('help_option_content');
		$data['help_upgrade'] = $this->language->get('help_upgrade');		
		
		$data['entry_delete'] = $this->language->get('entry_delete');
		$data['entry_tree_type'] = $this->language->get('entry_tree_type');		
		$data['entry_auto_assign'] = $this->language->get('entry_auto_assign');		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_option_general'] = $this->language->get('entry_option_general');
		$data['entry_option_content'] = $this->language->get('entry_option_content');		
		$data['entry_upgrade'] = $this->language->get('entry_upgrade');		
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/extratabs', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('extension/module/extratabs', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['upgrade'] = $this->url->link('extension/module/extratabs/upgrade', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['extratabs_delete'])) {
			$data['extratabs_delete'] = $this->request->post['extratabs_delete'];
		} else {
			$data['extratabs_delete'] = $this->config->get('extratabs_delete');
		}	
		if (isset($this->request->post['extratabs_status'])) {
			$data['extratabs_status'] = $this->request->post['extratabs_status'];
		} else {
			$data['extratabs_status'] = $this->config->get('extratabs_status');
		}	
		if (isset($this->request->post['extratabs_tree_type'])) {
			$data['extratabs_tree_type'] = $this->request->post['extratabs_tree_type'];
		} else {
			$data['extratabs_tree_type'] = $this->config->get('extratabs_tree_type');
		}		
		if (isset($this->request->post['extratabs_auto_assign'])) {
			$data['extratabs_auto_assign'] = $this->request->post['extratabs_auto_assign'];
		} else {
			$data['extratabs_auto_assign'] = $this->config->get('extratabs_auto_assign');
		}				
		if (isset($this->request->post['extratabs_overwrite_general'])) {
			$data['extratabs_overwrite_general'] = $this->request->post['extratabs_overwrite_general'];
		} else {
			$data['extratabs_overwrite_general'] = $this->config->get('extratabs_overwrite_general');
		}		
		if (isset($this->request->post['extratabs_overwrite_content'])) {
			$data['extratabs_overwrite_content'] = $this->request->post['extratabs_overwrite_content'];
		} else {
			$data['extratabs_overwrite_content'] = $this->config->get('extratabs_overwrite_content');
		}				
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/extratabs.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/extratabs')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}


		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	public function upgrade() {   
		$this->language->load('extension/module/extratabs');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {					
			$this->load->model('extension/extratabs/install');
			$this->model_extension_extratabs_install->install($this->request->post);	
			
			$this->session->data['success'] = $this->language->get('text_success_upgrade');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	
	public function install() {   
		$this->load->model('extension/extratabs/install');
		$this->model_extension_extratabs_install->install();	
	}
	
	public function uninstall() {   
		$this->load->model('extension/extratabs/install');
		$this->model_extension_extratabs_install->uninstall();		
	}	
}
?>