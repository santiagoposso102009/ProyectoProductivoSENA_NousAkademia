-- =====================================================
-- NOUS AKADEMIA - MIGRACIÓN A MAESTRÍA POR TEMAS
-- Haz una copia de seguridad (Exportar) antes de ejecutar.
-- Ejecutar UNA vez en phpMyAdmin > nous_akademia > SQL
-- =====================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `feynman`;
DROP TABLE IF EXISTS `progreso`;
DROP TABLE IF EXISTS `sesiones_estudio`;
DROP TABLE IF EXISTS `usuario_metodos`;
DROP TABLE IF EXISTS `metodos`;
DROP TABLE IF EXISTS `materias`;
DROP TABLE IF EXISTS `flashcards`;

SET FOREIGN_KEY_CHECKS = 1;

-- Rol de usuario (el usuario 1 queda como administrador)
ALTER TABLE `usuarios`
  ADD COLUMN IF NOT EXISTS `rol` ENUM('estudiante','admin') NOT NULL DEFAULT 'estudiante' AFTER `password`;

UPDATE `usuarios` SET `rol` = 'admin' WHERE `id_usuario` = 1;

-- Temas (los crea el administrador)
CREATE TABLE `temas` (
  `id_tema` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL DEFAULT '',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_tema`),
  UNIQUE KEY `nombre_unico` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Niveles de cada tema
CREATE TABLE `niveles` (
  `id_nivel` int(11) NOT NULL AUTO_INCREMENT,
  `id_tema` int(11) NOT NULL,
  `numero` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_nivel`),
  UNIQUE KEY `tema_numero` (`id_tema`,`numero`),
  CONSTRAINT `niveles_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Flashcards de opción múltiple.
-- Relaciones: id_nivel -> niveles (cada pregunta pertenece a un nivel)
--             id_creador -> usuarios (administrador que la creó)
CREATE TABLE `flashcards` (
  `id_flashcard` int(11) NOT NULL AUTO_INCREMENT,
  `id_nivel` int(11) NOT NULL,
  `id_creador` int(11) DEFAULT NULL,
  `pregunta` text NOT NULL,
  `respuesta` varchar(500) NOT NULL,
  `incorrecta_1` varchar(500) NOT NULL,
  `incorrecta_2` varchar(500) NOT NULL,
  `incorrecta_3` varchar(500) NOT NULL,
  `pista` varchar(300) NOT NULL DEFAULT '',
  `explicacion` varchar(1000) NOT NULL DEFAULT '',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_flashcard`),
  KEY `id_nivel` (`id_nivel`),
  KEY `id_creador` (`id_creador`),
  CONSTRAINT `flashcards_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `flashcards_ibfk_2` FOREIGN KEY (`id_creador`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Intentos de los estudiantes en cada nivel
CREATE TABLE `intentos` (
  `id_intento` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `aciertos` smallint(5) UNSIGNED NOT NULL,
  `total` smallint(5) UNSIGNED NOT NULL,
  `porcentaje` decimal(5,2) NOT NULL,
  `aprobado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_intento`),
  KEY `usuario_nivel` (`id_usuario`,`id_nivel`),
  KEY `id_nivel` (`id_nivel`),
  CONSTRAINT `intentos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `intentos_ibfk_2` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
