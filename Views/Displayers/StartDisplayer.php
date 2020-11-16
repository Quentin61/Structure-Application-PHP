<?php

require_once("AbstractDisplayer.php");

class StartDisplayer extends AbstractDisplayer
{

    public function _render()
    {
        parent::render($this->data);
    }

    /**
     * gestion des données pour la home page
     * @param array $data tableau des données de la vue
     */
    public function startPage(array $data)
    {
        $this->data=$data;
        $this->data['menu'] = parent::makeMenu();
        $this->data['title'] = "home";
        $this->data = parent::getFeedback($this->data);
        $this->includedTemplates['content'] = "Views/Templates/StartPage/StartPage.html";
    }
}