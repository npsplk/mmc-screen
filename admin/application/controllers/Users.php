<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->aauth->control();
        $this->load->model('Users_m', 'Users_model');
        $this->load->helper('master_data');
    }

    public function index() {
        $data['title'] = 'Manage Users';
        $data['styles'] = array("assets/js/data_tables/DataTables-1.10.12/css/dataTables.bootstrap.min.css",
            "assets/js/chosen_v1.6.2/chosen.min.css",
            "assets/js/chosen_v1.6.2/chosen-bootstrap.css",
            "assets/js/sweetalert-master/dist/sweetalert.css",
            "assets/js/sweetalert-master/themes/google/google.css");

        $data['scripts'] = array(
            "assets/js/data_tables/DataTables-1.10.12/js/jquery.dataTables.min.js",
            "assets/js/data_tables/DataTables-1.10.12/js/dataTables.bootstrap.min.js",
            "assets/js/jquery-validation-1.15.0/jquery.validate.min.js",
            "assets/js/chosen_v1.6.2/chosen.jquery.min.js",
            "assets/js/sweetalert-master/dist/sweetalert.min.js"
        );
        $data['scriptview'] = array(
            'user_account_script'
        );
        $this->load->model('Users_m', 'Users_model');
        $data['empl_list'] = get_my_employee_list(false);
//        $data['empl_list'] = $this->Users_model->getEmployeeList();
        $data['divisions_list'] = $this->Users_model->getDivisionList();
//        $data['sections_list'] = $this->Users_model->getSectionsListByDivision();
        //
        $this->load->view('template/header', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('template/footer', $data);
    }

    /**
     * jquery datatables load function
     */
    public function getDtableUsers() {

        $json_data = $this->Users_model->getDtableUsers();
        echo json_encode($json_data);  // send data as json format
    }

    public function getSectionsByDivisionJson() {
        $division_id = $this->input->post('division_id');
        $result = get_my_sections_by_division($division_id);
        if (!empty($result)) {
            echo json_encode(array("status" => "1", "data" => $result));
        } else {
            echo json_encode(array("status" => "2", "data" => "Error. No Data Found"));
        }
    }

    public function getUserById() {
        $result = $this->Users_model->getUserDataById($this->input->post('uid'));
        if (!empty($result)) {
            echo json_encode(array("status" => "1", "data" => $result));
        } else {
            echo json_encode(array("status" => "2", "data" => "Error"));
        }
    }

    public function save() {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->load->model('Users_m', 'Users_model');

        $flag = FALSE;
        $user_id = (int) $this->input->post('id');
        //validations
        if (empty($user_id)) {
            $this->form_validation->set_rules('u_name', 'User Name', 'trim|required');
            $this->form_validation->set_rules('group_id', 'User Group', 'trim|required|numeric');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('division_id[]', 'Division', 'required');
        } else {
            $this->form_validation->set_rules('division_id[]', 'Division', 'required');
            $this->form_validation->set_rules('id', 'User', 'trim|required|numeric');
        }

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array("status" => 2, "msg" => validation_errors('<span class="error-msg">', '</span>')));
            return;
        }
        // end of field validation
        $group_id = (int) $this->input->post('group_id');
        $emp_id = (int) $this->input->post('emp_id');
        $division_listids = $this->input->post('division_id[]');
        $section_listids = $this->input->post('section_id[]');
        //update user
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


            $flag = $this->aauth->update_user($user_id, $email, $pass, $uname);
            $err_arr = $this->aauth->get_errors_array();

            if (count($err_arr) <= 0) {
                $this->aauth->remove_member_from_all($user_id);
                //
                if (!empty($user_id) && !empty($group_id)) {
                    $flag = $this->aauth->add_member($user_id, $group_id);
                }
                //set user employee
                if (!empty($user_id)) {
                    $u_emp = $this->Users_model->saveUserEmployee($user_id, $emp_id);
                    log_message('error', "emp:" . $u_emp);
                }
                //set user divisions
                if (!empty($user_id)) {
//                    $a = implode(',', $division_listids);
                    $u_divisions = $this->Users_model->saveUserDivisions($user_id, $division_listids);
//                    log_message('error', "division:" . $a);
                }
                //set user sections
                if (!empty($user_id)) {
                    $u_sections = $this->Users_model->saveUserSections($user_id, $section_listids);
//                    log_message('error', "section:" . $u_sections);
                }
            }
            $flag = true;
        } else {
            //new user
            $user_id = $this->aauth->create_user($this->input->post('email'), $this->input->post('password'), $this->input->post('u_name'));
            if (!empty($user_id) && !empty($group_id)) {
                $flag = $this->aauth->add_member($user_id, $group_id);
            }
            //set user employee
            if (!empty($user_id)) {
                $u_emp = $this->Users_model->saveUserEmployee($user_id, $emp_id);
                log_message('error', "emp:" . $u_emp);
            }
            //set user divisions
            if (!empty($user_id)) {
                $u_divisions = $this->Users_model->saveUserDivisions($user_id, $division_listids);
                log_message('error', "division:" . $u_divisions);
            }
            //set user sections
            if (!empty($user_id)) {
                $u_sections = $this->Users_model->saveUserSections($user_id, $section_listids);
                log_message('error', "section:" . $u_sections);
            }
        }

        if ($flag) {
            echo json_encode(array("status" => 1, "msg" => "Successfully Saved"));
        } else {
            $err_arr = $this->aauth->get_errors_array();
            $str_err = implode(',', $err_arr);
            echo json_encode(array("status" => 2, "msg" => "Cannot save user. " . $str_err));
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
        $user_id = (int) $this->input->post('uid');

        $flag1 = $this->Users_model->remove_user($user_id);
        if ($flag1) {
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
        return true;
    }

    public function unblockUserById() {
        $user_id = (int) $this->input->post('uid');
        $flag = $this->aauth->unban_user($user_id);
        if ($flag) {
            echo json_encode(array("status" => 1, "msg" => "User activated"));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Cannot activate user"));
        }
        return true;
    }

    public function backup_db($nodata=FALSE) {
        $this->load->database();
        // Load the DB utility class
        $this->load->dbutil();
        $backup_folder = "backups/";
        $time_stamp = mdate('%Y%m%d_%H%i%s%A');
        $file_name = 'sllrdcdb_' . $time_stamp;
        $full_path = $backup_folder . $file_name;

        $prefs = array(
            'format' => 'zip', // gzip, zip, txt
            'filename' => $file_name . '.sql',
            'add_insert' => true,
            'add_drop' => false,
            'foreign_key_checks' => false
        );
        
        if (!empty($nodata)){
            $prefs['add_insert']=false;
        }
        
// Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup($prefs);
// Load the file helper and write the file to your server
        $this->load->helper('file');

        write_file($full_path . '.zip', $backup);

// Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download($file_name . '.zip', $backup);
    }
    
    
    public function check_user_name_in_db() {
       $result = $this->Users_model->check_user_name_in_db();
      
            echo json_encode(array("status" => "1", "data" => $result));
     
    }

}
