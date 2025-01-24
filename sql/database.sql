
--
-- Base de datos: `streaming`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actor`
--

CREATE TABLE `actor` (
  `id` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `actor`
--

INSERT INTO `actor` (`id`, `nombre`) VALUES
(1, 'Betsy Jefford'),
(2, 'Shandee Winspare'),
(3, 'Phil Lohan'),
(4, 'Thedric Ashtonhurst'),
(5, 'Marchelle Jagielski'),
(6, 'Roderic Parrington'),
(7, 'Broddie Tunnock'),
(8, 'Durand Alner'),
(9, 'Vivianne Pruckner'),
(10, 'Charmine McIlwraith'),
(11, 'Ewell Ebunoluwa'),
(12, 'Ignazio Caffin'),
(13, 'Michel Scutter'),
(14, 'Orazio Johananoff'),
(15, 'Augy Clatworthy'),
(16, 'Ellissa Wolfindale'),
(17, 'Emmeline Nuttall'),
(18, 'Andriana Jenney'),
(19, 'Morgan Rohlfing'),
(20, 'Reg Buglar'),
(21, 'Mikel Unstead'),
(22, 'Arron Cossentine'),
(23, 'Belle Sharrocks'),
(24, 'Godfree Sexti'),
(25, 'Julie Scriven'),
(26, 'Tanya MacColgan'),
(27, 'Annie Joreau'),
(28, 'Ozzy Bisseker'),
(29, 'Westleigh Macauley'),
(30, 'Thedric Elleton'),
(31, 'Harcourt Klaffs'),
(32, 'Jabez Spering'),
(33, 'Quentin Coldbath'),
(34, 'Lynna McCusker'),
(35, 'Babita Kesby'),
(36, 'Alida Siddell'),
(37, 'Esteban Bucklee'),
(38, 'Teresa Balcock'),
(39, 'Adams Cockshott'),
(40, 'Shandy Langstone'),
(41, 'Bernice Blest'),
(42, 'Abbey Gosson'),
(43, 'Judi Kettridge'),
(44, 'Dotti Hambric'),
(45, 'Donni Crebott'),
(46, 'Lindsy Wison'),
(47, 'Berrie Charlesworth'),
(48, 'Peggie Covendon'),
(49, 'Whitaker Laying'),
(50, 'Arin O\' Loughran'),
(51, 'Philippine Van der Velde'),
(52, 'Garik Deshorts'),
(53, 'Anya Ching'),
(54, 'Virge Bangley'),
(55, 'Carma Sempill'),
(56, 'Kennedy Nurdin'),
(57, 'Jonah Tinline'),
(58, 'Duke Basini-Gazzi'),
(59, 'Starlene Roseburgh'),
(60, 'Matilda Garley'),
(61, 'Saraann Gilkison'),
(62, 'Cymbre Brewins'),
(63, 'Ellis Scurrell'),
(64, 'Rocky Aberchirder'),
(65, 'Ezekiel Fairfoull'),
(66, 'Lazar Ragdale'),
(67, 'Kizzee Wildor'),
(68, 'Willamina Gerrelt'),
(69, 'Antonietta Wither'),
(70, 'Jeddy Scourgie'),
(71, 'Mayer Slatten'),
(72, 'Alwyn Barby'),
(73, 'Jethro Fenck'),
(74, 'Kerwin Parminter'),
(75, 'Neely Springett'),
(76, 'Salome Wurz'),
(77, 'Fernanda Gennerich'),
(78, 'Blancha Petruk'),
(79, 'Deloria Turfs'),
(80, 'Abram Banfill'),
(81, 'Bethena Cicchetto'),
(82, 'Orville Deporte'),
(83, 'Elfrieda Ketts'),
(84, 'Clive McDavid'),
(85, 'Alexandro O\'Hagirtie'),
(86, 'Fairleigh Faveryear'),
(87, 'Carmita Cramp'),
(88, 'Noel Laguerre'),
(89, 'Bradley Joslin'),
(90, 'Zaccaria Geertje'),
(91, 'Aviva Jovasevic'),
(92, 'Layne Gyngyll'),
(93, 'Venus Dunlop'),
(94, 'Riannon Ellam'),
(95, 'Berty Doohan'),
(96, 'Vite Dana'),
(97, 'Mellisent Furmage'),
(98, 'Abdel Maken'),
(99, 'Ruthanne Hamsson'),
(100, 'Dierdre Jacox');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_video`
--

