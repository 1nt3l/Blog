<div class="row">
	<div class="col-lg-12">
		<h1>Blog settings</h1>

		<?php
		if(isset($_POST['do_save'])) {
			if(idinfo($_SESSION['user_id'],"sysadmin") == 1) {
				$title = protect($_POST['title']);
				$description = protect($_POST['description']);
				$keywords = protect($_POST['keywords']);
				$url = protect($_POST['url']);
				$web_name = protect($_POST['web_name']);
				$web_email = protect($_POST['web_email']);
				$web_description = protect($_POST['web_description']);
				$date_f = protect($_POST['date_f']);

				if(empty($title) or empty($description) or empty($keywords) or empty($url) or empty($web_email) or empty($web_name) or empty($web_description) or empty($date_f)) { echo error("All fields are required."); }
				elseif(!isValidURL($url)) { echo error("Please enter valid blog url address."); }
				elseif(!isValidEmail($web_email)) { echo error("Please enter valid blog email address."); }
				else {
					$update = mysql_query("UPDATE blogger_settings SET title='$title',description='$description',keywords='$keywords',url='$url',web_email='$web_email',web_name='$web_name',web_description='$web_description',date_f='$date_f'");
					echo success("Your changes was saved successfully.");
					$web = mysql_fetch_array(mysql_query("SELECT * FROM blogger_settings ORDER BY id DESC LIMIT 1"));
				}
			} else {
				echo error("You don't have access to complete this function only System Administrator.");
			}
		}
		?>

		<form role="form" action="" method="POST">
		  <div class="form-group">
			<label>Title</label>
			<input type="text" class="form-control" name="title" value="<?php echo $web['title']; ?>">
		  </div>
		  <div class="form-group">
			<label>Description</label>
			<textarea name="description" class="form-control" rows="3"><?php echo $web['description']; ?></textarea>
		  </div>
		  <div class="form-group">
			<label>Keywords</label>
			<textarea name="keywords" class="form-control" rows="3"><?php echo $web['keywords']; ?></textarea>
		  </div>
		  <div class="form-group">
			<label>Blog url</label>
			<input type="text" class="form-control" name="url" value="<?php echo $web['url']; ?>">
		  </div>
		  <div class="form-group">
			<label>Blog name</label>
			<input type="text" class="form-control" name="web_name" value="<?php echo $web['web_name']; ?>">
		  </div>
		  <div class="form-group">
			<label>Blog description</label>
			<input type="text" class="form-control" name="web_description" value="<?php echo $web['web_description']; ?>">
		  </div>
		  <div class="form-group">
			<label>Blog email</label>
			<input type="text" class="form-control" name="web_email" value="<?php echo $web['web_email']; ?>">
		  </div>
		  <div class="form-group">
			<label>Date format</label>
			<select name="date_f" class="form-control">
				<option value="1" <?php if($web['date_f'] == 1) { echo 'selected'; } ?>>January 1, 2014</option>
				<option value="2" <?php if($web['date_f'] == 2) { echo 'selected'; } ?>>1 January 2014</option>
				<option value="3" <?php if($web['date_f'] == 3) { echo 'selected'; } ?>>1 Jan 2014</option>
			</select>
		  </div>
		  <button type="submit" class="btn btn-default" name="do_save">Save changes</button>
		</form>
	</div>
</div>
