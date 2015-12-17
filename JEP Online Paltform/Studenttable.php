
<?php
	
	include 'DBlogin.php';
	
	$str = $_POST["str"];
	$sql="SELECT V.usc_id, V.first_name, V.last_name, V.course, S.name, V.schedule, ST.first_name AS STfirstname, ST.last_name AS STlastname,S.site_id FROM VOLUNTEERS V,SITES S, STAFF ST WHERE S.site_id = V.site_id AND ST.usc_id = V.pa_usc_id ".$str;
		$result = mysql_query($sql);
	
	echo "<table cellpadding='0' cellspacing='0' id='infotable'>
		<thead>
		<tr>
			<th>Name</th>
			<th>Course</th>
			<th>Schedule</th>
			<th>Site</th>
			<th>PA</th>
			<th>detail info</th>
			<th>Record</th>
		</tr>
		</thead>";
	while($row = mysql_fetch_array($result))
    {
        echo"<tr class='light'>";
		echo"<td>". $row['first_name'] . ", " . $row['last_name'] ."</td>";
		echo"<td>". $row['course'] ."</td>";
		echo"<td>". $row['schedule'] ."</td>";
		echo"<td>". $row['name'] ."</td>";
		echo"<td>". $row['STfirstname'] . ", " . $row['STlastname'] ."</td>";
		$course="".$row['course'];
		$usc_id="".$row['usc_id'];
		$site_id="".$row['site_id'];
		echo "<td><a  href=\"javascript:void(0)\" onclick='showdetail(" .$usc_id. ")'><img src='images/view.png'  width='20' height='20' /></a></td>";
		echo "<td><a  href=\"javascript:void(0)\" onclick='showhistory(" .$usc_id. "," .$site_id.",". $course .")'><img src='images/view.png'  width='20' height='20' /></a></td>";
		echo"</tr>";
		
    }
	echo "</table>";
?>
