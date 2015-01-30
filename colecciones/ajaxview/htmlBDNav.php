<?php

/**
 * Este archivo genera el HTML necesario para visualizar la paginación del listado de bases de datos
 *
 * @author David Andrés Manzano -  damanzano
 * @since 15/10/10
 */
include_once '../control/ControlBusquedaBD.php';
include_once ('../../commons/services/GeneralServices.php');
include_once ('../Config.php');

session_start();
$cont = trim($_POST['cont']);
$size = trim($_POST['size']);
$newsearch = trim($_POST['newsearch']);
$pBD = trim($_POST['pBD']);
$pArea = trim($_POST['pArea']);
$pTipoAcceso = trim($_POST['pTipoAcceso']);

$cont = GeneralServices::parseInt($cont);
$size = GeneralServices::parseInt($size);

$controlBusqueda = $_SESSION['dbsearcher'];
if ($controlBusqueda == null || $controlBusqueda == '') {
    echo 'entro aqui';
    $controlBusqueda = new ControlBusquedaBD();
    $_SESSION["dbsearcher"] = $controlBusqueda;
}

$tamano = $controlBusqueda->getSize();
$paginas = intval($tamano / $size);
$modulo = ($tamano % $size);
if ($modulo > 0) {
    $paginas+=1;
}
$contador = $cont;
$pag = intval($cont / 100);
$inicio = $pag * $size;

/* pruebas de consulta */
//echo "contador: " . $cont . "<br/>";
//echo "tamannomostrar: " . $size . "<br/>";
//echo "buscar: " . $newsearch . "<br/>";
//echo "BD: " . $pBD . "<br/>";
//echo "Area: " . $pArea . "<br/>";
//echo "Acceso: " . $pTipoAcceso . "<br/>";
//echo "tamannoreal:" . $tamano . "<br/>";
//echo "numpaginas:" . $paginas . "<br/>";
//echo "pagactual:" . $pag . "<br/>";
//echo "inicio:" . $inicio . "<br/>";
/* fin */

echo HTMLNavegacionBD($cont, $paginas, $size, $tamano);

/**
 * Imprime la estructura HTML nesaria para desplegar la paginación de un resultado de una búsqueda
 *
 * @author damanzano
 * @since 15/10/10
 *
 * @param int $cont Indice del primer elemento a mostar 
 * @param int $paginas Número de páginas a mostrar
 * @param int $elemPaginas Número de elementos por página
 * @param int $tamano Número de resultados de la búsqueda
 */
function HTMLNavegacionBD($cont, $paginas, $elemPaginas, $tamano) {
    $html = '';
    if ($tamano <= 0) {
        $html = '-';
        return $html;
    }
    $numpag = 0;
    $paginaactual = ($cont / $elemPaginas) + 1;
    $html.='<table border="0" align="center" class="margenLinks">
            <tr>';
    /*if ($paginaactual > 1) {
        $html.= '<td valign="bottom"></td>
         <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a class="app_navlink"  onclick="loadBDResults(\'' . ($cont - $elemPaginas) . '\',\'' . $elemPaginas . '\', \'n\',\'\',\'\',\'\');"><img src="' . $GLOBALS["biblio_apps"] . '/commons/images/previous.png" alt="Anterior" title="Anterior" width="20" height="20"></a></font></td>';
    }*/
    /* Se generan los botones inicio y anterior */
    $style_anterior = 'class="app_navlink_disabled"';
    $style_inicio = 'class="app_navlink_disabled"';
    $tipo_imagen='_disabled';
    if ($paginaactual > 1) {
        $style_inicio = 'class="app_navlink" title="Inicio" onclick="loadBDResults(\'0\',\'' . $elemPaginas . '\', \'n\',\'' . $keyword . '\',\'\',\'\');"';
        $style_anterior = 'class="app_navlink" title="Anterior" onclick="loadBDResults(\'' . ($cont - $elemPaginas) . '\',\'' . $elemPaginas . '\', \'n\',\'\',\'\',\'\');"';
        $tipo_imagen='';
    }
    $html.= '<td width="10%" align="left">';
    $html.= '<table><tr>';
    $html.='<td><a ' . $style_inicio . '><img src="' . $GLOBALS["biblio_apps"] . '/commons/images/start'.$tipo_imagen.'.png" alt="Inicio" width="20" height="20"></a></td>';
    $html.= '<td><a ' . $style_anterior . '><img src="' . $GLOBALS["biblio_apps"] . '/commons/images/previous'.$tipo_imagen.'.png" alt="Anterior" title="Anterior" width="20" height="20"></a></td>';
    $html.= '</tr></table>';
    $html.= '</td>';

    /*Se Generan las páginas*/
    $html.= '<td width="80%" align="center">';
    $html.= '<table><tr>';
    $html.= '<td width="15"></td>';

    for ($i = 0; $i < $paginas; $i++) {
        $claseactual = '';
        $numpag = $i + 1;
        if ($numpag == $paginaactual) {
            $claseactual = '_active';
        }
        if ($numpag <= ($paginas)) {
            $html.= '<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a class="app_navlink' . $claseactual . '" onclick="loadBDResults(\'' . ($i * $elemPaginas) . '\',\'' . $elemPaginas . '\', \'n\',\'\',\'\',\'\');">' . $numpag . '</a></font></td>';
        }
    }
    $html.= '</tr></table>';
    $html.= '</td>';

    /*if ($paginaactual < $paginas) {
        $html.= '<td><a class="app_navlink" title="Siguiente" onclick="loadBDResults(\'' . ($cont + $elemPaginas) . '\',\'' . $elemPaginas . '\', \'n\',\'\',\'\',\'\');"><img src="' . $GLOBALS["biblio_apps"] . '/commons/images/next.png" alt="Siguiente" title="Siguiente" width="20" height="20"></a></td>';
    }*/
    /*Se generan los botones siguiente y fin */
    $style_siguiente = 'class="app_navlink_disabled"';
    $style_fin = 'class="app_navlink_disabled"';
    $tipo_imagen_fin='_disabled';
    $modulo_pag=($tamano%$elemPaginas);
    if($modulo_pag==0){
        $modulo_pag=$elemPaginas;
    }
    if ($paginaactual < $paginas) {
        $style_siguiente = 'class="app_navlink" title="Siguiente" onclick="loadBDResults(\'' . ($cont + $elemPaginas) . '\',\'' . $elemPaginas . '\', \'n\',\'\',\'\',\'\');"';
        $style_fin = 'class="app_navlink" title="Fin" onclick="loadBDResults(\''.($tamano-$modulo_pag).'\',\'' . $elemPaginas . '\', \'n\',\'' . $keyword . '\');"';
        $tipo_imagen_fin='';
    }

    $html.= '<td width="10%" align="right">';
    $html.= '<table><tr>';
    $html.= '<td><a '.$style_siguiente.'><img src="' . $GLOBALS["biblio_apps"] . '/commons/images/next'.$tipo_imagen_fin.'.png" alt="Siguiente" title="Siguiente" width="20" height="20"></a></td>';
    $html.='<td><a '.$style_fin.'><img src="' . $GLOBALS["biblio_apps"] . '/commons/images/end'.$tipo_imagen_fin.'.png" alt="Fin" title="Fin" width="20" height="20"></a></td>';
    $html.= '</tr></table>';
    $html.= '</td>';
    $html.= '</tr></table>';
    return $html;
}

?>
