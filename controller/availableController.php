<?php

class AvailableController extends BaseController
{
    public function index()
    {
        $rs = new ReservationService();
        $classroomsList = $rs->getAllClassrooms();
        $this->registry->template->classroomsList = $classroomsList;
        $reservationsArray = array();
        
        foreach($classroomsList as $classroom)
            array_push($reservationsArray, $rs->getAllReservationsOfClassroom($classroom));

        $this->registry->template->title = 'Dostupne predavaonice na Matematičkom odsjeku';
		$this->registry->template->reservationsArray = $reservationsArray;
        $this->registry->template->show( 'available_index' );
    }
}
?>