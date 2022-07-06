<?php

require_once __SITE_PATH . '/vendor/autoload.php';

use myPHPnotes\Microsoft\Auth;
use myPHPnotes\Microsoft\Handlers\Session;
use myPHPnotes\Microsoft\Models\User;

class CallbackController extends BaseController
{
    public function index()
    {
        $auth = new Auth( Session::get("tenant_id"), Session::get("client_id"), 
            Session::get("client_secret"), Session::get("redirect_uri"), Session::get("scopes"));
        $tokens = $auth->getToken($_REQUEST['code']);
        $accessToken = $tokens->access_token;

        $auth->setAccessToken($accessToken);
        
        $user = new User;
        //echo "Name: " . $user->data->getDisplayName() . "<br>";
        //echo "Email: " . $user->data->getUserPrincipalName() . "<br>";
        
        $_SESSION['username'] = $user->data->getDisplayName();
        $_SESSION['name'] = $user->data->getGivenName();
		$_SESSION['surname'] = explode( " ", $_SESSION['username'])[1];
        $_SESSION['email'] = $user->data->getMail();
        $_SESSION['role'] = $user->data->getJobTitle();
        $this->addUser();
        $this->registry->template->title = 'You have successfully logged in.';
        $this->registry->template->show( 'logged_in' );
    }

    public function addUser()
    {
        $rs = new ReservationService();

        $user = $rs->getUserByUsername( $_SESSION['username'] );
            
        if( $user === null )
        {
            // u ovom slučaju password_hash i reg_seq se ne pamti
            $rs->makeNewUser( $_SESSION['username'], '', $_SESSION['email'], '', $_SESSION['role'], $_SESSION['name'], $_SESSION['surname'] );
        }
        
    }
    
}

?>