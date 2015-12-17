<?php 
 include 'PALogin.php';
?>
<!DOCTYPE HTML>
<html>
<head>
<title>JEP Online Platform</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/tables.css" rel="stylesheet" type="text/css" media="all"/>
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
				                  <span>PA Homepage</span>
				                </div>
				             	
				             <div class="clear"></div>		  	
					    </div>	
		 		      <div class="clear"></div>				 
				   </div>
			</div>	  					     
	   </div>	
 <!-- ######################################## NAVIGATION BAR ############################################################### -->	   
		<nav id="menu">
			<ul>
				<fieldset id="body1">
				<?php 
					if ($_SESSION['PAStudent']=='True') 
					{
					echo "<li class=\"active\"> <a href=\"mHomepagePAVolunteer.php\">Home</a><li>";	
					}
					else {
					echo	"<li class=\"active\"> <a href=\"mHomepagePA.php\">Home</a></li>";
					}
				?>
				</fieldset>
				<fieldset id="body2">
				<a href="mStudentsDetailsPA.php"><span><i><img src="images/favourite.png"></i> Students Details</span></a>
				</fieldset>
				<fieldset id="body3">
				<a href="mAnnouncement.php"><span> <i><img src="images/invites.png"></i>  Announcement</span></a>
				</fieldset>
				<fieldset id="body4">
				<a href="LogOut.php"><i><img src="images/user.png" alt="" /></i>Log Out</a>
				</fieldset>
			</ul>
		</nav>
</body>
</html>

