<?php

header('Content-Type: application/json; charset=utf-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
include_once "../DAO/operaciones.php";
include_once "../Modelo/Estanteria.php";

$obj = $_REQUEST['obj'];
$obj = json_decode($obj);
$codigo = $obj->codigo;
$numLejas = $obj->numLejas;
$material = $obj->material;
$fechaAlta = $obj->fechaAlta;
$idPasillo = $obj->idPasillo;
$hueco = $obj->hueco;


try{
  Operaciones::crearEstanteria($codigo, $numLejas, $material, $fechaAlta, $idPasillo, $hueco);
  $string = "Estantería: $codigo, insertada correctamente";
  header("Location: ../Controlador/cHome.php?Msg=$string");
  return;
}catch(AppException $e){
  header("Location: ../Vista/vError.php?Error=$e");
  return;
}



