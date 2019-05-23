<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_permission_c extends CI_Controller {

    function __construct() {
//        is_group_allowed($perm_par, $group_par=false);

        parent::__construct();
        $admin = $this->aauth->is_admin();
        if ($admin) {
            $this->load->model('cms_permission_m');
            $this->load->helper('master_data');
        } else {
            redirect(site_url("administrator/admin_login"));
        }
    }

    public function index() {
        $data['title'] = 'Permissions';
        $data['styles'] = array("assets/js/data_tables/DataTables-1.10.12/css/dataTables.bootstrap.min.css",
            "assets/js/data_tables/DataTables-1.10.12/css/responsive.dataTables.min.css",
            "assets/js/sweetalert-master/dist/sweetalert.css",
            "assets/js/sweetalert-master/themes/google/google.css");
        $data['scripts'] = array(
            "assets/js/data_tables/DataTables-1.10.12/js/jquery.dataTables.min.js",
            "assets/js/data_tables/DataTables-1.10.12/js/dataTables.bootstrap.min.js",
            "assets/js/data_tables/DataTables-1.10.12/js/dataTables.responsive.min.js",
            "assets/js/sweetalert-master/dist/sweetalert.min.js"
        );
        $data['scriptview'] = array(
            "cms_permission"
        );
        $this->load->model('cms_permission_m');

        $this->load->view('template/header', $data);
        $this->load->view('cms_permissions', $data);
        $this->load->view('template/footer', $data);
    }

    function load_permission_table() {
        $this->cms_permission_m->load_permissions_data();
        return;
    }

    function save_permissions() {
        $flag = $this->cms_permission_m->save_permissions();
        if ($flag) {
            echo json_encode(array('success' => 1));
        } else {
            echo json_encode(array('error' => 2));
        }
    }

//
    function update_permissions() {
        $flag = $this->cms_permission_m->update_permissions();
        if ($flag) {
            echo json_encode(array('success' => 1));
        } else {
            echo json_encode(array('error' => 2));
        }
    }

//
//
    function delete_permission_details() {
        $data = $this->cms_permission_m->delete_permissions();
        if ($data) {
            echo json_encode(array('success' => 1));
        } else {
            echo json_encode(array('error' => 2));
        }
    }

//
    function edit_permissions_details() {
        $data = $this->cms_permission_m->edit_permissions_data();
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }

}
