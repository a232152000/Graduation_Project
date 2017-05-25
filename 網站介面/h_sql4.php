<?php
		header("Content-type:text/html;charset=utf8");
		
		
		
		
		
		$date=$_GET['date'];
		$type=$_GET['type'];
		$name=$_GET['name'];
		$tablename="";
		$real_type="";
		switch($name){
			case 1:$tablename="post_feed";break;
			case 2:$tablename="chen_post";break;
		}
		switch($type){
			case "正":$real_type="1";break;
			case "負":$real_type="-1";break;
			case "無":$real_type="0";break;
		}
		
		$conn =new PDO("mysql:host=localhost;dbname=main",'root','');
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$smt=$conn->prepare("set names UTF8");
		$smt->execute();
		function getdata($t,$d,$c,$tb){
			
	
		
			$smt=$c->prepare("SELECT PostName,PostMessage,PostTime,PostPN,PostId FROM ".$tb." WHERE date(PostTime)=:t AND PostPN=:d");

		
		
			$tt=$t;
			$dd=$d;
			$smt->bindParam(":t",$tt);
			$smt->bindParam(":d",$dd);
			$smt->execute();
			$result=$smt->fetchALL();
			
			return $result;
			}
		function Prin($d,$name){
				echo '<table width="100%" style="font-size:18pt;font-family:微軟正黑體;border:1px solid;">
					<th style="font-family:微軟正黑體;border:1px solid;">留言姓名</th>
					<th style="font-family:微軟正黑體;border:1px solid;">留言內容</th>
					<th style="font-family:微軟正黑體;border:1px solid;">留言時間</th>
					<th style="font-family:微軟正黑體;border:1px solid;">分析情緒</th>
					<th style="font-family:微軟正黑體;border:1px solid;">回饋機制</th>';
				foreach($d as $b){ 
				$text="";

				switch($b['PostPN'])
				{
					case 1:$text='<font color="#228B22";font size="18pt">正面</font>';break;
					case -1:$text='<font color="#CC0000;";font size="18pt">負面</font>';break;
					case 0:$text='<font color="#FF8C00";font size="18pt">中性</font>';break;
					
				}

	
		
				echo '
				<tr>
				<td style="width:80px;font-family:微軟正黑體;border:1px solid;">
						'.$b['PostName'].'
				</td>
					
				<td class="AutoNewline" style="font-family:微軟正黑體;border:1px solid;">
					<br>
						'.$b['PostMessage'].'
					<br>
					<br>
				</td>
				
				<td style="font-family:微軟正黑體;border:1px solid;">
					<br>
						'.$b['PostTime'].'
					<br>
					<br>
				</td>
				<td style="font-family:微軟正黑體;border:1px solid;font-size:24px">
					<br>
						'.$text.'
					
					<br>
					<br>
				</td>
				
				
				
				<td  style="font-family:微軟正黑體;border:1px solid;">
				<br>
				<br>
				<input type ="button" class="css_btn1" onclick="feedback(1, \''.$b['PostId'] .'\');" value="正面" style=";font-size:18pt;font-family:微軟正黑體"></input>
				<br>
				<input type ="button" class="css_btn1" onclick="feedback(-1,\''.$b['PostId']. '\');" value="負面" style="font-size:18pt;font-family:微軟正黑體"></input>
				<br>
				<input type ="button" class="css_btn1" onclick="feedback(0,\''.$b['PostId'] .'\');" value="中性" style="font-size:18pt;font-family:微軟正黑體"></input>
				<br>
				<br>
			</td>
				</tr>';
				}
				echo "</table>";
		}
		prin(getdata($date,$real_type,$conn,$tablename),$name);
?>