<?php

		session_start();
		$NameId=$_SESSION["NameId"];
		@$_SESSION["SelectWeek"]=$_GET['SelectWeek'];
		$SelectWeek=$_SESSION["SelectWeek"];

		@$_SESSION["SelectMonth"]=$_GET['SelectMonth'];
		$SelectMonth=$_SESSION["SelectMonth"];

		@$_SESSION["id_click"]=$_GET['id_click'];
		$id_click=$_SESSION["id_click"];

		@$_SESSION["wordid"]=$_GET['wordid'];
		$wordid=$_SESSION["wordid"];

		@$_SESSION["total"]=$_GET['total'];
		$total=$_SESSION["total"];
		
		@$NameId=$_GET['NameId'];
		$NameId=$_SESSION["NameId"];
		
		@$_SESSION["SelectWeekMonth"]=$_GET['SelectWeekMonth'];
		$SelectWeekMonth=$_SESSION["SelectWeekMonth"];
		
		@$_SESSION["EmotionValue"]=$_GET['EmotionValue'];
		$EmotionValue=$_SESSION["EmotionValue"];
		
		$servername="127.0.0.1";
		$userid="root";
		$password="";
		$db=new PDO("mysql:host=".$servername.";dbname=main",$userid,$password);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$setnames=$db->prepare("SET NAMES UTF8");
		$setnames->execute();
		

////////////////////////////////////////
///////////////NameId預設蔡英文到時候要改/////////////////////////


/////////////////////////////////////////////////////////////

if($SelectWeek==NULL)$SelectWeek="1";
//if($SelectMonth==NULL)$SelectMonth="1";
if($id_click==NULL)$id_click="0";
if($total==NULL)$total="50";
if($SelectWeekMonth==NULL)$SelectWeekMonth="0";
if($EmotionValue==NULL)$EmotionValue="-1";



?>

<html>
<head>
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
  
  
<script>
function GetWeek()
{
//alert("Connect");
TakeValue=$("#GetTWeekValue").val();
//alert(TakeValue);

window.location.href="keyword.php?SelectWeek="+TakeValue+"<?php echo '&SelectWeekMonth=0';?>"+"<?php echo '&wordid=';echo $wordid?>"+"<?php echo '&id_click=0'?>"+"<?php echo '&SelectMonth=';echo $SelectMonth?>"+"<?php echo '&EmotionValue=';echo $EmotionValue?>";
}
</script>

<script>

function GetMonth()
{
//alert("Connect");
TakeValue=$("#GetTMonthValue").val();
//alert(TakeValue);
window.location.href="keyword.php?SelectMonth="+TakeValue+"<?php echo '&SelectWeekMonth=1';?>"
}

</script>

<script>
	
	function GetValue()
	{
	//alert("Connect");
	TakeValue=$("#GetListValue").val();
	//alert(TakeValue);
	
	window.location.href="keyword.php?total="+TakeValue+"<?php echo '&wordid=';echo $wordid?>"+"<?php echo '&id_click=1'?>"+"<?php echo '&SelectWeek=';echo $SelectWeek?>"+"<?php echo '&SelectMonth=';echo $SelectMonth?>"+"<?php echo '&EmotionValue=';echo $EmotionValue?>";

	}

	</script>

