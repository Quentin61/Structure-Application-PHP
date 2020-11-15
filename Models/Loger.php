<?php

require_once("Models/Managers/UserManager.php");

/**
 * Class Loger
 * Classe qui permet de connecter et de déconnecter un utilisateur
 */
class Loger
{
    /**
     * @var UserManager instance de UserManager
     */
    private $userManager;

    /**
     * Loger constructor.
     */
    public function __construct(){
        $this->userManager = new UserManager();
    }

    /**
     * function de connexion pour les utilisateurs
     * @param String $password mot de passe de l'utilisateur (hash)
     * @param String $login login de l'utilisateur
     * @return bool retourne true si la connexion réussi
     */
    public function login(String $login,String $password) : bool
    {
        $user = $this->userManager->getOneByLogin($login);
        if(!empty($user))
        {
            if(password_verify($password,$user->getPassword()))
            {
                $_SESSION['user']=$user;
                return true;
            }
        }
        return false;
    }

    /**
     * fonction pour déconnecté les utilisateurs
     * enlève les variables de la session et la détruit
     */
    public function logout()
    {
        session_unset();
        session_destroy();
    }

    /**
     * retourne l'utilisateur de la session
     * @return User|null
     */
    public function getUser()
    {
        $user = null;
        if(key_exists('user',$_SESSION)) {
            if ($_SESSION['user'] instanceof User) {
                $user = $_SESSION['user'];
            }
        }
        return $user;
    }

    /**
     * retourne si l'utilisateur est connecté est bien celui en session
     * @param $user User instance d'utilisateur
     * @return bool
     */
    public function isUserLoged($user) : bool
    {
        $logged = false;
        if(key_exists('user',$_SESSION))
        {
            if($_SESSION['user'] instanceof User) {
                $logged = $_SESSION['user']->getName === $user->getName();
            }
        }
        return $logged;
    }
}