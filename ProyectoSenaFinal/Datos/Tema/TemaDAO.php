<?php

require_once __DIR__ . "/../../Config/conexionBDD.php";


class TemaDAO
{

    private $conexion;


    public function __construct()
    {

        global $conexion;

        $this->conexion = $conexion;

    }


    /* =====================================================
       LISTAR TEMAS (con totales de niveles y flashcards)
    ===================================================== */

    public function listarTemas()
    {

        $sql = "SELECT
                    t.id_tema,
                    t.nombre,
                    t.descripcion,
                    COUNT(DISTINCT n.id_nivel) AS total_niveles,
                    COUNT(f.id_flashcard) AS total_flashcards

                FROM temas t

                LEFT JOIN niveles n
                    ON n.id_tema = t.id_tema

                LEFT JOIN flashcards f
                    ON f.id_nivel = n.id_nivel

                GROUP BY t.id_tema, t.nombre, t.descripcion

                ORDER BY t.nombre ASC";

        $resultado = $this->conexion->query($sql);

        $temas = [];

        if ($resultado === false) {

            return $temas;

        }

        while ($fila = $resultado->fetch_assoc()) {

            $temas[] = $fila;

        }

        return $temas;

    }


    /* =====================================================
       OBTENER TEMA
    ===================================================== */

    public function obtenerTema($idTema)
    {

        $sql = "SELECT id_tema, nombre, descripcion
                FROM temas
                WHERE id_tema = ?
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return null;

        }

        $stmt->bind_param("i", $idTema);

        $stmt->execute();

        $resultado = $stmt->get_result();

        $tema = null;

        if ($resultado->num_rows === 1) {

            $tema = $resultado->fetch_assoc();

        }

        $stmt->close();

        return $tema;

    }


    /* =====================================================
       COMPROBAR SI EXISTE UN TEMA
    ===================================================== */

    public function existeTema($nombre)
    {

        $sql = "SELECT id_tema
                FROM temas
                WHERE nombre = ?
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param("s", $nombre);

        $stmt->execute();

        $resultado = $stmt->get_result();

        $existe = $resultado->num_rows > 0;

        $stmt->close();

        return $existe;

    }


    /* =====================================================
       REGISTRAR TEMA
    ===================================================== */

    public function registrarTema($nombre, $descripcion)
    {

        $sql = "INSERT INTO temas
                (nombre, descripcion)
                VALUES (?, ?)";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param("ss", $nombre, $descripcion);

        if (!$stmt->execute()) {

            $stmt->close();

            return false;

        }

        $idTema = $stmt->insert_id;

        $stmt->close();

        return $idTema;

    }


    /* =====================================================
       ELIMINAR TEMA (borra niveles y flashcards en cascada)
    ===================================================== */

    public function eliminarTema($idTema)
    {

        $sql = "DELETE FROM temas
                WHERE id_tema = ?";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param("i", $idTema);

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
