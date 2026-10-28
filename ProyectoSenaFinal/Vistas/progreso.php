<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Datos/Tema/TemaDAO.php";

require_once __DIR__ . "/../Datos/Nivel/NivelDAO.php";

require_once __DIR__ . "/../Datos/Intento/IntentoDAO.php";


$idUsuario = requerirSesion();

$temaDAO = new TemaDAO();

$nivelDAO = new NivelDAO();

$intentoDAO = new IntentoDAO();


$estadisticas = $intentoDAO->obtenerEstadisticas($idUsuario);

$ultimosIntentos = $intentoDAO->ultimosIntentos($idUsuario, 10);


/* Progreso por tema */

$temas = $temaDAO->listarTemas();

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

    $temas[$indice]["niveles"] = $niveles;

    $temas[$indice]["aprobados"] = $aprobados;

}


$titulo = "Mi progreso";

$paginaActual = "progreso";

$base = "../";

require __DIR__ . "/componentes/cabecera.php";

?>


<main class="pagina">

<div class="contenedor">


    <div class="pagina-cabecera">

        <span class="section-label">
            MI PROGRESO
        </span>

        <h1>
            Conoce tu avance.
        </h1>

        <p>
            Tus niveles superados, tus resultados y
            tus últimos intentos en un solo lugar.
        </p>

    </div>


    <!-- =================================================
         ESTADÍSTICAS
    ================================================== -->

    <div class="stats-grid">

        <div class="stat-card">
            <strong><?= $estadisticas["total_intentos"] ?></strong>
            <span>intentos realizados</span>
        </div>

        <div class="stat-card">
            <strong><?= $estadisticas["niveles_aprobados"] ?></strong>
            <span>niveles superados</span>
        </div>

        <div class="stat-card">
            <strong><?= round($estadisticas["promedio"]) ?> %</strong>
            <span>promedio de aciertos</span>
        </div>

    </div>


    <!-- =================================================
         PROGRESO POR TEMA
    ================================================== -->

    <h2 class="subtitulo">Tus temas</h2>

    <?php if (count($temas) === 0): ?>

        <div class="tarjeta vacio">
            <p>Aún no hay temas publicados.</p>
        </div>

    <?php else: ?>

        <div class="lista-temas">

            <?php foreach ($temas as $tema): ?>

                <?php

                $totalNiveles = count($tema["niveles"]);

                $porcentaje =
                    ($totalNiveles > 0)
                        ? round(($tema["aprobados"] / $totalNiveles) * 100)
                        : 0;

                ?>

                <article class="tarjeta">

                    <div class="tema-linea">

                        <h3>
                            <?= htmlspecialchars($tema["nombre"]) ?>
                        </h3>

                        <a href="tema.php?id=<?= intval($tema["id_tema"]) ?>"
                           class="btn btn-claro btn-chico">
                            Ver niveles
                        </a>

                    </div>

                    <div class="barra">
                        <div class="barra-relleno"
                             style="width: <?= $porcentaje ?>%"></div>
                    </div>

                    <div class="barra-texto">
                        <?= $tema["aprobados"] ?> de <?= $totalNiveles ?>
                        niveles superados
                    </div>

                    <?php if ($totalNiveles > 0): ?>

                        <div class="chips chips-niveles">

                            <?php foreach ($tema["niveles"] as $nivel): ?>

                                <span class="chip chip-<?= $nivel["estado"] ?>"
                                      title="<?= htmlspecialchars($nivel["nombre"]) ?>">

                                    N<?= intval($nivel["numero"]) ?>

                                    <?php if ($nivel["total_intentos"] > 0): ?>
                                        · <?= round($nivel["mejor_porcentaje"]) ?> %
                                    <?php endif; ?>

                                </span>

                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>

                </article>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>


    <!-- =================================================
         ÚLTIMOS INTENTOS
    ================================================== -->

    <h2 class="subtitulo">Últimos intentos</h2>

    <?php if (count($ultimosIntentos) === 0): ?>

        <div class="tarjeta vacio">

            <p>Todavía no has practicado ningún nivel.</p>

            <a href="temas.php" class="btn">Empezar a practicar</a>

        </div>

    <?php else: ?>

        <div class="tarjeta tabla-scroll">

            <table class="tabla">

                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tema</th>
                        <th>Nivel</th>
                        <th>Aciertos</th>
                        <th>Resultado</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($ultimosIntentos as $intento): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars(
                                    date("d/m/Y H:i", strtotime($intento["fecha"]))
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($intento["tema_nombre"]) ?>
                            </td>

                            <td>
                                <?= intval($intento["numero"]) ?>
                                · <?= htmlspecialchars($intento["nivel_nombre"]) ?>
                            </td>

                            <td>
                                <?= intval($intento["aciertos"]) ?>
                                / <?= intval($intento["total"]) ?>
                                (<?= round($intento["porcentaje"]) ?> %)
                            </td>

                            <td>
                                <?php if (intval($intento["aprobado"]) === 1): ?>
                                    <span class="insignia insignia-ok">Superado</span>
                                <?php else: ?>
                                    <span class="insignia insignia-no">No superado</span>
                                <?php endif; ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>


</div>

</main>


<?php require __DIR__ . "/componentes/pie.php"; ?>
