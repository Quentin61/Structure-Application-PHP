<?php

require_once("Models/DataBase.php");

/**
 * Class AbstractManager
 */
abstract class AbstractManager
{
    /**
     * @var DataBase instance de la base de données
     */
    protected $database;

    /**
     * AbstractManager constructor.
     */
    protected function __construct()
    {
        $this->database = DataBase::getBD(0);
    }

    /**
     * Fonction qui retourne toutes les données d'une table
     * @param $table String nom de la table dans la base de données
     * @param $entity String nom de l'entité à retourné
     * @return array retourne une liste d'entité
     */
    protected function _getAll(String $table, String $entity)
    {
        return $this->database->prepareRequest('SELECT * FROM '.$table,[], $entity);
    }
}