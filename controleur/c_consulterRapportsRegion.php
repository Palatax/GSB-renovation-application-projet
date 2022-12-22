<?php
require_once('controleur/c_rapport.php');

class consulterRapportsRegionControleur extends RapportControleur
{
    private $action;

    public function __construct($action)
    {
        $this->action = $action;
    }

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
    
    private function rapportRegion()
    {
    
    }
    
    private function confirmerRapportRegion()
    {
    
    }
}
