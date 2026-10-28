<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Config/constantes.php";

require_once __DIR__ . "/../Datos/Tema/TemaDAO.php";

require_once __DIR__ . "/../Datos/Nivel/NivelDAO.php";

require_once __DIR__ . "/../Datos/Flashcard/FlashcardDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


requerirAdmin();

$idNivel = intval($_GET["id"] ?? 0);

if (!validarId($idNivel)) {

    redirigir("admin.php");

}


$nivelDAO = new NivelDAO();

$nivel = $nivelDAO->obtenerNivel($idNivel);

if ($nivel === null) {

    redirigir("admin.php");

}

$idTema = intval($nivel["id_tema"]);

$temaDAO = new TemaDAO();

$tema = $temaDAO->obtenerTema($idTema);

$flashcardDAO = new FlashcardDAO();

$flashcards = $flashcardDAO->listarPorNivel($idNivel);

$total = count($flashcards);

$faltan = max(0, MINIMO_FLASHCARDS_NIVEL - $total);

$porcentajeMinimo =
    min(100, round(($total / MINIMO_FLASHCARDS_NIVEL) * 100));


/* =====================================================
   ¿SE ESTÁ EDITANDO UNA PREGUNTA?
===================================================== */

$editando = null;

$idEditar = intval($_GET["editar"] ?? 0);

if ($idEditar > 0) {

    $candidata = $flashcardDAO->obtenerFlashcard($idEditar);

    if (
        $candidata !== null
        &&
        intval($candidata["id_nivel"]) === $idNivel
    ) {

        $editando = $candidata;

    }

}

$valor = [

    "pregunta" => "",

    "opciones" => ["", "", "", ""],

    "correcta" => 0,

    "pista" => "",

    "explicacion" => ""

];

if ($editando !== null) {

    $valor = [

        "pregunta" => $editando["pregunta"],

        "opciones" => [
            $editando["respuesta"],
            $editando["incorrecta_1"],
            $editando["incorrecta_2"],
            $editando["incorrecta_3"]
        ],

        "correcta" => 1,

        "pista" => $editando["pista"],

        "explicacion" => $editando["explicacion"]

    ];

}


$mensajes = [

    "nivel_creado" => ["ok", "Nivel creado. Escribe su primera pregunta."],

    "flashcard_creada" => ["ok", "Pregunta guardada. Puedes escribir la siguiente."],

    "flashcard_actualizada" => ["ok", "Cambios guardados."],

    "flashcard_eliminada" => ["ok", "Pregunta eliminada."],

    "flashcard_vacia" => ["error", "Completa la pregunta y las cuatro opciones."],

    "flashcard_sin_correcta" => ["error", "Marca cuál de las cuatro opciones es la correcta."],

    "flashcard_larga" => ["error", "Alguno de los textos es demasiado largo (pregunta y explicación máx. 1000, opciones 500, pista 300)."],

    "flashcard_repetida" => ["error", "Las cuatro opciones deben ser distintas entre sí."]

];

$mensaje = $mensajes[$_GET["mensaje"] ?? ""] ?? null;

$letras = ["A", "B", "C", "D"];


$titulo = "Preguntas del nivel " . $nivel["numero"];

$paginaActual = "admin";

$base = "../";

require __DIR__ . "/componentes/cabecera.php";

?>


<main class="pagina">

