<?php

class Medicament extends Modele 
{
    public function getAllNomMedicament() {
        $req = 'SELECT MED_DEPOTLEGAL, MED_NOMCOMMERCIAL FROM medicament ORDER BY MED_NOMCOMMERCIAL';
        $result = parent::getRequestResults($req, array());

        return $result;
    }
    
    public function getNomMedicament($medDepotLegal)
    {
        $req = 'SELECT MED_NOMCOMMERCIAL
                FROM medicament
                WHERE MED_DEPOTLEGAL = :MED_DEPOTLEGAL';

        $result = parent::getRequestResults($req, [
            ':MED_DEPOTlEGAL' => $medDepotLegal
        ]);
    
        return $result;
    }
    
    public function getAllInformationMedicamentDepot($depot) {
        $req = 'SELECT m.MED_DEPOTLEGAL as \'depotlegal\', 
                       m.MED_NOMCOMMERCIAL as \'nomcom\', 
                       m.MED_COMPOSITION as \'compo\', 
                       m.MED_EFFETS as \'effet\', 
                       m.MED_CONTREINDIC as \'contreindic\', 
                       m.MED_PRIXECHANTILLON as \'prixechan\', 
                       f.FAM_LIBELLE as \'famille\' 
                FROM medicament m 
                INNER JOIN famille f 
                ON f.FAM_CODE = m.FAM_CODE 
                WHERE MED_DEPOTLEGAL = :MED_DEPOTLEGAL';
                
        $result = parent::getRequestResults($req, [
            ':MED_DEPOTLEGAL' => $depot
        ]);
        
        return $result;
    }
    
    public function getAllInformationMedicamentNom($nom) {
        $req = 'SELECT m.MED_DEPOTLEGAL as \'depotlegal\', 
                       m.MED_NOMCOMMERCIAL as \'nomcom\', 
                       m.MED_COMPOSITION as \'compo\', 
                       m.MED_EFFETS as \'effet\', 
                       m.MED_CONTREINDIC as \'contreindic\', 
                       m.MED_PRIXECHANTILLON as \'prixechan\', 
                       f.FAM_LIBELLE as \'famille\' 
                FROM medicament m 
                INNER JOIN famille f 
                ON f.FAM_CODE = m.FAM_CODE 
                WHERE MED_NOMCOMMERCIAL = :MED_NOMCOMMERCIAL';

        $result = parent::getRequestResults($req, [
            ':MED_NOMCOMMERCIAL' => $nom
        ]);
        return $result;
    }
    
    public function getDepotMedoc($nom){
        $req = 'SELECT MED_DEPOTLEGAL, MED_NOMCOMMERCIAL FROM medicament WHERE MED_DEPOTLEGAL = :MED_DEPOTLEGAL';
        
        $result = parent::getRequestResults($req, [
            ':MED_DEPOTLEGAL' => $nom
        ]); 

        return $result;
    }
        
    public function getNbMedicament(){
        $req = 'SELECT COUNT(MED_DEPOTLEGAL) as \'nb\' FROM medicament';
        $result = parent::getRequestResults($req, []);
        return $result;
    }
    
    public function supprimerEchantillons($numRapport, $matricule)
    {
        $req = 'DELETE FROM offrir 
                WHERE RAP_NUM = :RAP_NUM 
                AND COL_MATRICULE = :COL_MATRICULE';

        parent::executeRequest($req, [
            ':COL_MATRICULE' => $matricule,
            ':RAP_NUM' => $numRapport
        ]);
    }
    
    public function insererEchantillons($numRapport, $tabEchantillons, $nbEchantillons, $matricule)
    {
        for($i = 0; $i < count($tabEchantillons); $i++)
        {
            $req = 'INSERT INTO offrir VALUES
                    (:RAP_NUM, :MED_DEPOTLEGAL, :OFF_QTE, :COL_MATRICULE)';

            parent::executeRequest($req, [
                ':RAP_NUM' => $numRapport,
                ':MED_DEPOTLEGAL' => $tabEchantillons[$i],
                ':OFF_QTE' => $nbEchantillons[$i],
                ':COL_MATRICULE' => $matricule
            ]);
        }
    }
    
    public function getEchantillons($numRapport, $matricule)
    {
        $req = 'SELECT o.MED_DEPOTLEGAL, o.OFF_QTE, m.MED_NOMCOMMERCIAL
                FROM offrir o
                INNER JOIN medicament m
                ON o.MED_DEPOTLEGAL = m.MED_DEPOTLEGAL
                WHERE RAP_NUM = :RAP_NUM
                AND COL_MATRICULE = :COL_MATRICULE';

        $results = parent::getRequestResults($req, [
            ':RAP_NUM' => $numRapport,
            ':COL_MATRICULE' => $matricule
        ]);
    
        return $results;
    }
}
