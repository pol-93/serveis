<?php
$datainici = $_REQUEST['datainici'];
$datafi = $_REQUEST['datafi'];
$datainici = date("Y-m-d", strtotime($datainici));
$datafi = date("Y-m-d", strtotime($datafi));

session_start();
if($_SESSION['loguejat']!='SI'){
		session_destroy();
		header('Location: https://serveis.auriagrup.cat/');
	}
	else{
		include "./funcionsComuns.php";
		$link=DB::getConnection();

		$consulta=$link->prepare("SELECT e.NomEmplaçament, oc.Domicili, op.NomOperacio, oc.Data, oc.DataTancament, ocf.CodiEmpresa, ocf.Exercici, ocf.Serie, ocf.NumeroComanda, ocf.CodiSeccio ,ocf.CodiParte, if (oc.DataTancament is null, 0,oco.fet) as fet,if (count(ocf.CodiParte)=0, \"\",\"fotos\") as numerofotos from Emplaçaments e 
		inner join OrdresFabricacio_Comunicats oc on (oc.CodiEmpresa=e.CodiEmpresa and oc.CodiEmplaçament=e.CodiEmplaçament and oc.CodiClient=e.CodiClient) 
		inner join OrdresFabricacio_Comunicats_Operacions oco on(oc.CodiParte=oco.CodiParte and oc.CodiEmpresa=oco.CodiEmpresa) inner join Operacions op on (oco.CodiOperacio=op.CodiOperacio and oco.CodiEmpresa=op.CodiEmpresa and oco.CodiDepartament=op.CodiDepartament)
		inner join UsuarisEmpreses ue on (ue.CodiEmpresa=oc.CodiEmpresa and ue.CodiClient=oc.Codiclient) left join OrdresFabricacio_Comunicats_Fotos ocf on (ocf.CodiEmpresa=oc.CodiEmpresa and ocf.Exercici=oc.Exercici and ocf.Serie=oc.Serie and ocf.NumeroComanda=oc.NumeroComanda and ocf.CodiParte=oc.CodiParte)
		WHERE ue.CodiUsuari=:cu and op.CodiEmpresa=:cc and (oc.Data between :d1 and :d2 or oc.DataTancament between :d1 and :d2) group by  e.NomEmplaçament, oc.Domicili, op.NomOperacio, oc.Data, oc.DataTancament, oco.fet 
		order by oc.DataTancament");

		$consulta->bindParam(':cc',$_SESSION['empreses']);
		$consulta->bindparam(':d1',$datainici);
		$consulta->bindparam(':d2',$datafi);
		$consulta->bindparam(':cu',$_SESSION['CodiUsuari']);
		//$consulta->bindParam(':nl',PDO::PARAM_NULL);
		try {
	
			if ($consulta->execute()) {
				
				$registres=$consulta->fetchAll(PDO::FETCH_ASSOC);
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

	if(count($registres)==0) {
		echo "ok";
 		die;
	}
	else{
		
		$a = array();
		$i=0;
		foreach($registres as $r) {
			$a[$i][0] = $r["NomEmplaçament"];
			$a[$i][1] = $r["NomOperacio"];
			$a[$i][2] = $r["Data"];
			$a[$i][3] = $r["DataTancament"];
			$a[$i][4] = $r["fet"];
			$a[$i][5] = $r["CodiEmpresa"];
			$a[$i][6] = $r["Exercici"];
			$a[$i][7] = $r["Serie"];
			$a[$i][8] = $r["NumeroComanda"];
			$a[$i][9] = $r["CodiSeccio"];
			$a[$i][10] = $r["CodiParte"];
			$a[$i][11] = $r["numerofotos"];
			$a[$i][12] = $r["Domicili"];
			$i++;
		}
		if(!empty($a)){
			echo json_encode($a);
		}
		else{
			echo "XD";
		}
	}
	}
?>


