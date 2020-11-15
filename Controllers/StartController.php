<?php

require_once("Controllers/AbstractController.php");
require_once("Views/Displayers/StartDisplayer.php");

/**
 * Class StartController
 */
class StartController extends AbstractController
{
    /**
     * @var StartDisplayer instance de l'affichage de la page d'accueil
     */
    private $displayer;

    /**
     * StartController constructor.
     * @param String $action fonction que le controller va exécuter
     * @param Router $router instance du router
     */
    public function __construct(String $action, Router $router)
    {
        $this->displayer = new StartDisplayer();
        parent::__construct($action,$router);
    }

    /**
     * Contrôle de la page d'accueil
     */
    public function index()
    {
        $this->displayer->startPage([]);
        $this->displayer->_render();
    }
}