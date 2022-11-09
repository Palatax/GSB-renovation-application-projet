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