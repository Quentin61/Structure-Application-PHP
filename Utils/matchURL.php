<?php

/**
 * @param $url String
 * @param $urlInput String
 * @return false|int
 */
function match($url, $urlInput)
{
    $urlInput = trim($urlInput,'/') ;
    $path = preg_replace('#:([\w]+)#', '([^/]+)', $urlInput);
    $regex = "#^$path$#i";
    return preg_match($regex, $url);
}