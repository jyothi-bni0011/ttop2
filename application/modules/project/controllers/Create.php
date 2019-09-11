<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends MY_Controller {


    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('create_model');
        $this->load->model('region/region_model');
        $this->load->model('login/login_model');
        $this->load->model('project/project_model');
        $this->load->model('users/users_model');
        $this->load->model('site/site_model');
    }

    public function index() {
        $data['title'] = "Create Project";

        if (count($_POST)) {

            $this->form_validation->set_rules('project_id', 'Project ID', 'trim|required|max_length[49]');
            $this->form_validation->set_rules('project_name', 'Project Name', 'trim|required|max_length[49]');
            $this->form_validation->set_rules('explicite_subtask', 'Explicite Subtask', 'trim|required');
            $this->form_validation->set_rules('project_type', 'Project Type', 'trim|required');
            $this->form_validation->set_rules('cost_center', 'Cost Center Name', 'trim|required|integer');

            if ($this->form_validation->run()) {
                if ($this->create_model->check_duplicate(PROJECTS, SAP_NO, $this->input->post('project_id'))) {

                    $supervisor_id = ($this->input->post('project_type') != 'site') ? '' : $this->input->post('supervisor_id');
                    $project_array = array(
                        PROJECT_SITE_ID => $this->input->post('site_id'),
                        SAP_NO => $this->input->post('project_id'),
                        PROJECT_NAME => $this->input->post('project_name'),
                        PROJECT_DESCRIPTION => $this->input->post('project_description'),
                        PROJECT_BUDGET => $this->input->post('project_budget'),
                        PROJECT_TYPE => $this->input->post('project_type'),
                        SUPERVISOR_ID => $supervisor_id,
                        PROJECT_EXP_SUBTASK => $this->input->post('explicite_subtask'),
                        PROJECT_START_DATE => date("Y-m-d", strtotime($this->input->post('start_date'))),
                        PROJECT_END_DATE => date("Y-m-d", strtotime($this->input->post('end_date'))),
                        PROJECT_CREATED_BY => $this->session->userdata('user_id'),
                        STATUS => 1,
                        CREATED_ON => date('Y-m-d H:i:s', now()),
                        'project_owner' => $this->input->post('owner'),
                        'cost_center_id' => $this->input->post('cost_center')
                    );


                    if ($inserted_id = $this->create_model->create($project_array)) {



                        //insert in log
                        $this->create_model->insert_log_history((int) $this->session->userdata('user_id'), 'Project', 'New Project \'' . $this->input->post('project_name') . '\' is created');
                        //echo "<pre>"; print_r($_POST);

                        if ($this->input->post('continue_with_subtask') == 'yes') {
                            //echo "<pre>"; print_r($_SESSION); exit;
                            $data['regions'] = $this->region_model->region();
                            $site_name = $this->site_model->get_site_name($this->input->post('site_id'));
                            //echo "<pre>"; print_r($site_name); exit;
                            $data['title'] = "Create Subtask";
                            $data['site_name'] = $site_name->site_name;
                            $data['site_id'] = $this->input->post('site_id');
                            $data['region_id'] = $this->input->post('region_id');
                            $data['project_id'] = $inserted_id;
                            $data['projects'] = $this->project_model->get_projects($this->input->post('region_id'), $this->input->post('site_id'), 'global');
                            $data['continue_from_project'] = 1;
                            //echo "<pre>"; print_r($data); exit;
                            //$this->session->set_flashdata('data', '123');
                            //redirect( '/subtask/create', $data );
                            //exit;
                            $data['title'] = "Create Subtask";
                            $data['project_flag'] = 1;
                            $this->load->view('common/header');
                            $this->load->view('subtask/create', $data);
                            $this->load->view('common/footer');
                        } else {

                            $this->session->set_flashdata('message', '<div class="alert alert-success">Project has been created successfully</div>');
                            redirect('/project', $data);
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to create the project</div>');
                        redirect('/project/create', $data);
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Duplicate SAP No. Failed to create the project</div>');
                    redirect('/project/create', $data);
                }
            } else {
                $this->session->set_flashdata('message', validation_errors());
                redirect('/project/create', $data);
            }
        } else {

            $user_id = $this->session->userdata('user_id');
            $userdata = $this->login_model->get_userdata($user_id, $this->session->userdata('region_id'), $this->session->userdata('site_id'));
            $data['userdata'] = !empty($userdata) ? $userdata : '';
            //echo $this->db->last_query(); exit;
            //echo "<pre>"; print_r($userdata); exit;
            //supervisor_role = 3
            $data['supervisordata'] = $this->users_model->get_rolewise_users('3', $this->session->userdata('site_id'));
            $data['cost_centers'] = $this->users_model->getByIdAll(COST_CENTER, 'status', 1);
            //echo "<pre>"; print_r($data['supervisordata']); exit;
            //$data['cost_center']=$this->Sites_model->get_cost_center();
            //$data['regions'] = $this->users_model->getByIdAll( 'region', 'status', $this->session->userdata('site_id') );
            $data['regions'] = $this->region_model->region();
            //echo $this->db->last_query(); exit;
            $this->load->view('common/header');
            $this->load->view('create', $data);
            $this->load->view('common/footer');
        }
    }

    public function check_duplicate() {
         $feild = $this->input->post('feild');
        if ($feild == 'project_id') {
            if ($this->create_model->check_duplicate(PROJECTS, SAP_NO, $this->input->post('project_id'))) {
                echo "true";
            } else {
                echo "false";
            }
        }
        if ($feild == 'project_name') {
            if ($this->create_model->check_duplicate(PROJECTS, PROJECT_NAME, $this->input->post('project_name'))) {
                echo "true";
            } else {
                echo "false";
            }
        }
            
    }

}

