<?php

/**
 * Description of ControlBusquedaRevistas
 * Esta Clase se encarga de ejecutar la busqueda de los elementos de base de datos
 * según los parametros establecidos por los usuarios y de almacenar los resultados en
 * un arreglo para su consulta.
 *
 * @author David Andrés Manzano - damanzano
 * @since 24/11/10
 * 
 * @version 2.0 Se modificó para que utilizara la verisón 2 de la clase de conexión a oracle
 * @since 2012-08-03 damanzano
 */
include_once ('../model/Revista.php');
include_once ('../../commons/services/OracleServices2.php');
include_once ('../Config.php');

class ControlBusquedaRevistas {
    /* private $tamanno; */

    private $elementos = array();

    /**
     * Retorna el tamaño del arreglo generado por la consulta.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchRevistas($cont, $pkeyword). Si se hace de manera previa a la ejecucion de la consulta
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
     * cargarSearchRevistas($cont, $pkeyword). Si se hace de manera previa a la ejecucion de la consulta
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
     * cargarSearchBD($cont, $pBD, $pArea, $pTipoAcceso). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 24/11/10
     */
    public function getElementos() {
        return $this->elementos;
    }

    /**
     * Este método se encarga de buscar las bases de datos registradas en el sistema que coincidan con
     * los parametrós de búsqueda
     *
     * @author damanzano
     * @since 24/11/10
     *
     * @param string $pkeyword Palabra clave para la búsqueda
     */
    public function cargarSearchRevistas($cont, $pArea) {
        //exit;
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $conecto = $bd->conectar();

        $idConsulta = 0;
        $sql = "select r.titulono, r.titulo, r.imagen, r.issn, count(t2.titleno)
                from (select distinct t.titleno titulono, t.title titulo, o.locator imagen, ti.isn issn
                      from titles t, titleclasses tc, classes cl, titleobjs t_o, objects o, titleisns ti
                      where tc.titleno = t.titleno
                      and ti.titleno = t.titleno
                      and tc.classmarkno = cl.classmarkno
                      and tc.classtp = 'AREA'
                      and cl.classmarkno = '".$pArea."'
                      and t.mediatp in ('SER')
                      and t.titleno = t_o.titleno(+)
                      and t_o.objectno = o.objectno(+)
                      and t.title is not null) r, titles t2
                where t2.articleno=r.titulono
                group by r.titulono, r.titulo, r.imagen, r.issn
                order by r.titulo ASC";

        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();

        while ($bd->siguienteFila($idConsulta)) {
            $revista = new Revista();
            $revista->setTitleno($bd->dato($idConsulta,1));
            $revista->setTitulo($bd->dato($idConsulta, 2));
            $revista->setEmisiones($bd->dato($idConsulta,5));
            $revista->setISSN($bd->dato($idConsulta, 4));
            $revista->setLink($GLOBALS["olib_webview"]."?infile=details.glu&oid=" . $bd->dato($idConsulta, 1));
            $imagen = $bd->dato($idConsulta, 3);
            if ($imagen != null && $imagen != "null") {
                $revista->setImagen($imagen);
            } else {
                $revista->setImagen($GLOBALS["biblio_apps"].'/commons/images/no_image.jpg');
            }
            $elementos[] = $revista;
        }

        $this->elementos = $elementos;
        $bd->desconectar();
    }

    /**
     * Este método se encarga de buscar las bases de datos registradas en el sistema que coincidan con
     * los parametrós de búsqueda
     *
     * @author damanzano
     * @since 24/11/10
     *
     * @param string $pinicial Inicial del t&iacute;tulo de la revista
     */
    public function cargarSearchRevistasIni($cont, $pinicial) {
        //exit;
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $conecto = $bd->conectar();

        $idConsulta = 0;
        $sql = "select r.titulono, r.titulo, r.imagen, r.issn, count(t2.titleno)
                from (select distinct t.titleno titulono, t.title titulo, o.locator imagen, ti.isn issn
                      from titles t, titleclasses tc, titleobjs t_o, objects o, titleisns ti
                      where tc.titleno = t.titleno
                      and ti.titleno = t.titleno
                      and tc.classtp = 'AREA'
                      and t.mediatp in ('SER')
                      and t.titleno = t_o.titleno(+)
                      and t_o.objectno = o.objectno(+)
                      and t.title is not null
                      and (lower (t.n_title) like(lower ('".$pinicial."') || '%'))) r, titles t2
                where t2.articleno=r.titulono
                group by r.titulono, r.titulo, r.imagen, r.issn
                order by r.titulo ASC";

        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();

        while ($bd->siguienteFila($idConsulta)) {
            $revista = new Revista();
            $revista->setTitleno($bd->dato($idConsulta,1));
            $revista->setTitulo($bd->dato($idConsulta, 2));
            $revista->setEmisiones($bd->dato($idConsulta,5));
            $revista->setISSN($bd->dato($idConsulta, 4));
            $revista->setLink($GLOBALS["olib_webview"]."?infile=details.glu&oid=" . $bd->dato($idConsulta, 1));
            $imagen = $bd->dato($idConsulta, 3);
            if ($imagen != null && $imagen != "null") {
                $revista->setImagen($imagen);
            } else {
                $revista->setImagen($GLOBALS["app_route"].'/images/no_image.jpg');
            }
            $elementos[] = $revista;
        }

        $this->elementos = $elementos;
        $bd->desconectar();
    }

}

?>
