<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subtask extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('subtask_model');
		$this->load->model('project/project_model');
		$this->load->model('region/region_model');
		$this->load->model('login/login_model');
	}

	public function index()
	{
		$data['title'] = "Manage Subtask";
		
		if($this->session->userdata('role_id') == 1){
			$site_id = '';
			$region_id = '';
		}else{
			$site_id = $this->session->userdata('site_id');
			$region_id = $this->session->userdata('region_id');
		}
		$data['subtasksdata'] = $this->subtask_model->subtask($region_id, $site_id);
		for($i=0;$i<count($data['subtasksdata']);$i++)
		{
			$data['subtasksdata'][$i]->subtasksIds=explode(',', $data['subtasksdata'][$i]->subtasksIds);
			$data['subtasksdata'][$i]->subtasknames=explode(',', $data['subtasksdata'][$i]->subtasknames);
			$data['subtasksdata'][$i]->sap_numbers=explode(',', $data['subtasksdata'][$i]->sap_numbers);
			$data['subtasksdata'][$i]->subtaskstatus=explode(',', $data['subtasksdata'][$i]->subtaskstatus);
			$data['subtasksdata'][$i]->estimatedhours=explode(',', $data['subtasksdata'][$i]->estimatedhours);
		
		}
		
		//$data['regions'] = $this->region_model->region();
		$this->load->view('common/header');
		$this->load->view('subtask',$data);
		$this->load->view('common/footer');
	}

	

	public function change_status()
	{
		if ( ! empty( $_POST['where'] ) || ! empty( $_POST['table'] ) || ! isset( $_POST['value'] ) || ! empty( $_POST['column'] ) ) 
		{
			if ( $this->project_model->change_status( $_POST['table'], $_POST['column'], $_POST['where'], $_POST['value'] ) ) 
			{
				
				$data = ['success' => 1]; 
			
				$this->output
					->set_content_type('application/json')
			        ->set_output(json_encode($data));		
			}
		}
	}
}