<script>
	
	function GetTEmotion()
	{
	//alert("Connect");
	TakeValue=$("#GetTEmotionValue").val();
	//alert(TakeValue);
	
	window.location.href="keyword.php?EmotionValue="+TakeValue+"<?php echo '&wordid=';echo $wordid?>"+"<?php echo '&id_click=0'?>"+"<?php echo '&SelectWeek=';echo $SelectWeek?>"+"<?php echo '&SelectMonth=';echo $SelectMonth?>";

	}

	</script>

	<script>
	function feedback(data,PostId){
  //取得 "data" 值
  var value = data;        

   //取得 "PostId" 值                                
  var PostId = PostId;                                           

    $.ajax({

        //告訴程式表單要傳送到哪裡    
		<?php 
		if($NameId=="46251501064"){
		?>	
		 url:"feedback.php",     
		<?php } ?>
		
		<?php 
		if( $NameId=="232716627404"){
		?>
		
		 url:"chen_feedback.php",     
		<?php } ?>

		
                                                                
		
        //需要傳送的資料
        data:"&value="+value+"&PostId="+PostId,  

         //使用POST方法     
        type : "GET",                                                                    

         //傳送失敗則跳出失敗訊息      
        error:function(){                                                                 

        //資料傳送失敗後就會執行這個function內的程式，可以在這裡寫入要執行的程式  
        alert("失敗");
        },

        //傳送成功則跳出成功訊息
        success:function(){                                                           
        //資料傳送成功後就會執行這個function內的程式，可以在這裡寫入要執行的程式  
		alert("value=" +value + "  以回報");
        }
    }); 
};
	</script>
	
<style type="text/css">
			.AutoNewline
			{
			word-break: break-all;/*必須*/
			}
</style>

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
	
	<table width="100%" border="2">
        <tr>
            <td>
			  <div><img src="tsaiingwen.jpg" style="width:200px"></div>
              <div style="width:350px;padding-left:8px;padding-right:8px ;font-size: auto;font-family:微軟正黑體">蔡英文 Tsai Ing-wen </div>
              <div style="padding-top:10px;text-align:left ;font-size: auto;font-family:微軟正黑體">「台灣的好，不應該輕易被擊倒。當新時代已經敲門，我們必須把門打開，讓世界看見台灣的好。」</div>
			</td>
			
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
<p></p>

<!--選擇第幾週-->
<table width="100%" style="font-size:18pt;font-family:微軟正黑體;border:1px solid;">
        <tr>
            <td>
				<select id="GetTWeekValue" style="width:220px;font-size:16pt;font-family:微軟正黑體">
					<option selected value=1>第1週(1/01~1/07)</option>
					<option value=2>第2週(1/08~1/14)</option>
					<option value=3>第3週(1/15~1/21)</option>
					<option value=4>第4週(1/22~1/28)</option>
					<option value=5>第5週(1/29~2/04)</option>
					<option value=6>第6週(2/05~2/11)</option>
					<option value=7>第7週(2/12~2/18)</option>
					<option value=8>第8週(2/19~2/25)</option>
					<option value=9>第9週(2/26~3/03)</option>
					<option value=10>第10週(3/04~3/10)</option>
					<option value=11>第11週(3/11~3/17)</option>
					<option value=12>第12週(3/18~3/24)</option>
					<option value=13>第13週(3/25~3/31)</option>
					<option value=14>第14週(4/01~4/07)</option>
					<option value=15>第15週(4/08~4/14)</option>
					<option value=16>第16週(4/15~4/21)</option>
					<option value=17>第17週(4/22~4/28)</option>
					<option value=18>第18週(4/29~5/05)</option>
					<option value=19>第19週(5/06~5/12)</option>
					<option value=20>第20週(5/13~5/19)</option>
					<option value=21>第21週(5/20~5/26)</option>
					<option value=22>第22週(5/27~6/02)</option>
					<option value=23>第23週(6/03~6/09)</option>
					<option value=24>第24週(6/10~6/16)</option>
					<option value=25>第25週(6/17~6/23)</option>
					<option value=26>第26週(6/24~6/30)</option>
					<option value=27>第27週(7/01~7/07)</option>
					<option value=28>第28週(7/08~1/14)</option>
					<option value=29>第29週(7/15~7/21)</option>
					<option value=30>第30週(7/22~1/28)</option>
				</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type ="button" class="css_btn1" onclick="GetWeek()"  value="選擇週" style="width:140px;height:40px;font-size:18pt"></input>
