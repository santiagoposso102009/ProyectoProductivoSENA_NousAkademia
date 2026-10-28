-- =====================================================
-- CONTENIDO INICIAL: Biología (3 niveles), Matemáticas
-- (3 niveles) e Inglés (1 nivel), con 10 preguntas por nivel.
--
-- Ejecutar DESPUÉS de migracion.sql.
-- Si ya existen temas con estos nombres (por ejemplo el
-- "Biología" de datos_demo.sql), este script los reemplaza
-- (se borran sus niveles, preguntas y resultados).
-- =====================================================

DELETE FROM temas WHERE nombre IN ('Biología', 'Matemáticas', 'Inglés');

-- Las preguntas quedan a nombre del primer administrador
SET @admin = (SELECT id_usuario FROM usuarios WHERE rol = 'admin' ORDER BY id_usuario LIMIT 1);

-- ---------- BIOLOGÍA ----------
INSERT INTO temas (nombre, descripcion) VALUES ('Biología', 'Biología básica: la célula, la genética y los ecosistemas.');
SET @tema = LAST_INSERT_ID();

INSERT INTO niveles (id_tema, numero, nombre, descripcion) VALUES (@tema, 1, 'La célula', 'Estructura y orgánulos de la célula');
SET @nivel = LAST_INSERT_ID();
INSERT INTO flashcards (id_nivel, id_creador, pregunta, respuesta, incorrecta_1, incorrecta_2, incorrecta_3, pista, explicacion) VALUES
(@nivel, @admin, '¿Cuál es la unidad básica de los seres vivos?', 'La célula', 'El átomo', 'El tejido', 'El órgano', 'Es lo más pequeño que se considera vivo.', 'Todos los seres vivos están formados por una o más células.'),
(@nivel, @admin, '¿Qué orgánulo produce la mayor parte de la energía de la célula?', 'La mitocondria', 'El ribosoma', 'El lisosoma', 'El aparato de Golgi', 'Se le llama la "central energética".', 'La mitocondria realiza la respiración celular y produce ATP.'),
(@nivel, @admin, '¿Qué estructura delimita y protege a la célula?', 'La membrana plasmática', 'El núcleo', 'El citoplasma', 'La vacuola', '', 'La membrana controla qué sustancias entran y salen de la célula.'),
(@nivel, @admin, '¿Dónde se encuentra el ADN en una célula eucariota?', 'En el núcleo', 'En el ribosoma', 'En la membrana', 'En la vacuola', 'Eucariota significa "núcleo verdadero".', 'El ADN de las células eucariotas está protegido dentro del núcleo.'),
(@nivel, @admin, '¿Qué orgánulo realiza la fotosíntesis?', 'El cloroplasto', 'La mitocondria', 'El retículo endoplasmático', 'El lisosoma', 'Solo está en células vegetales.', 'El cloroplasto contiene clorofila y convierte la luz en energía química.'),
(@nivel, @admin, '¿Qué estructura tienen las células vegetales y no las animales?', 'La pared celular', 'La membrana plasmática', 'El núcleo', 'El citoplasma', 'Da rigidez a las plantas.', 'La pared celular, hecha de celulosa, protege y da forma a la célula vegetal.'),
(@nivel, @admin, '¿Cuál es la función de los ribosomas?', 'Fabricar proteínas', 'Producir energía', 'Digerir sustancias', 'Almacenar agua', '', 'Los ribosomas leen el ARN mensajero y ensamblan proteínas.'),
(@nivel, @admin, '¿Qué tipo de célula no tiene un núcleo definido?', 'La célula procariota', 'La célula eucariota', 'La célula vegetal', 'La célula animal', 'Las bacterias son un ejemplo.', 'En las células procariotas el ADN está libre en el citoplasma.'),
(@nivel, @admin, '¿Cómo se llaman los organismos formados por una sola célula?', 'Unicelulares', 'Pluricelulares', 'Mamíferos', 'Árboles', '', 'Las bacterias y las amebas son organismos unicelulares.'),
(@nivel, @admin, '¿Cómo se llama el material gelatinoso que llena el interior de la célula?', 'Citoplasma', 'Savia', 'Cromatina', 'Membrana', 'En él flotan los orgánulos.', 'El citoplasma es el medio donde ocurren muchas reacciones de la célula.');

