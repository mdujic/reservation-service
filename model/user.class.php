<?php

class User
{
	protected $id, $name, $surname, $username, $password_hash, $email, $registration_sequence, $has_registered, $role;

	function __construct( $id, $name, $surname, $username, $password_hash, $email, $registration_sequence, $has_registered )
	{
		$this->id = $id;
		$this->name = $name;
		$this->surname = $surname;
		$this->username = $username;
		$this->password_hash = $password_hash;
		$this->email = $email;
        $this->registration_sequence = $registration_sequence;
        $this->has_registered = $has_registered;
		$this->role = $role;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>

