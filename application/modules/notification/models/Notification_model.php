<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends MY_Model {


	public function notification( $user_id = '' )
	{
		$this->db->select('n.*, CONCAT(u.first_name," ",u.last_name) as to_name, CONCAT(u1.first_name," ",u1.last_name) as from_name');
		$this->db->from('notification as n');
		$this->db->join('users as u', 'n.notification_to = u.user_id');
		$this->db->join('users as u1', 'n.notification_from = u1.user_id');
		if(!empty($user_id)){
			$this->db->where('notification_to', $user_id);
		}
		$this->db->order_by('n.notification_id','desc');
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

	public function current_notifications($user_id)
	{
		$this->db->select('*, DATE(created_on) as created_date');
		$this->db->from('notification');
		$this->db->where('notification_to', $user_id);
		$this->db->where('status', 0);
		$query = $this->db->get();

		return $query->result();
		// print_r( $query->result() ); exit();
	}

}