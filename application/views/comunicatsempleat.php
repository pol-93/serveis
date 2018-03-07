
	<body>

<div class="container">
	
	<div class="row" style="margin-bottom:20px;">
		<a href="<?php echo site_url("LoginEmpresa/Index"); ?>"><input type="button" class="btn btn-danger" onclick="sortir()" style="float:right;display:block;margin-top:15px;margin-right:15px;" value="Sortir"></input></a>
		<a href="<?php  echo site_url("/LoginEmpresaQr/carregarEmplacamentsValids"); ?>"><input type="button" class="btn btn-danger" style="float:right;display:block;margin-top:15px;margin-right:15px;" value="Veure emplaçaments on he d'anar avui"></input></a>
	</div>
	<form id="f1" name="f1" method="POST" action="<?php echo site_url("Entrada"); ?>">
	<div class="row">
	<div class="col-xs-12 col-md-12">
		<div>
		<select class="form-control" name="codiclient" id="clientinput">
		<?php
			    
			for($i = 0; $i < count($clients);$i++){
				if(isset($client) && $client == $clients[$i]["CodiClient"]){
					echo '<option value="'.$clients[$i]["CodiClient"].'" selected>'.$clients[$i]["Client"].'</option>';
				}else{
					echo '<option value="'.$clients[$i]["CodiClient"].'">'.$clients[$i]["Client"].'</option>';
				}
				
			}
		?>
		</select>	
		</div>
	</div>
	</div>
	<div class="row" style="margin-top:20px;">
		<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
			<?php
			if(isset($check) && $check){
				?>
				<input	type="CheckBox" name="antics" id="Comunicats" style="font-family:helvetica;" checked/> Mostrar Comunicats Antics No Tancats </input>
				<?php
			}else{
				?>
				<input	type="CheckBox" name="antics" id="Comunicats" style="font-family:helvetica;"/> Mostrar Comunicats Antics No Tancats </input>
				<?php
			}
			?>
		</div>
	</div>
	<div class="row">
	   <div class="col-xs-12 col-md-12" style="margin-top:20px;">
		<?php
			if(isset($domicili)){
				?>
				<input type="text" class="form-control" placeholder="Domicili" name="domicili" id="domicili" value="<?php echo $domicili; ?>"></input>
				<?php
			}else{
				?>
				<input type="text" class="form-control" placeholder="Domicili" name="domicili" id="domicili"></input>
				<?php
			}
			?>
		</div>
	</div>
	<div class="row">
		<div style="margin-top:20px;" class="col-xs-12">
			
			<div>
				<div class=" col-sm-3 col-xs-5" style="font-family:arial;float:left;text-align:center;padding-top:3px;margin-right:-30px;"><p>Seleccionar Dia:</p></div>
				<div id="data" class="col-sm-2 col-xs-4">
					<input style="cursor:pointer;display:block;width:90px;border-radius:5px;" name="dia" type="text" id="datepicker3">
					<!--<i style="z-index:2;cursor:pointer;border-radius:5px;display:block;position:absolute;top:2px;left:95px;background-color:gray;padding:2px;" onclick="fertriger()" class="fa fa-bars " aria-hidden="true"></i>-->
				</div>
			<div class="col-sm-2 col-xs-2" style="float:left;text-align:center;"><input class="btn btn-default" style="padding:2px;" type="submit" value="consultar"></div>
			</div>
		</div>
	</div>
	</form>
	<div class="row">
		<div id="tot" style="margin-top:20px;" class="col-xs-8 col-xs-offset-2 col-md-8 col-md-offset-2">
		<?php
		if(count($tasques) == 0){
			echo "<p> No tens cap comunicat obert aquest dia amb aquest client </p>";
			echo '<br>';
			echo '<input type="button" class="btn btn-danger" style="margin:0px auto" value="REOBRIR COMUNICAT" onclick="reobrir()"/>';
		}else{
		$aux = $tasques[0]["CodiParte"];	
		$i=0;
		
		echo "tasques totals: " . count($tasques);
		
		for ($i=0; $i < count($tasques); $i++) {
						?>
								<div class="row" style="padding:2px;padding-right:6px;margin-bottom:25px;">		
									<a href="<?php echo site_url().'/entrada/operacionsambfotos/'.$tasques[$i]["CodiParte"].'/'.$tasques[$i]["Data"].'/'.$dataDP.'/'.$tasques[$i]["CodiDepartament"].'/'.$tasques[$i]["CodiEmpresa"].'/'.$tasques[$i]["Exercici"].'/'.$tasques[$i]["Serie"].'/'.$tasques[$i]["NumeroComanda"].'/'.$tasques[$i]["CodiSeccio"].'/'.$tasques[$i]["CodiEmplaçament"]; ?>">
								<Button class="col-md-12 col-sm-12 col-xs-12 visible-xs visible-md visible-sm visible-lg emplasaments btn btn-gris">
								<?php 
								if($tasques[$i]["Imatge"]!=null){
								?>
									<div class="col-md-5 col-sm-6"><img width="250" <?php echo $tasques[$i]["Imatge"]; ?>/></div>
								<?php
								}
								if($tasques[$i]["Imatge"]==null || $tasques[$i]["Imatge"]==''){
								?>
									<div class="col-md-5 col-sm-6"><img style="border-radius:5px;" width="150" src="<?php echo base_url("assets/img/ubicacio.png"); ?>"/></div>
								<?php
								}
								?>
								<div class="col-md-7 col-sm-6">
								<div style="text-align:left;" class="col-md-12 col-sm-12">Data: <?php echo $tasques[$i]["Data"]; ?></div>
								<div style="text-align:left;" class="col-md-12 col-sm-12">Codi Parte: <?php echo $tasques[$i]["CodiParte"]; ?> </div>
								<br>
								<div style="text-align:left;" class="col-md-12 col-sm-12"><?php echo $tasques[$i]["NomEmplaçament"] . " -  " . $tasques[$i]["Equip"]; ?></div>
								<?php
								if($tasques[$i]["Domicili"]!=''){
								?>
								<div style="text-align:left;" class="col-md-12 col-sm-12">Domicili: <?php echo $tasques[$i]["Domicili"]; ?> </div>	
								<?php
								}								
								if($tasques[$i]["ComandaClient"]!=''){
								?>
								<div style="text-align:left;" class="col-md-12 col-sm-12">Comanda Client: <?php echo $tasques[$i]["ComandaClient"] ; ?></div>	
								<?php
								}
								?>
								</div>
								</Button>
								</a>
								</div>
								<?php
						
						
				}
			}
		?>
	
