
<?php
  
  include_once '../Modelo/Usuario.php';
  include_once '../Modelo/Pasillo.php';
  include_once '../Modelo/Estanteria.php';
  include_once '../Modelo/Caja.php';

  session_start();
  $usuario = $_SESSION['usuario'];
  $pasillos = $_SESSION['pasillos'];

?>

<html>
  <head>
    <?php include_once 'Estaticos/meta.php'; ?>
    <title>Inventory</title>
  </head>

  <body>
    <?php include_once 'Estaticos/header.php'; ?>
    <main>
      <section id="pasillosContainer">
        <h1>Pasillos</h1>
        <article class="pasillos">
          <?php
            foreach($pasillos as $pasillo){
              $contHueco = 0;
          ?>
          <div class="pasillo" id="<?=$pasillo->getId() ?>">
            <div class="filaHuecos">
              <?php
              for($i=1; $i<=ceil($pasillo->getHuecosTotales()/2); $i++){
              ?>
                <?php
                if($pasillo->getOcupacion()[$contHueco]){
                ?>
                  <div id="<?=$contHueco+1 ?>" class="hueco ocupado" onclick="verEstanteria(this)">
                    <h3><?= $contHueco+1 ?></h3>
                    <div class="bgHueco"></div>
                    <div class="opcionOculta">
                      <i class="far fa-eye"></i>
                      <h4>Ver Estanteria</h4>
                    </div>
                  </div>
                <?php
                }else{
                ?>
                <div id="<?=$contHueco+1 ?>" class="hueco" onclick="crearEstanteria(this)">
                  <h3><?= $contHueco+1 ?></h3>
                  <div class="bgHueco"></div>
                  <div class="opcionOculta">
                    <i class="fas fa-plus"></i>
                    <h4>Añadir Estanteria</h4>
                  </div>
                </div>
              <?php
                }
                $contHueco++;
              }
              ?>
            </div>

            <div class="nombrePasillo">
              <h2><?= $pasillo->getCodigo() ?></h2>
            </div>
            
            <div class="filaHuecos">
              <?php
              for($i=ceil($pasillo->getHuecosTotales()/2)+1; $i<=$pasillo->getHuecosTotales(); $i++){
              ?>
                <?php
                if($pasillo->getOcupacion()[$contHueco]){
                ?>
                  <div id="<?=$contHueco+1 ?>" class="hueco ocupado" onclick="verEstanteria(this)">
                    <h3><?= $contHueco+1 ?></h3>
                    <div class="bgHueco"></div>
                    <div class="opcionOculta">
                      <i class="far fa-eye"></i>
                      <h4>Ver Estanteria</h4>
                    </div>
                  </div>
                <?php
                }else{
                ?>
                <div id="<?=$contHueco+1 ?>" class="hueco" onclick="crearEstanteria(this)">
                  <h3><?= $contHueco+1 ?></h3>
                  <div class="bgHueco"></div>
                  <div class="opcionOculta">
                    <i class="fas fa-plus"></i>
                    <h4>Añadir Estanteria</h4>
                  </div>
                </div>
              <?php
                }
                $contHueco++;
              }
              ?>
            </div>
          </div>
          
          <?php
            }
          ?>
        </article>

      </section>
    </main>
    <?php include_once 'Estaticos/scripts.php' ?>
  </body>

</html>