<?php

/**
 * Este archivo genera el HTML necesario para visualizar la paginación del listado de bases de datos
 *
 * @author David Andrés Manzano -  damanzano
 * @since 15/10/10
 */
include_once '../control/ControlBusquedaNA.php';
include_once ('../../commons/services/GeneralServices.php');

session_start();
$cont = trim($_POST['cont']);
$size = trim($_POST['size']);
$newsearch = trim($_POST['newsearch']);
$idArea = trim($_POST['idArea']);

$cont = GeneralServices::parseInt($cont);
$size = GeneralServices::parseInt($size);

$controlBusqueda = $_SESSION['nasearcher'];
if ($controlBusqueda == null || $controlBusqueda == '') {
    //echo 'entro aqui';
    $controlBusqueda = new ControlBusquedaNA();
    $_SESSION["nasearcher"] = $controlBusqueda;
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
//echo "Area: " . $idArea . "<br/>";
//echo "tamannoreal:" . $tamano . "<br/>";
//echo "numpaginas:" . $paginas . "<br/>";
//echo "pagactual:" . $pag . "<br/>";
//echo "inicio:" . $inicio . "<br/>";
/* fin */

echo HTMLNavegacionNA($cont, $paginas, $size, $tamano, $idArea);

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
function HTMLNavegacionNA($cont, $paginas, $elemPaginas, $tamano, $idArea) {
    $html = '';
    if ($tamano <= 0) {
        $html = '-';
        return $html;
    }
    $numpag = 0;
    $paginaactual = ($cont / $elemPaginas) + 1;
    $html.='<table border="0" align="center" class="margenLinks">
            <tr>';
    if ($paginaactual > 1) {
        $html.= '<td valign="bottom"><img src="../images/anterior.gif" width="13" height="13"></td>
         <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a class="app_navlink"  onclick="loadBDResults(\'' . ($cont - $elemPaginas) . '\',\'' . $elemPaginas . '\', \'n\',\''.$idArea.'\');">Anterior</a></font></td>';
    }

    $html.= '<td width="15"></td>';

    for ($i = 0; $i < $paginas; $i++) {
        $claseactual = '';
        $numpag = $i + 1;
        if ($numpag == $paginaactual) {
            $claseactual = '_active';
        }
        if ($numpag <= ($paginas)) {
            $html.= '<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a class="app_navlink' . $claseactual . '" onclick="loadBDResults(\'' . ($i * $elemPaginas) . '\',\'' . $elemPaginas . '\', \'n\',\''.$idArea.'\');">' . $numpag . '</a></font></td>';
        }
    }

    if ($paginaactual < $paginas) {
        $html.= '<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a class="app_navlink" onclick="loadBDResults(\'' . ($cont + $elemPaginas) . '\',\'' . $elemPaginas . '\', \'n\',\''.$idArea.'\');">Siguiente</a></font></td>
          <td valign="bottom"><img src="../images/siguiente.gif" width="13" height="13"></td>';
    }
    $html.= '</tr></table>';
    return $html;
}

?>
