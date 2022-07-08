<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table>
	<tr>
	Prizemlje:
	<?php 
		sort($classroomsList);

		foreach( $classroomsList as $classroom )
		{
			if($classroom[0] === '0' || ($classroom[0] === 'A' && $classroom[1] === '0'))
				echo '<td><a href="' . __SITE_URL .
                  '/index.php?rt=classrooms/showById&id_classroom=' . $classroom . '">' 
                  . $classroom . '</a></td>';
		}
	?>
	</tr>
</table>

<br />
<table>
	<tr>
	Prvi kat:
	<?php 
		foreach( $classroomsList as $classroom )
		{
			if($classroom[0] === '1' || ($classroom[0] === 'A' && $classroom[1] === '1'))
				echo '<td><a href="' . __SITE_URL .
                  '/index.php?rt=classrooms/showById&id_classroom=' . $classroom . '">' 
                  . $classroom . '</a></td>';
		}
	?>
	</tr>
</table>

<br />
<table>
	<tr>
	Drugi kat:
	<?php 
		foreach( $classroomsList as $classroom )
		{
			if($classroom[0] === '2' || ($classroom[0] === 'A' && $classroom[1] === '2'))
				echo '<td><a href="' . __SITE_URL .
                  '/index.php?rt=classrooms/showById&id_classroom=' . $classroom . '">' 
                  . $classroom . '</a></td>';
		}
	?>
	</tr>
</table>

<br />
<table>
	<tr>
	Praktikumi:
	<?php 
		foreach( $classroomsList as $classroom )
		{
			if($classroom[0] === 'P' && $classroom[1] === 'R')
				echo '<td><a href="' . __SITE_URL .
                  '/index.php?rt=classrooms/showById&id_classroom=' . $classroom . '">' 
                  . $classroom . '</a></td>';
		}
	?>
	</tr>
</table>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
