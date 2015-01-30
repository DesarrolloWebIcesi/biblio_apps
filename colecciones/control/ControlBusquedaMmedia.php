<?php

/**
 * Description of ControlBusquedaMmedia
 * Esta Clase se encarga de ejecutar la busqueda de los elementos multimedia
 * según los parametros establecidos por los usuarios y de almacenar los resultados en
 * un arreglo para su consulta.
 *
 * @author David Andrés Manzano - damanzano
 * @since 23/12/10
 * 
 * @version 2.0 Se modificó para que utilizara la verisón 2 de la clase de conexión a oracle
 * @since 2012-08-03 damanzano
 */
include_once ('../model/ElementoMultimedia.php');
include_once ('../../commons/services/OracleServices2.php');

class ControlBusquedaMmedia {
    /* private $tamanno; */

    private $elementos = array();

    /**
     * Retorna el tamaño del arreglo generado por la consulta.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchMmedia($cont, $pkeyword). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 23/12/10
     */
    public function getSize() {
        return count($this->elementos);
    }

    /**
     * Retorna  un subarreglo del generado por la consulta de acuerdo a los parametros establecidos.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchMmedia($cont, $pkeyword). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 23/12/10
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
     * cargarSearchMmedia($cont, $pkeyword). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 23/12/10
     */
    public function getElementos() {
        return $this->elementos;
    }

    /**
     * Este método se encarga de buscar los elementos multimedia registradas en el sistema que coincidan con
     * los parametrós de búsqueda
     *
     * @author damanzano
     * @since 23/12/10
     *
     * @param string $pkeyword Palabra clave para la búsqueda
     */
    public function cargarSearchMmedia($cont, $pkeyword) {
        //exit;
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $conecto = $bd->conectar();

        $idConsulta = 0;
        $sql = "SELECT t2.titleno, t2.title, fbibus_bibliografiaxtitulo (t2.titleno) biblio, t2.abstract, o.locator imagen
                FROM titles t2, titleobjs t_o, objects o
                WHERE  t2.titleno = t_o.titleno(+)
                AND t_o.objectno = o.objectno(+)
                AND t2.titleno IN (
                  SELECT DISTINCT t1.titleno
                  FROM titles t1
                  WHERE t1.medium IN ('CDR', 'DVD')
                  AND t1.mediatp IN ('DVD', 'CD', 'CUR', 'REF')                  
                  AND t1.titleno IN (
                    SELECT tc.titleno
                    FROM classes cl, titleclasses tc
                    WHERE tc.titleno = t1.titleno
                    AND tc.classmarkno = cl.classmarkno
                    AND cl.classtp = 'AREA'))
                AND t2.articleno IS NULL
                AND (LOWER (t2.n_title) LIKE ('%' || LOWER ('".$pkeyword."') || '%')
                  OR LOWER (t2.n_subtitle) LIKE ('%' || LOWER ('".$pkeyword."') || '%')
                  OR LOWER (fbibus_bibliografiaxtitulo (t2.titleno)) LIKE ('%' || LOWER ('".$pkeyword."') || '%')
                  OR fbibus_abstract (t2.titleno, '".$pkeyword."') = 1)
                ORDER BY t2.title ASC";
        
        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();

        while ($bd->siguienteFila($idConsulta)) {
            $emmedia = new ElementoMultimedia();
            $emmedia->setTitleno($bd->dato($idConsulta, 1));
            $emmedia->setTitulo($bd->dato($idConsulta, 2));
            $emmedia->setResumen($bd->dato($idConsulta, 3));

            $abstract=$bd->dato($idConsulta, 4);
            if($abstract!=null && $abstract!=''){
                $emmedia->setAbstract($abstract);
            }else{
                $emmedia->setAbstract("Sin resumen");
            }            
            $emmedia->setLink($GLOBALS["olib_webview"]."?infile=details.glu&oid=" . $bd->dato($idConsulta, 1));

            $imagen = $bd->dato($idConsulta, 5);
            if ($imagen != null && $imagen != "null") {
                $emmedia->setImagen($imagen);
            } else {
                $emmedia->setImagen($GLOBALS["app_route"].'/images/no_mediaimage.png');
            }
            $elementos[] = $emmedia;
        }

        $this->elementos = $elementos;
        $bd->desconectar();
    }    

}

?>
