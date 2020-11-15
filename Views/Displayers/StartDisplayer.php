<?php

require_once("AbstractDisplayer.php");

class StartDisplayer extends AbstractDisplayer
{
    public function _render()
    {
        parent::render($this->data);
    }

    public function startPage(array $data)
    {
        $this->data=$data;
        $this->data['menu'] = parent::makeMenu();
        $this->data['title'] = "home";
        $this->data['feedback'] = !isset($_SESSION['feedback']["message"])?"":$_SESSION['feedback']["message"];
        $this->data['feedbackType'] = !isset($_SESSION['feedback']["type"])?"":$_SESSION['feedback']["type"];
        $this->includedTemplates['content'] = "Views/Templates/StartPage/StartPage.html";
    }
}