<?php
	header("Content-type:application/json; charset=big5");
	
	define("userid","root");
	define("userpassword","");
	define("servername","127.0.0.1");
	
	$db=new PDO("mysql:host=".servername.";dbname=main",userid,userpassword);
	$setnames=$db->prepare("SET NAMES big5");
	$setnames->execute();
	
	//$sql = "SELECT COUNT(*) FROM firstdata WHERE target=:p";
	$sql = "SELECT COUNT(*) FROM post_feed WHERE PostPN=:p";
	$sth=$db->prepare($sql);
	
		$tar=1;
		$sth->bindParam(':p',$tar);
		$sth->execute();
		$r1 = $sth->fetchALL();
		
		$tar=-1;
		$sth->bindParam(':p',$tar);
		$sth->execute();
		$r2 = $sth->fetchALL();
		
		$tar=0;
		$sth->bindParam(':p',$tar);
		$sth->execute();
		$r3 = $sth->fetchALL();
	   $pc= $r1[0][0];
	   $nc= $r2[0][0];
	   $mc= $r3[0][0];
	   $pc_per=  number_format($pc/($pc+$nc+$mc),3);
	   $nc_per=  number_format($nc/($pc+$nc+$mc),3);
	   $mc_per=  number_format($mc/($pc+$nc+$mc),3);
	   
	   $r=json_encode(array("p_count"=>$pc,"n_count"=>$nc,"m_count"=>$mc,'p_per'=>$pc_per,'n_per'=>$nc_per,'m_per'=>$mc_per));
	   echo $r;
?>