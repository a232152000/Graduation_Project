<?php

$NameId=$_GET['NameId'];

		$servername="127.0.0.1";
		$userid="root";
		$password="";
		$db=new PDO("mysql:host=".$servername.";dbname=main",$userid,$password);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$setnames=$db->prepare("SET NAMES UTF8");
		$setnames->execute();$conn= new PDO("mysql:localhost");

		
echo $NameId;
	$sql="UPDATE interface SET NameId ='$NameId'";
	$sth=$db->prepare($sql);
	$sth->execute();
?>
