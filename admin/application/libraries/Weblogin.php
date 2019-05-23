<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Aauth is a User Authorization Library for sampath wijesinghe
  custom login script
 */
class Weblogin {

    public function logout() {

        $cookie = array(
            'name' => 'user',
            'value' => '',
            'expire' => -3600,
            'path' => '/',
        );
        $this->CI->input->set_cookie($cookie);

        return $this->CI->session->sess_destroy();
    }

    public function is_loggedin_ok() {

        if ($this->CI->session->userdata('loggedin')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
