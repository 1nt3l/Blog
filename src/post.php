<?php 
$id = protect($_GET['id']);
$sql = mysql_query("SELECT * FROM blogger_posts WHERE id='$id'");
if(mysql_num_rows($sql)==0) { header("Location: $web[url]"); }
$row = mysql_fetch_array($sql);
$cat = mysql_fetch_array(mysql_query("SELECT * FROM blogger_categories WHERE id='$row[category]'"));
$update = mysql_query("UPDATE blogger_posts SET views=views+1 WHERE id='$id'");
?>
	<article class="post">
		<div class="post-head">
			<h2 class="post-title">
				<?php echo $row['title']; ?>
			</h2>
			<p class="post-meta muted">
				<span><i class="fa fa-calendar"></i><?php echo format_time($web['date_f'],$row['time']); ?></span>
				<span><i class="fa fa-user"></i><?php echo idinfo($row['author'],"name"); ?></span>
				<span><i class="fa fa-folder"></i><a href="<?php echo $url.'category/'.make_category_link($cat[id]).'-'.$cat[id]; ?>"><?php echo $cat['value']; ?></a></span>
				<span><i class="fa fa-comments"></i><a href="<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>#comments"><?php echo $row['comments']; ?> <?php echo $lang['comments']; ?></a></span>
			</p>
		</div>
		<div class="post-body">
			<p>
			<?php
			if($web['ad_place1']) {
				?>
				<div class="col-lg-12">
					<center><?php echo $web['ad_place1']; ?></center>
					<br>
				</div>
				<?php
			}
			echo nl2br($row['content']);
			?>
			</p>

			<br>

			<div class="btn-group">
			  <button type="button" id="btn_t_u" onclick="thumb_up('<?php echo $web['url']; ?>','<?php echo $row['id']; ?>','<?php echo $_SERVER['REMOTE_ADDR']; ?>');" class="btn btn-success"><i class="fa fa-thumbs-up"></i> <span id="thumbs_up_<?php echo $row['id']; ?>"><?php echo $row['thumbs_up']; ?></span></button>
			  <button type="button" id="btn_t_d" onclick="thumb_down('<?php echo $web['url']; ?>','<?php echo $row['id']; ?>','<?php echo $_SERVER['REMOTE_ADDR']; ?>');" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> <span id="thumbs_down_<?php echo $row['id']; ?>"><?php echo $row['thumbs_down']; ?></span></button>
			  <button type="button" class="btn btn-default"><span id="vote_text_<?php echo $row['id']; ?>"><?php echo $lang['vote_post']; ?></span></button>
			</div>

			<div class="tags" style="margin-top:10px;">
			<?php
			$tags = explode(",",$row['tags']);
			foreach ($tags as $tag) {
					$tag = str_replace(' ','',$tag);
					echo '<a href="'.$url.'tag/'.$tag.'" style="margin:2px;">'.$tag.'</a>';
			}
			?>
			</div>

			<div style="margin-top:10px;">
				<b><?php echo $lang['share_this_post']; ?></b><br/>
				<a href="http://www.facebook.com/share.php?u=<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>" target="_blank"><i class="fa fa-facebook-square"></i> Facebook</a>&nbsp;&nbsp;&nbsp;
				<a href="https://twitter.com/share?url=<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>" target="_blank"><i class="fa fa-twitter-square"></i> Twitter</a>&nbsp;&nbsp;&nbsp;
				<a href="https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>" target="_blank"><i class="fa fa-google-plus-square"></i> Google+</a>&nbsp;&nbsp;&nbsp;
				<a href="http://www.tumblr.com/share?v=3&u=<?php echo $url.'post/'.make_post_link($row[id]).'-'.$row[id]; ?>" target="_blank"><i class="fa fa-tumblr-square"></i> Tumblr</a>&nbsp;&nbsp;&nbsp;
			</div>
		</div>

	</article>


<hr />

