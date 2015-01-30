
<?php
/**
 * Este archivo recibe por POST el nombre de la lista que se desea desplegar y retorna
 * el codigo HTML requerido para llenar los elementos select correspondientes
 *
 * @author David Andrés Manzano - damanzano
 * @since 15/10/10
 */
include_once '../control/ControlListasDesplegables.php';

$lista=$_POST['listtype'];
switch ($lista){
    case "nombresbd":
        echo HTMLNombresBD();
        break;
    case  "areasbd":
        echo HTMLAreasBD();
        break;
    case "tiposacceso":
        echo HTMLTiposAcceso();
        break;
    case "areasna":
        echo HTMLAreasAquisiciones();
        break;
    default :
        return '<option value="">Seleccione</option>';
}

/**Funciones Usadas para la impresión**/

/**
 * Imprime los OPTIONS para la lista de nombres de bases de datos.
 * 
 * @author damanzano
 * @since 15/10/10
 */
function HTMLNombresBD() {
    $nombresBD = ControlListasDesplegables::getNombresBD();
    $html = '<option value="">Todas</option>';
    if ($nombresBD != null) {
        //echo count($nombresBD);
        for ($i = 0; $i < count($nombresBD); $i++) {
            $elementoGenerico = $nombresBD[$i];
            $html.='<option value="' . $elementoGenerico->getId() . '">' . htmlentities($elementoGenerico->getDescripcion()) . '</option>';
        }
    }
    return $html;
}

/**
 * Imprime los OPTIONS para la lista de tipos de accedo a bases de datos.
 *
 * @author damanzano
 * @since 15/10/10
 */
function HTMLTiposAcceso() {
    $tiposAcceso = ControlListasDesplegables::getTiposAcceso();
    $html = '<option value="">Todos</option>';
    if ($tiposAcceso  != null) {
        for ($i = 0; $i < count($tiposAcceso); $i++) {
            $elementoGenerico = $tiposAcceso [$i];
            $html.='<option value="'.$elementoGenerico->getId().'">'.htmlentities($elementoGenerico->getDescripcion()).'</option>';
        }
    }
    return $html;
}

/**
 * Imprime los OPTIONS para la lista de áreas de las bases de datos.
 *
 * @author damanzano
 * @since 15/10/10
 */
function HTMLAreasBD() {
    $areasBD = ControlListasDesplegables::getAreasBD();
    $html = '<option value="">Todas</option>';
    if ($areasBD != null) {
        for ($i = 0; $i < count($areasBD); $i++) {
            $elementoGenerico = $areasBD[$i];
            $html.='<option value="' . $elementoGenerico->getId() . '">' . htmlentities($elementoGenerico->getDescripcion()) . '</option>';
        }
    }
    return $html;
}

/**
 * Imprime los OPTIONS para la lista de áreas de nuevas adquisiciones
 *
 * @author damanzano
 * @since 26/10/10
 */
function HTMLAreasAquisiciones(){
    $areasAdq=ControlListasDesplegables::getAreasAdq();
    $html = '<option value="">Seleccione</option>';
    if($areasAdq !=null){
        for ($i = 0; $i < count($areasAdq); $i++) {
            $area = $areasAdq[$i];
            $html.='<option value="' . $area->getId() . '">' . htmlentities($area->getNombre()) . '</option>';
        }
    }
    return $html;
}


?>
