<?php

require_once __DIR__ . "/../../Config/conexionBDD.php";


class FlashcardDAO
{

    private $conexion;


    public function __construct()
    {

        global $conexion;

        $this->conexion = $conexion;

    }


    /* =====================================================
       LISTAR FLASHCARDS DE UN NIVEL (con el nombre del creador)
    ===================================================== */

    public function listarPorNivel($idNivel)
    {

        $sql = "SELECT
                    f.id_flashcard,
                    f.pregunta,
                    f.respuesta,
                    f.incorrecta_1,
                    f.incorrecta_2,
                    f.incorrecta_3,
                    f.pista,
                    f.explicacion,
                    u.nombre AS creador

                FROM flashcards f

                LEFT JOIN usuarios u
                    ON u.id_usuario = f.id_creador

                WHERE f.id_nivel = ?

                ORDER BY f.id_flashcard ASC";

        $stmt = $this->conexion->prepare($sql);

        $flashcards = [];

        if (!$stmt) {

            return $flashcards;

        }

        $stmt->bind_param("i", $idNivel);

        $stmt->execute();

        $resultado = $stmt->get_result();

        while ($fila = $resultado->fetch_assoc()) {

            $flashcards[] = $fila;

        }

        $stmt->close();

        return $flashcards;

    }


    /* =====================================================
       IDS DE LAS FLASHCARDS DE UN NIVEL
    ===================================================== */

    public function obtenerIdsPorNivel($idNivel)
    {

        $ids = [];

        foreach ($this->listarPorNivel($idNivel) as $fila) {

            $ids[] = intval($fila["id_flashcard"]);

        }

        return $ids;

    }


    /* =====================================================
       OBTENER UNA FLASHCARD COMPLETA
    ===================================================== */

    public function obtenerFlashcard($idFlashcard)
    {

        $sql = "SELECT
                    id_flashcard,
                    id_nivel,
                    pregunta,
                    respuesta,
                    incorrecta_1,
                    incorrecta_2,
                    incorrecta_3,
                    pista,
                    explicacion

                FROM flashcards

                WHERE id_flashcard = ?

                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return null;

        }

        $stmt->bind_param("i", $idFlashcard);

        $stmt->execute();

        $resultado = $stmt->get_result();

        $flashcard = null;

        if ($resultado->num_rows === 1) {

            $flashcard = $resultado->fetch_assoc();

        }

        $stmt->close();

        return $flashcard;

    }


    /* =====================================================
       REGISTRAR FLASHCARD DE OPCIÓN MÚLTIPLE
    ===================================================== */

    public function registrarFlashcard(
        $idNivel,
        $idCreador,
        $pregunta,
        $respuesta,
        $incorrecta1,
        $incorrecta2,
        $incorrecta3,
        $pista,
        $explicacion
    )
    {

        $sql = "INSERT INTO flashcards
                (
                    id_nivel,
                    id_creador,
                    pregunta,
                    respuesta,
                    incorrecta_1,
                    incorrecta_2,
                    incorrecta_3,
                    pista,
                    explicacion
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param(
            "iisssssss",
            $idNivel,
            $idCreador,
            $pregunta,
            $respuesta,
            $incorrecta1,
            $incorrecta2,
            $incorrecta3,
            $pista,
            $explicacion
        );

        if (!$stmt->execute()) {

            $stmt->close();

            return false;

        }

        $idFlashcard = $stmt->insert_id;

        $stmt->close();

        return $idFlashcard;

    }


    /* =====================================================
       ACTUALIZAR FLASHCARD
    ===================================================== */

    public function actualizarFlashcard(
        $idFlashcard,
        $pregunta,
        $respuesta,
        $incorrecta1,
        $incorrecta2,
        $incorrecta3,
        $pista,
        $explicacion
    )
    {

        $sql = "UPDATE flashcards

                SET pregunta = ?,
                    respuesta = ?,
                    incorrecta_1 = ?,
                    incorrecta_2 = ?,
                    incorrecta_3 = ?,
                    pista = ?,
                    explicacion = ?

                WHERE id_flashcard = ?";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param(
            "sssssssi",
            $pregunta,
            $respuesta,
            $incorrecta1,
            $incorrecta2,
            $incorrecta3,
            $pista,
            $explicacion,
            $idFlashcard
        );

        $correcto = $stmt->execute();

        $stmt->close();

        return $correcto;

    }


    /* =====================================================
       ELIMINAR FLASHCARD
    ===================================================== */

    public function eliminarFlashcard($idFlashcard)
    {

        $sql = "DELETE FROM flashcards
                WHERE id_flashcard = ?";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {

            return false;

        }

        $stmt->bind_param("i", $idFlashcard);

        if (!$stmt->execute()) {

            $stmt->close();

            return false;

        }

        $eliminadas = $stmt->affected_rows;

        $stmt->close();

        return $eliminadas > 0;

    }

}

?>
