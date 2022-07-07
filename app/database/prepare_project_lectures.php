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

	$st->execute( array( 'tblname' => 'project_lectures' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;
}
catch( PDOException $e ) { exit( "PDO error [show tables]: " . $e->getMessage() ); }


if( $has_table )
{
	exit( 'Tablica project_lectures već postoji. Obrišite ju pa probajte ponovno.' );
}



try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS project_lectures (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'ime_profesora varchar(30) NOT NULL,' .
		'prezime_profesora varchar(30) NOT NULL,' .
		'kolegij varchar(200) NOT NULL,' .
		'vrsta varchar(10) NOT NULL,' .
		'dan varchar(3) NOT NULL,' .
		'sati varchar(5) NOT NULL,' .
		'prostorija varchar(5) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create project_lectures]: " . $e->getMessage() ); }

echo "Napravio tablicu dz2_projects.<br />";




// Ubaci neke projekte unutra (ovo nije baš pametno ovako raditi, preko hardcodiranih id-eva usera)
try
{
	$st = $db->prepare( 'INSERT INTO project_lectures(
		ime_profesora, prezime_profesora, kolegij, vrsta, dan, sati, prostorija) 
		VALUES (:ip, :pp, :k, :v, :d, :s, :p)' );

	if (($open = fopen( __DIR__ . '/../../data/nastavnici.csv', "r")) !== FALSE) 
	{
	    $first = True;
		while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
		{
            if(!$first){
			    $st->execute( array('ip' => $data[0], 
								    'pp' => $data[1], 
								    'k' => $data[2], 
								    'v' => $data[3], 
								    'd' => $data[4], 
								    's' => $data[5], 
								    'p' => $data[6]) );
            }
            $first = False;
		}
	
		fclose($open);
	}
}
catch( PDOException $e ) { exit( "PDO error [project_lectures]: " . $e->getMessage() ); }

echo "Ubacio u tablicu project_lectures.<br />";


?>
