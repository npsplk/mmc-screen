<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dash_c extends CI_Controller {

    function __construct() {
        parent::__construct();
//        $admin = $this->aauth->is_admin();
        if ($admin) {
            $this->load->model('admin_dash_m');
            $this->load->helper('master_data');
        } else {
            redirect(site_url("administrator/admin_login"));
        }
    }

    public function index() {
        $data['title'] = 'Admin dashboard';
        $data['styles'] = array(
//            "assets/js/data_tables/DataTables-1.10.12/css/dataTables.bootstrap.min.css",
            "assets/js/sweetalert-master/dist/sweetalert.css",
            "assets/js/sweetalert-master/themes/google/google.css",
            "assets/css/customcss.css");
        $data['scripts'] = array(
//            "assets/js/data_tables/DataTables-1.10.12/js/jquery.dataTables.min.js",
            "assets/js/data_tables/DataTables-1.10.12/js/dataTables.bootstrap.min.js");
        $data['scriptview'] = array(
            "admin_dashboard_script"
        );
        $this->load->model('admin_dash_m');

        $this->load->view('template/header', $data);
        $this->load->view('admin_dashboard', $data);
        $this->load->view('template/footer', $data);
    }

}
