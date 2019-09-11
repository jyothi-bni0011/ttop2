<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		$this->load->model('delete_model');
	}

	

	public function index()
	{

		if( count($_POST) ) {
			$old_data = $this->delete_model->getById( COST_CENTER, CC_ID, $_POST['cost_center_id'] );
			if ( $this->delete_model->delete( $_POST['cost_center_id'] ) ) {
				//$data['message'] = "Role deleted successfuly";

				$this->delete_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Cost Center', 'Cost center \''.$old_data->{CC_NAME}.'\' is deleted' );
			}

			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}