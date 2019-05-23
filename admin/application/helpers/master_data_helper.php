<?php

/**
 * CodeIgniter
 *
 * @author	Pooranee Inspirations
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SLLRDC Master Data Helpers
 *
 * @package	SLLRDC
 * @subpackage	Helpers
 * @category	Helpers	
 */
// ------------------------------------------------------------------------
// SYS CODE GROUPs
const RELATIONSHIP = 1;
const EMP_DESIG_CATEGORY = 2;
const EMP_TITLE = 3;
const EMP_LOCATION = 4;
const EMP_MARITAL_STATUS = 5;
const EMP_HI_EDU_QUAL = 6;

/**
 * Wetland clearence application, external institutes for recommendation
 */
const WM_RECOMM_EXT_ORG = 7;
const SEC_ACTIVITY_TYPE = 8;
const VEH_OWNER_TYPE = 9;
const VEH_FUEL_TYPE = 10;
const VEH_STATUS_TYPE = 11;
const VEH_REQUEST_VEH_STATUS = 12;
const LEGAL_CASE_CATEGORY = 13;
const MEDIA_STALL_CATEGORY = 14;
const MEDIA_VENDOR_CATEGORY = 15;
const MEDIA_EVENT_TYPE = 16;
const TRANSPORT_VEH_STATUS = 17;
const RND_CLIENT_TYPE = 18;
const PE_JOB_PRIORITY = 19;
const TENDER_STATUS = 20;
const RISK_STATUS = 21;
const REPORT_TYPE = 22;
//        const used = 17;
//        const used = 18;


