<?php
	
include_once 'bd.inc.php';



	function recupererRapportsRegion() {

        try{
            $monPdo = connexionPDO();

            $req = 'SELECT RAP_NUM,RAP_BILAN,RAP_DATESAISIE,';

            $res = $monPdo->query($req);
            $result = $res->fetchAll();
            return $result;
        } 

        catch (PDOException $e){
            print "Erreur !: " . $e->getMessage();
            die();
        }


	} 


?>