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
 
class Bay_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
    }		
		public function getRouteid($seleted_val = '') {

        $this->db->select(array('A.route_id as id', 'A.route as name'));
        $this->db->from('mmc_master_route  AS A');
        $this->db->where('A.status' . '=' . '1');
        $this->db->order_by("A.route", "asc");
        $d = $this->db->get();

        if ($d) {
            $data = array();
            $data[''] = "Select Route Id";
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
			'bay_name' => $this->input->post('bay_name'),
			'route_id' => $this->input->post('route_id'),
			'created_date' => $this->input->post('created_date'),	
			 'last_updated' => $datetime,	
			 'updated_by' => $user_id,
			'remark' => $this->input->post('remark'),
			'status' => $this->input->post('status')			
        );

        $flag = $this->db->insert('mmc_master_bay', $data);
        return $flag;
    }

    public function update($id) {
        if (empty($id)) {
            return false;
        }
        $datetime = mdate('%Y-%m-%d %H:%i:%s');
        $user_id = $this->aauth->get_user_id();

            $data = array(
			'bay_name' => $this->input->post('bay_name'),
			'route_id' => $this->input->post('route_id'),
			'created_date' => $this->input->post('created_date'),	
			 'last_updated' => $datetime,	
			 'updated_by' => $user_id,
			'remark' => $this->input->post('remark'),
			'status' => $this->input->post('status')			
        );

        $this->db->where('bay_id', (int) $id);
        $flag = $this->db->update('mmc_master_bay', $data);
        return $flag;
    }

    public function delete($id) {
        $this->db->where('bay_id', $id);
        $flag = $this->db->delete('mmc_master_bay');
        return $flag;
    }

    public function hideRecord($id) {
        $this->db->set('status', -1);
        $this->db->where('bay_id', (int) $id);
        $flag = $this->db->update('mmc_master_bay');
        return $flag;
    }

    public function showRecord($id) {
        $this->db->set('status', 1);
        $this->db->where('bay_id', (int) $id);
        $flag = $this->db->update('mmc_master_bay');
        return $flag;
    }

    public function getRecordById($id) {
        $this->db->from('mmc_master_bay');
        $this->db->where('bay_id', $id);

        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }
        return $result;
    }

    public function getDatatableRecords() {


 // filter
            $search = $this->input->post_get('search');
            $order = $this->input->post_get('order');
            $start = $this->input->post_get('start');
            $limit = $this->input->post_get('length');
			
			
        $this->db->select('`mmc_master_bay`.`bay_id`', false);
        $this->db->from('mmc_master_bay');
	$this->db->join('`mmc_master_route`', '`mmc_master_bay`.`route_id` = `mmc_master_route`.`route_id`', 'LEFT'); 
//        $this->db->where('mmc_master_bay.status >=', 0);
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
		    "`mmc_master_bay`.`bay_name`",
		    "`mmc_master_bay`.`route_id`",
		    "`mmc_master_bay`.`created_date`",
		    "`mmc_master_bay`.`last_updated`",
		    "`mmc_master_bay`.`updated_by`",
		    "`mmc_master_bay`.`remark`",
		    "`mmc_master_bay`.`status`",
		   "`mmc_master_bay`.`bay_id`"
            );
           


            $this->db->select("
			`mmc_master_bay`.`bay_id`,
			`mmc_master_bay`.`bay_name`,
			`mmc_master_bay`.`route_id`,
			`mmc_master_bay`.`created_date`,
			`mmc_master_bay`.`last_updated`,
			`mmc_master_bay`.`updated_by`,
			`mmc_master_bay`.`remark`,
			`mmc_master_route`.`route`,
			`mmc_master_route`.`to_location`,
		   `mmc_master_bay`.`status`");
            $this->db->from('mmc_master_bay');
            
		    $this->db->join('`mmc_master_route`', '`mmc_master_bay`.`route_id` = `mmc_master_route`.`route_id`', 'LEFT');
//           $this->db->where('mmc_master_bay.status >=', 0);

       

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
