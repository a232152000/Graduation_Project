<?php
		$servername="127.0.0.1";
		$userid="root";
		$password="";
		$db=new PDO("mysql:host=".$servername.";dbname=main",$userid,$password);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$setnames=$db->prepare("SET NAMES UTF8");
		$setnames->execute();
		
session_start();
?>

<html>
<head>
<style>

h1 {
font-family: "微軟正黑體", TW-Kai, "Yu Gothic", "Ms PGothic", SimHei, DFKai-SB, sans-serif;
font-size: 60px;
color: #666;
text-shadow: 1px 1px 2px #bbb;
}
</style>


  <meta charset="utf-8">
  <link rel=stylesheet type="text/css" href="1_1.css">
  <link rel=stylesheet type="text/css" href="button.css">
  
	<script src='jquery-3.0.0.min.js'></script>
	<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
	<script src="http://cdn.hcharts.cn/highstock/highstock.js"></script>
	<script src="http://cdn.hcharts.cn/highmaps/highmaps.js"></script>
  <style>
  	body {background :#EDEDED	;color : black}
	.img1{float:left;}
  </style>
  <title>情緒分析之臉書粉絲團</title>
<div style="position:absolute;left: 180px ;top: -25px"> <h1>歡迎來到臉書粉絲團情緒分析系統</h1> </div>
 

 <script>
 /*
 function people1()
 {	
	<?php  
	 $_SESSION["people"]=232716627404;
	?>
	location.href='2.php';
 }
 
 function people2()
 {	
	<?php  
	
	 $_SESSION["people"]=46251501064;
	?>
	location.href='2.php';
 }
 */
 </script>
 
 
</head>

<body>

	<div style="position:absolute;left: 230px ;top: 100px"> 
		<center><img src='h1.jpg' width="800" height="80" align="center" ></center></p>
	</div>
	
	
	<div style="position:absolute;left: 300px ;top: 260px"> 

		<img src="kikuChen.jpg" height="360" width="280">

		<p align="center"><input type ="button" class="css_btn1" onclick="location.href='2.php?NameId=232716627404'" value="陳菊(花媽)市長"style="width:180px;height:40px;font-size:18pt" ></input></p>
	</div>
	
		<div style="position:absolute;left: 700px ;top: 260px"> 

		<img src="tsaiingwen.jpg" height="360" width="280">
		<p align="center"> <input type ="button" class="css_btn1" onclick="location.href='2.php?NameId=46251501064'" value="蔡英文" style="width:140px;height:40px;font-size:18pt"></input></p>
	</div>
	

</body>

</html>
<div class="img1">
</div>


<input type ="button" class="css_btn1" onclick="location.href='http://02360325.ddns.net/project_extra/get_message.php#'" value="即時分析" style="width:140px;height:40px;font-size:18pt"></p>





<!---跑馬燈-->

	<script language="javascript">
		var info="                                ~~~~~歡迎來到情緒分析系統~~~~~以臉書粉絲團為例~~~~~                                ";
		var interval = 200;
		var empty = "";
		var sin = 0;
		function Scroll()
		{
		document.myForm.myText.value = info.substring(sin,info.length) + empty +info.substring(0,info.length);
		sin++;
		sin++;
		if(sin>info.length)
			sin=0;
		window.setTimeout("Scroll();",interval);
		}
	</script>

<!---跑馬燈結束-->

<!--
<body onload="javascript:Scroll()">
	<ul class="drop-down-menu">
        <li><a href="1.php">首頁</a></li>
	<li>
-->	
	<!--跑馬燈使用------------------------------------------------------------->
<!--	
	<form name="myForm" style="height:12px">
		<input type="text" name="myText" style="width:301%;height:41px;font-size:30px;font-family:微軟正黑體">
-->
	</form>
	<!--跑馬燈使用結束--------------------------------------------------------->
	</li>
    </ul> 