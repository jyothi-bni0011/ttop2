<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subtask_model extends MY_Model {


	public function subtask( $region_id = '', $site_id = '' )
	{
		$this->db->select('GROUP_CONCAT(st.subtask_id) as subtasksIds, GROUP_CONCAT(st.subtask_name) as subtasknames, st.project_id, p.project_name, s.site_name, r.region_name, GROUP_CONCAT(st.estimated_hours) as estimatedhours, GROUP_CONCAT(st.status) as subtaskstatus, GROUP_CONCAT(st.sap_number) as sap_numbers');
		$this->db->from(SUBTASK .' as st');
		$this->db->join(PROJECTS .' as p', 'st.project_id = p.id');
		$this->db->join(SITE .' as s', 's.site_id = p.site_id');
		$this->db->join(REGION .' as r', 'r.reg_id = s.region_id');
		$r_where = $s_where = '1';
		if($region_id != ''){
			$r_where = "(r.reg_id = $region_id AND p.project_type = 'region')";
		}
		if($site_id != ''){
			$s_where = "(p.site_id = $site_id AND p.project_type = 'site')";
		}
		$this->db->where("p.project_type = 'global' OR $r_where OR $s_where");
		//$this->db->where('p.project_type','global');
                $this->db->order_by('st.created_on','desc');
		$this->db->group_by('st.project_id');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}	

}