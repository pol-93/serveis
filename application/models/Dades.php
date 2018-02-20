<?php

/**
 * Created by PhpStorm.
 * User: Pol
 * Date: 14/12/15
 * Time: 17:31
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dades extends CI_Model{
    function __construct() {
        $this->load->database();
    }
    public function closeBd($mysqli){
        $mysqli=null;
    }

    public function getComunicats($usuari,$empresa,$datainici,$datafi) {

		$sql = "SELECT e.NomEmplaçament, oc.Domicili, op.NomOperacio, oc.Data, if (oc.DataTancament is null or oc.DataTancament = '0000-00-00 00:00:00', \"\", oc.DataTancament) as DataTancament, oc.CodiEmpresa, oc.Exercici, oc.Serie, 
				oc.NumeroComanda, oc.CodiSeccio ,oc.CodiParte, if (((sum(ocol.HoresReals) > 0 and oc.DataTancament is not null) or (ocol.HoresReals = 0 and ocol.HoresPlanificades = 0 and oc.DataTancament is not null)), 1, 0) as fet,if (count(ocf.CodiParte)=0, \"\",\"fotos\")
				as numerofotos 
			    from Emplaçaments e inner join OrdresFabricacio_Comunicats oc on (oc.CodiEmpresa=e.CodiEmpresa and oc.CodiEmplaçament=e.CodiEmplaçament
					and oc.CodiClient=e.CodiClient) 
		
				inner join OrdresFabricacio_Comunicats_Operacions_Linies ocol on(oc.CodiParte=ocol.CodiParte and oc.CodiEmpresa=ocol.CodiEmpresa 
					and oc.Serie=ocol.Serie and oc.Exercici=ocol.Exercici and oc.NumeroComanda=ocol.NumeroComanda and oc.CodiSeccio=ocol.CodiSeccio) 
		
				inner join Operacions op on (ocol.CodiOperacio=op.CodiOperacio and ocol.CodiEmpresa=op.CodiEmpresa and 
					ocol.CodiDepartament=op.CodiDepartament)
		
				inner join UsuarisEmpreses ue on (ue.CodiEmpresa=oc.CodiEmpresa and ue.CodiClient=oc.Codiclient) 
        
				left join OrdresFabricacio_Comunicats_Fotos ocf on (ocf.CodiEmpresa=oc.CodiEmpresa and ocf.Exercici=oc.Exercici and 		    				  
					ocf.Serie=oc.Serie and ocf.NumeroComanda=oc.NumeroComanda and ocf.CodiParte=oc.CodiParte)
				
				WHERE ue.CodiUsuari=? and op.CodiEmpresa=? and (oc.Data between ? and ? or oc.DataTancament between ? and ?) 
				group by  e.NomEmplaçament, oc.Domicili, op.NomOperacio, oc.Data, oc.DataTancament
				order by oc.DataTancament";
		
		
		$resultat = $this->db->query($sql, array($usuari,$empresa, $datainici, $datafi,$datainici,$datafi));
		
		
		
        $a = array();
        $row_cnt = $resultat->num_rows();
        if($row_cnt==0){
            return 0;
        }
        else{
			$i=0;
            foreach($resultat->result_array() as $row){
				$a[$i][0] = $row["NomEmplaçament"];
				$a[$i][1] = $row["NomOperacio"];
				$a[$i][2] = $row["Data"];
				$a[$i][3] = $row["DataTancament"];
				$a[$i][4] = $row["fet"];
				$a[$i][5] = $row["CodiEmpresa"];
				$a[$i][6] = $row["Exercici"];
				$a[$i][7] = $row["Serie"];
				$a[$i][8] = $row["NumeroComanda"];
				$a[$i][9] = $row["CodiSeccio"];
				$a[$i][10] = $row["CodiParte"];
				$a[$i][11] = $row["numerofotos"];
				$a[$i][12] = $row["Domicili"];
				$i++;
            }
        }
		if(!empty($a)){
			echo json_encode($a);
		}
		else{
			echo "XD";
		}
    }
	
	public function getfotoscom($comcodiempresa,$comexercici,$comserie,$comnumerocomanda,$comcodiseccio,$comcodicomunicat){
		
		
		$sql = "select ocf.CodiEmpresa,ocf.Exercici,ocf.Serie,ocf.NumeroComanda,ocf.CodiSeccio,ocf.CodiParte,
		ocf.TipusFotos, ocf.Foto, ocf.Extensio, ocf.OrdreFotos, oc.CodiEmplaçament, oc.CodiParte from OrdresFabricacio_Comunicats_Fotos ocf
		inner join OrdresFabricacio_Comunicats oc on (ocf.CodiEmpresa=oc.CodiEmpresa and ocf.Exercici=oc.Exercici and ocf.Serie=oc.Serie 
		and ocf.NumeroComanda=oc.NumeroComanda and ocf.CodiSeccio=oc.CodiSeccio and oc.CodiParte=ocf.CodiParte)
		where oc.CodiEmpresa=? and oc.Exercici=? and oc.Serie=? and oc.NumeroComanda=? and oc.CodiSeccio=? and oc.CodiParte=? order by ocf.TipusFotos,ocf.OrdreFotos";
		
		$resultat = $this->db->query($sql,array($comcodiempresa,$comexercici,$comserie,$comnumerocomanda,$comcodiseccio,$comcodicomunicat));

		
		$a = array();
        $row_cnt = $resultat->num_rows();
        if($row_cnt==0){
            return 0;
        }
        else{
			$i=0;
			$this->load->library('image_lib');
            foreach($resultat->result_array() as $r){
				if($r["Foto"]!='' || $r["Foto"]!=NULL){				
				$a[$i][0] = $r["CodiEmpresa"];
				$a[$i][1] = $r["Exercici"];
				$a[$i][2] = $r["Serie"];
				$a[$i][3] = $r["NumeroComanda"];
				$a[$i][4] = $r["CodiSeccio"];
				$a[$i][5] = $r["CodiParte"];
				$a[$i][6] = $r["TipusFotos"];
				$a[$i][7] = $r["Extensio"];
			
				 
				   ## and the image extension is also stored in ext column
				    $ext = $r['Extensio'];
					switch($ext)
					{
					case 'image/jpeg': // no need to perform any changes
						$ext = '.jpg';
					break;
					case 'image/png':
						$ext = '.png';
					break;
					case 'image/bmp':
						$ext = '.bmp';
					break;
					case 'image/gif':
						$ext = '.gif';
					break;
					default: 
						$ext = '.jpg';
					break;
					}
				
			$ubicacio = FCPATH . 'assets/images/'.$r["CodiEmpresa"].$r["Exercici"].$r["Serie"].$r["NumeroComanda"].$r["CodiSeccio"].$r["CodiParte"].$i . $ext;
			$ubicacio2 = base_url() . 'assets/images/'.$r["CodiEmpresa"].$r["Exercici"].$r["Serie"].$r["NumeroComanda"].$r["CodiSeccio"].$r["CodiParte"].$i . $ext;				
						
			if (!file_exists($ubicacio)) {
				
				
			
					
					//echo $ubicacio;
				   ## use fwrite() function
				   $physicalFile = fopen($ubicacio ,"w");
				   ## write the physical file
				   fwrite($physicalFile, $r['Foto']);

				   fclose($physicalFile);
				   
				 
					
		
				//list($width, $height) = getimagesize($ubicacio2);
	
				$filepath = $ubicacio;
				$exif = @exif_read_data($filepath);
				
				
				
				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image']	= $filepath;
				
		
				$config['rotation_angle'] = '';
				if(isset($exif['Orientation'])){
					switch($exif['Orientation'])
					{
					case 1: 
					break;
			
					case 2: 
					 $config['rotation_angle'] = 'hor';
					break;
											
					case 3:
						$config['rotation_angle'] = '180';
					break;
								
					case 4: 
						$config['rotation_angle'] = 'ver';
					break;
							
					case 5:
						$config['rotation_angle'] = 'ver';
						$config['rotation_angle'] = '270';
					break;
							
					case 6:
						$config['rotation_angle'] = '270';
					break;
							
					case 7:
						$config['rotation_angle'] = 'hor';
						$config['rotation_angle'] = '270';
					break;
							
					case 8:
						$config['rotation_angle'] = '90';
					break;
					
				default: break;
				}
				
				}	
		
				
				$this->image_lib->initialize($config);

				if( ! $this->image_lib->rotate())
				{
						//echo $this->image_lib->display_errors();
				}	

				
				$this->image_lib->clear();
			
				}
				 
				 ///$file_content = file_get_contents($ubicacio);
				
				$a[$i][8] = 'src="' . base_url() . 'assets/images/'.$r["CodiEmpresa"].$r["Exercici"].$r["Serie"].$r["NumeroComanda"].$r["CodiSeccio"].$r["CodiParte"].$i . $ext.'"';
				$a[$i][9] = $r["OrdreFotos"];
				$a[$i][10] = $r["CodiEmplaçament"];
				$a[$i][11] = $r["CodiParte"];
				$i++;
				}
			}
		}
		 
		  $path = FCPATH . 'assets/images/';
		  $todayDate = new DateTime();
		  if ($handle = opendir($path)) {
			 while (false !== ($file = readdir($handle))) {
				 if($file != '..' && $file != '.'){
					$dataactual = date ("Y-m-d H:i:s", filectime($path.$file));
					$dataactual = new DateTime($dataactual);
					$seconds =  (strtotime($todayDate->format('Y-m-d H:i:s'))) - (strtotime($dataactual->format('Y-m-d H:i:s')));
					if($seconds>3600){
							unlink ($path.$file);
					}
			 }
		  }
	  }
		
		
		
        if(!empty($a)){
			echo json_encode($a, JSON_UNESCAPED_SLASHES);
		}
		else{
			echo "XD";
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
		
		public function getClients($CodiEmpresa,$codiusuari){
			$sql = "select * from Clients c join UsuarisEmpreses ue on (ue.CodiClient=c.CodiClient and ue.CodiEmpresa=c.CodiEmpresa) where ue.CodiUsuari=? and ue.permis='demandes' and ue.CodiEmpresa=? group by ue.CodiClient";
			$resultat = $this->db->query($sql,array($codiusuari,$CodiEmpresa));
			$a = array();
			$i=0;
			foreach($resultat->result_array() as $r){		
				$a[$i]["CodiUsuari"] = $r["CodiUsuari"];
				$a[$i]["CodiEmpresa"] = $r["CodiEmpresa"];
				$a[$i]["CodiClient"] = $r["CodiClient"];
				$a[$i]["Permis"] = $r["permis"];
				$a[$i]["RaoSocial1"] = $r["RaoSocial1"];
				$a[$i]["RaoSocial2"] = $r["RaoSocial2"];
				$i++;
			}
				return $a;
		}
			
		
		
		public function getDesti($codiusuari){
			$sql = "select ue.CodiEmpresa, e.nomEmpresa from UsuarisEmpreses ue join Empreses e on (e.CodiEmpresa=ue.CodiEmpresa) where CodiUsuari=? group by CodiEmpresa";
			$resultat = $this->db->query($sql,array($codiusuari));
			$a = array();
			$i=0;
			 foreach($resultat->result_array() as $r){
				$a[$i]["CodiEmpresa"] = $r["CodiEmpresa"];
				$a[$i]["nomEmpresa"] = $r["nomEmpresa"];
				$i++;
			}
			return $a;
		}
		
		public function getId($CodiClient,$CodiEmpresa){
			$sql = "SELECT CodiDemanda FROM Demandes_serveis where CodiClient=? and CodiEmpresa=? order by CodiDemanda desc Limit 1 ";
			$resultat = $this->db->query($sql,array($CodiClient,$CodiEmpresa));
			$id;
			$i=0;
			 foreach($resultat->result_array() as $r){
				$id = $r["CodiDemanda"];
				$i++;
			}
			if($i==0){
				return 0;
			}
			else{
				return $id;
			}
		}
		
		
		
		public function getIdArxiu(){
			$sql = "SELECT CodiArxiu FROM Demandes_Arxius where Tipus=\"extern\" order by CodiArxiu desc Limit 1 ";
			$resultat = $this->db->query($sql);
			$i=0;
			 foreach($resultat->result_array() as $r){
				$id = $r["CodiArxiu"];
				$i++;
			}
			if($i==0){
				return 0;
			}
			else{
				return $id;
			}
		}

		
		public function crearDemanda($id,$lloc,$descripcio,$codiusuari,$client,$desti,$estat,$ladata,$nomusuari){
		$this->db->trans_start();
		
		$data = array(
				'CodiDemanda' => $id,
				'Lloc' => $lloc,
				'descripcio' => $descripcio,
				'CodiUsuari' => $codiusuari,
				'Estat' => $estat,
				'CodiClient' => $client,
				'CodiEmpresa' => $desti,
				'Modificat' => 1,
				'DataModificacio' => $ladata,
				'DataCreacio' => $ladata,
				'UsuariCreacio' => $nomusuari
			);
		$this->db->insert('Demandes_serveis', $data);
		$str = $this->db->last_query();
		echo $str;
		$this->db->trans_complete();
		} 
		
		public function arxiusDemanda($arxiu,$CodiClient,$CodiEmpresa,$id){
			$this->db->trans_start();
			
			for($i=0;$i<count($arxiu);$i++){
				$idArxiu = $this->getIdArxiu();
				$idArxiu = $idArxiu + 1;
				$data = array(
					'CodiArxiu' => $idArxiu,
					'Arxiu' => $arxiu[$i][0],
					'Extensio' => $arxiu[$i][1],
					'nomArxiu' => $arxiu[$i][2],
					'CodiDemanda' => $id,
					'CodiEmpresa' => $CodiEmpresa,
					'CodiClient' => $CodiClient,
					'Tipus' => "extern",
				);
			
				$this->db->insert('Demandes_Arxius', $data);
			}
			$this->db->trans_complete();
		}
		
		public function getDemandes($empresa,$client){
			$sql = "SELECT de.CodiDemanda, de.Lloc, de.Descripcio, IF(cli.RaoSocial1=cli.RaoSocial2, cli.RaoSocial1, CONCAT(CONCAT(cli.RaoSocial1,\" - \"),cli.RaoSocial2)) as desclient,  de.CodiUsuari, de.Estat, de.CodiClient, de.CodiEmpresa from Demandes_serveis de join UsuarisEmpreses usu on(usu.CodiEmpresa=de.CodiEmpresa and usu.CodiClient=de.CodiClient) join Clients cli on(cli.CodiEmpresa=usu.CodiEmpresa and cli.CodiClient=usu.CodiClient) WHERE de.CodiEmpresa=? and de.CodiClient=? group by de.CodiDemanda, de.CodiClient, de.CodiEmpresa";
			$resultat = $this->db->query($sql,array($empresa,$client));
			
			$a = array();
			$i=0;
			
			foreach($resultat->result_array() as $r){		
				$a[$i][0] = $r["CodiDemanda"];
				$a[$i][1] = $r["desclient"];
				$a[$i][2] = $r["Lloc"];
				$a[$i][3] = $r["Descripcio"];
				$a[$i][4] = $r["CodiUsuari"];
				$a[$i][5] = $r["Estat"];
				$a[$i][6] = $r["CodiClient"];
				$a[$i][7] = $r["CodiEmpresa"];	
				$i++;
			}
			if(!empty($a)){
				echo json_encode($a);
			}
			else{
				return "No hi ha Demandes";
			}
		
		}
		
		public function borrarDemanda($id,$empreses,$clientcod,$client,$empresa){
			$this->db->trans_start();
			$this->db->delete('Demandes_serveis', array('CodiDemanda' => $id,'CodiEmpresa'=>$empreses, 'CodiClient' =>$clientcod));
			//$this->db->delete('Demandes_Arxius', array('CodiArxiu' => $id,'CodiEmpresa'=>$empreses, 'CodiClient' =>$clientcod ));
			$this->db->trans_complete();	
				
		}	
		
		public function editarDemanda($id,$empreses,$clientcod){
	
			$sql = "select distinct s.CodiDemanda, IF(cli.RaoSocial1=cli.RaoSocial2, cli.RaoSocial1, CONCAT(CONCAT(cli.RaoSocial1,' - '),cli.RaoSocial2)) as Entitat, s.Lloc, s.Descripcio, s.CodiClient, s.CodiEmpresa, s.CodiUsuari, s.Estat, a.CodiArxiu as 'CodiFoto', a.Arxiu, a.nomArxiu, a.Extensio,a.Tipus from Demandes_serveis s left join Demandes_Arxius a on (a.CodiDemanda=s.CodiDemanda) join UsuarisEmpreses ue on (s.CodiClient=ue.CodiClient and s.CodiEmpresa=ue.CodiEmpresa) join Clients cli on (cli.CodiEmpresa=ue.CodiEmpresa and cli.CodiClient=ue.CodiClient) where s.CodiDemanda=? and s.CodiClient=? and s.CodiEmpresa=? ";
			$resultat = $this->db->query($sql,array($id,$clientcod,$empreses));
			
			$a = array();
			$i=0;
			foreach($resultat->result_array() as $r) {
				$a[$i][0] = $r["CodiDemanda"];
				$a[$i][1] = $r["Entitat"];
				$a[$i][2] = $r["Lloc"];
				$a[$i][3] = $r["Descripcio"];
				if($r["CodiFoto"]!='' || $r["CodiFoto"]!=null){
					$a[$i][4] = "SI";
					$a[$i][5] = $r["CodiFoto"];
					if($r["Extensio"]=='image/jpeg' || $r["Extensio"]=='image/png' || $r["Extensio"]=='image/gif'){
						$img = $this->generaFoto($r["Arxiu"]);
						$a[$i][6] = 'src="data:'.$r["Extensio"].';base64,'.base64_encode($img).'"';
						$a[$i][7] = $r['nomArxiu'];
					}
					else{
						$a[$i][6] = 'src="/assets/img/DEFAULT.png"';
						$a[$i][7] = $r['nomArxiu'];
					}
				}
				else{
					$a[$i][4] = "NO";
				}
				$a[$i][8]= $r["CodiEmpresa"];
				$a[$i][9]= $r["CodiClient"];
				$a[$i][10] = $r["Tipus"];
				$i++;
			}
			if(!empty($a)){
				echo json_encode($a);
			}
			else{
				echo "error";
			}
	
		}

		public function actualitzardemanda($id,$lloc,$descripcio,$idclient,$idempresa,$nomusuari){
			$this->db->trans_start();
			$date = new DateTime();
			$date->setTimeZone(new DateTimeZone("Europe/Madrid"));
			$result = $date->format('Y-m-d');
			$data = array(
				'Lloc' => $lloc,
				'Descripcio' => $descripcio,
				'DataModificacio' => $result,
				'modificat' => 1,
				'UsuariCreacio' => $nomusuari,
			);
			
			$this->db->where('CodiDemanda', $id);
			$this->db->where('CodiClient', $idclient);
			$this->db->where('CodiEmpresa', $idempresa);

			$this->db->update('Demandes_serveis', $data);
			$this->db->trans_complete();	
		}

		public function borrararxiusdemanda($borrades,$arr,$idclient,$idempresa){
			$this->db->trans_start();
			for($i=0;$i<$borrades;$i++){
				$this->db->delete('Demandes_Arxius', array('CodiArxiu' => $arr[$i], 'CodiEmpresa' => $idempresa, 'CodiClient' => $idclient));
			}
			$this->db->trans_complete();	
		}
		
		public function nousarxiusdemanda($id,$arxiu,$fotos,$idclient,$idempresa){
			$this->db->trans_begin();
			

			  for($i=0;$i<count($arxiu);$i++){ 
			  $idArxiu = $this->getIdArxiu();
			  $idArxiu = $idArxiu + 1;
				   $data = array(
					   'CodiArxiu' => $idArxiu, 
					   'Arxiu' => $arxiu[$i][0],
					   'Extensio' => $arxiu[$i][1],
					   'nomArxiu' => $arxiu[$i][2],
					   'CodiDemanda' => $id,
					   'CodiEmpresa' => $idempresa,
					   'CodiClient' => $idclient,
					   'Tipus' => "extern",
				   );
				   $this->db->insert('Demandes_Arxius', $data);
			   }
			$this->db->trans_complete();	
		}
		
		
		public function Seleccionarcorreus($client,$empresa){
			$permis = "demandes";
			$sql = "SELECT u.CorreuElectronic, ue.CodiUsuari, ue.CodiEmpresa, ue.CodiClient FROM UsuarisEmpreses ue join Usuaris u on (ue.CodiUsuari=u.CodiUsuari) where ue.CodiEmpresa=? and ue.CodiClient=? and ue.permis=? group by u.CorreuElectronic";
			$resultat = $this->db->query($sql,array($empresa,$client,$permis));
			
			$a = array();
			$i=0;
			
			foreach($resultat->result_array() as $r){		
				$a[$i][0] = $r["CorreuElectronic"];
				$a[$i][1] = $r["CodiUsuari"];
				$a[$i][2] = $r["CodiEmpresa"];
				$a[$i][3] = $r["CodiClient"];
				$i++;
			}
			return $a;
			
		}
		
		function getnomclient($client,$desti){
			$query = $this->db->get_where('Clients', array('CodiEmpresa' => $desti, 'CodiClient' => $client));
			$nom="";
			$i=0;
			 foreach($query->result_array() as $r){
				 if(strtoupper($r["RaoSocial1"])==strtoupper($r["RaoSocial2"])){
					 $nom = $r["RaoSocial1"];
				 }else{
					 $nom = strtoupper($r["RaoSocial1"]).' - '.strtoupper($r["RaoSocial2"]);
				 }
				$i++;
			}
			$this->db->last_query();

			//Returns the last query that was run (the query string, not the result). Example:
			$str = $this->db->last_query();
			echo $str;
			if($i==0){
				return 0;
			}
			else{
				return $nom;
			}
		}
		
		function seleccionarfitxatges($empreses,$datainici,$datafi,$incidencies){
			$sql = "SELECT CodiEmpresa, Data, Nom, PrimerCognom, SegonCognom, Fitxa, HE1, HS1, 
			HE2, HS2, HE3, HS3, HE4, HS4, HE5, HS5, Treb, Incid, Sit, Sit2, HABSJ, TipusJ, HABSI, TipusI, Torn
			from ControlPresencia WHERE CodiEmpresa=? and Data between ? and ?";
			
			if($incidencies=="si"){
					$sql .= "and Incid!=''"; 
			} 
				 
			$resultat = $this->db->query($sql,array($empreses,$datainici,$datafi));
			
			$a = array();
			$i=0;
			
			foreach($resultat->result_array() as $r){		
				 $a[$i]["Data"] = $r["Data"];
				 $a[$i]["Nom"] = $r["Nom"];
				 $a[$i]["PrimerCognom"] = $r["PrimerCognom"];
				 $a[$i]["SegonCognom"] = $r["SegonCognom"];
				 $a[$i]["Fitxa"] = $r["Fitxa"];
				 $a[$i]["HE1"] = $r["HE1"];
				 $a[$i]["HS1"] = $r["HS1"];
				 $a[$i]["HE2"] = $r["HS2"];
				 $a[$i]["HS2"] = $r["HS2"];
				 $a[$i]["HE3"] = $r["HE3"];
				 $a[$i]["HS3"] = $r["HS3"];
				 $a[$i]["HE4"] = $r["HE4"];
				 $a[$i]["HS4"] = $r["HS4"];
				 $a[$i]["HE5"] = $r["HS5"];
				 $a[$i]["HS5"] = $r["HS5"]; 
				 $a[$i]["Treb"] = $r["Treb"];
				 $a[$i]["Incid"] = $r["Incid"];
				 $a[$i]["Sit"] = $r["Sit"];
				 $a[$i]["Sit2"] = $r["Sit2"];
				 $a[$i]["HABSJ"] = $r["HABSJ"];
				 $a[$i]["TipusJ"] = $r["TipusJ"];
				 $a[$i]["HABSI"] = $r["HABSI"];
				 $a[$i]["Tipusl"] = $r["TipusI"];
				 $a[$i]["Torn"] = $r["Torn"];
				 $i++;
			}
			return $a;	 
		}
				
		function seleccioColumnes($empreses,$datainici,$datafi){
			$sql = "select count(p.CodiFitxa) as numfiles from Personal pe join Personal_Fitxatges p on(p.CodiFitxa=pe.CodiFitxa) WHERE p.CodiFitxa in (select empt.CodiFitxa from Emplaçaments_treballadors empt where empt.CodiEmpresa=?)and p.Data between ? and ? group BY p.CodiFitxa,p.Data order by count(p.CodiFitxa) DESC Limit 1";
			$resultat = $this->db->query($sql,array($empreses,$datainici,$datafi));
			$columnes=null;
			foreach($resultat->result_array() as $r){		
				 $columnes = $r["numfiles"];
			}
			if($columnes!=null){
				return $columnes;
			}else{
				return -1;
			}
		}
		
		function getarxiu($idarxiu,$tipus){
			$query = $this->db->get_where('Demandes_Arxius', array('CodiArxiu' => $idarxiu, 'Tipus' => $tipus));
			$a = array();
			foreach($query->result_array() as $r){
				$a[] = $r["Extensio"];
				$a[] = $r["nomArxiu"];
				$a[] = $r["Arxiu"];
				
			}
			return $a;
		}
	}
		


	
	
			
				
