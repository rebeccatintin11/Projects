<?php 
 include 'AdminLogin.php';
 
 $usc_id=$_SESSION['myusername'];
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
  
	<div align="center">

	<form action="upload_file_admin.php" method="post" enctype="multipart/form-data">
	 <table>
 
  	<tr>
		<td class="center"> <label for="file">Upload File:</label> </td>
		<td><input type="file" name="file" id="file"> </td>
	</tr>
	<tr>
		<td class="center"> <label for="file">File Name:</label></td>
		<td><textarea type="text" name="filename" rows="1" cols="50"></textarea></td>
	</tr>
	<tr>
		<td class="center"><label for="file">Description:</label></td>
		<td><textarea name="description"rows="4" cols="50"></textarea></td>
	</tr>
	</table>
		 <input type="submit" name="submit" value="Submit" />
	
	</form>

	</div>
	
  
<?php
	// connect to DB
	include 'DBlogin.php';
	
	// Get all file records.
	$getdata = mysql_query("SELECT * FROM DOCUMENTS WHERE staff_id=$usc_id order by document_id DESC;") 
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
        	<th>Delete</th>
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
<?php
			echo '<td><a href="delete_file.php?document_id=' . $row['document_id'].'&name='.$row['name']. '"' ?> onclick="return confirm('Are you sure you want to delete this document?')"> <img src="images/delete.png"  width='20' height='20'/></a></td>
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