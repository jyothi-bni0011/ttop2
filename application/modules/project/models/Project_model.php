<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends MY_Model {

    public function project($reg_id = '', $site_id = '', $project_type = '', $list_project = '', $to_date = '') {
        $this->db->select('p.*,p.status as pstatus,r.region_name, s.site_name, u.username as svname');
        $this->db->from(PROJECTS . ' as p');
        $this->db->join(SITE . ' as s', 's.site_id = p.site_id');
        $this->db->join(REGION . ' as r', 's.region_id = r.reg_id');
        $this->db->join(USER . ' as u', 'u.user_id = p.supervisor_id', 'left');

        $r_conditions = $s_conditions = $g_conditions = '';



        if (!empty($project_type) && $project_type == 'global') {
            $this->db->where('p.project_type', 'global');
        }
        if (!empty($project_type) && $project_type == 'region') {
            $this->db->where('p.project_type', 'region');
            $this->db->where('r.reg_id', $reg_id);
        }
        if (!empty($project_type) && $project_type == 'site') {
            $this->db->where('p.project_type', 'site');
            $this->db->where('s.site_id', $site_id);
        }
        if (empty($project_type)) {
            $where = "p.project_type = 'global' OR p.project_type = 'region' AND r.reg_id = '" . $reg_id . "' OR p.project_type = 'site' AND s.site_id = '" . $site_id . "'";
            $this->db->where($where);
        }

        if (!empty($r_conditions)) {
            $r_conditions = trim($r_conditions, ' OR ');
            //exit;
            $this->db->where('(' . $r_conditions . ')');
        }
        /*
          if(!empty($reg_id)){
          $this->db->where('r.reg_id', $reg_id);
          }

          if(!empty($site_id)){
          $this->db->where('s.site_id', $site_id);
          }

          if(!empty($project_type)){
          $this->db->where('p.project_type', $project_type);
          }
         */
        if (empty($list_project)) {
            $this->db->where('p.status', 1);
        }

        if (!empty($to_date)) {
            $this->db->where('p.created_on <= ', $to_date);
        }
        $this->db->order_by('p.created_on','desc');
        $query = $this->db->get();
//		echo $this->db->last_query(); exit;
        return $query->result();
    }

    public function get_projects($reg_id = '', $site_id = '', $project_type = '', $list_project = '', $to_date = '',$came_from=null, $from_date=''){ 
        $this->db->select('p.*,p.status as pstatus,r.region_name, s.site_name, u.username as svname,cc.cost_center_code,cc.cost_center_name, (SELECT SUM(ts.hours) FROM timesheet as ts LEFT JOIN timecard as tc ON tc.timecard_id=ts.timecard_id WHERE p.id = ts.project_id AND (tc.status = 2 OR tc.status = 3) AND DATE(ts.working_date) >=\''. $from_date .'\' AND DATE(ts.working_date) <= \''. $to_date. '\') as total_hours, (SELECT SUM(st.estimated_hours) from subtask as st where st.project_id = p.id AND st.status = 1) as estimated_hours');
        $this->db->from(PROJECTS . ' as p');
        $this->db->join(SITE . ' as s', 's.site_id = p.site_id');
        $this->db->join(REGION . ' as r', 's.region_id = r.reg_id');
        $this->db->join(USER . ' as u', 'u.user_id = p.supervisor_id', 'left');
        // $this->db->join('subtask as st', 'st.project_id = p.id', 'left');

        //echo $came_from; 
            $this->db->join('cost_center as cc', 'cc.cc_id = p.cost_center_id', 'left');
        if($came_from=='dashboard')
        {
            if (empty($project_type)) {
                $where = "p.status = '1' AND (p.project_type = 'global' OR p.project_type = 'region' AND r.reg_id = '" . $reg_id . "' OR p.project_type = 'site' AND s.site_id = '" . $site_id . "')";
                $this->db->where($where);
            }

        }
        else
        {
            if (empty($came_from) && empty($list_project)) {
             $this->db->where('p.status', 1);
             }
           
            
            $r_conditions = $s_conditions = $g_conditions = '';
            if (!empty($reg_id)) {

                $r_conditions .= "(p.project_type = 'region' and r.reg_id = $reg_id) OR ";
            }

            if (!empty($site_id)) {

                $r_conditions .= "(p.project_type = 'site' and s.site_id = $site_id) OR ";
            }

            if (!empty($project_type)) {
                $r_conditions .= "(p.project_type = 'global')";
            }

            if (!empty($r_conditions)) {
                $r_conditions = trim($r_conditions, ' OR ');
                //exit;
                $this->db->where('(' . $r_conditions . ')');
            }
        }
        

        

        if (!empty($to_date)) {
            $this->db->where('p.created_on <= ', $to_date);
        }

        $query = $this->db->get();
       // echo $this->db->last_query(); exit;
        return $query->result();
    }

    public function get_users_project($user_id, $end_date, $next_or_prev = '') {


        $this->db->select('p.id, p.project_name, p.project_name as id1, u.username, ap.start_date, ap.end_date');
        $this->db->from(PROJECTS . ' as p');
        $this->db->join(ASSIGN_PROJECT . ' as ap', 'p.id = ap.project_id');
        $this->db->join(USER . ' as u', 'u.user_id = ap.user_id');
        $this->db->where('ap.user_id', $user_id);
        $this->db->where_in('ap.status', array('1', '2')); //only approved projects
        $where = '(ap.end_date  >= "' . $end_date . '" or ap.end_date is NULL or ap.end_date = "0000-00-00")';

        if (!empty($next_or_prev) && ($next_or_prev == 'next')) {
            $like_cond = "LIKE";
            $operator = "OR";

            $where .= 'AND (';
            $proj_cond = '';
            foreach (HOLIDAY_PROJECTS as $proj) {
                $proj_cond .= "p.project_name $like_cond '%" . $proj . "%' $operator ";
            }

            $proj = rtrim($proj_cond, " $operator ");
            $where .= $proj . ')';

            $this->db->where($where);
        } else {
            //$like_cond = "NOT LIKE";
            //$operator = "AND";
            $this->db->where($where);
        }


        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $query->result();
    }

    public function get_cost_center_by_site($site_id) {
        $this->db->select('*');
        $this->db->from('cost_center');
        $this->db->join('site', 'site.cost_center_id = cost_center.cc_id');
        $this->db->where('site.site_id', $site_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getallusersbyproject($proj_id) {
        $supervisor_id = $this->session->userdata('user_id');
        $this->db->select('users.user_id, users.username');
        $this->db->from('assign_project');
        $this->db->join('users', 'assign_project.user_id = users.user_id', 'left');
        $this->db->join('projects', 'assign_project.project_id = projects.id', 'left');
        // if ( $this->session->userdata('role_id') != 1 ) 
        // {
        // 	$mgrAssignedCond = "(users.supervisor_id = " . $supervisor_id . " OR users.pr_supervisor_id = " . $supervisor_id . ")";
        // 	$this->db->where($mgrAssignedCond);
        // }
        $this->db->where('assign_project.project_id', $proj_id);
        // $this->db->where('assign_projects.other_status', 0);
        $this->db->where('projects.status', 1);
        // $this->db->where('users.status', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getprojectallengineers($proj_id, $from, $to, $user_id = 0) {
        $return = array();
        $supervisor_id = $this->session->userdata('user_id');
        $this->db->select('users.user_id, users.username, users.employee_id as emp_id, assign_project.subtask_ids');
        $this->db->from('assign_project');
        $this->db->join('users', 'assign_project.user_id = users.user_id', 'left');
        $this->db->join('projects', 'assign_project.project_id = projects.id', 'left');
        // if ( $this->session->userdata('role_id') != 1 ) 
        // {
        // 	$mgrAssignedCond = "(users.supervisor_id = " . $supervisor_id . " OR users.pr_supervisor_id = " . $supervisor_id . ")";
        // 	$this->db->where($mgrAssignedCond);
        // }
        $this->db->where('assign_project.project_id', $proj_id);
        $this->db->where('projects.status', 1);
        if ($user_id) {
            $this->db->where('users.user_id', $user_id);
        }
        $query = $this->db->get();

        // echo'<pre>'; print_r( $query->result() ); exit();
        foreach ($query->result() as $engineer) {
            $return[$engineer->user_id] = $engineer;
            $return[$engineer->user_id]->engineerdata = $this->get_engineerereddata($engineer->user_id, $proj_id, $from, $to);
            $return[$engineer->user_id]->subtaskdata = $this->get_assigned_subtasks_details(json_decode($engineer->subtask_ids));
        }
        // 	print_r( $return );echo $from.' '.$to;
        // exit();

        return $return;
    }

    public function get_engineerereddata($user_id, $proj_id, $from, $to) {
        $this->db->select('SUM(ts.hours) as total_hours, st.subtask_name');
        $this->db->from('timesheet as ts');
        $this->db->join('timecard as tc', 'tc.timecard_id = ts.timecard_id', 'left');
        $this->db->join('subtask as st', 'st.subtask_id = ts.subtask_id', 'left');
        $this->db->where('ts.project_id', $proj_id);
        $this->db->where('tc.employee_id', $user_id);
        $this->db->where('DATE(ts.working_date) >=', $from);
        $this->db->where('DATE(ts.working_date) <=', $to);
        $where = '(tc.status = 3 OR tc.status = 2)';
        $this->db->where($where);
        // $this->db->where('tc.status',3); // Only approved timesheet
        // $this->db->group_by('ts.subtask_id');
        $query = $this->db->get();
        // echo'<pre>'; print_r( $query->result() ); exit();
        return $query->result();
    }

    public function assign_project($value)
    {
        $this->db->insert('assign_project', $value);
        if( $this->db->affected_rows() ) {
            return $this->db->insert_id();
        }   
        return FALSE;
    }

}
