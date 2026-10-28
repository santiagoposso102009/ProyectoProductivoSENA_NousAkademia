<?php

/* =====================================================
   COMPRUEBA UNA RESPUESTA DURANTE LA PRÁCTICA
   (la llama practica.js con fetch y responde en JSON)

   La respuesta correcta nunca viaja al navegador antes
   de contestar: se revela aquí, ya comprobada, y el
   resultado se guarda en la sesión del servidor.
===================================================== */

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Datos/Flashcard/FlashcardDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


function responderJson($codigo, $datos)
{

    http_response_code($codigo);

    header("Content-Type: application/json; charset=utf-8");

    echo json_encode($datos, JSON_UNESCAPED_UNICODE);

    exit;

}


/* =====================================================
   COMPROBAR SESIÓN Y MÉTODO
===================================================== */

if (!isset($_SESSION["id_usuario"])) {

    responderJson(401, ["error" => "Debes iniciar sesión."]);

}

if (!validarMetodoPost()) {

    responderJson(405, ["error" => "Solicitud no válida."]);

}


/* =====================================================
   RECIBIR Y VALIDAR DATOS
===================================================== */

$idNivel = intval($_POST["id_nivel"] ?? 0);

$idFlashcard = intval($_POST["id_flashcard"] ?? 0);

$respuesta = trim($_POST["respuesta"] ?? "");


if (
    !validarId($idNivel)
    ||
    !validarId($idFlashcard)
    ||
    !validarTexto($respuesta)
) {

    responderJson(400, ["error" => "Datos no válidos."]);

}


/* =====================================================
   LA PRÁCTICA DEBE ESTAR ACTIVA PARA ESTE NIVEL
===================================================== */

$practica = $_SESSION["practica"] ?? null;

if (
    !is_array($practica)
    ||
    intval($practica["id_nivel"]) !== $idNivel
) {

    responderJson(
        400,
        ["error" => "La práctica no está activa. Recarga la página."]
    );

}


/* =====================================================
   COMPROBAR LA FLASHCARD Y LA OPCIÓN ELEGIDA
===================================================== */

$flashcardDAO = new FlashcardDAO();

$flashcard = $flashcardDAO->obtenerFlashcard($idFlashcard);

if (
    $flashcard === null
    ||
    intval($flashcard["id_nivel"]) !== $idNivel
) {

    responderJson(400, ["error" => "La pregunta no es válida."]);

}


$opcionesValidas = [

    $flashcard["respuesta"],

    $flashcard["incorrecta_1"],

    $flashcard["incorrecta_2"],

    $flashcard["incorrecta_3"]

];

if (!in_array($respuesta, $opcionesValidas, true)) {

    responderJson(400, ["error" => "La opción no es válida."]);

}


/* =====================================================
   REGISTRAR EL RESULTADO (cuenta el primer intento)
===================================================== */

if (isset($_SESSION["practica"]["respuestas"][$idFlashcard])) {

    $correcta =
        $_SESSION["practica"]["respuestas"][$idFlashcard];

} else {

    $correcta = ($respuesta === $flashcard["respuesta"]);

    $_SESSION["practica"]["respuestas"][$idFlashcard] = $correcta;

}


responderJson(200, [

    "correcta" => $correcta,

    "respuesta_correcta" => $flashcard["respuesta"],

    "explicacion" => $flashcard["explicacion"]

]);

?>
