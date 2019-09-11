<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $cost_center_id )
	{
		
		if( empty($cost_center_id) ) {
			return false;
		}

		
		
		$this->db->where(CC_ID, $cost_center_id);
		$delete = $this->db->delete(COST_CENTER);
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}