<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once APPPATH.'config/email_config.php';

class Reset_password_model extends MY_Model {

	public function update_firstimepwd($userid,$newpwd) {

		$encryptpwd = md5($newpwd);

		$this->db->where('user_id',$userid);
		$query = $this->db->update('users', array('password' => $encryptpwd, 'is_firsttime' => 1));
		$this->session->sess_destroy();
		return $query;
	}
	
}