<div class="contenedor">


    <nav class="migas-ruta" aria-label="Ruta">

        <a href="admin.php">Administrar</a>

        <span>›</span>

        <a href="adminTema.php?id=<?= $idTema ?>">
            <?= htmlspecialchars($tema["nombre"]) ?>
        </a>

        <span>›</span>

        <strong>Nivel <?= intval($nivel["numero"]) ?></strong>

    </nav>


    <div class="pagina-cabecera">

        <span class="section-label">
            PREGUNTAS DEL NIVEL
        </span>

        <h1>
            <?= htmlspecialchars($nivel["nombre"]) ?>
        </h1>

        <?php if ($nivel["descripcion"] !== ""): ?>

            <p><?= htmlspecialchars($nivel["descripcion"]) ?></p>

        <?php endif; ?>

    </div>


    <!-- Estado de publicación -->

    <div class="tarjeta estado-publicacion">

        <div class="estado-barra">

            <div class="barra">
                <div class="barra-relleno"
                     style="width: <?= $porcentajeMinimo ?>%"></div>
            </div>

            <div class="barra-texto">
                <?= $total ?> <?= $total === 1 ? "pregunta" : "preguntas" ?>
                · mínimo <?= MINIMO_FLASHCARDS_NIVEL ?> para publicar
            </div>

        </div>

        <?php if ($faltan > 0): ?>

            <span class="insignia insignia-alerta">
                Faltan <?= $faltan ?> para publicar
            </span>

        <?php else: ?>

            <span class="insignia insignia-ok">
                ✓ Publicado: los estudiantes ya pueden practicarlo
            </span>

        <?php endif; ?>

    </div>


    <?php if ($mensaje !== null): ?>

        <div class="aviso aviso-<?= $mensaje[0] ?>">
            <?= htmlspecialchars($mensaje[1]) ?>
        </div>

    <?php endif; ?>


    <!-- =================================================
         EDITOR + VISTA PREVIA
    ================================================== -->

    <div class="editor-layout" id="editor">


        <section class="tarjeta editor-form">

            <h2 class="subtitulo subtitulo-chico">
                <?= $editando !== null
                    ? "Editar pregunta"
                    : "Nueva pregunta" ?>
            </h2>

            <form action="../Procesos/guardarFlashcard.php"
                  method="POST"
                  class="formulario"
                  id="form-pregunta">

                <input type="hidden"
                       name="id_nivel"
                       value="<?= $idNivel ?>">

                <input type="hidden"
                       name="id_flashcard"
                       value="<?= $editando !== null
                           ? intval($editando["id_flashcard"])
                           : 0 ?>">


                <label for="f-pregunta">Pregunta</label>

                <textarea id="f-pregunta"
                          name="pregunta"
                          rows="2"
                          maxlength="1000"
                          placeholder="Ejemplo: ¿Qué orgánulo realiza la fotosíntesis?"
                          required><?= htmlspecialchars($valor["pregunta"]) ?></textarea>


                <span class="etiqueta-grupo">
                    Opciones: toca la letra de la respuesta correcta
                </span>

                <?php foreach ($letras as $i => $letra): ?>

                    <div class="opcion-editor">

                        <input type="radio"
                               name="correcta"
                               id="correcta-<?= $i + 1 ?>"
                               value="<?= $i + 1 ?>"
                               <?= ($valor["correcta"] === $i + 1) ? "checked" : "" ?>
                               required>

                        <label for="correcta-<?= $i + 1 ?>"
                               class="pr-letra"
                               title="Marcar como respuesta correcta">
                            <?= $letra ?>
                        </label>

                        <input type="text"
                               name="opcion_<?= $i + 1 ?>"
                               class="f-opcion"
                               maxlength="500"
                               placeholder="Opción <?= $letra ?>"
                               value="<?= htmlspecialchars($valor["opciones"][$i]) ?>"
                               aria-label="Opción <?= $letra ?>"
                               required>

                        <span class="marca-correcta">✓ Correcta</span>

                    </div>

                <?php endforeach; ?>


                <label for="f-pista">Pista (opcional)</label>

                <input type="text"
                       id="f-pista"
                       name="pista"
                       maxlength="300"
                       placeholder="Una ayuda que el estudiante puede ver"
                       value="<?= htmlspecialchars($valor["pista"]) ?>">

                <label for="f-explicacion">Explicación (opcional)</label>

                <textarea id="f-explicacion"
                          name="explicacion"
                          rows="2"
                          maxlength="1000"
                          placeholder="Se muestra después de contestar"><?= htmlspecialchars($valor["explicacion"]) ?></textarea>


                <p class="pr-error" id="f-error" hidden></p>


                <div class="editor-botones">

                    <button type="submit" class="btn">
                        <?= $editando !== null
                            ? "Guardar cambios"
                            : "Guardar y agregar otra" ?>
                    </button>

                    <?php if ($editando !== null): ?>

                        <a href="adminNivel.php?id=<?= $idNivel ?>#lista"
                           class="btn btn-claro">
                            Cancelar
                        </a>

                    <?php endif; ?>

                </div>

            </form>

        </section>


        <aside class="vista-previa">

            <span class="section-label">
                ASÍ LA VERÁ EL ESTUDIANTE
            </span>

            <article class="pr-tarjeta">

                <span class="pr-etiqueta">
                    Pregunta <?= $editando !== null ? "" : ($total + 1) ?>
                </span>

                <h3 class="pr-pregunta" id="vp-pregunta"></h3>

                <p class="pr-pista" id="vp-pista" hidden></p>

                <div class="pr-opciones" id="vp-opciones"></div>

                <div class="pr-feedback ok" id="vp-feedback" hidden>

                    <strong>¡Correcto!</strong>

                    <p id="vp-explicacion"></p>

                </div>

            </article>

        </aside>


    </div>


    <!-- =================================================
         LISTA DE PREGUNTAS
    ================================================== -->

    <h2 class="subtitulo" id="lista">
        Preguntas de este nivel (<?= $total ?>)
    </h2>

    <?php if ($total === 0): ?>

        <div class="tarjeta vacio">
            <p>Todavía no hay preguntas. Escribe la primera arriba.</p>
        </div>

    <?php else: ?>

        <ol class="lista-preguntas">

            <?php foreach ($flashcards as $indice => $flashcard): ?>

                <li class="<?= ($editando !== null
                    && intval($editando["id_flashcard"])
                       === intval($flashcard["id_flashcard"]))
                    ? "en-edicion" : "" ?>">

                    <div class="pregunta-cuerpo">

                        <strong>
                            <?= $indice + 1 ?>.
                            <?= htmlspecialchars($flashcard["pregunta"]) ?>
                        </strong>

                        <ul class="opciones-admin">

                            <li class="correcta">
                                ✓ <?= htmlspecialchars($flashcard["respuesta"]) ?>
                            </li>

                            <li>✗ <?= htmlspecialchars($flashcard["incorrecta_1"]) ?></li>

                            <li>✗ <?= htmlspecialchars($flashcard["incorrecta_2"]) ?></li>

                            <li>✗ <?= htmlspecialchars($flashcard["incorrecta_3"]) ?></li>

                        </ul>

                        <?php if ($flashcard["pista"] !== ""): ?>

                            <p class="nota">
                                Pista: <?= htmlspecialchars($flashcard["pista"]) ?>
                            </p>

                        <?php endif; ?>

                        <?php if ($flashcard["explicacion"] !== ""): ?>

                            <p class="nota">
                                Explicación: <?= htmlspecialchars($flashcard["explicacion"]) ?>
                            </p>

                        <?php endif; ?>

                        <?php if ($flashcard["creador"] !== null): ?>

                            <p class="nota">
                                Creada por <?= htmlspecialchars($flashcard["creador"]) ?>
                            </p>

                        <?php endif; ?>

                    </div>


                    <div class="pregunta-acciones">

                        <a href="adminNivel.php?id=<?= $idNivel ?>&editar=<?= intval($flashcard["id_flashcard"]) ?>#editor"
                           class="btn btn-claro btn-chico">
                            Editar
                        </a>

                        <form action="../Procesos/eliminarFlashcard.php"
                              method="POST"
                              onsubmit="return confirm('¿Eliminar esta pregunta?');">

                            <input type="hidden"
                                   name="id_flashcard"
                                   value="<?= intval($flashcard["id_flashcard"]) ?>">

                            <button type="submit"
                                    class="btn btn-peligro btn-chico">
                                Eliminar
                            </button>

                        </form>

                    </div>

                </li>

            <?php endforeach; ?>

        </ol>

    <?php endif; ?>


    <div class="pie-nivel">

        <a href="adminTema.php?id=<?= $idTema ?>" class="btn btn-claro">
            ← Volver a los niveles
        </a>

    </div>


</div>

</main>


<script src="../js/adminNivel.js"></script>


<?php require __DIR__ . "/componentes/pie.php"; ?>
