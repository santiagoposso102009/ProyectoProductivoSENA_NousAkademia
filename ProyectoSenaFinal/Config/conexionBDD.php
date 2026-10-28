<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$baseDatos = "nous_akademia";


$conexion = new mysqli(
    $servidor,
    $usuario,
    $password,
    $baseDatos
);


if ($conexion->connect_error) {

    die(
        "Error de conexión con la base de datos: "
        . $conexion->connect_error
    );

}


$conexion->set_charset("utf8mb4");

?>
