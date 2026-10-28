<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Config/constantes.php";

require_once __DIR__ . "/../Datos/Nivel/NivelDAO.php";

require_once __DIR__ . "/../Datos/Intento/IntentoDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


$idUsuario = requerirSesion();

$idIntento = intval($_GET["intento"] ?? 0);

if (!validarId($idIntento)) {

    redirigir("temas.php");

}


$intentoDAO = new IntentoDAO();

$intento = $intentoDAO->obtenerIntento($idIntento, $idUsuario);

if ($intento === null) {

    redirigir("temas.php");

}


$idTema = intval($intento["id_tema"]);

$aprobado = intval($intento["aprobado"]) === 1;


/* Siguiente nivel disponible y si el tema quedó completo */

$nivelDAO = new NivelDAO();

$siguiente = null;

$temaCompleto = true;

foreach (
    $nivelDAO->listarNivelesConEstado($idUsuario, $idTema)
    as $n
) {

    if ($n["estado"] !== "aprobado") {

        $temaCompleto = false;

    }

    if ($n["estado"] === "disponible" && $siguiente === null) {

        $siguiente = $n;

    }

}


$titulo = "Resultado";

$paginaActual = "temas";

$base = "../";

require __DIR__ . "/componentes/cabecera.php";

?>


<main class="pagina">

<div class="contenedor contenedor-estrecho">


    <section class="tarjeta resultado-card">

        <span class="section-label">
            <?= htmlspecialchars($intento["tema_nombre"]) ?>
            · NIVEL <?= intval($intento["numero"]) ?>
        </span>


        <div class="resultado-porcentaje <?= $aprobado ? "ok" : "no" ?>">
            <?= round($intento["porcentaje"]) ?>%
        </div>


        <p class="resultado-detalle">
            Acertaste <?= intval($intento["aciertos"]) ?>
            de <?= intval($intento["total"]) ?> tarjetas.
        </p>


        <?php if ($aprobado): ?>

            <h2>
                <?= ($temaCompleto && $siguiente === null)
                    ? "¡Dominaste este tema!"
                    : "¡Nivel superado!" ?>
            </h2>

            <p>
                <?php if ($siguiente !== null): ?>
                    Ya puedes empezar el nivel
                    <?= intval($siguiente["numero"]) ?>.
                <?php elseif ($temaCompleto): ?>
                    Has superado todos los niveles disponibles.
                <?php else: ?>
                    Cuando se publique el siguiente nivel podrás continuar.
                <?php endif; ?>
            </p>

        <?php else: ?>

            <h2>Casi lo logras.</h2>

            <p>
                Necesitas al menos <?= PORCENTAJE_APROBACION ?> %
                para avanzar. Repasa y vuelve a intentarlo.
            </p>

        <?php endif; ?>


        <div class="resultado-acciones">

            <?php if ($aprobado && $siguiente !== null): ?>

                <a href="practica.php?nivel=<?= intval($siguiente["id_nivel"]) ?>"
                   class="btn">
                    Siguiente nivel →
                </a>

            <?php endif; ?>

            <?php if (!$aprobado): ?>

                <a href="practica.php?nivel=<?= intval($intento["id_nivel"]) ?>"
                   class="btn">
                    Intentar de nuevo
                </a>

            <?php endif; ?>

            <a href="tema.php?id=<?= $idTema ?>"
               class="btn btn-claro">
                Volver al tema
            </a>

        </div>

    </section>


</div>

</main>


<?php require __DIR__ . "/componentes/pie.php"; ?>
