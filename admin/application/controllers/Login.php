<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct()
    {

        parent::__construct();
//        $this->load->helper('web_service_config_helper');
//        echo 'ssadada';
//        exit;
        $this->load->model('User_dashboard_model');
        $this->load->library('aauth');
    }

    public function index()
    {

        $is_logged = $this->aauth->is_loggedin();
//        print_r($is_logged);
//exit;
        if ($is_logged) {

            $err_arr = $this->session->flashdata('errors');
            if (count($err_arr) > 0) {

                $this->session->set_flashdata('errors', $err_arr);
            }

            redirect('user_dashboard');
        }
      
        $data['title'] = 'Login';
        $data['body_class'] = 'login-body';
        $data['styles'] = array();
        $data['scripts'] = array("assets/app_js/login.js");
        $data['remove_footer'] = true;

        $this->load->view('template/header', $data);
        $this->load->view('login', $data);
        $this->load->view('template/footer', $data);
    }

    public function user_login()
    {
        $this->load->library('form_validation');

        $flag = FALSE;

        if (isset($_POST['btn_save'])) {
            $this->form_validation->set_rules('u_name', 'User Name', 'trim|required');
            $this->form_validation->set_rules('password', 'User Group', 'required');
//            $this->form_validation->set_rules('captcha', 'Email Address', 'trim|required');


            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('login_err', true);
                $this->session->set_flashdata('login_message', 'Please enter the user name, password and captcha');
                redirect('login');
            }
// Form fields are ok
//run captcha verification
            $captcha_sess = $this->session->login_captcha;
            $captcha_entered = $this->input->post('captcha');
            if (empty($captcha_sess) || strtolower($captcha_sess) != strtolower($captcha_entered)) {
                $this->session->set_flashdata('login_err', true);
                $this->session->set_flashdata('login_message', "Incorrect captcha");
                redirect('login');
            }

// perform login
// NOTE: user session data created on User_dashboard controller
            $is_logged = $this->aauth->login($this->input->post('u_name'), $this->input->post('password'), FALSE);
            if ($is_logged) {
                //redirect('user_dashboard');
				redirect('Shedule');
            } else {
                $err_arr = $this->aauth->get_errors_array();
                $str_err = implode(',', $err_arr);
                $this->session->set_flashdata('login_err', true);
                $this->session->set_flashdata('login_message', $str_err);
                redirect('login');
            }
        } else {
            redirect('login');
        }
    }

    public function user_logout()
    {
        $this->aauth->logout();
        redirect('login');
    }

    public function generateCaptcha()
    {
//        echo 'sdfsdfdsfsdfds';
//        exit;
        try {

            $string = '';

            $char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4));

// Concatenate the random string onto the random numbers
// The font 'Anorexia' doesn't have a character for '8', so the numbers will only go up to 7
// '0' is left out to avoid confusion with 'O'
            $string = rand(1, 7) . rand(1, 7) . $char;
//            $captcha_base_img = ;

            $image = imagecreatefrompng('assets/images/captcha_back.png'); //returns an image identifier representing a black image of the specified size(w,h).

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

//            print_r($img_settext);
// ( resource $image , float $fontsize , float $rotateangle , int $x , int $y , int $color , string $fontfile , string $text )
            $this->session->login_captcha = $string;
            header("Content-type: image/png");
            imagepng($image);
        } catch (Exception $exc) {
            die($exc->getMessage());
        }
    }

}
