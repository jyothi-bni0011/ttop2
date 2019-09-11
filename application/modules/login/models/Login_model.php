<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends MY_Model {

	public function get_roles()
	{
		$this->db->select('*');
		$this->db->from('role');
		$query = $this->db->get();
		return $query->result();
	}

	public function users_roles( $user_id )
	{
		$this->db->select( 'users_role_mapping.*, role.role_name, users.user_id' );
		$this->db->from( 'users_role_mapping' );
		$this->db->join( 'role', 'role.role_id = users_role_mapping.role_id' );
		$this->db->join( 'users', 'users.user_id = users_role_mapping.user_id' );
		$this->db->where( 'users_role_mapping.user_id', $user_id );
		$query = $this->db->get();
		return $query->result();
	}	

	public function user( $user )
	{

		if( empty($user) AND count($user) ) {
			return false;
		}

		if(array_key_exists('user_id', $user))  $where['user_id']  = (int)$user['user_id'];
		if(array_key_exists('email_id', $user)) $where['email_id'] = $user['email_id'];
		if(array_key_exists('username', $user)) $where['username'] = $user['username'];

		$this->db->select('*')
			->from('users');

		foreach ($where as $key => $value) {
			$this->db->or_where( $key, $value );
		}

		$result = $this->db->get();
		return $result->row();

	}

	public function role_info( $value )
	{
		$this->db->where( 'role_id', $value );
		$result = $this->db->get('role');

		return $result->row();		
	}

	public function models_assigned_to_user($role_id)
	{
		$this->db->select( '*' );
		$this->db->from( ROLE_MENU_MAPPING );
		$this->db->join( ROLE_MENU, sprintf( '%s.%s = %s.%s', ROLE_MENU_MAPPING, MENU_ID, ROLE_MENU, MENU_ID ) );
		$this->db->where( sprintf('%s.%s', ROLE_MENU_MAPPING, ROLE_ID), $role_id );
		$this->db->order_by('role_menu.menu_sequence', "asc");
		$result = $this->db->get();
		return $result->result();
		
	}

	public function authenticate( $username, $password )
	{
		
		if( empty($username) || empty($password) ) {
			return false;
		}

		$data['username']	= $this->input->post('username');
		$data['email_id']	= $this->input->post('username');

		$user = $this->user( $data );
		if( $user ) { 

			if( $user->password !== md5($password) ||  $user->status == 2) {
				return false;
			}

			$init_session = array(
				'user_id' 		=> $user->user_id,
				'username' 		=> $user->username,
				'full_name'		=> sprintf('%s %s %s', $user->first_name, $user->middle_name, $user->last_name),
				'email_id' 		=> $user->email_id,
				'supervisor_id' => $user->supervisor_id,
				// 'site_id'		=> $user->site_id,
				'status'		=> $user->status,
				'is_firsttime'	=> $user->is_firsttime,
				'logged_in'		=> 1,
				'profile_pic'	=> $user->profile_pic,
				'logged_time'	=> date('Y-m-d H:i:s', now())
			);

			if( $role = $this->users_roles( $user->user_id ) ) {
				if ( count($role) <= 1 ) {
					$init_session['role_id'] = $role[0]->role_id;
					$init_session['role_name'] = $role[0]->role_name;
					$init_session['region_id'] = $role[0]->region_id;
					$init_session['site_id'] = $role[0]->site_id;

					$init_session['total_roles'] = 1;
					if( $menu = $this->models_assigned_to_user( $role[0]->role_id ) ) 
					{
						$init_session['menu'] = $menu;
					}
					else 
					{
						$init_session['menu'] = [];
					}
				}
			}
			else {
				return false;
			}
			
			$this->session->set_userdata( $init_session );
			
			return true;
		}

		return false;

	}

	public function updatepassword($email,$password)

	{

		$pwddata = array('password' => $password);
		$this->db->from('users');
		$this->db->where('email_id',$email);
		$this->db->update('users', $pwddata);
		return true;

	}

	public function get_userdata($user_id, $region_id = '', $site_id = ''){
		$this->db->select('u.*,r.region_name,m.region_id, s.cost_center_id, s.site_id, s.site_name');
		$this->db->from(USER.' as u'); 
		$this->db->join(USER_ROLE_MAPPING. ' as m', 'u.user_id = m.user_id' );
		$this->db->join(SITE. ' as s', 'm.site_id = s.site_id', 'left');
		$this->db->join(REGION. ' as r', 'm.region_id = r.reg_id', 'left');
		$this->db->where('u.user_id',$user_id);
		if(!empty($region_id)){
			$this->db->where('m.region_id',$region_id);	
		}
		if(!empty($site_id)){
			$this->db->where('m.site_id',$site_id);
		}
		
		$query = $this->db->get();
		return $query->row();
	}

}
