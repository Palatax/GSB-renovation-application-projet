<?php
if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
	$action = "connexion";
} else {
	$action = $_REQUEST['action'];
}
switch ($action) {
	case 'formulairePraticien': {

			if (!isset($_SESSION['matricule'])) {
				header('location: index.php?uc=connexion&action=connexion');
			} else {
				$info = getAllInformationCompte($_SESSION['matricule']);





				include("vues/v_afficherPraticien.php");
			}
			break;
		}

	default: {
			header('location: index.php?uc=connexion&action=connexion');
			break;
		}
}
?>