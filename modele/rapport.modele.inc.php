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
                FROM rapport_visite
                WHERE COL_MATRICULE = :COL_MATRICULE';

        $res = $monPdo->prepare($req);
        $res->execute();
        $result = $res->fetchAll(PDO::FETCH_ASSOC);
var_dump($result);
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

function ajouterRapport()
{
    try
    {
        $monPdo = connexionPDO();

        $req = '';

        $res = $monPdo->prepare($req);
    }
    catch (PDOException $e)
    {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}
