<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {

    function __construct() {

        parent::__construct();
//        $this->aauth->what_user_can_do('cms', '9');
        $admin = $this->aauth->is_admin();
        if ($admin) {
            $this->load->model('cms_model');
            $this->load->helper('master_data');
        } else {
            redirect(site_url("administrator/admin_login"));
        }
    }

    public function index() {
        $data['title'] = 'Cms';
        $data['styles'] = array(
            "assets/js/data_tables/DataTables-1.10.12/css/dataTables.bootstrap.min.css",
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
            "cms_script"
        );
        $this->load->model('cms_model');
        $data['menu'] = $this->cms_model->get_main_menu_details();
        $data['permissions'] = $this->cms_model->get_permissions();


        $this->load->view('template/header', $data);
        $this->load->view('Cms_view', $data);
        $this->load->view('template/footer', $data);
    }

    function save_menu_details() {
        $flag = $this->cms_model->save_menu_details();
        if ($flag) {
            echo json_encode(array('success' => 1));
            $this->cms_model->get_main_menu_details();
        } else {
            echo json_encode(array('error' => 2));
        }
    }

    function update_menu_details() {
        $flag = $this->cms_model->update_menu_details();
        if ($flag) {
            echo json_encode(array('success' => 1));
            $this->cms_model->get_main_menu_details();
        } else {
            echo json_encode(array('error' => 2));
        }
    }

    function load_menu_details() {
        $this->cms_model->load_menu_data();
        return;
    }

    function delete_menu_details() {
        $data = $this->cms_model->delete_menu_data();
        if ($data) {
            echo json_encode(array('success' => 1));
            $this->cms_model->get_main_menu_details();
        } else {
            echo json_encode(array('error' => 2));
        }
    }

    function edit_menu_details() {
        $data = $this->cms_model->edit_menu_data();

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }

}
