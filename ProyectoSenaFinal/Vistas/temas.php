<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Datos/Tema/TemaDAO.php";

require_once __DIR__ . "/../Datos/Nivel/NivelDAO.php";


$idUsuario = requerirSesion();

$temaDAO = new TemaDAO();

$nivelDAO = new NivelDAO();

$temas = $temaDAO->listarTemas();


/* Progreso del estudiante en cada tema */

foreach ($temas as $indice => $tema) {

    $niveles =
        $nivelDAO->listarNivelesConEstado(
            $idUsuario,
            intval($tema["id_tema"])
        );

    $aprobados = 0;

    foreach ($niveles as $nivel) {

        if ($nivel["estado"] === "aprobado") {

            $aprobados++;

        }

    }

    $temas[$indice]["aprobados"] = $aprobados;

}


$titulo = "Aprender";

$paginaActual = "temas";

$base = "../";

require __DIR__ . "/componentes/cabecera.php";

?>


<main class="pagina">

<div class="contenedor">


    <div class="pagina-cabecera">

        <span class="section-label">
            MAESTRÍA POR TEMAS
        </span>

        <h1>
            Elige un tema.<br>
            Domínalo nivel a nivel.
        </h1>

        <p>
            Practica con flashcards, supera cada nivel con
            al menos <?= PORCENTAJE_APROBACION ?> % de aciertos
            y desbloquea el siguiente.
        </p>

    </div>


    <?php if (count($temas) === 0): ?>

        <div class="tarjeta vacio">

            <h2>Todavía no hay temas.</h2>

            <p>
                El administrador publicará los primeros temas muy pronto.
            </p>

            <?php if (esAdmin()): ?>

                <a href="admin.php" class="btn">
                    Crear el primer tema
                </a>

            <?php endif; ?>

        </div>

    <?php else: ?>

        <div class="tema-grid">

            <?php foreach ($temas as $tema): ?>

                <?php

                $totalNiveles = intval($tema["total_niveles"]);

                $porcentaje =
                    ($totalNiveles > 0)
                        ? round(
                            ($tema["aprobados"] / $totalNiveles) * 100
                        )
                        : 0;

                ?>

                <article class="tema-card">

                    <h2>
                        <?= htmlspecialchars($tema["nombre"]) ?>
                    </h2>

                    <?php if ($tema["descripcion"] !== ""): ?>

                        <p>
                            <?= htmlspecialchars($tema["descripcion"]) ?>
                        </p>

                    <?php endif; ?>

                    <div class="chips">

                        <span class="chip">
                            <?= $totalNiveles ?>
                            <?= $totalNiveles === 1 ? "nivel" : "niveles" ?>
                        </span>

                        <span class="chip">
                            <?= intval($tema["total_flashcards"]) ?> tarjetas
                        </span>

                    </div>

                    <div>

                        <div class="barra">
                            <div class="barra-relleno"
                                 style="width: <?= $porcentaje ?>%"></div>
                        </div>

                        <div class="barra-texto">
                            <?= $tema["aprobados"] ?> de <?= $totalNiveles ?>
                            niveles superados
                        </div>

                    </div>

                    <a href="tema.php?id=<?= intval($tema["id_tema"]) ?>"
                       class="btn">

                        <?= $tema["aprobados"] > 0
                            ? "Continuar"
                            : "Empezar" ?> →

                    </a>

                </article>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>


</div>

</main>


<?php require __DIR__ . "/componentes/pie.php"; ?>
