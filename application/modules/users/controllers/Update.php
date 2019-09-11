<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('update_model');
		$this->load->model('roles/Roles_model');
		$this->load->model('login/Login_model');
		$this->load->model('region/Region_model');
		$this->load->model('site/Site_model');
		$this->load->model('users_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Edit User";
		$user_permission = $this->Roles_model->roles($this->session->userdata('role_id'));
		$permissions = json_decode($user_permission[0]->create_user_permission); 
		//echo "<pre>"; print_r($permissions); exit;
		if( count($_POST) ) {
			//echo "<pre>"; print_r($_POST); exit;
			$this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('user_last_name', 'Last Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|max_length[49]');
			//$this->form_validation->set_rules('user_email', 'User Email ID', 'trim|required|valid_email');
			//$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

			if( $this->form_validation->run() ) {

				$result = $this->update_model->fetch_data($this->input->post('user_id'));
				
				if ( $result->username != $this->input->post('user_name') ) {
					if ( $this->update_model->check_duplicate( USER, USERNAME, $this->input->post('user_name') ) ) {
						$update[USERNAME] = $this->input->post('user_name');
					}
					else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger">Duplicate Username. Failed to update the user</div>');
						redirect( '/users/update/index/'.$_POST['user_id'] );
					}
				}

				if ( $result->employee_id != $this->input->post('employee_id') ) {
					if ( $this->update_model->check_duplicate( USER, EMPLOYEE_ID, $this->input->post('employee_id') ) ) {
						$update[EMPLOYEE_ID] = $this->input->post('employee_id');	
					}
					else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger">Duplicate Employee ID. Failed to update the user</div>');
						redirect( '/users/update/index/'.$_POST['user_id'] );
					}
				}

				$count = $_POST['addrowcount'];
				$mapping = array();
				for($j=0; $j<$count; $j++){
					$mapping[$j]['role_id'] = $_POST['user_role'][$j];
					$mapping[$j]['region_id'] = $_POST['region_id'][$j];
					
					if($_POST['user_role'][$j] == 7){
						$site_id = $_POST['fm_site_id'][$j];
					}else{
						$site_id = $_POST['site_id'][$j];
					}
					$mapping[$j]['site_id'] = $site_id;
				}
				//echo "<pre>"; print_r($mapping); exit;
                                $mapping=array_unique($mapping, SORT_REGULAR);
				if( $this->update_model->update( $this->input->post('user_first_name'), $this->input->post('user_last_name'), $this->input->post('user_name'), $this->input->post('user_email'), $this->input->post('user_id'), $mapping, $this->input->post('user_middle_name'), $this->input->post('employee_id'), $this->input->post('select_supervisor'), $permissions ) ) {
					//$data['message'] = "Role has been created.";

					//insert in log
					$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'User', 'User \''.$this->input->post('user_name').'\' is updated' );

					$this->session->set_flashdata('message', '<div class="alert alert-success">User has been updated successfully.</div>');
					redirect( '/users', $data );
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to update the user</div>');
					redirect( '/users/update/index/'.$_POST['user_id'] );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/users/update/index/'.$_POST['user_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$allroles = $this->Roles_model->roles();
								
				$role_array = $role_id_array = $selected_role = '';
				//echo "<pre>"; print_r($user_permission); exit;
				foreach((array)$allroles as $role){
					if(in_array($role->role_id, (array)$permissions)){
						$role_array[] = $role;
						$role_id_array[] = $role->role_id;
					}
				}
				$data['roles'] = $role_array;
				
				$data['user_id'] = $row->{USER_ID};
				$data['user_name'] = $row->{USERNAME};
				$data['user_first_name'] = $row->{USER_FIRST_NAME};
				$data['user_middle_name'] = $row->{USER_MIDDLE_NAME};
				$data['user_last_name'] = $row->{USER_LAST_NAME};
				$data['email_id'] = $row->{USER_EMAIL};

				$userdata = $this->Login_model->get_userdata($this->session->userdata('user_id'));
				$data['site_id'] = $userdata->site_id;
				$data['site_name'] = $userdata->site_name;
				$data['employee_id'] =$row->{EMPLOYEE_ID};
				$data['supervisor_id'] =$row->{SUPERV_ID};
				$data['reg_id'] = $userdata->region_id;
				$data['reg_name'] = $userdata->region_name;
				//$data['portals'] = $this->users_model->getAll(PORTAL);
				// $data['regions'] = $this->Region_model->region();

				if ( $this->session->userdata('role_id') != 1 ) 
	            {
	                $data['regions'] = $this->Region_model->getByIdAll('region', 'reg_id', $this->session->userdata('region_id'));
	            }
	            else
	            {

	                $data['regions'] = $this->Region_model->region();
	            }
				
				// $data['regions'] = $this->Region_model->getByIdAll('region', 'reg_id', $this->session->userdata('region_id'));
				$user_roles = $this->update_model->get_user_roles( $slag );
				$i=0;
				$selected_role = '';
				
				//echo "<pre>"; print_r($user_roles); exit;
				$get_site_ids = $this->users_model->getByIdAll(SITE, 'region_id', $userdata->region_id);
				if(!empty($get_site_ids)){
		            foreach($get_site_ids as $sites){
		                $site_arr[] = $sites->site_id;
		            }
	        	}
	            if($this->session->userdata('role_id') == 1) $site_arr='';

	            $eng_region = $userdata->region_id;
				$eng_site =  $site_arr;

				foreach($user_roles as $role){
					$site_array = '';
					if(!empty($role->role_id) && !empty($role->region_id) && in_array($role->role_id, $role_id_array)){
						$selected_role[$i]['role_id'] = $role->role_id;
						$selected_role[$i]['region_id'] = $role->region_id;

						if ( $this->session->userdata('role_id') != 1 ) 
			            {
			       			$site_array = $this->Region_model->getByIdAll('site', 'site_id', $role->site_id); 
			            }
			            else
			            {
							$site_array = $this->Site_model->get_sites($role->region_id);
			            }
						//echo "<pre>"; print_r($site_array); 
						$selected_role[$i]['site_array'] = $site_array;
						$selected_role[$i]['site_id'] = $role->site_id;
						if($role->role_id == 4){
							$eng_region = $role->region_id;
							$eng_site = array($role->site_id);
						}
						$i++;
					}
				}
				// echo "<pre>"; print_r($selected_role); exit;
				$data['user_roles'] = $selected_role;
				
	            $supervisordata = $this->users_model->getSupervisors($eng_region, $eng_site, $slag);
	            //echo "<pre>"; print_r($supervisordata); exit;
				$data['supervisors'] = $supervisordata;
				//exit;
				
			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}