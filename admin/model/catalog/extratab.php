<?php
class ModelCatalogExtratab extends Model {
	
	public function getExtratabProducts($extra_tab_id) {
		$extra_tab_products_query = $this->db->query("select pc.category_id, pc.product_id from " . DB_PREFIX . "product_to_category pc LEFT JOIN " . DB_PREFIX . "stv_product_tab spt ON (pc.product_id = spt.product_id) where spt.extra_tab_id = '" . (int)$extra_tab_id . "'");	
		$result = array();
		foreach ($extra_tab_products_query->rows as $ppp) {
			$result[$ppp['category_id']][$ppp['product_id']] = $ppp['product_id'];
		}
		//return $extra_tab_products_query->rows;
		return $result;
	}	
	public function getCategoriesToChange($extra_tab_id) { //added in 1.3.2
		$extra_tab_products_query = $this->db->query("select pc.category_id, pc.product_id from " . DB_PREFIX . "product_to_category pc LEFT JOIN " . DB_PREFIX . "stv_product_tab spt ON (pc.product_id = spt.product_id) where spt.extra_tab_id = '" . (int)$extra_tab_id . "' group by pc.category_id");	
		return $extra_tab_products_query->rows;
	}	
	public function getCategoriesOnlyToChange($extra_tab_id) { //added in 1.3.3
		$extra_tab_products_query = $this->db->query("select category_id from " . DB_PREFIX . "extra_tab_categories where extra_tab_id = '" . (int)$extra_tab_id . "'");	

		$result = array();
		foreach ($extra_tab_products_query->rows as $ppp) {
			$result[$ppp['category_id']] = $ppp['category_id'];
		}

		return $result;		
	}	
	public function getExtratabCategories($extra_tab_id) {

			$sql1 = "select distinct c.category_id, c.parent_id, cd.name from " . DB_PREFIX . "category c left join " . DB_PREFIX . "category_description cd on (c.category_id=cd.category_id) where cd.language_id='".$this->config->get('config_language_id')."' order by c.parent_id ASC,c.category_id ASC"; 		
			$query1 = $this->db->query($sql1);	
			if ($extra_tab_id!=0) {
				$assigned = $this->getCategoriesOnlyToChange($extra_tab_id);			
				$assigned_products = $this->getExtratabProducts($extra_tab_id);
			}
			else {
				$assigned = array();		
				$assigned_products = array();
			}	
			
			$allcategories=array();
			foreach ($query1->rows as $category) {
				$allcategories[$category['category_id']] = array(
					'parent'	=>  $category['parent_id'],	
					'enabled'	=> isset($assigned[$category['category_id']])?true:false,					
					'products'	=>	array(),
					'name'	=>	$category['name'],								
					'categories'	=>	array()
				);				
				if ($category['parent_id']!=0) {
					$allcategories[$category['parent_id']]['categories'][]=$category['category_id'];
				}			
			}		

			$sql2 = "select pc.category_id, p.product_id, pd.name from " . DB_PREFIX . "product_to_category pc left join " . DB_PREFIX . "product p on (p.product_id=pc.product_id) left join " . DB_PREFIX . "product_description pd on (p.product_id=pd.product_id) where pd.language_id='".$this->config->get('config_language_id')."' order by pd.name";
			$query2 = $this->db->query($sql2);		
			foreach ($query2->rows as $product) {
				$allcategories[$product['category_id']]['products'][]= array(
					'product_id'	=> $product['product_id'],
					'enabled'		=> isset($assigned_products[$product['category_id']][$product['product_id']])?true:false,
					'name'			=> $product['name']
					);
			}			
			return $allcategories;	
	}	
	
