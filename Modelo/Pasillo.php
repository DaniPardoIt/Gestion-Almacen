
<?php

class Pasillo{
  private $id;
  private $codigo;
  private $huecosTotales;
  private $huecosLibres;
  private $ocupacion;


  public function __construct($id, $codigo, $huecosTotales, $huecosLibres){
    $this->setId($id);
    $this->setCodigo($codigo);
    $this->setHuecosTotales($huecosTotales);
    $this->setHuecosLibres($huecosLibres);
    $this->setOcupacion(array($huecosTotales));
  }

  function getId() {
      return $this->id;
  }

  function getCodigo() {
    return $this->codigo;
  }

  function getHuecosTotales() {
      return $this->huecosTotales;
  }

  function getHuecosLibres() {
      return $this->huecosLibres;
  }

  function getOcupacion() {
      return $this->ocupacion;
  }

  function setId($id) {
      $this->id = $id;
  }

  function setCodigo($codigo) {
      $this->codigo = $codigo;
  }

  function setHuecosTotales($huecosTotales) {
      $this->huecosTotales = $huecosTotales;
  }

  function setHuecosLibres($huecosLibres) {
      $this->huecosLibres = $huecosLibres;
  }

  function setOcupacion($ocupacion) {
      $this->ocupacion = $ocupacion;
  }

  function verOcupacion(){
    $string = "Ocupacion: </br>";
    foreach($this->ocupacion as $o){
        $string = $string."$o->getId()</br>";
    }
    return $string;
  }

}