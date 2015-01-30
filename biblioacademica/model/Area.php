<?php

/**
 * Description of Area
 *
 * @author David Andrés Manzano - damanzano
 * @since 11/02/11
 */
class Area {

    private $id;
    private $nombre;
    

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

}

?>
