<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_model extends MY_Model {

	/*public function check_duplicate($role_name)
	{
		$this->db->where('role_name', $role_name);
		$res = $this->db->get('role');
		if (count($res->result()) == 0) {
			return true;
		}
		else {
			return false;
		}
	}*/

	public function create( $project_array )
	{  
		
		if ($this->check_duplicate( PROJECTS, PROJECT_NAME, $project_array['project_name'] )) { 
			$this->db->insert(PROJECTS, $project_array);
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		}
		
		return FALSE;

	}	

}