<?php 

class UsersController extends BaseController
{
	public function index() 
	{
		// Kontroler koji prikazuje popis svih usera

		$rs = new ReservationService();

		// Popuni template potrebnim podacima
		$this->registry->template->title = 'Popis svih usera';
		$this->registry->template->userList = $rs->getAllUsers();

        $this->registry->template->show( 'users_index' );
	}


}; 

?>
