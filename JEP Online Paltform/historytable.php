<?php
	
	
	
	include 'DBlogin.php';

	$course = $_POST["course"];
	$site_id = $_POST["site_id"];
	$usc_id = $_POST["usc_id"];

	
	$sql="SELECT V.first_name,V.last_name, C.course, C.checkin_time, C.return_code, S.name FROM CHECKINS C, VOLUNTEERS V,SITES S WHERE V.usc_id=" .$usc_id. " AND C.usc_id = V.usc_id AND S.site_id = C.site_id AND S.site_id = V.site_id AND C.course = V.course AND C.course = '" .$course. "' ORDER BY C.checkin_time DESC" ;
	
	$result = mysql_query($sql);


	echo "<table cellpadding='0' cellspacing='0' id='infotable'>
		<thead>
		<tr>
			<th>Name</th>
			<th>Course</th>
			<th>site</th>
			<th>checkin time</th>
			<th>Success/fail</th>
		</tr>
		</thead>";

	while($row = mysql_fetch_array($result))
    {
        $date = date_create($row[checkin_time]);
        echo"<tr class='light'>";
		echo"<td>". $row['first_name'] . ", " . $row['last_name'] ."</td>";
		echo"<td>". $row['course'] ."</td>";
		echo"<td>". $row['name'] ."</td>";
		echo"<td>". date_format($date, 'g:ia \o\n l jS F Y') ."</td>";
		echo"<td>"; if($row['return_code']==1){echo "Success";} else{echo "Fail";} echo "</td>";
		echo"</tr>";
    }
	echo "</table>";
	
?>
