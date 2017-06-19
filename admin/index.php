<?php
ob_start();
session_start();
if(file_exists("../install.php")) {
	header("Location: ../install.php");
}  
include("../inc/config.php");
// get web settings
$web = mysql_fetch_array(mysql_query("SELECT * FROM blogger_settings ORDER BY id DESC LIMIT 1"));
$url = $web['url'];
$aurl = $web['url']."admin/";
include("../inc/functions.php");

if(!$_SESSION['usern']) {
	include("src/login.php");
} else {
$m = protect($_GET['m']);
include("src/header.php");
switch($m) {
		case "new_post": include("src/new_post.php"); break;
		case "new_category": include("src/new_category.php"); break;
		case "new_user": include("src/new_user.php"); break;
		case "login_as": include("src/login_as.php"); break;
		case "manage_posts": include("src/manage_posts.php"); break;
		case "manage_categories": include("src/manage_categories.php"); break;
		case "manage_archives": include("src/manage_archives.php"); break;
		case "manage_comments": include("src/manage_comments.php"); break;
		case "manage_users": include("src/manage_users.php"); break;
		case "blog_settings": include("src/blog_settings.php"); break;
		case "advertisements": include("src/advertisements.php"); break;
		case "stats": include("src/stats.php"); break;
		case "settings": include("src/settings.php"); break;
		case "edit": include("src/edit.php"); break;
		case "delete": include("src/delete.php"); break;
		case "approve": include("src/approve.php"); break;
		case "logout":
			unset($_SESSION['usern']);
			unset($_SESSION['user_id']);
			session_unset();
			session_destroy();
			header("Location: ./");
			break;
		default: include("src/home.php");
}
include("src/footer.php");
}
?>
