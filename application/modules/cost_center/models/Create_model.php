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

	public function create( $cost_center_name, $cost_center_code)
	{
		
		if( empty($cost_center_name) || empty($cost_center_code) ) {
			return false;
		}

		$create = array(
			CC_NAME			=>	$cost_center_name,
			CC_CODE	        =>	$cost_center_code,
			CREATED_ON			=>	date('Y-m-d H:i:s', now())
		);


		//if ($this->check_duplicate( COST_CENTER, CC_NAME, $cost_center_name )) {
		if ($this->check_Duplicate_WithOr( COST_CENTER, array(CC_NAME=>$cost_center_name, CC_CODE=>$cost_center_code) )) { 
			$this->db->insert(COST_CENTER, $create);
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		}
		

		return FALSE;

	}	

}