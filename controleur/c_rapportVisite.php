<?php

if(isset($_SESSION['login']))
{
    $action = $_REQUEST['action'];
    
    switch($action)
    {
        case 'choixRedaction':
        {
            $rapports = getRapportsNonDef($_SESSION['matricule']);

            if(count($rapports) == 0)
                header('Location:index.php?uc=rapportdevisite&action=redigerrapport');

            include('vues/v_choixRedaction.php');

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

            $url = 'index.php?uc=rapportdevisite&action=confirmerRapport';
            
            include('vues/v_saisieRapport.php');

            break;
        }
        case 'confirmerRapport':
        {
            $motifs = getMotifs();
            $medicaments = getAllNomMedicament();
            $praticiens = getAllNomPraticien();

            $matricule = $_SESSION['matricule'];
            $numRapport = getRapportNum($matricule);
            $praticien = $_POST['praticien'];
            $remplacant = $_POST['remplacant'];
            $dateSaisie = $_POST['dateSaisie'];
            $bilan = $_POST['bilan'];
            $dateVisite = $_POST['dateVisite'];
            $medicament1 = $_POST['medicament1'];
            $medicament2 = '';
            if(isset($_POST['medicament2'])) $medicament2 = $_POST['medicament2'];
            $motif = $_POST['motifNormal'];
            $motifAutre = '';
            if(isset($_POST['motif-autre'])) $motifAutre = $_POST['motif-autre'];
            $saisieDefinitive = 0;

            // Mise à null des valeurs non renseignées
            if($medicament1 == '') { $medicament1 = null; }

            if(isset($_POST['saisieDefinitive']))
            {
                $saisieDefinitive = 1;
            }

            $erreurs = getErreurs($praticien, $dateVisite, $dateSaisie, $motif, $motifAutre, $bilan);

            if(empty($erreurs))
            {
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
            }
            else 
            {
                $url = 'index.php?uc=rapportdevisite&action=confirmerRapport';
            
                include('vues/v_saisieRapport.php');
            }

            break;
        }
        case 'modifierRapport':
        {
            if(!isset($_POST['rapport']))
                header('Location:index.php?uc=rapportdevisite&action=choixModifierRapport');

            // Récupération des données générales
            $numRapport = $_POST['rapport'];
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
            $remplacant = $rapport['PRA_REMP'];
            $motif = $rapport['MOTIF_NUM'];
            
            if($dateSaisie == null) $dateSaisie = date('Y-m-d', time());

            $url = 'index.php?uc=rapportdevisite&action=confirmerModification';

            include('vues/v_saisieRapport.php');

            break;
        }
        case 'confirmerModification':
        {
            var_dump($_POST);

            $motifs = getMotifs();
            $medicaments = getAllNomMedicament();
            $praticiens = getAllNomPraticien();

            $matricule = $_SESSION['matricule'];
            $numRapport = getRapportNum($matricule) - 1;
            $praticien = $_POST['praticien'];
            $dateSaisie = $_POST['dateSaisie'];
            $bilan = $_POST['bilan'];
            $dateVisite = $_POST['dateVisite'];
            $medicament1 = $_POST['medicament1'];
            $medicament2 = '';
            if(isset($_POST['medicament2'])) $medicament2 = $_POST['medicament2'];
            $motif = $_POST['motifNormal'];
            $motifAutre = '';
            if(isset($_POST['motif-autre'])) $motifAutre = $_POST['motif-autre'];
            $saisieDefinitive = 0;
            
            // Mise à null des valeurs non renseignées
            if($medicament1 == '') { $medicament1 = null; }
            
            if(isset($_POST['saisieDefinitive']))
            {
                $saisieDefinitive = 1;
            }

            $erreurs = getErreurs($praticien, $dateVisite, $dateSaisie, $motif, $motifAutre, $bilan);

            if(empty($erreurs))
            {
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
            else 
            {
                $url = 'index.php?uc=rapportdevisite&action=confirmerModification';
            
                include('vues/v_saisieRapport.php');
            }
        }
        case 'mesrapports' :
        {
            break;
        }
        case 'rapportregion' :
        {
            include("vues/v_formulaireRapportRegion.php");
            break;
        }
        case 'confirmerRapportRegion':
        {
          include("vues/v_afficherRapportRegion.php");
          break;
        }
        default:
          header('Location: index.php?uc=accueil');
          break;
    }
}