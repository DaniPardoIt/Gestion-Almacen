<?php
include_once "../Modelo/Estanteria.php";
include_once "../Modelo/Caja.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <?php include_once 'Estaticos/meta.php'; ?>
    <title>Inventory | Salida Cajas</title>
  </head>
</head>
<body>
  <?php include_once 'Estaticos/header.php'; ?>
  <main class="salidaCajas">
    <h1>Salida de cajas</h1>
    <form id="salidaCajas">
      <h2>Escribe el código de la caja que quieres que salga del almacen</h2>
      <div class="formGroup">
        <label for="codigo"><h3>Código</h3></label>
        <input onchange="cambiaCodigoCajaSalida(this)" type="text" id="codigo" name="codigo" placeholder="Ej: CA001" maxlength="5">
        <p class="errorMsg">No hay ninguna caja con ese código</p>
      </div>
      <div id="cajaDiv" class="caja">
        
      </div>
      <div class="formGroup">
        <label for="checkbox"><h3>Confirmar</h3></label>
        <input type="checkbox" id="checkbox" name="checkbox">
        <p class="errorMsg">Este campo debe estar seleccionado</p>
      </div>
      <article class="buttonContainer">
        <button class="btn btn-cError" type="button" onclick="irAtras()">CANCELAR</button>
        <button class="btn btn-c1" type="button" onclick="checkFormSalirCaja()">SALIR CAJA</button>
      </article>
    </form>
  </main>
  <?php include_once 'Estaticos/scripts.php' ?>
</body>
</html>