<?php
	session_start();
	header("Content-type:text/html;charset=utf8");
	@$NameId=$_GET['NameId'];
	$NameId=$_SESSION["NameId"];
	@$_SESSION["SelectTime"]=$_GET['SelectTime'];
	$SelectTime=$_SESSION["SelectTime"];

		//echo $NameId;
		
		
		$UserName=@$_POST['UserName'];
		$PageMessage=@$_POST['PageMessage'];
		$PageTime=@$_POST['PageTime'];
		$PageId=@$_POST['PageId'];

		
		
		$servername="127.0.0.1";
		$userid="root";
		$password="";
		$db=new PDO("mysql:host=".$servername.";dbname=main",$userid,$password);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$setnames=$db->prepare("SET NAMES UTF8");
		$setnames->execute();
		
		//select
	if( $NameId=="46251501064")
	{
	if($SelectTime==NULL)$SelectTime="7";
				$sql="SELECT * FROM `page` WHERE month(PageTime)='$SelectTime'";

				$sth=$db->prepare($sql);
				$sth->execute();
				$e=$sth->fetchALL();	
	}		

	if( $NameId=="232716627404")
	{
	if($SelectTime==NULL)$SelectTime="7";
				$sql="SELECT * FROM chen_page WHERE month(PageTime)='$SelectTime'";

				$sth=$db->prepare($sql);
				$sth->execute();
				$e=$sth->fetchALL();	
	}		
?>
<!DOCTYPE>
<html>
<head>
  <title>情緒分析之臉書粉絲團</title>
  <link rel=stylesheet type="text/css" href="1_1.css">
  <link rel=stylesheet type="text/css" href="button.css">

	<script src='jquery-3.0.0.min.js'></script>
	<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
	<script src="http://cdn.hcharts.cn/highstock/highstock.js"></script>
	<script src="http://cdn.hcharts.cn/highmaps/highmaps.js"></script>
	
	<style>
		body {background :#EDEDED	;color : black}
	</style>
	<style type="text/css">
		.AutoNewline
		{
		word-break: break-all;/*必須*/
		}
	</style>

<script>

function GetTime()
{
	//alert("Connect");
	TakeValue=$("#GetTimeValue").val();
	//alert(TakeValue);
	
	window.location.href="3.php?SelectTime="+TakeValue;
}

</script>

</head>
<body>
	<ul class="drop-down-menu">
        <li><a href="1.php">首頁</a></li>
        <li><a href="2.php?NameId=<?php echo $NameId?>">圖表分析</a></li>
        <li><a href="3.php?NameId=<?php echo $NameId?>">文章列表</a></li>
        <li><a href="keyword.php?NameId=<?php echo $NameId?>">關鍵字</a></li>

    </ul>

	<p></p>		
	
	<!--背景-->

	<?php if( $NameId=="46251501064" ){?>
	
	<table width="100%" style="font-family:微軟正黑體;border:1px solid;">
        <tr>
            <td>
			  <div><img src="tsaiingwen.jpg" style="width:200px"></div>
              <div style="width:350px;padding-left:8px;padding-right:8px ;font-size: auto; font-family:微軟正黑體">蔡英文 Tsai Ing-wen </div>
              <hr style='border-right:2px solid #A9A9A9'>
			  <div style="padding-top:10px;text-align:left ;font-size: auto;font-family:微軟正黑體">「台灣的好，不應該輕易被擊倒。當新時代已經敲門，我們必須把門打開，讓世界看見台灣的好。」</div>
			</td>
			<td style='border-right:2px solid #A9A9A9'></td>			
			<td>
				<img src="tsaiingwen_background.jpg" style=" background-repeat:no-repeat;height:300px">
            </td>
			
		</tr>
    </table>
	<?php } ?>
	
	<?php if( $NameId=="232716627404" ){?>
	
	<table width="100%" border="2">
        <tr>
            <td>
			  <div><img src="kikuChen.jpg" style="width:200px"></div>
              <div style="width:350px;padding-left:8px;padding-right:8px ;font-size: auto;font-family:微軟正黑體">陳菊(花媽)市長 </div>
              <div style="padding-top:10px;text-align:left ;font-size: auto;font-family:微軟正黑體">㊣㊣㊣ 陳菊 ● 花媽粉絲團 ㊣㊣㊣ since 2010.01.06. 高雄市政府市民熱線：1999 里民防災卡資訊↓ http://cabu.kcg.gov.tw/precaution/main/index.aspx</div>
			</td>
			
			<td>
				<img src="kikuChen_background.jpg" style=" background-repeat:no-repeat;height:300px">
            </td>
			
		</tr>
    </table>
	<?php } ?>
<!--背景-->

<!-- 選擇時間 -->
<p></p>

	
				<select id="GetTimeValue" style="width:120px;font-size:16pt;font-family:微軟正黑體">
					<option value=1>一月</option>
					<option value=2>二月</option>
					<option value=3>三月</option>
					<option value=4>四月</option>
					<option value=5>五月</option>
					<option value=6>六月</option>
					<option selected value=7>七月</option>
				</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type ="button" onclick="GetTime()"  value="選擇" class="css_btn1" style="font-family:微軟正黑體"></input>
				
			
<p></p>

<!-- 選擇時間 -->



<!--	<span id='container1'></span>  -->
	<table style="font-family:微軟正黑體 ;font-size:18pt;border:1px solid;">
		
		<th style="font-family:微軟正黑體;border:1px solid;">貼文</th>
		<th style="font-family:微軟正黑體;border:1px solid;">時間</th>
		<th style="font-family:微軟正黑體;border:1px solid;">留言</th>
		
		<?php foreach($e as $b){ ?>	
			<tr style="font-family:微軟正黑體;border:1px solid;">
				
				
				<td class="AutoNewline" style="font-family:微軟正黑體;border:1px solid;">
					<br>
					<?php echo $b['PageMessage']?>
					<br>
					<br>
				</td>
				
				<td style="font-size:18pt;font-family:微軟正黑體;border:1px solid;">
					<?php echo $b['PageTime']?>
				</td>
				
				<td style="font-size:18pt;font-family:微軟正黑體;border:1px solid;">
					<input type ="button" class="css_btn1" onclick="location.href='4.php?PageId=<?php echo $b['PageId']?>'"  value="觀看留言" style="font-size:18pt;font-family:微軟正黑體"></input>
				</td>
			</tr>
		<?php }?>
		</table>
<!--頁面置頂-->
<a style="display:scroll;position:fixed;bottom:0px;right:10px;" href="#" title="" onFocus="if(this.blur)this.blur()">
<img alt='' border='0' onmouseover="this.src='頁面置頂箭頭.png'" src="頁面置頂箭頭.png" onmouseout="this.src='頁面置頂箭頭.png'" /></a>
<!--頁面置頂-->
	</body>
</html>
