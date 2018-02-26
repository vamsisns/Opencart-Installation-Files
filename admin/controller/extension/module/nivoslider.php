<?php
class ControllerExtensionModuleNivoSlider extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/nivoslider');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (!isset($this->request->get['module_id'])) {
			$data['apply_btn'] = false;
		} else {
			$data['apply_btn'] = true;
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('nivoslider', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			if ($this->request->post['apply']) {
				$this->session->data['success'] = $this->language->get('text_apply');
				$this->response->redirect($this->url->link('extension/module/nivoslider', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true));
			} else {
				$this->session->data['success'] = $this->language->get('text_success');
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['default_store'] = $this->config->get('config_name');
		$data['version'] = '1.1';

		$data['text_author'] = date('Y') . ' © ' . $this->language->get('text_author');
		$data['text_author_link'] = $this->language->get('text_author_link');
		$data['text_support'] = $this->language->get('text_support');
		$data['text_more'] = $this->language->get('text_more');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_allcat'] = $this->language->get('text_allcat');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['text_autocomplete'] = $this->language->get('text_autocomplete');

		$data['entry_module_name'] = $this->language->get('entry_module_name');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_categories'] = $this->language->get('entry_categories');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['text_elegant_style'] = $this->language->get('text_elegant_style');
		$data['text_bar_style'] = $this->language->get('text_bar_style');
		$data['text_light_style'] = $this->language->get('text_light_style');
		$data['text_dark_style'] = $this->language->get('text_dark_style');
		$data['text_default_style'] = $this->language->get('text_default_style');

		$data['entry_banner'] = $this->language->get('entry_banner');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['entry_style'] = $this->language->get('entry_style');
		$data['entry_autoplay'] = $this->language->get('entry_autoplay');
		$data['entry_effect'] = $this->language->get('entry_effect');
		$data['entry_slices'] = $this->language->get('entry_slices');
		$data['entry_boxes'] = $this->language->get('entry_boxes');
		$data['entry_speed'] = $this->language->get('entry_speed');
		$data['entry_start'] = $this->language->get('entry_start');
		$data['entry_pause'] = $this->language->get('entry_pause');
		$data['entry_random'] = $this->language->get('entry_random');
		$data['entry_directionnav'] = $this->language->get('entry_directionnav');
		$data['entry_controlnav'] = $this->language->get('entry_controlnav');
		$data['entry_caption'] = $this->language->get('entry_caption');
		$data['entry_thumbnails'] = $this->language->get('entry_thumbnails');
		$data['entry_thumbwidth'] = $this->language->get('entry_thumbwidth');

		$data['entry_beforechange'] = $this->language->get('entry_beforechange');
		$data['entry_afterchange'] = $this->language->get('entry_afterchange');
		$data['entry_slideshowend'] = $this->language->get('entry_slideshowend');
		$data['entry_lastslide'] = $this->language->get('entry_lastslide');
		$data['entry_afterload'] = $this->language->get('entry_afterload');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_apply'] = $this->language->get('button_apply');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['help_categories'] = $this->language->get('help_categories');
		$data['help_boxes'] = $this->language->get('help_boxes');
		$data['help_slices'] = $this->language->get('help_slices');
		$data['help_start'] = $this->language->get('help_start');

		$data['tab_setting'] = $this->language->get('tab_setting');
		$data['tab_config'] = $this->language->get('tab_config');
		$data['tab_triggers'] = $this->language->get('tab_triggers');

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

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/nivoslider', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/nivoslider', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/nivoslider', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/nivoslider', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['banner_id'])) {
			$data['banner_id'] = $this->request->post['banner_id'];
		} elseif (!empty($module_info)) {
			$data['banner_id'] = $module_info['banner_id'];
		} else {
			$data['banner_id'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = 1;
		}

		$data['nivoslider'] = array();

		if (isset($this->request->post['nivoslider'])) {
			$data['nivoslider'] = $this->request->post['nivoslider'];
		} elseif (!empty($module_info)) {
			$data['nivoslider'] = $module_info['nivoslider'];
		} else {
			$data['nivoslider']['store_id'][] = 0;
			$data['nivoslider']['allcat'] = 1;
			$data['nivoslider']['location'] = 1;
			$data['nivoslider']['controlnavthumbs'] = 'false';
		}

		$this->load->model('design/banner');
		$data['banners'] = $this->model_design_banner->getBanners();

		$this->load->model('setting/store');
		$data['stores'] = $this->model_setting_store->getStores();

		$this->load->model('catalog/category');
		$data['categories'] = array();

		if (!empty($this->request->post['nivoslider']['fcat'])) {
			$categories = $this->request->post['nivoslider']['fcat'];
		} elseif (!empty($module_info) && !empty($module_info['nivoslider']['fcat'])) {
			$categories = $module_info['nivoslider']['fcat'];
		} else {
			$categories = array();
		}

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => $category_info['path'] ? $category_info['path'] . ' - &gt; ' . $category_info['name'] : $category_info['name']
					);
			}
		}

		$data['locations'] = array();

		if (!empty($this->request->post['nivoslider']['fcid'])) {
			$locations = $this->request->post['nivoslider']['fcid'];
		} elseif (!empty($module_info) && !empty($module_info['nivoslider']['fcid'])) {
			$locations = $module_info['nivoslider']['fcid'];
		} else {
			$locations = array();
		}

		foreach ($locations as $location) {
			$category_info = $this->model_catalog_category->getCategory($location);

			if ($category_info) {
				$data['locations'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => $category_info['path'] ? $category_info['path'] . ' - &gt; ' . $category_info['name'] : $category_info['name']
					);
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/nivoslider', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/nivoslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}
}