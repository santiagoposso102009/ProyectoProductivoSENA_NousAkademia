<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Config/constantes.php";

$titulo = "Repetición activa";

$paginaActual = "metodo";

$base = "../";

require __DIR__ . "/componentes/cabecera.php";

?>


<section class="method-detail">

    <div class="method-detail-content">

        <span class="section-label">
            EL MÉTODO
        </span>

        <div class="method-letter">
            R
        </div>

        <h1>
            Repetición activa
        </h1>

        <p class="method-intro">
            Una estrategia de aprendizaje basada en recuperar
            información de la memoria para fortalecer el
            aprendizaje y comprobar qué conocimientos se
            recuerdan realmente.
        </p>


        <div class="method-science">

            <span class="section-label">
                SOBRE EL MÉTODO
            </span>

            <h2>
                ¿Por qué funciona?
            </h2>

            <p>
                La repetición activa consiste en intentar
                recordar información sin consultar directamente
                los apuntes, libros o materiales utilizados
                durante el estudio. En lugar de limitarse a
                releer una información, el estudiante intenta
                recuperarla de su memoria mediante preguntas,
                ejercicios, explicaciones o pequeños
                cuestionarios.
            </p>

            <p>
                Desde la perspectiva de la ciencia cognitiva,
                practicar la recuperación de información puede
                favorecer que los conocimientos puedan ser
                recordados posteriormente. Además, este método
                permite identificar qué partes de un tema se
                recuerdan con facilidad y cuáles necesitan ser
                estudiadas nuevamente.
            </p>

            <p>
                En Nous Akademia cada tema se divide en niveles.
                Practicas con flashcards de opción múltiple: eliges tu respuesta, recibes retroalimentación al instante y aprendes de cada error. Cuando
                alcanzas el <?= PORCENTAJE_APROBACION ?> % de aciertos, superas el
                nivel y desbloqueas el siguiente.
            </p>

        </div>

        <a href="temas.php" class="more-btn">
            Ir a los temas →
        </a>

    </div>

</section>


<?php require __DIR__ . "/componentes/pie.php"; ?>
