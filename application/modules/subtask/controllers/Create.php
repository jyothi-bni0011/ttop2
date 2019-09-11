<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('create_model');
		$this->load->model('region/Region_model');
		$this->load->model('login/login_model');
		$this->load->model('project/project_model');
	}

	

	public function index()
	{

 		$data['title'] = "Create Sub Task";

		if( count($_POST) ) { 
			
			$this->form_validation->set_rules('project_id', 'Project', 'trim|required');
			$this->form_validation->set_rules('subtask_name', 'Project Name', 'trim|required');
			$this->form_validation->set_rules('estimated_hours', 'Estimated Subtask', 'trim|required');
			
			if( $this->form_validation->run() ) { //echo "<pre>!!"; print_r($this->input->post('project_id')); exit;
					$subtask_array = array(
						SUBTASK_NAME => $this->input->post('subtask_name'),
						SAP_NUMBER => $this->input->post('sap_number'),
						SUB_PROJECT_ID => $this->input->post('project_id'),
						SUBTASK_HOURS	 => $this->input->post('estimated_hours'),
						CREATED_BY => $this->session->userdata('user_id'),
						STATUS => '1',
						CREATED_ON => date('Y-m-d H:i:s', now())
					);
					
				if( $inserted_id = $this->create_model->create( $subtask_array ) ) {
					//$data['message'] = "Role has been created.";

					//insert in log
					$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Subtask', 'New Subtask \''.$this->input->post('subtask_name').'\' is created' );

					$this->session->set_flashdata('message', '<div class="alert alert-success">Subtask has been created successfully</div>');
					redirect( '/subtask', $data );
				}
				else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to create the subtask. Subtask Name is already exist.</div>');
					redirect( '/subtask', $data );
				}
			}
			else {
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/subtask', $data );
			}
		}
		else{
			$user_id = $this->session->userdata('user_id');
			$data['userdata']=$this->login_model->get_userdata($user_id);
			$data['regions']=$this->Region_model->region();
			if($this->session->userdata('role_id') != 1){
				$region_id = $this->session->userdata('region_id');
				$site_id = $this->session->userdata('site_id');
			}else{
				$region_id = '';
				$site_id = '';
			}	
			$data['projects']=$this->project_model->get_projects($region_id, $site_id, 'global');	
			$this->load->view('common/header');
			$this->load->view('create',$data);
			$this->load->view('common/footer');
			
		}

	}

}