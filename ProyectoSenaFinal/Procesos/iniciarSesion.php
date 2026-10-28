<?php

session_start();

require_once __DIR__ . "/../Datos/Usuario/UsuarioDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


/* =====================================================
   COMPROBAR MÉTODO
===================================================== */

if (!validarMetodoPost()) {

    header(
        "Location: ../Vistas/login.php"
    );

    exit;

}


/* =====================================================
   RECIBIR DATOS
===================================================== */

$correo =
    trim(
        $_POST["correo"] ?? ""
    );


$password =
    $_POST["password"] ?? "";



/* =====================================================
   VALIDAR CAMPOS
===================================================== */

if (
    !validarTexto($correo)
    ||
    !validarTexto($password)
) {

    die(
        "Debes completar todos los campos."
    );

}


/* =====================================================
   VALIDAR CORREO
===================================================== */

if (
    !validarCorreo($correo)
) {

    die(
        "El correo electrónico no es válido."
    );

}


/* =====================================================
   BUSCAR USUARIO
===================================================== */

$usuarioDAO =
    new UsuarioDAO();


$usuario =
    $usuarioDAO->obtenerPorCorreo(
        $correo
    );


/* =====================================================
   COMPROBAR USUARIO
===================================================== */

if ($usuario === null) {

    die(
        "Correo o contraseña incorrectos."
    );

}


/* =====================================================
   COMPROBAR CONTRASEÑA
===================================================== */

if (
    !password_verify(
        $password,
        $usuario["password"]
    )
) {

    die(
        "Correo o contraseña incorrectos."
    );

}


/* =====================================================
   CREAR SESIÓN
===================================================== */

$_SESSION["id_usuario"] =
    $usuario["id_usuario"];


$_SESSION["nombre"] =
    $usuario["nombre"];


$_SESSION["correo"] =
    $usuario["correo"];



/* =====================================================
   REDIRECCIÓN
===================================================== */

header(
    "Location: ../Vistas/progreso.php"
);

exit;

?>