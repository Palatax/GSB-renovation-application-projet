<?php
require_once('controleur/c_rapport.php');

class ConsulterRapportsControleur extends RapportControleur
{
    private $action;

    public function __construct($action)
    {
        parent::__construct();

        $this->action = $action;
    }

    public function routeAction()
    {
        switch($this->action)
        {
            case 'mesrapports':
                $this->mesRapports();
                break;
            case 'consulterRapport':
                $this->consulterRapport();
                break;
        }
    }

    private function mesRapports()
    {
        $matricule = $_SESSION['matricule'];
        $praticiens = $this->praticienModele->getAllNomPraticienCol($matricule);

        var_dump($praticiens);
    
        isset($_POST['praticien']) && $_POST['praticien'] != '' ? $praticien = $_POST['praticien'] : $praticien = null;
        isset($_POST['dateDebut']) && $_POST['dateDebut'] != '' ? $dateDebut = $_POST['dateDebut'] : $dateDebut = null;
        isset($_POST['dateFin']) && $_POST['dateFin'] != '' ? $dateFin = $_POST['dateFin'] : $dateFin = null;
    
        // Récupération des rapports
        $rapports = $this->rapportModele->getRapports($matricule, $praticien, $dateDebut, $dateFin);
            
        include('vues/v_selectionRapports.php');
    
        if ($rapports)
            include('vues/v_listeRapports.php');
        else 
        {
            $erreurs[] = 'Aucun rapport trouvé';
            include('vues/v_afficherErreurs.php');
        }
    }
    
    private function consulterRapport()
    {
        $rapNum = $_GET['rapNum'];
        $matricule = $_SESSION['matricule'];
    
        $rapport = $this->rapportModele->getRapport($rapNum, $matricule);
        $motif = getMotifLibelle($rapport);
        $praticien = $this->praticienModele->getPraticien($rapport['PRA_NUM']);
    
        $rapport['MEDICAMENT1'] != null ? $medicament1 = $this->medicamentModele->getNomMedicament($rapport['MEDICAMENT1']) : $medicament1 = null;
        $rapport['MEDICAMENT2'] != null ? $medicament2 = $this->medicamentModele->getNomMedicament($rapport['MEDICAMENT2']) : $medicament2 = null;
    
        $echantillons = $this->medicamentModele->getEchantillons($rapNum, $matricule);
    
        include('vues/v_consulterRapport.php');
    }
}

