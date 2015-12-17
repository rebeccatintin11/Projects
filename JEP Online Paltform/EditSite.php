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
	var noerrors=true;
	var name=document.forms["editform"]["name"].value;
	var email=document.forms["editform"]["c_email"].value;
	var phone=document.forms["editform"]["phone"].value;
	if(email!="")
	{
		var atpos=email.indexOf("@");
		var dotpos=email.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
  		{
 			document.getElementById("mailerror").innerHTML='invalid mail format';
  			noerrors= false;
  		}
  		else
  		{
  			document.getElementById("mailerror").innerHTML='';
  		}
  	}
  	if(name=="")
	{
		document.getElementById("missingname").innerHTML='must enter a name';
		noerrors=false;
  	}
  	else
  	{
  		document.getElementById("missingname").innerHTML='';
  	}

  	if(phone!="") 
  	{
		var intRegex = /^\d+$/;
    	if(!intRegex.test(phone))
		{
	 		document.getElementById("phoneerror").innerHTML='phone must be numeric only';		
    		noerrors= false;
    	}
    	else if(phone.length != 10)
    	{
    		document.getElementById("phoneerror").innerHTML='phone must be 10 digits';
  			noerrors= false;
    	}
    	else
    	{
    		document.getElementById("phoneerror").innerHTML='';
    	}
  	}
    
	
  return noerrors;
}
</script>
</head>
<body>
 
 <!-- Get the USCID from the URL and get the record from DB -->
<?php 
include 'DBlogin.php';
$site_id = $_GET['site_id'];
if($site_id=="")
header("Location: Sites.php"); 
$result = mysql_query("SELECT * FROM SITES WHERE site_id= $site_id"); 
 $row = mysql_fetch_array($result);
 ?>

  <!-- ####################################################################################################### -->
    <!-- Display the record info in the form, call validateForm(), then redirect to editpermisison1.php-->
  <font color="red">* is required</font>
<form action="EditSiteAction.php" name="editform" method="post"   onsubmit="return validateForm()" enctype="multipart/form-data">
<div align="center">
  <table>
 
  	<tr>
  		<td class="center"><font color="red">*</font>site_id</td>
  		<td><input type="text" name="site_id" value="<?php echo  $row['site_id']; ?>"  readonly /></td>
  	</tr>
  	<tr>
		<td class="center"> <label for="file">Upload File:</label> </td>
		<td><?php echo  $row['image'];?><input type="file" name="file" id="file"> </td>
	</tr>
	<tr>
 
  		<td class="center">Site name<font color="red">*</font>
  		<label id="missingname" style="Color:red;"></label></td>
  		<td><input type="text" name="name"  value="<?php echo  $row['name']; ?>"  /></td>
  	</tr>	
	<tr>
  		<td class="center" >Address</td>
  		<td><input type="text" name="adress" value="<?php echo  $row['adress'];?>" /></td>
  	</tr>
  	<tr>
 
  		<td class="center">Radius</td>
  		<td><input type="text" name="radius"  value="<?php echo  $row['radius']; ?>"  /></td>
  	</tr>

  	<tr>
 
  		<td class="center">Phone
  		<label id="phoneerror" style="Color:red;"></label></td>
  		<td><input type="text" name="phone"  value="<?php echo  $row['phone']; ?>"  /></td>
  	</tr>
  	<tr>
  		<td class="center">Email
		<label id="mailerror" style="Color:red;"></label></td>
  		<td><input type="text" value="<?php echo  $row['c_email']; ?>"  name="c_email" id="c_email" />


</td>
  	</tr>
  	<tr>
 
  		<td class="center">Coordinator first name</td>
  		<td><input type="text" name="c_first_name"  value="<?php echo  $row['c_first_name']; ?>"  /></td>
  	</tr>
  	<tr>
 
  		<td class="center">Coordinator last name</td>
  		<td><input type="text" name="c_last_name"  value="<?php echo  $row['c_last_name']; ?>"  /></td>
  	</tr>
	<tr>
 
  		<td class="center">Office location</td>
  		<td><input type="text" name="c_office_location"  value="<?php echo  $row['c_office_location']; ?>"  /></td>
  	</tr>
  	<tr>
 
  		<td class="center">Early dismissal</td>
  		<td><input type="text" name="early_dismissal"  value="<?php echo  $row['early_dismissal']; ?>"  /></td>
  	</tr>
  	<tr>
 
  		<td class="center">Dress code</td>
  		<td><input type="text" name="dress_code"  value="<?php echo  $row['dress_code']; ?>"  /></td>
  	</tr>
	<tr>
  		<td class="center">Description</td>
  		<td><textarea name="description"rows="4" cols="50"  > <?php echo  $row['description']; ?></textarea></td>
  	</tr>
  
  </table>
  <input class="button" type="submit" name="submit" value="Edit" />
  <input class="button" type="submit" name="clear" value="Cancel" />
</div>

</form>
</body>
</html>