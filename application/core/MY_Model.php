<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	
	//This function check duplicate entry in database. If entry is duplicate then it return false and if no duplicate entry then return true.
	public function check_duplicate( $table, $column, $value, $notin=0, $notincolunm='' )
	{
		$this->db->where($column, $value);
		
		if ($notin != 0) {
			$this->db->where_not_in( $notincolunm, $notin );
		}

		$res = $this->db->get($table);
		//echo $this->db->last_query(); exit;
		if (count($res->result()) == 0) {
			return true;
		}
		else {
			return false;
		}
	}
	//Function end

	//This function get all data from the table and return object formated data
	public function getAll( $table )
	{
		$this->db->select('*');
		$this->db->from( $table );
		$query = $this->db->get();
		return $query->result();
	}
	//function end

	//This function get data from table by ID
	public function getById( $table, $column, $value )
	{
		if( empty($value) ) {
			return false;
		}

		$row = $this->db->get_where( $table, array( $column => $value ) )->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;
	}
	//Function end

	//This function all get data from table by Coloum and value
	public function getByIdAll( $table, $column, $value )
	{
		if( empty($value) ) {
			return false;
		}

		$this->db->select('*');
		$this->db->from( $table );
		$this->db->where( $column, $value );
		$query = $this->db->get();
		return $query->result();
	}
	//Function end

	//This function sends email 
	public function send_email( $email_subject, $email_body, $to, $data )
	{
		// if ( $email_template = $this->getById( EMAIL_TEMPLATE, EMAIL_TEMPLATE_NAME, $email_type ) ) 
		// {

			// $msg = $this->load->view( 'forgot.php', $data, true );
			$this->load->library('email', config_item('email_config'));
			$this->email->set_newline("\r\n");
			$this->email->from('ttop@bluenettech.com'); // change it to yours   'dev@bluenettech.com'
			$this->email->to( $to );// change it to yours rahul.deo@talentserv.co.in
			$this->email->subject( $email_subject );

			// $data['first_name'] = "Rahul Deo";
			// $email_body = $email_template->{EMAIL_TEMPLATE_BODY};

			// foreach ($data as $key => $value) {
			// 	$email_body = str_replace("{" .$key . "}", $value, $email_body);
			// }
			
			$this->email->message( $email_body );
			if($this->email->send())
			{
//				echo 'Email sent.';
				return true;
			}
			else
			{
				show_error($this->email->print_debugger());
			} 
		
		// }
		// else{
		// 	return false;
		// } 

		return false;
	}
	//Function End

	//This function get all data from the table with conditions
	public function getRecordWithcondition( $table, $conditions = array(), $order_by = array(), $fields = '*', $limit = '' )
	{
		$this->db->select("$fields");
		$this->db->from( $table );
		foreach($conditions as $key=>$val){
			$this->db->where( $key, $val ); 
		}
		if(!empty($order_by)){
			list($order_key, $order_value) = each($order_by);
			$this->db->order_by($order_key, $order_value);
		}
		$query = $this->db->get();
		
		if($limit == '1'){
			return $query->row();
		}else{
			return $query->result();
		}
		
	}
	//function end

	//insert single record
	public function insert_Record( $table, $insert_array = array() ){
		$this->db->insert($table, $insert_array);
		return $insert_id = $this->db->insert_id();
	}

	//insert batch
	public function insert_batch_Record( $table, $insert_array = array() ){
		return $this->db->insert_batch($table, $insert_array);
		//return $insert_id = $this->db->insert_id();
	}

	public function update_Record ($table, $update_array = array(), $key_arr = array()){
		list($key, $value) = each($key_arr);
		$this->db->where($key, $value);
		return $this->db->update($table, $update_array);
	}

	public function update_Record_multi_col ($table, $update_array = array(), $key_arr = array()){

		
		$this->db->where($key_arr); 
		return $this->db->update($table, $update_array);
	}

	public function insert_log_history( $user_id, $action, $description )
	{
		if ( empty( $user_id ) || empty( $action ) || empty( $description ) ) {
			return false;
		}

		$create = array(
			USER_ID					=>	$user_id,
			LOG_EVENT				=>	$action,
			LOG_EVENT_DESCRIPTION	=>	$description,
			LOG_DATE				=>	date('Y-m-d H:i:s', now())
		);

		$this->db->insert( LOG_HISTORY, $create );
		if( $this->db->affected_rows() ) {
			return $this->db->insert_id();
		}

		return false;
	}

	public function change_status( $table, $column, $where, $value )
	{
		if ( empty( $table ) || empty( $column ) || empty( $where ) || empty( $value ) ) 
		{
			// echo "string ".$whereempty;exit();
			return FALSE;
		}
		$update = array(
			STATUS => $value,
		);

		$this->db->where($column, $where);  
		$this->db->update($table, $update);  		
		if( $this->db->affected_rows() ) 
		{
			return true;
		}	

		return FALSE;			
	}
	
	//Check Duplicate with multiple conditions
	public function check_duplicate_on_multiCol($table, $where_array=array(), $id_arr=array()){
		
		foreach($where_array as $key=>$val){
			$this->db->where($key, $val);	
		}
		
		if ($id_arr) {
			list($key, $value) = each($id_arr);
			$this->db->where_not_in( $key, $value );
		}

		$res = $this->db->get($table);
		if (count($res->result()) == 0) {
			return true;
		} else {
			return false;
		}
	}
	//End

	public function check_Duplicate_WithOr( $table, $where_array, $id_arr = array() )
	{
		$where = '';
		
		foreach($where_array as $key=>$val){
			$where .= "$key = '$val' OR ";
		} 
		$whr_cond = rtrim($where, ' OR ');
		
		$this->db->where('('.$whr_cond .')');  
		if ($id_arr) {
			list($key, $value) = each($id_arr);
			$this->db->where_not_in( $key, $value );
		}

		$res = $this->db->get($table);
		//echo $this->db->last_query(); exit;
		if (count($res->result()) == 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function deleteRecord($table, $id_array){
		list($key, $value) = each($id_array);

		if($this->getByIdAll($table, $key, $value)){
			$this->db->where($key, $value);
			$this->db->delete($table);	
		}
		
	}

	//get sites by region_id
	public function get_sites($reg_id = ''){
		$this->db->select('site_name,site_id');
		$this->db->from(SITE); 
		$this->db->where('region_id',$reg_id);
		$this->db->where('status','1');
		$query = $this->db->get();
		return $query->result();
	}	

	public function get_assigned_subtasks_details($subtask)
	{
		$result = array();
		if(is_array($subtask)){
			foreach ($subtask as $value) 
			{
				$this->db->select('subtask_id,subtask_name');
				$this->db->from('subtask');
				$this->db->where('subtask_id', $value);
				$query = $this->db->get();
				$result[] = $query->row();
			}
		}
			return( $result );
	}

	public function createDateRange($startDate, $endDate, $format = "Y-m-d")
	{
	    $begin = new DateTime($startDate);
	    $end = new DateTime($endDate);

	    $interval = new DateInterval('P1D'); // 1 Day
	    $dateRange = new DatePeriod($begin, $interval, $end);

	    $range = [];
	    foreach ($dateRange as $date) {
	        $range[] = $date->format($format);
	    }

	    return $range;
	}

	public function find_roles($user_id)
	{
		$this->db->select('role_id');
		$this->db->from('users_role_mapping');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();

		return $query->result();
	}
}