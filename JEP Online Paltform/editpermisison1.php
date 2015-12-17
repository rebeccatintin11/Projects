<?php 
session_start();
if(!isset( $_SESSION['myusername'] ) ||$_SESSION['role']!='Admin') // if the user is not the same user that logged in or he is not an admin then  then 

{                            // it redirects to the login page
    header("location:http://uscdornsife.usc.edu/secure/JEP/checkin.cfm");
}
//connect to DB
include 'DBlogin.php';
// get values from post
if (isset($_POST['submit']))

{
  $usc_id=mysql_real_escape_string(htmlspecialchars($_POST['uscid']));
 $firstname = mysql_real_escape_string(htmlspecialchars($_POST['firstname']));
 $lastname = mysql_real_escape_string(htmlspecialchars($_POST['lastname']));
  $email = mysql_real_escape_string(htmlspecialchars($_POST['email']));
   $role = mysql_real_escape_string(htmlspecialchars($_POST['role']));
 $officehours = mysql_real_escape_string(htmlspecialchars($_POST['officehours']));
// update the record
$result=mysql_query("Update STAFF  SET  first_name='$firstname', last_name='$lastname',email ='$email',is_admin='$role',office_hour='$officehours' WHERE usc_id= '$usc_id' ");
// if successful display message and redirect.
if($result)
{
echo "<script type=\"text/javascript\">".
        "alert('User Role Edit Success');".
		"location.href = 'Permission.php';".
        "</script>";




	
}

 }
 // redirect to permission page otherwise.
else
header("Location: Permission.php"); 


 ?>