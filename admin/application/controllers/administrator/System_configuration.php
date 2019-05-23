<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class System_configuration extends CI_Controller {

    function __construct() {
//        is_group_allowed($perm_par, $group_par=false);

        parent::__construct();
        $admin = $this->aauth->is_admin();
        if ($admin) {
            $this->load->model('system_configuration_m');
            $this->load->helper('master_data');
        } else {
            redirect(site_url("administrator/admin_login"));
        }
    }

    public function index() {
        $data['title'] = 'System Configuration';
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
            "system_configuration_script"
        );
        $this->load->model('System_configuration_m');

        $this->load->view('template/header', $data);
        $this->load->view('system_configuration_v', $data);
        $this->load->view('template/footer', $data);
    }

    function dual_authenticate() {
        $dual_switch = $this->input->post('dual_switch');
        $flag = $this->system_configuration_m->dual_athenticate($dual_switch);
        return $flag;
    }

    function dual_authenticate_staus() {
        $flag = $this->system_configuration_m->get_dual_authenticate_stat();
        return $flag;
    }

}
