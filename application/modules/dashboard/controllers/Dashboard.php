<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends MY_Controller {
	
	public function __construct() 
	{
		parent::__construct();
		
		$this->load->model('dashboard_model');
		$this->load->model('timesheet/timesheet_model');
		$this->load->model('users/users_model');
		$this->load->model('period_closing/Period_closing_model');
                $this->load->model('project/project_model');
		
	}
	
	public function index() 
	{

		$current_week = date('W');
        $current_year = date('Y');
        
        $firstweekday = date("Y-m-d", strtotime("{$current_year}-W{$current_week}-1")); 
        $lastweekday = date("Y-m-d", strtotime("{$current_year}-W{$current_week}-7")); 
		//insert blank timesheet records for current week, only for engineer and supervisor
		if($this->session->userdata('role_id') == 3 || $this->session->userdata('role_id') == 4){

			$get_user_data = $this->timesheet_model->getById(USER, USER_ID, $this->session->userdata('user_id'));


	        //Check already insert or not
	        $chk_duplicate = $this->timesheet_model->check_duplicate_on_multiCol('timecard', array("employee_id" => $this->session->userdata('user_id'), "start_date" => $firstweekday, "end_date" => $lastweekday ));
	       

	        if($chk_duplicate){
				$timecard['employee_id'] = $this->session->userdata('user_id');
				$timecard['supervisor_id'] = empty($get_user_data->pr_supervisor_id) ? $get_user_data->supervisor_id : $get_user_data->pr_supervisor_id;
				$timecard['status'] = 0;
				$timecard['start_date'] = $firstweekday;
				$timecard['end_date'] = $lastweekday;
				$timecard['created_on'] = date('Y-m-d H:i:s', now());

				$insert_timecard = $this->timesheet_model->insert_Record('timecard', $timecard);

				if($insert_timecard){

					$working_date = date('Y-m-d', strtotime($firstweekday));
					for ($j = 0; $j < 7; $j++) {
						
						$timesheet[$working_date]['timecard_id'] = $insert_timecard;
						$timesheet[$working_date]['project_id'] = 0;
						$timesheet[$working_date]['Subtask_id'] = 0;
						$timesheet[$working_date]['working_date'] = $working_date;
						$timesheet[$working_date]['hours'] = 0;
						$timesheet[$working_date]['created_on'] = date('Y-m-d H:i:s', now());
					

						$working_date = date('Y-m-d', strtotime($working_date . "+1 days"));
					}

					$insert_timesheet = $this->timesheet_model->insert_batch_Record('timesheet', $timesheet);

				}
			}
		}
		//End insert timesheet for week

		if ( ! empty($_GET['from_date']) AND ! empty($_GET['to_date']) ) 
		{
			$firstweekday = date("Y-m-d", strtotime($_GET['from_date']));
			$lastweekday = date("Y-m-d", strtotime($_GET['to_date']));//print_r( $_GET ); exit();
			$date = new DateTime($firstweekday);
			$current_week = $date->format("W");
			$current_year = $date->format("Y");
		}

		$role = $this->session->userdata('role_id');
		$site = $this->session->userdata('site_id');
		$region = $this->session->userdata('region_id');
		$user_id = $this->session->userdata('user_id');

		foreach ($this->session->userdata('menu') as $menu1) 
		{
			
			if ( $menu1->menu_link == 'project' OR $menu1->menu_link == 'assign_project' ) 
			{
				// $data['total_projects_for_estimated'] = $this->dashboard_model->get_total_projects( $role, $site, $region, $firstweekday, $lastweekday );
                                $data['total_projects'] = $this->project_model->get_projects($region, $site,'','',$lastweekday,'dashboard', $firstweekday);

// print_r( $data['total_projects'] ); exit();
				// $data['week_wise_date'] = $this->dashboard_model->get_week_wise_project_data();
			}	
			if ( $menu1->menu_link == 'site' ) 
			{
				$data['total_sites'] = $this->dashboard_model->get_total_sites( $role, $site, $region, $lastweekday );
			}
			if ( $menu1->menu_link == 'region' ) 
			{
				$data['total_regions'] = $this->dashboard_model->get_total_regions( $lastweekday );	
			}
			if ( $menu1->menu_link == 'timesheet/my_timesheet' ) 
			{
				$data['my_projects'] = $this->dashboard_model->get_my_projects( $user_id, $firstweekday, $lastweekday );
			}
			if ( $menu1->menu_link == 'timesheet/others_timesheet' ) 
			{
				$status_counts = $this->dashboard_model->get_status_count( $user_id, $firstweekday, $lastweekday );
				// print_r( $status_counts );
				// exit();
				$c = array();
				if ( ! empty($status_counts) ) 
				{
					$unsubmitted = $pending = $approved = $rejected = 0;
					foreach ($status_counts as $value) 
					{
						if ( $value->tc_status == 1 OR $value->tc_status == 0 ) 
						{
							$unsubmitted = $unsubmitted + 1;
						}	
						elseif ( $value->tc_status == 2 ) 
						{
							$pending = $pending + 1;
						}
						elseif ( $value->tc_status == 3 ) 
						{
							$approved = $approved + 1;
						}
						elseif ( $value->tc_status == 4 ) 
						{
							$rejected = $rejected + 1;
						}
					}
					// foreach ($status_counts as $key => $value) 
					// {
					// 	$c[$value->status] = $value->status_count;
					// }
					$c[1] = $unsubmitted;
					$c[2] = $pending;
					$c[3] = $approved;
					$c[4] = $rejected;
				}
				$data['status_counts'] = $c;
			}
			if ( $menu1->menu_link == 'users' )
			{
				$data['users_details'] = $this->dashboard_model->get_total_users( $user_id, $role, $lastweekday );
				// $cond_query = array('users_role_mapping.region_id'=>$region, 'users_role_mapping.site_id'=>$site);
				// $data['users_details'] = $this->users_model->users(array(3), $cond_query, $lastweekday, $user_id);
			}
			if ( $menu1->menu_link == 'assign_project' )
			{
				$data['total_project_hours'] = $this->dashboard_model->get_total_project_hours( $region, $site,'','','','dashboard' );
			}

		}

		//for finance manager
		if ( $role == 7 ) 
		{
			$data['supervisor_data'] = $this->dashboard_model->get_users_by_role( 3, $lastweekday );
			$supervisor_timesheet_data = $this->dashboard_model->get_timesheet_data_by_role( 3, $firstweekday, $lastweekday );
			$supervisor_submited = $supervisor_unsubmited = $engineer_submited = $engineer_unsubmited = 0;
			foreach ($supervisor_timesheet_data as $value) 
			{
				if ( $value->tc_status == 3 OR $value->tc_status == 2 ) 
				{
					$supervisor_submited = $supervisor_submited + 1;
				}	
				else {
					$supervisor_unsubmited = $supervisor_unsubmited + 1;
				}
			}
			$data['supervisor_submited'] = $supervisor_submited;
			$data['supervisor_unsubmited'] = $supervisor_unsubmited;

			$data['engineer_data'] = $this->dashboard_model->get_users_by_role( 4, $lastweekday );
			$engineer_timesheet_data = $this->dashboard_model->get_timesheet_data_by_role( 4, $firstweekday, $lastweekday );
			foreach ($engineer_timesheet_data as $value1) 
			{
				if ( $value1->tc_status == 3 OR $value1->tc_status == 2 ) 
				{
					$engineer_submited = $engineer_submited + 1;
				}	
				else {
					$engineer_unsubmited = $engineer_unsubmited + 1;
				}
			}
			$data['engineer_submited'] = $engineer_submited;
			$data['engineer_unsubmited'] = $engineer_unsubmited;
		}

		if ( $role == 3 ) 
		{
			$data['supervisors_engineers'] = $this->dashboard_model->get_users_by_role( 4, $lastweekday, 1 );
		}
		$data['current_week'] = $current_week;
		$data['firstweekday'] = $firstweekday;
		$data['lastweekday'] = $lastweekday;
		$data['current_year'] = $current_year;

		//Check Period is closed or not
		$close_flag = array();

		$startdate = date("Y-m-d", strtotime($firstweekday)); 
		for($i=0;$i<6;$i++){
			$period_close = $this->Period_closing_model->check_period_closed($startdate, $this->session->userdata('region_id'));
			if(!empty($period_close)){
				$close_flag['status'] = $period_close->status;
				$close_flag['start'] = $period_close->from_date;
				$close_flag['end'] = $period_close->to_date;
				break;
			} 
			$startdate = date('Y-m-d', strtotime($startdate . ' +1 day')); 
		}
		//echo $close_flag;
		//echo "<pre>"; print_r($close_flag); //exit;
		$data['close_flag'] = $close_flag;
		//End

		$data['title'] = "Dashboard";
		$this->load->view('common/header');
		$this->load->view('dashboard', $data);
		$this->load->view('common/footer');

	}

	public function project_timesheet($project_id)
	{
		$user_id = $this->session->userdata('user_id');
		$from_date = $_GET['from_date'];
		$to_date = $_GET['to_date'];

		$my_timesheet = $this->dashboard_model->project_timesheet_of_user( $user_id, $project_id, $from_date, $to_date );
		$data1 = [];
		foreach($my_timesheet as $array) 
		{
			//$data1[$array->project_id][] = $array;
			$data1[$array->project_id][$array->subtask_id][] = $array;
		}
		
		$data['my_timesheet'] = $data1;
		$data['start_date'] = $from_date;
		$data['end_date'] = $to_date;
		
		$data['title'] = "Dashboard";
		$this->load->view('common/header');
		$this->load->view('dashboard_my_timesheet', $data);
		$this->load->view('common/footer');

		// echo "<pre>"; print_r( $data1 ); exit();
	}
	

	public function status_vise_users($status='',$role='')
	{
		if ( ! empty($_GET['from_date']) AND ! empty($_GET['to_date']) ) 
		{
			$firstweekday = date("Y-m-d", strtotime($_GET['from_date']));
			$lastweekday = date("Y-m-d", strtotime($_GET['to_date']));
			$date = new DateTime($firstweekday);
			$current_week = $date->format("W");
		}

		if ( $role == 3 ) 
		{
			$data['title'] = 'supervisors';
		}
		else
		{
			$data['title'] = 'Engineers';
		}
		$timesheet_data = $this->dashboard_model->get_timesheet_data_by_role( $role, $firstweekday, $lastweekday );

		$users = array();
		if ( $status == 1 ) //all submitted timesheet users 
		{
			foreach ($timesheet_data as $value1) 
			{
				if ( $value1->tc_status == 3 OR $value1->tc_status == 2 ) 
				{
					$users[] = $value1;
				}	
			}
		}
		else
		{
			foreach ($timesheet_data as $value1) 
			{
				if ( $value1->tc_status == 1 OR $value1->tc_status == 4 OR empty($value1->tc_status) ) 
				{
					$users[] = $value1;
				}	
			}	
		}

		$data['users'] = $users;

		$this->load->view('common/header');
		$this->load->view('timesheet_status_vise_users', $data);
		$this->load->view('common/footer');
	}

	public function view_all_users_of_role($role_id)
	{
		if ( $role_id == 3 ) {
			$data['title'] = 'Active Supervisors';
		}
		else if( $role_id == 4 )
		{
			$data['title'] = 'Active Engineers';
		}else if( $role_id == 2 ){
			$data['title'] = 'Active Admins';
		}else {
			$data['title'] = 'Active Users';
		}
		if ( $this->session->userdata('role_id') == 1 ) 
		{
			$data['users'] = $this->dashboard_model->get_users_by_role($role_id, $_GET['to_date']);
		}
		else
		{
			$data['users'] = $this->dashboard_model->get_users_by_role($role_id, $_GET['to_date'],1);	
		}
		//echo "<pre>"; print_r($data['users']); exit;
		$data['get_values'] = '?from_date='.$_GET['from_date'].'&to_date='.$_GET['to_date'];
		$this->load->view('common/header');
		$this->load->view('view_all_users', $data);
		$this->load->view('common/footer');

	}

	public function getStartAndEndDate() {
	  $week = $this->input->post('week');
	  $year = $this->input->post('year');
	  $dto = new DateTime();
	  $dto->setISODate($year, $week);
	  $ret['week_start'] = $dto->format('d M');
	  $ret['weekstart'] = $dto->format('Y-m-d');
	  $dto->modify('+6 days');
	  $ret['week_end'] = $dto->format('d M');
	  $ret['weekend'] = $dto->format('Y-m-d');
	  //echo "<pre>"; print_r($ret); exit;
	  echo json_encode($ret);
	}
	
	public function users_list_timesheet($status='')
	{
		$from_date = $_GET['from_date'];
		$to_date = $_GET['to_date'];
		$user_id = $this->session->userdata('user_id');

		$data['title'] = 'Users';
		$data['users'] = $this->dashboard_model->get_status_count( $user_id, $from_date, $to_date, $status );

		// print_r( $status_counts ); exit();

		$this->load->view('common/header');
		$this->load->view('team_timesheet_user_list', $data);
		$this->load->view('common/footer');

	}

	
}