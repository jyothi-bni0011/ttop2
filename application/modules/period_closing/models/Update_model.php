<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $period_id )
	{
		
		if( empty($period_id) ) {
			return false;
		}

		$row = $this->db->get_where('period_closing', array('period_id' => $period_id))->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $update_array, $period_id )
	{
		
		$result = $this->fetch_data( $period_id );
		
		//print_r($update); exit();
		$this->db->where('period_id', $period_id);  
		$this->db->update('period_closing', $update_array);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		return FALSE;

	}	

}