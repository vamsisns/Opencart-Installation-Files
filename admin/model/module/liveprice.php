<?php
//  Live Price / Живая цена (Динамическое обновление цены)
//  Support: support@liveopencart.com / Поддержка: help@liveopencart.ru

class ModelModuleLivePrice extends Model {

	private $extension_code = "lp2";
	
	public function versionPRO() {
		return ($this->getExtensionCode() == 'lppro');
	}
	
	public function getExtensionCode() {
		return $this->extension_code;
	}

  public function installed() {
    
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'module' AND `code` = 'liveprice'");
    
    return $query->num_rows;
  }

  public function check_tables() {
    
		if ( !$this->versionPRO() ) {
			return;
		}
		
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_discount` WHERE field='price_prefix' ");
		if (!$query->num_rows) {
			$this->db->query("ALTER TABLE `".DB_PREFIX."product_discount` ADD COLUMN `price_prefix` VARCHAR(1) NOT NULL " );
		}
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_special` WHERE field='price_prefix' ");
		if (!$query->num_rows) {
			$this->db->query("ALTER TABLE `".DB_PREFIX."product_special` ADD COLUMN `price_prefix` VARCHAR(1) NOT NULL " );
		}
		
		$this->db->query(
				"CREATE TABLE IF NOT EXISTS
					`" . DB_PREFIX . "liveprice_global_discount` (
						`category_id` int(11) NOT NULL,
						`manufacturer_id` int(11) NOT NULL,
						`customer_group_id` int(11) NOT NULL,
						`quantity` int(4) NOT NULL,
						`priority` int(5) NOT NULL,
						`price_prefix` VARCHAR(1) NOT NULL,
						`price` decimal(15,4) NOT NULL DEFAULT '0.0000',
						`date_start` date NOT NULL DEFAULT '0000-00-00',
						`date_end` date NOT NULL DEFAULT '0000-00-00',
						`sort_order` int(11) NOT NULL
					) ENGINE=MyISAM DEFAULT CHARSET=utf8"
		);
		
		$this->db->query(
				"CREATE TABLE IF NOT EXISTS
					`" . DB_PREFIX . "liveprice_global_special` (
						`category_id` int(11) NOT NULL,
						`manufacturer_id` int(11) NOT NULL,
						`customer_group_id` int(11) NOT NULL,
						`priority` int(5) NOT NULL,
						`price_prefix` VARCHAR(1) NOT NULL,
						`price` decimal(15,4) NOT NULL DEFAULT '0.0000',
						`date_start` date NOT NULL DEFAULT '0000-00-00',
						`date_end` date NOT NULL DEFAULT '0000-00-00',
						`sort_order` int(11) NOT NULL
					) ENGINE=MyISAM DEFAULT CHARSET=utf8"
		);
		
  }
	
	// save data and unset it in POST array
	public function saveDBSettings($post) {
		
		if ( !$this->versionPRO() ) {
			return $post;
		}
		
		$this->check_tables();
		
		$this->db->query("TRUNCATE TABLE ".DB_PREFIX."liveprice_global_discount ");
		$this->db->query("TRUNCATE TABLE ".DB_PREFIX."liveprice_global_special ");
		
		if ( isset($post['liveprice_settings']['discounts']) ) {
			$discounts = $post['liveprice_settings']['discounts'];
			$sort_order = 0;
			foreach ( $discounts as $discount ) {
				$sort_order++;
				$this->db->query("INSERT INTO ".DB_PREFIX."liveprice_global_discount
													SET category_id = ". ( (int)$discount['category_id']==0 ? -1 : (int)$discount['category_id'] ) ."
														, manufacturer_id = ". ( (int)$discount['manufacturer_id']==0 ? -1 : (int)$discount['manufacturer_id'] ) ."
														, customer_group_id = ". $discount['customer_group_id']."
														, quantity = ".(int)$discount['quantity']."
														, priority = ".(int)$discount['priority']."
														, price_prefix = '".$this->db->escape($discount['price_prefix'])."'
														, price = ".(float)$discount['price']."
														, date_start = '".$this->db->escape($discount['date_start'])."'
														, date_end = '".$this->db->escape($discount['date_end'])."'
														, sort_order = ".(int)$sort_order."
													");
			}
			unset($post['liveprice_settings']['discounts']);
		}
		
		if ( isset($post['liveprice_settings']['specials']) ) {
			$specials = $post['liveprice_settings']['specials'];
			$sort_order = 0;
			foreach ( $specials as $special ) {
				$sort_order++;
				$this->db->query("INSERT INTO ".DB_PREFIX."liveprice_global_special
													SET category_id = ". ( (int)$special['category_id']==0 ? -1 : (int)$special['category_id'] ) ."
														, manufacturer_id = ". ( (int)$special['manufacturer_id']==0 ? -1 : (int)$special['manufacturer_id'] ) ."
														, customer_group_id = ". $special['customer_group_id']."
														, priority = ".(int)$special['priority']."
														, price_prefix = '".$this->db->escape($special['price_prefix'])."'
														, price = ".(float)$special['price']."
														, date_start = '".$this->db->escape($special['date_start'])."'
														, date_end = '".$this->db->escape($special['date_end'])."'
														, sort_order = ".(int)$sort_order."
													");
			}
			unset($post['liveprice_settings']['specials']);
		}
		
		return $post;
		
	}
	
	public function readDBSettings($settings) {
		
		if ( !$this->versionPRO() ) {
			return $settings;
		}
		
		$query = $this->db->query("	SELECT LGP.*, CD.name category, M.name manufacturer
																FROM ".DB_PREFIX."liveprice_global_discount LGP
																		LEFT JOIN ".DB_PREFIX."category_description CD
																			ON (LGP.category_id = CD.category_id AND CD.language_id = ".(int)$this->config->get('config_language_id').")
																		LEFT JOIN ".DB_PREFIX."manufacturer M
																			ON (LGP.manufacturer_id = M.manufacturer_id)
																ORDER BY sort_order ASC
																");
		foreach ( $query->rows as &$row ) {
			if ( !$row['category']) {
				$row['category'] = '';
			}
			if ( !$row['manufacturer']) {
				$row['manufacturer'] = '';
			}
		}
		unset($row);
		
		$settings['discounts'] = $query->rows;
		
		
		$query = $this->db->query("	SELECT LGP.*, CD.name category, M.name manufacturer
																FROM ".DB_PREFIX."liveprice_global_special LGP
																		LEFT JOIN ".DB_PREFIX."category_description CD
																			ON (LGP.category_id = CD.category_id AND CD.language_id = ".(int)$this->config->get('config_language_id').")
																		LEFT JOIN ".DB_PREFIX."manufacturer M
																			ON (LGP.manufacturer_id = M.manufacturer_id)
																ORDER BY sort_order ASC
																");
		foreach ( $query->rows as &$row ) {
			if ( !$row['category']) {
				$row['category'] = '';
			}
			if ( !$row['manufacturer']) {
				$row['manufacturer'] = '';
			}
		}
		unset($row);
		
		$settings['specials'] = $query->rows;
		
		
		return $settings;
		
	}
  
  public function current_version() {
    
    return '2.3.2';
    
  }
	
	
	public function uninstall() {
		
		if ( !$this->versionPRO() ) {
			return;
		}
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "liveprice_global_discount`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "liveprice_global_special`;");
		
	}

}

