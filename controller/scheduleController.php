<?php 

class ScheduleController extends BaseController
{
	public function index() 
	{
		$this->registry->template->show( 'schedule_index' );
    }

    public function addSchedule()
    {
        $rs = new ReservationService();
        $rs->importLectures($_FILES['myfile']['tmp_name']);
        $this->registry->template->show( 'schedule_index' );
    }

    public function removeSchedule()
    {
        $rs = new ReservationService();
        $rs->removeLectures();
        $this->registry->template->show( 'schedule_index' );
    }
}
?>