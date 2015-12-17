<?php 
 include 'StudentLogin.php';
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/layout.css" type="text/css" />
<meta charset="UTF-8">
<title>JEP Online Platform</title>
<script type="text/javascript">
function RedirectSmartphone(url){
    if (url && url.length > 0 && (screen.width < 1024) && (screen.height < 768))
    window.location = url;
}

RedirectSmartphone("mHomepageStudent.html");
//direct the pages
function updateObjectIframe(which){
    document.getElementById('result_area').innerHTML = '<'+'object  width="1000" height="380" id="main" name="main" type="text/html" data="'+which.href+'"><\/object>';
}
</script>
</head>

<!-- ####################################################################################################### -->

<body id="top">
<div class="wrapper">
  <div id="header">
    <div class="fl_left">
      <h1><a href="HomepageVolunteer.php">JEP Online Platform</a></h1>
      <p>Volunteer Homepage</p> 
    </div>
    <br class="clear" />
    
<!-- navigation bar  -->  
  <!-- ####################################################################################################### -->
  <div id="topbar">
    <div id="topnav">
      <ul>
      	  	
      	<?php if ($_SESSION['PAStudent']=='True') 
      	{
      	echo "<li class=\"active\"> <a href=\"HomepagePAVolunteer.php\">Home</a><li>";	
      	}
      	else {
     	echo	"<li class=\"active\"> <a href=\"Intro.html\" onclick=\"updateObjectIframe(this); return false;\">Home</a></li>";
      	}
      	?>
      	
        <li><a href="CheckIn.php" onclick="updateObjectIframe(this); return false;">Check-In</a></li>
        <li><a href="CheckinHistory.php" onclick="updateObjectIframe(this); return false;">Check-In History</a></li>
        <li><a href="MySchedule.php" onclick="updateObjectIframe(this); return false;">My Schedule</a></li>
        <li><a href="MyDocumentsVolunteer.php" onclick="updateObjectIframe(this); return false;">My Documents</a></li>
        <li class="last"><a href="LogOut.php">Log Out</a></li>
      </ul>
    </div>
  </div>
  <br class="clear" />
  <br class="clear" />
  <!-- ####################################################################################################### -->
 
<!-- where we show pages  -->
<div id="result_area">
<object width="1000" height="380" id="main" name="main" type="text/html" data="Intro.html"></object>
</div>

  
</div>
</body>
</html>