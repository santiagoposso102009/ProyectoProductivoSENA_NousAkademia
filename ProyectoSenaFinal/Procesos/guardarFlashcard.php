<?php

/* =====================================================
   CREA O EDITA UNA FLASHCARD (solo administrador)

   El formulario trae 4 opciones y marca cuál es la
   correcta. Aquí se convierte al formato de la tabla:
   respuesta + incorrecta_1/2/3.
===================================================== */

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Datos/Nivel/NivelDAO.php";

require_once __DIR__ . "/../Datos/Flashcard/FlashcardDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


$idAdmin = requerirAdmin();


if (!validarMetodoPost()) {

    redirigir("../Vistas/admin.php");

}


/* =====================================================
   RECIBIR DATOS
===================================================== */

$idNivel = intval($_POST["id_nivel"] ?? 0);

$idFlashcard = intval($_POST["id_flashcard"] ?? 0);

$pregunta = trim($_POST["pregunta"] ?? "");

$opciones = [

    1 => trim($_POST["opcion_1"] ?? ""),

    2 => trim($_POST["opcion_2"] ?? ""),

    3 => trim($_POST["opcion_3"] ?? ""),

    4 => trim($_POST["opcion_4"] ?? "")

];

$correcta = $_POST["correcta"] ?? "";

$pista = trim($_POST["pista"] ?? "");

$explicacion = trim($_POST["explicacion"] ?? "");


if (!validarId($idNivel)) {

    die("ERROR: Nivel no válido.");

}


$nivelDAO = new NivelDAO();

$nivel = $nivelDAO->obtenerNivel($idNivel);

if ($nivel === null) {

    die("ERROR: El nivel no existe.");

}

$flashcardDAO = new FlashcardDAO();

$editando = ($idFlashcard > 0);

$volver = "../Vistas/adminNivel.php?id=" . $idNivel;

$volverError = $volver . ($editando ? "&editar=" . $idFlashcard : "");


/* =====================================================
   SI SE EDITA: la flashcard debe ser de este nivel
===================================================== */

if ($editando) {

    $existente = $flashcardDAO->obtenerFlashcard($idFlashcard);

    if (
        $existente === null
        ||
        intval($existente["id_nivel"]) !== $idNivel
    ) {

        die("ERROR: La pregunta no pertenece a este nivel.");

    }

}


/* =====================================================
   VALIDAR
===================================================== */

if (!validarTexto($pregunta)) {

    redirigir($volverError . "&mensaje=flashcard_vacia#editor");

}

foreach ($opciones as $opcion) {

    if (!validarTexto($opcion)) {

        redirigir($volverError . "&mensaje=flashcard_vacia#editor");

    }

}

if (!validarOpcionCorrecta($correcta)) {

    redirigir($volverError . "&mensaje=flashcard_sin_correcta#editor");

}

if (
    !validarLongitudMaxima($pregunta, 1000)
    ||
    !validarLongitudMaxima($opciones[1], 500)
    ||
    !validarLongitudMaxima($opciones[2], 500)
    ||
    !validarLongitudMaxima($opciones[3], 500)
    ||
    !validarLongitudMaxima($opciones[4], 500)
    ||
    !validarLongitudMaxima($pista, 300)
    ||
    !validarLongitudMaxima($explicacion, 1000)
) {

    redirigir($volverError . "&mensaje=flashcard_larga#editor");

}

if (!validarOpcionesDistintas($opciones)) {

    redirigir($volverError . "&mensaje=flashcard_repetida#editor");

}


/* =====================================================
   SEPARAR LA CORRECTA DE LAS INCORRECTAS
===================================================== */

$correcta = intval($correcta);

$respuesta = $opciones[$correcta];

$incorrectas = [];

foreach ($opciones as $numero => $opcion) {

    if ($numero !== $correcta) {

        $incorrectas[] = $opcion;

    }

}


/* =====================================================
   GUARDAR
===================================================== */

if ($editando) {

    $guardada = $flashcardDAO->actualizarFlashcard(
        $idFlashcard,
        $pregunta,
        $respuesta,
        $incorrectas[0],
        $incorrectas[1],
        $incorrectas[2],
        $pista,
        $explicacion
    );

    if (!$guardada) {

        die("ERROR: No se pudo actualizar la pregunta.");

    }

    redirigir($volver . "&mensaje=flashcard_actualizada#lista");

}

$idNueva = $flashcardDAO->registrarFlashcard(
    $idNivel,
    $idAdmin,
    $pregunta,
    $respuesta,
    $incorrectas[0],
    $incorrectas[1],
    $incorrectas[2],
    $pista,
    $explicacion
);

if ($idNueva === false) {

    die("ERROR: No se pudo guardar la pregunta.");

}

redirigir($volver . "&mensaje=flashcard_creada#editor");

?>
