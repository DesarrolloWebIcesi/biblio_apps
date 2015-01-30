<?php

/**
 * Este archivo genera el HTML necesario para visualizar la paginación del listado de bases de datos
 *
 * @author David Andrés Manzano -  damanzano
 * @since 15/10/10
 */
include_once '../control/ControlBusquedaRevistas.php';
include_once ('../../commons/services/GeneralServices.php');
include_once ('../Config.php');

session_start();
echo HTMLNavegacionRevistasAZ();

/**
 * Imprime la estructura HTML nesaria para desplegar la paginación alfabetica
 *
 * @author damanzano
 * @since 15/10/10
 *
 * @param int $cont Indice del primer elemento a mostar 
 * @param int $paginas Número de páginas a mostrar
 * @param int $elemPaginas Número de elementos por página
 * @param int $tamano Número de resultados de la búsqueda
 */
function HTMLNavegacionRevistasAZ() {
    $url=$GLOBALS['app_route'].'/ajaxview/htmlRevistasAZ.php';
    $html .= '<ul>';
    $html .= '<li><a href="'.$url.'">A</a></li>';
    $html .= '<li><a href="'.$url.'">B</a></li>';
    $html .= '<li><a href="'.$url.'">C</a></li>';
    $html .= '<li><a href="'.$url.'">D</a></li>';
    $html .= '<li><a href="'.$url.'">E</a></li>';
    $html .= '<li><a href="'.$url.'">F</a></li>';
    $html .= '<li><a href="'.$url.'">G</a></li>';
    $html .= '<li><a href="'.$url.'">H</a></li>';
    $html .= '<li><a href="'.$url.'">I</a></li>';
    $html .= '<li><a href="'.$url.'">J</a></li>';
    $html .= '<li><a href="'.$url.'">K</a></li>';
    $html .= '<li><a href="'.$url.'">L</a></li>';
    $html .= '<li><a href="'.$url.'">M</a></li>';
    $html .= '<li><a href="'.$url.'">N</a></li>';
    $html .= '<li><a href="'.$url.'">O</a></li>';
    $html .= '<li><a href="'.$url.'">P</a></li>';
    $html .= '<li><a href="'.$url.'">Q</a></li>';
    $html .= '<li><a href="'.$url.'">R</a></li>';
    $html .= '<li><a href="'.$url.'">S</a></li>';
    $html .= '<li><a href="'.$url.'">T</a></li>';
    $html .= '<li><a href="'.$url.'">U</a></li>';
    $html .= '<li><a href="'.$url.'">V</a></li>';
    $html .= '<li><a href="'.$url.'">W</a></li>';
    $html .= '<li><a href="'.$url.'">X</a></li>';
    $html .= '<li><a href="'.$url.'">Y</a></li>';
    $html .= '<li><a href="'.$url.'">Z</a></li>';
    $html .= '</ul>';
    return $html;
}

?>
