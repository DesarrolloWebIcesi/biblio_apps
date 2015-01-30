<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once  ('../control/ControlAreas.php');
include_once ('../../commons/services/GeneralServices.php');
include_once ('../Config.php');

session_start();
$controlAreas = $_SESSION["controlAreas"];
if ($controlAreas == null || $controlAreas == '') {
    $controlAreas = new ControlAreas();
    $_SESSION["controlAreas"] = $controlAreas;
}

$controlAreas->cargarAreas();
$tamano = $controlAreas->getSize();
$elementos = array();
$elementos = $controlAreas->getElementos();

echo '<script type="text/javascript" src="'.$GLOBALS["app_route"].'/js/lareas_effects.js" charset="iso-8859-1"></script>';
echo HTMLResultadosBD($tamano, $elementos);

function HTMLResultadosBD($tamano, $elementos) {
    //echo 'tamanño ='.$tamano.'<br>';
    $html = '';
    if ($tamano <= 0) {
        $html.= '<br/><br/>';
        $html.= '<div class="noelements">&nbsp;&nbsp; No existen m&aacute;s elementos por mostrar</div>';
    }
    $filas=intval(count($elementos)/4);
    $f=0;
    $html.='<div id="result_block">';
	$html.='<p>Escoge el &Aacute;rea que deseas consultar</p>';
    $html.='<table class="areas_result" style="width:100%">';    
    for ($i=0; (($i< count($elementos))&& ($f< $filas)); $f++) {        
        $html.='<tr>';
        for($j=0;$j<4;$j++, $i++){
            $elemento = $elementos[$i];
            $html.='<td>';
            $html.='<div class="area ui-widget-content ui-corner-all" id="'.$elemento->getId().'"><h3>'.htmlentities($elemento->getNombre()).'</h3></div>';
            $html.='</td>';
        }
        $html.='</tr>';
    }
    $html.='</table>'; 
    $html.='</div>';    
    return $html;
}
?>