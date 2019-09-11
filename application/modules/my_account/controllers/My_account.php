<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_account extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('my_account_model');
	}

	

	public function index()
	{
		
		$user_id = $this->session->userdata('user_id');
		if ( count( $_POST ) ) 
		{
			// print_r($_FILES['image']['error']);exit();
			$file = '';
			if ( ! empty( $this->input->post('hdn_inner_banner') ) ) 
			{
				$file = $this->input->post('hdn_inner_banner');
			}
			if ( empty( $_FILES['image']['error'] ) ) 
			{
				
				$config['upload_path'] = 'uploads/profileimages/';
		        $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = 0;
		        $config['file_name'] = $_FILES['image']['name'];

		        $this->load->library('upload', $config);
	        
		        if ( ! $this->upload->do_upload('image'))
		        {
		                $error = array('error' => $this->upload->display_errors());
		                // $this->session->set_flashdata('message', $error);
		                // redirect('/document/create');
		                print_r($error);exit();
		                //$this->load->view('upload_form', $error);
		        }
		        else
		        {
		                $data = array('upload_data' => $this->upload->data());
		                // print_r( $data['upload_data'] );
		                // exit();
		                $file = $data['upload_data']['file_name'];
		                //$this->load->view('upload_success', $data);
		        }

			}
			// print_r( $_FILES ); exit();
			$this->form_validation->set_rules('admin_fname', 'First Name', 'trim|required');
			$this->form_validation->set_rules('admin_lname', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('username', 'User Name', 'trim|required');
			$this->form_validation->set_rules('email_id', 'Email ID', 'trim|required');
						
			if( $this->form_validation->run() ) 
			{

				$update_array = array(
					//'region_id' => $this->input->post('region_id'),
					'first_name' => $this->input->post('admin_fname'),
					'last_name' => $this->input->post('admin_lname'),
					'profile_pic' => $file,
					'updated_on' => date('Y-m-d H:i:s', now())
				);

				if ( $this->my_account_model->update( $update_array, $user_id ) ) 
				{
					$this->session->set_userdata('profile_pic', $file);
					$this->session->set_flashdata('message', 'Information Updated.');
					redirect( '/my_account' );
				}
				else
				{
					$this->session->set_flashdata('message', 'Something Went Wrong.');
					redirect( '/my_account' );	
				}
			}
			else 
			{
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/my_account' );
			}		
		}
		
		$data['admindata'] = $this->my_account_model->getById('users', 'user_id', $user_id);	

		$data['title'] = "My Account";
		$this->load->view('common/header');
		$this->load->view('my_account', $data);
		$this->load->view('common/footer');
	}
}