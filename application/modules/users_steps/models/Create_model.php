<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_model extends MY_Model {

	public function create( $user_array )
	{
		
		$this->db->insert(USER, $user_array);
		if( $this->db->affected_rows() ) {
			return $this->db->insert_id();
		}	
		
		return FALSE;
	}	

	public function create_user_role( $user_role, $user_id )
	{
		
		if( empty($user_role) ) {
			return false;
		}

		//print_r($user_role); exit();

		foreach ($user_role as $value) {
			$create = array(
				
				ROLE_ID		=>		$value,
				USER_ID		=>		$user_id
			);

			
			$this->db->insert(USER_ROLE_MAPPING, $create);
		}

		return true;
	}	

	public function insert_portal_data($portal_selection, $user_id){
		
		foreach ($portal_selection as $value) {
			$create1 = array(
				ADMIN_PORTAL_ID		=>		$value,
				ADMIN_USER_ID		=>		$user_id
			);

			
			$this->db->insert(ADMIN_PORTAL, $create1);
		}

		return true;
	}

}