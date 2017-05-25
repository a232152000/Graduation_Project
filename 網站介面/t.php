<?php
	header("Content-type:text/html;charset=utf8");
		
		
		
		
		$PostName=@$_POST['PostName'];
		$PostMessage=@$_POST['PostMessage'];
		
		
		
		
		
		$servername="127.0.0.1";
		$userid="root";
		$password="";
		$db=new PDO("mysql:host=".$servername.";dbname=main",$userid,$password);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$setnames=$db->prepare("SET NAMES UTF8");
		$setnames->execute();
		
		//select
				$sql="SELECT * FROM post";
				$sth=$db->prepare($sql);
				$sth->execute();
				$e=$sth->fetchALL();	
				
				
		
		
		
		/*
		//insert
		$sql="INSERT INTO test (id,number) VALUES(:a,:b)";

		$sth=$db->prepare($sql);
		$sth->bindParam(":a",$u);
		$sth->bindParam(":b",$q);
		$u=$id;
		$q=$number;
		$sth->execute();
		*/
?>
<!DOCTYPE>
<html>
	<head>
			<meta charset="utf8"/>
			
			<style type="text/css">
			.AutoNewline
			{
			word-break: break-all;/*必須*/
			}
</style>
	</head>
	<body>
		<form action="t.php" method="POST">
				<input type="text" name="id">
				<input type="text" name="number">
				<input type="submit">
		</form>
		<table border='1'>
		<?php foreach($e as $b){ ?>	
			<tr>
				<td>
			<?php echo $b['PostName']?>
				</td>
				
				<td class="AutoNewline">
			<?php echo $b['PostMessage']?>
				</td>
				
			</tr>
		<?php }?>
		</table>
	</body>
</html>
