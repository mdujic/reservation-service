<?php

# TODO

# 1. pocetni dan i mjesec se unese preko terminala
# 2. napraviti sve ovo za zimski semestar (kod mjeseca ne moras uvijek 0 stavljat prije broja)
#    jer su mjeseci s dvije znamenke 

require_once __DIR__ . '/../model/reservationservice.class.php';
require_once __DIR__ . '/../app/database/db.class.php';

function stavi_u_bazu($arr, $id){
	try
	{
		$db = DB::getConnection();
		$st = $db->prepare( 'UPDATE project_lectures SET datum=:datum WHERE id=:id' );
	    $st->execute( array('datum' => $arr, 'id' =>$id ) );
	}
	catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	return true;
}


function setAllDates() {
	$rs = new ReservationService();
	$project_lectures = $rs -> getAllLectures();
	foreach($project_lectures as $lecture) {
		$datum = 'prazno';
		switch ($lecture->dan) {
			case 'PON':
				$datum = 7;
				break;
			case 'UTO':
				#echo "UTO ima";
				$datum = 8;
				break;
			case 'SRI':
				$datum = 9;
				break;
			case 'ČET':
				$datum = 10;
				break;
			case 'PET':
				$datum = 11;
				break;
		}
		$jos_jedan_dan = true;
		$mjesec = 3;
		$ukupan_unos = '';
		$praznik = false;
		for($i=0; $i < 15; ++$i){
			$dana_u_mjesecu = 30;
			if($i == 7) $praznik = true;
			else if ($i == 9) $praznik = false;
			if ($jos_jedan_dan) {
				$dana_u_mjesecu++;
			}
			if($datum > $dana_u_mjesecu) {
				$datum -= $dana_u_mjesecu;
				if($jos_jedan_dan){
					$jos_jedan_dan = false;
				} else {
					$jos_jedan_dan = true;
				}
				$mjesec++;
			}
			$vrijeme = '';
			if($datum - 10 < 0){
				$vrijeme='0';
			}
			$vrijeme .= $datum . '.0' . $mjesec . ";";
			if(!$praznik){
				$ukupan_unos .= $vrijeme;
			}
			$datum += 7;
		}
		print($ukupan_unos);
        if(!stavi_u_bazu($ukupan_unos, $lecture->id)){
            print("Doslo je do pogreske");
        }
	}


}

setAllDates()

?>