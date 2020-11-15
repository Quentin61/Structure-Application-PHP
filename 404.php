<?php
require_once("Views/Displayers/ServerDisplayer.php");
define('URL', str_replace('index.php', '', (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$_SERVER['HTTP_HOST']."/".explode("/",$_SERVER['PHP_SELF'])[1]));
$displayer = new ServerDisplayer();
$displayer->error404([]);
$displayer->_render();