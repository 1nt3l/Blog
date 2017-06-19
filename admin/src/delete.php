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
				<h1>Delete <small>post</small></h1>

				<?php
				if(isset($_GET['y']) == "1") {
					$delete = mysql_query("DELETE FROM blogger_posts WHERE id='$row[id]'");
					$delete = mysql_query("DELETE FROM blogger_comments WHERE post_id='$row[id]'");
					$delete = mysql_query("DELETE FROM blogger_archives_posts WHERE post_id='$row[id]'");
					$delete = mysql_query("DELETE FROM blogger_likes WHERE post_id='$row[id]'");
					echo success("This post was deleted successfully.");
				} else {
				echo info("Are you sure you want to delete post '$row[title]'?");
				?>
				<a href="./?m=delete&type=post&id=<?php echo $row['id']; ?>&y=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a> <a href="./?m=manage_posts" class="btn btn-danger"><i class="fa fa-times"></i> No</a>
				<?php
				}
				?>

				<?php
				} elseif($type == "comment") {
				$sql = mysql_query("SELECT * FROM blogger_comments WHERE id='$id'");
				if(mysql_num_rows($sql)==0) { header("Location: $aurl"); }
				$row = mysql_fetch_array($sql);
				?>
				<h1>Delete <small>comment</small></h1>

				<?php
				if(isset($_GET['y']) == "1") {
					$delete = mysql_query("DELETE FROM blogger_comment WHERE id='$row[id]'");
					echo success("This comment was deleted successfully.");
				} else {
				echo info("Are you sure you want to delete comment?");
				?>
				<a href="./?m=delete&type=comment&id=<?php echo $row['id']; ?>&y=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a> <a href="./?m=manage_comments" class="btn btn-danger"><i class="fa fa-times"></i> No</a>
				<?php
				}
				?>

				<?php
				} elseif($type == "category") {
				$sql = mysql_query("SELECT * FROM blogger_categories WHERE id='$id'");
				if(mysql_num_rows($sql)==0) { header("Location: $aurl"); }
				$row = mysql_fetch_array($sql);
				?>
				<h1>Delete <small>category</small></h1>

				<?php
				if(isset($_GET['y']) == "1") {
					$delete = mysql_query("DELETE FROM blogger_posts WHERE category='$row[id]'");
					$delete = mysql_query("DELETE FROM blogger_categories WHERE id='$row[id]'");
					echo success("This category was deleted successfully.");
				} else {
				echo info("Are you sure you want to delete category '$row[value]'?");
				?>
				<a href="./?m=delete&type=category&id=<?php echo $row['id']; ?>&y=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a> <a href="./?m=manage_categories" class="btn btn-danger"><i class="fa fa-times"></i> No</a>
				<?php
				}
				?>

				<?php
				} elseif($type == "archive") {
				$sql = mysql_query("SELECT * FROM blogger_archives WHERE id='$id'");
				if(mysql_num_rows($sql)==0) { header("Location: $aurl"); }
				$row = mysql_fetch_array($sql);
				?>
				<h1>Delete <small>archive</small></h1>

				<?php
				if(isset($_GET['y']) == "1") {
					$sql = mysql_query("SELECT * FROM blogger_archives_posts WHERE archive_id='$row[id]'");
					while($r = mysql_fetch_array($sql)) {
						$delete = mysql_query("DELETE FROM blogger_posts WHERE id='$r[post_id]'");
					}
					$delete = mysql_query("DELETE FROM blogger_archives WHERE id='$row[id]'");
					$delete = mysql_query("DELETE FROM blogger_archives_posts WHERE archive_id='$row[id]'");
					echo success("This archive was deleted successfully.");
				} else {
				$date = decode_month($row[month]).' '.$row[year];
				echo info("Are you sure you want to delete archive '$date'?");
				?>
				<a href="./?m=delete&type=archive&id=<?php echo $row['id']; ?>&y=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a> <a href="./?m=manage_archives" class="btn btn-danger"><i class="fa fa-times"></i> No</a>
				<?php
				}
				?>

				<?php
				} elseif($type == "user") {
				$sql = mysql_query("SELECT * FROM blogger_users WHERE id='$id'");
				if(mysql_num_rows($sql)==0) { header("Location: $aurl"); }
				$row = mysql_fetch_array($sql);
				?>
				<h1>Delete <small>user</small></h1>

				<?php
				if(idinfo($_SESSION['user_id'],"sysadmin") == 1) {
					if(isset($_GET['y']) == "1") {
						$delete = mysql_query("DELETE FROM blogger_users WHERE id='$row[id]'");
						$sql = mysql_query("SELECT * FROM blogger_posts WHERE author='$row[id]'");
						while($row = mysql_fetch_array($sql)) {
							$delete = mysql_query("DELETE FROM blogger_archives_posts WHERE post_id='$row[id]'");
							$delete = mysql_query("DELETE FROM blogger_posts WHERE id='$row[id]'");
							$delete = mysql_query("DELETE FROM blogger_comments WHERE post_id='$row[id]'");
							$delete = mysql_query("DELETE FROM blogger_likes WHERE post_id='$row[id]'");
						}
						echo success("This user was deleted successfully.");
					} else {
					echo info("Are you sure you want to delete user '$row[usern]'?");
					?>
					<a href="./?m=delete&type=user&id=<?php echo $row['id']; ?>&y=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a> <a href="./?m=manage_users" class="btn btn-danger"><i class="fa fa-times"></i> No</a>
					<?php
					}
				} else {
				echo error("You dont have access to complete this function only System Administrator.");
				}
				?>

				<?php
				} else {
					echo '<h1>404 error - Page not found!</h1>';
				}
				?>
			</div>
		</div>
