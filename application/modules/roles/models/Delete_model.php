<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $role_id )
	{
		
		if( empty($role_id) ) {
			return false;
		}

		
		
		$this->db->where(ROLE_ID, $role_id);
		$delete = $this->db->delete(ROLE);
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}