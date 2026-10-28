<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Datos/Tema/TemaDAO.php";


requerirAdmin();

$temaDAO = new TemaDAO();

$temas = $temaDAO->listarTemas();


$mensajes = [

    "tema_eliminado" => ["ok", "Tema eliminado correctamente."],

    "tema_vacio" => ["error", "El tema necesita un nombre."],

    "tema_largo" => ["error", "El nombre del tema es demasiado largo (máximo 100 caracteres)."],

    "descripcion_larga" => ["error", "La descripción es demasiado larga (máximo 500 caracteres)."],

    "tema_existente" => ["alerta", "Ya existe un tema con ese nombre."]

];

$mensaje = $mensajes[$_GET["mensaje"] ?? ""] ?? null;


$titulo = "Administrar";

$paginaActual = "admin";

$base = "../";

require __DIR__ . "/componentes/cabecera.php";

?>


<main class="pagina">

<div class="contenedor">


    <div class="pagina-cabecera">

        <span class="section-label">
            PANEL DE ADMINISTRACIÓN
        </span>

        <h1>
            Temas y niveles.
        </h1>

        <p>
            Crea los temas, divídelos en niveles y sube
            las flashcards que practicarán los estudiantes.
        </p>

    </div>


    <?php if ($mensaje !== null): ?>

        <div class="aviso aviso-<?= $mensaje[0] ?>">
            <?= htmlspecialchars($mensaje[1]) ?>
        </div>

    <?php endif; ?>


    <section class="tarjeta">

        <h2 class="subtitulo subtitulo-chico">Crear un tema</h2>

        <form action="../Procesos/guardarTema.php"
              method="POST"
              class="formulario">

            <label for="nombre">Nombre del tema</label>

            <input type="text"
                   id="nombre"
                   name="nombre"
                   maxlength="100"
                   placeholder="Ejemplo: Biología"
                   required>

            <label for="descripcion">Descripción (opcional)</label>

            <textarea id="descripcion"
                      name="descripcion"
                      rows="3"
                      maxlength="500"
                      placeholder="¿Qué aprenderá el estudiante en este tema?"></textarea>

            <div>
                <button type="submit" class="btn">Crear tema</button>
            </div>

        </form>

    </section>


    <h2 class="subtitulo">Temas publicados</h2>

    <?php if (count($temas) === 0): ?>

        <div class="tarjeta vacio">
            <p>Aún no has creado ningún tema.</p>
        </div>

    <?php else: ?>

        <div class="lista-temas">

            <?php foreach ($temas as $tema): ?>

                <article class="tarjeta tema-linea">

                    <div>

                        <h3><?= htmlspecialchars($tema["nombre"]) ?></h3>

                        <div class="chips">

                            <span class="chip">
                                <?= intval($tema["total_niveles"]) ?> niveles
                            </span>

                            <span class="chip">
                                <?= intval($tema["total_flashcards"]) ?> tarjetas
                            </span>

                        </div>

                    </div>

                    <div class="acciones-fila">

                        <a href="adminTema.php?id=<?= intval($tema["id_tema"]) ?>"
                           class="btn btn-chico">
                            Gestionar
                        </a>

                        <form action="../Procesos/eliminarTema.php"
                              method="POST"
                              onsubmit="return confirm('¿Eliminar este tema con todos sus niveles, flashcards y resultados?');">

                            <input type="hidden"
                                   name="id_tema"
                                   value="<?= intval($tema["id_tema"]) ?>">

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
