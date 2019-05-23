<?php
/**
 * @version $Id: 1.0 2019-04-09 : 12:46:11
 * @package Manage Bus Schedule
 * @copyright Copyright (C) 2003- 2019 Procons Infortech, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author Procons
 * @author info@procons.lk
 * @developer Indika
 */
 
class Route_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
    }		
    public function insert() {
        $datetime = mdate('%Y-%m-%d %H:%i:%s');
        $user_id = $this->aauth->get_user_id();

        $data = array(
			'route' => $this->input->post('route'),
			'route_type' => $this->input->post('route_type'),
			'from_location' => $this->input->post('from_location'),
			'to_location' => $this->input->post('to_location'),
			'from_location_si' => $this->input->post('from_location_si'),
			'to_location_si' => $this->input->post('to_location_si'),
			'from_location_ta' => $this->input->post('from_location_ta'),
			'to_location_ta' => $this->input->post('to_location_ta'),
			'created_date' => $this->input->post('created_date'),	
			 'last_updated' => $datetime,	
			 'updated_by' => $user_id,
			'remark' => $this->input->post('remark'),
			'status' => $this->input->post('status')			
        );

        $flag = $this->db->insert('mmc_master_route', $data);
        return $flag;
    }
	
	
	public function getRouteType($seleted_val = '') {
		$data = array();
            $data[0] = "Select Type";
			$data[1] = "Bus";
			 $data[2] = "Train";
				
	 	return $data;
	}

    public function update($id) {
        if (empty($id)) {
            return false;
        }
        $datetime = mdate('%Y-%m-%d %H:%i:%s');
        $user_id = $this->aauth->get_user_id();

            $data = array(
			'route' => $this->input->post('route'),
			'route_type' => $this->input->post('route_type'),
			'from_location' => $this->input->post('from_location'),
			'to_location' => $this->input->post('to_location'),
			'from_location_si' => $this->input->post('from_location_si'),
			'to_location_si' => $this->input->post('to_location_si'),
			'from_location_ta' => $this->input->post('from_location_ta'),
			'to_location_ta' => $this->input->post('to_location_ta'),
			'created_date' => $this->input->post('created_date'),	
			 'last_updated' => $datetime,	
			 'updated_by' => $user_id,
			'remark' => $this->input->post('remark'),
			'status' => $this->input->post('status')			
        );

        $this->db->where('route_id', (int) $id);
        $flag = $this->db->update('mmc_master_route', $data);
        return $flag;
    }

    public function delete($id) {
        $this->db->where('route_id', $id);
        $flag = $this->db->delete('mmc_master_route');
        return $flag;
    }

    public function hideRecord($id) {
        $this->db->set('status', -1);
        $this->db->where('route_id', (int) $id);
        $flag = $this->db->update('mmc_master_route');
        return $flag;
    }

    public function showRecord($id) {
        $this->db->set('status', 1);
        $this->db->where('route_id', (int) $id);
        $flag = $this->db->update('mmc_master_route');
        return $flag;
    }

    public function getRecordById($id) {
        $this->db->from('mmc_master_route');
        $this->db->where('route_id', $id);

        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }
        return $result;
    }

    public function getDatatableRecords() {

        $this->db->select('`mmc_master_route`.`route_id`', false);
        $this->db->from('mmc_master_route');	 
//        $this->db->where('mmc_master_route.status >=', 0);
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
		    "`mmc_master_route`.`route`",
		    "`mmc_master_route`.`route_type`",
		    "`mmc_master_route`.`from_location`",
		    "`mmc_master_route`.`to_location`",
		    "`mmc_master_route`.`from_location_si`",
		    "`mmc_master_route`.`to_location_si`",
		    "`mmc_master_route`.`from_location_ta`",
		    "`mmc_master_route`.`to_location_ta`",
		    "`mmc_master_route`.`created_date`",
		    "`mmc_master_route`.`last_updated`",
		    "`mmc_master_route`.`updated_by`",
		    "`mmc_master_route`.`remark`",
		    "`mmc_master_route`.`status`",
		   "`mmc_master_route`.`route_id`"
            );
            // filter
            $search = $this->input->post_get('search');
            $order = $this->input->post_get('order');
            $start = $this->input->post_get('start');
            $limit = $this->input->post_get('length');


            $this->db->select("
			`mmc_master_route`.`route_id`,
			`mmc_master_route`.`route`,
			`mmc_master_route`.`route_type`,
			if(`mmc_master_route`.`route_type`=1, 'Bus', 'Train' ) AS `route_type_name`,
			`mmc_master_route`.`from_location`,
			`mmc_master_route`.`to_location`,
			`mmc_master_route`.`from_location_si`,
			`mmc_master_route`.`to_location_si`,
			`mmc_master_route`.`from_location_ta`,
			`mmc_master_route`.`to_location_ta`,
			`mmc_master_route`.`created_date`,
			`mmc_master_route`.`last_updated`,
			`mmc_master_route`.`updated_by`,
			`mmc_master_route`.`remark`,
		   `mmc_master_route`.`status`");
            $this->db->from('mmc_master_route');
            
//           $this->db->where('mmc_master_route.status >=', 0);

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
