<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function get_user_roles( $user_id )
	{
		$this->db->where(USER_ID, $user_id);
		$this->db->from(USER_ROLE_MAPPING);
		$query = $this->db->get();
		return $query->result();
	}

	public function fetch_data( $user_id )
	{
		
		if( empty($user_id) ) {
			return false;
		}

		$row = $this->db->get_where(USER, array(USER_ID => $user_id))->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	

	public function insert_new_roles( $user_role, $user_id )
	{
		
		if( empty($user_role) ) {
			return false;
		}

		//print_r($user_role); exit();

		foreach ($user_role as $value) {
			$create = array(
				
				ROLE_ID		=>		$value,
				USER_ID		=>		$user_id
			);

			
			$this->db->insert(USER_ROLE_MAPPING, $create);
		}

		return true;
	}	

	public function delete_old_roles( $user_id )
	{
		if( empty($user_id) ) {
			return false;
		}

		$this->db->where(USER_ID, $user_id);
		$delete = $this->db->delete(USER_ROLE_MAPPING);
		if( $this->db->affected_rows() ) {
			return true;
		}	

		return FALSE;
	}	
	
	public function update( $user_first_name, $user_last_name, $user_name, $user_email, $user_id, $user_role, $user_middle_name, $user_portal = '', $employee_id, $supervisor_id = '' )
	{
		
		if( empty($user_name) || empty($user_email) /*|| empty($user_role)*/ ) {
			return false;
		}

		$update = array(
			USER_FIRST_NAME		=>		$user_first_name,
			USER_LAST_NAME		=>		$user_last_name,
			USER_MIDDLE_NAME	=>		$user_middle_name,
			EMPLOYEE_ID         =>      $employee_id,
			SUPERV_ID           => 		$supervisor_id,
			//'username'		=> 		$user_name,
			//'email_id'		=>		$user_email,
			//'role_id'			=>		$user_role,
			UPDATED_ON			=>		date('Y-m-d H:i:s', now())
		);
		
		$result = $this->fetch_data($user_id);
		
		if ( $result->username != $user_name ) {
			if ( $this->check_duplicate( USER, USERNAME, $user_name ) ) {
				$update[USERNAME] = $user_name;
			}
			else {
				return false;
			}
		}

		if ( $result->email_id != $user_email ) {
			if ( $this->check_duplicate( USER, USER_EMAIL, $user_email ) ) {
				$update[USER_EMAIL] = $user_email;	
			}
			else {
				return false;
			}
		}

		$this->db->where(USER_ID, $user_id);  
		$this->db->update(USER, $update);  		
		if( $this->db->affected_rows() ) {
			$this->delete_old_roles($user_id);
			$this->insert_new_roles($user_role, $user_id);
			//echo "<pre>"; print_r($user_portal); exit;
			if(!empty($user_portal)){
				$this->delete_old_portal($user_id);
				$this->insert_new_portal($user_portal, $user_id);
			}

			return true;
		}	
		
		return FALSE;

	}	

	public function insert_new_portal( $user_portal, $user_id )
	{
		
		if( empty($user_portal) ) {
			return false;
		}

		//print_r($user_role); exit();

		foreach ($user_portal as $value) {
			$create = array(
				
				ADMIN_PORTAL_ID		=>		$value,
				ADMIN_USER_ID		=>		$user_id
			);

			
			$this->db->insert(ADMIN_PORTAL, $create);
		}

		return true;
	}	

	public function delete_old_portal( $user_id )
	{
		if( empty($user_id) ) {
			return false;
		}

		$this->db->where(ADMIN_USER_ID, $user_id);
		$delete = $this->db->delete(ADMIN_PORTAL);
		if( $this->db->affected_rows() ) {
			return true;
		}	

		return true;
	}

}