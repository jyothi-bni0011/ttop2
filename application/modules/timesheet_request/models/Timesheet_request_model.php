<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timesheet_request_model extends MY_Model {

	public function get_all_submitted_timesheets($user_id){
		$this->db->select('n.*, CONCAT(u.first_name," ",u.last_name) as to_name, CONCAT(u1.first_name," ",u1.last_name) as from_name');
		$this->db->from('notification as n');
		$this->db->join('users as u', 'n.notification_to = u.user_id');
		$this->db->join('users as u1', 'n.notification_from = u1.user_id');
		if(!empty($user_id)){
			$this->db->where('n.notification_from', $user_id);
		}
		$this->db->where('n.request', 'timesheet_edit');
		$this->db->order_by('n.notification_id','desc');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}
	
	public function get_timecard_entries($user_id)
	{
		$this->db->select('*');
		$this->db->from('timecard');
		$this->db->where('employee_id', $user_id);
		$this->db->where_in('status', [2,3]);
		$query = $this->db->get();

		// print_r($query->result()); exit();

		return $query->result();
	}

	public function check_duplicate_request($from,$to,$user_id)
	{
		$this->db->select('*');
		$this->db->from('notification');
		$this->db->where('from_date', $from);
		$this->db->where('to_date', $to);
		$this->db->where('notification_from', $user_id);
		$this->db->where('request', 'timesheet_edit');
		$this->db->where_in('status', [0,1]);
		$query = $this->db->get();

		$rowcount = $query->num_rows();
		// echo "count : ".$rowcount; exit();
		return $rowcount;
	}

	public function create($insert)
	{
		
		$this->db->insert('notification', $insert);
		if( $this->db->affected_rows() ) {
			return $this->db->insert_id();
		}	
		
		
		return FALSE;
	}
}