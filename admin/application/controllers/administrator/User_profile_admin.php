<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_profile_admin extends CI_Controller {

    function __construct() {
        parent::__construct();
//        print_r($_SESSION) ;
//        exit;
        $this->aauth->control('User_profile_admin');

        $this->aauth->is_group_have_permission_for_access($_SESSION['id']);
    }

    public function index() {
        $data['title'] = 'Users account';
        $data['styles'] = array("assets/js/sweetalert-master/dist/sweetalert.css",
            "assets/js/sweetalert-master/themes/google/google.css");
        $data['scripts'] = array(
            "assets/js/jquery-validation-1.15.0/jquery.validate.min.js",
            "assets/js/sweetalert-master/dist/sweetalert.min.js",
            "assets/app_js/user_profile_admin.js"
        );
        $user_profile = $this->session->user_profile;
        $admin = $this->aauth->is_admin();
        if ($admin) {
            $this->load->view('template/header', $data);

            $this->load->view('admin/user_profile_admin');
            $this->load->view('template/footer', $data);
        } else {

            redirect(site_url("administrator/admin_login"));
        }
    }

//    public function save() {
//        $user_profile = $this->session->user_profile;
//        $this->load->library('form_validation');
//        $logged_user_id = $this->aauth->get_user_id();
//        $aauth_user_data = $this->aauth->get_user();
//        $profile_id = (int) $user_profile->profile_id;
//        //
//        $flag = FALSE;
//        $this->form_validation->set_rules('profile_name', 'Profile Name', 'trim|required');
//        $this->form_validation->set_rules('nic_no', 'NIC No', 'trim|required');
//        $this->form_validation->set_rules('email', 'Email Address', 'trim|required');
//        $this->form_validation->set_rules('contact_no', 'Contact No', 'trim|required');
//        $chk_password_chnge = $this->input->post('chk_password_chnge');
//        if (!empty($chk_password_chnge)) {
//            $this->form_validation->set_rules('password_current', 'Existing Password', 'required');
//            $this->form_validation->set_rules('password_new', 'New Password', 'required');
//            $this->form_validation->set_rules('password2', 'Confirm New Password', 'required|matches[password_new]');
//        }
//
//        if ($this->form_validation->run() == FALSE) {
//            echo json_encode(array("status" => 2, "msg" => validation_errors('<span class="error-msg">', '</span>')));
//            return;
//        }
//
//        if (!empty($user_profile->profile_id)) {
//            $flag = $this->update();
//        } else {
//            $flag = $this->insert();
//        }
//
//        $password_change = true;
//        if ($flag && !empty($chk_password_chnge)) {
//            $password_change = FALSE;
//            // update user password
//            $curr_pass = $this->input->post('password_current');
//            $current_pass_ok = $this->aauth->verify_password($this->aauth->hash_password($curr_pass, $aauth_user_data->id), $aauth_user_data->pass);
//            if ($current_pass_ok) {
//                $password_change = $this->aauth->update_user($logged_user_id, FALSE, $this->input->post('password_new'), FALSE);
//            }
//        }
//
//        if ($flag) {
//            if (empty($password_change)) {
//                echo json_encode(array("status" => 2, "msg" => "Could not update the password"));
//            } else {
//                echo json_encode(array("status" => 1, "msg" => "Successfully Saved, Refreshing user profile, Please wait..."));
//            }
//        } else {
//            echo json_encode(array("status" => 2, "msg" => "Could not save"));
//        }
//    }

    /**
     * Insert user profile
     * @return type
     */
//    public function insert() {
//        $datestring = '%Y-%m-%d %H:%i:%s';
//        $user_profile = $this->session->user_profile;
//        $this->load->database();
//        if ($user_profile->profile_table == 'naqda_user_profile') {
//            $data = array(
//                'profile_name' => $this->input->post('profile_name'),
//                'contact_no' => $this->input->post('contact_no'),
//                'email' => $this->input->post('email'),
//                'nic_no' => $this->input->post('nic_no'),
//                'designation_id' => 1,
//                'aauth_user_id' => $this->aauth->get_user_id(),
//                'created_date' => mdate($datestring),
//                'last_updated' => mdate($datestring),
//                'status' => 1
//            );
//        } else if ($user_profile->profile_table == 'society_user_profile') {
//            $data = array(
//                'profile_name' => $this->input->post('profile_name'),
//                'contact_no' => $this->input->post('contact_no'),
//                'email' => $this->input->post('email'),
//                'nic_no' => $this->input->post('nic_no'),
//                'address' => $this->input->post('address'),
//                'society_id' => $this->input->post('society_id'),
//                'aauth_user_id' => $this->aauth->get_user_id(),
//                'created_date' => mdate($datestring),
//                'last_updated' => mdate($datestring),
//                'status' => 1
//            );
//        }
//
//        $flag = $this->db->insert($user_profile->profile_table, $data);
//        return $flag;
//    }

    /**
     * Update User profile
     * @return type
     */
//    public function update() {
//        $datestring = '%Y-%m-%d %H:%i:%s';
//        $this->load->database();
//        $user_profile = $this->session->user_profile;
//        if (empty($user_profile->profile_id)) {
//            return false;
//        }
//        if ($this->session->user_profile->profile_table == 'naqda_user_profile') {
//            $this->db->set('profile_name', $this->input->post('profile_name'));
//            $this->db->set('contact_no', $this->input->post('contact_no'));
//            $this->db->set('email', $this->input->post('email'));
//            $this->db->set('nic_no', $this->input->post('nic_no'));
//            $this->db->set('last_updated', mdate($datestring));
//        } else if ($user_profile->profile_table == 'society_user_profile') {
//            $this->db->set('profile_name', $this->input->post('profile_name'));
//            $this->db->set('contact_no', $this->input->post('contact_no'));
//            $this->db->set('email', $this->input->post('email'));
//            $this->db->set('nic_no', $this->input->post('nic_no'));
////            $this->db->set('address', $this->input->post('nic_no'));
//            $this->db->set('last_updated', mdate($datestring));
//        }
//        $this->db->where($user_profile->profile_table_pk_field, (int) $user_profile->profile_id);
//        $flag = $this->db->update($user_profile->profile_table);
//        return $flag;
//    }

    public function load_personal_profile() {
        $userdetail = $_POST['user_detail'];

        $this->db->select('exm_sp_basic.AddressOfPlaceOfWorkCity,
 exm_sp_basic.AddressOfPlaceOfWorkLine1,
 exm_sp_basic.AddressOfPlaceOfWorkLine2,
 exm_sp_basic.AddressOfPlaceOfWorkLine3,
 exm_sp_basic.CitizenshipID,
 exm_sp_basic.CivilStatus,
 exm_sp_basic.CorrespondenceAddressLine1,
 exm_sp_basic.CorrespondenceAddressLine2,
 exm_sp_basic.CorrespondenceAddressLine3,
 exm_sp_basic.CorrespondenceCity,
 date(`exm_sp_basic`.`DateOfBirth`) AS bdate,
 exm_sp_basic.DateOfRegistration,
 exm_sp_basic.DateOfSubmission,
 exm_sp_basic.DeclarationBirthCertificateFlag,
 exm_sp_basic.DeclarationEducationCertificateFlag,
 exm_sp_basic.DeclarationPhotographFlag,
 exm_sp_basic.DeclarationReferenceSource,
 exm_sp_basic.DistrictId,
 exm_sp_basic.EmailAddress,
 exm_sp_basic.FullName,
 exm_sp_basic.Gender,
 exm_sp_basic.Id,
 exm_sp_basic.Activation,
 exm_sp_basic.ActivationUntillDate,
 exm_sp_basic.ActivityId,
 exm_sp_basic.Amount,
 exm_sp_basic.BatchId,
 exm_sp_basic.HomeCityID,
 exm_sp_basic.ICASLNo,
 exm_sp_basic.IcaslTempNo,
 exm_sp_basic.IsCharted,
 exm_sp_basic.KnowAboutICASLType,
 exm_sp_basic.LanguageMedium,
 exm_sp_basic.LastActiveYear,
 exm_sp_basic.LastName,
 exm_sp_basic.NIC,
 exm_sp_basic.NameInitials,
 exm_sp_basic.NameOfPlaceOfWorkCode,
 exm_sp_basic.Nationality,
 exm_sp_basic.PassportNo,
 exm_sp_basic.PaymentCode,
 exm_sp_basic.PermanentAddressCity,
 exm_sp_basic.PermanentAddressCityID,
 exm_sp_basic.PermanentAddressLine1,
 exm_sp_basic.PermanentAddressLine2,
 exm_sp_basic.PermanentAddressLine3,
 exm_sp_basic.PhotoFilePath,
 exm_sp_basic.PresentEmployment,
 exm_sp_basic.ProvinceId,
 exm_sp_basic.ScholarshipFlag,
 exm_sp_basic.TelephoneExtension,
 exm_sp_basic.TelephoneHome,
 exm_sp_basic.TelephoneMobile,
 exm_sp_basic.TelephoneOffice,
 exm_sp_basic.Title,
 exm_sp_basic.profile_sync_date,
 exm_smdistrict.`Name` AS ditrict,
exm_smprovince.`Name` AS Province');
        $this->db->from('aauth_users');
        $this->db->join('exm_sp_basic', 'exm_sp_basic.ICASLNo = aauth_users.username');
        $this->db->join('exm_smdistrict', 'exm_sp_basic.DistrictId = exm_smdistrict.PK');
        $this->db->join('exm_smprovince', 'exm_smdistrict.fkProvince = exm_smprovince.PK');
        $this->db->where('aauth_users.username', $userdetail);
        $query = $this->db->get();
//         log_message('error', $this->db->last_query());
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
            echo json_encode($result);
//            print_r($result);
//            exit;
        } else {
            echo json_encode(FALSE);
        }
    }

    public function load_member_profile() {
        $userdetail = $_POST['user_detail'];
        $this->db->select('exm_mp_basic.Id,
exm_mp_basic.Activation,
exm_mp_basic.ActivationUntillDate,
exm_mp_basic.ActivityId,
exm_mp_basic.AddressOfPlaceOfWorkCity,
exm_mp_basic.AddressOfPlaceOfWorkCountry,
exm_mp_basic.AddressOfPlaceOfWorkLine1,
exm_mp_basic.AddressOfPlaceOfWorkLine2,
exm_mp_basic.AddressOfPlaceOfWorkLine3,
exm_mp_basic.Amount,
exm_mp_basic.BatchId,
exm_mp_basic.CitizenshipID,
exm_mp_basic.CivilStatus,
exm_mp_basic.CorrespondenceAddressLine1,
exm_mp_basic.CorrespondenceAddressLine2,
exm_mp_basic.CorrespondenceAddressLine3,
exm_mp_basic.CorrespondenceCity,
exm_mp_basic.CorrespondenceCountry,
date(`exm_mp_basic`.`DateOfBirth`) AS bdate,
exm_mp_basic.DateOfRegistration,
exm_mp_basic.DateOfSubmission,
exm_mp_basic.DeclarationBirthCertificateFlag,
exm_mp_basic.DeclarationEducationCertificateFlag,
exm_mp_basic.DeclarationPhotographFlag,
exm_mp_basic.DeclarationReferenceSource,
exm_mp_basic.EmailAddress,
exm_mp_basic.FullName,
exm_mp_basic.HomeCityID,
exm_mp_basic.ICASLNo,
exm_mp_basic.IsCharted,
exm_mp_basic.KnowAboutICASL,
exm_mp_basic.LanguageMedium,
exm_mp_basic.LastActiveYear,
exm_mp_basic.LastName,
exm_mp_basic.MemberNo,
exm_mp_basic.NIC,
exm_mp_basic.NameInitials,
exm_mp_basic.NameOfPlaceOfWork,
exm_mp_basic.NameWithInitials,
exm_mp_basic.Nationality,
exm_mp_basic.PassportNo,
exm_mp_basic.PaymentCode,
exm_mp_basic.PermanentAddressCity,
exm_mp_basic.PermanentAddressCityID,
exm_mp_basic.PermanentAddressLine1,
exm_mp_basic.PermanentAddressLine2,
exm_mp_basic.PermanentAddressLine3,
exm_mp_basic.PermanentCountry,
exm_mp_basic.PhotoFilePath,
exm_mp_basic.PresentEmployment,
exm_mp_basic.ScholarshipFlag,
exm_mp_basic.TelephoneExtension,
exm_mp_basic.TelephoneHome,
exm_mp_basic.TelephoneMobile,
exm_mp_basic.TelephoneOffice,
exm_mp_basic.Title,
exm_mp_basic.Correspondence,
exm_mp_basic.profile_sync_date,
exm_smdistrict.`Name` AS ditrict,
exm_mp_basic.Gender,
exm_smprovince.`Name` AS Province');

        $this->db->from('exm_mp_basic');
        $this->db->join('aauth_users', 'exm_mp_basic.MemberNo = aauth_users.username', 'left');
        $this->db->join('exm_smprovince', 'exm_mp_basic.ProvinceId = exm_smprovince.PK', 'left');
        $this->db->join('exm_smdistrict', 'exm_mp_basic.DistrictId = exm_smdistrict.PK', 'left');
        $this->db->where('aauth_users.username', $userdetail);
        $query = $this->db->get();
//         log_message('error', $this->db->last_query());
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
            echo json_encode($result);
//            print_r($result);
//            exit;
        } else {
            echo json_encode(FALSE);
        }
    }

    public function load_member_qualification_profile() {

        $userdetail = $_POST['user_detail'];
        $this->db->select('exm_mp_acadamicq.Id,
exm_mp_acadamicq.MemberNo,
exm_mp_acadamicq.InstitutionCode AS acInstitutionCode,
exm_mp_acadamicq.NameOfInstitution AS acNameOfInstitution,
exm_mp_acadamicq.QualifiedYear,
exm_mp_acadamicq.CurrentYear,
exm_mp_acadamicq.Duration AS acDuration,
exm_mp_acadamicq.IsInternal,
exm_mp_acadamicq.IsObtained,
exm_mp_acadamicq.SubQualificationID,
exm_mp_acadamicq.Title,
exm_mp_genqualification.Id,
exm_mp_genqualification.MemberNo,
exm_mp_genqualification.InstitutionCode AS genInstitutionCode,
exm_mp_genqualification.NameOfInstitution AS genNameOfInstitution,
exm_mp_genqualification.QualifiedYear,
exm_mp_genqualification.Duration AS genDuration,
exm_mp_genqualification.Grade,
exm_mp_genqualification.IndexNo,
exm_mp_genqualification.MediumOfStudy,
exm_mp_genqualification.NameOfQualification,
exm_mp_genqualification.QualificationCode,
exm_mp_profqualification.NameOfInstitution AS proNameOfInstitution,
exm_mp_profqualification.QualifiedYear,
exm_mp_profqualification.IsObtained,
exm_mp_profqualification.QualificationName');

        $this->db->from('aauth_users');
        $this->db->join('exm_mp_acadamicq', 'exm_mp_acadamicq.MemberNo = aauth_users.username', 'left');
        $this->db->join('exm_mp_genqualification', 'aauth_users.username = exm_mp_genqualification.MemberNo', 'left');
        $this->db->join('exm_mp_profqualification', 'aauth_users.username = exm_mp_profqualification.MemberNo', 'left');
        $this->db->where('aauth_users.username', $userdetail);
        $query = $this->db->get();
//        log_message('error', $this->db->last_query());
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
            echo json_encode($result);
//            print_r($result);
//            exit;
        } else {
            echo json_encode(FALSE);
        }
    }

    public function load_personal_qualification_profile() {

        $userdetail = $_POST['user_detail'];
        $this->db->select('`exm_sp_acadamicq`.`NameOfInstitution` AS acinstitute,,
exm_sp_acadamicq.Duration AS ac_duration,
exm_sp_acadamicq.InstitutionCode,
exm_sp_acadamicq.Title,
exm_sp_genqualification.NameOfInstitution AS geninstitute,
exm_sp_genqualification.Duration AS gen_duration,
exm_sp_genqualification.Grade,
exm_sp_genqualification.MediumOfStudy,
exm_sp_genqualification.NameOfQualification,
exm_sp_genqualification.IndexNo,
exm_sp_profqualification.NameOfInstitution AS proinstitute,
exm_sp_profqualification.QualifiedYear,
exm_sp_profqualification.QualificationName');
        $this->db->from('aauth_users');
        $this->db->join('exm_sp_acadamicq', 'aauth_users.username = exm_sp_acadamicq.ICASLNo', 'left');
        $this->db->join('exm_sp_genqualification', 'exm_sp_genqualification.ICASLNo = aauth_users.username', 'left');
        $this->db->join('exm_sp_profqualification', 'exm_sp_profqualification.ICASLNo = aauth_users.username', 'left');
        $this->db->where('aauth_users.username', $userdetail);
        $query = $this->db->get();
//        log_message('error', $this->db->last_query());
        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
            echo json_encode($result);
//            print_r($result);
//            exit;
        } else {
            echo json_encode(FALSE);
        }
    }

}
