<?php 

class LecturesController extends BaseController
{
	public function index() 
	{
		// Kontroler koji prikazuje popis svih usera

		$rs = new ReservationService();

		// Popuni template potrebnim podacima
		$this->registry->template->title = 'Popis svih predavanja';
		$this->registry->template->lecturesList = $rs->getAllLectures();

        $this->registry->template->show( 'lectures_index' );
	}

	public function addLecture()
	{
		
	}


}; 

?>