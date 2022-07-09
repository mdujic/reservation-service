<?php
require_once __DIR__ . '/lecture.class.php';
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
			return new User( $row['id'],$row['name'], $row['surname'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'], $row['role'] );
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
			return new User( $row['id'],$row['name'], $row['surname'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'], $row['role']  );
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
			$arr[] = new User( $row['id'],$row['name'], $row['surname'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'], $row['role']  );
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
			$arr[] = new Lecture( $row['ime_profesora'], $row['prezime_profesora'], $row['kolegij'], $row['vrsta'], $row['dan'], $row['sati'], $row['prostorija'], $row['id'], $row['datum'] );
		}

		return $arr;
	}

	function getLecturesOfProfessor($name, $surname){
		try{
			$db = DB::getConnection();
			$st = $db -> prepare( 'SELECT * FROM project_lectures where ime_profesora = :ime AND prezime_profesora = :prez' );
			$st->execute(array('ime' => $name, 'prez' => $surname));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while($row = $st->fetch())
		{
			$arr[] = new Lecture( $row['ime_profesora'], $row['prezime_profesora'], $row['kolegij'], $row['vrsta'], $row['dan'], $row['sati'], $row['prostorija'], $row['id'], $row['datum'] );
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
			$arr[] = new Lecture( $row['ime_profesora'], $row['prezime_profesora'], $row['kolegij'], $row['vrsta'], $row['dan'], $row['sati'], $row['prostorija'], $row['id'], $row['datum'] );
		}

		return $arr;
	}

	function createReservation($lecture)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO project_lectures(ime_profesora, prezime_profesora, kolegij, vrsta, dan, sati, prostorija, datum) VALUES (:ime, :prezime, :kolegij, :vrsta, :dan, :sati, :prostorija, :datum)' );
			if($lecture->datum === ""){
				$date = explode("/", date('d/m', time()));
				$today_day = date('w');
				$reservation_day = -1;
				$new_date = intval($date[0]);
				switch($lecture->dan){
					case 'PON':
						$reservation_day = 1;
						break;
					case 'UTO':
						$reservation_day = 2;
						break;
					case 'SRI':
						$reservation_day = 3;
						break;
					case 'ČET':
						$reservation_day = 4;
						break;
					case 'PET':
						$reservation_day = 5;
						break;
				}
				if ($reservation_day > $today_day) {
					$new_date += $reservation_day - $today_day;
				} else if ($today_day > $reservation_day){
					$new_date += 7-($today_day-$reservation_day);
				}
				$final = '';
				if ($new_date === intval($date[0])){
					$final = date('d.m', time());
				} else if ($new_date - 10 < 0) {
					$final = '0' . $new_date . "." . $date[1];
				}else {
					$final = $new_date . "." . $date[1];
				}
			} else {
				$final = $lecture->datum . ';';
			}
			#echo $final;
			$st->execute( array('ime' => $lecture->ime_profesora, 'prezime' =>$lecture->prezime_profesora ,'kolegij' => $lecture ->kolegij, 'vrsta' => $lecture -> vrsta, 'dan' => $lecture -> dan, 'sati' => $lecture -> sati, 'prostorija' => $lecture -> prostorija, 'datum' => $final) );
		}
		catch( PDOException $e ) {  exit( "PDO error [project_lectures]: " . $e->getMessage() ); }
	}

	function deleteReservation($day, $start, $classroom)
	{
		try
		{
			$db = DB::getConnection();
			$start = $start.'-';
			$st = $db->prepare( "DELETE FROM project_lectures WHERE prostorija=:pr AND dan=:d AND sati LIKE '$start%'" );

			$st->execute( array('pr' => $classroom, 'd' =>$day ) );
		}
		catch( PDOException $e ) {  exit( "PDO error [project_lectures]: " . $e->getMessage() ); }
	}

	function makeNewUser( $username, $password, $email, $reg_seq, $role, $name, $surname )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO project_users(username, password_hash, email, registration_sequence, has_registered, role, name, surname) VALUES ' .
								'(:username, :password_hash, :email, :registration_sequence, 0, :role, :name, :surname)' );
			
			$st->execute( array( 'username' => $username, 
								'password_hash' => password_hash( $password, PASSWORD_DEFAULT ), 
								'email' => $email, 
								'registration_sequence'  => $reg_seq,
								'role'  => $role,
								'name' => $name,
								'surname' => $surname ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
	}

	function getAllReservationsForUser( $username )
	{
		$user = $this->getUserByUsername($username);
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM project_lectures 
								 WHERE ime_profesora=:name AND prezime_profesora=:surname'
								  );
			$st->execute( array( 'name' => $user->name, 'surname' => $user->surname ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Lecture( $row['ime_profesora'], $row['prezime_profesora'], $row['kolegij'], $row['vrsta'], $row['dan'], $row['sati'], $row['prostorija'], $row['id'], $row['datum'] );
		}

		return $arr;
	}
};
#$rs = new ReservationService;
#$lecture = new Lecture("Matija", "Šantek", "Proba", "1P", "PON", "12-13", "PR2", "13333", "");
#$rs -> createReservation($lecture);

?>

