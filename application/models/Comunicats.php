<?php

/**
 * Created by PhpStorm.
 * User: Pol
 * Date: 14/12/15
 * Time: 17:31
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Comunicats extends CI_Model{
    function __construct() {
        $this->load->database();
    }
    public function closeBd($mysqli){
        $mysqli=null;
    }

    public function treballadors($codiEmpresa) {
        
		$sql = "SELECT et.*, e.NomEmpresa from OrdresFabricacio_Comunicats_Treballadors et, Empreses e, UsuarisEmpreses ue where et.CodiEmpresa=e.CodiEmpresa and ue.CodiEmpresa=et.CodiEmpresa and et.CodiEmpresa=? group by et.DNI";
		$resultat = $this->db->query($sql,array($codiEmpresa));
			
		$a = array();
		$i=0;
			
		foreach($resultat->result_array() as $r){		
			$a[$i][0] = $r["NomEmpresa"];
			$a[$i][1] = $r["DNI"];
			$a[$i][2] = $r["NomTreballador"];
			$i++;
		}
		return $a;
	}
	
	public function loginTreballador($usuari,$clau){
	
	$sql = 'SELECT * FROM OrdresFabricacio_Comunicats_Treballadors WHERE DNI=? and CodiFitxa=? group by DNI';
	$resultat = $this->db->query($sql,array($usuari,$clau));
	
	$a = array();
	$i=0;
		
	foreach($resultat->result_array() as $r){		
		$_SESSION['dniusuari'] = $r['DNI'];
		$_SESSION['nomtreballador'] = $r['NomTreballador'];
		$_SESSION['codifitxa'] = $r['CodiFitxa'];
		$i++;
	}
	
		if ($i == 0) {
			return 0; 
			exit;
		}
		else if(isset($_SESSION["QrCode"]) && $_SESSION["QrCode"]="si"){
			return 2;
			exit;
		}
		else{
			return 1; 
			exit;
		}
	}
	
	public function getClientsTreballador($empresa,$dni){
		$sql = 'SELECT com.Client, com.CodiClient from OrdresFabricacio_Comunicats com 
		join OrdresFabricacio_Comunicats_Treballadors et on (et.CodiEmpresa=com.CodiEmpresa and et.Exercici=com.Exercici
		and et.Serie=com.Serie and et.NumeroComanda=com.NumeroComanda and et.CodiSeccio=com.CodiSeccio and et.CodiParte=com.CodiParte)  where com.CodiEmpresa=? and et.DNI=? group by com.CodiClient order by com.Client';
		
		$resultat = $this->db->query($sql,array($empresa,$dni));
			
		$a = array();
		$i=0;
			
		foreach($resultat->result_array() as $r){		
			$a[$i]["CodiClient"] = $r["CodiClient"];
			$a[$i]["Client"] = $r["Client"];
			$i++;
		}
		
		return $a;
	}
	
	public function getComunicatQr($clientcod,$domicili,$empreses,$dniusuari,$dataactualYMD){
		$sql = 'SELECT oc.ComandaClient, oc.Equip, oc.Domicili, oc.CodiDepartament, oc.Exercici,oc.Serie,oc.NumeroComanda,
		oc.CodiSeccio, e.CodiEmplaçament, e.CodiClient,e.CodiEmpresa, e.NomEmplaçament, e.Imatge, oc.Data, oc.CodiParte  
        from Emplaçaments e inner join 
		OrdresFabricacio_Comunicats oc on (oc.CodiEmpresa=e.CodiEmpresa and oc.CodiEmplaçament=e.CodiEmplaçament and 
		oc.CodiClient=e.CodiClient) 
		left join OrdresFabricacio_Comunicats_Treballadors oct on(oc.CodiParte=oct.CodiParte and oc.CodiEmpresa=oct.CodiEmpresa 
		and oc.Exercici=oct.Exercici and oc.Serie=oct.serie and oc.NumeroComanda=oct.NumeroComanda and oc.CodiSeccio=oct.CodiSeccio) 
		where oct.DNI=? and oc.CodiEmpresa=? and e.CodiEmplaçament=? and oc.Data=? and oc.DataTancament is NULL and oc.CodiClient=? 
        group by oc.CodiParte order by oc.Data';


		$resultat = $this->db->query($sql,array($dniusuari,$empreses,$domicili,$dataactualYMD,$clientcod));
		
		$a = array();
		$i=0;
			
		foreach($resultat->result_array() as $r){		
			$a[$i][0] = $r["CodiEmplaçament"];
			$a[$i][1] = $r["CodiClient"];
			$a[$i][2] = $r["CodiEmpresa"];
			$a[$i][3] = $r["NomEmplaçament"];
			if($r["Imatge"]==''){
				$a[$i][4] = null;
			}
			else{
				$img = $this->generaFoto($r["Imatge"]);
				$a[$i][4] = 'src="data:image/jpg;base64,'.base64_encode($img).'"';
			}
			$a[$i][5] = $r["Data"];
			//$a[$i][6] = $r["CodiOperacio"];
			//$a[$i][7] = $r["NomOperacio"];
			$a[$i][8] = $r["CodiParte"];
			$a[$i][10] =$r["Equip"];
			$a[$i][11] =$r["Exercici"];
			$a[$i][12] =$r["Serie"];
			$a[$i][13] =$r["NumeroComanda"];
			$a[$i][14] =$r["CodiSeccio"];
			$a[$i][15] =$r["Domicili"];
			$a[$i][16] =$r["CodiDepartament"];
			$a[$i][17] =$r["ComandaClient"];
			$i++;
		}
		if($i==0){
			return "noregistres";
			exit;
		}
		else{
			return $a;
		}
	}

	public function getComunicats($dia,$clientcod,$domicili,$empreses,$dniusuari,$antics){
		
		$sql = 'SELECT oc.ComandaClient, oc.Equip, oc.Domicili, oc.CodiDepartament, oc.Exercici,oc.Serie,oc.NumeroComanda,
		oc.CodiSeccio, e.CodiEmplaçament, e.CodiClient,e.CodiEmpresa, e.NomEmplaçament, e.Imatge, oc.Data, oc.CodiParte  
        from Emplaçaments e inner join 
		OrdresFabricacio_Comunicats oc on (oc.CodiEmpresa=e.CodiEmpresa and oc.CodiEmplaçament=e.CodiEmplaçament and 
		oc.CodiClient=e.CodiClient) 
		left join OrdresFabricacio_Comunicats_Treballadors oct on(oc.CodiParte=oct.CodiParte and oc.CodiEmpresa=oct.CodiEmpresa 
		and oc.Exercici=oct.Exercici and oc.Serie=oct.serie and oc.NumeroComanda=oct.NumeroComanda and oc.CodiSeccio=oct.CodiSeccio)  
		where (oct.DNI=?) and oc.CodiEmpresa=? and (oc.Domicili like "%'.$domicili.'%" or e.NomEmplaçament like "%'.$domicili.'%") and oc.DataTancament is NULL and oc.CodiClient=? ';

		if($antics==true){
			$sql .= 'and (oc.Data<=? or oc.Data is NULL)';
		}
		
		else if($antics==false){
			$sql .= 'and (oc.Data=? or oc.Data is NULL)';
		}
		
        $sql .= 'group by oc.CodiParte order by oc.Data';

		$resultat = $this->db->query($sql,array($dniusuari,$empreses,$clientcod,$dia));
		
		$resultat = $resultat->result_array();
		
		$this->Imatges($resultat);
		
		return $resultat;
		
		
		
		
		
		// $resultat;
		// $a = array();
		// $i=0;
			
		// foreach($resultat->result_array() as $r){		
			// $a[$i][0] = $r["CodiEmplaçament"];
			// $a[$i][1] = $r["CodiClient"];
			// $a[$i][2] = $r["CodiEmpresa"];
			// $a[$i][3] = $r["NomEmplaçament"];
			// if($r["Imatge"]==''){
				// $a[$i][4] = null;
			// }
			// else{
				// $img = $this->generaFoto($r["Imatge"]);
				// $a[$i][4] = 'src="data:image/jpg;base64,'.base64_encode($img).'"';
			// }
			// $a[$i][5] = $r["Data"];
			// $a[$i][6] = $r["CodiOperacio"];
			// $a[$i][7] = $r["NomOperacio"];
			// $a[$i][8] = $r["CodiParte"];
			// $a[$i][10] =$r["Equip"];
			// $a[$i][11] =$r["Exercici"];
			// $a[$i][12] =$r["Serie"];
			// $a[$i][13] =$r["NumeroComanda"];
			// $a[$i][14] =$r["CodiSeccio"];
			// $a[$i][15] =$r["Domicili"];
			// $a[$i][16] =$r["CodiDepartament"];
			// $a[$i][17] =$r["ComandaClient"];
			// $i++;
		// }
		// if($i==0){
			// return "noregistres";
			// exit;
		// }
		// else{
			// return $a;
		// }
	}
	
	public function Imatges(&$data){
		for ($i=0; $i<count($data);$i++){
			if($data[$i]["Imatge"]=='' || $data[$i]["Imatge"] == null){
				$data[$i]["Imatge"] = null;
			}else{
				$img = $this->generaFoto($data[$i]["Imatge"]);
				$data[$i]["Imatge"]= 'src="data:image/jpg;base64,'.base64_encode($img).'"';
			}
		}
	}
	
	public function generaFoto($dadesImatge) {
		$source= imagecreatefromstring($dadesImatge);
		list($width,$height)=getimagesizefromstring($dadesImatge);
		$newwidth=250; $newheight=$height/($width/$newwidth);
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
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
	
	public function Reobrirparte($dataactual,$dniusuari){

		$dataactual = new DateTime($dataactual);
		$dataactual = date_format($dataactual,"Y/m/d H:i:s");
		$sql = "UPDATE OrdresFabricacio_Comunicats oc inner join
		Emplaçaments_treballadors et on(et.CodiEmpresa=oc.CodiEmpresa and et.CodiEmplaçament=oc.CodiEmplaçament) 
		SET DataTancament=null, DataModificacio=curdate(),Modificacio=1 
		where et.DNI='$dniusuari' and oc.Data='$dataactual'";


		
		
		
		if ($this->db->query($sql) === TRUE) {
			//echo "Record updated successfully";
		} else {
			return "Error updating record: " . $conn->error;
		}	
		
		return "totok";
		
	}
	
	public function modificat($codiparte,$codiempresa,$exercici,$serie,$codiSeccio,$numeroComanda){
		$modificacio = 1;
		$data = array(
			'Modificacio' => $modificacio,
		);
			
		$this->db->where('Serie', $serie);
		$this->db->where('NumeroComanda', $numeroComanda);
		$this->db->where('CodiSeccio', $codiSeccio);
		$this->db->where('CodiParte', $codiparte);
		$this->db->where('Exercici', $exercici);
		$this->db->where('CodiEmpresa', $codiempresa);

		$this->db->update('OrdresFabricacio_Comunicats', $data);	
	}
	
	public function emplacamentsavui($empresa,$dniusuari,$data){
		$sql = "SELECT oc.CodiEmpresa, oc.CodiClient, oc.Data, oc.DataTancament, if(oc.Equip is null or oc.Equip=\"\",\"\",oc.Equip) as Equip, emp.CodiEmplaçament, emp.NomEmplaçament 
		FROM OrdresFabricacio_Comunicats oc 
		inner join OrdresFabricacio_Comunicats_Treballadors oct on (oc.CodiParte=oct.CodiParte and oc.CodiEmpresa=oct.CodiEmpresa and 
			oc.Exercici=oct.Exercici and oc.Serie=oct.serie and oc.NumeroComanda=oct.NumeroComanda and oc.CodiSeccio=oct.CodiSeccio) 
		inner join Emplaçaments emp on(emp.CodiEmpresa=oc.CodiEmpresa and emp.CodiClient=oc.CodiClient and 
			emp.CodiEmplaçament=oc.CodiEmplaçament) 
		where oc.CodiEmpresa=? and oct.DNI = ? and oc.data=?";

		$resultat = $this->db->query($sql,array($empresa,$dniusuari,$data));
		
		return $resultat->result_array();
		
	}
	

}
