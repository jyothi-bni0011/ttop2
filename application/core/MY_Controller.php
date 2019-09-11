<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller
{	

	public $data = [];

	public function __construct() 
	{
		parent::__construct();
		$this->_hmvc_fixes();
		$this->init();
	}
	
	public function _hmvc_fixes()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
	}
	
	public function init() {
		
		$this->data = [];
		$this->data['message'] = "";
		
	}

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
