<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author sachith
 */
class Users_m extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
    }

    public function getEmployeeList() {
        $this->db->select('emp_id,
            emp_no,
            emp_type_id,
            emp_level_id,
            name_full,
            name_short,
            name_title,
	');
        $this->db->from('emp_profile');
        $this->db->where('status=1');
        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }

        return $result;
    }

    public function getDivisionList() {
        $this->db->select('
            division_id,
            division_name,
            division_code
	');
        $this->db->from('corp_division');
        $this->db->where('status=1');
        $this->db->order_by('row_order', 'ASC');
        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }

        return $result;
    }

    public function getSectionsListByDivision($division_id = array()) {
        $this->db->select('
            section_id,
            section_name,
            section_code
	');
        $this->db->from('corp_section');
        $this->db->where('status=1');
        $this->db->where_in('division_id', $division_id);
        $this->db->order_by('row_order', 'ASC');
        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }

        return $result;
    }

    public function saveUserEmployee($user_id = 0, $empl_id = 0) {
        if (empty($user_id) || empty($empl_id)) {
            return false;
        }
        //remove current records
        $datestring = '%Y-%m-%d %H:%i:%s';
        $this->db->trans_start();

        $this->db->where('users_id', $user_id);
        $this->db->delete('user_employee');
        //
        $data = array(
            'emp_id' => $empl_id,
            'users_id' => $user_id
        );

        $flag = $this->db->insert('user_employee', $data);
        $trans = $this->db->trans_complete();
        if ($trans) {
            return true;
        } else {
            return false;
        }
    }

    public function saveUserDivisions($user_id = 0, $divisions = array()) {
        if (empty($user_id) || empty($divisions)) {
            return false;
        }
        if (!is_array($divisions)) {
            return false;
        }
        //remove current records
        $datestring = '%Y-%m-%d %H:%i:%s';
        $this->db->trans_start();

        $this->db->where('users_id', $user_id);
        $this->db->delete('user_division');
        //
        $division_batch = array();
        foreach ($divisions as $division) {
            $div_row["users_id"] = $user_id;
            $div_row["division_id"] = $division;
            $division_batch[] = $div_row;
        }
        $flag = $this->db->insert_batch('user_division', $division_batch);
        $trans = $this->db->trans_complete();
        if ($trans) {
            return true;
        } else {
            return false;
        }
    }

    public function saveUserSections($user_id = 0, $sections = array()) {
        if (empty($user_id) || empty($sections)) {
            return false;
        }
        if (!is_array($sections)) {
            return false;
        }

        //remove current records
        $datestring = '%Y-%m-%d %H:%i:%s';
        $this->db->trans_start();

        $this->db->where('users_id', $user_id);
        $this->db->delete('user_section');
        //
        $section_batch = array();
        foreach ($sections as $section) {
            $sec_row["users_id"] = $user_id;
            $sec_row["section_id"] = $section;
            $section_batch[] = $sec_row;
        }
        $flag = $this->db->insert_batch('user_section', $section_batch);
        $trans = $this->db->trans_complete();
        if ($trans) {
            return true;
        } else {
            return false;
        }
    }

    public function getDtableUsers() {
//        $this->load->database();
        $this->db->select('id, 
	email');
        $this->db->from('aauth_users');
        $this->db->where('status >', 0);
        $this->db->where('user_type !=', 0);
        $this->db->order_by('id', 'DESC');
        $result = FALSE;
        $totalData = $this->db->count_all_results();
        if (!empty($query)) {
            $result = $query->result();
        }

        $totalFiltered = $totalData;
        $table_data = array();
        $q = '';
        if (!empty($totalData)) {
            $columns = array(
                // datatable column index  => database column name
                0 => 'id',
                1 => 'email',
                2 => 'username',
                3 => 'last_login',
                4 => 'banned'
            );
            // filter
            $search = $this->input->post_get('search');
            $order = $this->input->post_get('order');
            $start = $this->input->post_get('start');
            $limit = $this->input->post_get('length');
            $this->db->select('id, 
                    email, 
                    username, 
                    banned, 
                    last_login');
            $this->db->from('aauth_users');
            $this->db->where('status >', 0);
            $this->db->where('user_type !=', 0);
            // if there is a search parameter, ['search']['value'] contains search parameter
            if (!empty($search['value'])) {
                $this->db->group_start();
                $this->db->like('email', $search['value'], 'both');
                $this->db->or_like('username', $search['value'], 'both');
                $this->db->group_end();
            }
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
//            if (!empty($order[0]['column'])) {
//            }
            if (!empty($limit)) {
                $this->db->limit($limit, $start);
            }
            $query = $this->db->get();
            $data_result = false;
            if (empty($query)) {
                return false;
            } else {
                $data_result = $query->result();
            }
            if (!empty($search['value'])) {
                $totalFiltered = $query->num_rows();
            }

//            if (!empty($data_result)) {
//                foreach ($data_result as $row) {
//                    $a = array();
//                    $a[] = $row->id;
//                    $a[] = $row->username;
//                    $a[] = $row->email;
//                    $a[] = $row->last_login;
//                    $a[] = $row->banned;
//
//                    $table_data[] = $a;
//                }
//            }
        }
        $json_data = array(
            "draw" => intval($this->input->post_get('draw')), // for every request/draw by clientside , they send a number as a parameter
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data_result   // total data array
        );
        return $json_data;
    }

    public function getUserDataById($id) {
        $this->load->database();
        $this->db->select('A.id, 
                    A.email, 
                    A.username,
                    ');
        $this->db->from('aauth_users AS A');
        $this->db->where('A.id', $id);
        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }

        if (!empty($result)) {
            $result->group = $this->getUserGroupByUserId($id);
            $result->employee = $this->getUserEmployeeByUserId($id);
            $division_arr = array();
            $divisions = $this->getUserDivisionByUserId($id);
            if (!empty($divisions)) {
                foreach ($divisions as $div) {
                    $division_arr[] = $div->division_id;
                }
            }
            $result->divisions = $division_arr;
            //
            $section_arr = array();
            $sections = $this->getUserSectionsByUserId($id);
            if (!empty($sections)) {
                foreach ($sections as $sec) {
                    $section_arr[] = $sec->section_id;
                }
            }
            $result->sections = $section_arr;
        }
        return $result;
    }

    public function remove_user($user_id) {
        // do not delete record, we only update the record status to -1
        $this->db->set('status', -1);
        $this->db->set('username', 'concat("_DELETED_",username)', FALSE);
        $this->db->set('banned', 1);
        $this->db->where('id', $user_id);
        $flag = $this->db->update('aauth_users');
        return $flag;
    }

    public function getUserGroupByUserId($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('group_id', 'DESC');
        $query = $this->db->get('aauth_user_to_group');
        $result = false;
        if (!empty($query)) {
            $result = $query->row();
        }
        return $result;
    }

    public function getUserDivisionByUserId($id) {
        $this->db->from('user_division');
//        $this->db->where('status=1');
        $this->db->where('users_id', $id);
        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }

        return $result;
    }

    public function getUserSectionsByUserId($user_id) {
        $this->db->where('users_id', $user_id);
//        $this->db->order_by('group_id', 'DESC');
        $query = $this->db->get('user_section');
        $result = false;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

    public function getUserEmployeeByUserId($user_id) {
        $this->db->where('users_id', $user_id);
        $query = $this->db->get('user_employee');
        $result = false;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

    public function getUsersByGroupId($group_id) {
        $this->db->select('B.id,
        B.username');
        $this->db->from('aauth_user_to_group AS A');
        $this->db->join('aauth_users AS B', 'B.id = A.user_id');
        $this->db->where('group_id', $group_id);
        $this->db->where('B.status=1');
        $query = $this->db->get();
        $result = false;
        if (!empty($query)) {
            $result = $query->result();
//            print_r($this->db->last_query());
//            exit;
        }
        return $result;
    }
    public function check_user_name_in_db() {
          $emp_id = $this->input->post('emp_id');  
          
        $this->db->select('user_employee.users_id');
        $this->db->from('user_employee');
        $this->db->where('emp_id', $emp_id);
//        $this->db->where('status=1');
        $query = $this->db->get();
//           print_r($this->db->last_query());
//    exit;
        $result = false;
        if (!empty($query)) {
           $rowcount = $query->num_rows();
        }
        return $rowcount;
    }
    
    

}
