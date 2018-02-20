<?php

/**
 * Created by PhpStorm.
 * User: Pol
 * Date: 14/12/15
 * Time: 17:31
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class fitxar extends CI_Model{
    function __construct() {
        $this->load->database();
    }
    public function closeBd($mysqli){
        $mysqli=null;
    }

    public function fitxarTreballador($data) {
		$this->db->insert('Personal_Fitxatges', $data); 
    }

}
