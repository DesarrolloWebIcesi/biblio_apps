<?php

/**
 * Description of ControlBusquedaCasos
 * Esta Clase se encarga de ejecutar la busqueda de los elementos La colección casos de estudio
 * según los parametros establecidos por los usuarios y de almacenar los resultados en
 * un arreglo para su consulta.
 *
 * @author David Andrés Manzano - damanzano
 * @since 24/11/10
 * 
 * @version 2.0 Se modificó para que utilizara la verisón 2 de la clase de conexión a oracle
 * @since 2012-08-03 damanzano
 */
include_once ('../model/CasoEstudio.php');
include_once ('../../commons/services/OracleServices2.php');

class ControlBusquedaCasos {

    private $elementos = array();

    /**
     * Retorna el tamaño del arreglo generado por la consulta.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchCasos($cont, $pkeyword). Si se hace de manera previa a la ejecucion de la consulta
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
     * cargarSearchCasos($cont, $pkeyword). Si se hace de manera previa a la ejecucion de la consulta
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
     * cargarSearchCasos($cont, $pkeyword). Si se hace de manera previa a la ejecucion de la consulta
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
    public function cargarSearchCasos($cont, $pkeyword) {
        //exit;
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $conecto = $bd->conectar();

        $idConsulta = 0;
        $sql = "SELECT t.titleno, t.title, fbibus_bibliografiaxtitulo (t.titleno) biblio, t.abstract, o.locator imagen
                FROM titles t,  titleobjs t_o, objects o
                WHERE t.articleno IS NULL
                AND (LOWER (t.n_title) LIKE ('%' || LOWER ('".$pkeyword."') || '%')
		    OR LOWER (t.n_subtitle) LIKE ('%' || LOWER ('".$pkeyword."') || '%')
                    OR LOWER (fbibus_bibliografiaxtitulo (t.titleno)) LIKE ('%' || LOWER ('".$pkeyword."') || '%')
                    OR fbibus_abstract (t.titleno, '".$pkeyword."') = 1)
                AND t.titleno IN (
                    SELECT DISTINCT c.titleno
		    FROM copies c, classes cl, titleclasses tc
                    WHERE c.copycat = 'CASO'
                    AND tc.titleno = c.titleno
                    AND tc.classmarkno = cl.classmarkno
		    AND cl.classtp = 'AREA')
                AND t.titleno = t_o.titleno(+)
                AND t_o.objectno = o.objectno(+)
                ORDER BY t.title ASC";
        
        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();

        while ($bd->siguienteFila($idConsulta)) {
            $caso = new CasoEstudio();
            $caso->setTitleno($bd->dato($idConsulta, 1));
            $caso->setTitulo($bd->dato($idConsulta, 2));
            $caso->setResumen($bd->dato($idConsulta, 3));
            
            $abstract=$bd->dato($idConsulta, 4);
            if($abstract!=null && $abstract!=''){
                $caso->setAbstract($abstract);
            }else{
                $caso->setAbstract("Sin resumen");
            }
            $caso->setLink($GLOBALS["olib_webview"]."?infile=details.glu&oid=" . $bd->dato($idConsulta, 1));

            $imagen = $bd->dato($idConsulta, 5);
            if ($imagen != null && $imagen != "null") {
                $caso->setImagen($imagen);
            } else {
                $caso->setImagen($GLOBALS["app_route"].'/images/no_caseimage.png');
            }
            $elementos[] = $caso;
        }

        $this->elementos = $elementos;
        $bd->desconectar();
    }    

}

?>
