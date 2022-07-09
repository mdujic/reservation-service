<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Reservation Service</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
	<div style="padding: 1em;
    height: 5%;
    background-color: #43424d;
    overflow: hidden;
    color: white;">
		<h1 style="float:left">Reservation Service</h1>
		<h2 style="float:right">Hello, <?php echo $_SESSION['username']; ?>!</h2>
	</div>
	
	<ul>
		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=users">Users</a></li>
		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=lectures">Lectures</a></li>
		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=classrooms">Classrooms</a></li>
		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=available">Available</a></li>
		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=calendar">Calendar</a></li>
		<?php
			if($_SESSION['role'] == 'satnicar')
			?>
		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=schedule">New Schedule</a></li>	
			<?php
		?>
		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=logout">Logout</a></li>
		
	</ul>

	<h2><?php echo $title; ?></h2>
	
