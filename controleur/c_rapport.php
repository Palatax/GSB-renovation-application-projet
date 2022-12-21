<?php
require_once('controleur/c_controleur.php');
require_once('modele/rapport.modele.inc.php');
require_once('modele/medicament.modele.inc.php');
require_once('modele/praticien.modele.inc.php');

class RapportControleur extends Controleur
{
    protected $rapportModele;
    protected $medicamentModele;
    protected $praticienModele;

    public function __construct()
    {
        $this->rapportModele = new Rapport();
        $this->medicamentModele = new Medicament();
        $this->praticienModele = new Praticien();
    }
}