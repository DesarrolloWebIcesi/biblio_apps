<?php

/**
 * Esta archivo genera el HTML necesario para el despliegue de los resultados de una búsqueda de bases de datos.
 *
 * @author David Andrés Manzano - damanzano
 * @since 24/11/10
 */
include_once ('../control/ControlBusquedaRevistas.php');
include_once ('../../commons/services/GeneralServices.php');
include_once ('../Config.php');


session_start();
$area=$_SESSION['parea'];
$cont = trim($_POST['cont']);
$size = trim($_POST['size']);
$newsearch = trim($_POST['newsearch']);

$cont = GeneralServices::parseInt($cont);
$size = GeneralServices::parseInt($size);

/* pruebas de consulta */
//echo "contador: " . $cont . "<br/>";
//echo "tamanno: " . $size . "<br/>";
//echo "buscar: " . $newsearch . "<br/>";
//echo "keyword: " . $pkeyword . "<br/>";
/* fin */
$controlBusqueda = $_SESSION['baresearcher'];
if ($controlBusqueda == null || $controlBusqueda == '') {
    $controlBusqueda = new ControlBusquedaRevistas();
    $_SESSION["baresearcher"] = $controlBusqueda;
}

if ($newsearch == 's') {
    $controlBusqueda->cargarSearchRevistas(0, $area);
}

$tamano = $controlBusqueda->getSize();
$elementos = array();
$elementos = $controlBusqueda->getElementosDesde($cont, $size);

/* pruebas de consulta */
//echo "# elementos de la pagina: ".count($elementos)."<br/>";
//echo "# elementos de la consulta: ".$tamano."<br/>";
/* fin */
echo HTMLResultadosRevistas($tamano, $elementos, $area);

/**
 * Imprime la estructura HTML nesaria para deplegar los elementos de la búsqueda
 *
 * @author damanzano
 * @since 24/11/10
 *
 * @param int $tamano Cantidad real de resultados que arrojo la búsqueda.
 * @param Array<Revista> $elementos Los elementos que desean mostrarse en una página.
 */
function HTMLResultadosRevistas($tamano, $elementos, $keyword) {
    //echo 'tamanño ='.$tamano.'<br>';
    $html = '';
    if ($tamano <= 0) {
        $html.= '<br/><br/>';
        $html.= '<div class="noelements">&nbsp;&nbsp; No existen m&aacute;s elementos por mostrar</div>';
        return $html;
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

?>
