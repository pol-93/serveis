<?php

/**
 * Created by PhpStorm.
 * User: Pol
 * Date: 14/12/15
 * Time: 17:31
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Operacions extends CI_Model{
    function __construct() {
        $this->load->database();
    }
    public function closeBd($mysqli){
        $mysqli=null;
    }

    public function getOperacions($dniusuari,$empreses,$dia,$codicomunicat){
        if ($dia!=NULL){
			$sql="SELECT oc.Materials, oc.Detalls, oc.Equip, oc.Domicili, oc.CodiDepartament, oc.Exercici,oc.Serie, oc.NumeroComanda,oc.CodiSeccio, e.CodiEmplaçament, 
				e.CodiClient, e.CodiEmpresa, e.NomEmplaçament,	e.Imatge, oc.Data, oc.CodiParte, oclo.CodiOperacio, op.NomOperacio, op.Imatge imatgeoperacio, 
				 oclo.Ordre, oclo.Data, oclo.Carrec, oclo.HoraInici, oclo.HoresReals, oclo.HoresPlanificades
			FROM Emplaçaments e INNER JOIN OrdresFabricacio_Comunicats oc ON 
				(oc.CodiEmpresa = e.CodiEmpresa AND oc.CodiEmplaçament = e.CodiEmplaçament AND oc.CodiClient = e.CodiClient)
				INNER JOIN OrdresFabricacio_Comunicats_Treballadors ot ON (ot.CodiEmpresa = oc.CodiEmpresa AND ot.Exercici = oc.Exercici 
				AND ot.Serie = oc.Serie
				AND ot.NumeroComanda = oc.NumeroComanda
				AND ot.CodiSeccio = oc.CodiSeccio
				AND ot.CodiParte = oc.CodiParte)
				INNER JOIN OrdresFabricacio_Comunicats_Operacions_Linies oclo ON (oclo.CodiEmpresa = oc.CodiEmpresa
				AND oclo.Exercici = oc.Exercici AND oclo.Serie = oc.Serie AND oclo.Serie = oc.Serie
				AND oclo.NumeroComanda = oc.NumeroComanda AND oclo.CodiSeccio = oc.CodiSeccio AND oclo.CodiParte = oc.CodiParte
				AND oclo.CodiDepartament = oc.CodiDepartament)
				INNER JOIN Operacions op ON (oclo.CodiOperacio = op.CodiOperacio AND oclo.CodiEmpresa = op.CodiEmpresa
				AND oclo.CodiDepartament = oc.CodiDepartament)						
			where ot.DNI=? and op.CodiEmpresa=? and oc.Data=? and oc.DataTancament is NULL and oc.CodiParte=?";
			$resultat = $this->db->query($sql,array($dniusuari,$empreses,$dia,$codicomunicat));
		}else{
				$sql="SELECT oc.Materials, oc.Detalls, oc.Equip, oc.Domicili, oc.CodiDepartament, oc.Exercici,oc.Serie, oc.NumeroComanda,oc.CodiSeccio, e.CodiEmplaçament, 
				e.CodiClient, e.CodiEmpresa, e.NomEmplaçament,	e.Imatge, oc.Data, oc.CodiParte, oclo.CodiOperacio, op.NomOperacio, op.Imatge imatgeoperacio, 
				 oclo.Ordre, oclo.Data, oclo.Carrec, oclo.HoraInici, oclo.HoresReals, oclo.HoresPlanificades
				FROM Emplaçaments e INNER JOIN OrdresFabricacio_Comunicats oc ON 
				(oc.CodiEmpresa = e.CodiEmpresa AND oc.CodiEmplaçament = e.CodiEmplaçament AND oc.CodiClient = e.CodiClient)
				INNER JOIN OrdresFabricacio_Comunicats_Treballadors ot ON (ot.CodiEmpresa = oc.CodiEmpresa AND ot.Exercici = oc.Exercici 
				AND ot.Serie = oc.Serie
				AND ot.NumeroComanda = oc.NumeroComanda
				AND ot.CodiSeccio = oc.CodiSeccio
				AND ot.CodiParte = oc.CodiParte)
				INNER JOIN OrdresFabricacio_Comunicats_Operacions_Linies oclo ON (oclo.CodiEmpresa = oc.CodiEmpresa
				AND oclo.Exercici = oc.Exercici AND oclo.Serie = oc.Serie AND oclo.Serie = oc.Serie
				AND oclo.NumeroComanda = oc.NumeroComanda AND oclo.CodiSeccio = oc.CodiSeccio AND oclo.CodiParte = oc.CodiParte
				AND oclo.CodiDepartament = oc.CodiDepartament)
				INNER JOIN Operacions op ON (oclo.CodiOperacio = op.CodiOperacio AND oclo.CodiEmpresa = op.CodiEmpresa
				AND oclo.CodiDepartament = oc.CodiDepartament)
				where et.DNI=? and op.CodiEmpresa=? and oc.Data is NULL and oc.DataTancament is NULL and oc.CodiParte=?";
			$resultat = $this->db->query($sql,array($dniusuari,$empreses,$codicomunicat));
		}
		
			
		$a = array();
		$i=0;
			
		foreach($resultat->result_array() as $r){		
			$a[$i]["Materials"] = $r["Materials"];
			$a[$i]["Detall"] = $r["Detalls"];
			$a[$i]["torn"] = $r["Equip"];
			$a[$i]["Domicili"] = $r["Domicili"];
			$a[$i]["CodiDepartament"] = $r["CodiDepartament"];
			$a[$i]["Exercici"] = $r["Exercici"];
			$a[$i]["Serie"] = $r["Serie"];
			$a[$i]["NumeroComanda"] = $r["NumeroComanda"];
			$a[$i]["CodiSeccio"] = $r["CodiSeccio"];
			$a[$i]["CodiEmplaçament"] = $r["CodiEmplaçament"];
			$a[$i]["CodiClient"] = $r["CodiClient"];
			$a[$i]["CodiEmpresa"] = $r["CodiEmpresa"];
			$a[$i]["NomEmplaçament"] = $r["NomEmplaçament"];
			if($r["Imatge"]!=NULL){
				$a[$i]["Imatge"] = $this->generaFoto($r["imatge"]);
			}
			else{
				$a[$i]["Imatge"] = NULL;
			}
			$a[$i]["Data"] = $r["Data"];
			$a[$i]["CodiParte"] = $r["CodiParte"];
			$a[$i]["CodiOperacio"] = $r["CodiOperacio"];
			$a[$i]["NomOperacio"] = $r["NomOperacio"];
			if($r["imatgeoperacio"] != NULL){
				$a[$i]["imatgeoperacio"] = $this->generaFoto($r["imatgeoperacio"]);
			}else{
				$a[$i]["imatgeoperacio"] = NULL;
			}
			//$a[$i]["fet"] = $r["fet"];
			$a[$i]["Data"] = $r["Data"];
			$a[$i]["Carrec"] = $r["Carrec"];
			$a[$i]["HoraInici"] = $r["HoraInici"];
			$a[$i]["HoresReals"] = $r["HoresReals"];
			$a[$i]["Ordre"] = $r["Ordre"];
			$a[$i]["HoresPlanificades"] = $r["HoresPlanificades"];
			$i++;
		}
		return $a;
    }
	
	public function getOperacionsEmplaçaments($codiemplaçament,$codiempresa,$comunicatdpt){
		$sql="SELECT o.CodiOperacio, o.NomOperacio FROM Operacions o join OperacionsEmplaçament oe on (o.CodiEmpresa=oe.CodiEmpresa and o.CodiDepartament=oe.CodiDepartament and o.CodiOperacio=oe.CodiOperacio) where oe.CodiEmpresa=? and oe.CodiEmplaçament=? and oe.CodiDepartament=?";
		$resultat = $this->db->query($sql,array($codiempresa,$codiemplaçament,$comunicatdpt));
		$a = array();
		$i=0;
			
		foreach($resultat->result_array() as $r){		
			$a[$i]["CodiOperacio"] = $r["CodiOperacio"];
			$a[$i]["NomOperacio"] = $r["NomOperacio"];
			$i++;
		}
		return $a;
	}
	
	public function generaFoto($dadesImatge) {
			$source= imagecreatefromstring($dadesImatge);
			list($width,$height) = getimagesizefromstring($dadesImatge);
			//$newwidth=250; 
			//$newheight=$height/($width/$newwidth);
			$thumb = imagecreatetruecolor($width, $height);
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $width, $height);
			if ($thumb !== false) {
				ob_start();
				imagejpeg($thumb);
				imagedestroy($thumb);
				imagedestroy($source);
				$thumb = ob_get_clean();
				return $thumb;
			}
			else {
				return 'NO';

			}	
		}
		
	public function canviestattasques($codiparte,$codioperacio,$codiempresa,$exercici,$serie,$codiSeccio,$numeroComanda,$codiDepartament,$valid){
	$this->db->trans_start();
		if($valid=="novalid"){
			$data = array(
				'fet' => 0,
			);
			$this->db->where('CodiParte', $codiparte);
			$this->db->where('CodiOperacio', $codioperacio);
			$this->db->where('CodiEmpresa', $codiempresa);
			$this->db->where('Exercici', $exercici);
			$this->db->where('Serie', $serie);
			$this->db->where('NumeroComanda', $numeroComanda);
			$this->db->where('CodiSeccio', $codiSeccio);
			$this->db->where('CodiDepartament', $codiDepartament);
			$this->db->update('OrdresFabricacio_Comunicats_Operacions', $data);
		}
		else{
			$data = array(
			'fet' => 1,
			);
			
			$this->db->where('CodiParte', $codiparte);
			$this->db->where('CodiOperacio', $codioperacio);
			$this->db->where('CodiEmpresa', $codiempresa);
			$this->db->where('Exercici', $exercici);
			$this->db->where('Serie', $serie);
			$this->db->where('NumeroComanda', $numeroComanda);
			$this->db->where('CodiSeccio', $codiSeccio);
			$this->db->where('CodiDepartament', $codiDepartament);
				$this->db->update('OrdresFabricacio_Comunicats_Operacions', $data);
		}
		$this->db->trans_complete();	
	}
	
	public function updateDetall($CodiEmpresa,$exercici,$serie,$numcom,$CodiSeccio,$CodiParte,$detall){
		$this->db->trans_start();
		
			$data = array(
				'Detall' => $detall,
			);
			$this->db->where('CodiParte', $CodiParte);
			$this->db->where('CodiEmpresa', $CodiEmpresa);
			$this->db->where('Exercici', $exercici);
			$this->db->where('Serie', $serie);
			$this->db->where('NumeroComanda', $numcom);
			$this->db->where('CodiSeccio', $CodiSeccio);
			$this->db->update('OrdresFabricacio_Comunicats', $data);
		
		$this->db->trans_complete();

	}
	
	public function getimatges($dia,$comexercici,$comserie,$comnumerocomanda,$comcodiseccio,$comcodicomunicat,$comcodiempresa){
		$sql = "select ocf.CodiEmpresa,ocf.Exercici,ocf.Serie,ocf.NumeroComanda,ocf.CodiSeccio,ocf.CodiParte,
		ocf.TipusFotos, ocf.Foto, ocf.Extensio, ocf.OrdreFotos, oc.CodiEmplaçament, oc.CodiParte from OrdresFabricacio_Comunicats_Fotos ocf
		inner join OrdresFabricacio_Comunicats oc on (ocf.CodiEmpresa=oc.CodiEmpresa and ocf.Exercici=oc.Exercici and ocf.Serie=oc.Serie 
		and ocf.NumeroComanda=oc.NumeroComanda and ocf.CodiSeccio=oc.CodiSeccio and oc.CodiParte=ocf.CodiParte)
		where oc.Data=? and oc.DataTancament is NULL and oc.CodiEmpresa=? and oc.Exercici=? and oc.Serie=? and oc.NumeroComanda=? and oc.CodiSeccio=? and oc.CodiParte=? order by ocf.TipusFotos,ocf.OrdreFotos";
		
		
		$resultat = $this->db->query($sql,array($dia,$comcodiempresa,$comexercici,$comserie,$comnumerocomanda,$comcodiseccio,$comcodicomunicat));
		
		
		$b = array();
		$i=0;
		
		foreach($resultat->result_array() as $r){

			if($r["Foto"]!='' || $r["Foto"]!=NULL){	

			
			
				$b[$i][0] = $r["CodiEmpresa"];
				$b[$i][1] = $r["Exercici"];
				$b[$i][2] = $r["Serie"];
				$b[$i][3] = $r["NumeroComanda"];
				$b[$i][4] = $r["CodiSeccio"];
				$b[$i][5] = $r["CodiParte"];
				$b[$i][6] = $r["TipusFotos"];
				$b[$i][7] = $r["Extensio"];
				$img = $this->generaFoto($r["Foto"]);
				$b[$i][8] = 'src="data:image/'.$b[$i][7].';base64,'.base64_encode($img).'"';
				$b[$i][9] = $r["OrdreFotos"];
				$b[$i][10] = $r["CodiEmplaçament"];
				$b[$i][11] = $r["CodiParte"];
				$i++;
			}
		}
		if($i==0){
			return "noregistres";
		}else{
			return $b;
		}
	}
	
	public function getproperid($codiempresa,$codiexercici,$codiserie,$codinumerocomanda,$codiseccio,$codiparte,$tipusFotos){
		
		$sql = "SELECT IFNULL(max(OrdreFotos),0)+1 as propera FROM OrdresFabricacio_Comunicats_Fotos WHERE CodiEmpresa=? AND Exercici=? AND Serie=? AND NumeroComanda=? AND CodiSeccio=? AND CodiParte=? AND tipusFotos=?";
				
		$resultat = $this->db->query($sql,array($codiempresa,$codiexercici,$codiserie,$codinumerocomanda,$codiseccio,$codiparte,$tipusFotos));
		
		$propera = "";
		foreach($resultat->result_array() as $r){
			$propera = $r["propera"];
		}
		if($propera  != ""){
			return $propera;
		}
		else{
			return "error";
		}
	}
	
	public function Insereiximatge($codiempresa,$codiexercici,$codiserie,$codinumerocomanda,$codiseccio,$codiparte,$propera,$tipusFotos,$extensio,$arxiu){	
		   $data = array(
			   'CodiEmpresa' => $codiempresa, 
			   'Exercici' => $codiexercici,
			   'Serie' => $codiserie,
			   'NumeroComanda' => $codinumerocomanda,
			   'CodiSeccio' => $codiseccio,
			   'CodiParte' => $codiparte,
			   'OrdreFotos' => $propera,
			   'TipusFotos' => $tipusFotos,
			   'Foto' => $arxiu,
			   'Extensio' => $extensio,
		   );
		   $this->db->insert('OrdresFabricacio_Comunicats_Fotos', $data); 
	}
	
	public function updateDataModificacioComunicat($modificacio,$codiempresa,$codiexercici,$codiserie,$codinumerocomanda,$codiseccio,$codiparte){
		$date = new DateTime();
		$date->setTimeZone(new DateTimeZone("Europe/Madrid"));
		$result = $date->format('Y-m-d');
		
		$data = array(
			'DataModificacio' => $result,
			'Modificacio' => $modificacio,
		);
			
		$this->db->where('Serie', $codiserie);
		$this->db->where('NumeroComanda', $codinumerocomanda);
		$this->db->where('CodiSeccio', $codiseccio);
		$this->db->where('CodiParte', $codiparte);
		$this->db->where('Exercici', $codiexercici);
		$this->db->where('CodiEmpresa', $codiempresa);

		$this->db->update('OrdresFabricacio_Comunicats', $data);	
	}

	public function borrarimatge($codiempresa,$codiexercici,$codiserie,$numcom,$seccio,$parte,$ordrefotos,$tipusfotos){
		
		$this->db->delete('OrdresFabricacio_Comunicats_Fotos', array('CodiEmpresa' => $codiempresa, 'Exercici' => $codiexercici, 'NumeroComanda' => $numcom, 'CodiSeccio' => $seccio, 'CodiParte' => $parte, 'OrdreFotos' => $ordrefotos, 'TipusFotos' => $tipusfotos));

	}
	
	public function tancarparte($datausuari,$dataavui,$datatancament,$coords,$material,$tancarparte,$empresacod,$exercici,$serie,$numerocomanda,$codiseccio,$detall){
		if($datatancament==null){
			$aux=null;
		}	
		if($datatancament!=null){
					$datatancament = new DateTime($datatancament);
					$datatancament = $datatancament->format('Y-m-d');
					//$datatancament->setTimeZone(new DateTimeZone("Europe/Madrid"));
					
					$aux = date("Y-m-d", strtotime($datatancament));
					
					//$aux->setTimeZone(new DateTimeZone("Europe/Madrid"));
					//$aux = $dataavui->format('Y-m-d');
		}
		if($datausuari=="null"){				
			$data = array(
				
				'Data' => $dataavui,
				'DataTancament' => $datatancament,
				'DataModificacio' => $dataavui,
				'Modificacio' => 1,
				'Altitud' => $coords[0],
				'Longitud' => $coords[1],
				'Materials' => $material,
				'Detalls' => $detall
			);
		}else{
			$data = array(
				'DataTancament' => $aux,
				'DataModificacio' => $dataavui,
				'Modificacio' => 1,
				'Altitud' => $coords[0],
				'Longitud' => $coords[1],
				'Materials' => $material,
				'Detalls' => $detall
			);
		}
		$this->db->where('CodiParte', $tancarparte);
		$this->db->where('CodiEmpresa', $empresacod);
		$this->db->where('Exercici', $exercici);
		$this->db->where('Serie', $serie);
		$this->db->where('NumeroComanda', $numerocomanda);
		$this->db->where('CodiSeccio', $codiseccio);
		$this->db->update('OrdresFabricacio_Comunicats', $data);
	}
	
	public function comprovarlinia($CodiEmpresa,$exercici,$serie,$numcom,$CodiSeccio,$CodiParte,$datainici){
		$sql = "select * from OrdresFabricacio_Comunicats_Linies where CodiEmpresa=? and Exercici=? and Serie=? and NumeroComanda=? and CodiSeccio=? and CodiParte=? and Data=?";
		$resultat = $this->db->query($sql,array($CodiEmpresa,$exercici,$serie,$numcom,$CodiSeccio,$CodiParte,$datainici));
		$i=0;
		foreach($resultat->result_array() as $r){
				$i++;
			}
		if($i==0){
			return 1;
		}else{
			return -1;
		}
	}
	
	public function afegirlinia($CodiEmpresa,$exercici,$serie,$numcom,$CodiSeccio,$CodiParte,$datainici,$horainici,$hores,$operaris,$unitats){
		$data = array(
			   'CodiEmpresa' => $CodiEmpresa, 
			   'Exercici' => $exercici,
			   'Serie' => $serie,
			   'NumeroComanda' => $numcom,
			   'CodiSeccio' => $CodiSeccio,
			   'CodiParte' => $CodiParte,
			   'Data' => $datainici,
			   'HoraInici' => $horainici,
			   'Hores' => $hores,
			   'Operaris' => $operaris,
			   'Unitats' => $unitats
		   );
		   $this->db->insert('OrdresFabricacio_Comunicats_Linies', $data);
	}
	
	// public function getLinies($CodiEmpresa,$exercici,$serie,$numcom,$CodiSeccio,$CodiParte){
		// $sql = "select * from OrdresFabricacio_Comunicats_Linies where CodiEmpresa=? and Exercici=? and Serie=? and NumeroComanda=? and CodiSeccio=? and CodiParte=? order by Data";
		// $resultat = $this->db->query($sql,array($CodiEmpresa,$exercici,$serie,$numcom,$CodiSeccio,$CodiParte));
		// $a = array();
		// $i=0;
		// foreach($resultat->result_array() as $r){
			// $a[$i]["CodiEmpresa"] = $r["CodiEmpresa"];
			// $a[$i]["Exercici"] = $r["Exercici"];
			// $a[$i]["Serie"] = $r["Serie"];
			// $a[$i]["NumeroComanda"] = $r["NumeroComanda"];
			// $a[$i]["CodiSeccio"] = $r["CodiSeccio"];
			// $a[$i]["CodiParte"] = $r["CodiParte"];
			// $a[$i]["Data"] = $r["Data"];
			// $a[$i]["HoraInici"] = $r["HoraInici"];
			// $a[$i]["Unitats"] = $r["Unitats"];
			// $a[$i]["Operaris"] = $r["Operaris"];
			// $a[$i]["Hores"] = $r["Hores"];
			// $i++;
		// }
		// if($i == 0){
			// return -1;
		// }else{
			// return $a;
		// }
		
	// }
	
	public function borrarliniabd($data){
		$this->db->delete('OrdresFabricacio_Comunicats_Linies', $data);
	}
	
	public function updateHoresTasca($data,$horesReals){
	
			$this->db->where('CodiEmpresa', $data["CodiEmpresa"]);
			$this->db->where('Exercici', $data["Exercici"]);
			$this->db->where('Serie', $data["Serie"]);
			$this->db->where('NumeroComanda', $data["NumeroComanda"]);
			$this->db->where('CodiSeccio', $data["CodiSeccio"]);
			$this->db->where('CodiParte', $data["CodiParte"]);
			$this->db->where('CodiDepartament', $data["CodiDepartament"]);
			$this->db->where('CodiOperacio', $data["CodiOperacio"]);
			$this->db->where('Ordre', $data["Ordre"]);
	
			$updatedata = array(
			   'HoresReals' => $horesReals, 
			);
			
			$this->db->update('OrdresFabricacio_Comunicats_Operacions_Linies', $updatedata);
	}
	
	public function borrarOperacioLinia($data){
		$this->db->delete('OrdresFabricacio_Comunicats_Operacions_Linies', $data);
	}
	
	public function afagirliniaop($data){
		$this->db->insert('OrdresFabricacio_Comunicats_Operacions_Linies', $data); 
	}
	
	public function getautonumeric($data){
		$sql = "SELECT ordre+1 as seguent FROM `OrdresFabricacio_Comunicats_Operacions_Linies` where CodiEmpresa=? and Exercici=? and Serie=? and NumeroComanda=? and CodiSeccio=? and CodiOperacio=? and CodiParte=? and CodiDepartament=? order by ordre desc limit 1";
		
		$resultat = $this->db->query($sql,array($data["CodiEmpresa"],$data["Exercici"],$data["Serie"],$data["NumeroComanda"],$data["CodiSeccio"],$data["CodiOperacio"],$data["CodiParte"],$data["CodiDepartament"]));
		
		$a = 0;
		
		foreach($resultat->result_array() as $r){		
			$a = $r["seguent"];
		}
		if($a==0){
			$a = 1;
		}
		return $a;
		
	}
	
}
