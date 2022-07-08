<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Rezervacije prostorija (PMF - MO)</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/styleTable.css?v=<?php echo time(); ?>">
</head>
<body>
	<div style="padding: 1em;
    height: 5%;
    background-color: #43424d;
    overflow: hidden;
    color: white;">
		<h1 style="float:left">Rezervacije prostorija (PMF - MO)</h1>
		<h2 style="float:right">Pozdrav, <?php echo $_SESSION['username']; ?>!</h2>
	</div>
	
	<ul>
		<?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'satnicar')
			echo '<li><a href="' . __SITE_URL . '/index.php?rt=users">Korisnici</a></li>';
		?>
		<?php if(isset($_SESSION['role']) && ($_SESSION['role'] === 'satnicar' || $_SESSION['role'] === 'djelatnik'))
			echo '<li><a href="' . __SITE_URL . '/index.php?rt=lectures">Kolegiji</a></li>';
		?>
		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=classrooms">Rasporedi po prostorijama</a></li>
		<?php 
			$avail = array('demos', 'gl_demos', 'djelatnik', 'satnicar');
			if(isset($_SESSION['role']) && in_array($_SESSION['role'], $avail))
				echo '<li><a href="' . __SITE_URL . '/index.php?rt=available">Dostupne prostorije</a></li>';
		?>
		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=calendar">Kalendar</a></li>
		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=logout">Odjava</a></li>
	</ul>
	
	<h2><?php echo $title; ?></h2>
	
