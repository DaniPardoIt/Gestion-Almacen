<?php

class Estanteria {
    
    public $id;
    public $codigo;
    public $lejas;
    public $material;
    public $objetos = array();
    
    public function __construct($codigo, $lejas, $material){
        $this->codigo = $codigo;
        $this->lejas = $lejas;
        $this->material = $material;
    }
    
    public function addObjeto($obj){
        if(lejasLibres()>0){
            $objetos[] = $obj;
        }
    }
    
    public function lejasLibres(){
        $lejasLibres = $lejas - count($objetos);
        return $lejasLibres;
    }
}
