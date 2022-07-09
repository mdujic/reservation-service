<?php 

class ClassroomsController extends BaseController
{
	public function index() 
	{
		// Kontroler koji prikazuje popis svih usera

		$rs = new ReservationService();

		// Popuni template potrebnim podacima
		$this->registry->template->title = 'Popis svih predavaona';
		$this->registry->template->classroomsList = $rs->getAllClassrooms();

        $this->registry->template->show( 'classrooms_index' );
	}

    public function showById(){

        if ( isset($_GET['id_classroom']) ){
            $rs = new ReservationService();
		    // Popuni template potrebnim podacima
		    $this->registry->template->title = $_GET['id_classroom'];
		    $this->registry->template->brojac = 0;
		    $this->registry->template->name = $_SESSION['name'];
		    $this->registry->template->surname = $_SESSION['surname'];


		    $lecturesList = $rs->getAllReservationsOfClassroom($_GET['id_classroom']);
            $toJavaScript = array();

            foreach ($lecturesList as $lecture){
                array_push($toJavaScript,
                    array(
                        'ime' => $lecture->ime_profesora,
                        'prezime' => $lecture->prezime_profesora,
                        'kolegij' => $lecture->kolegij,
                        'vrsta' => $lecture->vrsta,
                        'dan' => $lecture->dan,
                        'sati' => $lecture->sati,
                        'prostorija' => $lecture->prostorija
                )
                );
            }
            $this->registry->template->lectures = $toJavaScript;
            $this->registry->template->show( 'one_classroom_index' );
        }else {
            $this->index();
        }
    }


}; 

?>