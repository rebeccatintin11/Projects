<?php
include 'StudentLogin.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="UTF-8">
<title>JEP Online Platform</title>
<link rel="stylesheet" href="css/layout.css" type="text/css" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<script>
	var req;
	function deleteAnnouncement(id){
		var r=window.confirm("Are you sure you want to delete this permission?");
		if (r==true){
			doRequest("DeleteAnnouncement.php?id='"+id+"'");
		}
	}
	
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
				location.reload();
			} else {
				alert("There was a problem to save into database:\n" + req.statusText);
			}
		}
	}
</script>
</head>
<body>
	<div id="AddNew">
	<button type="button" onclick="">Add New</button>
	</div>
	<div id="TableDable">
	<table border='1' cellpadding='10'>
		<caption style="font-size:150%"><b>Current Announcement</b></caption>
		<thead>
		<tr>
			<th >Site Name</th>
			<th style="width:600px">Announcement</th>
			<th style="width:120px">Start Date</th>
			<th style="width:120px">End Date</th>
			<th>Edit</th>
			<th>delete</th>
		</tr>
		</thead>
<?php

include 'DBlogin.php';
//input $sql and show the table 
$myusername=$_SESSION['myusername'];
$sql = "SELECT DISTINCT S.name, A.* FROM Announcement A, SITES S WHERE A.staff_id=" .$myusername. " AND A.site_id = S.site_id";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	echo "<tr class='light'>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['announcement']. "</td>";
	echo "<td>" . $row['start_date'] . "</td>";
	echo "<td>" . $row['end_date'] . "</td>";
	$id="".$row['announcement_id'];
	echo "<td><a href=''> <img src='images/edit.png' width='20' height='20' /></a></td>";
	echo "<td><a href='#' onClick=\"deleteAnnouncement('".$id."');\"><img src='images/delete.png'  width='20' height='20' /></a></td>";
	echo "</tr>";
}
?>
</table> </div>
</body>
</html>