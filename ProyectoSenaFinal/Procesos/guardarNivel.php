<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Datos/Tema/TemaDAO.php";

require_once __DIR__ . "/../Datos/Nivel/NivelDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


requerirAdmin();


if (!validarMetodoPost()) {

    redirigir("../Vistas/admin.php");

}


/* =====================================================
   RECIBIR DATOS
===================================================== */

$idTema = intval($_POST["id_tema"] ?? 0);

$nombre = trim($_POST["nombre"] ?? "");

$descripcion = trim($_POST["descripcion"] ?? "");


if (!validarId($idTema)) {

    die("ERROR: Tema no válido.");

}

$volver = "../Vistas/adminTema.php?id=" . $idTema;


/* =====================================================
   VALIDAR
===================================================== */

if (!validarTexto($nombre)) {

    redirigir($volver . "&mensaje=nivel_vacio");

}

if (
    !validarLongitudMaxima($nombre, 100)
    ||
    !validarLongitudMaxima($descripcion, 255)
) {

    redirigir($volver . "&mensaje=nivel_largo");

}


/* =====================================================
   REGISTRAR (el número se asigna automáticamente)
===================================================== */

$temaDAO = new TemaDAO();

if ($temaDAO->obtenerTema($idTema) === null) {

    die("ERROR: El tema no existe.");

}

$nivelDAO = new NivelDAO();

$numero = $nivelDAO->siguienteNumero($idTema);

$idNivel = $nivelDAO->registrarNivel(
    $idTema,
    $numero,
    $nombre,
    $descripcion
);

if ($idNivel === false) {

    die("ERROR: No se pudo crear el nivel.");

}

/* Se abre el nivel recién creado para agregar sus preguntas */

redirigir(
    "../Vistas/adminNivel.php?id=" . $idNivel
    . "&mensaje=nivel_creado#editor"
);

?>
