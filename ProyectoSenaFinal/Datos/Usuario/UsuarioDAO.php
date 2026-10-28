<?php

require_once __DIR__ . "/../../Config/conexionBDD.php";


class UsuarioDAO
{

    private $conexion;


    public function __construct()
    {

        global $conexion;

        $this->conexion = $conexion;

    }


    /* =====================================================
       COMPROBAR SI EXISTE UN CORREO
    ===================================================== */

    public function existeCorreo($correo)
    {

        $sql = "SELECT id_usuario
                FROM usuarios
                WHERE correo = ?
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param("s", $correo);

        $stmt->execute();

        $resultado = $stmt->get_result();

        $existe = $resultado->num_rows > 0;

        $stmt->close();

        return $existe;

    }


    /* =====================================================
       REGISTRAR USUARIO (rol estudiante por defecto)
    ===================================================== */

    public function registrarUsuario($nombre, $correo, $password)
    {

        $sql = "INSERT INTO usuarios
                (nombre, correo, password)
                VALUES (?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param("sss", $nombre, $correo, $password);

        if (!$stmt->execute()) {

            $stmt->close();

            return false;

        }

        $idUsuario = $stmt->insert_id;

        $stmt->close();

        return $idUsuario;

    }


    /* =====================================================
       OBTENER USUARIO POR CORREO
    ===================================================== */

    public function obtenerPorCorreo($correo)
    {

        $sql = "SELECT id_usuario, nombre, correo, password
                FROM usuarios
                WHERE correo = ?
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return null;

        }

        $stmt->bind_param("s", $correo);

        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows !== 1) {

            $stmt->close();

            return null;

        }

        $usuario = $resultado->fetch_assoc();

        $stmt->close();

        return $usuario;

    }


    /* =====================================================
       OBTENER ROL (NUEVO)
    ===================================================== */

    public function obtenerRol($idUsuario)
    {

        $sql = "SELECT rol
                FROM usuarios
                WHERE id_usuario = ?
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return null;

        }

        $stmt->bind_param("i", $idUsuario);

        $stmt->execute();

        $resultado = $stmt->get_result();

        $rol = null;

        if ($resultado->num_rows === 1) {

            $fila = $resultado->fetch_assoc();

            $rol = $fila["rol"];

        }

        $stmt->close();

        return $rol;

    }

}

?>
