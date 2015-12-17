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
								<span>Check-In History</span> 
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
					<td>Course</td>
					<td>Site name</td>
					<td>Time</td>
					<td>Status</td>
				</tr>
			<?php
				include 'DBlogin.php';
				//input $sql and show the table 
				$myusername=$_SESSION['myusername'];
				$sql = "SELECT DISTINCT * FROM SITES S, CHECKINS C WHERE C.usc_id=" .$myusername. " AND C.site_id = S.site_id ORDER BY C.checkin_time DESC";
				$result = mysql_query($sql);
				while ($row = mysql_fetch_array($result)) 
				{
					$date = date_create($row[checkin_time]);
					echo "<tr class='light'>";
					echo "<td>" . $row['course'] . "</td>";
					echo "<td>" . $row['name'] . "</td>";
					echo "<td>" . date_format($date, 'g:ia \o\n l jS F Y') . "</td>";
					echo"<td>"; if($row['return_code']==1){echo "Success";} else{echo "Fail";} echo "</td>";
					echo "</tr>";
				}
			?>
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
				<a href="LogOut.php"><i><img src="images/favourite.png" alt="" /></i>Log Out</a>
				</fieldset>
			</ul>
		</nav>
</body>
</html>

