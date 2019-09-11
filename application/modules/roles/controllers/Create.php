<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('create_model');
	}

	

	public function index()
	{

		$data['title'] = "Roles";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|max_length[49]');
			
			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) { 

				if( $inserted_id = $this->create_model->create( $this->input->post('role_name'), $this->input->post('role_description') ) ) {
					//$data['message'] = "Role has been created.";

					//insert in log
					$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Role', 'New Role \''.$this->input->post('role_name').'\' is created' );

					$this->session->set_flashdata('message', '<div class="alert alert-success">Role has been created successfully</div>');
					redirect( 'admin_masters/module_permission/assign_module_permissions/'.$inserted_id );
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to create the role</div>');
					redirect( '/roles/create', $data );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/roles/create', $data );
			}
		}
		else{

			$this->load->view('common/header');
			$this->load->view('create', $data);
			$this->load->view('common/footer');
		}

	}

}