<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table>
	<?php 
		foreach( $lecturesList as $lecture )
		{
			echo '<tr>' .
			     '<td>' . $lecture->ime_profesora . ' ' . $lecture->prezime_profesora . 
                 '<br>' . $lecture->kolegij .
                 '<br>' . $lecture->vrsta .
                 '<br>' . $lecture->dan . 
                 '<br>' . $lecture->sati .
                 '<br>' . $lecture->prostorija . '</td>' .
			     '</tr>';
		}
	?>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
