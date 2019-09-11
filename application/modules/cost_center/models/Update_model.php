<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $cost_center_id )
	{
		
		if( empty($cost_center_id) ) {
			return false;
		}

		$row = $this->db->get_where(COST_CENTER, array(CC_ID => $cost_center_id))->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $cost_center_name, $cost_center_code, $cost_center_id )
	{
		
		if( empty($cost_center_name)  || empty($cost_center_code) || empty($cost_center_id) ) {
			return false;
		}

		$update = array(
			CC_NAME	=>	$cost_center_name,
			CC_CODE	=>	$cost_center_code,
			//'role_alice_name'	=> (int)$department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->fetch_data( $cost_center_id );
		
		if ( $result->cost_center_name != $cost_center_name ) {
			if ($this->check_duplicate( COST_CENTER, CC_NAME, $cost_center_name )) {
				$update[CC_NAME] = $cost_center_name;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where(CC_ID, $cost_center_id);  
		$this->db->update(COST_CENTER, $update);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;

	}	

}