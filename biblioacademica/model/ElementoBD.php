<?php
/**
 * Description of ElementoBD
 *
 * @author David Andrés Manzano - damanzano
 * @since 13/10/10
 */
class ElementoBD {

    private $titleno;
    private $biblio;
    private $resumen;
    private $imagen;
    private $masInfo;
    private $tipoAcceso;
    private $enlaceConsultar;

    public function getTitleno() {
        return $this->titleno;
    }

    public function setTitleno($titleno) {
        $this->titleno = $titleno;
    }

    public function getBiblio() {
        return $this->biblio;
    }

    public function setBiblio($biblio) {
        $this->biblio = $biblio;
    }

    public function getResumen() {
        return $this->resumen;
    }

    public function setResumen($resumen) {
        $this->resumen = $resumen;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function getMasInfo() {
        return $this->masInfo;
    }

    public function setMasInfo($masInfo) {
        $this->masInfo = $masInfo;
    }

    public function getTipoAcceso() {
        return $this->tipoAcceso;
    }

    public function setTipoAcceso($tipoAcceso) {
        $this->tipoAcceso = $tipoAcceso;
    }

    public function getEnlaceConsultar() {
        return $this->enlaceConsultar;
    }

    public function setEnlaceConsultar($enlaceConsultar) {
        $this->enlaceConsultar = $enlaceConsultar;
    }

}
?>

