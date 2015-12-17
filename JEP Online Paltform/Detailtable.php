<?php
	
	include 'DBlogin.php';

	$usc_id = $_POST["usc_id"];
	//$q = $_GET["q"];

	$sql="SELECT DISTINCT V.last_name,V.first_name,V.email,V.cellphone, V.car, V.housing, V.international, V.major FROM VOLUNTEERS V WHERE V.usc_id=" .$usc_id;
	$result = mysql_query($sql);

	while($row = mysql_fetch_array($result))
    {
        echo "<table cellpadding='0' cellspacing='0' id='infotable'>
		<thead>
		<tr>
			<th>Name</th>
			<th>email</th>
			<th>cellphone</th>
			<th>car</th>
		</tr>
		</thead>";


        
        echo"<tr class='light'>";
		echo"<td>". $row['first_name'] . ", " . $row['last_name'] ."</td>";
		echo"<td>". $row['email'] ."</td>";
		echo"<td>". $row['cellphone'] ."</td>";
		echo"<td>". $row['car'] ."</td>";
		echo"</tr>";
		
		echo "<thead>
		<tr>
			<th>housing</th>
			<th>international</th>
			<th>major</th>
		</tr>
		</thead>";


        
        echo"<tr class='light'>";
		echo"<td>". $row['housing'] . "</td>";
		echo"<td>". $row['international'] ."</td>";
		echo"<td>". $row['major'] ."</td>";
		echo"</tr>";


    }
	echo "</table>";
	//echo "<button type=\"button\" onclick=\"showprev(" .$q. ");\">Back</button>";
?>
