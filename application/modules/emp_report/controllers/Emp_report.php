<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_report extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Emp_report_model');
		$this->load->model('login/login_model');
		$this->load->model('project/project_model');
		$this->load->model('users/users_model');
	}

	public function index()
	{

		$data['title'] = "Employee Hours Report";

		$role = $hours_type = $period_closed_hours = $project = $emp_id = $subtask = $subtask_array = $sap_code = '';
		$current_week = date('W');
        $current_year = date('Y');
        $to_date = date("Y-m-d", strtotime("{$current_year}-W{$current_week}-7"));
        $from_date = date('Y-m-d', strtotime("{$current_year}-W{$current_week}-1"));
        $role_array = array(3,4);

        if(null !==$this->session->userdata('site_id') && $this->session->userdata('site_id') != 0){
			$fm_site_id = $this->session->userdata('site_id');
		}else{
			$fm_site_id = '';
		}
		$site = $fm_site_id;
		
        
		if( count($_POST) ) {
			$site = $this->input->post('site_name');
			$role = $this->input->post('timesheets');
			$hours_type = $this->input->post('hours_type');
			$period_closed_hours = $this->input->post('period_closed_hours');
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$project = $this->input->post('project_id');
			$sap_code = $this->input->post('sap_code');
			$emp_id = $this->input->post('employee_id');
			$subtask = $this->input->post('subtask_id');
			$role_array = (!empty($role)) ? array($role) : array(3,4);
		}

		$user_id = $this->session->userdata('user_id');
		//$userdata = $this->login_model->get_userdata($user_id, $this->session->userdata('region_id'), $this->session->userdata('site_id'));
		//echo "<pre>"; print_r($userdata); exit;
		$region = $this->session->userdata('region_id');
		$site_week_hours = '';

		if($hours_type == 'sub'){
			$status = array(2,3);
		}else if($hours_type == 'unsub'){
			$status = array(1,4);
		}else if($hours_type == 'missing'){
			$status = array(2,3);
			//Get Work Hours Per Week of Site
			// if($site!=''){
			// 	$site_query = $this->Emp_report_model->getById(SITE, 'site_id', $site);
			// 	$site_week_hours = $site_query->workhours_per_week; 
			// }else{
			// 	$site_week_hours = 0; 
			// }
			
		}else{
			$status = array();
		}

		if($fm_site_id!=""){
			$data['sites'] = $this->Emp_report_model->getRecordWithcondition( 'site', array('status'=>1, 'region_id'=>$region, 'site_id'=>$fm_site_id) );
		}else{
			$data['sites'] = $this->Emp_report_model->getRecordWithcondition( 'site', array('status'=>1, 'region_id'=>$region) );
		}
		//$get_period_close_dates = $this->get_period_close_dates($region);


		$data['reportdata'] = $this->Emp_report_model->emp_report_data( $user_id, $from_date, $to_date, $site, $region, $role, $status, $period_closed_hours, $project, $subtask, $emp_id, $hours_type , $sap_code );
		// echo "<pre>"; print_r($data['reportdata']); exit;

		if(!empty($project)){
			$subtask_array = $this->Emp_report_model->getRecordWithcondition(SUBTASK, array(SUB_PROJECT_ID=>$project, STATUS=>1));
		}

		$data['site'] = $site;
		$data['timesheets'] = $role;
		$data['hours_type'] = $hours_type;
		$data['period_closed_hours'] = $period_closed_hours;
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['projects'] = $this->project_model->get_projects($region, $site, 'global');
		$data['emp_id'] = $emp_id;
		$data['project'] = $project;
		$data['sap_code'] = $sap_code;
		$data['subtask'] = $subtask;
		//$data['site_hour'] = $site_week_hours;
		$data['subtask_array'] = $subtask_array;

		$array_user = array();
		if(!empty($region)){
			$array_user['users_role_mapping.region_id'] = $region;
		}

		if(!empty($site)){
			$array_user['users_role_mapping.site_id'] = $site;
		}
		//echo "here"; exit;
		$data['employees'] = $this->users_model->users($role_array, $array_user);

		$this->load->view('common/header');
		$this->load->view('emp_report',$data);
		$this->load->view('common/footer');
	}

	//Will be in use
	/*public function get_period_close_dates($region_id){
		$get_sites = $this->Emp_report_model->getRecordWithcondition('site', array('region_id'=>$region_id, 'status'=>1));
		if(!empty($get_sites)){
			foreach($get_sites as $site){
				$get_period_close_date =  $this->Emp_report_model->get_period_closedate($site->site_id);
				$get_close_dates[$site->site_id] = $get_period_close_date;
			}
			return $get_close_dates;
		}
	}*/

	public function change_status()
	{
		if ( ! empty( $_POST['where'] ) || ! empty( $_POST['table'] ) || ! isset( $_POST['value'] ) || ! empty( $_POST['column'] ) ) 
		{
			if ( $this->Notification_model->change_status( $_POST['table'], $_POST['column'], $_POST['where'], $_POST['value'] ) ) 
			{
				$notification_data = $this->Notification_model->getById($_POST['table'], $_POST['column'],  $_POST['where']);
				//print_r($notification_data); exit();
				if($_POST['value']==2){
					$status = 'Approved';
					$sts = 3;
				}else{
					$status = 'Rejected';
					$sts = 4;
				}

				//echo "<pre>"; print_r($notification_data); exit;

				//Update notification status 
				$update_arr = array('status'=>$sts, 'updated_on'=>date('Y-m-d'));
				$update_on = array('timecard_id'=>$notification_data->request_id);
				$this->Notification_model->update_Record_multi_col('timecard', $update_arr, $update_on);

				//echo $this->db->last_query(); 
				//Insert notification for approved/reject
				$notification_array = array('notification_from' => $this->session->userdata('user_id'),
										'notification_to' => $notification_data->notification_from, 
										'notification' => 'Your Timesheet has been '.$status. ' for week number '.date('W', strtotime($notification_data->from_date)),
										'request' => 'timesheet_response',
										'status' => 0,
										'assign_by' =>  $this->session->userdata('user_id'),
										'created_on' => date('Y-m-d H:i:s', now())
										 );
				$this->Notification_model->insert_Record('notification', $notification_array);
				$data = ['success' => 1]; 
			
				$this->output
					->set_content_type('application/json')
			        ->set_output(json_encode($data));		
			}
		}
	}

	public function sendTimesheetRemainderEmail(){

		$weeknumber=$_POST['week_number'];
		$engineer_id=base64_decode($_POST['engineer_id']);
		$engineerfullname=$_POST['engineer_full_name'];
		$engineeremailaddress=$_POST['engineer_email_id'];
		$resourcename=$_POST['resource_manager'];
		
		$resourceemailid=$_POST['manager_email_id'];
		$mail_to=$_POST['email_to'];
		$message='';

		$subject = 'Unsubmitted Timesheet Reminder';

		//Engineer hours have to be rejected ---- added by maruti 19Jan
								
//		$this->Dashboard_model->reject_timesheet_and_send_notifications($engineer_id,$weeknumber); 
				
		if($mail_to=='engineer')
		{
			$message = 'Dear ' .urldecode($engineerfullname). ', <br /><br /> Kindly update and submit your time sheet for the week# ' .$weeknumber. ' as soon as possible. <br /><br />Thank you.<br /><br />Regards,<br/>Finance Team';
			$to=$engineeremailaddress;
		}
		
		else if($mail_to=='manager')
		{
			$message = 'Dear ' .$resourcename. ' , <br /> Please note that  : '.urldecode($engineerfullname).' has not submitted the timesheet for the week : '.$weeknumber.'<br/><br/>Kindly ensure that your reportee submits the timesheet as soon as possible.<br /><br />Thank you.<br /><br />Regards,<br/>Finance Team';
			$to=$resourceemailid;

		}
		//send mail
                return $this->Emp_report_model->send_email( $subject, $message, $to, '' );


	}
	public function hours_to_sap_report(){
		$data['title'] = 'Hours to SAP Report';
		$role = $hours_type = $period_closed_hours = $project = $emp_id = $subtask = $subtask_array = $sap_code = '';
		$current_week = date('W');
        $current_year = date('Y');
        $to_date = date("Y-m-d", strtotime("{$current_year}-W{$current_week}-7"));
        $from_date = date('Y-m-d', strtotime("{$current_year}-W{$current_week}-1"));
        if(null !==$this->session->userdata('site_id') && $this->session->userdata('site_id') != 0){
			$fm_site_id = $this->session->userdata('site_id');
		}else{
			$fm_site_id = '';
		}

		$site = $fm_site_id;

		
        $role_array = array(3,4);

		if( count($_POST) ) {
			$site = $this->input->post('site_name');
			$role = $this->input->post('timesheets');
			$hours_type = $this->input->post('hours_type');
			$period_closed_hours = $this->input->post('period_closed_hours');
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$role_array = (!empty($role)) ? array($role) : array(3,4);
			$project = $this->input->post('project_id');
			$sap_code = $this->input->post('sap_code');
			$emp_id = $this->input->post('employee_id');
			$subtask = $this->input->post('subtask_id');
		}

		$user_id = $this->session->userdata('user_id');
		$region = $this->session->userdata('region_id');
		

		if($hours_type == 'sub'){
			$status = array(2,3); // 2-submitted, 3-approved
		}else if($hours_type == 'unsub'){
			$status = array(1,4); // 1-saved, 4-rejected
		}else if($hours_type == 'missing'){
			$status = array(0); //0-pending submission
		}else{
			$status = array();
		}

		if($fm_site_id!=""){
			$data['sites'] = $this->Emp_report_model->getRecordWithcondition( 'site', array('status'=>1, 'region_id'=>$region, 'site_id'=>$fm_site_id) );
		}else{
			$data['sites'] = $this->Emp_report_model->getRecordWithcondition( 'site', array('status'=>1, 'region_id'=>$region) );
		}

		$start = strtotime($from_date);
		$end   = strtotime($to_date);
	
		$workdays = 0;

		for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
			$day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
			if ($day != 0 && $day !=6) {
				$workdays++;
			}
		}
		
		$final_data = '';
		$hours_report_data = $this->Emp_report_model->hours_to_sap_report_data($user_id, $from_date, $to_date, $site, $region, $role, $status, $period_closed_hours, $project, $subtask, $emp_id, $sap_code);
		// echo "<pre>"; print_r($hours_report_data); exit;
		foreach($hours_report_data as $report_data){
			
			//Not specific to project_id
			$get_all_hours = $this->Emp_report_model->get_all_hours($report_data->employee_id, $from_date, $to_date);
			$report_data->all_project_hours = $get_all_hours->all_hours;
			$report_data->workdays = $workdays;
			//echo $get_all_hours->all_hours." ** ".WEEKDAYS." ** ".$workdays;
			if($get_all_hours->all_hours != 0){
				$report_data->normalized_hours = round (((( $report_data->total_hours / $get_all_hours->all_hours ) * $report_data->workhours_per_week / WEEKDAYS) * $workdays ), 2 );
			}else{
				$report_data->normalized_hours = 0;
			}
			

			//$final_data
			$final_data = $report_data;
		}

		//echo "<pre>"; print_r($final_data);
		//exit;
		if(!empty($project)){
			$subtask_array = $this->Emp_report_model->getRecordWithcondition(SUBTASK, array(SUB_PROJECT_ID=>$project, STATUS=>1));
		}
               

		$data['hours_report_data'] = $hours_report_data;
		$data['site'] = $site;
		$data['timesheets'] = $role;
		$data['hours_type'] = $hours_type;
		$data['period_closed_hours'] = $period_closed_hours;
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['projects'] = $this->project_model->get_projects($region, $site, 'global');
		$data['emp_id'] = $emp_id;
		$data['project'] = $project;
		$data['sap_code'] = $sap_code;
		$data['subtask'] = $subtask;
		$data['subtask_array'] = $subtask_array;
		$array_user = array();
		if(!empty($region)){
			$array_user['users_role_mapping.region_id'] = $region;
		}

		if(!empty($site)){
			$array_user['users_role_mapping.site_id'] = $site;
		}
		$data['employees'] = $this->users_model->users($role_array, $array_user);

		//echo "<pre>"; print_r($data['employees']); exit;

		$this->load->view('common/header');
		$this->load->view('hours_to_sap_report',$data);
		$this->load->view('common/footer');
	}

	public function get_projects_users(){

		$site = $this->input->post('site_id');
		$role = $this->input->post('role');
		$region = $this->session->userdata('region_id');
		if(empty($role)){
			$role_array = array(3,4);
		}else{
			$role_array = array($role);
		}
		
		$all_projects = $this->project_model->get_projects($region, $site, 'global');
		$all_users = $this->users_model->users($role_array, array('users_role_mapping.site_id'=>$site, 'users.status'=>1));
		$project_options = $user_options = array();

		foreach($all_projects as $project){
	    	$project_options[] = array(
	    		"project_id" => $project->id,
	    		"project_name" => $project->project_name
	    	);
		}

		foreach($all_users as $users){
	    	$user_options[] = array(
	    		"user_id" => $users->user_id,
	    		"user_name" => $users->username
	    	);
		}

		$options['project'] = $project_options;
		$options['user'] = $user_options;
		echo json_encode($options); //exit;
	}

	public function get_users(){
		$site = $this->input->post('site_id');
		$role = $this->input->post('role_id');
		$all_users = $this->users_model->users(array($role), array('users_role_mapping.site_id'=>$site, 'users.status'=>1));
		$user_options = array();

		foreach($all_users as $users){
	    	$user_options[] = array(
	    		"user_id" => $users->user_id,
	    		"user_name" => $users->username
	    	);
		}

		$options['user'] = $user_options;
		echo json_encode($options); //exit;

	}

}