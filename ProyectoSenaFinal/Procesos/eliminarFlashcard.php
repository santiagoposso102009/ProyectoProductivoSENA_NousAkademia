<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Datos/Flashcard/FlashcardDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


requerirAdmin();


if (!validarMetodoPost()) {

    redirigir("../Vistas/admin.php");

}


$idFlashcard = intval($_POST["id_flashcard"] ?? 0);

if (!validarId($idFlashcard)) {

    die("ERROR: Flashcard no válida.");

}


$flashcardDAO = new FlashcardDAO();

$flashcard = $flashcardDAO->obtenerFlashcard($idFlashcard);

if ($flashcard === null) {

    die("ERROR: La flashcard no existe.");

}

$idNivel = intval($flashcard["id_nivel"]);

if (!$flashcardDAO->eliminarFlashcard($idFlashcard)) {

    die("ERROR: No se pudo eliminar la flashcard.");

}

redirigir(
    "../Vistas/adminNivel.php?id=" . $idNivel
    . "&mensaje=flashcard_eliminada#lista"
);

?>
