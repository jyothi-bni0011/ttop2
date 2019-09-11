<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends MY_Model {


	public function users( $role_ids = array(), $conditional = array(), $toDate = '', $created_by = '' ) // to fetch specific role users
	{
		
		$this->db->select('users_role_mapping.*, role.role_name, users.*, GROUP_CONCAT(users_role_mapping.role_id SEPARATOR ",") as user_roles, GROUP_CONCAT(site.site_name) as sites, GROUP_CONCAT(role.role_name) as roles, GROUP_CONCAT(region.region_name) as regions');
		$this->db->from('users_role_mapping');
		$this->db->join('role', 'role.role_id = users_role_mapping.role_id');
		$this->db->join('users', 'users.user_id = users_role_mapping.user_id');
		$this->db->join('site', 'users_role_mapping.site_id = site.site_id', 'left');
		$this->db->join('region', 'users_role_mapping.region_id = region.reg_id', 'left');

		$where = $where1 = '(';
		if(!empty($conditional)){
			foreach($conditional as $key=>$value){
				//$this->db->where($key, $value);	
				$where .= "$key = $value AND ";
      			
			}
		}
		$in = '';
		//print_r($role_ids) ; exit;
		if(!empty($role_ids)){
			//$this->db->where_in('users_role_mapping.role_id', $role_ids);
			foreach($role_ids as $id){ 
				$in.= "'".$id."',";
			}
			$in = rtrim($in,',');
			$where .= " users_role_mapping.role_id IN(".$in.") AND "; //exit;

			$where1 .= " users_role_mapping.role_id IN(".$in.") AND "; //exit;
		}

		if(!empty($toDate)){
			$this->db->where('users.status', 1);
			$where .= " DATE(users.created_on) <= '$toDate'";
		}

		$where = trim($where,' AND ');
		$where .= ')';
		//echo $where; exit;
		


		if(!empty($created_by)){
			$where1 .= "users.created_by = $created_by";
		}
		//$where1 .= "users.created_by = $created_by";


		$where1 = trim($where1,' AND ');
		$where1 .= ')';

		if(!empty($created_by)){
			$this->db->where('('.$where ." OR ". $where1.')');
		}else{
			$this->db->where($where);
		}
		
                $this->db->order_by('users.created_on','desc');
		$this->db->group_by('users.user_id');
                
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
		//echo "<pre>";
		//print_r($query->result()); exit();
	}

	public function get_user_portal( $user_id )
	{
		$this->db->select('p.portal_id, p.portal_name');
		$this->db->from(PORTAL. ' as p');
		$this->db->join(ADMIN_PORTAL. ' as a', 'a.portal_id = p.portal_id') ;
		if(!empty($user_id)){
			$this->db->where('a.user_id', $user_id);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function get_rolewise_users( $role_id='', $site_id='' ){
		$this->db->select('u.user_id, CONCAT(u.first_name," ",u.last_name) as name, m.site_id, m.region_id');
		$this->db->from(USER. ' as u');
		$this->db->join(USER_ROLE_MAPPING. ' as m', 'u.user_id = m.user_id') ;
		if(!empty($role_id)){
			$this->db->where('m.role_id', $role_id);
		}
		$site_ar = explode(',',$site_id);
		if(!empty($site_id)){
			//$this->db->where('u.site_id', $site_id);
			$this->db->where_in('m.site_id', $site_ar);
		}

		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}

	public function getSupervisors($region = '', $site_arr = array(), $sv_id = ''){
		$this->db->select('CONCAT(u.first_name," ",u.last_name) as name, u.user_id, u.status, m.site_id');
		$this->db->from(USER.' as u');
		$this->db->join(USER_ROLE_MAPPING. ' as m', 'u.user_id = m.user_id' );
		$this->db->where('m.role_id', 3);
		$this->db->where('u.status', 1);
		if(!empty($region)){
			$this->db->where('m.region_id', $region);
		}
		if(!empty($site_arr)){
			$this->db->where_in('m.site_id', $site_arr);
		}
		if(!empty($sv_id)){
			$this->db->where('m.user_id !=', $sv_id);
		}
		$this->db->group_by('u.user_id');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}

	
	public function shift_notifications( $change_from, $change_to )
	{
		$data = [
			'notification_to' => $change_to
		];
		 // echo "  in shift ".$change_from.'   '. $change_to;
		$this->db->where('notification_to', $change_from);
		$this->db->where('status', 0);
        $this->db->update('notification', $data);

        if ( $this->db->affected_rows() ) 
        {
        	return true;	
        }
        return false;
	}

	public function getuserallprojects($user_id, $start, $last, $project_id=0)
	{
		// echo "proj : ".$project_id;exit();
		$return = array();
		$this->db->select('assign_project.*,projects.project_name,cost_center.cost_center_code,cost_center.cost_center_name');	
		$this->db->from('assign_project');
		$this->db->join('projects', 'projects.id = assign_project.project_id','left');
		$this->db->join('cost_center', 'cost_center.cc_id = projects.cost_center_id','left');
		$this->db->where('assign_project.user_id', $user_id);
		$this->db->where('projects.status',1);
		if ( $project_id ) 
		{
			$this->db->where('assign_project.project_id',$project_id);
		}
		$query = $this->db->get();

		if ( ! empty( $query->result() ) ) {
			
			foreach ($query->result() as $project)
		    {
		        $return[$project->project_id] = $project;
				$return[$project->project_id]->projectdata = $this->get_projectdata($project->project_id,$user_id,$start,$last);
				$return[$project->project_id]->subtaskdata = $this->get_assigned_subtasks_details(json_decode($project->subtask_ids));
		    }

		}
		// echo "<pre>"; print_r( $return ); exit();
		return $return;
	}

	public function get_projectdata($proj_id, $user_id, $start, $last)
	{
		$this->db->select('SUM(ts.hours) as total_hours');
		$this->db->from('timesheet as ts');
		$this->db->join('timecard as tc', 'tc.timecard_id = ts.timecard_id', 'left');
		$this->db->join('subtask as st', 'st.subtask_id = ts.subtask_id', 'left');
		$this->db->where('ts.project_id',$proj_id);
		$this->db->where('tc.employee_id',$user_id);
		$this->db->where('DATE(ts.working_date) >=',$start);
		$this->db->where('DATE(ts.working_date) <=',$last);
		// $this->db->where('tc.status',3); // Only approved timesheet
		// $this->db->group_by('ts.subtask_id');
		$query = $this->db->get();
		// echo'<pre>'; print_r( $query->result() );
		return $query->row();
	}

	

	public function assigned_project_list($user_id)
	{
		$this->db->select('projects.id as project_id, projects.project_name');	
		$this->db->from('assign_project');
		$this->db->join('projects', 'projects.id = assign_project.project_id');
		$this->db->where('assign_project.user_id', $user_id);
		$this->db->where('projects.status', 1);
		// $this->db->where('assign_project.other_status', 0);
		$this->db->group_by('assign_project.project_id');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_user_mapping_data($user_id = '', $role_id = ''){
		$this->db->select('map.*, u.supervisor_id, u.pr_supervisor_id, u.username');
		$this->db->from('users as u');
		$this->db->join('users_role_mapping as map', 'u.user_id = map.user_id');
		$this->db->join('role as r', 'map.role_id = map.role_id');

		if(!empty($user_id)){
			$this->db->where('u.user_id', $user_id);	
		}

		if(!empty($role_id)){
			$this->db->where('map.role_id', $role_id);
		}
		$this->db->group_by('u.user_id');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->row();
	}
}