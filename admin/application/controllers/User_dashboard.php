<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_dashboard extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->aauth->control();
        $this->load->helper('master_data');
        $this->load->helper('dashboard');
        $this->load->library("Aauth");
        $this->load->library('session');
        $this->load->model('User_dashboard_model');
    }

    public function index()
    {
        $this->redirect_user();
    }

    /**
     * Set user profile data to session and load user home page
     */
    public function redirect_user()
    {
        $is_loggedin = $this->aauth->is_loggedin();
        $profile_data = new stdClass();
//        $user_view = '';
      
        $user_view = 'user_dashboard_exam';
        if ($is_loggedin)
        {
                
            $user_id = $this->aauth->get_user_id();
            $this->session->divisions = $this->User_dashboard_model->getUserDivisions_array($user_id);
            $this->session->sections = $this->User_dashboard_model->getUserSections_array($user_id);
            $this->session->employee = $this->User_dashboard_model->getUserEmployeeInfo($user_id);
             
            $this->view($user_view);
            //
        }
    }

    public function view($user_view)
    {
//         echo '<pre>';
//             print_r($this->session->userdata()) ;
//        exit;
//                $this->output->enable_profiler(TRUE);
        $data['title'] = 'Dashboard';
        $data['body_class'] = 'dashboard-page';

        $data['styles'] = array(
            "assets/bower_components/Ionicons/css/ionicons.min.css",
            "assets/js/sweetalert-master/dist/sweetalert.css",
            "assets/bower_components/jvectormap/jquery-jvectormap.css",
            "assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css",
            "assets/dist/css/AdminLTE.min.css",
            "assets/dist/css/skins/_all-skins.min.css",
        );
        $data['scripts'] = array(
            "assets/js/sweetalert-master/dist/sweetalert.min.js",
            "assets/bower_components/raphael/raphael.min.js",
            "assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js",
            "assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js",
            "assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js",
            "assets/bower_components/jquery-knob/dist/jquery.knob.min.js",
            "assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js",
            "assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js",
            "assets/bower_components/fastclick/lib/fastclick.js",
            "assets/dist/js/adminlte.min.js"
        );


        $this->session->user_menu = $this->createUserMenu();

//        $sections = array(
//                'config'  => TRUE,
//                'queries' => TRUE
//        );
//$this->output->enable_profiler(TRUE);
//        $this->output->set_profiler_sections();
        //
            $data['scriptview'] = array(
            "dashboard_script"
        );

//        $data['employee_count'] = $this->User_dashboard_model->getUserEmployee_count();
//        $data['users_count'] = $this->User_dashboard_model->getUsers_count();
//        $data['category'] = $this->User_dashboard_model->category_notification_details();
//        $data['wetland'] = $this->User_dashboard_model->get_count_of_all('application_id', 'wm_application');
//        $data['security'] = $this->User_dashboard_model->get_count_of_all('complain_id', 'sec_unauthorized_complain');
//        dashboard_notification_details($subcat);
//        $data['users_count'] = $this->User_dashboard_model->get_count_of_all($suto_inc, $from, $where_tbl, $where_id);
        $this->load->view('template/header', $data);
        $this->load->view($user_view, $data);
        $this->load->view('template/footer', $data);
    }

    public function createUserMenu_old()
    {

        $user_id = $this->session->id;
        $group_id = $this->get_group_id_menu($user_id);
//         print_r($group_id) ;
//        exit;
        $this->load->database();
        $this->db->select('A.menu_id,A.menu_title, 
                    A.menu_parent,A.menu_path,A.menu_icon');
        $this->db->from('system_menu AS A');
        $this->db->join('aauth_perm_to_group AS B', 'A.aauth_perm_id = B.perm_id', 'left');
        $this->db->where('B.group_id', $group_id);
        $this->db->where('A.menu_parent', 0);
        $this->db->where('A.status', 1);
        $this->db->order_by('A.row_order', 'ASC');
        $query = $this->db->get();
//         log_message('error', $this->db->last_query());
        $result = FALSE;
        //
        $menu = array();
        if (!empty($query))
        {
            $result = $query->result_array();
        }
        if (!empty($result))
        {
            foreach ($result as $menu_item)
            {
                $b = $this->getSubMenuItemsByParentId($menu_item['menu_id'], $group_id);
                $a = array(
                    "menu_id" => $menu_item['menu_id'],
                    "menu_title" => $menu_item['menu_title'],
                    "menu_path" => $menu_item['menu_path'],
                    "menu_icon" => $menu_item['menu_icon'],
                    "sub_items" => $b);
                $menu[] = $a;
            }
        }
        return $menu;
    }

    private function getSubMenuItemsByParentId($parent_id)
    {
        $this->load->database();
        $this->db->select('A.menu_id,A.menu_title, 
                    A.menu_parent,A.menu_path,A.menu_icon');
        $this->db->from('system_menu AS A');
        $this->db->where('A.menu_parent', $parent_id);
        $this->db->where('A.status', 1);
        $this->db->order_by('A.row_order', 'ASC');
        $query = $this->db->get();
        $result = FALSE;
        //
        if (!empty($query))
        {
            $result = $query->result_array();
        }
        return $result;
    }

    public function createUserMenu()
    {

        $user_id = $this->session->id;
        $group_id = $this->get_group_id_menu($user_id);
        //group menu items

        $this->load->database();
        $this->db->select('A.menu_id,A.menu_title, 
                    A.menu_parent,A.menu_path,A.menu_icon,A.aauth_perm_id');
        $this->db->from('system_menu AS A');
        $this->db->join('aauth_perm_to_group AS B', 'A.aauth_perm_id = B.perm_id', 'inner');
        $this->db->where('B.group_id', $group_id);
        $this->db->where('A.status', 1);
        $this->db->order_by('A.row_order', 'ASC');
        $query = $this->db->get();

        $result = array();
        if (!empty($query))
        {
            $result = $query->result_array();
        }
        //
        //user menu items
        $this->db->select('A.menu_id,A.menu_title, 
                    A.menu_parent,A.menu_path,A.menu_icon,A.aauth_perm_id');
        $this->db->from('system_menu AS A');
        $this->db->join('aauth_perm_to_user AS B', 'A.aauth_perm_id = B.perm_id', 'inner');
        $this->db->where('B.user_id', $user_id);
        $this->db->where('A.status', 1);
        $this->db->order_by('A.row_order', 'ASC');
        $query = $this->db->get();
        //
        $result2 = array();
        if (!empty($query))
        {
            $result2 = $query->result_array();
        }
        //MERGE ALL ACCESSIBLE MENU ITEMS
        $all_menu_items = array_merge($result, $result2);

        $parent_items = array();
        $sub_items = array();
        foreach ($all_menu_items as $m1)
        {
            if ($m1['menu_parent'] == 0)
            {
                $parent_items[$m1['menu_id']] = $m1;
            }
        }
//        GROUP SUB MENU ITEMS BY PARENT MENU ITEM
        foreach ($all_menu_items as $m2)
        {
            if ($m2['menu_parent'] != 0)
            {
                $sub_items[$m2['menu_parent']][$m2['menu_id']] = $m2;
            }
        }

        foreach ($parent_items as $kp1 => $p1)
        {
            if (!empty($sub_items[$p1['menu_id']]))
            {
                $parent_items[$kp1]['sub_items'] = $sub_items[$p1['menu_id']];
            }
        }
        return $parent_items;
    }

    public function get_group_id_menu($user_id)
    {

        $this->db->select('aauth_user_to_group.group_id');
        $this->db->from('aauth_user_to_group');
        $this->db->where('aauth_user_to_group.user_id', $user_id);

        $query = $this->db->get();
//         log_message('errorasdasdasd', $this->db->last_query());

        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();

            return $array = array_shift($row);
        }
        else
        {
            redirect('login');
        }
    }

    public function reset_user_password()
    {

        $trans = $this->User_dashboard_model->update_user_password();
        return $trans;
    }

}
