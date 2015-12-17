<?php 
session_start();
if(!isset( $_SESSION['myusername'] ) ||$_SESSION['role']!='Admin') // if the user is not the same user that logged in or he is not an admin then 

{                            // it redirects to the login page
    header("location:http://uscdornsife.usc.edu/secure/JEP/checkin.cfm");
}
if (isset($_POST['submit']))
{
 include 'DBlogin.php';// connectto DB
 // Get the values from POST.
 
 $usc_id=mysql_real_escape_string(htmlspecialchars($_POST['uscid']));
 $firstname = mysql_real_escape_string(htmlspecialchars($_POST['firstname']));
 $lastname = mysql_real_escape_string(htmlspecialchars($_POST['lastname']));
  $email = mysql_real_escape_string(htmlspecialchars($_POST['email']));
   $role = mysql_real_escape_string(htmlspecialchars($_POST['role']));
 $officehours = mysql_real_escape_string(htmlspecialchars($_POST['officehours']));
 
 
 
 
 
 
 
 
 
 // Check if the USC id already exist and display a message. 
  $result=mysql_query("SELECT * FROM STAFF  where usc_id= '$usc_id' LIMIT 1");
if(mysql_fetch_array($result) != false)
{ 

echo "<script type=\"text/javascript\">".
        "alert('USC ID already exist');".
		"location.href = 'Permission.php';".
        "</script>";
}

// if USC ID not exist add the user to he DB.




  else
  {



$result1=mysql_query("INSERT STAFF  SET usc_id= '$usc_id', first_name='$firstname', last_name='$lastname',email ='$email',is_admin='$role',office_hour='$officehours '  ");
if($result1)// Display message if add  successful 
{
echo "<script type=\"text/javascript\">".
        "alert('User Role Add Success');".
		"location.href = 'Permission.php';".
        "</script>";

}
 }}
 // redirect to permission page otherwise.

 else 
header("Location: Permission.php"); 
  ?>