<?php
ob_start();
session_start(); 
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM blogger_settings ORDER BY id DESC LIMIT 1"));
include("../lang/language.php");
include("../inc/functions.php");
$type = protect($_GET['type']);
$url = $web['url'];

if($type == "home") {
	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 15;
	$startpoint = ($page * $limit) - $limit;
	$sql = mysql_query("SELECT * FROM blogger_posts ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
	if(mysql_num_rows($sql)>0) {
		while($row = mysql_fetch_array($sql)) {
		$cat = mysql_fetch_array(mysql_query("SELECT * FROM blogger_categories WHERE id='$row[category]'"));
		?>
		<article class="post">
			<div class="post-head">
				<h2 class="post-title">
					<a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>"><?php echo $row['title']; ?></a>
				</h2>
				<p class="post-meta muted">
					<span><i class="fa fa-calendar"></i><?php echo format_time($web['date_f'],$row['time']); ?></span>
					<span><i class="fa fa-user"></i><?php echo idinfo($row['author'],"name"); ?></span>
					<span><i class="fa fa-folder"></i><a href="<?php echo $url.'category/'.make_category_link($cat[id]).'-'.$cat[id]; ?>"><?php echo $cat['value']; ?></a></span>
					<span><i class="fa fa-<?php echo $lang['comments']; ?>"></i><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>#<?php echo $lang['comments']; ?>"><?php echo $row['<?php echo $lang['comments']; ?>']; ?> <?php echo $lang['comments']; ?></a></span>
				</p>
			</div>
			<div class="post-body">
				<p>
				<?php
				$content = clean_input2($row['content']);
				$content = (strlen($content) > 903) ? substr($content,0,900).'...' : $content;
				echo $content;
				?>
				</p>
			</div>
			<div class="post-foot">
				<span><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>#leave_comment" class="btn btn-default"><?php echo $lang['leave_a_comment']; ?></a></span>
				<span><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>" class="btn btn-default"><?php echo $lang['read_more']; ?></a></span>
			</div>
		</article>
		<?php
		}
	} else {
		echo $lang['no_posts'];
	}

	echo '<br>';
	$num_rows = mysql_num_rows(mysql_query("SELECT * FROM blogger_posts"));
	$itemPerPage = $limit;
	$firstPage = 1; // or 1, depending on your implementation
	$totalPage = ceil($num_rows / $itemPerPage);
	$currentPage = (int)$page;
	if($currentPage > $firstPage) {
		$pg = $currentPage-1;
		$load_page = "'$url','#results','home','$pg',''";
		echo '<a href="javascript:void(0);" class="btn btn-primary" onclick="load_page('.$load_page.');"><i class="fa fa-arrow-circle-o-left"></i> '.$lang[prev].'</a>';
	}

	if($currentPage < $totalPage) {
		$pg = $currentPage+1;
		$load_page = "'$url','#results','home','$pg',''";
		echo '<a href="javascript:void(0);" class="btn btn-primary pull-right" onclick="load_page('.$load_page.');">'.$lang[next].' <i class="fa fa-arrow-circle-o-right"></i></a>';

	}
} elseif($type == "category") {
	$id = protect($_GET['custom_id']);
	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 15;
	$startpoint = ($page * $limit) - $limit;
	$sql = mysql_query("SELECT * FROM blogger_posts WHERE category='$id' ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
	if(mysql_num_rows($sql)>0) {
		while($row = mysql_fetch_array($sql)) {
		$cat = mysql_fetch_array(mysql_query("SELECT * FROM blogger_categories WHERE id='$row[category]'"));
		?>
		<article class="post">
			<div class="post-head">
				<h2 class="post-title">
					<a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>"><?php echo $row['title']; ?></a>
				</h2>
				<p class="post-meta muted">
					<span><i class="fa fa-calendar"></i><?php echo format_time($web['date_f'],$row['time']); ?></span>
					<span><i class="fa fa-user"></i><?php echo idinfo($row['author'],"name"); ?></span>
					<span><i class="fa fa-folder"></i><a href="<?php echo $url.'category/'.make_category_link($cat[id]).'-'.$cat[id]; ?>"><?php echo $cat['value']; ?></a></span>
					<span><i class="fa fa-<?php echo $lang['comments']; ?>"></i><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>#<?php echo $lang['comments']; ?>"><?php echo $row['<?php echo $lang['comments']; ?>']; ?> <?php echo $lang['comments']; ?></a></span>
				</p>
			</div>
			<div class="post-body">
				<p>
				<?php
				$content = clean_input2($row['content']);
				$content = (strlen($content) > 903) ? substr($content,0,900).'...' : $content;
				echo $content;
				?>
				</p>
			</div>
			<div class="post-foot">
				<span><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>#leave_comment" class="btn btn-default"><?php echo $lang['leave_a_comment']; ?></a></span>
				<span><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>" class="btn btn-default"><?php echo $lang['read_more']; ?></a></span>
			</div>
		</article>
		<?php
		}
	} else {
		echo $lang['no_posts'];
	}

	echo '<br>';
	$num_rows = mysql_num_rows(mysql_query("SELECT * FROM blogger_posts WHERE category='$id'"));
	$itemPerPage = $limit;
	$firstPage = 1; // or 1, depending on your implementation
	$totalPage = ceil($num_rows / $itemPerPage);
	$currentPage = (int)$page;
	if($currentPage > $firstPage) {
		$pg = $currentPage-1;
		$load_page = "'$url','#results','category','$pg','$id'";
		echo '<a href="javascript:void(0);" class="btn btn-primary" onclick="load_page('.$load_page.');"><i class="fa fa-arrow-circle-o-left"></i> '.$lang[prev].'</a>';
	}

	if($currentPage < $totalPage) {
		$pg = $currentPage+1;
		$load_page = "'$url','#results','category','$pg','$id'";
		echo '<a href="javascript:void(0);" class="btn btn-primary pull-right" onclick="load_page('.$load_page.');">'.$lang[next].' <i class="fa fa-arrow-circle-o-right"></i></a>';

	}
} elseif($type == "tag") {
	$tag = protect($_GET['custom_id']);
	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 15;
	$startpoint = ($page * $limit) - $limit;
	$sql = mysql_query("SELECT * FROM blogger_posts WHERE tags LIKE '%$tag%' ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
	if(mysql_num_rows($sql)>0) {
		while($row = mysql_fetch_array($sql)) {
		$cat = mysql_fetch_array(mysql_query("SELECT * FROM blogger_categories WHERE id='$row[category]'"));
		?>
		<article class="post">
			<div class="post-head">
				<h2 class="post-title">
					<a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>"><?php echo $row['title']; ?></a>
				</h2>
				<p class="post-meta muted">
					<span><i class="fa fa-calendar"></i><?php echo format_time($web['date_f'],$row['time']); ?></span>
					<span><i class="fa fa-user"></i><?php echo idinfo($row['author'],"name"); ?></span>
					<span><i class="fa fa-folder"></i><a href="<?php echo $url.'category/'.make_category_link($cat[id]).'-'.$cat[id]; ?>"><?php echo $cat['value']; ?></a></span>
					<span><i class="fa fa-<?php echo $lang['comments']; ?>"></i><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>#<?php echo $lang['comments']; ?>"><?php echo $row['<?php echo $lang['comments']; ?>']; ?> <?php echo $lang['comments']; ?></a></span>
				</p>
			</div>
			<div class="post-body">
				<p>
				<?php
				$content = clean_input2($row['content']);
				$content = (strlen($content) > 903) ? substr($content,0,900).'...' : $content;
				echo $content;
				?>
				</p>
			</div>
			<div class="post-foot">
				<span><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>#leave_comment" class="btn btn-default"><?php echo $lang['leave_a_comment']; ?></a></span>
				<span><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>" class="btn btn-default"><?php echo $lang['read_more']; ?></a></span>
			</div>
		</article>
		<?php
		}
	} else {
		echo $lang['no_posts'];
	}

	echo '<br>';
	$num_rows = mysql_num_rows(mysql_query("SELECT * FROM blogger_posts WHERE tags LIKE '%$tag%'"));
	$itemPerPage = $limit;
	$firstPage = 1; // or 1, depending on your implementation
	$totalPage = ceil($num_rows / $itemPerPage);
	$currentPage = (int)$page;
	if($currentPage > $firstPage) {
		$pg = $currentPage-1;
		$load_page = "'$url','#results','tag','$pg','$tag'";
		echo '<a href="javascript:void(0);" class="btn btn-primary" onclick="load_page('.$load_page.');"><i class="fa fa-arrow-circle-o-left"></i> '.$lang[prev].'</a>';
	}

	if($currentPage < $totalPage) {
		$pg = $currentPage+1;
		$load_page = "'$url','#results','tag','$pg','$tag'";
		echo '<a href="javascript:void(0);" class="btn btn-primary pull-right" onclick="load_page('.$load_page.');">'.$lang[next].' <i class="fa fa-arrow-circle-o-right"></i></a>';

	}
} elseif($type == "archive") {
	$archive_id = protect($_GET['custom_id']);
	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit = 15;
	$startpoint = ($page * $limit) - $limit;
	$sql = mysql_query("SELECT * FROM blogger_archives_posts WHERE archive_id='$archive_id' ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
	if(mysql_num_rows($sql)>0) {
		while($a = mysql_fetch_array($sql)) {
		$row = mysql_fetch_array(mysql_query("SELECT * FROM blogger_posts WHERE id='$a[post_id]'"));
		$cat = mysql_fetch_array(mysql_query("SELECT * FROM blogger_categories WHERE id='$row[category]'"));
		?>
		<article class="post">
			<div class="post-head">
				<h2 class="post-title">
					<a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>"><?php echo $row['title']; ?></a>
				</h2>
				<p class="post-meta muted">
					<span><i class="fa fa-calendar"></i><?php echo format_time($web['date_f'],$row['time']); ?></span>
					<span><i class="fa fa-user"></i><?php echo idinfo($row['author'],"name"); ?></span>
					<span><i class="fa fa-folder"></i><a href="<?php echo $url.'category/'.make_category_link($cat[id]).'-'.$cat[id]; ?>"><?php echo $cat['value']; ?></a></span>
					<span><i class="fa fa-<?php echo $lang['comments']; ?>"></i><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>#<?php echo $lang['comments']; ?>"><?php echo $row['<?php echo $lang['comments']; ?>']; ?> <?php echo $lang['comments']; ?></a></span>
				</p>
			</div>
			<div class="post-body">
				<p>
				<?php
				$content = clean_input2($row['content']);
				$content = (strlen($content) > 903) ? substr($content,0,900).'...' : $content;
				echo $content;
				?>
				</p>
			</div>
			<div class="post-foot">
				<span><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>#leave_comment" class="btn btn-default"><?php echo $lang['leave_a_comment']; ?></a></span>
				<span><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>" class="btn btn-default"><?php echo $lang['read_more']; ?></a></span>
			</div>
		</article>
		<?php
		}
	} else {
		echo $lang['no_posts'];
	}

	echo '<br>';
	$num_rows = mysql_num_rows(mysql_query("SELECT * FROM blogger_archives_posts WHERE archive_id='$archive_id'"));
	$itemPerPage = $limit;
	$firstPage = 1; // or 1, depending on your implementation
	$totalPage = ceil($num_rows / $itemPerPage);
	$currentPage = (int)$page;
	if($currentPage > $firstPage) {
		$pg = $currentPage-1;
		$load_page = "'$url','#results','archive','$pg','$archive_id'";
		echo '<a href="javascript:void(0);" class="btn btn-primary" onclick="load_page('.$load_page.');"><i class="fa fa-arrow-circle-o-left"></i> '.$lang[prev].'</a>';
	}

	if($currentPage < $totalPage) {
		$pg = $currentPage+1;
		$load_page = "'$url','#results','archive','$pg','$archive_id'";
		echo '<a href="javascript:void(0);" class="btn btn-primary pull-right" onclick="load_page('.$load_page.');">'.$lang[next].' <i class="fa fa-arrow-circle-o-right"></i></a>';

	}
} else {
	echo 'Hacking attempt!';
}
?>
