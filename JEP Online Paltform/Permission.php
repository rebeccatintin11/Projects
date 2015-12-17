<?php 
 include 'AdminLogin.php';
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

  <br/>
  <a href="AddPermission.php" class="button">Add User</a>
	<br/>
<br/>
	<?php
 // connect to DB
 include 'DBlogin.php';
 // Get all Staff records.

 $result = mysql_query("SELECT * FROM STAFF order by first_name") 


  or die(mysql_error()); 
             
                
        // display data in table
   ?>
<div id="TableDable"> 

        
        <table border='1' cellpadding='10'>
        <thead> <tr> <th>ID</th> <th>First Name</th> <th>Last Name</th> <th>Role</th>
<th>Office Hours</th> <th>Email</th> <th>Edit</th> <th id="delete">Delete</th></tr> </thead>

        // loop through results of database query, displaying them in the table
<?php
        while($row = mysql_fetch_array( $result )) {
                ?>
                // echo out the contents of each row into a table
  <tbody>
                <tr>
                <td><?php echo $row['usc_id'] ?></td>
                <td><?php echo $row['first_name']?></td>
                <td><?php echo $row['last_name'] ?></td>
<?php if ($row['is_admin']==1) 
 {
 
 ?>
 <td>Admin </td>
<?php
 }
 
else
 {
 
  ?>
 <td> Program  Assistant</td>
 <?php 
 } 
 ?>


<td> <?php echo $row['office_hour'] ?> </td>
<td> <?php echo $row['email'] ?></td>
                <td><a href="EditPermission.php?usc_id=<?php echo $row['usc_id'] . '"' ?> ><img src="images/edit.png"  width='20' height='20' /></a></td>



          <?php   echo '<td><a  href="DeletePermission.php?usc_id=' . $row['usc_id'] . '"' ?> onclick="return confirm('Are you sure you want to delete this permission?')"> <img src="images/delete.png"  width='20' height='20'/>
</a></td>
          </tr>
       <?php } ?>

        // close table>
</tbody>
       </table>

</div>
	  <!-- Show the results in paginated table -->
  <script type="text/javascript">
	
	var dable = new Dable("TableDable");
</script>
</body>
</html>