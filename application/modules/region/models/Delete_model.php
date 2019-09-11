<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $region_id )
	{
		
		if( empty($region_id) ) {
			return false;
		}

		
		
		$this->db->where(REG_ID, $region_id);
		$delete = $this->db->delete(REGION);
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}