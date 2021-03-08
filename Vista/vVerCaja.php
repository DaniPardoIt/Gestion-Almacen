<?php
include_once '../Modelo/Pasillo.php';
include_once '../Modelo/Caja.php';

session_start();

$idEstanteria = $_SESSION['idEstanteria'];
$leja = $_SESSION['leja'];
$caja = $_SESSION['caja'];

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
  <main>
    <h3>IdEstanteria = <?=$idEstanteria ?></h3>
    <h3>leja = <?=$leja ?></h3>
    <h3>IdCaja = <?=$caja->getId() ?></h3>
  </main>
  <?php include_once 'Estaticos/scripts.php' ?>
</body>
</html>