	public function getExtratabCategoriesOnly($extra_tab_id) {

			$sql1 = "select distinct c.category_id, c.parent_id, (select count(*) from " . DB_PREFIX . "product_to_category pc where pc.category_id=c.category_id) as has_products, cd.name from " . DB_PREFIX . "category c left join " . DB_PREFIX . "category_description cd on (c.category_id=cd.category_id) where cd.language_id='".$this->config->get('config_language_id')."' order by c.parent_id ASC, c.category_id ASC"; 		
			$query1 = $this->db->query($sql1);	
			if ($extra_tab_id!=0)
				$assigned = $this->getCategoriesOnlyToChange($extra_tab_id);			
			else $assigned = array();
			$allcategories=array();
			foreach ($query1->rows as $category) {
				$allcategories[$category['category_id']] = array(
					'parent'	=>  $category['parent_id'],	
					'enabled'	=> isset($assigned[$category['category_id']])?true:false,
					'has_products'	=> $category['has_products'],	
					'name'	=>	$category['name'],								
					'categories'	=>	array()
				);				
				if ($category['parent_id']!=0) {
					$allcategories[$category['parent_id']]['categories'][]=$category['category_id'];
				}			
			}			

			return $allcategories;	
	}			
	public function getExtratabProductsIds($extra_tab_id) {
		$extra_tab_products_query = $this->db->query("select distinct product_id from " . DB_PREFIX . "stv_product_tab where extra_tab_id = '" . (int)$extra_tab_id . "'");	
		$result = array();
		foreach ($extra_tab_products_query->rows as $row)
			$result[$row['product_id']]=$row['product_id'];
		return $result;
	}	
	public function addExtratabToProduct($extra_tab_id,$option_general,$option_content,$products) { //changed in 1.3.2
		$old_products = $this->getExtratabProductsIds($extra_tab_id);
		$thistab = $this->getExtratab($extra_tab_id);
		$added_products = array();

		if ($option_content == 1) {	// delete all contents on overwrite option set
				$this->db->query("delete from " . DB_PREFIX . "stv_product_tab_description where product_tab_id in (select product_tab_id from " . DB_PREFIX . "stv_product_tab where extra_tab_id = '" . (int)$extra_tab_id . "')");
		}
		if ($option_general == 1) {	// delete all contents on overwrite option set
				$this->db->query("update " . DB_PREFIX . "stv_product_tab SET  sort_order = '" . $thistab['sort_order'] . "', position = '" . $thistab['position'] . "', name = '" . $this->db->escape($thistab['name']) . "' where extra_tab_id = '" . (int)$extra_tab_id . "'");
		}						
		//add new tabs 
		if ($products) {
			foreach ($products as $product){
				if (!isset($added_products[$product])) {
					if (isset($old_products[$product])) {	
						/*$old_tabs = $this->db->query("select product_tab_id,status from " . DB_PREFIX . "stv_product_tab where product_id = '" . (int)$product ."' and extra_tab_id = '" . (int)$extra_tab_id . "'");
						if (($option_general == 1) && ($option_content == 1)) {	// overwrite all					
							foreach ($old_tabs->rows as $old_tab) {	
								//$this->db->query("delete from " . DB_PREFIX . "stv_product_tab where product_tab_id = '" . (int)$old_tab['product_tab_id'] . "'");
								$this->db->query("delete from " . DB_PREFIX . "stv_product_tab_description where product_tab_id = '" . (int)$old_tab['product_tab_id'] . "'");						
								$this->db->query("update " . DB_PREFIX . "stv_product_tab SET  sort_order = '" . $thistab['sort_order'] . "', position = '" . $thistab['position'] . "', name = '" . $thistab['name'] . "' where product_tab_id = '" . (int)$old_tab['product_tab_id'] . "'");
								//$this->db->query("INSERT INTO " . DB_PREFIX . "stv_product_tab SET product_id = '" . (int)$product ."', extra_tab_id = '" . (int)$extra_tab_id . "', sort_order = '" . $thistab['sort_order'] . "', position = '" . $thistab['position'] . "',status = '" . (int)$old_tab['status'] . "', name = '" . $thistab['name'] . "'");
								// description not added if it is the same with the template

							}
						} elseif (($option_general == 1) && ($option_content == 0)) {	// overwrite general
							foreach ($old_tabs->rows as $old_tab) {	
								$this->db->query("update " . DB_PREFIX . "stv_product_tab SET  sort_order = '" . $thistab['sort_order'] . "', position = '" . $thistab['position'] . "', name = '" . $thistab['name'] . "' where product_tab_id = '" . (int)$old_tab['product_tab_id'] . "'");
							}
						} elseif (($option_general == 0) && ($option_content == 1)) {	// overwrite content					
							foreach ($old_tabs->rows as $old_tab) {	
								$this->db->query("delete from " . DB_PREFIX . "stv_product_tab_description where product_tab_id = '" . (int)$old_tab['product_tab_id'] . "'");						
								// description not added if it is the same with the template

							}
						}*/	
						unset($old_products[$product]);						
					} else {
						$this->db->query("INSERT INTO " . DB_PREFIX . "stv_product_tab SET product_id = '" . (int)$product ."', extra_tab_id = '" . (int)$extra_tab_id . "', sort_order = '" . $thistab['sort_order'] . "', position = '" . $thistab['position'] . "',status = '1', name = '" . $this->db->escape($thistab['name']) . "'");
						// description not added if it is the same with the template
						/*$product_tab_id	=$this->db->getLastId(); 
						foreach ($thistab['descriptions'] as $tab_desc) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "stv_product_tab_description SET language_id = '" . $tab_desc['language_id'] . "', product_tab_id = '" . $product_tab_id . "', product_tab_title = '" . $this->db->escape($tab_desc['extra_tab_title']) . "', product_tab_text = '" . $this->db->escape($tab_desc['extra_tab_text']) . "'");
						}	*/				
					}
					$added_products[$product]=$product;
				}
			}
		}
		//remove tabs not included any more
		$old_products[0]=0;
		//$this->db->query("delete from " . DB_PREFIX . "stv_product_tab_description where product_tab_id in (select product_tab_id from " . DB_PREFIX . "stv_product_tab where extra_tab_id = '" . (int)$extra_tab_id . "' and product_id in (".implode(",",$old_products).")) ");
		$this->db->query("delete from " . DB_PREFIX . "stv_product_tab where extra_tab_id = '" . (int)$extra_tab_id . "' and product_id in (".implode(",",$old_products).")");			

	}

