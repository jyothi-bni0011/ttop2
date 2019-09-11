<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cost_center_model extends MY_Model {


	public function cost_center( )
	{
		$this->db->select('*');
		$this->db->from(COST_CENTER);
		$query = $this->db->get();
		return $query->result();
	}	

}