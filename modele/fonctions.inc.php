<?php



function getMotifLibelle($rapport)
{
    $motifNum = $rapport['MOTIF_NUM'];

    $motifNum != null ? 
        $motif = getMotif($motifNum) : 
        $motif = $rapport['RAP_MOTIF'];

    return $motif;
}