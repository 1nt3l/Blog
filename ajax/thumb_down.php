<?php
ob_start(); 
session_start();
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM blogger_settings ORDER BY id DESC LIMIT 1"));
include("../lang/language.php");
include("../inc/functions.php");
$post_id = protect($_GET['post_id']);
$user_ip = protect($_GET['user_ip']);

if(empty($post_id) or empty($user_ip)) { echo 'Hacking attempt!'; }
else {
	$sql = mysql_query("SELECT * FROM blogger_likes WHERE post_id='$post_id' and user_ip='$user_ip'");
	if(mysql_num_rows($sql)>0) {
		echo $lang['already_voted'];
	} else {
		$insert = mysql_query("INSERT blogger_likes (post_id,user_ip) VALUES ('$post_id','$user_ip')");
		$update = mysql_query("UPDATE blogger_posts SET thumbs_down=thumbs_down+1 WHERE id='$post_id'");
		echo $lang['thanks_vote'];
	}
}
?>
