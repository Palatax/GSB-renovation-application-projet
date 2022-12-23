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

    /**
     * Permet d'afficher la liste des rapports de visite du visiteur actuellement authentifié
     * @return void
     */
    private function mesRapports()
    {
        $matricule = $_SESSION['matricule'];
        $praticiens = $this->praticienModele->getAllNomPraticienCol($matricule);
    
        // Récupération des champs du formulaire de filtre
        $praticien = $_POST['praticien'] ?? null;
        $dateDebut = $_POST['dateDebut'] ?? null;
        $dateFin = $_POST['dateFin'] ?? null;

        // Récupération des rapports
        $rapports = $this->rapportModele->getRapports($matricule, $praticien, $dateDebut, $dateFin);

        // Récupération des motifs et des praticiens de chaque rapport
        foreach ($rapports as $rap)
        {
            $motifs[] = $this->getMotifLibelle($rap);
            $praticiensRap[] = $this->praticienModele->getAllInformationPraticien($rap['RAP_NUM']);
        }

        include('vues/consulterRapport/v_selectionRapports.php');
    
        if ($rapports)
            include('vues/consulterRapport/v_listeRapports.php');
        else 
        {
            $erreurs[] = 'Aucun rapport trouvé';
            include('vues/consulterRapport/v_afficherErreurs.php');
        }
    }
    
    /**
     * Permet d'afficher toutes les informations concernant un rapport de la liste
     * @return void
     */
    private function consulterRapport()
    {
        $rapNum = $_GET['rapNum'];
        $matricule = $_SESSION['matricule'];
    
        $rapport = $this->rapportModele->getRapport($rapNum, $matricule);
        $motif = $this->getMotifLibelle($rapport);
        $praticien = $this->praticienModele->getPraticien($rapport['PRA_NUM']);
        $rapport['MEDICAMENT1'] != null ? $medicament1 = $this->medicamentModele->getNomMedicament($rapport['MEDICAMENT1']) : $medicament1 = null;
        $rapport['MEDICAMENT2'] != null ? $medicament2 = $this->medicamentModele->getNomMedicament($rapport['MEDICAMENT2']) : $medicament2 = null;

        $echantillons = $this->medicamentModele->getEchantillons($rapNum, $matricule);
    
        include('vues/consulterRapport/v_consulterRapport.php');
    }

    /**
     * Retourne le libellé du motif d'un rapport
     * @param mixed $rapport le rapport dont on veut le motif
     * @return mixed $motif le libellé du motif du rapport
     */
    private function getMotifLibelle($rapport)
    {
        $motifNum = $rapport['MOTIF_NUM'];

        $motifNum != null ? 
            $motif = $this->rapportModele->getMotif($motifNum) : 
            $motif = $rapport['RAP_MOTIF'];

        return $motif;
    }
}

