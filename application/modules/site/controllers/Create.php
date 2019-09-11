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

		$data['title'] = "Sites";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('site_name', 'Site Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('region_id', 'Region ID', 'trim|required');
			$this->form_validation->set_rules('timezone', 'Timezone', 'trim|required');

			if( $this->form_validation->run() ) {
					$site_array = array(
						SITE_NAME => $this->input->post('site_name'),
						SITE_CODE => $this->input->post('site_code'),
						SITE_OWNER => $this->input->post('site_owner'),
						SITE_REG_ID => $this->input->post('region_id'),
						SITE_HRS_WEEK => $this->input->post('workhours_per_week'),
						SITE_TIMEZONE => $this->input->post('timezone'),
						STATUS => '1',
						'cost_center_id' => $this->input->post('cost_center'),
						CREATED_ON => date('Y-m-d H:i:s', now())
					);
					

				if( $inserted_id = $this->create_model->create( $site_array ) ) {
					//$data['message'] = "Role has been created.";

					//insert in log
					$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Site', 'New Site \''.$this->input->post('site_name').'\' is created' );

					$this->session->set_flashdata('message', '<div class="alert alert-success">Site has been created successfully</div>');
					redirect( '/site', $data );
				}
				else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Duplicate Site Name/Code. Failed to create the site</div>');
					redirect( '/site', $data );
				}
			}
			else {
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/site/create', $data );
			}
		}
		else{

			$this->load->view('common/header');
			$this->load->view('create', $data);
			$this->load->view('common/footer');
		}

	}

}