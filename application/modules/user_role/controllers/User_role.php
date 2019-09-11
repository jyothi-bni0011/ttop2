<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_role extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		
		
		
		$this->load->view('common/header');
		$this->load->view('index', $this->data);
		$this->load->view('common/footer');
	}
	
}