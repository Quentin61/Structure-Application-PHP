<?php

require('init.php');
require("Utils/matchURL.php");
require_once("Models/Entities/User.php");

define('URL', str_replace('index.php', '', (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));
/**
 * Class Router
 * Classe qui gère la redirection des URL de l'application web (reprise d'un classe du tutoriel de Grafikart.fr)
 */
class Router
{

    /**
     * @var string URL entrée dans le navigateur
     */
    private $url;

    /**
     * @var array liste des routes
     */
    private $routes = [];

    /**
     * Router constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->main();
    }

    public function main(){
        $this->request();
        $this->run();
        if(isset($_SESSION['feedback']))unset($_SESSION['feedback']);
        if(isset($_SESSION['builder']))unset($_SESSION['builder']);
    }

    /**
     * @param $path string
     * @param $callable
     */
    public function addRoute(String $path, $callable)
    {
        $this->routes[$path] = $callable;
    }

    /**
     * fonction qui cherche parmi les routes enregistrées et redirige vers la fonction associé au bon controller
     * @return mixed
     */
    public function run()
    {
        if(!isset($_SESSION))session_start();
        foreach ($this->routes as $url=>$route)
        {
            if(match(explode('/',$this->url)[0],$url))
            {
                return call_user_func_array($route, []);
            }
        }
        header("location: ".URL."404.php");
        exit;
    }

    /**
     * Fonction qui enregistre l'appel des controller (premier paramêtre de l'URL) avec la bonne méthode (deuxième paramêtre de l'URL)
     */
    public function request()
    {
        $pathsObjects= initSlugController();
        $url = explode('/', filter_var($this->url, FILTER_SANITIZE_URL));
        foreach($pathsObjects as $paths)
        {
            foreach ($paths as $path)
            {
                if($path===$url[0])
                {
                    $controllerClass = array_search($paths, $pathsObjects);
                    $controller = $path;
                    include("Controllers/".$controllerClass.".php");
                    $action = $this->setMethod($url,$controllerClass);
                    $callable = function () use($action, $controllerClass) {new $controllerClass($action,$this);};
                    $this->addRoute($controller,$callable);
                }
            }
        }
    }

    /**
     * fonction qui va gérer l'appel de méthodes dans le controller avec le deuxième argument de l'URL
     * @param $url array URL entré
     * @param $object string nom du controller
     * @return false|int|mixed|string retourne le nom de la fonction associé ou créée une erreur 404
     */
    public function setMethod($url, String $object)
    {
        $pathsAction=initSlugAction();
        if(count($url)==1)
        {
            return "index";
        }
        else if(count($url)>1)
        {
            foreach ($pathsAction as $path)
            {
                if($path===$url[1] && method_exists($object,array_search($path, $pathsAction)))
                {
                    return array_search($path, $pathsAction);
                }
            }
        }
        header("location: ".URL."404.php");
        exit;
    }

    /**
     * fonction de redirection see to other
     * @param $url String url vers laquel on rediriger
     * @param $feedback String message a affiché après la redirection
     * @param $type String type de message a affiché
     */
    public static function redirectToSeeOther($url, $feedback,$type){
        $_SESSION['feedback'] = ["message" => $feedback, "type" => $type];
        header("Location: ".URL.$url,true,303);
        exit();
    }

    /**
     * fonction de redirection
     * @param $url url vers laquel on rediriger
     * @param $feedback String message a affiché après la redirection
     * @param $type String type de message a affiché
     */
    public static function redirect($url,$feedback,$type){
        $_SESSION['feedback'] = ["message" => $feedback, "type" => $type];
        header("Location: ".URL.$url);
        exit();
    }
}