<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('update_model');
		$this->load->model('region/region_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Update Site";

		if( count($_POST) ) {
			$this->form_validation->set_rules('site_name', 'Site Name', 'trim|required|max_length[49]');
			//$this->form_validation->set_rules('site_code', 'Site Code', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('timezone', 'Timezone', 'trim|required');
			
			if( $this->form_validation->run() ) {

				$site_array = array(
					SITE_OWNER => $this->input->post('site_owner'),
					SITE_HRS_WEEK => $this->input->post('workhours_per_week'),
					SITE_TIMEZONE => $this->input->post('timezone'),
					'site_code' => $this->input->post('site_code'),
					'cost_center_id' => $this->input->post('cost_center'),
					UPDATED_ON => date('Y-m-d H:i:s', now())
				);

				if( $this->update_model->update( $site_array, $this->input->post('site_id') ) ) {
					//echo $this->db->last_query(); 
					//$data['message'] = "Role has been created.";

					//insert in log
					$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Site', 'Site \''.$this->input->post('site_name').'\' is updated' );

					$this->session->set_flashdata('message', '<div class="alert alert-success">Site has been updated successfully</div>');
					redirect( '/site', $data );
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Duplicate Site Name/Code. Failed to update the site</div>');
					redirect( '/site/update/index/'.$_POST['site_id'] );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/site/update/index/'.$_POST['site_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$data['site_name'] = $row->{SITE_NAME};
				$data['site_id'] = $row->{SITE_ID};
				$data['site_code'] = $row->{SITE_CODE};
				$data['site_owner'] = $row->{SITE_OWNER};
				$data['site_reg_id'] = $row->{SITE_REG_ID};
				$data['site_cc_id'] = $row->{SITE_CC_ID};
				$data['site_hrs_week'] = $row->{SITE_HRS_WEEK};
				$data['site_timezone'] = $row->{SITE_TIMEZONE};
				$data['status'] = $row->{STATUS};
				$data['regions'] = $this->region_model->region();
				$data['cost_centers'] = $this->region_model->getAll(COST_CENTER);

			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}