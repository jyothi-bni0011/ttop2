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

		$data['title'] = "Create Cost Center ";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('cost_center_name', 'Cost Center Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('cost_center_code', 'Cost Center Code', 'trim|required|max_length[49]');

			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) {

				if( $inserted_id = $this->create_model->create( $this->input->post('cost_center_name'), $this->input->post('cost_center_code') ) ) {
					//$data['message'] = "Role has been created.";

					//insert in log
					$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Cost Center', 'New Cost Center \''.$this->input->post('cost_center_name').'\' is created' );

					$this->session->set_flashdata('message', '<div class="alert alert-success">Cost Center has been created successfully</div>');
					redirect( '/cost_center', $data );
				}
				else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to create the cost center. Cost Center Name/Code Already Exist</div>');
					redirect( '/cost_center/create', $data );
				}
			}
			else {
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/cost_center/create', $data );
			}
		}
		else{

			$this->load->view('common/header');
			$this->load->view('create', $data);
			$this->load->view('common/footer');
		}

	}

}