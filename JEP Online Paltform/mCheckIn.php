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
				                  <span>Check-In</span>
				                    
				            </div>
				             	
				             <div class="clear"></div>		  	
					    </div>	
		 		      <div class="clear"></div>				 
				   </div>
			
			<br/>
			</div>	  
			<div class="CSSTableGenerator">
			<table>
				<tr>
				<td>Site Name</td>
				<td colspan="3">Information</td>

				</tr>
			
			<?php

			include 'DBlogin.php';
			//input $sql and show the table
			$myusername=$_SESSION['myusername'];
			$sql = "SELECT DISTINCT * FROM SITES S, VOLUNTEERS V WHERE V.usc_id=" .$myusername. " AND V.site_id = S.site_id";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result)) {
				echo "<tr class='light'>";
				echo "<td rowspan=\"5\">" . $row['name'] . "</td>";
				echo "<tr>";
				echo "<td colspan=\"3\">" . $row['course'] . "</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td colspan=\"3\">" . $row['phone'] . "</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td colspan=\"3\">" . $row['adress'] . "</td>";
				echo "</tr>";
				echo "<tr>";
				$address="".$row['adress'];
				$radius="".$row['radius'];
				$siteId="".$row['site_id'];
				$course="".$row['course'];
				$staffid="".$row['pa_usc_id'];
				echo "<td><a href=\"DirectionService.php?address='".$address."'\"><img src='images/direction.png'  width='20' height='20' /></a></td>";
				echo "<td><a href='' ><img src='images/view.png'  width='20' height='20' /></a></td>";
				echo "<td><a class=\"button\"  href=\"CheckInService.php?address='".$address."'&radius='".$radius."'&siteId='".$siteId."'&course='".$course."'&staff='".$staffid."'\"><img src='images/check.jpg'  width='70' height='30' /></</a></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td colspan=\"4\"> </td>";
				echo "</tr>";
				echo "</tr>";
				
			}
			?>
			
			</table>
			</div>
	   </div>	  				 
		<nav id="menu">
			<ul>
				<fieldset id="body1">
					<?php 
					if ($_SESSION['PAStudent']=='True') 
					{
						echo "<li class=\"active\"> <a href=\"mHomepagePAVolunteer.php\">Home</a><li>";	
					}
					else 
					{
						echo	"<li class=\"active\"> <a href=\"mHomepageVolunteer.php\">Home</a></li>";
					}
					?>
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
				<a href="LogOut.php"><i><img src="images/favourite.png" alt="" /></i>Log Out</a>
				</fieldset>
			</ul>
		</nav>
</body>
</html>

