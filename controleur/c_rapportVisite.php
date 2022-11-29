<?php

if(isset($_SESSION['login']))
{
    $action = $_REQUEST['action'];
    
    switch($action)
    {
        case 'choixRedaction':
        {
            if(count(getRapports()) > 1)
            {
                include('vues/v_choixRedaction.php');
            }
            else 
            {
                header('Location:index.php?uc=rapportdevisite&action=redigerrapport');
            }
        }
        case 'redigerrapport' :
        {
            $matricule = $_SESSION['matricule'];
            $numRapport = getRapportNum($matricule);
            $motifs = getMotifs();
            $medicaments = getAllNomMedicament();
            $praticiens = getAllNomPraticien();
            $date = date('Y-m-d', time());

            echo $numRapport;
            
            include('vues/v_saisieRapport.php');
        }
        case 'confirmerRapport':
        {

        }
        case 'modifierRapport':
        {
            
        }
        case 'mesrapports' :
        {

        }
        case 'rapportregion' :
        {

        }
    }
}
