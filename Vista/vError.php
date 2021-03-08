<?php

$error = $_REQUEST['Error'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include_once 'Estaticos/meta.php'; ?>
  <title>Inventory | Error</title>
</head>
<body>
  <?php include_once 'Estaticos/header.php'; ?>
  <main>
    <h1><?=$error ?></h1>
  </main>
  <?php include_once 'Estaticos/scripts.php' ?>
</body>
</html>