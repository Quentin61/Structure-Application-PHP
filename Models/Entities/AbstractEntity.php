<?php


/**
 * Class AbstractEntity
 * Classe dont hérite toutes les entités
 */
abstract class AbstractEntity
{
    /**
     * AbstractEntity constructor.
     * Attribue une valeur aux variables de classe en fonction du nom des varibles de la classe et des noms des clés associées
     * @param array $data tableau de données récupérer de la base de données
     * @param bool $getFromBD indique si les données viennent de la base de données
     */
    protected function __construct(array $data, $getFromBD = true)
    {
        foreach ($data as $key=>$item)
        {
            $keyEntity = $getFromBD?strtolower(explode('_',$key)[1]):strtolower($key);
            $method = 'set'.ucfirst($keyEntity);
            if(method_exists($this,$method) && $keyEntity!="id")
            {
                $this->$method($item);
            }
        }
    }
}