<?php

/**
 * Class AbstractBuilder
 */
abstract class AbstractBuilder
{
    /**
     * @var String chaine de charactère pour la détection d'erreurs dans une formulaire
     */
    protected $error;

    /**
     * @var array Données du formulaire
     */
    protected $data;

    /**
     * @var array Données non enregistées du formulaire
     */
    protected $unPostData;

    /**
     * AbstractBuilder constructor.
     * @param $data array Données de formualaire
     */
    protected function __construct(array $data)
    {
        $this->data = $data;
        $this->error = null;
        $this->unPostData = null;
    }

    /**
     * @return Object retourne une instance d'un object créé à partir d'un formulaire
     */
    public abstract function createObject();

    /**
     * @return Object|null retourne un objet si le formulaire est valide, sinon null
     */
    public abstract function isValid();
}