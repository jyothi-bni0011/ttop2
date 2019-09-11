<?php

class User_timezone {
	
	private $CI;
	
	public function __construct() {
		$this->CI =& get_instance();
	}
	
	public function set() {

		$site_id = $this->CI->session->userdata('site_id');

		$timezone = '';
		if( (int)$site_id ) 
		{

			$query = $this->CI->db->select('timezone')
				->from('site')
				->where('site_id', $site_id)
				->get();

			if( $query->num_rows() ) {
				$result = $query->row();

				$timezone = $result->timezone;
			}
		}

		if( $timezone ) {
			date_default_timezone_set($timezone);

			//echo "HOOK". $timezone . "<br/>";
			//echo date_default_timezone_get(); 
			//echo date('Y-m-d H:i:s'); exit;
		}

	}

}

?>