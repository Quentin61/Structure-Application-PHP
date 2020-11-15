<?php

/**
 * Class AbstractController
 * Classe abstraite dont tous les controllers héritent
 */
abstract class AbstractController
{
    protected $router;

    /**
     * AbstractController constructor
     * @param String $action fonction que le controller va exécuter
     * @param Router $router instance du router
     */
    protected function __construct(String $action, Router $router)
    {
        $this->router = $router;
        $this->$action();
    }

    /**
     * Génération d'index
     *
     * Méthode de base qui génère l'index d'un élément
     * @return mixed
     */
    public abstract function index();
}