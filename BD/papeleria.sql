-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2023 a las 02:57:52
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `papeleria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_clientes`
--

CREATE TABLE `tbl_clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(50) NOT NULL,
  `direccion_cliente` text DEFAULT NULL,
  `telefono_cliente` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_clientes`
--

INSERT INTO `tbl_clientes` (`id_cliente`, `nombre_cliente`, `direccion_cliente`, `telefono_cliente`) VALUES
(1, 'RODRIGO', 'TEJOCOTE 65 ESTADO DE MEXICO', '2147483648'),
(2, 'TAMRA XIMENA', 'DURANGO 165 COYOACAN CDMX', '5510263458'),
(3, 'KAREN IBARRA', 'TEJACATES 45 BENITO JUAREZ CDMX', '5516357894'),
(4, 'MARIA CARDENAS', 'BOCA DEL RREVIO 25 VRACUZ', '5549760213'),
(5, 'CECAR CONTERAS ', 'FRAGOSO 22 ESTADO DE MEXICO', '5525468975'),
(6, 'GUADALUPE GARCIA ', 'BUENAVISTA 34 CDMX', '5548796412'),
(7, 'MAURICIO RODRIGUEZ', '6 DE ENERO ESTADO DE MEXICO', '5548795631');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_empleados`
--

CREATE TABLE `tbl_empleados` (
  `rfc` varchar(13) NOT NULL,
  `nombre_empleado` varchar(30) NOT NULL,
  `genero` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_empleados`
--

INSERT INTO `tbl_empleados` (`rfc`, `nombre_empleado`, `genero`) VALUES
('D2Z65A6YY5FGH', 'ARTURO TORRES', 'Masculino'),
('DF5AD15E5HCDT', 'SARA FERNANDEZ ', 'Femenino'),
('H6C6SDS2V6FH5', 'PATRICIA HERNANDEZ ', 'Femenino'),
('JJ4X5S6C5D6A6', 'OSCAR GONZALEZ ', 'Masculino'),
('SFV2D5GDV2X92', 'DANIELA', 'Femenino'),
('VD5VDV5D2V56G', 'XIMENA', 'Femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_productos`
--

CREATE TABLE `tbl_productos` (
  `id_producto` int(11) NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `proveedor` varchar(60) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `nombre_producto` varchar(50) NOT NULL,
  `descripcion_producto` text DEFAULT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `cantidad_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_productos`
--

INSERT INTO `tbl_productos` (`id_producto`, `fecha_compra`, `proveedor`, `categoria`, `nombre_producto`, `descripcion_producto`, `precio_unitario`, `cantidad_stock`) VALUES
(1, '2023-05-28 21:57:39', 'PANCHO CONTRERAS', 'Bolígrafos y lápices', 'LAPIZ', 'LAPICES EDEL NUMERO 2', 3.50, 100),
(2, '2023-05-28 21:58:19', 'JAIME TORRES', 'Útiles de escritura', 'MARCATEXTOS', 'MARCATEXTCOS OLOR PASTEL', 5.00, 50),
(3, '2023-05-29 13:26:47', 'GABRIEL RODRIGUEZ ', 'Cuadernos y libretas', 'CUADERNOS', 'CUADERNOS DE CUADRO CHICO', 15.00, 25),
(4, '2023-05-29 13:27:56', 'JAIME TORRES', 'Archivo y organización', 'CARPETAS', 'CARPETAS ESCOLAR CON 8 SEPARACIONES ', 35.00, 20),
(5, '2023-05-29 13:28:42', 'GABRIEL RODRIGUEZ ', 'Material de dibujo y pintura', 'ACUARELAS ', 'ACUARELAS DE 13 COLORES CON 1 PINCEL ', 7.00, 30),
(6, '2023-05-29 13:29:53', 'GABRIEL RODRIGUEZ ', 'Útiles de escritura', 'CRAYOLAS ', 'CAJA DE CRAYOLAS CON 20 RCRAYOLAS DE COLORES DIFERENTES ', 12.00, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_productos_venta`
--

CREATE TABLE `tbl_productos_venta` (
  `id_producto_venta` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_comprada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_productos_venta`
--

INSERT INTO `tbl_productos_venta` (`id_producto_venta`, `id_venta`, `id_producto`, `cantidad_comprada`) VALUES
(1, 1, 2, 4),
(2, 2, 1, 5),
(3, 3, 3, 2),
(4, 4, 3, 3),
(5, 5, 6, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ventas`
--

CREATE TABLE `tbl_ventas` (
  `id_venta` int(11) NOT NULL,
  `fecha_venta` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `rfc_empleado` varchar(13) NOT NULL,
  `total_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_ventas`
--

INSERT INTO `tbl_ventas` (`id_venta`, `fecha_venta`, `id_cliente`, `rfc_empleado`, `total_venta`) VALUES
(1, '2023-05-28 21:59:25', 1, 'SFV2D5GDV2X92', 20.00),
(2, '2023-05-28 21:59:46', 1, 'VD5VDV5D2V56G', 17.50),
(3, '2023-05-29 13:30:07', 3, 'H6C6SDS2V6FH5', 30.00),
(4, '2023-05-29 13:30:18', 1, 'SFV2D5GDV2X92', 45.00),
(5, '2023-05-31 23:39:42', 5, 'H6C6SDS2V6FH5', 60.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_clientes`
--
ALTER TABLE `tbl_clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `tbl_empleados`
--
ALTER TABLE `tbl_empleados`
  ADD PRIMARY KEY (`rfc`);

--
-- Indices de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `tbl_productos_venta`
--
ALTER TABLE `tbl_productos_venta`
  ADD PRIMARY KEY (`id_producto_venta`),
  ADD KEY `fk_productos_venta_ventas` (`id_venta`),
  ADD KEY `fk_productos_venta_productos` (`id_producto`);

--
-- Indices de la tabla `tbl_ventas`
--
ALTER TABLE `tbl_ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fk_ventas_clientes` (`id_cliente`),
  ADD KEY `fk_ventas_empleados` (`rfc_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_clientes`
--
ALTER TABLE `tbl_clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_productos_venta`
--
ALTER TABLE `tbl_productos_venta`
  MODIFY `id_producto_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_ventas`
--
ALTER TABLE `tbl_ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_productos_venta`
--
ALTER TABLE `tbl_productos_venta`
  ADD CONSTRAINT `fk_productos_venta_productos` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`),
  ADD CONSTRAINT `fk_productos_venta_ventas` FOREIGN KEY (`id_venta`) REFERENCES `tbl_ventas` (`id_venta`);

--
-- Filtros para la tabla `tbl_ventas`
--
ALTER TABLE `tbl_ventas`
  ADD CONSTRAINT `fk_ventas_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_clientes` (`id_cliente`),
  ADD CONSTRAINT `fk_ventas_empleados` FOREIGN KEY (`rfc_empleado`) REFERENCES `tbl_empleados` (`rfc`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
