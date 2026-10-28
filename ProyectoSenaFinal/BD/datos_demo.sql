-- OPCIONAL: tema de prueba (ejecutar después de migracion.sql)
INSERT INTO temas (nombre, descripcion) VALUES
('Biología', 'La célula y los seres vivos.');
SET @t = LAST_INSERT_ID();

INSERT INTO niveles (id_tema, numero, nombre, descripcion) VALUES
(@t, 1, 'La célula', 'Conceptos básicos de la célula'),
(@t, 2, 'Genética básica', 'ADN, genes y herencia');

SET @n1 = (SELECT id_nivel FROM niveles WHERE id_tema=@t AND numero=1);
SET @n2 = (SELECT id_nivel FROM niveles WHERE id_tema=@t AND numero=2);

INSERT INTO flashcards (id_nivel, pregunta, respuesta) VALUES
(@n1, '¿Cuál es la unidad básica de los seres vivos?', 'La célula.'),
(@n1, '¿Qué orgánulo produce la mayor parte de la energía celular?', 'La mitocondria.'),
(@n1, '¿Qué estructura protege y delimita a la célula?', 'La membrana plasmática.'),
(@n1, '¿Dónde se encuentra el material genético en una célula eucariota?', 'En el núcleo.'),
(@n1, '¿Qué orgánulo realiza la fotosíntesis?', 'El cloroplasto.'),
(@n2, '¿Qué molécula contiene la información genética?', 'El ADN.'),
(@n2, '¿Cómo se llama cada unidad de información hereditaria?', 'Gen.'),
(@n2, '¿Cuántos cromosomas tiene una célula humana normal?', '46 (23 pares).'),
(@n2, '¿Cómo se llaman las distintas versiones de un gen?', 'Alelos.'),
(@n2, '¿Qué es un genotipo?', 'El conjunto de genes de un individuo.');
