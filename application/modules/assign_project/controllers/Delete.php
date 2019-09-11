<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		$this->load->model('delete_model');
	}

	

	public function index()
	{

		if( count($_POST) ) {
			$old_data = $this->delete_model->getById( ASSIGN_PROJECT, ASSIGN_ID, $_POST['assign_project_id'] );
			if ( $this->delete_model->delete( $_POST['assign_project_id'] ) ) {
				//$data['message'] = "Role deleted successfuly";

				$this->delete_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Assign_project', 'Assign_project \''.$old_data->{ASSIGN_ID}.'\' is deleted' );
			}

			$data = ['success' => 1]; 

			$this->session->set_flashdata('message', "<div class='alert alert-danger'>Assigned Project has been deleted successfully</div>");
					//redirect( '/assign_project/', $data );
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}