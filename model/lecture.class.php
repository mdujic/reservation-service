<?php

class Lecture
{
	protected $ime_profesora, $prezime_profesora, $kolegij, $vrsta, $dan, $sati, $prostorija;

	function __construct( $ime_profesora, $prezime_profesora, $kolegij, $vrsta, $dan, $sati, $prostorija )
	{
		$this->ime_profesora = $ime_profesora;
		$this->prezime_profesora = $prezime_profesora;
		$this->kolegij = $kolegij;
		$this->vrsta = $vrsta;
        $this->dan = $dan;
        $this->sati = $sati;
        $this->prostorija = $prostorija;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
