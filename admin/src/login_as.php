<?php
$id = protect($_GET['id']);
$sql = mysql_query("SELECT * FROM blogger_users WHERE usern='$id'");
if(mysql_num_rows($sql)==0) { header("Location: $aurl"); }
$row = mysql_fetch_array($sql);
?>
<div class="row">
	<div class="col-lg-12">
		<h1>Login as <small><?php echo $row['usern']; ?></small></h1>

		<?php
		if(idinfo($_SESSION['user_id'],"sysadmin") == 1) {
			$_SESSION['usern'] = $row['usern'];
			$_SESSION['user_id'] = $row['id'];
			header("Location: ./?m=manage_users");
		} else {
			echo error("You don't have access to complete this function only System Administrator.");
		}
		?>
	</div>
</div>
