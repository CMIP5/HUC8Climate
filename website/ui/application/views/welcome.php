<?php
HTML_Render_Head($js_vars,getTxt('Home'));
echo $CSS_Main;
echo $JS_JQuery;
echo $JS_Forms;
HTML_Render_Body_Start();
?>
<br />
<div class="col-md-6">
	<?php showMsgs();?>
	<?php if ($welcome) {?>
	<h1><?php echo $welcome[0];?></h1>
	<h4><?php echo $welcome[1];?></h4>
	<p><?php echo $welcome[2];?></p>
	<p><?php echo $welcome[3];?></p>
	<?php }else{?>
	<h1><?php echo getTxt('Welcome'); ?></h1>
	<p>The climate forecast models for USGS HUC8 Watersheds provide monthly temperature and precipitation data scaled to the spatial resolution of each USGS Hydrologic Unit Code (HUC8) watershed in the contiguous U.S. The historical data ranges from 1950 to 2006. The future predictions cover the time period 2006 - 2100 according to different global climate models and future climate scenarios.</p>
    <p><a href="index.php/default/sites/map">Go to the map</a> to select your watershed and download data.</p>
	
	<?php }?>
    <?php if($multi){?>
    <p><?php echo getTxt('congratsMultiple')."<a href='".base_url('index.php/default/home/installation')."'>Click Here</a>."; ?></p>
    <?php }?>
</div>
<div class="col-md-3"><img src="<?php echo getImg('homepage_shot.jpg');?>" class="img-responsive" alt="site picture"/></div>
<?php HTML_Render_Body_End(); ?>
<script type="text/javascript">

//Validate username and password
$("form").submit(function(){
	if(($("#username").val())==""){
	alert("Please enter a username!");
	return false;
	}

	if(($("#password").val())==""){
	alert("Please enter a password!");
	return false;
	}

//Now that all validation checks are completed, allow the data to query database

	return true;
});
</script>
