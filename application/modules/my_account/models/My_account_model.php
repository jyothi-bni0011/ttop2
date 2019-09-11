<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_account_model extends MY_Model {

	

	public function update( $update_array, $user_id )
	{

		$this->db->where('user_id', $user_id);  
		$this->db->update('users', $update_array);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		return FALSE;

	}	

}