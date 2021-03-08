<?php
include_once '../Modelo/Pasillo.php';
include_once '../Modelo/Estanteria.php';
include_once '../Modelo/Caja.php';
session_start();

$inventario = $_SESSION['inventario'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <?php include_once 'Estaticos/meta.php'; ?>
    <title>Inventory | Ver caja</title>
  </head>
</head>
<body>
  <?php include_once 'Estaticos/header.php'; ?>
  <main class="inventarioContainer">
    <section class="inventario">        
      <?php
      foreach($inventario as $pasillo){
        ?>
        <article class="pasillo">
          <h2>Pasillo: <?=$pasillo->getCodigo() ?></h2>
          <?php
          for($i=0; $i<count($pasillo->getOcupacion()); $i++){
            $estanteria = $pasillo->getOcupacion()[$i];
            if(!is_null($estanteria)){
              ?>
              <div class="estanteria">
                <h3>Estantería: <?=$estanteria->getCodigo() ?></h3>
                <?php
                for($j=0; $j<count($estanteria->getObjetos()); $j++){
                  $caja = $estanteria->getObjetos()[$j];
                  if(!is_null($caja)){
                  ?>
                  <div class="caja">
                    <h4>Caja: <?=$caja->getCodigo() ?></h4>
                    <div class="datosCaja">
                      <div class="datosHeader">
                        <h5 class="caja-color">Color</h5>
                        <h5 class="caja-alto">Alto</h5>
                        <h5 class="caja-ancho">Ancho</h5>
                        <h5 class="caja-largo">Largo</h5>
                        <h5 class="caja-material">Material</h5>
                        <h5 class="caja-contenido">Contenido</h5>
                      </div>
                      <div class="datosBody">
                        <div class="caja-color">
                          <svg style="width: 40px; height:40px" i:rulerorigin="0 0" overflow="visible" i:vieworigin="129.9341 392.8721" i:pagebounds="0 595.2764 841.8896 0" enable-background="new 0 0 188.873 223.338" xml:space="preserve" viewBox="0 0 188.873 223.338">
                            <polygon id="box-right" fill="#<?= $caja->getColor()?>" points="188.87 54.608 188.55 168.73 94.582 223.34 94.905 109.22" i:knockout="Off"></polygon>
                            <polygon fill="rgba(0,0,0,.45)" points="188.87 54.608 188.55 168.73 94.582 223.34 94.905 109.22" i:knockout="Off"></polygon>
                            <polygon id="box-left" fill="#<?= $caja->getColor()?>" points="94.905 109.22 94.582 223.34 0 168.73 0.323 54.608" i:knockout="Off"></polygon>
                            <polygon fill="rgba(0,0,0,.3)" points="94.905 109.22 94.582 223.34 0 168.73 0.323 54.608" i:knockout="Off"></polygon>
                            <polygon id="box-top" fill="#<?= $caja->getColor()?>" points="188.87 54.608 94.905 109.22 0.323 54.608 94.291 0" i:knockout="Off"></polygon>
                            <line y2="82.781" x1="47.769" i:knockout="Off" x2="141.84" stroke="#72512F" y1="27.226" stroke-width="2" fill="none"></line>
                            <polygon fill="rgb(225, 137, 78)" points="146.65 79.052 129.72 89.216 35.138 34.608 52.068 24.445" i:knockout="Off"></polygon>
                            <polygon fill="rgb(225, 137, 78)" points="146.76 78.939 146.75 109.15 129.52 119.46 129.53 89.252" i:knockout="Off"></polygon>
                            <polygon fill="rgba(0,0,0,.3)" points="146.76 78.939 146.75 109.15 129.52 119.46 129.53 89.252" i:knockout="Off"></polygon>
                          </svg>
                        </div>
                        <h5 class="caja-alto"><?= $caja->getAlto()?>cm</h5>
                        <h5 class="caja-ancho"><?= $caja->getAncho()?>cm</h5>
                        <h5 class="caja-largo"><?= $caja->getLargo()?>cm</h5>
                        <h5 class="caja-material"><?= $caja->getMaterial()?></h5>
                        <h5 class="caja-contenido"><?= $caja->getContenido()?></h5>
                      </div>
                    </div>
                  </div>
                  <?php
                  }
                }
                ?>
              </div>
              <?php
            }
          }
          ?>
        </article>
        <?php
      }
      ?>
    </section>
  </main>
  <?php include_once 'Estaticos/scripts.php' ?>
</body>
</html>