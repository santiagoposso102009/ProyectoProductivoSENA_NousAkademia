<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Config/constantes.php";

require_once __DIR__ . "/../Datos/Nivel/NivelDAO.php";

require_once __DIR__ . "/../Datos/Flashcard/FlashcardDAO.php";

require_once __DIR__ . "/../Datos/Intento/IntentoDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


/* =====================================================
   COMPROBAR SESIÓN Y MÉTODO
===================================================== */

$idUsuario = requerirSesion();

if (!validarMetodoPost()) {

    redirigir("../Vistas/temas.php");

}


/* =====================================================
   RECIBIR Y VALIDAR DATOS
===================================================== */

$idNivel = intval($_POST["id_nivel"] ?? 0);

if (!validarId($idNivel)) {

    die("ERROR: Nivel no válido.");

}


/* =====================================================
   COMPROBAR QUE EL NIVEL EXISTE Y ESTÁ DESBLOQUEADO
===================================================== */

$nivelDAO = new NivelDAO();

$nivel = $nivelDAO->obtenerNivel($idNivel);

if ($nivel === null) {

    die("ERROR: El nivel no existe.");

}

$idTema = intval($nivel["id_tema"]);

$permitido = false;

foreach (
    $nivelDAO->listarNivelesConEstado($idUsuario, $idTema)
    as $n
) {

    if (
        intval($n["id_nivel"]) === $idNivel
        &&
        in_array(
            $n["estado"],
            ["disponible", "aprobado"],
            true
        )
    ) {

        $permitido = true;

    }

}

if (!$permitido) {

    redirigir(
        "../Vistas/tema.php?id="
        . $idTema
        . "&mensaje=nivel_no_disponible"
    );

}


/* =====================================================
   LEER LAS RESPUESTAS COMPROBADAS POR EL SERVIDOR
===================================================== */

$practica = $_SESSION["practica"] ?? null;

if (
    !is_array($practica)
    ||
    intval($practica["id_nivel"]) !== $idNivel
) {

    redirigir(
        "../Vistas/practica.php?nivel=" . $idNivel
    );

}

$respuestas = $practica["respuestas"];


$flashcardDAO = new FlashcardDAO();

$idsNivel = $flashcardDAO->obtenerIdsPorNivel($idNivel);

$total = count($idsNivel);

if ($total === 0) {

    die("ERROR: El nivel no tiene flashcards.");

}


/* Deben estar contestadas todas las preguntas */

$aciertos = 0;

foreach ($idsNivel as $idFlashcard) {

    if (!isset($respuestas[$idFlashcard])) {

        redirigir(
            "../Vistas/practica.php?nivel=" . $idNivel
        );

    }

    if ($respuestas[$idFlashcard] === true) {

        $aciertos++;

    }

}


$porcentaje =
    round(($aciertos / $total) * 100, 2);

$aprobado =
    ($porcentaje >= PORCENTAJE_APROBACION) ? 1 : 0;


/* =====================================================
   REGISTRAR INTENTO (y cerrar la práctica)
===================================================== */

$intentoDAO = new IntentoDAO();

$idIntento = $intentoDAO->registrarIntento(
    $idUsuario,
    $idNivel,
    $aciertos,
    $total,
    $porcentaje,
    $aprobado
);

if ($idIntento === false) {

    die("ERROR: No se pudo registrar el intento.");

}

unset($_SESSION["practica"]);

redirigir(
    "../Vistas/resultado.php?intento=" . $idIntento
);

?>
