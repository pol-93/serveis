
	<body>
	
		<div class="container-fluid">
		
		<div id="AppendModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="modal-title">Afegir</h2>
			  </div>
			  <div class="modal-body">
				<p>Operacions</p>
				<select id="Operacioafegida" style="width:100%;">
				<option value="Seleccionar una opció" selected disabled>Seleccionar una operacio</option>
				<?php
				for ($i = 0; $i < sizeof($operacionsempl) ; $i++){
					echo '<option value="'.$operacionsempl[$i]["CodiOperacio"].'">'.$operacionsempl[$i]["NomOperacio"].'</option>';
				}
				?>
				</select>
				<br><br>
				<p>Carrec</p>
				<select id="afegircarrec">
				<option value="Seleccionar una opció" selected disabled>Seleccionar una opcio</option>
				<option value="Oficial">Oficial</option>
				<option value="Peo">Peo</option>
				</select>
				<br><br>
				<p>Data inici</p>
				<input id='datepicker2' type="text" readonly />
				<br><br>
				<p>Hores Reals</p>
				<input type="tel" id="afegirhoresreals"/>
				<br><br>
				<input type="button" id="guardarafegit" class="btn btn-info" onclick="guardarafegit()" value="Guardar"/>
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Descartar canvis</button>
			  </div>
			</div>

		  </div>
		</div>
		
		
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="modal-title">Modificar</h2>
			  </div>
			  <div class="modal-body">
			  <p id="missatge1" class="alert alert-danger" style="padding:2px;display:none">Es obligatori posar un valor vàlid</p>
			  <p id="missatge2" class="alert alert-danger" style="padding:2px;display:none">Es obligatori posar un valor numeric</p>
			  <p id="missatge3" class="alert alert-danger" style="padding:2px;display:none">El valor maxim son 8.00 hores</p>
				<p>Hores Reals</p>
				<input type="tel" id="modhoresreals"/>
				<br><br>
				<input type="button" id="guardarmod" class="btn btn-info" onclick="gardarmod()" value="Guardar"/>
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Descartar canvis</button>
			  </div>
			</div>

		  </div>
		</div>
		
		
		<div class="row" style="padding:10px;margin-top:20px;">
		<div style="margin-bottom:10px;" class="col-xs-12 col-md-8 col-md-offset-2">
		<a href="<?php  echo site_url("/LoginEmpresaQr/carregarEmplacamentsValids"); ?>"><input type="button" class="btn btn-danger" style="float:right;display:block;margin-top:15px;margin-right:15px;" value="Veure emplaçaments on he d'anar avui"></input></a>
		<p><a href="<?php echo site_url("entrada/index/") . $comunicatdatepiker; ?>"><input type="button" class="btn btn-danger" style="float:left;display:block;margin-top:15px;margin-right:15px;" value="Enrrere"></a></input></p>
		</div>
		<div id="tot" class="col-xs-12 col-md-8 col-md-offset-2 alert alert-success" style="background-image: linear-gradient(to bottom,#cbcbcb 0,#fbfbfb 100%);border-color: black;">
		
		<?php
		echo '<div class="row" style="color:black;">';
		echo '<div class="col-xs-12 col-md-12">';
		echo'<p style="clear:both;border-bottom:1px solid black;font-size:18px;font-family:helvetica;margin-bottom:10px;">OPERACIONS</p>';
		if(!empty($registres)){
			for ($i = 0; $i < sizeof($registres) ; $i++) {
					$aux = $registres[$i]["CodiOperacio"];
					if($registres[$i]["imatgeoperacio"]=='' || $registres[$i]["imatgeoperacio"]==NULL){
							echo '<div  class="col-xs-12 alert" style="float:left;cursor:default;padding:5px;background-color:#6c6c6c;color:white;margin-bottom: 5px;" data-valid="novalid" data-operacio="si" 
							data-empresacod="'.$comunicatemp.'" data-codioperacio="'.$registres[$i]["CodiOperacio"].'" data-codiparte="'.$registres[$i]["CodiParte"].'"
							data-codiseccio="'.$registres[$i]["CodiSeccio"].'" data-numcomanda="'.$registres[$i]["NumeroComanda"].'" data-exercici="'.$registres[$i]["Exercici"].'"
							data-serie="'.$registres[$i]["Serie"].'" data-codidepartament="'.$registres[$i]["CodiDepartament"].'">'.$registres[$i]["NomOperacio"].'</div>';
							
					}
					else{
						$img = $registres[$i]["imatgeoperacio"];
						$posarla = 'src="data:image/jpg;base64,'.base64_encode($img).'"';
							echo '<div class="col-xs-12 alert" style="float:left;overflow:auto;cursor:default;padding:5px;background-color:#6c6c6c;;color:white;margin-bottom: 5px;" data-valid="novalid" data-operacio="si" data-empresacod="'.$comunicatemp.'" data-codioperacio="'.$registres[$i]["CodiOperacio"].'" data-codiparte="'.$registres[$i]["CodiParte"].'" data-codiseccio="'.$registres[$i]["CodiSeccio"].'" data-numcomanda="'.$registres[$i]["NumeroComanda"].'" data-exercici="'.$registres[$i]["Exercici"].'" data-serie="'.$registres[$i]["Serie"].'"	data-codidepartament="'.$registres[$i]["CodiDepartament"].'">';
							echo '<img style="float:left;" width="35%" '.$posarla.'/>';
							echo '<div style="float:left;margin-left:10px;padding-top:40px;">'.$registres[$i]["NomOperacio"].'</div>';
							echo '</div>';
				}
					echo '<div style="margin-bottom:5px;" class="row">';
							echo '<div class="col-xs-2 col-md-2"> Carrec </div>';
							echo '<div class="col-xs-3 col-md-3"> Data </div>';
							echo '<div class="col-xs-3 col-md-3">Hores Reals</div>';
							echo '<div class="col-xs-1 col-md-1"><i class="fa fa-pencil" aria-hidden="true"></i></div>';
							if($registres[$i]["HoresPlanificades"]==0){
								echo '<div class="col-xs-1 col-md-1"><i class="fa fa-trash" aria-hidden="true"></i></div>';
							}
						echo '</div>';
						echo '<hr style="margin-top: 3px;margin-bottom: 2px;border-top-color: black;width:101%">';
						echo '<div class="row" style="padding:15px;">'; 
					while($registres[$i]["CodiOperacio"]==$aux){
							echo '<div style="margin-bottom:2px;clear:both;" class="row">';
							echo '<div class="col-xs-2 col-md-2">'. $registres[$i]["Carrec"] .'</div>';
							echo '<div class="col-xs-3 col-md-3">'. $registres[$i]["Data"]. '</div>';
							echo '<div class="col-xs-3 col-md-3">'. $registres[$i]["HoresReals"]. '</div>';
							echo '<div class="col-xs-1 col-md-1"><button data-empresacod="'.$comunicatemp.'" data-codioperacio="'.$registres[$i]["CodiOperacio"].'" data-codiparte="'.$registres[$i]["CodiParte"].'"
							data-codiseccio="'.$registres[$i]["CodiSeccio"].'" data-numcomanda="'.$registres[$i]["NumeroComanda"].'" data-exercici="'.$registres[$i]["Exercici"].'"
							data-serie="'.$registres[$i]["Serie"].'" data-codidepartament="'.$registres[$i]["CodiDepartament"].'" data-ordre="'.$registres[$i]["Ordre"].'" class="btn btn-default" onclick="modificarregistre(this)" data-toggle="modal" data-target="#myModal" style="padding:2px;width:20px;"><i class="fa fa-pencil" aria-hidden="true"></i>
							</button></div>';
							if($registres[$i]["HoresPlanificades"]==0){
								echo '<div class="col-xs-1 col-md-1"><button data-empresacod="'.$comunicatemp.'" data-codioperacio="'.$registres[$i]["CodiOperacio"].'" data-codiparte="'.$registres[$i]["CodiParte"].'"
								data-codiseccio="'.$registres[$i]["CodiSeccio"].'" data-numcomanda="'.$registres[$i]["NumeroComanda"].'" data-exercici="'.$registres[$i]["Exercici"].'"
								data-serie="'.$registres[$i]["Serie"].'" data-codidepartament="'.$registres[$i]["CodiDepartament"].'" data-ordre="'.$registres[$i]["Ordre"].'" class="btn btn-danger" onclick="borraroperaciolinia(this)" style="padding:2px;width:20px;"><i class="fa fa-trash" aria-hidden="true"></i>
								</button></div>';
							}
							echo '</div>';
							$i++;
							if(sizeof($registres)==$i){
								break;
							}
							
						}
						$i--;
						echo '</div>';
			}
		}
		echo '<div style="margin-top:20px;margin-bottom:20px;" class="row">';
		echo '<div class="col-xs-10"><input class="btn btn-danger" data-empresacod="'.$comunicatemp.'" data-codiparte="'.$comunicatcod.'"
		data-codiseccio="'.$comunicatcodiseccio.'" data-numcomanda="'.$comunicatnumerocomanda.'" data-exercici="'.$comunicatexercici.'"
		data-serie="'.$comunicatserie.'" data-codidepartament="'.$comunicatdpt.'" style="padding:2px;width:100px;" data-toggle="modal" data-target="#AppendModal" onclick="resetdatepicker(this)" value="Afegir"/></div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '<div class="row" style="color:black;">';
		echo '<div class="col-md-12" style="margin-bottom:20px;">';
		echo '<p style="clear:both;border-bottom:1px solid black;font-size:18px;font-family:helvetica;margin-bottom:10px;">Detall</p>';
		echo '<textarea id="detall" style="resize:none;width:100%;height:100px;">';
		if(!empty($registres)){
			echo $registres[0]["Detall"];
		}
		echo '</textarea>';
		echo '</div>';
		echo '</div>';
		echo '<div class="row" style="color:black;">';
		echo '<div class="col-md-12" style="margin-bottom:20px;">';
		echo '<p style="clear:both;border-bottom:1px solid black;font-size:18px;font-family:helvetica;margin-bottom:10px;">Materials</p>';
		echo '<textarea id="materials" style="resize:none;width:100%;height:100px;">';
		if(!empty($registres)){
			echo $registres[0]["Materials"];
		}
		echo '</textarea>';
		echo '</div>';
		echo '</div>';
		echo '<div class="row" style="color:black;">';
		echo '<div style="clear:both;font-size:18px;font-family:helvetica;" class="col-md-12">';
		echo '<div class="row" style="color:black;">';
		echo '<div style="margin-top:10px;" class="col-md-12">';
		echo '<p style="clear:both;border-bottom:1px solid black;font-size:18px;font-family:helvetica;margin-bottom:10px;">Imatges Comunicat</p>';
		echo '<div style="clear:both;" id="picturescontent" name="picturescontent"></div>';
		echo '</div>';
		echo '</div>';
		echo '<p style="clear:both;border-bottom:1px solid black;font-size:18px;font-family:helvetica;padding-top:10px;margin-bottom:10px;">Data Tancament</p>';
		echo '<input style="cursor:pointer;display:block;width:100px;border-radius:5px;" type="text" id="datepicker"/>';
		echo '<button id="bototancar" data-empresacod="'.$comunicatemp.'" data-codiparte="'.$comunicatcod.'" data-codiseccio="'.$comunicatcodiseccio.'"
		data-numcomanda="'.$comunicatnumerocomanda.'" data-exercici="'.$comunicatexercici.'" data-serie="'.$comunicatserie.'" data-codidepartament="'.$comunicatdpt.'" data-codinumerocomanda="'.$comunicatnumerocomanda.'"
		data-datacomunicat="'.$datacomunicat .'" onclick="retrieve_location()" style="margin-top:15px;font-size:18px;" class="btn btn-danger form-control">
		Guardar</button>';
		?>
		</div>
		</div>

		
		<div style="visibility:hidden" id="loadingDiv"> holaa </div>
		
		
		<script>
	var $loading = $('#loadingDiv').hide();
	$(document)
	  .ajaxStart(function () {
		$loading.show();
	  })
	  .ajaxStop(function () {
		$loading.hide();
	 });

	function callback(aixo){
		if($(aixo).attr("data-valid")=="valid"){
				$(aixo).css("background-color","#5bba5b");
				$(aixo).attr("data-valid","novalid");
		}
		else{
			$(aixo).css("background-color","#ff2E2E");
			$(aixo).attr("data-valid","valid");
		}
	}
	
	function display_geolocation_properties(position)
		{
			callback2(position.coords.latitude+","+position.coords.longitude)
		}
		
		function handle_error(error)
		{
			callback2("no");
		}
		
		function retrieve_location()
		{
			if (navigator.geolocation)
			{
				
				navigator.geolocation.getCurrentPosition(display_geolocation_properties, handle_error);
				
			}
			else
			{
				callback2("no");
			}
		}
		
		function callback2(coordenades){	
				if($("#materials").val().length<150){
					console.log($("#detall").val());
					datatancament = $("#datepicker").val();
					if(datatancament==''){
						datatancament=null;
					}
					console.log(datatancament);
					$.ajax({
							method: "POST",
							url: "<?php echo site_url()."/entrada/tancarparte";?>",
							data: {empresacod:$("#bototancar").attr("data-empresacod"),codiseccio:$("#bototancar").attr("data-codiseccio"),tancarparte:$("#bototancar").attr("data-codiparte"),serie:$("#bototancar").attr("data-serie"),numerocomanda:$("#bototancar").attr("data-numcomanda"),exercici:$("#bototancar").attr("data-exercici"),datausuari:$("#bototancar").attr("data-datacomunicat"),coords:coordenades,material:$("#materials").val(),datatancament:datatancament,detall:$("#detall").val()},
							cache: false,
							success: function(resultat){
								console.log(resultat);
								 if(datatancament!=null){
									 <?php
										echo 'window.location.replace("'. site_url("entrada/index/") . $comunicatdatepiker .'")';
									 ?>
								 }
								 else{
									 alert("Guardat");
								 }
							}
						});
					}
				else{
					alert("no pot superar els 150 carcaters")
				}
			
		}
		
		
		$(document).ready(function(){
			$( "#datepicker" ).datepicker({
			    autoclose: true,
			    todayHighlight: true,
				dateFormat: 'dd-mm-yy'
			});
			
			
			$( "#datepicker2" ).datepicker({
			    autoclose: true,
			    todayHighlight: true,
				dateFormat: 'dd-mm-yy'
			});

			<?php
				
				echo 'maquinaconsulta("'.$datacomunicat .'","'.$comunicatexercici.'","'.$comunicatserie.'","'.$comunicatnumerocomanda.'","'.$comunicatcodiseccio.'","'.$comunicatcod.'","'.$comunicatemp.'");';
				
			?>
		});
		
		function maquinaconsulta(data,exercici,serie,numerocomanda,codiseccio,codicomunicat,comunicatemp){
				var string = "";
				$.ajax({
						method: "POST",
						url: "<?php echo site_url()."/entrada/getfotos"; ?>",
						data: {dia:data,comexercici:exercici,comserie:serie,comnumerocomanda:numerocomanda,comcodiseccio:codiseccio,comcodicomunicat:codicomunicat,comcodiempresa:comunicatemp},
						success: function(resultat){
							console.log("resultat es:"+resultat);
							$("#picturescontent").empty();
							var string = "";
							if(resultat=="noregistres"){
								string += '<div class="row">';
								string+='<div class="col-sm-6 col-xs-6">';
								string+='<div>';
								string += '<form id="FFotoAbans" method="post" enctype="multipart/form-data">';
								string+='<input type="file" data-valor="Abans" data-imatge="arxiuFotoAbans" name="arxiuFotoAbans" id="file" class="inputfile inputfile-2 hidden" onChange="EnviarFoto(this,FFotoAbans)"/>';
								string+='<label for="file" style="font-size:15px;color:#6C6C6C;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size:15px;">Foto Abans</span></label>';
								string += '</form>';
								string+='</div>';
								string +='<div id="fotosabans"></div>';
								string += '</div>';
								string+='<div class="col-sm-6 col-xs-6">';
								string+='<div>';
								string += '<form id="FFotoDespres" method="post" enctype="multipart/form-data">';
								
								string+='<input type="file" data-valor="Despres" data-imatge="arxiuFotoDespres" name="arxiuFotoDespres" id="file-2" class="inputfile inputfile-2 hidden" onChange="EnviarFoto(this,FFotoDespres)" />';
								string+='<label for="file-2 style="font-size:15px;color:#6C6C6C;" style="font-size:15px;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span  style="font-size:15px;">Foto Després</span></label>';
								string += '</form>';
								string+='</div>';
								string+='</div>';
								string +='<div id="fotosdespres"></div>';
								string+='</div>';
							}
							else{
								var algo = jQuery.parseJSON(resultat);
								string+='<div class="col-sm-6 col-xs-6">';
					
								string+='<div>';
								string += '<form id="FFotoAbans" method="post" enctype="multipart/form-data">';
								string+='<input type="file" data-valor="Abans" data-imatge="arxiuFotoAbans" name="arxiuFotoAbans" id="file" class="inputfile inputfile-2 hidden" onChange="EnviarFoto(this,FFotoAbans)"/>';
								string+='<label for="file" style="font-size:13px;color:#6C6C6C;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Foto Abans</span></label>';
									string += '</form>';
								string+='</div>';
								string +='<div id="fotosabans">';
									for (var k = 0; k < algo.length; k++) {
										if(algo[k][6]=='Abans'){
											string+='<div style="position:relative;" data-codiempresa="'+algo[k][0]+'" data-exercici="'+algo[k][1]+'" data-serie="'+algo[k][2]+'" data-numerocomanda="'+algo[k][3]+'" data-seccio="'+algo[k][4]+'" data-parte="'+algo[k][5]+'" data-tipusfotos="'+algo[k][6]+'" data-ordrefotos="'+algo[k][9]+'" onclick="borrar(this)">'
											string+='<div class="btn btn-danger" style="position:absolute;bottom:5px;left:80%;padding:2px 5px;"> <i class="fa fa-trash" aria-hidden="true"></i></div>';
											string+='<img style="display:block;margin-bottom:10px;border:2px solid black;" width="100%" '+algo[k][8]+'/>';
											string+='</div>'
											string+='<br>';
										}
									}

								string+='</div>';
								
								string+='</div>';
								string+='<div class="col-sm-6 col-xs-6">';
								string+='<div>';
								string += '<form id="FFotoDespres" method="post" enctype="multipart/form-data">';
								string+='<input type="file" data-valor="Despres" data-imatge="arxiuFotoDespres"  name="arxiuFotoDespres" id="file-2" class="inputfile inputfile-2 hidden" onChange="EnviarFoto(this,FFotoDespres)" />';
								string+='<label for="file-2" style="font-size:13px;color:#6C6C6C;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Foto Després</span></label>';
								string += '</form>';
								string+='</div>';
								string +='<div id="fotosdespres">';
								for (var k = 0; k < algo.length; k++) {
									if(algo[k][6]=='Despres'){
										string+='<div style="position:relative;" data-codiempresa="'+algo[k][0]+'" data-exercici="'+algo[k][1]+'" data-serie="'+algo[k][2]+'" data-numerocomanda="'+algo[k][3]+'" data-seccio="'+algo[k][4]+'" data-parte="'+algo[k][5]+'" data-tipusfotos="'+algo[k][6]+'" data-ordrefotos="'+algo[k][9]+'" onclick="borrar(this)">'
											string+='<div class="btn btn-danger" style="position:absolute;bottom:5px;left:80%;padding:2px 5px;"><i class="fa fa-trash" aria-hidden="true"></i></div>';
											string+='<img style="display:block;margin-bottom:10px;border:2px solid black;" width="100%" '+algo[k][8]+'/>';
											string+='</div>'
											string+='<br>';
									}
								}
								string +='</div>';
								string+='</div>';
								}
								$("#picturescontent").append(string); 		
					}
				});
		}
		
		function EnviarFoto(foto,formulari){
			
			
			
			var file = foto.files[0];
			
			if (file.type=='image/jpeg' || file.type=='image/png' || file.type=='image/gif'){
			
				var canvas = document.createElement('canvas');
				
				var ctx = canvas.getContext("2d");
				
				var reader = new FileReader;

				reader.onload = function(){		
					
					var image = new Image();

					image.src = reader.result;

					image.onload = function() {
				
							var oc = document.createElement('canvas'),
									octx = oc.getContext('2d');
									
									console.log("height imatge : " + image.height);
									console.log("width imatge : " + image.width);
								if(image.height > 1024 && image.width > 768 || image.height > 768 && image.width > 1024){	
									if(image.height > image.width){
										canvas.height = 1024;
										canvas.width = 768;
										oc.width = 768;
										oc.height = 1024;
									}
									else{
										canvas.height = 768;
										canvas.width = 1024;
										oc.width = 768;
										oc.height = 1024;
									}
								}else{
									if(image.height > image.width){
										canvas.height = image.height;
										canvas.width = image.width;
										oc.width = image.width;
										oc.height = image.height;
									}
									else{
										canvas.height = image.height;
										canvas.width = image.width;
										oc.width = image.width;
										oc.height = image.height;
									}
								}
								//canvas.height = canvas.width * (image.height / image.width);

								// step 1 - resize to 50%
								

								//oc.width = image.width * 0.5;
								//oc.height = image.height * 0.5;
								octx.drawImage(image, 0, 0, oc.width, oc.height);

								/// step 2 - resize 50% of step 1
								octx.drawImage(oc, 0, 0, oc.width, oc.height);

								/// step 3, resize to final size
								ctx.drawImage(oc, 0, 0, oc.width, oc.height,
								0, 0, canvas.width, canvas.height);
								
							
								canvas.toBlob(function(blob) {
									console.log(blob);
									idemplasament = $("#bototancar");
									var nomarxiu = file.name;
									var extension = file.type;
									var formData = new FormData();
									formData.append('codiempresa', $(idemplasament).attr("data-empresacod"));
									formData.append('codiseccio', $(idemplasament).attr("data-codiseccio"));
									formData.append('codiparte', $(idemplasament).attr("data-codiparte"));
									formData.append('codiserie', $(idemplasament).attr("data-serie"));
									formData.append('codinumerocomanda', $(idemplasament).attr("data-codinumerocomanda"));
									formData.append('codiexercici', $(idemplasament).attr("data-exercici"));
									formData.append('extensio', extension);
									formData.append('tipusFotos', $(foto).attr("data-valor"));
									formData.append($(foto).attr("data-imatge"), blob);
									
									  $.ajax({
											
										url: '<?php echo site_url()."/entrada/enviamentParte";?>',
										type: 'POST',
										data: formData,
										cache: false,
										contentType: false,
										processData: false,
									
										success: function (returndata) {
											console.log(returndata);
											var algo = jQuery.parseJSON(returndata);
											
											if($(foto).attr("data-valor")=="Abans"){
												$("#fotosabans").prepend('<div style="position:relative;" data-codiempresa="'+algo[0]+'" data-exercici="'+algo[1]+'" data-serie="'+algo[2]+'" data-numerocomanda="'+algo[3]+'" data-seccio="'+algo[4]+'" data-parte="'+algo[5]+'" data-tipusfotos="'+algo[7]+'" data-ordrefotos="'+algo[6]+'" onclick="borrar(this)"><div class="btn btn-danger" style="position:absolute;bottom:5px;left:80%;"> <i class="fa fa-trash" aria-hidden="true"></i></div><img style="display:block;margin-bottom:10px;border:2px solid black;" width="100%" '+algo[8]+'/></div>');		
												document.getElementById("file").value = "";
											}
											else{
												$("#fotosdespres").prepend('<div style="position:relative;" data-codiempresa="'+algo[0]+'" data-exercici="'+algo[1]+'" data-serie="'+algo[2]+'" data-numerocomanda="'+algo[3]+'" data-seccio="'+algo[4]+'" data-parte="'+algo[5]+'" data-tipusfotos="'+algo[7]+'" data-ordrefotos="'+algo[6]+'" onclick="borrar(this)"><div class="btn btn-danger" style="position:absolute;bottom:5px;left:80%;"><i class="fa fa-trash" aria-hidden="true"></i></div><img style="display:block;margin-bottom:10px;border:2px solid black;" width="100%" '+algo[8]+'/></div>');
												document.getElementById("file-2").value = "";
											}
											
										}
										  
									  });
								
								
								
								}, file.type, 1.00);
								
							}
							

							
						};

				

					reader.readAsDataURL(file);
					
					
					}
					else{
						alert("formats de imatges acceptats: JPG, PNG, GIF");
					}
				}
		
		
		function borrar(aixo){
			 $.ajax({
					url: '<?php echo site_url()."/entrada/borrarfoto";?>',
					method: 'POST',
					data: {codiempresa:$(aixo).attr("data-codiempresa"),codiexercici:$(aixo).attr("data-exercici"),codiserie:$(aixo).attr("data-serie"),numcom:$(aixo).attr("data-numerocomanda"),seccio:$(aixo).attr("data-seccio"),parte:$(aixo).attr("data-parte"),tipusfotos:$(aixo).attr("data-tipusfotos"),ordrefotos:$(aixo).attr("data-ordrefotos")},
					success: function (returndata) {
						if(returndata=='ok'){
							$(aixo).remove();
						}
						else{
							alert("error! no s'ha pogut esborrar la foto");
						}
					}
				  });
			}
	
		function modificarregistre(aixo){
			horesReal = $(aixo).parent().siblings().eq(3).text();
			horainici = $(aixo).parent().siblings().eq(2).text();
			console.log(horainici);
			$("#modhoresreals").val(horesReal);
			nodeguardat = $(aixo);
			console.log(nodeguardat);
		}
		
		function gardarmod(){
		
			console.log(parseInt($("#modhoresreals").val()));
			nouvalor = $("#modhoresreals").val();
			nouvalor = nouvalor.replace(",", ".");
			
			if(($("#modhoresreals").val()==null) || (typeof($("#modhoresreals").val()))=="undefined" || ($("#modhoresreals").val()=='')){
				$("#missatge1").fadeIn().delay(4000).fadeOut('slow');
				return;
			}
			if(isNaN(nouvalor)==true){
				$("#missatge2").fadeIn().delay(4000).fadeOut('slow');
				return;
			}
			if (parseInt(nouvalor)>8){
				$("#missatge3").fadeIn().delay(4000).fadeOut('slow');
				return;
			}
			console.log("hola");
			 $.ajax({
				url: '<?php echo site_url()."/entrada/actualitzarHoresTasca";?>',
				method: 'POST',
				data: {HoresReals:nouvalor,codiempresa:$(nodeguardat).attr("data-empresacod"),codioperacio:$(nodeguardat).attr("data-codioperacio"),codiexercici:$(nodeguardat).attr("data-exercici"),codiserie:$(nodeguardat).attr("data-serie"),numcom:$(nodeguardat).attr("data-numcomanda"),seccio:$(nodeguardat).attr("data-codiseccio"),codiparte:$(nodeguardat).attr("data-codiparte"),codidepartament:$(nodeguardat).attr("data-codidepartament"),codiordre:$(nodeguardat).attr("data-ordre")},
				success: function (returndata) {
					 $('#myModal').modal('toggle');
					$(nodeguardat).parent().siblings().eq(2).text(nouvalor);
				}
				
			  });
			
			
			
			
			
		}
		
		function borraroperaciolinia(aixo){
			 $.ajax({
				url: '<?php echo site_url()."/entrada/borraroperaciolinia";?>',
				method: 'POST',
				data: {codiempresa:$(aixo).attr("data-empresacod"),codioperacio:$(aixo).attr("data-codioperacio"),codiexercici:$(aixo).attr("data-exercici"),codiserie:$(aixo).attr("data-serie"),numcom:$(aixo).attr("data-numcomanda"),seccio:$(aixo).attr("data-codiseccio"),codiparte:$(aixo).attr("data-codiparte"),codidepartament:$(aixo).attr("data-codidepartament"),codiordre:$(aixo).attr("data-ordre")},
				success: function (returndata) {
					$(aixo).parent().parent().fadeOut();
					location.reload(); 
				}
				
			  });
		}
		
		function resetdatepicker(aixo){
			nodeguardat = $(aixo);
			$( "#datepicker2" ).val("");
		}
		
		function guardarafegit(){
		
			console.log($("#Operacioafegida").val());
			console.log("hola");
		
			 $.ajax({
				url: '<?php echo site_url()."/entrada/afegirliniaoperacio";?>',
				method: 'POST',
				data: {dia:$("#datepicker2").val(),Carrec:$("#afegircarrec").val(),HoresReals:$("#afegirhoresreals").val(),codiempresa:$(nodeguardat).attr("data-empresacod"),codioperacio:$("#Operacioafegida").val(),codiexercici:$(nodeguardat).attr("data-exercici"),codiserie:$(nodeguardat).attr("data-serie"),numcom:$(nodeguardat).attr("data-numcomanda"),seccio:$(nodeguardat).attr("data-codiseccio"),codiparte:$(nodeguardat).attr("data-codiparte"),codidepartament:$(nodeguardat).attr("data-codidepartament"),codiordre:$(nodeguardat).attr("data-ordre")},
				success: function (returndata) {
					var date = $("#datepicker2").val();
					var newdate = date.split("-").reverse().join("-");
				console.log(returndata);
				location.reload(); 
			}
			
			  });
		
			
		}
	
		</script>


</body>
</html>
