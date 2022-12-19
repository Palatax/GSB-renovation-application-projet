<?php
require_once('modele/connexion.modele.inc.php');

Class ConnexionControleur
{
	private $connexionModel;
	private $action;

	public function __construct($action)
	{
		$this->connexionModel = new Connexion();
		$this->action = $action;
	}
	
	public function routeAction()
	{
		switch($this->action)
		{
			case 'connexion':
				$this->connexion();
				break;
			case 'confirmerConnexion':
				$this->confirmerConnexion();
				break;
			case 'deconnexion':
				$this->deconnexion();
				break;
			case 'profil':
				$this->profil();
				break;
			default:
				$this->connexion();
				break;
		}
	}

	private function connexion()
	{
		isset($_SESSION['login']) ? $login = $_SESSION['login'] : $login = null;

		$login !== null ? $this->profil() : include('vues/v_connexion.php');
	}

	private function confirmerConnexion()
	{
		$erreurs = [];

		// On vérifie que les champs de nom d'utilisateur et de mot de passe soient remplis
		if (!isset($_POST['username']) || $_POST['username'] === '')
			$erreurs[] = 'Veuillez saisir votre identifiant !';
		if (!isset($_POST['password']) || $_POST['password'] === '')
			$erreurs[] = 'Veuillez saisir votre mot de passe !';

		// On récupère les informations correspondant à l'utilisateur
		if(empty($erreurs))
			$user = $this->connexionModel->checkConnexion($_POST['username'], $_POST['password']);

		// Si les informations sont incorrects, on ajoute un message d'erreur
		if (empty($user)) 
            $erreurs[] = "Informations incorrectes !";

		// S'il y a des erreurs, on affiche de nouveau le formulaire de connexion
		if ($erreurs)
			include('vues/v_connexion.php');
		else 
		{
			// On enregistre en session les informations de l'utilisateur
			$_SESSION['habilitation'] = $user['habilitation'];
			$_SESSION['login'] = $user['id_log'];
			$_SESSION['matricule'] = $user['matricule'];
			$_SESSION['erreur'] = false;
	
			// On affiche sa page de profil
			header('Location: index.php?uc=connexion&action=profil');
		}
	}

	private function deconnexion()
	{
		session_destroy();
		header('Location:index.php?uc=accueil');
	}

	private function profil()
	{
		!isset($_SESSION['matricule']) ? header('Location:index.php?uc=connexion&action=connexion') : $matricule = $_SESSION['matricule'];

		$info = $this->connexionModel->getAllInformationCompte($matricule);
		$_SESSION['region'] = $info['region'];

		for ($i = 7; $i <= 8; $i++) {
			if (empty($info[$i])) {
				$info[$i] = 'Non défini(e)';
			}
		}

		include("vues/v_profil.php");
	}
}