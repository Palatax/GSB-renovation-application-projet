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
            case 'confirmerRapportRegion':
                $this->confirmerRapportRegion();
                break;
        }
    }



    /**
     * Permet d'afficher la liste des rapports de visite de la région du délégué actuellement authentifié
     * @return void
     */
    private function rapportRegion()
    {
        $matricule = $_SESSION['matricule'];

        $rapports = $this->rapportModele->getRapportRegion($matricule);

        include('vues/consulterRapport/v_listeRapport.php');
    }
    
    private function confirmerRapportRegion()
    {
    
    }
}
