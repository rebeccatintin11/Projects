<?php 
 include 'PALogin.php';
?>
<!DOCTYPE HTML>
<html>
<head>
<title>JEP</title>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
  <link type="text/css" href="css/mmenu.css" rel="stylesheet" media="all" />
	<script type="text/javascript" src="js/jquery.mmenu.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$('nav#menu').mmenu();
		});
		
		$(document).ready(function()
	{
  		$("#flip").click(function()
  		{
    		$("#panel").slideToggle("slow");
    		if($(this).is(":hidden"))
    		{
    			document.getElementById("flip").innerHTML="click to show";
    		}
    		else
    		{
    			document.getElementById("flip").innerHTML="click to hide";
    		}
 		});
	});
	
	$(document).ready(function()
	{
  		$("#search").click(function()
  		{
    		$("#panel").slideUp("slow");
    		if($(this).is(":hidden"))
    		{
    			document.getElementById("flip").innerHTML="click to show";
    		}
    		else
    		{
    			document.getElementById("flip").innerHTML="click to hide";
    		}

  		});
	});

	function checkAND(str)
	{
		if(str!="")
		{
			str = str + " AND ";
		}
		return str;
	}
	
	function showinfo(site_id, last_name)
	{
		var str="";
		
		if(site_id!="")
  		{
			str = checkAND(str) + "site_id=" + site_id;
  		}
  		
  		if(last_name!="")
  		{
  			str = checkAND(str) + "last_name=\"" + last_name + "\""; 
  		}
  		
		if (str=="")
 	  	{
  			document.getElementById("txtHint").innerHTML="";
  			return;
  		} 
		if (window.XMLHttpRequest)
  		{// code for IE7+, Firefox, Chrome, Opera, Safari
  			xmlhttp=new XMLHttpRequest();
  		}
		else
  		{// code for IE6, IE5
  			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  		}
		xmlhttp.onreadystatechange=function()
  		{
  			if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    		}
  		}
		xmlhttp.open("GET","Studenttable.php?q="+str,true);
		xmlhttp.send();
	}
	
		
	</script>
</head>
<body>			       
	    <div class="wrap">	 
	      <div class="header">
	      	  <div class="header_top">
	      	     	<div class="menu-ico"><a href="#menu"></a></div>
					  <div class="profile_details">
								<div id="loginContainer">
				                  <span>Students</span>
				                </div>
				             	
				             <div class="clear"></div>		  	
					    </div>	
		 		      <div class="clear"></div>				 
				   </div>
			</div>	  					     
	   </div> 
	   
	   <br/>
		<div id="flip">Click to slide the panel down or up</div>
		<div class="CSSTableGenerator">
	
		<?php
	
		include 'studentdrop.php';	
	
		?>
		</div>
		<div id="txtHint"><b>Information will be listed here.</b></div>
   
			
	 
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
				<a href="mStudentsDetailsPA.php"><span><i><img src="images/user.png"></i> Students Details</span></a>
				</fieldset>
				<fieldset id="body3">
				<a href="mAnnouncement.php"><span> <i><img src="images/invites.png"></i>  Announcement</span></a>
				</fieldset>
				<fieldset id="body4">
				<a href="LogOut.php"><i><img src="images/favourite.png" alt="" /></i>Log Out</a>
				</fieldset>
			</ul>
		</nav>
</body>
</html>

