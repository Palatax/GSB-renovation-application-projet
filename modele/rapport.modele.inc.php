<?php

include_once 'bd.inc.php';

function getMotifs()
{
    $monPdo = connexionPDO();
    $req = 'SELECT MOTIF_NUM, MOTIF_LIBELLE
            FROM motif';
    $res = $monPdo->query($req);
    $result = $res->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getRapports()
{
    $monPdo = connexionPDO();
    $req = 'SELECT RAP_NUM, 
                   RAP_DATE, 
                   RAP_BILAN, 
                   RAP_DATESAISIE, 
                   RAP_MOTIF,
                   PRA_NUM,
                   MOTIF_NUM,
                   COL_MATRICULE,
                   MEDICAMENT1,
                   MEDICAMENT2,
                   PRA_REMP
            FROM rapport_visite';

    $res = $monPdo->prepare($req);
    $res->execute();
    $result = $res->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getRapport($id, $matricule)
{
    $monPdo = connexionPDO();
    $req = 'SELECT RAP_DATE, 
                   RAP_BILAN, 
                   RAP_DATESAISIE, 
                   RAP_MOTIF,
                   PRA_NUM,
                   MOTIF_NUM,
                   MEDICAMENT1,
                   MEDICAMENT2,
                   PRA_REMP
            FROM rapport_visite
            WHERE RAP_NUM = :RAP_NUM
            AND COL_MATRICULE = :COL_MATRICULE';

    $res = $monPdo->prepare($req);
    $res->bindValue(':RAP_NUM', $id, PDO::PARAM_INT);
    $res->bindValue(':COL_MATRICULE', $matricule, PDO::PARAM_STR);

    $res->execute();
    $result = $res->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function getRapportsNonDef($matricule)
{
    $monPdo = connexionPDO();
    $req = 'SELECT RAP_NUM,
                   RAP_DATE, 
                   RAP_BILAN, 
                   RAP_DATESAISIE, 
                   RAP_MOTIF,
                   PRA_NUM,
                   MOTIF_NUM,
                   MEDICAMENT1,
                   MEDICAMENT2,
                   PRA_REMP
            FROM rapport_visite
            WHERE COL_MATRICULE = :COL_MATRICULE
            AND DEFINITIF = 0';

    $res = $monPdo->prepare($req);
    $res->bindValue(':COL_MATRICULE', $matricule, PDO::PARAM_STR);

    $res->execute();
    $result = $res->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getRapportNum($colMatricule)
{
    $monPdo = connexionPDO();
    $req = 'SELECT MAX(RAP_NUM)
            FROM rapport_visite
            WHERE COL_MATRICULE = :COL_MATRICULE';

    $res = $monPdo->prepare($req);
    $res->bindValue(':COL_MATRICULE', $colMatricule);
    $res->execute();

    $result = $res->fetch(PDO::FETCH_ASSOC);

    $rapNum = 0;

    if($result)
    {
        $rapNum = $result['MAX(RAP_NUM)'] + 1;
    }

    return $rapNum;
}

function ajouterRapport($numRapport, $matrCol, $dateVis, $praticien, $remplacant, $motif, $dateSaisie, $bilan, $medicament1, $medicament2, $definitif)
{
    $monPdo = connexionPDO();

    $req = 'INSERT INTO rapport_visite (
        RAP_NUM, 
        COL_MATRICULE, 
        RAP_DATE, 
        PRA_NUM, 
        MOTIF_NUM,
        PRA_REMP,
        RAP_DATESAISIE, 
        RAP_BILAN, 
        MEDICAMENT1,
        MEDICAMENT2,
        DEFINITIF
    ) VALUES 
    (
        :RAP_NUM, 
        :COL_MATRICULE, 
        :RAP_DATE, 
        :PRA_NUM,
        :PRA_REMP,
        :MOTIF_NUM,
        :RAP_DATESAISIE, 
        :RAP_BILAN, 
        :MEDICAMENT1,
        :MEDICAMENT2,
        :DEFINITIF
    )';

    $res = $monPdo->prepare($req);
    $res->bindValue(':RAP_NUM', $numRapport);
    $res->bindValue(':COL_MATRICULE', $matrCol);
    $res->bindValue(':RAP_DATE', $dateVis);
    $res->bindValue(':PRA_NUM', $praticien);
    $res->bindValue(':PRA_REMP', $remplacant);
    $res->bindValue(':MOTIF_NUM', $motif);
    $res->bindValue(':RAP_DATESAISIE', $dateSaisie);
    $res->bindValue(':RAP_BILAN', $bilan);
    $res->bindValue(':MEDICAMENT1', $medicament1);
    $res->bindValue(':MEDICAMENT2', $medicament2);
    $res->bindValue(':DEFINITIF', $definitif);

    $res->execute();
}

function modifierRapport($numRapport, $matrCol, $dateVis, $praticien, $remplacant, $motif, $dateSaisie, $bilan, $medicament1, $medicament2, $definitif)
{
    $monPdo = connexionPDO();

    $req = 'UPDATE rapport_visite
            SET RAP_DATE = :RAP_DATE,
                PRA_NUM = :PRA_NUM,
                PRA_REMP = :PRA_REMP,
                MOTIF_NUM = :MOTIF_NUM,
                RAP_DATESAISIE = :RAP_DATESAISIE,
                RAP_BILAN = :RAP_BILAN,
                MEDICAMENT1 = :MEDICAMENT1,
                MEDICAMENT2 = :MEDICAMENT2,
                DEFINITIF = :DEFINITIF
            WHERE RAP_NUM = :RAP_NUM
            AND COL_MATRICULE = :COL_MATRICULE';

    $res = $monPdo->prepare($req);

    $res->bindValue(':RAP_DATE', $dateVis);
    $res->bindValue(':PRA_NUM', $praticien);
    $res->bindValue(':PRA_REMP', $remplacant);
    $res->bindValue(':MOTIF_NUM', $motif);
    $res->bindValue(':RAP_DATESAISIE', $dateSaisie);
    $res->bindValue(':RAP_BILAN', $bilan);
    $res->bindValue(':MEDICAMENT1', $medicament1);
    $res->bindValue(':MEDICAMENT2', $medicament2);
    $res->bindValue(':DEFINITIF', $definitif);
    $res->bindValue(':RAP_NUM', $numRapport);
    $res->bindValue(':COL_MATRICULE', $matrCol);

    $res->execute();
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

    $req = 'SELECT MED_DEPOTLEGAL, OFF_QTE
            FROM offrir
            WHERE RAP_NUM = :RAP_NUM
            AND COL_MATRICULE = :COL_MATRICULE';
    
    $res = $monPdo->prepare($req);

    $res->bindValue(':RAP_NUM', $numRapport);
    $res->bindValue(':COL_MATRICULE', $matricule);

    $res->execute();

    $results = $res->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}