INSERT INTO niveles (id_tema, numero, nombre, descripcion) VALUES (@tema, 2, 'Genética básica', 'ADN, genes y herencia');
SET @nivel = LAST_INSERT_ID();
INSERT INTO flashcards (id_nivel, id_creador, pregunta, respuesta, incorrecta_1, incorrecta_2, incorrecta_3, pista, explicacion) VALUES
(@nivel, @admin, '¿Qué molécula contiene la información genética?', 'El ADN', 'El almidón', 'El ATP', 'La hemoglobina', '', 'El ADN guarda las instrucciones para construir y hacer funcionar al organismo.'),
(@nivel, @admin, '¿Cómo se llama cada unidad de información hereditaria?', 'Gen', 'Enzima', 'Ribosoma', 'Lípido', 'Es un fragmento de ADN que codifica un rasgo.', 'Un gen es un segmento de ADN con la información de una característica.'),
(@nivel, @admin, '¿Cuántos cromosomas tiene una célula humana normal?', '46', '32', '64', '92', 'Son 23 pares.', 'Las células humanas tienen 23 pares de cromosomas, es decir, 46.'),
(@nivel, @admin, '¿Cómo se llaman las distintas versiones de un mismo gen?', 'Alelos', 'Fenotipos', 'Cariotipos', 'Plásmidos', '', 'Por ejemplo, los alelos del gen del color de ojos.'),
(@nivel, @admin, '¿Qué es el genotipo?', 'El conjunto de genes de un individuo', 'El aspecto visible del individuo', 'El número de cromosomas', 'El ambiente donde vive', '', 'El fenotipo es lo que se ve; el genotipo son los genes que lo determinan.'),
(@nivel, @admin, '¿Quién es considerado el padre de la genética por sus experimentos con guisantes?', 'Gregor Mendel', 'Charles Darwin', 'Louis Pasteur', 'Alexander Fleming', 'Fue un monje del siglo XIX.', 'Mendel descubrió las leyes de la herencia cruzando plantas de guisante.'),
(@nivel, @admin, 'Un alelo dominante se caracteriza porque:', 'Se expresa aunque solo haya una copia', 'Solo se expresa si hay dos copias', 'Nunca se expresa', 'Solo está en los hombres', '', 'Si hay un alelo dominante, este determina el rasgo aunque el otro alelo sea recesivo.'),
(@nivel, @admin, '¿Cómo se llama la célula que resulta de la unión de un óvulo y un espermatozoide?', 'Cigoto', 'Gameto', 'Cromosoma', 'Plásmido', '', 'El cigoto es la primera célula de un nuevo individuo.'),
(@nivel, @admin, '¿Cuántos cromosomas tiene un óvulo o un espermatozoide humano?', '23', '46', '92', '12', 'Es la mitad de los de una célula normal.', 'Los gametos son haploides: tienen 23 cromosomas, la mitad que el resto de las células.'),
(@nivel, @admin, '¿Qué cromosomas sexuales tiene un hombre?', 'XY', 'XX', 'YY', 'XO', '', 'Las mujeres tienen XX y los hombres XY.');

