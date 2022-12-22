<?php
session_start();

require_once('modele/Modele.php');

require_once('controleur/c_connexion.php');
require_once('controleur/c_medicaments.php');
require_once('controleur/c_praticien.php');
require_once('controleur/c_saisirRapport.php');
require_once('controleur/c_consulterRapports.php');
require_once('controleur/c_consulterRapportsRegion.php');

!isset($_GET['uc']) || empty($_GET['uc']) ? $uc = 'accueil' : $uc = $_GET['uc'];
!isset($_GET['action']) || empty($_GET['action']) ? $action = null : $action = $_GET['action'];

try 
{
    empty($_SESSION['login']) ? include('vues/v_headerDeconnexion.php') : include('vues/v_header.php');

    switch($uc)
    {
        case 'accueil':
        {   
            include("vues/v_accueil.php");
            break;
        }
        case 'medicaments' :
        {
            if(!empty($_SESSION['login'])){
                (new MedicamentControleur($action))->routeAction();
            }else{
                include("vues/v_accesInterdit.php");
            }
            break;
        }
        case 'praticien':
        {          
            if(!empty($_SESSION['login'])){
                (new PraticienControleur($action))->routeAction();
            }else{
                include("vues/v_accesInterdit.php");
            }
            break;

        }
        case 'connexion' :
        {
            (new ConnexionControleur($action))->routeAction();
            break; 
        }
        
        case 'saisirRapport' :
        {
            if(!empty($_SESSION['login'])){
                (new SaisirRapportControleur($action))->routeAction();
            }else{
                include("vues/v_accesInterdit.php");
            }
            break;
        }

        case 'consulterRapports' :
        {
            if(!empty($_SESSION['login'])){
                (new ConsulterRapportsControleur($action))->routeAction();
            }else{
                include("vues/v_accesInterdit.php");
            }
            break;
        }

        case 'consulterRapportsRegionControleur' :
        {
            if(!empty($_SESSION['login'])){
                (new consulterRapportsRegionControleur($action))->routeAction();
            }else{
                include("vues/v_accesInterdit.php");
            }
            break;
        }

        default :
        {
            include("vues/v_accueil.php");
            break;
        }
    }

    include("vues/v_footer.php") ;

}
catch(PDOException $e)
{
    print "Erreur : " . $e->getMessage();
    die();
}
