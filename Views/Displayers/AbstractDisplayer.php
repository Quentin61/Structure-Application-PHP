<?php


abstract class AbstractDisplayer
{
    /**
     * @var string définition du header pour chaque pages
     */
    private static $header = "Views/Templates/base/header.html";

    /**
     * @var string définition du footer pour chaque page
     */
    private static $footer = "Views/Templates/base/footer.html";

    /**
     * @var string définition du conteneur main pour chaque page
     */
    private static $main = "Views/Templates/base/content.html";

    /**
     * @var array tableau des données de la vue
     */
    protected $data;

    /**
     * @var array tableau de chemin de blocks HTML
     */
    protected $includedTemplates;

    /**
     * Extraction des données et affichage de la page web
     * @param array $data tableau des données de la vue
     * @param bool $presentation affichage du header et du footer
     */
    public function render(array $data, $presentation = true)
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

    /**
     * Retourne le contenu d'une variable
     * @param $dataName string nom de la variable
     * @return string contenu de la variable
     */
    protected function printData(string $dataName)
    {
        return (!key_exists($dataName,$this->data)?"":$this->data[$dataName]);
    }

    /**
     * Remplit les données d'un formulaire en fonction d'un builder
     * @param $data array tableau des données de la vue
     * @param $builderName string nom du builder à récupérer
     * @return array
     */
    protected function getUnpostedForm(array $data, string $builderName){
        try {
            $reflection = new ReflectionClass($builderName);
            $staticsfunctions = $reflection->getMethods(ReflectionMethod::IS_STATIC);
            foreach ($staticsfunctions as $function)
            {
                if(isset($_SESSION['builder']))
                    $data[$builderName::{$function->getName()}()]=$_SESSION['builder']->getUnPostData()[$builderName::{$function->getName()}()];
                else
                    $data[$builderName::{$function->getName()}()]="";
            }
        }
        catch (ReflectionException $exception) {}
        finally {
            return $data;
        }
    }

    /**
     * @param $data array tableau des données de la vue
     * @return array
     */
    protected function getFeedback(array $data)
    {
        $data['feedback'] = !isset($_SESSION['feedback']["message"])?"":$_SESSION['feedback']["message"];
        $data['feedbackType'] = !isset($_SESSION['feedback']["type"])?"":$_SESSION['feedback']["type"];
        return $data;
    }

    /**
     * Créé et retourne le menu
     * @return string
     */
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

    /**
     * Inclut un block HTML
     * @param $blockName string Nom du block à inclure
     * @return mixed|null
     */
    protected function includeBlock(string $blockName)
    {
        return key_exists($blockName,$this->includedTemplates)?$this->includedTemplates[$blockName]:null;
    }
}