CREATE TABLE `tipo_video` (
  `id` int NOT NULL,
  `tipo` varchar(10) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tipo_video`
--

INSERT INTO `tipo_video` (`id`, `tipo`) VALUES
(1, 'Película'),
(2, 'Serie'),
(3, 'Documental');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `id` int NOT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `video`
--

CREATE TABLE `video` (
  `id` int NOT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `minuto_duracion` int DEFAULT NULL,
  `fecha_estreno` date DEFAULT NULL,
  `tipo_video` int DEFAULT NULL
);

--
-- Volcado de datos para la tabla `video`
--

INSERT INTO `video` (`id`, `titulo`, `minuto_duracion`, `fecha_estreno`, `tipo_video`) VALUES
(1, 'Notorious', 154, '2021-07-06', 3),
(2, 'Open Road, The', 123, '2022-05-30', 2),
(3, 'Station, The (Blutgletscher)', 244, '2023-10-16', 2),
(4, 'I Declare War', 325, '2020-12-30', 3),
(5, 'I Dream Too Much', 95, '2022-03-14', 2),
(6, 'The Sex and Violence Family Hour', 465, '2024-10-13', 3),
(7, 'American Dreamz', 320, '2024-02-01', 1),
(8, 'The Nativity', 208, '2021-09-19', 3),
(9, 'Three Seasons', 255, '2023-10-08', 1),
(10, 'About Time', 176, '2023-06-03', 3),
(11, 'Kamikaze', 275, '2023-10-12', 2),
(12, 'Casper', 419, '2024-07-04', 1),
(13, 'Beast of Yucca Flats, The', 436, '2023-10-05', 1),
(14, 'Zero Years, The', 458, '2023-01-15', 1),
(15, 'Story Written with Water, A (Mizu de kakareta)', 166, '2021-03-03', 3),
(16, 'Seems Like Old Times', 62, '2020-10-22', 2),
(17, 'Bonneville', 398, '2021-09-25', 3),
(18, 'Female Agents (Les femmes de l\'ombre)', 291, '2021-09-27', 3),
(19, 'Death Note 2: The Last Name', 94, '2023-10-17', 1),
(20, 'Once Upon a Time in America', 274, '2025-08-27', 2),
(21, 'Paper Birds (Pájaros de papel)', 81, '2024-07-23', 1),
(22, 'Shameless (Maskeblomstfamilien )', 98, '2022-01-26', 3),
(23, 'Let\'s Be Cops', 473, '2023-11-24', 3),
(24, 'Hannibal', 384, '2024-07-05', 2),
(25, 'Superman III', 181, '2021-10-31', 2),
(26, 'Russia 88', 344, '2021-12-27', 2),
(27, 'Let Him Have It', 144, '2025-06-06', 3),
(28, 'Hercules and the Circle of Fire', 323, '2025-06-19', 3),
(29, 'Step Up 3D', 270, '2025-01-14', 1),
(30, 'Arrival, The', 289, '2021-11-23', 1),
(31, 'Blackout', 177, '2024-11-20', 2),
(32, 'The Third Reich: The Rise & Fall', 257, '2021-09-28', 2),
(33, 'The Hire: Hostage', 248, '2021-05-30', 2),
(34, 'Secret Ballot (Raye makhfi)', 141, '2021-07-01', 1),
(35, 'Trip to Mars, A', 183, '2024-09-21', 3),
(36, 'Cocaine Cowboys II: Hustlin\' With the Godmother', 287, '2023-06-26', 3),
(37, 'Lovers, The (Les Amants)', 452, '2022-05-02', 3),
(38, 'Big Girls Don\'t Cry (Große Mädchen weinen nicht)', 401, '2021-08-09', 3),
(39, 'Fandango', 57, '2023-05-11', 1),
(40, 'Passion of Darkly Noon, The', 376, '2025-06-01', 2),
(41, 'His New Profession', 75, '2023-12-30', 1),
(42, 'My Mother Likes Women ', 389, '2023-07-10', 3),
(43, 'Mister Magoo\'s Christmas Carol', 494, '2021-11-04', 1),
(44, 'Misery', 189, '2021-10-21', 1),
(45, 'Aloha Summer', 416, '2024-04-22', 1),
(46, '51', 317, '2021-07-22', 3),
(47, 'The Divine Woman', 255, '2023-05-13', 1),
(48, 'Second Civil War, The', 464, '2021-11-26', 3),
(49, 'Ben', 87, '2023-10-10', 2),
(50, 'Body of Water (Syvälle salattu)', 153, '2023-10-07', 3),
(51, 'September', 332, '2024-10-07', 2),
(52, 'Uncle Sam', 105, '2024-08-05', 1),
(53, 'That\'s Entertainment', 433, '2024-01-21', 2),
(54, 'Prince of Tides, The', 297, '2024-07-06', 1),
(55, 'Battle of the Rails, The (La bataille du rail)', 150, '2024-05-03', 3),
(56, 'Murder in Coweta County', 241, '2022-05-07', 3),
(57, 'I Spy', 210, '2023-09-16', 1),
(58, 'Samurai Fiction (SF: Episode One)', 13, '2022-01-10', 2),
(59, 'North and South, Book I', 109, '2024-06-10', 3),
(60, 'Thief and the Cobbler, The (a.k.a. Arabian Knight)', 497, '2021-07-18', 1),
(61, 'Paris', 470, '2022-02-08', 1),
(62, 'Way You Wanted Me, The', 25, '2023-12-12', 3),
(63, 'Girlfight', 256, '2024-04-24', 2),
(64, 'Josephine', 413, '2022-10-18', 2),
(65, 'Cthulhu', 273, '2024-01-10', 2),
(66, 'Rules of Engagement', 56, '2023-12-29', 1),
(67, 'Young Aphrodites (Mikres Afrodites)', 212, '2024-11-20', 2),
(68, 'Command Performance', 273, '2023-10-20', 3),
(69, 'Ong-Bak 2: The Beginning (Ong Bak 2)', 122, '2024-08-11', 3),
(70, 'Hatchet for the Honeymoon', 296, '2021-07-25', 3),
(71, 'Cape Fear', 67, '2024-10-11', 3),
(72, 'Count Three and Pray', 106, '2022-09-19', 2),
(73, 'Philomena', 229, '2023-11-20', 3),
(74, 'Barrens, The', 159, '2022-11-20', 2),
(75, 'Burn! (Queimada)', 373, '2025-05-23', 1),
(76, 'Double Take', 463, '2023-09-12', 3),
(77, 'Rise of the Guardians', 430, '2022-07-17', 1),
(78, 'Under the Flag of the Rising Sun', 205, '2022-05-12', 2),
(79, 'Gracie', 359, '2025-02-06', 2),
(80, 'You Are So Beautiful (Je vous trouve très beau)', 156, '2022-07-23', 2),
(81, 'Sand Sharks', 140, '2021-12-06', 3),
(82, 'Two Friends', 145, '2025-04-29', 3),
(83, 'Wooden Man\'s Bride, The (Yan shen)', 451, '2025-01-09', 2),
(84, 'Murderous Maids (Blessures assassines, Les)', 373, '2022-05-18', 2),
(85, 'Hungry for Change', 446, '2024-08-20', 2),
(86, '41', 323, '2022-07-31', 2),
(87, 'Silent House', 129, '2020-12-17', 3),
(88, 'Deception', 339, '2023-02-16', 3),
(89, 'Gloomy Sunday (Ein Lied von Liebe und Tod)', 448, '2020-11-22', 3),
(90, 'Vice', 323, '2022-09-08', 2),
(91, 'Bloody New Year', 342, '2022-02-20', 2),
(92, 'Back in Business', 420, '2024-03-11', 2),
(93, 'Adventures of Ichabod and Mr. Toad, The', 409, '2024-07-31', 2),
(94, 'Riot Club, The', 444, '2025-02-01', 2),
(95, 'Reluctant Fundamentalist, The', 393, '2021-01-10', 3),
(96, 'AmericanEast', 15, '2023-05-19', 1),
(97, 'Star Maker, The (Uomo delle stelle, L\')', 410, '2022-07-21', 3),
(98, 'Christmas on Mars', 284, '2024-10-13', 1),
(99, 'Fists in the Pocket (Pugni in tasca, I)', 36, '2025-05-28', 1),
(100, 'Way South, The (De weg naar het zuiden)', 439, '2022-06-07', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `video_actor`
--

CREATE TABLE `video_actor` (
  `id` int NOT NULL,
  `actor` int DEFAULT NULL,
  `video` int DEFAULT NULL
);

--
-- Volcado de datos para la tabla `video_actor`
--

INSERT INTO `video_actor` (`id`, `actor`, `video`) VALUES
(1, 30, 2),
(2, 39, 5),
(3, 86, 61),
(4, 50, 75),
(5, 19, 92),
(6, 70, 58),
(7, 51, 36),
(8, 90, 56),
(9, 21, 50),
(10, 69, 47),
(11, 37, 34),
(12, 88, 36),
(13, 95, 48),
(14, 15, 14),
(15, 65, 85),
(16, 25, 31),
(17, 25, 7),
(18, 83, 22),
(19, 31, 68),
(20, 65, 96),
(21, 24, 38),
(22, 94, 60),
(23, 86, 17),
(24, 22, 57),
(25, 23, 32),
(26, 27, 6),
(27, 17, 20),
(28, 52, 48),
(29, 2, 72),
(30, 61, 83),
(31, 42, 92),
(32, 82, 80),
(33, 84, 72),
(34, 5, 22),
(35, 3, 13),
(36, 63, 64),
(37, 82, 37),
(38, 10, 44),
(39, 25, 44),
(40, 27, 35),
(41, 75, 4),
(42, 9, 7),
(43, 86, 37),
(44, 16, 84),
(45, 57, 74),
(46, 93, 40),
(47, 10, 74),
(48, 21, 13),
(49, 92, 98),
(50, 65, 44),
(51, 57, 34),
(52, 11, 70),
(53, 97, 63),
(54, 20, 4),
(55, 18, 66),
(56, 19, 85),
(57, 70, 43),
(58, 56, 58),
(59, 73, 23),
(60, 50, 11),
(61, 32, 82),
(62, 73, 64),
(63, 69, 54),
(64, 88, 20),
(65, 70, 5),
(66, 1, 85),
(67, 10, 22),
(68, 7, 77),
(69, 42, 55),
(70, 78, 84),
(71, 9, 17),
(72, 94, 34),
(73, 81, 89),
(74, 100, 14),
(75, 49, 26),
(76, 27, 66),
(77, 27, 25),
(78, 76, 1),
(79, 45, 34),
(80, 30, 54),
(81, 46, 56),
(82, 77, 94),
(83, 35, 89),
(84, 6, 4),
(85, 54, 85),
(86, 34, 7),
(87, 93, 97),
(88, 12, 59),
(89, 79, 69),
(90, 14, 40),
(91, 26, 10),
(92, 40, 75),
(93, 38, 60),
(94, 43, 30),
(95, 75, 8),
(96, 32, 34),
(97, 31, 88),
(98, 43, 53),
(99, 25, 42),
(100, 90, 55);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actor`
--
ALTER TABLE `actor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_video`
--
ALTER TABLE `tipo_video`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_tipo_video` (`tipo_video`);

--
-- Indices de la tabla `video_actor`
--
ALTER TABLE `video_actor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actor` (`actor`),
  ADD KEY `video` (`video`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tipo_video`
--
ALTER TABLE `tipo_video`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `video`
--
ALTER TABLE `video`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
--
ALTER TABLE `actor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `video_actor`
--
ALTER TABLE `video_actor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_tipo_video` FOREIGN KEY (`tipo_video`) REFERENCES `tipo_video` (`id`);

--
-- Filtros para la tabla `video_actor`
--
ALTER TABLE `video_actor`
  ADD CONSTRAINT `video_actor_ibfk_1` FOREIGN KEY (`actor`) REFERENCES `actor` (`id`),
  ADD CONSTRAINT `video_actor_ibfk_2` FOREIGN KEY (`video`) REFERENCES `video` (`id`);
COMMIT;