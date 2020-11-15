<?php

/**
 * Class DataBase
 */
class DataBase
{
    /**
     * @var DataBase instance de la classe
     */
    private static $db;

    /**
     * @var PDO instance de PDO
     */
    private $connexion;

    /**
     * DataBase constructor.
     * @param int $mod mode de connexion à une base de données (locale ou distante)
     */
    private function __construct($mod = 0)
    {
        try
        {
            $this->connexion = (($mod===0)?$this->getLocalBD():$this->getRemoteBD());
        }
        catch (PDOException $error)
        {
            echo $error->getMessage();
        }
    }

    /**
     * @return PDO retourne une instance de PDO pour une base de données locale
     */
    private function getLocalBD()
    {
        $db = "mysql:host=localhost;dbname=structure;charset=UTF8"; //nom de la base de données créée par default + SGBD par default
        $username = "root"; //identifiant par default de WAMP
        $password = ""; //mot de passe par default de WAMP
        return new PDO($db,$username,$password);
    }

    /**
     * @return PDO retourne une instance de PDO pour une base de données distante
     */
    private function getRemoteBD()
    {
        $db = "";
        $username = "";
        $password = "";
        return new PDO($db,$username,$password);
    }

    /**
     * Retourne une instance unique de la classe (singleton)
     * @param int $mod mode de connexion (0 = local, 1 = distant)
     * @return DataBase
     */
    public static function getBD($mod = 0)
    {
        if(!isset(self::$db))
            self::$db = new DataBase($mod);
        return self::$db;
    }

    /**
     * function qui permet de faire des requêtes préparées par injection
     * @param $request String requête SQL
     * @param $params array tableau des variables pour les requêtes préparées
     * @param null|string $createObject crée une entité passée en paramêtre
     * @param false|true $isCRUD indique si c'est une opération CRUD
     * @return array|bool retourne un tableau de données ou un tableau d'entités ou un boolean (si CRUD)
     */
    public function prepareRequest($request,$params,$createObject=null,$isCRUD = false)
    {
        $query = $this->connexion->prepare($request);
        $result = $query->execute($params);
        if(!$isCRUD) {
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $queryResult = null;
            if ($createObject)
                foreach ($results as $result)
                    $queryResult[] = new $createObject($result);
            else
                $queryResult = $results;
            return $queryResult;
        }
        else{
            return $result;
        }
    }
}

