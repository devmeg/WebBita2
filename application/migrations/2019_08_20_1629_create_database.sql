CREATE DATABASE `webbita2` /*!40100 COLLATE 'utf8_general_ci' */;
USE `webbita2`;
-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 04-08-2019 a las 21:59:13
-- Versión del servidor: 5.7.25
-- Versión de PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `bitacora_viaje`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistentes`
--

CREATE TABLE `asistentes` (
  `id_asistente` int(11) NOT NULL,
  `id_delegacion` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `rut` varchar(45) NOT NULL,
  `edad` int(11) NOT NULL,
  `club` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `delegaciones`
--

CREATE TABLE `delegaciones` (
  `id_delegacion` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `itinerario` longtext,
  `informacion` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `delegaciones`
--

INSERT INTO `delegaciones` (`id_delegacion`, `nombre`, `itinerario`, `informacion`) VALUES
(1, 'UNAB', 'abc\nbla bla', 'Info extra'),
(2, 'Viña del Mar', 'Itinerario', 'info extra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `delegacion_transporte`
--

CREATE TABLE `delegacion_transporte` (
  `id_medio_transporte` int(11) NOT NULL,
  `id_delegacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `delegados_comunicaciones`
--

CREATE TABLE `delegados_comunicaciones` (
  `id_usuario` int(11) NOT NULL,
  `id_delegacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `delegados_comunicaciones`
--

INSERT INTO `delegados_comunicaciones` (`id_usuario`, `id_delegacion`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinatarios_ext`
--

CREATE TABLE `destinatarios_ext` (
  `id_destinatarios_ext` int(11) NOT NULL,
  `id_delegacion` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_viaje`
--

CREATE TABLE `estados_viaje` (
  `id_estados_viaje` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estados_viaje`
--

INSERT INTO `estados_viaje` (`id_estados_viaje`, `nombre`) VALUES
(1, 'En ruta'),
(2, 'Parada para comer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_estado`
--

CREATE TABLE `historial_estado` (
  `id_estados_viaje` int(11) NOT NULL,
  `id_delegacion` int(11) NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historial_estado`
--

INSERT INTO `historial_estado` (`id_estados_viaje`, `id_delegacion`, `fecha_modificacion`) VALUES
(1, 1, '2019-08-04 21:29:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hitos`
--

CREATE TABLE `hitos` (
  `id_hito` int(11) NOT NULL,
  `id_delegacion` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `lugar` varchar(45) NOT NULL,
  `mensaje` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `latitud` varchar(100) NOT NULL,
  `longitud` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `hitos`
--

INSERT INTO `hitos` (`id_hito`, `id_delegacion`, `usuario`, `lugar`, `mensaje`, `fecha`, `latitud`, `longitud`) VALUES
(1, 2, 'jalberto', 'casa', 'Prueba', '2019-01-01', '-33.024129', '-71.551109'),
(2, 2, 'jalberto', 'copec', 'Prueba 2', '2019-08-04', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medio_transporte`
--

CREATE TABLE `medio_transporte` (
  `id_medio_transporte` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `medio_transporte`
--

INSERT INTO `medio_transporte` (`id_medio_transporte`, `nombre`) VALUES
(1, 'Auto'),
(2, 'Avion'),
(4, 'Bus');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id_usuario_para` int(11) NOT NULL,
  `id_usuario_de` int(11) NOT NULL,
  `estado_lectura` int(11) NOT NULL,
  `mensaje` varchar(250) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id_usuario_para`, `id_usuario_de`, `estado_lectura`, `mensaje`, `fecha`) VALUES
(2, 1, 1, 'Hola Juan!', '2019-08-04 21:33:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_perfil`
--

CREATE TABLE `t_perfil` (
  `id_perfil` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_perfil`
--

INSERT INTO `t_perfil` (`id_perfil`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Viajero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `edad` int(11) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_perfil`, `nombre_completo`, `edad`, `correo`, `usuario`, `password`) VALUES
(1, 1, 'Administración central', 99, 'admin@admin.cl', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997'),
(2, 2, 'Juan Alberto Nuñez', 32, 'jalberto@mail.com', 'jalberto', 'd033e22ae348aeb5660fc2140aec35850c4da997');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  ADD PRIMARY KEY (`id_asistente`),
  ADD KEY `fk_asistentes_delegaciones1_idx` (`id_delegacion`);

--
-- Indices de la tabla `delegaciones`
--
ALTER TABLE `delegaciones`
  ADD PRIMARY KEY (`id_delegacion`);

--
-- Indices de la tabla `delegacion_transporte`
--
ALTER TABLE `delegacion_transporte`
  ADD PRIMARY KEY (`id_medio_transporte`,`id_delegacion`),
  ADD KEY `fk_medio_transporte_has_delegaciones_delegaciones1_idx` (`id_delegacion`),
  ADD KEY `fk_medio_transporte_has_delegaciones_medio_transporte1_idx` (`id_medio_transporte`);

--
-- Indices de la tabla `delegados_comunicaciones`
--
ALTER TABLE `delegados_comunicaciones`
  ADD PRIMARY KEY (`id_usuario`,`id_delegacion`),
  ADD KEY `fk_usuario_has_delegaciones_delegaciones1_idx` (`id_delegacion`),
  ADD KEY `fk_usuario_has_delegaciones_usuario_idx` (`id_usuario`);

--
-- Indices de la tabla `destinatarios_ext`
--
ALTER TABLE `destinatarios_ext`
  ADD PRIMARY KEY (`id_destinatarios_ext`),
  ADD KEY `fk_destinatarios_ext_delegaciones1_idx` (`id_delegacion`);

--
-- Indices de la tabla `estados_viaje`
--
ALTER TABLE `estados_viaje`
  ADD PRIMARY KEY (`id_estados_viaje`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_evento`);

--
-- Indices de la tabla `historial_estado`
--
ALTER TABLE `historial_estado`
  ADD PRIMARY KEY (`id_estados_viaje`,`id_delegacion`),
  ADD KEY `fk_estados_viaje_has_delegaciones_delegaciones1_idx` (`id_delegacion`),
  ADD KEY `fk_estados_viaje_has_delegaciones_estados_viaje1_idx` (`id_estados_viaje`);

--
-- Indices de la tabla `hitos`
--
ALTER TABLE `hitos`
  ADD PRIMARY KEY (`id_hito`),
  ADD KEY `fk_hitos_delegaciones1_idx` (`id_delegacion`);

--
-- Indices de la tabla `medio_transporte`
--
ALTER TABLE `medio_transporte`
  ADD PRIMARY KEY (`id_medio_transporte`);

--
-- Indices de la tabla `t_perfil`
--
ALTER TABLE `t_perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_usuario_t_perfil1_idx` (`id_perfil`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  MODIFY `id_asistente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `delegaciones`
--
ALTER TABLE `delegaciones`
  MODIFY `id_delegacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `destinatarios_ext`
--
ALTER TABLE `destinatarios_ext`
  MODIFY `id_destinatarios_ext` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estados_viaje`
--
ALTER TABLE `estados_viaje`
  MODIFY `id_estados_viaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hitos`
--
ALTER TABLE `hitos`
  MODIFY `id_hito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `medio_transporte`
--
ALTER TABLE `medio_transporte`
  MODIFY `id_medio_transporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `t_perfil`
--
ALTER TABLE `t_perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistentes`
--
ALTER TABLE `asistentes`
  ADD CONSTRAINT `fk_asistentes_delegaciones1` FOREIGN KEY (`id_delegacion`) REFERENCES `delegaciones` (`id_delegacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `delegacion_transporte`
--
ALTER TABLE `delegacion_transporte`
  ADD CONSTRAINT `fk_medio_transporte_has_delegaciones_delegaciones1` FOREIGN KEY (`id_delegacion`) REFERENCES `delegaciones` (`id_delegacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_medio_transporte_has_delegaciones_medio_transporte1` FOREIGN KEY (`id_medio_transporte`) REFERENCES `medio_transporte` (`id_medio_transporte`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `delegados_comunicaciones`
--
ALTER TABLE `delegados_comunicaciones`
  ADD CONSTRAINT `fk_usuario_has_delegaciones_delegaciones1` FOREIGN KEY (`id_delegacion`) REFERENCES `delegaciones` (`id_delegacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_has_delegaciones_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `destinatarios_ext`
--
ALTER TABLE `destinatarios_ext`
  ADD CONSTRAINT `fk_destinatarios_ext_delegaciones1` FOREIGN KEY (`id_delegacion`) REFERENCES `delegaciones` (`id_delegacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historial_estado`
--
ALTER TABLE `historial_estado`
  ADD CONSTRAINT `fk_estados_viaje_has_delegaciones_delegaciones1` FOREIGN KEY (`id_delegacion`) REFERENCES `delegaciones` (`id_delegacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estados_viaje_has_delegaciones_estados_viaje1` FOREIGN KEY (`id_estados_viaje`) REFERENCES `estados_viaje` (`id_estados_viaje`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `hitos`
--
ALTER TABLE `hitos`
  ADD CONSTRAINT `fk_hitos_delegaciones1` FOREIGN KEY (`id_delegacion`) REFERENCES `delegaciones` (`id_delegacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_t_perfil1` FOREIGN KEY (`id_perfil`) REFERENCES `t_perfil` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Registrar migracion
--
INSERT INTO `migrations` (`migration`) 
  VALUES ('2019_08_20_1629_create_database');