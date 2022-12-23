<?php
require_once('controleur/c_controleur.php');
require_once('modele/medicament.modele.inc.php');

class MedicamentControleur extends Controleur
{
	private $medicamentModel;
	private $action;

	public function __construct($action)
	{
		$this->medicamentModel = new Medicament();
		$this->action = $action;
	}

	public function routeAction()
	{
		switch($this->action)
		{
			case 'formulairemedoc':
				$this->formulaireMedoc();
				break;
			case 'affichermedoc':
				$this->afficherMedoc($_REQUEST['medicament']);
				break;
			default:
				$this->formulaireMedoc();
				break;
		}
	}

	private function formulaireMedoc()
	{
		$result = $this->medicamentModel->getAllNomMedicament();

		$this->render('v_formulaireMedicament', [
			'result' => $result
		]);
	}

	private function afficherMedoc($medicament)
	{
		if ($medicament !== null)
			$carac = $this->medicamentModel->getAllInformationMedicamentDepot($medicament);

		if(!isset($carac)) 
		{
			$_SESSION['erreur'] = "medic-true";
			header("Location: index.php?uc=medicaments&action=formulairemedoc");
		}

		$this->render('v_afficherMedicament', [
			'carac' => $carac
		]);
	}
}