INSERT INTO niveles (id_tema, numero, nombre, descripcion) VALUES (@tema, 3, 'Ecosistemas y evolución', 'Cadenas alimentarias, relaciones entre especies y evolución');
SET @nivel = LAST_INSERT_ID();
INSERT INTO flashcards (id_nivel, id_creador, pregunta, respuesta, incorrecta_1, incorrecta_2, incorrecta_3, pista, explicacion) VALUES
(@nivel, @admin, '¿Cómo se llama el conjunto formado por los seres vivos y su entorno físico?', 'Ecosistema', 'Población', 'Especie', 'Organismo', '', 'Un ecosistema incluye a los seres vivos y los factores del medio, como el agua, el suelo y el clima.'),
(@nivel, @admin, '¿Cómo se llaman los organismos que fabrican su propio alimento?', 'Productores', 'Consumidores', 'Descomponedores', 'Parásitos', 'Las plantas son un ejemplo.', 'Los productores, como las plantas, elaboran su alimento mediante la fotosíntesis.'),
(@nivel, @admin, 'En una cadena alimentaria, ¿qué hacen los descomponedores?', 'Transforman la materia muerta en nutrientes', 'Fabrican su alimento con luz', 'Cazan a otros animales', 'Producen oxígeno', 'Hongos y bacterias.', 'Los descomponedores devuelven los nutrientes al suelo para que los usen los productores.'),
(@nivel, @admin, 'Un animal que se alimenta únicamente de plantas es:', 'Herbívoro', 'Carnívoro', 'Omnívoro', 'Descomponedor', '', 'Los herbívoros, como la vaca o el conejo, comen solo vegetales.'),
(@nivel, @admin, '¿Quién propuso la teoría de la evolución por selección natural?', 'Charles Darwin', 'Gregor Mendel', 'Isaac Newton', 'Louis Pasteur', 'Viajó en el barco Beagle.', 'Darwin propuso que sobreviven y se reproducen más los individuos mejor adaptados.'),
(@nivel, @admin, '¿Qué es una especie?', 'Un grupo de organismos que se reproducen entre sí y tienen descendencia fértil', 'Cualquier grupo de animales que viven juntos', 'Todos los seres vivos de un ecosistema', 'Un conjunto de plantas del mismo lugar', '', 'El criterio de la descendencia fértil distingue a una especie de otra.'),
(@nivel, @admin, '¿Qué gas absorben las plantas durante la fotosíntesis?', 'Dióxido de carbono', 'Oxígeno', 'Nitrógeno', 'Hidrógeno', '', 'Las plantas toman dióxido de carbono y liberan oxígeno.'),
(@nivel, @admin, '¿Cómo se llama la relación en la que las dos especies se benefician?', 'Mutualismo', 'Parasitismo', 'Depredación', 'Competencia', 'Un ejemplo son las abejas y las flores.', 'En el mutualismo ambas especies obtienen una ventaja.'),
(@nivel, @admin, '¿Cuál es la fuente de energía de casi todos los ecosistemas?', 'El Sol', 'El suelo', 'El agua', 'El viento', '', 'La energía solar entra a los ecosistemas por medio de la fotosíntesis.'),
(@nivel, @admin, '¿Qué significa que una especie esté "en peligro de extinción"?', 'Su población es tan pequeña que podría desaparecer', 'Ya desapareció por completo', 'Vive solo en zoológicos', 'Se reproduce demasiado rápido', '', 'Una especie en peligro tiene pocos individuos y necesita protección para sobrevivir.');

-- ---------- MATEMÁTICAS ----------
INSERT INTO temas (nombre, descripcion) VALUES ('Matemáticas', 'Aritmética, álgebra y geometría básicas.');
SET @tema = LAST_INSERT_ID();

INSERT INTO niveles (id_tema, numero, nombre, descripcion) VALUES (@tema, 1, 'Operaciones y fracciones', 'Aritmética básica, fracciones y porcentajes');
SET @nivel = LAST_INSERT_ID();
INSERT INTO flashcards (id_nivel, id_creador, pregunta, respuesta, incorrecta_1, incorrecta_2, incorrecta_3, pista, explicacion) VALUES
(@nivel, @admin, '¿Cuánto es 12 × 8?', '96', '86', '108', '88', '', '12 × 8 = 96.'),
(@nivel, @admin, '¿Cuánto es 144 ÷ 12?', '12', '14', '11', '16', '', '12 × 12 = 144, por eso 144 ÷ 12 = 12.'),
(@nivel, @admin, '¿Cuál es el resultado de 3 + 4 × 2?', '11', '14', '10', '24', 'Primero se multiplica.', 'Se resuelve primero la multiplicación: 4 × 2 = 8, y luego 3 + 8 = 11.'),
(@nivel, @admin, '¿Cuánto es 1/2 + 1/4?', '3/4', '2/6', '1/6', '1/8', 'Convierte 1/2 en cuartos.', '1/2 = 2/4, y 2/4 + 1/4 = 3/4.'),
(@nivel, @admin, '¿Qué fracción es equivalente a 2/4?', '1/2', '1/4', '2/3', '3/4', 'Divide numerador y denominador entre 2.', '2/4 se simplifica dividiendo entre 2 y queda 1/2.'),
(@nivel, @admin, '¿Cuánto es el 10 % de 250?', '25', '10', '50', '2,5', '10 % es lo mismo que dividir entre 10.', 'El 10 % de 250 es 250 ÷ 10 = 25.'),
(@nivel, @admin, '¿Cuál de estos números es primo?', '17', '15', '21', '27', 'Solo es divisible entre 1 y entre sí mismo.', '17 solo se puede dividir exactamente entre 1 y 17. Los otros tienen más divisores.'),
(@nivel, @admin, '¿Cuánto es (−5) + 8?', '3', '−3', '13', '−13', '', 'Al sumar 8 a −5 avanzas 8 unidades desde −5 y llegas a 3.'),
(@nivel, @admin, '¿Cuánto es 7²?', '49', '14', '42', '77', 'Es 7 × 7.', '7² = 7 × 7 = 49.'),
(@nivel, @admin, '¿Cuál es el resultado de 0,5 × 6?', '3', '30', '0,3', '12', '0,5 es la mitad.', 'Multiplicar por 0,5 es lo mismo que tomar la mitad: la mitad de 6 es 3.');

