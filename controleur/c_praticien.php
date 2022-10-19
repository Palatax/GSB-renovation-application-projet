<?php
if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
	$action = "connexion";
} else {
	$action = $_REQUEST['action'];
}
switch ($action) {
	case 'formulairePraticien': {

			$result = getAllNomPraticien();
			include("vues/v_formulairePraticien.php");
			break;
		}
	
	case 'afficherPraticien': {
		if (isset($_REQUEST['praticien']) && getAllInformationPraticien($_REQUEST['praticien'])) {
			$pra = $_REQUEST['praticien'];
			$carac = getAllInformationPraticien($pra);
			if (empty($carac[7])) {
				$carac[7] = 'Non défini(e)';
			}
			include("vues/v_afficherPraticien.php");
		} else {
			$_SESSION['erreur'] = true;
			header("Location: index.php?uc=praticien&action=formulairePraticien");
		}
		break;
	}

	default: {

			header('Location: index.php?uc=praticien&action=formulairePraticien');
			break;
		}
}
?>