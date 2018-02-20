<?php
$datainici = $_REQUEST['datainici'];
$datafi = $_REQUEST['datafi'];
$datainici = date("Y-m-d", strtotime($datainici));
$datafi = date("Y-m-d", strtotime($datafi));



		include "./funcionsComuns.php";
		$link=DB::getConnection();
		$consulta=$link->prepare("SELECT pe.CodiEmpresa, pe.Noms, p.Data, p.Hora, pe.CodiFitxa from Personal pe join Personal_Fitxatges p 
			on(p.CodiFitxa=pe.CodiFitxa) WHERE p.CodiFitxa in (select empt.CodiFitxa from Emplaçaments_treballadors empt where empt.CodiEmpresa=:cc) and 
			p.Data between :d1 and :d2 order by p.Data,pe.CodiFitxa");
			
		$consulta->bindParam(':cc',$_SESSION['empreses']);
		$consulta->bindparam(':d1',$datainici);
		$consulta->bindparam(':d2',$datafi);
		
		$maximcolumnes=$link->prepare("select count(p.CodiFitxa) as numfiles from Personal pe join Personal_Fitxatges p on(p.CodiFitxa=pe.CodiFitxa) 
		WHERE p.CodiFitxa in (select empt.CodiFitxa from Emplaçaments_treballadors empt where empt.CodiEmpresa=:cc)
		and p.Data between :d1 and :d2 group BY p.CodiFitxa,p.Data order by count(p.CodiFitxa) DESC Limit 1 ");
		$maximcolumnes->bindParam(':cc',$_SESSION['empreses']);
		$maximcolumnes->bindparam(':d1',$datainici);
		$maximcolumnes->bindparam(':d2',$datafi);
		
		try {
			if ($consulta->execute()) {
				
				$registres=$consulta->fetchAll(PDO::FETCH_ASSOC);

			}
			if ($maximcolumnes->execute()) {
				$columnes=$maximcolumnes->fetchAll(PDO::FETCH_ASSOC);
				$columnes = $columnes[0]["numfiles"];
			}
		} catch (PDOException $e) {
			die("error");
		}

	if(!$registres) {
		echo "ok";
 		die;
	}
	else{
		$a = array();
		$i=0;
		foreach($registres as $r) {
			$a[$i][0] = $r["CodiEmpresa"];
			$a[$i][1] = $r["Noms"];
			$a[$i][2] = $r["CodiFitxa"];
			$a[$i][3] = $r["Data"];
			$a[$i][4] = $r["Hora"];
			$i++;
		}
		if(!empty($a)){
		echo json_encode(array("a" => $a, "b" => $columnes));

		}
		else{
			echo "XD";
		}
	}
?>


