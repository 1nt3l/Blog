<div id="loader">
	<h2><img src="<?php echo $url.'imgs/loader.gif'; ?>" width="30px"> Loading...</h2>
</div>
<h2><?php echo $lang['unsubscribe']; ?></h2>
<br>
 
<?php
$hash = protect($_GET['hash']);
$sql = mysql_query("SELECT * FROM blogger_subscribers WHERE hash='$hash'");
if(mysql_num_rows($sql)>0) {
	$row = mysql_fetch_array($sql);
	$msg = $lang[hello].', '.$row[email].'<br/>'.$lang[unsubscribe_success];
	echo success($msg);
	$delete = mysql_query("DELETE FROM blogger_subscribers WHERE hash='$hash'");
} else {
	echo error($lang['unsubscribe_error']);
}
?>
