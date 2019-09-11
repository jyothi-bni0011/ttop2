<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $site_id )
	{
		
		if( empty($site_id) ) {
			return false;
		}

		$row = $this->db->get_where(SITE, array(SITE_ID => $site_id))->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $site_array, $site_id )
	{
		
		if( empty($site_array['timezone']) ) {
			return false;
		}
		
		//print_r($site_array); exit();

		if( !empty($site_array['site_code'])) { 

			$cond_array = array(SITE_CODE => $site_array['site_code']);
			$id_array = array(SITE_ID => $site_id);
			if ($this->check_duplicate_on_multiCol( SITE, $cond_array, $id_array)) { 
				$this->db->where(SITE_ID, $site_id);  
				$this->db->update(SITE, $site_array);  		
				if( $this->db->affected_rows() ) {
					return true;
				}	
			}

		} else {
			
			$this->db->where(SITE_ID, $site_id);  
			$this->db->update(SITE, $site_array);  		
			if( $this->db->affected_rows() ) {
				return true;
			}	
		}

		
		
		return FALSE;

	}	

}