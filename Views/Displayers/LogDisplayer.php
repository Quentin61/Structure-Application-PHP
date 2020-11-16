<?php

require_once("Views/Displayers/AbstractDisplayer.php");

class LogDisplayer extends AbstractDisplayer
{
    public function _render()
    {
        parent::render($this->data);
    }

    public function signIn(array $data)
    {
        $this->data = $data;
        $this->data['menu'] = parent::makeMenu();
        $this->data = parent::getFeedback($this->data);
        $this->data['loginForm'] = "";
        $this->data['title'] = "Log in";
        $this->data['signUpURL'] = URL."login/sign-up";
        $this->data['actionFormLog'] = URL."login";
        $this->includedTemplates['content'] = "Views/Templates/LogPage/logForm.html";
    }

    public function signUp(array $data)
    {
        $this->data= $data;
        $this->data['menu'] = parent::makeMenu();
        $this->data = parent::getUnpostedForm($this->data,"UserBuilder");
        $this->data = parent::getFeedback($this->data);
        $this->data['title'] = "Sign up";
        $this->data['actionFormSignUp'] = URL."login/sign-up";
        $this->includedTemplates['content'] = "Views/Templates/LogPage/signUpForm.html";
    }
}