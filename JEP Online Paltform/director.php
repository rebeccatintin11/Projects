<?php
 


 include 'DBlogin.php'; 

$tbl_name_1="STAFF"; // Table name 
$tbl_name_2="VOLUNTEERS"; // Table name 




// username and password sent from form 
$myusername=$_POST['uscid']; 
// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$myusername = mysql_real_escape_string($myusername);




$sql="SELECT *
FROM  $tbl_name_1 ,  $tbl_name_2
WHERE  $tbl_name_1.usc_id =  $tbl_name_2.usc_id
AND is_admin ='0' and $tbl_name_1.usc_id='$myusername' ";







$result=mysql_query($sql);
$count=mysql_num_rows($result);

if($count!=0)
{
session_start();
// Register $myusername redirect to hoempage
$_SESSION['myusername']=$myusername;
$_SESSION['role']='PA';
$_SESSION['PAStudent']='True';
header("location:HomepagePAVolunteer.php");
exit;
}

$sql="SELECT * FROM $tbl_name_1 WHERE usc_id='$myusername' and is_admin='1'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername table row must be 1 row
if($count==1)
{
session_start();
// Register $myusername redirect to hoempage
$_SESSION['myusername']=$myusername;
$_SESSION['role']='Admin';
header("location:HomepageAdmin.php");
exit;
}

$sql="SELECT * FROM $tbl_name_1 WHERE usc_id='$myusername' and is_admin='0'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername table row must be 1 row
if($count==1)
{
session_start();
// Register $myusername redirect to hoempage
$_SESSION['myusername']=$myusername;
$_SESSION['role']='PA';
header("location:HomepagePA.php");
exit;
}


$sql="SELECT * FROM $tbl_name_2 WHERE usc_id='$myusername'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
session_start();
// Register $myusername, $mypassword and redirect to file "login_success.php"
$_SESSION['myusername']=$myusername;
header("location:HomepageVolunteer.php");
exit;
}


header("location:NoID.html");

?>