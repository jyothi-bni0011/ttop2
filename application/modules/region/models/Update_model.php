<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $region_id )
	{
		
		if( empty($region_id) ) {
			return false;
		}

		$row = $this->db->get_where(REGION, array(REG_ID => $region_id))->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $region_name, $region_code, $region_id )
	{
		
		if( empty($region_name)  || empty($region_code) || empty($region_id) ) {
			return false;
		}

		$update = array(
			REG_NAME	=>	$region_name,
			REG_CODE	=>	$region_code,
			//'role_alice_name'	=> (int)$department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$this->db->where(REG_ID, $region_id);  
		$this->db->update(REGION, $update);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;

	}	

}