<?php

/**
 * Esta archivo genera el HTML necesario para el despliegue de los resultados de una búsqueda elementos multimedia.
 *
 * @author David Andrés Manzano - damanzano
 * @since 24/11/10
 */
include_once ('../control/ControlBusquedaMmedia.php');
include_once ('../../commons/services/GeneralServices.php');
include_once ('../Config.php');


session_start();
$cont = trim($_POST['cont']);
$size = trim($_POST['size']);
$newsearch = trim($_POST['newsearch']);
$pkeyword = trim($_POST['pkeyword']);

$cont = GeneralServices::parseInt($cont);
$size = GeneralServices::parseInt($size);
if ($pkeyword == null) {
    $pkeyword = "";
}

/* pruebas de consulta */
//echo "contador: " . $cont . "<br/>";
//echo "tamanno: " . $size . "<br/>";
//echo "buscar: " . $newsearch . "<br/>";
//echo "keyword: " . $pkeyword . "<br/>";
/* fin */
$controlBusqueda = $_SESSION['mmediasearcher'];
if ($controlBusqueda == null || $controlBusqueda == '') {
    $controlBusqueda = new ControlBusquedaMmedia();
    $_SESSION["mmediasearcher"] = $controlBusqueda;
}

if ($newsearch == 's') {
    $controlBusqueda->cargarSearchMmedia(0, $pkeyword);
}

$tamano = $controlBusqueda->getSize();
$elementos = array();
$elementos = $controlBusqueda->getElementosDesde($cont, $size);

/* pruebas de consulta */
//echo "# elementos de la pagina: ".count($elementos)."<br/>";
//echo "# elementos de la consulta: ".$tamano."<br/>";
/* fin */
echo HTMLResultadosMmedia($tamano, $elementos, $pkeyword);

/**
 * Imprime la estructura HTML nesaria para deplegar los elementos de la búsqueda
 *
 * @author damanzano
 * @since 24/11/10
 *
 * @param int $tamano Cantidad real de resultados que arrojo la búsqueda.
 * @param Array<Mapa> $elementos Los elementos que desean mostrarse en una página.
 * @param string $keyword palabra clave
 */
function HTMLResultadosMmedia($tamano, $elementos, $keyword) {
    //echo 'tamanño ='.$tamano.'<br>';
    $html = '';
    if ($tamano <= 0) {
        $html.= '<br/><br/>';
        $html.= '<div class="noelements">&nbsp;&nbsp; No existen m&aacute;s elementos por mostrar</div>';
    } else {
        $mensaje = ($keyword != null && $keyword != "") ? 'para: ' . htmlentities($keyword) : '';
        $html.= '<div class="subtitulo">Resultados de elementos multimedia ' . $mensaje . '</div>';
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
                            <div class="map">
                                <div class="map_image" width="40%">
                                    <div>
                                        <a href="' . $elemento->getLink() . '" target="_blank">
                                            <img src="' . $elemento->getImagen() . '"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="map_info" width="55%">
                                    <span class="map_info_title">
                                        <a href="' . $elemento->getLink() . '" target="_blank">
                                            <strong>' . htmlentities($elemento->getTitulo()) . '</strong>
                                        </a>
                                    </span>
                                    <span class="map_info_biblio">
                                        <strong>Bibliograf&iacute;a:</strong> ' . htmlentities($elemento->getResumen()) . '
                                    </span>
                                    <span class="map_info_biblio">
                                        <strong>Resumen:</strong> ' . htmlentities($elemento->getAbstract()) . '
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

?>
