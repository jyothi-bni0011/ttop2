<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Select_user_role extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('select_user_role_model');
		$this->load->model('login/login_model');
	}

	public function index()
	{

		$data['title'] = "Roles";
		if ($_POST) {
			// print_r( $_POST );exit();
			$this->form_validation->set_rules('user_role', 'Role Name', 'trim|required');
			if ( $this->form_validation->run() ) {
				if( $this->select_user_role_model->select_role( $this->input->post('user_role') ) ) {
					$init_session['region_id'] = $this->input->post('region_id');
					$init_session['site_id'] = $this->input->post('site_id');
					$this->session->set_userdata( $init_session );
					redirect( base_url('dashboard') );
					exit;
				}
			}
		}

		
		$data['roles'] = $this->select_user_role_model->users_roles( $this->session->userdata( 'user_id' ) );
		$data['role_count'] = $this->select_user_role_model->find_distinct_users_roles( $this->session->userdata( 'user_id' ) );
		$data['region_count'] = $this->select_user_role_model->find_distinct_users_region( $this->session->userdata( 'user_id' ) );
		// print_r( $data['role_count'] ); exit();
		$this->load->view('common/header');
		$this->load->view('select_user_role', $data);
		$this->load->view('common/footer');

	}

	public function find_region_site()
	{
		if ( array_key_exists('region_id', $_POST) ) 
		{
			if ( $_POST['region_id'] ) 
			{
				$region_site = $this->select_user_role_model->find_region_site( $_POST['user_id'], $_POST['role_id'], $_POST['region_id'] );	
			}
			else
			{
				$region_site = '';
			}
		}
		else
		{
			$region_site = $this->select_user_role_model->find_region_site( $_POST['user_id'], $_POST['role_id'] );
		}

		$data = ['success' => 1, 'result' => $region_site];
		
		// print_r( $region_site ); exit();
		$this->output
   				->set_content_type('application/json')
   		        ->set_output(json_encode($data));
	}
}