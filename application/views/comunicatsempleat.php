
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
								<button class="col-md-12 col-sm-12 col-xs-12 visible-xs visible-md visible-sm visible-lg emplasaments btn btn-gris" style="border-radius:4px 4px 0px 0px;white-space: normal;">
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
								<div class="col-md-7 col-sm-6" style="margin-bottom:20px;">
								<div style="text-align:left;" class="col-md-12 col-sm-12"><p class="negreta">Data:</p> <?php echo $tasques[$i]["Data"]; ?></div>
								<div style="text-align:left;" class="col-md-12 col-sm-12"><p class="negreta">Codi Parte:</p> <?php echo $tasques[$i]["CodiParte"]; ?> </div>
								
								<div style="text-align:left;" class="col-md-12 col-sm-12"><p class="negreta">Emplacament:</p><?php echo $tasques[$i]["NomEmplaçament"] . " -  " . $tasques[$i]["Equip"]; ?></div>
								<?php
								if($tasques[$i]["Domicili"]!=''){
								?>
								<div style="text-align:left; word-break: break-all;height:50px;" class="col-md-12 col-sm-12 "><p class="negreta">Domicili:</p>  <?php echo $tasques[$i]["Domicili"]; ?> </div>	
								<?php
								}								
								if($tasques[$i]["ComandaClient"]!=''){
								?>
								<div style="text-align:left;" class="col-md-12 col-sm-12"><p class="negreta">Comanda Client:</p> <?php echo $tasques[$i]["ComandaClient"] ; ?></div>	
								<?php
								}
								?>
								
								</div>
								</button>
								</a>
								<?php
								if($tasques[$i]["Altitud"]!='0' && $tasques[$i]["Longitud"]!='0'){
								?>
								
								<a href="<?php  echo site_url("/Entrada/VisualitzarUbicacio/").$tasques[$i]["Altitud"]."/".$tasques[$i]["Longitud"]."/".$dataDP."/".$tasques[$i]["CodiDepartament"]."/".$tasques[$i]["CodiEmpresa"]."/".$tasques[$i]["Exercici"]."/".$tasques[$i]["Serie"]."/".$tasques[$i]["NumeroComanda"]."/".$tasques[$i]["CodiSeccio"]; ?>"><div style="font-family:helvetica;margin:0px;z-index:100;width:100%;border-radius:0px 0px 4px 4px" class="btn btn-danger"> Consultar ubicacio en Mapa </div></a>
								<?php
								}
								?>
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
		});
		
		function consultar(){
			getcomunicats($("#datepicker3").val(),$("#clientinput").val());
		}

		
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
