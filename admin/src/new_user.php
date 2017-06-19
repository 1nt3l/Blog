<div class="row">
	<div class="col-lg-12">
		<h1>New user</h1>

		<?php
		if(idinfo($_SESSION['user_id'],"sysadmin") == 1) {

		if(isset($_POST['do_save'])) {
			$name = protect($_POST['name']);
			$usern = protect($_POST['usern']);
			$passwd = protect($_POST['passwd']);
			$email = protect($_POST['email']);

			$check_username = mysql_query("SELECT * FROM blogger_users WHERE usern='$usern'");
			$check_email = mysql_query("SELECT * FROM blogger_users WHERE email='$email'");

			if(empty($name) or empty($usern) or empty($passwd) or empty($email)) { echo error("All fields are required."); }
			elseif(!isValidUsername($usern)) { echo error("Please enter valid username."); }
			elseif(!isValidEmail($email)) { echo error("Please enter valid email address."); }
			elseif(mysql_num_rows($check_username)>0) { echo error("This username already exists."); }
			elseif(mysql_num_rows($check_email)>0) { echo error("This email address already exists."); }
			else {
				$passwd = md5($passwd);
				$insert = mysql_query("INSERT blogger_users (name,usern,passwd,email) VALUES ('$name','$usern','$passwd','$email')");
				echo success("New user was added successfully.");
			}
		}
		?>

		<form role="form" action="" method="POST">
		  <div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name">
		  </div>
		  <div class="form-group">
			<label>Username</label>
			<input type="text" class="form-control" name="usern">
		  </div>
		  <div class="form-group">
			<label>Password</label>
			<input type="text" class="form-control" name="passwd">
		  </div>
		  <div class="form-group">
			<label>Email address</label>
			<input type="text" class="form-control" name="email">
		  </div>
		  <button type="submit" class="btn btn-default" name="do_save">Add</button>
		</form>
		<?php
		} else {
			echo error("You don't have access to complete this function only System Administrator.");
		}
		?>
	</div>
</div>