<!--選擇第幾週-->
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<!--選擇第幾月-->
<!--
				<select id="GetTMonthValue" style="width:120px;font-size:16pt;font-family:微軟正黑體">
					<option selected value=1>第1月</option>
					<option value=2>第2月</option>
					<option value=3>第3月</option>
					<option value=4>第4月</option>
					<option value=5>第5月</option>
					<option value=6>第6月</option>
					<option value=7>第7月</option>
				</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type ="button" class="css_btn1" onclick="GetMonth()"  value="選擇月" style="width:100px;height:30px;font-size:16px;"></input>
-->
<!--選擇第幾月-->



<!--選擇正負無-->
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<select id="GetTEmotionValue" style="width:120px;font-size:16pt;font-family:微軟正黑體">
					<option selected value='-1'>負面情緒</option>
					<option value='1'>正面情緒</option>
					<option value='0'>無情緒</option>
				</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type ="button" class="css_btn1" onclick="GetTEmotion()"  value="選擇情緒" style="font-size:18pt;width:140px;height:40px"></input>
<!--選擇正負無-->				
			</td>
			
		</tr>
    </table>

	<p></p>
<?php if( $SelectWeekMonth=='0'){ ?>

<!--顯示週的日期-->

	<script>
				if (<?php echo $SelectWeek ?>=="1")document.write("<center><font color='red' size='26px'>1/01~1/07</font>");
				if (<?php echo $SelectWeek ?>=="2")document.write("<center><font color='red' size='26px'>1/08~1/14</font>");
				if (<?php echo $SelectWeek ?>=="3")document.write("<center><font color='red' size='26px'>1/15~1/21</font>");
				if (<?php echo $SelectWeek ?>=="4")document.write("<center><font color='red' size='26px'>1/22~1/28</font>");
				if (<?php echo $SelectWeek ?>=="5")document.write("<center><font color='red' size='26px'>1/29~2/04</font>");
				if (<?php echo $SelectWeek ?>=="6")document.write("<center><font color='red' size='26px'>2/05~2/11</font>");
				if (<?php echo $SelectWeek ?>=="7")document.write("<center><font color='red' size='26px'>2/12~2/18</font>");
				if (<?php echo $SelectWeek ?>=="8")document.write("<center><font color='red' size='26px'>2/19~2/25</font>");
				if (<?php echo $SelectWeek ?>=="9")document.write("<center><font color='red' size='26px'>2/26~3/03</font>");
				if (<?php echo $SelectWeek ?>=="10")document.write("<center><font color='red' size='26px'>3/04~3/10</font>");
				if (<?php echo $SelectWeek ?>=="11")document.write("<center><font color='red' size='26px'>3/11~3/17</font>");
				if (<?php echo $SelectWeek ?>=="12")document.write("<center><font color='red' size='26px'>3/18~3/24</font>");
				if (<?php echo $SelectWeek ?>=="13")document.write("<center><font color='red' size='26px'>3/25~3/31</font>");
				if (<?php echo $SelectWeek ?>=="14")document.write("<center><font color='red' size='26px'>4/01~4/07</font>");
				if (<?php echo $SelectWeek ?>=="15")document.write("<center><font color='red' size='26px'>4/08~4/14</font>");
				if (<?php echo $SelectWeek ?>=="16")document.write("<center><font color='red' size='26px'>4/15~4/21</font>");
				if (<?php echo $SelectWeek ?>=="17")document.write("<center><font color='red' size='26px'>4/22~4/28</font>");
				if (<?php echo $SelectWeek ?>=="18")document.write("<center><font color='red' size='26px'>4/29~5/05</font>");
				if (<?php echo $SelectWeek ?>=="19")document.write("<center><font color='red' size='26px'>5/06~5/12</font>");
				if (<?php echo $SelectWeek ?>=="20")document.write("<center><font color='red' size='26px'>5/13~5/19</font>");
				if (<?php echo $SelectWeek ?>=="21")document.write("<center><font color='red' size='26px'>5/20~5/26</font>");
				if (<?php echo $SelectWeek ?>=="22")document.write("<center><font color='red' size='26px'>5/27~6/02</font>");
				if (<?php echo $SelectWeek ?>=="23")document.write("<center><font color='red' size='26px'>6/03~6/09</font>");
				if (<?php echo $SelectWeek ?>=="24")document.write("<center><font color='red' size='26px'>6/10~6/16</font>");
				if (<?php echo $SelectWeek ?>=="25")document.write("<center><font color='red' size='26px'>6/17~6/23</font>");
				if (<?php echo $SelectWeek ?>=="26")document.write("<center><font color='red' size='26px'>6/24~6/30</font>");
				if (<?php echo $SelectWeek ?>=="27")document.write("<center><font color='red' size='26px'>7/01~7/07</font>");
				if (<?php echo $SelectWeek ?>=="28")document.write("<center><font color='red' size='26px'>7/08~1/14</font>");
				if (<?php echo $SelectWeek ?>=="29")document.write("<center><font color='red' size='26px'>7/15~7/21</font>");
				if (<?php echo $SelectWeek ?>=="30")document.write("<center><font color='red' size='26px'>7/22~1/28</font>");
				
				
				if (<?php echo $EmotionValue ?>=="0")document.write("<center><font color='red' size='26px'>無情緒</font>");
				if (<?php echo $EmotionValue ?>=="-1")document.write("<center><font color='red' size='26px'>負面情緒</font>");
				if (<?php echo $EmotionValue ?>=="1")document.write("<center><font color='red' size='26px'>正面情緒</font>");

</script>	

	<p></p>
	<p></p>

	
<div>

<!--顯示關鍵字週排行-->

<?php 
		if($NameId=="46251501064"){
		?>	
		

<?php if($EmotionValue=='0'){ ?>
<img src='wordcloud_rfidf_total/week<?php echo $SelectWeek ?>.png' width="750" height="750" align="left" HSPACE='80'></p>
<?php } ?>

<?php if($EmotionValue=='-1'){ ?>
<img src='wordcloud_rfidf_neg/week<?php echo $SelectWeek ?>.png' width="750" height="750" align="left" HSPACE='80'></p>
<?php } ?>

<?php if($EmotionValue=='1'){ ?>
<img src='wordcloud_rfidf_pos/week<?php echo $SelectWeek ?>.png' width="750" height="750" align="left" HSPACE='80'></p>
<?php } ?>

 
		<?php } ?>
		
		
		
		
		<?php 
		if($NameId=="232716627404"){
		?>	
		

<?php if($EmotionValue=='0'){ ?>
<img src='chen_wordcloud_rfidf_total/week<?php echo $SelectWeek ?>.png' width="750" height="750" align="left" HSPACE='80'></p>
<?php } ?>

<?php if($EmotionValue=='-1'){ ?>
<img src='chen_wordcloud_rfidf_neg/week<?php echo $SelectWeek ?>.png' width="750" height="750" align="left" HSPACE='80'></p>
<?php } ?>

<?php if($EmotionValue=='1'){ ?>
<img src='chen_wordcloud_rfidf_pos/week<?php echo $SelectWeek ?>.png' width="750" height="750" align="left" HSPACE='80'></p>
<?php } ?>

 
		<?php } ?>
<!--顯示關鍵字週排行-->

<?php
if($NameId=="46251501064"){

if($EmotionValue==0)
{
$sql="select keyword_feed.keyword,keyword_feed.wordid,(idf_feed.rfidf * idf_feed.DF) from keyword_feed,idf_feed WHERE keyword_feed.nametype='n' AND idf_feed.week='$SelectWeek' AND idf_feed.id=keyword_feed.wordid ORDER BY (idf_feed.rfidf * idf_feed.DF) DESC limit 0,20";
}

if($EmotionValue==-1)
{
$sql="select keyword_feed.keyword,keyword_feed.wordid,(idf_neg.rfidf * idf_neg.DF) from keyword_feed,idf_neg WHERE keyword_feed.nametype='n' AND idf_neg.week='$SelectWeek' AND idf_neg.id=keyword_feed.wordid ORDER BY (idf_neg.rfidf * idf_neg.DF) DESC limit 0,20";
}

if($EmotionValue==1)
{
$sql="select keyword_feed.keyword,keyword_feed.wordid,(idf_pos.rfidf * idf_pos.DF) from keyword_feed,idf_pos WHERE keyword_feed.nametype='n' AND idf_pos.week='$SelectWeek' AND idf_pos.id=keyword_feed.wordid ORDER BY (idf_pos.rfidf * idf_pos.DF) DESC limit 0,20";
}

}


if($NameId=="232716627404"){

if($EmotionValue==0)
{
$sql="select keyword_feed.keyword,keyword_feed.wordid,(chen_idf_all.rfidf * chen_idf_all.DF) from keyword_feed,chen_idf_all WHERE keyword_feed.nametype='n' AND chen_idf_all.week='$SelectWeek' AND chen_idf_all.id=keyword_feed.wordid ORDER BY (chen_idf_all.rfidf * chen_idf_all.DF) DESC limit 0,20";
}

if($EmotionValue==-1)
{
$sql="select keyword_feed.keyword,keyword_feed.wordid,(chen_idf_neg.rfidf * chen_idf_neg.DF) from keyword_feed,chen_idf_neg WHERE keyword_feed.nametype='n' AND chen_idf_neg.week='$SelectWeek' AND chen_idf_neg.id=keyword_feed.wordid ORDER BY (chen_idf_neg.rfidf * chen_idf_neg.DF) DESC limit 0,20";
}

if($EmotionValue==1)
{
$sql="select keyword_feed.keyword,keyword_feed.wordid,(chen_idf_pos.rfidf * chen_idf_pos.DF) from keyword_feed,chen_idf_pos WHERE keyword_feed.nametype='n' AND chen_idf_pos.week='$SelectWeek' AND chen_idf_pos.id=keyword_feed.wordid ORDER BY (chen_idf_pos.rfidf * chen_idf_pos.DF) DESC limit 0,20";
}

}

				$sth=$db->prepare($sql);
				$sth->execute();
				$a=$sth->fetchALL();	
				
?>
<!--顯示關鍵字週排行-->


<!--顯示關鍵字排行留言-->

<?php
if($NameId=="46251501064"){

if($id_click=='1')
{
$sql="select post_feed.PostMessage,post_feed.PostPN,post_feed.PostId from post_feed,key_post_feed where post_feed.PostPN='$EmotionValue' AND post_feed.number=key_post_feed.PostId AND key_post_feed.keyword='$wordid' limit 0,$total ";
}		
}
if($NameId=="232716627404"){

if($id_click=='1')
{
$sql="select chen_post.PostMessage,chen_post.PostPN,chen_post.PostId from chen_post,chen_keypost where chen_post.PostPN='$EmotionValue' AND chen_post.number=chen_keypost.PostId AND chen_keypost.keyword='$wordid' limit 0,$total ";
}		
}


				$sth=$db->prepare($sql);
				$sth->execute();
				$aa=$sth->fetchALL();
			
?>
<!--顯示關鍵字排行留言-->


		<table border='1' align="left" style="font-size:16pt">
		<th style="font-family:微軟正黑體;border:1px solid;">關鍵詞彙</th>
	<!--	<th style="font-family:微軟正黑體;border:1px solid;">詞彙id</th>  -->
		<th style="font-family:微軟正黑體;border:1px solid;">觀看文章留言</th>
		<?php foreach($a as $b){ ?>	
			
			<tr>
				<td class="AutoNewline" style="font-family:微軟正黑體;border:1px solid;">
				<?php echo $b['keyword']?>
				</td>
	<!--			<td style="font-family:微軟正黑體;border:1px solid;">   -->
				<?php /* echo $b['wordid'] */?>  
				</td>
				<td>
				<input type ="button" class="css_btn1" onclick="location.href='keyword.php?wordid=<?php echo $b['wordid']?>&id_click=<?php echo '1' ?>&<?php echo '&SelectWeek=';echo $SelectWeek?>&<?php echo '&SelectMonth=';echo $SelectMonth?>&<?php echo '&EmotionValue=';echo $EmotionValue?>'"  value="觀看文章留言" style="width:180px;height:40px;font-size:16pt"></input>
				</td>
			</tr>
		<?php }?>
		</table>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br>

<div>

	<?php if ($id_click=='1'){ ?>	
	
		<table width="100%" style="font-size:18pt;font-family:微軟正黑體;border:1px solid;margin-left:auto; margin-right:auto;" >
		<!--選擇留言筆數-->

			<tr style="margin-left:auto; margin-right:auto;">
				<td style="width:80px;font-family:微軟正黑體;border:1px solid">
				<select id="GetListValue" style="width:120px;font-size:18pt">
					<option value=50>50</option>
					<option value=100>100</option>
					<option value=200>200</option>
					<option value=500>500</option>
				</select>

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type ="button" class="css_btn1" onclick="GetValue()"  value="選擇筆數" style="width:120px;height:40px;font-size:18pt;"></input>
	
				</td>
			</tr>
		<!--選擇留言筆數-->

		<th style="font-family:微軟正黑體;border:1px solid;">詞彙出現留言</th>
		<th style="font-family:微軟正黑體;border:1px solid;">分析情緒</th>
		<th style="font-family:微軟正黑體;border:1px solid;">回饋機制</th>
		<?php foreach($aa as $c){ ?>	
			<tr style="font-family:微軟正黑體;border:1px solid;">
				<td class="AutoNewline" style="font-family:微軟正黑體;border:1px solid;">
				<br>
				<?php echo $c['PostMessage']?>
				<br>
				<br>
				</td>
			<td style="font-family:微軟正黑體;border:1px solid;font-size:24px">
				<script>
				if (<?php echo $c['PostPN'] ?>=="1")document.write("<font color='#228B22';font size='18pt'>正面</font>");
				if (<?php echo $c['PostPN'] ?>=="-1")document.write("<font color='#CC0000';font size='18pt'>負面</font>");
				if (<?php echo $c['PostPN'] ?>=="0")document.write("<font color='#FF8C00';font size='18pt'>中性</font>");
				</script>
			</td>
			
			<td style="font-family:微軟正黑體;border:1px solid;">
				<br>
				<br>
				<input type ="button" class="css_btn1" onclick="feedback(1,'<?php echo $c['PostId'] ?>');" value="正面" style="font-family:微軟正黑體;font-size:18pt"></input>
				<input type ="button" class="css_btn1" onclick="feedback(-1,'<?php echo $c['PostId'] ?>');" value="負面" style="font-family:微軟正黑體;font-size:18pt"></input>
				<input type ="button" class="css_btn1" onclick="feedback(0,'<?php echo $c['PostId'] ?>');" value="中性" style="font-family:微軟正黑體;font-size:18pt"></input>
				<br>
				<br>
			</td>
			</tr>
		<?php }?>
		</table>
	<?php } ?>	

<?php	} ?>

