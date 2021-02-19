<?php 

include_once 'conexion.php';
include_once '../Modelo/AppException.php';
include_once '../Modelo/Usuario.php';
include_once '../Modelo/Pasillo.php';
include_once '../Modelo/Estanteria.php';
include_once '../Modelo/Caja.php';

class Operaciones{

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

  function getPasillos(){
    global $conexion;
  
    $sqlQuery = "SELECT * FROM pasillo";
    $resul = $conexion->query($sqlQuery);

    $pasillos = array();

    if($resul->num_rows > 0){
      while($row = $resul->fetch_assoc()){
        $id = intval($row['id']);
        $codigo = $row['codigo'];
        $huecosTotales = intval($row['huecosTotales']);
        $huecosLibres = intval($row['huecosLibres']);
        
        $pasillo = new Pasillo($id, $codigo, $huecosTotales, $huecosLibres);

        $ocupacion = operaciones::getEstanteriasPasillo($id, $huecosTotales);
        $pasillo->setOcupacion($ocupacion);

        $pasillos[] = $pasillo;
      }
      
    }
    return $pasillos;
  }

  function getEstanteriasPasillo($idPasillo, $huecosTotales){
    global $conexion;
    $estanterias = array();

    for($i=0; $i<$huecosTotales; $i++){
      $estanterias[] = null;
    }

    $sqlQuery = "SELECT * FROM estanteria_pasillo WHERE idPasillo='$idPasillo'";
    $resul = $conexion->query($sqlQuery);

    if($resul->num_rows > 0){
      while($row = $resul->fetch_assoc()){
        $id = $row['id'];
        $idEstanteria = $row['idEstanteria'];
        $hueco = $row['hueco'];

        $estanteria = operaciones::getEstanteriaById($idEstanteria);
        if(!$estanteria){
          throw new AppException("Error al buscar una estantería", 01002);
        }
        $estanterias[$hueco-1] = $estanteria;
      }
    }

    return $estanterias;
  }

  function getEstanteriaById($idEstanteria){
    global $conexion;
    $sqlQuery = "SELECT * FROM estanteria WHERE id='$idEstanteria'";
    $resul = $conexion->query($sqlQuery);

    if($resul->num_rows > 0){
      $row = $resul->fetch_assoc();
      $id = $row['id'];
      $codigo = $row['codigo'];
      $lejas = $row['lejas'];
      $material = $row['material'];
      $lejasLibres = $row['lejasLibres'];

      $estanteria = new Estanteria($id, $codigo, $lejas, $material, $lejasLibres);
      return $estanteria;
    }else{
      return false;
    }
  }
}