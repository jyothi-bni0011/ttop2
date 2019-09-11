<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region_model extends MY_Model {


	public function region( )
	{
		$this->db->select('*');
		$this->db->from(REGION);
		//$this->db->where('status',1);
		$query = $this->db->get();
		return $query->result();
	}	

}