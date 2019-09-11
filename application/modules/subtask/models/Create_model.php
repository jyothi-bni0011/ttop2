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

	public function create( $subtask_array )
	{  
		
		if( empty($subtask_array['project_id']) || empty($subtask_array['subtask_name']) || empty($subtask_array['estimated_hours']) ) { 
			return false;
		}
		
		if ($this->check_duplicate_on_multiCol(SUBTASK, array('subtask_name'=>$subtask_array['subtask_name'], 'project_id'=>$subtask_array['project_id'] ) )) { 
			$this->db->insert(SUBTASK, $subtask_array);
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		}
		
		return FALSE;

	}		

}