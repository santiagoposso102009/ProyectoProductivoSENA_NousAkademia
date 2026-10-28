<?php

require_once __DIR__ . "/../Datos/Usuario/UsuarioDAO.php";

require_once __DIR__ . "/../Validaciones/validarFormulario.php";


/* =====================================================
   COMPROBAR QUE EL FORMULARIO FUE ENVIADO
===================================================== */

if (!validarMetodoPost()) {

    header(
        "Location: ../Vistas/registro.php"
    );

    exit;

}


/* =====================================================
   RECIBIR DATOS
===================================================== */

$nombre =
    trim(
        $_POST["nombre"] ?? ""
    );


$correo =
    trim(
        $_POST["correo"] ?? ""
    );


$password =
    $_POST["password"] ?? "";


$confirmar =
    $_POST["confirmar"] ?? "";



/* =====================================================
   VALIDAR CAMPOS OBLIGATORIOS
===================================================== */

if (
    !validarTexto($nombre)
    ||
    !validarTexto($correo)
    ||
    !validarTexto($password)
    ||
    !validarTexto($confirmar)
) {

    die(
        "Todos los campos son obligatorios."
    );

}


/* =====================================================
   VALIDAR NOMBRE
===================================================== */

if (
    !validarLongitudMaxima(
        $nombre,
        100
    )
) {

    die(
        "El nombre es demasiado largo."
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
   VALIDAR CONTRASEÑA
===================================================== */

if (
    !validarPassword(
        $password,
        6
    )
) {

    die(
        "La contraseña debe tener al menos 6 caracteres."
    );

}


/* =====================================================
   CONFIRMAR CONTRASEÑA
===================================================== */

if (
    !validarPasswordConfirmada(
        $password,
        $confirmar
    )
) {

    die(
        "Las contraseñas no coinciden."
    );

}


/* =====================================================
   CREAR DAO
===================================================== */

$usuarioDAO =
    new UsuarioDAO();



/* =====================================================
   COMPROBAR CORREO
===================================================== */

if (
    $usuarioDAO->existeCorreo(
        $correo
    )
) {

    die(
        "Ya existe una cuenta con ese correo."
    );

}


/* =====================================================
   PROTEGER CONTRASEÑA
===================================================== */

$passwordSegura =
    password_hash(
        $password,
        PASSWORD_DEFAULT
    );


/* =====================================================
   REGISTRAR USUARIO
===================================================== */

$idUsuario =
    $usuarioDAO->registrarUsuario(
        $nombre,
        $correo,
        $passwordSegura
    );


/* =====================================================
   COMPROBAR REGISTRO
===================================================== */

if ($idUsuario === false) {

    die(
        "Error al registrar el usuario."
    );

}


/* =====================================================
   REDIRECCIÓN
===================================================== */

header(
    "Location: ../Vistas/login.php?registro=exitoso"
);

exit;

?>