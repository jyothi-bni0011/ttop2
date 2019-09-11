<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('create_model');
		$this->load->model('users_model');
		$this->load->model('roles/Roles_model');
		$this->load->model('region/Region_model');
		$this->load->model('login/Login_model');
	}

	

	public function index()
	{
        //echo "<pre>"; print_r($_SESSION); exit;

		$data['title'] = "Users";

        if (count($_POST)) {
			//print_r($_POST); exit();
			
			$this->form_validation->set_rules('user_name', 'User Name', 'trim|required');
			$this->form_validation->set_rules('user_email', 'User Email ID', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
			//$this->form_validation->set_rules('region_id', 'Region', 'required');
			//$this->form_validation->set_rules('site_id', 'Site', 'required');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
			if( $this->form_validation->run() ) {

				if ($this->create_model->check_duplicate( USER, USER_EMAIL, $this->input->post('user_email') )) 
				{
					if ($this->create_model->check_duplicate( USER, USERNAME, $this->input->post('user_name') )) 
					{
						$user_array = array(
							USER_FIRST_NAME => $this->input->post('user_first_name'),
							USER_MIDDLE_NAME => $this->input->post('user_middle_name'),
							USER_LAST_NAME	 => $this->input->post('user_last_name'),
							USERNAME => $this->input->post('user_name'),
							EMPLOYEE_ID => $this->input->post('employee_id'),
							USER_EMAIL => $this->input->post('user_email'),
							USER_PASSWORD => md5($this->input->post('password')),
							//USER_SITE_ID => $this->input->post('site_id'),
                            //SUPERV_ID => $this->input->post('select_supervisor'),
                            CREATED_BY => $this->session->userdata('user_id'),
							STATUS => '1',
							CREATED_ON => date('Y-m-d H:i:s', now())
						);
						if( $inserted_id = $this->create_model->create($user_array) ) 
						{
					
							/*if ( $this->create_model->create_user_role( $this->input->post('user_role'), $inserted_id ) ) {

								$this->create_model->insert_portal_data($this->input->post('portal_selection'), $inserted_id);
								
								//insert log
								$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'User', 'New User \''.$this->input->post('user_name').'\' is created' );

								
							}
                            $this->session->set_flashdata('message', '<div class="alert alert-success">User has been created.</div>');*/
					
						}
						else {
							
							$this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to create the user</div>');
							redirect( '/users/create', $data );
						}		
					}
					else 
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger">Duplicate Username.Failed to create the user</div>');
						redirect( '/users/create', $data );
					}
				}
				else 
				{
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Duplicate Email.Failed to create the user</div>');
					redirect( '/users/create', $data );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/users/create', $data );
			}

            //$data['inserted_id'] = $inserted_id;
            //$data['inserted_emp'] = $this->input->post('user_name');
            
			//$this->load->view('common/header');
            //$this->load->view('assign_role', $data);
            redirect( '/users/assign_role/'.$inserted_id, $data );
            //$this->load->view('common/footer');
		}
		else{

            
			$allroles = $this->Roles_model->roles();
			$login_user = $this->Roles_model->roles($this->session->userdata('role_id'));
			$permissions = json_decode($login_user[0]->create_user_permission);
			$data['regions'] = $this->Region_model->region();
			$userdata = $this->Login_model->get_userdata($this->session->userdata('user_id'));
			$data['site_id'] = $userdata->site_id;
			$data['site_name'] = $userdata->site_name;
			$data['employee_id'] = $userdata->employee_id;
			$data['reg_id'] = $userdata->region_id;
			$data['portals'] = $this->users_model->getAll(PORTAL);
            $cond_arr = array('role_id'=>3,
                                'status'=>1);

            $get_site_ids = $this->users_model->getByIdAll(SITE, 'region_id', $userdata->region_id);
            foreach($get_site_ids as $sites){
                $site_arr[] = $sites->site_id;
            }
            $supervisordata = $this->users_model->getSupervisors($userdata->region_id, $site_arr);
            //echo "<pre>"; print_r($supervisordata); exit;

			foreach($allroles as $role){
				if(in_array($role->role_id, (array)$permissions)){
					$role_array[] = $role;
				}
			}
            $data['supervisors'] = $supervisordata;
			$data['roles'] = $role_array;
			$this->load->view('common/header');
			$this->load->view('create', $data);
			$this->load->view('common/footer');
		}

	}


    public function assign_role(){
       // echo "<pre>"; print_r($_POST); exit;
        $total_rec = $this->input->post('addrowcount');
        $user_array = $mapping_array = array();
        $x=0;

        $del = $this->users_model->deleteRecord('users_role_mapping', array('user_id'=>$_POST['user_id']));

        for($i=0; $i<$total_rec; $i++){

            for($j=0; $j < count($_POST['user_role'][$i]); $j++){

                $mapping_array[$x]['user_id'] = $_POST['user_id'];
                $mapping_array[$x]['role_id'] = $_POST['user_role'][$i][$j];
                $mapping_array[$x]['region_id'] = $_POST['region_id'][$i];
                $mapping_array[$x]['site_id'] = $_POST['site_id'][$i];

                $user_array['select_supervisor'] = $_POST['select_supervisor'][$i];

                if(isset($_POST['portal_selection'][$i])){
                    for($k=0; $k < count($_POST['portal_selection'][$i]); $k++){
                        $final_array[$x]['portal_selection'][] = $_POST['portal_selection'][$i][$k];
                    }
                }
              $x++;  
            }
            
        }

        $insert_timesheet = $this->users_model->insert_batch_Record('users_role_mapping', $mapping_array);
        echo "<pre>"; print_r($final_array); exit;
    }

     /* Des: Bulk upload for Users (start)
     * @created BY: Jyothi @created on:04/06/2019
     * @modified BY: Jyothi @modified on:06/06/2019
     * 
     */

    //upload view - start
    public function upload() {

        $allroles = $this->Roles_model->roles();
        $login_user = $this->Roles_model->roles($this->session->userdata('role_id'));
        $permissions = json_decode($login_user[0]->create_user_permission);
        foreach ($allroles as $role) {
            if (in_array($role->role_id, (array) $permissions)) {
                $role_array[] = $role;
            }
        }
        $data['roles'] = $role_array;
        $user_id = $this->session->userdata('user_id');
        $result = $this->Login_model->get_userdata($user_id);
        $data['regiondata'] = $result;
        $data['page_title'] = "Upload Users Bulk Data";
        $this->load->view('common/header');
        $this->load->view('upload_user', $data);
        $this->load->view('common/footer');
    }

    //inserting data using excel - start 
    public function insertexcel() {

        $config['upload_path'] = 'uploads/excel/';
        $config['allowed_types'] = '*';
        $config['file_name'] = $_FILES['userfile']['name'];
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('userfile');

        $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
        $file_name = $upload_data['file_name']; //uploded file name
        $extension = $upload_data['file_ext'];    // uploded file extension
        //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
        require_once( APPPATH . 'third_party/PHPExcel/IOFactory.php');
        $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007 	  
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load(FCPATH . 'uploads/excel/' . $file_name);
        $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel   
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

        // Headers matching !!
        $user_name = $objWorksheet->getCellByColumnAndRow(0, 1)->getValue();
        $employee_id = $objWorksheet->getCellByColumnAndRow(1, 1)->getValue();
        $first_name = $objWorksheet->getCellByColumnAndRow(2, 1)->getValue();
        $middle_name = $objWorksheet->getCellByColumnAndRow(3, 1)->getValue();
        $last_name = $objWorksheet->getCellByColumnAndRow(4, 1)->getValue();
        $email_id = $objWorksheet->getCellByColumnAndRow(5, 1)->getValue();
        $password = $objWorksheet->getCellByColumnAndRow(6, 1)->getValue();
        $highestcolumn = $objWorksheet->getHighestColumn();

        $projects_added_msg = '';
        if ($user_name != 'username' || $employee_id != 'employee_id' || $first_name != 'first_name' || $last_name != 'last_name' || $middle_name != 'middle_name' || $email_id != 'email_id' || $password != 'password'
        ) {
            $projects_added_msg .= 'Invalid Headers provided for the fields.';
            $totalrows = 0;
        }
        for ($i = 2; $i <= $totalrows; $i++) {
            if ($objWorksheet->getCellByColumnAndRow(0, $i)->getValue() != '') {

                $user_name = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
                $employee_id = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
                $first_name = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
                $middle_name = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
                $last_name = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
                $email_id = $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
                $password = $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();


                // Any empty values will lead to break the for loop
                if (empty($user_name) || empty($employee_id) || empty($first_name) || empty($last_name) || empty($email_id) || empty($password)){
                   $projects_added_msg .= '<div class="alert alert-danger">Invalid data privide for row ' . $i . '</div>';
                    break;
                }
                if ($this->create_model->check_duplicate(USER, USER_EMAIL, $email_id)) {
                    if ($this->create_model->check_duplicate(USER, USERNAME, $user_name)) {
                        $user_array = array(
                            USER_FIRST_NAME => $first_name,
                            USER_MIDDLE_NAME => $middle_name,
                            USER_LAST_NAME => $last_name,
                            USERNAME => $user_name,
                            EMPLOYEE_ID => $employee_id,
                            USER_EMAIL => $email_id,
                            USER_PASSWORD => md5($password),
                            USER_SITE_ID => $this->session->userdata('site_id'),
                            CREATED_BY => $this->session->userdata('user_id'),
                            STATUS => '1',
                            CREATED_ON => date('Y-m-d H:i:s', now())
                        );
                            $role_id = $this->input->post('user_role');
                        if ($inserted_id = $this->create_model->create($user_array)) {
                            if ($this->create_model->create_user_role($role_id, $inserted_id)) {

                                $this->create_model->insert_portal_data([1], $inserted_id);

                                //insert log
                                $this->create_model->insert_log_history((int) $this->session->userdata('user_id'), 'User', 'New User \'' . $user_name . '\' is created');

                                    $projects_added_msg .= '<div class="alert alert-success">' . $user_name . ' User has been created.</div>';
                                } else {
                                    $projects_added_msg .= '<div class="alert alert-danger">Failed to create the user role</div>';
                            }
                        } else {

                                $projects_added_msg .= '<div class="alert alert-danger">Failed to create the user</div>';
                        }
                    } else {
                            $projects_added_msg .= '<div class="alert alert-danger">Duplicate Username ' . $user_name . ' .Failed to create the user</div>';
                    }
                } else {
                        $projects_added_msg .= '<div class="alert alert-danger">Duplicate Email ' . $email_id . ' .Failed to create the user</div>';
                }
            }
        }

        unlink('././uploads/excel/' . $file_name); //File Deleted After uploading in database .	
        $this->session->set_flashdata('message', $projects_added_msg);
        redirect(base_url() . "users");
    }

    //Bulk upload for Users (end)
}