</div>
	
<!--頁面置頂-->
<a style="display:scroll;position:fixed;bottom:0px;right:10px;" href="#" title="" onFocus="if(this.blur)this.blur()">
<img alt='' border='0' onmouseover="this.src='頁面置頂箭頭.png'" src="頁面置頂箭頭.png" onmouseout="this.src='頁面置頂箭頭.png'" /></a>
<!--頁面置頂-->
</body>
</html>









<!--月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月月-->	
<?php  if( $SelectWeekMonth=='1'){ ?>

<!--顯示月的日期-->

<script>
				if (<?php echo $SelectMonth ?>=="1")document.write("<center><font color='red' size='26px'>1月</font>");
				if (<?php echo $SelectMonth ?>=="2")document.write("<center><font color='red' size='26px'>2月</font>");
				if (<?php echo $SelectMonth ?>=="3")document.write("<center><font color='red' size='26px'>3月</font>");
				if (<?php echo $SelectMonth ?>=="4")document.write("<center><font color='red' size='26px'>4月</font>");
				if (<?php echo $SelectMonth ?>=="5")document.write("<center><font color='red' size='26px'>5月</font>");
				if (<?php echo $SelectMonth ?>=="6")document.write("<center><font color='red' size='26px'>6月</font>");
				if (<?php echo $SelectMonth ?>=="7")document.write("<center><font color='red' size='26px'>7月</font>");

</script>
	<p></p>
<img src='wordcloud_rfidf_month/month<?php echo $SelectMonth ?>.png' width="800" height="800" align="middle "></p>


<!--顯示關鍵字月排行-->

<?php
if($SelectWeek==1)
$sql="select keyword.keyword,keyword.wordid,(date_idf.rfidf * date_idf.DF) from keyword,date_idf WHERE keyword.nametype='n' AND (date_idf.date between '2016-01-01' AND '2016-02-01') AND date_idf.id=keyword.wordid ORDER BY (date_idf.rfidf * date_idf.DF) DESC limit 0,10";

				$sth=$db->prepare($sql);
				$sth->execute();
				$a=$sth->fetchALL();	
				
?>
<!--顯示關鍵字月排行-->

<!--顯示關鍵字排行留言-->
<?php
if($id_click=='1')
{
$sql="select post.PostMessage from post,key_post where post.number=key_post.PostId AND key_post.keyword='$wordid' limit 0,$total ";

				$sth=$db->prepare($sql);
				$sth->execute();
				$aa=$sth->fetchALL();	
}				
?>
<!--顯示關鍵字排行留言-->


		<table border='1' style="font-size:18pt;">
		<th style="font-family:微軟正黑體;border:1px solid;">>詞彙</th>
		<th style="font-family:微軟正黑體;border:1px solid;">>詞彙id</th>
		<th style="font-family:微軟正黑體;border:1px solid;">>留言</th>
		<?php foreach($a as $b){ ?>	
			<tr>
				<td class="AutoNewline" style="font-family:微軟正黑體;border:1px solid;">
				<?php echo $b['keyword']?>
				</td>
				<td style="font-family:微軟正黑體;border:1px solid;">
				<?php echo $b['wordid']?>
				</td>
				<td style="font-family:微軟正黑體;border:1px solid;">
				<input type ="button" class="css_btn1" onclick="location.href='keyword.php?wordid=<?php echo $b['wordid']?>&id_click=<?php echo '1' ?>&<?php echo '&SelectWeek=';echo $SelectWeek?>&<?php echo '&SelectMonth=';echo $SelectMonth?>'"  value="留言" style="width:60px;height:30px;font-size:16px;"></input>
				</td>
			</tr>
		<?php }?>
		</table>



<!--選擇留言筆數-->

	<?php if ($id_click=='1'){ ?>
			

		<table width="100%" border="2">
        <tr>
            <td>
				<select id="GetListValue" style="width:120px;font-size:16pt">
					<option value=50>50</option>
					<option value=100>100</option>
					<option value=200>200</option>
					<option value=500>500</option>
				</select>

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type ="button" class="css_btn1" onclick="GetValue()"  value="選擇筆數" style="width:120px;height:30px;font-size:16px;"></input>
				
			
			</td>
			
		</tr>
    </table>
	
<!--選擇留言筆數-->

	<?php } ?>	
		
	<?php if ($id_click=='1'){ ?>	
		<table border='1' style="font-size:18pt">
		
		<th style="font-family:微軟正黑體;border:1px solid;">詞彙文章</th>
		<?php foreach($aa as $c){ ?>	
			<tr>
				<td class="AutoNewline" style="font-family:微軟正黑體;border:1px solid;">
				<br>
				<?php echo $c['PostMessage']?>
				<br>
				<br>
				</td>
			</tr>
		<?php }?>
		</table>
	<?php } ?>	

<?php } ?>


