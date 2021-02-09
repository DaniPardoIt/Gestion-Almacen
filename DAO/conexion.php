<?php

header('Content-Type: application/json; charset=utf-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

$conexion = new mysqli("localhost", "root", "");
$conexion->set_charset("utf8");
$conexion->select_db("servidor_php_almacen_dpm") or die("Base de datos no encontrada");
if($conexion->connect_errno){
    echo json_encode("<br/>Cliente".$conexion->client_info."<br/>Error de la conexión: ".$conexion->connect_errno);
}else{
    /* echo json_encode("Conexión correcta: ".$conexion->client_info); */
}

/* echo json_encode("; v.".$conexion->client_version); */
?>