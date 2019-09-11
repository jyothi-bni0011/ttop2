<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $user_id )
	{
		
		if( empty($user_id) ) {
			return false;
		}

		
		
		$this->db->where(USER_ID, $user_id);
		$delete = $this->db->delete(USER);
		if( $this->db->affected_rows() ) {
			$this->db->where(USER_ID, $user_id);
			$delete = $this->db->delete(USER_ROLE_MAPPING);
			return true;
		}	
		
		

		return FALSE;

	}	

}