<?php

/**
 * @return array retourne un tableau avec les correspondance entre le premier paramètre de l'URL et le controller associé avec les méthodes autorisés
 */
function initSlugController()
{
    $array = [];
    $array['StartController']=['home',''];
    $array['LogController']=['login'];
    return $array;
}

/**
 * @return array retourne un tableau avec les correspondances entre le deuxième paramêtre de l'URL et les fonctions disponibles
 */
function initSlugAction()
{
    $array = [];
    $array['signUp']='sign-up';
    $array['signOut']='sign-out';
    return $array;
}