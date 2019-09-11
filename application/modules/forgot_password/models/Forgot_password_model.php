<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once APPPATH.'config/email_config.php';

class Forgot_password_model extends MY_Model {

	public function user( $user )
	{

		if( empty($user) AND count($user) ) {
			return false;
		}

		if(array_key_exists('user_id', $user))  $where['user_id']  = (int)$user['user_id'];
		if(array_key_exists('email_id', $user)) $where['email_id'] = $user['email_id'];
		if(array_key_exists('username', $user)) $where['username'] = $user['username'];

		$this->db->select('email_id')
			->from('users');

		foreach ($where as $key => $value) {
			$this->db->or_where( $key, $value );
		}

		$result = $this->db->get();

		return $result->row();

	}


	public function authenticate( $username )
	{
		
		if( empty($username) ) {
			return false;
		}

		//$data['username']	= $this->input->post('username');
		$data['email_id']	= $this->input->post('username');

		$user = $this->user( $data );

		if( $user ) {

			/*$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
					'smtp_port' => 587,
					'smtp_user' => 'AKIAJ5L2XRPOLYKZZYGQ', // change it to yours
					'smtp_pass' => 'AgPsduS65LPoBSQKhHs55JR4h4X1QJ9vRw8ocUr1r0v4', // change it to yours
			 		'smtp_crypto' => "tls",
					/*'charset' => 'iso-8859-1',
					'wordwrap' => TRUE*/
					/*'charset'=>'utf-8',
					'wordwrap'=> TRUE,
					'mailtype' => 'text'
			);*/

			
			return true;
		}

		return false;

	}

	public function get_data_for_forgot_password( $email_id )
	{
		$this->db->select('username as user_name, email_id as email, first_name as first_name, middle_name as middle_name, last_name as last_name')
			->from( USER )
			->where( 'email_id', $email_id );
		$query = $this->db->get();

		return $query->row();
	}

}
