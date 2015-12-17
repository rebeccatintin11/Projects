<?php
 include 'AdminLogin.php';
 include 'DBlogin.php';// connectto DB
 
 if (isset($_POST['submit'])){
 
 	// Get the values from POST.
 	$description=mysql_real_escape_string(htmlspecialchars($_POST['description']));
 	$filename = mysql_real_escape_string(htmlspecialchars($_POST['filename']));
 	$uscid=$_SESSION['myusername'];
 	
 	$time = time();
 	$filename = $filename."_".date("m_d_y_His",$time);
 	$targetfolder = "upload/";
 	$targetfolder = $targetfolder.$filename.".".basename($_FILES['file']['type']);
 	
 	$ok=1;
 
	$file_type=$_FILES['file']['type'];

	if (($file_type=="application/pdf" ) && ($_FILES["file"]["size"] < 2048000) ){
		
		if(move_uploaded_file($_FILES['file']['tmp_name'],  $targetfolder)){
		
				
			$result=mysql_query("INSERT INTO DOCUMENTS (staff_id,name , description) VALUES ('$uscid', '$filename', '$description')");
				
			
			$_SESSION['filename']=$filename;
		
			if($result){
				
				// Display message if add  successful 
				echo "<script type=\"text/javascript\">".
        		"alert('File Upload Success');".
				"location.href = 'SelectStudentAdmin.php';".
       			 "</script>";
			
			
			}else{
				echo "something wrong";
			}
		
		}else{
 			echo "Error uploading file";
		}
	
	}else{
		echo "You may only upload PDF files under 2 Mb.<br>";
	}

}

 
?>