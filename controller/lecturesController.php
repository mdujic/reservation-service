<?php 

class LecturesController extends BaseController
{
	public function index() 
	{
		// Kontroler koji prikazuje popis svih usera

		$rs = new ReservationService();

		// Popuni template potrebnim podacima
		$this->registry->template->title = 'Popis svih predavanja';
		$tmp = [];
		if($_SESSION['role'] === 'djelatnik')
			$tmp = $rs -> getLecturesOfProfessor($_SESSION['name'], $_SESSION['surname']);
		else if($_SESSION['role'] === 'satnicar')
			$tmp = $rs -> getAllLectures();
		$this->registry->template->lecturesList = $tmp;
        $this->registry->template->show( 'lectures_index' );
	}

	public function addLecture()
	{
		// Kontroler koji upisuje u raspored 
		$rs = new ReservationService();
		$termini = explode(",",$_GET['termini']);
		$user = null;
		if($_SESSION['role'] !== 'satnicar')
			$user = $rs -> getUserByUsername($_SESSION['username']);
		else{
			echo 'dobio sam ' . $_GET['sime'] . ' ' . $_GET['sprez'];
			$user = $rs -> getUserByUsername($_GET['sime'] . ' ' . $_GET['sprez']);
		}

		$lectures = [];
		$zapamtiTip = "";
		if(strlen($_GET['subject'])>= 0)
		{
			foreach($termini as $termin)
			{
				$find = FALSE;
				$parts = explode( '-', $termin );
				foreach($lectures as $lec)
				{
					$sat = explode( '-', $lec->sati );
					if($lec->dan == $parts[0] && ((int)$sat[0] == (int)$parts[1]+1 || (int)$sat[1] == (int)$parts[1]))
					{
						if((int)$sat[0] == (int)$parts[1]+1)
						{
							$lec->sati = $parts[1]."-".$sat[1];
							$razlika = (int)$sat[1] - (int)$parts[1];
							if($_GET['tip'] == "predavanja" || $_GET['tip'] == "vjezbe")
								$lec->vrsta = $razlika.$zapamtiTip;
							else
								$lec->vrsta = $zapamtiTip;
						}
						if((int)$sat[1] == (int)$parts[1])
						{
							$zavrsava = (int)$parts[1] + 1; 
							$lec->sati = $sat[0]."-".$zavrsava;
							$razlika = (int)$parts[1] + 1 - (int)$sat[0];
							if($_GET['tip'] == "predavanja" || $_GET['tip'] == "vjezbe")
								$lec->vrsta = $razlika.$zapamtiTip;
							else
								$lec->vrsta = $zapamtiTip;
						}
						$find = TRUE;
						break;
					}
				}
				if(!$find)
				{
					$broj = (int)$parts[1] + 1;
					$sati = $parts[1]."-".$broj;
					if($_GET['tip'] == "predavanja")
					{
						$tip = "1P";
						$zapamtiTip = "P";
					}
					else if($_GET['tip'] == "vjezbe")
					{
						$zapamtiTip = "V";
						$tip = "1V";
					}
					else if($_GET['tip'] == "dem")
					{
						$zapamtiTip = "dem";
						$tip = "dem";
					}
					else if($_GET['tip'] == "sem")
					{
						$zapamtiTip = "sem";
						$tip = "sem";
					}
					else
					{
						$zapamtiTip = "ost";
						$tip = "ost";
					}
					$datum = $_GET['datum'];
					
					$id = 1;
					$lecture = new Lecture($user->name, $user->surname, $_GET['subject'], $tip, $parts[0], $sati, $_GET['classroom'], $id, $datum);
					array_push($lectures, $lecture);
				}
			}
			foreach($lectures as $lec)
				$rs ->createReservation($lec);
		}
		header('Location: index.php?rt=classrooms/showById&id_classroom='.$_GET['classroom']);
		
	}

	public function removeLecture()
	{

		$classroom = $_GET['classroom'];
		$termini = explode(",",$_GET['termini']);
		foreach($termini as $termin)
		{
			$parts = explode( '-', $termin );
			$rs = new ReservationService();
			$rs -> deleteReservation($parts[0], $parts[1], $classroom);
		}

		header('Location: index.php?rt=classrooms/showById&id_classroom='.$_GET['classroom']);
	} 


}; 

?>