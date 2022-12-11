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
            // Données à choisir dans le formulaire
            $motifs = getMotifs();
            $medicaments = getAllNomMedicament();
            $praticiens = getAllNomPraticien();

            // Données non choisies
            $matricule = $_SESSION['matricule'];
            $numRapport = $_POST['rapport'];
            
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

            $erreurs = getErreurs($praticien, $dateVisite, $dateSaisie, $motif, $motifAutre, $bilan);

            if(empty($erreurs))
            {
                ajouterRapport(
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
                    insererEchantillons($numRapport, $_POST['echantillonadd'], $_POST['nbEchantillon'], $matricule);
                }
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
            $motifAutre = $rapport['RAP_MOTIF'];
            
            if($dateSaisie == null) $dateSaisie = date('Y-m-d', time());

            $echantillons = getEchantillons($numRapport, $matricule);

            $url = 'index.php?uc=rapportdevisite&action=confirmerModification';

            include('vues/v_saisieRapport.php');

            break;
        }
        case 'confirmerModification':
        {
            // Données à choisir dans le formulaire
            $motifs = getMotifs();
            $medicaments = getAllNomMedicament();
            $praticiens = getAllNomPraticien();

            // Données non choisies
            $matricule = $_SESSION['matricule'];
            $numRapport = $_POST['rapport'];
            
            // Données obligatoires remplies
            $praticien = $_POST['praticien'];
            $dateSaisie = $_POST['dateSaisie'];
            $bilan = $_POST['bilan'];
            $dateVisite = $_POST['dateVisite'];
            $_POST['motifNormal'] != 'autre' && $_POST['motifNormal'] != '' ? $motif = $_POST['motifNormal'] : $motif = null;
            isset($_POST['motif-autre']) ? $motifAutre = $_POST['motif-autre'] : $motifAutre = null;

            // Données non obligatoires remplies
            $_POST['medicament1'] != '' ? $medicament1 = $_POST['medicament1'] : $medicament1 = null;
            isset($_POST['medicament2']) && $_POST['medicament2'] != 'default' ? $medicament2 = $_POST['medicament2'] : $medicament2 = null;
            isset($_POST['saisieDefinitive']) ? $saisieDefinitive = 1 : $saisieDefinitive = 0;
            $_POST['remplacant'] != '' ? $remplacant = $_POST['remplacant'] : $remplacant = null;

            $erreurs = getErreurs($praticien, $dateVisite, $dateSaisie, $motif, $motifAutre, $bilan);

            if(empty($erreurs))
            {
                modifierRapport(
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

                supprimerEchantillons($numRapport, $matricule);

                if(isset($_POST['echantillonadd']))
                {
                    insererEchantillons($numRapport, $_POST['echantillonadd'], $_POST['nbEchantillon'], $matricule);
                }
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