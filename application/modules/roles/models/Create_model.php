<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_model extends MY_Model {

	/*public function check_duplicate($role_name)
	{
		$this->db->where('role_name', $role_name);
		$res = $this->db->get('role');
		if (count($res->result()) == 0) {
			return true;
		}
		else {
			return false;
		}
	}*/

	public function create( $role_name, $role_description="", $sequence="" )
	{
		if( empty($role_name) ) {
			return false;
		}

		$create = array(
			ROLE_NAME			=>	$role_name,
			ROLE_DESCRIPTION	=>	$role_description,
			CREATED_ON		=>	date('Y-m-d H:i:s', now())
		);
		
		if ($this->check_duplicate( ROLE, ROLE_NAME, $role_name )) {
			$this->db->insert(ROLE, $create);
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		}
		
		return FALSE;

	}	

}