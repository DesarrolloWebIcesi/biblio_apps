<?php

/**
 * Description of ControlBusquedaBD
 * Esta Clase se encarga de ejecutar la busqueda de las nuevas adquisiciones de la biblioteca
 * según los parametros establecidos por los usuarios y de almacenar los resultados en
 * un arreglo para su consulta.
 *
 * @author David Andrés Manzano - damanzano
 * @since 28/10/10
 * 
 * @version 2.0 Se modificó para que utilizara la verisón 2 de la clase de conexión a oracle
 * @since 2012-08-03 damanzano
 */
include_once ('../model/Area.php');
include_once ('../model/Adquisicion.php');
include_once ('../../commons/services/OracleServices2.php');

class ControlBusquedaNA {
    /* private $tamanno; */

    private $elementos = array();
    private $areas = array();

    /**
     * Cosntructor de la clase
     */
    public function ControlBusquedaNA() {
        $this->cargarAreas();
    }

    /**
     * Retorna el tamaño del arreglo generado por la consulta.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchNA($cont,$idArea). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 28/10/10
     */
    public function getSize() {
        return count($this->elementos);
    }

    /**
     * Retorna  un subarreglo del generado por la consulta de acuerdo a los parametros establecidos.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchNA($cont,$idArea). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 28/10/10
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
     * cargarSearchNA($cont,$idArea). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 28/10/10
     */
    public function getElementos() {
        return $this->elementos;
    }

    /**
     * Este método se encarga de buscar las nuevas adquisiciones registradas en el sistema que coincidan con
     * los parametrós de búsqueda
     *
     * @author damanzano
     * @since 28/10/10
     * @version 1.1 2013-04-05 damanzano
     * El concepto de nueva adquisición cambio debido a que el proceso de compra
     * y cataogación de un material puede tardar mucho más de un mes. Esto 
     * causaba que al momento de catalogar y definir las áreas ya habia pasado
     * más de 30 día desde la solicitud de compra y ya no eran consideradas 
     * nuevas adquisiciones, como resultado la lista de áreas en las que habian 
     * nuevas adquisiciones siempre estaba vacia. Bajo el nuevo esquema se 
     * considera una nueva adquisición aquellos titulos que han pasado de la 
     * fase de procesos técnicos a en circulación durante los últimos 30 días. 
     * Para ello se utilizará la fecha de acceso que ponen los catalogadores al 
     * momento en que se termina la catalogación de un título.
     * 
     * La consulta anterior era:
     * select e.title, e.titulo, e.autores, count(e.ejemplar)
     * from (select distinct t.titleno title, t.title titulo, decode(fbibbus_autores(t.titleno),null,'',fbibbus_autores(t.titleno)) autores, c.barcode ejemplar
     * from order_items oi, titles t, copies c, titleclasses tc, classes cl
     * where oi.oi_datereq >= (sysdate - 30) 
     * and tc.classmarkno = '" . $idArea . "'
     * and cl.classtp = 'AREA'
     * and t.titleno = oi.oi_titleno
     * and t.titleno = tc.titleno
     * and tc.classmarkno = cl.classmarkno
     * and c.titleno=t.titleno) e
     * group by e.title, e.titulo, e.autores
     *     
     * @param string $idArea área en la que se clasifican las nuevas adquisiciones
     */
    public function cargarSearchNA($cont, $idArea) {
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $conecto = $bd->conectar();

        $idConsulta = 0;
                
        $sql = "select e.title, e.titulo, e.autores, count(e.ejemplar)
                from (select distinct t.titleno title, t.title titulo, decode(fbibbus_autores(t.titleno),null,'',fbibbus_autores(t.titleno)) autores, c.barcode ejemplar
                from titles t, copies c, titleclasses tc, classes cl
                where t.accdate >= (sysdate - 30)
                and tc.classmarkno = '" . $idArea . "'
                and cl.classtp = 'AREA'
                and t.titleno = tc.titleno
                and tc.classmarkno = cl.classmarkno
                and c.titleno=t.titleno) e
                group by e.title, e.titulo, e.autores";

        //echo 'SQL: '.$sql.'<br/>';

        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();        

        while ($bd->siguienteFila($idConsulta)) {
            $adq = new Adquisicion();
            $adq->setTitulo($bd->dato($idConsulta, 2));
            $adq->setAutores($bd->dato($idConsulta, 3));
            $adq->setEjemplares($bd->dato($idConsulta, 4));
            $adq->setLink($GLOBALS["olib_webview"]."?infile=details.glu&oid=" . $bd->dato($idConsulta, 1));
            if ($adq->getAutores() == null || $adq->getAutores() == "null") {
                $adq->setAutores("");
            }
            $elementos[] = $adq;
        }
        $this->elementos = $elementos;
        $bd->desconectar();
    }

    /**
     * Este método retorna el área identificada con el id ingresado por parametro.
     *
     * @author damanzano
     * @since 28/10/10
     */
    public function obtenerArea($idArea) {
        $mi_area = null;
        for ($i = 0; ($i < count($this->areas)) && ($area_actual == false); $i = $i + 1) {
            $area = $this->areas[$i];
            if ($area->getId() == $idArea) {
                $area_actual = true;
                $mi_area = new Area();
                $mi_area->setId($area->getId());
                $mi_area->setNombre($area->getNombre());
            }
        }
        return $mi_area;
    }

    /**
     * Este método carga el listado de áreas para las cuales se hacen consultas de nuevas adquisiciones.
     *
     * @author damanzano
     * @since 28/10/10
     * @version 1.1 2013-04-05 damanzano
     * El concepto de nueva adquisición cambio debido a que el proceso de compra
     * y cataogación de un material puede tardar mucho más de un mes. Esto 
     * causaba que al momento de catalogar y definir las áreas ya habia pasado
     * más de 30 día desde la solicitud de compra y ya no eran consideradas 
     * nuevas adquisiciones, como resultado la lista de áreas en las que habian 
     * nuevas adquisiciones siempre estaba vacia. Bajo el nuevo esquema se 
     * considera una nueva adquisición aquellos titulos que han pasado de la 
     * fase de procesos técnicos a en circulación durante los últimos 30 días. 
     * Para ello se utilizará la fecha de acceso que ponen los catalogadores al 
     * momento en que se termina la catalogación de un título.
     * 
     * La consulta anterior era:
     * select distinct cl.classmark area, cl.classmarkno p_id_area 
     * from order_items oi, orders o, titles t, titleclasses tc, classes cl 
     * where o.ord_orderno = oi.oi_orderno 
     * and oi.oi_datereq >= (sysdate - 30) 
     * and t.titleno = oi.oi_titleno 
     * and t.titleno = tc.titleno 
     * and tc.classmarkno = cl.classmarkno 
     * and cl.classtp = 'AREA' 
     * order by cl.classmark asc;
     */
    private function cargarAreas() {
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $bd->conectar();
        
        $sql = "select distinct cl.classmark area, cl.classmarkno p_id_area from titles t, titleclasses tc, classes cl where t.accdate >= (sysdate - 30) and t.titleno = tc.titleno and tc.classmarkno = cl.classmarkno and cl.classtp = 'AREA' order by cl.classmark asc";

        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();
        while ($bd->siguienteFila($idConsulta)) {
            $elemento = new Area();
            $elemento->setId($bd->dato($idConsulta, 2));
            $elemento->setNombre($bd->dato($idConsulta, 1));
            $elementos[] = $elemento;
        }
        $this->areas = $elementos;
        $bd->desconectar();
    }

}

?>
