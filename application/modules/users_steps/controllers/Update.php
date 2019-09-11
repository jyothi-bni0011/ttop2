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
		$this->load->model('users_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Users";

		if( count($_POST) ) {
			//$this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required|max_length[49]');
			//$this->form_validation->set_rules('user_last_name', 'Last Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('user_email', 'User Email ID', 'trim|required|valid_email');
			//$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

			if( $this->form_validation->run() ) {

				$result = $this->update_model->fetch_data($this->input->post('user_id'));
				
				if ( $result->username != $this->input->post('user_name') ) {
					if ( $this->update_model->check_duplicate( USER, USERNAME, $this->input->post('user_name') ) ) {
						$update[USERNAME] = $user_name;
					}
					else {
						$this->session->set_flashdata('message', 'Duplicate Username. Failed to update the user');
						redirect( '/users/update/index/'.$_POST['user_id'] );	
					}
				}

				if ( $result->email_id != $this->input->post('user_email') ) {
					if ( $this->update_model->check_duplicate( USER, USER_EMAIL, $this->input->post('user_email') ) ) {
						$update[USER_EMAIL] = $user_email;	
					}
					else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger">Duplicate Email. Failed to update the user</div>');
						redirect( '/users/update/index/'.$_POST['user_id'] );
					}
				}

				if( $this->update_model->update( $this->input->post('user_first_name'), $this->input->post('user_last_name'), $this->input->post('user_name'), $this->input->post('user_email'), $this->input->post('user_id'), $this->input->post('user_role'), $this->input->post('user_middle_name'), $this->input->post('portal_selection'), $this->input->post('employee_id'), $this->input->post('select_supervisor') ) ) {
					//$data['message'] = "Role has been created.";

					//insert in log
					$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'User', 'User \''.$this->input->post('user_name').'\' is updated' );

					$this->session->set_flashdata('message', '<div class="alert alert-success">User has been updated.</div>');
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
				$user_permission = $this->Roles_model->roles($this->session->userdata('role_id'));
				$permissions = json_decode($user_permission[0]->create_user_permission); 
				$role_array = $portal_array = '';
				//echo "<pre>"; print_r($user_permission); exit;
				foreach((array)$allroles as $role){
					if(in_array($role->role_id, (array)$permissions)){
						$role_array[] = $role;
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
				$data['portals'] = $this->users_model->getAll(PORTAL);
				$user_roles = $this->update_model->get_user_roles( $slag );
				foreach($user_roles as $role){
					$selected_role[] = $role->role_id;
				}
				$data['user_roles'] = $selected_role;
				 
				$selected_portal = $this->users_model->get_user_portal( $slag );

				if(!empty($selected_portal)){
					foreach($selected_portal as $portal){
						$portal_array[] = $portal->portal_id;
					}
				}
				$data['selected_portal'] = $portal_array;

				$get_site_ids = $this->users_model->getByIdAll(SITE, 'region_id', $userdata->region_id);
	            foreach($get_site_ids as $sites){
	                $site_arr[] = $sites->site_id;
	            }
	            $supervisordata = $this->users_model->getSupervisors($site_arr);
				$data['supervisors'] = $supervisordata;
				/*$this->load->view('common/header');
				$this->load->view('update', $data);
				$this->load->view('common/footer');*/
			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}