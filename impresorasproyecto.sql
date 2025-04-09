-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-04-2025 a las 12:24:44
-- Versión del servidor: 8.0.41-0ubuntu0.24.04.1
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `impresorasproyecto`
--
CREATE DATABASE IF NOT EXISTS `impresorasproyecto` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `impresorasproyecto`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `cache`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `cache_locks`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `failed_jobs`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impresoras`
--

DROP TABLE IF EXISTS `impresoras`;
CREATE TABLE `impresoras` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ubicacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_reserva_dhcp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_cola_hacos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `impresoras`:
--

--
-- Volcado de datos para la tabla `impresoras`
--

INSERT INTO `impresoras` (`id`, `created_at`, `updated_at`, `tipo`, `ubicacion`, `usuario`, `ip`, `nombre_reserva_dhcp`, `observaciones`, `nombre_cola_hacos`) VALUES
(17, NULL, '2025-04-08 09:58:48', '1', 'Tesorería', 'Carmen Cisneros', '10.66.129.61', 'ImpEpsonTesore1', 'EPSONB1DC89', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1618'),
(18, '2025-04-08 10:07:15', '2025-04-08 10:43:45', '1', 'Secretaría Part.', 'Juan F.Sanchez de Mo', '10.66.129.62', 'ImpEpsonTesore2', 'EPSONB1DC89', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1619'),
(19, '2025-04-08 10:45:03', '2025-04-08 10:45:03', '1', 'Tesorería', 'Mercedes Alvarez', '10.66.129.63', 'ImpEpsonTesore3', 'EPSONB1DA4E', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1620'),
(20, '2025-04-08 11:05:42', '2025-04-08 11:05:42', '1', 'Secretaría', 'Juan Luis Lara', '10.66.129.64', 'ImpEpsonTesore4', 'EPSONB1DBAB', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1621'),
(21, '2025-04-08 11:16:07', '2025-04-08 11:16:07', '1', 'Desr. Informático', '3ª Planta', '10.66.129.65', 'ImpEpsonTesore5', 'EPSONB1DAB7', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1622'),
(22, '2025-04-08 11:22:06', '2025-04-08 11:22:06', '1', 'Informática', 'Fran León', '10.66.129.66', 'ImpEpsonInspSe1', 'EPSONB1DB7D', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1623'),
(23, '2025-04-08 11:23:51', '2025-04-08 11:23:51', '1', 'Secretario Industrial', 'Ángel Bravo', '10.66.129.68', 'ImpEpsonInspSe2', 'EPSONB1DB7E', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1625'),
(24, '2025-04-08 11:26:06', '2025-04-08 11:26:06', '1', 'Secretaría Deleg.', 'Agustín López', '10.66.129.69', 'ImpEpsonSecret1', 'EPSONB1DA4D', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1626'),
(25, '2025-04-08 11:29:38', '2025-04-08 11:29:38', '1', 'Secretaría Industrial', 'Toñi Naranjo', '10.66.129.70', 'ImpEpsonSecret2', 'EPSONB1DC88', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1627'),
(26, '2025-04-08 11:31:09', '2025-04-08 11:31:09', '1', 'Informática', 'Javier Polo', '10.66.129.71', 'ImpEpsonCalidad', 'EPSONB1DA4C', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1628'),
(27, '2025-04-08 11:33:14', '2025-04-08 11:33:14', '1', 'Interv.A', 'Julio Lora', '10.66.129.72', 'ImpEpsonIntervA', 'EPSONB1D932', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1629'),
(28, '2025-04-08 11:34:13', '2025-04-08 11:34:13', '1', 'Informática', 'Rafa Lora', '10.66.129.74', 'ImpEpsonArchivo', 'EPSONB1DB9D', 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1630'),
(29, '2025-04-08 11:35:46', '2025-04-08 11:35:46', '1', 'Interv.B', 'Miguel Ángel Ortega Pino', '10.66.129.77', 'ImpEpsonCatiP', NULL, 'HR-IL-CO-SGHIE-EPSON_WF-C5790-CO1813'),
(30, '2025-04-08 11:45:05', '2025-04-08 11:45:05', '2', 'Interv. B', NULL, '10.66.129.56', 'ImpHP2-IntervB', 'HP62F269', 'HR-IL-CO-SGHIE-HP_408dn-CO1641'),
(31, '2025-04-08 11:47:38', '2025-04-08 11:47:38', '2', 'Recaudación', 'Antes en Registro', '10.66.129.57', 'ImpHP2-Registro', 'HP62F234', 'HR-IL-CO-SGHIE-HP_408dn-CO1633'),
(32, '2025-04-08 11:48:54', '2025-04-08 11:48:54', '2', 'Tesorería', NULL, '10.66.129.58', 'ImpHP2-Tesoreria', 'HP62F22D', 'HR-IL-CO-SGHIE-HP_408dn-CO1637'),
(33, '2025-04-08 11:51:05', '2025-04-08 11:55:26', '2', 'Secretaría 1', NULL, '10.66.129.59', 'ImpHP2-Secreta1', 'HP62F22E', 'HR-IL-CO-SGHIE-HP_408dn-CO1635'),
(34, '2025-04-08 11:52:15', '2025-04-08 11:52:15', '2', 'Secretaría 2', NULL, '10.66.129.60', 'ImpHP2-Secreta2', 'HP62F0FB', 'HR-IL-CO-SGHIE-HP_408dn-CO1636'),
(35, '2025-04-08 11:53:16', '2025-04-08 11:55:13', '2', 'Secretaría-Indus.', '2ª Planta', '10.66.129.53', 'ImpHP2-Calidad', 'HP62F094', 'HR-IL-CO-SGHIE-HP_408dn-CO1638'),
(36, '2025-04-08 11:57:53', '2025-04-08 11:58:17', '2', 'Inspección', 'Puerta patio', '10.66.129.54', 'ImpHP2-SalaJunt', 'HP62F227', 'HR-IL-CO-SGHIE-HP_408dn-CO1639'),
(37, '2025-04-08 12:01:05', '2025-04-08 12:01:05', '2', 'Interv. A', NULL, '10.66.129.55', 'ImpHP2-IntervA', 'HP62F25F', 'HR-IL-CO-SGHIE-HP_408dn-CO1640'),
(38, '2025-04-08 12:30:38', '2025-04-08 12:30:38', '2', 'Informática', 'CPD', '10.66.129.75', 'ImpHP2-Informat', 'HP62F228', 'HR-IL-CO-SGHIE-HP_408dn-CO1632'),
(39, '2025-04-08 12:32:26', '2025-04-08 12:32:26', '3', 'Interv.B', NULL, '10.66.129.46', 'ImpHP3-IntervB', 'NPI9031EA', 'HR-IL-CO-SGHIE-HP_M527-CO1647'),
(40, '2025-04-09 07:35:34', '2025-04-09 07:35:34', '3', 'Recaudación', 'Antes en Registro', '10.66.129.47', 'ImpHP3-Registro', 'NPID7BF24', 'HR-IL-CO-SGHIE-HP_M527-CO1642'),
(41, '2025-04-09 08:13:07', '2025-04-09 08:13:07', '3', 'Tesorería', NULL, '10.66.129.48', 'ImpHP3-Tesoreria', 'NPID7BF9E', 'HR-IL-CO-SGHIE-HP_M527-CO1643'),
(42, '2025-04-09 08:14:16', '2025-04-09 08:14:16', '3', 'Secretaría', NULL, '10.66.129.49', 'ImpHP3-Secretaria', 'NPID7BF29', 'HR-IL-CO-SGHIE-HP_M527-CO1644'),
(43, '2025-04-09 08:15:29', '2025-04-09 08:15:29', '3', 'Interv. A', NULL, '10.66.129.50', 'ImpHP3-IntervA', 'NPID7BFE9', 'HR-IL-CO-SGHIE-HP_M527-CO1646'),
(44, '2025-04-09 08:17:01', '2025-04-09 08:17:01', '3', 'Valoración', 'Antes en Archivo', '10.66.129.51', 'ImpHP3-Archivo', 'NPID7BF96', 'HR-IL-CO-SGHIE-HP_M527-CO1648');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impresora_historicos`
--

