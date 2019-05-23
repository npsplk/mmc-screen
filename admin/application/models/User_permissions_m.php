<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_permissions_m extends CI_Model {

    public function load_user_combo($group_id) {
        $this->db->select('aauth_users.id,
        aauth_users.username');
        $this->db->from('aauth_users');
        $this->db->join('aauth_user_to_group', 'aauth_users.id = aauth_user_to_group.user_id');
        $this->db->where('aauth_user_to_group.group_id', $group_id);
        $query = $this->db->get();
//         log_message('error', $this->db->last_query());
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

    public function load_user_permissions_data($group_id) {

        $query = $this->db->query("SELECT
aauth_perms.`name` AS pname,
aauth_perm_to_group.perm_id
FROM
aauth_perms
INNER JOIN aauth_perm_to_group ON aauth_perms.id = aauth_perm_to_group.perm_id
WHERE
aauth_perm_to_group.group_id = $group_id");
//        $query = $this->db->get();

        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        if ($result) {
            echo json_encode(array("status" => 1, "data" => $result));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Could not get the user  permissions"));
        }
    }

//
    public function save_update_user_permissions($checked_values, $permision_id, $groupid, $userid) {

        $save = $checked_values['save'];
        $edit = $checked_values['edit'];
        $delete = $checked_values['delete'];
//        exit;
        $query = $this->db->query("INSERT INTO `aauth_perm_to_user` (`perm_id`, `user_id`, `perm_save`, `perm_edit`, `perm_delete`, `perm_other`, `perm_group_id`) VALUES($permision_id, $userid, $save, $edit, $delete, '0', $groupid)ON DUPLICATE KEY UPDATE `perm_save` = $save, `perm_edit` = $edit, `perm_delete` = $delete");

        if ($query) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }

//        log_message('error', $this->db->last_query());
    }

    public function get_user_related_permissions($userid) {

        $this->db->from('aauth_perm_to_user');
        $this->db->where('user_id', $userid);
        $query = $this->db->get();

        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

}
