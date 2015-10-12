<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<style>
		body { margin: 40px; }
		#ajax_loader{
			display:none;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<h1><?php echo $title; ?></h1>
			<hr>
<?php if (Session::get_flash('success')): ?>
			<div class="alert alert-success">
				<strong>Success</strong>
				<p>
				<?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
				</p>
			</div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
			<div class="alert alert-danger">
				<strong>Error</strong>
				<p>
				<?php echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
				</p>
			</div>
<?php endif; ?>
		</div>
		<div class="col-md-12">
<?php echo $content; ?>
		</div>
		<footer>
			<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			<p>
				<a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
				<small>Version: <?php echo e(Fuel::VERSION); ?></small>
			</p>
		</footer>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<?php echo Asset::js('bootstrap.js'); ?>
	<?php echo Asset::js('bootstrap-select.js'); ?>
	<script>
		$(function(){
			$('#search_weather').on('click', function(){
				//showing and hiding elements
				$('#ajax_loader').show();
				$('#result').hide();
				setTimeout(function(){
					//data to be requested
					var data = $('#cities option:selected').val().split('-');
					data[0] = data[0].replace(' ', '_');
					var url ='/weather/public/weather/get_weather.json?city='+data[0]+'&state='+data[1];

					//request data
					$.ajax({
						async:false,
						type:'GET',
						contentType: 'text/xml',
						dataType: "json",
						url: url, 
					success: function(result){

						//Weather block intructions************************************
					      var resHtml = '';
					      result.result.weather.forEach(function(data){
											resHtml += '<tr>'+
											'<td>'+data.main+'</td>'+
											'<td>'+data.description+'<img src="http://openweathermap.org/img/w/'+data.icon+'.png"" alt=""></td>'+
											'</tr>';		
										});

					      var newHtml = '<div>'+
											'<h1>'+result.result.name+'</h1>'+
											'<h2>weather</h2>'+
											'<table class="table">'+
												'<thead>'+
													'<tr>'+
														'<td>Main</td>'+
														'<td>Description</td>'+
													'</tr>'+
												'</thead>'+
												'<tbody>'+
													resHtml+
												'</tbody>'+
											'</table>'+
										'</div>';

										 $('#result').show();
										 $('#result').html(newHtml);

					//Last 5 search block instructions***********************
									var liSearch = '';
							      result.search.forEach(function(data){
													liSearch += '<li>'+data+'</li>'	
												});
								$('#search').html(liSearch);			
					},
					error: function(error){
						console.log(error);
					}, 
					complete: function(){
						$('#ajax_loader').hide();
					}});
				}, 1000);
				
			})
		});
	</script>
</body>
</html>

