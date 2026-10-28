-- =====================================================
-- SOLO si ya ejecutaste una versión anterior de migracion.sql
-- (la tabla flashcards todavía no tiene la columna id_creador).
-- Si vas a ejecutar migracion.sql desde cero, ignora este archivo.
-- Ejecutar UNA sola vez.
-- =====================================================

ALTER TABLE `flashcards`
  ADD COLUMN IF NOT EXISTS `id_creador` int(11) DEFAULT NULL AFTER `id_nivel`;

ALTER TABLE `flashcards`
  ADD CONSTRAINT `flashcards_ibfk_2` FOREIGN KEY (`id_creador`)
  REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Las preguntas que ya existían quedan a nombre del primer administrador
UPDATE `flashcards`
SET `id_creador` = (
    SELECT `id_usuario` FROM `usuarios`
    WHERE `rol` = 'admin' ORDER BY `id_usuario` LIMIT 1
)
WHERE `id_creador` IS NULL;
