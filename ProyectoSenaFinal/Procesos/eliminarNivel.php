<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Datos/Nivel/NivelDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


requerirAdmin();


if (!validarMetodoPost()) {

    redirigir("../Vistas/admin.php");

}


$idNivel = intval($_POST["id_nivel"] ?? 0);

if (!validarId($idNivel)) {

    die("ERROR: Nivel no válido.");

}


$nivelDAO = new NivelDAO();

$nivel = $nivelDAO->obtenerNivel($idNivel);

if ($nivel === null) {

    die("ERROR: El nivel no existe.");

}

if (!$nivelDAO->eliminarNivel($idNivel)) {

    die("ERROR: No se pudo eliminar el nivel.");

}

redirigir(
    "../Vistas/adminTema.php?id="
    . intval($nivel["id_tema"])
    . "&mensaje=nivel_eliminado"
);

?>
