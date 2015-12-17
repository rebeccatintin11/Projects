<?php
//the php file is used to save record into the database
include 'PALogin.php';
// connect to DB
include 'DBlogin.php';

//get the value of location, returncode and siteid
if ($_GET['id']) {
	$id = trim($_GET['id']);
} else {
	echo "error";
}

//get the current userID
$uscId=$_SESSION['myusername'];

//connect to database and save the record into the databse
$result = mysql_query("DELETE FROM Announcement WHERE Announcement_id=$id And staff_id=$uscId"); 
?>
