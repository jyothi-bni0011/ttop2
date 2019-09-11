<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('site_model');
		$this->load->model('region/region_model');
		$this->load->model('dashboard/dashboard_model');
	}

	public function index()
	{

		$data['title'] = "Sites";
		$data['sites'] = $this->site_model->site();
		$data['regions'] = $this->region_model->region();
		$this->load->view('common/header');
		$this->load->view('site',$data);
		$this->load->view('common/footer');
	}

	public function Create()
	{ 	
		$data['regions']=$this->region_model->region();
		//echo "<pre>"; print_r($data['regions']); exit;
		$data['cost_centers']=$this->site_model->getByIdAll( COST_CENTER, 'status', 1 );		
		$this->load->view('common/header');
		$this->load->view('create',$data);
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

	public function view_all_sites()
	{
		$role = $this->session->userdata('role_id');
		$site = $this->session->userdata('site_id');
		$region = $this->session->userdata('region_id');

		$data['total_sites'] = $this->dashboard_model->get_total_sites( $role, $site, $region, $_GET['to_date'] );
		$data['title'] = 'Active Sites';

		$this->load->view('common/header');
		$this->load->view('view_all_sites',$data);
		$this->load->view('common/footer');
	}
}