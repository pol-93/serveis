<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class veuresession {

    public function mirarsessio()
    {

        $CI =& get_instance();

        $CI->load->library('session');

        if ($CI->session->userdata('email') == null) {
            header("location: " . site_url("LoginController/index") . "");
        }
    }


}

?>