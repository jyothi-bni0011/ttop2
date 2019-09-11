<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_model extends MY_Model {

	/*public function check_duplicate($role_name)
	{
		$this->db->where('role_name', $role_name);
		$res = $this->db->get('role');
		if (count($res->result()) == 0) {
			return true;
		}
		else {
			return false;
		}
	}*/

	public function create( $period_closing_array )
	{
		
		if( empty($period_closing_array['period_name']) ) {
			return false;
		}

		if ($this->check_duplicate_on_multiCol( 'period_closing', array('period_name'=>$period_closing_array['period_name'], 'from_date'=>$period_closing_array['from_date']) )) { 
			$this->db->insert('period_closing', $period_closing_array);
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		}
		

		return FALSE;

	}	

	public function check_period_alreadyexist($date, $region){
		$this->db->select('*');
		$this->db->from('period_closing as p');
		$this->db->join('period_closing_dates as pd', 'p.period_id = pd.period_id');
		$this->db->where('p.region_id', $region);
		$this->db->where('pd.day', $date);

		$query = $this->db->get();
		return $rowcount = $query->num_rows();
	}

}