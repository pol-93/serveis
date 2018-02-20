/*
var x = document.getElementById("demo");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x = position.coords.latitude;
	document.getElementById("latitud").value = x;	
    x = position.coords.longitude;
	document.getElementById("altitud").value = x;
}
 */
function data(){
	var date = new Date();
	var month = date.getMonth()+ 1;
	var dateString =  date.getDate() + "-" + month + "-" + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes();
	var data = date.getDate() + "-" + month + "-" + date.getFullYear();
	var horam = date.getHours() + ":" + date.getMinutes();
	document.getElementById("hora").innerHTML = "Hora: "+dateString;
	document.getElementById("data").value = data;
	document.getElementById("horamin").value = horam;
}

function myFunction() {
    setInterval(function(){ data(); }, 1000);
}

function start(){
    //getLocation();
	myFunction();
}

function geoFindMe() {
	var output = document.getElementById("out");

	if (!navigator.geolocation){
		output.innerHTML = "<p>Geolocation is not supported by your browser</p>";
		return;
	}

	function success(position) {
		var latitude  = position.coords.latitude;
		var longitude = position.coords.longitude;

		output.innerHTML = '<p>Latitude is ' + latitude + '° <br>Longitude is ' + longitude + '°</p>';

		var img = new Image();
		img.src = "https://maps.googleapis.com/maps/api/staticmap?center=" + latitude + "," + longitude + "&zoom=13&size=300x300&sensor=false";

		output.appendChild(img);
	}

	function error() {
		output.innerHTML = "Unable to retrieve your location";
	}

	output.innerHTML = "<p>Locating…</p>";

	navigator.geolocation.getCurrentPosition(success, error);
}


