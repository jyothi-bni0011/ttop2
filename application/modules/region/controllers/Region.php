<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('region_model');
		$this->load->model('dashboard/dashboard_model');
	}

	

	public function index()
	{

		$data['title'] = "Regions";
		
		$data['regions'] = $this->region_model->region();

		$this->load->view('common/header');
		$this->load->view('region',$data);
		$this->load->view('common/footer');
	}

	public function change_status()
	{
		if ( ! empty( $_POST['where'] ) || ! empty( $_POST['table'] ) || ! isset( $_POST['value'] ) || ! empty( $_POST['column'] ) ) 
		{
			if ( $this->region_model->change_status( $_POST['table'], $_POST['column'], $_POST['where'], $_POST['value'] ) ) 
			{
				
				$data = ['success' => 1]; 
			
				$this->output
					->set_content_type('application/json')
			        ->set_output(json_encode($data));		
			}
		}
	}

	public function view_all_regions()
	{

		$data['total_regions'] = $this->dashboard_model->get_total_regions( $_GET['to_date'] );
		$data['title'] = 'Active Regions';

		$this->load->view('common/header');
		$this->load->view('view_all_regions',$data);
		$this->load->view('common/footer');
	}
}