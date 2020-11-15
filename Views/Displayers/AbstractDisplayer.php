<?php


abstract class AbstractDisplayer
{
    private static $header = "Views/Templates/base/header.html";
    private static $footer = "Views/Templates/base/footer.html";
    private static $main = "Views/Templates/base/content.html";

    protected $data;

    protected $includedTemplates;

    public function render($data, $presentation = true)
    {
        extract($data);
        ob_start();
        if(file_exists(AbstractDisplayer::$header) && $presentation)
            require(AbstractDisplayer::$header);
        if(file_exists(AbstractDisplayer::$main))
            require(AbstractDisplayer::$main);
        if(file_exists(AbstractDisplayer::$footer) && $presentation)
            require(AbstractDisplayer::$footer);
        echo ob_get_clean();
    }

    protected function printData($dataName)
    {
        return (!key_exists($dataName,$this->data)?"":$this->data[$dataName]);
    }

    protected function getUnpostedForm($data){
        $reflection = new ReflectionClass(get_class($_SESSION['builder']));
        $staticsfunctions = $reflection->getMethods(ReflectionMethod::IS_STATIC);
        foreach ($staticsfunctions as $function)
            $data[$_SESSION['builder']::{$function->getName()}()]=$_SESSION['builder']->getUnPostData()[$_SESSION['builder']::{$function->getName()}()];
        return $data;
    }

    protected function makeMenu()
    {
        $menu = "";
        if(!isset($_SESSION['user'])) {
            $menu .= "<a class='menuItem' href='".URL.'home'."'>Home</a>&nbsp;";
            $menu .= "<a class='menuItem' href='".URL.'login'."'>Sign in</a>&nbsp;";
        }
        elseif ($_SESSION['user']->getType()=='user') {
            $menu .= "<a class='menuItem' href='".URL.'home'."'>Home</a>&nbsp;";
            $menu .= "<a class='menuItem' href='".URL.'login/sign-out'."'>Sign out</a>";
        }
        return $menu;
    }

    protected function includeBlock($blockName)
    {
        return key_exists($blockName,$this->includedTemplates)?$this->includedTemplates[$blockName]:null;
    }
}