<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timesheet_model extends MY_Model {


	public function timesheet( $reg_id = '', $site_id = '', $project_type = '' )
	{
		$this->db->select('p.*, r.region_name, s.site_name');
		$this->db->from(PROJECTS .' as p');
		$this->db->join(SITE .' as s', 's.site_id = p.site_id');
		$this->db->join(REGION .' as r', 's.region_id = r.reg_id');
		if(!empty($reg_id)){
			$this->db->where('r.reg_id', $reg_id);  
		}
		if(!empty($site_id)){
			$this->db->where('s.site_id', $site_id);  
		}
		if(!empty($project_type)){
			$this->db->where('p.project_type', $project_type);  
		}
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}	

	public function getAssignedSubtask($project_id, $user_id){
		$this->db->select('ap.subtask_ids, ap.end_date, ap.start_date, ap.project_id');
		$this->db->from(PROJECTS.' as p');
		$this->db->join(ASSIGN_PROJECT. ' as ap', 'p.id=ap.project_id');
		$this->db->where('ap.user_id', $user_id);
		$this->db->where('ap.project_id', $project_id);
		$this->db->where('ap.subtask_ids !=', 'null');
		$query = $this->db->get();
		
		$result = $query->row();
		
		if($result){ 
			$end_date = $start_date = '';
			if(!empty($result->end_date)){
				$end_date = $result->end_date;	
			}
			if(!empty($result->start_date)){
				$start_date = $result->start_date;	
			}
			$sub_arr = '';
			if(!empty($result->subtask_ids)){
				$sub_arr = json_decode($result->subtask_ids);
			}
			
			$this->db->select("subtask_id, subtask_name");
			$this->db->from(SUBTASK);
			$this->db->where('project_id', $result->project_id);
			if(is_array($sub_arr)){
				$this->db->where_in('subtask_id', $sub_arr);
			}
			
			$this->db->where_in('status', 1);
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
			//$result['start_date'] = $start_date;
			//$result['end_date'] = $end_date;
			$result = $query->result();
			$data['result'] = $result;
			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;
			//$result->start_date = $start_date;
			return $data;
		}
		return false;
	}

	public function getMyTimesheet($timecard_id='', $start='', $end='', $emp_id='', $status=''){
		if ( !empty($timecard_id) ) 
		{
			/*$this->db->query('select ts.*, sum(ts.hours) as tot_hr from timesheet as ts inner join timecard as t using(timecard_id) where ts.timecard_id = '.$timecard_id.' and t.employee_id = '.$emp_id.' and ts.working_date between \''.$start.'\' and \''.$end.'\'  group by ts.working_date, ts.subtask_id, ts.project_id order by ts.id');

			$query = $this->db->get();*/

			$this->db->select('p.project_name, st.subtask_name, ts.*, ts.hours as tot_hr, (SELECT end_date FROM assign_project WHERE ts.project_id = assign_project.project_id AND t.employee_id = assign_project.user_id) as end_date, (SELECT start_date FROM assign_project WHERE ts.project_id = assign_project.project_id AND t.employee_id = assign_project.user_id) as start_date, u.username');
			$this->db->from('timesheet as ts');
			$this->db->join('timecard as t', 'ts.timecard_id=t.timecard_id');
			$this->db->join('users as u', 'u.user_id=t.employee_id');
			$this->db->join('projects as p', 'ts.project_id=p.id','left');
			$this->db->join('subtask as st', 'ts.subtask_id=st.subtask_id','left');
			$this->db->where('ts.timecard_id', $timecard_id);
			$this->db->where('t.employee_id', $emp_id);
			$this->db->where('ts.working_date >=', $start);
			$this->db->where('ts.working_date <=', $end);
			$this->db->group_by('ts.working_date, ts.subtask_id, ts.project_id');
			$this->db->order_by('ts.id');
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
			return $query->result();
		}

		$this->db->select('t.*');
		$this->db->from('timecard as t');
		$this->db->join('timesheet as ts', 't.timecard_id = ts.timecard_id', 'inner');
		if($start){
			$this->db->where('t.start_date >=', $start);	
		}
		if($end){
			$this->db->where('t.start_date <=', $end);	
		}
		if($emp_id){
			$this->db->where('t.employee_id', $emp_id);	
		}
		if($status!=''){
			$this->db->where('t.status', $status);	
		}
		
		$this->db->group_by('t.timecard_id');
		$this->db->order_by('t.timecard_id', 'DESC');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}

	public function get_timesheet_projectwise($timecard_id){
		$this->db->select('*');
		$this->db->from('timesheet');
		$this->db->where('timecard_id', $timecard_id);
		$this->db->group_by('project_id, subtask_id');
	}

	public function checkfor_timesheet($emp_id, $start_date){
		$this->db->select('*');
		$this->db->from('timecard');
		$this->db->where('employee_id', $emp_id);
		$this->db->where('start_date', $start_date);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->row();
	}

	public function get_engineers_timesheet( $emp_id='', $status='', $start='', $end='', $roles = '' )
	{	
		$supervisor_id = $this->session->userdata('user_id');
		$username = $this->session->userdata('username');	

		if ( ! empty( $status ) ) 
		{
			$status_arr = array($status);
		}
		else
		{
			$status_arr = array('2','3','4');
		}
		$this->db->select('users.user_id, users.employee_id, users.first_name, users.last_name, DATE(tc.start_date) as start_date, DATE(tc.end_date) as end_date, tc.status, tc.timecard_id, GROUP_CONCAT(distinct(r.role_name)) as role_name');
		$this->db->from('users');
		$this->db->join('timecard as tc', 'tc.employee_id = users.user_id', 'left');
		$this->db->join('timesheet as ts', 'ts.timecard_id = tc.timecard_id','left');
		$this->db->join('users_role_mapping as map', 'users.user_id = map.user_id');
		$this->db->join('role as r', 'r.role_id = map.role_id');

		if($this->session->userdata('role_id') == 5){ // 5- Program Manager
			$this->db->where('map.role_id', 3);
		}else if(!empty($roles)){
			$this->db->where_in('map.role_id', $roles);
		}

		$mgrAssignedCond = "(if(users.pr_supervisor_id=0,users.supervisor_id='$supervisor_id',users.pr_supervisor_id='$supervisor_id'))";
		$this->db->where($mgrAssignedCond);
		$this->db->where('users.status', 1);
		if ( ! empty( $emp_id ) ) 
		{
			$this->db->where('users.user_id', $emp_id);
		}
		if ( ! empty( $start ) ) 
		{
			$this->db->where('DATE(ts.working_date) >= ', $start);
		}
		if ( ! empty( $end ) ) 
		{
			$this->db->where('DATE(ts.working_date) <= ', $end);
		}
		$this->db->where_in('tc.status', $status_arr);
		$this->db->group_by('tc.timecard_id');
		$this->db->order_by('tc.status', 'ASC');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit();
		// print_r( $query->result() ); exit();
		return $query->result();
	}

	public function get_timecards_by_status( $user_id='', $status='' )
	{
		if ( empty($status) || empty($user_id) ) 
		{
			return false;	
		}
		$this->db->select('t.*');
		$this->db->from('timecard as t');
		$this->db->join('timesheet as ts', 't.timecard_id = ts.timecard_id', 'inner');
		$this->db->where('t.employee_id', $user_id);	
		$this->db->where('t.status', $status);
		$this->db->group_by('t.timecard_id');
		$this->db->order_by('t.timecard_id', 'DESC');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();


		// $this->db->select('*');
		// $this->db->from('timecard');
		// $this->db->where('employee_id', $user_id);
		// $this->db->where('status', $status);
		// $query = $this->db->get();

		// // print_r($user_id);print_r($query->result()); exit();

		// if ( ! empty( $query->result() ) ) 
		// {
		// 	return $query->result();	
		// }
		// return false;
	}

	public function get_my_engineers($user_id, $permission)
	{
		
		// print_r( json_decode( $roles->assign_project_permission ) ); exit();
		$this->db->from('users');
		$mgrAssignedCond = "(if(users.pr_supervisor_id=0,users.supervisor_id='$user_id',users.pr_supervisor_id='$user_id'))";
		//If Program manager login, he can see only supervisors
		if($this->session->userdata('role_id') == 5){ // 5- Program Manager
			$this->db->join('users_role_mapping as map', 'users.user_id = map.user_id');
			$this->db->where('map.role_id', 3);
		}
		else
		{
			$this->db->join('users_role_mapping as map', 'users.user_id = map.user_id');
			$this->db->where_in('map.role_id', $permission);
			
		}
		$this->db->where($mgrAssignedCond);
		$this->db->where('users.status', 1);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit();
		// print_r( $query->result() ); exit();
		return $query->result();
	}

	// public function getallsubmittedtimesheets($user_id){
	// 	$this->db->select('n.*, CONCAT(u.first_name," ",u.last_name) as to_name, CONCAT(u1.first_name," ",u1.last_name) as from_name');
	// 	$this->db->from('notification as n');
	// 	$this->db->join('users as u', 'n.notification_to = u.user_id');
	// 	$this->db->join('users as u1', 'n.notification_from = u1.user_id');
	// 	if(!empty($user_id)){
	// 		$this->db->where('n.notification_to', $user_id);
	// 	}
	// 	$this->db->where('n.request', 'timesheet');
	// 	$this->db->order_by('n.notification_id','desc');
	// 	$query = $this->db->get();
	// 	//echo $this->db->last_query(); exit;
	// 	return $query->result();
	// }
}