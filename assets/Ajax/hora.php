<?php
$fechaactual = getdate();
			$ladata = "$fechaactual[mday]-$fechaactual[mon]-$fechaactual[year]";
			$algo = $fechaactual['minutes'];
			if($algo<10){
				$lahora = "$fechaactual[hours]:0$fechaactual[minutes]";
			}
			else{
			$lahora = "$fechaactual[hours]:$fechaactual[minutes]";
			}
 echo $ladata." ".$lahora;
?>