
		<?php
/**
 * @version $Id: 1.0 2019-04-03 : 12:16:58
 * @package Manage Bus Schedule
 * @copyright Copyright (C) 2003- 2019 Procons Infortech, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author Procons
 * @author info@procons.lk
 * @developer Indika
 */
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Shedule extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->aauth->control();
        $this->load->model('Shedule_model', 'model');
        $this->load->helper('master_data');
    }

    public function index() {

        $header_data = $this->get_header_data();
        $footer_data = $this->get_footer_data();
	
        $form_data = $this->get_form_data();

        $this->load->view('template/header', $header_data);
        $this->load->view('Shedule', $form_data);
        $this->load->view('template/footer', $footer_data);
    }

    private function get_header_data() {
        $data = array();

        $data['title'] = 'Manage Bus / Train Shedule';
        $data['styles'] = array("assets/js/sweetalert-master/dist/sweetalert.css",
            "assets/js/sweetalert-master/themes/google/google.css",
            "assets/js/data_tables/DataTables-1.10.12/css/dataTables.bootstrap.min.css",
        );

        return $data;
    }

    private function get_footer_data() {
        $data = array();
        $data['scripts'] = array(
            "assets/js/jquery-validation-1.15.0/jquery.validate.min.js",
            "assets/js/sweetalert-master/dist/sweetalert.min.js",
            "assets/js/data_tables/DataTables-1.10.12/js/jquery.dataTables.min.js",
            "assets/js/data_tables/DataTables-1.10.12/js/dataTables.bootstrap.min.js",
        );
        $data['scriptview'] = array(
            "Shedule"
        );
        return $data;
    }

    private function get_form_data() {
        $data = array();
		$data['route_id'] = $this->model->getRouteid();
		
		$data['status_id'] = $this->model->getStatus();
		
		$data['week_day_id'] = $this->model->getWeekdayid();
		$data['type'] = $this->model->getRouteType();
		
	
        return $data;
    }

    public function save() {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
		$id = $this->input->post('id');
		
        $this->form_validation->set_rules('week_day_id', 'Week Day Id', 'trim');
		
        $this->form_validation->set_rules('route_id', 'Route Id', 'trim');
		
        $this->form_validation->set_rules('bus_number', 'Bus Number', 'trim');
		
        $this->form_validation->set_rules('departure_time', 'Departure Time', 'trim');
		
        $this->form_validation->set_rules('arrival_time', 'Arrival Time', 'trim');
		
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim');
		
        $this->form_validation->set_rules('status_id', 'Status Id', 'trim');
		
        $this->form_validation->set_rules('status', 'Status', 'trim');
		 
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array("status" => 2, "msg" => validation_errors('<span>', '</span>')));
            return;
        }

        if (!empty($id)) {
            $trans = $this->model->update($id);
        } else {
            $trans = $this->model->insert();
        }

        if ($trans) {
            echo json_encode(array("status" => 1, "msg" => "Successfully Saved", "data" => $trans));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Could Not Save, Encountered an Error."));
        }
    }

    public function delete() {
        // delete is not recomended, sections will be automatically deleted
        $id = (int) $this->input->post('id');
        if (empty($id)) {
            echo json_encode(array("status" => 2, "msg" => "Cannot delete, Record id not found"));
            return false;
        }
        $flag = $this->model->delete($id);

        if ($flag) {
            echo json_encode(array("status" => 1, "msg" => "Successfully deleted"));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Cannot delete"));
        }
        return $flag;
    }

    public function hide() {
        $id = (int) $this->input->post('id');
        if (empty($id)) {
            echo json_encode(array("status" => 2, "msg" => "Cannot change, Record id not found"));
            return false;
        }
        $flag = $this->model->hideRecord($id);

        if ($flag) {
            echo json_encode(array("status" => 1, "msg" => "Successfully changed"));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Cannot change"));
        }
        return $flag;
    }

    public function show() {
        $id = (int) $this->input->post('id');
        if (empty($id)) {
            echo json_encode(array("status" => 2, "msg" => "Cannot change, Record id not found"));
            return false;
        }
        $flag = $this->model->showRecord($id);

        if ($flag) {
            echo json_encode(array("status" => 1, "msg" => "Successfully changed"));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Cannot change"));
        }
        return $flag;
    }

    public function getRecordById() {
        $id = $this->input->post('id');

        if (empty($id)) {
            echo json_encode(array("status" => 2, "msg" => "Record not specified"));
            return;
        }
        $data = $this->model->getRecordById($id);
        echo json_encode(array("status" => 1, "data" => $data));
        return;
    }

    public function getDatatableRecords() {
        $data = $this->model->getDatatableRecords();
        echo json_encode($data);  // send data as json format
    }

}
		