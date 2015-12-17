<?php 
session_start();
if(!isset( $_SESSION['myusername'] ) ||$_SESSION['role']!='Admin') // if the user is not the same user that logged in or he is not an admin then 

{                            // it redirects to the login page
    header("location:http://uscdornsife.usc.edu/secure/JEP/checkin.cfm");
}

/* 
 DELETEPermission.PHP
 Deletes a specific entry from the 'Staff' table
*/

 include 'DBlogin.php'; 

 
 // check if the 'usc_id' variable is set in URL, and check that it is valid
 if (isset($_GET['usc_id']) )
 {
 // get id value
 $usc_id = $_GET['usc_id'];
 
 // delete the entry
 $result = mysql_query("DELETE FROM STAFF  WHERE usc_id=$usc_id")
 or die(mysql_error()); 
 // If delte success show message
if($result)
{ 

echo "<script type=\"text/javascript\">".
        "alert('User Role Delete Success');".
		"location.href = 'Permission.php';".
        "</script>";




		
 }
 }
 else
 // if id isn't set, or isn't valid, redirect back to view page
 {
 header("Location: Permission.php"); 
 } 
 ?>