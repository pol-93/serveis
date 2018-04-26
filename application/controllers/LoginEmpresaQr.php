<?php

/**
 * Created by PhpStorm.
 * User: Pol
 * Date: 14/12/15
 * Time: 17:31
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class LoginEmpresaQr extends CI_Controller{
    
	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	//https://serveis.auriagrup.cat/index.php/LoginEmpresaQr/Index/1/107/parc del xipreret/
	// url --> https://serveis.auriagrup.cat/entradaqr/1/107/parc del xipreret/
	
	public function index($idempresa=null,$codiClient=null,$emplaçament=null,$codiusuari=null,$nomusuari=null)
	{	
		if(isset($_SESSION["loguejat"]) && isset($_SESSION["CodiUsuari"]) && isset($_SESSION["NomUsuari"]) && isset($_SESSION["dniusuari"])){
			 //estic en sessio
			 $this->load->model('comunicats');
			 $dataactual = new DateTime();
			 $dataactualYMD = new DateTime();
			 $dataactual = $dataactual->format('d-m-Y');
			 $dataactualYMD = $dataactualYMD->format('Y-m-d');
			 if($idempresa==null && $codiClient==null && $emplaçament==null){
					$parte = $this->comunicats->getComunicatQr($_SESSION["codiclient"],$_SESSION['emplaçament'],$_SESSION['empreses'],$_SESSION['dniusuari'],$dataactualYMD);
					unset($_SESSION["QrCode"]);
					if($parte=="noregistres"){
						$this->carregarEmplacamentsValids($this->comunicats->emplacamentsavui($_SESSION["dniusuari"],$dataactualYMD));
					}
					else{
						redirect('/Entrada/operacionsambfotos/'.$parte[0][8].'/'.$parte[0][5].'/'.$dataactual.'/'.$parte[0][16].'/'.$parte[0][2].'/'.$parte[0][11].'/'.$parte[0][12].'/'.$parte[0][13].'/'.$parte[0][14].'/'.$parte[0][0], 'refresh');
					}
			 }else{
				$emplaçament =  urldecode(str_replace("%20", " ", $emplaçament));
				$parte = $this->comunicats->getComunicatQr($codiClient,$emplaçament,$idempresa,$_SESSION["dniusuari"],$dataactualYMD);
				unset($_SESSION["QrCode"]);
				if($parte=="noregistres"){
					$this->carregarEmplacamentsValids($this->comunicats->emplacamentsavui($_SESSION["dniusuari"],$dataactualYMD));
				}
				else{
					redirect('/Entrada/operacionsambfotos/'.$parte[0][8].'/'.$parte[0][5].'/'.$dataactual.'/'.$parte[0][16].'/'.$parte[0][2].'/'.$parte[0][11].'/'.$parte[0][12].'/'.$parte[0][13].'/'.$parte[0][14].'/'.$parte[0][0], 'refresh');
				}
			 }
		}else{
			$_SESSION["loguejat"] = "SI";
			$_SESSION['CodiUsuari'] = $codiusuari; 
			$nomusuari =  urldecode(str_replace("%20", " ", $nomusuari));
			$_SESSION['NomUsuari'] = $nomusuari;
			$_SESSION['permis'] = "partes";				
			$_SESSION['empreses'] = $idempresa;
			$_SESSION['codiclient'] = $codiClient;
			$emplaçament =  urldecode(str_replace("%20", " ", $emplaçament));
			$_SESSION['emplaçament'] = $emplaçament;
			$_SESSION["QrCode"] = "si";
			redirect('/LoginEmpresa/Index', 'refresh');
		}
			if($idempresa!='' || $idempresa!=null || $codiClient!='' || $codiClient!=null || $emplaçament!='' || $emplaçament!=null || $codiusuari!='' || $codiusuari!=null || $nomusuari!='' || $nomusuari!=null){
					
			}
			else{
				if(isset($_SESSION['dniusuari'])){
					$this->load->model("comunicats");
					unset($_SESSION["QrCode"]);
					echo $_SESSION["loguejat"];
					echo "<br>";
					echo "Id empresa" . $_SESSION['empreses'];
					echo "<br>";
					echo "Codi Client" . $_SESSION['codiclient'];

					echo "<br>";
					echo "Emplaçament" . $_SESSION['emplaçament'];
					echo "<br>";
					
					$this->load->model("comunicats");
					
					$dataactual = new DateTime();
					$dataactual = $dataactual->format('d-m-Y');
					
					$parte = $this->comunicats->getComunicatQr($_SESSION["codiclient"],$_SESSION['emplaçament'],$_SESSION['empreses'],$_SESSION['dniusuari']);
					
					unset($_SESSION["QrCode"]);
					
					redirect('/Entrada/operacionsambfotos/'.$parte[0][8].'/'.$parte[0][5].'/'.$dataactual.'/'.$parte[0][16].'/'.$parte[0][2].'/'.$parte[0][11].'/'.$parte[0][12].'/'.$parte[0][13].'/'.$parte[0][14].'/'.$parte[0][0], 'refresh');
					
				}else{
					redirect('/LoginEmpresa/Index', 'refresh');
				}
		}
		
	}
	
	public function mostrarparte(){
		$this->load->model("comunicats");
		$dataactual = new DateTime();
		$dataactualYMD = new DateTime();
		$dataactual = $dataactual->format('d-m-Y');
		$dataactualYMD = $dataactualYMD->format('Y-m-d');	
		
		if(!isset($_SESSION["codiclient"])){
			$_SESSION["codiclient"] = $_POST["CodiClient"];
		}
		$parte = $this->comunicats->getComunicatQr($_POST["CodiClient"],$_POST["valor"],$_SESSION['empreses'],$_SESSION['dniusuari'],$dataactualYMD);
	
		redirect('/Entrada/operacionsambfotos/'.$parte[0][8].'/'.$parte[0][5].'/'.$dataactual.'/'.$parte[0][16].'/'.$parte[0][2].'/'.$parte[0][11].'/'.$parte[0][12].'/'.$parte[0][13].'/'.$parte[0][14].'/'.$parte[0][0], 'refresh');
	}
	

	public function carregarEmplacamentsValids($info = null){		
		if(isset($_SESSION["loguejat"]) && isset($_SESSION["CodiUsuari"]) && isset($_SESSION["NomUsuari"]) && isset($_SESSION["dniusuari"])){
			$this->load->model("comunicats");
			$dataactualYMD = new DateTime();
			$dataactualYMD = $dataactualYMD->format('Y-m-d');	
			if($info == null){
				$info = $this->comunicats->emplacamentsavui($_SESSION["empreses"],$_SESSION["dniusuari"],$dataactualYMD);
			}
			$data = array(
				'emplacaments' => $info
			);
			
			
			$this->load->view("templates/header.php");
			$this->load->view('emplacaments',$data);
		}else{
			redirect('/IndexController/Index', 'refresh');
		}
	}
	
	
}
