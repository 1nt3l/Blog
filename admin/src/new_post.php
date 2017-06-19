<div class="row">
	<div class="col-lg-12">
		<h1>New post</h1>

		<?php 
		if(isset($_POST['do_publish'])) {
			$title = protect($_POST['title']);
			$content = clean_input($_POST['content']);
			$tags = protect($_POST['tags']);
			$category = protect($_POST['category']);
			$time = time();

			if(empty($title) or empty($content) or empty($tags) or empty($category)) { echo error("All fields are required."); }
			elseif(strlen($title)>60) { echo error("Post title must be less than 60 characters."); }
			else {
				$insert = mysql_query("INSERT blogger_posts (title,content,author,category,time,tags) VALUES ('$title','$content','$_SESSION[user_id]','$category','$time','$tags')");
				$row = mysql_fetch_array(mysql_query("SELECT * FROM blogger_posts WHERE author='$_SESSION[user_id]' ORDER BY id DESC LIMIT 1"));
				$link = $url.'post/'.make_post_link($row[id]).'-'.$row[id];
				$link = '<a href="'.$link.'" target="_blank">'.$link.'</a>';
				$month = date("m");
				$year = date("Y");
				$check_archive = mysql_query("SELECT * FROM blogger_archives WHERE month='$month' and year='$year'");
				if(mysql_num_rows($check_archive)>0) {
					$archive = mysql_fetch_array($check_archive);
					$insert_archive_post = mysql_query("INSERT blogger_archives_posts (post_id,archive_id) VALUES ('$row[id]','$archive[id]')");
				} else {
					$create_archive = mysql_query("INSERT blogger_archives (month,year) VALUES ('$month','$year')");
					$archive = mysql_fetch_array(mysql_query("SELECT * FROM blogger_archives WHERE month='$month' and year='$year'"));
					$insert_archive_post = mysql_query("INSERT blogger_archives_posts (post_id,archive_id) VALUES ('$row[id]','$archive[id]')");
				}
				$tags = explode(",",$tags);
				foreach ($tags as $tag) {
						$tag = str_replace(' ','',$tag);
						$check_tag = mysql_query("SELECT * FROM blogger_popular_tags WHERE tag='$tag'");
						if(mysql_num_rows($check_tag)>0) {
							$update_tag = mysql_query("UPDATE blogger_popular_tags SET used=used+1 WHERE tag='$tag'");
						} else {
							$insert_tag = mysql_query("INSERT blogger_popular_tags (tag,used) VALUES ('$tag','1')");
						}
				}
				$get_subscribers = mysql_query("SELECT * FROM blogger_subscribers ORDER BY id");
				if(mysql_num_rows($get_subscribers)>0) {
					while($subscriber = mysql_fetch_array($get_subscribers)) {
					$to      = $subscriber['email'];
					$subject = $web['web_name']." publish new post";
					$message = 'Hi '.$subscriber[email].'

We publish a new post in our blog you can preview it here:
'.$url.'post/'.make_post_link($row[id]).'-'.$row[id].'

If you do not wish to receive such messages more can unsubscribe here: '.$url.'unsubscribe/'.$subscriber[hash].'
Do not reply on this message.';
					$headers = 'From: '.$web[web_email].'' . "\r\n" .
						'Reply-To: '.$web[web_email].'' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();

						mail($to, $subject, $message, $headers);
					}
				}
				echo success("Your new post was published successfully.<br/>Click on link to preview post: $link");
			}
		}
		?>

		<form role="form" action="" method="POST">
		  <div class="form-group">
			<label>Post title</label>
			<input type="text" class="form-control" name="title" placeholder="Post title *">
		  </div>
		  <div class="form-group">
			<label>Content</label>
			<textarea id="editor" class="textarea" name="content"></textarea>
		  </div>
		  <div class="form-group">
			<label>Tags</label>
			<input type="text" class="form-control" name="tags" placeholder="Example: post, tag1, title, tag2, bla, bla">
		  </div>
		  <div class="form-group">
			<label>Category</label>
			<select name="category" class="form-control">
				<?php
				$get_cats = mysql_query("SELECT * FROM blogger_categories ORDER BY id");
				if(mysql_num_rows($get_cats)>0) {
					while($cat = mysql_fetch_array($get_cats)) {
						echo '<option value="'.$cat[id].'">'.$cat[value].'</option>';
					}
				} else {
					echo '<option>No have categories.</option>';
				}
				?>
			</select>
		  </div>
		  <button type="submit" class="btn btn-default" name="do_publish">Publish</button>
		</form>
	</div>
</div>
