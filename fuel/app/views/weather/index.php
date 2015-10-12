<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('weather/index','Index');?></li>
</ul>
<p>Index </p>

<div class="row">
	<div class="col-md-3">
		<select id="cities"  class="formcontrol">
		<?php if (count($cities) >= 1): ?>
			<?php foreach ($cities as $city): ?>
				<option value="<?php echo $city['city'].'-'.$city['state_code'] ?>"><?php echo $city['city'].' - '.$city['state_code'] ?></option>
			<?php endforeach ?>
		<?php endif ?>	
		</select>
	</div>
	<div class="col-md-9">
		<button id="search_weather" class="btn btn-success">Search</button>
	</div>
</div>

<h2>Last searchs</h2>
<ul id="search">
<?php if (count($search) >= 1): ?>
	<?php foreach ($search as $key): ?>
		<li><?php echo $key ?></li>
	<?php endforeach ?>
<?php endif ?>
	
</ul>

<div>
	<?php echo Asset::img('ajax-loader.gif', array('id' => 'ajax_loader')); ?>
	<p id="result"></p>
</div>

