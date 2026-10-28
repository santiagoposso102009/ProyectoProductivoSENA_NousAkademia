-- =====================================================
-- SOLO si ya ejecutaste la primera versión de migracion.sql
-- (la de flashcards "la sabía / aún no la sé").
-- Si aún no has ejecutado ninguna migración, ignora este
-- archivo y usa migracion.sql (ya incluye estos cambios).
--
-- Borra las flashcards existentes: las antiguas no tienen
-- opciones de respuesta y no se pueden usar.
-- =====================================================

DELETE FROM `flashcards`;

ALTER TABLE `flashcards`
  MODIFY `respuesta` varchar(500) NOT NULL,
  ADD COLUMN `incorrecta_1` varchar(500) NOT NULL AFTER `respuesta`,
  ADD COLUMN `incorrecta_2` varchar(500) NOT NULL AFTER `incorrecta_1`,
  ADD COLUMN `incorrecta_3` varchar(500) NOT NULL AFTER `incorrecta_2`,
  ADD COLUMN `pista` varchar(300) NOT NULL DEFAULT '' AFTER `incorrecta_3`,
  ADD COLUMN `explicacion` varchar(1000) NOT NULL DEFAULT '' AFTER `pista`;
