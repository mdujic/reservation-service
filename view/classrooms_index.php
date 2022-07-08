<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<?php 

	if($_SESSION['role'] === 'satnicar' || $_SESSION['role'] === 'djelatnik'){
		echo '<table>';
		echo '<tr>';
		echo 'Prizemlje:';
		sort($classroomsList);

		foreach( $classroomsList as $classroom )
		{
			if($classroom[0] === '0' || ($classroom[0] === 'A' && $classroom[1] === '0'))
				echo '<td><a href="' . __SITE_URL .
                  '/index.php?rt=classrooms/showById&id_classroom=' . $classroom . '">' 
                  . $classroom . '</a></td>';
		}
		echo '</tr>';
		echo '</table>';

		echo '<br/>';
	}
?>

	
<?php 
	if($_SESSION['role'] === 'satnicar' || $_SESSION['role'] === 'djelatnik'){
		echo 'Prvi kat:';
		echo '<table>';
		echo '<tr>';
		foreach( $classroomsList as $classroom )
		{
			if($classroom[0] === '1' || ($classroom[0] === 'A' && $classroom[1] === '1'))
				echo '<td><a href="' . __SITE_URL .
                  '/index.php?rt=classrooms/showById&id_classroom=' . $classroom . '">' 
                  . $classroom . '</a></td>';
		}
		echo '</tr>';
		echo '</table>';
		echo '</br>';
	}
?>

<?php
	if($_SESSION['role'] === 'satnicar' || $_SESSION['role'] === 'djelatnik'){
		echo 'Drugi kat'; 
		echo '<table>';
		echo '<tr>';
		foreach( $classroomsList as $classroom )
		{
			if($classroom[0] === '2' || ($classroom[0] === 'A' && $classroom[1] === '2'))
				echo '<td><a href="' . __SITE_URL .
	              '/index.php?rt=classrooms/showById&id_classroom=' . $classroom . '">' 
	              . $classroom . '</a></td>';
		}
		echo '</tr>';
		echo '<table>';
		echo '</br>';
	}
?>

<?php
	echo 'Praktikumi:'; 
	echo '<table>';
	echo '<tr>';
	foreach( $classroomsList as $classroom )
	{
		if($classroom[0] === 'P' && $classroom[1] === 'R')
			echo '<td><a href="' . __SITE_URL .
              '/index.php?rt=classrooms/showById&id_classroom=' . $classroom . '">' 
              . $classroom . '</a></td>';
	}
	echo '</tr>';
	echo '</table>';
?>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
