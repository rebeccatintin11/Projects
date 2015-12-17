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
			<th>Course</th>
			<th>Time</th>
			<th>Site name</th>
			<th>Location</th>
		</tr>
		</thead>
<?php

include 'DBlogin.php';
//input $sql and show the table 
$myusername=$_SESSION['myusername'];
$sql = "SELECT DISTINCT V.course,V.schedule,S.name,S.adress FROM SITES S, VOLUNTEERS V WHERE V.usc_id=" .$myusername. " AND V.site_id = S.site_id";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	echo "<tr class='light'>";
	echo "<td>" . $row['course'] . "</td>";
	echo "<td>" . $row['schedule']. "</td>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['adress'] . "</td>";
	echo "</tr>";
}
?>
</table> </div>
</body>
</html>