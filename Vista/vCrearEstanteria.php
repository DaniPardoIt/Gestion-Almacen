<?php
include_once '../Modelo/Pasillo.php';

session_start();

$idPasillo = intval($_REQUEST['idPasillo']);
$hueco = intval($_REQUEST['hueco']);

$_SESSION['idPasillo'] = $idPasillo;
$_SESSION['hueco'] = $hueco;
$pasillos = $_SESSION['pasillos'];

foreach($pasillos as $p){
  if($p->getId() == $idPasillo){
    $pasillo = $p;
    break;
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <?php include_once 'Estaticos/meta.php'; ?>
    <title>Inventory | Crea una estantería</title>
  </head>
</head>
<body>
  <?php include_once 'Estaticos/header.php'; ?>
  <main class="crearEstanteria">
    <section id="estanteriaContainer">
      <h2 id="h2Codigo">Código</h2>
      <div id = "estanteria" class="estanteria">
      </div>
    </section>
    <section id="datosEstanteriaContainer">
      <h1>CREAR UNA ESTANTERÍA</h1>
      <article class="datosPasillo">
        <h3>Pasillo: <span id="idPasillo"><?= $pasillo->getId()?></span></h3>
        <h3>Hueco: <span id="hueco"><?= $hueco?></span></h3>
      </article>
      <form action="../Controlador/cCrearEstanteria.php">
        <div class="greatFormGroup">

          <div class="formGroup">
            <label for="codigo">Código</label>
            <input  type="text" id="codigo" maxlength="5" onchange="cambiaCodigoEstanteria(this)" placeholder="Ej: ES001">
            <p class="errorMsg">Este campo no es válido</p>
          </div>
          <div class="formGroup">
            <label for="numLejas">Número de lejas</label>
            <input type="number" id="numLejas" onchange="cambiaLejasEstanteria(this)" placeholder="Máx. 15 lejas" value="1">
            <p class="errorMsg">Este campo no es válido</p>
          </div>
        </div>

        <div class="greatFormGroup">
          <div class="formGroup">
            <label for="material">Material</label>
            <input type="text" id="material" placeholder="Ej: Acero" onchange="checkMaterialInput()">
            <p class="errorMsg">Este campo no es válido</p>
          </div>
          <div class="formGroup">
            <label for="fechaAlta">Fecha de Alta</label>
            <input type="date" id="fechaAlta" onchange="checkFechaAltaInput()">
            <p class="errorMsg">Este campo no es válido</p>
          </div>
        </div>
      </form>
      <article class="buttonContainer">
        <button class="btn btn-cError" type="button" onclick="irAHome()">CANCELAR</button>
        <button class="btn btn-c1" type="button" onclick="checkFormCrearEstanteria()">CREAR ESTANTERÍA</button>
      </article>
    </section>
  </main>
  <?php include_once 'Estaticos/scripts.php' ?>
</body>
</html>