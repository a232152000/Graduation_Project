<?php
	session_start();
	$NameId=$_SESSION["NameId"];
	header("Content-type:text/html;charset=utf8");
	
	$_SESSION["PageId"]=$_GET['PageId'];	
	$PageId=$_SESSION["PageId"];
	
	@$_SESSION["count"]=$_GET['count'];	
	$count=$_SESSION['count'];
	
	@$_SESSION["count2"]=$_GET['count2'];	
	$count2=$_SESSION['count2'];
	
	@$_SESSION["TF"]=$_GET['TF'];	
	$TF=$_SESSION['TF'];
	
	@$_SESSION["EmotionValue"]=$_GET['EmotionValue'];
	$EmotionValue=$_SESSION["EmotionValue"];
		
		$PostName=@$_POST['PostName'];
		$PostMessage=@$_POST['PostMessage'];
		$PostPN=@$_POST['PostPN'];
		$PostId=@$_POST['PostId'];

		
		$servername="127.0.0.1";
		$userid="root";
		$password="";
		$db=new PDO("mysql:host=".$servername.";dbname=main",$userid,$password);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$setnames=$db->prepare("SET NAMES UTF8");
		$setnames->execute();
		
/*計算留言數量*/		
	if($EmotionValue==NULL)
	{
		$EmotionValue=-1;
	}
	if($count==NULL && $count2==NULL)
		{
			$count=0;
			$count2=25;
		}
	
	
		if($TF==1)
		{
			$count=$count-$count2;
		}
		else if($TF==2)
		{
			$count=$count+$count2;
		}
		
		
		if($count<=0)
		{
			$count=0;
		}
		
/*計算留言數量*/		
		
		
		
		//select
		if( $NameId=="46251501064")
		{
				$sql="SELECT * FROM post_feed WHERE (PageId='$PageId' AND PostPN='$EmotionValue') LIMIT $count,$count2";
//echo $sql;
				//$sql="SELECT * FROM post LIMIT $count,$count2";
				$sth=$db->prepare($sql);
				$sth->execute();
				$e=$sth->fetchALL();	
		}		
		
		if( $NameId=="232716627404")
	{
				$sql="SELECT * FROM chen_post WHERE (PageId='$PageId' AND PostPN=$EmotionValue) LIMIT $count,$count2";

				//$sql="SELECT * FROM post LIMIT $count,$count2";
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
<!--情緒按鈕-->

<script>
	
function GetTEmotion()
{
	//alert("Connect");
	TakeValue=$("#GetTEmotionValue").val();
	//alert(TakeValue);
	
	window.location.href="4.php?EmotionValue="+TakeValue+"<?php echo '&count='; echo $count ;echo '&TF=';echo $TF?>"+"<?php echo "&PageId=";echo $PageId ?>"+"<?php echo "&count2=";echo $count2 ?>";
	
}

	</script>
	
<!--回饋機制-->
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


function GetValue1()
{
	//alert("Connect");
	TakeValue=$("#GetListValue").val();
	//alert(TakeValue);

	window.location.href="4.php?count2="+TakeValue+"<?php echo '&count='; echo $count;echo '&TF=1' ?>"+"<?php echo "&PageId=";echo $PageId ?>"+"<?php echo "&EmotionValue=";echo $EmotionValue ?>";
}

function GetValue2()
{
	//alert("Connect");
	TakeValue=$("#GetListValue").val();
	//alert(TakeValue);

	window.location.href="4.php?count2="+TakeValue+"<?php echo '&count='; echo $count;echo '&TF=2' ?>"+"<?php echo "&PageId=";echo $PageId ?>"+"<?php echo "&EmotionValue=";echo $EmotionValue ?>";
}

</script>


<!--回饋機制-->

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
	
	<table width="100%"style="font-family:微軟正黑體;border:1px solid;">
        <tr>
            <td>
			  <div><img src="tsaiingwen.jpg" style="width:200px"></div>
              <div style="width:350px;padding-left:8px;padding-right:8px ;font-size: auto ;font-family:微軟正黑體">蔡英文 Tsai Ing-wen </div>
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
<p></p>

				<select id="GetListValue" style="width:120px;font-size:16pt">
					<option value=25>25</option>
					<option value=50>50</option>
					<option value=100>100</option>
					<option value=200>200</option>
				</select>

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type ="button" class="css_btn1" onclick="GetValue1()"  value="上一頁" style="font-family:微軟正黑體"></input>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type ="button" class="css_btn1" onclick="GetValue2()"  value="下一頁" style="font-family:微軟正黑體"></input>
				
				<!--選擇正負無-->
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<select id="GetTEmotionValue" style="width:120px;font-size:16pt;font-family:微軟正黑體">
					<option selected value='-1'>負面情緒</option>
					<option value='1'>正面情緒</option>
					<option value='0'>無情緒</option>
				</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type ="button" class="css_btn1" onclick="GetTEmotion()"  value="選擇情緒" style="width:100px;height:40px;font-size:18px;"></input>
<!--選擇正負無-->	
			
<p></p>


		<table width="100%" style="font-size:18pt;font-family:微軟正黑體;border:1px solid;">
		
		<th style="font-family:微軟正黑體;border:1px solid;">留言姓名</th>
		<th style="font-family:微軟正黑體;border:1px solid;">留言內容</th>
		<th style="font-family:微軟正黑體;border:1px solid;">留言時間</th>
		<th style="font-family:微軟正黑體;border:1px solid;">分析情緒</th>
		<th style="font-family:微軟正黑體;border:1px solid;">回饋機制</th>
		
		<?php foreach($e as $b){ ?>	
			<tr>
			<td style="width:80px;font-family:微軟正黑體;border:1px solid;">
				<?php echo $b['PostName']?>
			</td>
				
			<td class="AutoNewline" style="font-family:微軟正黑體;border:1px solid;">
				<br>
				<?php echo $b['PostMessage']?>
				<br>
				<br>
			</td>
			
			<td style="font-family:微軟正黑體;border:1px solid;">
				<br>
				<?php echo $b['PostTime']?>
				<br>
				<br>
			</td>
				
			<td style="font-family:微軟正黑體;border:1px solid;font-size:24px">
				<script>
				if (<?php echo $b['PostPN'] ?>=="1")document.write("<font color='#228B22';font size='18pt'>正面</font>");
				if (<?php echo $b['PostPN'] ?>=="-1")document.write("<font color='#CC0000';font size='18pt'>負面</font>");
				if (<?php echo $b['PostPN'] ?>=="0")document.write("<font color='#FF8C00'>;font size='18pt'中性</font>");
				</script>
			</td>
			
			<td  style="font-family:微軟正黑體;border:1px solid;">
				<br>
				<br>
				<input type ="button" class="css_btn1" onclick="feedback(1,'<?php echo $b['PostId'] ?>');" value="正面" style="font-size:18pt;font-family:微軟正黑體"></input>
				<br>
				<input type ="button" class="css_btn1" onclick="feedback(-1,'<?php echo $b['PostId'] ?>');" value="負面" style="font-size:18pt;font-family:微軟正黑體"></input>
				<br>
				<input type ="button" class="css_btn1" onclick="feedback(0,'<?php echo $b['PostId'] ?>');" value="中性" style="font-size:18pt;font-family:微軟正黑體"></input>
				<br>
				<br>
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
