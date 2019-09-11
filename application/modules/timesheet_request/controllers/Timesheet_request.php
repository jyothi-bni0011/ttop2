<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timesheet_request extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('timesheet_request_model');
		$this->load->model('region/region_model');
		$this->load->model('login/login_model');
		$this->load->model('users/users_model');
		$this->load->model('project/project_model');
		$this->load->model('roles/roles_model');
		$this->load->model('period_closing/period_closing_model');
		$this->load->helper('url');
	}

	
	public function index(){

		$data['title'] = "Requests";
		$user_id = $this->session->userdata('user_id');
		$get_requests = $this->timesheet_request_model->get_all_submitted_timesheets( $user_id );
		// echo "<pre>"; print_r($get_requests); exit;
		$data['allrequests'] = $get_requests;
		$this->load->view('common/header');
		$this->load->view('timesheet_request',$data);
		$this->load->view('common/footer');	
	}

	public function create_timesheet_request()
	{

		$data['title'] = 'Create Request';

		if ( count( $_POST ) ) 
		{
			$user_id = $this->session->userdata('user_id');

			$engineer_details = $this->timesheet_request_model->getById( 'users', 'user_id', $user_id );

			if ( empty($engineer_details->supervisor_id) AND empty($engineer_details->pr_supervisor_id) ) 
			{
				
		        $this->session->set_flashdata('message', '<div class="alert alert-danger">You do not have any reporting manager assigned.</div>');
				redirect( '/timesheet_request', $data );
		        exit;
			}

			$timecard_details = $this->timesheet_request_model->getById( 'timecard', 'timecard_id', $_POST['week_number'] );
			
			$period_close = $this->period_closing_model->check_period_closed($timecard_details->start_date, $this->session->userdata('region_id'), 1);

			// print_r( $period_close ); exit();
			
			if ( !empty( $period_close ) && $period_close->status == 2 ) 
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Timesheet is closed for the selected week.</div>');
				redirect( '/timesheet_request', $data );
		        exit;	
			}
			
			$check_duplicate = $this->timesheet_request_model->check_duplicate_request($timecard_details->start_date, $timecard_details->end_date, $user_id);
			
			if ( $check_duplicate == 0 ) //count 0 = no duplicate entry found
			{
				$supervisor_id = 0;
				if ( !empty( $engineer_details->pr_supervisor_id ) ) 
				{
					$supervisor_id = $engineer_details->pr_supervisor_id;
				}
				else
				{
					$supervisor_id = $engineer_details->supervisor_id;	
				}
				$ddate = $timecard_details->start_date;
				$date = new DateTime($ddate);
				$week = $date->format("W");
				// echo "Weeknummer: $week";
				$notification = sprintf("%s Timesheet Edit Request for week number %d.", $this->session->userdata('username'), $week);

				$insert_data = array(	  
					'notification_to' 		=> $supervisor_id,
					'notification_from' 	=> $user_id,
					'notification' 			=> $_POST['reason'],
					'request' 				=> 'timesheet_edit',
					'from_date' 			=> $timecard_details->start_date,
					'to_date' 				=> $timecard_details->end_date,
					'request_id' 			=> $_POST['week_number'],
					'status'				=> 0,
					'created_on'			=> date('Y-m-d H:i:s', now())
				);

				if ( $this->timesheet_request_model->create( $insert_data ) ) 
				{
					$this->session->set_flashdata('message', '<div class="alert alert-success">Successfully Inserted..</div>');
					redirect( '/timesheet_request', $data );
			        exit;
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-success">Failed to Insert..</div>');
					redirect( '/timesheet_request', $data );
			        exit;	
				}
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger">You already have an request.</div>');
				redirect( '/timesheet_request', $data );
		        exit;
			}

		}
		$data['timesheets'] = $this->timesheet_request_model->get_timecard_entries( $this->session->userdata('user_id') );

		$this->load->view('common/header');
		$this->load->view('timesheet_request_create',$data);
		$this->load->view('common/footer');	
	}
}