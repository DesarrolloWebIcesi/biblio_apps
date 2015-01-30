<?php
/**
 * Description of Revista
 *
 * @author David Andrés Manzano - damanzano
 */
class Revista {

    private $titleno;
    private $titulo;
    private $imagen;
    private $emisiones;
    private $issn;
    private $link;    

    public function getTitleno() {
        return $this->titleno;
    }

    public function setTitleno($titleno) {
        $this->titleno = $titleno;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function getEmisiones() {
        return $this->emisiones;
    }

    public function setEmisiones($emisiones) {
        $this->emisiones = $emisiones;
    }

    public function getISSN() {
        return $this->issn;
    }

    public function setISSN($issn) {
        $this->issn = $issn;
    }


    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }    
}

?>
