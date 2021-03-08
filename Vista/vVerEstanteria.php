<?php
include_once '../Modelo/Pasillo.php';
include_once '../Modelo/Estanteria.php';
include_once '../Modelo/Caja.php';

session_start();

$idPasillo = intval($_SESSION['idPasillo']);
$huecoPasillo = intval($_SESSION['huecoPasillo']);
$estanteria = $_SESSION['estanteria'];

$arrayObjetos = $estanteria->getObjetos();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <?php include_once 'Estaticos/meta.php'; ?>
    <title>Inventory | Ver estantería</title>
  </head>
</head>
<body>
  <?php include_once 'Estaticos/header.php'; ?>
  <main class="crearEstanteria">
    <section id="estanteriaContainer">
      <h2 id="h2Codigo"><?=$estanteria->getCodigo() ?></h2>
      <div id="<?= $estanteria->getId()?>" class="estanteria">
      <?php
      for($i=0; $i<$estanteria->getLejas(); $i++){
        if($arrayObjetos[$i] != null){
          ?>
          <div id="<?=$i+1 ?>" class="leja lejaOcupada" onclick="verCaja(this)">
            <div id="<?=$arrayObjetos[$i]->getId() ?>"class="cajaLeja">
              <svg style="width: 35px; height:35px" i:rulerorigin="0 0" overflow="visible" i:vieworigin="129.9341 392.8721" i:pagebounds="0 595.2764 841.8896 0" enable-background="new 0 0 188.873 223.338" xml:space="preserve" viewBox="0 0 188.873 223.338">
                <polygon id="box-right" fill="#<?=$arrayObjetos[$i]->getColor() ?>" points="188.87 54.608 188.55 168.73 94.582 223.34 94.905 109.22" i:knockout="Off"></polygon>
                <polygon fill="rgba(0,0,0,.45)" points="188.87 54.608 188.55 168.73 94.582 223.34 94.905 109.22" i:knockout="Off"></polygon>
                <polygon id="box-left" fill="#<?=$arrayObjetos[$i]->getColor() ?>" points="94.905 109.22 94.582 223.34 0 168.73 0.323 54.608" i:knockout="Off"></polygon>
                <polygon fill="rgba(0,0,0,.3)" points="94.905 109.22 94.582 223.34 0 168.73 0.323 54.608" i:knockout="Off"></polygon>
                <polygon id="box-top" fill="#<?=$arrayObjetos[$i]->getColor() ?>" points="188.87 54.608 94.905 109.22 0.323 54.608 94.291 0" i:knockout="Off"></polygon>
                <line y2="82.781" x1="47.769" i:knockout="Off" x2="141.84" stroke="#72512F" y1="27.226" stroke-width="2" fill="none"></line>
                <polygon fill="rgb(225, 137, 78)" points="146.65 79.052 129.72 89.216 35.138 34.608 52.068 24.445" i:knockout="Off"></polygon>
                <polygon fill="rgb(225, 137, 78)" points="146.76 78.939 146.75 109.15 129.52 119.46 129.53 89.252" i:knockout="Off"></polygon>
                <polygon fill="rgba(0,0,0,.3)" points="146.76 78.939 146.75 109.15 129.52 119.46 129.53 89.252" i:knockout="Off"></polygon>
              </svg>
              <h4>Cod: <?=$arrayObjetos[$i]->getCodigo() ?></h4>
            </div>
            <div class="verCajaHover">
                <h4>Ver Caja</h4>
                <i class="fas fa-eye"></i>
            </div>
        </div>
          <?php
        }else{
          ?>
          <div id="ES<?=$i ?>" class="leja lejaVacia" onclick="addCaja(this)">
            <div>
              <h4>Añadir Caja</h4>
              <i class="fas fa-plus"></i>
            </div>
          </div>
          <?php
        }
      }
      ?>
      </div>
    </section>
    <section id="datosEstanteriaContainer">
      <h1>VER ESTANTERÍA</h1>
      <article class="datosPasillo">
        <h3>Pasillo: <span id="idPasillo"><?= $idPasillo?></span></h3>
        <h3>Hueco: <span id="huecoPasillo"><?= $huecoPasillo?></span></h3>
      </article>

    </section>
  </main>
  <?php include_once 'Estaticos/scripts.php' ?>
</body>
</html>