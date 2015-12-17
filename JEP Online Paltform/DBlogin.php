<?php
 
$host="localhost"; // Host name 
$username="csci"; // Mysql username 
$password="cRe33Eth"; // Mysql password 
$db_name="jepop"; // Database name
// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect: "  . mysql_error()); 
mysql_select_db("$db_name")or die("cannot select DB");
 ?>