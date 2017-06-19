<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $web['web_name']; ?> Control Panel</title>
 
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $aurl; ?>css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="<?php echo $aurl; ?>css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $aurl; ?>css/font-awesome.css">
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
	<script src="<?php echo $aurl; ?>js/jquery.js"></script>
	<link rel="stylesheet" href="<?php echo $aurl; ?>cleditor/jquery.cleditor.css">
	<script src="<?php echo $aurl; ?>cleditor/jquery.cleditor.min.js"></script>
    <script src="<?php echo $aurl; ?>js/bootstrap.js"></script>
	<script type="text/javascript">
		$(document).ready(function () { $("#editor").cleditor(); });
	  </script>
  </head>

  <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $aurl; ?>"><?php echo $web['web_name']; ?> Control Panel</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="<?php echo $aurl; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo $aurl.'?m=new_post'; ?>"><i class="fa fa-plus"></i> New post</a></li>
			<li><a href="<?php echo $aurl.'?m=manage_posts'; ?>"><i class="fa fa-copy"></i> Manage posts</a></li>
			<li><a href="<?php echo $aurl.'?m=manage_categories'; ?>"><i class="fa fa-folder"></i> Manage categories</a></li>
			<li><a href="<?php echo $aurl.'?m=manage_archives'; ?>"><i class="fa fa-archive"></i> Manage archives</a></li>
			<li><a href="<?php echo $aurl.'?m=manage_comments'; ?>"><i class="fa fa-comments"></i> Manage comments</a></li>
			<li><a href="<?php echo $aurl.'?m=manage_users'; ?>"><i class="fa fa-users"></i> Manage users</a></li>
			<li><a href="<?php echo $aurl.'?m=blog_settings'; ?>"><i class="fa fa-cogs"></i> Blog settings</a></li>
			<li><a href="<?php echo $aurl.'?m=advertisements'; ?>"><i class="fa fa-globe"></i> Advertisements</a></li>
			<li><a href="<?php echo $aurl.'?m=stats'; ?>"><i class="fa fa-bar-chart-o"></i> Stats</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo idinfo($_SESSION['user_id'],"name"); ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $aurl.'?m=settings'; ?>"><i class="fa fa-gear"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo $aurl.'?m=logout'; ?>"><i class="fa fa-power-off"></i> Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <div id="page-wrapper">
