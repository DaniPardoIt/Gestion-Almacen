<?php

class Estanteria {
    
    private $id;
    private $codigo;
    private $lejas;
    private $material;
    private $lejasLibres;
    private $objetos = array();
    
    public function __construct($id, $codigo, $lejas, $material, $lejasLibres){
        $this->setId($id);
        $this->setCodigo($codigo);
        $this->setLejas($lejas);
        $this->setMaterial($material);
        $this->setLejasLibres($lejasLibres);
        $this->setObjetos(array($lejas));
    }
    
    public function addObjeto($obj){
        if($this->getLejasLibres()>0){
            $objetos[] = $obj;
        }
    }

    function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getLejas() {
        return $this->lejas;
    }

    function getMaterial() {
        return $this->material;
    }

    function getLejasLibres() {
        return $this->lejasLibres;
    }

    function getObjetos() {
        return $this->objetos;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setLejas($lejas) {
        $this->lejas = $lejas;
    }

    function setMaterial($material) {
        $this->material = $material;
    }

    function setLejasLibres($lejasLibres) {
        $this->lejasLibres = $lejasLibres;
    }

    function setObjetos($objetos) {
        $this->objetos = $objetos;
    }
}
