<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Datos/Tema/TemaDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


requerirAdmin();


if (!validarMetodoPost()) {

    redirigir("../Vistas/admin.php");

}


$idTema = intval($_POST["id_tema"] ?? 0);

if (!validarId($idTema)) {

    die("ERROR: Tema no válido.");

}


$temaDAO = new TemaDAO();

if (!$temaDAO->eliminarTema($idTema)) {

    die("ERROR: No se pudo eliminar el tema.");

}

redirigir("../Vistas/admin.php?mensaje=tema_eliminado");

?>