	public function addExtratab($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "extra_tab_template SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . $this->db->escape($data['sort_order']) . "', position = '" . (int)$data['position'] . "', status = '" . (int)$data['status'] . "'");
		$extra_tab_id = $this->db->getLastId();	
		foreach ($data['descriptions'] as $description){
			if (strip_tags(html_entity_decode($description['extra_tab_text']))=='') $description['extra_tab_text']='';
			$this->db->query("INSERT INTO " . DB_PREFIX . "extra_tab_template_description SET extra_tab_id = '" . (int)$extra_tab_id . "', language_id = '" . $this->db->escape($description['language_id']) . "', extra_tab_title = '" . $this->db->escape($description['extra_tab_title']) . "', extra_tab_text = '" . $this->db->escape($description['extra_tab_text']) ."'");
		}
		if (isset($data['tab_stores']))							
			foreach ($data['tab_stores'] as $store){
				$this->db->query("INSERT INTO " . DB_PREFIX . "extra_tab_store SET extra_tab_id = '" . (int)$extra_tab_id ."', store_id = '" . $store . "'");					
			}
		if (isset($data['tab_customer_groups']))							
			foreach ($data['tab_customer_groups'] as $group){
				$this->db->query("INSERT INTO " . DB_PREFIX . "extra_tab_customer_group SET extra_tab_id = '" . (int)$extra_tab_id ."', customer_group_id = '" . $group . "'");					
			}				

		if (isset($data['products'])) {
		$this->addExtratabToProduct($extra_tab_id,$data['option_general'],$data['option_content'],$data['products']);
		} else 	if (isset($data['categories'])) {
			$products_query = $this->db->query("select distinct(pc.product_id) from " . DB_PREFIX . "product_to_category pc LEFT JOIN " . DB_PREFIX . "category c ON (pc.category_id = c.category_id) where c.category_id in (" . implode(",",$data['categories']) . ")");	

			$products = array();
			foreach ($products_query->rows as $ppp) {
				$products[] = $ppp['product_id'];
			}			
			$this->addExtratabToProduct($extra_tab_id,$data['option_general'],$data['option_content'],$products);		
		} else 	$this->addExtratabToProduct($extra_tab_id,$data['option_general'],$data['option_content'],null);
		
		if (!isset($data['categories'])) $data['categories']=array();
			
		if ($this->config->get('extratabs_tree_type')==1) { 
			//check if a category has all his products selected so it can be saved
			$categories_query = $this->db->query("select category_id from " . DB_PREFIX . "category");	
			foreach ($categories_query->rows as $category) {
				if (!isset($data['categories']) || (!in_array($category['category_id'],$data['categories']))) {
					$products_tab_query = $this->db->query("select count(pc.product_id) as total from " . DB_PREFIX . "product_to_category pc LEFT JOIN " . DB_PREFIX . "stv_product_tab spt ON (pc.product_id = spt.product_id) where pc.category_id = '".$category['category_id']."' and spt.extra_tab_id = '" . (int)$extra_tab_id . "'");	
					$products_query = $this->db->query("select count(product_id) as total from " . DB_PREFIX . "product_to_category where category_id = '".$category['category_id']."'");						
					if (($products_tab_query->row['total']==$products_query->row['total']) && ($products_tab_query->row['total']!=0)) {
						$data['categories'][] = $category['category_id'];
					}
				}
			}
		}			
		if (isset($data['categories']))							
			foreach ($data['categories'] as $category_id){
				$this->db->query("INSERT INTO " . DB_PREFIX . "extra_tab_categories SET extra_tab_id = '" . (int)$extra_tab_id ."', category_id = '" . $category_id . "'");					
			}			
	}
	
