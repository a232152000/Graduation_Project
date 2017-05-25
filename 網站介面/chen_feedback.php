
<?php

$value=$_GET['value'];
$PageId_value=$_GET['PostId'];


		$servername="127.0.0.1";
		$userid="root";
		$password="";
		$db=new PDO("mysql:host=".$servername.";dbname=main",$userid,$password);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$setnames=$db->prepare("SET NAMES UTF8");
		$setnames->execute();$conn= new PDO("mysql:localhost");

echo $value;
echo $PostId;
	$sql="UPDATE chen_post SET POSTPN = '$value' WHERE PostId = '$PageId_value'";
	$sth=$db->prepare($sql);
	$sth->execute();
?>
