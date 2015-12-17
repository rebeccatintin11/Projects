<?php 
 include 'AdminLogin.php';
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

RedirectSmartphone("mHomepageAdmin.html");


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
      <h1><a href="HomepagePA.php">JEP Online Platform</a></h1>
      <p>Admin Homepage</p> 
    </div>
    <br class="clear" />
   </div>
  
  <!-- ####################################################################################################### -->
  <div id="topbar">
    <div id="topnav">
      <ul>
      	<li class="active"><a href="intro.html" onclick="updateObjectIframe(this); return false;">Home</a></li>
        <li><a href="StudentsDetails.php" onclick="updateObjectIframe(this); return false;">Students</a></li>
        <li><a href="Sites.php" onclick="updateObjectIframe(this); return false;">Sites</a></li>
        <li><a href="MyDocumentsAdmin.php" onclick="updateObjectIframe(this); return false;">Documents</a></li>
        <li><a href="Permission.php" onclick="updateObjectIframe(this); return false;">Manage User</a></li>
        <li><a href="Announcement.php" onclick="updateObjectIframe(this); return false;">Announcement</a></li>
        <li class="last"><a href="LogOut.php">Log Out</a></li>
      </ul>
    </div>
  </div>
  <br class="clear" />
  <br class="clear" />
  <!-- ####################################################################################################### -->


<div id="result_area">
<object width="1000" height="380" id="main" name="main" type="text/html" data="Intro.html"></object>
</div>


  
</div>
</body>
</html>