<?php


/* =====================================================
   FUNCIONES AUXILIARES DE TEXTO
   (usan mbstring si está activo; si no, un respaldo)
===================================================== */

function longitudTexto(
    $texto
)
{

    if (function_exists("mb_strlen")) {

        return mb_strlen($texto, "UTF-8");

    }

    return preg_match_all("/./su", $texto);

}


function minusculasTexto(
    $texto
)
{

    if (function_exists("mb_strtolower")) {

        return mb_strtolower($texto, "UTF-8");

    }

    return strtolower($texto);

}


/* =====================================================
   VALIDAR QUE SEA POST
===================================================== */

function validarMetodoPost()
{

    return
        $_SERVER["REQUEST_METHOD"]
        === "POST";

}


/* =====================================================
   VALIDAR TEXTO OBLIGATORIO
===================================================== */

function validarTexto(
    $texto
)
{

    return
        trim($texto) !== "";

}


/* =====================================================
   VALIDAR LONGITUD MÁXIMA
===================================================== */

function validarLongitudMaxima(
    $texto,
    $maximo
)
{

    return
        longitudTexto(trim($texto))
        <= $maximo;

}


/* =====================================================
   VALIDAR CORREO
===================================================== */

function validarCorreo(
    $correo
)
{

    return
        filter_var(
            $correo,
            FILTER_VALIDATE_EMAIL
        ) !== false;

}


/* =====================================================
   VALIDAR CONTRASEÑA
===================================================== */

function validarPassword(
    $password,
    $minimo = 6
)
{

    return
        strlen($password)
        >= $minimo;

}


/* =====================================================
   VALIDAR CONFIRMACIÓN DE CONTRASEÑA
===================================================== */

function validarPasswordConfirmada(
    $password,
    $confirmar
)
{

    return
        $password === $confirmar;

}


/* =====================================================
   VALIDAR ID
===================================================== */

function validarId(
    $id
)
{

    return
        intval($id) > 0;

}


/* =====================================================
   VALIDAR LA OPCIÓN CORRECTA (1 a 4)
===================================================== */

function validarOpcionCorrecta(
    $numero
)
{

    return
        is_numeric($numero)
        &&
        intval($numero) >= 1
        &&
        intval($numero) <= 4;

}


/* =====================================================
   VALIDAR QUE LAS OPCIONES SEAN DISTINTAS
   (ignora mayúsculas y espacios sobrantes)
===================================================== */

function validarOpcionesDistintas(
    $opciones
)
{

    $vistas = [];


    foreach ($opciones as $opcion) {

        $clave =
            minusculasTexto(trim($opcion));


        if (in_array($clave, $vistas, true)) {

            return false;

        }


        $vistas[] = $clave;

    }


    return true;

}

?>
