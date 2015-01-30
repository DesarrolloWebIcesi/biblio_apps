<?php
/**
 * Formulario que sirve de interfaz entre la página de la bibliteca y el sistema web de Olib
 *
 * @author David Andrés Manzano - damanzano
 * @since 17/03/11
 *
 * @method Este archivo recibe un parametro $vista que le indica cual es el tipo de vista que se debe desplegar.
 * Este valor de $vista se recibirá por defecto del arreglo $JUMI[] debido a que la aplicación esta diseñada para
 * funcionar en Joomla! Sin embargo por razones de flexibilidad si el valor obtenido de este arreglo es null,
 * se tomará del areglo de parametros enviados por $_POST['listado']
 */
include_once 'Config.php';
$vista='';
if(empty ($jumi)){
    $vista=$_POST['vista'];
}else{
    $vista=$jumi[0];
}

switch ($vista){
    case 'normal':
        include_once 'view/normal.php';
        break;
    case 'mini':
        include_once 'view/mini.php';
        break;
    default :
        include_once 'view/normal.php';
}



?>
