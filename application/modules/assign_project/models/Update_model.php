<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $assign_project_id )
	{
		if( empty($assign_project_id) ) {
			return false;
		}

		$this->db->select('ap.id, ap.project_id, p.start_date as project_start_date, p.end_date as project_end_date, p.project_name, p.project_type, ap.user_id, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(u1.first_name, " ", u1.last_name) as assign_by, GROUP_CONCAT(s.subtask_name) as all_subtasks, GROUP_CONCAT(s.subtask_id) as all_subtaskids, ap.start_date, ap.end_date, u.site_id, ap.assign_to_role, ap.subtask_ids as assigned_subtask, p.explicite_subtask, map.site_id, map.region_id');
		$this->db->from(ASSIGN_PROJECT.' as ap');
		$this->db->join(PROJECTS.' as p', 'ap.project_id=p.id');
		$this->db->join(USER.' as u', 'u.user_id=ap.user_id');
		$this->db->join(USER.' as u1', 'u1.user_id=ap.assign_by');
		$this->db->join(USER_ROLE_MAPPING.' as map', 'u.user_id=map.user_id', 'left');
		$this->db->join(SUBTASK.' as s', 's.project_id=p.id', 'left');
		$this->db->where('ap.id', $assign_project_id);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$result = $query->row();
		//$row = $this->db->get_where(ASSIGN_PROJECT, array(ASSIGN_ID => $assign_project_id))->row();
		  		
		if( $result ) {
			return $result;
		}	
		
		return FALSE;
	}

	public function update( $project_array, $id )
	{
		if($this->check_duplicate_on_multiCol( ASSIGN_PROJECT, $project_array, array(ASSIGN_ID=>$id) )){

			$this->db->where(ASSIGN_ID, $id);  
			$this->db->update(ASSIGN_PROJECT, $project_array);  		
			if( $this->db->affected_rows() ) {
				return true;
			}

		}else{
			return false;
		}

		//print_r($update); exit();
			
		
		return FALSE;

	}	

}