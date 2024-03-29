<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_controller'] = array(
        'class'    => 'Authorization',
        'function' => 'auth',
        'filename' => 'Authorization.php',
        'filepath' => 'hooks',
        'params'   => array()
);

$hook['post_controller_constructor'] = array(
	'class'    => 'User_timezone',
	'function' => 'set',
	'filename' => 'User_timezone.php',
	'filepath' => 'hooks',
	'params'   => []
);