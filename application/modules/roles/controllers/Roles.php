<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('roles_model');
	}

	

	public function index()
	{

		$data['title'] = "Manage Roles";
		
		$data['roles'] = $this->roles_model->roles();

		$this->load->view('common/header');
		$this->load->view('roles',$data);
		$this->load->view('common/footer');
	}

	public function change_status()
	{
		if ( ! empty( $_POST['where'] ) || ! empty( $_POST['table'] ) || ! isset( $_POST['value'] ) || ! empty( $_POST['column'] ) ) 
		{
			if ( $this->roles_model->change_status( $_POST['table'], $_POST['column'], $_POST['where'], $_POST['value'] ) ) 
			{
				
				$data = ['success' => 1]; 
			
				$this->output
					->set_content_type('application/json')
			        ->set_output(json_encode($data));		
			}
		}
	}
}