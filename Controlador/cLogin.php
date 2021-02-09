
<?php
include_once '../DAO/operaciones.php';
include_once '../Modelo/Usuario.php';
global $conexion;

try{
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    
    $usuario = login($email, $password);
    session_start();
    $_SESSION['usuario'] = $usuario;
    echo json_encode(true);
}catch(AppException $e){
    echo json_encode($e);
}


