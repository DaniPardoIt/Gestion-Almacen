<?php
include_once "../DAO/operaciones.php";
include_once "../Modelo/Estanteria.php";
session_start();

try{
    $idPasillo = $_REQUEST['idPasillo'];
    $huecoPasillo = $_REQUEST['huecoPasillo'];
    $_SESSION['idPasillo'] = $idPasillo;
    $_SESSION['huecoPasillo'] = $huecoPasillo;  
  
    $estanteria = Operaciones::verEstanteria($idPasillo, $huecoPasillo);
    $_SESSION['estanteria'] = $estanteria;
    header("Location: ../Vista/vVerEstanteria.php");
    return;
}catch(AppException $e){
  header("Location: ../Vista/vError.php?Error=$e");
  return;
}