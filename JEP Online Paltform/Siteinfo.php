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
<script type="text/javascript">

 function back(){
    if ((screen.width < 1024) && (screen.height < 768)){
    	window.location = "mCheckIn.php";
    }else{
    	window.location = "CheckIn.php";
    	}
    }
  </script> 

</head>
<body>
	<div id="TableDable">
<?php

include 'DBlogin.php';
//input $sql and show the table 
$site_id = $_GET["site_id"];
$sql = "SELECT DISTINCT * FROM SITES S WHERE S.site_id=".$site_id;
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
    {
        echo "<img border='0' src='/site_image/".$row[image]."'  width='300' height='230'>";
        echo "<table cellpadding='0' cellspacing='0' id='infotable'>
		<thead>
		<tr>
			<th>Site name</th>
			<th>address</th>
			<th>phone</th>
		</tr>
		</thead>";

        echo"<tr class='light'>";
		echo"<td>". $row['name'] . "</td>";
		echo"<td>". $row['adress'] ."</td>";
		echo"<td>". $row['phone'] ."</td>";
		echo"</tr>";
		echo "</table>";
		
		echo "<table cellpadding='0' cellspacing='0' id='infotable'>
		<thead>
		<tr>
			<th>Coordinator name</th>
			<th>Coordinator email</th>
			<th>Coordinator office</th>
		</tr>
		</thead>";

		echo"<tr class='light'>";
		echo"<td>". $row['c_first_name'] . ",". $row['c_last_name'] . "</td>";
		echo"<td>". $row['c_email'] ."</td>";
		echo"<td>". $row['c_office_location'] ."</td>";
		echo"</tr>";
		echo "</table>";
		
		echo "<table cellpadding='0' cellspacing='0' id='infotable'>
		<thead>
		<tr>
			<th>Early dismissal</th>
			<th>Dress code</th>
		</tr>
		</thead>";

		echo"<tr class='light'>";
		echo"<td>". $row['early_dismissal'] . "</td>";
		echo"<td>". $row['dress_code'] ."</td>";
		echo"</tr>";
		echo "</table>";
		
		echo "<table cellpadding='0' cellspacing='0' id='infotable'>
		<thead>
		<tr>
			<th>Description</th>
		</tr>
		</thead>";

		echo"<tr class='light'>";
		echo"<td>". $row['description'] . "</td>";
		echo"</tr>";
		echo "</table>";
    }

?>
<button type="button" onclick="back();">Back</button>
</div>
</body>
</html>