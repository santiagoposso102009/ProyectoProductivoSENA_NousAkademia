<?php

require_once __DIR__ . "/../../Config/conexionBDD.php";


class IntentoDAO
{

    private $conexion;


    public function __construct()
    {

        global $conexion;

        $this->conexion = $conexion;

    }


    /* =====================================================
       REGISTRAR INTENTO
    ===================================================== */

    public function registrarIntento(
        $idUsuario,
        $idNivel,
        $aciertos,
        $total,
        $porcentaje,
        $aprobado
    )
    {

        $sql = "INSERT INTO intentos
                (
                    id_usuario,
                    id_nivel,
                    aciertos,
                    total,
                    porcentaje,
                    aprobado
                )
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param(
            "iiiidi",
            $idUsuario,
            $idNivel,
            $aciertos,
            $total,
            $porcentaje,
            $aprobado
        );

        if (!$stmt->execute()) {

            $stmt->close();

            return false;

        }

        $idIntento = $stmt->insert_id;

        $stmt->close();

        return $idIntento;

    }


    /* =====================================================
       OBTENER UN INTENTO DEL USUARIO
    ===================================================== */

    public function obtenerIntento($idIntento, $idUsuario)
    {

        $sql = "SELECT
                    i.id_intento,
                    i.id_nivel,
                    i.aciertos,
                    i.total,
                    i.porcentaje,
                    i.aprobado,
                    n.numero,
                    n.nombre AS nivel_nombre,
                    n.id_tema,
                    t.nombre AS tema_nombre

                FROM intentos i

                INNER JOIN niveles n
                    ON n.id_nivel = i.id_nivel

                INNER JOIN temas t
                    ON t.id_tema = n.id_tema

                WHERE i.id_intento = ?
                AND i.id_usuario = ?

                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return null;

        }

        $stmt->bind_param("ii", $idIntento, $idUsuario);

        $stmt->execute();

        $resultado = $stmt->get_result();

        $intento = null;

        if ($resultado->num_rows === 1) {

            $intento = $resultado->fetch_assoc();

        }

        $stmt->close();

        return $intento;

    }


    /* =====================================================
       ÚLTIMOS INTENTOS DEL USUARIO
    ===================================================== */

    public function ultimosIntentos($idUsuario, $limite)
    {

        $sql = "SELECT
                    i.aciertos,
                    i.total,
                    i.porcentaje,
                    i.aprobado,
                    i.fecha,
                    n.numero,
                    n.nombre AS nivel_nombre,
                    t.nombre AS tema_nombre

                FROM intentos i

                INNER JOIN niveles n
                    ON n.id_nivel = i.id_nivel

                INNER JOIN temas t
                    ON t.id_tema = n.id_tema

                WHERE i.id_usuario = ?

                ORDER BY i.fecha DESC, i.id_intento DESC

                LIMIT ?";

        $stmt = $this->conexion->prepare($sql);

        $intentos = [];

        if (!$stmt) {

            return $intentos;

        }

        $stmt->bind_param("ii", $idUsuario, $limite);

        $stmt->execute();

        $resultado = $stmt->get_result();

        while ($fila = $resultado->fetch_assoc()) {

            $intentos[] = $fila;

        }

        $stmt->close();

        return $intentos;

    }


    /* =====================================================
       ESTADÍSTICAS DEL USUARIO
    ===================================================== */

    public function obtenerEstadisticas($idUsuario)
    {

        $sql = "SELECT
                    COUNT(*) AS total_intentos,

                    COUNT(DISTINCT CASE
                        WHEN aprobado = 1 THEN id_nivel
                    END) AS niveles_aprobados,

                    COALESCE(AVG(porcentaje), 0) AS promedio

                FROM intentos

                WHERE id_usuario = ?";

        $stmt = $this->conexion->prepare($sql);

        $vacio = [
            "total_intentos" => 0,
            "niveles_aprobados" => 0,
            "promedio" => 0
        ];

        if (!$stmt) {

            return $vacio;

        }

        $stmt->bind_param("i", $idUsuario);

        $stmt->execute();

        $fila = $stmt->get_result()->fetch_assoc();

        $stmt->close();

        return [
            "total_intentos" => intval($fila["total_intentos"]),
            "niveles_aprobados" => intval($fila["niveles_aprobados"]),
            "promedio" => floatval($fila["promedio"])
        ];

    }

}

?>
