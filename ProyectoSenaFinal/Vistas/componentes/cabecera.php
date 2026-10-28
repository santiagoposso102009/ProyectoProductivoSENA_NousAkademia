<?php

/* =====================================================
   CABECERA COMÚN (head + navbar)

   Antes de incluirla, cada vista define:
   $titulo        -> título de la página
   $base          -> "../" (Vistas) o "" (index.php)
   $paginaActual  -> para resaltar el enlace activo
===================================================== */

require_once __DIR__ . "/../../Config/sesion.php";

$base = $base ?? "../";

$vistas = ($base === "") ? "Vistas/" : "";

$titulo = $titulo ?? "";

$paginaActual = $paginaActual ?? "";

$tituloCompleto =
    ($titulo === "")
        ? "Nous Akademia"
        : $titulo . " | Nous Akademia";

$sesionIniciada = isset($_SESSION["id_usuario"]);

?>
<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($tituloCompleto) ?></title>

    <link rel="stylesheet"
          href="<?= $base ?>CSS/estilos.css">

    <link rel="stylesheet"
          href="<?= $base ?>CSS/maestria.css">

</head>


<body>


<header class="navbar">


    <a href="<?= $base ?>index.php"
       class="logo">

        Nous Akademia

        <small>
            Estudio y progreso académico
        </small>

    </a>


    <nav class="nav-links">

        <a href="<?= $base ?>index.php"
           class="<?= $paginaActual === "inicio" ? "activo" : "" ?>">
            Inicio
        </a>

        <a href="<?= $vistas ?>repeticionActiva.php"
           class="<?= $paginaActual === "metodo" ? "activo" : "" ?>">
            El método
        </a>

        <a href="<?= $vistas ?>temas.php"
           class="<?= $paginaActual === "temas" ? "activo" : "" ?>">
            Aprender
        </a>

        <a href="<?= $vistas ?>progreso.php"
           class="<?= $paginaActual === "progreso" ? "activo" : "" ?>">
            Mi progreso
        </a>

        <?php if (esAdmin()): ?>

            <a href="<?= $vistas ?>admin.php"
               class="<?= $paginaActual === "admin" ? "activo" : "" ?>">
                Administrar
            </a>

        <?php endif; ?>

    </nav>


    <div class="auth-buttons">

        <?php if ($sesionIniciada): ?>

            <a href="<?= $vistas ?>perfil.php"
               class="login-btn">

                Hola, <?= htmlspecialchars($_SESSION["nombre"] ?? "") ?>

            </a>

        <?php else: ?>

            <a href="<?= $vistas ?>registro.php"
               class="register-btn">

                Registrarse

            </a>

            <a href="<?= $vistas ?>login.php"
               class="login-btn">

                Iniciar sesión

            </a>

        <?php endif; ?>

    </div>


</header>
