<?php

require("Models/Entities/AbstractEntity.php");

/**
 * Class User
 */
class User extends AbstractEntity
{
    /**
     * @var String identifiant unique
     */
    private $id;

    /**
     * @var String nom de l'utilisateur
     */
    private $name;

    /**
     * @var String mot de passe de l'utilisateur
     */
    private $password;

    /**
     * @var String login de l'utilisateur
     */
    private $login;

    /**
     * @var String adresse email de l'utilisateur
     */
    private $mail;

    /**
     * @var String type d'utilisateur
     */
    private $type;

    /**
     * User constructor.
     * @param array $data tableau de données
     * @param bool $getFromBD indique si les données viennent de la base de données
     */
    public function __construct(array $data, $getFromBD = true)
    {
        $this->id = $data["US_ID"];
        parent::__construct($data, $getFromBD);
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param String $name
     */
    public function setName(String $name)
    {
        $this->name = $name;
    }

    /**
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param String $password
     */
    public function setPassword(String $password)
    {
        $this->password = $password;
    }

    /**
     * @return String
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param String $login
     */
    public function setLogin(String $login)
    {
        $this->login = $login;
    }

    /**
     * @return String
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param String $mail
     */
    public function setMail(String $mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return String
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param String $id
     */
    public function setId(String $id)
    {
        $this->id = $id;
    }

    /**
     * @return String
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param String $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

}