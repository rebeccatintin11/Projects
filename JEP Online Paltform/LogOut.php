<?php 
session_start();
if(!isset( $_SESSION['myusername'] )) // if the user is not the same user that logged in then 

{                            // it redirects to the login page
    header("location:http://uscdornsife.usc.edu/secure/JEP/checkin.cfm");
}




session_start();
session_destroy();


?>








<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="EN" lang="EN" dir="ltr">
<head profile="http://gmpg.org/xfn/11">
<title>JEP Online Platform</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="styles/layout.css" type="text/css" />
</head>
<body id="top">
<div class="wrapper">
  <!-- ####################################################################################################### -->
  <div id="header">
    <div class="fl_left">
  
      <p>To ensure log out, you must completely quit/close your web browser.
</p> 



	<br/>
	
</div>

</body>
</html>