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
			$temp=array(0,0,0);
			
			for($i=0;$i<=$t;$i++){
				 $temp[0]=$temp[0]+$result[$i]['P'];
				 $temp[1]=$temp[1]+$result[$i]['M'];
				 $temp[2]=$temp[2]+$result[$i]['N'];
			}
			
			
			return $temp;
			}
		function Prin($d){

			echo "<script>$('#container1').highcharts({
				   chart: {
						type: 'bar',
						width:'1100',
						x: -20 //center
					},
					title: {
						text: '留言正負無數量'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories: [
							'留言正負無數量'
						]
					},
					yAxis: {
						min: 0,
						title: {
							text: '正負無數量'
						}
					},
					tooltip: {
						headerFormat: '<span style=font-size:10px>{point.key}</span><table>',
						pointFormat: '<tr><td style=color:{series.color};padding:0>{series.name}: </td>' +
							'<td style=padding:0><b>{point.y:.1f} </b></td></tr>',
						footerFormat: '</table>',
						shared: true,
						useHTML: true,
					},
					plotOptions: {
						
						column: {
							pointPadding: 0.5,
							borderWidth: 0
						}
					},
			
					series: [{
						name: '正',
						data: [parseInt($d[0])]

					}, 
					{
						name: '無',
						data: [parseInt($d[1])]

					},
					{
						name: '負',
						data: [parseInt($d[2])]

					}
					
					]
					
				
			});
				</script>";
			
		}
		prin(getdata($month_top,$month_down,$conn));
?>