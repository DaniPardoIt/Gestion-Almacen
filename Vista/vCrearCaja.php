<?php
include_once "../Modelo/Estanteria.php";
include_once "../Modelo/Caja.php";
session_start();

$estanteria = $_SESSION['estanteria'];

$idEstanteria = $_REQUEST['idEstanteria'];
$huecoEstanteria = $_REQUEST['huecoEstanteria'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <?php include_once 'Estaticos/meta.php'; ?>
    <title>Inventory | Crear Caja</title>
  </head>
</head>
<body>
  <?php include_once 'Estaticos/header.php'; ?>
  <main class="crearCaja">
    <section class="gridCaja">
      <article class="infoCaja">
        <div class="infoEstanteria">
          <h3>Estantería: <span id="codEstanteria"><?=$estanteria->getCodigo()?></span></h3>
          <input id="idEstanteria" type="number" value="<?=$idEstanteria ?>" style="display: none;">
          <h3>Hueco: <span id="huecoEstanteria"><?=$huecoEstanteria?></span></h3>
        </div>
        <div class="cajaContainer">
          <h2 id="codigoCaja">Código</h2>
          <svg style="width: 150px; height:150px" i:rulerorigin="0 0" overflow="visible" i:vieworigin="129.9341 392.8721" i:pagebounds="0 595.2764 841.8896 0" enable-background="new 0 0 188.873 223.338" xml:space="preserve" viewBox="0 0 188.873 223.338">
            <polygon id="box-right" fill="#AD7546" points="188.87 54.608 188.55 168.73 94.582 223.34 94.905 109.22" i:knockout="Off"></polygon>
            <polygon fill="rgba(0,0,0,.45)" points="188.87 54.608 188.55 168.73 94.582 223.34 94.905 109.22" i:knockout="Off"></polygon>
            <polygon id="box-left" fill="#AD7546" points="94.905 109.22 94.582 223.34 0 168.73 0.323 54.608" i:knockout="Off"></polygon>
            <polygon fill="rgba(0,0,0,.3)" points="94.905 109.22 94.582 223.34 0 168.73 0.323 54.608" i:knockout="Off"></polygon>
            <polygon id="box-top" fill="#AD7546" points="188.87 54.608 94.905 109.22 0.323 54.608 94.291 0" i:knockout="Off"></polygon>
            <line y2="82.781" x1="47.769" i:knockout="Off" x2="141.84" stroke="#72512F" y1="27.226" stroke-width="2" fill="none"></line>
            <polygon fill="rgb(225, 137, 78)" points="146.65 79.052 129.72 89.216 35.138 34.608 52.068 24.445" i:knockout="Off"></polygon>
            <polygon fill="rgb(225, 137, 78)" points="146.76 78.939 146.75 109.15 129.52 119.46 129.53 89.252" i:knockout="Off"></polygon>
            <polygon fill="rgba(0,0,0,.3)" points="146.76 78.939 146.75 109.15 129.52 119.46 129.53 89.252" i:knockout="Off"></polygon>
          </svg>
        </div>
      </article>
      <article class="datosCaja">
        <h1>Crear una caja</h1>
        <form>
          <div class="greatFormGroup">
            <div class="formGroup">
              <label for="codigo"><h3>Código</h3></label>
              <input onchange="cambiaCodigoCaja(this)" type="text" id="codigo" name="codigo" placeholder="Ej: CA001" maxlength="5">
              <p class="errorMsg">Este campo no es válido</p>
            </div>
            <div class="formGroup">
              <label for="material">
                <h3>Material</h3>
              </label>
              <input onchange="checkSimpleString(this)" type="text" id="material" name="material" placeholder="Ej: Cartón" value="Cartón">
              <p class="errorMsg">Este campo no es válido</p>
            </div>
            <div class="formGroup">
              <label for="color">
                <h3>Color</h3>
              </label>
              <input type="color" id="color" name="color" value="#AD7546" onchange="cambiaColorCaja(this.value)">
              <p class="errorMsg">Este campo no es válido</p>
            </div>
          </div>
          <div class="greatFormGroup">
            <div class="formGroup">
              <label for="alto"><h3>Alto</h3></label>
              <input onchange="checkMedidaCaja(this)" id="alto" name="alto" type="number" placeholder="Ej: 125 (cm)">
              <p class="errorMsg">Este campo no es válido</p>
            </div>
            <div class="formGroup">
              <label for="ancho"><h3>Ancho</h3></label>
              <input onchange="checkMedidaCaja(this)" id="ancho" name="ancho" type="number" placeholder="Ej: 125 (cm)">
              <p class="errorMsg">Este campo no es válido</p>
            </div>
            <div class="formGroup">
              <label for="largo"><h3>Largo</h3></label>
              <input onchange="checkMedidaCaja(this)" id="largo" name="largo" type="number" placeholder="Ej: 125 (cm)">
              <p class="errorMsg">Este campo no es válido</p>
            </div>
          </div>
          <div class="formGroup">
            <label for="contenido"><h3>Contenido</h3></label>
            <input onchange="checkSimpleString(this)" type="text" id="contenido" name="contenido" placeholder="Ej: Bolígrafos">
            <p class="errorMsg">Este campo no es válido</p>
          </div>
          <div class="formGroup">
            <label for="fechaAlta"><h3>Fecha de Alta</h3></label>
            <input onchange="checkFechaAltaInput()" type="date" id="fechaAlta" name="fechaAlta" placeholder="Ej: Bolígrafos">
            <p class="errorMsg">Este campo no es válido</p>
          </div>
        </form>
        <article class="buttonContainer">
          <button class="btn btn-cError" type="button" onclick="irAtras()">CANCELAR</button>
          <button class="btn btn-c1" type="button" onclick="checkFormCrearCaja()">CREAR CAJA</button>
        </article>
      </article>
    </section>
  </main>
  <?php include_once 'Estaticos/scripts.php' ?>
</body>
</html>