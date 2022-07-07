<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table>
	<?php 

		foreach( $classroomsList as $classroom )
		{
			echo '<tr>' .
                 '<td><a href="' . __SITE_URL .
                  '/index.php?rt=classrooms/showById&id_classroom=' . $classroom . '">' 
                  . $classroom . '</a></td>' .
			     '</tr>';
		}
	?>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