if (!function_exists('get_system_code_list_by_group')) {


    function get_system_code_list_by_group($group)
    {
        // get main CI object
        $CI = & get_instance();
        $CI->load->database();
        //        
        $CI->db->select('code_id,code_title,code_value');
        $CI->db->where('status', 1);
        $CI->db->where('code_group', (int) $group);
        $CI->db->order_by('row_order');
        $query = $CI->db->get('corp_system_code');
        $count = 0;
        if (!empty($query)) {
            $count = $query->num_rows();
        }
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

}

if (!function_exists('convert_system_codes_to_keyed_list')) {

    /**
     * 
     * @param $result object
     * @return mixed array of objects. array key is object id
     */
    function convert_system_codes_to_keyed_list($result)
    {
        $inst = $result;
        $data = array();
        if (empty($inst)) {
            return false;
        }
        foreach ($inst as $inst_r)
        {
            $data[$inst_r->code_id] = $inst_r;
        }
        return $data;
    }

}

function get_my_employee_list_for_notification($filter = true)
{
    $CI = & get_instance();


    $user_emp = $CI->session->employee;


    $sections = $CI->session->sections;
    // get main CI object
    $CI->load->database();
    //
//        $this->aauth->get_user_id();
    $CI->db->select('emp_id,
            emp_no,
            emp_type_id,
            emp_level_id,
            name_short,
            name_title,
    ');
    $CI->db->where('status', 1);

    $CI->db->order_by('emp_no');
    $query = $CI->db->get('emp_profile');
    $count = 0;
    if (!empty($query)) {
        $count = $query->num_rows();
    }
    $result = FALSE;
    if (!empty($query)) {
        $result = $query->result();
    }
    return $result;
}

if (!function_exists('get_my_employee_list')) {

    /**
     * Employees falls under logged in user
     * @return array 
     * 
     */
    function get_my_employee_list($filter = true)
    {
        $CI = & get_instance();

        $hr = $CI->aauth->is_allowed('is_hr_user', FALSE);
        $user_emp = $CI->session->employee;


        $sections = $CI->session->sections;
        // get main CI object
        $CI->load->database();
        //

        $CI->db->select('emp_id,
            emp_no,
            emp_type_id,
            emp_level_id,
            name_short,
            name_title,
	');
        $CI->db->where('status', 1);
//              $CI->db->where('`emp_profile`.`emp_id` NOT IN (SELECT `user_employee`.`emp_id` FROM `user_employee` Group by `user_employee`.`emp_id`)');
        if ($filter) {
            if (!($hr || empty($user_emp))) {
                $CI->db->where('emp_id', (int) $user_emp->emp_id);
            }
        }

        $CI->db->order_by('emp_no');
        $query = $CI->db->get('emp_profile');

        $count = 0;
        if (!empty($query)) {
            $count = $query->num_rows();
        }
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

}



if (!function_exists('get_employee_info_by_empno')) {

    /**
     * Employee id fields from profile table
     * @return Object
     * @example emp_no,emp_type_id,emp_level_id,name_title
     * 
     */
    function get_employee_info_by_empno($empno)
    {
        // get main CI object
        $CI = & get_instance();
        $CI->load->database();

        $query = $CI->db->get_where("emp_profile", array("emp_no" => $empno));
//    print_r($CI->db->last_query());
//    exit;
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }
        return $result;
    }

}
if (!function_exists('get_employee_info_by_empid')) {

    /**
     * Employee id fields from profile table
     * @return Object
     * @example emp_no,emp_type_id,emp_level_id,name_title
     * 
     */
    function get_employee_info_by_empid($empid)
    {
        // get main CI object
        $CI = & get_instance();
        $CI->load->database();

        $query = $CI->db->get_where("emp_profile", array("emp_id" => $empid));
//    print_r($CI->db->last_query());
//    exit;
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }
        return $result;
    }

}
if (!function_exists('get_employee_ref_ids_by_empid')) {

    /**
     * Employee id fields from profile table
     * @return Object
     * @example emp_no,emp_type_id,emp_level_id,name_title
     * 
     */
    function get_employee_ref_ids_by_empid($empid)
    {
        // get main CI object
        $CI = & get_instance();
        $CI->load->database();

        $CI->db->select('emp_id,
            emp_no,
            emp_type_id,
            emp_level_id,
            name_short,
            name_title,
	');
        $CI->db->where('status', 1);
        $CI->db->where('emp_id', (int) $empid);
        $query = $CI->db->get('emp_profile');

        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }
        return $result;
    }

}

if (!function_exists('get_my_sections_by_division')) {

    /**
     * sections filtered by division
     * @return Object 
     * 
     */
    function get_my_sections_by_division($division_id, $user_id = 0)
    {
        // get main CI object
        $CI = & get_instance();
        $CI->load->database();

        $CI->db->select('
            section_id,
            section_name,
            section_code
	');
        $CI->db->from('corp_section');
        $CI->db->where('status', 1);
        $CI->db->where_in('division_id', $division_id);
        $CI->db->order_by('row_order', 'ASC');
        $query = $CI->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }

        return $result;
    }

}

if (!function_exists('get_division_list')) {

    function get_division_list()
    {
        $CI = & get_instance();
        $CI->load->database();
        $CI->db->select('
            division_id,
            division_name,
            division_code
	');
        $CI->db->from('corp_division');
        $CI->db->where('status=1');
        $CI->db->order_by('row_order', 'ASC');
        $query = $CI->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }

        return $result;
    }

}

if (!function_exists('get_my_division_list')) {

    function get_my_division_list()
    {
        $CI = & get_instance();
        $CI->load->database();
        $user_division_array = $CI->session->divisions;
        $CI->db->select('
            division_id,
            division_name,
            division_code
	');
        $CI->db->from('corp_division');
        $CI->db->where('status=1');
        if (!empty($user_division_array)) {
            $CI->db->where_in('division_id', $user_division_array);
        }
        $CI->db->order_by('row_order', 'ASC');
        $query = $CI->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }

        return $result;
    }

}

if (!function_exists('get_emp_division_list')) {

    function get_emp_division_list($emp_id = 0)
    {

        $CI = & get_instance();
        $CI->load->database();
        $CI->db->select('
            B.division_id,
            B.division_name,
            B.division_code
	');
        $CI->db->from('emp_in_division AS A');
        $CI->db->join('corp_division AS B', 'A.division_id = B.division_id', 'inner');
        $CI->db->where('B.status', 1);
        $CI->db->order_by('division_name', 'ASC');
        $query = $CI->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
//            print_r($CI->db->last_query());
//            exit;
        }

        return $result;
    }

}



if (!function_exists('get_province_list')) {

    /**
     * get province list
     * @return Object 
     * 
     */
    function get_province_list()
    {
        // get main CI object
        $result = array();
        $CI = & get_instance();
        $CI->load->database();
        //
        $CI->db->select('
            province_id,
            province_code,
            province_name            
	');
        $CI->db->from('corp_province');
        $CI->db->where('status', 1);
        $CI->db->order_by('province_name', 'ASC');
        $query = $CI->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }

        return $result;
    }

}

if (!function_exists('get_districts_by_provinceId')) {

    /**
     * get province list
     * @return Object 
     * 
     */
    function get_districts_by_provinceId($province_id = 0)
    {
        // get main CI object
        $result = array();
        $CI = & get_instance();
        $CI->load->database();
        $CI->db->select('
            district_id,
            district_name
	');
        $CI->db->from('corp_district');
        $CI->db->where('status', 1);
        if (!empty($province_id)) {
            $CI->db->where('province_id', (int) $province_id);
        }
        $CI->db->order_by('district_code', 'ASC');
        $query = $CI->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }

        return $result;
    }

}

if (!function_exists('get_gndivision_by_districtId')) {

    /**
     * get province list
     * @return Object 
     * 
     */
    function get_gndivision_by_districtId($district_id)
    {
        // get main CI object
        $result = array();
        $CI = & get_instance();
        $CI->load->database();
        $CI->db->select('
            gn_division_id,
            gn_division_name
	');
        $CI->db->from('corp_gn_division');
        $CI->db->where('status', 1);
        $CI->db->where('district_id', (int) $district_id);
        $CI->db->order_by('gn_division_name', 'ASC');
        $query = $CI->db->get();
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }

        return $result;
    }

}

if (!function_exists('isValidDate')) {

    function isValidDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}

if (!function_exists('dateDifference')) {

    function dateDifference($date_1, $date_2, $differenceFormat = '%a')
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }

}

function dashboard_notification_details($catid)
{

//    echo $section;
//    exit;
    $CI = & get_instance();
    $CI->load->library('session');
    $CI->load->database();
    $divisions = $CI->session->userdata('divisions');
//    print_r($divisions);
//    exit;
    if ($catid == '10') {
//        echo 'awwwwwwwwwwww';
        $current_emp = $CI->session->employee->emp_id;
        $section = get_section_and_data($current_emp);
    }
    $CI->db->select('`notification`.`notification_sub_category_id`,
         `notification_sub_category`.`notification_sub_category`,COUNT(`notification`.`notification_sub_category_id`) as total');
    $CI->db->join('`notification_category`', '`notification`.`notification_category_id` = `notification_category`.`notification_category_id`', 'LEFT');
    $CI->db->join('`notification_sub_category`', '`notification`.`notification_sub_category_id` = `notification_sub_category`.`notification_sub_category_id`', 'LEFT');
    $CI->db->where('`notification`.`notification_category_id`', $catid);
    if (!empty($section)) {
        $CI->db->where('`notification`.`section_id`', $section);
    }

    $CI->db->where('`notification`.`is_active`', '1');
    $CI->db->where_in('`notification`.`division_id`', $divisions);
    $CI->db->group_by('notification.notification_sub_category_id');

    $query = $CI->db->get('notification');
//    print_r($CI->db->last_query());
//    exit;

    return $query->result_array();
//    echo '<pre>';
//    print_r($query->row_array());
//    exit;
}

function get_section_and_data($sec_head_id)
{
    $CI = & get_instance();
    $CI->load->library('session');
    $CI->load->database();

    $CI->db->select('machinery_repair_section.id');
    $CI->db->where('`machinery_repair_section`.`section_head`', $sec_head_id);
    $query = $CI->db->get('machinery_repair_section');
//    print_r($CI->db->last_query());
//    exit;
    return $query->row()->id;
//    echo '<pre>';
//    print_r($query->row()->id);
//    exit;
}

if (!function_exists('get_division_name_by_id')) {

    /**
     * Employee id fields from profile table
     * @return Object
     * @example emp_no,emp_type_id,emp_level_id,name_title
     * 
     */
    function get_division_name_by_id($divid)
    {
        // get main CI object
        $CI = & get_instance();
        $CI->load->database();

        $query = $CI->db->get_where("corp_division", array("division_id" => $divid));
//    print_r($CI->db->last_query());
//    exit;
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->row();
        }
        return $result;
    }

}







if (!function_exists('get_my_employee_list_to_division')) {

    /**
     * Employees falls under logged in user
     * @return array 
     * 
     */
    function get_my_employee_list_to_division($filter = false)
    {
        $CI = & get_instance();

        $hr = $CI->aauth->is_allowed('is_hr_user', FALSE);
        $user_emp = $CI->session->employee;
        $user_division_array = $CI->session->divisions;
//       $division = get_emp_division_list($user_emp->emp_id);
//       echo '<pre>';
//       print_r($user_division_array[0]);
//       exit;
//        $sections = $CI->session->sections;
        // get main CI object
        $CI->load->database();
        //
//        SELECT
//emp_profile.emp_id,
//emp_profile.emp_no,
//emp_profile.emp_type_id,
//emp_profile.emp_level_id,
//emp_profile.name_short,
//emp_profile.name_title,
//emp_in_division.emp_id,
//emp_in_division.division_id
//FROM
//emp_profile
//INNER JOIN emp_in_division ON emp_in_division.emp_id = emp_profile.emp_id
//WHERE
//emp_profile.`status` = 1 AND
//emp_in_division.division_id = 3
//ORDER BY `emp_no`

        $CI->db->select('emp_profile.emp_id,
emp_profile.emp_no,
emp_profile.emp_type_id,
emp_profile.emp_level_id,
emp_profile.name_short,
emp_profile.name_title,
emp_in_division.emp_id,
emp_in_division.division_id');

        $CI->db->join('`emp_in_division`', 'emp_in_division.emp_id = emp_profile.emp_id');
        $CI->db->where('status', 1);
        $CI->db->where('emp_in_division.division_id', $user_division_array[0]);
//              $CI->db->where('`emp_profile`.`emp_id` NOT IN (SELECT `user_employee`.`emp_id` FROM `user_employee` Group by `user_employee`.`emp_id`)');
//       
//      echo 'adadadasd';
//        exit;

        $CI->db->order_by('emp_no');
        $query = $CI->db->get('emp_profile');
//       print_r($CI->db->last_query());
//    exit;
        $count = 0;
        if (!empty($query)) {
            $count = $query->num_rows();
        }
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

}
// ------------------------------------------------------------------------


