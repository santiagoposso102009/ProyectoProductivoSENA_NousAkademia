<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Datos/Tema/TemaDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


/* =====================================================
   SOLO ADMINISTRADOR
===================================================== */

requerirAdmin();


if (!validarMetodoPost()) {

    redirigir("../Vistas/admin.php");

}


/* =====================================================
   RECIBIR DATOS
===================================================== */

$nombre = trim($_POST["nombre"] ?? "");

$descripcion = trim($_POST["descripcion"] ?? "");


/* =====================================================
   VALIDAR
===================================================== */

if (!validarTexto($nombre)) {

    redirigir("../Vistas/admin.php?mensaje=tema_vacio");

}

if (!validarLongitudMaxima($nombre, 100)) {

    redirigir("../Vistas/admin.php?mensaje=tema_largo");

}

if (!validarLongitudMaxima($descripcion, 500)) {

    redirigir("../Vistas/admin.php?mensaje=descripcion_larga");

}


/* =====================================================
   REGISTRAR
===================================================== */

$temaDAO = new TemaDAO();

if ($temaDAO->existeTema($nombre)) {

    redirigir("../Vistas/admin.php?mensaje=tema_existente");

}

$idTema = $temaDAO->registrarTema($nombre, $descripcion);

if ($idTema === false) {

    die("ERROR: No se pudo crear el tema.");

}

redirigir(
    "../Vistas/adminTema.php?id="
    . $idTema
    . "&mensaje=tema_creado"
);

?>
