<?php


class Caja {
    public $id;
    public $codigo;
    public $alto;
    public $ancho;
    public $largo;
    public $color;
    public $material;
    
    public function __construct($codigo, $alto, $ancho, $largo, $color, $material) {
        $this->codigo = $codigo;
        $this->alto = $alto;
        $this->ancho = $ancho;
        $this->largo = $largo;
        $this->color = $color;
        $this->material = $material;
    }
    
    public function calculaVolumen(){
        $volumen = $alto*$ancho*$largo;
        return $volumen;
    }
}
