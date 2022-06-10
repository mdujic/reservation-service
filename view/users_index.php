<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table>
	<tr><th>Users</th></tr>
	<?php 
		foreach( $userList as $user )
		{
			echo '<tr>' .
			     '<td>' . $user->username . '<br>' . $user->email . '</td>' .
			     '</tr>';
		}
	?>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
