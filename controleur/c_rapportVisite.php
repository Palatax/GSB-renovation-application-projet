<?php

if(isset($_SESSION['login']))
{
    $action = $_REQUEST['action'];
    
    switch($action)
    {
        case 'redigerrapport' :
        {
            $matricule = $_SESSION['matricule'];
            $numRapport = getRapportNum($matricule);
            $motifs = getMotifs();
            $medicaments = getAllNomMedicament();
            $praticiens = getAllNomPraticien();
            $date = date('d/m/Y', time());

            echo $numRapport;
            
            include('vues/v_saisieRapport.php');
        }
        case 'mesrapports' :
        {

        }
        case 'rapportregion' :
        {

        }
    }
}
