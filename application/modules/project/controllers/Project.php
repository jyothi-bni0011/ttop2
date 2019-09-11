<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model(array('create_model','project_model'));
		$this->load->model('region/region_model');
		$this->load->model('login/login_model');
		$this->load->model('users/users_model');
		$this->load->model('site/site_model');
		$this->load->model('dashboard/dashboard_model');
	}

	public function index()
	{
		$data['title'] = "Manage Projects";
		$type = $allsites = '';
        $region = $this->session->userdata('region_id');
		$site = $this->session->userdata('site_id');
		if( count($_POST) ) {
			$type = !empty($this->input->post('project_type'))?$this->input->post('project_type'):'';
                       
		} else if($this->session->userdata('role_id') != 1){

			$type = 'global';
                }

		$list_project = 1;
		$allsites = $this->site_model->site();
		$to_date = '';
		$come_from = 'project';
		if ( ! empty($_GET['from_date']) AND ! empty($_GET['to_date']) ){ 
			$from_date = $_GET['from_date'];
			$to_date = $_GET['to_date'];
			$list_project='';
			$come_from = 'dashboard';$type='';
                        
		}

//		echo $site;
		if($come_from == 'dashboard'){
			$data['title'] = "Active Projects";
			$data['projects'] = $this->project_model->get_projects($region, $site, $type, $list_project, $to_date,'dashboard');
                }else{
			$data['projects'] = $this->project_model->project($region, $site, $type, $list_project, $to_date);
		}
		
//		echo "<pre>"; print_r($data['projects']); exit;
        $data['regions'] = $this->region_model->region();
		$data['Allsites'] = $allsites;
		$data['selected_region'] = $region;
		$data['selected_site'] = $site;
		$data['selected_type'] = $type;
		$data['come_from'] = $come_from;
		// echo "<pre>"; print_r($data); exit;
 		$this->load->view('common/header');
		$this->load->view('project',$data);
		$this->load->view('common/footer');
	}

	

	public function upload()
	{
		$user_id = $this->session->userdata('user_id');
		$result=$this->login_model->get_userdata($user_id);
		$data['regiondata'] = $result;

		$this->load->view('common/header');
		$this->load->view('upload_project',$data);
		$this->load->view('common/footer');

		//$this->template->write_view('content', 'admin/projects/upload_project',$data);
		
	}

	public function getsites(){
		$reg_id = $this->input->post('region_id');
		$sites = $this->project_model->getRecordWithcondition(SITE, array('region_id' => $reg_id));
		foreach($sites as $site){
	    	$site_opt[] = array(
	    		"id" => $site->site_id,
	    		"name" => $site->site_name
	    	);
		}

		echo json_encode($site_opt); //exit;*/
	}

	public function insertexcel() {
//            
        //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)	 
        $config['upload_path'] = 'uploads/excel/';
        $config['allowed_types'] = '*';
        $config['file_name'] = $_FILES['userfile']['name'];
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('userfile');
        $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
        $file_name = $upload_data['file_name']; //uploded file name
        $extension = $upload_data['file_ext'];    // uploded file extension
        require_once( APPPATH . 'third_party/PHPExcel/IOFactory.php');
        $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007 	  

        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load(FCPATH . 'uploads/excel/' . $file_name);
        $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

        // Headers matching !!
        $project_number = $objWorksheet->getCellByColumnAndRow(0, 1)->getValue();
        $project_name = $objWorksheet->getCellByColumnAndRow(1, 1)->getValue();
        $project_budget = $objWorksheet->getCellByColumnAndRow(2, 1)->getValue();
        $project_type = $objWorksheet->getCellByColumnAndRow(3, 1)->getValue();
        $supervisor_email_id = $objWorksheet->getCellByColumnAndRow(4, 1)->getValue();
        $owner = $objWorksheet->getCellByColumnAndRow(5, 1)->getValue();
        $cost_center_code = $objWorksheet->getCellByColumnAndRow(6, 1)->getValue();
        $start_date = $objWorksheet->getCellByColumnAndRow(7, 1)->getValue();
        $end_date = $objWorksheet->getCellByColumnAndRow(8, 1)->getValue();
        $project_description = $objWorksheet->getCellByColumnAndRow(9, 1)->getValue();
        $highestcolumn = $objWorksheet->getHighestColumn();

        $projects_added_msg = '';
        if ($project_number != 'SAP Number' || $project_name != 'Project Name' || $project_budget != 'Project Budget' || $project_type != 'Project Type' || $supervisor_email_id != 'supervisor_email_id' || $owner != 'owner' || $cost_center_code != 'cost_center_code' || $start_date != 'start_date' || $end_date != 'end_date' || $project_description != 'project_description'
        ) {
            $projects_added_msg = '<div class="alert alert-danger">Please select valid template file.</div>';
            $totalrows = 0;
        }

        //loop from first data untill last data
        for ($i = 2; $i <= $totalrows; $i++) {
            if ($objWorksheet->getCellByColumnAndRow(0, $i)->getValue() != '') {
                $project_id = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
                $project_name = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue(); //Excel Column 1
                $project_budget = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue(); //Excel Column 2
                $project_type = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue(); //Excel Column 3
                $supervisor_email_id = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue(); //Excel Column 5
                // $supervisor_email_id = str_replace(',', "','", $supervisor_email_id);
                //added code for multiple supervisor Email IDs
                
                $owner = $objWorksheet->getCellByColumnAndRow(5, $i)->getValue(); //Excel Column 5
                $cost_center_code = $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
                $start_date = $objWorksheet->getCellByColumnAndRow(7, $i)->getValue(); //Excel Column 5
                $end_date = $objWorksheet->getCellByColumnAndRow(8, $i)->getValue(); //Excel Column 5
                $project_description = $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();

                $result1 = $this->project_model->getById(USER, 'email_id', $supervisor_email_id);
				$result2 = $this->project_model->getById('cost_center','cost_center_code',$cost_center_code);
				if ( ! empty( $start_date ) ) 
				{
                	$start_date_formatted = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($start_date)); //formatting the start date value so that it can be treated as a date
				}
				else
				{
					$start_date_formatted = NULL;
				}
				if ( ! empty( $end_date ) ) 
				{
                	$end_date_formatted = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($end_date)); //formatting the end date value so that it can be treated as a date
				}
				else
				{
					$end_date_formatted = NULL;
				}
				// echo "start_date : ".$start_date." end_date : ".$end_date; exit();

                if (empty($project_id) || empty($project_name) || empty($project_type) || empty($cost_center_code)) {
                    $projects_added_msg .= '<div class="alert alert-danger">Invalid Data Provided for row ' . $i . '</div>';
                    break;
                }

                if ($result2) {
                	if(!empty($result1)){ $supervisor_id = $result1->user_id; } else { $supervisor_id = 0; }
                   
		    		$cc_id = $result2->cc_id;
                    $data_user = array(
                        SAP_NO => $project_id,
                        PROJECT_NAME => $project_name,
                        PROJECT_BUDGET => $project_budget,
                        PROJECT_TYPE => $project_type,
                        SUPERVISOR_ID => $supervisor_id,
                        'project_owner' => !empty($owner)?$owner:"NA",
                        'cost_center_id'=>$result2->cc_id , 
                        PROJECT_DESCRIPTION => !empty($project_description)?$project_description:"NA",
                        PROJECT_START_DATE => $start_date_formatted,
                        PROJECT_END_DATE => $end_date_formatted,
                        PROJECT_EXP_SUBTASK => 'no', // this line has been added to add by default 'No' in the explicit assignment of subtasks
                        STATUS => 1,
                        PROJECT_SITE_ID => $this->session->userdata('site_id'),
                        PROJECT_CREATED_BY => $this->session->userdata('user_id'),
                        CREATED_ON => date('Y-m-d H:i:s', now()),
                    );

                    if ($this->project_model->getById('projects', 'project_name', $project_name)) {
                        $projects_added_msg .= '<div class="alert alert-danger">' . $project_name . ' not added due to Project Name already exists.</div>';
                    }else if ($this->project_model->getById('projects', 'project_id', $project_id)) {
                        $projects_added_msg .= '<div class="alert alert-danger">' . $project_name . ' not added due to Project Code already exists.</div>';
                    } else {
                        $last_insert_id = $this->create_model->create($data_user);
                        //insert in log
                        $this->create_model->insert_log_history((int) $this->session->userdata('user_id'), 'Project', 'New Project \'' . $project_name . '\' is created');

                        // when project is created it will assign to supervisors.
                        $super_email_id = explode(",",$supervisor_email_id);
                        foreach ($super_email_id as $supervisor)
                        {
                        	$user = $this->project_model->getById('users', 'email_id', $supervisor);
                        	if ( $user ) 
                        	{
                        		$roles = $this->project_model->find_roles($user->user_id);
                        		foreach ($roles as $role) 
                        		{
	                        		if ( $role->role_id == 3 ) 
	                        		{
	                        			$assign_project = array(
	                        				'project_id' => $last_insert_id,
	                        				'user_id' => $user->user_id,
	                        				'assign_by' => $this->session->userdata('user_id'),
	                        				'assign_to_role' =>$role->role_id,
	                        				'status' => 1,
	                        				'start_date' => date('Y-m-d', now()),
	                        				'created_on' => date('Y-m-d H:i:s', now()),
	                        			);
	                        			// print_r( $assign_project )
	                        			if ($this->project_model->assign_project($assign_project)) 
	                        			{
	                        				$projects_added_msg .= '<div class="alert alert-success">' . $project_name . ' successfully assigned to '.$user->username.'.</div>';
	                        			}
	                        		}
	                        		else
	                        		{
	                        			$projects_added_msg .= '<div class="alert alert-danger">' . $project_name . ' not assigned to '.$supervisor.'.'.$supervisor.' is not a supervisor.</div>';			
	                        		}
                        		} 
                        	}
                        	else
                        	{
                        		$projects_added_msg .= '<div class="alert alert-danger">' . $project_name . ' not assigned to '.$supervisor.'. Supervisor does not found in our records.</div>';
                        	}
                        }
                        
                        $projects_added_msg .= '<div class="alert alert-success">' . $project_name . ' added Successfully.</div>';
                    }
                } else {
                    $projects_added_msg .= '<div class="alert alert-danger">' . $project_name . ' not added due to Cost Center does not found in our records.</div>';
                }
            }
        }

        unlink('././uploads/excel/' .$file_name); //File Deleted After uploading in database .			 
        $this->session->set_flashdata('message', $projects_added_msg);
        redirect(base_url() . "project");
    }

        public function change_status()
	{
		if ( ! empty( $_POST['where'] ) || ! empty( $_POST['table'] ) || ! isset( $_POST['value'] ) || ! empty( $_POST['column'] ) ) 
		{
			if ( $this->project_model->change_status( $_POST['table'], $_POST['column'], $_POST['where'], $_POST['value'] ) ) 
			{
				
				$data = ['success' => 1]; 
			
				$this->output
					->set_content_type('application/json')
			        ->set_output(json_encode($data));		
			}
		}
	}

	public function find_sites_by_region()
	{
		if ( $sites = $this->project_model->get_sites( $_POST['id'] ) ) 
		{
			$data = [ 'success' => 1, 'sites' => $sites ]; 
			
			$this->output
				->set_content_type('application/json')
			    ->set_output(json_encode($data));	
		}
		else
		{
			$data = [ 'success' => 0 ]; 
			
			$this->output
				->set_content_type('application/json')
			    ->set_output(json_encode($data));	
		}
	}

	public function find_cost_center_by_site()
	{
		if ( $cost_center = $this->project_model->get_cost_center_by_site( $_POST['site_id'] ) ) 
		{
			$data = [ 'success' => 1, 'cost_center' => $cost_center ]; 
			
			$this->output
				->set_content_type('application/json')
			    ->set_output(json_encode($data));	
		}
		else
		{
			$data = [ 'success' => 0 ]; 
			
			$this->output
				->set_content_type('application/json')
			    ->set_output(json_encode($data));
		}
	}

	public function project_details($prj_id)
	{
		if ( empty( $prj_id ) ) 
		{
			redirect('project');
        	exit();
		}
		$current_week = date('W');
        $current_year = date('Y');
        
        $firstweekday = date("Y-m-d", strtotime("{$current_year}-W{$current_week}-1")); 
        $lastweekday = date("Y-m-d", strtotime("{$current_year}-W{$current_week}-7")); 

        $data['form_date'] 	= $firstweekday;
		$data['to_date'] 	= $lastweekday;
		$data['user_id'] 	= $this->input->post('username');
        $data['project_id'] 	= $prj_id;
		$data['project_details'] 	= $this->project_model->getById( 'projects', 'id', $prj_id );
		$data['all_engineers']  = $this->project_model->getallusersbyproject( $prj_id );
		$data['projectdata'] 	= $this->project_model->getprojectallengineers($prj_id,$firstweekday,$lastweekday);
		
		// echo'<pre>'; print_r( $data ); exit();
		$this->load->view('common/header');
		$this->load->view('project_details',$data);
		$this->load->view('common/footer');
	}

	public function search_project_details($prj_id)
	{
		if ( empty( $prj_id ) ) 
		{
			redirect('project');
        	exit();
		}
        if ( empty( $_GET['from_date'] ) || empty( $_GET['to_date'] ) ) 
        {
		// echo "string : ".$prj_id; print_r($_POST); exit();
        	redirect('project/project_details/'.$prj_id);
        	exit();
        }

        $firstweekday = $this->input->get('from_date'); 
        $lastweekday = $this->input->get('to_date'); 

        $data['form_date'] 	= $firstweekday;
		$data['to_date'] 	= $lastweekday;
		$data['user_id'] 	= $this->input->get('username');
        $data['project_id'] 	= $prj_id;
		$data['project_details'] 	= $this->project_model->getById( 'projects', 'id', $prj_id );
		$data['all_engineers']  = $this->project_model->getallusersbyproject( $prj_id );
		$data['projectdata'] 	= $this->project_model->getprojectallengineers($prj_id,$firstweekday,$lastweekday,$data['user_id']);
		
		// echo'<pre>'; print_r( $data ); exit();
		$this->load->view('common/header');
		$this->load->view('project_details',$data);
		$this->load->view('common/footer');
	}

	public function view_all_projects()
	{
		$role = $this->session->userdata('role_id');
		$site = $this->session->userdata('site_id');
		$region = $this->session->userdata('region_id');
		if ( ! empty($_GET['from_date']) AND ! empty($_GET['to_date']) ) 
		{
			$firstweekday = date("Y-m-d", strtotime($_GET['from_date']));
			$lastweekday = date("Y-m-d", strtotime($_GET['to_date']));
                        $type=$list_project='';
			
		}
//		$data['total_projects'] = $this->dashboard_model->get_total_projects( $role, $site, $region, $firstweekday, $lastweekday );
		$data['total_projects'] = $this->project_model->get_projects($region, $site, $type, $list_project, $lastweekday, 'dashboard');
//                print_r($data['projects']);exit;
                $data['title'] = 'Active Projects';
		$this->load->view('common/header');
		$this->load->view('view_all_projects',$data);
		$this->load->view('common/footer');
	}
}