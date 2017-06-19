<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
	<?php
	if(protect($_GET['m']) == "post") {
		$id = protect($_GET['id']);
		$sql = mysql_query("SELECT * FROM blogger_posts WHERE id='$id'");
		if(mysql_num_rows($sql)>0) {
			$row = mysql_fetch_array($sql);
			echo $row['title']." - ".$web['web_name'];
		} else {
			echo $web['title'];
		}
	} else {
		echo $web['title'];
	}
	?>
	</title>
	<meta name="description" content="<?php echo $web['description']; ?>">
	<meta name="keywords" content="<?php echo $web['keywords']; ?>">
	<meta name="author" content="1nt3l">
	<!-- BOOTSTRAP -->
	<link type="text/css" href="<?php echo $url; ?>css/bootstrap.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic,500italic,500,300italic,300' rel='stylesheet' type='text/css'>
	<!-- <link href='http://fonts.googleapis.com/css?family=Droid+Sans:700|Roboto:400,400italic,700,700italic' rel='stylesheet' type='text/css'> -->
	<link href='http://fonts.googleapis.com/css?family=Mr+Dafoe' rel='stylesheet' type='text/css'>
	<!-- THEME -->
	<link type="text/css" href="<?php echo $url; ?>css/theme.css" rel="stylesheet">
	<link type="text/css" href="<?php echo $url; ?>css/font-awesome.css" rel="stylesheet">

	<!-- SCRIPTS: BASE -->
	<script src="<?php echo $url; ?>js/jquery.js"></script>
	<!-- SCRIPTS: IMPORT BOOTSTRAP JS -->
	<script src="<?php echo $url; ?>js/bootstrap.js"></script>
	<script src="<?php echo $url; ?>js/theme.js"></script>
	<script src="<?php echo $url; ?>js/custom.js"></script>
</head>
<body>
	<div class="section-headlines">
		<div class="container">
			<h1><a href="<?php echo $url; ?>" style="color:#000000;"><?php echo $web['web_name']; ?></a></h1>
			<div class="lead"><?php echo $web['web_description']; ?></div>
		</div>
	</div>

	<div class="container">
		<section class="section blog">
			<div class="row">
				<div class="col-lg-8">
