<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();
        $admin = $this->aauth->is_admin();
//        if ($admin) {
//             $this->load->helper('master_data');
//        } else {
//            redirect(site_url("administrator/admin_login"));
//        }
    }

    public function index() {
        $data['title'] = 'Manage Users';
        $data['styles'] = array("assets/js/data_tables/DataTables-1.10.12/css/dataTables.bootstrap.min.css",
            "assets/js/chosen_v1.6.2/chosen.min.css",
            "assets/js/chosen_v1.6.2/chosen-bootstrap.css",
            "assets/js/sweetalert-master/dist/sweetalert.css",
            "assets/js/sweetalert-master/themes/google/google.css",
            "assets/js/data_tables/DataTables-1.10.12/css/responsive.dataTables.min.css");

        $data['scripts'] = array(
            "assets/js/data_tables/DataTables-1.10.12/js/jquery.dataTables.min.js",
            "assets/js/data_tables/DataTables-1.10.12/js/dataTables.bootstrap.min.js",
            "assets/js/jquery-validation-1.15.0/jquery.validate.min.js",
            "assets/js/chosen_v1.6.2/chosen.jquery.min.js",
            "assets/js/sweetalert-master/dist/sweetalert.min.js",
            "assets/app_js/users.js",
            "assets/js/data_tables/DataTables-1.10.12/js/dataTables.responsive.min.js",
        );
        $admin = $this->aauth->is_admin();
        if ($admin) {
            $this->load->view('template/header', $data);
            $this->load->view('admin/users', $data);
            $this->load->view('template/footer', $data);
        } else {
            redirect(site_url("administrator/admin_login"));
        }
    }

    /**
     * jquery datatables load function
     */
    public function getJtableUsers() {

        $this->load->database();
        $this->db->select('id');
        $this->db->from('aauth_users');
        $this->db->join('aauth_user_to_group', 'aauth_users.id = aauth_user_to_group.user_id');
        $this->db->join('aauth_groups', 'aauth_user_to_group.group_id = aauth_groups.id');
        $this->db->where('status >', 0);
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
                1 => 'username',
                2 => 'user_type',
                3 => 'last_login',
                4 => 'banned',
            );
            // filter
            $search = $this->input->post_get('search');
            $order = $this->input->post_get('order');
            $start = $this->input->post_get('start');
            $limit = $this->input->post_get('length');

            $this->db->select('aauth_groups.`name` AS groupname,
aauth_users.username,
aauth_users.banned,
aauth_users.last_login,
aauth_users.id');
            $this->db->from('aauth_users');
            $this->db->join('aauth_user_to_group', 'aauth_users.id = aauth_user_to_group.user_id');
            $this->db->join('aauth_groups', 'aauth_user_to_group.group_id = aauth_groups.id');
            $this->db->where('status >', 0);
            // if there is a search parameter, ['search']['value'] contains search parameter
            if (!empty($search['value'])) {
                $this->db->group_start();
                $this->db->like('username', $search['value'], 'both');
                $this->db->or_like('aauth_groups.`name`', $search['value'], 'both');
//                $this->db->like('groupname', $search['value'], 'both');
                $this->db->group_end();
            }

            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
//            if (!empty($order[0]['column'])) {
//            }
//            log_message('error', $this->db->last_query());
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

            if (!empty($data_result)) {
                foreach ($data_result as $row) {
                    $a = array();
//                    if(strlen($row->username) == 4){
//                        $user = 'Member';
//                    }else{
//                        $user = 'Student';
//                    }
                    $a[] = $row->id;
                    $a[] = $row->username;
                    $a[] = $row->groupname;
//                    $a[] = $user;
                    $a[] = $row->last_login;
                    $a[] = $row->banned;

                    $table_data[] = $a;
                }
            }
        }
        $json_data = array(
            "draw" => intval($this->input->post_get('draw')), // for every request/draw by clientside , they send a number as a parameter
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $table_data   // total data array
        );
