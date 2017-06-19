<?php
ob_start();
session_start();
include("inc/functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<!--META-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Blogger Install Wizard</title>

<!--STYLESHEETS-->
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/install.css" rel="stylesheet" type="text/css" />

</head>
<body>

<!--WRAPPER-->
<div id="wrapper">
<!--LOGIN FORM-->

<?php
$step = protect($_GET['step']);

if($step == 2) {
?>
<form name="login-form" class="login-form" action="" method="post">
	<!--HEADER-->
    <div class="header">
    <!--TITLE--><h1>Blogger<span style="font-size:12px;">Install Wizard</span></h1><!--END TITLE-->
    <!--DESCRIPTION-->
	<span>
	<?php
	include("inc/config.php");
	if(isset($_POST['next'])) {
		$title = protect($_POST['title']);
		$description = protect($_POST['description']);
		$keywords = protect($_POST['keywords']);
		$url = protect($_POST['url']);
		$web_name = protect($_POST['web_name']);
		$web_description = protect($_POST['web_description']);
		$web_email = protect($_POST['web_email']);

		if(empty($title) or empty($description) or empty($keywords) or empty($url) or empty($web_name) or empty($web_description) or empty($web_email)) { echo error("All fields are required."); }
		elseif(!isValidURL($url)) { echo error("Please enter valid blog url address. Example: http://blogger.com/"); }
		elseif(!isValidEmail($web_email)) { echo error("Please enter valid blog email address. Example: no-reply@blogger.com"); }
		else {
			$insert = mysql_query("INSERT blogger_settings (title,description,keywords,url,web_name,web_description,web_email,date_f) VALUES ('$title','$description','$keywords','$url','$web_name','$web_description','$web_email','1')") or die(mysql_error());
			header("Location: ./install.php?step=3");
		}
	}
	?>
	</span><!--END DESCRIPTION-->
    </div>

	<div class="content">
		<input name="title" type="text" class="input username" placeholder="Title" />
		<input name="description" type="text" class="input username" placeholder="Description" />
		<input name="keywords" type="text" class="input username" placeholder="Keywords" />
		<input name="url" type="text" class="input username" placeholder="Blog url. Example: http://myblogger.com/" />
		<input name="web_name" type="text" class="input username" placeholder="Blog name. Example: Blogger" />
		<input name="web_description" type="text" class="input username" placeholder="Blog description. Example: My sample blog bla bla..." />
		<input name="web_email" type="text" class="input username" placeholder="Blog email. Example: no-reply@blogger.com" />
	</div>

    <div class="footer">
		<input type="submit" name="next" value="Next" class="button" />
    </div>
</form>
<?php
} elseif($step == 3) {
?>
<form name="login-form" class="login-form" action="" method="post">
	<!--HEADER-->
    <div class="header">
    <!--TITLE--><h1>Blogger<span style="font-size:12px;">Install Wizard</span></h1><!--END TITLE-->
    <!--DESCRIPTION-->
	<span>
	<?php
	include("inc/config.php");
	if(isset($_POST['next'])) {
		$name = protect($_POST['name']);
		$usern = protect($_POST['usern']);
		$passwd = protect($_POST['passwd']);
		$email = protect($_POST['email']);

		if(empty($name) or empty($usern) or empty($passwd) or empty($email)) { echo error("Please enter details for System Administrator."); }
		elseif(!isValidUsername($usern)) { echo error("Please enter valid username."); }
		elseif(!isValidEmail($email)) { echo error("Please enter valid email address."); }
		else {
			$_SESSION['install_usern'] = $usern;
			$_SESSION['install_passwd'] = $passwd;
			$passwd = md5($passwd);
			$insert = mysql_query("INSERT blogger_users (name,usern,passwd,email,sysadmin) VALUES ('$name','$usern','$passwd','$email','1')");
			header("Location: ./install.php?step=4");
		}
	}
	?>
	</span><!--END DESCRIPTION-->
    </div>

	<div class="content">
		<input name="name" type="text" class="input username" placeholder="Admin name" />
		<input name="usern" type="text" class="input username" placeholder="Admin username" />
		<input name="passwd" type="text" class="input username" placeholder="Admin password" />
		<input name="email" type="text" class="input username" placeholder="Admin email" />
	</div>

    <div class="footer">
		<input type="submit" name="next" value="Finish" class="button" />
    </div>
</form>
<?php
} elseif($step == 4) {
include("inc/config.php");
	$web = mysql_fetch_array(mysql_query("SELECT * FROM blogger_settings ORDER BY id DESC LIMIT 1"));
?>
<form name="login-form" class="login-form" action="<?php echo $web['url']; ?>admin" method="post">
	<!--HEADER-->
    <div class="header">
    <!--TITLE--><h1>Blogger<span style="font-size:12px;">Install Wizard</span></h1><!--END TITLE-->
    <!--DESCRIPTION-->
	<span>
	Installation was successfully!<br/>
	Blog address: <a href="<?php echo $web['url']; ?>"><?php echo $web['url']; ?></a><br/>
	Blog control panel address: <a href="<?php echo $web['url']; ?>admin"><?php echo $web['url']; ?>admin</a><br/>
	Username: <?php echo $_SESSION['install_usern']; ?><br/>
	Password: <?php echo $_SESSION['install_passwd']; ?>
	</span><!--END DESCRIPTION-->
    </div>

    <div class="footer">
		<input type="submit" name="next" value="Login to Control Panel" class="button" />
    </div>
</form>
<?php
@unlink("install.php");
} else {
?>
<form name="login-form" class="login-form" action="" method="post">
	<!--HEADER-->
    <div class="header">
    <!--TITLE--><h1>Blogger<span style="font-size:12px;">Install Wizard</span></h1><!--END TITLE-->
    <!--DESCRIPTION-->
	<span>
	<?php
	if(isset($_POST['next'])) {
		$mysql_host = protect($_POST['mysql_host']);
		$mysql_user = protect($_POST['mysql_user']);
		$mysql_pass = protect($_POST['mysql_pass']);
		$mysql_base = protect($_POST['mysql_base']);

		if(empty($mysql_host) or empty($mysql_user) or empty($mysql_pass) or empty($mysql_base)) { echo error("Please enter MySQL Connection details."); }
		else {
				$db = mysql_connect($mysql_host,$mysql_user,$mysql_pass);
				if($db) {
				$select_db = mysql_select_db($mysql_base,$db);
					if($select_db) {

						$sql_filename = 'sql.sql';
						$sql_contents = file_get_contents($sql_filename);
						$sql_contents = explode(";", $sql_contents);

						foreach($sql_contents as $k=>$v) {
							mysql_query($v);
						}

						$current .= '<?php
						';
						$current .= '$sql["host"] = "'.$mysql_host.'";
						';
						$current .= '$sql["user"] = "'.$mysql_user.'";
						';
						$current .= '$sql["pass"] = "'.$mysql_pass.'";
						';
						$current .= '$sql["base"] = "'.$mysql_base.'";
						';
						$current .= '$connection = mysql_connect($sql["host"],$sql["user"],$sql["pass"]);
						';
						$current .= '$select_database = mysql_select_db($sql["base"], $connection);
						';
						$current .= 'mysql_query("SET NAMES utf8");
						';
						$current .= '?>
						';

						file_put_contents("inc/config.php", $current);
						@unlink("sql.sql");

						header("Location: ./install.php?step=2");

					} else {
						echo error("MySQL database not exists.");
					}
				} else {
					echo error("Failed to connect to MySQL server.");
				}
		}
	}
	?>
	</span><!--END DESCRIPTION-->
    </div>

	<div class="content">
		<input name="mysql_host" type="text" class="input username" placeholder="MySQL Host" />
		<input name="mysql_user" type="text" class="input username" placeholder="MySQL Username" />
		<input name="mysql_pass" type="text" class="input username" placeholder="MySQL Password" />
		<input name="mysql_base" type="text" class="input username" placeholder="MySQL Database" />
	</div>

    <div class="footer">
		<input type="submit" name="next" value="Next" class="button" />
    </div>
</form>
<?php
}
?>

</div>
<!--END WRAPPER-->

<!--GRADIENT--><div class="gradient"></div><!--END GRADIENT-->

</body>
</html>
