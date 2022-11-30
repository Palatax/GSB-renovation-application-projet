<?php
	
include_once 'bd.inc.php';



	function recupererRapportsRegion() {

        try{
            $monPdo = connexionPDO();
            
            $req = '';

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