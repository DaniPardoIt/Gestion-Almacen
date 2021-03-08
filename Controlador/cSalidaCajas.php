<?php
include_once "../DAO/operaciones.php";
session_start();

try{
  $objJSON = $_REQUEST['objJSON'];
  $obj = json_decode($objJSON);

  Operaciones::salidaCaja($obj->codigo);
  $msg = "Salida de caja cod: $obj->codigo correcta";
  header("Location: ../Vista/vHome.php?msg=$msg");
  return;
}catch(AppException $e){
  header("Location: ../Vista/vError.php?Error=$e");
  return;
}