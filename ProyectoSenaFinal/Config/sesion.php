<?php

/* =====================================================
   SESIÓN Y PERMISOS
   (se incluye desde Vistas/ y Procesos/)
===================================================== */

if (session_status() === PHP_SESSION_NONE) {

    session_start();

}

require_once __DIR__ . "/../Datos/Usuario/UsuarioDAO.php";


function redirigir($ruta)
{

    header("Location: " . $ruta);

    exit;

}


/* Exige sesión iniciada y devuelve el id del usuario */

function requerirSesion()
{

    if (!isset($_SESSION["id_usuario"])) {

        redirigir("../Vistas/login.php");

    }

    return intval($_SESSION["id_usuario"]);

}


/* Consulta el rol en la BD (no se guarda en sesión) */

function esAdmin()
{

    static $admin = null;

    if ($admin !== null) {

        return $admin;

    }

    if (!isset($_SESSION["id_usuario"])) {

        $admin = false;

        return $admin;

    }

    $usuarioDAO = new UsuarioDAO();

    $admin =
        $usuarioDAO->obtenerRol(
            intval($_SESSION["id_usuario"])
        ) === "admin";

    return $admin;

}


/* Exige rol administrador */

function requerirAdmin()
{

    $idUsuario = requerirSesion();

    if (!esAdmin()) {

        redirigir("../Vistas/temas.php");

    }

    return $idUsuario;

}

?>
