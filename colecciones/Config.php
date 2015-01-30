<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author David Andrés Manzano Herrera - damanzano
 * 
 * @version 2.0 Se agregó a las variables globales la ruta de olib webview para efectos paso entre entornos debido a la migración a olib820
 */
global $biblio_apps;
global $app_route;
global $olib_webview;
$biblio_apps="biblio_apps";
$app_route="biblio_apps/colecciones";
$olib_webview="http://biblioteca2.icesi.edu.co/cgi-olib/"
//$GLOBALS['biblio_apps']="biblio_apps";
/*class Config {
    public static $app_route="biblio_apps/colecciones";
    public static $biblio_apps="biblio_apps";
}*/
?>
