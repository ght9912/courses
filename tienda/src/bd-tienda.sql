/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 100411
Source Host           : localhost:3306
Source Database       : tienda

Target Server Type    : MYSQL
Target Server Version : 100411
File Encoding         : 65001

Date: 2022-12-10 11:52:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `rfc` varchar(15) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cel` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of clientes
-- ----------------------------
INSERT INTO `clientes` VALUES ('8', 'Juan Perez Hernandez', 'Abasolo 1418', 'PUHL950612N74', '1234567891', 'hola@hotmail.com', '8441223334');
INSERT INTO `clientes` VALUES ('9', 'Arturo Gonzalez', 'Real de Valencia 308', 'PUHL950612N75', '8441223334', 'luisp@landprofitgenerator.com', '8441223334');
INSERT INTO `clientes` VALUES ('13', 'Publico General', 'Ninguna', 'XXXX000000XXX', '8441234567', 'sinemail@hotmail.com', '8441234567');

-- ----------------------------
-- Table structure for costos
-- ----------------------------
DROP TABLE IF EXISTS `costos`;
CREATE TABLE `costos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) unsigned NOT NULL,
  `id_proveedor` int(11) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `metodo_pago` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_producto` (`id_producto`),
  KEY `id_proveedor` (`id_proveedor`),
  CONSTRAINT `costos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  CONSTRAINT `costos_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of costos
-- ----------------------------

-- ----------------------------
-- Table structure for gastos
-- ----------------------------
DROP TABLE IF EXISTS `gastos`;
CREATE TABLE `gastos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `concepto` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of gastos
-- ----------------------------

-- ----------------------------
-- Table structure for inventario
-- ----------------------------
DROP TABLE IF EXISTS `inventario`;
CREATE TABLE `inventario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) unsigned DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign_producto` (`id_producto`),
  CONSTRAINT `foreign_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of inventario
-- ----------------------------
INSERT INTO `inventario` VALUES ('2', '1', '20');
INSERT INTO `inventario` VALUES ('9', '2', '8');
INSERT INTO `inventario` VALUES ('10', '3', '3');

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) unsigned DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign_proveedor` (`id_proveedor`),
  CONSTRAINT `foreign_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES ('1', '3', 'Pepsi 500ML', 'Esta es una pepsi', 'Refrescos', '25.00');
INSERT INTO `productos` VALUES ('2', '2', 'Coca Light 600ML', 'Coca light 600ML', 'Refrescos', '20.00');
INSERT INTO `productos` VALUES ('3', '4', 'Ruffles 120g', 'Ruffles 120g', 'Frituras', '30.00');

-- ----------------------------
-- Table structure for proveedores
-- ----------------------------
DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `rfc` varchar(15) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `responsable` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of proveedores
-- ----------------------------
INSERT INTO `proveedores` VALUES ('2', 'Coca Cola', 'HSDS123123SDC', '1234567891', 'Luis');
INSERT INTO `proveedores` VALUES ('3', 'Pepsi', 'adfasdfasdf', '2315464654654', 'Juan Perez');
INSERT INTO `proveedores` VALUES ('4', 'Sabritas', 'prueba', '1323113131', 'Juanita');

-- ----------------------------
-- Table structure for ventas
-- ----------------------------
DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) unsigned DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `metodo_de_pago` int(1) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ventas
-- ----------------------------
INSERT INTO `ventas` VALUES ('2', '13', '2022-11-26 00:00:00', '25.00', '1', '2022-11-26 15:16:01');
INSERT INTO `ventas` VALUES ('3', '13', '2022-11-27 15:16:45', '25.00', '1', '2022-12-03 11:45:27');
INSERT INTO `ventas` VALUES ('4', '13', '2022-11-28 15:19:44', '25.00', '1', '2022-12-03 11:45:39');
INSERT INTO `ventas` VALUES ('5', '13', '2022-11-29 09:56:57', '25.00', '1', '2022-12-03 11:45:47');
INSERT INTO `ventas` VALUES ('6', '13', '2022-11-30 10:03:06', '25.00', '1', '2022-12-03 11:46:14');
INSERT INTO `ventas` VALUES ('7', '13', '2022-11-25 10:05:34', '130.00', '1', '2022-12-03 11:46:33');
INSERT INTO `ventas` VALUES ('8', '8', '2022-12-03 10:06:23', '60.00', '1', '2022-11-25 10:06:23');
INSERT INTO `ventas` VALUES ('9', '13', '2022-12-03 10:23:42', '25.00', '1', '2022-12-03 10:23:42');

-- ----------------------------
-- Table structure for ventas_productos
-- ----------------------------
DROP TABLE IF EXISTS `ventas_productos`;
CREATE TABLE `ventas_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) unsigned NOT NULL,
  `id_venta` int(11) unsigned NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `cantidad` decimal(10,2) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_venta` (`id_venta`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `ventas_productos_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  CONSTRAINT `ventas_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ventas_productos
-- ----------------------------
INSERT INTO `ventas_productos` VALUES ('4', '1', '2', '2022-11-26 00:00:00', '1.00', '25.00');
INSERT INTO `ventas_productos` VALUES ('5', '1', '3', '2022-11-26 15:16:45', '1.00', '25.00');
INSERT INTO `ventas_productos` VALUES ('7', '1', '4', '2022-11-26 15:19:44', '1.00', '25.00');
INSERT INTO `ventas_productos` VALUES ('8', '1', '5', '2022-12-03 09:56:57', '1.00', '25.00');
INSERT INTO `ventas_productos` VALUES ('9', '1', '6', '2022-12-03 10:03:06', '1.00', '25.00');
INSERT INTO `ventas_productos` VALUES ('10', '1', '7', '2022-12-03 10:05:34', '2.00', '25.00');
INSERT INTO `ventas_productos` VALUES ('11', '2', '7', '2022-12-03 10:05:34', '1.00', '20.00');
INSERT INTO `ventas_productos` VALUES ('12', '2', '7', '2022-12-03 10:05:34', '1.00', '20.00');
INSERT INTO `ventas_productos` VALUES ('13', '3', '8', '2022-12-03 10:06:23', '2.00', '30.00');
INSERT INTO `ventas_productos` VALUES ('14', '1', '9', '2022-12-03 10:23:42', '1.00', '25.00');
SET FOREIGN_KEY_CHECKS=1;
