<?php
	 $text = $_POST['eltext'];
	 if($text!=""){
		 
	 $enlace = mysqli_connect("localhost", "auriasoft", "G35t10$16", "AuriaSoft");
	if (!$enlace) {
		echo	 "Error: No se pudo conectar a MySQL." . PHP_EOL;
		echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
		echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}

	$sql = 'SELECT Noms FROM Personal where Noms like "'.$text.'%" Limit 20';
	$lastring="";
	if ($resultado = $enlace->query($sql)) {
			if (!$resultado) {
				echo "no hi ha resultat";
				exit;
			}
			$row_cnt = $resultado->num_rows;
			if ($row_cnt == 0) {
				echo "numero de columnes es 0";
				exit;
			}

			while ($fila = $resultado->fetch_row()) {
				$lastring=$lastring.",".$fila[0];
		}
	}
	

	mysqli_close($enlace);

	echo utf8_encode($lastring);
	}
	else{
		echo 0;
	}
?>
