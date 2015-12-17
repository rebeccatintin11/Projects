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
var email=document.forms["addform"]["email"].value;
var uscid=document.forms["addform"]["uscid"].value;
if(email!="")
{
var atpos=email.indexOf("@");
var dotpos=email.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
  {
 document.getElementById("mailerror").style.visibility="visible";
  noerrors= false;
  }}
  if(uscid=="")
  {
  document.getElementById("missinguscid").innerHTML='USC ID can not be empty';
   document.getElementById("missinguscid").style.visibility="visible";
    noerrors= false;
  }
  
  
  if(uscid != "") 
  {

    var intRegex = /^\d+$/;
    if(!intRegex.test(uscid))
	{
	 document.getElementById("missinguscid").innerHTML='USC ID must be numeric only';
          document.getElementById("missinguscid").style.visibility="visible";
    noerrors= false;
    }

    if(uscid.length != 10)
    {
    	document.getElementById("missinguscid").innerHTML='USC ID must be 10 digits';
        document.getElementById("missinguscid").style.visibility="visible";
  noerrors= false;
    }
  
  
  }
  return noerrors;
}
</script>
</head>
<body>
   <!-- Display the form, call validateForm(), and redirect to addpermisison1.php-->
  <font color="red">* is required</font>
<form action="addpermisison1.php" method="post" onsubmit="return validateForm()" name="addform">
<div align="center">
  <table>
 
  	<tr>
  		<td class="center"><font color="red">*</font>USC ID </br>
<label id="missinguscid" style="visibility: hidden;Color:red;"> </label>
</td>
  		<td><input type="text" name="uscid"  /></td>
  	</tr>
	<tr>
  		<td class="center">First Name</td>
  		<td><input type="text" name="firstname" /></td>
  	</tr>	
	<tr>
  		<td class="center">Last Name</td>
  		<td><input type="text" name="lastname" /></td>
  	</tr>
  	<tr>
  		<td class="center"><font color="red">*</font>Role</td>
  		<td><select>
  			<option value="1">Admin</option>
  			<option value="0">Program Assistant</option>
			</select>
		</td>
  	</tr>
	<tr>
  		<td class="center">Email
</br>
<label id="mailerror" style="visibility: hidden;Color:red;"> Invalid email format</label>

</td>
  		<td><input type="text" name="email" /></td>
  	</tr>
	<tr>
  		<td class="center">Office Hours</td>
  		<td><textarea name="officehours"rows="4" cols="50"></textarea></td>
  	</tr>
  
  </table>
  <input class="button" type="submit" name="submit" value="Submit" />
  <input class="button" type="submit" name="clear" value="Cancel" />
</div>
</form>
</body>
</html>