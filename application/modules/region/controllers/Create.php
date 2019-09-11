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

		$data['title'] = "Create Region";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('region_name', 'Region Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('region_code', 'Region Code', 'trim|required|max_length[49]');

			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) {

				if( $inserted_id = $this->create_model->create( $this->input->post('region_name'), $this->input->post('region_code') ) ) {
					//$data['message'] = "Role has been created.";

					//insert in log
					$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Region', 'New Region \''.$this->input->post('region_name').'\' is created' );

					$this->session->set_flashdata('message', '<div class="alert alert-success">Region has been created successfully</div>');
					redirect( '/region', $data );
				}
				else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to create the region. Region Name/Code Already Exist</div>');
					redirect( '/region/create', $data );
				}
			}
			else {
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/region/create', $data );
			}
		}
		else{

			$this->load->view('common/header');
			$this->load->view('create', $data);
			$this->load->view('common/footer');
		}

	}

}