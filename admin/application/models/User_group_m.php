<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author sachith
 */
class User_group_m extends CI_Model {

    public function getSystemParentPermissions() {

        $this->load->database();
        $this->db->select('id, 
                    name, 
                    definition');
        $this->db->from('aauth_perms');
        $this->db->where('status', 1);
        $this->db->where('parent_id', 0);
        $this->db->order_by('definition', 'ASC');
        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

    public function getPermissionsTree() {
        $this->db->from('aauth_perms');
        $this->db->where('status', 1);
        $this->db->order_by('definition', 'ASC');
        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        $tree_structure = array();
        if ($result) {
            $perm_tree = array();
            $obj_state = new stdClass();

            $obj_state->checked = false;
//                $obj_state->disabled= true,
            $obj_state->expanded = false;
            $obj_state->selected = false;

            foreach ($result as $perm_parent) {
                if ($perm_parent->parent_id == 0) {
                    $k = $perm_parent->id;
//                    $perm_parent->nodes = array();
                    $item = new stdClass();
                    $item->id = $k;
                    $item->selectable = "false";
                    $item->state = $obj_state;
                    $item->text = $perm_parent->definition;
                    $item->permid = $perm_parent->id;
                    $item->nodes = array();
                    $perm_tree[$k] = $item;
                }
            }
            foreach ($result as $perm_child) {
                $p = $perm_child->parent_id;
                if ($p > 0) {
                    $item = new stdClass();
                    $item->id = $perm_child->id;
                    $item->text = $perm_child->definition;
                    $item->selectable = "false";
                    $item->state = $obj_state;
                    $item->permid = $perm_child->id;
                    $perm_tree[$p]->nodes[] = $item;
                }
            }

            foreach ($perm_tree as $data) {
                $tree_structure[] = $data;
            }
        }

        return $tree_structure;
    }

    public function getUserGroupPermissions($group_id) {
        $this->db->select('perm_id');
        $this->db->from('aauth_perm_to_group AS A');
        $this->db->where('group_id', $group_id);
        $query = $this->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

}
