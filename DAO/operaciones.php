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

  function checkCodigoEstanteria($codigo){
    global $conexion;
    $sqlQuery = "SELECT id FROM estanteria WHERE codigo='$codigo'";
    $resul = $conexion->query($sqlQuery);

    if($resul->num_rows > 0){
      return true;
    }else{
      return false;
    }
  }

  function crearEstanteria($codigo, $numLejas, $material, $fechaAlta, $idPasillo, $hueco){
    global $conexion;

    try{
      $conexion->autocommit(false); 
      $stmt = $conexion->prepare("INSERT INTO estanteria (id, codigo, lejas, lejasLibres, material, fecha_alta) VALUES (null,?,?,?,?,?)");
      if ($stmt === false) {
        throw new AppException("No se ha podido insertar la estantería", 0010);
      }
      $stmt->bind_param("siiss", $bCod, $bLejas, $bLejasLibres, $bMat, $bFechaAlta);
      $bCod = $codigo;
      $bLejas = $numLejas;
      $bLejasLibres = $numLejas;
      $bMat = $material;
      $bFechaAlta = $fechaAlta;
      $stmt->execute();
      if ($stmt === false) {
        throw new AppException("No se ha podido insertar la estantería", 0011);
      }

      if($stmt->affected_rows<1){
        throw new AppException("No se ha podido insertar la estantería", 0012);
      }

      $ultimo_id = $conexion->insert_id;

      $sql = "INSERT INTO estanteria_pasillo (id, idEstanteria, idPasillo, hueco)VALUES (null, $ultimo_id, $idPasillo, $hueco)";
      $resultado=$conexion->query($sql);
      if ($conexion-> affected_rows<1){
        throw new AppException("No se ha podido insertar la estantería en pasillo", 0013);
      }
      
      $sql = "UPDATE pasillo SET huecosLibres=(huecosLibres-1) WHERE id='$idPasillo'";$resultado=$conexion->query($sql);
      if ($conexion-> affected_rows<1){
        throw new AppException("No se ha podido actualizar huecosLibres de Pasillo", 0014);
      }

      $conexion->commit();
      $conexion->close(); 
    }catch(AppException $e){
      $conexion->rollback();
      $conexion->close(); 
      throw $e;
    }
  }

  function verEstanteria($idPasillo, $hueco){
    global $conexion;
    try{
      $sql = "SELECT * FROM estanteria WHERE id=(SELECT idEstanteria FROM estanteria_pasillo WHERE idPasillo='$idPasillo' AND hueco='$hueco')";
      $resul=$conexion->query($sql);

      if($resul->num_rows > 0){
        $row = $resul->fetch_assoc();
        $id = $row['id'];
        $codigo = $row['codigo'];
        $lejas = $row['lejas'];
        $material = $row['material'];
        $lejasLibres = $row['lejasLibres'];

        $estanteria = new Estanteria($id, $codigo, $lejas, $material, $lejasLibres);

        $estanteria->setObjetos(Operaciones::getObjetosEstanteria($id, $lejas));
        $conexion->close(); 
        return $estanteria;
      }else{
        throw new AppException("No se ha podido encontrar la estantería", 0015);
      }

    }catch(AppException $e){
      $conexion->close(); 
      throw $e;
    }
  }

  function getObjetosEstanteria($idEstanteria, $lejas){
    global $conexion;
    try{
      $arrayObjetos = array();
      $arrayIdObjetos = array();
      for($i=0; $i<$lejas; $i++){
        $arrayObjetos[$i] = null;
        $arrayIdObjetos[$i] = null;
      }

      $sql = "SELECT * FROM caja_estanteria WHERE idEstanteria=$idEstanteria";
      $resul=$conexion->query($sql);

      if($resul->num_rows > 0){
        while($row = $resul->fetch_assoc()){
          $idCaja = $row['idCaja'];
          $leja = $row['leja'];

          $arrayIdObjetos[$leja-1] = $idCaja;
        }
      }else{
        return $arrayObjetos;
      }

      for($i=0; $i<count($arrayIdObjetos); $i++){
        if($arrayIdObjetos[$i] != null){
          $sql = "SELECT * FROM caja WHERE id=$arrayIdObjetos[$i]";
          $resul=$conexion->query($sql);
          $row = $resul->fetch_assoc();
          $id = $arrayIdObjetos[$i];
          $codigo = $row['codigo'];
          $alto = $row['alto'];
          $ancho = $row['ancho'];
          $largo = $row['largo'];
          $color = $row['color'];
          $material = $row['material'];
          $contenido = $row['contenido'];

          $caja = new Caja($codigo, $alto, $ancho, $largo, $color, $material, $contenido);
          $caja->setId($id);

          $arrayObjetos[$i] = $caja;
        }
      }
      $conexion->close(); 
      return $arrayObjetos;

    }catch(AppException $e){
      $conexion->close(); 
      throw $e;
    }
  }

  function checkCodigoCaja($codigo){
    global $conexion;
    $sqlQuery = "SELECT id FROM caja WHERE codigo='$codigo'";
    $resul = $conexion->query($sqlQuery);

    if($resul->num_rows > 0){
      return true;
    }else{
      return false;
    }
  }

  function crearCaja($objCaja){
    global $conexion;

    $codigo = $objCaja->codigo;
    $alto = $objCaja->alto;
    $ancho = $objCaja->ancho;
    $largo = $objCaja->largo;
    $color = $objCaja->color;
    $material = $objCaja->material;
    $contenido = $objCaja->contenido;
    $fechaAlta = $objCaja->fechaAlta;
    $idEstanteria = $objCaja->idEstanteria;
    $huecoEstanteria = $objCaja->huecoEstanteria;

    try{
      $conexion->autocommit(false); 
      $stmt = $conexion->prepare("INSERT INTO caja (id, codigo, alto, ancho, largo, color, material, contenido, fechaAlta) VALUES (null,?,?,?,?,?,?,?,?)");
      if ($stmt === false) {
        throw new AppException("No se ha podido insertar la caja", 0020);
      }
      $stmt->bind_param("siiissss", $bCod, $bAlto, $bAncho, $bLargo, $bColor, $bMat, $bCont, $bFechAlta);
      $bCod = $codigo;
      $bAlto = $alto;
      $bAncho = $ancho;
      $bLargo = $largo;
      $bColor = $color;
      $bMat = $material;
      $bCont = $contenido;
      $bFechAlta = $fechaAlta;
      $stmt->execute();
      if ($stmt === false) {
        throw new AppException("No se ha podido insertar la caja", 0021);
      }

      if($stmt->affected_rows<1){
        throw new AppException("No se ha podido insertar la caja", 0022);
      }

      $ultimo_id = $conexion->insert_id;

      $sql = "INSERT INTO caja_estanteria (id, idCaja, idEstanteria, leja) VALUES (null, $ultimo_id, $idEstanteria, $huecoEstanteria)";
      $resultado=$conexion->query($sql);
      if ($conexion-> affected_rows<1){
        throw new AppException("No se ha podido insertar la caja en la estantería", 0023);
      }

      $sql = "UPDATE estanteria SET lejasLibres=(lejasLibres-1) WHERE id='$idEstanteria'";$resultado=$conexion->query($sql);
      if ($conexion-> affected_rows<1){
        throw new AppException("No se ha podido actualizar lejasLibres de la estanteria", 0024);
      }

      $conexion->commit();
      $conexion->close(); 
    }catch(AppException $e){
      $conexion->rollback();
      $conexion->close(); 
      throw $e;
    }
  }

  function getCaja($idCaja){
    global $conexion;
    try{
      $sql = "SELECT * FROM caja where id='$idCaja'";
      $resul=$conexion->query($sql);

      if($resul->num_rows > 0){
        $row = $resul->fetch_assoc();
        $id = intval($row['id']);
        $codigo = $row['codigo'];
        $alto = doubleval($row['alto']);
        $ancho = doubleval($row['ancho']);
        $largo = doubleval($row['largo']);
        $color = $row['color'];
        $material = $row['material'];
        $contenido = $row['contenido'];

        $caja = new Caja($codigo, $alto, $ancho, $largo, $color, $material, $contenido);
        $caja->setId($id);

        $conexion->close(); 
        return $caja;
      }else{
        throw new AppException("No se ha encontrado ninguna caja", 0025);
      }

    }catch(AppException $e){
      $conexion->close(); 
      throw $e;
    }
  }

  function getCajaPorCodigo($codigo){
    global $conexion;
    try{
      $sql = "SELECT * FROM caja where codigo='$codigo'";
      $resul=$conexion->query($sql);

      if($resul->num_rows > 0){
        $row = $resul->fetch_assoc();
        $id = intval($row['id']);
        $codigo = $row['codigo'];
        $alto = doubleval($row['alto']);
        $ancho = doubleval($row['ancho']);
        $largo = doubleval($row['largo']);
        $color = $row['color'];
        $material = $row['material'];
        $contenido = $row['contenido'];

        /* UTILIZO UNA stdClass para poder pasar los datos a cliente, ya que si lo hacemos con un modelo, los atributos no son visibles por cliente ya que sus atributos son private */
        $caja = new stdClass();
        $caja->id = $id;
        $caja->codigo = $codigo;
        $caja->alto = $alto;
        $caja->ancho = $ancho;
        $caja->largo = $largo;
        $caja->color = $color;
        $caja->material = $material;
        $caja->contenido = $contenido;
        $conexion->close(); 
        return $caja;
      }else{
        return false;
      }

    }catch(AppException $e){
      $conexion->close(); 
      throw $e;
    }
  }

  function verInventario(){
    $inventario = Operaciones::getPasillos();
    $estanterias = Operaciones::getEstanteriasCompletas();
    $estanterias_pasillos = Operaciones::getEstanteria_Pasillo();
    
    foreach($inventario as $pasillo){
      $ocupacion = array();
      $idPasillo = $pasillo->getId();
      for($i=0; $i<count($estanterias_pasillos); $i++){
        if($idPasillo == $estanterias_pasillos[$i]->idPasillo){
          foreach($estanterias as $estanteria){
            if($estanterias_pasillos[$i]->idEstanteria == $estanteria->getId()){
              $ocupacion[] = $estanteria;
            }
          }
        }
      }
      $pasillo->setOcupacion($ocupacion);
    }

    return $inventario;
  }
  
  function getCajas_Estanterias(){
    $cajas_estanteria = array();
    global $conexion;
    try{
      $sql = "SELECT * FROM caja_estanteria ORDER BY idEstanteria";
      $resul=$conexion->query($sql);
  
      if($resul->num_rows > 0){
        while($caja_estanteria = $resul->fetch_object()){
            $caja_estanteria->id = intval($caja_estanteria->id);
            $caja_estanteria->idCaja = intval($caja_estanteria->idCaja);
            $caja_estanteria->idEstanteria = intval($caja_estanteria->idEstanteria);
            $caja_estanteria->leja = intval($caja_estanteria->leja);
          $cajas_estanteria[] = $caja_estanteria;
        }
        
      }
  
    }catch(AppException $e){
      $conexion->close(); 
      throw $e;
    }
    return $cajas_estanteria;
  }

  function getCajas(){
    global $conexion;

    $cajas = array();
    try{
      $sql = "SELECT * FROM caja";
      $resul=$conexion->query($sql);
  
      if($resul->num_rows > 0){
        while($row = $resul->fetch_assoc()){
          $id = intval($row['id']);
          $codigo = $row['codigo'];
          $alto = doubleval($row['alto']);
          $ancho = doubleval($row['ancho']);
          $largo = doubleval($row['largo']);
          $color = $row['color'];
          $material = $row['material'];
          $contenido = $row['contenido'];
  
          $caja = new Caja($codigo, $alto, $ancho, $largo, $color, $material, $contenido);
          $caja->setId($id);
          $cajas[] = $caja;
        }
      }
  
    }catch(AppException $e){
      $conexion->close(); 
      throw $e;
    }
    return $cajas;
  }

  function getEstanterias(){
    global $conexion;

    $estanterias = array();
    try{
      $sql = "SELECT * FROM estanteria";
      $resul=$conexion->query($sql);
  
      if($resul->num_rows > 0){
        while($row = $resul->fetch_assoc()){
          $id = intval($row['id']);
          $codigo = $row['codigo'];
          $lejas = intval($row['lejas']);
          $material = $row['material'];
          $lejasLibres = intval($row['lejasLibres']);
  
          $estanteria = new Estanteria($id, $codigo, $lejas, $material, $lejasLibres);
          $estanteria->setId($id);
          $estanterias[] = $estanteria;
        }
        
      }
  
    }catch(AppException $e){
      $conexion->close(); 
      throw $e;
    }
    return $estanterias;
  }

  function getEstanteriasCompletas(){
    $estanterias = Operaciones::getEstanterias();
    $cajas_estanteria = Operaciones::getCajas_Estanterias();
    $cajas = Operaciones::getCajas();
    
    foreach($estanterias as $estanteria){
      $ocupacion = array();
      $idEstanteria = $estanteria->getId();
      for($i=0; $i<count($cajas_estanteria); $i++){
        if($idEstanteria == $cajas_estanteria[$i]->idEstanteria){
          foreach($cajas as $caja){
            if($cajas_estanteria[$i]->idCaja == $caja->getId()){
              $ocupacion[] = $caja;
              break;
            }
          }
        }
      }
      $estanteria->setObjetos($ocupacion);
    }

    return $estanterias;
  }

  function getEstanteria_Pasillo(){
    
    $estanterias_pasillos = array();
    global $conexion;
    try{
      $sql = "SELECT * FROM estanteria_pasillo ORDER BY idPasillo";
      $resul=$conexion->query($sql);
  
      if($resul->num_rows > 0){
        while($estanteria_pasillo = $resul->fetch_object()){
            $estanteria_pasillo->id = intval($estanteria_pasillo->id);
            $estanteria_pasillo->idEstanteria = intval($estanteria_pasillo->idEstanteria);
            $estanteria_pasillo->idPasillo = intval($estanteria_pasillo->idPasillo);
            $estanteria_pasillo->hueco = intval($estanteria_pasillo->hueco);
          $estanterias_pasillos[] = $estanteria_pasillo;
        }
        
      }
  
    }catch(AppException $e){
      $conexion->close(); 
      throw $e;
    }
    return $estanterias_pasillos;

  }

  function salidaCaja($codigo){
    global $conexion;

    try{
      $conexion->autocommit(false); 
      $stmt = $conexion->prepare("DELETE FROM caja WHERE codigo=?;");
      if ($stmt === false) {
        throw new AppException("No se ha podido borrar la caja", 0101);
      }
      $stmt->bind_param("s", $bCod);
      $bCod = $codigo;
      $stmt->execute();
      if ($stmt === false) {
        throw new AppException("No se ha podido borrar la caja", 0102);
      }

      if($stmt->affected_rows<1){
        throw new AppException("No se ha podido borrar la caja", 0102);
      }

      $conexion->commit();
      $conexion->close(); 
    }catch(AppException $e){
      $conexion->rollback();
      $conexion->close(); 
      throw $e;
    }
  }
}
