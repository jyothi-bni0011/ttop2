<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('users_model');
		$this->load->model('roles/Roles_model');
		$this->load->model('site/Site_model');
		$this->load->model('region/Region_model');
		$this->load->model('login/Login_model');
	}

	

	public function index()
	{

		$data['title'] = "Users";

		$user_permission = $this->Roles_model->roles($this->session->userdata('role_id'));
		$permissions = json_decode($user_permission[0]->create_user_permission);
		$assign_permissions = json_decode($user_permission[0]->assign_project_permission);
		$selected_role = '';
		if( count($_POST) ) { 
			$selected_role = $this->input->post('search_role');
			if($selected_role){
				$permissions_role = array($selected_role);
			}else{
				$permissions_role = $permissions;
			}
			//echo "<pre>"; print_r($permissions_role); exit;
			$data['users'] = $this->users_model->users($permissions_role);
			
		}else{
			
			$selected_role = count($permissions==1) ? $permissions[0] : '';
			$data['users'] = $this->users_model->users($permissions);
		}

		$role_array = '';
		$allroles = $this->Roles_model->roles();
		foreach($allroles as $role){
			if(in_array($role->role_id, (array)$permissions)){
				$role_array[] = $role;
			}
		}
		//echo $selected_role; exit;
		// echo "<pre>"; print_r($assign_permissions);print_r($data['users']); exit;
		$data['roles'] = $role_array;
		$data['selected_role'] = $selected_role;
		$data['assign_permissions'] = $assign_permissions;
		$this->load->view('common/header');
		$this->load->view('users', $data);
		$this->load->view('common/footer');
	}

	public function assign_role(){

		$data['post'] = $_POST;
		//echo "<pre>"; print_r($data['post']); exit;
		//$inserted_id = $this->uri->segment(3); 
		//$ins_data = $this->users_model->getById(USER, 'user_id', $inserted_id);
		$data['user_data'] = $_POST;
        $allroles = $this->Roles_model->roles();
        $login_user = $this->Roles_model->roles($this->session->userdata('role_id'));
        $permissions = json_decode($login_user[0]->create_user_permission);
        $data['regions'] = $this->Region_model->region();
        $userdata = $this->Login_model->get_userdata($this->session->userdata('user_id'));
        $data['site_id'] = $userdata->site_id;
        $data['site_name'] = $userdata->site_name;
        $data['employee_id'] = $userdata->employee_id;
        //$data['reg_id'] = $userdata->region_id;
        $data['portals'] = $this->users_model->getAll(PORTAL);
        $cond_arr = array('role_id'=>3,
                            'status'=>1);

        $get_site_ids = $this->users_model->getByIdAll(SITE, 'region_id', $userdata->region_id);
        foreach($get_site_ids as $sites){
            $site_arr[] = $sites->site_id;
        }
        //$supervisordata = $this->users_model->getSupervisors($site_arr);
        //echo "<pre>"; print_r($supervisordata); exit;

        foreach($allroles as $role){
            if(in_array($role->role_id, (array)$permissions)){
                $role_array[] = $role;
            }
        }
        // /$data['supervisors'] = $supervisordata;
        $data['roles'] = $role_array;
		$this->load->view('common/header');
		$this->load->view('assign_role', $data);
		$this->load->view('common/footer');
	}

	public function getsite(){
		
		$reg_id = $this->input->post('region_id');
		$sv_show = $this->input->post('sv_show');

		//Get Site data
		$result=$this->Site_model->get_sites($reg_id);
		$options = $options_sv = $site_array = array();
		foreach($result as $alldata){
	    	$options[] = array(
	    		"site_id" => $alldata->site_id,
	    		"site_name" => $alldata->site_name
	    	);
	    	$site_array[] = $alldata->site_id;
		}
		$data['site_opt'] = $options;

		if($sv_show == 1){
			//Get supervisor data
			$supervisors = $this->users_model->getSupervisors($site_array);
			$options_sv = array();
			foreach($supervisors as $sv){
		    	$options_sv[] = array(
		    		"user_id" => $sv->user_id,
		    		"user_name" => $sv->name
		    	);
		    	
			}
			$data['sv_opt'] = $options_sv;
		}
		
		echo json_encode($data); //exit;
	}

	public function assign_supervisor(){
		
		$id=$this->input->post('user_id');
		$action=$this->input->post('action');
		$result1 = $this->users_model->getById(USER, USER_ID, $id);
		
		if($action == 'assigned'){

			$supervisor = $this->session->userdata('user_id');
			$log_desc = ucwords($this->session->userdata('username')).' Assigned to '.$result1->username;
		}else{

			$supervisor = 0;
			$log_desc = ucwords($this->session->userdata('username')).' Unassigned to '.$result1->username;
		}

		$data=array(	
			'pr_supervisor_id'=> $supervisor,	
			'updated_on' => date('Y-m-d H:i:s'),	
			);	
		
		$result=$this->users_model->update_Record( USER , $data, array('user_id' => $id));
		if($result==1){
			$this->users_model->insert_log_history((int)$this->session->userdata('user_id'), 'Assign Supervisor', $log_desc);
			//notification shifting
			if ( $action == 'assigned' ) 
			{
				// echo $result1->supervisor_id.'  '. $supervisor;
				if ( $result1->supervisor_id ) 
				{
					$this->users_model->shift_notifications( $result1->supervisor_id, $supervisor );
				}

			}
			else
			{

				$supervisor1 = $this->session->userdata('user_id');
				if ( $result1->supervisor_id ) 
				{
					$this->users_model->shift_notifications( $supervisor1, $result1->supervisor_id );	
				}

			}
			//notification shifting end
			$this->session->set_flashdata('message', '<div class="alert alert-success"> Successfully '.ucwords($action).'..</div>');
			
		}else{
			$this->session->set_flashdata('message', '<div class="alert alert-success"> Failed..</div>');
			
		}
	}

	public function change_status()
	{
		if ( ! empty( $_POST['where'] ) || ! empty( $_POST['table'] ) || ! isset( $_POST['value'] ) || ! empty( $_POST['column'] ) ) 
		{
			if ( $this->users_model->change_status( $_POST['table'], $_POST['column'], $_POST['where'], $_POST['value'] ) ) 
			{
				//insert log
				$user = $this->users_model->getById(USER, USER_ID, $_POST['where']);
				if ( $_POST['value'] == 1 ) 
				{
					$this->users_model->insert_log_history( (int)$this->session->userdata('user_id'), 'User', 'User \''.$user->first_name.' '.$user->last_name.'\' is activated' );
				}
				else
				{
					$this->users_model->insert_log_history( (int)$this->session->userdata('user_id'), 'User', 'User \''.$user->first_name.' '.$user->last_name.'\' is deactivated' );	
				}
				$data = ['success' => 1]; 
			
				$this->output
					->set_content_type('application/json')
			        ->set_output(json_encode($data));		
			}
		}
	}

}