<?php

class ReservationService
{
	function getUserById( $id )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM project_users WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new User( $row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'] );
	}

    function getUserByUsername( $username )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM project_users WHERE username=:username' );
			$st->execute( array( 'username' => $username ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new User( $row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'] );
	}

	function getUserByRegSeq( $reg_seq )
	{
		// Nađi korisnika s tim nizom u bazi
        $db = DB::getConnection();

        try
        {
            $st = $db->prepare( 'SELECT * FROM project_users WHERE registration_sequence=:reg_seq' );
            $st->execute( array( 'reg_seq' => $reg_seq ) );
        }
        catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
		$row = $st->fetch();

        if( $st->rowCount() !== 1 )
            return false;
        else
        {
            // Sad znamo da je točno jedan takav. Postavi mu has_registered na 1.
            try
            {
                $st = $db->prepare( 'UPDATE project_users SET has_registered=1 WHERE registration_sequence=:reg_seq' );
                $st->execute( array( 'reg_seq' => $reg_seq ) );
            }
            catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

            return true;
        }
	}

	function getAllUsers( )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM project_users ORDER BY username' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new User( $row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'] );
		}

		return $arr;
	}

	function getAllLectures( )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM project_lectures' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Lecture( $row['ime_profesora'], $row['prezime_profesora'], $row['kolegij'], $row['vrsta'], $row['dan'], $row['sati'], $row['prostorija'] );
		}

		return $arr;
	}

	function getAllClassrooms( )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT DISTINCT prostorija FROM project_lectures' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] =  $row['prostorija'];
		}

		return $arr;
	}

	function getAllReservationsOfClassroom( $classroom_name)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM project_lectures WHERE prostorija=:prostorija_name' );
			$st->execute( array( 'prostorija_name' => $classroom_name ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Lecture( $row['ime_profesora'], $row['prezime_profesora'], $row['kolegij'], $row['vrsta'], $row['dan'], $row['sati'], $row['prostorija'] );
		}

		return $arr;
	}
};

?>

