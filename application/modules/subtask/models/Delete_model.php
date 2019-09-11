<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $subtask_id )
	{
		
		if( empty($subtask_id) ) {
			return false;
		}

		
		
		$this->db->where(SUBTASK_ID, $subtask_id);
		$delete = $this->db->delete(SUBTASK);
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}