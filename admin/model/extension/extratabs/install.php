<?php 

class ModelExtensionExtratabsInstall extends Model {  

	public function install($data=null) {
		$exists = $this->db->query("SHOW TABLES LIKE '". DB_PREFIX . "extra_tab_template'");	
		if (!$exists->num_rows){		
		$sql="CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "extra_tab_template` (";
		$sql.="  `extra_tab_id` int(11) NOT NULL AUTO_INCREMENT,";
		$sql.="  `name` varchar(96),";		
		$sql.="  `sort_order` int(5) NOT NULL DEFAULT '0',";	
		$sql.="  `position` tinyint(1) NOT NULL DEFAULT '1',";		
		$sql.="  `status` tinyint(1) NOT NULL DEFAULT '1',";
		$sql.="  PRIMARY KEY (`extra_tab_id`)";
		$sql.=") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
				$query = $this->db->query($sql);
		} else {
			//==== New Field show for older versions before 1.2
			$exists2 = $this->db->query("SHOW COLUMNS from `" . DB_PREFIX . "extra_tab_template` LIKE 'position'");
			if (!$exists2->num_rows){
				$sql="ALTER TABLE `" . DB_PREFIX . "extra_tab_template` ";
				$sql.="  add `position` tinyint(1) NOT NULL DEFAULT '1'";
				$query = $this->db->query($sql);
			}	
		}					
		$sql="CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "extra_tab_store` (";
		$sql.="  `extra_tab_id` int(11) NOT NULL,";
		$sql.="  `store_id` int(11) NOT NULL,";
		$sql.="  PRIMARY KEY (`extra_tab_id`,`store_id`)";		
		$sql.=") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
				$query = $this->db->query($sql);
		$sql="CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "extra_tab_customer_group` (";
		$sql.="  `extra_tab_id` int(11) NOT NULL,";
		$sql.="  `customer_group_id` int(11) NOT NULL,";
		$sql.="  PRIMARY KEY (`extra_tab_id`,`customer_group_id`)";		
		$sql.=") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
				$query = $this->db->query($sql);	
		$sql="CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "extra_tab_categories` (";
		$sql.="  `extra_tab_id` int(11) NOT NULL,";
		$sql.="  `category_id` int(11) NOT NULL,";
		$sql.="  PRIMARY KEY (`extra_tab_id`,`category_id`)";		
		$sql.=") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
				$query = $this->db->query($sql);				
		$sql="CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "extra_tab_template_description` (";
		$sql.="  `extra_tab_id` int(11) NOT NULL,";
		$sql.="  `language_id` int(11) NOT NULL,";
		$sql.="  `extra_tab_title` varchar(96),";
		$sql.="  `extra_tab_text` text,";			
		$sql.="  PRIMARY KEY (`extra_tab_id`,`language_id`)";		
		$sql.=") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
				$query = $this->db->query($sql);

		$exists = $this->db->query("SHOW TABLES LIKE '". DB_PREFIX . "stv_product_tab'");	
		if (!$exists->num_rows){			
			$sql="CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "stv_product_tab` (";
			$sql.="  `product_tab_id` int(11) NOT NULL AUTO_INCREMENT,";
			$sql.="  `product_id` int(11) NOT NULL,";
			$sql.="  `extra_tab_id` int(11) NOT NULL,";		
			$sql.="  `name` varchar(96),";		
			$sql.="  `position` tinyint(1) NOT NULL DEFAULT '1',";			
			$sql.="  `sort_order` int(5) NOT NULL DEFAULT '0',";	
			$sql.="  `status` tinyint(1) NOT NULL DEFAULT '1',";
			$sql.="  PRIMARY KEY (`product_tab_id`)";
			$sql.=") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
					$query = $this->db->query($sql);
		} else {
			//==== New Field show for older versions before 1.2
			$exists2 = $this->db->query("SHOW COLUMNS from `" . DB_PREFIX . "stv_product_tab` LIKE 'position'");
			if (!$exists2->num_rows){
				$sql="ALTER TABLE `" . DB_PREFIX . "stv_product_tab` ";
				$sql.="  add `position` tinyint(1) NOT NULL DEFAULT '1'";
				$query = $this->db->query($sql);
			}	
		}						
			$sql="CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "stv_product_tab_description` (";
			$sql.="  `product_tab_id` int(11) NOT NULL,";
			$sql.="  `language_id` int(11) NOT NULL,";
			$sql.="  `product_tab_title` varchar(96),";
			$sql.="  `product_tab_text` text,";			
			$sql.="  PRIMARY KEY (`product_tab_id`,`language_id`)";		
			$sql.=") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
					$query = $this->db->query($sql);
					
		if (isset($data)) {
			$settings = array(
				'extratabs_status'		=> isset($data['extratabs_status'])?$data['extratabs_status']:'1',
				'extratabs_delete'		=> isset($data['extratabs_delete'])?$data['extratabs_delete']:'0',	
				'extratabs_tree_type'	=> isset($data['extratabs_tree_type'])?$data['extratabs_tree_type']:'1',	
				'extratabs_auto_assign'	=> isset($data['extratabs_auto_assign'])?$data['extratabs_auto_assign']:'1',				
				'extratabs_overwrite_general'	=> isset($data['extratabs_overwrite_general'])?$data['extratabs_overwrite_general']:'1',
				'extratabs_overwrite_content'	=> isset($data['extratabs_overwrite_content'])?$data['extratabs_overwrite_content']:'1',
				'extratabs_installed'	=> '1'	
			);
		
		} else {
			$settings = array(
				'extratabs_status'		=> '1',
				'extratabs_delete'		=> '0',	
				'extratabs_tree_type'	=> '1',	
				'extratabs_auto_assign'	=> '0',				
				'extratabs_overwrite_general'	=> '1',
				'extratabs_overwrite_content'	=> '1',
				'extratabs_installed'	=> '1'	
			);
		}
		$this->load->model('setting/setting');
		$this->load->model('user/user_group');
		$this->model_setting_setting->editSetting('extratabs', $settings );		

		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'catalog/extratab');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'catalog/extratab');		
	}

	public function uninstall() {
		if ($this->config->get('extratabs_delete')==1) {	
			$sql="drop TABLE `" . DB_PREFIX . "extra_tab_template`,
			`" . DB_PREFIX . "extra_tab_store`,
			`" . DB_PREFIX . "extra_tab_customer_group`,
			`" . DB_PREFIX . "extra_tab_categories`,			
			`" . DB_PREFIX . "extra_tab_template_description`,
			`" . DB_PREFIX . "stv_product_tab`,
			`" . DB_PREFIX . "stv_product_tab_description`";
			$query = $this->db->query($sql);
			
			$this->load->model('setting/setting');
			$this->model_setting_setting->deleteSetting('extratabs');
		}
	}	
}

?>