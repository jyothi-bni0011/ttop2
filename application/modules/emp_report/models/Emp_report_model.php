<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_report_model extends MY_Model {


	public function emp_report_data( $user_id, $from_date = '', $to_date = '', $site_id = '', $region = '', $role = '', $status = '', $period_closed_hours = '', $project = '', $subtask = '', $employee = '', $hours_type = '' )
	{
		
		$this->db->select('tc.*, SUM(ts.hours) as total_hours, s.site_name, s.workhours_per_week, CONCAT(u.first_name, " ", u.last_name) as name, CONCAT(u1.first_name, " ", u1.last_name) as sv_name, u.user_id as emp_id, u1.user_id as sv_id, u.email_id as emp_email, u1.email_id as sv_email, GROUP_CONCAT(distinct(r.role_id)) as roles');
		$this->db->from('timecard as tc');
		$this->db->join('timesheet as ts', 'tc.timecard_id = ts.timecard_id');
		$this->db->join('users as u', 'tc.employee_id = u.user_id');
		$this->db->join('users as u1', 'tc.supervisor_id = u1.user_id', 'left');
		$this->db->join('users_role_mapping as r', 'u.user_id = r.user_id');
		$this->db->join('site as s', 'r.site_id = s.site_id', 'left');

		//$where = 'tc.status = 3 OR tc.status = 2';
		//$this->db->where($where);
		if(!empty($from_date)){
			$this->db->where('ts.working_date >=', $from_date);
		}

		if(!empty($to_date)){
			$this->db->where('ts.working_date <=', $to_date);
		}

		if(!empty($region)){
			$this->db->where('r.region_id', $region);
		}

		if(!empty($site_id)){
			$this->db->where('r.site_id', $site_id);
		}

		if(!empty($role)){
			$this->db->where('r.role_id', $role);	
		}

		if(!empty($status)){
			$this->db->where_in('tc.status', $status);	
		}

		if(!empty($project)){
			$this->db->where('ts.project_id', $project);	
		}

		if(!empty($subtask)){
			$this->db->where('ts.subtask_id', $subtask);	
		}

		if(!empty($employee)){
			$this->db->where('tc.employee_id', $employee);	
		}

		if(!empty($period_closed_hours) && $period_closed_hours=='no'){

			$where = "ts.working_date NOT IN(SELECT day FROM period_closing_dates inner join period_closing using(period_id) WHERE day BETWEEN '$from_date' AND '$to_date' AND region_id=r.region_id )";
			$this->db->where($where);		
		}

		
		//$this->db->where('tc.status !=', 0);
		$this->db->group_by('tc.timecard_id');

		if(!empty($hours_type) && $hours_type == 'missing'){
			//$this->db->having("total_hours < $site_week_hours");	
			$this->db->having("total_hours < s.workhours_per_week");
		}
		

		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}	

	public function change_notification_status( $user_id = '' ){
		
		$update = array('status'=>1);
		$array = array('notification_to' => $user_id, 'status'=>0);
		$this->db->where($array); 
		return $this->db->update('notification', $update);

	}

	public function hours_to_sap_report_data( $user_id, $from_date = '', $to_date = '', $site_id = '', $region = '', $role = '', $status = '', $period_hours = '', $project = '', $subtask = '', $employee = '' ){

		$this->db->select('u.username, SUM(ts.hours) as total_hours,tc.`status`,  tc.employee_id, ts.project_id, p.project_name, s.site_name, s.workhours_per_week, c.cost_center_code, c.cost_center_name, s.workhours_per_week, GROUP_CONCAT(m.role_id) as roles');
		//$this->db->select('u.username, SUM(ts.hours) as total_hours,tc.`status`,  tc.employee_id, ts.project_id, p.project_name, s.site_name, s.workhours_per_week, c.cost_center_code, c.cost_center_name, s.workhours_per_week, GROUP_CONCAT(m.role_id) as roles, GROUP_CONCAT(ts.working_date ORDER BY ts.working_date ASC) AS group_dates, GROUP_CONCAT((ts.hours) ORDER BY ts.working_date ASC) AS group_hours');
		$this->db->from(USER.' as u');
		$this->db->join(USER_ROLE_MAPPING.' as m', 'u.user_id=m.user_id');
		$this->db->join('timecard as tc', 'm.user_id=tc.employee_id', 'left');
		$this->db->join('timesheet as ts', 'tc.timecard_id=ts.timecard_id');
		$this->db->join(PROJECTS.' as p', 'ts.project_id=p.id');
		$this->db->join(SITE.' as s', 'm.site_id=s.site_id', 'left');
		$this->db->join(COST_CENTER.' as c', 'p.cost_center_id=c.cc_id', 'left');

		//$where = 'tc.status = 3 OR tc.status = 2';
		//$this->db->where($where);

		if(!empty($from_date)){
			$this->db->where('ts.working_date >=', $from_date);
		}

		if(!empty($to_date)){
			$this->db->where('ts.working_date <=', $to_date);
		}

		if(!empty($region)){
			$this->db->where('m.region_id', $region);
		}

		if(!empty($site_id)){
			$this->db->where('m.site_id', $site_id);
		}

		if(!empty($role)){
			$this->db->where('m.role_id', $role);	
		}else{
			$this->db->where_in('m.role_id', array(3,4));
		}

		if(!empty($status)){
			$this->db->where_in('tc.status', $status);	
		}else{
			$this->db->where_in('tc.status', array(1,2,3));
		}
		
		if(!empty($project)){
			$this->db->where('ts.project_id', $project);	
		}

		if(!empty($project)){
			$this->db->where('ts.project_id', $project);	
		}

		if(!empty($subtask)){
			$this->db->where('ts.subtask_id', $subtask);	
		}

		if(!empty($employee)){
			$this->db->where('tc.employee_id', $employee);	
		}

		if(!empty($period_closed_hours) && $period_closed_hours=='no'){
			$where = "ts.working_date NOT IN(SELECT day FROM period_closing_dates inner join period_closing using(period_id) WHERE day BETWEEN '$from_date' AND '$to_date' AND region_id=r.region_id )";
			$this->db->where($where);		
		}

		$this->db->group_by('m.user_id, ts.project_id');
		$this->db->order_by('u.user_id');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();

	}

	public function get_all_hours($user_id, $from, $to){
		$this->db->select('SUM(ts.hours) as all_hours, GROUP_CONCAT(ts.working_date) as work_dates');
		$this->db->from('timecard as tc');
		$this->db->join('timesheet as ts', 'tc.timecard_id=ts.timecard_id');
		$this->db->where('tc.employee_id', $user_id);
		$this->db->where ('ts.working_date>=', $from);
		$this->db->where ('ts.working_date<=', $to);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->row();
	}

	public function get_period_closedate($site){
		$this->db->select('from_date, to_date, period_name');
		$this->db->from('period_closing');
		$this->db->where('site_id', $site);
		$this->db->where('status', 2);
		$query = $this->db->get();
		return $query->row();
	}

}