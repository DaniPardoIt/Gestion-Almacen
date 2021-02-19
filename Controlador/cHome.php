
<?php

include_once '../DAO/operaciones.php';
include_once '../Modelo/AppException.php';
session_start();
global $conexion;

try{
    $usuario = $_SESSION['usuario'];
    if($usuario == null){
        header("Location: ../Vista/vLogin.php");
        return;
    }

    $pasillos = operaciones::getPasillos();

    $_SESSION['pasillos'] = $pasillos;

    header("Location: ../Vista/vHome.php");
    return;
}catch(AppException $e){
    header("Location: ../Vista/vError.php?Error="+$e);
    return;
}

