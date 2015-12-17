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
</head>
<body>
	<div id="TableDable">
	<table>
		<thead>
		<tr>
			<th>Site Name</th>
			<th>Course</th>
			<th>Phone</th>
			<th>Address</th>
			<th>Direction</th>
			<th>View</th>
			<th>Check in</th>
		</tr>
		</thead>
<?php

include 'DBlogin.php';
//input $sql and show the table 
$myusername=$_SESSION['myusername'];
$sql = "SELECT DISTINCT * FROM SITES S, VOLUNTEERS V WHERE V.usc_id=" .$myusername. " AND V.site_id = S.site_id";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	echo "<tr class='light'>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['course']. "</td>";
	echo "<td>" . $row['phone'] . "</td>";
	echo "<td>" . $row['adress'] . "</td>";
	$address="".$row['adress'];
	$radius="".$row['radius'];
	$siteId="".$row['site_id'];
	$course="".$row['course'];
	$staffid="".$row['pa_usc_id'];
	echo "<td><a href=\"DirectionService.php?address='".$address."'\"><img src='images/direction.png'  width='20' height='20' /></a></td>";
	echo "<td><a href=\"Siteinfo.php?site_id=".$siteId."\"  ><img src='images/view.png'  width='20' height='20' /></a></td>";
	echo "<td><a href=\"CheckInService.php?address='".$address."'&radius='".$radius."'&siteId='".$siteId."'&course='".$course."'&staff='".$staffid."'\"><img src='images/check.jpg'  height='30' /></a></td>";
	echo "</tr>";//direct CheckInService.php with check information
}
?>
</table> </div>
</body>
</html>