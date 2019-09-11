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
		$this->load->model('users/users_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Update Project";
		
		if( count($_POST) ) {
			$this->form_validation->set_rules('sap_id', 'Project ID / SAP Number', 'trim|required');
			$this->form_validation->set_rules('project_name', 'Project Name', 'trim|required|max_length[150]');
			$this->form_validation->set_rules('project_type', 'Project Type', 'trim|required');
			$this->form_validation->set_rules('explicite_subtask', 'Project Explicite', 'trim|required');
			
			if( $this->form_validation->run() ) {
				$array_cond = array(SAP_NO=>$this->input->post('sap_id'), PROJECT_NAME=>$this->input->post('project_name'));
				$array_key = array(PROJECT_ID=>$this->input->post('project_id'));
				
				if ($this->update_model->check_Duplicate_WithOr( PROJECTS, $array_cond, $array_key )) {
					$supervisor_id = ($this->input->post('project_type') != 'site') ? '' : $this->input->post('supervisor_id');
					//echo "<pre>"; print_r($this->input->post()); exit;
					$project_array = array(
						SAP_NO => $this->input->post('sap_id'),
						PROJECT_NAME => $this->input->post('project_name'),
						PROJECT_DESCRIPTION => $this->input->post('project_description'),
						PROJECT_BUDGET => $this->input->post('project_budget'),
						PROJECT_EXP_SUBTASK => $this->input->post('explicite_subtask'),
						PROJECT_TYPE =>$this->input->post('project_type'),
						SUPERVISOR_ID =>$supervisor_id,
						PROJECT_START_DATE => $this->input->post('start_date'),
						PROJECT_END_DATE => $this->input->post('end_date'),
						STATUS => $this->input->post('status'),
						'project_owner' => $this->input->post('owner'),
						//'cost_center_id' => $this->input->post('cost_center'),
						UPDATED_ON => date('Y-m-d H:i:s', now())
					);
					
					if( $this->update_model->update( $project_array, $this->input->post('project_id') ) ) {
						//$data['message'] = "Role has been created.";

						//insert in log
						$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Project', 'Project \''.$this->input->post('project_name').'\' is updated' );

						$this->session->set_flashdata('message', '<div class="alert alert-success">Project has been updated successfully</div>');
						redirect( '/project', $data );
					}
					else {
						//$data['message'] = "Failed to crate the role";
						$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to update the project</div>');
						redirect( '/project/update/index/'.$_POST['project_id'] );
					}
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Duplicate SAP No/Project Name. Failed to update the project</div>');
						redirect( '/project', $data );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/project/update/index/'.$_POST['project_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {
				//	echo "<pre>"; print_r($row); exit;
				$user_id = $this->session->userdata('user_id');
				$userdata = $this->login_model->get_userdata($user_id);
				$data['supervisordata'] = $this->users_model->get_rolewise_users('3', $this->session->userdata('site_id'));

				$data['userdata'] = $this->login_model->get_userdata($user_id);

				$data['project_id'] = $row->{PROJECT_ID};
				$data['sap_no'] = $row->{SAP_NO};
				$data['project_name'] = $row->{PROJECT_NAME};
				$data['project_description'] = $row->{PROJECT_DESCRIPTION};
				$data['project_budget'] = $row->{PROJECT_BUDGET};
				$data['project_site_id'] = $row->{PROJECT_SITE_ID};
				$data['project_reg_id'] = $row->reg_id;
				$data['project_site_name'] = $row->site_name;
				$data['project_reg_name'] = $row->region_name;
				$data['exp_subtask'] = $row->{PROJECT_EXP_SUBTASK};
				$data['project_type'] = $row->{PROJECT_TYPE};
				$data['start_date'] = $row->{PROJECT_START_DATE};
				$data['end_date'] = $row->{PROJECT_END_DATE};
				$data['created_by'] = $row->{PROJECT_CREATED_BY};
				$data['status'] = $row->{STATUS};
				$data['supervisor_id'] = $row->{SUPERVISOR_ID};
				$data['owner'] = $row->project_owner;
				$data['selected_cost_center'] = $row->cost_center_id;
				//$data['selected_region'] = $this->update_model->get_region_by_site( $row->{PROJECT_SITE_ID} );
				$data['site_list'] = $this->update_model->getByIdAll( 'site', 'region_id', $row->reg_id );
				//echo "<pre>"; print_r($data['site_list']); exit;
			}
		}
		$data['regions'] = $this->users_model->getAll('region');
		$data['cost_centers'] = $this->users_model->getAll(COST_CENTER);
		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}