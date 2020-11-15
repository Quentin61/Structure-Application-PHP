<?php

require_once("Models/Loger.php");
require_once("Views/Displayers/LogDisplayer.php");
require_once("Controllers/AbstractController.php");
require_once("Models/Managers/UserManager.php");
require_once("Models/Builders/UserBuilder.php");

class LogController extends AbstractController
{
    /**
     * @var Loger instance pour la connexion des utilisateurs
     */
    private $loger;

    /**
     * @var LogDisplayer instance pour l'affichage des pages de connexions/inscriptions
     */
    private $logDisplayer;

    /**
     * @var UserManager  instance pour la gestion des utilisateurs dans le model
     */
    private $userManager;

    /**
     * LogController constructor.
     * @param string $action fonction que le controller va exécuter
     * @param Router $router instance du routeur
     */
    public function __construct(string $action, Router $router)
    {
        $this->loger = new Loger();
        $this->logDisplayer = new LogDisplayer();
        $this->userManager = new UserManager();
        parent::__construct($action,$router);
    }

    /**
     * Contrôle de la page de connexion
     */
    public function index()
    {
        if(key_exists('submitLog',$_POST)){
            if(key_exists(UserBuilder::getLoginField(),$_POST) && key_exists(UserBuilder::getPasswordField(),$_POST)){
                if($this->loger->login($_POST[UserBuilder::getLoginField()],$_POST[UserBuilder::getPasswordField()])) {
                    $this->router->redirect("home","Connexion réussi !","feedback succes");
                }
                else{
                    $this->router->redirect("login","Les identifiants sont incorrectes","feedback warning");
                }
            }
            else{
                $this->router->redirect("login","L'un des champs est vide","feedback warning");
            }
        }
        else{
            $this->logDisplayer->signIn([]);
            $this->logDisplayer->_render();
        }
    }

    /**
     * Contrôle de la page d'inscription
     */
    public function signUp()
    {
        if(key_exists('submitSignUp',$_POST)){
            $builder = new UserBuilder($_POST);
            $user = $builder->isValid($this->userManager);
            if($user !== null){
                $this->userManager->add($user);
                $this->router->redirectToSeeOther("login","Compte créé avec succes","feedback succes");
            }
            else{
                $_SESSION['builder'] = $builder;
                $this->router->redirect("login/sign-up",$builder->getError(),"feedback error");
            }
        }
        else{
            $this->logDisplayer->signUp([]);
            $this->logDisplayer->_render();
        }
    }

    /**
     * Contrôle de la fonction de déconnexion
     */
    public function signOut()
    {
        $this->loger->logout();
        $this->router->redirect("home","Déconnexion réussi !","feedback succes");
    }
}