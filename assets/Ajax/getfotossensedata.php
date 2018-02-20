<?php

session_start();
if($_SESSION['loguejat']!='SI'){
		session_destroy();
		header('Location: http://serveis.auriagrup.cat/');
	}
	else{
		
		
		$comexercici = $_REQUEST['comexercici'];
		$comserie = $_REQUEST['comserie'];
		$comnumerocomanda = $_REQUEST['comnumerocomanda'];
		$comcodiseccio = $_REQUEST['comcodiseccio'];
		$comcodicomunicat = $_REQUEST['comcodicomunicat'];
		$comcodiempresa = $_REQUEST['comcodiempresa'];

		
		
		include "./funcionsComuns.php";
		$link=DB::getConnection();
	
		$consulta=$link->prepare("select ocf.CodiEmpresa,ocf.Exercici,ocf.Serie,ocf.NumeroComanda,ocf.CodiSeccio,ocf.CodiParte,
		ocf.TipusFotos, ocf.Foto, ocf.Extensio, ocf.OrdreFotos, oc.CodiEmplaçament, oc.CodiParte from OrdresFabricacio_Comunicats_Fotos ocf
		inner join OrdresFabricacio_Comunicats oc on (ocf.CodiEmpresa=oc.CodiEmpresa and ocf.Exercici=oc.Exercici and ocf.Serie=oc.Serie 
		and ocf.NumeroComanda=oc.NumeroComanda and ocf.CodiSeccio=oc.CodiSeccio and oc.CodiParte=ocf.CodiParte)
		where oc.CodiEmpresa=:cc and oc.Exercici=:ee and oc.Serie=:ss and oc.NumeroComanda=:nc and oc.CodiSeccio=:cs and oc.CodiParte=:cp order by ocf.TipusFotos,ocf.OrdreFotos");
		
		$consulta->bindParam(':cc',$comcodiempresa);
		$consulta->bindParam(':ee',$comexercici);
		$consulta->bindParam(':ss',$comserie);
		$consulta->bindParam(':nc',$comnumerocomanda);
		$consulta->bindParam(':cs',$comcodiseccio);
		$consulta->bindParam(':cp',$comcodicomunicat);
		
		try {
			if ($consulta->execute()){
				$registres=$consulta->fetchAll(PDO::FETCH_ASSOC);
			
			}
		} catch (PDOException $e){
			die("error 2");
		}
		
		if(count($registres)==0){
			echo "noregistres";
		}
		else{
	
		$b = array();
		$i=0;
		foreach($registres as $r) {
			if($r["Foto"]!='' || $r["Foto"]!=NULL){				
				$b[$i][0] = $r["CodiEmpresa"];
				$b[$i][1] = $r["Exercici"];
				$b[$i][2] = $r["Serie"];
				$b[$i][3] = $r["NumeroComanda"];
				$b[$i][4] = $r["CodiSeccio"];
				$b[$i][5] = $r["CodiParte"];
				$b[$i][6] = $r["TipusFotos"];
				$b[$i][7] = $r["Extensio"];
				$img = generaFoto($r["Foto"]);
				$b[$i][8] = 'src="data:image/'.$b[$i][7].';base64,'.base64_encode($img).'"';
				$b[$i][9] = $r["OrdreFotos"];
				$b[$i][10] = $r["CodiEmplaçament"];
				$b[$i][11] = $r["CodiParte"];
				$i++;
			}
		}
		
			if(!empty($b)){
				echo json_encode($b);
			}
			else{
				echo "XD";
			}
		}
	}
	
?>


