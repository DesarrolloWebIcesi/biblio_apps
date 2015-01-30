<?php

/**
 * Esta archivo genera el HTML necesario para el despliegue de los resultados de una búsqueda de
 * Nuevas Adquisiciones.
 *
 * @author David Andrés Manzano - damanzano
 * @since 15/10/10
 */
include_once ('../control/ControlBusquedaNA.php');
include_once ('../../commons/services/GeneralServices.php');
include_once ('../Config.php');


session_start();
$cont = trim($_POST['cont']);
$size = trim($_POST['size']);
$newsearch = trim($_POST['newsearch']);
$idArea = trim($_POST['idArea']);

$cont = GeneralServices::parseInt($cont);
$size = GeneralServices::parseInt($size);

/* pruebas de consulta */
//echo "contador: " . $cont . "<br/>";
//echo "tamanno: " . $size . "<br/>";
//echo "buscar: " . $newsearch . "<br/>";
//echo "Area: " . $idArea . "<br/>";
/* fin */

$controlBusqueda = $_SESSION['nasearcher'];
if ($controlBusqueda == null || $controlBusqueda == '') {
    $controlBusqueda = new ControlBusquedaNA();
    $_SESSION["nasearcher"] = $controlBusqueda;
}

if ($newsearch == 's') {
    $controlBusqueda->cargarSearchNA(0, $idArea);
}

$tamano = $controlBusqueda->getSize();
$elementos = array();
$elementos = $controlBusqueda->getElementosDesde($cont, $size);

$area = $controlBusqueda->obtenerArea($idArea);

/* pruebas de consulta */
//echo "# elementos de la pagina: " . count($elementos) . "<br/>";
//echo "# elementos de la consulta: " . $tamano . "<br/>";
/* fin */
echo HTMLResultadosNA($tamano, $elementos, $area);

/**
 * Imprime la estructura HTML nesaria para deplegar los elementos de la búsqueda
 *
 * @author damanzano
 * @since 15/10/10
 *
 * @param int $tamano Cantidad real de resultados que arrojo la búsqueda.
 * @param Array<Adquisicion> $elementos Los elementos que desean mostrarse en una página.
 * @param Area $area Area para la cual se esta realizando la búsqueda
 */
function HTMLResultadosNA($tamano, $elementos, $area) {
    //echo 'tamanño ='.$tamano.'<br>';
    if ($area == null || $area == '') {
        $htm = '<div>NO seleccion&oacute; ning&uacute;n &aacute;rea</div>';
        return $html;
    }

    $html = '<div class="subtitulo">&Uacute;ltimas adquisiciones en el &aacute;rea de ' . htmlentities($area->getNombre()) . '</div>';

    if ($tamano <= 0) {
        $html.= '<br/><br/>';
        $html.= '<div class="noelements">No existen elementos por mostrar</div>';

        return $html;
    }

    $html.='<br/>
        <table width="100%" cellpadding="0" class="results">
            <tr>
                <td>
                    <table width="100%" border="0" bordercolor="#999999">';

    if ($elementos != null) {

        for ($i = 0; $i < count($elementos); $i++) {
            $elemento = $elementos[$i];
            $html.='<div class="resultitem" align="left">';
            $html.='<B> -<a target="_blank" href="' . $elemento->getLink() . '">' . htmlentities($elemento->getTitulo()) . '</a></B><br/>';
            if ($elemento->getAutores() != null && $elemento->getAutores() != "") {
                $html.= '<span class="authors"><b>Autores:</b> ' . htmlentities($elemento->getAutores()).'</span>';
            }
            $html.='<span class="copies"><b>Ejemplares:</b>'.$elemento->getEjemplares().'</span>';
            $html.='</div>';
        }

        $html.= '</table></td></tr>';
    }
    $html.= '</table>
        <br/><br/>';

    return $html;
}

?>