INSERT INTO niveles (id_tema, numero, nombre, descripcion) VALUES (@tema, 2, 'Álgebra básica', 'Ecuaciones y expresiones algebraicas sencillas');
SET @nivel = LAST_INSERT_ID();
INSERT INTO flashcards (id_nivel, id_creador, pregunta, respuesta, incorrecta_1, incorrecta_2, incorrecta_3, pista, explicacion) VALUES
(@nivel, @admin, 'Si x + 7 = 15, ¿cuánto vale x?', '8', '22', '7', '9', 'Resta 7 en ambos lados.', 'x = 15 − 7 = 8.'),
(@nivel, @admin, 'Si 3x = 21, ¿cuánto vale x?', '7', '18', '24', '63', 'Divide entre 3 en ambos lados.', 'x = 21 ÷ 3 = 7.'),
(@nivel, @admin, 'Simplifica: 2x + 3x', '5x', '6x', '5x²', '2x³', 'Los términos son semejantes.', 'Al sumar términos semejantes se suman los coeficientes: 2 + 3 = 5, queda 5x.'),
(@nivel, @admin, '¿Cuál es el valor de 2x + 1 cuando x = 4?', '9', '8', '10', '12', 'Sustituye x por 4.', '2 × 4 + 1 = 8 + 1 = 9.'),
(@nivel, @admin, 'Resuelve: 2x − 4 = 10', 'x = 7', 'x = 3', 'x = 5', 'x = 14', 'Primero suma 4 en ambos lados.', '2x = 14, y por tanto x = 7.'),
(@nivel, @admin, '¿Cuál es el resultado de (x + 2)(x + 3)?', 'x² + 5x + 6', 'x² + 6', 'x² + 5x + 5', '2x + 5', 'Multiplica cada término por cada término.', 'x·x + x·3 + 2·x + 2·3 = x² + 5x + 6.'),
(@nivel, @admin, '¿Cuál de estas es una ecuación lineal?', '2x + 5 = 11', 'x² − 4 = 0', 'x³ = 8', '1/x = 2', 'En una ecuación lineal, x tiene exponente 1.', 'Solo 2x + 5 = 11 tiene la incógnita elevada a 1.'),
(@nivel, @admin, 'Si y = 2x + 1, ¿cuánto vale y cuando x = 3?', '7', '6', '5', '9', '', 'y = 2 × 3 + 1 = 7.'),
(@nivel, @admin, 'Resuelve: x/4 = 5', 'x = 20', 'x = 9', 'x = 1,25', 'x = 24', 'Multiplica ambos lados por 4.', 'x = 5 × 4 = 20.'),
(@nivel, @admin, '¿Cuál es la pendiente de la recta y = 3x − 2?', '3', '−2', '2', '1/3', 'Es el número que multiplica a x.', 'En y = mx + b, la pendiente es m; aquí m = 3.');

