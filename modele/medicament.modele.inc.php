<?php

include_once 'bd.inc.php';

function getAllNomMedicament() {
    $monPdo = connexionPDO();
    $req = 'SELECT MED_DEPOTLEGAL, MED_NOMCOMMERCIAL FROM medicament ORDER BY MED_NOMCOMMERCIAL';
    $res = $monPdo->query($req);
    $result = $res->fetchAll();
    return $result;
}

function getAllInformationMedicamentDepot($depot) {
    $monPdo = connexionPDO();
    $req = 'SELECT m.MED_DEPOTLEGAL as \'depotlegal\', m.MED_NOMCOMMERCIAL as \'nomcom\', m.MED_COMPOSITION as \'compo\', m.MED_EFFETS as \'effet\', m.MED_CONTREINDIC as \'contreindic\', m.MED_PRIXECHANTILLON as \'prixechan\', f.FAM_LIBELLE as \'famille\' FROM medicament m INNER JOIN famille f ON f.FAM_CODE = m.FAM_CODE WHERE MED_DEPOTLEGAL = "'.$depot.'"';
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