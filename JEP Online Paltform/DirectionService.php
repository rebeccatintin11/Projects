<?php
//the php file is used to realize the direction user case

include 'StudentLogin.php';

//get the value of destination address through the request url
if ($_GET['address']) {
	$inputValue = trim($_GET['address']);
} else {
	echo "error";
}
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">
<title>Directions Service for JEP</title>
<style>
html,body,#map-canvas {
	height: 100%;
	margin: 0px;
	padding: 0px
}

#panel {
	top: 5px;
	z-index: 1;
	background-color: #ffffff;
	padding: 5px;
	font-size: 14px;
	font-family: Arial;
	border: 1px solid #999;
	box-shadow: 0 2px 2px rgba(33, 33, 33, 0.4);
	display: none;
}

#directions-panel {
	height: 100%;
	float: right;
	width: 30%;
	overflow: auto;
}

#map-canvas {
	float: left;
	width: 70%;
}

@media print {
	#map-canvas {
		margin: 0;
		width: 100%;
	}
	#directions-panel {
		float: none;
		width: auto;
	}
}
</style>
<!-- call google map api -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
	var map;
	var directionsDisplay;
	var directionsService;
	var stepDisplay;
	var markerArray = [];
	var lat;
	var lng;
	var current;
	var geocoder;
	var currentinfo;

	/* initialize the direction service */
	function initialize() {
		directionsService = new google.maps.DirectionsService();
		
		//make the direction route dragable
		var rendererOptions = {
				draggable : true
			};
		//new a direction renderer. 
		directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
		
		current = new google.maps.LatLng(34.02272852128912, -118.28406984940722); //JEP HOUSE
		
		// new a geocoder to help transfer between LatLng and string address
		geocoder = new google.maps.Geocoder(); 
		getLocation(); //Get geolocation

		//The infowindow is used to display the marker information on the map
		currentinfo = new google.maps.InfoWindow();
		stepDisplay = new google.maps.InfoWindow();
		
		// initialize map
		var mapOptions = {
			zoom : 12,
			center : current
		}
		map = new google.maps.Map(document.getElementById('map-canvas'),
				mapOptions);
				
		//set the direction route with the specific map
		directionsDisplay.setMap(map);
		//set the direction route step descriptions with the specific panel
		directionsDisplay.setPanel(document.getElementById("directions-panel"));

		//set control part into the map
		var control = document.getElementById('panel');
		control.style.display = 'block';
		map.controls[google.maps.ControlPosition.TOP_CENTER].push(control);

		//add map event to listen the direction change
		google.maps.event.addListener(directionsDisplay, 'directions_changed',
				function() {
					showSteps(directionsDisplay.getDirections());
					computeTotalDistance(directionsDisplay.getDirections());
				});
	}

	//get current location
	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition, showError);
		} else {
			document.getElementById("demo").innerHTML = "Geolocation is not supported by this browser.";
		}
	}
	
	//show current location on the map and calculate its route to the destination address
	function showPosition(position) {
		lat = position.coords.latitude;
		lng = position.coords.longitude;
		current = new google.maps.LatLng(lat, lng); //set current location
		decodeLatLng();
		map.panTo(current);
		calcRoute();
	}

	//display the error message based on the error type
	function showError(error) {
		switch (error.code) {
		case error.PERMISSION_DENIED:
			document.getElementById("demo").innerHTML = "User denied the request for Geolocation."
			break;
		case error.POSITION_UNAVAILABLE:
			document.getElementById("demo").innerHTML = "Location information is unavailable."
			break;
		case error.TIMEOUT:
			document.getElementById("demo").innerHTML = "The request to get user location timed out."
			break;
		case error.UNKNOWN_ERROR:
			document.getElementById("demo").innerHTML = "An unknown error occurred."
			break;
		}
	}

	//calculate the routh from the current location to the destination
	function calcRoute() {
		var markerArray = [];

		var start = current;
		var end = "<?php echo $inputValue; ?>";
		// set the transportation mode
		var selectedMode = document.getElementById('mode').value;
		//initialize route request
		var request = {
			origin : start,
			destination : end,
			travelMode : google.maps.TravelMode[selectedMode]
		};
		//send the route request to google
		directionsService.route(request, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				//set the route in the map
				directionsDisplay.setDirections(response);
				//show steps in the map one by one 
				showSteps(response);
			}
		});
	}
	
	// For each step, place a marker, and add the text to the marker's
	// info window. Also attach the marker to an array so we can 
	// keep track of it and remove it when calculating new routes.
	function showSteps(directionResult) {
		if (markerArray) {
			for ( var i = 0; i < markerArray.length; i++) {
				markerArray[i].setMap(null);
			}
		}
		
		var myRoute = directionResult.routes[0].legs[0];

		for ( var i = 0; i < myRoute.steps.length; i++) {
			//initialize a step marker
			var marker = new google.maps.Marker({
				position : myRoute.steps[i].start_location,
				icon : {
					path : google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
					scale : 5
				},
				map : map
			});
			
			//attach the infoWindow to each marker
			attachInstructionText(marker, myRoute.steps[i].instructions);
			markerArray[i] = marker;
		}
	}

	function attachInstructionText(marker, text) {
		//Open an info window when the marker is clicked on, containing the text of the step.
		google.maps.event.addListener(marker, 'click', function() {

			stepDisplay.setContent(text);
			stepDisplay.open(map, marker);
		});
	}

	//calculate the total distance from current location to destination
	function computeTotalDistance(result) {
		var total = 0;
		var myroute = result.routes[0];
		for ( var i = 0; i < myroute.legs.length; i++) {
			total += myroute.legs[i].distance.value;
		}
		total = total / 1000.0;
		document.getElementById('total').innerHTML = total + ' km';
	}
	
	//transfer the LatLng to the string address
	function decodeLatLng() {
		geocoder.geocode({
			'latLng' : current
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {
					map.setZoom(12);
				} else {
					alert('No results found');
				}
			} else {
				alert('Geocoder failed due to: ' + status);
			}
		});
	}
	
	//initialize map when page loaded
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body>
	<div id="panel">
		<b>Mode of Travel: </b>
		<!-- used for the mode select-->
		<select id="mode" onchange="calcRoute();">
			<option value="DRIVING">Driving</option>
			<option value="WALKING">Walking</option>
			<option value="BICYCLING">Bicycling</option>
			<option value="TRANSIT">Transit</option>
		</select>
		<a href="CheckIn.php"><button type="button">Back</button></a>
	</div>
	<div id="directions-panel">
		<p>
			Total Distance: <span id="total"></span>
		</p>
		<p>
			<span id="demo"></span>
		</p>
	</div>
	<div id="map-canvas"></div>
</body>
</html>