<div class="row">
	<div class="col-lg-12">
		<h1>Change password</h1>

		<?php
		if(isset($_POST['do_change'])) {
			$cpasswd = protect($_POST['cpasswd']);
			$npasswd = protect($_POST['npasswd']);
			$cnpasswd = protect($_POST['cnpasswd']);

			if(empty($cpasswd) or empty($npasswd) or empty($cnpasswd)) { echo error("All fields are required."); }
			elseif(idinfo($_SESSION['user_id'],"passwd") !== md5($cpasswd)) { echo error("Current password does not match."); }
			elseif($npasswd !== $cnpasswd) { echo error("New passwords does not match."); }
			else {
				$passwd = md5($npasswd);
				$update = mysql_query("UPDATE blogger_users SET passwd='$passwd' WHERE id='$_SESSION[user_id]'");
				echo success("Your password was changed successfully.");
			}
		}

		if(isset($_POST['do_save'])) {
			$profile_photo = protect($_POST['profile_photo']);
			$profile_info = protect($_POST['profile_info']);

			if(!empty($profile_photo) && !isValidURL($profile_photo)) { echo error("Please enter valid avatar link."); }
			else {
				$update = mysql_query("UPDATE blogger_users SET profile_photo='$profile_photo',profile_info='$profile_info' WHERE id='$_SESSION[user_id]'");
				echo success("Your changes was saved successfully.");
			}
		}
		?>

		<form role="form" action="" method="POST">
		  <div class="form-group">
			<label>Current password</label>
			<input type="password" class="form-control" name="cpasswd">
		  </div>
		  <div class="form-group">
			<label>New password</label>
			<input type="password" class="form-control" name="npasswd">
		  </div>
		  <div class="form-group">
			<label>Confirm new password</label>
			<input type="password" class="form-control" name="cnpasswd">
		  </div>
		  <button type="submit" class="btn btn-default" name="do_change">Change</button>
		</form>

		<h1>Profile</h1>
		 
		<form role="form" action="" method="POST">
		  <div class="form-group">
			<label>Avatar link</label>
			<input type="text" class="form-control" name="profile_photo" value="<?php echo idinfo($_SESSION['user_id'],"profile_photo"); ?>">
		  </div>
		  <div class="form-group">
			<label>Profile info</label>
			<textarea class="form-control" name="profile_info" rows="3"><?php echo idinfo($_SESSION['user_id'],"profile_info"); ?></textarea>
		  </div>
		  <button type="submit" class="btn btn-default" name="do_save">Save changes</button>
		</form>
	</div>
</div>
