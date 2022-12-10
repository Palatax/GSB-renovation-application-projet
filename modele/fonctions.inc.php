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
        $erreurs[] = 'Veuillez saisir le motif autre';
    if($bilan == '')
        $erreurs[] = 'Vous devez rédiger un bilan';

    return $erreurs;
}
