<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('update_model');
		$this->load->model('login/login_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Update Period Close";

		if( count($_POST) ) {
			$this->form_validation->set_rules('period_name', 'Period Name', 'trim|required');
			
			if( $this->form_validation->run() ) {

				$update_array = array(
					//'region_id' => $this->input->post('region_id'),
					'period_name' => $this->input->post('period_name'),
					'from_date' => $this->input->post('start_date'),
					'to_date' => $this->input->post('end_date'),
					'updated_on' => date('Y-m-d H:i:s', now())
				);

				$all_dates = $this->update_model->createDateRange($this->input->post('start_date'), date('Y-m-d', strtotime($this->input->post('end_date'). "+1 days")));

				$period_close_day = array();

				if( $this->update_model->update( $update_array, $this->input->post('period_id') ) ) {
					
					$i=0;
					foreach($all_dates as $dates){
						
						$period_close_day[$i]['day'] = $dates;
						$period_close_day[$i]['period_id'] = $this->input->post('period_id');
						$i++;
					}
					$delete = $this->update_model->deleteRecord('period_closing_dates', array('period_id'=>$this->input->post('period_id')));
					$ins = $this->update_model->insert_batch_Record('period_closing_dates', $period_close_day);
					//$data['message'] = "Role has been created.";

					//insert in log
					$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Period Closing', 'Period Closing \''.$this->input->post('period_name').'\' is updated' );

					$this->session->set_flashdata('message', '<div class="alert alert-success">Period Closing has been updated successfully</div>');
					redirect( '/period_closing', $data );
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to update the cost center</div>');
					redirect( '/period_closing/update/index/'.$_POST['period_id'] );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/period_closing/update/index/'.$_POST['period_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {
				//echo "<pre>"; print_r($row); exit;
				$user_id = $row->user_id;
				$userdata = $this->login_model->get_userdata($this->session->userdata('user_id'));
				$data['userdata'] = !empty($userdata) ? $userdata : '';
				//$data['regions'] = $this->create_model->getByIdAll( 'region', 'status', $row->site_id );
				//print_r($userdata); exit;
				//$data['sites'] = $this->update_model->getRecordWithcondition( 'site', array('status'=>1, 'region_id'=>$userdata->region_id) );

				$data['period_closing'] = $row;
				
			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}