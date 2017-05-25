<?php
		session_start();
		$conn= new PDO("mysql:localhost");
		$_SESSION["NameId"]=$_GET['NameId'];
		$NameId=$_SESSION["NameId"];
		
?>


<html>
<head>
  <title>情緒分析之臉書粉絲團</title>
  <link rel=stylesheet type="text/css" href="1_1.css">
  <link rel=stylesheet type="text/css" href="button.css">

	<script src='jquery-3.0.0.min.js'></script>
<script src="http://cdn.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
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
	/*	
	function load(){
					$.ajax({
					method:"post_feed",
					url:"test2.php",
					cache: false,
					success:function(r){
						create_chart(r);			
					}
				});
		}
	*/
	<!--回饋機制-->

				
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
			function load(s1,s2){
			
					$.get( 
								'http://localhost/data/interface//h_sql4.php',
									{date:s1,type:s2,name:<?php switch($NameId){
												case "46251501064":echo 1;break;
												case "232716627404":echo 2;break;	
									}				  		
									?>},
									
									function(res){				
										$('#container3').html(res);				
									}
							)
			}

		$(function () {
			
				test=function (mt,md){
							$.get( 
							<?php 
							if($NameId=="46251501064"){
							?>	
								'http://localhost/data/interface//h_sql.php',
							<?php } ?>
							
							<?php 
							if( $NameId=="232716627404"){
							?>
		
							'http://localhost/data/interface//chen_h_sql.php', 
							<?php } ?>
							
							
									{top:mt,down:md},
									function(res){
										$('#container').html(res);
										
									}
							)
				};	
				test($('#topdate').val(),$('#downdate').val());
				
				$('#topdate').change(function(){
					
					test($('#topdate').val(),$('#downdate').val());
				});
				$('#downdate').change(function(){
					test($('#topdate').val(),$('#downdate').val());
				});
				
				
				
				test1=function (mt,md){
							$.get( 
							
							<?php 
							if($NameId=="46251501064"){
							?>	
								'http://localhost/data/interface//h_sql2.php',
							<?php } ?>
							
							<?php 
							if( $NameId=="232716627404"){
							?>
		
							'http://localhost/data/interface//chen_h_sql2.php', 
							<?php } ?>
							
									{top:mt,down:md},
									function(res){
										$('#container1').html(res);
										
									}
							)
				};	
				test1($('#topdate').val(),$('#downdate').val());
				
				$('#topdate').change(function(){
					
					test1($('#topdate').val(),$('#downdate').val());
				});
				$('#downdate').change(function(){
					test1($('#topdate').val(),$('#downdate').val());
				});
				

				test2=function (mt,md){
							$.get( 
							
							<?php 
							if($NameId=="46251501064"){
							?>	
								'http://localhost/data/interface//h_sql3.php',
							<?php } ?>
							
							<?php 
							if( $NameId=="232716627404"){
							?>
		
							'http://localhost/data/interface//chen_h_sql3.php', 
							<?php } ?>
							
									{top:mt,down:md},
									function(res){
										$('#container2').html(res);
										
									}
							)
				};	
				test2($('#topdate').val(),$('#downdate').val());
				
				$('#topdate').change(function(){
					
					test2($('#topdate').val(),$('#downdate').val());
				});
				$('#downdate').change(function(){
					test2($('#topdate').val(),$('#downdate').val());
				});
			
			});
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
              <div style="width:350px;padding-left:8px;padding-right:8px ;font-size: auto">蔡英文 Tsai Ing-wen </div>
              <hr style='border-right:2px solid #A9A9A9'>
			  <div style="padding-top:10px;text-align:left ;font-size: auto">「台灣的好，不應該輕易被擊倒。當新時代已經敲門，我們必須把門打開，讓世界看見台灣的好。」</div>
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
              <div style="width:350px;padding-left:8px;padding-right:8px ;font-size: auto">陳菊(花媽)市長 </div>
              <div style="padding-top:10px;text-align:left ;font-size: auto">㊣㊣㊣ 陳菊 ● 花媽粉絲團 ㊣㊣㊣ since 2010.01.06. 高雄市政府市民熱線：1999 里民防災卡資訊↓ http://cabu.kcg.gov.tw/precaution/main/index.aspx</div>
			</td>
			
			<td>
				<img src="kikuChen_background.jpg" style=" background-repeat:no-repeat;height:300px">
            </td>
			
		</tr>
    </table>
	<?php } ?>
<!--背景-->
<!--時間軸-->
<br>
<hr>
<br>
<font size='5' color="red" face="微軟正黑體">選擇時間</font>
<input id="downdate" type='date' value='2016-02-05' style="font-size:18px" />
<input id="topdate" type='date' value='2016-05-05' style="font-size:18px"'/>

<!--
				<div id="container" style='min-width:400px;height:400px;'></div>
				<select id='down_cho'>
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5</option>
						<option value='6'>6</option>
						<option value='7'>7</option>
						<option value='8'>8</option>
						<option value='9'>9</option>
						<option value='10'>10</option>
						<option value='11'>11</option>
						<option value='12'>12</option>
				</select>
				<select id='top_cho'>
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5</option>
						<option value='6'>6</option>
						<option value='7'>7</option>
						<option value='8'>8</option>
						<option value='9'>9</option>
						<option value='10'>10</option>
						<option value='11'>11</option>
						<option value='12'>12</option>
				</select>
-->
				

<!--時間軸-->
<br>
<br>
<br>

<center><font size='26' color="red" face="微軟正黑體">正/負/無/留言情緒折線圖</font></center>
		<div id='container'  align="center" ></div>
<br><hr><br>
<center><font size='26' color="red" face="微軟正黑體">正/負/無/留言數量長條圖</font></center>
		<div id='container1' align="center"></div>
<br><hr><br>
<center><font size='26' color="red" face="微軟正黑體">正/負/無/留言圓餅圖</font></center>
		<div id='container2' align="center"></div>
		
	<div id='container3' align="center"></div>
	<p></p>
	
<!--頁面置頂-->
<a style="display:scroll;position:fixed;bottom:0px;right:10px;" href="#" title="" onFocus="if(this.blur)this.blur()">
<img alt='' border='0' onmouseover="this.src='頁面置頂箭頭.png'" src="頁面置頂箭頭.png" onmouseout="this.src='頁面置頂箭頭.png'" /></a>
<!--頁面置頂-->
</body>
</html>