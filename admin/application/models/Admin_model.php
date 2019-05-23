<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends CI_Model {

   

//
//    public function load_permissions_data() {
//        $this->db->select('aauth_perms.id');
//        $this->db->from('aauth_perms');
//        $this->db->where('status', 1);
//
//        $totalData = $this->db->count_all_results();
//
//        $totalFiltered = $totalData;
//        $table_data = array();
//        $q = '';
//        if (!empty($totalData)) {
//            $columns = array(
//                // datatable column index  => database column name
//                'id',
//                'name',
//                'definition'
//            );
//            // filter
//            $search = $this->input->post_get('search');
//            $order = $this->input->post_get('order');
//            $start = $this->input->post_get('start');
//            $limit = $this->input->post_get('length');
//            $this->db->select('
//        aauth_perms.name AS pname,
//        aauth_perms.id AS pid ,
//        aauth_perms.definition');
//            $this->db->from('aauth_perms');
//            $this->db->where('status', 1);
//            // if there is a search parameter, ['search']['value'] contains search parameter
//            if (!empty($search['value'])) {
//                $this->db->group_start();
//                $this->db->like('pname', $search['value'], 'both');
//                $this->db->or_like('definition', $search['value'], 'both');
//                $this->db->group_end();
//            }
//            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
//
//            if (!empty($limit)) {
//                $this->db->limit($limit, $start);
//            }
//
//            $query = $this->db->get();
//            $data_result = false;
//            if (empty($query)) {
//                return false;
//            } else {
//                $data_result = $query->result();
//            }
//            if (!empty($search['value'])) {
//                $totalFiltered = $query->num_rows();
//            }
//
//            if (!empty($data_result)) {
//                foreach ($data_result as $row) {
//                    $a = array();
//                    $a[] = $row->pid;
//                    $a[] = $row->pname;
//                    $a[] = $row->definition;
//                    $table_data[] = $a;
//                }
//            }
//        }
//        $json_data = array(
//            "draw" => intval($this->input->post_get('draw')), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
//            "recordsTotal" => intval($totalData), // total number of records
//            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
//            "data" => $table_data   // total data array
//        );
////        return $result;
//        echo json_encode($json_data);  // send data as json format
//    }
//
////
//    public function delete_permissions() {
//        // do not delete record, we only update the record status to -1
//
//        $this->db->set('status', -1);
//        $this->db->where('id', (int) $this->input->post('pdel_id'));
//        $flag = $this->db->update('aauth_perms');
//        return $flag;
//    }
//
////
//    function edit_permissions_data() {
////        $lid = $this->input->post('lid');
//        $this->db->select('
//aauth_perms.name,
//aauth_perms.id,
//aauth_perms.definition');
//        $this->db->where('id', (int) $this->input->post('pupdate_id'));
//        $data = $this->db->get('aauth_perms');
//
////                log_message('error', $this->db->last_query());
//        if ($data) {
//            return $data->result_array();
//        } else {
//            
//        }
//    }
//
////
//    public function update_permissions() {
//        $perm_name = $this->input->post('perm_name');
//        $perm_defi = $this->input->post('perm_defi');
//        $pidhdn = $this->input->post('pidhdn');
//
//        $data = array(
//            'name' => $perm_name,
//            'definition' => $perm_defi
//        );
//        $this->db->where('id', $pidhdn);
//        $this->db->where('status', '1');
//        return $this->db->update('aauth_perms', $data);
////        log_message('error', $this->db->last_query());
//    }
}
