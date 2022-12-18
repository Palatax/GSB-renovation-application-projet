<?php

include_once 'bd.inc.php';

function getAllNomMedicament() {
    $monPdo = connexionPDO();
    $req = 'SELECT MED_DEPOTLEGAL, MED_NOMCOMMERCIAL FROM medicament ORDER BY MED_NOMCOMMERCIAL';
    $res = $monPdo->query($req);
    $result = $res->fetchAll();
    return $result;
}

function getNomMedicament($medDepotLegal)
{
    $monPdo = connexionPDO();
    $req = 'SELECT MED_NOMCOMMERCIAL
            FROM medicament
            WHERE MED_DEPOTLEGAL = :MED_DEPOTLEGAL';

    $res = $monPdo->prepare($req);
    $res->bindValue(':MED_DEPOTLEGAL', $medDepotLegal, PDO::PARAM_STR);
    $res->execute();

    $result = $res->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getAllInformationMedicamentDepot($depot) {
    $monPdo = connexionPDO();
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
            WHERE MED_DEPOTLEGAL = "'.$depot.'"';
            
    $res = $monPdo->query($req);
    $result = $res->fetch();    
    return $result;
}

function getAllInformationMedicamentNom($nom) {
    $monPdo = connexionPDO();
    $req = 'SELECT m.MED_DEPOTLEGAL as \'depotlegal\', m.MED_NOMCOMMERCIAL as \'nomcom\', m.MED_COMPOSITION as \'compo\', m.MED_EFFETS as \'effet\', m.MED_CONTREINDIC as \'contreindic\', m.MED_PRIXECHANTILLON as \'prixechan\', f.FAM_LIBELLE as \'famille\' FROM medicament m INNER JOIN famille f ON f.FAM_CODE = m.FAM_CODE WHERE MED_NOMCOMMERCIAL = "'.$nom.'"';
    $res = $monPdo->query($req);
    $result = $res->fetch();    
    return $result;
}

function getDepotMedoc($nom){
    $monPdo = connexionPDO();
    $req = 'SELECT MED_DEPOTLEGAL, MED_NOMCOMMERCIAL FROM medicament WHERE MED_DEPOTLEGAL = "'.$nom.'"';
    $res = $monPdo->query($req);
    $result = $res->fetch();    
    return $result;
}
    
function getNbMedicament(){
    $monPdo = connexionPDO();
    $req = 'SELECT COUNT(MED_DEPOTLEGAL) as \'nb\' FROM medicament';
    $res = $monPdo->query($req);
    $result = $res->fetch();    
    return $result;
}

function supprimerEchantillons($numRapport, $matricule)
{
    $monPdo = connexionPDO();
    
    $req = 'DELETE FROM offrir 
            WHERE RAP_NUM = :RAP_NUM 
            AND COL_MATRICULE = :COL_MATRICULE';
    
    $res = $monPdo->prepare($req);

    $res->bindValue(':RAP_NUM', $numRapport, PDO::PARAM_INT);
    $res->bindValue(':COL_MATRICULE', $matricule, PDO::PARAM_STR);

    $res->execute();
}

function insererEchantillons($numRapport, $tabEchantillons, $nbEchantillons, $matricule)
{
    for($i = 0; $i < count($tabEchantillons); $i++)
    {
        $monPdo = connexionPDO();

        $req = 'INSERT INTO offrir VALUES
                (:RAP_NUM, :MED_DEPOTLEGAL, :OFF_QTE, :COL_MATRICULE)';

        $res = $monPdo->prepare($req);

        $res->bindValue(':RAP_NUM', $numRapport);
        $res->bindValue(':MED_DEPOTLEGAL', $tabEchantillons[$i]);
        $res->bindValue(':OFF_QTE', $nbEchantillons[$i]);
        $res->bindValue(':COL_MATRICULE', $matricule);

        $res->execute();
    }
}

function getEchantillons($numRapport, $matricule)
{
    $monPdo = connexionPDO();

    $req = 'SELECT o.MED_DEPOTLEGAL, o.OFF_QTE, m.MED_NOMCOMMERCIAL
            FROM offrir o
            INNER JOIN medicament m
            ON o.MED_DEPOTLEGAL = m.MED_DEPOTLEGAL
            WHERE RAP_NUM = :RAP_NUM
            AND COL_MATRICULE = :COL_MATRICULE';
    
    $res = $monPdo->prepare($req);

    $res->bindValue(':RAP_NUM', $numRapport);
    $res->bindValue(':COL_MATRICULE', $matricule);

    $res->execute();

    $results = $res->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}