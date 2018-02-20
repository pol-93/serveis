<?php
session_start();
include "./funcionsComuns.php";
//Si es reben dades al parametre dParte vol dir que envia una foto en cas contrari son les dades del formulari.
$estat = "No iniciat";	
	$link=DB::getConnection();
	
	$consulta=$link->prepare('Insert into Demandes_serveis (entitat,lloc,descripcio,CodiUsuari,CodiClient,CodiEmpresa,Estat) values (:en,:lloc,:des,:cd,:cc,:empresa,:es)');
	
	$consulta->bindParam(':en',$_POST["Entitat"]);	
	$consulta->bindParam(':lloc',$_POST["lloc"]);
	$consulta->bindParam(':des',$_POST["descripcio"]);
	$consulta->bindParam(':cd',$_SESSION["CodiUsuari"]);
	$consulta->bindParam(':cc',$_SESSION["clientCod"]);
	$consulta->bindParam(':empresa',$_SESSION["empreses"]);
	$consulta->bindParam(':es',$estat);
	
	$consulta->execute();
	
	$id = $link->lastInsertId(); 
	
	echo $id;
		
	$fotos = $_POST["imatgestotals"];
	echo $fotos;
	echo "-----------------------------------------------------------------------------";
	$arxiu = array();
		$consulta=$link->prepare('Insert into Demandes_Arxius (Arxiu,Extensio,nomArxiu,id_demanda) values (:ar,:ext,:nom,:id)');
	for($i=0;$i<$fotos;$i++){
		$arxiu[$i] = file_get_contents($_FILES['imatge'.$i.'']['tmp_name']);
		$consulta->bindParam(':ar',$arxiu[$i]);	
		$consulta->bindParam(':ext',$_FILES['imatge'.$i.'']['type']);
		$consulta->bindParam(':nom',$_FILES['imatge'.$i.'']['name']);
		$consulta->bindParam(':id',$id);
		$consulta->execute();
	}
	echo "totok";


?>
