<?php
require_once("Views/Displayers/AbstractDisplayer.php");

class ServerDisplayer extends AbstractDisplayer
{

    public function _render()
    {
        parent::render($this->data);
    }

    /**
     * Gestion des données de la page 404
     * @param array $data tableau de données de la vue
     */
    public function error404(array $data)
    {
        $this->data = $data;
        $this->data['menu'] = parent::makeMenu();
        $this->data = parent::getFeedback($this->data);
        $this->includedTemplates['content']="Views/Templates/server/404.html";
    }
}