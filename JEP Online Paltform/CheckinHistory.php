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
			<th>Site name</th>
			<th>Time</th>
			<th>Status</th>
		</tr>
		</thead>
<?php

include 'DBlogin.php';
//input $sql and show the table 
$myusername=$_SESSION['myusername'];
$sql = "SELECT DISTINCT * FROM SITES S, CHECKINS C WHERE C.usc_id=" .$myusername. " AND C.site_id = S.site_id ORDER BY C.checkin_time DESC";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	$date = date_create($row[checkin_time]);
	echo "<tr class='light'>";
	echo "<td>" . $row['course'] . "</td>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . date_format($date, 'g:ia \o\n l jS F Y') . "</td>";
	echo"<td>"; if($row['return_code']==1){echo "Success";} else{echo "Fail";} echo "</td>";
	echo "</tr>";}
?>
</table> </div>
</body>
</html>