<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('create_model');
		$this->load->model('login/login_model');

	}

	

	public function index()
	{

		$data['title'] = "Create Period Close";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('period_name', 'Period Name', 'trim|required');
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
			//echo "<pre>"; print_r($_POST); exit;
			
			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) {

				$period_closing_array = array(
						'region_id' => $this->input->post('region_id'),
						'period_name' => $this->input->post('period_name'),
						'from_date' => $this->input->post('start_date'),
						'to_date' => $this->input->post('end_date'),
						'user_id' => $this->session->userdata('user_id'),
						'status' => '1',
						'created_on' => date('Y-m-d H:i:s', now())
					);

				$all_dates = $this->create_model->createDateRange($this->input->post('start_date'), date('Y-m-d', strtotime($this->input->post('end_date'). "+1 days")));

				$period_close_day = array();
				

				//echo "<pre>"; print_r($period_close_day); exit;
				if( $inserted_id = $this->create_model->create( $period_closing_array ) ){
					
					$i=0;
					foreach($all_dates as $dates){
						$check_duplicate_entry = $this->create_model->check_period_alreadyexist($dates, $this->input->post('region_id'));
						if($check_duplicate_entry == 0){
							$period_close_day[$i]['day'] = $dates;
							$period_close_day[$i]['period_id'] = $inserted_id;
							$i++;
						}
						
					}
					$ins = $this->create_model->insert_batch_Record('period_closing_dates', $period_close_day);

					$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Period Closing', 'New Period Close \''.$this->input->post('period_name').'\' is created' );

					$this->session->set_flashdata('message', '<div class="alert alert-success">Period Closing record has been created successfully</div>');
					redirect( '/period_closing', $data );
				}
				else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to create the Period Closing</div>');
					redirect( '/period_closing/create', $data );
				}
			}
			else {
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/period_closing/create', $data );
			}
		}
		else{

			$user_id = $this->session->userdata('user_id');
			$userdata = $this->login_model->get_userdata($user_id);
			$data['userdata'] = !empty($userdata) ? $userdata : '';
			//$data['regions'] = $this->create_model->getByIdAll( 'region', 'status', $this->session->userdata('site_id') );
			//print_r($userdata); exit;
			//$data['sites'] = $this->create_model->getRecordWithcondition( 'site', array('status'=>1, 'region_id'=>$userdata->region_id) );
			$this->load->view('common/header');
			$this->load->view('create', $data);
			$this->load->view('common/footer');
		}

	}

}