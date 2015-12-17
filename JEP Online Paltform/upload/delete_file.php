<?php 
include 'PALogin.php';
include 'DBlogin.php'; 

 
 
 if (isset($_GET['name']) )
 {
  $name = $_GET['name'];
  $targetfolder = "upload/";
$target = $targetfolder.$name . ".pdf";
// See if it exists before attempting deletion on it
if (file_exists($target)) {
    unlink($target); // Delete now
} 


 }
 
 
 
 
 // check if the 'usc_id' variable is set in URL, and check that it is valid
 if (isset($_GET['document_id']) )
 {
 // get id value
 $document_id = $_GET['document_id'];
 
 // delete the entry
 $result1 = mysql_query("DELETE FROM DOCUMENTS WHERE document_id=$document_id")
 or die(mysql_error()); 
 
  $result2 = mysql_query("DELETE FROM DocumentsVoulnteer WHERE document_id=$document_id")
 or die(mysql_error()); 
 // If delte success show message
if($result1 && $result2 )
{ 

echo "<script type=\"text/javascript\">".
        "alert('Document Delete Success');".
		"location.href = 'MyDocumentsPA.php';".
        "</script>";		
 }
 }
 else
 // if id isn't set, or isn't valid, redirect back to view page
 {
 header("Location: MyDocumentsPA.php"); 
 } 
 ?>