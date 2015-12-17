<?php 
 include 'StudentLogin.php';
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
<body>			       
	    <div class="wrap">	 
	      <div class="header">
	      	  <div class="header_top">
	      	     	<div class="menu-ico"><a href="#menu"></a></div>
					  <div class="profile_details">
				    		<div id="loginContainer">
				                <span>My Documents</span>
				            </div>
				             	
				             <div class="clear"></div>		  	
					    </div>	
		 		      <div class="clear"></div>				 
				   </div>
			</div>	  
			<br/>
			<div class="CSSTableGenerator">
			<table>
				<tr>
				<td> Documents </td>
				<td> Description</td>
				<td> Download</td>
				</tr>
			<!-- loop through results of database query, displaying them in the table -->
				<?php
					while($row = mysql_fetch_array( $getdata )) {
						// echo out the contents of each row into a table	
				?>
				
				<tr>
					<td><?php echo $row['name'] ?></td>
					<td><?php echo $row['description']?></td>
					<td><a href="http://jeppro.usc.edu/download.php?f=<?php echo $row['name'].".pdf"?>" ><img src="images/download.png"  width='20' height='20' /></a></td>
				</tr>
				<?php }// close table ?>
			</table>
			</div>
	   </div>	  				 
		<nav id="menu">
			<ul>
				<fieldset id="body1">
					<a href="mHomepageVolunteer.php"><i><img src="images/user.png"></i> Home </a>
				</fieldset>
				<fieldset id="body2">
					<a href="mCheckIn.php"><span><i><img src="images/user.png"></i> Check-In</span></a>
				</fieldset>
				<fieldset id="body3">
					<a href="mCheckinHistory.php"><span> <i><img src="images/invites.png"></i> Check-In History</span></a>
				</fieldset>
				<fieldset id="body4">
				<a href="mMySchedule.php"><span> <i><img src="images/events.png"></i> My Schedule</span></a>
				</fieldset>
				<fieldset id="body5">
				<a href="mMyDocumentsVolunteer.php"><i><img src="images/favourite.png" alt="" /></i> My Document</a>
				</fieldset>
				<fieldset id="body6">
				<a href="LogOut.php"><i><img src="images/favourite.png" alt="" /></i> Log Out</a>
				</fieldset>
			</ul>
		</nav>
</body>
</html>

