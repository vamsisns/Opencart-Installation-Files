<?php
class ModelExtensionMkenqprolist extends Model {
 	public function deletemkenqpro($mkenqpro_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "mkenqpro WHERE mkenqpro_id = '" . (int)$mkenqpro_id . "'");
 	}

	public function getmkenqpro($mkenqpro_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "mkenqpro WHERE mkenqpro_id = '" . (int)$mkenqpro_id . "'");

		return $query->row;
	}
  
	public function getmkenqpros($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "mkenqpro WHERE 1 ";
  
		if (!empty($data['filter_mkenqpro_id'])) {
			$sql .= " and mkenqpro_id = '" . $this->db->escape($data['filter_mkenqpro_id']) . "'";
		}
		if (!empty($data['filter_name'])) {
			$sql .= " and name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		if ((!empty($data['filter_store_id'])) && $data['filter_store_id'] != '*') {
			$sql .= " and store_id = '" . $this->db->escape($data['filter_store_id']) . "'";
		}
		if (!empty($data['filter_email'])) {
			$sql .= " and email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		if (!empty($data['filter_phnum'])) {
			$sql .= " and phnum LIKE '" . $this->db->escape($data['filter_phnum']) . "%'";
		}
   
		$sort_data = array(
 			'mkenqpro_id',
			'name',
			'email',
			'phnum',
			'replied_enquiry'.
 			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY email";
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
 
	public function getTotalmkenqpros($data = array()) {
 		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "mkenqpro WHERE 1 ";
  
		if (!empty($data['filter_mkenqpro_id'])) {
			$sql .= " and mkenqpro_id = '" . $this->db->escape($data['filter_mkenqpro_id']) . "'";
		}
		if (!empty($data['filter_name'])) {
			$sql .= " and name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		if ((!empty($data['filter_store_id'])) && $data['filter_store_id'] != '*') {
			$sql .= " and store_id = '" . $this->db->escape($data['filter_store_id']) . "'";
		}
		if (!empty($data['filter_email'])) {
			$sql .= " and email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		if (!empty($data['filter_phnum'])) {
			$sql .= " and phnum LIKE '" . $this->db->escape($data['filter_phnum']) . "%'";
		}
  
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
 
} 