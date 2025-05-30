-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2025 a las 00:34:48
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

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
  `c_abonado` double DEFAULT NULL,
  `c_deuda` double DEFAULT NULL,
  `c_saldo` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `c_identificacion`, `c_nombre`, `c_apellido`, `c_telefono`, `c_edad`, `c_direccion`, `c_pais`, `c_estado`, `c_ciudad`, `c_codpostal`, `c_email`, `c_napartamento`, `c_abonado`, `c_deuda`, `c_saldo`) VALUES
(10, '0105925929', 'Patricio Esteban', ' Peralta Ochoa', '0979272404', 23, 'Heroes de Verdeloma y Estevez de toral', 'Ecuador', 'Azuay', 'Cuenca', '010101', 'patricioperalta090@gmail.com', '3', 175, 380, 205);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_data`
--

CREATE TABLE `login_data` (
  `id_login` int(100) NOT NULL,
  `l_fecha_hora` datetime(6) NOT NULL,
  `id_usuario` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login_data`
--

INSERT INTO `login_data` (`id_login`, `l_fecha_hora`, `id_usuario`) VALUES
(2, '2025-05-05 05:35:26.000000', 1),
(3, '2025-05-05 05:35:38.000000', 1),
(4, '2025-05-05 05:36:25.000000', 2),
(5, '2025-05-05 05:40:51.000000', 2),
(6, '2025-05-04 22:44:05.000000', 2),
(7, '2025-05-04 22:44:45.000000', 1),
(8, '2025-05-07 19:28:33.000000', 2),
(9, '2025-05-07 19:39:39.000000', 2),
(10, '2025-05-07 19:39:47.000000', 2),
(11, '2025-05-07 20:00:13.000000', 1),
(12, '2025-05-07 20:02:53.000000', 1),
(13, '2025-05-20 17:19:49.000000', 1),
(14, '2025-05-20 17:34:56.000000', 1),
(15, '2025-05-20 17:35:37.000000', 1),
(16, '2025-05-20 17:46:06.000000', 1),
(17, '2025-05-21 11:22:13.000000', 1),
(19, '2025-05-21 17:06:55.000000', 1),
(20, '2025-05-22 13:50:07.000000', 1),
(21, '2025-05-22 17:02:16.000000', 1),
(22, '2025-05-22 17:31:09.000000', 1),
(23, '2025-05-22 17:41:16.000000', 1),
(24, '2025-05-28 17:27:19.000000', 1),
(25, '2025-05-30 17:22:44.000000', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantillas`
--

CREATE TABLE `plantillas` (
  `id_plantilla` int(11) NOT NULL,
  `nombre_plantilla` varchar(255) NOT NULL,
  `contenido_html` longtext NOT NULL,
  `tipo_documento` varchar(100) DEFAULT 'poder_especial',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultima_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plantillas`
--

INSERT INTO `plantillas` (`id_plantilla`, `nombre_plantilla`, `contenido_html`, `tipo_documento`, `fecha_creacion`, `ultima_modificacion`) VALUES
(1, 'Poder Especial Venta Inmuebles', '<!DOCTYPE html>\r\n<html lang=\"es\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <title>Escritura de Poder Especial</title>\r\n</head>\r\n<body>\r\n\r\n    <h1>ESCRITURA DE PODER ESPECIAL PARA<br>VENTA DE INMUEBLES EN EL ECUADOR</h1>\r\n\r\n    <div class=\"main-content\">\r\n        <p>En la ciudad de <strong>CUENCA</strong> Estado de New York, Estados Unidos de América, el día de hoy <strong>[[fecha_otorgamiento]]</strong>, ante mí <strong>[[notario_nombre]]</strong>, Notario Público, por y para el Estado de New York;</p>\r\n\r\n        <p>comparece(n) por su(s) propio(s) derecho(s) <strong>[[poderdante_nombre]]</strong>, quien(es) se identifica(n) con Número <strong>[[poderdante_identificacion]]</strong>, manifiesta(n) ser de estado civil <strong>[[poderdante_estado_civil]]</strong>, de nacionalidad <strong>[[poderdante_nacionalidad]]</strong>, mayor(es) de edad, con domicilio en <strong>[[poderdante_domicilio_calle]]</strong>, <strong>[[poderdante_domicilio_ciudad]]</strong>, <strong>[[poderdante_domicilio_estado]]</strong>, <strong>[[poderdante_domicilio_pais]]</strong>, y teléfono número +1([[poderdante_telefono_formatted]]);</p>\r\n\r\n        <p>idóneo(s) y conocido(s) por mí, bien instruido(s) en uso de sus legítimos derechos, manifiesta(n) que confiere(n) Poder Especial, amplio y suficiente cual en derecho se requiere, para que tenga plena validez en la República del Ecuador en favor y nombre de <strong>[[mandatario_nombre]]</strong>, con Cédula de Identidad Número <strong>[[mandatario_cedula]]</strong>, para que en representación del(la, los) mandante(s) realice, ejercite o ejecute con plenitud de competencia, atribuciones y facultades todas las gestiones que a continuación se indican: Para dar en venta y real enajenación perpetua, un bien inmueble de su propiedad, consistente en <strong>[[inmueble_tipo]]</strong> ubicado(a) en <strong>[[inmueble_ubicacion]]</strong>, provincia de <strong>[[inmueble_provincia]]</strong>, República del Ecuador;</p>\r\n\r\n        <p>para cuya identificación precisa se tomarán en cuenta los linderos, dimensiones y demás datos que consten en el actual Título de Dominio, que se tendrá como documento habilitante y expresamente incorporado a este instrumento público. Consecuentemente, el(la, los) mandatario(s) nombrado(s) queda facultado(a) para buscar comprador del referido inmueble;</p>\r\n\r\n        <p>fijar el precio de la venta, la forma de cobro, así como para recibir el dinero producto de la venta;</p>\r\n\r\n        <p>y, suscribir la Escritura Pública de transferencia de dominio del mencionado inmueble, en favor del o los compradores;</p>\r\n\r\n        <p>y, en general, ejecutar cuanto trámite y diligencia sean necesarios y sean propios de este tipo de negociación.</p>\r\n\r\n        <p>El(La) apoderado(a), mandatario(a) o procurador se verá(n) investido(a) de las más amplias facultades que la naturaleza del encargo requiera, de tal manera que nunca se vea impedido(a) de actuar por falta de atribuciones o facultades, ni se pueda alegar insuficiencia de Poder por falta de alguna cláusula especial, por lo que se le confiere todas las atribuciones y facultades comunes y especiales constantes en la Ley.</p>\r\n\r\n        <p>Para la ejecución de este Poder el(la) mandatario(a) podrá contratar los servicios profesionales de un Abogado en libre ejercicio de la profesión para que represente al(la, los) poderdante(s) en todo trámite, ante autoridades judiciales o administrativas del Ecuador, quedando el(la) mandatario(a) aquí constituido(a) facultado(a) para delegar total o parcialmente este Mandato pero solo con fines de Procuración Judicial, conservado la facultad de revocar las delegaciones y hacer otras.</p>\r\n\r\n        <p>Quien haga las veces de apoderado(a) se obliga, a rendir cuentas de su gestión y a cumplir con la recta ejecución del mandato en los términos artículo 2038 del Código Civil Vigente y los Artículos 41, 42, 43 y siguientes del Código Orgánico General de Procesos -COGEP.- LIMITACIÓN.- El presente mandato se mantendrá vigente mientras el(la, los) poderdante(s) no lo revoque(n).- Hasta aquí la voluntad expresa del(la, los) mandante(s).</p>\r\n\r\n        <p>El presente instrumento público será legalizado a través de la apostilla a fin de que surta plenos efectos legales y jurídicos en la República del Ecuador.- Para el otorgamiento de este Instrumento Público se cumplieron con todas las formalidades y requisitos legales;</p>\r\n\r\n        <p>y, leído que fue por mí, íntegramente al(la, los) otorgante(s), se ratificó(aron) en su contenido, valor y fuerza legal del mismo, y aprobando todas sus partes firma(n) y estampa(n) su huella digital del pulgar derecho conmigo al pie del presente, esto para constancia, en cuyo acto lo autorizo definitivamente, y de todo lo cual DOY FE.----------</p>\r\n    </div>\r\n\r\n    <div class=\"signature-section\">\r\n        <div class=\"signature-line\"></div>\r\n        <div class=\"signature-name\"><strong>[[poderdante_nombre]]</strong></div>\r\n        <div class=\"signature-name\">NUI. <strong>[[poderdante_identificacion]]</strong></div>\r\n    </div>\r\n\r\n    <div class=\"notary-block\">\r\n        <p>State of New York, County of <strong>[[lugar_otorgamiento]]</strong>,<br>Sworn to before me this: <strong>[[fecha_otorgamiento_raw_usa]]</strong></p>\r\n        <p>---------------------------------------------------------</p>\r\n        <p>Estado de New York, Condado de <strong>[[lugar_otorgamiento]]</strong>,<br>Jurado ante mí este: <strong>[[fecha_otorgamiento]]</strong></p>\r\n        <br>\r\n        <p>Atentamente,</p>\r\n        <p>___________________________________</p>\r\n        <p><strong>[[notary_info_name]]</strong></p>\r\n        <p>[[notary_info_title]]</p>\r\n        <p>No. [[notary_info_no]]</p>\r\n        <p>Qualified in [[notary_info_county]]</p>\r\n        <p>Cert. Filed in [[notary_info_filed]]</p>\r\n        <p>Commission Expires [[notary_info_expires]]</p>\r\n        <br>\r\n        <p>[[notary_address]] - Tel: [[notary_tel]] WhatsApp: [[notary_whatsapp]]</p>\r\n        <p>[[notary_website1]] | [[notary_website2]] | [[notary_email]]</p>\r\n    </div>\r\n</body>\r\n</html>', 'poder_especial', '2025-05-22 21:49:06', '2025-05-22 22:29:55'),
(2, 'Poder Especial Venta Inmuebles Ecuador', '<div style=\"font-family: \'Arial MT\', Arial, sans-serif; font-size: 10pt; line-height: 1.5; margin: 0 auto; width: 210mm; min-height: 297mm; padding: 25mm;\">\n    <h2 style=\"text-align: center; margin: 20pt 0 5pt 0; font-size: 12pt;\">ESCRITURA DE PODER ESPECIAL PARA</h2>\n    <h3 style=\"text-align: center; margin: 0 0 20pt 0; font-size: 11pt;\">VENTA DE INMUEBLES EN EL ECUADOR</h3>\n\n    <p style=\"text-align: justify; text-indent: 0.5in; margin: 0 0 10pt 0; font-size: 10pt;\">\n        En la ciudad de Brooklyn, Condado de Kings, Estado de New York, Estados Unidos de América, el día de hoy\n        <strong>[[fecha_otorgamiento]]</strong>, ante mí Christian Moreno, Notario Público, por y para el Estado de New York;\n        comparece(n) por su(s) propio(s) derecho(s) <strong>[[poderdante_nombre]]</strong>, quien(es) se identifica(n) con\n        Pasaporte Ecuatoriano Número <strong>[[poderdante_identificacion]]</strong>, manifiesta(n) ser de estado civil\n        <strong>[[poderdante_estado_civil]]</strong>, de nacionalidad <strong>[[poderdante_nacionalidad]]</strong>, mayor(es) de edad,\n        con domicilio en <strong>[[poderdante_domicilio_calle]]</strong>, <strong>[[poderdante_domicilio_ciudad]]</strong>,\n        <strong>[[poderdante_domicilio_estado]]</strong>, <strong>[[poderdante_domicilio_pais]]</strong>, y teléfono número\n        <strong>[[poderdante_telefono_formatted]]</strong>; idóneo(s) y conocido(s) por mí, bien instruido(s) en uso de sus\n        legítimos derechos, manifiesta(n) que confiere(n) Poder Especial, amplio y suficiente cual en derecho se requiere,\n        para que tenga plena validez en la República del Ecuador en favor y nombre de <strong>[[mandatario_nombre]]</strong>,\n        con Cédula de Identidad Número <strong>[[mandatario_cedula]]</strong>, para que en representación del(la, los)\n        mandante(s) realice, ejercite o ejecute con plenitud de competencia, atribuciones y facultades todas las gestiones\n        que a continuación se indican: Para dar en venta y real enajenación perpetua,\n        <strong>[[inmueble_tipo]]</strong> de su propiedad, consistente en ubicado(a) en <strong>[[inmueble_ubicacion]]</strong>,\n        provincia de <strong>[[inmueble_provincia]]</strong>.\n        A tal efecto el(la, los) mandatario(a,s) queda(n) facultado(s) para intervenir, en representación del(la, los)\n        mandante(s) en la protocolización del documento habilitante, firmar la Escritura Pública de Compra Venta,\n        aceptar o rechazar ofertas, recibir el precio de la venta, con la facultad de dar carta de pago, y realizar\n        todos los demás actos necesarios, sean estos preparatorios o posteriores para el fiel y legal cumplimiento\n        del presente poder, con la facultad expresa de suscribir, renunciar, aceptar, prorrogar, solicitar\n        declaraciones de propiedad horizontal, protocolizar resoluciones administrativas, realizar traspaso de\n        dominios, inscribir en el Registro de la Propiedad, firmar escrituras aclaratorias o complementarias,\n        aclarar linderos, superficie, cabida, ubicación, o cualquier otra característica del inmueble, solicitar\n        cédulas catastrales, certificados de gravamen y realizar todos los demás actos necesarios para el fiel y\n        legal cumplimiento del presente poder, con la facultad expresa de sustituir este poder en la persona o\n        personas que bien tenga a objeto de conseguir su total cumplimiento.- Es expresa voluntad del(la, los)\n        mandante(s) que el presente poder tendrá plena validez en la República del Ecuador y a fin de que surta\n        plenos efectos legales, deberá ser apostillado.-\n        Se advierte al (a la, a los) otorgante(s) que el presente instrumento público será legalizado a través de la\n        “apostilla” a fin de que surta plenos efectos legales y jurídicos en la República del Ecuador.- Para el\n        otorgamiento de este Instrumento Público se cumplieron con todas las formalidades y requisitos legales; y,\n        leído que fue por mí, íntegramente al(la, los) otorgante(s), se ratificó(aron) en su contenido, valor y fuerza\n        legal del mismo, y aprobando todas sus partes firma(n) y estampa(n) su huella digital del pulgar derecho\n        conmigo al pie del presente, esto para constancia, en cuyo acto lo autorizo definitivamente, y de todo lo\n        cual DOY FE.----------\n    </p>\n    <div style=\"text-align:center;margin-top: 40pt\">\n        <p>-------------------------------</p>\n        <p>Pulgar Derecho</p>\n    </div>\n\n    <div style=\"text-align: center; margin-top: 40pt; font-size: 10pt; line-height: 1.3;\">\n        <p style=\"margin: 0;\">___________________________________</p>\n        <p style=\"margin: 5pt 0; font-weight: bold;\">[[notary_info_name]]</p>\n    </div>\n\n    <div style=\"margin-top: 10pt; text-align: center; font-size: 10pt;\">\n        <p style=\"margin: 0;\">Estado de New York, Condado de Kings, Jurado ante mí este: <strong>[[fecha_otorgamiento]]</strong></p>\n    </div>\n\n    <div style=\"text-align: center; margin-top: 10pt; font-size: 10pt;\">\n        <p style=\"margin: 5pt 0;\">[[notary_address]] - Tel: [[notary_tel]] WhatsApp: [[notary_whatsapp]]</p>\n        <p style=\"margin: 5pt 0;\">[[notary_website1]]</p>\n        <p style=\"margin: 5pt 0;\">[[notary_email]]</p>\n    </div>\n</div>', 'poder_especial', '2025-05-29 19:47:29', '2025-05-29 21:11:35');

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
(36, 10, 'Poderes', 'Ofrecemos envios express al Ecuador en 3 dias labo', 23131, 'Norma Ochoa', 'Guayaquil', 'Guayas', '0954785724', 1, 'Defuncion', 1, 1, 1, 1, 200);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramite_divorcio`
--

CREATE TABLE `tramite_divorcio` (
  `id_tram_div` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `td_controvertido` tinyint(1) NOT NULL,
  `td_consensual` tinyint(1) NOT NULL,
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
  `td_separados` tinyint(1) NOT NULL,
  `td_noseparados` tinyint(1) NOT NULL,
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
(13, 10, '2025-05-30', 1, '2025-05-02', '13', 'Soltero(A)', '4', 'CASH', 'Autro', '1231231', '1231123', 'Esta listo todo', 1, 'Ingeniero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramite_poderes`
--

CREATE TABLE `tramite_poderes` (
  `id_tram_poderes` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `tp_oficina` varchar(150) NOT NULL,
  `tp_fecha` date NOT NULL,
  `tp_estado_civil` varchar(100) NOT NULL,
  `tp_nombres_otorga_poder` varchar(150) NOT NULL,
  `tp_cedulla_otorga_poder` varchar(150) NOT NULL,
  `tp_razon_otorga_poder` varchar(150) NOT NULL,
  `tp_opcion_envio_poder` varchar(150) NOT NULL,
  `tp_enviar_nombrede` varchar(150) NOT NULL,
  `tp_ciudad_enviar` varchar(150) NOT NULL,
  `tp_provincia` varchar(11) NOT NULL,
  `tp_telefonos_enviar` varchar(150) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tramite_poderes`
--

INSERT INTO `tramite_poderes` (`id_tram_poderes`, `id_cliente`, `tp_oficina`, `tp_fecha`, `tp_estado_civil`, `tp_nombres_otorga_poder`, `tp_cedulla_otorga_poder`, `tp_razon_otorga_poder`, `tp_opcion_envio_poder`, `tp_enviar_nombrede`, `tp_ciudad_enviar`, `tp_provincia`, `tp_telefonos_enviar`, `id_usuario`) VALUES
(58, 10, 'Ecuador', '2025-05-30', 'Soltero(A)', 'Juan Carangui', '0123568547', 'General ($170)', 'Scan a un email o Whatsapp ($10)', 'Norma Ochoa', 'Guayaquil', '', '0954785724', 1);

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
(2, 'Juan', 'Caranqui', 'juanfe', '1234');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `login_data`
--
ALTER TABLE `login_data`
  ADD PRIMARY KEY (`id_login`),
  ADD KEY `relacion` (`id_usuario`);

--
-- Indices de la tabla `plantillas`
--
ALTER TABLE `plantillas`
  ADD PRIMARY KEY (`id_plantilla`),
  ADD UNIQUE KEY `nombre_plantilla_UNIQUE` (`nombre_plantilla`);

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
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `login_data`
--
ALTER TABLE `login_data`
  MODIFY `id_login` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `plantillas`
--
ALTER TABLE `plantillas`
  MODIFY `id_plantilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tramites_varios`
--
ALTER TABLE `tramites_varios`
  MODIFY `id_tramite_varios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `tramite_impuestos`
--
ALTER TABLE `tramite_impuestos`
  MODIFY `id_tram_impuestos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tramite_poderes`
--
ALTER TABLE `tramite_poderes`
  MODIFY `id_tram_poderes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `login_data`
--
ALTER TABLE `login_data`
  ADD CONSTRAINT `relacion` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
