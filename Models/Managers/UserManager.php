<?php
require_once("AbstractManager.php");
require_once("Models/Entities/User.php");

/**
 * Class UserManager
 */
class UserManager extends AbstractManager
{
    /**
     * @var string nom de la table dans la base de données
     */
    private static $table = "ST_USER";

    /**
     * @var string nom de l'entité
     */
    private static $entity = "User";

    /**
     * UserManager constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * fonction d'ajout d'une entité dans la base de données
     * @param $data User entité à ajouté dans la base
     * @return bool retourne true si la requête a fonctionnée
     */
    public function add(User $data)
    {
        $params = [
          ":id" => $data->getId(),
          ":login" => $data->getLogin(),
          ":password" => $data->getPassword(),
          ":mail" => $data->getMail(),
          ":name" => $data->getName()
        ];
        $request = "INSERT INTO ".self::$table." (US_ID, US_LOGIN, US_PASSWORD, US_MAIL, US_NAME) VALUES 
        (:id, :login, :password, :mail, :name)";
        return $this->database->prepareRequest($request,$params,self::$entity,true);
    }

    /**
     * retourne une entité User en recherchant une adresse email
     * @param $mail String adresse email de l'utilisateur
     * @return User|null retourne un User ou null
     */
    public function getOneByMail(String $mail)
    {
        $params = [":mail"=>$mail];
        $request = "SELECT * FROM ".self::$table." WHERE US_MAIL=:mail";
        return $this->database->prepareRequest($request,$params,self::$entity)[0];
    }

    /**
     * retourne un utilisateur en recherchant un login
     * @param $login String login de l'utilisateur
     * @return User|null retourne un User ou null
     */
    public function getOneByLogin(String $login)
    {
        $params = [":login"=>$login];
        $request = "SELECT * FROM ".self::$table." WHERE US_LOGIN=:login";
        return $this->database->prepareRequest($request,$params,self::$entity)[0];
    }
}