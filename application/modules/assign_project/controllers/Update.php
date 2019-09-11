<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('update_model');
		$this->load->model('users/Users_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Update Assigned Project";

		if( count($_POST) ) {
			$this->form_validation->set_rules('project_type', 'Project Type', 'trim|required');
			$this->form_validation->set_rules('project_name', 'Project Name', 'trim|required');
			
			if( $this->form_validation->run() ) {

				$check_exist = $this->update_model->check_duplicate_on_multiCol( ASSIGN_PROJECT, array(ASSIGN_USER_ID => $this->input->post('user_name'), ASSIGN_PROJECT_ID => $this->input->post('project_name')), array( ASSIGN_ID => $this->input->post('assign_project_id')) );
				if($check_exist){
					$project_array = array(
						ASSIGN_PROJECT_ID => $this->input->post('project_name'),
						ASSIGN_USER_ID	=>	$this->input->post('user_name'),
						START_DATE => $this->input->post('start_date'),
						END_DATE => $this->input->post('end_date'),
						SUBTASK_IDS => !empty($this->input->post('subtask_id')) ? json_encode($this->input->post('subtask_id')) : '',
						ASSIGN_PROJECT_BY => $this->session->userdata('user_id'),
						UPDATED_ON => date('Y-m-d H:i:s', now())
					);

					if( $this->update_model->update( $project_array, $this->input->post('assign_project_id') ) ) {
						//$data['message'] = "Role has been created.";

						//insert in log
						$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Assign Project', 'Assign Project \''.$this->input->post('region_name').'\' is updated' );

						$this->session->set_flashdata('message', '<div class="alert alert-success">Assigned Project has been updated successfully</div>');
						redirect( '/assign_project', $data );
					}
					else {
						//$data['message'] = "Failed to crate the role";
						$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to update the Project Assignment</div>');
						redirect( '/assign_project/update/index/'.$_POST['region_id'] );
					}
				} else {
					$this->session->set_flashdata('message', "<div class='alert alert-danger'>Project is Already Assigned to selected user</div>");
					redirect( '/assign_project', $data );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/assign_project/update/index/'.$_POST['region_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {
				// echo "<pre>"; print_r($row); exit;
				$data['assign_id'] = $row->id;
				$data['assign_project_id'] = $row->project_id;
				$data['assign_project_name'] = $row->project_name;
				$data['assign_project_type'] = $row->project_type;
				$data['assigned_subtask'] = json_decode($row->assigned_subtask);
				$data['assign_site_id'] = $row->site_id;
				$data['assign_user_id'] = $row->user_id;
				$data['from_date'] = $row->start_date;
				$data['to_date'] = $row->end_date;
				$data['assign_by'] = $row->assign_by;
				$data['assigned_role'] = $row->assign_to_role;
				$data['all_subtaskids'] = $row->all_subtaskids;
				$data['all_subtasks'] = $row->all_subtasks;
				$data['exp_subtask'] = $row->explicite_subtask;
				$data['project_start_date'] = $row->project_start_date;
				$data['project_end_date'] = $row->project_end_date;
				// echo "<pre>"; print_r($data); exit;

				
				$reg_rec = $this->update_model->getById(SITE, SITE_ID, $this->session->userdata('site_id'));
				$type_cond = ($row->project_type == 'region') ? array(SITE_REG_ID=>$row->region_id, STATUS=>1) : array();
				$data['sites'] = $this->update_model->getRecordWithcondition(SITE, $type_cond);

				$role_id = $row->assign_to_role;
				$site_id = $row->site_id;
				$data['users'] = $this->Users_model->get_rolewise_users($role_id, $site_id);
				//echo $this->db->last_query(); exit;	
				//echo "<pre>"; print_r($data); exit;
				
			}
		}
		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}