<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $assign_id )
	{
		
		if( empty($assign_id) ) {
			return false;
		}

		
		
		$this->db->where(ASSIGN_ID, $assign_id);
		$delete = $this->db->delete(ASSIGN_PROJECT);
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}