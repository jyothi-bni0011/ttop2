<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Period_closing extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Period_closing_model');
	}

	

	public function index()
	{

		$data['title'] = "Period Closing";
		
		$data['period_close'] = $this->Period_closing_model->period_closing();

		$this->load->view('common/header');
		$this->load->view('period_closing',$data);
		$this->load->view('common/footer');
	}

	public function change_status()
	{
		if ( ! empty( $_POST['where'] ) || ! empty( $_POST['table'] ) || ! isset( $_POST['value'] ) || ! empty( $_POST['column'] ) ) 
		{
			if ( $this->Period_closing_model->change_status( $_POST['table'], $_POST['column'], $_POST['where'], $_POST['value'] ) ) 
			{
				
				$data = ['success' => 1]; 
				$status_text = (isset($_POST['value']) && $_POST['value'] == 2) ? 'Closed' : 'Opened';
				$this->session->set_flashdata('message', "<div class='alert alert-success'>Period is ".$status_text." successfully. </div>");
				$this->output
					->set_content_type('application/json')
			        ->set_output(json_encode($data));		
			}
		}
	}

	
}