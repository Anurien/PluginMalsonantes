<?php
/**
 * @package Malsonantes
 * @version 1.0
 */
/*
Plugin Name: Cambiar malsonantes
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: Busca palabras malsonantes y las cambia por otras menos malsonantes
Author: Nuria garcia
Version: 1.0
Author URI: http://ma.tt/
*/

add_filter('the_content', 'censura_palabras_malsonantes');

function censura_palabras_malsonantes($content)
{
    $palabrasMalsonantes = array('caca', 'culo', 'pedo', 'pis', 'piroca');

    //Reemplaza cada letra de la palabra por un * que la censura
    /*    foreach ( $palabrasMalsonantes as $Palabras ) {
            $Censura = substr( $Palabras, 0, 1 ) . str_repeat( '*', strlen( $Palabras ) - 1 );
            $content = str_replace( $Palabras, $Censura, $content );
        }*/

    //Reemplaza las palabras malsonantes por otras menos malsonantes
    $Censura = array('popo', 'pompis', 'flatulencia', 'pipi', 'pito');
    $content = str_replace($palabrasMalsonantes, $Censura, $content);

    return $content;
}