INSERT INTO niveles (id_tema, numero, nombre, descripcion) VALUES (@tema, 3, 'Geometría', 'Ángulos, perímetros, áreas y figuras');
SET @nivel = LAST_INSERT_ID();
INSERT INTO flashcards (id_nivel, id_creador, pregunta, respuesta, incorrecta_1, incorrecta_2, incorrecta_3, pista, explicacion) VALUES
(@nivel, @admin, '¿Cuántos grados suman los ángulos interiores de un triángulo?', '180°', '90°', '360°', '270°', '', 'Los tres ángulos de cualquier triángulo suman siempre 180°.'),
(@nivel, @admin, '¿Cuál es el área de un rectángulo de 5 cm de base y 3 cm de altura?', '15 cm²', '8 cm²', '16 cm²', '15 cm', 'Área = base × altura.', '5 × 3 = 15, y el área se expresa en unidades cuadradas: 15 cm².'),
(@nivel, @admin, '¿Cuál es el perímetro de un cuadrado de lado 4 cm?', '16 cm', '8 cm', '12 cm', '20 cm', 'Suma sus cuatro lados.', '4 + 4 + 4 + 4 = 16 cm.'),
(@nivel, @admin, '¿Cómo se llama un ángulo de exactamente 90°?', 'Recto', 'Agudo', 'Obtuso', 'Llano', '', 'Los ángulos agudos miden menos de 90° y los obtusos más de 90°.'),
(@nivel, @admin, 'En un triángulo rectángulo con catetos de 3 y 4, ¿cuánto mide la hipotenusa?', '5', '7', '6', '12', 'Usa el teorema de Pitágoras.', '3² + 4² = 9 + 16 = 25, y la raíz cuadrada de 25 es 5.'),
(@nivel, @admin, '¿Cuál es el área de un triángulo de base 6 y altura 4?', '12', '24', '10', '20', 'Es la mitad de base × altura.', '(6 × 4) ÷ 2 = 12.'),
(@nivel, @admin, '¿Cuál es la fórmula del área de un círculo?', 'π × r²', '2 × π × r', 'π × r', '2 × r²', '', '2 × π × r es la longitud de la circunferencia; el área es π × r².'),
(@nivel, @admin, '¿Cuántos lados tiene un hexágono?', '6', '5', '8', '7', '', 'Hexa significa seis.'),
(@nivel, @admin, 'Si el radio de una circunferencia mide 5 cm, ¿cuánto mide su diámetro?', '10 cm', '2,5 cm', '15 cm', '25 cm', 'El diámetro es el doble del radio.', 'Diámetro = 2 × radio = 10 cm.'),
(@nivel, @admin, '¿Cuánto suman dos ángulos complementarios?', '90°', '180°', '360°', '45°', '', 'Los suplementarios suman 180° y los complementarios 90°.');

-- ---------- INGLÉS ----------
INSERT INTO temas (nombre, descripcion) VALUES ('Inglés', 'Vocabulario y gramática básica del inglés.');
SET @tema = LAST_INSERT_ID();

INSERT INTO niveles (id_tema, numero, nombre, descripcion) VALUES (@tema, 1, 'Vocabulario y gramática básica', 'Palabras comunes, verbo to be y pasado simple');
SET @nivel = LAST_INSERT_ID();
INSERT INTO flashcards (id_nivel, id_creador, pregunta, respuesta, incorrecta_1, incorrecta_2, incorrecta_3, pista, explicacion) VALUES
(@nivel, @admin, '¿Cómo se dice "gato" en inglés?', 'Cat', 'Dog', 'Rat', 'Cow', '', 'Cat es gato; dog es perro.'),
(@nivel, @admin, '¿Cuál es el plural de "child"?', 'Children', 'Childs', 'Childes', 'Childrens', 'Es un plural irregular.', 'Child es irregular: su plural es children.'),
(@nivel, @admin, 'Completa: "She ___ a student."', 'is', 'are', 'am', 'be', '', 'Con she, he e it se usa is.'),
(@nivel, @admin, '¿Qué significa "house"?', 'Casa', 'Caballo', 'Hora', 'Mano', '', 'House es casa; horse es caballo.'),
(@nivel, @admin, 'Completa: "They ___ playing football."', 'are', 'is', 'am', 'be', '', 'Con they, we y you se usa are.'),
(@nivel, @admin, '¿Cuál es el pasado simple de "go"?', 'Went', 'Goed', 'Gone', 'Goes', 'Es un verbo irregular.', 'Go es irregular: pasado went y participio gone.'),
(@nivel, @admin, '¿Cómo se dice "gracias" en inglés?', 'Thank you', 'Please', 'Sorry', 'Goodbye', '', 'Please es por favor, sorry es lo siento y goodbye es adiós.'),
(@nivel, @admin, 'Completa: "I ___ a book every week."', 'read', 'reads', 'reading', 'readed', 'Con I no se añade -s.', 'En presente simple, con I el verbo va en su forma base: I read.'),
(@nivel, @admin, '¿Qué significa "Where are you from?"', '¿De dónde eres?', '¿Cómo estás?', '¿Cuántos años tienes?', '¿Qué hora es?', 'Where significa dónde.', 'Se usa para preguntar el país o la ciudad de origen de alguien.'),
(@nivel, @admin, '¿Cuál es el opuesto de "big"?', 'Small', 'Tall', 'Fast', 'Cold', '', 'Big significa grande y su opuesto es small, pequeño.');
