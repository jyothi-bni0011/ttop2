<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cost_center extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Cost_center_model');
	}

	

	public function index()
	{

		$data['title'] = "Manage Cost Center";
		
		$data['cost_center'] = $this->Cost_center_model->cost_center();

		$this->load->view('common/header');
		$this->load->view('cost_center',$data);
		$this->load->view('common/footer');
	}

	public function change_status()
	{
		if ( ! empty( $_POST['where'] ) || ! empty( $_POST['table'] ) || ! isset( $_POST['value'] ) || ! empty( $_POST['column'] ) ) 
		{
			if ( $this->Cost_center_model->change_status( $_POST['table'], $_POST['column'], $_POST['where'], $_POST['value'] ) ) 
			{
				
				$data = ['success' => 1]; 
			
				$this->output
					->set_content_type('application/json')
			        ->set_output(json_encode($data));		
			}
		}
	}
}