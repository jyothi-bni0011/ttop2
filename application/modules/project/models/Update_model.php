<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $project_id )
	{
		
		if( empty($project_id) ) {
			return false;
		}

		//$row = $this->db->get_where(PROJECTS, array(PROJECT_ID => $project_id))->row();

		$this->db->select('p.*, s.site_name, r.reg_id, r.region_name');
		$this->db->from(PROJECTS.' as p');
		$this->db->join(SITE.' as s', 'p.site_id=s.site_id');
		$this->db->join(REGION. ' as r', 's.region_id=r.reg_id');

		$this->db->where(PROJECT_ID, $project_id);
		$query = $this->db->get();
		$row = $query->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $project_array, $project_id )
	{
		
		/*if( empty($site_array['site_owner'])  || empty($site_array['workhours_per_week']) || empty($site_array['timezone']) ) {
			return false;
		}*/
		
		//print_r($update); exit();
		$this->db->where(PROJECT_ID, $project_id);  
		$this->db->update(PROJECTS, $project_array);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		return FALSE;

	}	

	public function get_region_by_site( $site_id )
	{
		$this->db->select('*');
		$this->db->from('region');
		$this->db->join('site', 'site.region_id = region.reg_id');
		$this->db->where('site.site_id', $site_id);
		$query = $this->db->get();
		// print_r( $site_id ); exit();
		return $query->row();
	}
}