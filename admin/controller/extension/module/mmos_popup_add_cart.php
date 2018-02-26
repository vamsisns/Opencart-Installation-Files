<?php

class ControllerExtensionModuleMmosPopupAddCart extends Controller {

    private $error = array();

    public function index() {
        if (!isset($this->request->get['store_id'])) {
            $this->response->redirect($this->url->link('extension/module/mmos_popup_add_cart', 'token=' . $this->session->data['token'] . '&store_id=0', 'SSL'));
        }
        $data['current_store_id'] = (int) $this->request->get['store_id'];

        $this->load->language('module/mmos_popup_add_cart');

        $this->document->setTitle($this->language->get('heading_title1'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_setting_setting->editSetting('popup_add_cart', $this->request->post, $data['current_store_id']);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module/mmos_popup_add_cart&store_id=' . $data['current_store_id'], 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->document->addStyle('view/javascript/colorpicker/css/colorpicker.css');
        $this->document->addScript('view/javascript/colorpicker/js/bootstrap-colorpicker.js');

        //WWw.MMOsolution.com config data -- DO NOT REMOVE--- 
        $data['MMOS_version'] = '1.3';
        $data['MMOS_code_id'] = 'MMOSOC167';

        $data['heading_title'] = $this->language->get('heading_title1');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_width'] = $this->language->get('text_width');
        $data['text_height'] = $this->language->get('text_height');
        $data['text_name'] = $this->language->get('text_name');
        $data['text_color'] = $this->language->get('text_color');
        $data['text_link'] = $this->language->get('text_link');
        $data['text_link_placeholder'] = $this->language->get('text_link_placeholder');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['text_choose_store'] = $this->language->get('text_choose_store');
        $data['entry_btn_define'] = $this->language->get('entry_btn_define');
        $data['entry_btn_define_help'] = $this->language->get('entry_btn_define_help');
        $data['entry_btn_add'] = $this->language->get('entry_btn_add');
        $data['entry_btn_goto_checkout'] = $this->language->get('entry_btn_goto_checkout');
        $data['entry_custom_field'] = $this->language->get('entry_custom_field');
        $data['entry_product_image_size'] = $this->language->get('entry_product_image_size');
        $data['entry_popup_size'] = $this->language->get('entry_popup_size');
        $data['entry_popup_background_color'] = $this->language->get('entry_popup_background_color');
        $data['how_to_setup_icon'] = $this->language->get('how_to_setup_icon');

        $data['tab_setting'] = $this->language->get('tab_setting');
        $data['tab_support'] = $this->language->get('tab_support');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title1'),
            'href' => $this->url->link('extension/module/mmos_popup_add_cart', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('extension/module/mmos_popup_add_cart&store_id=' . $data['current_store_id'], 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL');

        $popup_add_cart = $this->model_setting_setting->getSetting('popup_add_cart', $data['current_store_id']);


        if (isset($this->request->post['popup_add_cart'])) {
            $data['popup_add_cart'] = $this->request->post['popup_add_cart'];
        } elseif ($popup_add_cart) {
            $data['popup_add_cart'] = $popup_add_cart['popup_add_cart'];
        } else {
            $data['popup_add_cart'] = array();
        }


        $data['stores'] = array();

        $data['stores'][] = array(
            'store_id' => 0,
            'name' => $this->config->get('config_name') . $this->language->get('text_default')
        );

        $this->load->model('setting/store');
        $stores = $this->model_setting_store->getStores();

        foreach ($stores as $result) {
            $data['stores'][$result['store_id']] = array(
                'store_id' => $result['store_id'],
                'name' => $result['name']
            );
        }
        // current store ID

        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();
        $data['token'] = $this->session->data['token'];
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/mmos_popup_add_cart.tpl', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/mmos_popup_add_cart')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }

    public function uninstall() {
        if ($this->user->hasPermission('modify', 'extension/extension/module')) {
            $this->load->model('setting/setting');

            $this->model_setting_setting->deleteSetting('popup_add_cart');
            $this->vqmod_protect();
            if (!defined('MMOS_ROOT_DIR'))
                define('MMOS_ROOT_DIR', substr(DIR_APPLICATION, 0, strrpos(DIR_APPLICATION, '/', -2)) . '/');

        }
    }

    public function install() {
        if ($this->user->hasPermission('modify', 'extension/extension/module')) {
            $this->load->model('setting/setting');

            $this->load->model('localisation/language');

            $languages = $this->model_localisation_language->getLanguages();

            foreach ($languages as $language) {
                $name_cart[$language['language_id']] = "<i class='fa fa-shopping-cart'></i> Go To Cart";
                $color_cart[$language['language_id']] = 'primary';
                $link_cart[$language['language_id']] = './index.php?route=checkout/cart';

                $name_checkout[$language['language_id']] = "<i class='fa fa-share-square-o'></i> Go To Checkout";
                $color_checkout[$language['language_id']] = 'success';
                $link_checkout[$language['language_id']] = './index.php?route=checkout/checkout';


                $name_checkout1[$language['language_id']] = "<i class='fa fa-refresh'></i> Continue shopping";
                $color_checkout1[$language['language_id']] = 'info';
                $link_checkout1[$language['language_id']] = '';
            }
            $button = array(
               '0' => array(
                    'name' => $name_checkout1,
                    'color' => $color_checkout1,
                    'link' => $link_checkout1
                ),
                '1' => array(
                    'name' => $name_checkout,
                    'color' => $color_checkout,
                    'link' => $link_checkout
                ),
                 '2' => array(
                    'name' => $name_cart,
                    'color' => $color_cart,
                    'link' => $link_cart
                )          
            );

            $data_initial = array(
                'popup_add_cart' => array(
                    'status' => '0',
                    'image_width' => '90',
                    'image_height' => '90',
                    'popup_width' => '600',
                    'popup_background_color' => '#ffffff',
                    'button' => $button,
                    'customer_field' => ''
                )
            );

            $this->model_setting_setting->editSetting('popup_add_cart', $data_initial, 0);


            $this->load->model('setting/store');
            $stores = $this->model_setting_store->getStores();

            foreach ($stores as $result) {


                $this->model_setting_setting->editSetting('popup_add_cart', $data_initial, $result['store_id']);
            }
            $this->vqmod_protect(1);
            if (!defined('MMOS_ROOT_DIR'))

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL'));
        }
    }
    protected function vqmod_protect($action = 0) {
        // action 1 =  install; 0: uninstall
        $vqmod_file = 'MMOSolution_popup_add_cart.xml';
        if ($this->user->hasPermission('modify', 'extension/extension/module')) {
            $MMOS_ROOT_DIR = substr(DIR_APPLICATION, 0, strrpos(DIR_APPLICATION, '/', -2)) . '/vqmod/xml/';
            if ($action == 1) {
                if (is_file($MMOS_ROOT_DIR . $vqmod_file . '_mmosolution')) {
                    @rename($MMOS_ROOT_DIR . $vqmod_file . '_mmosolution', $MMOS_ROOT_DIR . $vqmod_file);
                }
            } else {
                if (is_file($MMOS_ROOT_DIR . $vqmod_file)) {
                    @rename($MMOS_ROOT_DIR . $vqmod_file, $MMOS_ROOT_DIR . $vqmod_file . '_mmosolution');
                }
            }
        }
    }
    

}
