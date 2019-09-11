<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Reset_password_model');
	}
	
	public function index( $user_id ) {
		$this->data['user_id'] = $user_id;
		$this->load->view('reset_password', $this->data);
	}

	public function update_firsttimepwd() {

		if(count($_POST) > 0) {
			$user_id = $this->input->post('user_id');
			$newpwd  = $this->input->post('new_password');
			$status = $this->Reset_password_model->update_firstimepwd($user_id, $newpwd);
			if($status) {
				echo '1';
				exit;
			}
		}
	}

	public function sendmail($email){
		$password = mt_rand(100000,999999);
                $subject="Forgot Password";
                $body='Dear User,<br /> Your Updated Password is ' .$password. '<br /><br />Thanks,<br />TTOP Team';
                $mail_send=$this->forgot_password_model->send_email( $subject, $body, $email, '' );
                if($mail_send){
		$res = $this->Login_model->updatepassword($email,md5($password));
                }else{
                    return false;
                }
                
	}
}