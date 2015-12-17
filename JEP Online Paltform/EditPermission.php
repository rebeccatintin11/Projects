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
<script>
function validateForm()
{

var x=document.forms["editform"]["email"].value;
if(x!="")
{
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
 document.getElementById("mailerror").style.visibility="visible";
  return false;
  }}
}
</script>
</head>
<body>
 
 <!-- Get the USCID from the URL and get the record from DB -->
<?php 
include 'DBlogin.php';
$usc_id = $_GET['usc_id'];
if($usc_id=="")
header("Location: Permission.php"); 
$result = mysql_query("SELECT * FROM STAFF where usc_id= $usc_id"); 
 $row = mysql_fetch_array($result);
 ?>

  <!-- ####################################################################################################### -->
    <!-- Display the record info in the form, call validateForm(), then redirect to editpermisison1.php-->
  <font color="red">* is required</font>
<form action="editpermisison1.php" name="editform" method="post"   onsubmit="return validateForm()" >
<div align="center">
  <table>
 
  	<tr>
  		<td class="center"><font color="red">*</font>USC ID</td>
  		<td><input type="text" name="uscid" value="<?php echo  $row['usc_id']; ?>"  readonly /></td>
  	</tr>
	<tr>
 
  		<td class="center">First Name</td>
  		<td><input type="text" name="firstname"  value="<?php echo  $row['first_name']; ?>"  /></td>
  	</tr>	
	<tr>
  		<td class="center" >Last Name</td>
  		<td><input type="text" name="lastname" value="<?php echo  $row['last_name'];?>" /></td>
  	</tr>
  	<tr>
  		<td class="center"><font color="red">*</font>Role</td>
  		<td><select name="role">
  			<option value="1">Admin</option>
  			<option value="0">Program Assistant</option>
			</select>
		</td>
  	</tr>
	<tr>
  		<td class="center">Email</br>
<label id="mailerror" style="visibility: hidden;Color:red;"> Invalid email format</label></td>
  		<td><input type="text" value="<?php echo  $row['email']; ?>"  name="email" id="email" />


</td>
  	</tr>
	<tr>
  		<td class="center">Office Hours</td>
  		<td><textarea name="officehours"rows="4" cols="50"  > <?php echo  $row['office_hour']; ?></textarea></td>
  	</tr>
  
  </table>
  <input class="button" type="submit" name="submit" value="Edit" />
  <input class="button" type="submit" name="clear" value="Cancel" />
</div>

</form>
</body>
</html>