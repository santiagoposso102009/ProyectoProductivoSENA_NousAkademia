<?php

require_once __DIR__ . "/../Config/sesion.php";

require_once __DIR__ . "/../Datos/Intento/IntentoDAO.php";


$idUsuario = requerirSesion();

$nombre = $_SESSION["nombre"] ?? "";

$correo = $_SESSION["correo"] ?? "";


$intentoDAO = new IntentoDAO();

$estadisticas = $intentoDAO->obtenerEstadisticas($idUsuario);


$titulo = "Mi cuenta";

$paginaActual = "";

$base = "../";

require __DIR__ . "/componentes/cabecera.php";

?>


<main class="pagina">

<div class="contenedor contenedor-estrecho">


    <div class="pagina-cabecera">

        <span class="section-label">
            MI CUENTA
        </span>

        <h1>
            Tu espacio de estudio.
        </h1>

    </div>


    <section class="tarjeta">

        <h2 class="subtitulo subtitulo-chico">
            Información personal
        </h2>

        <dl class="datos">

            <div>
                <dt>Nombre</dt>
                <dd><?= htmlspecialchars($nombre) ?></dd>
            </div>

            <div>
                <dt>Correo</dt>
                <dd><?= htmlspecialchars($correo) ?></dd>
            </div>

            <div>
                <dt>Tipo de cuenta</dt>
                <dd><?= esAdmin() ? "Administrador" : "Estudiante" ?></dd>
            </div>

        </dl>

    </section>


    <section class="tarjeta">

        <h2 class="subtitulo subtitulo-chico">
            Estadísticas de estudio
        </h2>

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

        <div class="tarjeta-acciones">

            <a href="progreso.php" class="btn">Ver mi progreso</a>

        </div>

    </section>


    <section class="tarjeta">

        <h2 class="subtitulo subtitulo-chico">
            Cerrar sesión
        </h2>

        <p>
            Al cerrar sesión tendrás que volver a iniciar
            sesión para acceder a tu cuenta.
        </p>

        <div class="tarjeta-acciones">

            <a href="../Procesos/cerrarSesion.php"
               class="btn btn-peligro">
                Cerrar sesión
            </a>

        </div>

    </section>


</div>

</main>


<?php require __DIR__ . "/componentes/pie.php"; ?>
