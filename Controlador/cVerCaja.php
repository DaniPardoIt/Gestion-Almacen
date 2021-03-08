<?php
include_once "../DAO/operaciones.php";
include_once "../Modelo/Caja.php";
session_start();

try{
  $idEstanteria = $_REQUEST['idEstanteria'];
  $leja = $_REQUEST['leja'];
  $idCaja = $_REQUEST['idCaja'];
  
  $caja = Operaciones::getCaja($idCaja);

  $_SESSION['caja'] = $caja;
  $_SESSION['idEstanteria'] = $idEstanteria;
  $_SESSION['leja'] = $leja;

  header("Location: ../Vista/vVerCaja.php");
  return;
}catch(AppException $e){
  header("Location: ../Vista/vError.php?Error=$e");
  return;
}