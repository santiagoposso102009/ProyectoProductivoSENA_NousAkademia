<?php

require_once __DIR__ . "/Config/sesion.php";

require_once __DIR__ . "/Config/constantes.php";


$titulo = "";

$paginaActual = "inicio";

$base = "";

require __DIR__ . "/Vistas/componentes/cabecera.php";

?>


<!-- =====================================================
     HERO
===================================================== -->

<section id="inicio" class="hero">

    <div class="hero-content">

        <span class="hero-label">
            NOUS AKADEMIA
        </span>

        <h1>
            Domina cada tema.
            <br>
            Nivel a nivel.
        </h1>

        <p>
            Practica con flashcards, supera cada nivel con
            <?= PORCENTAJE_APROBACION ?> % de aciertos y
            construye una maestría real sobre lo que estudias.
        </p>

        <?php if ($sesionIniciada): ?>

            <a href="Vistas/temas.php" class="more-btn">
                Ir a los temas
            </a>

        <?php else: ?>

            <a href="Vistas/registro.php" class="more-btn">
                Comenzar ahora
            </a>

        <?php endif; ?>

    </div>

</section>


<!-- =====================================================
     CARACTERÍSTICAS
===================================================== -->

<section class="features">

    <div class="feature-grid">

        <div class="feature">

            <div class="icon circles"></div>

            <h3>Recuerda</h3>

            <p>
                Responde de memoria antes de ver la solución.
                Recordar fortalece lo aprendido.
            </p>

        </div>

        <div class="feature">

            <div class="icon check"></div>

            <h3>Supera</h3>

            <p>
                Cada nivel exige <?= PORCENTAJE_APROBACION ?> % de
                aciertos para demostrar que lo dominas.
            </p>

        </div>

        <div class="feature">

            <div class="icon squares"></div>

            <h3>Avanza</h3>

            <p>
                Desbloquea niveles más difíciles y observa tu
                progreso en cada tema.
            </p>

        </div>

    </div>

</section>


<!-- =====================================================
     CÓMO FUNCIONA
===================================================== -->

<section class="methods">

    <div class="section-heading">

        <span class="section-label">
            ¿CÓMO FUNCIONA?
        </span>

        <h2>
            Tres pasos para
            <br>
            dominar un tema
        </h2>

        <p>
            Cada tema se divide en niveles de dificultad
            creciente, preparados por el administrador de la plataforma.
        </p>

    </div>


    <div class="method-grid">

        <div class="method-card">

            <span class="method-number">01</span>

            <div class="method-icon">1</div>

            <h3>Elige un tema</h3>

            <p>
                Biología, matemáticas o cualquier materia
                que esté publicada en la plataforma.
            </p>

            <a href="Vistas/temas.php" class="method-btn">
                Ver temas →
            </a>

        </div>

        <div class="method-card">

            <span class="method-number">02</span>

            <div class="method-icon">2</div>

            <h3>Practica con flashcards</h3>

            <p>
                Lee la pregunta, elige tu respuesta y recibe
                retroalimentación al instante, con pistas y explicaciones.
            </p>

            <a href="Vistas/repeticionActiva.php" class="method-btn">
                Conocer el método →
            </a>

        </div>

        <div class="method-card">

            <span class="method-number">03</span>

            <div class="method-icon">3</div>

            <h3>Sube de nivel</h3>

            <p>
                Con <?= PORCENTAJE_APROBACION ?> % de aciertos superas
                el nivel y se abre el siguiente.
            </p>

            <a href="Vistas/progreso.php" class="method-btn">
                Mi progreso →
            </a>

        </div>

    </div>

</section>


<!-- =====================================================
     RUTA DE NIVELES (ejemplo ilustrativo)
===================================================== -->

<section id="progreso" class="progress-section">

    <div class="progress-content">

        <span class="section-label">
            TU EVOLUCIÓN
        </span>

        <h2>
            Un camino
            <br>
            claro
        </h2>

        <p>
            Siempre sabrás qué nivel superaste, cuál sigue
            y cuánto te falta para dominar el tema.
        </p>

        <?php if ($sesionIniciada): ?>

            <a href="Vistas/progreso.php" class="more-btn">
                Ver mi progreso
            </a>

        <?php else: ?>

            <a href="Vistas/login.php" class="more-btn">
                Iniciar sesión
            </a>

        <?php endif; ?>

    </div>


    <div class="progress-card">

        <div class="progress-card-header">

            <div>
                <span>EJEMPLO</span>
                <h3>Biología</h3>
            </div>

            <span class="positive">2 / 3</span>

        </div>

        <ol class="ruta ruta-mini">

            <li class="ruta-item estado-aprobado">
                <div class="ruta-marca">✓</div>
                <div class="ruta-cuerpo">
                    <h3>Nivel 1 · La célula</h3>
                    <p>Superado con 92 %</p>
                </div>
            </li>

            <li class="ruta-item estado-disponible">
                <div class="ruta-marca">2</div>
                <div class="ruta-cuerpo">
                    <h3>Nivel 2 · Genética básica</h3>
                    <p>Disponible para practicar</p>
                </div>
            </li>

            <li class="ruta-item estado-bloqueado">
                <div class="ruta-marca">🔒</div>
                <div class="ruta-cuerpo">
                    <h3>Nivel 3 · Evolución</h3>
                    <p>Supera el nivel 2 para desbloquear</p>
                </div>
            </li>

        </ol>

    </div>

</section>


<!-- =====================================================
     NOSOTROS
===================================================== -->

<section id="nosotros" class="about">

    <span class="section-label">
        SOBRE EL PROYECTO
    </span>

    <h2>
        Estudiar es recordar,
        <br>
        no solo releer
    </h2>

    <p>
        Nous Akademia convierte la repetición activa en una
        experiencia de práctica guiada: temas, niveles y
        flashcards pensadas para comprobar lo que realmente
        sabes.
    </p>

</section>


<?php require __DIR__ . "/Vistas/componentes/pie.php"; ?>
