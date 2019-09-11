<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $site_id )
	{
		
		if( empty($site_id) ) {
			return false;
		}

		
		
		$this->db->where(SITE_ID, $site_id);
		$delete = $this->db->delete(SITE);
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}