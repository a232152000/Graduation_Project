
<!DOCTYPE html>
<html>
		<head>
			<script src="http://cdn.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
			<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
		<script>
		$(function () {
				test=function (mt,md){
							$.get( 'http://localhost/data/interface//h_sql.php',
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
				
				
				
			});
		</script>
		</head>
		<body>
				<input id="downdate" type='date' value='2016-02-05'/>
				<input id="topdate" type='date' value='2016-05-05'/>

				
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
				<hr/>
				<br/>
				
		</body>
</html>