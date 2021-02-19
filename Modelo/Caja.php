<?php

class Caja {
    private $id;
    private $codigo;
    private $alto;
    private $ancho;
    private $largo;
    private $color;
    private $material;
    
    public function __construct($codigo, $alto, $ancho, $largo, $color, $material) {
        $this->setCodigo($codigo);
        $this->setAlto($alto);
        $this->setAncho($ancho);
        $this->setLargo($largo);
        $this->setColor($color);
        $this->setMaterial($material);
    }
    
    public function calculaVolumen(){
        $volumen = $this->getAlto()*$this->getAncho()*$this->getLargo();
        return $volumen;
    }
    
    function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getAlto() {
        return $this->alto;
    }

    function getAncho() {
        return $this->ancho;
    }

    function getLargo() {
        return $this->largo;
    }

    function getColor() {
        return $this->color;
    }

    function getMaterial() {
        return $this->material;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setAlto($alto) {
        $this->alto = $alto;
    }

    function setAncho($ancho) {
        $this->ancho = $ancho;
    }

    function setLargo($largo) {
        $this->largo = $largo;
    }

    function setColor($color) {
        $this->color = $color;
    }

    function setMaterial($material) {
        $this->material = $material;
    }


}
