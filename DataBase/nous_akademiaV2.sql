-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2026 a las 06:19:11
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nous_akademia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flashcards`
--

CREATE TABLE `flashcards` (
  `id_flashcard` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `id_creador` int(11) DEFAULT NULL,
  `pregunta` text NOT NULL,
  `respuesta` varchar(255) NOT NULL,
  `incorrecta_1` varchar(255) NOT NULL,
  `incorrecta_2` varchar(255) NOT NULL,
  `incorrecta_3` varchar(255) NOT NULL,
  `pista` text DEFAULT NULL,
  `explicacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `flashcards`
--

INSERT INTO `flashcards` (`id_flashcard`, `id_nivel`, `id_creador`, `pregunta`, `respuesta`, `incorrecta_1`, `incorrecta_2`, `incorrecta_3`, `pista`, `explicacion`) VALUES
(1, 2, 1, '¿Cuál es la unidad básica de los seres vivos?', 'La célula', 'El átomo', 'El tejido', 'El órgano', 'Es lo más pequeño que se considera vivo.', 'Todos los seres vivos están formados por una o más células.'),
(2, 2, 1, '¿Qué orgánulo produce la mayor parte de la energía de la célula?', 'La mitocondria', 'El ribosoma', 'El lisosoma', 'El aparato de Golgi', 'Se le llama la \"central energética\".', 'La mitocondria realiza la respiración celular y produce ATP.'),
(3, 2, 1, '¿Qué estructura delimita y protege a la célula?', 'La membrana plasmática', 'El núcleo', 'El citoplasma', 'La vacuola', '', 'La membrana controla qué sustancias entran y salen de la célula.'),
(4, 2, 1, '¿Dónde se encuentra el ADN en una célula eucariota?', 'En el núcleo', 'En el ribosoma', 'En la membrana', 'En la vacuola', 'Eucariota significa \"núcleo verdadero\".', 'El ADN de las células eucariotas está protegido dentro del núcleo.'),
(5, 2, 1, '¿Qué orgánulo realiza la fotosíntesis?', 'El cloroplasto', 'La mitocondria', 'El retículo endoplasmático', 'El lisosoma', 'Solo está en células vegetales.', 'El cloroplasto contiene clorofila y convierte la luz en energía química.'),
(6, 2, 1, '¿Qué estructura tienen las células vegetales y no las animales?', 'La pared celular', 'La membrana plasmática', 'El núcleo', 'El citoplasma', 'Da rigidez a las plantas.', 'La pared celular, hecha de celulosa, protege y da forma a la célula vegetal.'),
(7, 2, 1, '¿Cuál es la función de los ribosomas?', 'Fabricar proteínas', 'Producir energía', 'Digerir sustancias', 'Almacenar agua', '', 'Los ribosomas leen el ARN mensajero y ensamblan proteínas.'),
(8, 2, 1, '¿Qué tipo de célula no tiene un núcleo definido?', 'La célula procariota', 'La célula eucariota', 'La célula vegetal', 'La célula animal', 'Las bacterias son un ejemplo.', 'En las células procariotas el ADN está libre en el citoplasma.'),
(9, 2, 1, '¿Cómo se llaman los organismos formados por una sola célula?', 'Unicelulares', 'Pluricelulares', 'Mamíferos', 'Árboles', '', 'Las bacterias y las amebas son organismos unicelulares.'),
(10, 2, 1, '¿Cómo se llama el material gelatinoso que llena el interior de la célula?', 'Citoplasma', 'Savia', 'Cromatina', 'Membrana', 'En él flotan los orgánulos.', 'El citoplasma es el medio donde ocurren muchas reacciones de la célula.'),
(11, 3, 1, '¿Cuál es la unidad básica de los seres vivos?', 'La célula', 'El átomo', 'El tejido', 'El órgano', 'Es lo más pequeño que se considera vivo.', 'Todos los seres vivos están formados por una o más células.'),
(12, 3, 1, '¿Qué orgánulo produce la mayor parte de la energía de la célula?', 'La mitocondria', 'El ribosoma', 'El lisosoma', 'El aparato de Golgi', 'Se le llama la \"central energética\".', 'La mitocondria realiza la respiración celular y produce ATP.'),
(13, 3, 1, '¿Qué estructura delimita y protege a la célula?', 'La membrana plasmática', 'El núcleo', 'El citoplasma', 'La vacuola', '', 'La membrana controla qué sustancias entran y salen de la célula.'),
(14, 3, 1, '¿Dónde se encuentra el ADN en una célula eucariota?', 'En el núcleo', 'En el ribosoma', 'En la membrana', 'En la vacuola', 'Eucariota significa \"núcleo verdadero\".', 'El ADN de las células eucariotas está protegido dentro del núcleo.'),
(15, 3, 1, '¿Qué orgánulo realiza la fotosíntesis?', 'El cloroplasto', 'La mitocondria', 'El retículo endoplasmático', 'El lisosoma', 'Solo está en células vegetales.', 'El cloroplasto contiene clorofila y convierte la luz en energía química.'),
(16, 3, 1, '¿Qué estructura tienen las células vegetales y no las animales?', 'La pared celular', 'La membrana plasmática', 'El núcleo', 'El citoplasma', 'Da rigidez a las plantas.', 'La pared celular, hecha de celulosa, protege y da forma a la célula vegetal.'),
(17, 3, 1, '¿Cuál es la función de los ribosomas?', 'Fabricar proteínas', 'Producir energía', 'Digerir sustancias', 'Almacenar agua', '', 'Los ribosomas leen el ARN mensajero y ensamblan proteínas.'),
(18, 3, 1, '¿Qué tipo de célula no tiene un núcleo definido?', 'La célula procariota', 'La célula eucariota', 'La célula vegetal', 'La célula animal', 'Las bacterias son un ejemplo.', 'En las células procariotas el ADN está libre en el citoplasma.'),
(19, 3, 1, '¿Cómo se llaman los organismos formados por una sola célula?', 'Unicelulares', 'Pluricelulares', 'Mamíferos', 'Árboles', '', 'Las bacterias y las amebas son organismos unicelulares.'),
(20, 3, 1, '¿Cómo se llama el material gelatinoso que llena el interior de la célula?', 'Citoplasma', 'Savia', 'Cromatina', 'Membrana', 'En él flotan los orgánulos.', 'El citoplasma es el medio donde ocurren muchas reacciones de la célula.'),
(21, 4, 1, '¿Qué molécula contiene la información genética?', 'El ADN', 'El almidón', 'El ATP', 'La hemoglobina', '', 'El ADN guarda las instrucciones para construir y hacer funcionar al organismo.'),
(22, 4, 1, '¿Cómo se llama cada unidad de información hereditaria?', 'Gen', 'Enzima', 'Ribosoma', 'Lípido', 'Es un fragmento de ADN que codifica un rasgo.', 'Un gen es un segmento de ADN con la información de una característica.'),
(23, 4, 1, '¿Cuántos cromosomas tiene una célula humana normal?', '46', '32', '64', '92', 'Son 23 pares.', 'Las células humanas tienen 23 pares de cromosomas, es decir, 46.'),
(24, 4, 1, '¿Cómo se llaman las distintas versiones de un mismo gen?', 'Alelos', 'Fenotipos', 'Cariotipos', 'Plásmidos', '', 'Por ejemplo, los alelos del gen del color de ojos.'),
(25, 4, 1, '¿Qué es el genotipo?', 'El conjunto de genes de un individuo', 'El aspecto visible del individuo', 'El número de cromosomas', 'El ambiente donde vive', '', 'El fenotipo es lo que se ve; el genotipo son los genes que lo determinan.'),
(26, 4, 1, '¿Quién es considerado el padre de la genética por sus experimentos con guisantes?', 'Gregor Mendel', 'Charles Darwin', 'Louis Pasteur', 'Alexander Fleming', 'Fue un monje del siglo XIX.', 'Mendel descubrió las leyes de la herencia cruzando plantas de guisante.'),
(27, 4, 1, 'Un alelo dominante se caracteriza porque:', 'Se expresa aunque solo haya una copia', 'Solo se expresa si hay dos copias', 'Nunca se expresa', 'Solo está en los hombres', '', 'Si hay un alelo dominante, este determina el rasgo aunque el otro alelo sea recesivo.'),
(28, 4, 1, '¿Cómo se llama la célula que resulta de la unión de un óvulo y un espermatozoide?', 'Cigoto', 'Gameto', 'Cromosoma', 'Plásmido', '', 'El cigoto es la primera célula de un nuevo individuo.'),
(29, 4, 1, '¿Cuántos cromosomas tiene un óvulo o un espermatozoide humano?', '23', '46', '92', '12', 'Es la mitad de los de una célula normal.', 'Los gametos son haploides: tienen 23 cromosomas, la mitad que el resto de las células.'),
(30, 4, 1, '¿Qué cromosomas sexuales tiene un hombre?', 'XY', 'XX', 'YY', 'XO', '', 'Las mujeres tienen XX y los hombres XY.'),
(31, 5, 1, '¿Cómo se llama el conjunto formado por los seres vivos y su entorno físico?', 'Ecosistema', 'Población', 'Especie', 'Organismo', '', 'Un ecosistema incluye a los seres vivos y los factores del medio, como el agua, el suelo y el clima.'),
(32, 5, 1, '¿Cómo se llaman los organismos que fabrican su propio alimento?', 'Productores', 'Consumidores', 'Descomponedores', 'Parásitos', 'Las plantas son un ejemplo.', 'Los productores, como las plantas, elaboran su alimento mediante la fotosíntesis.'),
(33, 5, 1, 'En una cadena alimentaria, ¿qué hacen los descomponedores?', 'Transforman la materia muerta en nutrientes', 'Fabrican su alimento con luz', 'Cazan a otros animales', 'Producen oxígeno', 'Hongos y bacterias.', 'Los descomponedores devuelven los nutrientes al suelo para que los usen los productores.'),
(34, 5, 1, 'Un animal que se alimenta únicamente de plantas es:', 'Herbívoro', 'Carnívoro', 'Omnívoro', 'Descomponedor', '', 'Los herbívoros, como la vaca o el conejo, comen solo vegetales.'),
(35, 5, 1, '¿Quién propuso la teoría de la evolución por selección natural?', 'Charles Darwin', 'Gregor Mendel', 'Isaac Newton', 'Louis Pasteur', 'Viajó en el barco Beagle.', 'Darwin propuso que sobreviven y se reproducen más los individuos mejor adaptados.'),
(36, 5, 1, '¿Qué es una especie?', 'Un grupo de organismos que se reproducen entre sí y tienen descendencia fértil', 'Cualquier grupo de animales que viven juntos', 'Todos los seres vivos de un ecosistema', 'Un conjunto de plantas del mismo lugar', '', 'El criterio de la descendencia fértil distingue a una especie de otra.'),
(37, 5, 1, '¿Qué gas absorben las plantas durante la fotosíntesis?', 'Dióxido de carbono', 'Oxígeno', 'Nitrógeno', 'Hidrógeno', '', 'Las plantas toman dióxido de carbono y liberan oxígeno.'),
(38, 5, 1, '¿Cómo se llama la relación en la que las dos especies se benefician?', 'Mutualismo', 'Parasitismo', 'Depredación', 'Competencia', 'Un ejemplo son las abejas y las flores.', 'En el mutualismo ambas especies obtienen una ventaja.'),
(39, 5, 1, '¿Cuál es la fuente de energía de casi todos los ecosistemas?', 'El Sol', 'El suelo', 'El agua', 'El viento', '', 'La energía solar entra a los ecosistemas por medio de la fotosíntesis.'),
(40, 5, 1, '¿Qué significa que una especie esté \"en peligro de extinción\"?', 'Su población es tan pequeña que podría desaparecer', 'Ya desapareció por completo', 'Vive solo en zoológicos', 'Se reproduce demasiado rápido', '', 'Una especie en peligro tiene pocos individuos y necesita protección para sobrevivir.'),
(41, 6, 1, '¿Cuánto es 12 × 8?', '96', '86', '108', '88', '', '12 × 8 = 96.'),
(42, 6, 1, '¿Cuánto es 144 ÷ 12?', '12', '14', '11', '16', '', '12 × 12 = 144, por eso 144 ÷ 12 = 12.'),
(43, 6, 1, '¿Cuál es el resultado de 3 + 4 × 2?', '11', '14', '10', '24', 'Primero se multiplica.', 'Se resuelve primero la multiplicación: 4 × 2 = 8, y luego 3 + 8 = 11.'),
(44, 6, 1, '¿Cuánto es 1/2 + 1/4?', '3/4', '2/6', '1/6', '1/8', 'Convierte 1/2 en cuartos.', '1/2 = 2/4, y 2/4 + 1/4 = 3/4.'),
(45, 6, 1, '¿Qué fracción es equivalente a 2/4?', '1/2', '1/4', '2/3', '3/4', 'Divide numerador y denominador entre 2.', '2/4 se simplifica dividiendo entre 2 y queda 1/2.'),
(46, 6, 1, '¿Cuánto es el 10 % de 250?', '25', '10', '50', '2,5', '10 % es lo mismo que dividir entre 10.', 'El 10 % de 250 es 250 ÷ 10 = 25.'),
(47, 6, 1, '¿Cuál de estos números es primo?', '17', '15', '21', '27', 'Solo es divisible entre 1 y entre sí mismo.', '17 solo se puede dividir exactamente entre 1 y 17. Los otros tienen más divisores.'),
(48, 6, 1, '¿Cuánto es (−5) + 8?', '3', '−3', '13', '−13', '', 'Al sumar 8 a −5 avanzas 8 unidades desde −5 y llegas a 3.'),
(49, 6, 1, '¿Cuánto es 7²?', '49', '14', '42', '77', 'Es 7 × 7.', '7² = 7 × 7 = 49.'),
(50, 6, 1, '¿Cuál es el resultado de 0,5 × 6?', '3', '30', '0,3', '12', '0,5 es la mitad.', 'Multiplicar por 0,5 es lo mismo que tomar la mitad: la mitad de 6 es 3.'),
(51, 7, 1, 'Si x + 7 = 15, ¿cuánto vale x?', '8', '22', '7', '9', 'Resta 7 en ambos lados.', 'x = 15 − 7 = 8.'),
(52, 7, 1, 'Si 3x = 21, ¿cuánto vale x?', '7', '18', '24', '63', 'Divide entre 3 en ambos lados.', 'x = 21 ÷ 3 = 7.'),
(53, 7, 1, 'Simplifica: 2x + 3x', '5x', '6x', '5x²', '2x³', 'Los términos son semejantes.', 'Al sumar términos semejantes se suman los coeficientes: 2 + 3 = 5, queda 5x.'),
(54, 7, 1, '¿Cuál es el valor de 2x + 1 cuando x = 4?', '9', '8', '10', '12', 'Sustituye x por 4.', '2 × 4 + 1 = 8 + 1 = 9.'),
(55, 7, 1, 'Resuelve: 2x − 4 = 10', 'x = 7', 'x = 3', 'x = 5', 'x = 14', 'Primero suma 4 en ambos lados.', '2x = 14, y por tanto x = 7.'),
(56, 7, 1, '¿Cuál es el resultado de (x + 2)(x + 3)?', 'x² + 5x + 6', 'x² + 6', 'x² + 5x + 5', '2x + 5', 'Multiplica cada término por cada término.', 'x·x + x·3 + 2·x + 2·3 = x² + 5x + 6.'),
(57, 7, 1, '¿Cuál de estas es una ecuación lineal?', '2x + 5 = 11', 'x² − 4 = 0', 'x³ = 8', '1/x = 2', 'En una ecuación lineal, x tiene exponente 1.', 'Solo 2x + 5 = 11 tiene la incógnita elevada a 1.'),
(58, 7, 1, 'Si y = 2x + 1, ¿cuánto vale y cuando x = 3?', '7', '6', '5', '9', '', 'y = 2 × 3 + 1 = 7.'),
(59, 7, 1, 'Resuelve: x/4 = 5', 'x = 20', 'x = 9', 'x = 1,25', 'x = 24', 'Multiplica ambos lados por 4.', 'x = 5 × 4 = 20.'),
(60, 7, 1, '¿Cuál es la pendiente de la recta y = 3x − 2?', '3', '−2', '2', '1/3', 'Es el número que multiplica a x.', 'En y = mx + b, la pendiente es m; aquí m = 3.'),
(61, 8, 1, '¿Cuántos grados suman los ángulos interiores de un triángulo?', '180°', '90°', '360°', '270°', '', 'Los tres ángulos de cualquier triángulo suman siempre 180°.'),
(62, 8, 1, '¿Cuál es el área de un rectángulo de 5 cm de base y 3 cm de altura?', '15 cm²', '8 cm²', '16 cm²', '15 cm', 'Área = base × altura.', '5 × 3 = 15, y el área se expresa en unidades cuadradas: 15 cm².'),
(63, 8, 1, '¿Cuál es el perímetro de un cuadrado de lado 4 cm?', '16 cm', '8 cm', '12 cm', '20 cm', 'Suma sus cuatro lados.', '4 + 4 + 4 + 4 = 16 cm.'),
(64, 8, 1, '¿Cómo se llama un ángulo de exactamente 90°?', 'Recto', 'Agudo', 'Obtuso', 'Llano', '', 'Los ángulos agudos miden menos de 90° y los obtusos más de 90°.'),
(65, 8, 1, 'En un triángulo rectángulo con catetos de 3 y 4, ¿cuánto mide la hipotenusa?', '5', '7', '6', '12', 'Usa el teorema de Pitágoras.', '3² + 4² = 9 + 16 = 25, y la raíz cuadrada de 25 es 5.'),
(66, 8, 1, '¿Cuál es el área de un triángulo de base 6 y altura 4?', '12', '24', '10', '20', 'Es la mitad de base × altura.', '(6 × 4) ÷ 2 = 12.'),
(67, 8, 1, '¿Cuál es la fórmula del área de un círculo?', 'π × r²', '2 × π × r', 'π × r', '2 × r²', '', '2 × π × r es la longitud de la circunferencia; el área es π × r².'),
(68, 8, 1, '¿Cuántos lados tiene un hexágono?', '6', '5', '8', '7', '', 'Hexa significa seis.'),
(69, 8, 1, 'Si el radio de una circunferencia mide 5 cm, ¿cuánto mide su diámetro?', '10 cm', '2,5 cm', '15 cm', '25 cm', 'El diámetro es el doble del radio.', 'Diámetro = 2 × radio = 10 cm.'),
(70, 8, 1, '¿Cuánto suman dos ángulos complementarios?', '90°', '180°', '360°', '45°', '', 'Los suplementarios suman 180° y los complementarios 90°.'),
(71, 9, 1, '¿Cómo se dice \"gato\" en inglés?', 'Cat', 'Dog', 'Rat', 'Cow', '', 'Cat es gato; dog es perro.'),
(72, 9, 1, '¿Cuál es el plural de \"child\"?', 'Children', 'Childs', 'Childes', 'Childrens', 'Es un plural irregular.', 'Child es irregular: su plural es children.'),
(73, 9, 1, 'Completa: \"She ___ a student.\"', 'is', 'are', 'am', 'be', '', 'Con she, he e it se usa is.'),
(74, 9, 1, '¿Qué significa \"house\"?', 'Casa', 'Caballo', 'Hora', 'Mano', '', 'House es casa; horse es caballo.'),
(75, 9, 1, 'Completa: \"They ___ playing football.\"', 'are', 'is', 'am', 'be', '', 'Con they, we y you se usa are.'),
(76, 9, 1, '¿Cuál es el pasado simple de \"go\"?', 'Went', 'Goed', 'Gone', 'Goes', 'Es un verbo irregular.', 'Go es irregular: pasado went y participio gone.'),
(77, 9, 1, '¿Cómo se dice \"gracias\" en inglés?', 'Thank you', 'Please', 'Sorry', 'Goodbye', '', 'Please es por favor, sorry es lo siento y goodbye es adiós.'),
(78, 9, 1, 'Completa: \"I ___ a book every week.\"', 'read', 'reads', 'reading', 'readed', 'Con I no se añade -s.', 'En presente simple, con I el verbo va en su forma base: I read.'),
(79, 9, 1, '¿Qué significa \"Where are you from?\"', '¿De dónde eres?', '¿Cómo estás?', '¿Cuántos años tienes?', '¿Qué hora es?', 'Where significa dónde.', 'Se usa para preguntar el país o la ciudad de origen de alguien.'),
(80, 9, 1, '¿Cuál es el opuesto de \"big\"?', 'Small', 'Tall', 'Fast', 'Cold', '', 'Big significa grande y su opuesto es small, pequeño.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intentos`
--

CREATE TABLE `intentos` (
  `id_intento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `aciertos` smallint(5) UNSIGNED NOT NULL,
  `total` smallint(5) UNSIGNED NOT NULL,
  `porcentaje` decimal(5,2) NOT NULL,
  `aprobado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `intentos`
--

INSERT INTO `intentos` (`id_intento`, `id_usuario`, `id_nivel`, `aciertos`, `total`, `porcentaje`, `aprobado`, `fecha`) VALUES
(1, 1, 3, 10, 10, 100.00, 1, '2026-10-15 20:08:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `id_nivel` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL,
  `numero` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`id_nivel`, `id_tema`, `numero`, `nombre`, `descripcion`) VALUES
(3, 3, 1, 'La célula', 'Estructura y orgánulos de la célula'),
(4, 3, 2, 'Genética básica', 'ADN, genes y herencia'),
(5, 3, 3, 'Ecosistemas y evolución', 'Cadenas alimentarias, relaciones entre especies y evolución'),
(6, 4, 1, 'Operaciones y fracciones', 'Aritmética básica, fracciones y porcentajes'),
(7, 4, 2, 'Álgebra básica', 'Ecuaciones y expresiones algebraicas sencillas'),
(8, 4, 3, 'Geometría', 'Ángulos, perímetros, áreas y figuras'),
(9, 5, 1, 'Vocabulario y gramática básica', 'Palabras comunes, verbo to be y pasado simple');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id_tema` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL DEFAULT '',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`id_tema`, `nombre`, `descripcion`, `fecha_creacion`) VALUES
(3, 'Biología', 'Biología básica: la célula, la genética y los ecosistemas.', '2026-10-15 18:57:20'),
(4, 'Matemáticas', 'Aritmética, álgebra y geometría básicas.', '2026-10-15 18:57:20'),
(5, 'Inglés', 'Vocabulario y gramática básica del inglés.', '2026-10-15 18:57:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('estudiante','admin') NOT NULL DEFAULT 'estudiante',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Samuel Emilio Vásquez Álvarez', 'sevasquezlol@gmail.com', '$2y$10$SMDn1J.Fc64XN8dJTx9/i.1z6tJB/lcXDHHVWeEzwPfmQHW/IouRG', 'admin', '2026-08-30 17:39:56'),
(2, 'aedwdwwd', 'pepito@gmail.com', '$2y$10$cM17PM1ytpDQgpYMVUq1uuEWu8/uiZYL65Bw050mKqcVzJgYlWXfG', 'estudiante', '2026-09-09 18:32:04'),
(3, 'Samuel Emilio Vásquez Álvarez', 'lmaolmao@gmail.com', '$2y$10$K1Hhz8wteY8H.etqfwUTu.lDy7ZoFYxPUFk4mc0X3he.D1GZ0Qf26', 'estudiante', '2026-10-15 04:40:42');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `flashcards`
--
ALTER TABLE `flashcards`
  ADD PRIMARY KEY (`id_flashcard`),
  ADD KEY `flashcards_ibfk_2` (`id_creador`);

--
-- Indices de la tabla `intentos`
--
ALTER TABLE `intentos`
  ADD PRIMARY KEY (`id_intento`),
  ADD KEY `usuario_nivel` (`id_usuario`,`id_nivel`),
  ADD KEY `id_nivel` (`id_nivel`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id_nivel`),
  ADD UNIQUE KEY `tema_numero` (`id_tema`,`numero`);

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id_tema`),
  ADD UNIQUE KEY `nombre_unico` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `flashcards`
--
ALTER TABLE `flashcards`
  MODIFY `id_flashcard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `intentos`
--
ALTER TABLE `intentos`
  MODIFY `id_intento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id_nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `flashcards`
--
ALTER TABLE `flashcards`
  ADD CONSTRAINT `flashcards_ibfk_2` FOREIGN KEY (`id_creador`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `intentos`
--
ALTER TABLE `intentos`
  ADD CONSTRAINT `intentos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `intentos_ibfk_2` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD CONSTRAINT `niveles_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
