<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 

$this->load->helper('directory');
$_dirs = directory_map(APPPATH . '/modules');

foreach( $_dirs as $module => $dir ) {
	
	echo "Module: " . str_replace(DIRECTORY_SEPARATOR, "", $module) . "<br/>";
	
	if( array_key_exists("controllers" . DIRECTORY_SEPARATOR, $dir) ) {
		foreach ($dir["controllers" . DIRECTORY_SEPARATOR] as $controller ) {
			echo "&nbsp;&mdash; Controller: " . $controller . "<br/>";
			
			$className = str_replace(".php", "", $controller);
			echo "&nbsp;&nbsp;&nbsp;&mdash; Class Name: " . $className . "<br/>";

		}
	}
	
}

?>