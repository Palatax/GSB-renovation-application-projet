<?php
require_once('controleur/c_controleur.php');
require_once('modele/medecin.modele.inc.php');

class MedecinControleur extends Controleur {

	public function __construct($action)
	{
		$this->medicamentModel = new Medicament();
		$this->action = $action;
	}


}