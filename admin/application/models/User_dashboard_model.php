<?php

//sampath wijesinghe
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_dashboard_model extends CI_Model {

    public function getUserDivisions_array($user_id = 0)
    {

        $this->db->select('division_id');
        $this->db->from('user_division AS A');
        $this->db->where('A.users_id', $user_id);
        $query = $this->db->get();
        $divi_result = FALSE;
//
        $user_divisions_arr = array();
        if (!empty($query))
        {
            $divi_result = $query->result();
        }
        if (!empty($divi_result))
        {
            foreach ($divi_result as $divi)
            {
                $user_divisions_arr[] = $divi->division_id;
            }
        }
        return $user_divisions_arr;
    }

    public function getUserSections_array($user_id = 0)
    {

        $this->db->select('section_id');
        $this->db->from('user_section AS A');
        $this->db->where('A.users_id', $user_id);
        $query = $this->db->get();
        $result = FALSE;
//
        $user_sections_arr = array();
        if (!empty($query))
        {
            $result = $query->result();
        }
        if (!empty($result))
        {
            foreach ($result as $record)
            {
                $user_sections_arr[] = $record->section_id;
            }
        }
        return $user_sections_arr;
    }

    public function getUserEmployeeInfo($user_id = 0)
    {

        $this->db->from('user_employee AS A');
        $this->db->join('emp_profile AS B', 'A.emp_id = B.emp_id', 'inner');
        $this->db->where('B.status >=', 1);
        $this->db->where('A.users_id', $user_id);
        $query = $this->db->get();
//        print_r($this->db->last_query());
//        exit;
        $result = FALSE;

        if (!empty($query))
        {
            $result = $query->row();
        }

        return $result;
    }

//    Get employees count
    public function getUserEmployee_count()
    {

        $this->db->select('A.emp_id', false);
        $this->db->from('emp_profile AS A');
        $this->db->join('emp_in_division AS B', 'A.emp_id = B.emp_id', 'left');
        $this->db->join('corp_division AS C', 'B.division_id = C.division_id', 'left');

        $this->db->where('A.status >=', 1);

        $totalData = $this->db->count_all_results();

        return $totalData;
    }

//    Get users count
    public function getUsers_count()
    {

        $this->db->select('id');
        $this->db->from('aauth_users');
        $this->db->join('aauth_user_to_group', 'aauth_users.id = aauth_user_to_group.user_id');
        $this->db->join('aauth_groups', 'aauth_user_to_group.group_id = aauth_groups.id');
        $this->db->where('status >', 0);
        $totalData = $this->db->count_all_results();
        return $totalData;
    }

//    Get users count
    public function get_count_of_all($suto_inc, $from)
    {

        $this->db->select($suto_inc);
        $this->db->from($from);
//        $this->db->join('aauth_user_to_group', 'aauth_users.id = aauth_user_to_group.user_id');
//        $this->db->join('aauth_groups', 'aauth_user_to_group.group_id = aauth_groups.id');
        $this->db->where('status >', 0);
//        $this->db->where($where_tbl, $where_id);
        $totalData = $this->db->count_all_results();
        return $totalData;
    }

    public function category_notification_details()
    {
        $this->db->select('`notification`.`notification_category_id`,`notification_category`.`notification_category`');
        $this->db->join('`notification_category`', '`notification`.`notification_category_id` = `notification_category`.`notification_category_id`', 'LEFT');
        $this->db->group_by('notification.notification_category_id');
        $this->db->where('`notification`.`state`', '1');
        $d = $this->db->get('notification');
        if ($d)
        {
            return $d->result_array();
        }
    }

    public function update_user_password()
    {


        $pass = $this->input->post('password');
//        print_r($abc);
//        exit;
        $user_id = $this->session->userdata('id');
//       print_r($flag);
//       exit;
        $flag = $this->aauth->update_user($user_id, false, $pass, false);
        if ($flag)
        {
            echo json_encode(array("status" => 1, "msg" => "Successfully Saved"));
        }
        else
        {
            $err_arr = $this->aauth->get_errors_array();
            $str_err = implode(',', $err_arr);
            echo json_encode(array("status" => 2, "msg" => "Cannot change user name. " . $str_err));
        }
    }

  

}
