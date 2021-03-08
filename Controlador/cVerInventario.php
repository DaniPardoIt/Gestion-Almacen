<?php
include_once "../DAO/operaciones.php";
include_once "../Modelo/Estanteria.php";
session_start();

try{
  $inventario = Operaciones::verInventario();
  $_SESSION['inventario'] = $inventario;

  header("Location: ../Vista/vVerInventario.php");
  return;
}catch(AppException $e){
  header("Location: ../Vista/vError.php?Error=$e");
  return;
}