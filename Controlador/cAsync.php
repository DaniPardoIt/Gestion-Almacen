<?php
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

include_once "../DAO/operaciones.php";

$obj = $_REQUEST['obj'];
$obj = json_decode($obj);

$metodo = $obj->metodo;

switch ($metodo){
  case "checkCodigoEstanteria":
    echo json_encode(operaciones::checkCodigoEstanteria($obj->cod));
    break;

  case "checkCodigoCaja":
    echo json_encode(operaciones::checkCodigoCaja($obj->cod));
    break;

  case "checkCodigoCajaSalida":
    echo json_encode(operaciones::getCajaPorCodigo($obj->cod));
    break;
}