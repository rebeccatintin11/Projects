<?php 
include 'AdminLogin.php';

/* 
 DELETEPermission.PHP
 Deletes a specific entry from the 'Staff' table
*/

 include 'DBlogin.php'; 

 
 // check if the 'usc_id' variable is set in URL, and check that it is valid
 if (isset($_GET['site_id']) )
 {
 // get id value
 $site_id = $_GET['site_id'];
 $image = $_GET['image'];
 // delete the entry
 $result = mysql_query("DELETE FROM SITES  WHERE site_id=$site_id")
 or die(mysql_error()); 
 
 if($image!="")
 {
 	$image = "/var/www/html/site_image/".$image;
 	unlink($image);
 }
 // If delte success show message
if($result)
{ 

echo "<script type=\"text/javascript\">".
        "alert('Site Delete Success');".
		"location.href = 'Sites.php';".
        "</script>";	
 }
 }
 else
 // if id isn't set, or isn't valid, redirect back to view page
 {
 header("Location: Sites.php"); 
 } 
 ?>