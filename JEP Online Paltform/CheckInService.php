<?php
//The php file is used to implement the checkin user case and save the result into database

include 'StudentLogin.php';
 // connect to DB
 include 'DBlogin.php';

//get the value about address, radius and siteId from the AJAX request
if ($_GET['address'] && $_GET['radius']&&$_GET['siteId']) {
	$destination = trim($_GET['address']);
	$radius = trim($_GET['radius']);
	$siteId = trim($_GET['siteId']);
	$course	= trim($_GET['course']);
	$staffid = trim($_GET['staff']);
} else {
	echo "error";
}

//input $sql and show the table 
$myusername=$_SESSION['myusername'];
$sql = "SELECT * FROM Announcement A, VOLUNTEERS V WHERE V.usc_id=".$myusername." AND V.volunteer_id = A.volunteer_id AND A.staff_id = ".$staffid;
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$announcement = "".$row['announcement'];
?>

<!-- create the html page for the checkin map -->
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="UTF-8">
<title>CheckIn Service for JEP</title>
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

</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
	var map;
	var lat;
	var lng;
	var current;
	var geocoder;
	var sitelocation;
	var radius;
	var currentadd;
	var bounds = new google.maps.LatLngBounds();
	var markersArray = [];
	var siteId;
	var req;
	var course;
	var announcement;
	var staffid;
	var origins=[];
	var destinations=[];
	
	
	//icon used for the destination marker
	var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
	//icon used for the origin marker
	var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';

	//initialize the value got from php to the javascript variable
	function initialize(){
		sitelocation = "<?php echo $destination; ?>";
		radius = <?php echo $radius; ?>;
		siteId = <?php echo $siteId; ?>;
		course = <?php echo $course; ?>;
		announcement = "<?php echo $announcement; ?>";
		staffid = "<?php echo $staffid; ?>";
		// initialize Geocoder which is used to transfer address string to LatLng
		geocoder = new google.maps.Geocoder();
		getLocation(); 
	}
	
	//get current location
	function getLocation() {
		if (navigator.geolocation) {
			//if get current location successfuly, jump to showPosition, otherwises showError
			navigator.geolocation.getCurrentPosition(showPosition, showError);
		} else {
			alert("Geolocation is not supported by this browser.");
		}
	}

	//show  the map, current location and destination into the map
	function showPosition(position) {
		lat = position.coords.latitude;
		lng = position.coords.longitude;
		//initialize the current Latlng
		current = new google.maps.LatLng(lat, lng);
		//set the initial map option 
		var mapOptions = {
			zoom : 12,
			center : current
		}
		//new a map
		map = new google.maps.Map(document.getElementById('map-canvas'),
				mapOptions);
		// select the panel div
		var control = document.getElementById('panel');
		//display control part on the map
		control.style.display = 'block';
		map.controls[google.maps.ControlPosition.TOP_CENTER].push(control);
		//check the check_in
		check_in();
	}

	//display the error message based on the error type
	function showError(error) {
		switch (error.code) {
		case error.PERMISSION_DENIED:
			alert("User denied the request for Geolocation.");
			break;
		case error.POSITION_UNAVAILABLE:
			alert("Location information is unavailable.");
			break;
		case error.TIMEOUT:
			alert("The request to get user location timed out.");
			break;
		case error.UNKNOWN_ERROR:
			alert("An unknown error occurred.");
			break;
		}
	}
	
	//response the ccheckin button
	function checkinupdate(){
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(updatePosition, showError);
		} else {
			alert("Geolocation is not supported by this browser.");
		}
	}
	
	//update the current location
	function updatePosition(position) {
		lat = position.coords.latitude;
		lng = position.coords.longitude;
		current = new google.maps.LatLng(lat, lng); 
		check_in();
	}

	//check checkin result 
	function check_in() {
		//call the google map distance matrix
		var service = new google.maps.DistanceMatrixService();
		//initialize the map distance matrix
		service.getDistanceMatrix({
			origins : [ current ],
			destinations : [ sitelocation ],
			travelMode : google.maps.TravelMode.WALKING,
			unitSystem : google.maps.UnitSystem.IMPERIAL,
			avoidHighways : false,
			avoidTolls : false
		}, callback);
		//set map center to current
		map.panTo(current);
	}

	//callback for check_in DistanceMatrix
	function callback(response, status) {
		//if the system cannot get the distance matrix, display error
		if (status != google.maps.DistanceMatrixStatus.OK) {
			window.alert('Error was: ' + status);
		} else {
			//the origin location
			origins = response.originAddresses;
			
			//the destination location
			destinations = response.destinationAddresses;
			
			//empty the map
			deleteOverlays();
			
			//get the result distance
			var results = response.rows[0].elements;
			
			r=false;
			//compare the distance with radius
			if(results[0].distance.value<=radius){
				var url = "saveCheckIn.php?location='"
						+ origins[0]
						+ "'&returncode='1'&siteId='"
						+ siteId+"'&course='"+course+"'";
				// send request to save the record into database
				doRequest(url);
			}else{
				var url = "saveCheckIn.php?location='"
						+ origins[0]
						+ "'&returncode='0'&siteId='"
						+ siteId+"'&course='"+course+"'";
				// send request to save the record into database
				doRequest(url);
				alert("Checkin Failure!\nCurrent Location is "+origins[0]+".\nThe distance is "+ results[0].distance.text+".");
				addMarker(origins[0], false);
				addMarker(destinations[0], true);
			}
		}
	}
	
	// send request to save the record into database
	function doRequest(url) {
		req = false;
		//initialize AJAX request
		if (window.XMLHttpRequest) {
			try {
				req = new XMLHttpRequest();
			} catch (e) {
				req = false;
			}
		} else if (window.ActiveXObject) {
			try {
				req = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					req = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {
					req = false;
				}
			}
		}
		//send request
		if (req) {
			req.open("GET", url, true);
			req.onreadystatechange = processReqChange;
			req.send(null);
		}
	}
	
	
	
	//process the return result
	function processReqChange() {
		if (req.readyState == 4) {
			if (req.status == 200) {
				r=window.confirm("Successfully Checkin!\n"+announcement);
				//add origin marker in the map
				if (r==true){
				    if ((screen.width < 1024) && (screen.height < 768)){
				    	window.location="mCheckinHistory.php";
				    }
				    else{
				    	window.location="CheckinHistory.php";
				    }
				}else{
					addMarker(origins[0], false);
					addMarker(destinations[0], true);
				}
			} else {
				alert("There was a problem to save into database:\n" + req.statusText);
			}
		}
	}
	
	//add marker to map based on the loscation and icon type
	function addMarker(location, isDestination) {
		var icon;
		if (isDestination) {
			icon = destinationIcon;
		} else {
			icon = originIcon;
		}
		geocoder.geocode({
			'address' : location
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				bounds.extend(results[0].geometry.location);
				map.fitBounds(bounds);
				var marker = new google.maps.Marker({
					map : map,
					position : results[0].geometry.location,
					icon : icon
				});
				markersArray.push(marker);
			} else {
				alert('Geocode was not successful for the following reason: '
						+ status);
			}
		});
	}
	
	//clear the map markers
	function deleteOverlays() {
		if (markersArray) {
			for ( var i = 0; i < markersArray.length; i++) {
				markersArray[i].setMap(null);
			}
		}
		markersArray = [];
	}
 
    function direction(){
    if ((screen.width < 1024) && (screen.height < 768)){
    	window.location = "DirectionService.php?address="+sitelocation;
    }else{
    	window.location = "DirectionService.php?address="+sitelocation;
    	}
    }
    
   function back(){
    if ((screen.width < 1024) && (screen.height < 768)){
    	window.location = "mCheckIn.php";
    }else{
    	window.location = "CheckIn.php";
    	}
    }
   
   //initialize the map
 	google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<!-- the html part for the page -->
<body>
	<div id="map-canvas"> </div>
	<div id="panel">
		<button type="button" onclick="checkinupdate();">Check In</button>
		<button type="button" onclick="direction();">Direction</button>
		<button type="button" onclick="back();">Back</button>
	</div>
</body>
</html>