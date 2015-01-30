<?php

/**
 * Description of ControlBusquedaMapas
 * Esta Clase se encarga de ejecutar la busqueda de los mapas
 * según los parametros establecidos por los usuarios y de almacenar los resultados en
 * un arreglo para su consulta.
 *
 * @author David Andrés Manzano - damanzano
 * @since 24/11/10
 * 
 * @version 2.0 Se modificó para que utilizara la verisón 2 de la clase de conexión a oracle
 * @since 2012-08-03 damanzano
 */
include_once ('../model/Mapa.php');
include_once ('../../commons/services/OracleServices2.php');
include_once ('../Config.php');

class ControlBusquedaMapas {
    /* private $tamanno; */

    private $elementos = array();

    /**
     * Retorna el tamaño del arreglo generado por la consulta.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchMapas($cont, $pkeyword). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 24/11/10
     */
    public function getSize() {
        return count($this->elementos);
    }

    /**
     * Retorna  un subarreglo del generado por la consulta de acuerdo a los parametros establecidos.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchMapas($cont, $pkeyword). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 24/11/10
     *
     * @param int $cont Indica a partir de que posición del arreglo original se desa el subarreglo.
     * @param int $size Indica el tamaños del subarreglo deseado.
     */
    public function getElementosDesde($cont, $size) {
        $newElementos = array();
        for ($i = $cont, $j = 0; ($i < count($this->elementos) && $j < $size); $i++, $j++) {
            $newElementos[] = $this->elementos[$i];
        }
        return $newElementos;
    }

    /**
     * Retorna el  arreglo generado por la consulta.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchMapas($cont, $pkeyword). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 24/11/10
     */
    public function getElementos() {
        return $this->elementos;
    }

    /**
     * Este método se encarga de buscar los mapas registradas en el sistema que coincidan con
     * los parametrós de búsqueda
     *
     * @author damanzano
     * @since 24/11/10
     *
     * @param string $pkeyword Palabra clave para la búsqueda
     */
    public function cargarSearchMapas($cont, $pArea) {
        //exit;
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $conecto = $bd->conectar();

        $idConsulta = 0;
        $sql = "SELECT t.titleno, t.title, fbibus_bibliografiaxtitulo (t.titleno) || ' -- [' || s.title || ']' bibliografia, o.locator imagen
                FROM titles t, titleseries ts, series s, titleobjs t_o, objects o, classes cl, titleclasses tc
                WHERE t.mediatp = 'CART'
                AND t.titleno = ts.titleno
                AND ts.seriesno = s.seriesno                
                AND tc.classmarkno = cl.classmarkno 
                AND tc.titleno = t.titleno
                AND cl.classtp = 'AREA' 
                AND cl.classmarkno = '".$pArea."'  
                AND t.titleno = t_o.titleno(+)
                AND t_o.objectno = o.objectno(+)";
        
        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();

        while ($bd->siguienteFila($idConsulta)) {
            $mapa = new Mapa();
            $mapa->setTitleno($bd->dato($idConsulta, 1));
            $mapa->setTitulo($bd->dato($idConsulta, 2));
            $mapa->setResumen($bd->dato($idConsulta, 3));
            $mapa->setLink($GLOBALS["olib_webview"]."?infile=details.glu&oid=" . $bd->dato($idConsulta, 1));
            $imagen = $bd->dato($idConsulta, 4);
            if ($imagen != null && $imagen != "null") {
                $mapa->setImagen($imagen);
            } else {
                $mapa->setImagen($GLOBALS["biblio_apps"].'/commons/images/no_mapimage.jpg');
            }
            $elementos[] = $mapa;
        }

        $this->elementos = $elementos;
        $bd->desconectar();
    }    

}

?>
