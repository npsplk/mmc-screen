<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->helper('master_data');
    }

    public function index() {

//        $this->load->model('admin_model');
//        $data['title'] = 'Administrative Login';
//        $data['scripts'] = array("assets/app_js/login.js");
//        $this->load->view('template/header', $data);
//        $this->load->view('admin_view', $data);
//
//        $data['remove_footer'] = true;
//        
        $data['title'] = ' Administration Login';
        $data['body_class'] = 'login-body';
        $data['styles'] = array();
        $data['scripts'] = array("assets/app_js/login.js");
        $data['remove_footer'] = true;
//        $data['test'] = $this->testClient();
//        $data['test'] = $this->codegen();
//        $data['tesst'] = $this->get_user_and_pass();
//        $data['tessti'] = $this->GetMemberProfile();
        $this->load->view('template/header', $data);
        $this->load->view('admin_view', $data);
        $this->load->view('template/footer', $data);
//        $this->load->library('email');
    }

    public function admin_login() {
//      print_r($_POST) ;
        $this->load->library('form_validation');
        $login_attemp = $this->aauth->get_login_attempts();
        if ($login_attemp > 3) {
            $this->sendMail();
        }
        $flag = FALSE;

        if (isset($_POST['admin_save'])) {
            $this->form_validation->set_rules('ad_user_name', 'Username', 'required');
            $this->form_validation->set_rules('ad_password', 'Password', 'required', array('required' => 'You must provide a %s.'));
            $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('admin_login_err', true);
                $this->session->set_flashdata('admin_login_message', 'Please enter the user name, password and captcha');
                redirect(site_url("administrator/admin_login"));
            }


            // Form fields are ok
//run captcha verification
            $captcha_sess = $this->session->login_captcha_admin;
            $captcha_entered = $this->input->post('captcha');
            if (empty($captcha_sess) || strtolower($captcha_sess) != strtolower($captcha_entered)) {
                $this->session->set_flashdata('admin_login_err', true);
                $this->session->set_flashdata('admin_login_message', "Incorrect captcha");
                redirect(site_url("administrator/admin_login"));
            }
// perform login
// NOTE: user session data created on User_dashboard controller

            $user_name = $this->input->post('ad_user_name');
            $upassword = $this->input->post('ad_password');

            $admin_login = $this->aauth->login($user_name, $upassword, $remember = FALSE, $totp_code = NULL);

            if ($admin_login) {
                $admin = $this->aauth->is_admin();
                $admin = $this->aauth->is_allowed($perm_par, $user_id = false);
                if ($admin) {
                    redirect(site_url("administrator/admin_dash_c"));
                } else {
                    $this->session->set_flashdata('admin_login_err', true);
                    $this->session->set_flashdata('admin_login_message', 'You are not a admin !');
                    redirect(site_url("administrator/admin_login"));
                }
            } else {
                $this->session->set_flashdata('admin_login_err', true);
                $this->session->set_flashdata('admin_login_message', 'Please enter correct user name and password');
                redirect(site_url("administrator/admin_login"));
            }
        } else {
            redirect(site_url("administrator/admin_login"));
        }
    }

    public function generateCaptcha_admin() {

        try {

            $string = '';

            $char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4));

// Concatenate the random string onto the random numbers
// The font 'Anorexia' doesn't have a character for '8', so the numbers will only go up to 7
// '0' is left out to avoid confusion with 'O'
            $string = rand(1, 7) . rand(1, 7) . $char;
            $captcha_base_img = base_url("assets/images/captcha_back.png");
            $image = imagecreatefrompng($captcha_base_img); //returns an image identifier representing a black image of the specified size(w,h).
            if ($image === FALSE) {
                die("imagecreatefrompng");
            }

            $colour = imagecolorallocate($image, 73, 139, 244);

            if ($colour === false) {
                die("imagecolorallocate text");
            }

            $white = imagecolorallocate($image, 255, 255, 255); // background color white
            if ($white === false) {
                die("imagecolorallocate backgr");
            }
            $this->load->helper('path');
            $font = set_realpath("assets/fonts/111anorexia.ttf", FALSE);
//            $font = "/var/www/html/2017/gov/naqda/assets/fonts/111anorexia.ttf";
            $rotate = rand(0, 0);

// Create an image using our original image and adding the detail

            $img_settext = imagettftext($image, 16, $rotate, 18, 30, $colour, $font, $string); //Write text to the image using TrueType fonts
            if ($img_settext === false) {
                die("imagettftext:: " . $font);
            }

// ( resource $image , float $fontsize , float $rotateangle , int $x , int $y , int $color , string $fontfile , string $text )
            $this->session->login_captcha_admin = $string;
            header("Content-type: image/png");
            imagepng($image);
        } catch (Exception $exc) {
            die($exc->getMessage());
        }
    }

    public function admin_user_logout() {
        $this->aauth->logout();
        redirect(site_url("administrator/admin_login"));
//        session_write_close();
    }

    function sendMail() {
        echo HOST_MAIL;
        echo SENDER_EMAIL;
        echo SENDER_PASS;
        exit;
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => HOST_MAIL,
            'smtp_user' => SENDER_EMAIL, // change it to yours
            'smtp_pass' => SENDER_PASS, // change it to yours
            'smtp_port' => '25'
//            'protocol' => 'smtp',
//            'smtp_host' => 'ssl://smtp.googlemail.com',
//            'smtp_user' => '.com', // change it to yours
//            'smtp_pass' => 'pass', // change it to yours
//            'smtp_port' => '465'
//            'mailtype' => 'html',
//            'charset' => 'iso-8859-1',
//            'wordwrap' => TRUE
        );
        $ip = $this->input->ip_address();
        $message = 'some one trying to log in to the system. ip address - ' . $ip . '';
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('sampathw@pooranee.lk'); // change it to yours
        $this->email->to(SYSTEM_ADMINS_EMAIL); // change it to yours
        $this->email->subject('security alert');
        $this->email->message($message);
        if ($this->email->send()) {
            $this->session->set_flashdata('admin_login_err', true);
            $this->session->set_flashdata('admin_login_message', 'Exceed your login attempts, Security email sent to the system administer.');
            redirect(site_url("administrator/admin_login"));
        } else {
            redirect(site_url("administrator/admin_login"));
        }
    }

}
