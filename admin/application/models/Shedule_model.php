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
 
class Shedule_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
    }		
		public function getWeekdayid($seleted_val = '') {

        $this->db->select(array('A.week_day_id as id', 'A.day as name'));
        $this->db->from('mmc_master_week_days AS A');
        $this->db->where('A.status' . '=' . '1');
        $this->db->order_by("A.week_day_id", "asc");
        $d = $this->db->get();
       	 
		 
		 $date = new DateTime();
         $timestamp= $date->getTimestamp();
	     $seleted_val = idate('w', $timestamp);

             if ($d) {
            $data = array();
            $data['-1'] = "Select Week Day";
            foreach ($d->result() as $row) {
// Add array keys to the array while looping...
                $data[$row->id] = $row->name;
            }

            return $data;
        } else {
            return FALSE;
        }
    }		
		public function getRouteid($seleted_val = '') {



        $this->db->select(array('A.route_id as id', 'CONCAT(A.route, "-", A.to_location) as name'));
        $this->db->from('mmc_master_route AS A');
        $this->db->where('A.status' . '=' . '1');
        $this->db->order_by("A.route", "asc");
        $d = $this->db->get();

        if ($d) {
			
			 
            $data = array();
            $data[0] = "Select Route";
            foreach ($d->result() as $row) {
// Add array keys to the array while looping...
                $data[$row->id] = $row->name;
            }

            return $data;
        } else {
            return FALSE;
        }
    }	
	
	
	
	
		public function getStatus($seleted_val = '') {	


        $this->db->select(array('A.status_id as id', 'A.status_name as name'));
        $this->db->from('mmc_bus_status AS A');
        $this->db->where('A.status' . '=' . '1');
        $this->db->order_by("A.status_name", "asc");
        $d = $this->db->get();

        if ($d) {
			
			 
            $data = array();
            $data[0] = "Select Status";
            foreach ($d->result() as $row) {
// Add array keys to the array while looping...
                $data[$row->id] = $row->name;
            }

            return $data;
        } else {
            return FALSE;
        }
    }
	
	public function getRouteType($seleted_val = '') {
		$data = array();
            $data[0] = "Select Type";
			$data[1] = "Bus";
			 $data[2] = "Train";
				
	 	return $data;
	}
	
	

	
	
		
    public function insert() {
        $datetime = mdate('%Y-%m-%d %H:%i:%s');
        $user_id = $this->aauth->get_user_id();

        $data = array(
			'week_day_id' => $this->input->post('week_day_id'),
			'route_id' => $this->input->post('route_id'),
			'bus_number' => $this->input->post('bus_number'),
			'departure_time' => $this->input->post('departure_time'),
			'arrival_time' => $this->input->post('arrival_time'),
			'remarks' => $this->input->post('remarks'),
			'status_id' => $this->input->post('status_id'),
			'status' => $this->input->post('status')			
        );

        $flag = $this->db->insert('mmc_bus_shedule', $data);
        return $flag;
    }

    public function update($id) {
        if (empty($id)) {
            return false;
        }
        $datetime = mdate('%Y-%m-%d %H:%i:%s');
        $user_id = $this->aauth->get_user_id();

            $data = array(
			'week_day_id' => $this->input->post('week_day_id'),
			'route_id' => $this->input->post('route_id'),
			'bus_number' => $this->input->post('bus_number'),
			'departure_time' => $this->input->post('departure_time'),
			'arrival_time' => $this->input->post('arrival_time'),
			'remarks' => $this->input->post('remarks'),
			'status_id' => $this->input->post('status_id'),
			'status' => $this->input->post('status')			
        );

        $this->db->where('shedule_id', (int) $id);
        $flag = $this->db->update('mmc_bus_shedule', $data);
        return $flag;
    }

    public function delete($id) {
        $this->db->where('shedule_id', $id);
        $flag = $this->db->delete('mmc_bus_shedule');
        return $flag;
    }

    public function hideRecord($id) {
        $this->db->set('status', -1);
        $this->db->where('shedule_id', (int) $id);
        $flag = $this->db->update('mmc_bus_shedule');
        return $flag;
    }

    public function showRecord($id) {
        $this->db->set('status', 1);
        $this->db->where('shedule_id', (int) $id);
        $flag = $this->db->update('mmc_bus_shedule');
        return $flag;
    }

    public function getRecordById($id) {
        $this->db->from('mmc_bus_shedule');
        $this->db->where('shedule_id', $id);

        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }
        return $result;
    }

    public function getDatatableRecords() {
	
	$week_day = $this->input->post('week_day');
	$status_filter = $this->input->post('status_filter');
	$route_filter = $this->input->post('route_filter');
	$type = $this->input->post('type');
	$search = $this->input->post_get('search');
	$order = $this->input->post_get('order');
	$start = $this->input->post_get('start');
	$limit = $this->input->post_get('length');
	
        $this->db->select('`mmc_bus_shedule`.`shedule_id`', false);
        $this->db->from('mmc_bus_shedule');
		$this->db->join('`mmc_master_route`', '`mmc_bus_shedule`.`route_id` = `mmc_master_route`.`route_id`', 'LEFT');	 
		$this->db->join('`mmc_bus_status`', '`mmc_bus_shedule`.`status_id` = `mmc_bus_status`.`status_id`', 'LEFT');
		
		if($week_day>0){
		$this->db->where('mmc_bus_shedule`.`week_day_id`', $week_day);
		}
		if($route_filter>0){
		$this->db->where('mmc_bus_shedule`.`route_id`', $route_filter);
		}
		if($status_filter>0){
		$this->db->where('mmc_bus_shedule`.`status_id`', $status_filter);
		}
		
		if ($type>0){
			$this->db->where('mmc_master_route`.`route_type`', $type);
		}
		
			 
//        $this->db->where('mmc_bus_shedule.status >=', 0);

 		if (!empty($search['value'])) {
            $this->db->group_start();
            $this->db->like('bus_number', $search['value'], 'both');
            $this->db->or_like('route', $search['value'], 'both');
			$this->db->or_like('departure_time', $search['value'], 'both');
           
            $this->db->group_end();
        }



        $totalData = $this->db->count_all_results();


        $totalFiltered = $totalData;
        $data_result = array();
        if (!empty($totalData)) {
            //for sorting
            $columns = array(
		    "`mmc_bus_shedule`.`shedule_id`",
		    "`mmc_master_week_days`.`day`",
		    "`mmc_bus_shedule `.`bus_number`",
		    "`mmc_bus_shedule`.`departure_time`",
		    "`mmc_bus_shedule`.`to_location`",
		    "`mmc_bus_shedule`.`remarks`",
		    "`mmc_bus_status`.`status_name`",
		    "`mmc_bus_shedule`.`status`",
		   "`mmc_bus_shedule`.`shedule_id`"
            );
            // filter
           


            $this->db->select("
			`mmc_bus_shedule`.`shedule_id`,
			`mmc_master_week_days`.`day`,
			`mmc_master_route`.`route`,
			`mmc_master_route`.`to_location`,
			`mmc_bus_shedule`.`bus_number`,
			`mmc_bus_shedule`.`departure_time`,
			if(`mmc_master_route`.`route_type`=1, 'Bus', 'Train' ) AS `route_type_name`,
			`mmc_bus_shedule`.`remarks`,
			`mmc_bus_status`.`status_name`,
		   `mmc_bus_shedule`.`status`");
            $this->db->from('mmc_bus_shedule');
            
			$this->db->join('`mmc_master_route`', '`mmc_bus_shedule`.`route_id` = `mmc_master_route`.`route_id`', 'LEFT');	 
			$this->db->join('`mmc_bus_status`', '`mmc_bus_shedule`.`status_id` = `mmc_bus_status`.`status_id`', 'LEFT');
			$this->db->join('`mmc_master_week_days`', '`mmc_bus_shedule`.`week_day_id` = `mmc_master_week_days`.`week_day_id`', 'LEFT');
			
			if($week_day>0){
			$this->db->where('mmc_bus_shedule`.`week_day_id`', $week_day);
			}
			
			if($route_filter>0){
			$this->db->where('mmc_bus_shedule`.`route_id`', $route_filter);
			}
			
			if($status_filter>0){
			$this->db->where('mmc_bus_shedule`.`status_id`', $status_filter);
			}
			
			if ($type>0){
			$this->db->where('mmc_master_route`.`route_type`', $type);
		    }
		

 			if (!empty($search['value'])) {
            $this->db->group_start();
            $this->db->like('bus_number', $search['value'], 'both');
            $this->db->or_like('route', $search['value'], 'both');
           $this->db->or_like('departure_time', $search['value'], 'both');
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
