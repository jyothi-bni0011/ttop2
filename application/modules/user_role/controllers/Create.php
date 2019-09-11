<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		
		
		
		$this->load->view('common/header');
		$this->load->view('create', $this->data);
		$this->load->view('common/footer');
	}
	
}