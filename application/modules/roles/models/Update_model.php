<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $role_id )
	{
		
		if( empty($role_id) ) {
			return false;
		}

		$row = $this->db->get_where(ROLE, array(ROLE_ID => $role_id))->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $role_array, $role_id )
	{
		
		/*if( empty($role_array['role_description']) || empty($role_array['role_name']) || empty($role_id) ) {
			return false;
		}*/

		$result = $this->fetch_data( $role_id );
		
		if ( $result->role_name != $role_array['role_name'] ) {
			if ($this->check_duplicate( ROLE, ROLE_NAME, $role_array['role_name'] )) {
				$update[ROLE_NAME] = $role_array['role_name'];
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where(ROLE_ID, $role_id);  
		$this->db->update(ROLE, $role_array);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;

	}	

}