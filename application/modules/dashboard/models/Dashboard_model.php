<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends MY_Model {

	public function insert_blank_timesheet(  )
	{
		//Insert Blank Timesheet after login
		$get_user_data = $this->getById(USER, USER_ID, $this->session->userdata('user_id'));

		$current_week = date('W');
        $current_year = date('Y');
        
        $firstweekday = date("M d, Y", strtotime("{$current_year}-W{$current_week}-1")); 
        $lastweekday = date("M d, Y", strtotime("{$current_year}-W{$current_week}-7")); 

		$timecard['employee_id'] = $this->session->userdata('user_id');
		$timecard['supervisor_id'] = $get_user_data->supervisor_id;
		$timecard['status'] = 0;
		$timecard['start_date'] = date('Y-m-d', strtotime($firstweekday));
		$timecard['end_date'] = date('Y-m-d', strtotime($lastweekday));
		$timecard['created_on'] = date('Y-m-d H:i:s', now());

		$insert_timecard = $this->timesheet_model->insert_Record('timecard', $timecard);

	}

	public function get_total_projects($role, $site = '', $region = '', $from_date = '', $to_date= '')
	{
		$reg_id = $this->session->userdata('region_id');
		$site_id = $this->session->userdata('site_id');
		$this->db->select('projects.*, cc.cost_center_code, cc.cost_center_name, SUM(st.estimated_hours) as estimated_hours, (SELECT SUM(ts.hours) FROM timesheet as ts LEFT JOIN timecard as tc ON tc.timecard_id=ts.timecard_id WHERE projects.id = ts.project_id AND (tc.status = 2 OR tc.status = 3) AND DATE(ts.working_date) >=\''. $from_date .'\' AND DATE(ts.working_date) <= \''. $to_date. '\') as total_hours');
		$this->db->from('projects');
		$this->db->join(SITE . ' as s', 's.site_id = projects.site_id', 'left');
        $this->db->join(REGION . ' as r', 's.region_id = r.reg_id', 'left');
		$this->db->join('cost_center as cc', 'cc.cc_id = projects.cost_center_id', 'left');
		$this->db->join('subtask as st', 'st.project_id = projects.id', 'left');
		$where = "(projects.project_type = 'global' OR projects.project_type = 'region' AND r.reg_id = '" . $reg_id . "' OR projects.project_type = 'site' AND s.site_id = '" . $site_id . "')";
		$this->db->where($where);
		$this->db->where('projects.created_on <= ', $to_date);
		$this->db->where('projects.status', 1);
		$this->db->where('st.status', 1);
		$this->db->group_by('projects.id');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}

	public function get_total_sites($role, $site, $region, $to_date)
	{
		$this->db->select('site.*, cc.cost_center_name, region.region_name');
		$this->db->from('site');
		$this->db->join('cost_center as cc', 'cc.cc_id = site.cost_center_id', 'left');
		$this->db->join('region', 'region.reg_id = site.region_id', 'left');
		$this->db->where('site.status',1);
		$this->db->where('site.created_on <= ', $to_date);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_total_regions( $to_date )
	{
		$this->db->select('region.*');
		$this->db->from('region');
		$this->db->where('region.status',1);
		$this->db->where('region.created_on <= ', $to_date);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_my_projects($user_id, $from_date, $to_date)
	{
		$this->db->select('*');
		$this->db->from('assign_project');
		$this->db->join('projects', 'projects.id = assign_project.project_id', 'left');
		$this->db->where('user_id', $user_id);
		$this->db->where_in('assign_project.status', array('1','2')); //only approved projects

		// $where = '(assign_project.end_date  >= "'. $to_date.'" or assign_project.end_date is NULL or assign_project.end_date = "0000-00-00")';
  //     	$this->db->where($where);

  //     	$where1 = '(assign_project.start_date  <= "'. $from_date.'" or assign_project.start_date is NULL or assign_project.start_date = "0000-00-00")';
  //     	$this->db->where($where1);

		$where = '((assign_project.start_date >= "'.$from_date.'" AND (assign_project.end_date >= "'.$to_date.'" AND assign_project.end_date <= "'.$from_date.'")) OR (assign_project.start_date <= "'.$from_date.'" AND (assign_project.end_date <= "'.$to_date.'" AND assign_project.end_date >= "'.$from_date.'")) OR (assign_project.start_date >= "'.$from_date.'" AND (assign_project.end_date <= "'.$to_date.'" AND assign_project.end_date >= "'.$from_date.'")) OR (assign_project.start_date <= "'.$from_date.'" AND assign_project.end_date >= "'.$to_date.'") OR (((assign_project.start_date <= "'.$from_date.'" AND assign_project.start_date <= "'.$to_date.'") OR (assign_project.start_date >= "'.$from_date.'" AND assign_project.start_date <= "'.$to_date.'")) AND assign_project.end_date IS NULL) OR (assign_project.start_date IS NULL AND assign_project.end_date IS NULL) OR (assign_project.start_date >= "'.$from_date.'" AND assign_project.start_date <= "'.$to_date.'"))';
		$this->db->where($where);		

		$query = $this->db->get();

		// echo $this->db->last_query(); exit;

		
		return $query->result();
	}	

	public function project_timesheet_of_user($user_id, $project_id, $from_date, $to_date)
	{
		
		$this->db->select('p.project_name, st.subtask_name, ts.*, sum(ts.hours) as tot_hr, (SELECT end_date FROM assign_project WHERE ts.project_id = assign_project.project_id AND t.employee_id = assign_project.user_id) as end_date, (SELECT start_date FROM assign_project WHERE ts.project_id = assign_project.project_id AND t.employee_id = assign_project.user_id) as start_date, u.username');
		$this->db->from('timesheet as ts');
		$this->db->join('timecard as t', 'ts.timecard_id=t.timecard_id');
		$this->db->join('users as u', 'u.user_id=t.employee_id');
		$this->db->join('projects as p', 'ts.project_id=p.id','left');
		$this->db->join('subtask as st', 'ts.subtask_id=st.subtask_id','left');
		$this->db->where('ts.project_id', $project_id);
		
		$this->db->where('t.employee_id', $user_id);
		$this->db->where('DATE(ts.working_date) >=', $from_date);
		$this->db->where('DATE(ts.working_date) <=', $to_date);
		$this->db->group_by('ts.working_date, ts.subtask_id, ts.project_id');
		$this->db->order_by('ts.id');
		$query = $this->db->get();
		
		return $query->result();

		// echo "<pre>"; print_r( $query->result() ); exit();
	}

	public function get_week_wise_project_data()
	{
		$this->db->select('SUM(ts.hours), ts.project_id');
		$this->db->from('timesheet as ts');
		$this->db->join('timecard as tc', 'tc.timecard_id = ts.timecard_id');
		// $this->db->where('ts.working_date >=', 'tc.start_date');
		// $this->db->where('ts.working_date <=', 'tc.end_date');
		// $this->db->where('tc.start_date', $from_date);
		// $this->db->where('tc.end_date', $to_date);
		// $this->db->group_by('ts.project_id');
		$this->db->group_by('ts.project_id');
		$query = $this->db->get();

		
		echo "<pre>"; print_r( $query->result() ); exit();	
	}

	public function get_status_count( $user_id, $from_date, $to_date, $status=0 )
	{
		// $this->db->select('COUNT(tc.status) as status_count, tc.status');
		// $this->db->from('users');
		// $this->db->join('timecard as tc', 'tc.employee_id = users.user_id', 'left');
		// $mgrAssignedCond = "(if(users.pr_supervisor_id=0,users.supervisor_id='$user_id',0))";
		// $this->db->where($mgrAssignedCond);
		// $this->db->where('users.status', 1);
		// $this->db->where('DATE(tc.start_date) >= ', $from_date);
		// $this->db->where('DATE(tc.end_date) <= ', $to_date);
		// $this->db->group_by('tc.timecard_id');
		// $query = $this->db->get();
		// return $query->result();

		$this->db->select('um.role_id, u.user_id, u.employee_id, r.role_name, CONCAT(u.first_name," ", u.last_name) as full_name, u.email_id, u.status as user_status, tc.status as tc_status');
		$this->db->from('users_role_mapping as um');
		$this->db->join('role as r', 'r.role_id = um.role_id', 'left');
		$this->db->join('users as u', 'u.user_id = um.user_id', 'right');
		$this->db->join('timecard as tc', 'u.user_id = tc.employee_id', 'left');
		$mgrAssignedCond = "(if(u.pr_supervisor_id=0,u.supervisor_id='$user_id',u.pr_supervisor_id='$user_id'))";
		$this->db->where($mgrAssignedCond);
		$this->db->where('u.status', 1);
		if ( $status ) 
		{
			if ( $status == 1 ) 
			{
				$this->db->where_in('tc.status', [0,1]);
			}
			else
			{
				$this->db->where('tc.status', $status);	
			}
		}
		$this->db->where('DATE(tc.start_date) >= ', $from_date);
		$this->db->where('DATE(tc.end_date) <= ', $to_date);
		$this->db->group_by('tc.timecard_id');
		$query = $this->db->get();
		// print_r( $query->result() ); exit();
		return $query->result();
	}

	public function get_total_users( $user_id, $role, $to_date )
	{
		$this->db->select('create_user_permission');
		$this->db->from('role');
		$this->db->where('role_id', $role);
		$query = $this->db->get();

		$role_details = array();
		$roles = json_decode($query->row()->create_user_permission);
		foreach ($roles as $role) 
		{
			// $role_details[$role] = $this->getById('role', 'role_id', $role);
			if ( $role == 3 || $role == 4 || $role == 2 ) 
			{
				if ( $this->session->userdata('role_id') == 1  ) {
					$role_details[$role] = $this->get_users_by_role($role, $to_date);	
				}
				else
				{

					$role_details[$role] = $this->get_users_by_role($role, $to_date,1);
				}
			}
		}
		
		// $this->db->select('*');
		// $this->db->from('userd_role_mapping');
		// $this->db->where('role_id', );
		// $query = $this->db->get();

		// foreach ($query->row() as $permissions) 
		// {
		// 	$role_info = $this->find_roles_by_json($permissions->create_user_permission);
		// }
		// echo "<pre>"; print_r( $role_details ); exit();
		return $role_details;
	}

	public function get_users_by_role($role_id, $to_date, $supervisor=0)
	{
		$user_id = $this->session->userdata('user_id');
		$this->db->select('um.role_id, u.user_id, r.role_name, CONCAT(u.first_name," ", u.last_name) as full_name, u.email_id, u.status, um.region_id, um.site_id, s.site_name, rg.region_name');
		$this->db->from('users_role_mapping as um');
		$this->db->join('role as r', 'r.role_id = um.role_id');
		$this->db->join('users as u', 'u.user_id = um.user_id');
		$this->db->join('region as rg', 'rg.reg_id = um.region_id', 'left');
		$this->db->join('site as s', 's.site_id = um.site_id', 'left');
		if ( 7 == $this->session->userdata('role_id') ) 
		{
			if ( $this->session->userdata('site_id') ) 
			{
				$region = $this->session->userdata('region_id');
				$site = $this->session->userdata('site_id');
				$this->db->where('um.region_id', $region);
				// $this->db->where('um.site_id', $site);
			}
			else
			{
				$region = $this->session->userdata('region_id');
				$this->db->where('um.region_id', $region);
			}
			$this->db->where('DATE(u.created_on) <= ', $to_date);
			$this->db->where('um.role_id', $role_id);
			$this->db->where('u.status', 1);
		}
		else
		{
			if ( 1 != $this->session->userdata('role_id') ) 
			{
				if ( $this->session->userdata('role_id') == 6 OR $this->session->userdata('role_id') == 5 ) {
					$region_id = $this->session->userdata('region_id');
					$this->db->where('um.region_id', $region_id);
				}
				else
				{
					$site_id = $this->session->userdata('site_id');
					$this->db->where('um.site_id', $site_id);
				}
			}
			if (2 == $this->session->userdata('role_id')) {
				if($this->session->userdata('site_id')==NULL){
					$site_id_full = 0;
				}else{
					$site_id_full = $this->session->userdata('site_id');
				}
				$this->db->where('um.site_id', $site_id_full);
			}else{
				if ( $supervisor )
				{
					$mgrAssignedCond = "(if(u.pr_supervisor_id=0,u.supervisor_id='$user_id',u.pr_supervisor_id='$user_id'))";
					$this->db->where($mgrAssignedCond);
				}
			}
			// $condition = '';
			// if ( $this->session->userdata('role_id') != 1 ) 
			// {
			// 	$site_id = $this->session->userdata('site_id');
			// 	$user_id = $this->session->userdata('user_id');
			// 	$condition .= "(um.site_id = $site_id) OR (u.created_by = $user_id) ";
			// 	$this->db->where($condition);	
			// }
			// $this->db->where('u.created_by', $this->session->userdata('user_id'));
			$this->db->where('DATE(u.created_on) <= ', $to_date);
			$this->db->where('um.role_id', $role_id);
			$this->db->where('u.status', 1);
			
			$condition = "(u.created_by = $user_id AND um.role_id = $role_id AND u.status=1)";
			$this->db->or_where($condition);
			
		}
		
		$this->db->group_by('um.user_id');

		$query = $this->db->get();
		// echo $this->db->last_query(); exit;
		return $query->result();		
	}

	public function get_total_project_hours($reg_id = '', $site_id = '', $project_type = '', $list_project = '', $to_date = '',$came_from=null)
	{
		// $this->db->select('projects.*, cc.cost_center_code, cc.cost_center_name, SUM(st.estimated_hours) as estimated_hours, (SELECT SUM(ts.hours) FROM timesheet as ts LEFT JOIN timecard as tc ON tc.timecard_id=ts.timecard_id WHERE projects.id = ts.project_id AND (tc.status = 2 OR tc.status = 3)) as total_hours');
		// $this->db->from('projects');
		// $this->db->join('cost_center as cc', 'cc.cc_id = projects.cost_center_id');
		// $this->db->join('subtask as st', 'st.project_id = projects.id', 'left');
		// $this->db->where('DATE(projects.created_on) <= ', $to_date);
		// $this->db->group_by('projects.id');
		// $query = $this->db->get();

		$this->db->select('p.*,p.status as pstatus,r.region_name, s.site_name, u.username as svname,cc.cost_center_code,cc.cost_center_name, (SELECT SUM(ts.hours) FROM timesheet as ts LEFT JOIN timecard as tc ON tc.timecard_id=ts.timecard_id WHERE p.id = ts.project_id AND (tc.status = 2 OR tc.status = 3)) as total_hours, (SELECT SUM(st.estimated_hours) from subtask as st where st.project_id = p.id) as estimated_hours');
        $this->db->from(PROJECTS . ' as p');
        $this->db->join(SITE . ' as s', 's.site_id = p.site_id');
        $this->db->join(REGION . ' as r', 's.region_id = r.reg_id');
        $this->db->join(USER . ' as u', 'u.user_id = p.supervisor_id', 'left');
        // $this->db->join('subtask as st', 'st.project_id = p.id', 'left');

        if($came_from='dashboard'){
        $this->db->join('cost_center as cc', 'cc.cc_id = p.cost_center_id', 'left');
        if (empty($project_type)) {
            $where = "p.status = '1' AND p.project_type = 'global' OR p.project_type = 'region' AND r.reg_id = '" . $reg_id . "' OR p.project_type = 'site' AND s.site_id = '" . $site_id . "'";
            $this->db->where($where);
        }
        }
        if (empty($came_from) && empty($list_project)) {
         $this->db->where('p.status', 1);
         }
       
        
        $r_conditions = $s_conditions = $g_conditions = '';
        if (!empty($reg_id)) {

            $r_conditions .= "(p.project_type = 'region' and r.reg_id = $reg_id) OR ";
        }

        if (!empty($site_id)) {

            $r_conditions .= "(p.project_type = 'site' and s.site_id = $site_id) OR ";
        }

        if (!empty($project_type)) {
            $r_conditions .= "(p.project_type = 'global')";
        }

        if (!empty($r_conditions)) {
            $r_conditions = trim($r_conditions, ' OR ');
            //exit;
            $this->db->where('(' . $r_conditions . ')');
        }

        

        if (!empty($to_date)) {
            $this->db->where('p.created_on <= ', $to_date);
        }

        $query = $this->db->get();
       // echo $this->db->last_query(); exit;
        // return $query->result();
		
		return $query->result();
	}

	public function get_timesheet_data_by_role($role_id='', $from_date, $to_date)
	{
		if ( ! empty( $role_id ) ) 
		{
			// $this->db->select('COUNT(tc.status) as status_count, tc.status');
			// $this->db->from('users_role_mapping as urm');
			// $this->db->join('timecard as tc', 'tc.employee_id = urm.user_id', 'left');
			// // $mgrAssignedCond = "(if(users.pr_supervisor_id=0,users.supervisor_id='$user_id',0))";
			// // $this->db->where($mgrAssignedCond);
			// $this->db->where('urm.region_id', $this->session->userdata('region_id'));
			// $this->db->where('urm.role_id', $role_id);
			// $this->db->where('DATE(tc.start_date) >= ', $from_date);
			// $this->db->where('DATE(tc.end_date) <= ', $to_date);
			// $this->db->group_by('tc.status');
			// $query = $this->db->get();

			$this->db->select('um.role_id, u.user_id, u.employee_id, r.role_name, CONCAT(u.first_name," ", u.last_name) as full_name, u.email_id, u.status as user_status, tc.status as tc_status');
			$this->db->from('users_role_mapping as um');
			$this->db->join('role as r', 'r.role_id = um.role_id', 'left');
			$this->db->join('users as u', 'u.user_id = um.user_id', 'right');
			$this->db->join('timecard as tc', 'u.user_id = tc.employee_id', 'left');
			if ( 1 != $this->session->userdata('role_id') ) 
			{
				$region = $this->session->userdata('region_id');
				$this->db->where('um.region_id', $region);
			}
			$this->db->where('DATE(u.created_on) <= ', $to_date);
			$this->db->where('um.role_id', $role_id);
			$this->db->group_by('um.user_id');

			$query = $this->db->get();
			// print_r( $query->result() ); exit();
			return $query->result();
		}
	}

	public function get_user_data_for_cron(){

		$this->db->select('u.user_id, u.username, r.site_id, s.timezone, IF(u.pr_supervisor_id=0, u.supervisor_id, u.pr_supervisor_id) as supervisor');
		$this->db->from('users as u');
		$this->db->join('users_role_mapping as r', 'u.user_id=r.user_id');
		$this->db->join('site as s', 'r.site_id=s.site_id');
		$this->db->where_in('r.role_id', array(3,4));
		$this->db->where('u.status', 1);
		$this->db->group_by('u.user_id');

		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}

	//Get all submitted timesheet
	public function get_submitted_for_autoapproval(){ 
		$this->db->select('tc.timecard_id, u.user_id, tc.status');
		$this->db->from('users as u');
		$this->db->join('timecard as tc', 'u.user_id=tc.employee_id');
		$this->db->where('tc.status','2');
		$this->db->where('u.status','1');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
		
	}
	
}
