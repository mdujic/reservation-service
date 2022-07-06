<?php

class CalendarController extends BaseController
{
    public function index()
    {
        $rs = new ReservationService();

		// Popuni template potrebnim podacima
		$this->registry->template->title = 'Kalendar Vaših obaveza';
		$this->registry->template->lecturesList = $rs->getAllReservationsForUser($_SESSION['username']);
        $this->registry->template->show( 'calendar_index' );
    }
};

?>