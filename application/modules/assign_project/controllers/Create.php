<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('create_model');
		$this->load->model('users/users_model');
		$this->load->model('roles/Roles_model');
	}

	

	public function index()
	{
		//echo "<pre>";print_r($_SESSION);exit;
		$data['title'] = "Create Assigned Project";
		$login_user = $this->Roles_model->roles($this->session->userdata('role_id'));
		$role_data = '';
		if(!empty($login_user[0]->assign_project_permission)){ 
			$permissions = json_decode($login_user[0]->assign_project_permission);
			$role_data = $this->Roles_model->get_role_data('role', $permissions);
		}
		
		if( count($_POST) ) {
			
			$this->form_validation->set_rules('assign_to', 'Assign To', 'trim|required');
			$this->form_validation->set_rules('project_type', 'Project Type', 'trim|required');
			$this->form_validation->set_rules('project_name', 'Project Name', 'trim|required');
			//$this->form_validation->set_rules('user_name', 'Engineer/Supervisor Name', 'trim|required');
			if( $this->form_validation->run() ) {

				$notification_array = array();
				$non_assigned_engg = '';
				$users_ids = $this->input->post('user_name');
				foreach($users_ids as $user){
					$check_exist = $this->create_model->getRecordWithcondition( ASSIGN_PROJECT, array(ASSIGN_USER_ID => $user, ASSIGN_PROJECT_ID => $this->input->post('project_name'), STATUS.' !=' => 3) );

					$user_site_id = '';
					$user_rec = $this->users_model->get_user_mapping_data( $user, $this->input->post('assign_to') );
					if($user_rec){
						$user_site_id = $user_rec->site_id;
						$user_supervisor = empty($user_rec->pr_supervisor_id) ? $user_rec->supervisor_id : $user_rec->pr_supervisor_id;
					}


					$actual_site_id = $this->session->userdata('site_id');
					//echo "<pre>"; print_r($user_rec);
					//echo $user_site_id." ### ".$actual_site_id; exit;
					if($user_site_id != $actual_site_id){
						$status = 0; //pending
					}else{
						$status = 1; //approved
					}

					$i = 0;
					//echo "<pre>"; print_r($check_exist); exit;

					if(empty($check_exist)){
						//if($user_supervisor != 0){
							$final_array = array(
									ASSIGN_PROJECT_ID	=>	$this->input->post('project_name'),
									ASSIGN_USER_ID	=>	$user,
									START_DATE => $this->input->post('start_date'),
									END_DATE => $this->input->post('end_date'),
									SUBTASK_IDS => !empty($this->input->post('subtask_id')) ? json_encode($this->input->post('subtask_id')) : '',
									ASSIGN_PROJECT_BY => $this->session->userdata('user_id'),
									ASSIGN_TO_ROLE => $this->input->post('assign_to'),
									STATUS => $status,
									CREATED_ON	=>	date('Y-m-d H:i:s', now())
							);  
							$i = 1;

							$rejected_projects = $this->create_model->getRecordWithcondition( ASSIGN_PROJECT, array(ASSIGN_USER_ID => $user, ASSIGN_PROJECT_ID => $this->input->post('project_name'), STATUS => 3), '', '', 1 );

							//If rejected project is found, delete from assign project
							if(!empty($rejected_projects)){
								//echo "<pre>"; print_r($check_rejected_projects); exit;
								$this->create_model->deleteRecord(ASSIGN_PROJECT, array('id'=>$rejected_projects->id));
							}

							$assign_insert = $this->create_model->insert_Record(ASSIGN_PROJECT, $final_array);

							//Add notification code here
							//Send notification to supervisor
							if($status == 0 && !empty($assign_insert)){
								$project_rec = $this->create_model->getById( PROJECTS, PROJECT_ID, $this->input->post('project_name') );
								$site_rec = $this->create_model->getById( SITE, SITE_ID, $this->session->userdata('site_id') );

								if($project_rec){
									
									if($user_supervisor!=0){
										$notification_array[] = array(
											//'notification_from' => $this->session->userdata('user_id'),
											'notification_from' => $user,
											'notification_to' => $user_supervisor,
											'notification' => 'Request for user ('.$user_rec->username.') to project ('. $project_rec->project_name.') in site ('.$site_rec->site_name.').',
											'request' => 'Assign_project',
											'request_id' => $assign_insert,
											'status' => 0,
											'assign_by' => $this->session->userdata('user_id'),
											'created_on' => date('Y-m-d H:i:s', now())
											);
									}
								
								}					

							}
							//End send notification

						//}

					}else{
						$non_assigned_engg .= $user_rec->username.", ";
					}

				}

				if($i==0){
					$this->session->set_flashdata('message', "<div class='alert alert-danger'>Project is Already Assigned to ".rtrim($non_assigned_engg, ' ,')."</div>");
					redirect( '/assign_project/create', $data );
				} else {
				
				//echo "<pre>"; print_r($ins_array); exit;

				//if( $inserted_id = $this->create_model->create( $final_array ) ) {
					
					//Insert batch for notification
					if(!empty($notification_array)){
						$ins_notification = $this->create_model->insert_batch_Record('notification', $notification_array);
					}
					//insert in log
					$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Assign Project', 'New Project  \''.$this->input->post('project_name').'\' is assigned successfully.' );

					$this->session->set_flashdata('message', '<div class="alert alert-success">Project assigned successfully</div>');
					redirect( '/assign_project', $data );
				} 
			}
			else {
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/assign_project/create', $data );
			}
		}
		else{
			
			$data['assign_permission'] = $role_data;
			$this->load->view('common/header');
			$this->load->view('create', $data);
			$this->load->view('common/footer');
		}

	}

}