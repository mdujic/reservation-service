<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Reservation Service</title>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.7.2/vue.min.js'></script>
	<script src='https://unpkg.com/v-calendar@2.4.1/lib/v-calendar.umd.min.js'></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/styleTable.css?v=<?php echo time(); ?>">
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
		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=logout">Logout</a></li>
	</ul>

	<h2><?php echo $title; ?></h2>
	
