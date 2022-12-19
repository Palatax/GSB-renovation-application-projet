<?php
require_once('controleur/c_rapport.php');

class SaisirRapportControleur extends RapportControleur
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
            case 'choixRedaction':
                $this->choixRedaction();
                break;
            case 'redigerRapport':
                $this->redigerRapport();
                break;
            case 'confirmerRapport':
                $this->confirmerRapport();
                break;
            case 'modifierRapport':
                $this->modifierRapport();
                break;
            case 'confirmerModification':
                $this->confirmerModification();
                break;
            default:
                header('Location: index.php?uc=accueil');
                break;
        }
    }

    private function choixRedaction()
    {
        $rapports = parent::$rapportModele->getRapportsNonDef($_SESSION['matricule']);

        if(count($rapports) == 0)
            header('Location:index.php?uc=rapportdevisite&action=redigerrapport');

        include('vues/v_choixRedaction.php');
    }

    private function redigerRapport()
    {
        $this->getValeursNonChoisies($motifs, $medicaments, $praticiens, $matricule, $numRapport);

        $dateSaisie = date('Y-m-d', time());

        $url = 'index.php?uc=rapportdevisite&action=confirmerRapport';
        
        include('vues/v_saisieRapport.php');
    }

    private function confirmerRapport()
    {
        $this->getValeursNonChoisies($motifs, $medicaments, $praticiens, $matricule, $numRapport);

        $this->getValeursForm($praticien, $dateSaisie, $bilan, $dateVisite, $motif, $motifAutre, $medicament1, $medicament2, $saisieDefinitive, $remplacant);
    
        $erreurs = getErreurs($praticien, $dateVisite, $dateSaisie, $motif, $motifAutre, $bilan);

        if(empty($erreurs))
        {
            parent::$rapportModele->ajouterRapport(
                $numRapport, 
                $matricule, 
                $dateVisite, 
                $praticien,
                $remplacant,
                $motif,
                $motifAutre,
                $dateSaisie, 
                $bilan, 
                $medicament1,
                $medicament2,
                $saisieDefinitive
            );

            if(isset($_POST['echantillonadd']))
            {
                parent::$medicamentModele->insererEchantillons($numRapport, $_POST['echantillonadd'], $_POST['nbEchantillon'], $matricule);
            }
        }
        else 
        {
            $url = 'index.php?uc=rapportdevisite&action=confirmerRapport';
            
            include('vues/v_saisieRapport.php');
        }
    }
    
    private function modifierRapport()
    {
        if(!isset($_POST['rapport']))
            header('Location:index.php?uc=rapportdevisite&action=choixModifierRapport');

        $this->getValeursNonChoisies($motifs, $medicaments, $praticiens, $matricule, $numRapport);

        // Récupère les données depuis le rapport à modifier
        $rapport = parent::$rapportModele->getRapport($numRapport, $matricule);
        $dateSaisie = $rapport['RAP_DATESAISIE'];
        $bilan = $rapport['RAP_BILAN'];
        $dateVisite = $rapport['RAP_DATE'];
        $praticien = $rapport['PRA_NUM'];
        $medicament1 = $rapport['MEDICAMENT1'];
        $remplacant = $rapport['PRA_REMP'];
        $motif = $rapport['MOTIF_NUM'];
        $motifAutre = $rapport['RAP_MOTIF'];
            
        if($dateSaisie == null) $dateSaisie = date('Y-m-d', time());

        $echantillons = parent::$medicamentModele->getEchantillons($numRapport, $matricule);

        $url = 'index.php?uc=rapportdevisite&action=confirmerModification';

        include('vues/v_saisieRapport.php');
    }
    
    private function confirmerModification()
    {
        $this->getValeursNonChoisies($motifs, $medicaments, $praticiens, $matricule, $numRapport);
        $this->getValeursForm($praticien, $dateSaisie, $bilan, $dateVisite, $motif, $motifAutre, $medicament1, $medicament2, $saisieDefinitive, $remplacant);
    
        $erreurs = getErreurs($praticien, $dateVisite, $dateSaisie, $motif, $motifAutre, $bilan);

        if(empty($erreurs))
        {
            parent::$rapportModele->modifierRapport(
                $numRapport, 
                $matricule, 
                $dateVisite, 
                $praticien,
                $remplacant,
                $motif, 
                $motifAutre,
                $dateSaisie,
                $bilan, 
                $medicament1,
                $medicament2,
                $saisieDefinitive
            );

            parent::$medicamentModele->supprimerEchantillons($numRapport, $matricule);

            if(isset($_POST['echantillonadd']))
            {
                parent::$medicamentModele->insererEchantillons($numRapport, $_POST['echantillonadd'], $_POST['nbEchantillon'], $matricule);
            }
        }
        else 
        {
            $url = 'index.php?uc=rapportdevisite&action=confirmerModification';
            
            include('vues/v_saisieRapport.php');
        }
    }

    private function getValeursNonChoisies(&$motifs, &$medicaments, &$praticiens, &$matricule, &$numRapport)
    {
        // Données à choisir dans le formulaire
        $motifs = parent::$rapportModele->getMotifs();
        $medicaments = parent::$medicamentModele->getAllNomMedicament();
        $praticiens = parent::$praticienModele->getAllNomPraticien();

        // Données non choisies
        $matricule = $_SESSION['matricule'];
        $numRapport = $_POST['rapport'];
    }

    private function getValeursForm(&$praticien, &$dateSaisie, &$bilan, &$dateVisite, &$motif, &$motifAutre, &$medicament1, &$medicament2, &$saisieDefinitive, &$remplacant)
    {
        // Données obligatoires remplies
        $praticien = $_POST['praticien'];
        $dateSaisie = $_POST['dateSaisie'];
        $bilan = $_POST['bilan'];
        $dateVisite = $_POST['dateVisite'];
        $_POST['motifNormal'] != 'autre' && $_POST['motifNormal'] != '' ? $motif = $_POST['motifNormal'] : $motif = null;
        isset($_POST['motif-autre']) ? $motifAutre = $_POST['motif-autre'] : $motifAutre = null;

        // Données non obligatoires remplies
        $_POST['medicament1'] != '' ? $medicament1 = $_POST['medicament1'] : $medicament1 = null;
        isset($_POST['medicament2']) ? $medicament2 = $_POST['medicament2'] : $medicament2 = null;
        isset($_POST['saisieDefinitive']) ? $saisieDefinitive = 1 : $saisieDefinitive = 0;
        $_POST['remplacant'] != '' ? $remplacant = $_POST['remplacant'] : $remplacant = null;
    }
}
