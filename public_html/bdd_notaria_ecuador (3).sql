-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-04-2025 a las 15:40:15
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
-- Base de datos: `bdd_notaria_ecuador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `c_identificacion` varchar(50) NOT NULL,
  `c_nombre` varchar(50) NOT NULL,
  `c_apellido` varchar(50) NOT NULL,
  `c_telefono` varchar(50) NOT NULL,
  `c_edad` int(3) NOT NULL,
  `c_direccion` varchar(50) NOT NULL,
  `c_pais` varchar(50) NOT NULL,
  `c_estado` varchar(50) NOT NULL,
  `c_ciudad` varchar(50) NOT NULL,
  `c_codpostal` varchar(50) NOT NULL,
  `c_email` varchar(50) NOT NULL,
  `c_napartamento` varchar(50) NOT NULL,
  `c_abonado` double NOT NULL,
  `c_deuda` double NOT NULL,
  `c_saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `c_identificacion`, `c_nombre`, `c_apellido`, `c_telefono`, `c_edad`, `c_direccion`, `c_pais`, `c_estado`, `c_ciudad`, `c_codpostal`, `c_email`, `c_napartamento`, `c_abonado`, `c_deuda`, `c_saldo`) VALUES
(1, '0150308732', 'Juan', 'Carangui', '0983141176', 23, 'Miraflores', 'Ecuador', 'Azuay', 'Cuenca', '010206', 'juanfelicc@gmail.com', '0', 1100, 2850, 1750),
(2, '0105925929', 'patricio', 'peralta', '09754115', 23, 'heroes', 'Ecuador', 'Azuay', 'Cuenca', '010101', 'pato@mail', '14', 2498.5, 6000, 3501.5),
(3, '01051251', 'Patricio', 'Peralta', '0979272404', 23, 'Heroes de verdeloma y Estevez de Toral', 'Ecuador', 'Azuay', 'Cuenca, Azuay', '010101', 'patricio.peralta.est@tecazuay.edu.ec', 'd', 500, 0, 0),
(7, '0105925921', 'Domenica', 'Peralta', '09020421231', 29, 'Heroes de verdeloma y Estevez de Toral', 'Ecuador', 'Azuay', 'Cuenca, Azuay', '010101', 'patricio.peralta.est@tecazuay.edu.ec', 'd', 750, 2000, 1250);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramites_varios`
--

CREATE TABLE `tramites_varios` (
  `id_tramite_varios` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `tv_motivo` varchar(50) NOT NULL,
  `tv_oenvio` varchar(50) NOT NULL,
  `tv_nrecibo` int(50) NOT NULL,
  `tv_nom_envio` varchar(50) NOT NULL,
  `tv_ciudad` varchar(50) NOT NULL,
  `tv_provincia` varchar(50) NOT NULL,
  `tv_telefono` varchar(50) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tv_tip_documento` varchar(50) NOT NULL,
  `tv_traducciones` tinyint(1) NOT NULL,
  `tv_notarizacion` tinyint(1) NOT NULL,
  `tv_certificacion` tinyint(1) NOT NULL,
  `tv_apostilla` tinyint(1) NOT NULL,
  `tv_valor_tramite` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tramites_varios`
--

INSERT INTO `tramites_varios` (`id_tramite_varios`, `id_cliente`, `tv_motivo`, `tv_oenvio`, `tv_nrecibo`, `tv_nom_envio`, `tv_ciudad`, `tv_provincia`, `tv_telefono`, `id_usuario`, `tv_tip_documento`, `tv_traducciones`, `tv_notarizacion`, `tv_certificacion`, `tv_apostilla`, `tv_valor_tramite`) VALUES
(1, 1, 'drogas', 'A su domicilio en EE.UU.', 23131, 'Juan', 'Cuenca', 'Azuay', '1231323', 1, 'Nacimiento', 0, 0, 1, 1, 0),
(9, 2, 'drogas', 'Venirlo a retirar personalmente en la oficina.', 23131, 'Juan', 'Cuenca', 'Azuay', '1231323', 1, 'Divorcio', 1, 0, 1, 0, 0),
(11, 2, 'drogas', 'A su domicilio en EE.UU.', 23131, 'Juan', 'Cuenca', 'Azuay', '1231323', 1, 'Nacimiento', 1, 0, 1, 0, 0),
(12, 2, 'drogas', 'A su domicilio en EE.UU.', 23131, 'Juan', 'Cuenca', 'Azuay', '1231323', 1, 'Carta de invitacion', 1, 1, 0, 1, 0),
(13, 2, 'drogas', 'A su domicilio en EE.UU.', 23131, 'Juan', 'Cuenca', 'Azuay', '1231323', 1, 'Matrimonio', 1, 1, 0, 0, 0),
(14, 1, 'drogas', 'Ofrecemos envios express al Ecuador en 3 dias labo', 23131, 'Juan', 'Cuenca', 'Azuay', '1231323', 2, 'Defuncion', 1, 1, 0, 0, 0),
(15, 2, 'drogas', 'Ofrecemos envios express al Ecuador en 3 dias labo', 23131, 'Juan', 'Cuenca', 'Azuay', '1231323', 1, 'Otros', 1, 0, 0, 1, 0),
(16, 2, 'Cosas', 'Venirlo a retirar personalmente en la oficina.', 23131, 'Domenitca', 'Azogues', 'Cañar', '123213123', 1, 'Matrimonio', 0, 0, 0, 0, 0),
(17, 2, 'Cosas', 'A su domicilio en EE.UU.', 23131, 'Domenitca', 'Azogues', 'Cañar', '12312424214', 1, 'Defuncion', 1, 0, 0, 0, 0),
(18, 2, 'Cosas', 'A su domicilio en EE.UU.', 23131, 'Domenitca', 'Azogues', 'Cañar', '12312424214', 1, 'Nacimiento', 1, 1, 1, 1, 300),
(19, 2, 'Cosas', 'A su domicilio en EE.UU.', 23131, 'Domenitca', 'Azogues', 'Cañar', '12312424214', 1, 'Matrimonio', 1, 0, 0, 0, 300),
(20, 2, 'Cosas', 'A su domicilio en EE.UU.', 23131, 'Domenitca', 'Azogues', 'Cañar', '12312424214', 1, 'Nacimiento', 1, 1, 1, 1, 500),
(21, 2, 'Cosas', 'A su domicilio en EE.UU.', 23131, 'Domenitca', 'Azogues', 'Cañar', '12312424214', 1, 'Nacimiento', 1, 1, 0, 0, 1000),
(22, 2, 'Cosas', 'A su domicilio en EE.UU.', 23131, 'Domenitca', 'Azogues', 'Cañar', '12312424214', 1, 'Nacimiento', 1, 0, 0, 0, 1000),
(23, 1, 'Cosas', 'A su domicilio en EE.UU.', 23131, 'Domenitca', 'Azogues', 'Cañar', '12312424214', 1, 'Nacimiento', 1, 1, 1, 1, 1000),
(24, 2, 'Cosas', 'A su domicilio en EE.UU.', 23131, 'Domenitca', 'Azogues', 'Cañar', '12312424214', 1, 'Nacimiento', 1, 0, 0, 1, 1000),
(25, 2, 'Cosas', 'A su domicilio en EE.UU.', 23131, 'Domenitca', 'Azogues', 'Cañar', '12312424214', 1, 'Matrimonio', 1, 1, 1, 1, 2000),
(26, 2, 'Cosas', 'A su domicilio en EE.UU.', 23131, 'Domenitca', 'Azogues', 'Cañar', '12312424214', 1, 'Matrimonio', 1, 0, 1, 0, 2000),
(27, 7, 'Poderes', 'A su domicilio en EE.UU.', 23131, 'Domenitca', 'Azogues', 'Cañar', '12312424214', 1, 'Nacimiento', 1, 1, 0, 0, 2000),
(28, 1, 'Poderes', 'A su domicilio en EE.UU.', 23131, 'Patricio', 'Azogues', 'Cañar', '12312424214', 1, 'Defuncion', 1, 0, 0, 0, 2000),
(29, 2, 'Poderes', 'Venirlo a retirar personalmente en la oficina.', 23131, 'Patricio', 'Azogues', 'Cañar', '12312424214', 1, 'Matrimonio', 1, 0, 1, 0, 2000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramite_divorcio`
--

