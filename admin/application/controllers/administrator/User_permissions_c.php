<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_permissions_c extends CI_Controller {

    function __construct() {
        parent::__construct();
        $admin = $this->aauth->is_admin();
        if ($admin) {
            $this->load->model('user_permissions_m');
            $this->load->helper('master_data');
        } else {
            redirect(site_url("administrator/admin_login"));
        }
    }

    public function index() {
        $data['title'] = 'User Permissions';
        $data['styles'] = array("assets/js/data_tables/DataTables-1.10.12/css/dataTables.bootstrap.min.css",
            "assets/js/sweetalert-master/dist/sweetalert.css",
            "assets/js/sweetalert-master/themes/google/google.css",
            "assets/js/chosen_v1.6.2/chosen-bootstrap.css",
            "assets/css/bootstrap-switch.css");
        $data['scripts'] = array(
            "assets/js/data_tables/DataTables-1.10.12/js/jquery.dataTables.min.js",
            "assets/js/data_tables/DataTables-1.10.12/js/dataTables.bootstrap.min.js",
            "assets/js/sweetalert-master/dist/sweetalert.min.js",
            "assets/js/chosen_v1.6.2/chosen.jquery.min.js",
            "assets/js/bootstrap-switch.js"
        );
        $data['scriptview'] = array(
            "user_permission_script"
        );
        $this->load->model('user_permissions_m');

        $this->load->view('template/header', $data);
        $this->load->view('user_permissions_view', $data);
        $this->load->view('template/footer', $data);
    }

//    function load_user_combo_to_group() {
//        $this->user_permissions_m->load_user_combo();
//        return;
//    }

    public function load_user_combo_to_group() {

        $group_id = $this->input->post('goup_id');
        $result = $this->user_permissions_m->load_user_combo($group_id);
        if (!empty($result)) {
            echo json_encode(array("status" => "1", "data" => $result));
        } else {
            echo json_encode(array("status" => "2", "data" => "Error"));
        }
    }

    function load_user_permission_data() {
        $group_id = $this->input->post('groupid');
//        $user_id = $this->input->post('user_id');
//        echo $group_id;
//        echo $user_id;
//        exit;

        $this->user_permissions_m->load_user_permissions_data($group_id);
        return;
    }

    function save_update_permissions() {
        $checked_values = $this->input->post('checked_values');
        $permision_id = $this->input->post('permision_id');
        $groupid = $this->input->post('groupid');
        $userid = $this->input->post('userid');
        $flag = $this->user_permissions_m->save_update_user_permissions($checked_values, $permision_id, $groupid, $userid);
        return;
    }

    function get_permissions_to_user() {
        $groupid = $this->input->post('groupid');
        $userid = $this->input->post('user_id');
        $flag = $this->user_permissions_m->get_user_related_permissions($groupid, $userid);
        return;
    }

}
