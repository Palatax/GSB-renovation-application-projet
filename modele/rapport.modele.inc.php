<?php

class Rapport extends Modele 
{
    public function getMotifs()
    {
        $req = 'SELECT MOTIF_NUM, MOTIF_LIBELLE
                FROM motif';

        $results = parent::getRequestResults($req, []);
        return $results;
    }
    
    public function getRapport($rapNum, $matricule)
    {
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

        $result = parent::getRequestResults($req, [
            ':RAP_NUM' => $rapNum,
            ':COL_MATRICULE' => $matricule
        ]);
    
        return $result;
    }
    
    public function getRapportsNonDef($matricule)
    {
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

        $result = parent::getRequestResults($req, [
            ':COL_MATRICULE' => $matricule
        ], 'fetchAll');

        return $result;
    }
    
    public function getRapportNum($colMatricule)
    {
        $req = 'SELECT MAX(RAP_NUM)
                FROM rapport_visite
                WHERE COL_MATRICULE = :COL_MATRICULE';

        $result = parent::getRequestResults($req, [
            ':COL_MATRICULE' => $colMatricule
        ]);

        $result && $result['MAX(RAP_NUM)'] !== null ? $rapNum = $result['MAX(RAP_NUM)'] + 1 : $rapNum = 1;
    
        return $rapNum;
    }
    
    public function ajouterRapport($numRapport, $matrCol, $dateVis, $praticien, $remplacant, $motif, $motifAutre, $dateSaisie, $bilan, $medicament1, $medicament2, $definitif)
    {
        $req = 'INSERT INTO rapport_visite (
            RAP_NUM, 
            COL_MATRICULE, 
            RAP_DATE, 
            PRA_NUM, 
            MOTIF_NUM,
            RAP_MOTIF,
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
            :MOTIF_NUM,
            :RAP_MOTIF,
            :PRA_REMP,
            :RAP_DATESAISIE, 
            :RAP_BILAN, 
            :MEDICAMENT1,
            :MEDICAMENT2,
            :DEFINITIF
        )';

        parent::executeRequest($req, [
            ':RAP_NUM' => $numRapport,
            ':COL_MATRICULE' => $matrCol,
            ':RAP_DATE' => $dateVis,
            ':PRA_NUM' => $praticien,
            ':MOTIF_NUM' => $motif,
            ':RAP_MOTIF' => $motifAutre,
            ':PRA_REMP' => $remplacant,
            ':RAP_DATESAISIE' => $dateSaisie,
            ':RAP_BILAN' => $bilan,
            ':MEDICAMENT1' => $medicament1,
            ':MEDICAMENT2' => $medicament2,
            ':DEFINITIF' => $definitif
        ]);
    }
    
    public function modifierRapport($numRapport, $matrCol, $dateVis, $praticien, $remplacant, $motif, $motifAutre, $dateSaisie, $bilan, $medicament1, $medicament2, $definitif)
    {
        $req = 'UPDATE rapport_visite
                SET RAP_DATE = :RAP_DATE,
                    PRA_NUM = :PRA_NUM,
                    PRA_REMP = :PRA_REMP,
                    MOTIF_NUM = :MOTIF_NUM,
                    RAP_MOTIF = :RAP_MOTIF,
                    RAP_DATESAISIE = :RAP_DATESAISIE,
                    RAP_BILAN = :RAP_BILAN,
                    MEDICAMENT1 = :MEDICAMENT1,
                    MEDICAMENT2 = :MEDICAMENT2,
                    DEFINITIF = :DEFINITIF
                WHERE RAP_NUM = :RAP_NUM
                AND COL_MATRICULE = :COL_MATRICULE';

        parent::executeRequest($req, [
            ':RAP_DATE' => $dateVis,
            ':PRA_NUM' => $praticien,
            ':PRA_REMP' => $remplacant,
            ':MOTIF_NUM' => $motif,
            ':RAP_MOTIF' => $motifAutre,
            ':RAP_DATESAISIE' => $dateSaisie,
            ':RAP_BILAN' => $bilan,
            ':MEDICAMENT1' => $medicament1,
            ':MEDICAMENT2' => $medicament2,
            ':DEFINITIF' => $definitif,
            ':RAP_NUM' => $numRapport,
            ':COL_MATRICULE' => $matrCol
        ]);
    }
    
    public function getRapports($matrCol, $pranum, $dateDebut, $dateFin)
    {
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
                WHERE COL_MATRICULE = :COL_MATRICULE ';
    
        $params = [':COL_MATRICULE' => $matrCol];

        // Sélectionne uniquement les rapports concernant un praticien ou un interval si précisé
        if ($pranum != null)
        {
            $req .= 'AND PRA_NUM = :PRA_NUM ';
            $params[':PRA_NUM'] = $pranum;
        }

        // Sélectionne uniquement les rapports dans un interval de date si précisé
        if ($dateDebut != null && $dateFin != null)
        {
            $req .= ' AND RAP_DATE >= :DATE_DEBUT AND RAP_DATE <= :DATE_FIN';
            $params[':DATE_DEBUT'] = $dateDebut;
            $params[':DATE_FIN'] = $dateFin;
        }

        $results = parent::getRequestResults($req, $params, 'fetchAll');
        return $results;
    }
    
    public function getMotif($motifNum)
    {
        $req = 'SELECT MOTIF_LIBELLE
                FROM motif
                WHERE MOTIF_NUM = :MOTIF_NUM';

        $motif = parent::getRequestResults($req, [
            ':MOTIF_NUM' => $motifNum
        ]);
    
        $result = $motif['MOTIF_LIBELLE'];
    
        return $result;
    }
    public function getRapportRegion($matricule) 
    {
        $req =  'SELECT r.RAP_NUM, r.COL_MATRICULE, r.MOTIF_NUM, r.RAP_MOTIF,r.RAP_DATE, r.PRA_NUM, r.DEFINITIF FROM rapport_visite r
    WHERE r.col_matricule in (
        SELECT col_matricule FROM travailler t WHERE reg_code=(
            SELECT reg_code FROM travailler WHERE col_matricule= :COL_MATRICULE and tra_role="Délégué"
            ) AND tra_role="Visiteur" AND r.DEFINITIF!=0
        )';

        $result = parent::getRequestResults($req, [
            ':COL_MATRICULE' => $matricule
        ],'fetchAll');

        return $result;
    }
}