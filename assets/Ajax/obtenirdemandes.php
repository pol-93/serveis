<?php
$Cod = $_POST['CodiUsuari'];

session_start();
if($_SESSION['loguejat']!='SI'){
		session_destroy();
		header('Location: http://serveis.auriagrup.cat/');
	}
	else{
		
		
		include "./funcionsComuns.php";
		$link=DB::getConnection();
		$consulta=$link->prepare("SELECT Id, Lloc, Descripcio, CodiUsuari, Estat from Demandes_serveis WHERE codiUsuari=:cu");
		$consulta->bindParam(':cu',$Cod);
		


		try {
			if ($consulta->execute()) {
				
				$registres=$consulta->fetchAll(PDO::FETCH_ASSOC);
				
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
			$a[$i][0] = $r["Id"];
			$a[$i][1] = "En Desenvolupament";
			$a[$i][2] = $r["Lloc"];
			$a[$i][3] = $r["Descripcio"];
			$a[$i][4] = $r["CodiUsuari"];
			$a[$i][5] = $r["Estat"];
			$i++;
		}
		if(!empty($a)){
			echo json_encode($a);
		}
	}
}
?>


