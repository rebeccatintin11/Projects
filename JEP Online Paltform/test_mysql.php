<?php
$con = mysql_connect("localhost","csci","cRe33Eth");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// some code

mysql_close($con);
?>
