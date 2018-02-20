<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexController extends CI_Controller {

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
	}

	public function index()
	{	
		$this->load->view("templates/header.php");
		$this->load->view('Index');
	}
	
	
	public function validar(){
		$this->load->model("Verificacio");
		$registres = $this->Verificacio->comprovar($_POST['usuari'],$_POST['clau']);
		if($registres==0){
			$arr = array("vrf"=>"","codi"=>"Autenticació fallida!");
			echo json_encode($arr);
			redirect('/IndexController/Index', 'refresh');
		}
		else{
			// $this->session->set_flashdata('loguejat', 'SI');
			// $this->session->set_flashdata('CodiUsuari', $registres[0]['CodiUsuari']);
			// $this->session->set_flashdata('NomUsuari', $registres[0]['NomUsuari']);
			// $this->session->set_flashdata('NomRealUsuari', $registres[0]['Nom']);
			$_SESSION['loguejat']="SI";
			$_SESSION['CodiUsuari']=$registres[0]['CodiUsuari'];
			$_SESSION['NomUsuari']=$registres[0]['NomUsuari'];
			$_SESSION['NomRealUsuari']=$registres[0]['Nom'];
			
			
			
			
			$resultat = $this->Verificacio->getclientsusuari($_SESSION['CodiUsuari']);
			$i=0;
				foreach($resultat as $r) {
				if($i==0){
					// $this->session->set_flashdata('empreses', $r['CodiEmpresa']);
					// $this->session->set_flashdata('clientCod', $r['CodiClient']);
					// $this->session->set_flashdata('permis', $r['permis']);
					$_SESSION['empreses'] = $r['CodiEmpresa'];
					$_SESSION['clientCod'] = $r['CodiClient'];
					$_SESSION['permis'] = $r['permis'];
					$i++;
					}
					else{
						if($_SESSION['empreses']!=$r['CodiEmpresa']){
							$_SESSION['empreses'] .= $_SESSION['permis'].','.$r['empreses'];
						}
						if($_SESSION['clientCod']!=$r['CodiClient']){
							$_SESSION['clientCod'] .= $_SESSION['permis'].','.$r['CodiClient'];
						}
						if($_SESSION['permis']!=$r['permis']){
							$_SESSION['permis'] .= ','.$r['permis'];
						}
					}
				}
				if (strpos($_SESSION['permis'], 'fitxatges') !== false || strpos($_SESSION['permis'], 'demandes') !== false || strpos($_SESSION['permis'], 'consultes') !== false) {
					// echo $this->session->userdata('loguejat');
					// echo $this->session->userdata('CodiUsuari');
					// echo $this->session->userdata('NomUsuari');
					// echo $this->session->userdata('permis');
					// exit;
					//redirect('Consultes/Index');
					header('Location: '.site_url("Consultes/Index"));
					exit;
				}
				
				
				if($_SESSION['permis']=="partes"){
					 redirect('/LoginEmpresa/Index', 'refresh');
				}
				else if($_SESSION['permis']=="" || $_SESSION['permis']==null){
					redirect('/IndexController/Index', 'refresh');
				}
				
			}
	}

	public function deletesessions(){
		session_destroy();
		redirect('/IndexController/Index', 'refresh');
	}
	
}
