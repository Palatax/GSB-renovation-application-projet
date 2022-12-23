<?php
require_once('modele/praticien.modele.inc.php');

class PraticienControleur
{
	private $praticienModele;
	private $action;

	public function __construct($action)
	{
		$this->praticienModele = new Praticien();
		$this->action = $action;
	}

	public function routeAction()
	{
		switch($this->action)
		{
			case 'formulairePraticien':
				$this->formulairePraticien();
				break;
			case 'afficherPraticien':
				$this->afficherPraticien();
				break;
			default:
				$this->formulairePraticien();
				break;
		}
	}

	private function formulairePraticien()
	{
		$result = $this->praticienModele->getAllNomPraticien();
		include('vues/v_formulairePraticien.php');
	}

	private function afficherPraticien()
	{
		isset($_REQUEST['praticien']) ? $pra = $_REQUEST['praticien'] : $pra = null;

		if($pra === null || !$this->praticienModele->getAllInformationPraticien($pra))
		{
			$_SESSION['erreur'] = 'prati-true';
			header('Location:index.php?uc=praticien&action=formulairePraticien');
		}

		$carac = $this->praticienModele->getAllInformationPraticien($pra);
		
		if (empty($carac[7])) {
			$carac[7] = 'Non défini(e)';
		}
		include("vues/v_afficherPraticien.php");

	}
}