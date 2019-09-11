<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_history extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('log_history_model');
	}

	
	//list of category
	public function index($user_id)
	{
		$data['title'] = 'Log History';

		$data['log_history'] = $this->log_history_model->get_log_history($user_id);

		$this->load->view('common/header');
		$this->load->view('log_history/log_history', $data);
		$this->load->view('common/footer');
	}

	public function log_by_date()
	{
		if ( count($_POST) ) {
			$result = $this->log_history_model->get_log_history( $_POST['date'] ); 
				
				$table = 	'<thead>
								<tr>
	                          		<th>Sr No</th>
	                          		<th> User </th>
									<th width="25%"> Action </th>
									<th> Description </th>
	                          		<th> Date & Time</th>     
	                         	</tr>
                        	</thead>
                        	<tbody>';
                        	if ( ! empty( $result ) ) 
                        	{
                        		
                     	    	$i=1; 
                     	    	foreach($result as $log)
                     	    	{

                     		   	$table .=	'<tr class="odd gradeX">
		                            			<td>'. $i++ .'</td>
		                     			  		<td>'. $log->full_name. '</td>
		                     			  		<td>'. $log->log_event. '</td>
		                            			<td>'. $log->log_event_description. '</td>
		                            			<td>'. $log->log_date. '</td>
		                     		   		</tr>';
                     	    	}
                        	}
                     	    	
                $table .=   '</tbody>';

				$data = ['success' => 1, 'result' => $table];			
				$this->output
						->set_content_type('application/json')
				        ->set_output(json_encode($data));
			
		}

	}

}