<?php 
 include 'AdminLogin.php';
?>
<!DOCTYPE html>
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

  <br><a href="AddSite.php" class="button">Add site</a><br>  <br> 


	<div id="TableDable">
	<table>
		<thead>
		<tr>
			<th>Site Name</th>
			<th>Coordinator</th>
			<th>Phone</th>
			<th>Address</th>
			<th>View</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
		</thead>
<?php

include 'DBlogin.php';
//input $sql and show the table 
$sql = "SELECT DISTINCT * FROM SITES S";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	echo "<tr class='light'>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['c_first_name']. "," .$row['c_last_name']. "</td>";
	echo "<td>" . $row['phone'] . "</td>";
	echo "<td>" . $row['adress'] . "</td>";
	echo "<td><a href=\"SiteinfoAdmin.php?site_id=".$row['site_id']."\"  ><img src='images/view.png'  width='20' height='20' /></a></td>";
	echo "<td><a href=\"EditSite.php?site_id='".$row['site_id']."'\" ><img src='images/edit.png'  width='20' height='20' /></a></td>";
	echo "<td><a href=\"DeleteSite.php?site_id='".$row['site_id']."'&image=".$row['image']."\"  onclick=\"return confirm('Are you sure you want to delete this Site?')\"> <img src='images/delete.png'  width='20' height='20'/></a></td>";
	echo "</tr>";//direct CheckInService.php with check information
}
?>
</table> </div>
</body>
</html>