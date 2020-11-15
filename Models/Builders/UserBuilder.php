<?php

require_once("Models/Builders/AbstractBuilder.php");

/**
 * Class UserBuilder
 * Classe de construction d'objets User à partir des données d'un formulaire
 */
class UserBuilder extends AbstractBuilder
{

    /**
     * UserBuilder constructor.
     * @param $data array tableau de données
     */
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    /**
     * @return string nom du champ pour le nom de l'utilisateur
     */
    public static function getNameField(){
        return "name";
    }

    /**
     * @return string nom du champ pour le mot de passe de l'utilisateur
     */
    public static function getPasswordField(){
        return "password";
    }

    /**
     * @return string nom du champ pour l'adresse email de l'utilisateur
     */
    public static function getMailField(){
        return "mail";
    }

    /**
     * @return string nom du champ pour le login de l'utilisateur
     */
    public static function getLoginField(){
        return "login";
    }

    /**
     * @return Object|User
     */
    public function createObject()
    {
        $this->data['US_ID'] = substr(md5(uniqid()),0,15);
        $this->data[self::getPasswordField()]=password_hash($this->data[self::getPasswordField()],PASSWORD_BCRYPT);
        return new User($this->data, false);
    }

    /**
     * @param null $manager
     * @return Object|User|null
     */
    public function isValid($manager = null){
        try {
            if(key_exists("submitSignUp",$this->data)) {
                if(key_exists(self::getNameField(),$this->data) && key_exists(self::getLoginField(),$this->data) &&
                    key_exists(self::getPasswordField(),$this->data) && key_exists(self::getMailField(),$this->data)) {
                    if(!$this->checkNameOrLogin($this->data[self::getNameField()]))
                        throw new Exception("Le login est invalide");
                    if(!$this->checkNameOrLogin($this->data[self::getLoginField()]))
                        throw new Exception("Le nom est invalide");
                    if(!$this->checkEmail($this->data[self::getMailField()]))
                        throw new Exception("L'adresse mail est invalide");
                    if(!$this->checkPassword($this->data[self::getPasswordField()]))
                        throw new Exception("Le Format du mot de passe est invalide");
                    if(!$this->isExistingLogin($manager))
                        throw new Exception("Ce login n'est pas disponible");
                    if(!$this->isExistingMail($manager))
                        throw new Exception("Ce mail est déjà utilisé");
                    return $this->createObject();
                }
                else{
                    throw new Exception("L'un des champs n'a pas été rempli");
                }
            }
            else {
                throw new Exception("Le formulaire n'a pas été soumis");
            }
        }
        catch (Exception $exception) {
            $this->unPostData = $this->data;
            if(isset($this->data['submitSignUp']))unset($this->data['submitSignUp']);
            $this->error = $exception->getMessage();
        }
        return null;
    }

    /**
     * Vérifie si le login existe déjà dans la base de données
     * @param $manager UserManager instance du manager pour les utilisateurs
     * @return bool
     */
    public function isExistingLogin(UserManager $manager)
    {
        return $manager->getOneByLogin($this->data[self::getLoginField()])===null;
    }

    /**
     * Vérifie si l'adresse email existe déjà dans la base de données
     * @param $manager UserManager instance du manager pour les utilisateurs
     * @return bool
     */
    public function isExistingMail($manager)
    {
        return $manager->getOneByMail($this->data[self::getMailField()])===null;
    }

    /**
     * Vérifie la validité du nom ou du login
     * @param $nameOrLogin String adresse email ou du login
     * @return false|int
     */
    public function checkNameOrLogin(string $nameOrLogin)
    {
        $regex = "#[^\xc0-\xd6\xd8-\xf6\xf8-\xff][a-zA-Z0-9]{4,}#";
        return preg_match($regex,$nameOrLogin);
    }

    /**
     * Vérifie la validité de l'adresse email
     * @param $email String adresse email
     * @return false|int
     */
    public function checkEmail(string $email)
    {
        $regex = "#[a-z0-9]*+[@][a-z]*\.[a-z]{2,}#";
        return preg_match($regex,$email);
    }

    /**
     * Vérifie la validité du mot de passe (au moins 1 majuscule, 1 nombre et minimum 8 charactères)
     * @param $password
     * @return false|int
     */
    public function checkPassword($password)
    {
        $regex = "#(?=.*?[A-Z])(?=.*?[0-9])[a-zA-Z0-9]{8,}#";
        return preg_match($regex,$password);
    }

    /**
     * @return String|null retourne les erreurs de saisie de formulaire
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return array|null retourne les données non-enregistrées
     */
    public function getUnPostData()
    {
        return $this->unPostData;
    }
}