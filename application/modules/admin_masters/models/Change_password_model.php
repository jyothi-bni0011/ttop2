<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password_model extends MY_Model {

	public function check_old_password( $old_password )
	{
		if ( empty( $old_password ) ) {
			return false;
		}

		$user_id = $this->session->userdata('user_id');

		$query = $this->db->select( 'password' )
				 			->where( 'user_id', $user_id )
				 			->from( USER )
				 			->get();

		$result = $query->row();

		if ( md5( $old_password ) === $result->password ) {
			return true;
		}

		return false;

	}

	public function change_password( $password )
	{
		if ( empty( $password ) ) {
			return false;
		}

		$user_id = $this->session->userdata('user_id');

		$update = array(
			USER_PASSWORD	=>	md5($password),
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$this->db->where( USER_ID, $user_id );  
		$this->db->update( USER, $update );  		
		if( $this->db->affected_rows() ) {
			return true;
		}	

		return false;
	}
}