<span class="glyphicons glyphicons-tick"></span>
</div>

<script>
		

		
		// function fertriger(){
			 // $("#datepicker3").datepicker("show");
		// }
		
		
		$(document).ready(function(){
			
			<?php
			if(isset($dataDP) && $dataDP!=null){
				list($dia, $mes, $anio) = @split('[/.-]', $dataDP);
				echo '$("#datepicker3").datepicker().datepicker("setDate", new Date('.$anio.','.(($mes)-1).','.$dia.'));';
			}
			else{
				echo '$("#datepicker3").datepicker().datepicker("setDate", new Date());';
			 }
			?>
			$("#datepicker3").datepicker();
			$("#datepicker3").datepicker("option", "dateFormat", 'dd-mm-yy');
			// getcomunicats($("#datepicker3").val(),$("#clientinput").val());
		});
		
		function consultar(){
			getcomunicats($("#datepicker3").val(),$("#clientinput").val());
		}

		// function getcomunicats(data,client){
				// $("#tot").empty();
				// $("#missatge").empty();
				// domicili = $("#domicili").val();
				// var string = "";
				// $.ajax({
						// url: "<?php echo site_url()."/entrada/gettasques"; ?>",
						// method: "POST",
						// data: {dia:data,codiclient:client,domicili:domicili,antics:$("#Comunicats").prop('checked')},
						// success: function(resultat){
							// console.log(resultat);
						// if(resultat=='"noregistres"'){
							// $("#bototancar").hide();
							// $( "#posardata" ).hide();
							// string+='<br>';
							// string+='<p style="font-family:Helvetica;font-size:16px;">No hi ha cap comunicat obert per aquesta data</p>';
							// string+='<input type="button" class="btn btn-danger" value="REOBRIR COMUNICAT" onclick="reobrir()"/>';
						// }
						// else{
							// var algo = jQuery.parseJSON(resultat);
							
							// var aux = algo[0][8];
							// var pintat = "NO";
							// var i = 0;
				// for (i = 0; i < algo.length; i++) {
					// if(algo[i][8]!=aux){
						// aux = algo[i][8];
						// pintat = "NO";
						// string+='</div>';				
						// string+='</div>';
						// string += '</div>';
						// $("#tot").append(string);
						// string = "";
						// idoperacions="";
					// }				
					// if(algo[i][8]==aux && pintat=="NO"){
						// string += '<div class="row" style="padding:2px;padding-right:6px;margin-bottom:25px;">';
								// string += '<a href="<?php echo site_url().'/entrada/operacionsambfotos/';?>'+algo[i][8]+'/'+algo[i][5]+'/'+$("#datepicker3").val()+'/'+algo[i][16]+'/'+algo[i][2]+'/'+algo[i][11]+'/'+algo[i][12]+'/'+algo[i][13]+'/'+algo[i][14]+'/'+algo[i][0]+'">';
								// string += '<Button class="col-md-12 col-sm-12 col-xs-12 visible-xs visible-md visible-sm visible-lg emplasaments btn btn-gris">';
								// if(algo[0][4]!=null){
								// string += '<div class="col-md-5 col-sm-6"><img width="250" '+algo[i][4]+'/></div>';
								// }
								// if(algo[0][4]==null || algo[0][4]==''){
									// string += '<div class="col-md-5 col-sm-6"><img style="border-radius:5px;" width="150" src="<?php echo base_url("assets/img/ubicacio.png"); ?>"/></div>';
								// }
								// string += '<div class="col-md-7 col-sm-6">';
								// string += '<div style="text-align:left;" class="col-md-12 col-sm-12">Data: '+ algo[i][5] + '</div>';
								// string += '<div style="text-align:left;" class="col-md-12 col-sm-12">Codi Parte: '+ algo[i][8] + '</div>';
								// string+='<br>';
								// string += '<div style="text-align:left;" class="col-md-12 col-sm-12">'+ algo[i][3] + " -  " + algo[i][10] + '</div>';
								// if(algo[i][15]!=''){
								// string += '<div style="text-align:left;" class="col-md-12 col-sm-12">Domicili: '+  algo[i][15] + '</div>';	
								// }
								// if(algo[i][17]!=''){
								// string += '<div style="text-align:left;" class="col-md-12 col-sm-12">Comanda Client: '+  algo[i][17] + '</div>';	
								// }
								// string += '</div>';
								// string += '</Button>';
								// string+='</a>';
						// }
				// }
				
					// $( "#posardata" ).show();
					// $("#bototancar").show();	
					
				// }
					// $("#tot").append(string);
					 // $("body").show();											
					// }
				// });						
			// }
				
		function reobrir(numparte){
			$.ajax({
					method: "POST",
					url: "<?php echo site_url()."/entrada/reobrirparte" ?>",
					data: {dataactual:$("#datepicker3").val()},
					success: function(resultat){
						console.log(resultat);
						if(resultat=="totok"){
							getcomunicats($("#datepicker3").val(),$("#clientinput").val());
						}
						else{
							alert("no podem reobrir el comunicat");
						}
					}
				});			
		}
	

		</script>

		

</body>
</html>
