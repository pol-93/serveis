<?php

/**
 * Created by PhpStorm.
 * User: Pol
 * Date: 14/12/15
 * Time: 17:31
 */
 
include('assets/phpmailer/PHPMailerAutoload.php');

defined('BASEPATH') OR exit('No direct script access allowed');

class Consultes extends CI_Controller{
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		//echo $this->session->flashdata('loguejat');
		//echo $this->session->flashdata('CodiUsuari');
		//echo $this->session->flashdata('NomUsuari');
		//echo $this->session->userdata('permis');
		//exit;
		if(!isset($_SESSION["loguejat"]) || !isset($_SESSION['CodiUsuari']) || !isset($_SESSION['NomUsuari']) || (strpos($_SESSION['permis'], 'demandes') === false && strpos($_SESSION['permis'], 'consultes_fitxatges') === false && strpos($_SESSION['permis'], 'consultes') === false)){
			 redirect('/IndexController/Index', 'refresh');
		}
		
	}

	public function index()
	{	
		$this->load->model("Dades");
		$codiusuari = $_SESSION['CodiUsuari'];
		$data = array(
			//'clients' => $this->Dades->getClients($codiusuari),
			'desti' => $this->Dades->getDesti($codiusuari)
		);
		$this->load->view("templates/header.php");
		$this->load->view('consulta',$data);
	}
	
	public function obtenirclients(){
		$this->load->model("Dades");
		$CodiEmpresa = $_POST["CodiEmpresa"];
		$codiusuari = $_SESSION['CodiUsuari'];
		$clients = $this->Dades->getClients($CodiEmpresa,$codiusuari);
		echo json_encode($clients);		
	}
	
	public function obtenircomunicats(){
		$this->load->model("Dades");
		$datainici = $_POST['datainici'];
		$datafi = $_POST['datafi'];
		$codiEmpresa = $_POST['codiEmpresa'];
		$codiClient = $_POST['codiClient'];
		$datainici = date("Y-m-d", strtotime($datainici));
		$datafi = date("Y-m-d", strtotime($datafi));		
		$comunicats = $this->Dades->getComunicats($_SESSION['CodiUsuari'],$codiEmpresa,$codiClient,$datainici,$datafi);
		echo $comunicats;
	}
	
	public function getfotossensedata(){
		$this->load->model("Dades");
		
	//<button data-codemp="8" data-exercici="2016" data-serie="O" data-numcom="1016" data-codiseccio="0051" data-codiparte="10" onclick="getfotos(this)" type="button" class="btn btn-default">veure fotos</button>
		
		
		$comcodiempresa = $_POST["comcodiempresa"];
		$comexercici = $_POST["comexercici"];
		$comserie = $_POST["comserie"];
		$comnumerocomanda = $_POST["comnumerocomanda"];
		$comcodiseccio = $_POST["comcodiseccio"];
		$comcodicomunicat = $_POST["comcodicomunicat"];
		
		
		
		
		$fotoscom = $this->Dades->getfotoscom($comcodiempresa,$comexercici,$comserie,$comnumerocomanda,$comcodiseccio,$comcodicomunicat);
		
		echo $fotoscom;
	}
	
	public function enviamentDemanda(){
		
	 $codiusuari = $_SESSION["CodiUsuari"];
	 $empreses = $_SESSION['empreses'];
	 $clientcod = $_SESSION['clientCod'];
	 

	  $this->load->model("Dades");
	
	 $imatgestotals = $_POST["imatgestotals"];

	 $arxius = array();
	
		
	 $lloc = $_POST["lloc"];
	 $descripcio = $_POST["descripcio"];
	 $client = $_POST["client"];
	 $desti = $_POST["desti"];	
	 $estat = "No iniciat";	

		
	  $id = $this->Dades->getId($client,$desti);
	  $id = $id+1;
	
	 $fechaactual = getdate();
	 $ladata = "$fechaactual[year]-$fechaactual[mon]-$fechaactual[mday]";

	
	
    $this->Dades->crearDemanda($id,$lloc,$descripcio,$codiusuari,$client,$desti,$estat,$ladata,$_SESSION['NomRealUsuari']);
	
	
	
	if($imatgestotals!=0){
		 for($i=0;$i<$imatgestotals;$i++){
			 $arxius[$i][0] = file_get_contents($_FILES['imatge'.$i.'']['tmp_name']);
			 $arxius[$i][1] = $_FILES['imatge'.$i.'']['type'];
			 $arxius[$i][2] = $_FILES['imatge'.$i.'']['name'];		
		 }
		 $this->Dades->arxiusDemanda($arxius,$client,$desti,$id);
	}
	 $correus = $this->Dades->Seleccionarcorreus($client,$desti);
	 $this->correu($correus,$arxius,$lloc,$descripcio,$client,$desti,$ladata,$id);
	}
	
	public function obtenirdemandes(){
		$this->load->model("Dades");
		$client = $_POST["client"];
		$empresa = $_POST["empresa"];
		//$client = 1040;
		//$empresa = 8; 
		$demandes = $this->Dades->getDemandes($empresa,$client);
		echo $demandes;
	}
	
	public function borrarDemanda(){

		$client = $_POST["client"];
		$empresa = $_POST["empresa"];
		
		
		$this->load->model("Dades");

		$id = $_POST["iddemanda"];
		$accio = $_POST["tipus"];
		
		if($accio=="borrar"){
			$this->Dades->borrarDemanda($id,$empresa,$client);
		}
		else{
			$resultat = $this->Dades->editarDemanda($id,$empresa,$client);
			echo $resultat;
		}
	}
	
	public function updatearxiudemanda(){
	$this->load->model("Dades");
	$id = $_POST["iddemanda"];
	 
	$this->Dades->actualitzardemanda($id,$_POST["lloc"],$_POST["descripcio"],$_POST["idclient"], $_POST["idempresa"],$_SESSION['NomRealUsuari']);
			
	 if(isset($_POST["imatgesborradestotals"])){
		 
	  $borrades = $_POST["imatgesborradestotals"];
	  echo $borrades;
	  echo "idclient:" . $_POST["idclient"];
	  echo "idempresa:" . $_POST["idempresa"];
	  $arr = array();
		for($i=0;$i<$borrades;$i++){
			echo "imatge: ";
			echo $_POST['idsimatges'.$i.''];
			$arr[] = $_POST['idsimatges'.$i.''];		
		}
		$this->Dades->borrararxiusdemanda($borrades,$arr,$_POST["idclient"], $_POST["idempresa"]);
	 } 
	 if(isset($_POST["imatgestotals"])){
		 $fotos = $_POST["imatgestotals"];
		 $arxiu = array();
		$tamanytotal = 0;
		 for($i=0;$i<$fotos;$i++){
			 $arxiu[$i][0] = file_get_contents($_FILES['imatge'.$i.'']['tmp_name']);
			 $arxiu[$i][1] = $_FILES['imatge'.$i.'']['type'];
			 $arxiu[$i][2] = $_FILES['imatge'.$i.'']['name'];
		 }
		 $this->Dades->nousarxiusdemanda($id,$arxiu,$fotos,$_POST["idclient"], $_POST["idempresa"]);
	}
	echo "totok";	
	}
	
	
	public function correu($correus,$arxius,$lloc,$descripcio,$client,$desti,$data,$iddemanda){
		$this->load->model("Dades");
		
		$nomclient = $this->Dades->getnomclient($client,$desti);
			for($i=0;$i<count($correus);$i++){
				if($correus[$i][0]!=""){		
					$this->load->model("verificacio");
					
					$mail = new phpmailer(true); // create a new object
					$mail->IsSMTP(); // enable SMTP
					$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
					$mail->Helo = "serveis.auriagrup.cat";
					$mail->SMTPAuth = true; // authentication enabled
					$mail->Port=25;
					$mail->SMTPSecure = 'tls';
					$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
					$mail->Host = "smtp.gmail.com"; //smtp.1and1.es
					$mail->Port = 465; // or 587 465
					$mail->IsHTML(true);
					$mail->Username = "infoserveis@auriagrup.cat";// undealclothing@undealclothing.com
					$mail->Password = "info20ser17veis";
					$email->FromName = "Àuria grup Serveis";
					$mail->SetFrom("infoserveis@auriagrup.cat"); // undealclothing@undealclothing.com
					$mail->setFrom('infoserveis@auriagrup.cat', utf8_decode('Àuria grup Serveis'));
					$mail->Subject = 'Demanda internet amb el codi '.$iddemanda.' s\'ha creat';
					for($k=0;$k<count($arxius);$k++){
						$mail->AddStringAttachment($arxius[$k][0],$arxius[$k][2],'base64',$arxius[$k][1]);
					}
					$mail->Body = '<p>Demanda del client : '.$nomclient.'</p> <p>Remitent : '. $_SESSION["NomRealUsuari"] .' </p> Data demanda: '.$data.' </p><p> Codi demanda:  '.$iddemanda.'</p><p> Lloc:  '.$lloc.' </p> <p> Descripció: '.$descripcio.'</p>';
					$mail->Body = '<h1><b>Nova Demanda Del Client : '.$nomclient.' </b></h1><h2> Remitent : '. $_SESSION["NomRealUsuari"] .' </h2> <h2>Data Demanda: '.$data.'</h2><h2>Codi Demanda: '.$iddemanda.'</h2> <h3>Lloc:  </h3>'.$lloc.' <h3> Descripció: </h3> '.$descripcio;
						$mail->AddAddress($correus[$i][0]);
						if(!$mail->Send())
						{
							echo "hola";
							return "Mailer Error: " . $mail->ErrorInfo;
						}
					}
		}
		
	}
	
	public function obtenirfitxades(){
		 $empreses = $_POST["empresa"];
		 $datainici = $_REQUEST['datainici'];
		 $datafi = $_REQUEST['datafi'];
		 $datainici = date("Y-m-d", strtotime($datainici));
		 $datafi = date("Y-m-d", strtotime($datafi));
	 	 $incidencies = $_POST["incidencies"];
		// $empreses = 8;
		// $datainici = "2017-01-01";
		// $datafi = "2018-07-01";
			
		$this->load->model("Dades");
		$a = array();
		
		$a = $this->Dades->seleccionarfitxatges($empreses,$datainici,$datafi,$incidencies);
		
		$columnes = $this->Dades->seleccioColumnes($empreses,$datainici,$datafi);
		if(count($a)==0) {
			 echo "ok";
			 die;
		 }
			
		if(!empty($a)){
			echo json_encode(array("a" => $a, "b" => $columnes));

			}
		else{
				echo "XD";
			}
		}
		
		public function Descarregararxiu($idarx,$tipus){
			$this->load->model("Dades");
		
			
			$dades = $this->Dades->getarxiu($idarx,$tipus);
			//$dades[0];
			//$dades[1];
			
			//header("Content-Type: $dades[0]");
			header('Content-Disposition: attachment; filename='.$dades[1].'');
			echo $dades[2];

			
		}
	
}
