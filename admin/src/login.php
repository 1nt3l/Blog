<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<!--META-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $web['web_name']; ?> Login</title>

<!--STYLESHEETS-->
<link href="css/style.css" rel="stylesheet" type="text/css" />

<!--SCRIPTS-->
<script type="text/javascript" src="js/jquery.js"></script>
<!--Slider-in icons-->
<script type="text/javascript">
$(document).ready(function() {
	$(".username").focus(function() {
		$(".user-icon").css("left","-48px");
	});
	$(".username").blur(function() {
		$(".user-icon").css("left","0px");
	});

	$(".password").focus(function() {
		$(".pass-icon").css("left","-48px");
	});
	$(".password").blur(function() {
		$(".pass-icon").css("left","0px");
	});
});
</script>

</head>
<body>

<!--WRAPPER-->
<div id="wrapper">

	<!--SLIDE-IN ICONS-->
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
    <!--END SLIDE-IN ICONS-->

<!--LOGIN FORM-->
<form name="login-form" class="login-form" action="" method="post">

	<!--HEADER-->
    <div class="header">
    <!--TITLE--><h1><?php echo $web['web_name']; ?> <span style="font-size:12px;">Control Panel</span></h1><!--END TITLE-->
    <!--DESCRIPTION-->
	<span>
	<?php
	if(isset($_POST['do_login'])) {
		$usern = protect($_POST['usern']);
		$passwd = protect($_POST['passwd']);
		$passwd = md5($passwd);

		$sql = mysql_query("SELECT * FROM blogger_users WHERE usern='$usern' and passwd='$passwd'");
		if(mysql_num_rows($sql)>0) {
			$row = mysql_fetch_array($sql);
			$_SESSION['usern'] = $row['usern'];
			$_SESSION['user_id'] = $row['id'];
			header("Location: ./");
		} else {
			echo '<b style="color:red;font-size:12px;"><br>Wrong username or password.</b>';
		}
	} else {
		echo 'Please enter your login details.<br/>After login you have full control of blog.';
	}
	?>
	</span><!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->

	<!--CONTENT-->
    <div class="content">
	<!--USERNAME--><input name="usern" type="text" class="input username" placeholder="Username *" /><!--END USERNAME-->
    <!--PASSWORD--><input name="passwd" type="password" class="input password" placeholder="Password *" /><!--END PASSWORD-->
    </div>
    <!--END CONTENT-->

    <!--FOOTER-->
    <div class="footer">
    <!--LOGIN BUTTON--><input type="submit" name="do_login" value="Login" class="button" /><!--END LOGIN BUTTON-->
    </div>
    <!--END FOOTER-->

</form>
<!--END LOGIN FORM-->

</div>
<!--END WRAPPER-->

<!--GRADIENT--><div class="gradient"></div><!--END GRADIENT-->

</body>
</html>
