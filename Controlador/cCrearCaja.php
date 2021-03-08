<?php
include_once "../DAO/operaciones.php";
include_once "../Modelo/Estanteria.php";
session_start();

try{
  $obj = $_REQUEST['obj'];
  $obj = json_decode($obj);
  
  Operaciones::crearCaja($obj);

  $idPasillo = $_SESSION['idPasillo'];
  $huecoPasillo = $_SESSION['huecoPasillo'];

  header("Location: ../Controlador/cVerEstanteria.php?idPasillo=$idPasillo&huecoPasillo=$huecoPasillo");
  return;
}catch(AppException $e){
  header("Location: ../Vista/vError.php?Error=$e");
  return;
}