<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Period_closing_model extends MY_Model {


	public function period_closing( )
	{
		$this->db->select('p.*, r.region_name, p.region_id');
		$this->db->from('period_closing as p');
		$this->db->join('region as r', 'p.region_id=r.reg_id', 'inner');
		//$this->db->where('p.region_id', $this->session->userdata('region_id'));
		$query = $this->db->get();
		return $query->result();
	}	

	public function check_period_closed($date, $region='', $from_timesheet = ''){
		$this->db->select('p.from_date, p.to_date, p.status');
		$this->db->from('period_closing as p');
		$this->db->join('period_closing_dates as pd', 'p.period_id = pd.period_id');

		$this->db->where('pd.day', $date);

		if(!empty($from_timesheet)){
			//$this->db->where('p.region_id', $region);
			//$this->db->where('p.status','2'); //2 - closed
		}
		//if$from_dash
		
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
			return $query->row();
		}
	}

}