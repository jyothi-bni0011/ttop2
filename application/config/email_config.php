<?php

$config['email_config_old'] = array(
    'protocol' => 'smtp',
    //'smtp_host' 	=> 'email-smtp.us-west-2.amazonaws.com',
    'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
    'smtp_port' => 587,
    //'smtp_user' 	=> 'AKIAJKKFD3JWWQK3SQIQ', // change it to yours
    //'smtp_user'		=> 'AKIAJ5L2XRPOLYKZZYGQ', //blunet by ayaz
    'smtp_user' => 'AKIAIHFY4RLY3PV7TBEA',
    //'smtp_pass' 	=> 'AvcS+4fOuHyqFxp7UjgUDw7g1dysls1xAJV9NvT3xjHe', // change it to yours
    // 'smtp_pass'		=> 'AgPsduS65LPoBSQKhHs55JR4h4X1QJ9vRw8ocUr1r0v4', //blunet by ayaz
    'smtp_pass' => 'BHbay+Atzb8QoYDUtO13dczv+E6J6cYlzrNLt9P7Qyms',
    'smtp_crypto' => "tls",
    /* 'charset' 	=> 'iso-8859-1',
      'wordwrap' 		=> TRUE */
    'charset' => 'utf-8',
    'wordwrap' => TRUE,
    'mailtype' => 'html',
        // 'newline' 		=> "\r\n"
);
//Added by jyothi on 16-07-2019
$config['email_config'] = array(
	'protocol' 		=> 'smtp',
	'smtp_host' 	=> 'smtp.danahermail.com',
	'smtp_port' 	=> 25,
	'smtp_user' 	=> '', // change it to yours
	'smtp_pass' 	=> '', // change it to yours
	/*'smtp_crypto' 	=> "",*/
	/*'charset' 	=> 'iso-8859-1',
	'wordwrap' 		=> TRUE*/
	'charset'		=>'utf-8',
	'wordwrap'		=> TRUE,
	'mailtype' 		=> 'html',
	
	// 'newline' 		=> "\r\n"
);
?>