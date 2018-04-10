
<body> 
	<div id="loading-image" style="display:none;position:absolute;opacity:0.7;width:100%;height:100%;z-index:100;background-color:gray;">
	  <img style="position:absolute;left:50%;top:50%;margin-top:-75px;margin-left:-75px;" src='<?php echo base_url()."/assets/img/loading.svg"; ?>'/>
	</div>
	
	<div id="visualitzaciocomunicats" class="container-fluid">
	<div class="row">
	<div class="col-xs-8 col-xs-offset-2 col-md-8 col-md-offset-2">
		<input type="button" class="btn btn-danger" onclick="sortir()" style="float:right;display:block;" value="Sortir"></input>
	</div>
		
	</div>
		<div class="row">	
			<?php
			if (strpos($_SESSION['permis'], 'consultes') !== false){
			?>
				<div style="float:left;margin:10px;"><input onclick="carrega('c')" type="button" class="btn btn-default" value="Consultar Comunicats"></input></div>
			<?php
			}
			if (strpos($_SESSION['permis'], 'consultes_fitxatges') !== false){
			?>
				<div style="float:left;margin:10px;"><input onclick="carrega('p')" type="button" class="btn btn-default" value="Consultar fitxatges"></input></div>
			<?php
			}
			if (strpos($_SESSION['permis'], 'demandes') !== false){
			?>
				<div style="float:left;margin:10px;"><input onclick="carrega('d')" type="button" class="btn btn-default" value="Realitzar Demanda"></input></div>
				<div style="float:left;margin:10px;"><input onclick="carrega('e');" type="button" class="btn btn-default" value="Estat Demandes"></input></div>
			<?php
			}
			?>
		</div>
		<?php
			if (strpos($_SESSION['permis'], 'consultes') !== false){
		?>
		<div id="consultac">
			<div class="row">
				<div class="col-md-12">
					<p style="font-family:helvetica;font-size:20px;margin:10px 0px 10px 0px;">	Consultar Comunicats </p>
					<div style="overflow:auto;">
					<div style="float:left;margin-top:10px;margin-bottom:20px;width:300px;clear:both;">
						<select class="form-control" id="empresacomunicats" onchange="getclients(this,'#clientcomunicats')">
							<option disabled selected> Seleccionar un Empresa ..</option>
							<?php 
								for($i=0;$i<count($desti);$i++){
									echo '<option value="'.$desti[$i]["CodiEmpresa"].'">'.$desti[$i]["nomEmpresa"].'</option>';
								}
							?>
						</select>
					</div>
					<div style="float:left;margin-top:10px;margin-left:20px;margin-bottom:20px;width:300px;">
						<select class="form-control"id="clientcomunicats">
							<option disabled selected> Seleccionar Client ..</option>
							<?php
								for($i=0;$i<count($clients);$i++){
									echo '<option value="'.$clients[$i]["CodiClient"].'">'.$clients[$i]["Descripcio"].'</option>';
								}
							?>
						</select>
					</div>
					</div>
					<div style="overflow:auto;">
					<div style="width:200px;float:left;"><p id="posardata">Data inici: <input type="text" id="datepicker"></p></div>
					<div style="width:200px;float:left;"><p id="posardata">Data Final: <input type="text" id="datepicker2"></p></div>
					</div>
					<div><input style="margin-top:20px;" class="btn btn-default" type="button" id="botoquery" onclick="getcomunicats()" value="Rebre comunicats"/></div>
				</div>
			</div>
			<div style="margin-top:20px;" class="row">
				<div id="tot" class="col-md-12">
			
				</div>
			</div>
		</div>
			
			<?php
			}
				if (strpos($_SESSION['permis'], 'consultes_fitxatges') !== false){
				?>
					<div id="consultap">
						<div class="row">
							<div class="col-md-12">
								<p>	Consultar Fitxades entre dues dates </p>
								<div style="margin-top:20px;margin-bottom:20px;width:600px;">
									<select class="form-control" id="empresafitxatges">
										<option disabled selected value="defecte"> Seleccionar un destí ..</option>
										<?php 
											for($i=0;$i<count($desti);$i++){
												echo '<option value="'.$desti[$i]["CodiEmpresa"].'">'.$desti[$i]["nomEmpresa"].'</option>';
											}
										?>
									</select>
								</div>
								<div style="width:200px;float:left;"><p id="posardata">Data inici: <input type="text" id="datepicker3"></p></div>
								<div style="width:200px;float:left;"><p id="posardata">Data Final: <input type="text" id="datepicker4"></p></div>
								<div style="clear:both;padding-top:20px;"> <input type="checkbox" id="incidencies" value="Amb incidencies"> Amb incidencies</input></div>
								<div><input style="margin-top:20px;" type="button" id="botoquery" onclick="getfitxades()" value="Rebre Fitxades"/></div>
							</div>
						</div>
						<div style="margin-top:20px;" class="row">
							<div id="tot2" class="col-md-12">

							</div>
						</div>
					</div>
			<?php
				}
				if (strpos($_SESSION['permis'], 'demandes') !== false){
			?>
			<div id="consultad">
				<div class="row" style="margin-bottom:10px;">
					<div class="col-md-12">
						<div style="display:none;" id="missatge" class="alert alert-success">El missatge ha estat enviat</div>
						<h1>	Realitzar demanda </h1>
						<div style="margin-top:20px;margin-bottom:20px;width:600px;">
						<select class="form-control" id="selectdesti" onchange="getclients(this,'#selectclient')">
							<option disabled selected value="defecte"> Seleccionar un destí ..</option>
							<?php 
								for($i=0;$i<count($desti);$i++){
									echo '<option value="'.$desti[$i]["CodiEmpresa"].'">'.$desti[$i]["nomEmpresa"].'</option>';
								}
							?>
						</select>
						</div>
						<div style="margin-top:20px;margin-bottom:20px;width:600px;">
						<select class="form-control" id="selectclient">
							<option disabled selected> Cal seleccionar primer el destí</option>
						</select>
						</div>
						<div id="despresseleccio" style="display:none">
						<div style="overflow:auto;width:655px;">
							<button onclick="enviar()" class="btn btn-default" style="float:right;width:200px;">Enviar</button>
						</div>
						<div>Lloc :</div>
						<div><textarea id="lloc" style="overflow:auto;resize:none" rows="3" cols="75"></textarea></div>
						<div>Descripció Tasca :</div>
						<div><textarea id="descripcio" style="overflow:auto;resize:none" rows="5" cols="75"></textarea></div>
						<div class="col-lg-7">
						<!-- The fileinput-button span is used to style the file input field as button -->
						<span class="btn btn-default fileinput-button">
							<i class="glyphicon glyphicon-plus"></i>
							<span>Afegir Arxius...</span>
							<input id="files" onchange="filefunction(this,arraydefotos,'imatgespenjades','arraydefotos')" type="file" name="files[]" multiple>
						</span>
						</button>
						<!-- The global file processing state -->
						<span class="fileupload-process"></span>
					</div>
					</div>
					</div>
				</div>
				<div id="imatgespenjades" style="display:none"></div>
				
				<div style="margin-top:20px;" class="row">
					<div id="tot2" class="col-md-12">

					</div>
				</div>
			</div>
			<div id="consultae">
				
				<div style="width:400px;padding:5px;" id="missatgets"></div>
				<div id="formdemandes">
				<div style="float:left;margin-top:10px;margin-bottom:20px;width:200px;clear:both;">
					<select class="form-control" id="empresademanda" onchange="getclients(this,'#clientdemanda')">
						<option disabled selected> Seleccionar un Empresa ..</option>
						<?php 
							for($i=0;$i<count($desti);$i++){
								echo '<option value="'.$desti[$i]["CodiEmpresa"].'">'.$desti[$i]["nomEmpresa"].'</option>';
							}
						?>
					</select>
				</div>
				<div style="float:left;margin-top:10px;margin-left:20px;margin-bottom:20px;width:200px;">
					<select class="form-control"id="clientdemanda">
						<option disabled selected> Seleccionar Client ..</option>
						<?php
							for($i=0;$i<count($clients);$i++){
								echo '<option value="'.$clients[$i]["CodiClient"].'">'.$clients[$i]["Descripcio"].'</option>';
							}
						?>
					</select>
				</div>
				
				<input type="button" name="boto" id="boto" style="margin-top:10px;margin-left:20px;float:left;" value="Consultar" class="btn btn-default" onclick="getestatdemandes()"/>
				</div>
				<div style="clear:both;" id="estatdemandes"></div>
				<div style="clear:both;" id="editardemanda"></div>
			</div>
		
			<?php
				}
			?>
		</div>
	<div id="fotos"></div>
	</body>
	<script>
	

	
	
	
	function sortir(){
			window.location.replace("https://serveis.auriagrup.cat");
		}
		
	function carrega(menu){
		$("#consultac").hide();
		$("#consultap").hide();
		$("#consultad").hide();
		$("#consultae").hide();
		$("#consulta"+menu).show();
	}
	
	
	
	function callback(){
		$("#missatge").show().delay(5000).fadeOut();
		$("#lloc").val('');
		$("#descripcio").val('');
		$("#imatgespenjades").empty();
		arraydefotos = [];
	}

	
		
	<?php
		if (strpos($_SESSION['permis'], 'consultes') !== false){
	?>
	
	function incidencies(){
		alert("Bon dia");
	}
	
	function getcomunicats(){
			$('#loading-image').show();
			if($("#clientcomunicats").val() == null && $("#empresacomunicats").val() == null){
				alert("es obligatori seleccionar la empresa i el client");
				$('#loading-image').hide();                                                                         
				return;
			}
			$.ajax({
				url: "<?php echo site_url("Consultes/obtenircomunicats"); ?>",
				data:{datainici:$("#datepicker").val(),datafi:$("#datepicker2").val(),codiEmpresa:$("#empresacomunicats").val(),codiClient:$("#clientcomunicats").val()},
				method: "POST",
				success: function(resultat){
					$('#loading-image').hide();
					if(resultat=="ok" || resultat=='XD'){
						alert("Cap resultat");
					}
					else{
						$("#tot").empty();
						console.log(resultat);
						var algo = jQuery.parseJSON(resultat);
						var lastring="";			
						lastring+='<div class="table-responsive">';
						lastring+='<table class="table">';
						lastring+='<thead><tr><th>Nom Emplaçament</th><th>Domicili</th><th>Nom Operacio</th><th>Nom Operari</th><th> Data Planificacio </th><th>Data Tancament</th><th>estat</th></th><th>Fotos</th></tr></thead>';
						for(var i = 0; i < algo.length; i++) {
								lastring+='<tbody>';
							    lastring+='<tr>';
								lastring+='<td>'+algo[i][0]+'</td>';
								lastring+='<td>'+algo[i][12]+'</td>';
								lastring+='<td>'+algo[i][1]+'</td>';
								lastring+='<td>'+algo[i][13]+'</td>';
								lastring+='<td>'+algo[i][2]+'</td>';
								lastring+='<td>'+algo[i][3]+'</td>';
								if(algo[i][4]!=0){
									lastring+='<td>Fet</td>';
								}
								else{
									lastring+='<td>No Fet</td>';
								}
							
								if(algo[i][11]!=""){
									lastring+='<td><button data-codemp='+algo[i][5]+' data-exercici='+algo[i][6]+' data-serie='+algo[i][7]+' data-numcom='+algo[i][8]+' data-codiseccio='+algo[i][9]+' data-codiparte='+algo[i][10]+' onclick="getfotos(this)" type="button" class="btn btn-default">veure fotos</button></td>';
								}
							    lastring+='</tr>';
								lastring+='</tbody>';
						}
						  lastring+='</table>';
						lastring+='</div>';
					}
					$("#tot").append(lastring);	
				 }
			});
		}
	
		function getfotos(aixo){
			window.scrollTo(0, 0);
			$('html, body').css({
			overflow: 'hidden',
			height: '100%'
			});
			$('#loading-image').show();
			$.ajax({
				url: "getfotossensedata",
				data:{comcodiempresa:$(aixo).attr("data-codemp"),comexercici:$(aixo).attr("data-exercici"),comserie:$(aixo).attr("data-serie"),comnumerocomanda:$(aixo).attr("data-numcom"),comcodiseccio:$(aixo).attr("data-codiseccio"),comcodicomunicat:$(aixo).attr("data-codiparte")},
				method: "POST",
				success: function(resultat){
					$('#loading-image').hide();
					$("body").removeClass("loading");
					console.log(resultat);
					if(resultat!='noregistres'){
							//console.log(resultat);
							var algo = jQuery.parseJSON(resultat);
							
							var lastring = "";
							lastring +='<div style="width:625px;margin:0px auto;">';
							lastring+= '<div style="float:right"><button class="btn btn-default" onclick="endarrere()">Endarrere</button></a></div>';
							lastring+= '<table style="float:left;clear:both;"><tr><td style="text-align:center;font-family:helvetica;"><h2>Abans</h2></td></tr>';
							i=0;
							token = 0;
							while(i < algo.length){
									if(algo[i][6]=='Abans'){
										lastring+= '<tr><td><img width=300 '+algo[i][8]+'/></td></tr>';
									}
									else{
										if(token==0){
											lastring+= '</table><table style="float:left;margin-left:20px;"><tr><td style="text-align:center;font-family:helvetica;"><h2>Després</h2></td></tr>';
											token++;
										}
										lastring+= '<tr><td><img width=300 '+algo[i][8]+'/></td></tr>';
									}
							i++;
							}
							lastring+= '</table>';
							lastring+= "</div;";
							$("#visualitzaciocomunicats").hide();
							$("#fotos").empty();
							$("#fotos").append(lastring);
							$("#fotos").show();
							$('html, body').css({
							overflow: 'auto',
							height: 'auto'
						});
					}
				}
			});	
		}
		
		function endarrere(){
			$("#visualitzaciocomunicats").show();
			$("#fotos").empty();
			$("#fotos").hide();
		}
		<?php
		}
		?>
		
	<?php
	if (strpos($_SESSION['permis'], 'consultes_fitxatges') !== false){
	?>	
		function getfitxades(){
			var incidencies = "no"
			if($("#incidencies").prop('checked')==true){
				incidencies = 'si';
			}
			console.log("aqui"+$("#empresafitxatges").val());
			$('#loading-image').show();
			$.ajax({
				url: "<?php echo site_url("/Consultes/obtenirfitxades"); ?>",
				data:{datainici:$("#datepicker3").val(),datafi:$("#datepicker4").val(),empresa:$("#empresafitxatges").val(),incidencies:incidencies},
				method: "POST",
				success: function(resultat){
					console.log(resultat);
					$('#loading-image').hide();
					$("body").removeClass("loading");
					$("#tot2").empty();
					if(resultat=='ok'){
						alert("No hi ha cap fitxatge registrat");
					}
					else{
					var query = jQuery.parseJSON(resultat);
					
					lastring="";
					lastring+='<div class="table-responsive">';
					lastring+='<table class="table">';
					lastring+='<thead><tr><th>Data</th><th>Nom Treballador</th><th>Fitxa</th>';
					lastring+='<th>HE1</th><th>HS1</th><th>HE2</th><th>HS2</th>';
					lastring+='<th>HE3</th><th>HS3</th><th>HE4</th><th>HS4</th>';
					lastring+='<th>HE5</th><th>HS5</th><th>Treb</th>';
					lastring+='<th>Incidencies</th>';
					lastring+='<th>Sit</th><th>Sit2</th><th>HABSJ</th><th>TipusJ</th>';
					lastring+='<th>HABSI</th><th>Tipusl</th><th>TipusTorn</th>';
					lastring+='</tr></thead>';

					lastring+='<tbody>';
					

					for (var i = 0; i < query.a.length; i++) {
							lastring+='<tbody>';
							lastring+='<tr>';

							lastring+='<td>'+query.a[i]["Data"]+'</td>';

							lastring+='<td>'+query.a[i]["Nom"]+''+query.a[i]["PrimerCognom"]+''+query.a[i]["SegonCognom"]+'</td>';
							lastring+='<td>'+query.a[i]["Fitxa"]+'</td>';
							lastring+='<td>'+query.a[i]["HE1"]+'</td>';
							lastring+='<td>'+query.a[i]["HS1"]+'</td>';
							lastring+='<td>'+query.a[i]["HE2"]+'</td>';
							lastring+='<td>'+query.a[i]["HS2"]+'</td>';
							lastring+='<td>'+query.a[i]["HE3"]+'</td>';
							lastring+='<td>'+query.a[i]["HS3"]+'</td>';
							lastring+='<td>'+query.a[i]["HE4"]+'</td>';
							lastring+='<td>'+query.a[i]["HS4"]+'</td>';
							lastring+='<td>'+query.a[i]["HE5"]+'</td>';
							lastring+='<td>'+query.a[i]["HS5"]+'</td>';
							
							lastring+='<td>'+query.a[i]["Treb"]+'</td>';
							
							lastring+='<td>'+query.a[i]["Incid"]+'</td>';
							lastring+='<td>'+query.a[i]["Sit"]+'</td>';
							lastring+='<td>'+query.a[i]["Sit2"]+'</td>';
							lastring+='<td>'+query.a[i]["HABSJ"]+'</td>';
							lastring+='<td>'+query.a[i]["TipusJ"]+'</td>';
							lastring+='<td>'+query.a[i]["HABSI"]+'</td>';
							lastring+='<td>'+query.a[i]["Tipusl"]+'</td>';
							lastring+='<td>'+query.a[i]["Torn"]+'</td>';
							lastring+='</tr>';
							lastring+='</tbody>';
						
					}
					
					lastring+='</table>';
					lastring+='</div>';	
					$("#tot2").append(lastring);									
					}
				 }
			});
		}
		
		<?php 
			}
		?>
		
		$( function(){
			$( "#datepicker" ).datepicker();
			$( "#datepicker2" ).datepicker();
			$( "#datepicker3" ).datepicker();
			$( "#datepicker4" ).datepicker();
		});
		
		<?php
		if (strpos($_SESSION['permis'], 'demandes') !== false){
		?>
	
	function getclients(aixo,divdesti){
		 $.ajax({
				url: 'obtenirclients',
				type: 'POST',
				data: {CodiEmpresa:$(aixo).val()},
				success: function (returndata) {
				console.log(returndata);
					var algo = jQuery.parseJSON(returndata);
					console.log(returndata);
					lastring = '';
					for(var i = 0; i < algo.length; i++){
						if(algo[i]["RaoSocial1"].toUpperCase()==algo[i]["RaoSocial2"].toUpperCase()){
							lastring += '<option value='+algo[i]["CodiClient"]+'> '+algo[i]["RaoSocial1"].toUpperCase()+' </option>';
						}
						else if(algo[i]["RaoSocial2"].toUpperCase() == '' || algo[i]["RaoSocial2"].toUpperCase()==null){
							lastring += '<option value='+algo[i]["CodiClient"]+'> '+algo[i]["RaoSocial1"].toUpperCase()+ ' </option>';
						}
						else{
							lastring += '<option value='+algo[i]["CodiClient"]+'> '+algo[i]["RaoSocial1"].toUpperCase()+' - ' + algo[i]["RaoSocial2"].toUpperCase() + ' </option>';
						}
					}
					$(divdesti).empty();
					$(divdesti).append(lastring);
					$("#despresseleccio").fadeIn();
					$("#imatgespenjades").fadeIn();
				}
		});
	}
		
	function comprovarformat(tipus){
		if(tipus=='application/x-bzip'){
			return 0;
		}
		if(tipus=='application/x-bzip2'){
			return 0;
		}
		if(tipus=='application/epub+zip'){
			return 0;
		}
		if(tipus=='application/zip'){
			return 0;
		}
		if(tipus=='application/x-zip-compressed'){
			return 0;
		}
		if(tipus=='application/x-7z-compressed'){
			return 0;
		}
		if(tipus=='application/octet-stream'){
			return 0;
		}
		return true;
	}

	function enviar(){
		$('#loading-image').show();
		var client = $("#selectclient").val();
		var desti = $("#selectdesti").val();
		
		var formData = new FormData();
			for (i=0;i<arraydefotos.length;i++){
				formData.append('imatge'+i+'', arraydefotos[i]); 
			}
			formData.append('imatgestotals', arraydefotos.length); 
			formData.append('lloc',$("#lloc").val());
			formData.append('descripcio',$("#descripcio").val());
			formData.append('client',client);
			formData.append('desti',desti);
			  $.ajax({
				url: 'enviamentDemanda',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function (returndata) {
					$('#loading-image').hide();
					console.log(returndata);
					$("body").removeClass("loading");
					callback();
					$("#despresseleccio").hide();
					$("#imatgespenjades").hide();
					$("#selectdesti").val("defecte");
					$("#selectclient").empty();
					$("#selectclient").append('<option>Cal seleccionar primer el destí</option>');
				}
			  });
	 }

		function filefunction(fotos,contenidor,divdesti,nomarray){
		var file = fotos.files[0];
		if(file.size<2087790){
			if(comprovarformat(file.type)!=0){
				if(typeof file != 'undefined'){
					contenidor[contenidor.length] = file;
					penjarfotos = document.getElementById(divdesti);
					console.log("--------------------");
					var div = document.createElement('div');
					var p = document.createElement('p');
					var br = document.createElement('br');
					console.log(file.type);
					$(p).append(file.name);
					prova = contenidor.length;
					prova--;
					br.id=prova;
					$(div).append('<button style="position:absolute;bottom:0;left:320px;margin-bottom:5px;display:block" onclick="borrar(this,'+nomarray+','+divdesti+')" data-position="'+prova+'" type="button" class="btn btn-danger delete"><i class="fa fa-trash" aria-hidden="true"></i><span style="margin-left:3px;font-family:helvetica;">Borrar</span></button>');
					p.style = 'position:absolute;bottom:0;left:120px;width:200px;overflow:hidden;';
					var img = document.createElement('img');
					if(file.type=='image/jpeg' || file.type=='image/png' || file.type=='image/gif'){
					var files = file,read = new FileReader();
						read.readAsBinaryString(files);
						read.onloadend = function(){
							img.src = 'data:'+file.type+';base64,' + btoa(read.result);
						}
					}else{
						img.src = '<?php echo base_url().'assets/img/DEFAULT.png' ?>';
					}
					img.style = 'width:100px;float:left;';
					div.style = 'width:420px;border:1px solid gray;margin-bottom:5px;display: table-cell; vertical-align: bottom; overflow:auto;position:relative;border-radius:5px;padding:5px;clear:both;';
					div.appendChild(img);
					div.appendChild(p);
					penjarfotos.appendChild(div);
					penjarfotos.appendChild(br);
				}
			else{
				
			}
			}else{
				alert('No es pot afegir el seguent format per a mes informació: https://support.google.com/mail/answer/6590?p=BlockedMessage&visit_id=1-636342348232847782-3057524099&rd=1');
		}
		}else{
			alert("tamany màxmim per arxiu 2MB");
		}
	}
	
	function borrar(aixo,array,divcontenidor){
		$(aixo).parent().remove();
		var pos = $(aixo).attr("data-position");
		var prova = '#'+pos+''; 
		
		$(divcontenidor).find(prova).remove();
		if (typeof $(aixo).attr("data-idarxiu") != 'undefined') {
			imatgesborrades[imatgesborrades.length] = $(aixo).attr("data-idarxiu");			
		}else{
			
			array.splice(pos,1);	
			//aqui queda desordenat i fem bucle per divs per tornar a ordenar el data-position
			var children = $(divcontenidor).children();
			var aux = 0;
			for(var i = 0; i < children.length; i=i+2){
				var tableChild = children[i];
				segonapartat = $(tableChild).children();
				elfinal = segonapartat[0];
				$(elfinal).attr("data-position",aux);
				tableChild = children[i+1];
				$(tableChild).attr("id",aux);
				aux++;
			}
		}  
	}
	
	
	
	function Descarregar(aixo){
		idarxiu = $(aixo).attr("data-idarxiu");
		tipus = $(aixo).attr("data-tipus");
		window.open('./Descarregararxiu/'+idarxiu+'/'+tipus+'/', '_blank');
	}
	
	
		
		function getestatdemandes(){
			console.log($("#empresademanda").val());
			console.log('-------------------------');
			console.log($("#clientdemanda").val());
			if($("#empresademanda").val()!=null && $("#clientdemanda").val()!=null){
				$.ajax({
					url: "obtenirdemandes",
					data:{empresa:$("#empresademanda").val(),client:$("#clientdemanda").val()},
					method: "POST",
					success: function(resultat){
						//$('#loading-image').hide();
						console.log("resultat"+resultat);
						$("#estatdemandes").empty();
						if(resultat=='ok'){
							$("#estatdemandes").append("No hi ha cap demanda");
						}
						else{
							var algo = jQuery.parseJSON(resultat);
							lastring="";
							lastring+='<div class="table-responsive">';
							lastring+='<table class="table">';
							lastring+='<thead><tr><th>Client</th><th>Lloc</th><th>Descripció</th><th>Estat</th><th>Borrar</th><th>Editar / Visualitzar</th>';
							lastring+='</tr></thead>';
							lastring+='<tbody>';
							for (var i = 0; i < algo.length; i++) {
								lastring+='<tr>';
									lastring+='<td style="width:200px">'+algo[i][1]+'</td>';	
									lastring+='<td style="width:100px">'+algo[i][2]+'</td>';	
									lastring+='<td>'+algo[i][3]+'</td>';	
									lastring+='<td style="width:100px">'+algo[i][5]+'</td>';
									if(algo[i][5]=='No iniciat'){
										lastring+='<td><input type="button" onclick="estatdemandes(this)" data-valor="borrar" data-id='+algo[i][0]+' data-empresa='+$("#empresademanda").val()+' data-client='+$("#clientdemanda").val()+' class="btn btn-danger" value="Borrar"/></td>';
										lastring+='<td><input type="button" onclick="estatdemandes(this)" data-valor="editar" data-id='+algo[i][0]+' data-empresa='+$("#empresademanda").val()+' data-client='+$("#clientdemanda").val()+' class="btn btn-info" value="Editar"/></td>';
									}
									else{
										lastring += '<td></td><td><input type="button" onclick="estatdemandes(this)" data-valor="editar" data-id='+algo[i][0]+' data-empresa='+$("#empresademanda").val()+' data-client='+$("#clientdemanda").val()+' data-boto="visualitzar" class="btn btn-default" value="Visualitzar"/></td>';
									}
								lastring+='</tr>';
							}
							lastring+='</tbody>'
							lastring+='</table>';
							lastring+='</div>';	
							$("#estatdemandes").append(lastring);									
						}
						$("body").removeClass("loading");
					}
				});
			}else{
				$("#missatgets p").remove();
				$("#missatgets").append('<p class="alert alert-info" style="padding:5px" >Cal Seleccionar la empresa i el client </p>').fadeIn().delay(5000).fadeOut();
			}
		}
		
		function pintar(visualitzacio,result){
			console.log(result);
			var lastring = "";
			if(visualitzacio == "visualitzar"){
					lastring += '<textarea id="lloc2" style="overflow:auto;resize:none" rows="3" cols="100" disabled>'+result[0][2]+'</textarea></div>';
					lastring += '<div>Descripció Tasca :</div>';
					lastring += '<div><textarea id="descripcio2" style="overflow:auto;resize:none" rows="5" cols="100" disabled>'+result[0][3]+'</textarea></div>';
					lastring += '<div class="col-lg-7">';
					lastring += '<button onclick="tornar()" style="margin-top:10px;" type="reset" class="btn btn-warning cancel">';
					lastring +=	'<i class="fa fa-arrow-circle-left" aria-hidden="true"></i>';
					lastring += '<span style="margin-left:5px;">Tornar</span>';
					lastring += '</button>';
					lastring += '<div id="fotosbd">';
					lastring += '<br>';
				  for(var i = 0 ; i < result.length; i++){
					if(result[i][4]=="SI"){
						lastring += '<div style="width: 490px; border: 1px solid gray; margin-bottom: 5px; display: table-cell; vertical-align: bottom; overflow: auto; position: relative; border-radius: 5px; padding: 5px; clear: both;"><button style="position:absolute;bottom:-2px;left:320px;margin-bottom:5px;display:block" onclick="Descarregar(this)" data-idarxiu="'+result[i][5]+'" data-tipus="'+result[i][10]+'" type="button" class="btn btn-info delete"><i class="fa fa-download" aria-hidden="true"></i><span style="margin-left:3px;font-family:Helvetica"> DESCARREGAR</span></button><img width="100" '+result[i][6]+'><p style="position: absolute; bottom: 0px; left: 120px; width: 200px; overflow: hidden;">'+result[i][7]+'</p></div>';
						lastring += '<br id="ed'+i+'">';
					}
				  }
				  lastring += '</div>';
			}else{
					lastring += '<textarea id="lloc2" style="overflow:auto;resize:none" rows="3" cols="100">'+result[0][2]+'</textarea></div>';
					lastring += '<div>Descripció Tasca :</div>';
					lastring += '<div><textarea id="descripcio2" style="overflow:auto;resize:none" rows="5" cols="100">'+result[0][3]+'</textarea></div>';
					lastring += '<div class="col-lg-7">';
					lastring += '<span class="btn btn-default fileinput-button">';
					lastring += '<input id="files" onchange="filefunction(this,arraydefotos2,\'bonesfotos\',\'arraydefotos2\')" type="file" name="imatges[]" multiple>';
					lastring += '<i class="fa fa-plus-square" aria-hidden="true"></i>';
					lastring += '<span style="margin-left:5px">Afegir arxius ...</span>';
					lastring += '</span>';
					lastring += '<button onclick="guardar('+result[0][0]+','+result[0][8]+','+result[0][9]+')" style="margin-left:10px;" type="submit" class="btn btn-primary start">';
					lastring += '<i class="fa fa-floppy-o" aria-hidden="true"></i>';
					lastring +=	'<span style="margin-left:5px;">Guardar</span>';
					lastring += '</button>';
					lastring += '<button onclick="tornar()" style="margin-left:10px;" type="reset" class="btn btn-warning cancel">';
					lastring +=	'<i class="fa fa-arrow-circle-left" aria-hidden="true"></i>';
					lastring += '<span style="margin-left:5px;">Descartar canvis</span>';
					lastring += '</button>';
					lastring += '<br><br>';
					lastring += '<div id="fotosbd">'
				  for(var i = 0 ; i < result.length; i++){
					if(result[i][4]=="SI"){
						lastring += '<div style="width: 590px; border: 1px solid gray; margin-bottom: 5px; display: table-cell; vertical-align: bottom; overflow: auto; position: relative; border-radius: 5px; padding: 5px; clear: both;"><button style="position:absolute;bottom:0;left:320px;margin-bottom:5px;display:block" onclick="borrar(this,arraydefotos2,\'#fotosbd\')" data-position="ed'+i+'" data-idarxiu="'+result[i][5]+'" type="button" class="btn btn-danger delete"><span style="margin-left:3px;font-family:Helvetica;"><i class="fa fa-trash" aria-hidden="true"></i><span style="margin-left:3px;font-family:helvetica">BORRAR</span></button><button style="position:absolute;bottom:0;left:430px;margin-bottom:5px;display:block" onclick="Descarregar(this)" data-idarxiu="'+result[i][5]+'" data-tipus="'+result[i][10]+'" type="button" class="btn btn-info delete"><i class="fa fa-download" aria-hidden="true"></i><span style="margin-left:3px;font-family:Helvetica">DESCARREGAR</span></button><img width="100" '+result[i][6]+'><p style="position: absolute; bottom: 0px; left: 120px; width: 200px; overflow: hidden;">'+result[i][7]+'</p></div>';
						lastring += '<br id="ed'+i+'">';
					}
				  }
				  lastring += '</div>'
				  lastring += '<div id="bonesfotos">'
				  lastring += '</div>';
			}	
			return lastring;
		}
		
		function estatdemandes(aixo){
			var accio = $(aixo).attr("data-valor");
			var id = $(aixo).attr("data-id");
			var client = $(aixo).attr("data-client");
			var empresas = $(aixo).attr("data-empresa");
			var boto = $(aixo).attr("data-boto");

			$.ajax({
				url: "borrarDemanda",
				data: {iddemanda:id,tipus:accio,client:client,empresa:empresas},
				method: "POST",
				success: function(resultat){
					if(accio=='borrar'){
						$(aixo).parent().parent().remove();
					}
					else{
						  $("#formdemandes").fadeOut( "slow" );
						  $("#estatdemandes").fadeOut( "slow" );
						  $("#editardemanda").empty();
						  $("#editardemanda").hide();
						  var lastring = "";
						  console.log(resultat);
						  var result = jQuery.parseJSON(resultat);
						  lastring += '<div>Lloc :</div>';
						 if(boto=="visualitzar"){
							lastring = pintar("visualitzar",result);
						 }else{
							 lastring = pintar("editar",result);
						 }
					}
					$("#editardemanda").append(lastring);
					$("#editardemanda").delay( 800 ).fadeIn( 400 );
				}
			});	
		}
		
		function guardar(id,empresa,client){
			var formData = new FormData();
			var sizetotal = 0;
			if(arraydefotos2.length!=0){
				for (i=0;i<arraydefotos2.length;i++){
					formData.append('imatge'+i+'', arraydefotos2[i]); 
					sizetotal = sizetotal + arraydefotos2[i].size;
				}	
			}
			if(sizetotal<10000000){
				if(imatgesborrades.length!=0){
					formData.append('imatgesborradestotals', imatgesborrades.length); 
					for (i=0;i<imatgesborrades.length;i++){
						formData.append('idsimatges'+i+'',imatgesborrades[i]); 
					}
				}
				formData.append('imatgestotals', arraydefotos2.length); 
				formData.append('iddemanda',id);
				formData.append('idclient',client);
				formData.append('idempresa',empresa);

				formData.append('lloc',$("#lloc2").val());
				formData.append('descripcio',$("#descripcio2").val());

				  $.ajax({
					url: 'updatearxiudemanda',
					method: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function (returndata) {
						$('#loading-image').hide();
						console.log(returndata);
						imatgesborrades = [];
						arraydefotos2 = [];
						$("body").removeClass("loading");
						$("#estatdemandes").hide();
						getestatdemandes();
						$("#editardemanda").fadeOut(600);
						$("#estatdemandes").delay( 600 ).fadeIn( 600 );
						
					}
				  });
			  }else{
				 alert("Error: Tamany maxim permès 10 MB"); 
			  }
		}
		
		function tornar(){
			$("#editardemanda").fadeOut( 400 );
			$("#estatdemandes").delay( 800 ).fadeIn( 400 );
			$("#formdemandes").delay( 800 ).fadeIn( 400 );
			imatgesborrades = Array();
			arraydefotos2 = Array();
		}
		
		
		<?php } ?>
		
		$(document).ready(function(){	
			$("#datepicker").datepicker("option", "dateFormat", 'dd-mm-yy' );
			$("#datepicker").datepicker().datepicker("setDate", new Date());
			$("#datepicker2").datepicker("option", "dateFormat", 'dd-mm-yy' );
			$("#datepicker2").datepicker().datepicker("setDate", new Date());
			$("#datepicker3").datepicker("option", "dateFormat", 'dd-mm-yy' );
			$("#datepicker3").datepicker().datepicker("setDate", new Date());
			$("#datepicker4").datepicker("option", "dateFormat", 'dd-mm-yy' );
			$("#datepicker4").datepicker().datepicker("setDate", new Date());
			
			<?php
			if (strpos($_SESSION['permis'], 'demandes') !== false){
				echo 'getestatdemandes();';
			}
			if (strpos($_SESSION['permis'], 'consultes') !== false){
				echo '$("#consultap").hide();';
				echo '$("#consultad").hide();';
				echo '$("#consultae").hide();';
			}
			else if (strpos($_SESSION['permis'], 'fitxatges') !== false){
				echo '$("#consultad").hide();';
				echo '$("#consultae").hide();';
			}
			else{
				echo '$("#consultae").hide();';
			}
			?>
			
		});
		
		$('#loading-image').bind('ajaxStart', function(){
			$("#loading-image").show();
		}).bind('ajaxStop', function(){
			$("#loading-image").hide();
		});
		

	</script>
</html>
