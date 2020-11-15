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
        $this->data['loginForm'] = "";
        $this->data['feedback'] = !isset($_SESSION['feedback']["message"])?"":$_SESSION['feedback']["message"];
        $this->data['feedbackType'] = !isset($_SESSION['feedback']["type"])?"":$_SESSION['feedback']["type"];
        $this->data['title'] = "Log in";
        $this->data['signUpURL'] = URL."login/sign-up";
        $this->data['actionFormLog'] = URL."login";
        $this->includedTemplates['content'] = "Views/Templates/LogPage/logForm.html";
    }

    public function signUp(array $data)
    {
        $this->data= $data;
        $this->data['menu'] = parent::makeMenu();
        if(isset($_SESSION['builder']))
        {
            $this->data = parent::getUnpostedForm($this->data);
        }
        else{
            $this->data[UserBuilder::getLoginField()] = "";
            $this->data[UserBuilder::getNameField()] = "";
            $this->data[UserBuilder::getMailField()] = "";
        }
        $this->data['feedback'] = !isset($_SESSION['feedback']["message"])?"":$_SESSION['feedback']["message"];
        $this->data['feedbackType'] = !isset($_SESSION['feedback']["type"])?"":$_SESSION['feedback']["type"];
        $this->data['title'] = "Sign up";
        $this->data['actionFormSignUp'] = URL."login/sign-up";
        $this->includedTemplates['content'] = "Views/Templates/LogPage/signUpForm.html";
    }
}