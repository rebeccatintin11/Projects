<?php
include 'PALogin.php';
include 'DBlogin.php';// connectto DB
$checkBox =$_POST['students'];
$result1;
$document_id;
$filename=$_SESSION['filename'];


$query1="SELECT D.document_id from DOCUMENTS D where D.name='$filename' LIMIT 1";
$result = mysql_query($query1);

if ($result) {
  $row = mysql_fetch_row($result);
   $document_id = $row[0];
  
}


 if (isset($_POST['add']))
 {
 	for ($i=0; $i<sizeof($checkBox); $i++)
 	{
 		
 		$query = "INSERT INTO DocumentsVoulnteer(volunteer_id, document_id) VALUES($checkBox[$i], $document_id)";
		$result1= mysql_query($query);
		
 	}
 }

 if($result1)
 {
 	
echo "<script type=\"text/javascript\">".
      "alert('Document Assignment Success');".
		"location.href = 'MyDocumentsPA.php';".
     "</script>";
 }
 
 else
 {
 	echo"An error occuerd while assigning the doucment.";
 }
 

 

?>