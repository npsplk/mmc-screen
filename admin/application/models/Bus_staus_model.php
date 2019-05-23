<?php
/**
 * @version $Id: 1.0 2019-04-04 : 09:31:13
 * @package Manage Bus Schedule
 * @copyright Copyright (C) 2003- 2019 Procons Infortech, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author Procons
 * @author info@procons.lk
 * @developer Indika
 */
 
class Bus_staus_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
    }		
    public function insert() {
        $datetime = mdate('%Y-%m-%d %H:%i:%s');
        $user_id = $this->aauth->get_user_id();

        $data = array(
			'status_name' => $this->input->post('status_name'),
			'status_name_si' => $this->input->post('status_name_si'),
			'status_name_ta' => $this->input->post('status_name_ta'),
			'status' => $this->input->post('status')			
        );

        $flag = $this->db->insert('mmc_bus_status', $data);
        return $flag;
    }

    public function update($id) {
        if (empty($id)) {
            return false;
        }
        $datetime = mdate('%Y-%m-%d %H:%i:%s');
        $user_id = $this->aauth->get_user_id();

            $data = array(
			'status_name' => $this->input->post('status_name'),
			'status_name_si' => $this->input->post('status_name_si'),
			'status_name_ta' => $this->input->post('status_name_ta'),
			'status' => $this->input->post('status')			
        );

        $this->db->where('status_id', (int) $id);
        $flag = $this->db->update('mmc_bus_status', $data);
        return $flag;
    }

    public function delete($id) {
        $this->db->where('status_id', $id);
        $flag = $this->db->delete('mmc_bus_status');
        return $flag;
    }

    public function hideRecord($id) {
        $this->db->set('status', -1);
        $this->db->where('status_id', (int) $id);
        $flag = $this->db->update('mmc_bus_status');
        return $flag;
    }

    public function showRecord($id) {
        $this->db->set('status', 1);
        $this->db->where('status_id', (int) $id);
        $flag = $this->db->update('mmc_bus_status');
        return $flag;
    }

    public function getRecordById($id) {
        $this->db->from('mmc_bus_status');
        $this->db->where('status_id', $id);

        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }
        return $result;
    }

    public function getDatatableRecords() {

        $this->db->select('`mmc_bus_status`.`status_id`', false);
        $this->db->from('mmc_bus_status');
	
//        $this->db->where('mmc_bus_status.status >=', 0);
        if (!empty($search['value'])) {
            $this->db->group_start();
            
            $this->db->group_end();
        }

        $totalData = $this->db->count_all_results();


        $totalFiltered = $totalData;
        $data_result = array();
        if (!empty($totalData)) {
            //for sorting
            $columns = array(
		    "`mmc_bus_status`.`status_name`",
		    "`mmc_bus_status`.`status_name_si`",
		    "`mmc_bus_status`.`status_name_ta`",
		    "`mmc_bus_status`.`status`",
		   "`mmc_bus_status`.`status_id`"
            );
            // filter
            $search = $this->input->post_get('search');
            $order = $this->input->post_get('order');
            $start = $this->input->post_get('start');
            $limit = $this->input->post_get('length');


            $this->db->select("
			`mmc_bus_status`.`status_id`,
			`mmc_bus_status`.`status_name`,
			`mmc_bus_status`.`status_name_si`,
			`mmc_bus_status`.`status_name_ta`,
		   `mmc_bus_status`.`status`");
            $this->db->from('mmc_bus_status');
            
	
//           $this->db->where('mmc_bus_status.status >=', 0);

            if (!empty($search['value'])) {
                $this->db->group_start();
                
                $this->db->group_end();
            }
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
            if (!empty($limit)) {
                $this->db->limit($limit, $start);
            }
            $query = $this->db->get();

            if (empty($query)) {
                return false;
            } else {
                $data_result = $query->result();
            }
            if (!empty($search['value'])) {
                $totalFiltered = $query->num_rows();
            }
        }
        $json_data = array(
            "draw" => intval($this->input->post_get('draw')), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data_result   // total data array
        );
        return $json_data;
    }

}
