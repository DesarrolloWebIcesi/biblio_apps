<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$pagina = $jumi[0];
switch ($pagina){
    case "servicios":
        header("Location: /biblioteca/#tab_servicios");
        break;
    case "busqueda":
        header("Location: /biblioteca/#tab_busqueda");
        break;
    case "recursos":
        header("Location: /biblioteca/#tab_recursos");
        break;
    case "comunidad":
        header("Location: /biblioteca/#tab_comunidad");
        break;
}
?>
