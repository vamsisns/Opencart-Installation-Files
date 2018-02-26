<?php
/*****************************************************************************
 *
 * ---------------------------------------------------------------
 * Australia Post: Postage Assesment Calculator for Opencart 2.3+
 *    (c) 2017 WWWShop, unauthorized reproduction is prohibited
 * ---------------------------------------------------------------
 *
 * Developer: WWWShop (opencart@wwwshop.com.au)
 * Date: 2017-11-21
 * Website: http://wwwshop.com.au/
 *
 *****************************************************************************/
class ControllerExtensionShippingAuspostPac extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/auspost_pac');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('auspost_pac', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_services'] = $this->language->get('tab_services');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
        $data['text_select_service'] = $this->language->get('text_select_service');

		$data['help_origin_postcode'] = $this->language->get('help_origin_postcode');
		$data['help_show_delivery_time'] = $this->language->get('help_show_delivery_time');
		$data['help_multiple_packages'] = $this->language->get('help_multiple_packages');
		$data['help_handling_fee'] = $this->language->get('help_handling_fee');
		$data['help_min_weight'] = $this->language->get('help_min_weight');
		$data['help_max_weight'] = $this->language->get('help_max_weight');
		$data['help_remove_gst_from_price'] = $this->language->get('help_remove_gst_from_price');

		$data['entry_api_key'] = $this->language->get('entry_api_key');
		$data['entry_origin_postcode'] = $this->language->get('entry_origin_postcode');
        $data['entry_service'] = $this->language->get('entry_service');
        $data['entry_region'] = $this->language->get('entry_region');
        $data['entry_options'] = $this->language->get('entry_options');
		$data['entry_selected_services'] = $this->language->get('entry_selected_services');
		$data['entry_show_delivery_time'] = $this->language->get('entry_show_delivery_time');
		$data['entry_multiple_packages'] = $this->language->get('entry_multiple_packages');
		$data['entry_handling_fee'] = $this->language->get('entry_handling_fee');
		$data['entry_min_weight'] = $this->language->get('entry_min_weight');
		$data['entry_max_weight'] = $this->language->get('entry_max_weight');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_remove_gst_from_price'] = $this->language->get('entry_remove_gst_from_price');
        $data['entry_one_item_per_parcel'] = $this->language->get('entry_one_item_per_parcel');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_service_add'] = $this->language->get('button_service_add');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['api_key'])) {
			$data['error_api_key'] = $this->error['api_key'];
		} else {
			$data['error_api_key'] = '';
		}

		if (isset($this->error['origin_postcode'])) {
			$data['error_origin_postcode'] = $this->error['origin_postcode'];
		} else {
			$data['error_origin_postcode'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true)
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/shipping/auspost_pac', 'token=' . $this->session->data['token'], true),
		);

		$data['action'] = $this->url->link('extension/shipping/auspost_pac', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

		if (isset($this->request->post['auspost_pac_api_key'])) {
			$data['auspost_pac_api_key'] = $this->request->post['auspost_pac_api_key'];
		} else {
			$data['auspost_pac_api_key'] = $this->config->get('auspost_pac_api_key');
		}

		if (isset($this->request->post['auspost_pac_origin_postcode'])) {
			$data['auspost_pac_origin_postcode'] = $this->request->post['auspost_pac_origin_postcode'];
		} else {
			$data['auspost_pac_origin_postcode'] = $this->config->get('auspost_pac_origin_postcode');
		}

		if (isset($this->request->post['auspost_pac_service'])) {
			$data['auspost_pac_services'] = $this->request->post['auspost_pac_service'];
		} else {
			$data['auspost_pac_services'] = $this->config->get('auspost_pac_service');
		}

		$options_aus_parcel_regular = array(
			'AUS_SERVICE_OPTION_STANDARD' => array(
				'name' => $this->language->get('text_option_aus_service_option_standard'),
				'code' => 'AUS_SERVICE_OPTION_STANDARD',
			),
			'AUS_SERVICE_OPTION_SIGNATURE_ON_DELIVERY' => array(
				'name' => $this->language->get('text_option_aus_service_option_signature_on_delivery'),
				'code' => 'AUS_SERVICE_OPTION_SIGNATURE_ON_DELIVERY',
				'suboptions' => array(
					'AUS_SERVICE_OPTION_EXTRA_COVER' => array(
						'name' => $this->language->get('text_suboption_aus_service_option_extra_cover'),
						'code' => 'AUS_SERVICE_OPTION_EXTRA_COVER',
						'note' => $this->language->get('text_misc_extra_cover_up_to_5000'),
					),
				)
			),
		);

		$options_aus_parcel_express = $options_aus_parcel_regular;

		$options_aus_parcel_courier = array(
			'AUS_SERVICE_OPTION_STANDARD' => array(
				'name' => $this->language->get('text_option_aus_service_option_standard'),
				'code' => 'AUS_SERVICE_OPTION_STANDARD',
				'suboptions' => array(
					'AUS_SERVICE_OPTION_EXTRA_COVER' => array(
						'name' => $this->language->get('text_suboption_aus_service_option_extra_cover'),
						'code' => 'AUS_SERVICE_OPTION_EXTRA_COVER',
						'note' => $this->language->get('text_misc_extra_cover_up_to_5000'),
					),
				)
			),
		);

		$data['domestic'] = array(
			// Regular Parcels / Satchels
			'AUS_PARCEL_REGULAR' => array(
				'name' => $this->language->get('text_service_aus_parcel_regular'),
				'code' => 'AUS_PARCEL_REGULAR',
				'options' => $options_aus_parcel_regular,
			),
			'AUS_PARCEL_REGULAR_SATCHEL_500G' => array(
				'name' => $this->language->get('text_service_aus_parcel_regular_satchel_500g'),
				'code' => 'AUS_PARCEL_REGULAR_SATCHEL_500G',
				'options' => $options_aus_parcel_regular,
			),
			'AUS_PARCEL_REGULAR_SATCHEL_3KG' => array(
				'name' => $this->language->get('text_service_aus_parcel_regular_satchel_3kg'),
				'code' => 'AUS_PARCEL_REGULAR_SATCHEL_3KG',
				'options' => $options_aus_parcel_regular,
			),
			'AUS_PARCEL_REGULAR_SATCHEL_5KG' => array(
				'name' => $this->language->get('text_service_aus_parcel_regular_satchel_5kg'),
				'code' => 'AUS_PARCEL_REGULAR_SATCHEL_5KG',
				'options' => $options_aus_parcel_regular,
			),

			// Express Parcels / Satchels
			'AUS_PARCEL_EXPRESS' => array(
				'name' => $this->language->get('text_service_aus_parcel_express'),
				'code' => 'AUS_PARCEL_EXPRESS',
				'options' => $options_aus_parcel_express,
			),
			'AUS_PARCEL_EXPRESS_SATCHEL_500G' => array(
				'name' => $this->language->get('text_service_aus_parcel_express_satchel_500g'),
				'code' => 'AUS_PARCEL_EXPRESS_SATCHEL_500G',
				'options' => $options_aus_parcel_express,
			),
			'AUS_PARCEL_EXPRESS_SATCHEL_3KG' => array(
				'name' => $this->language->get('text_service_aus_parcel_express_satchel_3kg'),
				'code' => 'AUS_PARCEL_EXPRESS_SATCHEL_3KG',
				'options' => $options_aus_parcel_express,
			),
			'AUS_PARCEL_EXPRESS_SATCHEL_5KG' => array(
				'name' => $this->language->get('text_service_aus_parcel_express_satchel_5kg'),
				'code' => 'AUS_PARCEL_EXPRESS_SATCHEL_5KG',
				'options' => $options_aus_parcel_express,
			),

			// Courier Parcels / Satchels
			'AUS_PARCEL_COURIER' => array(
				'name' => $this->language->get('text_service_aus_parcel_courier'),
				'code' => 'AUS_PARCEL_COURIER',
				'options' => $options_aus_parcel_courier,
			),
			'AUS_PARCEL_COURIER_SATCHEL_MEDIUM' => array(
				'name' => $this->language->get('text_service_aus_parcel_courier_satchel_medium'),
				'code' => 'AUS_PARCEL_COURIER_SATCHEL_MEDIUM',
				'options' => $options_aus_parcel_courier,
			),
		);

		$data['international'] = array(
			'INT_PARCEL_AIR_OWN_PACKAGING' => array(
				'name' => $this->language->get('text_service_int_parcel_air_own_packaging'),
				'code' => 'INT_PARCEL_AIR_OWN_PACKAGING',
				'options' => array(
					'INT_EXTRA_COVER' => array(
						'name' => $this->language->get('text_option_int_extra_cover'),
						'code' => 'INT_EXTRA_COVER',
						'note' => $this->language->get('text_misc_extra_cover_up_to_5000'),
					),
                    'INT_SIGNATURE_ON_DELIVERY' => array(
                        'name' => $this->language->get('text_option_int_signature_on_delivery'),
                        'code' => 'INT_SIGNATURE_ON_DELIVERY',
                    ),
				),
			),
			'INT_PARCEL_SEA_OWN_PACKAGING' => array(
				'name' => $this->language->get('text_service_int_parcel_sea_own_packaging'),
				'code' => 'INT_PARCEL_SEA_OWN_PACKAGING',
				'options' => array(
					'INT_EXTRA_COVER' => array(
						'name' => $this->language->get('text_option_int_extra_cover'),
						'code' => 'INT_EXTRA_COVER',
						'note' => $this->language->get('text_misc_extra_cover_up_to_5000'),
					),
                    'INT_SIGNATURE_ON_DELIVERY' => array(
                        'name' => $this->language->get('text_option_int_signature_on_delivery'),
                        'code' => 'INT_SIGNATURE_ON_DELIVERY',
                    ),
				),
			),
			'INT_PARCEL_STD_OWN_PACKAGING' => array(
				'name' => $this->language->get('text_service_int_parcel_std_own_packaging'),
				'code' => 'INT_PARCEL_STD_OWN_PACKAGING',
				'options' => array(
					'INT_EXTRA_COVER' => array(
						'name' => $this->language->get('text_option_int_extra_cover'),
						'code' => 'INT_EXTRA_COVER',
						'note' => $this->language->get('text_misc_extra_cover_up_to_5000'),
					),
                    'INT_SIGNATURE_ON_DELIVERY' => array(
                        'name' => $this->language->get('text_option_int_signature_on_delivery'),
                        'code' => 'INT_SIGNATURE_ON_DELIVERY',
                    ),
                    'INT_SMS_TRACK_ADVICE' => array(
                        'name' => $this->language->get('text_option_int_sms_track_advice'),
                        'code' => 'INT_SMS_TRACK_ADVICE',
                    ),
				),
			),
			'INT_PARCEL_EXP_OWN_PACKAGING' => array(
				'name' => $this->language->get('text_service_int_parcel_exp_own_packaging'),
				'code' => 'INT_PARCEL_EXP_OWN_PACKAGING',
				'options' => array(
					'INT_EXTRA_COVER' => array(
						'name' => $this->language->get('text_option_int_extra_cover'),
						'code' => 'INT_EXTRA_COVER',
						'note' => $this->language->get('text_misc_extra_cover_up_to_5000'),
					),
				),
			),
			'INT_PARCEL_COR_OWN_PACKAGING' => array(
				'name' => $this->language->get('text_service_int_parcel_cor_own_packaging'),
				'code' => 'INT_PARCEL_COR_OWN_PACKAGING',
				'options' => array(
					'INT_EXTRA_COVER' => array(
						'name' => $this->language->get('text_option_int_extra_cover'),
						'code' => 'INT_EXTRA_COVER',
						'note' => $this->language->get('text_misc_extra_cover_up_to_5000'),
					),
				),
			),
		);

        foreach ($data['domestic'] as $key => $value) {
            $data['domestic'][$key]['region'] = 'Domestic';
        }

        foreach ($data['international'] as $key => $value) {
            $data['international'][$key]['region'] = 'International';
        }

        $data['services'] = array_merge($data['domestic'], $data['international']);

        $data['selected_services'] = array();

		if (isset($this->request->post['auspost_pac_show_delivery_time'])) {
			$data['auspost_pac_show_delivery_time'] = $this->request->post['auspost_pac_show_delivery_time'];
		} else {
			$data['auspost_pac_show_delivery_time'] = $this->config->get('auspost_pac_show_delivery_time');
		}

		if (isset($this->request->post['auspost_pac_multiple_packages'])) {
			$data['auspost_pac_multiple_packages'] = $this->request->post['auspost_pac_multiple_packages'];
		} else {
			$data['auspost_pac_multiple_packages'] = $this->config->get('auspost_pac_multiple_packages');
		}

		if (isset($this->request->post['auspost_pac_handling_fee'])) {
			$data['auspost_pac_handling_fee'] = (float) $this->request->post['auspost_pac_handling_fee'];
		} else {
			$data['auspost_pac_handling_fee'] = (float) $this->config->get('auspost_pac_handling_fee');
		}
		if (empty($data['auspost_pac_handling_fee'])) {
			$data['auspost_pac_handling_fee'] = '';
		}

		if (isset($this->request->post['auspost_pac_min_weight'])) {
			$data['auspost_pac_min_weight'] = (float) $this->request->post['auspost_pac_min_weight'];
		} else {
			$data['auspost_pac_min_weight'] = (float) $this->config->get('auspost_pac_min_weight');
		}
		if (empty($data['auspost_pac_min_weight'])) {
			$data['auspost_pac_min_weight'] = '';
		}

		if (isset($this->request->post['auspost_pac_max_weight'])) {
			$data['auspost_pac_max_weight'] = (float) $this->request->post['auspost_pac_max_weight'];
		} else {
			$data['auspost_pac_max_weight'] = (float) $this->config->get('auspost_pac_max_weight');
		}
		if (empty($data['auspost_pac_max_weight'])) {
			$data['auspost_pac_max_weight'] = '';
		}

		if (isset($this->request->post['auspost_pac_remove_gst_from_price'])) {
			$data['auspost_pac_remove_gst_from_price'] = $this->request->post['auspost_pac_remove_gst_from_price'];
		} else {
			$data['auspost_pac_remove_gst_from_price'] = $this->config->get('auspost_pac_remove_gst_from_price');
		}

		if (isset($this->request->post['auspost_pac_one_item_per_parcel'])) {
			$data['auspost_pac_one_item_per_parcel'] = $this->request->post['auspost_pac_one_item_per_parcel'];
		} else {
			$data['auspost_pac_one_item_per_parcel'] = $this->config->get('auspost_pac_one_item_per_parcel');
		}

		if (isset($this->request->post['auspost_pac_tax_class_id'])) {
			$data['auspost_pac_tax_class_id'] = $this->request->post['auspost_pac_tax_class_id'];
		} else {
			$data['auspost_pac_tax_class_id'] = $this->config->get('auspost_pac_tax_class_id');
		}

		if (isset($this->request->post['auspost_pac_geo_zone_id'])) {
			$data['auspost_pac_geo_zone_id'] = $this->request->post['auspost_pac_geo_zone_id'];
		} else {
			$data['auspost_pac_geo_zone_id'] = $this->config->get('auspost_pac_geo_zone_id');
		}

		if (isset($this->request->post['auspost_pac_status'])) {
			$data['auspost_pac_status'] = $this->request->post['auspost_pac_status'];
		} else {
			$data['auspost_pac_status'] = $this->config->get('auspost_pac_status');
		}

		if (isset($this->request->post['auspost_pac_sort_order'])) {
			$data['auspost_pac_sort_order'] = $this->request->post['auspost_pac_sort_order'];
		} else {
			$data['auspost_pac_sort_order'] = $this->config->get('auspost_pac_sort_order');
		}

		if (!is_array($data['auspost_pac_services'])) {
			$data['auspost_pac_services'] = array();
		}

		if (!$this->currency->has('AUD')) {
			$data['error_currency'] = $this->language->get('error_currency');
		} else {
			$data['error_currency'] = '';
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/auspost_pac.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping/auspost_pac')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['auspost_pac_api_key']) {
			$this->error['api_key'] = $this->language->get('error_api_key');
		}

		if (!$this->request->post['auspost_pac_origin_postcode']) {
			$this->error['origin_postcode'] = $this->language->get('error_origin_postcode');
		}

		return !$this->error;
	}
}
?>
