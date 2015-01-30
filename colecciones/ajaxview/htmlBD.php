<?php

/**
 * Esta archivo genera el HTML necesario para el despliegue de los resultados de una búsqueda de bases de datos.
 *
 * @author David Andrés Manzano - damanzano
 * @since 15/10/10
 */
include_once  ('../control/ControlBusquedaBD.php');
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
if ($pBD == null) {
    $pBD = "";
}
if ($pArea == null) {
    $pArea = "";
}
if ($pTipoAcceso == null) {
    $pTipoAcceso = "";
}
/* pruebas de consulta */
//echo "contador: " . $cont . "<br/>";
//echo "tamanno: " . $size . "<br/>";
//echo "buscar: " . $newsearch . "<br/>";
//echo "BD: " . $pBD . "<br/>";
//echo "Area: " . $pArea . "<br/>";
//echo "Acceso: " . $pTipoAcceso . "<br/>";
/* fin */
$controlBusqueda = $_SESSION['dbsearcher'];
if ($controlBusqueda == null || $controlBusqueda == '') {
    $controlBusqueda = new ControlBusquedaBD();
    $_SESSION["dbsearcher"] = $controlBusqueda;
}

if ($newsearch == 's') {    
    $controlBusqueda->cargarSearchBD(0, $pBD, $pArea, $pTipoAcceso);
}

$tamano = $controlBusqueda->getSize();
$elementos = array();
$elementos = $controlBusqueda->getElementosDesde($cont, $size);

/* pruebas de consulta */
//echo "# elementos de la pagina: ".count($elementos)."<br/>";
//echo "# elementos de la consulta: ".$tamano."<br/>";
/* fin */
echo HTMLResultadosBD($tamano, $elementos);

/**
 * Imprime la estructura HTML nesaria para deplegar los elementos de la búsqueda
 *
 * @author damanzano
 * @since 15/10/10
 *
 * @param int $tamano Cantidad real de resultados que arrojo la búsqueda.
 * @param Array<ElementoBD> $elementos Los elementos que desean mostrarse en una página.
 */
function HTMLResultadosBD($tamano, $elementos) {
    //echo 'tamanño ='.$tamano.'<br>';
    $html = '';
    if ($tamano <= 0) {
        $html.= '<br/><br/>';
        $html.= '<div class="noelements">&nbsp;&nbsp; No existen m&aacute;s elementos por mostrar</div>';
    }

    $html.='<br/>
        <table width="100%" cellpadding="0" class="results">
            <tr>
                <td>
                    <table width="100%" border="0" bordercolor="#999999">';

    if ($elementos != null) {

        for ($i = 0; $i < count($elementos); $i++) {
            $elemento = $elementos[$i];
            $html.='<tr>';
            if (($elemento->getImagen() != null) && ($elemento->getImagen() != "") && ($elemento->getEnlaceConsultar() != null) && ($elemento->getEnlaceConsultar() != "")) {

                $html.= '<td width="160" align="center" class="margenImagenDB" valign="middle"><a href="' . $elemento->getEnlaceConsultar() . '"><img width="140" align="bottom" src="' . $elemento->getImagen() . '"/></a>
	                </td>';
            } else if ($elemento->getImagen() != null && $elemento->getImagen() != "") {
                $html.= '<td width="160" align="center" class="margenImagenDB" valign="middle"><img width="140" align="bottom" src="' . $elemento->getImagen() . '"/>
	                </td>';
            } else {
                $html.= '<td width="160" align="center" class="margenImagenDB" valign="middle"><img width="140" align="bottom" src="imgs/no_disp.gif"/>
	                </td>';
            }

            $html.= '<td width="4"><img src="'.$GLOBALS["biblio_apps"].'/commons/images/sep_vert.gif"/></td>
                <td class="contenido2" valign="top" align="left"><span class="tituloBD">' . htmlentities($elemento->getBiblio()) . '</span> <br/> <br/><div align="left" class="acceso">Acceso:&nbsp;&nbsp;';

            if ($elemento->getTipoAcceso()=="L") {
                $html.= '<img src="'.$GLOBALS["app_route"].'/images/accesos/local_p.gif" width="18" height="18"> &nbsp;';
            }

            if ($elemento->getTipoAcceso()=="F") {
                $html.= '<img src="'.$GLOBALS["app_route"].'/images/accesos/fijo_p.gif" width="18" height="18">&nbsp;';
            }

            if ($elemento->getTipoAcceso()=="R") {
                $html.= '<img src="'.$GLOBALS["app_route"].'/images/accesos/remoto_p.gif" width="18" height="18">';
            }

            /*if ($elemento->getTipoAcceso() == null || $elemento->getTipoAcceso() == "") {
                $html.= '<img src="'.$GLOBALS["app_route"].'/images/accesos/local_p.gif" width="18" height="18">&nbsp;<img src="'.$GLOBALS["app_route"].'/images/accesos/fijo_p.gif" width="18" height="18">&nbsp;<img src="'.$GLOBALS["app_route"].'/images/accesos/remoto_p.gif" width="18" height="18">';
            }*/

            $html.= '</div><br/>';

            if ($elemento->getResumen() != null) {
                $html.= '<div class="resumen">' . htmlentities($elemento->getResumen()) . '</div>';
            }
            $html.= '<br>
                <table width="100%" border="0">
                    <tr>';
            if ($elemento->getMasInfo() != null && $elemento->getMasInfo() != "") {
                $html.= '<td align="left" width="50%"><a href="' . $elemento->getMasInfo() . '" target="_blank">M&aacute;s Informaci&oacute;n</a></td>';
            } else {
                $html.= '<td align="left" width="50%">&nbsp;</td>';
            }

            if ($elemento->getEnlaceConsultar() != null && $elemento->getEnlaceConsultar() != "") {
                $html.= '<td align="right" width="50%"><a href="' . $elemento->getEnlaceConsultar() . '" target="_blank">Consultar</a></td>';
            } else {
                $html.= '<td align="left" width="50%">&nbsp;</td>';
            }

            $html.= '</tr></table></td></tr><tr><td colspan="3">';
            if (($i + 1) < count($elementos)) {
                $html.= '<hr/>';
            }

            $html.= '</td></tr>';
        }

        $html.= '</table></td></tr>';
    }
    $html.= '</table>
        <br/><br/>';

    return $html;
}

?>
