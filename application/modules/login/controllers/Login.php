<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('login_model');
	}
	
	public function index() 
	{

		if( (int)$this->session->userdata('logged_in') ) {
			redirect('/dashboard');
			exit;
		}
		
		$this->data['message'] = "";
		if( count($_POST) ) 
		{
				
			$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[49]');
			if( $this->form_validation->run() ) 
			{
		
				$data['username']	= $this->input->post('username');
				$data['email_id']	= $this->input->post('username');
				if( $user = $this->login_model->user( $data ) ) {

					//For checking valid username and password 
					if ((strtolower($this->input->post('username')) == strtolower($user->username) || strtolower($this->input->post('username')) == strtolower($user->email_id)) && md5($this->input->post('password')) == $user->password){
						if(! (int)$user->is_firsttime){
							redirect(base_url('reset_password/index/' . $user->user_id));
							exit;
						} 
					} else {
						$this->data['message'] = '<div class="alert alert-success text-center" style="color: red;font-size:15px;">Invalid username or password.</div>';
						//$this->load->view('login', $this->data);
					}
					//End
						
					if ( $this->login_model->authenticate( $this->input->post('username'), $this->input->post('password')/*, (int)$this->input->post('user_role')*/ ) ) {
						
						//Insert Log 
						$this->login_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Login','\''. $this->session->userdata('username').'\' is logged in' );

						if ( $this->session->userdata( 'role_id' ) ) {
							redirect( base_url('dashboard') );
							exit;

						}
						else {
							redirect( base_url('select_user_role').'?from=login' );
						}
						
					}
					else {
						$this->data['message'] = '<div class="alert alert-success text-center" style="color: red;font-size:15px;">Unable to authenticate user. Please try again after sometime.</div>';
					}
		
				}
				else {
					$this->data['message'] = '<div class="alert alert-success text-center" style="color: red;font-size:15px;">Invalid username or password.</div>';
				}
			}
			else {
				$this->data['message'] = validation_errors();
			}
		}
		
		$this->data['roles'] = $this->login_model->get_roles();
		$this->load->view('login', $this->data);
	}
}