<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/styles.css">
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <title>SightMap® API</title>
</head>
<body>
	<main>
	    <nav>
			<div>
				<form method="get" action="<?=APP_URL;?>">
					<?php if(isset($_GET['page']) && is_numeric($_GET['page'])):?>
					<input type="hidden" name="page" value="<?=$_GET['page'];?>"/>
					<?php endif;?>
				    <select id="per-page" name="per-page">
					    <option <?php if( isset($_GET['per-page']) && !in_array($_GET['per-page'], VALID_PER_PAGE) ):?> selected<?php endif;?>></option>
					    <option value="25"<?php if(isset($_GET['per-page']) && $_GET['per-page']==25):?> selected<?php endif;?>>25</option>
					    <option value="50"<?php if(isset($_GET['per-page']) && $_GET['per-page']==50):?> selected<?php endif;?>>50</option>
					    <option value="100" <?php if((isset($_GET['per-page']) && $_GET['per-page']==100) || !isset($_GET['per-page'])):?> selected<?php endif;?>>100</option>
					    <option value="250" <?php if(isset($_GET['per-page']) && $_GET['per-page']==250):?> selected<?php endif;?>>250</option>
					    <option value="500" <?php if(isset($_GET['per-page']) && $_GET['per-page']==500):?> selected<?php endif;?>>500</option>
				    </select>
				    <label for="per-page">Per Page</label>
				    <input type="submit" id="submit-button" value="Request" />
				</form>
			</div>
	    </nav>
		<div class="content-container">
		    <section id="area-1">
			    <header><span><?=$units['count']['area_1'];?></span> Units with an Area of 1 ft<sup>2</sup></header>
				<ul>
					<?php foreach($units['area_1'] as $unit):?>
					<li>
						<strong>Unit <?=$unit['unit_number'];?></strong> (<?=$unit['area'];?> ft<sup>2</sup>)
						<small>Last updated on <?=$unit['formatted_update_time'];?></small>
					</li>
					<?php endforeach;?>
				</ul>
		    </section>
		    <section id="area-gt-1">
			    <header><span><?=$units['count']['area_gt_1'];?></span> Units with an Area > 1 ft<sup>2</sup></header>
				<ul>
					<?php foreach($units['area_gt_1'] as $unit):?>
					<li>
						<strong>Unit <?=$unit['unit_number'];?></strong> (<?=$unit['area'];?> ft<sup>2</sup>)
						<small>Last updated on <?=$unit['formatted_update_time'];?></small>
					</li>
					<?php endforeach;?>
				</ul>
		    </section>
		    <div id="loading"><span>LOADING</span></div>
		</div><!--content-container-->
		<nav>
			<a href="<?=APP_URL;?>?per-page=<?=$per_page;?>&page=1" id="restart" <?php if (isset($_GET['page']) && $_GET['page']!=1):?>style="display:inline-block;"<?php endif;?>><</a>
			<a href="<?=APP_URL;?>?per-page=<?=$per_page;?>&page=<?=$previous_page;?>" id="previous" <?php if ($previous_page):?>style="display:inline-block;"<?php endif;?>>&#8592; Page <span><?=$previous_page;?></span></a>
			<span id="current-page">Page <?=$paging['current_page'];?></span>
			<?php if ($next_page):?>
			<a href="<?=APP_URL;?>?per-page=<?=$per_page;?>&page=<?=$next_page;?>" id="next">Page <span><?=$next_page;?></span> &#8594;</a>
			<?php endif;?>
		</nav>
	</main>
	<script type="text/javascript">
		<?php if( isset($_GET['per-page']) && in_array($_GET['per-page'], VALID_PER_PAGE) ):?>
		var per_page = <?=$_GET['per-page'];?>;
		<?php else: ?>
		var per_page = 100;
		<?php endif;?>
		<?php if(isset($_GET['page']) && is_numeric($_GET['page'])):?>
		var current_page = <?=$_GET['page'];?>;
		<?php else: ?>
		var current_page = 1;
		<?php endif;?>
	</script>
    <script type="text/javascript" src="js/app.js"></script>
</body>
</html>
