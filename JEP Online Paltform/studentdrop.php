<?php

    include 'DBlogin.php';
	
	$myusername=$_SESSION['myusername'];
	
	echo "<form action = ''>";
	echo "<table cellpadding='0' cellspacing='0'>";
	echo "<tr><td>First name: <input type='text' id='first_name'></td>";
	echo "<td>Last name: <input type='text' id='last_name'></td></tr>";

//for site drop down list
	$sitesql="SELECT DISTINCT S.site_id,S.name FROM  SITES S";
    $siteresult=mysql_query($sitesql);    

    echo "<tr><td>site";
	echo "<select name = 'site_id' id = 'site_id'>
	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($siteresult))
        {
            echo "<option value =" . $row['site_id'] ." >" . $row['name'] ."</option>"; 
        }
    echo "</select></td>";
//for course dropdown list
	$coursesql="SELECT DISTINCT V.course FROM  VOLUNTEERS V";
    $courseresult=mysql_query($coursesql);    
 
    echo "<td>course";
	echo "<select name = 'course' id = 'course'>
	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($courseresult))
        {
            echo "<option value =" . $row['course'] ." >" . $row['course'] ."</option>"; 
        }

    echo "</select></td></tr>";
// for professor dorp down list
	$professorsql="SELECT DISTINCT V.professor FROM  VOLUNTEERS V";
    $professorresult=mysql_query($professorsql);    
    
    echo "<tr><td>professor";
   	echo "<select name = 'professor' id = 'professor'>
	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($professorresult))
        {
            echo "<option value =" . $row['professor'] ." >" . $row['professor'] ."</option>"; 
        }
    echo "</select></td>";
// for supervisor dropdown list
	$supervisorsql="SELECT DISTINCT V.supervisor FROM  VOLUNTEERS V";
    $supervisorresult=mysql_query($supervisorsql);    
   
    echo "<td>supervisor";
   	echo "<select name = 'supervisor' id = 'supervisor'>
	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($supervisorresult))
        {
            echo "<option value =" . $row['supervisor'] ." >" . $row['supervisor'] ."</option>"; 
        }
    echo "</select></td></tr>";

  
//for major  dropdown list   
    $majorsql="SELECT DISTINCT V.major FROM  VOLUNTEERS V";
    $majorresult=mysql_query($majorsql);    
    
    echo "<tr><td>major";
   	echo "<select name = 'major' id = 'major'>
	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($majorresult))
        {
            echo "<option value =" . $row['major'] ." >" . $row['major'] ."</option>"; 
        }
    echo "</select></td>";
// for room dropdown list
	$roomsql="SELECT DISTINCT V.room FROM VOLUNTEERS V";
    $roomresult=mysql_query($roomsql);   
    
    echo "<td>room";
   	echo "<select name = 'room' id = 'room'>
   	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($roomresult))
        {
            echo "<option value =" . $row['room'] ." >" . $row['room'] ."</option>"; 
        }
    echo "</select></td></tr>";
//for car dropdown list
	$carsql="SELECT DISTINCT V.car FROM  VOLUNTEERS V";
    $carresult=mysql_query($carsql);
        
    echo "<tr><td>car";
   	echo "<select name = 'car' id = 'car'>
	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($carresult))
        {
            echo "<option value =" . $row['car'] ." >" . $row['car'] ."</option>"; 
        }
    echo "</select></td>";
//for housing  dropdown list
	$housingsql="SELECT DISTINCT V.housing FROM  VOLUNTEERS V";
    $housingresult=mysql_query($housingsql);    
    
    echo "<td>housing";
   	echo "<select name = 'housing' id = 'housing'>
	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($housingresult))
        {
            echo "<option value =" . $row['housing'] ." >" . $row['housing'] ."</option>"; 
        }
    echo "</select></td></tr>";
// for international  dropdown list

    echo "<tr><td>international";
   	echo "<select name = 'international' id = 'international'>
	<option value =" . '' ." >" . '-select-' ."</option>";
	echo"<option value =" . 1 ." >" . 'yes' ."</option>";
	echo"<option value =" . 0 ." >" . 'no' ."</option>";
    echo "</select></td>";
// for assign_as  dropdown list
	$assigned_assql="SELECT DISTINCT V.assigned_as FROM  VOLUNTEERS V";
    $assigned_asresult=mysql_query($assigned_assql);   	
     
    echo "<td>assigned_as";
   	echo "<select name = 'assigned_as' id = 'assigned_as'>
   	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($assigned_asresult))
        {
            echo "<option value =" . $row['assigned_as'] ." >" . $row['assigned_as'] ."</option>"; 
        }
    echo "</select></td></tr>";
// for pa  dropdown list   
    $PAsql="SELECT DISTINCT ST.usc_id, ST.last_name, ST.first_name FROM STAFF ST";
    $PAresult=mysql_query($PAsql);    

    echo "<tr><td>PA";
   	echo "<select name = 'PA' id = 'PA'>
	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($PAresult))
        {
            echo "<option value =" . $row['usc_id'] ." >" . $row['first_name'] . " " . $row['last_name'] ."</option>"; 
        }
    echo "</select></td>";
// for team dropdown list
	$teamsql="SELECT DISTINCT V.team FROM  VOLUNTEERS V";
    $teamresult=mysql_query($teamsql);    

     
    echo "<td>team";
   	echo "<select name = 'team' id = 'team'>
   	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($teamresult))
        {
            echo "<option value =" . $row['team'] ." >". $row['team'] ."</option>"; 
        }
    echo "</select></td></tr>";
    // for  semester dropdown list
	$semestersql="SELECT DISTINCT V.semester FROM  VOLUNTEERS V";
    $semesterresult=mysql_query($semestersql);    

    echo "<tr><td>semester";
   	echo "<select name = 'semester' id = 'semester'>
	<option value =" . '' ." >" . '-select-' ."</option>"; 
		while($row = mysql_fetch_array($semesterresult))
        {
            echo "<option value =" . $row['semester'] ." >" . $row['semester'] ."</option>"; 
        }
    echo "</select></td></tr>";

	
    echo "</table>";
    echo"<input id= 'search' type='button' value='Search' onclick='showinfo($myusername,first_name.value,last_name.value,site_id.value,course.value,professor.value,supervisor.value,major.value,room.value,car.value,housing.value,international.value,assigned_as.value,PA.value,team.value,semester.value)'>";
    echo "</form>";

?>
