<?php
//the php file is used to save record into the database
include 'StudentLogin.php';
// connect to DB
include 'DBlogin.php';

//get the value of location, returncode and siteid
if ($_GET['location'] && $_GET['returncode']&&$_GET['siteId']) {
	$location = "".trim($_GET['location']);
	$returncode = trim($_GET['returncode']);
	$siteId = trim($_GET['siteId']);
	$course	= trim($_GET['course']);
} else {
	echo "error";
}

//get the current userID
$uscId=$_SESSION['myusername'];

//connect to database and save the record into the databse
$result = mysql_query("INSERT INTO CHECKINS (location,return_code,usc_id,site_id,course)
VALUES($location,$returncode,$uscId, $siteId, $course)"); 
?>
