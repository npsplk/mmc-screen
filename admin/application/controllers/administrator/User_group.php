<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_group extends CI_Controller {

    function __construct() {
        parent::__construct();
        
//        $perm = $this->aauth->is_allowed('cms', $_SESSION['id']);
//         $this->aauth->is_in_group('manage_user_group_permissions', $_SESSION['id']);
//        $this->aauth->login_defend();
    }

    public function index() {
        $data['title'] = 'Manage User Groups';
        $data['styles'] = array("assets/js/data_tables/DataTables-1.10.12/css/dataTables.bootstrap.min.css",
            "assets/js/sweetalert-master/dist/sweetalert.css",
            "assets/js/sweetalert-master/themes/google/google.css");

        $data['scripts'] = array(
            "assets/js/data_tables/DataTables-1.10.12/js/jquery.dataTables.min.js",
            "assets/js/data_tables/DataTables-1.10.12/js/dataTables.bootstrap.min.js",
            "assets/js/jquery-validation-1.15.0/jquery.validate.min.js",
            "assets/js/sweetalert-master/dist/sweetalert.min.js",
            "assets/app_js/users_group.js"
        );
        $admin = $this->aauth->is_admin();
        if ($admin) {
            $data['list_permissions'] = $this->getSystemPermissions();
            $this->load->view('template/header', $data);
//        $this->load->view('template/navbar', $data);
            $this->load->view('admin/user_group', $data);
            $this->load->view('template/footer', $data);
        } else {
            redirect(site_url("administrator/admin_login"));
        }
    }

    public function saveUserGroup() {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');


        $this->form_validation->set_rules('group_name', 'Species Name', 'trim|required');
        $this->form_validation->set_rules('definition', 'Commission Rate', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array("status" => 2, "msg" => validation_errors('<span class="error-msg">', '</span>')));
            return;
        }
        $id = $this->input->post('id');
        if (!empty($id)) {
            $flag = $this->aauth->create_group($this->input->post('group_name'), $this->input->post('definition'));
        } else {
            $flag = $this->aauth->update_group($this->input->post('id'), $this->input->post('group_name'));
        }

        if ($flag) {
            echo json_encode(array("status" => 1, "msg" => "Successfully Saved"));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Cannot Save"));
//            $error = $this->db->error();
//            log_message('error', $error['message']);
        }
    }

    public function setUserGroups() {
        $datestring = '%Y-%m-%d %H:%i:%s';
        $this->load->database();
        $group_id = $this->input->post('group_id');
        $perms = $this->input->post('perms');
        if (!empty($group_id)) {
            $this->db->trans_start();
            $this->clearUserPerms($group_id);
            $insert_row = array("group_id" => 0, "perm_id" => 0);
            $batch_data = array();
            foreach ($perms as $perm) {
                $insert_row["group_id"] = $group_id;
                $insert_row["perm_id"] = $perm;
                $batch_data[] = $insert_row;
            }
//        echo json_encode($batch_data);
            $flag = $this->db->insert_batch('aauth_perm_to_group', $batch_data);
            $trans = $this->db->trans_complete();
        }
        if (!empty($trans)) {
            echo json_encode(array("status" => 1, "msg" => "Permissions updated for the user group"));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Cannot update user group permissions"));
        }
    }

    public function clearUserPerms($group_id) {
        $this->db->where('group_id', $group_id);
        $flag = $this->db->delete('aauth_perm_to_group');
    }

    public function deleteUserGroup() {
        $group_id = (int) $this->input->post('id');
        $flag == FALSE;
        if (!empty($group_id) && $group_id > 3) {
            $flag = $this->aauth->delete_group($group_id);
        }
        if ($flag) {
            echo json_encode(array("status" => 1, "msg" => "Successfully deleted"));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Cannot delete"));
        }
    }

    public function getSystemPermissions() {

        $this->load->database();
        $this->db->select('id, 
                    name, 
                    definition');
        $this->db->from('aauth_perms');
        $this->db->where('status', 1);
        $this->db->order_by('definition', 'ASC');
        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

    public function getUserGroupPermissions() {
        $group_id = (int) $this->input->post('group_id');
        $this->load->database();
        $this->db->select('perm_id');
        $this->db->from('aauth_perm_to_group');
        $this->db->where('group_id', $group_id);
        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        if ($result) {
            echo json_encode(array("status" => 1, "data" => $result));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Could not get the user group permissions"));
        }
//        return $result;
    }

}
