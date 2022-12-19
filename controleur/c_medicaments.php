<?php
class MedicamentController
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
				$this->afficherMedoc();
				break;
			default:
				$this->formulaireMedoc();
				break;
		}
	}

	public function formulaireMedoc()
	{
		$result = $this->medicamentModel->getAllNomMedicament();
		include('vues/v_formulaireMedicament.php');
	}

	public function afficherMedoc($medicament)
	{
		if ($medicament !== null)
			$carac = $this->medicamentModel->getAllInformationMedicamentDepot($medicament);

		if(!isset($carac)) 
		{
			$_SESSION['erreur'] = "medic-true";
			header("Location: index.php?uc=medicaments&action=formulairemedoc");
		}

		if (empty($carac[7]))
			$carac[7] = 'Non défini(e)';

		include('vues/v_afficherMedicament.php');
	}
}
