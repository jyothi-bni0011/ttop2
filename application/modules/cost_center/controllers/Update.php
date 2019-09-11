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

		$data['title'] = "Update Cost Center";

		if( count($_POST) ) {
			$this->form_validation->set_rules('cost_center_name', 'Cost Center Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('cost_center_code', 'Cost Center Code', 'trim|required|max_length[49]');
			
			if( $this->form_validation->run() ) {

				$array_cond = array(CC_NAME=>$this->input->post('cost_center_name'), CC_CODE=>$this->input->post('cost_center_code'));
				$array_key = array(CC_ID=>$this->input->post('cost_center_id'));
				
				if ($this->update_model->check_Duplicate_WithOr( COST_CENTER, $array_cond, $array_key )) {

					if( $this->update_model->update( $this->input->post('cost_center_name'), $this->input->post('cost_center_code'), $this->input->post('cost_center_id') ) ) {
						//$data['message'] = "Role has been created.";

						//insert in log
						$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Cost Center', 'Cost Center \''.$this->input->post('cost_center_name').'\' is updated' );

						$this->session->set_flashdata('message', '<div class="alert alert-success">Cost Center has been updated successfully</div>');
						redirect( '/cost_center', $data );
					}
					else {
						//$data['message'] = "Failed to crate the role";
						$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to update the cost center</div>');
						redirect( '/cost_center/update/index/'.$_POST['cost_center_id'] );
					}
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to update the cost center. Cost Center Name/Code Already Exist</div>');
					redirect( '/cost_center/update/index/'.$_POST['cost_center_id'] );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/cost_center/update/index/'.$_POST['cost_center_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$data['cost_center_name'] = $row->{CC_NAME};
				$data['cost_center_id'] = $row->{CC_ID};
				$data['cost_center_code'] = $row->{CC_CODE};
			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}