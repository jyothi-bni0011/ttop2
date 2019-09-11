<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_model extends MY_Model {


	public function site( )
	{
		$this->db->select('s.*, r.region_name, c.cost_center_name');
		$this->db->from(SITE .' as s');
		$this->db->join(REGION .' as r', 's.region_id = r.reg_id');
		$this->db->join(COST_CENTER .' as c', 'c.cc_id = s.cost_center_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_sites( $reg_id = "" ){
		$this->db->select('*');
		$this->db->from(SITE);
		$this->db->where('region_id', $reg_id);
		$this->db->where('status', '1');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}

	public function get_site_name( $site_id = "" ){
		$this->db->select('site_name');
		$this->db->from(SITE);
		$this->db->where('site_id', $site_id);
		$this->db->where('status', '1');
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->row();
	}

}