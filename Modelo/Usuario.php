<?php

class Usuario {
  private $id;
  private $nombre;
  private $email;
  private $password;

  public function __construct($id, $nombre, $email){
    $this->setId($id);
    $this->setNombre($nombre);
    $this->setEmail($email);
  }
  
  public function getObject(){
    $obj = new stdClass;
    $obj->id = $this->getId();
    $obj->id = $this->getNombre();
    $obj->id =  $this->getEmail();

    return $obj;
  }

  public function __toString()
  {
    return "Nombre: ".$this->getNombre()."Email: ".$this->getEmail()."Id: ".$this->getId();
  }

  function setId($id){
    $this->id = $id;
  }
  
  function getId(){
    return $this->id;
  }
  
  function setNombre($nombre){
    $this->nombre = $nombre;
  }
  
  function getNombre(){
    return $this->nombre;
  }
  
  function setEmail($email){
    $this->email = $email;
  }
  
  function getEmail(){
    return $this->email;
  }
  
  function setPassword($password){
    $this->password = $password;
  }

  function getPassword(){
    return $this->password;
  }
}