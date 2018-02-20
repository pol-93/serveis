<?php

/**
 * Created by PhpStorm.
 * User: Pol
 * Date: 14/12/15
 * Time: 17:31
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class registrelogs extends CI_Model{
    function __construct() {
        $this->load->database();
    }
    public function closeBd($mysqli){
        $mysqli=null;
    }

    public function afegirregistre($fitxanum,$missatge,$nomuser,$ip){
        $this->db->query("SET NAMES 'utf8'");
        $data = array(
            'codi_fitxa' => $fitxanum,
            'missatge' => $missatge,
            'nomusuari' => $nomuser,
            'ip' => $ip,
        );
        $this->db->insert('logs',$data);
        $this->closeBd($this->db);
    }
}
