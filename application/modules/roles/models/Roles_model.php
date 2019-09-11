<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles_model extends MY_Model {


	public function roles( $role_id = '' )
	{
		$this->db->select('*');
		$this->db->from(ROLE);
		if(!empty($role_id)){
			$this->db->where(ROLE_ID, $role_id);
			$this->db->limit(1);
		}
		$this->db->order_by('role.sequence');
		$query = $this->db->get();
		return $query->result();
	}	

	public function get_role_data($table, $role_array=''){
		$this->db->select('role_id, role_name');
		$this->db->from($table);
		if(!empty($role_array)){
			$this->db->where_in('role_id', $role_array);	
		}
		$query = $this->db->get();
		return $query->result();
	}

}