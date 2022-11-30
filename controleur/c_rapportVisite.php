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
            $date = date('Y-m-d', time());
            
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

            if($dateSaisie == '')
            {
                $dateSaisie = null;
            }
            if($dateVisite == '')
            {
                $dateVisite = null;
            }
            if($praticien == '')
            {
                $praticien = null;
            }
            if($medicament1 == '')
            {
                $medicament1 = null;
            }

            if(isset($_POST['saisieDefinitive']))
            {
                $saisieDefinitive = 1;
            }

            var_dump($medicament1);

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
        case 'modifierRapport':
        {
            break;
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