	public function editExtratab($extra_tab_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "extra_tab_template SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . $this->db->escape($data['sort_order']) . "', position = '" . (int)$data['position'] . "', status = '" . (int)$data['status'] . "' WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "extra_tab_template_description WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");
		foreach ($data['descriptions'] as $description){
			if (strip_tags(html_entity_decode($description['extra_tab_text']))=='') $description['extra_tab_text']='';
			$this->db->query("INSERT INTO " . DB_PREFIX . "extra_tab_template_description SET extra_tab_title = '" . $this->db->escape($description['extra_tab_title']) . "', extra_tab_text = '" . $this->db->escape($description['extra_tab_text']) . "', extra_tab_id = '" . (int)$extra_tab_id . "', language_id = '" . $this->db->escape($description['language_id']) ."'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "extra_tab_store WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "extra_tab_customer_group WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "extra_tab_categories WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");
		
		if (isset($data['tab_stores']))							
			foreach ($data['tab_stores'] as $store){
				$this->db->query("INSERT INTO " . DB_PREFIX . "extra_tab_store SET extra_tab_id = '" .(int)$extra_tab_id ."', store_id = '" . $store . "'");					
			}
		if (isset($data['tab_customer_groups']))							
			foreach ($data['tab_customer_groups'] as $group){
				$this->db->query("INSERT INTO " . DB_PREFIX . "extra_tab_customer_group SET extra_tab_id = '" . (int)$extra_tab_id ."', customer_group_id = '" . $group . "'");					
			}	
			
		if (isset($data['products'])) {
			$this->addExtratabToProduct($extra_tab_id,$data['option_general'],$data['option_content'],$data['products']);
		} else 	if (isset($data['categories'])) {
			$products_query = $this->db->query("select distinct(pc.product_id) from " . DB_PREFIX . "product_to_category pc LEFT JOIN " . DB_PREFIX . "category c ON (pc.category_id = c.category_id) where c.category_id in (" . implode(",",$data['categories']) . ")");	

			$products = array();
			foreach ($products_query->rows as $ppp) {
				$products[] = $ppp['product_id'];
			}			
			$this->addExtratabToProduct($extra_tab_id,$data['option_general'],$data['option_content'],$products);	
		} else 	$this->addExtratabToProduct($extra_tab_id,$data['option_general'],$data['option_content'],null);
		
		if ($this->config->get('extratabs_tree_type')==1) { 
			//check if a category has all his products selected so it can be saved
			$categories_query = $this->db->query("select category_id from " . DB_PREFIX . "category");	
			foreach ($categories_query->rows as $category) {
				if (!isset($data['categories']) || (!in_array($category['category_id'],$data['categories']))) {
					$products_tab_query = $this->db->query("select count(pc.product_id) as total from " . DB_PREFIX . "product_to_category pc LEFT JOIN " . DB_PREFIX . "stv_product_tab spt ON (pc.product_id = spt.product_id) where pc.category_id = '".$category['category_id']."' and spt.extra_tab_id = '" . (int)$extra_tab_id . "'");	
					$products_query = $this->db->query("select count(product_id) as total from " . DB_PREFIX . "product_to_category where category_id = '".$category['category_id']."'");						
					if (($products_tab_query->row['total']==$products_query->row['total']) && ($products_tab_query->row['total']!=0)) {
						$data['categories'][] = $category['category_id'];
					}
				}
			}
		}			
		if (isset($data['categories']))							
			foreach ($data['categories'] as $category_id){
				$this->db->query("INSERT INTO " . DB_PREFIX . "extra_tab_categories SET extra_tab_id = '" . (int)$extra_tab_id ."', category_id = '" . $category_id . "'");					
			}		
	}
	
	public function deleteExtratab($extra_tab_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "extra_tab_template_description WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "extra_tab_template WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "extra_tab_store WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "extra_tab_customer_group WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "extra_tab_categories WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");
		//$this->db->query("update " . DB_PREFIX . "stv_product_tab set extra_tab_id='0' WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");
		$sql = "delete from " . DB_PREFIX . "stv_product_tab_description where product_tab_id in (select pt.product_tab_id from " . DB_PREFIX . "stv_product_tab pt where pt.extra_tab_id='".$extra_tab_id."')";
		$query = $this->db->query($sql);	
		$sql = "delete from " . DB_PREFIX . "stv_product_tab where extra_tab_id='".$extra_tab_id."'";
		$query = $this->db->query($sql);	
	}
	public function getExtraTabsInformation() {
		$extra_tabs_data = array();
		$extra_tabs_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extra_tab_template order by sort_order");
		foreach ($extra_tabs_query->rows as $extra_tab) {
			$extra_tab_stores = array();
			$extra_tab_customer_groups = array();	
			
			$extra_tab_stores_query = $this->db->query("SELECT store_id FROM " . DB_PREFIX . "extra_tab_store WHERE extra_tab_id = '" . (int)$extra_tab['extra_tab_id']. "'");
				foreach ($extra_tab_stores_query->rows as $extra_tab_store) {
					$extra_tab_stores[] = $extra_tab_store['store_id'];
				}			
			$extra_tab_customer_groups_query = $this->db->query("SELECT customer_group_id FROM " . DB_PREFIX . "extra_tab_customer_group WHERE extra_tab_id = '" . (int)$extra_tab['extra_tab_id'] . "'");
				foreach ($extra_tab_customer_groups_query->rows as $extra_tab_customer_group) {
					$extra_tab_customer_groups[] = $extra_tab_customer_group['customer_group_id'];
				}				
			
			$extra_tabs_data[$extra_tab['extra_tab_id']] = array(
				'extra_tab_id'  				=> $extra_tab['extra_tab_id'],		
				'name'          				=> $extra_tab['name'],
				'position'          			=> $extra_tab['position'],					
				'sort_order'          			=> $extra_tab['sort_order'],			
				'status' 						=> $extra_tab['status'],
				'tab_stores'					=> $extra_tab_stores,
				'tab_customer_groups'			=> $extra_tab_customer_groups				
			);		
			
			}
		return $extra_tabs_data;
	}	
	public function getExtratab($extra_tab_id) {
	
		$extra_tab_description = array();
		$extra_tab_stores = array();
		$extra_tab_customer_groups = array();		
		
		$all_languages = $this->db->query("SELECT language_id FROM " . DB_PREFIX . "language ");	
		
		if ((int)$extra_tab_id!=0){
			$extra_tab_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "extra_tab_template  WHERE extra_tab_id = '" . (int)$extra_tab_id . "'");
			foreach ($all_languages->rows as $language) {
				$product_language_extra_tab_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extra_tab_template_description WHERE extra_tab_id = '" . (int) $extra_tab_id . "' and language_id='". $language['language_id']. "'");
				foreach ($product_language_extra_tab_query->rows as $language_extra_tab) {
					$extra_tab_description[$language_extra_tab['language_id']] = array(
						'language_id'           		=> $language_extra_tab['language_id'],
						'extra_tab_title'          		=> $language_extra_tab['extra_tab_title'],			
						'extra_tab_text' 				=> $language_extra_tab['extra_tab_text']
					);
				}
			}
			$extra_tab_stores_query = $this->db->query("SELECT store_id FROM " . DB_PREFIX . "extra_tab_store WHERE extra_tab_id = '" . (int) $extra_tab_id . "'");
				foreach ($extra_tab_stores_query->rows as $extra_tab_store) {
					$extra_tab_stores[] = $extra_tab_store['store_id'];
				}			
			$extra_tab_customer_groups_query = $this->db->query("SELECT customer_group_id FROM " . DB_PREFIX . "extra_tab_customer_group WHERE extra_tab_id = '" . (int) $extra_tab_id . "'");
				foreach ($extra_tab_customer_groups_query->rows as $extra_tab_customer_group) {
					$extra_tab_customer_groups[] = $extra_tab_customer_group['customer_group_id'];
				}				
			
			$extra_tab_data = array(
				'extra_tab_id'  				=> $extra_tab_query->row['extra_tab_id'],		
				'name'          				=> $extra_tab_query->row['name'],
				'position'          			=> $extra_tab_query->row['position'],					
				'sort_order'          			=> $extra_tab_query->row['sort_order'],			
				'status' 						=> $extra_tab_query->row['status'],
				'descriptions'					=> $extra_tab_description,
				'tab_stores'					=> $extra_tab_stores,
				'tab_customer_groups'			=> $extra_tab_customer_groups				
			);
	} else {
			foreach ($all_languages->rows as $language) {
				$extra_tab_description[$language['language_id']] = array(
						'language_id'           		=> $language['language_id'],
						'extra_tab_title'          		=> "",			
						'extra_tab_text' 				=> ""
					);
				}
			
			$extra_tab_data = array(
				'extra_tab_id'  				=> 0,			
				'name'          				=> "",			
				'position'          			=> 10,					
				'descriptions'					=> $extra_tab_description,
				'tab_stores'					=> $extra_tab_stores,
				'tab_customer_groups'			=> $extra_tab_customer_groups
			);		
	}
	return $extra_tab_data;	

	
	}
	
	public function getExtratabs($data = array()) {
	
			$sql = "SELECT * FROM " . DB_PREFIX . "extra_tab_template";	
	
		$sort_data = array(
			'name',			
			'status',
			'sort_order',
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY sort_order";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}																																							  

		$query = $this->db->query($sql);																																				
		
		return $query->rows;	
	}
	
	public function getTotalExtratabs($data = array()) {

		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "extra_tab_template";
	
		$query = $this->db->query($sql);		
		return $query->row['total'];
	}
}
?>