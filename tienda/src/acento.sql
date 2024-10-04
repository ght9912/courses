/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 100411
Source Host           : localhost:3306
Source Database       : acento

Target Server Type    : MYSQL
Target Server Version : 100411
File Encoding         : 65001

Date: 2023-01-16 00:33:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for autores
-- ----------------------------
DROP TABLE IF EXISTS `autores`;
CREATE TABLE `autores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of autores
-- ----------------------------
INSERT INTO `autores` VALUES ('6', 'Luis Pruneda', 'adfsdf', '[{\"red\":\"FB\",\"link\":\"LJbsd\"}]', 'img/autores/6VYn1UFmhFK1LEjHKAqGQFOY0BIAgXHIusXxGOCm.jpg', '2023-01-06 05:37:47', '2023-01-06 21:37:56');
INSERT INTO `autores` VALUES ('7', 'Kasd', 'asdf', '[{\"red\":\"Insta\",\"link\":\"ad\"}]', 'img/autores/ArwnQE94hXL5WOrKjZPp978r2tFixELiu0j6HaiS.jpg', '2023-01-06 06:07:24', '2023-01-06 21:38:15');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2019_08_19_000000_create_failed_jobs_table', '1');
INSERT INTO `migrations` VALUES ('4', '2019_12_14_000001_create_personal_access_tokens_table', '1');
INSERT INTO `migrations` VALUES ('5', '2022_12_23_040343_secciones', '2');
INSERT INTO `migrations` VALUES ('6', '2022_12_23_041357_create_sub_secciones_table', '2');
INSERT INTO `migrations` VALUES ('7', '2023_01_05_063634_create_autores_table', '3');
INSERT INTO `migrations` VALUES ('8', '2023_01_06_214004_create_notas_table', '4');

-- ----------------------------
-- Table structure for notas
-- ----------------------------
DROP TABLE IF EXISTS `notas`;
CREATE TABLE `notas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `autor_id` bigint(20) unsigned NOT NULL,
  `seccion_id` bigint(20) unsigned DEFAULT NULL,
  `sub_seccion_id` bigint(20) unsigned DEFAULT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_titulo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `portada` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `des_portada` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cuerpo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notas_sub_seccion_id_foreign` (`sub_seccion_id`),
  KEY `notas_seccion_id_foreign` (`seccion_id`),
  KEY `notas_autor_id_foreign` (`autor_id`),
  CONSTRAINT `notas_autor_id_foreign` FOREIGN KEY (`autor_id`) REFERENCES `autores` (`id`),
  CONSTRAINT `notas_seccion_id_foreign` FOREIGN KEY (`seccion_id`) REFERENCES `secciones` (`id`),
  CONSTRAINT `notas_sub_seccion_id_foreign` FOREIGN KEY (`sub_seccion_id`) REFERENCES `sub_secciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of notas
-- ----------------------------
INSERT INTO `notas` VALUES ('2', '6', '1', '16', 'Nota', 'Esta es un titulo de prueba', 'El subtitulo de la nota fue cambiado', 'img/notas/portadas/UGbAh1m2Z2XgeUX2pOiuuPHMpNaij4ARwcSxSZZI.jpg', 'Esta foto solamente es de prueba', '<p style=\"text-align: left;\">Aqui agregamos una imagen al cuerpo</p><img src=\"/storage/img/notas/fo8qwHgHQ4xzcuHudvCRv4W21AbhetdeaMdb8kG4.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib fr-draggable\" status=\"ok\" message=\"Insersión realizada con exito\"><p><br></p>Aqui vemos el detalle de la imagen <br><p></p><p><br></p>', 'clave1,clave2', '2023-01-12 00:14:36', '2023-01-13 07:00:47');
INSERT INTO `notas` VALUES ('3', '6', '1', '16', 'Nota', 'Tests', null, 'img/notas/portadas/AsTQZCUYdSj8zUd79lwdN6MrRCSp9iz7zghLF6kp.jpg', null, '<p><img src=\"/storage/img/notas/r9KeRaZgkBYxj4GNUYAxt7mCtPIu2TuvHtvjUU0l.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib fr-draggable\" status=\"ok\" message=\"Insersión realizada con exito\"></p><p>revisando esta imagen<br></p>', 'adasdf', '2023-01-12 00:54:56', '2023-01-12 00:54:56');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for secciones
-- ----------------------------
DROP TABLE IF EXISTS `secciones`;
CREATE TABLE `secciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `secciones_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of secciones
-- ----------------------------
INSERT INTO `secciones` VALUES ('1', 'Historia', 'Esta es la sección de letras', '2023-01-01 15:41:59', '2023-01-13 18:06:28');
INSERT INTO `secciones` VALUES ('23', 'Plástica', null, '2023-01-05 04:35:35', '2023-01-13 07:09:04');
INSERT INTO `secciones` VALUES ('24', 'Escenarios', null, '2023-01-05 04:37:31', '2023-01-13 07:09:50');
INSERT INTO `secciones` VALUES ('25', 'Cine', null, '2023-01-05 06:33:03', '2023-01-13 07:11:41');
INSERT INTO `secciones` VALUES ('27', 'Ciencia', 'Esta es la sección de letras', '2023-01-13 18:07:36', '2023-01-13 18:07:36');

