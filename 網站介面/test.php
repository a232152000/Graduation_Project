<?php
		$conn= new PDO("mysql:localhost")
?>
<html>
<head>
  <title>情緒分析之臉書粉絲團</title>

	<script src='jquery-3.0.0.min.js'></script>
	
<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
<script src="http://cdn.hcharts.cn/highstock/highstock.js"></script>
<script src="http://cdn.hcharts.cn/highmaps/highmaps.js"></script>
	<script>
		function load(){
					$.ajax({
					method:"POST",
					url:"test2.php",
					cache: false,
					success:function(r){
						create_chart(r);			
					}
				});
		}
		function create_chart(r){
			var chart1=$("#container").highcharts({
				   chart: {
						type: 'bar',
						width: 700
					},
					title: {
						text: '陳菊'
					},
					subtitle: {
						text: 'fb_id:232716627404'
					},
					xAxis: {
						categories: [
							'陳菊'
						]
					},
					yAxis: {
						min: 0,
						title: {
							text: '正負數量'
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
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
						data: [parseInt(r.p_count)]

					}, 
					{
						name: '負',
						data: [parseInt(r.n_count)]

					}]
					
				
			});
			var chart2=$("#container1").highcharts({
				   chart: {
					   width: 700
					},
					title: {
						text: '陳菊'
					},
					subtitle: {
						text: 'fb_id:232716627404'
					},
					xAxis: {
						categories: [
							'正', '負'
						]
					},
					yAxis: {
						min: 0,
						title: {
							text: '正負數量'
						}
					},
					tooltip: {
						valueDecimals: 1,
						valueSuffix: '%',
						shared: true,
						useHTML: true
						
					},
					plotOptions: {
						column: {
							pointPadding: 0.5,
							borderWidth: 0
						}
					},
					series: [{
						data: [
							['正',parseFloat(r.p_per)*100],
							['負',parseFloat(r.n_per)*100]
						],
						type: 'pie',
					}]
			});
						
    $('#container2').highcharts({
        title: {
            text: 'Monthly Average Temperature',
            x: -20 //center
        },
        subtitle: {
            text: 'Source: WorldClimate.com',
            x: -20
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Temperature (°C)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '°C'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '正',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
        }, {
            name: '負',
            data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
        }]
    });
				
		
		}
		
		
		
		load();
	</script>
</head>
<body>
	<ul class="drop-down-menu">
        <li><a href="1.php">首頁</a></li>
        <li><a href="2.php">圖表</a></li>
        <li><a href="3.php">文章列表</a></li>
        <li><a href="4.php">留言列表/回饋機制</a></li>
    </ul>

	<p></p>
		<div id='container'></div>
		<span id='container1'></span>
		<div id='container2'></div>
</body>
</html>