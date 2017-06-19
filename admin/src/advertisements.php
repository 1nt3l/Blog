<div class="row">
	<div class="col-lg-12">
		<h1>Advertisements</h1>

		<?php
		if(isset($_POST['do_save'])) {
			if(idinfo($_SESSION['user_id'],"sysadmin") == 1) {
				$ad_place1 = $_POST['ad_place1'];
				$ad_place2 = $_POST['ad_place2'];
				$update = mysql_query("UPDATE blogger_settings SET ad_place1='$ad_place1',ad_place2='$ad_place2'");
				echo success("Your changes was saved successfully.");
				$web = mysql_fetch_array(mysql_query("SELECT * FROM blogger_settings ORDER BY id DESC LIMIT 1"));
			} else {
				echo error("You don't have access to complete this function only System Administrator.");
			}
		}
		?>

		<form role="form" action="" method="POST">
		  <div class="form-group">
			<label>Ad place 468x60</label>
			<textarea name="ad_place1" class="form-control" rows="5" placeholder="Paste code here..."><?php echo $web['ad_place1']; ?></textarea>
		  </div>
		  <div class="form-group">
			<label>Ad place 250x250</label>
			<textarea name="ad_place2" class="form-control" rows="5" placeholder="Paste code here..."><?php echo $web['ad_place2']; ?></textarea>
		  </div>
		  <button type="submit" class="btn btn-default" name="do_save">Save changes</button>
		</form>
	</div>
</div>
