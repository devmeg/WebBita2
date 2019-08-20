USE `webbita2`;

ALTER TABLE `asistentes` DROP `edad`;

ALTER TABLE `asistentes` ADD `fecha_nacimiento` DATE NULL AFTER `rut`;

INSERT INTO `migrations` (`migration`) 
  VALUES ('2019_08_20_1708_alter_table_asistentes');