<?php
ob_start();
session_start(); 
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM blogger_settings ORDER BY id DESC LIMIT 1"));
include("../inc/functions.php");
$post_id = protect($_GET['post_id']);
$type = protect($_GET['type']);

if(empty($post_id) or empty($type)) { echo 'Hacking attempt!'; }
else {
	if($type == "up") {
		$sql = mysql_query("SELECT * FROM blogger_posts WHERE id='$post_id'");
		$row = mysql_fetch_array($sql);
		echo $row['thumbs_up'];
	} elseif($type == "down") {
		$sql = mysql_query("SELECT * FROM blogger_posts WHERE id='$post_id'");
		$row = mysql_fetch_array($sql);
		echo $row['thumbs_down'];
	} else {
		echo '0';
	}
}
?>
