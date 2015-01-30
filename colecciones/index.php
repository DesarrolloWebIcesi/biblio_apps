<?php
/**
 * Página inicial de la aplicación de colecciones
 *
 * @author David Andrés Manzano - damanzano
 * @since 13/10/10
 *
 * @method Este archivo recibe un parametro $listado que le indica cual es el listado que se debe desplegar.
 * Este valor de $listado se recibirá por defecto del arreglo $JUMI[] debido a que la aplicación esta diseñada para
 * funcionar el Joomla! Sin embargo por razones de flexibilidad si el valor obtenido de este arreglo es null,
 * se tomará del areglo de parametros enviados por $_POST['listado']
 */
include_once 'Config.php';
$listado='';
if(empty ($jumi)){
    $listado=$_POST['listado'];
}else{
    $listado=$jumi[0];
}

switch ($listado){
    case 'lbd':
        include_once 'view/listadoBD.php';
        break;
    case 'lna':
        include_once 'view/listadoNuevasAdquisiciones.php';
        break;
    case 'lre':
        include_once 'view/listadoRevistas.php';
        break;
    case 'lmp':
        include_once 'view/listadoMapoteca.php';
        break;
    case 'lmm':
        include_once 'view/listadoMultimedia.php';
        break;
    case 'lsk':
        include_once 'view/listadoSonoteca.php';
        break;
    case 'lvk':
        include_once 'view/listadoVideoteca.php';
        break;
    case 'lce':
        include_once 'view/listadoCasosEstudio.php';
        break;
    default :
        echo 'No has seleccionado ningún listado';
}


?>
