		<div class="row">
			<div class="col-lg-12">
				<?php
				$type = protect($_GET['type']);
				$id = protect($_GET['id']);
				 
				if($type == "post") {
				$sql = mysql_query("SELECT * FROM blogger_posts WHERE id='$id'");
				if(mysql_num_rows($sql)==0) { header("Location: $aurl"); }
				$row = mysql_fetch_array($sql);
				?>
				<h1>Edit <small>post</small></h1>

				<?php
				if(isset($_POST['do_save'])) {
					$title = protect($_POST['title']);
					$content = clean_input($_POST['content']);
					$tags = protect($_POST['tags']);
					$category = protect($_POST['category']);

					if(empty($title) or empty($content) or empty($tags) or empty($category)) { echo error("All fields are required."); }
					elseif(strlen($title)>60) { echo error("Post title must be less than 60 characters."); }
					else {
						$update = mysql_query("UPDATE blogger_posts SET title='$title',content='$content',tags='$tags',category='$category' WHERE id='$row[id]'");
						echo success("Your changes was saved successfully.");
						$row = mysql_fetch_array(mysql_query("SELECT * FROM blogger_posts WHERE id='$id'"));
					}
				}
				?>

				<form role="form" action="" method="POST">
				  <div class="form-group">
					<label>Post title</label>
					<input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>">
				  </div>
				  <div class="form-group">
					<label>Content</label>
					<textarea id="editor" class="textarea" name="content"><?php echo $row['content']; ?></textarea>
				  </div>
				  <div class="form-group">
					<label>Tags</label>
					<input type="text" class="form-control" name="tags" value="<?php echo $row['tags']; ?>">
				  </div>
				  <div class="form-group">
					<label>Category</label>
					<select name="category" class="form-control">
						<?php
						$get_cats = mysql_query("SELECT * FROM blogger_categories ORDER BY id");
						if(mysql_num_rows($get_cats)>0) {
							while($cat = mysql_fetch_array($get_cats)) {
								if($row['category'] == $cat['id']) { $sel = 'selected'; } else { $sel = ''; }
								echo '<option value="'.$cat[id].'" '.$sel.'>'.$cat[value].'</option>';
							}
						} else {
							echo '<option>No have categories.</option>';
						}
						?>
					</select>
				  </div>
				  <button type="submit" class="btn btn-default" name="do_save">Save changes</button>
				</form>
				<?php
				} elseif($type == "comment") {
				$sql = mysql_query("SELECT * FROM blogger_comments WHERE id='$id'");
				if(mysql_num_rows($sql)==0) { header("Location: $aurl"); }
				$row = mysql_fetch_array($sql);
				?>
				<h1>Edit <small>comment</small></h1>

				<?php
				if(isset($_POST['do_save'])) {
					$name = protect($_POST['name']);
					$email = protect($_POST['email']);
					$website = protect($_POST['website']);
					$avatar = protect($_POST['avatar']);
					$comment = protect($_POST['comment']);

					if(empty($name) or empty($email) or empty($comment)) { echo error("Please do not leave empty this fields: author name, author email and comment"); }
					elseif(!isValidEmail($email)) { echo error("Please enter valid email address."); }
					elseif(!empty($website) && !isValidURL($website)) { echo error("Please enter valid website address."); }
					elseif(!empty($avatar) && !isValidURL($avatar)) { echo error("Please enter valid avatar address."); }
					else {
						$update = mysql_query("UPDATE blogger_comments SET name='$name',email='$email',website='$website',avatar='$avatar',comment='$comment' WHERE id='$row[id]'");
						echo success("Your changes was saved successfully.");
						$row = mysql_fetch_array(mysql_query("SELECT * FROM blogger_comments WHERE id='$row[id]'"));
					}
				}
				?>

				<form role="form" action="" method="POST">
				  <div class="form-group">
					<label>Author</label>
					<input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>">
				  </div>
				  <div class="form-group">
					<label>Author email</label>
					<input type="text" class="form-control" name="email" value="<?php echo $row['email']; ?>">
				  </div>
				  <div class="form-group">
					<label>Author website</label>
					<input type="text" class="form-control" name="website" value="<?php echo $row['website']; ?>">
				  </div>
				  <div class="form-group">
					<label>Author avatar</label>
					<input type="text" class="form-control" name="avatar" value="<?php echo $row['avatar']; ?>">
				  </div>
				  <div class="form-group">
					<label>Comment</label>
					<textarea class="form-control" rows="4" name="comment"><?php echo $row['comment']; ?></textarea>
				  </div>
				  <button type="submit" class="btn btn-default" name="do_save">Save changes</button>
				</form>
				<?php
				} elseif($type == "category") {
				$sql = mysql_query("SELECT * FROM blogger_categories WHERE id='$id'");
				if(mysql_num_rows($sql)==0) { header("Location: $aurl"); }
				$row = mysql_fetch_array($sql);
				?>
				<h1>Edit <small>category</small></h1>

				<?php
				if(isset($_POST['do_save'])) {
					$value = protect($_POST['value']);
					$check_category = mysql_query("SELECT * FROM blogger_categories WHERE value='$value'");

					if(empty($value)) { echo error("Please enter some category name."); }
					elseif($value !== $row['value'] && mysql_num_rows($check_category)>0) { echo error("This category already exists."); }
					else {
						$update = mysql_query("UPDATE blogger_categories SET value='$value' WHERE id='$row[id]'");
						echo success("Your changes was saved successfully.");
						$row = mysql_fetch_array(mysql_query("SELECT * FROM blogger_categories WHERE id='$row[id]'"));
					}
				}
				?>

				<form role="form" action="" method="POST">
				  <div class="form-group">
					<label>Category name</label>
					<input type="text" class="form-control" name="value" value="<?php echo $row['value']; ?>">
				  </div>
				  <button type="submit" class="btn btn-default" name="do_save">Save changes</button>
				</form>
				<?php
				} else {
					echo '<h1>404 error - Page not found!</h1>';
				}
				?>
			</div>
		</div>
