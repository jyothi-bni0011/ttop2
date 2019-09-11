<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_project_model extends MY_Model {


	public function Assigned_projects( $role_id = '' )
	{
		$this->db->select('distinct(u.user_id), p.project_name, p.project_type, s.site_name, r.region_name, GROUP_CONCAT(distinct(u.username)) as name, GROUP_CONCAT(distinct(u.username)) as username, GROUP_CONCAT(distinct(ap.id)) as ids, ap.assign_to_role, GROUP_CONCAT(role.role_name) as roles, GROUP_CONCAT(ap.status) as status, GROUP_CONCAT(ap.subtask_ids) as subtask_ids');
		$this->db->from(ASSIGN_PROJECT . ' as ap');
		$this->db->join(PROJECTS . ' as p', 'ap.project_id = p.id', 'inner');
		//$this->db->join(SUBTASK . ' as sub', 'sub.project_id =subtask_ids p.id', 'left');
		$this->db->join(USER .' as u', 'ap.user_id = u.user_id', 'inner');
		$this->db->join(USER_ROLE_MAPPING .' as map', 'map.user_id = u.user_id', 'inner');
		$this->db->join(ROLE .' as role', 'role.role_id = map.role_id', 'inner');
		$this->db->join(SITE .' as s', 'p.site_id = s.site_id', 'inner');
		$this->db->join(REGION .' as r', 'r.reg_id = s.region_id', 'inner');
		if(!empty($role_id)){
			$this->db->where_in('role.role_id', array($role_id)); //engineer and supervisor role
		}else{
			$this->db->where_in('role.role_id', array(3,4)); //engineer and supervisor role
		}
		
		$this->db->where('ap.assign_by', $this->session->userdata('user_id'));
                $this->db->order_by('ap.created_on','desc');
		$this->db->group_by('p.id');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}

	public function getProject_forassign($conditions = array()){
		
		$this->db->select('*');
		$this->db->from( PROJECTS );
		foreach($conditions as $key=>$val){
			if($key != 'site_arr'){ 
				$this->db->where( $key, $val ); 	
			}else{
				$this->db->where_in('site_id', $val);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
		
	}	

}