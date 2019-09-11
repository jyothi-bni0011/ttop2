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

	

	public function index($dash_role='')
	{
		$data['title'] = "Manage Users";

		$user_permission = $this->Roles_model->roles($this->session->userdata('role_id'));
		$permissions = json_decode($user_permission[0]->create_user_permission);
		$assign_permissions = json_decode($user_permission[0]->assign_project_permission);
		
		//If program manager can assign only supervisor
		if($this->session->userdata('role_id') == 5){
			$assign_permissions = array('3');
		}
		$come_from = 'user';
		$from_date = $to_date = '';

		//If comming from dashboard
		if(!empty($dash_role)){
			$permissions = array($dash_role);
			$come_from = 'dashboard';
			$from_date = $_GET['from_date'];
			$to_date = $_GET['to_date'];
			if($dash_role == 2){$title = 'Active Admins';}
			if($dash_role == 3){$title = 'Active Supervisors';}
			if($dash_role == 4){$title = 'Active Engineers';}
			$data['title'] = $title;
		}
		//echo "<pre>"; print_r($_SESSION); exit;

		$cond_query	= '';
		if($this->session->userdata('role_id') != 1){
			$region_query = $site_query = 0;
			if($this->session->userdata('region_id')!=0){
				$region_query = $this->session->userdata('region_id');
			}
			if($this->session->userdata('site_id')!=0){
				$site_query = $this->session->userdata('site_id');
			}
			$cond_query = array('users_role_mapping.region_id'=>$region_query, 'users_role_mapping.site_id'=>$site_query);

			if($this->session->userdata('role_id') == 5 || $this->session->userdata('role_id') == 6){
				$cond_query = array('users_role_mapping.region_id'=>$region_query);
			}

		}

		//$assign_permissions = $permissions;
		$selected_role = '';
		$created_by = $this->session->userdata('user_id');
		if( count($_POST) ) { 
			$selected_role = $this->input->post('search_role');
			if($selected_role){
				$permissions_role = array($selected_role);
			}else{
				$permissions_role = $permissions;
			}
			//echo "<pre>"; print_r($permissions_role); exit;
			$data['users'] = $this->users_model->users($permissions_role, $cond_query, '', $created_by);
			
		}else{
			
			//$selected_role = count($permissions==1) ? $permissions[0] : '';
			$selected_role = '';
			$data['users'] = $this->users_model->users($permissions, $cond_query, $to_date, $created_by);
		}

		//echo "<pre>"; print_r($data['users']);

		$role_array = '';
		$allroles = $this->Roles_model->roles();
		foreach($allroles as $role){
			if(in_array($role->role_id, (array)$permissions)){
				$role_array[] = $role;
			}
		}
		//echo $selected_role; exit;
		//echo "<pre>"; print_r($assign_permissions);print_r($data['users']); exit;

		$data['roles'] = $role_array;
		$data['selected_role'] = $selected_role;
		$data['assign_permissions'] = $assign_permissions;
		$data['come_from'] = $come_from;
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
        //echo "<pre>"; print_r($userdata); exit;
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
       // echo "<pre>"; print_r($data); exit;

		$this->load->view('common/header');
		$this->load->view('assign_role', $data);
		$this->load->view('common/footer');
	}

	public function getsite(){
		
		$reg_id = $this->input->post('region_id');
		$sv_show = $this->input->post('sv_show');
		$role = $this->input->post('role');

		//Get Site data
		if ( $this->session->userdata('role_id') != 1 ) 
        {
            $result = $this->Site_model->getByIdAll('site', 'site_id', $this->session->userdata('site_id'));    
        }
        else
        {
			$result=$this->Site_model->get_sites($reg_id);
        }
		$options = $options_sv = $site_array = array();
		foreach($result as $alldata){
	    	$options[] = array(
	    		"site_id" => $alldata->site_id,
	    		"site_name" => $alldata->site_name
	    	);
	    	//$site_array[] = $alldata->site_id;
		}
		$data['site_opt'] = $options;

		if($sv_show == 1 && $role == 4){
			//Get supervisor data
			$supervisors = $this->users_model->getSupervisors($reg_id);
			//$options_sv = array();
			if(!empty($supervisors)){
				foreach($supervisors as $sv){
			    	$options_sv[] = array(
			    		"user_id" => $sv->user_id,
			    		"user_name" => $sv->name
			    	);
			    	
				}
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
//			$log_desc = ucwords($this->session->userdata('username')).' Assigned to you('.$result1->username.')';
			$log_desc = ucwords($result1->username).' Assigned To '.$this->session->userdata('username').')';
		}else{

			$supervisor = 0;
//			$log_desc = ucwords($this->session->userdata('username')).' Unassigned to you('.$result1->username.')';
			$log_desc = ucwords($result1->username).' Unassigned By('.$this->session->userdata('username').')';
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

			//Notification to engineer
			$notification_array = array(
					//'notification_from' => $this->session->userdata('user_id'),
					'notification_from' => $this->session->userdata('user_id'),
					'notification_to' => $id,
					'notification' => $log_desc,
					'request' => 'AssignUser',
					'request_id' => '',
					'status' => 0,
					'assign_by' => $this->session->userdata('user_id'),
					'created_on' => date('Y-m-d H:i:s', now())
					);

			$ins_notification = $this->users_model->insert_Record('notification', $notification_array);

			//Notification to supervisor
			if(!empty($result1->supervisor_id)){

				$resultsv = $this->users_model->getById(USER, USER_ID, $result1->supervisor_id);

				if(!empty($resultsv)){
					$notification_array = array(
					//'notification_from' => $this->session->userdata('user_id'),
					'notification_from' => $this->session->userdata('user_id'),
					'notification_to' => $result1->supervisor_id,
					'notification' => ucwords($this->session->userdata('username')).' '. $action.' to '.$result1->username,
					'request' => 'AssignUser',
					'request_id' => '',
					'status' => 0,
					'assign_by' => $this->session->userdata('user_id'),
					'created_on' => date('Y-m-d H:i:s', now())
					);

					$ins_notification = $this->users_model->insert_Record('notification', $notification_array);
				}
				
			}
			

			$this->session->set_flashdata('message', '<div class="alert alert-success"> Successfully '.ucwords($action).'..</div>');
			
		}else{
			$this->session->set_flashdata('message', '<div class="alert alert-success"> Failed ..</div>');
			
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

	public function user_project_details($user_id)
	{
		if ( empty( $user_id ) ) 
		{
			redirect('users');
        	exit();
		}

		$current_week = date('W');
        $current_year = date('Y');
        
        $firstweekday = date("Y-m-d", strtotime("{$current_year}-W{$current_week}-1")); 
        $lastweekday = date("Y-m-d", strtotime("{$current_year}-W{$current_week}-7")); 
        
        $data['form_date'] = $firstweekday;
		$data['to_date'] = $lastweekday;
        $data['engineerdata'] = $this->users_model->getuserallprojects($user_id, $firstweekday, $lastweekday);
        $data['userdata'] 	= $this->users_model->getById('users', 'user_id', $user_id);
        $data['project_id'] = $this->input->post('project_id');
        $data['project_list'] = $this->users_model->assigned_project_list($user_id);

        $this->load->view('common/header');
		$this->load->view('user_project_details',$data);
		$this->load->view('common/footer');
	}

	public function search_user_project_details($user_id)
	{
		if ( empty( $user_id ) ) 
		{
			redirect('users');
        	exit();
		}

        $form_date 	= $this->input->get('from_date');
		$to_date 	= $this->input->get('to_date');
		$project_id = $this->input->get('project_id');

        $data['form_date'] = $form_date;
		$data['to_date'] = $to_date;
        $data['engineerdata'] = $this->users_model->getuserallprojects($user_id, $form_date, $to_date, $project_id);
        $data['userdata'] 	= $this->users_model->getById('users', 'user_id', $user_id);
        $data['project_id'] = $this->input->get('project_id');
        $data['project_list'] = $this->users_model->assigned_project_list($user_id);
        // print_r( $data ); exit();
        $this->load->view('common/header');
		$this->load->view('user_project_details',$data);
		$this->load->view('common/footer');
	}

	public function getSupervisors(){
		$site_id = $this->input->post('site_id');
		$options_sv = '';		
		//Get supervisor data
		$supervisors = $this->users_model->getSupervisors('', array($site_id));
		//$options_sv = array();
		if(!empty($supervisors)){
			foreach($supervisors as $sv){
		    	$options_sv[] = array(
		    		"user_id" => $sv->user_id,
		    		"user_name" => $sv->name
		    	);
		    	
			}
		}
		$data['sv_opt'] = $options_sv;
		
		
		echo json_encode($data); //exit;
	}

}