<section class="post-author media">
	<h3><?php echo $lang['author']; ?></h3>
	<div class="media">
		<img src="<?php echo get_profile_photo($row['author']); ?>" class="avatar pull-left" width="60">
		<div class="media-body">
			<h4><?php echo idinfo($row['author'],"name"); ?> <small>@<?php echo idinfo($row['author'],"usern"); ?></small></h4>
			<div><?php echo nl2br(check_urls(idinfo($row['author'],"profile_info"))); ?></div>
		</div>
	</div>
</section>
<hr>
<section class="comment-list">
	<h3><?php echo $lang['comments']; ?></h3>
	<div class="comments" id="comments">
		<?php
		$get_comments = mysql_query("SELECT * FROM blogger_comments WHERE post_id='$row[id]' and status='1' ORDER BY id");
		if(mysql_num_rows($get_comments)>0) {
			while($get = mysql_fetch_array($get_comments)) {
			if($get['avatar']) {
				$avatar = $get['avatar'];
			} else {
				$avatar = $url.'imgs/default_avatar.png';
			}
			?>
			<div class="comment media">
				<a href="<?php echo $get['website']; ?>" class="pull-left" target="_blank">
					<img src="<?php echo $avatar; ?>" class="avatar">
				</a>
				<div class="media-body">
					<h4><a href="<?php echo $get['website']; ?>" target="_blank" style="color:#000000;"><?php echo $get['name']; ?></a></h4>
					<div>
						<p><?php echo nl2br(check_urls($get['comment'])); ?></p>
						<small class="muted"><?php echo format_time($web['date_f'],$get['time']); ?></small>
					</div>
				</div>
			</div>
			<?php
			}
		} else {
			echo $lang['no_comments'];
		}
		?>
	</div>
</section>
					<hr>
<section class="comment-form" id="leave_comment">
	<h3><?php echo $lang['add_comment']; ?></h3>
	<?php
	if(isset($_POST['add_comment'])) {
		$name = protect($_POST['name']);
		$email = protect($_POST['email']);
		$website = protect($_POST['website']);
		$avatar = protect($_POST['avatar']);
		$comment = protect($_POST['comment']);
		$captcha = protect($_POST['captcha']);
		$time = time();
		if(empty($name) or empty($email) or empty($comment) or empty($captcha)) { echo error($lang['comment_error_1']); }
		elseif(!isValidEmail($email)) { echo error($lang['comment_error_2']); }
		elseif(!empty($website) && !isValidURL($website)) { echo error($lang['comment_error_3']); }
		elseif(!empty($avatar) && !isValidURL($website)) { echo error($lang['comment_error_4']); }
		elseif($captcha !== $_SESSION['captcha_code']) { echo error($lang['comment_error_5']); }
		else {
			$insert = mysql_query("INSERT blogger_comments (post_id,name,email,website,avatar,comment,status,time) VALUES ('$row[id]','$name','$email','$website','$avatar','$comment','2','$time')") or die(mysql_error());
			echo success($lang['comment_success']);
		}
	}
	?>
	<p><?php echo $lang['comment_info']; ?></p>
	<form action="" method="POST">
		<div class="form-group">
			<input type="text" class="form-control" name="name" placeholder="<?php echo $lang['name']; ?>">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="email" placeholder="<?php echo $lang['email']; ?>">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="website" placeholder="<?php echo $lang['website']; ?>">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="avatar" placeholder="<?php echo $lang['avatar']; ?>">
		</div>
		<div class="form-group">
			<textarea class="form-control" rows="8" name="comment" placeholder="<?php echo $lang['comment']; ?>"></textarea>
		</div>
		<div class="input-group" style="margin-bottom:15px;">
		  <input type="text" class="form-control" name="captcha" placeholder="<?php echo $lang['captcha']; ?>">
		  <span class="input-group-addon"><?php echo captcha(9); ?></span>
		</div>
		<button class="btn btn-primary pull-right" name="add_comment" type="submit"><?php echo $lang['add_comment']; ?></button>
	</form>
</section>
