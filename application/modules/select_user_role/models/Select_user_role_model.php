<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Select_user_role_model extends CI_Model {


	public function users_roles( $user_id )
	{
		$this->db->select( 'users_role_mapping.*, role.role_name, users.user_id' );
		$this->db->from( 'users_role_mapping' );
		$this->db->join( 'role', 'role.role_id = users_role_mapping.role_id' );
		$this->db->join( 'users', 'users.user_id = users_role_mapping.user_id' );
		$this->db->where( 'users_role_mapping.user_id', $user_id );
		$this->db->order_by( 'role.sequence',  'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function find_distinct_users_roles( $user_id )
	{
		$this->db->distinct();
		$this->db->select( 'users_role_mapping.role_id' );
		$this->db->from( 'users_role_mapping' );
		// $this->db->join( 'role', 'role.role_id = users_role_mapping.role_id' );
		// $this->db->join( 'users', 'users.user_id = users_role_mapping.user_id' );
		$this->db->where( 'users_role_mapping.user_id', $user_id );
		$query = $this->db->get();
		return $query->result();
	}	

	public function find_distinct_users_region( $user_id )
	{
		$this->db->distinct();
		$this->db->select( 'users_role_mapping.region_id' );
		$this->db->from( 'users_role_mapping' );
		// $this->db->join( 'role', 'role.role_id = users_role_mapping.role_id' );
		// $this->db->join( 'users', 'users.user_id = users_role_mapping.user_id' );
		$this->db->where( 'users_role_mapping.user_id', $user_id );
		$query = $this->db->get();
		return $query->result();
	}
	public function select_role( $role_id )
	{
		if ( empty($role_id) ) {
			return false;
		}

		$this->db->where( 'role_id', $role_id );
		$result = $this->db->get( 'role' );
		$role = $result->row();
		
		$init_session['role_id'] = $role->role_id;
		$init_session['role_name'] = $role->role_name;

		if( $menu = $this->login_model->models_assigned_to_user( $role->role_id ) ) 
		{
			$init_session['menu'] = $menu;
		}
		else 
		{
			$init_session['menu'] = [];
		}

		$this->session->set_userdata( $init_session );

		return true;
	}

	public function find_region_site($user_id, $role_id, $region=0)
	{
		$this->db->select('users_role_mapping.*, region.region_name, site.site_name');
		$this->db->from('users_role_mapping');
		$this->db->join('region', 'region.reg_id = users_role_mapping.region_id', 'left');
		$this->db->join('site', 'site.site_id = users_role_mapping.site_id', 'left');
		$this->db->where('users_role_mapping.user_id', $user_id);
		$this->db->where('users_role_mapping.role_id', $role_id);
		if ( $region )
		{
			$this->db->where('users_role_mapping.region_id', $region);
		}
		else
		{
			$this->db->group_by('users_role_mapping.region_id');
		}
		$query = $this->db->get();
		return $query->result();
	}
}