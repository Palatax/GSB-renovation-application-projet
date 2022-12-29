<?php

class Modele 
{
    private static $db = null;
    private $PDOConnexion;

    public function __construct()
    {
        if(self::$db == null)
            self::$db = $this->connexionBd();

        $this->PDOConnexion = self::$db;
    }

    private function connexionBd() 
    {
        include('modele/db-config.php');

        $conn = new PDO("mysql:host=$BDD_SERVEUR;port=3307;dbname=$BDD_NOM",$BDD_LOGIN,$BDD_MDP, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    protected function getRequestResults($request, $params, $forceFetchAll=null)
    {
        $res = $this->PDOConnexion->prepare($request);

        foreach($params as $name => $param)
        {
            $res->bindValue($name, $param);
        }

        $res->execute();

        if($forceFetchAll != null || $res->rowCount() > 1)
            $result = $res->fetchAll(PDO::FETCH_ASSOC);
        else
            $result = $res->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    protected function executeRequest($request, $params)
    {
        $res = $this->PDOConnexion->prepare($request);

        foreach($params as $name => $param)
        {
            $res->bindValue($name, $param);
        }

        $res->execute();
    }
}
