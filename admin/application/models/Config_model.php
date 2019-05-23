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
 
class Config_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
    }		
		public function getLocationid($seleted_val = '') {

        $this->db->select(array('A.location_id as id', 'A.location_name as name'));
        $this->db->from(' AS A');
        $this->db->where('A.status' . '=' . '1');
        $this->db->order_by("A.location_name", "asc");
        $d = $this->db->get();

        if ($d) {
            $data = array();
            $data[''] = "Select Location Id";
            foreach ($d->result() as $row) {
// Add array keys to the array while looping...
                $data[$row->id] = $row->name;
            }

            return $data;
        } else {
            return FALSE;
        }
    }		
    public function insert() {
        $datetime = mdate('%Y-%m-%d %H:%i:%s');
        $user_id = $this->aauth->get_user_id();

        $data = array(
			'location_id' => $this->input->post('location_id'),
			'visibility_bus_number' => $this->input->post('visibility_bus_number'),
			'visibility_departure_location' => $this->input->post('visibility_departure_location'),
			'number_of_bay' => $this->input->post('number_of_bay'),
			'number_of_raws' => $this->input->post('number_of_raws'),
			'number_of_raws_bay' => $this->input->post('number_of_raws_bay'),
			'remark' => $this->input->post('remark'),
			'status' => $this->input->post('status')			
        );

        $flag = $this->db->insert('mmc_master_config', $data);
        return $flag;
    }

    public function update($id) {
        if (empty($id)) {
            return false;
        }
        $datetime = mdate('%Y-%m-%d %H:%i:%s');
        $user_id = $this->aauth->get_user_id();

            $data = array(
			'location_id' => $this->input->post('location_id'),
			'visibility_bus_number' => $this->input->post('visibility_bus_number'),
			'visibility_departure_location' => $this->input->post('visibility_departure_location'),
			'number_of_bay' => $this->input->post('number_of_bay'),
			'number_of_raws' => $this->input->post('number_of_raws'),
			'number_of_raws_bay' => $this->input->post('number_of_raws_bay'),
			'remark' => $this->input->post('remark'),
			'status' => $this->input->post('status')			
        );

        $this->db->where('config_id', (int) $id);
        $flag = $this->db->update('mmc_master_config', $data);
        return $flag;
    }

    public function delete($id) {
        $this->db->where('config_id', $id);
        $flag = $this->db->delete('mmc_master_config');
        return $flag;
    }

    public function hideRecord($id) {
        $this->db->set('status', -1);
        $this->db->where('config_id', (int) $id);
        $flag = $this->db->update('mmc_master_config');
        return $flag;
    }

    public function showRecord($id) {
        $this->db->set('status', 1);
        $this->db->where('config_id', (int) $id);
        $flag = $this->db->update('mmc_master_config');
        return $flag;
    }

    public function getRecordById($id) {
        $this->db->from('mmc_master_config');
        $this->db->where('config_id', $id);

        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }
        return $result;
    }

    public function getDatatableRecords() {

        $this->db->select('`mmc_master_config`.`config_id`', false);
        $this->db->from('mmc_master_config');
		$this->db->join('``', '`mmc_master_config`.`location_id` = ``.`location_id`', 'LEFT');	 
//        $this->db->where('mmc_master_config.status >=', 0);
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
		    "`mmc_master_config`.`location_id`",
		    "`mmc_master_config`.`visibility_bus_number`",
		    "`mmc_master_config`.`visibility_departure_location`",
		    "`mmc_master_config`.`number_of_bay`",
		    "`mmc_master_config`.`number_of_raws`",
		    "`mmc_master_config`.`number_of_raws_bay`",
		    "`mmc_master_config`.`remark`",
		    "`mmc_master_config`.`status`",
		   "`mmc_master_config`.`config_id`"
            );
            // filter
            $search = $this->input->post_get('search');
            $order = $this->input->post_get('order');
            $start = $this->input->post_get('start');
            $limit = $this->input->post_get('length');


            $this->db->select("
			`mmc_master_config`.`config_id`,
			`mmc_master_config`.`location_id`,
			`mmc_master_config`.`visibility_bus_number`,
			`mmc_master_config`.`visibility_departure_location`,
			`mmc_master_config`.`number_of_bay`,
			`mmc_master_config`.`number_of_raws`,
			`mmc_master_config`.`number_of_raws_bay`,
			`mmc_master_config`.`remark`,
		   `mmc_master_config`.`status`");
            $this->db->from('mmc_master_config');
            
		$this->db->join('``', '`mmc_master_config`.`location_id` = ``.`location_id`', 'LEFT');
//           $this->db->where('mmc_master_config.status >=', 0);

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
