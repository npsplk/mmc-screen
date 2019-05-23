<?php

/**
 * Description of Corporation divisions
 *
 * @author sachith
 */
class Corp_division_m extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
    }

    public function insert() {
        $datetime = mdate('%Y-%m-%d %H:%i:%s');
        $user_id = $this->aauth->get_user_id();

        $data = array(
            'division_name' => $this->input->post('division_name'),
            'division_code' => $this->input->post('division_code'),
            'row_order' => 1,
            'last_updated' => $datetime,
            'updated_by' => $user_id,
            'status' => 1
        );

        $flag = $this->db->insert('corp_division', $data);
        return $flag;
    }

    public function update($id) {
        if (empty($id)) {
            return false;
        }
        $datetime = mdate('%Y-%m-%d %H:%i:%s');
        $user_id = $this->aauth->get_user_id();

        $data = array(
            'division_name' => $this->input->post('division_name'),
            'division_code' => $this->input->post('division_code'),
            'row_order' => 1,
            'last_updated' => $datetime,
            'updated_by' => $user_id
        );

        $this->db->where('division_id', (int) $id);
        $flag = $this->db->update('corp_division', $data);
        return $flag;
    }

    public function delete($id) {
        $this->db->where('division_id', $id);
        $flag = $this->db->delete('corp_division');
        return $flag;
    }

    public function hideRecord($id) {
        $this->db->set('status', -1);
        $this->db->where('division_id', (int) $id);
        $flag = $this->db->update('corp_division');
        return $flag;
    }

    public function showRecord($id) {
        $this->db->set('status', 1);
        $this->db->where('division_id', (int) $id);
        $flag = $this->db->update('corp_division');
        return $flag;
    }

    public function getRecordById($id) {
        $this->db->from('corp_division');
        $this->db->where('division_id', $id);

        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }
        return $result;
    }

    public function getDatatableRecords() {

        $this->db->select('A.division_id', false);
        $this->db->from('corp_division AS A');
//        $this->db->where('A.status >=', 0);
        if (!empty($search['value'])) {
            $this->db->group_start();
            $this->db->like('division_name', $search['value'], 'both');
            $this->db->or_like('division_code', $search['value'], 'both');
            $this->db->group_end();
        }

        $totalData = $this->db->count_all_results();

        $totalFiltered = $totalData;
        $data_result = array();
        if (!empty($totalData)) {
            //for sorting
            $columns = array(
                'division_name',
                'division_code',
                'last_updated',
                'division_id',
            );
            // filter
            $search = $this->input->post_get('search');
            $order = $this->input->post_get('order');
            $start = $this->input->post_get('start');
            $limit = $this->input->post_get('length');

            $this->db->select('A.division_id,division_name,division_code,status,last_updated');
            $this->db->from('corp_division AS A');
//            $this->db->where('A.status >=', 0);
            if (!empty($search['value'])) {
                $this->db->group_start();
                $this->db->like('division_name', $search['value'], 'both');
                $this->db->or_like('division_code', $search['value'], 'both');
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
