-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2022 a las 12:00:55
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `rfc` varchar(15) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cel` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `direccion`, `rfc`, `tel`, `email`, `cel`) VALUES
(8, 'Juan Perez Hernandez', 'Abasolo 1418', 'PUHL950612N74', '1234567891', 'hola@hotmail.com', '8441223334'),
(9, 'Arturo Gonzalez', 'Real de Valencia 308', 'PUHL950612N75', '8441223334', 'luisp@landprofitgenerator.com', '8441223334'),
(13, 'Publico General', 'Ninguna', 'XXXX000000XXX', '8441234567', 'sinemail@hotmail.com', '8441234567');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costos`
--

CREATE TABLE `costos` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_producto` int(11) UNSIGNED NOT NULL,
  `id_proveedor` int(11) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `metodo_pago` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id` int(11) UNSIGNED NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) UNSIGNED DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `id_producto`, `cantidad`) VALUES
(2, 1, 20),
(9, 2, 8),
(10, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_proveedor` int(11) UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_proveedor`, `nombre`, `descripcion`, `categoria`, `precio`) VALUES
(1, 3, 'Pepsi 500ML', 'Esta es una pepsi', 'Refrescos', '25.00'),
(2, 2, 'Coca Light 600ML', 'Coca light 600ML', 'Refrescos', '20.00'),
(3, 4, 'Ruffles 120g', 'Ruffles 120g', 'Frituras', '30.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `rfc` varchar(15) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `responsable` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `rfc`, `telefono`, `responsable`) VALUES
(2, 'Coca Cola', 'HSDS123123SDC', '1234567891', 'Luis'),
(3, 'Pepsi', 'adfasdfasdf', '2315464654654', 'Juan Perez'),
(4, 'Sabritas', 'prueba', '1323113131', 'Juanita');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_cliente` int(11) UNSIGNED DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `metodo_de_pago` int(1) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_cliente`, `fecha`, `total`, `metodo_de_pago`, `updated_at`) VALUES
(2, 13, '2022-11-26 06:00:00', '25.00', 1, '2022-11-26 21:16:01'),
(3, 13, '2022-11-27 21:16:45', '25.00', 1, '2022-12-03 17:45:27'),
(4, 13, '2022-11-28 21:19:44', '25.00', 1, '2022-12-03 17:45:39'),
(5, 13, '2022-11-29 15:56:57', '25.00', 1, '2022-12-03 17:45:47'),
(6, 13, '2022-11-30 16:03:06', '25.00', 1, '2022-12-03 17:46:14'),
(7, 13, '2022-11-25 16:05:34', '130.00', 1, '2022-12-03 17:46:33'),
(8, 8, '2022-12-03 16:06:23', '60.00', 1, '2022-11-25 16:06:23'),
(9, 13, '2022-12-03 16:23:42', '25.00', 1, '2022-12-03 16:23:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_productos`
--

CREATE TABLE `ventas_productos` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) UNSIGNED NOT NULL,
  `id_venta` int(11) UNSIGNED NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `cantidad` decimal(10,2) NOT NULL,
  `costo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas_productos`
--

INSERT INTO `ventas_productos` (`id`, `id_producto`, `id_venta`, `fecha`, `cantidad`, `costo`) VALUES
(4, 1, 2, '2022-11-26 06:00:00', '1.00', '25.00'),
(5, 1, 3, '2022-11-26 21:16:45', '1.00', '25.00'),
(7, 1, 4, '2022-11-26 21:19:44', '1.00', '25.00'),
(8, 1, 5, '2022-12-03 15:56:57', '1.00', '25.00'),
(9, 1, 6, '2022-12-03 16:03:06', '1.00', '25.00'),
(10, 1, 7, '2022-12-03 16:05:34', '2.00', '25.00'),
(11, 2, 7, '2022-12-03 16:05:34', '1.00', '20.00'),
(12, 2, 7, '2022-12-03 16:05:34', '1.00', '20.00'),
(13, 3, 8, '2022-12-03 16:06:23', '2.00', '30.00'),
(14, 1, 9, '2022-12-03 16:23:42', '1.00', '25.00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `costos`
--
ALTER TABLE `costos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreign_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreign_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `ventas_productos`
--
ALTER TABLE `ventas_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `costos`
--
ALTER TABLE `costos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ventas_productos`
--
ALTER TABLE `ventas_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `costos`
--
ALTER TABLE `costos`
  ADD CONSTRAINT `costos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `costos_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `foreign_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `foreign_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `ventas_productos`
--
ALTER TABLE `ventas_productos`
  ADD CONSTRAINT `ventas_productos_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `ventas_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
