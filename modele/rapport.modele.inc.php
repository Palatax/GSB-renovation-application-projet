<?php

include_once 'bd.inc.php';

function getMotifs()
{
    try
    {
        $monPdo = connexionPDO();
        $req = 'SELECT MOTIF_NUM, MOTIF_LIBELLE
                FROM motif';
        $res = $monPdo->query($req);
        $result = $res->fetchAll();
        return $result;
    }
    catch (PDOException $e)
    {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getRapports()
{
    try
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
    catch (PDOException $e)
    {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getRapport($id, $matricule)
{
    try
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
    catch (PDOException $e)
    {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getRapportNum($colMatricule)
{
    try
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
    catch (PDOException $e)
    {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function ajouterRapport($numRapport, $matrCol, $dateVis, $praticien, $motif, $dateSaisie, $bilan, $medicament1, $definitif)
{
    try
    {
        $monPdo = connexionPDO();

        $req = 'INSERT INTO rapport_visite (
            RAP_NUM, 
            COL_MATRICULE, 
            RAP_DATE, 
            PRA_NUM, 
            RAP_MOTIF,
            RAP_DATESAISIE, 
            RAP_BILAN, 
            MEDICAMENT1,
            DEFINITIF
        ) VALUES 
        (
            :RAP_NUM, 
            :COL_MATRICULE, 
            :RAP_DATE, 
            :PRA_NUM, 
            :RAP_MOTIF,
            :RAP_DATESAISIE, 
            :RAP_BILAN, 
            :MEDICAMENT1,
            :DEFINITIF
        )';

        $res = $monPdo->prepare($req);
        $res->bindValue(':RAP_NUM', $numRapport);
        $res->bindValue(':COL_MATRICULE', $matrCol);
        $res->bindValue(':RAP_DATE', $dateVis);
        $res->bindValue(':PRA_NUM', $praticien);
        $res->bindValue(':RAP_MOTIF', $motif);
        $res->bindValue(':RAP_DATESAISIE', $dateSaisie);
        $res->bindValue(':RAP_BILAN', $bilan);
        $res->bindValue(':MEDICAMENT1', $medicament1);
        $res->bindValue(':DEFINITIF', $definitif);

        $res->execute();
    }
    catch (PDOException $e)
    {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function modifierRapport($numRapport, $matrCol, $dateVis, $praticien, $motif, $dateSaisie, $bilan, $medicament1, $definitif)
{
    try
    {
        $monPdo = connexionPDO();

        $req = 'UPDATE rapport_visite
                SET RAP_DATE = :RAP_DATE,
                    PRA_NUM = :PRA_NUM,
                    RAP_MOTIF = :RAP_MOTIF,
                    RAP_DATESAISIE = :RAP_DATESAISIE,
                    RAP_BILAN = :RAP_BILAN,
                    MEDICAMENT1 = :MEDICAMENT1,
                    DEFINITIF = :DEFINITIF
                WHERE RAP_NUM = :RAP_NUM
                AND COL_MATRICULE = :COL_MATRICULE';

        $res = $monPdo->prepare($req);

        $res->bindValue(':RAP_DATE', $dateVis);
        $res->bindValue(':PRA_NUM', $praticien);
        $res->bindValue(':RAP_MOTIF', $motif);
        $res->bindValue(':RAP_DATESAISIE', $dateSaisie);
        $res->bindValue(':RAP_BILAN', $bilan);
        $res->bindValue(':MEDICAMENT1', $medicament1);
        $res->bindValue(':DEFINITIF', $definitif);
        $res->bindValue(':RAP_NUM', $numRapport);
        $res->bindValue(':COL_MATRICULE', $matrCol);

        var_dump($res);

        $res->execute();
    }
    catch (PDOException $e)
    {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}
