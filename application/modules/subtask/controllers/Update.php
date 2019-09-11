<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('update_model');
		$this->load->model('project/project_model');
		$this->load->model('login/login_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Update Subtask";
		
		if( count($_POST) ) {
			$this->form_validation->set_rules('subtask_name', 'Subtask Name', 'trim|required');
			
			if( $this->form_validation->run() ) {
				$array_cond = array(SUBTASK_NAME => $this->input->post('subtask_name'), SUB_PROJECT_ID=>$this->input->post('project_id'));
				$array_key = array(SUBTASK_ID=>$this->input->post('subtask_id'));

				if ($this->update_model->check_duplicate_on_multiCol( SUBTASK, $array_cond, $array_key )) {

					$subtask_array = array(
						SUBTASK_NAME => $this->input->post('subtask_name'),
						sap_number => $this->input->post('sap_number'),
						SUBTASK_HOURS => $this->input->post('estimated_hours'),
						SUB_PROJECT_ID => $this->input->post('project_id'),
						STATUS => $this->input->post('status'),
						UPDATED_ON => date('Y-m-d H:i:s', now())
					);
					
					if( $this->update_model->update( $subtask_array, $this->input->post('subtask_id') ) ) {
						//$data['message'] = "Role has been created.";

						//insert in log
						$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Subtask', 'subtask \''.$this->input->post('project_name').'\' is updated' );

						$this->session->set_flashdata('message', '<div class="alert alert-success">Subtask has been updated successfully</div>');
						redirect( '/subtask', $data );

					} else {
						//$data['message'] = "Failed to crate the role";
						$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to update the subtask</div>');
						redirect( '/subtask/update/index/'.$_POST['subtask_id'] );
					}

				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Duplicate Subtask. Failed to update the subtask</div>');
					redirect( '/subtask/update/index/'.$_POST['subtask_id'] );
				}

			} else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/subtask/update/index/'.$_POST['subtask_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$user_id = $this->session->userdata('user_id');
				$userdata = $this->login_model->get_userdata($user_id);
				$data['projects']=$this->project_model->get_projects($userdata->region_id, $userdata->site_id, 'global');

				$data['subtask_id'] = $row->{SUBTASK_ID};
				$data['subtask_name'] = $row->{SUBTASK_NAME};
				$data['sap_number'] = $row->{SAP_NUMBER};
				$data['project_id'] = $row->{SUB_PROJECT_ID};
				$data['estimated_hours'] = $row->{SUBTASK_HOURS};
				$data['created_by'] = $row->{CREATED_BY};
				$data['status'] = $row->{STATUS};
				$data['project_reg_id'] = $row->reg_id;
				$data['project_site_id'] =  $row->site_id;
				$data['project_site_name'] = $row->site_name;
				$data['project_reg_name'] = $row->region_name;
				
			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}