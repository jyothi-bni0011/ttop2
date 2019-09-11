<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('update_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Update Region";

		if( count($_POST) ) {
			$this->form_validation->set_rules('region_name', 'Region Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('region_code', 'Region Code', 'trim|required|max_length[49]');
			
			if( $this->form_validation->run() ) {

				$array_cond = array(REG_NAME=>$this->input->post('region_name'), REG_CODE=>$this->input->post('region_code'));
				$array_key = array(REG_ID=>$this->input->post('region_id'));
				
				if ($this->update_model->check_Duplicate_WithOr( REGION, $array_cond, $array_key )) {
					if( $this->update_model->update( $this->input->post('region_name'), $this->input->post('region_code'), $this->input->post('region_id') ) ) {
						//$data['message'] = "Role has been created.";

						//insert in log
						$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Region', 'Region \''.$this->input->post('region_name').'\' is updated' );

						$this->session->set_flashdata('message', '<div class="alert alert-success">Region has been updated successfully</div>');
						redirect( '/region', $data );
					}
					else {
						//$data['message'] = "Failed to crate the role";
						$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to update the region. Region Name Already Exist</div>');
						redirect( '/region/update/index/'.$_POST['region_id'] );
					}
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to update the region. Region Name/Code Already Exist</div>');
					redirect( '/region/update/index/'.$_POST['region_id'] );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/region/update/index/'.$_POST['region_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$data['region_name'] = $row->{REG_NAME};
				$data['region_id'] = $row->{REG_ID};
				$data['region_code'] = $row->{REG_CODE};
			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}