			</div>
				<div class="col-lg-4">
<div class="widget">
	<div>
		<form class="input-group" action="<?php echo $url.'search'; ?>" method="POST">
			<input class="form-control input-small" type="text" placeholder="<?php echo $lang['search']; ?>" name="q">
			<b class="input-group-btn">
				<button name="blog_search" class="btn btn-default btn-small"><?php echo $lang['go']; ?></button>
			</b>
		</form>
	</div>
</div>

<div class="widget">
	<div>
		<a href="<?php echo $url.'rss'; ?>" class="btn btn-default btn-small"><?php echo $lang['subscribe_rss']; ?></a>
		<a href="<?php echo $url.'subscribe'; ?>" class="btn btn-default btn-small"><?php echo $lang['subscribe_email']; ?></a>
	</div>
</div>

<div class="widget">
	<h3><?php echo $lang['most_commented_posts']; ?></h3>
	<div>
		<ul class="menu">
			<?php
			$sql = mysql_query("SELECT * FROM blogger_posts ORDER BY comments DESC LIMIT 5");
			if(mysql_num_rows($sql)>0) {
				while($row = mysql_fetch_array($sql)) {
					echo '<li>
						<h5><a href="'.$url.'post/'.make_post_link($row[id]).'-'.$row[id].'">'.$row[title].'</a></h5>
						<div class="muted">'.format_time($web[date_f],$row[time]).'</div>
					</li>';
				}
			} else {
				echo $lang['no_posts'];
			}
			?>
		</ul>
	</div>
</div>

<div class="widget">
	<h3><?php echo $lang['categories']; ?></h3>
	<div>
		<ul class="menu">
			<?php
			$sql = mysql_query("SELECT * FROM blogger_categories ORDER BY id");
			if(mysql_num_rows($sql)>0) {
				while($row = mysql_fetch_array($sql)) {
					echo '<li>
						<i class="fa fa-angle-right"></i>
						<a href="'.$web[url].'category/'.make_category_link($row[id]).'-'.$row[id].'">'.$row[value].'</a>
					</li>';
				}
			} else {
				echo '<li>'.$lang[no_categories].'</li>';
			}
			?>
			</ul>
	</div>
</div>

<?php
	if($web['ad_place2']) {
	?>
	<div class="widget">
		<h3><?php echo $lang['ads']; ?></h3>
		<div>
			<?php echo $web['ad_place2']; ?>
		</div>
	</div>
	<?php
	}
?>

<div class="widget">
	<h3><?php echo $lang['tags']; ?></h3>
	<div>
		<div class="tags">
			<?php
			$sql = mysql_query("SELECT * FROM blogger_popular_tags ORDER BY used DESC LIMIT 30");
			if(mysql_num_rows($sql)>0) {
				while($row = mysql_fetch_array($sql)) {
					echo '<a href="'.$url.'tag/'.$row[tag].'" style="margin:2px;">'.$row[tag].'</a>';
				}
			} else {
				echo $lang['no_tags'];
			}
			?>
		</div>
	</div>
</div>

<div class="widget">
	<h3><?php echo $lang['archives']; ?></h3>
	<div>
		<ul class="menu">
			<?php
			$sql = mysql_query("SELECT * FROM blogger_archives ORDER BY id");
			if(mysql_num_rows($sql)>0) {
				while($row = mysql_fetch_array($sql)) {
					echo '<li>
				<i class="fa fa-angle-right"></i>
				<a href="'.$url.'archive/'.$row[month].'-'.$row[year].'">'.decode_month($row[month]).' '.$row[year].'</a>
			</li>';
				}
			} else {
				echo $lang['no_archives'];
			}
			?>
		</ul>
	</div>
</div>

			</div>
			</div>
		</section>
	</div><!--END: .content-wrapper-->


	<hr class="section-seperator" />

	<section class="section">
		<div class="container">

			<div class="footer-wrapper">
				Copyright &copy; by <a href="https://yoursite.com" target="_blank"><b>Your Site</b></a>
			</div>
		</div>
	</section>
</footer>
</body>
</html>
