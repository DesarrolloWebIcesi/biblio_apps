<?php
/**
 * Página inicial de la aplicación de flickrgallery
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
include_once 'view/index.php';

?>
