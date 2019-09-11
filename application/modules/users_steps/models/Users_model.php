<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends MY_Model {


	public function users( $role_ids, $conditional = array() ) // to fetch specific role users
	{
		/*$this->db->select('users.*, role.role_name');
		$this->db->from('users');
		$this->db->join('role', 'role.role_id = users.role_id', 'left');
		$query = $this->db->get();
		return $query->result();*/

/*		$this->db->select('*');
		$this->db->from('users');
		$query = $this->db->get();
		return $query->result();*/
		
		$this->db->select('users_role_mapping.*, role.role_name, users.*, GROUP_CONCAT(users_role_mapping.role_id SEPARATOR ",") as user_roles');
		$this->db->from('users_role_mapping');
		$this->db->join('role', 'role.role_id = users_role_mapping.role_id', 'left');
		$this->db->join('users', 'users.user_id = users_role_mapping.user_id', 'right');

		if(!empty($conditional)){
			foreach($conditional as $key=>$value){
				$this->db->where($key, $value);	
			}
		}
		if(!empty($role_ids)){
			$this->db->where_in('users_role_mapping.role_id', $role_ids);
		}
		$this->db->group_by('users.user_id');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
		//echo "<pre>";
		//print_r($query->result()); exit();
	}

	public function get_user_portal( $user_id )
	{
		$this->db->select('p.portal_id, p.portal_name');
		$this->db->from(PORTAL. ' as p');
		$this->db->join(ADMIN_PORTAL. ' as a', 'a.portal_id = p.portal_id') ;
		if(!empty($user_id)){
			$this->db->where('a.user_id', $user_id);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function get_rolewise_users( $role_id='', $site_id='' ){
		$this->db->select('u.user_id, CONCAT(u.first_name," ",u.last_name) as name');
		$this->db->from(USER. ' as u');
		$this->db->join(USER_ROLE_MAPPING. ' as m', 'u.user_id = m.user_id') ;
		if(!empty($role_id)){
			$this->db->where('m.role_id', $role_id);
		}
		$site_ar = explode(',',$site_id);
		if(!empty($site_id)){
			//$this->db->where('u.site_id', $site_id);
			$this->db->where_in('u.site_id', $site_ar);
		}

		$query = $this->db->get();
		return $query->result();
	}

	public function getSupervisors($site_array = array()){
		$this->db->select('CONCAT(u.first_name," ",u.last_name) as name, u.user_id, u.status, u.site_id');
		$this->db->from(USER.' as u');
		$this->db->join(USER_ROLE_MAPPING. ' as m', 'u.user_id = m.user_id' );
		$this->db->where('m.role_id', 3);
		$this->db->where('u.status', 1);
		$this->db->where_in('u.site_id', $site_array);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result();
	}

	
	public function shift_notifications( $change_from, $change_to )
	{
		$data = [
			'notification_to' => $change_to
		];
		 // echo "  in shift ".$change_from.'   '. $change_to;
		$this->db->where('notification_to', $change_from);
		$this->db->where('status', 0);
        $this->db->update('notification', $data);

        if ( $this->db->affected_rows() ) 
        {
        	return true;	
        }
        return false;
	}
}