-- ----------------------------
-- Table structure for sub_secciones
-- ----------------------------
DROP TABLE IF EXISTS `sub_secciones`;
CREATE TABLE `sub_secciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `seccion_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_secciones_seccion_id_foreign` (`seccion_id`),
  CONSTRAINT `sub_secciones_seccion_id_foreign` FOREIGN KEY (`seccion_id`) REFERENCES `secciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sub_secciones
-- ----------------------------
INSERT INTO `sub_secciones` VALUES ('14', '23', 'Pintura', null, '2023-01-05 04:35:35', '2023-01-13 07:09:04');
INSERT INTO `sub_secciones` VALUES ('16', '1', 'Novedad Semanal', 'Aqui vermos x', '2023-01-05 06:05:49', '2023-01-13 07:07:31');
INSERT INTO `sub_secciones` VALUES ('17', '24', 'Teatro', null, '2023-01-05 06:30:58', '2023-01-13 07:09:50');
INSERT INTO `sub_secciones` VALUES ('18', '25', 'En cartelera', null, '2023-01-05 06:33:03', '2023-01-13 07:11:42');
INSERT INTO `sub_secciones` VALUES ('19', '1', 'Novela', null, '2023-01-13 07:07:31', '2023-01-13 07:07:31');
INSERT INTO `sub_secciones` VALUES ('20', '1', 'Ensayo', null, '2023-01-13 07:07:31', '2023-01-13 07:07:31');
INSERT INTO `sub_secciones` VALUES ('21', '1', 'Poesía', null, '2023-01-13 07:07:31', '2023-01-13 07:07:31');
INSERT INTO `sub_secciones` VALUES ('22', '1', 'Novela gráfica', null, '2023-01-13 07:07:31', '2023-01-13 07:07:31');
INSERT INTO `sub_secciones` VALUES ('23', '1', 'Lo más vendido 2022', null, '2023-01-13 07:07:31', '2023-01-13 07:07:31');
INSERT INTO `sub_secciones` VALUES ('24', '1', 'Autores', null, '2023-01-13 07:07:31', '2023-01-13 07:07:31');
INSERT INTO `sub_secciones` VALUES ('25', '1', 'Ferias y exposiciones', null, '2023-01-13 07:07:31', '2023-01-13 07:07:31');
INSERT INTO `sub_secciones` VALUES ('26', '1', 'Convocatorias', null, '2023-01-13 07:07:31', '2023-01-13 07:07:31');
INSERT INTO `sub_secciones` VALUES ('27', '23', 'Fotografía', null, '2023-01-13 07:09:04', '2023-01-13 07:09:04');
INSERT INTO `sub_secciones` VALUES ('28', '23', 'Escultura', null, '2023-01-13 07:09:04', '2023-01-13 07:09:04');
INSERT INTO `sub_secciones` VALUES ('29', '23', 'Cartón - Creadores', null, '2023-01-13 07:09:04', '2023-01-13 07:09:04');
INSERT INTO `sub_secciones` VALUES ('30', '23', 'Exposiciones', null, '2023-01-13 07:09:04', '2023-01-13 07:09:04');
INSERT INTO `sub_secciones` VALUES ('31', '23', 'Convocatorias', null, '2023-01-13 07:09:04', '2023-01-13 07:09:04');
INSERT INTO `sub_secciones` VALUES ('32', '24', 'Ópera', null, '2023-01-13 07:09:50', '2023-01-13 07:09:50');
INSERT INTO `sub_secciones` VALUES ('33', '24', 'Espectáculos', null, '2023-01-13 07:09:50', '2023-01-13 07:09:50');
INSERT INTO `sub_secciones` VALUES ('34', '24', 'Danza', null, '2023-01-13 07:09:50', '2023-01-13 07:09:50');
INSERT INTO `sub_secciones` VALUES ('35', '24', 'Convocatorias', null, '2023-01-13 07:09:50', '2023-01-13 07:09:50');
INSERT INTO `sub_secciones` VALUES ('36', '25', 'Película en plataforma', null, '2023-01-13 07:11:42', '2023-01-13 07:11:42');
INSERT INTO `sub_secciones` VALUES ('37', '25', 'Serie en plataforma', null, '2023-01-13 07:11:42', '2023-01-13 07:11:42');
INSERT INTO `sub_secciones` VALUES ('38', '25', 'Cine clásico', null, '2023-01-13 07:11:42', '2023-01-13 07:11:42');
INSERT INTO `sub_secciones` VALUES ('39', '25', 'Noticias', null, '2023-01-13 07:11:42', '2023-01-13 07:11:42');
INSERT INTO `sub_secciones` VALUES ('40', '25', 'Convocatorias', null, '2023-01-13 07:11:42', '2023-01-13 07:11:42');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('2', 'Luis Pruneda', 'luisfer_hdz9@hotmail.com', null, '$2y$10$27SmZ2deeeKedbbt8yMQfOKKpiXdDHvGsEHwvGcCzRfwJIxqvBxd6', null, '2022-12-07 03:01:49', '2022-12-07 03:01:49');
SET FOREIGN_KEY_CHECKS=1;
