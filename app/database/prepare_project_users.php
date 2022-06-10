<?php

// Manualno inicijaliziramo bazu ako već nije.
require_once 'db.class.php';

$db = DB::getConnection();

$has_table = false;

try
{
	$st = $db->prepare(
		'SHOW TABLES LIKE :tblname'
	);

	$st->execute( array( 'tblname' => 'project_users' ) );
	if( $st->rowCount() > 0 )
		$has_table = true;
}
catch( PDOException $e ) { exit( "PDO error [show tables]: " . $e->getMessage() ); }


if( $has_table )
{
	exit( 'Tablica project_users već postoji. Obrišite ju pa probajte ponovno.' );
}


try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS project_users (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'username varchar(50) NOT NULL,' .
		'password_hash varchar(255) NOT NULL,'.
		'email varchar(50) NOT NULL,' .
		'registration_sequence varchar(20) NOT NULL,' .
		'has_registered int)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create project_users]: " . $e->getMessage() ); }

echo "Napravio tablicu project_users.<br />";


// Ubaci neke korisnike unutra
try
{
	$st = $db->prepare( 'INSERT INTO project_users(username, password_hash, email, registration_sequence, has_registered) VALUES (:username, :password, \'a@b.com\', \'abc\', \'1\')' );

	$st->execute( array( 'username' => 'matijas', 'password' => password_hash( '1234', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'username' => 'matijaz', 'password' => password_hash( '1234', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'username' => 'mateo', 'password' => password_hash( '1234', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'username' => 'jurica', 'password' => password_hash( '1234', PASSWORD_DEFAULT ) ) );
}
catch( PDOException $e ) { exit( "PDO error [insert project_users]: " . $e->getMessage() ); }

echo "Ubacio u tablicu project_users.<br />";
?>
