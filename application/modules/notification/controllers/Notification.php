<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Notification_model');
	}

	public function index()
	{

		$data['title'] = "Notification";
		
		$data['notificationdata'] = $this->Notification_model->notification($this->session->userdata('user_id'));
                
		//Make all notifications viewed, change status from 0 to 1
		$update_status = $this->Notification_model->change_notification_status($this->session->userdata('user_id'));
		
//		echo "<pre>"; print_r($data['notificationdata']); exit;
		$this->load->view('common/header');
		$this->load->view('notification',$data);
		$this->load->view('common/footer');
	}

	public function change_status()
	{
		if ( ! empty( $_POST['where'] ) || ! empty( $_POST['table'] ) || ! isset( $_POST['value'] ) || ! empty( $_POST['column'] ) ) 
		{
			if ( $this->Notification_model->change_status( $_POST['table'], $_POST['column'], $_POST['where'], $_POST['value'] ) ) 
			{
				$notification_data = $this->Notification_model->getById($_POST['table'], $_POST['column'],  $_POST['where']);
				//print_r($notification_data); exit();
				if ( $_POST['request'] == 'timesheet' OR $_POST['request'] == 'Assign_project' ) 
				{
					if($_POST['value']==2){
						$status = 'Approved';
						$sts = 3;
					}else{
						$status = 'Rejected';
						$sts = 4;
					}
				}
				elseif ( $_POST['request'] == 'timesheet_edit' ) 
				{
					if($_POST['value']==2){
						$status = 'Approved';
						$sts = 1;
						$update_arr = array('status'=>$sts, 'updated_on'=>date('Y-m-d'));
					}else{
						$status = 'Rejected';
						$sts = 4;
						$update_arr = array('updated_on'=>date('Y-m-d'));
					}	
				}
				else
				{

				}

				//echo "<pre>"; print_r($notification_data); exit;
				if( $_POST['request'] == 'Assign_project'){
					$notification = 'Your pull request has been '.$status;
					$update_arr = array('status'=>$_POST['value'], 'updated_on'=>date('Y-m-d'));
					$update_on = array('id'=>$notification_data->request_id);
					//echo "<pre>"; print_r($update_arr); print_r($update_on);
					$this->Notification_model->update_Record_multi_col('assign_project', $update_arr, $update_on);

					
				} elseif ( $_POST['request'] == 'timesheet' ) {
					
					//Update notification status 
					$update_arr = array('status'=>$sts, 'updated_on'=>date('Y-m-d'));
					$update_on = array('timecard_id'=>$notification_data->request_id);
					$this->Notification_model->update_Record_multi_col('timecard', $update_arr, $update_on);

					$notification = 'Your Timesheet has been '.$status. ' for week number '.date('W', strtotime($notification_data->from_date));
				}
				else {
					//$update_arr = array('status'=>$sts, 'updated_on'=>date('Y-m-d'));
					$update_on = array('timecard_id'=>$notification_data->request_id);
					$this->Notification_model->update_Record_multi_col('timecard', $update_arr, $update_on);

					$notification = 'Your timesheet edit request has been '.$status. ' for week number '.date('W', strtotime($notification_data->from_date));	
				}
				//Insert notification for approved/reject
				
				$notification_array = array('notification_from' => $this->session->userdata('user_id'),
									'notification_to' => $notification_data->notification_from, 
									'notification' => $notification,
									'request' => $_POST['request']."_response",
									'status' => 0,
									'from_date' => $notification_data->from_date,
									'to_date' => $notification_data->to_date,
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

	public function current_notifications()
	{
		$user_id = $_POST['user'];
		$role_id = $_POST['role'];

		$notifications = $this->Notification_model->current_notifications( $user_id );

		$data = [];

		$data = ['notifications' => $notifications, 'success' => 1];

		$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));	
	}

}