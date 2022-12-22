<?php

Class Connexion extends Modele 
{
    public function getAllInformationCompte($matricule)
    {
        $req = 'SELECT c.`COL_MATRICULE` as `matricule`,
                       c.`COL_NOM` as `nom`,
                       c.`COL_PRENOM` as `prenom`,
                       c.`COL_ADRESSE` as `adresse`,
                       c.`COL_CP` as `cp`,
                       c.`COL_VILLE` as `ville`, 
                       concat(DAY(COL_DATEEMBAUCHE),\'/\',MONTH(`COL_DATEEMBAUCHE`),\'/\',YEAR(`COL_DATEEMBAUCHE`)) as `date_embauche`, 
                       h.HAB_LIB as `habilitation` ,
                       s.SEC_LIBELLE as `secteur`, 
                       r.REG_NOM as `region` 
                FROM collaborateur c 
                LEFT JOIN secteur s 
                ON s.`SEC_CODE`=c.`SEC_CODE` 
                LEFT JOIN habilitation h 
                ON h.HAB_ID=c.HAB_ID 
                LEFT JOIN travailler t
                ON c.COL_MATRICULE=t.COL_MATRICULE
                LEFT JOIN region r 
                ON r.REG_CODE=t.REG_CODE 
                WHERE c.COL_MATRICULE = :COL_MATRICULE';
    
        $result = parent::getRequestResults($req, [
            'COL_MATRICULE' => $matricule
        ]);
    
        return $result;
    }
    
    public function checkConnexion($username, $mdp)
    {
        $req = 'SELECT l.LOG_ID as \'id_log\', 
                       l.COL_MATRICULE as \'matricule\', 
                       c.HAB_ID as \'habilitation\' 
                FROM login l 
                INNER JOIN collaborateur c 
                ON l.COL_MATRICULE = c.COL_MATRICULE 
                WHERE l.LOG_LOGIN = :identifiant 
                AND l.LOG_MOTDEPASSE = :LOG_MOTDEPASSE';

        $result = parent::getRequestResults($req, [
            ':identifiant' => $username,
            ':LOG_MOTDEPASSE' => hash('sha512', $mdp)
        ]);
    
        return $result;
    }
    
    public function checkMatriculeInscription($matricule)
    {
        $req = 'SELECT `COL_MATRICULE` as \'matricule\' 
                FROM login 
                WHERE `COL_MATRICULE`=:matricule';

        $result = parent::getRequestResults($req, [
            ':matricule' => $matricule
        ]);
    
        return $result;
    }
    
    public function checkMatricule($matricule)
    {
        $req = 'SELECT `COL_MATRICULE` as \'matricule\' 
                FROM collaborateur 
                WHERE `COL_MATRICULE` = :matricule';

        $result = parent::getRequestResults($req, [
            ':matricule' => $matricule
        ]);
    
        return $result;
    }
    
    public function checkUserInscription($username)
    {
        $req = 'SELECT `LOG_LOGIN` 
                FROM login 
                WHERE `LOG_LOGIN` = :username';

        $result = parent::getRequestResults($req, [
            ':username' => $username
        ]);
    
        return $result;
    }
    
    public function getAllMatriculeCollaborateur()
    {
        $req = 'SELECT COL_MATRICULE 
                FROM collaborateur 
                ORDER BY COL_MATRICULE';

        $result = parent::getRequestResults($req, []);
    
        return $result;
    }
    
    public function getColMatricule()
    {
        $req = 'SELECT COL_MATRICULE 
                FROM collaborateur 
                ORDER BY COL_MATRICULE';

        $result = parent::getRequestResults($req, []);
    
        return $result;
    }
    
    public function getCountMatricule()
    {
        $req = 'SELECT COUNT(COL_MATRICULE) as \'nb\' 
                FROM collaborateur';

        $result = parent::getRequestResults($req, []);
    
        return $result;
    }
}
