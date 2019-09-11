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

	public function create( $region_name, $region_code)
	{
		
		if( empty($region_name) || empty($region_code) ) {
			return false;
		}

		$create = array(
			REG_NAME			=>	$region_name,
			REG_CODE	=>	$region_code,
			CREATED_ON			=>	date('Y-m-d H:i:s', now())
		);

		if ($this->check_Duplicate_WithOr( REGION, array(REG_NAME=>$region_name, REG_CODE=>$region_code) )) { 
				$this->db->insert(REGION, $create);
				if( $this->db->affected_rows() ) {
					return $this->db->insert_id();
				}
		}
		

		return FALSE;

	}	

}