//        return $result;
        echo json_encode($json_data);  // send data as json format
    }

    public function getUserById() {
        $result = $this->getUserDataById($this->input->post('uid'));
        if (!empty($result)) {
            echo json_encode(array("status" => "1", "data" => $result));
        } else {
            echo json_encode(array("status" => "2", "data" => "Error"));
        }
    }

    public function getUserDataById($id) {

        $this->db->select('aauth_users.username,aauth_users.id');
        $this->db->from('aauth_users');
        $this->db->where('aauth_users.id', $id);
        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }


        return $result;
    }

    public function save() {

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $flag = FALSE;
        $user_id = (int) $this->input->post('id');
        if (empty($user_id)) {
            $this->form_validation->set_rules('u_name', 'User Name', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'required');
        } else {
            $this->form_validation->set_rules('id', 'User', 'trim|required|numeric');
        }
        $user_id = (int) $this->input->post('id');
        $group_id = (int) $this->input->post('group_id');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array("status" => 2, "msg" => validation_errors('<span class="error-msg">', '</span>')));
            return;
        }
        if (!empty($user_id)) {
            //update user
            $email = FALSE;
            $e = $this->input->post('email');
            if (!empty($e)) {
                $email = $this->input->post('email');
            }

            $pass = FALSE;
            $p = $this->input->post('password');
            if (!empty($p)) {
                $pass = $this->input->post('password');
            }

            $uname = FALSE;
            $u = $this->input->post('u_name');
            if (!empty($u)) {
                $uname = $this->input->post('u_name');
            }
            $flag = true;
            // user group update is not allowed, as it's difficult to manage the user profiles
        } else {
            //new user
            $logged_user = $this->input->post('u_name');
            $email = $logged_user . '@testmail.com';
            $user_id = $this->aauth->create_user($email, $this->input->post('password'), $this->input->post('u_name'),$group_id);
//            echo $user_id;
//            exit;
            if (!empty($user_id) && !empty($group_id)) {
                $flag = $this->aauth->add_member($user_id, $group_id);
            }
        }

        if ($flag) {
            echo json_encode(array("status" => 1, "msg" => "Successfully Saved"));
        } else {
            $err_arr = $this->aauth->get_errors_array();
            $str_err = implode(',', $err_arr);
            echo json_encode(array("status" => 2, "msg" => "Cannot save user. " . $str_err));
//            $error = $this->db->error();
//            log_message('error', $error['message']);
        }
    }

    /**
     * remove all aauth_user_to_group records of selected user where group id is larger than 3.
     * and add user to new group
     * @param type int $user_id
     * @param type int $group_id
     * @return boolean
     */
    public function updateUserGroups($user_id, $group_id) {
        $flag = FALSE;
        $this->load->database();
        $this->db->where('user_id', $user_id);
        $this->db->where('group_id >', 3);
        $flag = $this->db->delete('aauth_user_to_group');
        if ($flag !== FALSE) {
            $flag = $this->aauth->add_member($user_id, $group_id);
        }
        return $flag;
    }

    public function removeUserById() {
        $datestring = '%Y-%m-%d %H:%i:%s';
        //
        $this->load->database();
        $this->db->trans_begin();
        $user_id = (int) $this->input->post('uid');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array("status" => 2, "msg" => "Cannot delete"));
        } else {
            $flag1 = $this->aauth->delete_user($user_id);
            $this->db->trans_commit();
            echo json_encode(array("status" => 1, "msg" => "Successfully deleted"));
        }

        return true;
    }

    public function blockUserById() {
        $user_id = (int) $this->input->post('uid');
        $flag = $this->aauth->ban_user($user_id);
        if ($flag) {
            echo json_encode(array("status" => 1, "msg" => "User deactivated"));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Cannot deactivate user"));
        }
//        return $flag;
    }

    public function unblockUserById() {
        $user_id = (int) $this->input->post('uid');
        $flag = $this->aauth->unban_user($user_id);
        if ($flag) {
            echo json_encode(array("status" => 1, "msg" => "User activated"));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Cannot activate user"));
        }
//        return $flag;
    }

    /**
     * 
     * @param type $district_id
     * @param type $society_id
     * @param type $user_id
     * @param type $group_id
     * @return type
     */
    public function insertUserProfile($district_id, $society_id, $user_id, $group_id) {
        $datestring = '%Y-%m-%d %H:%i:%s';
        $group = $this->getIfdmsUserGroupById($group_id);
        $this->load->database();
        if ($group->profile_table == 'naqda_user_profile') {
            $data = array(
                'district_id' => $district_id,
                'aauth_user_id' => $user_id,
                'created_date' => mdate($datestring),
                'status' => 1
            );
        } else if ($group->profile_table == 'society_user_profile') {
            $data = array(
                'district_id' => $district_id,
                'society_id' => $society_id,
                'aauth_user_id' => $user_id,
                'created_date' => mdate($datestring),
                'status' => 1
            );
        }

        $flag = $this->db->insert($group->profile_table, $data);
        return $flag;
    }

    /**
     * 
     * @param type $district_id
     * @param type $society_id or list
     * @param type $user_id
     * @param type $group_id
     * @return type
     */
    public function update_user_by_id() {

        $user_id = (int) $this->input->post('update_id');
        $pass = $this->input->post('pass');


        if (!empty($user_id)) {
            $data = array(
                'pass' => $this->aauth->getCryptedPassword($pass), // Password cannot be blank but user_id required for salt, setting bad password for now
            );

            $this->db->where('id', $user_id);
            $this->db->update('aauth_users', $data);
//            log_message('error', $this->db->last_query());
//            $aa = $this->db->affected_rows();
//            echo $aa;
//            exit;
            if ($this->db->affected_rows() > 0) {
                echo json_encode(array("status" => 1, "msg" => "Successfully Updated"));
            } else {
                $err_arr = $this->aauth->get_errors_array();
                $str_err = implode(',', $err_arr);
                echo json_encode(array("status" => 2, "msg" => "Cannot Update user. " . $str_err));
            }
        }
    }

}
