<?php

include 'DBlogin.php';// connectto DB
 


  // query = "SELECT document_id from DOCUMENTS D where d.name= mm_04_05_14_163038 LIMIT 1";
  
//$document_id = mysqli_query($query );
foreach($_POST["students"] as $loc_id)
{
  $query = "INSERT INTO DocumentsVoulnteer(volunteer_id, document_id) VALUES($loc_id, 000)";
 $result1= mysql_query($query);
}
?>