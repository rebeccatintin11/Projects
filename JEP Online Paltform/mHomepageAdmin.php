<?php 
 include 'AdminLogin.php';
?>

<!DOCTYPE HTML>
<html>
<head>
<title>JEP Online Platform</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<script type="text/javascript" src="js/Chart.js"></script>
 <script type="text/javascript" src="js/jquery.easing.js"></script>
 <script type="text/javascript" src="js/jquery.ulslide.js"></script>

  <link type="text/css" href="css/mmenu.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="js/jquery.mmenu.min.js"></script>
<script type="text/javascript">
		$(function() {
			$('nav#menu').mmenu();
		});
	</script>
</head>
<!-- ####################################################################################################### -->
<body>			       
	    <div class="wrap">	 
	      <div class="header">
	      	  <div class="header_top">
	      	     	<div class="menu-ico"><a href="#menu"></a></div>
					  <div class="profile_details">
				    		   <div id="loginContainer">
				                  <span>Admin Homepage</span>  
				                </div>
				             	
				             <div class="clear"></div>		  	
					    </div>	
		 		      <div class="clear"></div>				 
				   </div>
			</div>	  					     
	   </div>	
		  
	     <!-- #################################### NAVIGATION BAR ################################################################### -->
		 
		<nav id="menu">
			<ul>
				<fieldset id="body1">
				<a href="mHomepageAdmin.html"><i><img src="images/user.png"></i> Home </a>
				</fieldset>
				<fieldset id="body2">
				<a href="mStudentsDetails.php"><span><i><img src="images/user.png"></i> Students</span></a>
				</fieldset>
				<fieldset id="body3">
				<a href="mAnnouncement.html"><span> <i><img src="images/invites.png"></i> Announcement</span></a>
				<fieldset id="body4">
				<a href="logOut.php"><i><img src="images/favourite.png" alt="" /></i>Log Out</a>
				</fieldset>
			</ul>
		</nav>
</body>
</html>

