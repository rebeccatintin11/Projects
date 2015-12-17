<?php 
session_start();
if(!isset( $_SESSION['myusername'] ) ||$_SESSION['role']!='Admin' ) // if the user is not the same user that logged in or he is not an admin then  then

{                            // it redirects to the login page
    header("location:http://uscdornsife.usc.edu/secure/JEP/checkin.cfm");
}
?>
