<?php

/**
 * Created by PhpStorm.
 * User: Pol
 * Date: 14/12/15
 * Time: 17:31
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class verificacio extends CI_Model{
    function __construct() {
        $this->load->database();
    }
    public function closeBd($mysqli){
        $mysqli=null;
    }

    public function getusuaris() {
        $this->db->query("SET NAMES 'utf8'");
        $query = "select * from personal";
        $resultat = $this->db->query($query);
        $a = array();
        $row_cnt = $resultat->num_rows();
        if($row_cnt==0){
            return 0;
        }
        else{
            foreach($resultat->result_array() as $row){
                $a[] = $row;
            }
        }
        $this->closeBd($this->db);
        return $a;
    }

    public function comprovar($usuari,$clau){
		
		$query = $this->db->get_where('Usuaris', array('NomUsuari' => $usuari,'Contrasenya' => $clau));
		
        $a = array();
        $row_cnt = $query->num_rows();
        if($row_cnt==0){
            return 0;
        }
        else{
            foreach($query->result_array() as $row){
                $a[] = $row;
            }
        }
        $this->closeBd($this->db);
        return $a;
    }
	
	
	 public function getclientsusuari($codusuari){
		
		$sql = "select * from UsuarisEmpreses ue where CodiUsuari = ? group BY permis";
		$query = $this->db->query($sql,array($codusuari));
		
		
		
        $a = array();
        $row_cnt = $query->num_rows();
        if($row_cnt==0){
            return 0;
        }
        else{
            foreach($query->result_array() as $row){
                $a[] = $row;
            }
        }
        $this->closeBd($this->db);
        return $a;
    }
	
}
