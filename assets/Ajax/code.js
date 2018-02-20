function display_geolocation_properties(position)
{
	$("#f1").append("<input type='hidden' name='latitud' value=' " + position.coords.latitude + " '/>");
	$("#f1").append("<input type='hidden' name='altitud' value=' " + position.coords.longitude	 + " '/>");

	document.getElementById("f1").submit();
}

function handle_error(error)
{
	alert("error no hem pogut accedir a la teva localitzacio, codei error:"+error.code);
	//document.form1.capability.value = "ERROR: " + error.code;
	document.getElementById("f1").submit();
}

function retrieve_location()
{
	if (navigator.geolocation)
	{
		navigator.geolocation.getCurrentPosition(display_geolocation_properties, handle_error);
	}
	else
	{
		document.getElementById("f1").submit();
	}
}

$(document).ready(function(){
	setInterval(function(){ horaactual() }, 3000);
	$("#inputdefault").val('');
});

$( "#posarinputs" ).keyup(function() {
		var hola = $(this).val();
		alert(hola);
		$.ajax({
			scriptCharset: "iso-8859-1",
			cache: false,
			type: 'POST',
			url: "assets/Ajax/validar.php",
			data: {eltext:hola},
			success: function(resultat){
				alert(resultat);
				if(resultat==0){
					$("#persones").empty();
				}else{
					$("#persones").empty();
					bonarray = resultat.split(",");
					var i = 1;
					var cadena = "";
					for(i=1;i<bonarray.length;i++){
						cadena = cadena + '<li style="position:relative;" onclick="canviazo(this.innerHTML)" value="'+bonarray[i]+'">'+bonarray[i]+'</li>';
					}
					$("#persones").append(cadena);
				}
			}
		});
});


function canviazo(text){
	$("#posarinputs").val(text);
	$("#persones").empty();
}

function horaactual(){
	$.ajax({
		type: "GET",
		dataType: "php",
		url: '<?php echo base_url(); ?>assets/Ajax/hora.php',
		success: function(data){
			document.getElementById("dataactual").innerHTML=data;
		}
	});
}




