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

	public function create( $site_array )
	{  //echo "<pre>"; print_r($site_array); exit;
		
		if( empty($site_array['site_name'])) { 
			return false;
		}

		if( !empty($site_array['site_code'])) { 

			$cond_array = array(SITE_NAME=>$site_array['site_name'], SITE_CODE=>$site_array['site_code']);
		} else{
			
			$cond_array = array(SITE_NAME=>$site_array['site_name']);
		}

		//print_r($cond_array); exit; 
		
		//if ($this->check_duplicate( SITE, SITE_NAME, $site_array['site_name'] )) { 
		if ($this->check_Duplicate_WithOr( SITE, $cond_array)) { 
			$this->db->insert(SITE, $site_array);
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		}
		
		return FALSE;

	}	

}