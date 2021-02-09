<?php 

include_once 'conexion.php';
include_once '../Modelo/AppException.php';
include_once '../Modelo/Usuario.php';

function login($email, $password){
    global $conexion;

    $sqlQuery = "SELECT * FROM usuario WHERE email='$email' AND password='$password'";
    $resul = $conexion->query($sqlQuery);

    if($resul->num_rows == 1){
      $row = $resul->fetch_assoc();
      $id = $row['id'];
      $nombre = $row['nombre'];

      $usuario = new Usuario($id, $nombre, $email);
      return $usuario;
    }else{
        throw new AppException("Email o contraseña incorrectos", 0101);
    }
}

