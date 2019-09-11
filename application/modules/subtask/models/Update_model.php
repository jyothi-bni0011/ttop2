<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $subtask_id )
	{
		
		if( empty($subtask_id) ) {
			return false;
		}

		$this->db->select('st.*, p.site_id, s.site_name, r.reg_id, r.region_name');
		$this->db->from(SUBTASK.' as st');
		$this->db->join(PROJECTS.' as p', 'st.project_id=p.id');
		$this->db->join(SITE.' as s', 'p.site_id=s.site_id');
		$this->db->join(REGION. ' as r', 's.region_id=r.reg_id');

		$this->db->where(SUBTASK_ID, $subtask_id);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$row = $query->row();

		//$row = $this->db->get_where(SUBTASK, array(SUBTASK_ID => $subtask_id))->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $subtask_array, $subtask_id )
	{
		
		/*if( empty($site_array['site_owner'])  || empty($site_array['workhours_per_week']) || empty($site_array['timezone']) ) {
			return false;
		}*/
		
		//print_r($update); exit();
		$this->db->where(SUBTASK_ID, $subtask_id);  
		$this->db->update(SUBTASK, $subtask_array);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		return FALSE;

	}	

}