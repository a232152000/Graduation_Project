<?php
		header("Content-type:text/html;charset=utf8");
		
		
		
		
		
		$month_top=isset($_GET['top'])?$_GET['top']:'2016-01-01';
		$month_down=isset($_GET['down'])?$_GET['down']:'2016-01-01';
		
		$conn =new PDO("mysql:host=localhost;dbname=main",'root','');
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$smt=$conn->prepare("set names UTF8");
		$smt->execute();
		function getdata($t,$d,$c){
			$smt=$c->prepare("SELECT P,M,N,date_feed FROM date_feed WHERE date_feed BETWEEN :d and :t");
			$tt=$t;
			$dd=$d;
			$smt->bindParam(":t",$tt);
			$smt->bindParam(":d",$dd);
			$smt->execute();
			$result=$smt->fetchALL();

			$t=round((strtotime($t)-strtotime($d))/(60*60*24));
			$temp=array('','','','');
			
			for($i=0;$i<=$t;$i++){
				 $temp[0].=$result[$i]['P'];
				 $temp[1].=$result[$i]['M'];
				 $temp[2].=$result[$i]['N'];
				 $temp[3]= $temp[3]."'".$result[$i]['date_feed']."'";
				 if($i!=$t){
					 $temp[0].=',';
					 $temp[1].=',';
					 $temp[2].=',';
					 $temp[3].=',';
				 }			 
			}
			return $temp;
			
		}
		function Prin($d){
			
			
			
			
			echo "<script>		
			
			
					

			
			$('#container').highcharts({
					chart: {
						
						width:'1100',
						x: -20 //center
					},
					title: {
						text: '留言正負無折線圖',
						
						x: -20 //center
					},
					subtitle: {
						text: '月 ',
						x: -20
					},
					
					
					xAxis: {
						categories: [".$d[3]."]
					},
					yAxis: {
						title: {
							text: '留言數量'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#666666'
						}]
					},
					tooltip: {
						valueSuffix: '筆'
					},
					legend: {
						layout: 'vetical',
						align: 'left',
						verticalAlign: 'middle',
						borderWidth: 0
					}
					,
					plotOptions: {
						series: {
							cursor: 'pointer',
							point: {
							events: {
								click: function () {
									
								load(this.category,this.series.name);
								}
							}
							},
							marker: {
							lineWidth: 1
							}
						}
					},
					series: [
					
					

					{
						name: '正',
						data: [".$d[0]."]
					},{
						name: '無',
						data: [".$d[1]."]
					},{
						name: '負',
						data: [".$d[2]."]
					}
					]
					
				});
				</script>";
			
		}
		prin(getdata($month_top,$month_down,$conn));
		
?>