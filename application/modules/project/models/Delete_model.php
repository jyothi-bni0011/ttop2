<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $project_id )
	{
		
		if( empty($project_id) ) {
			return false;
		}

		
		
		$this->db->where(PROJECT_ID, $project_id);
		$delete = $this->db->delete(PROJECTS);
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}