<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Config/constantes.php";

require_once __DIR__ . "/../Datos/Tema/TemaDAO.php";

require_once __DIR__ . "/../Datos/Nivel/NivelDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


$idUsuario = requerirSesion();

$idTema = intval($_GET["id"] ?? 0);

if (!validarId($idTema)) {

    redirigir("temas.php");

}


$temaDAO = new TemaDAO();

$tema = $temaDAO->obtenerTema($idTema);

if ($tema === null) {

    redirigir("temas.php");

}


$nivelDAO = new NivelDAO();

$niveles = $nivelDAO->listarNivelesConEstado($idUsuario, $idTema);


$aprobados = 0;

foreach ($niveles as $nivel) {

    if ($nivel["estado"] === "aprobado") {

        $aprobados++;

    }

}

$totalNiveles = count($niveles);

$dominado = ($totalNiveles > 0 && $aprobados === $totalNiveles);

$porcentaje =
    ($totalNiveles > 0)
        ? round(($aprobados / $totalNiveles) * 100)
        : 0;

$mensaje = $_GET["mensaje"] ?? "";


$titulo = $tema["nombre"];

$paginaActual = "temas";

$base = "../";

require __DIR__ . "/componentes/cabecera.php";

?>


<main class="pagina">

<div class="contenedor">


    <a href="temas.php" class="migas">← Todos los temas</a>


    <div class="pagina-cabecera">

        <span class="section-label">
            TEMA
        </span>

        <h1>
            <?= htmlspecialchars($tema["nombre"]) ?>
        </h1>

        <?php if ($tema["descripcion"] !== ""): ?>

            <p>
                <?= htmlspecialchars($tema["descripcion"]) ?>
            </p>

        <?php endif; ?>

    </div>


    <?php if ($mensaje === "nivel_no_disponible"): ?>

        <div class="aviso aviso-alerta">
            Ese nivel todavía no está disponible.
            Supera primero el nivel anterior.
        </div>

    <?php endif; ?>


    <?php if ($totalNiveles > 0): ?>

        <div class="tarjeta resumen-tema">

            <div style="flex: 1; min-width: 220px;">

                <div class="barra">
                    <div class="barra-relleno"
                         style="width: <?= $porcentaje ?>%"></div>
                </div>

                <div class="barra-texto">
                    <?= $aprobados ?> de <?= $totalNiveles ?>
                    niveles superados
                </div>

            </div>

            <?php if ($dominado): ?>

                <span class="insignia insignia-ok">
                    ★ Tema dominado
                </span>

            <?php endif; ?>

        </div>

    <?php endif; ?>


    <?php if ($totalNiveles === 0): ?>

        <div class="tarjeta vacio">

            <h2>Este tema aún no tiene niveles.</h2>

            <p>Vuelve pronto.</p>

        </div>

    <?php else: ?>

        <ol class="ruta">

            <?php foreach ($niveles as $nivel): ?>

                <li class="ruta-item estado-<?= $nivel["estado"] ?>">

                    <div class="ruta-marca">

                        <?php if ($nivel["estado"] === "aprobado"): ?>
                            ✓
                        <?php elseif ($nivel["estado"] === "bloqueado"): ?>
                            🔒
                        <?php else: ?>
                            <?= intval($nivel["numero"]) ?>
                        <?php endif; ?>

                    </div>


                    <div class="ruta-cuerpo">

                        <h3>
                            Nivel <?= intval($nivel["numero"]) ?>
                            · <?= htmlspecialchars($nivel["nombre"]) ?>
                        </h3>

                        <?php if ($nivel["descripcion"] !== ""): ?>

                            <p>
                                <?= htmlspecialchars($nivel["descripcion"]) ?>
                            </p>

                        <?php endif; ?>

                        <div class="chips">

                            <span class="chip">
                                <?= $nivel["total_flashcards"] ?> tarjetas
                            </span>

                            <?php if ($nivel["total_intentos"] > 0): ?>

                                <span class="chip">
                                    Mejor resultado:
                                    <?= round($nivel["mejor_porcentaje"]) ?> %
                                </span>

                                <span class="chip">
                                    <?= $nivel["total_intentos"] ?>
                                    <?= $nivel["total_intentos"] === 1
                                        ? "intento"
                                        : "intentos" ?>
                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="ruta-accion">

                            <?php if ($nivel["estado"] === "disponible"): ?>

                                <a href="practica.php?nivel=<?= intval($nivel["id_nivel"]) ?>"
                                   class="btn">
                                    Practicar →
                                </a>

                            <?php elseif ($nivel["estado"] === "aprobado"): ?>

                                <span class="insignia insignia-ok">
                                    Superado
                                </span>

                                <a href="practica.php?nivel=<?= intval($nivel["id_nivel"]) ?>"
                                   class="btn btn-claro btn-chico">
                                    Repasar
                                </a>

                            <?php elseif ($nivel["estado"] === "bloqueado"): ?>

                                <span class="nota">
                                    Supera el nivel anterior con
                                    <?= PORCENTAJE_APROBACION ?> % para desbloquearlo.
                                </span>

                            <?php else: ?>

                                <span class="nota">
                                    En construcción: faltan
                                    <?= MINIMO_FLASHCARDS_NIVEL - $nivel["total_flashcards"] ?>
                                    tarjetas para publicarlo.
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                </li>

            <?php endforeach; ?>

        </ol>

    <?php endif; ?>


</div>

</main>


<?php require __DIR__ . "/componentes/pie.php"; ?>
