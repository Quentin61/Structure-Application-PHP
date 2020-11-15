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
        $this->data['feedback'] = !isset($_SESSION['feedback']["message"])?"":$_SESSION['feedback']["message"];
        $this->data['feedbackType'] = !isset($_SESSION['feedback']["type"])?"":$_SESSION['feedback']["type"];
        $this->includedTemplates['content']="Views/Templates/server/404.html";
    }
}