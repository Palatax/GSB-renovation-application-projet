<?php
	
include_once 'bd.inc.php';


    function getAllNomPraticien(){

        try{
            $monPdo = connexionPDO();
            $req = 'SELECT PRA_NUM, PRA_NOM, PRA_PRENOM FROM praticien ORDER BY PRA_PRENOM';
            $res = $monPdo->query($req);
            $result = $res->fetchAll();
            return $result;
        } 

        catch (PDOException $e){
            print "Erreur !: " . $e->getMessage();
            die();
        }
    }
   function getAllInformationPraticien($depot){

        try{
            $monPdo = connexionPDO();
            $req = 'SELECT p.PRA_NUM, p.PRA_NOM as \'nom\', p.PRA_PRENOM as \'prenom\', p.PRA_ADRESSE as \'adresse\', p.PRA_CP as \'codePostal\', p.PRA_VILLE as \'ville\', p.PRA_COEFNOTORIETE as \'coefNot\', p.TYP_CODE as \'typeCode\', t.TYP_LIBELLE as \'typeLib\' FROM praticien p INNER JOIN type_praticien t ON t.TYP_CODE = p.TYP_CODE;';
            $res = $monPdo->query($req);
            $result = $res->fetch();    
            return $result;
        } 
    
        catch (PDOException $e){
            print "Erreur !: " . $e->getMessage();
            die();
        }
    }
   /* function getAllInformationPraticienNom($nom){

        try{
            $monPdo = connexionPDO();
            $req = 'SELECT m.MED_DEPOTLEGAL as \'depotlegal\', m.MED_NOMCOMMERCIAL as \'nomcom\', m.MED_COMPOSITION as \'compo\', m.MED_EFFETS as \'effet\', m.MED_CONTREINDIC as \'contreindic\', m.MED_PRIXECHANTILLON as \'prixechan\', f.FAM_LIBELLE as \'famille\' FROM medicament m INNER JOIN famille f ON f.FAM_CODE = m.FAM_CODE WHERE MED_NOMCOMMERCIAL = "'.$nom.'"';
            $res = $monPdo->query($req);
            $result = $res->fetch();    
            return $result;
        } 
    
        catch (PDOException $e){
            print "Erreur !: " . $e->getMessage();
            die();
        }
    }
*/
?>