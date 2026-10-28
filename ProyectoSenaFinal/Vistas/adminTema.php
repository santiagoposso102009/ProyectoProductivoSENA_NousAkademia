<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Config/constantes.php";

require_once __DIR__ . "/../Datos/Tema/TemaDAO.php";

require_once __DIR__ . "/../Datos/Nivel/NivelDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


requerirAdmin();

$idTema = intval($_GET["id"] ?? 0);

if (!validarId($idTema)) {

    redirigir("admin.php");

}


$temaDAO = new TemaDAO();

$tema = $temaDAO->obtenerTema($idTema);

if ($tema === null) {

    redirigir("admin.php");

}


$nivelDAO = new NivelDAO();

$niveles = $nivelDAO->listarNiveles($idTema);


$mensajes = [

    "tema_creado" => ["ok", "Tema creado. Ahora agrega sus niveles."],

    "nivel_eliminado" => ["ok", "Nivel eliminado."],

    "nivel_vacio" => ["error", "El nivel necesita un nombre."],

    "nivel_largo" => ["error", "El nombre (máx. 100) o la descripción (máx. 255) son demasiado largos."]

];

$mensaje = $mensajes[$_GET["mensaje"] ?? ""] ?? null;


$titulo = "Gestionar " . $tema["nombre"];

$paginaActual = "admin";

$base = "../";

require __DIR__ . "/componentes/cabecera.php";

?>


<main class="pagina">

<div class="contenedor">


    <nav class="migas-ruta" aria-label="Ruta">

        <a href="admin.php">Administrar</a>

        <span>›</span>

        <strong><?= htmlspecialchars($tema["nombre"]) ?></strong>

    </nav>


    <div class="pagina-cabecera">

        <span class="section-label">
            GESTIONAR TEMA
        </span>

        <h1>
            <?= htmlspecialchars($tema["nombre"]) ?>
        </h1>

        <p>
            Crea los niveles del tema y entra a cada uno para
            escribir sus preguntas. Un nivel se publica cuando
            tiene al menos <?= MINIMO_FLASHCARDS_NIVEL ?> preguntas.
        </p>

    </div>


    <?php if ($mensaje !== null): ?>

        <div class="aviso aviso-<?= $mensaje[0] ?>">
            <?= htmlspecialchars($mensaje[1]) ?>
        </div>

    <?php endif; ?>


    <section class="tarjeta">

        <h2 class="subtitulo subtitulo-chico">Agregar un nivel</h2>

        <form action="../Procesos/guardarNivel.php"
              method="POST"
              class="formulario">

            <input type="hidden"
                   name="id_tema"
                   value="<?= $idTema ?>">

            <label for="nombre-nivel">Nombre del nivel</label>

            <input type="text"
                   id="nombre-nivel"
                   name="nombre"
                   maxlength="100"
                   placeholder="Ejemplo: La célula"
                   required>

            <label for="descripcion-nivel">Descripción (opcional)</label>

            <input type="text"
                   id="descripcion-nivel"
                   name="descripcion"
                   maxlength="255"
                   placeholder="Resumen de lo que se evalúa">

            <div>
                <button type="submit" class="btn">
                    Crear nivel y agregar preguntas →
                </button>
            </div>

        </form>

    </section>


    <h2 class="subtitulo">Niveles</h2>

    <?php if (count($niveles) === 0): ?>

        <div class="tarjeta vacio">
            <p>Este tema todavía no tiene niveles.</p>
        </div>

    <?php else: ?>

        <div class="lista-temas">

            <?php foreach ($niveles as $nivel): ?>

                <?php

                $idNivel = intval($nivel["id_nivel"]);

                $total = intval($nivel["total_flashcards"]);

                $faltan = MINIMO_FLASHCARDS_NIVEL - $total;

                ?>

                <article class="tarjeta tema-linea">

                    <div>

                        <h3>
                            Nivel <?= intval($nivel["numero"]) ?>
                            · <?= htmlspecialchars($nivel["nombre"]) ?>
                        </h3>

                        <?php if ($nivel["descripcion"] !== ""): ?>

                            <p class="nota">
                                <?= htmlspecialchars($nivel["descripcion"]) ?>
                            </p>

                        <?php endif; ?>

                        <div class="chips" style="margin-top: 10px;">

                            <span class="chip">
                                <?= $total ?>
                                <?= $total === 1 ? "pregunta" : "preguntas" ?>
                            </span>

                            <?php if ($faltan > 0): ?>

                                <span class="insignia insignia-alerta">
                                    Faltan <?= $faltan ?> para publicar
                                </span>

                            <?php else: ?>

                                <span class="insignia insignia-ok">
                                    Publicado
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>


                    <div class="acciones-fila">

                        <a href="adminNivel.php?id=<?= $idNivel ?>"
                           class="btn btn-chico">

                            <?= $total === 0
                                ? "Agregar preguntas →"
                                : "Ver y editar preguntas →" ?>

                        </a>

                        <form action="../Procesos/eliminarNivel.php"
                              method="POST"
                              onsubmit="return confirm('¿Eliminar este nivel con todas sus preguntas y resultados?');">

                            <input type="hidden"
                                   name="id_nivel"
                                   value="<?= $idNivel ?>">

                            <button type="submit"
                                    class="btn btn-peligro btn-chico">
                                Eliminar
                            </button>

                        </form>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>


</div>

</main>


<?php require __DIR__ . "/componentes/pie.php"; ?>
