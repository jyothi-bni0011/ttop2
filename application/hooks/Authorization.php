<?php

class Authorization {
	
	private $CI;
	
	public function __construct() {
		$this->CI =& get_instance();
	}
	
	public function auth() {
	
		$class 		= ucfirst($this->CI->router->fetch_class());
		$method 	= $this->CI->router->fetch_method();
		$exclude 	= ['Login','Forgot_password','Logout', 'Reset_password'];
		$flag		= 0;
		
		if( in_array($class, $exclude) ) {
			return;
		}
		
		// TODO: Recheck users existance every n minutes
		
		if( ! (int)$this->CI->session->userdata('logged_in') ) {
			redirect('/login');
			exit;
		}

		if (! (int)$this->CI->session->userdata( 'is_associate' ) ) {
			
			if ( ! (int)$this->CI->session->userdata( 'role_id' ) AND strtolower($class) !== 'select_user_role' ) {
				redirect('select_user_role');
				exit;
			}
		}

		if ( $class == 'Select_user_role' ) {
			return true;
		}

		//Restrict user from using unassigned urls
		// foreach ( $this->CI->session->userdata( 'menu' ) as $menu ) {
		// 	if ( $class == ucfirst( $menu->{MENU_CONTROLLER} ) ) {
		// 		$flag = 1;
		// 	}
		// 	if ( ucfirst( $menu->{MENU_CONTROLLER} ) == 'Roles' AND $class == 'Module_permission' ) {
		// 		$flag = 1;
		// 	}			
		// }

		// if ( $flag == 0 ) {
		// 	redirect('/dashboard');
		// }

		//Restrict user from using unassigned urls END
		
	}
	
}