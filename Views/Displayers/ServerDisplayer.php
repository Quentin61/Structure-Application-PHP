<?php
require_once("Views/Displayers/AbstractDisplayer.php");

class ServerDisplayer extends AbstractDisplayer
{

    public function _render()
    {
        parent::render($this->data);
    }

    public function error404(array $data)
    {
        $this->data = $data;
        $this->data['menu'] = parent::makeMenu();
        $this->data = parent::getFeedback($this->data);
        $this->includedTemplates['content']="Views/Templates/server/404.html";
    }
}