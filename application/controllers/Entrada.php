<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entrada extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		if(!isset($_SESSION["loguejat"]) || !isset($_SESSION['CodiUsuari']) || !isset($_SESSION['NomUsuari']) || (strpos($_SESSION['permis'], 'partes') === false)){
			 redirect('/IndexController/Index', 'refresh');
		}
	}

	public function index($diaretorn=null)
	{	
	
	$this->load->model("Comunicats");
	
	$data = array(
		'clients' =>  $this->Comunicats->getClientsTreballador($_SESSION['empreses'],$_SESSION['dniusuari']),
		'diaretorn' => $diaretorn,
	);

	$this->load->view("templates/header.php");
	$this->load->view('comunicatsempleat',$data);

	
	}
		
			
	public function gettasques(){
		
		$this->load->model("Comunicats");
		
		$dia = $_POST['dia'];
		 
		$clientcod = $_POST['codiclient'];
		
		$domicili = $_POST["domicili"];
		
		$antics = $_POST["antics"];

		$dia = date("Y-m-d", strtotime($dia));
		
		$getComunicats = $this->Comunicats->getComunicats($dia,$clientcod,$domicili,$_SESSION["empreses"],$_SESSION["dniusuari"],$antics);

		echo json_encode($getComunicats);
		
	}
	
	public function fitxa(){
		$this->load->model("Fitxar");
		$coords = $_POST["coords"];
		$fechaactual = getdate();
		$ladata = "$fechaactual[year]-$fechaactual[mon]-$fechaactual[mday]";
		$algo = $fechaactual['minutes'];
		if($algo<10){
			$lahora = "$fechaactual[hours]:0$fechaactual[minutes]";
		}
		else{
		$lahora = "$fechaactual[hours]:$fechaactual[minutes]";
		}
		$lector = 'serveis.auriagrup.cat';
		$traspassat = 0;
		
		if($coords!="no"){
			$coords = explode(",", $coords);
				$data = array(
					'CodiFitxa' => $_SESSION["codifitxa"],
					'Data' => $ladata,
					'Hora' => $lahora,
					'Longitud' => $coords[0],
					'Altitud' => $coords[1],
					'Lector' => $lector,
					'Traspassat' => $traspassat
				);
				$this->Fitxar->fitxarTreballador($data);
		}
		else{
			$data = array(
					'CodiFitxa' => $_SESSION["codifitxa"],
					'Data' => $ladata,
					'Hora' => $lahora,
					'Longitud' =>0,
					'Altitud' => 0,
					'Lector' => $lector,
					'Traspassat' => $traspassat
				);
				$this->Fitxar->fitxarTreballador($data);
		}	

		echo "ok";
		}
		
		public function reobrirparte(){
			$this->load->model("Comunicats");
			
			$dataactual = $_POST["dataactual"];
			
			
			$retorn = $this->Comunicats->ReobrirParte($dataactual,$_SESSION['dniusuari']);		
			
			echo $retorn;
			
		}
		
		public function operacionsambfotos($comunicatcod,$comunicatdate,$comunicatdatepiker,$comunicatdpt,$comunicatempresa,$comunicatexercici,$comunicatserie,$comunicatnumerocomanda,$comunicatcodiseccio,$codiemplaçament){
			$this->load->model("Operacions");
			$data = array(
				"registres" => $this->Operacions->getOperacions($_SESSION['dniusuari'],$_SESSION['empreses'],$comunicatdate,$comunicatcod),
				"comunicatcod" => $comunicatcod,
				"datacomunicat" => $comunicatdate,
				"comunicatdatepiker" => $comunicatdatepiker,
				"comunicatdpt" => $comunicatdpt,
				"comunicatemp" => $comunicatempresa,
				"comunicatexercici" => $comunicatexercici,
				"comunicatserie" => $comunicatserie,
				"comunicatnumerocomanda" => $comunicatnumerocomanda,
				"comunicatcodiseccio" => $comunicatcodiseccio,
				//"linies" => $this->Operacions->getLinies($comunicatempresa,$comunicatexercici,$comunicatserie,$comunicatnumerocomanda,$comunicatcodiseccio,$comunicatcod),
				"operacionsempl" => $this->Operacions->getOperacionsEmplaçaments($codiemplaçament,$_SESSION['empreses'],$comunicatdpt)
			);
			
			
			
			$this->load->view("templates/header.php");
			$this->load->view('operacionsempleat',$data);
				
		}
		
		public function hora(){
			$fechaactual = getdate();
			$ladata = "$fechaactual[mday]-$fechaactual[mon]-$fechaactual[year]";
			$algo = $fechaactual["minutes"];
			if($fechaactual["hours"]<10 && $fechaactual["minutes"]<10){
				$lahora = '0'.$fechaactual["hours"].':0'.$fechaactual["minutes"];
			}
			else if($fechaactual['hours']<10 && $fechaactual['minutes']>10){
				$lahora = '0'.$fechaactual["hours"].':'.$fechaactual["minutes"];
			}
			else if($fechaactual['hours']>10 && $fechaactual['minutes']<10){
				$lahora = $fechaactual["hours"].':0'.$fechaactual["minutes"];
			}
			else{
			$lahora = $fechaactual["hours"].':'.$fechaactual["minutes"];
			}
			echo $ladata." ".$lahora;
		}
		
		
		public function getfotos(){
			
			$this->load->model("Operacions");
			$dia = $_POST["dia"];
			$comexercici = $_POST["comexercici"];
			$comserie = $_POST["comserie"];
			$comnumerocomanda = $_POST["comnumerocomanda"];
			$comcodiseccio = $_POST["comcodiseccio"];
			$comcodicomunicat = $_POST["comcodicomunicat"];
			$comcodiempresa = $_POST["comcodiempresa"];
		
			$retorn = $this->Operacions->getimatges($dia,$comexercici,$comserie,$comnumerocomanda,$comcodiseccio,$comcodicomunicat,$comcodiempresa);
			
			echo json_encode($retorn);
		}

		public function enviamentParte(){
			$this->load->model("Operacions");
			
			$codiempresa = $_POST["codiempresa"];
			$codiseccio = $_POST["codiseccio"];
			$codiparte = $_POST["codiparte"];
			$codiserie = $_POST["codiserie"];
			$codinumerocomanda = $_POST["codinumerocomanda"];
			$codiexercici = $_POST["codiexercici"];
			$extensio = $_POST["extensio"];
			$tipusFotos = $_POST["tipusFotos"];
			
			
			if($tipusFotos=='Abans'){
				$arxiu = file_get_contents($_FILES['arxiuFotoAbans']['tmp_name']);
			}
			else{
				$arxiu = file_get_contents($_FILES['arxiuFotoDespres']['tmp_name']);
			}
		
			
			$propera = $this->Operacions->getproperid($codiempresa,$codiexercici,$codiserie,$codinumerocomanda,$codiseccio,$codiparte,$tipusFotos);
			
			$this->Operacions->Insereiximatge($codiempresa,$codiexercici,$codiserie,$codinumerocomanda,$codiseccio,$codiparte,$propera,$tipusFotos,$extensio,$arxiu);
			
			$modificacio = 1;
			
			$this->Operacions->updateDataModificacioComunicat($modificacio,$codiempresa,$codiexercici,$codiserie,$codinumerocomanda,$codiseccio,$codiparte);
	
			$img = $this->Operacions->generaFoto($arxiu);
			
			$arr = array();
			
			$arr[0] = $codiempresa;
			$arr[1] = $codiexercici;
			$arr[2] = $codiserie;
			$arr[3] = $codinumerocomanda;
			$arr[4] = $codiseccio;
			$arr[5] = $codiparte;
			$arr[6] = $propera;
			$arr[7] = $tipusFotos;
			$arr[8] = 'src="data:image/'.$extensio.';base64,'.base64_encode($arxiu).'"';
			
			echo json_encode($arr);
		}
		
		public function borrarfoto(){
			$this->load->model("Operacions");
			$codiempresa = $_POST["codiempresa"];
			$codiexercici = $_POST["codiexercici"];
			$codiserie = $_POST["codiserie"];
			$numcom = $_POST["numcom"];
			$seccio = $_POST["seccio"];
			$parte = $_POST["parte"];
			$tipusfotos = $_POST["tipusfotos"];
			$ordrefotos = $_POST["ordrefotos"];
			$this->Operacions->borrarimatge($codiempresa,$codiexercici,$codiserie,$numcom,$seccio,$parte,$ordrefotos,$tipusfotos);
			
			echo "ok";
		}
		
		public function tancarparte(){
		$this->load->model("Operacions");

		$tancarparte = $_POST['tancarparte'];
		$datausuari = $_POST['datausuari'];
		$empresacod = $_POST['empresacod'];
		$codiseccio = $_POST['codiseccio'];
		$coordenades = $_POST['coords'];
		$serie = $_POST['serie'];
		$numerocomanda = $_POST['numerocomanda'];
		$exercici = $_POST['exercici'];
		$material = $_POST['material'];
		$datatancament = $_POST["datatancament"];
		$detall = $_POST["detall"];

		

		if($coordenades=="no"){
			$coordenades = array("0", "0");
		}

		$coords = explode(",", $coordenades);
	
		$dataavui = new DateTime();
		$dataavui->setTimeZone(new DateTimeZone("Europe/Madrid"));
		$dataavui = $dataavui->format('Y-m-d');
		
		$this->Operacions->tancarparte($datausuari,$dataavui,$datatancament,$coords,$material,$tancarparte,$empresacod,$exercici,$serie,$numerocomanda,$codiseccio,$detall);
			
		}
		
		
		public function actualitzarHoresTasca(){
			$this->load->model("Operacions");
			$this->load->model("Comunicats");
			$horesReals = $_POST["HoresReals"];
			$data = array(
				"CodiEmpresa" => $_POST["codiempresa"],
				"Exercici" => $_POST["codiexercici"],
				"Serie" => $_POST["codiserie"],
				"NumeroComanda" => $_POST["numcom"],
				"CodiSeccio" => $_POST["seccio"],
				"CodiOperacio" => $_POST["codioperacio"],
				"CodiParte" => $_POST["codiparte"],
				"CodiDepartament" => $_POST["codidepartament"],
				"Ordre" => $_POST["codiordre"]
			);
		
			$this->Operacions->updateHoresTasca($data,$horesReals);
			$this->Comunicats->modificat($_POST["codiparte"],$_POST["codiempresa"],$_POST["codiexercici"],$_POST["codiserie"],$_POST["seccio"],$_POST["numcom"]);
			echo var_dump($data);
		}
		
		public function borraroperaciolinia(){
			$this->load->model("Operacions");
			$this->load->model("Comunicats");
			$data = array(
				"CodiEmpresa" => $_POST["codiempresa"],
				"Exercici" => $_POST["codiexercici"],
				"Serie" => $_POST["codiserie"],
				"NumeroComanda" => $_POST["numcom"],
				"CodiSeccio" => $_POST["seccio"],
				"CodiOperacio" => $_POST["codioperacio"],
				"CodiParte" => $_POST["codiparte"],
				"CodiDepartament" => $_POST["codidepartament"],
				"Ordre" => $_POST["codiordre"]
			);
		
			$this->Operacions->borrarOperacioLinia($data);
			$this->Comunicats->modificat($_POST["codiparte"],$_POST["codiempresa"],$_POST["codiexercici"],$_POST["codiserie"],$_POST["seccio"],$_POST["numcom"]);
			echo var_dump($data);
		}	
		
		public function afegirliniaoperacio(){
			$this->load->model("Operacions");
			$this->load->model("Comunicats");
			
			
			$dia = $_POST['dia'];

			$dia = date("Y-m-d", strtotime($dia));

			$data = array(
				"CodiEmpresa" => $_POST["codiempresa"],
				"Exercici" => $_POST["codiexercici"],
				"Serie" => $_POST["codiserie"],
				"NumeroComanda" => $_POST["numcom"],
				"CodiSeccio" => $_POST["seccio"],
				"CodiOperacio" => $_POST["codioperacio"],
				"CodiParte" => $_POST["codiparte"],
				"CodiDepartament" => $_POST["codidepartament"],
				"Ordre" => $_POST["codiordre"],
				"HoresReals" => $_POST["HoresReals"],
				"HoresPlanificades" => 0,
				"Data" => $dia,
				"HoraInici" => "00:00",
				"Carrec" => $_POST["Carrec"]
			);
			
			$ordre = $this->Operacions->getautonumeric($data);
			
			$data['Ordre']=$ordre;
		
			 $this->Operacions->afagirliniaop($data);
			 
			 $this->Comunicats->modificat($_POST["codiparte"],$_POST["codiempresa"],$_POST["codiexercici"],$_POST["codiserie"],$_POST["seccio"],$_POST["numcom"]);
			 
			 echo $ordre;
		
		}
		
}
