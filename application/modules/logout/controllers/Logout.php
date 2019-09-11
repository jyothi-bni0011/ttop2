<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MX_Controller {
	
	public function __construct() {
		parent::__construct();
		// Load session library
		$this->load->model('login/login_model');
		$this->load->library('session');
	}

	public function index() {
		//Insert Log 
		$this->login_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Logout','\'' . $this->session->userdata('username').'\' is logged out' );
		
		//destroy session
    	$this->session->sess_destroy();
		
		redirect('/');
	}
}
?>