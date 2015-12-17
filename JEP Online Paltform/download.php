<?php
if($_GET['f']!=null){
	$file=$_GET['f'];
	$url="http://jeppro.usc.edu/upload/";
	$num=date("Ymds");	
	header("Content-type:application");
	header("Content-Disposition: attachment; filename=".$file);	
	readfile($url.str_replace("@","",$file));	
	exit(0);
}else{
	echo "something is wrong";
}
?>