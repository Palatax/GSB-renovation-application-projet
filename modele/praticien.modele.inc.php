<?php

class Praticien extends Modele
{
    public function getAllNomPraticien() {
        $req = 'SELECT PRA_NUM, PRA_NOM, PRA_PRENOM FROM praticien ORDER BY PRA_PRENOM';
        $result = parent::getRequestResults($req, []);
        return $result;
    }
    
    public function getAllInformationPraticien($praticien) {
        $req = 'SELECT p.PRA_NOM as \'nom\', 
                       p.PRA_PRENOM as \'prenom\', 
                       p.PRA_ADRESSE as \'adresse\', 
                       p.PRA_CP as \'codePostal\', 
                       p.PRA_VILLE as \'ville\', 
                       p.PRA_COEFNOTORIETE as \'coefNot\', 
                       p.TYP_CODE as \'typeCode\', 
                       t.TYP_LIBELLE as \'typeLib\' 
                FROM praticien p 
                INNER JOIN type_praticien t 
                ON t.TYP_CODE = p.TYP_CODE 
                WHERE PRA_NUM = :PRA_NUM';

        $result = parent::getRequestResults($req, [
            ':PRA_NUM' => $praticien
        ]);

        return $result;
    }
    
    public function getAllNomPraticienCol($matricule)
    {
        $req = 'SELECT DISTINCT p.PRA_NUM, p.PRA_NOM, p.PRA_PRENOM
                FROM PRATICIEN p
                INNER JOIN RAPPORT_VISITE rp
                ON p.PRA_NUM = rp.PRA_NUM
                WHERE rp.COL_MATRICULE = :COL_MATRICULE';

        $results = parent::getRequestResults($req, [
            ':COL_MATRICULE' => $matricule
        ], 'fetchAll');
    
        return $results;
    }
    
    public function getPraticien($praNum)
    {
        $req = 'SELECT PRA_NOM,
                       PRA_PRENOM
                FROM praticien
                WHERE PRA_NUM = :PRA_NUM';

        $result = parent::getRequestResults($req, [
            ':PRA_NUM' => $praNum
        ]);

        return $result;
    }
}

/*public function getAllInformationPraticienNom($nom){
    $monPdo = connexionPDO();
    $req = 'SELECT m.MED_DEPOTLEGAL as \'depotlegal\', m.MED_NOMCOMMERCIAL as \'nomcom\', m.MED_COMPOSITION as \'compo\', m.MED_EFFETS as \'effet\', m.MED_CONTREINDIC as \'contreindic\', m.MED_PRIXECHANTILLON as \'prixechan\', f.FAM_LIBELLE as \'famille\' FROM medicament m INNER JOIN famille f ON f.FAM_CODE = m.FAM_CODE WHERE MED_NOMCOMMERCIAL = "'.$nom.'"';
    $res = $monPdo->query($req);
    $result = $res->fetch();    
    return $result;
}
*/
