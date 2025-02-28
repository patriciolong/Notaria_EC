-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2025 at 03:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdd_notaria_ecuador`
--

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
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
  `c_abonado` int(11) NOT NULL,
  `c_deuda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `c_identificacion`, `c_nombre`, `c_apellido`, `c_telefono`, `c_edad`, `c_direccion`, `c_pais`, `c_estado`, `c_ciudad`, `c_codpostal`, `c_email`, `c_napartamento`, `c_abonado`, `c_deuda`) VALUES
(1, '0150308732', 'Juan', 'Carangui', '0983141176', 23, 'Miraflores', 'Ecuador', 'Azuay', 'Cuenca', '010206', 'juanfelicc@gmail.com', '0', 100, 200),
(2, '0105925929', 'patricio', 'peralta', '09754115', 23, 'heroes', 'Ecuador', 'Azuay', 'Cuenca', '010101', 'pato@mail', '14', 300, 400);

-- --------------------------------------------------------

--
-- Table structure for table `tramites_varios`
--

CREATE TABLE `tramites_varios` (
  `id_tramite_varios` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `tv_motivo` varchar(50) NOT NULL,
  `tv_oenvio` varchar(50) NOT NULL,
  `tv_valor` double NOT NULL,
  `tv_abono` double NOT NULL,
  `tv_saldo` double NOT NULL,
  `tv_nrecibo` int(50) NOT NULL,
  `tv_nom_envio` varchar(50) NOT NULL,
  `tv_ciudad` varchar(50) NOT NULL,
  `tv_provincia` varchar(50) NOT NULL,
  `tv_telefono` varchar(50) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tramite_divorcio`
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
-- Table structure for table `tramite_impuestos`
--

CREATE TABLE `tramite_impuestos` (
  `id_tram_impuestos` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `ti_fecha` date NOT NULL,
  `ti_valor` double NOT NULL,
  `ti_abono` double NOT NULL,
  `ti_saldo` double NOT NULL,
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
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tramite_poderes`
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
-- Table structure for table `tram_div_menores`
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
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `u_nombre` char(50) NOT NULL,
  `u_apellido` char(50) NOT NULL,
  `u_usuario` char(50) NOT NULL,
  `u_contrasena` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `u_nombre`, `u_apellido`, `u_usuario`, `u_contrasena`) VALUES
(1, 'Patricio', 'Peralta', 'admin', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indexes for table `tramites_varios`
--
ALTER TABLE `tramites_varios`
  ADD PRIMARY KEY (`id_tramite_varios`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `tramite_divorcio`
--
ALTER TABLE `tramite_divorcio`
  ADD PRIMARY KEY (`id_tram_div`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_hijos` (`id_hijos`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `tramite_impuestos`
--
ALTER TABLE `tramite_impuestos`
  ADD PRIMARY KEY (`id_tram_impuestos`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `tramite_poderes`
--
ALTER TABLE `tramite_poderes`
  ADD PRIMARY KEY (`id_tram_poderes`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `tram_div_menores`
--
ALTER TABLE `tram_div_menores`
  ADD PRIMARY KEY (`id_tram_div_menores`),
  ADD KEY `id_tram_div` (`id_tram_div`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tramites_varios`
--
ALTER TABLE `tramites_varios`
  MODIFY `id_tramite_varios` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tramites_varios`
--
ALTER TABLE `tramites_varios`
  ADD CONSTRAINT `tramites_varios_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tramites_varios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tramite_divorcio`
--
ALTER TABLE `tramite_divorcio`
  ADD CONSTRAINT `tramite_divorcio_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `tramite_divorcio_ibfk_3` FOREIGN KEY (`id_hijos`) REFERENCES `tram_div_menores` (`id_tram_div_menores`),
  ADD CONSTRAINT `tramite_divorcio_ibfk_4` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `tramite_impuestos`
--
ALTER TABLE `tramite_impuestos`
  ADD CONSTRAINT `tramite_impuestos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `tramite_impuestos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tramite_poderes`
--
ALTER TABLE `tramite_poderes`
  ADD CONSTRAINT `tramite_poderes_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `tramite_poderes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tram_div_menores`
--
ALTER TABLE `tram_div_menores`
  ADD CONSTRAINT `tram_div_menores_ibfk_1` FOREIGN KEY (`id_tram_div`) REFERENCES `tramite_divorcio` (`id_tram_div`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
