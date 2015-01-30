<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once  ('../control/ControlAreas.php');
include_once  ('../control/ControlBusquedaBD.php');
include_once ('../../commons/services/GeneralServices.php');
include_once ('../Config.php');

session_start();
$tabs=array('bdatos', 'cestudio','revistas','mapas','mmedia','sonoteca','videoteca','otros');
$code=$_POST['tab'];

$tab=$tabs[GeneralServices::parseInt($code)];
$area=$_SESSION['parea'];
echo 'code='.$code.'- area='.$area.' - tab='.$tab;

switch ($tab){
    case 'bdatos':        
        $controlBusqueda = $_SESSION['badbsearcher'];
        $newsearch=$_POST['newsearch'];
        if ($controlBusqueda == null || $controlBusqueda == '') {
            $controlBusqueda = new ControlBusquedaBD();
            $_SESSION["badbsearcher"] = $controlBusqueda;
        }

        if ($newsearch == 's') {    
            $controlBusqueda->cargarSearchBD(0, $area);
        }
        
        echo $tamano = $controlBusqueda->getSize();
        $elementos = array();
        $elementos = $controlBusqueda->getElementos();

        echo HTMLResultadosBD($tamano, $elementos);
        break;
    case 'cestudio':
        break;
    case 'revistas':
        break;
    case 'mapas':
        break;
    case 'mmedia':
        break;
    case 'sonoteca':
        break;
    case 'videoteca':
        break;
    case 'otros':
        break;
}
$controlAreas = $_SESSION["controlAreas"];
if ($controlAreas == null || $controlAreas == '') {
    $controlAreas = new ControlAreas();
    $_SESSION["controlAreas"] = $controlAreas;
}

function HTMLResultadosCategoria($tamano, $elementos,$tab) {
     //echo 'tamanño ='.$tamano.'<br>';
    $html = '';
    if ($tamano <= 0) {
        $html.= '<br/><br/>';
        $html.= '<div class="noelements">&nbsp;&nbsp; No existen m&aacute;s elementos por mostrar</div>';
    } else {
        $mensaje = ($letra != null && $letra != "") ? 'para la letra: ' . strtoupper(htmlentities($letra)) : '';
        $html.= '<div class="subtitulo">'.$tamano.' Resultados de revistas ' . $mensaje . '</div>';
    }

    $html.='<br/>
        <table width="100%" cellpadding="0" class="results">
            <tr>
                <td>
                    <table width="100%" border="0" bordercolor="#999999">';

    if ($elementos != null) {

        for ($i = 0; $i < count($elementos); $i++) {
            $elemento = $elementos[$i];
            $html.='<tr>
                        <td>
                            <div class="journal">
                                <div class="journal_image" width="25%">
                                    <div><img src="' . $elemento->getImagen() . '"/></div>
                                </div>
                                <div class="journal_info" width="70%">
                                    <span class="journal_info_title">
                                        <a href="' . $elemento->getLink() . '" target="_blank">
                                            <strong>' . htmlentities($elemento->getTitulo()) . '</strong>
                                        </a>
                                    </span>
                                    <span class="journal_info_issn">
                                        <strong>ISSN:</strong> ' . $elemento->getISSN() . '
                                    </span>
                                    <span class="journal_info_emitions">
                                        <strong>Emisiones recibidas:</strong> ' . $elemento->getEmisiones() . '
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>';
        }

        $html.= '</table></td></tr>';
    }
    $html.= '</table>
        <br/><br/>';
    return $html;
}

function HTMLResultadosBD($tamano, $elementos) {
    //echo 'tamanño ='.$tamano.'<br>';
    $html = '';
    if ($tamano <= 0) {
        $html.= '<br/><br/>';
        $html.= '<div class="noelements">&nbsp;&nbsp; No existen m&aacute;s elementos por mostrar</div>';
    } else {

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

                $html.= '<td width="4"><img src="' . $GLOBALS["biblio_apps"] . '/commons/images/sep_vert.gif"/></td>
                <td class="contenido2" valign="top" align="left"><span class="tituloBD">' . htmlentities($elemento->getBiblio()) . '</span> <br/> <br/><div align="left" class="acceso">Acceso:&nbsp;&nbsp;';

                if ($elemento->getTipoAcceso() == "L") {
                    $html.= '<img src="' . $GLOBALS["app_route"] . '/images/accesos/local_p.gif" width="18" height="18"> &nbsp;';
                }

                if ($elemento->getTipoAcceso() == "F") {
                    $html.= '<img src="' . $GLOBALS["app_route"] . '/images/accesos/fijo_p.gif" width="18" height="18">&nbsp;';
                }

                if ($elemento->getTipoAcceso() == "R") {
                    $html.= '<img src="' . $GLOBALS["app_route"] . '/images/accesos/remoto_p.gif" width="18" height="18">';
                }

                /* if ($elemento->getTipoAcceso() == null || $elemento->getTipoAcceso() == "") {
                  $html.= '<img src="'.$GLOBALS["app_route"].'/images/accesos/local_p.gif" width="18" height="18">&nbsp;<img src="'.$GLOBALS["app_route"].'/images/accesos/fijo_p.gif" width="18" height="18">&nbsp;<img src="'.$GLOBALS["app_route"].'/images/accesos/remoto_p.gif" width="18" height="18">';
                  } */

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
    }

    return $html;
}
?>