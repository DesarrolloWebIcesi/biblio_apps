<?php

/**
 * Description of Area
 *
 * @author David Andrés Manzano - damanzano
 * @since 13/10/10
 */
class Area {

    private $id;
    private $nombre;
    private $ultimasAdquisiciones = array();

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getUltimasAdquisiciones() {
        return $this->ultimasAdquisiciones;
    }

    public function setUltimasAdquisiciones($ultimasAdquisiciones) {
        $this->ultimasAdquisiciones = $ultimasAdquisiciones;
    }

}

?>
