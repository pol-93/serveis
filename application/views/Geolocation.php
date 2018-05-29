   <body>
		<a href="<?php echo site_url("Entrada/index/").$DataRetorn; ?>"><div class="btn btn-danger"> Enrrere </div></a>
		<div style="margin-top:20px;">
		<div style="float:left;font-size:9px;"><img width="30" src="<?php echo base_url().'assets/images/tu.png'; ?>"> Ubicacio Actual.</div>
		<div style="float:left;font-size:9px;"><img width="20" src="<?php echo base_url().'assets/images/marker1.png'; ?>"> Ubicacio Comunicat Seleccionat.</div>
		<div style="float:left;font-size:9px;"><img width="20" src="<?php echo base_url().'assets/images/marker2.png'; ?>"> Ubicacio Altres Comunicats.</div>
		</div>
		<br/><br/><br/>
		<div id="map"  style="clear:Both" class="separar"></div>
   
	<script>
	  var latitude;
	  var longitude;
	  var map;
	  var markers = {};
	  var idactual;
	  var extensio = '';
	  var icono = "<?php echo base_url().'assets/images/tu.png'; ?>";
	  var icono2 = "<?php echo base_url().'assets/images/marker1.png'; ?>";
      function initMap() {
   
		 map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: {lat: <?php echo $Latitude ?>, lng: <?php  echo $Longitude; ?>},
		  mapTypeId: 'satellite'
        });

		<?php
		
		for($i=0;$i<count($Comunicats); $i++){
		?>	
		var id = <?php echo $i; ?>;
        var marker<?php echo $i; ?> = new google.maps.Marker({
		  id:id,
		  <?php if($Comunicats[$i]["Altitud"]==$Latitude && $Comunicats[$i]["Longitud"]==$Longitude){ ?>
			position: <?php echo '{lat: '.$Comunicats[$i]["Altitud"].', lng: '.$Comunicats[$i]["Longitud"].'}';?>,
			map: map,
			icon: icono2
		  <?php } else{ ?>
			position: <?php echo '{lat: '.$Comunicats[$i]["Altitud"].', lng: '.$Comunicats[$i]["Longitud"].'}';?>,
			map: map
		  <?php } ?>
        });
		
		markers[id] = marker<?php echo $i; ?>;
		
		google.maps.event.addDomListener(marker<?php echo $i; ?>, 'click', function() {
			idactual = "<?php echo $i; ?>";
			
			window.location.replace("<?php echo site_url("Entrada/operacionsambfotos/").$Comunicats[$i]["CodiParte"]."/".$Comunicats[$i]["Data"]."/".$DataRetorn."/".$Comunicats[$i]["CodiDepartament"]."/".$Comunicats[$i]["CodiEmpresa"]."/".$Comunicats[$i]["Exercici"]."/".$Comunicats[$i]["Serie"]."/".$Comunicats[$i]["NumeroComanda"]."/".$Comunicats[$i]["CodiSeccio"]."/".$Comunicats[$i]["CodiEmplaçament"];?>");
			
			
			
		});
		<?php
		}
		?>
		
		
		if (navigator.geolocation){
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
			console.log(pos);
			 var markerjo = new google.maps.Marker({
			  id:"jo",	
			  position: pos,
			  map: map,
			  icon: icono
			});
				
			markers["jo"] = markerjo;
			
			
			
			
		  });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      
		
		
	

	  
	  
	  
    </script>

     
			
       

        
		  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgxNWRot6OOzgOBr9cbJnCYRTxxK3U9Bg&callback=initMap"> </script>
 </body>
 </html> 





