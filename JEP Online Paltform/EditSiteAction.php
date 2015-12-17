<?php 
session_start();
//connect to DB
include 'DBlogin.php';
// get values from post
if (isset($_POST['submit']))

{
  $site_id=mysql_real_escape_string(htmlspecialchars($_POST['site_id']));
  $name = mysql_real_escape_string(htmlspecialchars($_POST['name']));
  $adress = mysql_real_escape_string(htmlspecialchars($_POST['adress']));
  $c_email = mysql_real_escape_string(htmlspecialchars($_POST['c_email']));
  $early_dismissal = mysql_real_escape_string(htmlspecialchars($_POST['early_dismissal']));
  $dress_code = mysql_real_escape_string(htmlspecialchars($_POST['dress_code']));
  $description=mysql_real_escape_string(htmlspecialchars($_POST['description']));
  $phone=mysql_real_escape_string(htmlspecialchars($_POST['phone']));
  $c_last_name=mysql_real_escape_string(htmlspecialchars($_POST['c_last_name']));
  $c_first_name=mysql_real_escape_string(htmlspecialchars($_POST['c_first_name']));
  $c_office_location=mysql_real_escape_string(htmlspecialchars($_POST['c_office_location']));
  $radius=mysql_real_escape_string(htmlspecialchars($_POST['radius']));

// update the record

  	$targetfolder = "site_image/";
 	$targetfolder = $targetfolder.$site_id.".".basename($_FILES['file']['type']);
    $image = $site_id.".".basename($_FILES['file']['type']);
	$file_type=$_FILES['file']['type'];

	if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 20000)){
		
		if(move_uploaded_file($_FILES['file']['tmp_name'],  $targetfolder)){
		
				
			$result=mysql_query("Update SITES  SET  name='$name',image='$image',adress ='$adress',c_email='$c_email',early_dismissal='$early_dismissal',dress_code='$dress_code',description='$description',phone ='$phone',c_last_name ='$c_last_name',c_first_name ='$c_first_name',c_office_location ='$c_office_location',radius ='$radius' WHERE site_id= '$site_id' ");
			
			if($result){
				
				// Display message if add  successful 
				echo "<script type=\"text/javascript\">".
        		"alert('Site Upload Success with image');".
				"location.href = 'Sites.php';".
       			 "</script>";
			}else{
				echo "<script type=\"text/javascript\">".
        		"alert('Upload fail');".
				"location.href = 'Sites.php';".
       			 "</script>";
			}
		
		}else{
 			echo "<script type=\"text/javascript\">".
        		"alert('Upload fail');".
				"location.href = 'Sites.php';".
       			 "</script>";
		}
	
	}
	else if (!isset($_FILES['my_file_input'])) {
			$result=mysql_query("Update SITES  SET  name='$name',adress ='$adress',c_email='$c_email',early_dismissal='$early_dismissal',dress_code='$dress_code',description='$description',phone ='$phone',c_last_name ='$c_last_name',c_first_name ='$c_first_name',c_office_location ='$c_office_location',radius ='$radius' WHERE site_id= '$site_id' ");
			
			if($result){
				
				// Display message if add  successful 
				echo "<script type=\"text/javascript\">".
        		"alert('Site Upload Success but no image');".
				"location.href = 'Sites.php';".
       			 "</script>";
			}else
			{
				echo "<script type=\"text/javascript\">".
        		"alert('Upload fail');".
				"location.href = 'Sites.php';".
       			 "</script>";

			}
	
	}
	else
	{
		echo "<script type=\"text/javascript\">".
        		"alert('Image type should only be png, jpg,gif and jpeg. And it size should not over 20KB');".
				"location.href = 'Sites.php';".
       			 "</script>";

	}

// if successful display message and redirect.
 }
 // redirect to permission page otherwise.
else
header("Location: Sites.php"); 


 ?>
