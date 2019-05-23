<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function insert_notification($noti_category_id, $noti_sub_category_id, $div_id, $perm_id, $ref_id, $url, $notification, $is_active, $task_id = 0, $section_id = 0)
{
//    echo $section_id;
//    exit;
    // get main CI object
    $CI = & get_instance();
    $CI->load->database();
    //    

    $countactive = Count_State_Active($noti_category_id, $ref_id);

    if ($countactive == 0) {

        Insert_values($noti_category_id, $noti_sub_category_id, $div_id, $perm_id, $ref_id, $url, $notification, $is_active, $task_id, $section_id);
    } else {

        $result = Update_values($noti_category_id, $ref_id);

        //	if($result === TRUE){
        Insert_values($noti_category_id, $noti_sub_category_id, $div_id, $perm_id, $ref_id, $url, $notification, $is_active, $task_id, $section_id);
        // }
    }
}

function Insert_values($noti_category_id, $noti_sub_category_id, $div_id, $perm_id, $ref_id, $url, $notification, $is_active, $task_id, $section_id)
{

    // get main CI object
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->trans_start();
    $data = array(
        'notification_category_id' => $noti_category_id,
        'notification_sub_category_id' => $noti_sub_category_id,
        'division_id' => $div_id,
        'perm_id' => $perm_id,
        'reference_id' => $ref_id,
        'url' => $url,
        'notification' => $notification,
        'is_active' => $is_active,
        'task_id' => $task_id,
        'notification_date' => mdate('%Y-%m-%d', time('Asia/colombo')),
        'notification_time' => mdate('%H:%i:%a', time('Asia/colombo')),
        'state' => 1,
        'section_id' => $section_id
    );

    $flag = $CI->db->insert('notification', $data);
    //return   
//    print_r($CI->db->last_query());
//    exit;
    $CI->db->trans_complete();
    if ($CI->db->trans_status() === TRUE) {
        $saved = TRUE;
    }

    return $saved;
}

function Update_values($noti_category_id, $ref_id)
{

    // get main CI object
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->trans_start();
    $CI->db->set('is_active', 0);
    //$CI->db->set('status', 1);
    $CI->db->where('notification_category_id', (int) $noti_category_id);
    $CI->db->where('reference_id', $ref_id);
    $CI->db->update('notification');
    $CI->db->trans_complete();

    if ($CI->db->trans_status() === TRUE) {
        $saved = TRUE;
    } else {
        $saved = FALSE;
    }

    return $saved;
}

function Count_State_Active($noti_category_id, $ref_id)
{

    // get main CI object
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('*');
    $CI->db->where('is_active', 1);
    //$CI->db->where('state', 1);
    $CI->db->where('notification_category_id', $noti_category_id);
    $CI->db->where('reference_id', $ref_id);
    $query = $CI->db->get('notification');



    //$results = $query->num_rows();
    //$results= $CI->db->last_query();

    return $query->num_rows();
}

function get_divition_id($ref_id)
{

    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('division_id');
    $CI->db->where('mnt_job_id', $ref_id);
    $query = $CI->db->get('mnt_joborder');
    $row = $query->row();

    return $row->division_id;
}

function category_notification_details()
{
    $this->db->select('`notification`.`notification_category_id`,`notification_category`.`notification_category`');
    $this->db->join('`notification_category`', '`notification`.`notification_category_id` = `notification_category`.`notification_category_id`', 'LEFT');
    $this->db->group_by('notification.notification_category_id');
    $this->db->where('`notification`.`state`', '1');
    $d = $this->db->get('notification');
    if ($d) {
        return $d->result_array();
    }
}

function check_permissions($permission)
{
    $CI = & get_instance();
    $CI->load->database();
    $user_id = $CI->session->id;
    $CI->db->select('aauth_perms.id');
    $CI->db->join('`aauth_perm_to_user`', 'aauth_perm_to_user.perm_id = aauth_perms.id', 'LEFT');
    $CI->db->where('aauth_perm_to_user.user_id', $user_id);
    $CI->db->where('aauth_perms.`status`', '1');
    $CI->db->where('aauth_perms.`name`', $permission);
    $d = $CI->db->get('aauth_perms');
//    echo $CI->db->last_query() ;
//    exit;
    if ($d) {
        return $d->row()->id;
    }
}

function get_user_id_to_division($division_id)
{

    $CI = & get_instance();
    $CI->load->library('session');
    $CI->load->database();

    $CI->db->select('aauth_user_to_group.user_id,
emp_in_division.division_id');
      $CI->db->join('`user_employee`', 'aauth_user_to_group.user_id = user_employee.users_id');
      $CI->db->join('`emp_in_division`', 'user_employee.emp_id = emp_in_division.emp_id');
    $CI->db->where('aauth_user_to_group.group_id', 6);
    $CI->db->where('emp_in_division.division_id', $division_id);
    $query = $CI->db->get('machinery_repair_section');
//    print_r($CI->db->last_query());
//    exit;
    return $query->row()->user_id;
//    echo '<pre>';
//    print_r($query->row()->id);
//    exit;
}