CREATE TABLE `tramite_divorcio` (
  `id_tram_div` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `td_tdivorcio` varchar(50) NOT NULL,
  `id_hijos` int(11) NOT NULL,
  `td_identificacion_c` varchar(50) NOT NULL,
  `td_nombre_c` varchar(50) NOT NULL,
  `td_direccion_c` varchar(50) NOT NULL,
  `td_telefono_c` varchar(50) NOT NULL,
  `td_estado_c` varchar(50) NOT NULL,
  `td_ciudad_c` varchar(50) NOT NULL,
  `td_apt_c` varchar(50) NOT NULL,
  `td_cpostal_c` varchar(50) NOT NULL,
  `td_lugar_matrimonio` varchar(50) NOT NULL,
  `td_fecha_matrimonio` date NOT NULL,
  `td_eseparacion` tinyint(1) NOT NULL,
  `td_tiempo_separacion` varchar(50) NOT NULL,
  `td_ep_matrimonio` tinyint(1) NOT NULL,
  `td_ep_nacimiento` tinyint(1) NOT NULL,
  `td_estado_contac_ecuador` tinyint(1) NOT NULL,
  `td_tel_ecuador` varchar(50) NOT NULL,
  `td_observaciones` varchar(50) NOT NULL,
  `td_mpago` varchar(50) NOT NULL,
  `td_valor` double NOT NULL,
  `td_abono` double NOT NULL,
  `td_saldo` double NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramite_impuestos`
--

CREATE TABLE `tramite_impuestos` (
  `id_tram_impuestos` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `ti_fecha` date NOT NULL,
  `ti_itin` tinyint(1) NOT NULL,
  `ti_fechain` date NOT NULL,
  `ti_nitin` varchar(50) NOT NULL,
  `ti_ecivil` varchar(50) NOT NULL,
  `ti_dependientes` varchar(50) NOT NULL,
  `ti_mpago` varchar(50) NOT NULL,
  `ti_banco` varchar(50) NOT NULL,
  `ti_ncuenta` varchar(50) NOT NULL,
  `ti_nruta` varchar(50) NOT NULL,
  `ti_observacion` varchar(50) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `ti_profesion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tramite_impuestos`
--

INSERT INTO `tramite_impuestos` (`id_tram_impuestos`, `id_cliente`, `ti_fecha`, `ti_itin`, `ti_fechain`, `ti_nitin`, `ti_ecivil`, `ti_dependientes`, `ti_mpago`, `ti_banco`, `ti_ncuenta`, `ti_nruta`, `ti_observacion`, `id_usuario`, `ti_profesion`) VALUES
(0, 2, '2025-04-13', 0, '2025-05-07', '12', 'Soltero(A)', '2', 'Elegir', 'Pichincha', '124321', '111111', 'asdas', 1, 'Ing Sistemas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramite_poderes`
--

CREATE TABLE `tramite_poderes` (
  `id_tram_poderes` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `tp_nombre` varchar(50) NOT NULL,
  `tp_cedula` varchar(50) NOT NULL,
  `tp_razon` varchar(50) NOT NULL,
  `tp_oenvio` varchar(50) NOT NULL,
  `tp_valor` double NOT NULL,
  `tp_abono` double NOT NULL,
  `tp_saldo` double NOT NULL,
  `tp_nrecibo` int(50) NOT NULL,
  `tp_noenvio` varchar(50) NOT NULL,
  `tp_ciudad` varchar(50) NOT NULL,
  `tp_provincia` varchar(50) NOT NULL,
  `tp_telefono` varchar(50) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tram_div_menores`
--

CREATE TABLE `tram_div_menores` (
  `id_tram_div_menores` int(11) NOT NULL,
  `id_tram_div` int(11) NOT NULL,
  `tdm_nombres` varchar(11) NOT NULL,
  `tdm_edad` int(50) NOT NULL,
  `tdm_lugar_nac` varchar(50) NOT NULL,
  `tdm_fecha_nac` date NOT NULL,
  `tdm_pension` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `u_nombre` char(50) NOT NULL,
  `u_apellido` char(50) NOT NULL,
  `u_usuario` char(50) NOT NULL,
  `u_contrasena` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `u_nombre`, `u_apellido`, `u_usuario`, `u_contrasena`) VALUES
(1, 'Patricio', 'Peralta', 'admin', '1234'),
(2, 'Juan', 'Caranqui', 'admin2', '1234');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `tramites_varios`
--
ALTER TABLE `tramites_varios`
  ADD PRIMARY KEY (`id_tramite_varios`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tramite_divorcio`
--
ALTER TABLE `tramite_divorcio`
  ADD PRIMARY KEY (`id_tram_div`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_hijos` (`id_hijos`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tramite_impuestos`
--
ALTER TABLE `tramite_impuestos`
  ADD PRIMARY KEY (`id_tram_impuestos`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tramite_poderes`
--
ALTER TABLE `tramite_poderes`
  ADD PRIMARY KEY (`id_tram_poderes`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tram_div_menores`
--
ALTER TABLE `tram_div_menores`
  ADD PRIMARY KEY (`id_tram_div_menores`),
  ADD KEY `id_tram_div` (`id_tram_div`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tramites_varios`
--
ALTER TABLE `tramites_varios`
  MODIFY `id_tramite_varios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tramites_varios`
--
ALTER TABLE `tramites_varios`
  ADD CONSTRAINT `tramites_varios_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tramites_varios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tramite_divorcio`
--
ALTER TABLE `tramite_divorcio`
  ADD CONSTRAINT `tramite_divorcio_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `tramite_divorcio_ibfk_3` FOREIGN KEY (`id_hijos`) REFERENCES `tram_div_menores` (`id_tram_div_menores`),
  ADD CONSTRAINT `tramite_divorcio_ibfk_4` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `tramite_impuestos`
--
ALTER TABLE `tramite_impuestos`
  ADD CONSTRAINT `tramite_impuestos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `tramite_impuestos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tramite_poderes`
--
ALTER TABLE `tramite_poderes`
  ADD CONSTRAINT `tramite_poderes_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `tramite_poderes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tram_div_menores`
--
ALTER TABLE `tram_div_menores`
  ADD CONSTRAINT `tram_div_menores_ibfk_1` FOREIGN KEY (`id_tram_div`) REFERENCES `tramite_divorcio` (`id_tram_div`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
