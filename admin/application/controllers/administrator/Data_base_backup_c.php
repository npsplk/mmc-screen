<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Data_base_backup_c extends CI_Controller {

    function __construct() {
        parent::__construct();
        $admin = $this->aauth->is_admin();
        if ($admin) {
            $this->load->model('database_backup_m');
            $this->load->helper('master_data');
        } else {
            redirect(site_url("administrator/admin_login"));
        }
    }

    public function index() {
        $data['title'] = 'Database Backup';
        $data['styles'] = array(
            "assets/js/sweetalert-master/dist/sweetalert.css",
            "assets/js/sweetalert-master/themes/google/google.css");
        $data['scripts'] = array(
            "assets/js/data_tables/DataTables-1.10.12/js/dataTables.bootstrap.min.js",
            "assets/js/sweetalert-master/dist/sweetalert.min.js",
            "assets/js/chosen_v1.6.2/chosen.jquery.min.js"
        );
//        $this->load->model('database_backup_m');

        $this->load->view('template/header', $data);
        $this->load->view('database_backup_v', $data);
        $this->load->view('template/footer', $data);
    }

    public function bd_backup_system() {
        $result = $this->database_backup_m->db_backup();
        if (!empty($result)) {
            echo json_encode(array("status" => "1", "data" => "success"));
        } else {
            echo json_encode(array("status" => "2", "data" => "Error"));
        }
    }

}
