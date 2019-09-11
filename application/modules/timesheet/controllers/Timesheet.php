
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timesheet extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('timesheet_model');
		$this->load->model('region/region_model');
		$this->load->model('login/login_model');
		$this->load->model('users/users_model');
		$this->load->model('project/project_model');
		$this->load->model('roles/roles_model');
		$this->load->model('period_closing/Period_closing_model');
		$this->load->helper('url');
	}

	public function index()
	{

		$data['title'] = "Timesheet";
		$region = $site = $type = $allsites = '';
		$my_timesheet = $subtasks = $lastweekday = '';
		//echo $this->uri->segment(3)." * ".$this->uri->segment(2); exit;

		if(!empty($this->uri->segment(4))) {
			$timecard = $this->timesheet_model->getByID('timecard', 'timecard_id', $this->uri->segment(4));
			$data['timecard'] = $timecard;
			$my_timesheet = $this->timesheet_model->getMyTimesheet($this->uri->segment(4), $timecard->start_date, $timecard->end_date,$this->session->userdata('user_id'));	
			//echo "<pre>"; print_r($my_timesheet); exit;
			$data1 = [];
			
			foreach($my_timesheet as $array) 
			{
				//$data1[$array->project_id][] = $array;
				//echo "<pre>"; print_r($array); exit;
				/*$period_close = $this->Period_closing_model->check_period_closed($array->working_date, $this->session->userdata('site_id'));
				if($period_close == 0){
					$allclose_flag = 0;
				}else{
					$close_flag = 1;
				}
				$array->period_closed = $period_close;*/
				//$data1[$array->project_id][$array->subtask_id]['period_closed'] = $period_close;
				$data1[$array->project_id][$array->subtask_id][] = $array;
			}
			
			$data['my_timesheet'] = $data1;
			// $subtasks[]='';
			foreach ($data1 as $key => $value) {
				if ( ! empty($key) ) {
					$subtasks[$key] = $this->timesheet_model->getAssignedSubtask( $key, $this->session->userdata('user_id') );
				}
			}
			$data['subtasks'] = $subtasks;

			$lastweekday = $timecard->start_date;

			//Check Period is closed or not
			$close_flag = array();

			$startdate = date("Y-m-d", strtotime($timecard->start_date)); 
			for($i=0;$i<6;$i++){
				$period_close = $this->Period_closing_model->check_period_closed($startdate, $this->session->userdata('region_id'), 1);
				if(!empty($period_close)){
					$close_flag['status'] = $period_close->status;
					$close_flag['start'] = $period_close->from_date;
					$close_flag['end'] = $period_close->to_date;
					break;
				} 
				$startdate = date('Y-m-d', strtotime($startdate . ' +1 day')); 
			}
			//echo $close_flag;
			
			$data['close_flag'] = $close_flag;
			//End 
			
			// echo "<pre>";
			// print_r($data);
			// exit;
		}

		//$data['projects'] = $this->timesheet_model->timesheet($region, $site, $type);
		$data['regions'] = $this->region_model->region();
		$data['Allsites'] = $allsites;
		$data['projects'] = $this->project_model->get_users_project($this->session->userdata('user_id'), $lastweekday);
		$data['mytimesheet'] = $my_timesheet;
		 //echo "<pre>"; print_r($this->uri->segment(3)); exit;

		$this->load->view('common/header');
		$this->load->view('timesheet',$data);
		$this->load->view('common/footer');	
		
 		
	}

	public function getsubtasks(){
		// print_r( $_POST );
		$project_id = $this->input->post('project_id');
		if ( ! array_key_exists('user_id', $_POST) ) 
		{
			$user_id = $this->session->userdata('user_id');
		}
		else
		{
			$user_id = $this->input->post('user_id');
		}
		$subtask_array = $this->timesheet_model->getAssignedSubtask($project_id, $user_id);
		//echo "<pre>"; print_r($subtask_array); exit;
		//echo "";
		$subtask_opt = array();
		if(!empty($subtask_array)){

			foreach((array)$subtask_array['result'] as $subtask){
		    	$subtask_opt[] = array(
		    		"subtask_id" => $subtask->subtask_id,
		    		"subtask_name" => $subtask->subtask_name
		    	);
			}
			$end_date = $subtask_array['end_date'];
			$start_date = $subtask_array['start_date'];
		}
		$data['subtask_opt'] = $subtask_opt;
		$data['end_date'] = !empty($end_date) ? $end_date : '';
		$data['start_date'] = !empty($start_date) ? $start_date : '';
		$data['holiday_projects'] = HOLIDAY_PROJECTS;

		echo json_encode($data); //exit;
	}

	public function submit_timesheet(){
		
		$timecard_id = $this->input->post('timecard_id');
		$supervisor_id_fixed = '';
		$get_user_data = $this->timesheet_model->getById(USER, USER_ID, $this->input->post('user_id'));
		if ( !empty($get_user_data->pr_supervisor_id) ) 
		{
			$supervisor_id_fixed = $get_user_data->pr_supervisor_id;
		}
		elseif( !empty($get_user_data->supervisor_id) )
		{
			$supervisor_id_fixed = $get_user_data->supervisor_id;	
		}
		if($get_user_data->supervisor_id == 0 AND $get_user_data->pr_supervisor_id == 0){
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to insert timesheet. No supervisor is assigned to you.</div>');
			redirect( '/timesheet/my_timesheet', $data );
			return false;
		}
		//echo "<pre>"; print_r($_POST); exit;
		$total_rec = $this->input->post('addrowcount'); 
		//$total_rec = count($this->input->post('selectProject'));
		
		$get_user_data->supervisor_id = $supervisor_id_fixed;

		$timecard['status'] = $this->input->post('timecard_submit_btn');
		$timecard['updated_on'] = date('Y-m-d H:i:s', now());
		$timecard['supervisor_id'] = $get_user_data->supervisor_id;
		
		//$get_timecard_data = $this->timesheet_model->getById('timecard', 'timecard_id', $timecard_id);
		
		$update_timecard = $this->timesheet_model->update_Record('timecard', $timecard, array('timecard_id'=>$timecard_id));

		if($update_timecard){

			//Delete one entry of timesheet
			$del = $this->timesheet_model->deleteRecord('timesheet', array('timecard_id'=>$timecard_id));
			//echo "<pre>"; print_r($_POST); exit;

			$k=0; $z=0;
			for($i=0; $i<$total_rec; $i++){ 
				
				if( array_key_exists($i, $_POST['selectProject']) ){

					$working_date = date('Y-m-d', strtotime($_POST['start_date'])); 
					for ($j = 0; $j < 7; $j++) {

						$timesheet[$i][$working_date]['timecard_id'] = $timecard_id;
						$timesheet[$i][$working_date]['project_id'] = $_POST['selectProject'][$i];
						$timesheet[$i][$working_date]['Subtask_id'] = $_POST['selectSubtask'][$i];
						$timesheet[$i][$working_date]['working_date'] = $working_date;
						$timesheet[$i][$working_date]['hours'] = (isset($_POST["hour_$j"][$i])) ? $_POST["hour_$j"][$i] : 0;
						$timesheet[$i][$working_date]['created_on'] = date('Y-m-d H:i:s', now());

						$timesheet_rec[$k] = $timesheet[$i][$working_date];
						$k++;

						$working_date = date('Y-m-d',strtotime($working_date . "+1 days"));
					}$z++;
				}
			} 
			//echo "<pre>"; print_r($z); exit;
			$insert_timesheet = $this->timesheet_model->insert_batch_Record('timesheet', $timesheet_rec);

			//Send Notification to supervisor after submit
			if(!empty($this->input->post('timecard_submit_btn')) && $this->input->post('timecard_submit_btn') == 2){

				$notification_array = array('notification_from' => $this->input->post('user_id'),
											'notification_to' => $get_user_data->supervisor_id, 
											'notification' => $get_user_data->first_name.' '.$get_user_data->last_name. ' Has Submitted Timesheet for Week No. '.date('W', strtotime($_POST['start_date'])),
											'request' => 'timesheet',
											'status' => 0,
											'assign_by' =>  $this->session->userdata('user_id'),
											'request_id' =>  $timecard_id,
											'from_date' => date('Y-m-d', strtotime($_POST['start_date'])),
											'to_date' => date('Y-m-d', strtotime($_POST['end_date'])),
											'created_on' => date('Y-m-d H:i:s', now())
											 );
				$this->timesheet_model->insert_Record('notification', $notification_array);
			}
			if($this->input->post('timecard_submit_btn') == 1) $message = 'Saved';
			else $message = 'Submitted';

			$this->session->set_flashdata('message', '<div class="alert alert-success">'.$message.' Successfully!</div>');
			redirect( '/timesheet/my_timesheet', $data );
			return false;
		} else{

			$this->session->set_flashdata('message', '<div class="alert alert-success">
				!</div>');
			redirect( '/timesheet/my_timesheet', $data );
			return false;
		}
		
		//insert into timesheet
		//echo $insert_timecard;
			
	}

	public function submit_timesheet_next_prev(){
		
		$get_user_data = $this->timesheet_model->getById(USER, USER_ID, $this->input->post('user_id'));
		$timecard_id = $this->input->post('timecard_id');

		if ( !empty($get_user_data->pr_supervisor_id) ) 
		{
			$supervisor_id_fixed = $get_user_data->pr_supervisor_id;
		}
		elseif( !empty($get_user_data->supervisor_id) )
		{
			$supervisor_id_fixed = $get_user_data->supervisor_id;	
		}

		if($get_user_data->supervisor_id == 0 AND $get_user_data->pr_supervisor_id == 0){
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to insert timesheet. No supervisor is assigned to you.</div>');
			redirect( '/timesheet', $data );
			return false;
		}

		$total_rec = $this->input->post('addrowcount');
		
		$timecard['status'] = $this->input->post('timecard_submit_btn');

		$get_user_data->supervisor_id = $supervisor_id_fixed;
		$working_date = '';
		//If timecard entry is already in database, need to update
		if($timecard_id){

			$timecard['supervisor_id'] = $get_user_data->supervisor_id;
			
			$timecard['updated_on'] = date('Y-m-d H:i:s', now());
			$update_timecard = $this->timesheet_model->update_Record('timecard', $timecard, array('timecard_id'=>$timecard_id));

			if($update_timecard){

				//Delete one entry of timesheet
				$del = $this->timesheet_model->deleteRecord('timesheet', array('timecard_id'=>$timecard_id));
				//echo "<pre>"; print_r($_POST); exit;

				$k=0;
				for($i=0; $i<$total_rec; $i++){
					if( array_key_exists($i, $_POST['selectProject']) ){
						$working_date = date('Y-m-d', strtotime($_POST['start_date']));
						for ($j = 0; $j < 7; $j++) {
							$timesheet[$i][$working_date]['timecard_id'] = $timecard_id;
							$timesheet[$i][$working_date]['project_id'] = $_POST['selectProject'][$i];
							$timesheet[$i][$working_date]['Subtask_id'] = $_POST['selectSubtask'][$i];
							$timesheet[$i][$working_date]['working_date'] = $working_date;
							$timesheet[$i][$working_date]['hours'] = (isset($_POST["hour_$j"][$i])) ? $_POST["hour_$j"][$i] : 0;
							$timesheet[$i][$working_date]['created_on'] = date('Y-m-d H:i:s', now());

							$timesheet_rec[$k] = $timesheet[$i][$working_date];
							$k++;

							$working_date = date('Y-m-d',strtotime($working_date . "+1 days"));
						}
					}
				}
				$insert_timesheet = $this->timesheet_model->insert_batch_Record('timesheet', $timesheet_rec);
			}
		}else{ //Insert New timecard Entry

			$firstweekday = date('Y-m-d', strtotime($_POST['start_date']));
			$lastweekday = date('Y-m-d', strtotime($_POST['end_date']));

			//Check already insert or not
	        $chk_duplicate = $this->timesheet_model->check_duplicate_on_multiCol('timecard', array("employee_id" => $this->session->userdata('user_id'), "start_date" => $firstweekday, "end_date" => $lastweekday ));
	       

	        if($chk_duplicate){
				$timecard['employee_id'] = $this->session->userdata('user_id');
				
				$timecard['supervisor_id'] = $get_user_data->supervisor_id;
				
				// $timecard['supervisor_id'] = $get_user_data->supervisor_id;
				$timecard['status'] = $this->input->post('timecard_submit_btn');
				$timecard['start_date'] = $firstweekday;
				$timecard['end_date'] = $lastweekday;
				$timecard['created_on'] = date('Y-m-d H:i:s', now());
				$total_rec = $this->input->post('addrowcount');
				$insert_timecard = $this->timesheet_model->insert_Record('timecard', $timecard);

				if($insert_timecard){

					$k=0;
					for($i=0; $i<$total_rec; $i++){
						if( array_key_exists($i, $_POST['selectProject']) ){
							$working_date = $firstweekday;
							for ($j = 0; $j < 7; $j++) {
								$timesheet[$i][$working_date]['timecard_id'] = $insert_timecard;
								$timesheet[$i][$working_date]['project_id'] = $_POST['selectProject'][$i];
								$timesheet[$i][$working_date]['Subtask_id'] = $_POST['selectSubtask'][$i];
								$timesheet[$i][$working_date]['working_date'] = $working_date;
								$timesheet[$i][$working_date]['hours'] = (isset($_POST["hour_$j"][$i])) ? $_POST["hour_$j"][$i] : 0;
								$timesheet[$i][$working_date]['created_on'] = date('Y-m-d H:i:s', now());

								$timesheet_rec[$k] = $timesheet[$i][$working_date];
								$k++;

								$working_date = date('Y-m-d',strtotime($working_date . "+1 days"));
							}
						}
					}

					$insert_timesheet = $this->timesheet_model->insert_batch_Record('timesheet', $timesheet_rec);
				}
			}

			$timecard['created_on'] = date('Y-m-d H:i:s', now());
		}

		if(!empty($get_user_data)){

			//Send Notification to supervisor after submit
			if(!empty($this->input->post('timecard_submit_btn')) && $this->input->post('timecard_submit_btn') == 2){

				$notification_array = array('notification_from' => $this->input->post('user_id'),
											'notification_to' => $get_user_data->supervisor_id, 
											'notification' => $get_user_data->first_name.' '.$get_user_data->last_name. 'Has Submitted Timesheet for Week No. '.date('W', strtotime($_POST['start_date'])),
											'request' => 'timesheet',
											'status' => 0,
											'assign_by' =>  $this->session->userdata('user_id'),
											'request_id' => $insert_timecard,
											'from_date' => date('Y-m-d', strtotime($_POST['start_date'])),
											'to_date' => date('Y-m-d', strtotime($_POST['end_date'])),
											'created_on' => date('Y-m-d H:i:s', now())
											 );
				$this->timesheet_model->insert_Record('notification', $notification_array);
			}

			
			$this->session->set_flashdata('message', '<div class="alert alert-success">Saved Successfully!</div>');
				redirect( '/timesheet/my_timesheet', $data );
				return false;

		}else{

			$this->session->set_flashdata('message', '<div class="alert alert-success">Failed!</div>');
				redirect( '/timesheet/my_timesheet', $data );
				return false;
		}

		//echo "<pre>"; print_r($timesheet_rec);	
	}

	public function my_timesheet(){
		$data['title'] = "My Timesheet";

		//echo "<pre>"; print_r($_POST); exit;
		
		if(!empty($_POST)){ 
			$from = $this->input->post('from_date');
			$to = $this->input->post('to_date');
			$status = $this->input->post('status');
		}else{
			$from = date("Y-m-d", strtotime("-1 months"));
			$to = date("Y-m-d", strtotime("+1 months"));
			$status = '';
		}

		$all_timesheets = $this->timesheet_model->getMyTimesheet('', $from, $to, $this->session->userdata('user_id'), $status);

//		$period_closed_dates = $this->Period_closing_model->get_period_closed_dates($this->session->userdata('site_id'));
		//echo "<pre>"; print_r($period_closed_dates); exit;

		$data['selected_from'] = $from; 
		$data['selected_to'] = $to;
		$data['selected_status'] = $status;
		$data['mytimesheets'] = $all_timesheets;
		$this->load->view('common/header');
		$this->load->view('my_timesheet',$data);
		$this->load->view('common/footer');	
	}

	public function next_week_timesheet(){

		$data['title'] = "Timesheet";
		$region = $site = $type = $allsites = '';
		$my_timesheet = $subtasks = '';
		$date =  $this->uri->segment(3);
		$data['start_date'] = date("Y-m-d", $date); 
		$date_now = date("Y-m-d");
		$next_prev_check = ($date_now < $data['start_date']) ? 'next' : 'prev';
		
		$data['user_id'] =  $this->session->userdata('user_id'); 
		$checkfor_timesheet = $this->timesheet_model->checkfor_timesheet($data['user_id'], $data['start_date']);
		if(!empty($checkfor_timesheet)){
			
			$timecard = $checkfor_timesheet;
			$data['timecard'] = $timecard;
			$my_timesheet = $this->timesheet_model->getMyTimesheet($timecard->timecard_id, $timecard->start_date, $timecard->end_date,$this->session->userdata('user_id'));	
			//echo "<pre>"; print_r($my_timesheet); exit;
			$data1 = [];
			$allclose_flag = 1;
			$close_flag = 0;
			foreach($my_timesheet as $array) 
			{
				//$data1[$array->project_id][] = $array;
				//For period close dates
				/*$period_close = $this->Period_closing_model->check_period_closed($array->working_date, $this->session->userdata('site_id'));
				if($period_close == 0){
					$allclose_flag = 0;
				}
				if($period_close == 1){
					$close_flag = 1;
				}
				$array->period_closed = $period_close;*/

				$data1[$array->project_id][$array->subtask_id][] = $array;
			}
			
			$data['my_timesheet'] = $data1;
			// $subtasks[]='';
			foreach ($data1 as $key => $value) {
				if ( ! empty($key) ) {
					$subtasks[$key] = $this->timesheet_model->getAssignedSubtask( $key, $this->session->userdata('user_id') );
				}
			}
			$data['subtasks'] = $subtasks;
			$data['allclose_flag'] = $allclose_flag;
			$data['close_flag'] = $close_flag;
		}
		//echo "<pre>"; print_r($timesheet_data); exit;
		$data['regions'] = $this->region_model->region();
		$data['Allsites'] = $allsites;
		$lastweekday = date('Y-m-d',strtotime($data['start_date']));
		$data['projects'] = $this->project_model->get_users_project($this->session->userdata('user_id'), $lastweekday, $next_prev_check);
		$data['mytimesheet'] = $my_timesheet;
		$data['next_prev_check'] = $next_prev_check;

		//Check Period is closed or not
		$close_flag = array();

		$startdate = date("Y-m-d", $date);
		for($i=0;$i<6;$i++){
			$period_close = $this->Period_closing_model->check_period_closed($startdate, $this->session->userdata('region_id'), 1);
			if(!empty($period_close)){
				$close_flag['status'] = $period_close->status;
				$close_flag['start'] = $period_close->from_date;
				$close_flag['end'] = $period_close->to_date;
				break;
			} 
			$startdate = date('Y-m-d', strtotime($startdate . ' +1 day')); 
		}
		$data['close_flag'] = $close_flag;
		//End 

		$this->load->view('common/header');
		$this->load->view('next_timesheet',$data);
		$this->load->view('common/footer');	
	}

	

	public function others_timesheet()
	{
		$status = $emp_id = $from = $to = '';
		
		$now = date( "Y-m-d", strtotime( date("Y-m-d") ) );
        $last_month = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
        
        $last_date = new DateTime($last_month);
		$last_week = $last_date->format("W");
		$last_year = $last_date->format("Y");
		$from = date("Y-m-d", strtotime("{$last_year}-W{$last_week}-1")); 

		$now_date = new DateTime($now);
		$now_week = $now_date->format("W");
		$now_year = $now_date->format("Y");
		$to = date("Y-m-d", strtotime("{$now_year}-W{$now_week}-1"));

        
		$user_id = $this->session->userdata('user_id');

		$data['title'] = 'Team Timesheet';

		//For assign project permission roles
		$login_user = $this->roles_model->roles($this->session->userdata('role_id'));
		$role_data='';
		$selected_role = '';
		if(!empty($login_user[0]->assign_project_permission)){ 
			$permissions = json_decode($login_user[0]->assign_project_permission);
			$role_data = $this->roles_model->get_role_data('role', $permissions);
			//echo "<pre>"; print_r($role_data); exit;
			if(count($role_data) == 1){
				$selected_role = $role_data[0]->role_id;
			}
		}
		$assign_to = $selected_role;

		$status = 2;

		if ( ! empty( $_GET ) ) 
		{
			$status = $_GET['status'];
			$emp_id = $_GET['emp_id'];
			$from = $_GET['from_date'];
			$to = $_GET['to_date'];
			$assign_to = $_GET['to_date'];
		}

		
		//$data['assign_to'] = $assign_to;
		$data['selected_role']  = $selected_role;
		$data['assign_permission'] = $role_data;

		$data['mytimesheets'] = $this->timesheet_model->get_engineers_timesheet( $emp_id, $status, $from, $to, $permissions );
		$data['employee_list'] = $this->timesheet_model->get_my_engineers( $user_id, $permissions );
		//echo "<pre>"; print_r($data['mytimesheets']);exit();
		$data['status'] = $status;
		$data['emp_id'] = $emp_id;
		$data['from'] = $from;
		$data['to'] = $to;


		$this->load->view('common/header');
		$this->load->view('supervisor/timecard_list',$data);
		$this->load->view('common/footer');	
	}

	public function timecards( $user_id='', $status='' ){
		if ( empty($status) || empty($user_id) ) 
		{
			return false;
		}
		
        // $timesheet_status='';
        switch ( $status ) {
            case '1':
                $data['title'] = "Saved Timesheets";
                break;

            case '2':
                $data['title'] = 'Submited Timesheets';
                break;
            
            case '3':
                $data['title'] = 'Approved Timesheets';
                break;

            case '4':
                $data['title'] = 'Rejected Timesheets';
                break;
            default:
                $data['title'] = 'Pending Submission';
                break;
        }
                            
		// $data['title'] = "Engineers/Supervisors Timecards";
		$all_timesheets = $this->timesheet_model->get_timecards_by_status( $user_id, $status );
		//echo "<pre>"; print_r($all_timesheets); exit;
		$data['mytimesheets'] = $all_timesheets;
		$this->load->view('common/header');
		$this->load->view('supervisor/timecard_list',$data);
		$this->load->view('common/footer');	
	}

	public function others_timesheet_details($user_id='', $timecard_id='')
	{
		if ( empty( $user_id ) || empty( $timecard_id ) ) 
		{
			return false;
		}
		$region = $site = $type = $allsites = '';
		$timecard = $this->timesheet_model->getByID('timecard', 'timecard_id', $timecard_id);
		$data['timecard'] = $timecard;
		$my_timesheet = $this->timesheet_model->getMyTimesheet($timecard_id, $timecard->start_date, $timecard->end_date,$user_id);	
		 //echo "<pre>"; print_r($my_timesheet); exit;
		$data1 = [];

		//$user_detail = $this->users_model->get_user_mapping_data($user_id);

		foreach($my_timesheet as $array) 
		{
			//$data1[$array->project_id][] = $array;
			
			if($array->working_date > $array->end_date || $array->working_date < $array->start_date){
				$array->disabled = 1;
			}else{
				$array->disabled = 0;
			}
			$data1[$array->project_id][$array->subtask_id][] = $array;
		}

		//echo "<pre>"; print_r($data1); exit; 
		
		$data['my_timesheet'] = $data1;
		$subtasks[]='';
		foreach ($data1 as $key => $value) {
			if ( ! empty($key) ) {
				$subtasks[$key] = $this->timesheet_model->getAssignedSubtask( $key, $user_id );
			}
		}
		$data['subtasks'] = $subtasks;

		$data['regions'] = $this->region_model->region();
		$data['Allsites'] = $allsites;

		$timecard_end_date = date('Y-m-d', strtotime($timecard->start_date));
		$data['projects'] = $this->project_model->get_users_project($user_id, $timecard_end_date);

		$data['mytimesheet'] = $my_timesheet;
		$data['user_id'] = $user_id;

		//Check Period is closed or not
		$close_flag = array();

		$startdate = date("Y-m-d", strtotime($timecard->start_date)); 
		for($i=0;$i<6;$i++){
			$period_close = $this->Period_closing_model->check_period_closed($startdate, $this->session->userdata('region_id'), 1);
			if(!empty($period_close)){
				$close_flag['status'] = $period_close->status;
				$close_flag['start'] = $period_close->from_date;
				$close_flag['end'] = $period_close->to_date;
				break;
			} 
			$startdate = date('Y-m-d', strtotime($startdate . ' +1 day')); 
		}
		//echo $close_flag;
		
		$data['close_flag'] = $close_flag;
		//End
		
		$this->load->view('common/header');
		$this->load->view('supervisor/timesheet',$data);
		$this->load->view('common/footer');	
	}

	public function update_timesheet_by_supervisor(){
		
		$timecard_id = $this->input->post('timecard_id');
		$supervisor_id_fixed = '';
		$get_user_data = $this->timesheet_model->getById(USER, USER_ID, $this->input->post('user_id'));

		if ( !empty($get_user_data->pr_supervisor_id) ) 
		{
			$supervisor_id_fixed = $get_user_data->pr_supervisor_id;
		}
		elseif( !empty($get_user_data->supervisor_id) )
		{
			$supervisor_id_fixed = $get_user_data->supervisor_id;	
		}

		if($get_user_data->supervisor_id == 0 AND $get_user_data->pr_supervisor_id == 0){
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to insert timesheet. No supervisor is assigned to you.</div>');
			redirect( '/timesheet/others_timesheet', $data );
			return false;
		}

		$get_user_data->supervisor_id = $supervisor_id_fixed;
		
		$total_rec = $this->input->post('addrowcount');
		
		//$timecard['status'] = $this->input->post('timecard_submit_btn');
		$timecard['updated_on'] = date('Y-m-d H:i:s', now());

		$update_timecard = $this->timesheet_model->update_Record('timecard', $timecard, array('timecard_id'=>$timecard_id));

		if($update_timecard){

			//Delete one entry of timesheet
			$del = $this->timesheet_model->deleteRecord('timesheet', array('timecard_id'=>$timecard_id));
			//echo "<pre>"; print_r($_POST); exit;

			$k=0;
			for($i=0; $i<$total_rec; $i++){
				if( array_key_exists($i, $_POST['selectProject']) ){
					$working_date = date('Y-m-d H:i:s', strtotime($_POST['start_date']));
					for ($j = 0; $j < 7; $j++) {
						$timesheet[$i][$working_date]['timecard_id'] = $timecard_id;
						$timesheet[$i][$working_date]['project_id'] = $_POST['selectProject'][$i];
						$timesheet[$i][$working_date]['Subtask_id'] = $_POST['selectSubtask'][$i];
						$timesheet[$i][$working_date]['working_date'] = $working_date;
						$timesheet[$i][$working_date]['hours'] = (isset($_POST["hour_$j"][$i])) ? $_POST["hour_$j"][$i] : 0;
						$timesheet[$i][$working_date]['created_on'] = date('Y-m-d H:i:s', now());

						$timesheet_rec[$k] = $timesheet[$i][$working_date];
						$k++;

						$working_date = date('Y-m-d H:i:s',strtotime($working_date . "+1 days"));
					}
				}	
			}
			//echo "<pre>"; print_r($timesheet_rec); exit;
			$insert_timesheet = $this->timesheet_model->insert_batch_Record('timesheet', $timesheet_rec);

			//Send Notification to supervisor after submit
			
			$get_supervisor_data = $this->timesheet_model->getById(USER, USER_ID, $this->session->userdata('user_id'));
			$notification_array = array('notification_from' => $this->session->userdata('user_id'),
										'notification_to' => $this->input->post('user_id'), 
										'notification' => $get_supervisor_data->first_name.' '.$get_supervisor_data->last_name. ' Has Updated Timesheet for Week No. '.date('W', strtotime($_POST['start_date'])),
										'request' => 'timesheet',
										'request_id' => $timecard_id,
										'status' => 0,
										'assign_by' =>  $this->session->userdata('user_id'),
										'created_on' => date('Y-m-d H:i:s', now())
										 );
			$this->timesheet_model->insert_Record('notification', $notification_array);
			

			$this->session->set_flashdata('message', '<div class="alert alert-success">Updated Successfully!</div>');
			redirect( '/timesheet/others_timesheet', $data );
			return false;
		}else{

			$this->session->set_flashdata('message', '<div class="alert alert-success">Failed!</div>');
			redirect( '/timesheet/others_timesheet', $data );
			return false;
		}
		
		//insert into timesheet
		//echo $insert_timecard;
			
	}

	public function change_status()
	{
		if ( ! empty( $_POST['where'] ) || ! empty( $_POST['table'] ) || ! isset( $_POST['value'] ) || ! empty( $_POST['column'] ) ) 
		{
			if ( $this->timesheet_model->change_status( $_POST['table'], $_POST['column'], $_POST['where'], $_POST['value'] ) ) 
			{
				$notification_data = $this->timesheet_model->getById('notification', 'request_id',  $_POST['where']);
				//print_r($notification_data); exit();
				if($_POST['value']==3){
					$status = 'Approved';
					$noti_sts = '2'; //Notification sttaus 2 = approve
				}else{
					$status = 'Rejected';
					$noti_sts = '3'; //Notification sttaus 3 = reject
				}

				//echo "<pre>"; print_r($notification_data); exit;

				//Update notification status 
				$update_arr = array('status'=>$noti_sts);
				$update_on = array('request_id'=>$_POST['where']);
				$this->timesheet_model->update_Record('notification', $update_arr, $update_on);

				//echo $this->db->last_query(); 
				//Insert notification for approved/reject
				$notification_array = array('notification_from' => $this->session->userdata('user_id'),
										'notification_to' => $notification_data->notification_from, 
										'notification' => 'Your Timesheet has been '.$status. ' for week number '.date('W', strtotime($notification_data->from_date)),
										'request' => 'timesheet_response',
										'status' => 0,
										'from_date' => $notification_data->from_date,
										'to_date' => $notification_data->to_date,
										'assign_by' =>  $this->session->userdata('user_id'),
										'created_on' => date('Y-m-d H:i:s', now())
										 );
				$this->timesheet_model->insert_Record('notification', $notification_array);
				$data = ['success' => 1]; 
			
				$this->output
					->set_content_type('application/json')
			        ->set_output(json_encode($data));		
			}
		}
	}

	//For Finance Manager, For Employee Hours Report, only view purpose
	public function view_timesheet_details($user_id='', $timecard_id='')
	{
		if ( empty( $user_id ) || empty( $timecard_id ) ) 
		{
			return false;
		}
		$region = $site = $type = $allsites = '';
		$timecard = $this->timesheet_model->getByID('timecard', 'timecard_id', $timecard_id);
		$data['timecard'] = $timecard;
		$my_timesheet = $this->timesheet_model->getMyTimesheet($timecard_id, $timecard->start_date, $timecard->end_date,$user_id);	

		//echo "<pre>"; print_r($my_timesheet); exit;
		$data1 = [];
		foreach($my_timesheet as $array) 
		{
			//$data1[$array->project_id][] = $array;
			$data1[$array->project_id][$array->subtask_id][] = $array;
		}
		
		$data['my_timesheet'] = $data1;
		$subtasks[]='';
		foreach ($data1 as $key => $value) {
			if ( ! empty($key) ) {
				$subtasks[$key] = $this->timesheet_model->getAssignedSubtask( $key, $user_id );
			}
		}
		$data['subtasks'] = $subtasks;

		$data['regions'] = $this->region_model->region();
		$data['Allsites'] = $allsites;

		$timecard_end_date = date('Y-m-d', strtotime($timecard->start_date));
		$data['projects'] = $this->project_model->get_users_project($user_id, $timecard_end_date);

		$data['mytimesheet'] = $my_timesheet;
		$data['user_id'] = $user_id;
		
		$this->load->view('common/header');
		$this->load->view('view_timesheet',$data);
		$this->load->view('common/footer');	
	}

	// public function Requests(){

	// 	$data['title'] = "Notification";
	// 	$user_id = $this->session->userdata('user_id');
	// 	$get_requests = $this->timesheet_model->getallsubmittedtimesheets( $user_id );
	// 	echo "<pre>"; print_r($get_requests); exit;
	// 	$data['allrequests'] = $get_requests;
	// 	$this->load->view('common/header');
	// 	$this->load->view('send_request',$data);
	// 	$this->load->view('common/footer');	
	// }
}