DROP TABLE IF EXISTS `impresora_historicos`;
CREATE TABLE `impresora_historicos` (
  `id` bigint UNSIGNED NOT NULL,
  `impresora_id` bigint UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `paginas` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `impresora_historicos`:
--   `impresora_id`
--       `impresoras` -> `id`
--

--
-- Volcado de datos para la tabla `impresora_historicos`
--

INSERT INTO `impresora_historicos` (`id`, `impresora_id`, `fecha`, `paginas`, `created_at`, `updated_at`) VALUES
(6, 17, '2025-04-09', 6908, '2025-04-09 10:53:55', '2025-04-09 11:36:20'),
(7, 18, '2025-04-09', 13784, '2025-04-09 10:53:55', '2025-04-09 11:36:20'),
(8, 19, '2025-04-09', 12673, '2025-04-09 10:53:55', '2025-04-09 11:36:20'),
(9, 20, '2025-04-09', 0, '2025-04-09 11:17:13', '2025-04-09 11:17:13'),
(10, 21, '2025-04-09', 21847, '2025-04-09 11:17:13', '2025-04-09 11:36:26'),
(11, 22, '2025-04-09', 11174, '2025-04-09 11:17:13', '2025-04-09 11:36:26'),
(12, 23, '2025-04-09', 19365, '2025-04-09 11:17:13', '2025-04-09 11:36:26'),
(13, 24, '2025-04-09', 7665, '2025-04-09 11:17:14', '2025-04-09 11:36:27'),
(14, 25, '2025-04-09', 47118, '2025-04-09 11:17:14', '2025-04-09 11:36:27'),
(15, 26, '2025-04-09', 0, '2025-04-09 11:17:20', '2025-04-09 11:17:20'),
(16, 27, '2025-04-09', 40982, '2025-04-09 11:17:20', '2025-04-09 11:36:33'),
(17, 28, '2025-04-09', 5765, '2025-04-09 11:17:20', '2025-04-09 11:36:33'),
(18, 29, '2025-04-09', 0, '2025-04-09 11:17:26', '2025-04-09 11:17:26'),
(19, 30, '2025-04-09', 176070, '2025-04-09 11:17:26', '2025-04-09 11:36:39'),
(20, 31, '2025-04-09', 39479, '2025-04-09 11:17:27', '2025-04-09 11:36:40'),
(21, 32, '2025-04-09', 21174, '2025-04-09 11:17:28', '2025-04-09 11:36:41'),
(22, 33, '2025-04-09', 85837, '2025-04-09 11:17:28', '2025-04-09 11:36:41'),
(23, 34, '2025-04-09', 53495, '2025-04-09 11:17:29', '2025-04-09 11:36:42'),
(24, 35, '2025-04-09', 51272, '2025-04-09 11:17:29', '2025-04-09 11:36:43'),
(25, 36, '2025-04-09', 41617, '2025-04-09 11:17:30', '2025-04-09 11:36:43'),
(26, 37, '2025-04-09', 70525, '2025-04-09 11:17:31', '2025-04-09 11:36:44'),
(27, 38, '2025-04-09', 0, '2025-04-09 11:17:37', '2025-04-09 11:17:37'),
(28, 39, '2025-04-09', 87057, '2025-04-09 11:17:37', '2025-04-09 11:36:50'),
(29, 40, '2025-04-09', 66748, '2025-04-09 11:17:37', '2025-04-09 11:36:50'),
(30, 41, '2025-04-09', 63766, '2025-04-09 11:17:37', '2025-04-09 11:36:50'),
(31, 42, '2025-04-09', 150339, '2025-04-09 11:17:37', '2025-04-09 11:36:50'),
(32, 43, '2025-04-09', 173728, '2025-04-09 11:17:37', '2025-04-09 11:36:50'),
(33, 44, '2025-04-09', 5779, '2025-04-09 11:17:37', '2025-04-09 11:36:50'),
(34, 17, '2025-04-09', 6908, '2025-04-09 11:20:55', '2025-04-09 11:20:55'),
(35, 17, '2025-04-10', 11000, NULL, '2025-04-09 11:23:44'),
(36, 17, '2025-04-10', 11000, NULL, '2025-04-09 11:24:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `jobs`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `job_batches`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `migrations`:
--

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_01_104310_create_impresoras_table', 2),
(5, '2025_04_01_191250_update_impresoras_table', 3),
(6, '2025_04_01_200859_rename_copias_semana_to_copias_mes', 4),
(7, '2025_04_07_104216_update_impresoras_table', 5),
(8, '2025_04_07_104509_update_impresoras_table', 6),
(9, '2025_04_07_104615_update_impresoras_tab', 7),
(10, '2025_04_08_080523_create_impresions_table', 8),
(11, '2025_04_08_082338_create_impresora_historicos_table', 9),
(12, '2025_04_08_104036_remove_mac_from_impresoras_table', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `password_reset_tokens`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `sessions`:
--

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ZaJ3NTgIaLaLcdwOtC22bK9hcothZ6MiCo58GpsI', NULL, '10.66.128.159', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUtBOUsxRUZDVmNvQ1U4dmt2dmdoU2FWbHExOXU2ajBwWU11Z1B0VSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9pbXByZXNvcmFzLnRlc3QvaW1wcmVzb3Jhcy8xNyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1744200164);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `users`:
--

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pablo', 'pablomerida03@gmail.com', NULL, '$2y$12$mPdPOd4TMsP1Sl8ptuwZyu6rIiEzW6lWKA2wNDvLrGBonWJFuKiTO', NULL, '2025-04-01 08:59:44', '2025-04-01 08:59:44');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `impresoras`
--
ALTER TABLE `impresoras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `impresora_historicos`
--
ALTER TABLE `impresora_historicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `impresora_historicos_impresora_id_foreign` (`impresora_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `impresoras`
--
ALTER TABLE `impresoras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `impresora_historicos`
--
ALTER TABLE `impresora_historicos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `impresora_historicos`
--
ALTER TABLE `impresora_historicos`
  ADD CONSTRAINT `impresora_historicos_impresora_id_foreign` FOREIGN KEY (`impresora_id`) REFERENCES `impresoras` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
