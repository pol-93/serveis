<?php

/**
 * Created by PhpStorm.
 * User: Pol
 * Date: 14/12/15
 * Time: 17:31
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class LoginEmpresa extends CI_Controller{
    
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		if(!isset($_SESSION["loguejat"]) || !isset($_SESSION['CodiUsuari']) || !isset($_SESSION['NomUsuari']) || (strpos($_SESSION['permis'], 'partes') === false)){
			redirect('/IndexController/Index', 'refresh');
		}
	}

	public function index()
	{	

		$this->load->model("comunicats");
		
		$data = array(
			'treballadors' =>  $this->comunicats->treballadors($_SESSION["empreses"]),
		);
	
		$this->load->view("templates/header.php");
		$this->load->view('Logintreballador',$data);
		
	}
	
	public function validarteaempresa(){
		$this->load->model("comunicats");
		$usuari = $_POST["usuari"];
		$clau = $_POST["clau"];	

		$resultat = $this->comunicats->loginTreballador($usuari,$clau);
		echo $resultat;
		
	}
	
	
}
