<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_project extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Assign_project_model');
		$this->load->model('users/Users_model');
		$this->load->model('roles/Roles_model');
	}

	public function index()
	{
		
		$data['title'] = "Assigned Projects";
		$login_user = $this->Roles_model->roles($this->session->userdata('role_id'));
		//echo "<pre>"; print_r($login_user); exit;
		$role_data='';
		$selected_role = '';
		if(!empty($login_user[0]->assign_project_permission)){ 
			$permissions = json_decode($login_user[0]->assign_project_permission);
			$role_data = $this->Roles_model->get_role_data('role', $permissions);
			//echo "<pre>"; print_r($role_data); exit;
			if(count($role_data) == 1){
				$selected_role = $role_data[0]->role_id;
			}

		}
		
		$assign_to = $selected_role;
		if( count($_POST) ) {
			$assign_to = $this->input->post('assign_to');
		}
		$data['assigned_projects'] = $this->Assign_project_model->assigned_projects($assign_to);
		$data['assign_to'] = $this->input->post('assign_to');

		$data['selected_role']  = $selected_role;
		$data['assign_permission'] = $role_data;
		$this->load->view('common/header');
		$this->load->view('assign_project',$data);
		$this->load->view('common/footer');
	}

	public function getprojects_and_sites(){
		$project_type = $this->input->post('type');
		$site_id = $this->input->post('site_id'); 
		$role_id = $this->input->post('role_id');
		$sites_array = '';
		if(!empty($project_type)){
			if(!empty($site_id)){
				$reg_rec = $this->Assign_project_model->getById(SITE, SITE_ID, $site_id);
				$region_id_fix = $reg_rec->region_id;
			}else{
				$region_id_fix = $this->session->userdata('region_id');
			}
			
			//echo "<pre>"; print_r($this->session->userdata('site_id')); exit;
			$project_type_region = $this->Assign_project_model->getRecordWithcondition(SITE, array(SITE_REG_ID=>$region_id_fix, STATUS=>1));

			foreach((array)$project_type_region as $reg){
				$sites_array[] = $reg->site_id;
			}
			
			if($project_type == 'site'){
				$con_arr = array(PROJECT_TYPE=>$project_type, STATUS=>1, PROJECT_SITE_ID=>$site_id);
			}else if($project_type == 'region'){
				$con_arr = array(PROJECT_TYPE=>$project_type, STATUS=>1, 'site_arr'=>$sites_array);
			}else {
				$con_arr = array(PROJECT_TYPE=>$project_type, STATUS=>1);
			}
			$project_array = $this->Assign_project_model->getProject_forassign($con_arr);

			$type_cond = ($project_type == 'region') ? array(SITE_REG_ID=>$region_id_fix, STATUS=>1) : array();
			$sites_array = $this->Assign_project_model->getRecordWithcondition(SITE, $type_cond);
			$options = $project_options = $site_options = array();
			
			foreach($project_array as $project){
		    	$project_options[] = array(
		    		"project_id" => $project->id,
		    		"project_name" => $project->project_name
		    	);
			}

			foreach($sites_array as $sites){
		    	$site_options[] = array(
		    		"site_id" => $sites->site_id,
		    		"site_name" => $sites->site_name
		    	);
			}

			if($project_type == 'site' && !empty($role_id)){
				$users = $this->Users_model->get_rolewise_users($role_id, $site_id);
				foreach($users as $user){
			    	$sv_options[] = array(
			    		"id" => $user->user_id,
			    		"name" => $user->name
			    	);
				}
			}else{
				$sv_options = array();
			}
		}else{
			$project_options = $site_options = array();
		}
		$options['project'] = $project_options;
		$options['site'] = $site_options;
		$options['supervisor'] = $sv_options;

		echo json_encode($options); //exit;
	}

	public function getsubtasks(){

		$project_id = $this->input->post('project_id');
		$subtask_array = $this->Assign_project_model->getRecordWithcondition(SUBTASK, array(SUB_PROJECT_ID=>$project_id, STATUS=>1));

		$subtask_opt = array();
		
		foreach($subtask_array as $subtask){
	    	$subtask_opt[] = array(
	    		"subtask_id" => $subtask->subtask_id,
	    		"subtask_name" => $subtask->subtask_name
	    	);

	    	$subtask_array[] = $subtask->subtask_id;
		}

		$project_info = $this->Assign_project_model->getById( 'projects', 'id', $project_id );
		
		$data['selected_subtask'] = $subtask_array;
 		$data['subtask_opt'] = $subtask_opt;
		$data['project_info'] = $project_info;
		echo json_encode($data); //exit;
	}

	public function getuserdata(){
		$role_id = $this->input->post('user_type');
		$site_id = $this->input->post('site_id');
		//echo $site_id; exit; 2,3
		$users_array = $this->Users_model->get_rolewise_users($role_id, $site_id);
		
		$user_opt = array();

		foreach($users_array as $user){
	    	$user_opt[] = array(
	    		"id" => $user->user_id,
	    		"name" => $user->name
	    	);
		}

		echo json_encode($user_opt); //exit;*/
	}

}