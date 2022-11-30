<?php
if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
	$action = "connexion";
} else {
	$action = $_REQUEST['action'];
}

switch ($action) {
	case 'rapportRegion':

		$result



		include("vues/v_formulaireRapportRegion.php");
		break;

	case 'confirmerRapportRegion':
	{
		include("vues/v_afficherRapportRegion.php");
		break;
	}	

	default:
		header('Location: index.php?uc=accueil');
		break;
}
?>

