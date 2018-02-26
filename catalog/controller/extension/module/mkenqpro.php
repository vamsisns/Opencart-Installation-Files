<?php
class ControllerExtensionModulemkenqpro extends Controller { 	
	private $error = array();
	private $modpath = 'module/mkenqpro'; 
	private $modpathcart = 'module/mkenqprocart';
	private $modtpl = 'default/template/module/mkenqpro.tpl'; 
	private $modname = 'mkenqpro';
	private $modtext = 'Make An Enquiry Instead of Add To Cart';
	private $modid = '21745';
 	private $modemail = 'opencarttools@gmail.com'; 
	private $modssl = 'SSL'; 
	private $modgrpid = 0;
	private $modlangid = 0;
	private $modstoreid = 0;
	
	public function __construct($registry) {
		parent::__construct($registry);
		
		$this->modgrpid = $this->config->get('config_customer_group_id');
		$this->modlangid = (int)$this->config->get('config_language_id');
		$this->modstoreid = (int)$this->config->get('config_store_id');
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3') { 
			$this->modtpl = 'extension/module/mkenqpro';
			$this->modpath = 'extension/module/mkenqpro';
			$this->modpathcart = 'extension/module/mkenqprocart';
		} else if(substr(VERSION,0,3)=='2.2') {
			$this->modtpl = 'module/mkenqpro';
		} 
		
		if(substr(VERSION,0,3)>='3.0') { 
			$this->modname = 'module_mkenqpro';
		} 
		
		if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') { 
			$this->modssl = true;
		} 
 	}
	
	public function index() {
		$data = $this->load->language($this->modpath);
		
		$data['modpathcart'] = $this->modpathcart;
		
 		$data['mkenqpro_status'] = $this->setvalue($this->modname.'_status');
 		if($data['mkenqpro_status']) { 
 	   		return $this->load->view($this->modtpl, $data);
		}
	}  
	
	protected function setvalue($postfield) {
		return $this->config->get($postfield);
	} 
}