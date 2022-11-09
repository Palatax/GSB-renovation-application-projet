<?php

if(isset($_SESSION['login']))
{
    $action = $_REQUEST['action'];
    
    switch($action)
    {
        case 'redigerrapport' :
        {
            $motifs = getMotifs();
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
