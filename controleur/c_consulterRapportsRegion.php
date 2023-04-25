<?php
require_once('controleur/c_rapport.php');

class consulterRapportsRegionControleur extends RapportControleur
{
    private $action;

    public function __construct($action)
    {

        parent::__construct();

        $this->action = $action;
    }


    #Gère les redirections
    public function routeAction()
    {
        switch($this->action)
        {
            case 'rapportRegion':
                $this->rapportRegion();
                break;
            case 'consulterRapportRegionLecture':
                $this->consulterRapportRegionLecture();
                break;
            case 'consulterRapportRegion':
                $this->consulterRapportRegion();
                break;
            case 'historiqueRapport':
                $this->historiqueRapport();
                break;
            default :
                include('vues/v_accueil.php');
        }
    }

    /**
     * Permet d'afficher la liste des rapports de visite de la région du délégué actuellement authentifié
     * @return void
     */
    private function rapportRegion()
    {
        if ($_SESSION['habilitation']==2) {
            
        //récupération du matricule du délégué connécté
        $matricule = $_SESSION['matricule'];

        //récupération des rapports via le matricule récupéré auparavant
        $rapports = $this->rapportModele->getRapportRegion($matricule);

        $rapports = $this->getPasLus($matricule,$rapports);
        foreach ($rapports as $rap)
        {
            $motifs[] = $this-> getMotifLibelle($rap);
            $praticiensRap[] = $this->praticienModele->getAllInformationPraticien($rap['PRA_NUM']);
        }

        include('vues/consulterRapport/v_listeRapports.php');
        }
        else {
            include('vues/v_accueil.php');
        }
    }
    


    /**
     * Permet d'afficher la page du rapport de visite sur lequel on a cliqué, tout en signalant à la base de donnés que le délégué authentifié à lu le rapport séléctioné 
     *
     * @return void
    */
    private function consulterRapportRegionLecture()
    {
        $rapNum = $_GET['rapNum'];
        $matricule = $_GET['matricule'];

        $rapport = $this->rapportModele->getRapport($rapNum, $matricule);
        $motif = $this->getMotifLibelle($rapport);
        $praticien = $this->praticienModele->getPraticien($rapport['PRA_NUM']);
        $rapport['MEDICAMENT1'] != null ? $medicament1 = $this->medicamentModele->getNomMedicament($rapport['MEDICAMENT1']) : $medicament1 = null;
        $rapport['MEDICAMENT2'] != null ? $medicament2 = $this->medicamentModele->getNomMedicament($rapport['MEDICAMENT2']) : $medicament2 = null;

        $echantillons = $this->medicamentModele->getEchantillons($rapNum, $matricule);
    
        $this->rapportModele->lire($_SESSION['matricule'],$matricule,$rapNum);

        include('vues/consulterRapport/v_consulterRapport.php');

    }




    /**
     * Permet d'afficher la page du rapport de visite sur lequel on a cliqué
     * @return void
    */
    private function consulterRapportRegion()
    {

       

        $rapNum = $_GET['rapNum'];
        $matricule = $_GET['matricule'];
    
        $rapport = $this->rapportModele->getRapport($rapNum, $matricule);
        var_dump($rapNum);
        var_dump($matricule);
        $motif = $this->getMotifLibelle($rapport);
        $praticien = $this->praticienModele->getPraticien($rapport['PRA_NUM']);
        $rapport['MEDICAMENT1'] != null ? $medicament1 = $this->medicamentModele->getNomMedicament($rapport['MEDICAMENT1']) : $medicament1 = null;
        $rapport['MEDICAMENT2'] != null ? $medicament2 = $this->medicamentModele->getNomMedicament($rapport['MEDICAMENT2']) : $medicament2 = null;

        $echantillons = $this->medicamentModele->getEchantillons($rapNum, $matricule);
    
        include('vues/consulterRapport/v_consulterRapport.php');
    }



    /**
     * Permet d'afficher la liste des rapports de visite de la région du délégué actuellelent authentifié
     *
     * @return void
     */
    private function historiqueRapport() 
    {
        $praticiens;
        $matricule = $_SESSION['matricule'];
        $praNum = $this->praticienModele->getPraticienRapportRegion($matricule);

        foreach ($praNum as $pra) {

            $praticiens[] = $this->praticienModele->getPraticien($pra['PRA_NUM']);
        }

        // Récupération des champs du formulaire de filtre
        $praticien = $_POST['praticien'] ?? null;
        $dateDebut = $_POST['dateDebut'] ?? null;
        $dateFin = $_POST['dateFin'] ?? null;

        // Récupération des rapports
        $rapports = $this->rapportModele->getRapportRegionFiltre($matricule, $praticien, $dateDebut, $dateFin);

        // Récupération des motifs et des praticiens de chaque rapport
        foreach ($rapports as $rap)
        {
            $motifs[] = $this->getMotifLibelle($rap);
            $praticiensRap[] = $this->praticienModele->getAllInformationPraticien($rap['PRA_NUM']);
        }
        include('vues/consulterRapport/v_selectionRapports.php');
        if ($rapports)
            include('vues/consulterRapport/v_listeRapports.php');
        else 
        {
            $erreurs[] = 'Aucun rapport trouvé';
            include('vues/v_afficherErreurs.php');
        }
    }

    /**
     *  Retourne un tableau des rapports de visite n'ayant pas été lus
     * @param $matricule matricule du lecteur des rapports à consulter
     * @param $listeRaps une liste de rapports à consulter 
     * @return $tab un tableau contenant les rapports qui n'ont pas été lus
     */
    private function getPasLus($matricule, $listeRaps) {



        $tab = array();

        foreach ($listeRaps as $key) {
            if(!$this->rapportModele->isRead($matricule,$key['COL_MATRICULE'] ,$key['RAP_NUM'])) {
                $tab[] = $key;
            }
        }
        return $tab;
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
