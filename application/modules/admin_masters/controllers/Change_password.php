<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('change_password_model');
	}

	
	//list of category
	public function index()
	{
		$data['title'] = 'Change Password';

		if ( $_POST ) {

			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
			
			if ( $this->change_password_model->check_old_password( $this->input->post('old_password') ) ) 
			{
				
				if( $inserted_id = $this->change_password_model->change_password( $this->input->post('new_password') ) ) 
				{

					$this->session->set_flashdata('message', success_message( 'Password has been changed.') );
					redirect( '/admin_masters/change_password' );
					exit();

				}
				else {
					
					$this->session->set_flashdata('message', error_message( 'Sorry, Change password failed.' ) );
					redirect( '/admin_masters/change_password' );
					exit();
				}

			}
			else
			{
				$this->session->set_flashdata('message', error_message('Old passwod is wrong.'));
				redirect( '/admin_masters/change_password' );
				exit();
			}

		}

		$this->load->view('common/header');
		$this->load->view('change_password/change_password', $data);
		$this->load->view('common/footer');
	}

}