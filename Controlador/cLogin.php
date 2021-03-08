
<?php
include_once '../DAO/operaciones.php';
include_once '../Modelo/Usuario.php';
session_start();
try{
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    
    $usuario = Operaciones::login($email, $password);
    $_SESSION['usuario'] = $usuario;
    echo json_encode(true);
}catch(AppException $e){
    echo json_encode(utf8_encode($e->getMessage()));
}


