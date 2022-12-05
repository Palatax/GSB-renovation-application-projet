<?php

if(isset($_SESSION['login']))
{
    $action = $_REQUEST['action'];
    
    switch($action)
    {
        case 'choixRedaction':
        {
            if(count(getRapports()) > 0)
            {
                include('vues/v_choixRedaction.php');
            }
            else 
            {
                header('Location:index.php?uc=rapportdevisite&action=redigerrapport');
            }

            break;
        }
        case 'redigerrapport' :
        {
            $matricule = $_SESSION['matricule'];
            $numRapport = getRapportNum($matricule);
            $motifs = getMotifs();
            $medicaments = getAllNomMedicament();
            $praticiens = getAllNomPraticien();
            $dateSaisie = date('Y-m-d', time());
            $dateVisite = '';
            $bilan = '';
            $praticien = '';
            $medicament1 = '';

            $url = 'index.php?uc=rapportdevisite&action=confirmerRapport';
            
            include('vues/v_saisieRapport.php');

            break;
        }
        case 'confirmerRapport':
        {
            $matricule = $_SESSION['matricule'];
            $numRapport = getRapportNum($matricule);
            $praticien = $_POST['praticien'];
            $dateSaisie = $_POST['dateSaisie'];
            $bilan = $_POST['bilan'];
            $dateVisite = $_POST['dateVisite'];
            $medicament1 = $_POST['medicament1'];
            $motif = $_POST['motifNormal'];
            $saisieDefinitive = 0;

            // Mise à null des valeurs non renseignées
            if($dateSaisie == '') { $dateSaisie = null; }
            if($dateVisite == '') { $dateVisite = null; }
            if($praticien == '') { $praticien = null; }
            if($medicament1 == '') { $medicament1 = null; }

            if(isset($_POST['saisieDefinitive']))
            {
                $saisieDefinitive = 1;
            }

            ajouterRapport(
                $numRapport, 
                $matricule, 
                $dateVisite, 
                $praticien, 
                $motif, 
                $dateSaisie, 
                $bilan, 
                $medicament1, 
                $saisieDefinitive
            );

            break;
        }
        case 'choixModifierRapport':
        {
            $rapports = getRapports();
            include('vues/v_choixRapport.php');

            break;
        }
        case 'modifierRapport':
        {
            if(!isset($_GET['id']))
                header('Location:index.php?uc=rapportdevisite&action=choixModifierRapport');

            // Récupération des données générales
            $numRapport = $_GET['id'];
            $matricule = $_SESSION['matricule'];
            $motifs = getMotifs();
            $medicaments = getAllNomMedicament();
            $praticiens = getAllNomPraticien();
            
            // Récupère les données depuis le rapport à modifier
            $rapport = getRapport($numRapport, $matricule);
            $dateSaisie = $rapport['RAP_DATESAISIE'];
            $bilan = $rapport['RAP_BILAN'];
            $dateVisite = $rapport['RAP_DATE'];
            $praticien = $rapport['PRA_NUM'];
            $medicament1 = $rapport['MEDICAMENT1'];
            
            if($dateSaisie == null) $dateSaisie = date('Y-m-d', time());

            $url = 'index.php?uc=rapportdevisite&action=confirmerModification';

            include('vues/v_saisieRapport.php');

            break;
        }
        case 'confirmerModification':
        {
            $matricule = $_SESSION['matricule'];
            $numRapport = getRapportNum($matricule) - 1;
            $praticien = $_POST['praticien'];
            $dateSaisie = $_POST['dateSaisie'];
            $bilan = $_POST['bilan'];
            $dateVisite = $_POST['dateVisite'];
            $medicament1 = $_POST['medicament1'];
            $motif = $_POST['motifNormal'];
            $saisieDefinitive = 0;
            
            // Mise à null des valeurs non renseignées
            if($dateSaisie == '') { $dateSaisie = null; }
            if($dateVisite == '') { $dateVisite = null; }
            if($praticien == '') { $praticien = null; }
            if($medicament1 == '') { $medicament1 = null; }
            
            if(isset($_POST['saisieDefinitive']))
            {
                $saisieDefinitive = 1;
            }

            modifierRapport(
                $numRapport, 
                $matricule, 
                $dateVisite, 
                $praticien, 
                $motif, 
                $dateSaisie,
                $bilan, 
                $medicament1, 
                $saisieDefinitive
            );
        }
        case 'mesrapports' :
        {
            break;
        }
        case 'rapportregion' :
        {
            break;
        }
    }
}
