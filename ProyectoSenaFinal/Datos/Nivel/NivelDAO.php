<?php

require_once __DIR__ . "/../../Config/conexionBDD.php";

require_once __DIR__ . "/../../Config/constantes.php";


class NivelDAO
{

    private $conexion;


    public function __construct()
    {

        global $conexion;

        $this->conexion = $conexion;

    }


    /* =====================================================
       OBTENER NIVEL
    ===================================================== */

    public function obtenerNivel($idNivel)
    {

        $sql = "SELECT id_nivel, id_tema, numero, nombre, descripcion
                FROM niveles
                WHERE id_nivel = ?
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return null;

        }

        $stmt->bind_param("i", $idNivel);

        $stmt->execute();

        $resultado = $stmt->get_result();

        $nivel = null;

        if ($resultado->num_rows === 1) {

            $nivel = $resultado->fetch_assoc();

        }

        $stmt->close();

        return $nivel;

    }


    /* =====================================================
       LISTAR NIVELES DE UN TEMA (vista del administrador)
    ===================================================== */

    public function listarNiveles($idTema)
    {

        $sql = "SELECT
                    n.id_nivel,
                    n.numero,
                    n.nombre,
                    n.descripcion,
                    COUNT(f.id_flashcard) AS total_flashcards

                FROM niveles n

                LEFT JOIN flashcards f
                    ON f.id_nivel = n.id_nivel

                WHERE n.id_tema = ?

                GROUP BY n.id_nivel, n.numero, n.nombre, n.descripcion

                ORDER BY n.numero ASC";

        $stmt = $this->conexion->prepare($sql);

        $niveles = [];

        if (!$stmt) {

            return $niveles;

        }

        $stmt->bind_param("i", $idTema);

        $stmt->execute();

        $resultado = $stmt->get_result();

        while ($fila = $resultado->fetch_assoc()) {

            $niveles[] = $fila;

        }

        $stmt->close();

        return $niveles;

    }


    /* =====================================================
       LISTAR NIVELES CON SU ESTADO PARA UN ESTUDIANTE

       aprobado     -> ya lo superó alguna vez
       disponible   -> es el siguiente que puede practicar
       bloqueado    -> debe superar el anterior
       construccion -> aún no tiene las flashcards mínimas
    ===================================================== */

    public function listarNivelesConEstado($idUsuario, $idTema)
    {

        $sql = "SELECT
                    n.id_nivel,
                    n.numero,
                    n.nombre,
                    n.descripcion,

                    (SELECT COUNT(*)
                     FROM flashcards f
                     WHERE f.id_nivel = n.id_nivel)
                    AS total_flashcards,

                    (SELECT COALESCE(MAX(i.porcentaje), 0)
                     FROM intentos i
                     WHERE i.id_nivel = n.id_nivel
                     AND i.id_usuario = ?)
                    AS mejor_porcentaje,

                    (SELECT COUNT(*)
                     FROM intentos i
                     WHERE i.id_nivel = n.id_nivel
                     AND i.id_usuario = ?)
                    AS total_intentos,

                    (SELECT COUNT(*)
                     FROM intentos i
                     WHERE i.id_nivel = n.id_nivel
                     AND i.id_usuario = ?
                     AND i.aprobado = 1)
                    AS veces_aprobado

                FROM niveles n

                WHERE n.id_tema = ?

                ORDER BY n.numero ASC";

        $stmt = $this->conexion->prepare($sql);

        $niveles = [];

        if (!$stmt) {

            return $niveles;

        }

        $stmt->bind_param(
            "iiii",
            $idUsuario,
            $idUsuario,
            $idUsuario,
            $idTema
        );

        $stmt->execute();

        $resultado = $stmt->get_result();

        $anteriorAprobado = true;

        while ($fila = $resultado->fetch_assoc()) {

            $fila["total_flashcards"] =
                intval($fila["total_flashcards"]);

            $fila["mejor_porcentaje"] =
                floatval($fila["mejor_porcentaje"]);

            $fila["total_intentos"] =
                intval($fila["total_intentos"]);

            if (intval($fila["veces_aprobado"]) > 0) {

                $fila["estado"] = "aprobado";

                $anteriorAprobado = true;

            } elseif (
                $fila["total_flashcards"]
                < MINIMO_FLASHCARDS_NIVEL
            ) {

                $fila["estado"] = "construccion";

                $anteriorAprobado = false;

            } elseif ($anteriorAprobado) {

                $fila["estado"] = "disponible";

                $anteriorAprobado = false;

            } else {

                $fila["estado"] = "bloqueado";

            }

            $niveles[] = $fila;

        }

        $stmt->close();

        return $niveles;

    }


    /* =====================================================
       SIGUIENTE NÚMERO DE NIVEL
    ===================================================== */

    public function siguienteNumero($idTema)
    {

        $sql = "SELECT COALESCE(MAX(numero), 0) + 1 AS siguiente
                FROM niveles
                WHERE id_tema = ?";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param("i", $idTema);

        $stmt->execute();

        $fila = $stmt->get_result()->fetch_assoc();

        $stmt->close();

        return intval($fila["siguiente"]);

    }


    /* =====================================================
       REGISTRAR NIVEL
    ===================================================== */

    public function registrarNivel(
        $idTema,
        $numero,
        $nombre,
        $descripcion
    )
    {

        $sql = "INSERT INTO niveles
                (id_tema, numero, nombre, descripcion)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param(
            "iiss",
            $idTema,
            $numero,
            $nombre,
            $descripcion
        );

        if (!$stmt->execute()) {

            $stmt->close();

            return false;

        }

        $idNivel = $stmt->insert_id;

        $stmt->close();

        return $idNivel;

    }


    /* =====================================================
       ELIMINAR NIVEL
    ===================================================== */

    public function eliminarNivel($idNivel)
    {

        $sql = "DELETE FROM niveles
                WHERE id_nivel = ?";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param("i", $idNivel);

        if (!$stmt->execute()) {

            $stmt->close();

            return false;

        }

        $eliminados = $stmt->affected_rows;

        $stmt->close();

        return $eliminados > 0;

    }

}

?>
