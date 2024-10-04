/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 100411
Source Host           : localhost:3306
Source Database       : tienda

Target Server Type    : MYSQL
Target Server Version : 100411
File Encoding         : 65001

Date: 2022-12-10 14:47:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `pass` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SET FOREIGN_KEY_CHECKS=1;
