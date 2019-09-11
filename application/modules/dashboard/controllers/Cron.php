<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Cron extends MY_Controller {
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('dashboard_model');
		$this->load->model('timesheet/timesheet_model');
		$this->load->model('period_closing/Period_closing_model');
	}

	public function insert_timesheet_cron() //Insert Timesheet for week 
	{

		$date_from=date('Y-m-d', strtotime("next monday"));
		//echo $date_to=date('Y-m-d', strtotime("next sunday")); 
		$date_to=date('Y-m-d', strtotime($date_from. ' + 6 days')); 
		//insert blank timesheet records for current week, only for engineer and supervisor

		$get_user_data = $this->dashboard_model->get_user_data_for_cron();

		foreach($get_user_data as $users){

			$date = new DateTime("now", new DateTimeZone($users->timezone));
			

			//Check already insert or not
	        $chk_duplicate = $this->timesheet_model->check_duplicate_on_multiCol('timecard', array("employee_id" => $users->user_id, "start_date" => $date_from, "end_date" => $date_to ));
	       
	        if($chk_duplicate){
				$timecard['employee_id'] = $users->user_id;
				$timecard['supervisor_id'] = $users->supervisor;
				$timecard['status'] = 0;
				$timecard['start_date'] = $date_from;
				$timecard['end_date'] = $date_to;
				$timecard['created_on'] = date('Y-m-d H:i:s', now());

				$insert_timecard = $this->timesheet_model->insert_Record('timecard', $timecard);

				if($insert_timecard){

					$working_date = date('Y-m-d', strtotime($date_from));
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
				//echo "<pre>"; print_r($users);
				//echo "in # ";
			}else{
				//echo "<pre>"; print_r($users);
				//echo "out * ";
			}

		}
	}
	
	//Cron for auto approval of submitted timesheet
	public function auto_approve_submitted_cron(){ // auto_approve_flag - 1 = Auto approved by cron
		$get_timesheet_data = $this->dashboard_model->get_submitted_for_autoapproval();
		$i=0;
		if(!empty($get_timesheet_data)){
			foreach((array)$get_timesheet_data as $timecard){
				$updated = $this->dashboard_model->update_Record('timecard', array('status'=>3, 'auto_approve_flag'=>1 ), array('timecard_id'=>$timecard->timecard_id));
				if($updated){
					$i++;
				}
			}
		}
	}
	

	public function auto_period_close(){
		$all_periods = $this->Period_closing_model->period_closing();
		$today = date('Y-m-d');
		if(!empty($all_periods)){
			$i=0;
			foreach($all_periods as $period){ 
				if(date('Y-m-d', strtotime(' +1 day', strtotime($period->to_date))) == $today){
					$update = $this->Period_closing_model->update_Record('period_closing', array('status'=>2), array('period_id'=>$period->period_id));
					$i++;
				}
			}
		}
		if($i!=0){
			echo "Period closed successfully";
		}
	}
}

?>