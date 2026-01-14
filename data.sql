-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-01-2026 a las 20:35:51
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
-- Base de datos: `login_php`
--
CREATE DATABASE IF NOT EXISTS `login_php` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `login_php`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user` int(11) NOT NULL,
  `agentid` varchar(5) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user`, `agentid`, `password`, `last_name`, `name`) VALUES
('MK001', 'KureoMad0_!', 'Mado', 'Kureo');

INSERT INTO `users` (`user`, `agentid`, `password`, `last_name`, `name`) VALUES
('TN219', '@tsuri-wLuV33', 'Nori', 'Tsuda');

--
-- Índices para tablas volcadas
--

--
-- Base de datos: `ghoul_system`
--
CREATE DATABASE IF NOT EXISTS `ghoul_system` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `ghoul_system`;


GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, DELETE HISTORY ON login_php.* TO `login-php`@`localhost` IDENTIFIED BY PASSWORD 'CCG_login.php';
--
-- Usuario con acceso a la base de datos
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
