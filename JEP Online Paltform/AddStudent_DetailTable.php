
<?php

	echo "<script language=\"JavaScript\">".
			"function toggle(source) {".
  			"checkboxes = document.getElementsByName('students[]');".
  			"for(var i=0, n=checkboxes.length;i<n;i++) {".
    		"checkboxes[i].checked = source.checked;".
			"}}</script>";


	include 'DBlogin.php';
	
	$str = $_POST["str"];
	$sql="SELECT V.usc_id,V.volunteer_id, V.first_name, V.last_name, V.course, S.name, V.assigned_as, ST.first_name AS STfirstname, ST.last_name AS STlastname,S.site_id FROM VOLUNTEERS V,SITES S, STAFF ST WHERE S.site_id = V.site_id AND ST.usc_id = V.pa_usc_id ".$str;
		$result = mysql_query($sql);
	echo "<form action=\"AddVolunteerDoc.php\" name=\"addstudentform\" method=\"post\"  >";
	echo "<table cellpadding='0' cellspacing='0' id='infotable'>
		<thead>
		<tr>
			<th><input type=\"checkbox\" onClick=\"toggle(this)\" /></th>
			<th>Name</th>
			<th>Course</th>
			<th>Assignd as</th>
			<th>Site</th>
			<th>PA</th>
		</tr>
		</thead>";
	while($row = mysql_fetch_array($result))
    {
        echo"<tr class='light'>"; ?>
     
       <td><input type="checkbox" name="students[]" value= "<?php echo $row['volunteer_id']?>" ></td>
	<?php 	echo"<td>". $row['first_name'] . ", " . $row['last_name'] ."</td>";
		echo"<td>". $row['course'] ."</td>";
		echo"<td>". $row['assigned_as'] ."</td>";
		echo"<td>". $row['name'] ."</td>";
		echo"<td>". $row['STfirstname'] . ", " . $row['STlastname'] ."</td>";
		$course="".$row['course'];
		$usc_id="".$row['usc_id'];
		$site_id="".$row['site_id'];
		echo"</tr>";
		
    }
	echo "</table>";
	echo "<input type=\"submit\" name=\"add\" value=\"Add\" />"; ?>
			
		
	<?php 	 
	echo "</form>";
?>
