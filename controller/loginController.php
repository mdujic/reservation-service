<?php 

class LoginController extends BaseController
{
	public function index() 
	{
		// Analizira $_POST iz forme za login

		$rs = new ReservationService();
		if( !isset( $_POST['username'] ) || !isset( $_POST['password'] ) )
		{
			$this->registry->template->title = 'Unesite korisničko ime i lozinku.';
			$this->registry->template->show( 'login_form' );
		}
		else if( !preg_match( '/^[a-zA-Z]{3,10}$/', $_POST['username'] ) )
		{
			$this->registry->template->title = 'Korisničko ime mora sadržavati od 3 do 10 znakova.';
			$this->registry->template->show( 'login_form' );
		}
		else
		{
			// Dakle dobro je korisničko ime. 
			// Provjeri taj korisnik postoji u bazi; dohvati njegove ostale podatke.
			$user = $rs->getUserByUsername( $_POST['username'] );
			if( $user === null )
			{
				$this->registry->template->title = 'Korisnik s ovim korisničkim imenom ne postoji.';
				$this->registry->template->show( 'login_form' );
			}
			else if( $user->has_registered === '0' )
			{
				$this->registry->template->title = 'Korisnik s ovim e-mailom nije registriran. Provjerite svoj e-mail.';
				$this->registry->template->show( 'login_form' );	
			}
			else if( !password_verify( $_POST['password'], $user->password_hash ) )
			{
				$this->registry->template->title = 'Netočna lozinka.';
				$this->registry->template->show( 'login_form' );
			}
			else
			{
				// Sad je valjda sve OK. Ulogiraj ga.
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['name'] = $user -> name;
				$_SESSION['surname'] = $user -> surname;
				$_SESSION['role'] = $user -> role;


				$this->registry->template->title = 'Uspješna prijava!';
				$this->registry->template->show( 'logged_in' );
			}
		}
	}

}; 

?>
