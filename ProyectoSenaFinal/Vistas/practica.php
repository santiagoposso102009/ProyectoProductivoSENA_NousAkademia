<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Config/constantes.php";

require_once __DIR__ . "/../Datos/Tema/TemaDAO.php";

require_once __DIR__ . "/../Datos/Nivel/NivelDAO.php";

require_once __DIR__ . "/../Datos/Flashcard/FlashcardDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


$idUsuario = requerirSesion();

$idNivel = intval($_GET["nivel"] ?? 0);

if (!validarId($idNivel)) {

    redirigir("temas.php");

}


$nivelDAO = new NivelDAO();

$nivel = $nivelDAO->obtenerNivel($idNivel);

if ($nivel === null) {

    redirigir("temas.php");

}

$idTema = intval($nivel["id_tema"]);


/* Solo se puede practicar un nivel disponible o ya superado */

$permitido = false;

foreach (
    $nivelDAO->listarNivelesConEstado($idUsuario, $idTema)
    as $n
) {

    if (
        intval($n["id_nivel"]) === $idNivel
        &&
        in_array($n["estado"], ["disponible", "aprobado"], true)
    ) {

        $permitido = true;

    }

}

if (!$permitido) {

    redirigir(
        "tema.php?id=" . $idTema . "&mensaje=nivel_no_disponible"
    );

}


$temaDAO = new TemaDAO();

$tema = $temaDAO->obtenerTema($idTema);


/* =====================================================
   NUEVA PRÁCTICA: el servidor guarda en la sesión las
   respuestas que va comprobando (comprobarRespuesta.php)
===================================================== */

$_SESSION["practica"] = [

    "id_nivel" => $idNivel,

    "respuestas" => []

];


/* =====================================================
   TARJETAS PARA EL NAVEGADOR
   Se mezclan las opciones y NO se indica cuál es la
   correcta: eso solo lo revela el servidor al comprobar.
===================================================== */

$flashcardDAO = new FlashcardDAO();

$tarjetas = [];

foreach ($flashcardDAO->listarPorNivel($idNivel) as $fila) {

    $opciones = [

        $fila["respuesta"],

        $fila["incorrecta_1"],

        $fila["incorrecta_2"],

        $fila["incorrecta_3"]

    ];

    shuffle($opciones);

    $tarjetas[] = [

        "id_flashcard" => intval($fila["id_flashcard"]),

        "pregunta" => $fila["pregunta"],

        "pista" => $fila["pista"],

        "opciones" => $opciones

    ];

}


$datosJs = [

    "idNivel" => $idNivel,

    "tarjetas" => $tarjetas,

    "umbral" => PORCENTAJE_APROBACION,

    "urlComprobar" => "../Procesos/comprobarRespuesta.php"

];


$titulo = "Practicar";

$paginaActual = "temas";

$base = "../";

require __DIR__ . "/componentes/cabecera.php";

?>


<main class="pagina">

<div class="contenedor contenedor-estrecho">


    <a href="tema.php?id=<?= $idTema ?>" class="migas">
        ← <?= htmlspecialchars($tema["nombre"]) ?>
    </a>


    <div class="practica-cabecera">

        <span class="section-label">
            NIVEL <?= intval($nivel["numero"]) ?>
        </span>

        <h1>
            <?= htmlspecialchars($nivel["nombre"]) ?>
        </h1>

    </div>


    <!-- =================================================
         PRÁCTICA
    ================================================== -->

    <section id="zona-practica">

        <div class="pr-puntos" id="pr-puntos"></div>


        <article class="pr-tarjeta" id="pr-tarjeta">

            <span class="pr-etiqueta" id="pr-etiqueta"></span>

            <h2 class="pr-pregunta" id="pr-pregunta"></h2>

            <div class="pr-pista-zona">

                <button type="button"
                        id="btn-pista"
                        class="pr-pista-boton">

                    💡 Ver pista

                </button>

                <p class="pr-pista" id="pr-pista" hidden></p>

            </div>

            <div class="pr-opciones" id="pr-opciones"></div>

            <div class="pr-feedback" id="pr-feedback" hidden>

                <strong id="pr-feedback-titulo"></strong>

                <p id="pr-feedback-texto"></p>

            </div>

            <p class="pr-error" id="pr-error" hidden></p>

        </article>


        <div class="pr-acciones">

            <button type="button"
                    id="btn-comprobar"
                    class="btn"
                    disabled>

                Comprobar

            </button>

            <button type="button"
                    id="btn-siguiente"
                    class="btn"
                    hidden>

                Siguiente →

            </button>

        </div>

        <p class="atajos">
            Atajos: teclas 1 a 4 eligen una opción ·
            Enter comprueba y avanza
        </p>

    </section>


    <!-- =================================================
         RESULTADO
    ================================================== -->

    <section id="zona-resultado" class="tarjeta resultado-previo" hidden>

        <span class="section-label">RESULTADO</span>

        <div class="resultado-porcentaje" id="res-porcentaje"></div>

        <p class="resultado-detalle" id="res-detalle"></p>

        <p id="res-mensaje"></p>

        <form action="../Procesos/registrarIntento.php"
              method="POST">

            <input type="hidden"
                   name="id_nivel"
                   value="<?= $idNivel ?>">

            <button type="submit" class="btn">
                Guardar resultado
            </button>

        </form>

    </section>


</div>

</main>


<script type="application/json" id="datos-practica"><?= json_encode(
    $datosJs,
    JSON_UNESCAPED_UNICODE
    | JSON_HEX_TAG
    | JSON_HEX_AMP
    | JSON_HEX_APOS
    | JSON_HEX_QUOT
) ?></script>

<script src="../js/practica.js"></script>


<?php require __DIR__ . "/componentes/pie.php"; ?>
