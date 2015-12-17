<?php
 include 'StudentLogin.php';
	$uscid=$_SESSION['myusername'];
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/layout.css" type="text/css" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<meta charset="UTF-8">
<title>JEP Online Platform</title>
<script src="js/Dable.js"></script>
</head>
<body>
 
<?php
	// connect to DB
	include 'DBlogin.php';
	
	// Get all file records.
	$getdata = mysql_query("SELECT  name,description,D.document_id FROM DOCUMENTS D, DocumentsVoulnteer DV, VOLUNTEERS V WHERE DV.volunteer_id=V.volunteer_id and DV.document_id=D.document_id and V.usc_id=$uscid order by D.document_id DESC;") 
	or die(mysql_error()); 
	
?>

	<!-- display data in table -->
<div id="TableDable"> 
	<table border='1' cellpadding='10'>
	
	<thead>
		<tr>
        	<th>Document</th>
        	<th>Description</th>
        	<th>Download</th>
       	</tr>
	</thead>

	<!-- loop through results of database query, displaying them in the table -->
<?php
	while($row = mysql_fetch_array( $getdata )) {
		// echo out the contents of each row into a table	
?>
	<tbody>
		<tr>
			<td><?php echo $row['name'] ?></td>
			<td><?php echo $row['description']?></td>
			<td><a href="http://jeppro.usc.edu/download.php?f=<?php echo $row['name'].".pdf"?>" >
				<img src="images/download.png"  width='20' height='20' /></a></td>
		</tr>
<?php }// close table ?>

	</tbody>
</table>
</div>

	  <!-- Show the results in paginated table -->
<script type="text/javascript">
	var dable = new Dable("TableDable");
</script>

</body>
</html>