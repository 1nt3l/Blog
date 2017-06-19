<div id="loader">
	<h2><img src="<?php echo $url.'imgs/loader.gif'; ?>" width="30px"> Loading...</h2>
</div>
<h2><?php echo $lang['subscribe']; ?></h2>
<p><?php echo $lang['subscribe_info']; ?></p>
<br>

<?php
if(isset($_POST['do_subscribe'])) {
	$email = protect($_POST['email']);
	$check_email = mysql_query("SELECT * FROM blogger_subscribers WHERE email='$email'");

	if(empty($email)) { echo error($lang['subscribe_error_1']); }
	elseif(!isValidEmail($email)) { echo error($lang['subscribe_error_2']); }
	elseif(mysql_num_rows($check_email)>0) { echo error("$email $lang[subscribe_error_3]"); }
	else {
		$hash = md5($email);
		$insert = mysql_query("INSERT blogger_subscribers (email,hash) VALUES ('$email','$hash')");
		echo success($lang['subscribe_success']);
	}
}
?>

<form role="form" action="" method="POST">
  <div class="form-group">
    <label for="exampleInputEmail1"><?php echo $lang['email_address']; ?></label>
    <input type="text" class="form-control" name="email" id="exampleInputEmail1" placeholder="<?php echo $lang['email_address_placeholder']; ?>">
  </div>
  <button type="submit" name="do_subscribe" class="btn btn-default"><?php echo $lang['submit']; ?></button>
</form>
