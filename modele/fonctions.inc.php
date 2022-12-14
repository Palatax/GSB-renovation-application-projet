<?php

function getErreurs($praticien, $dateVis, $dateSaisie, $motif, $motifAutre, $bilan)
{
    $erreurs = [];

    if($praticien == '')
        $erreurs[] = 'Vous devez choisir un praticien';
    if($dateVis == '')
        $erreurs[] = 'Vous devez choisir une date de visite';
    if($dateSaisie == '')
        $erreurs[] = 'Vous devez choisir une dateDeSaisie';
    if(($motif == '' || $motif == 'autre') && $motifAutre == '')
        $erreurs[] = 'Veuillez saisir un motif';
    if($bilan == '')
        $erreurs[] = 'Vous devez rédiger un bilan';

    return $erreurs;
}

function getMotifLibelle($rapport)
{
    $motifNum = $rapport['MOTIF_NUM'];

    $motifNum != null ? 
        $motif = getMotifLibelleFromNum($motifNum) : 
        $motif = $rapport['RAP_MOTIF'];

    return $motif;
}