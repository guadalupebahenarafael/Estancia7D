

DROP TABLE IF EXISTS `administrador`;

CREATE TABLE `administrador` (
  `ID_Administrador` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `paterno` varchar(60) NOT NULL,
  `materno` varchar(60) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fechaNac` date DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `Rol` varchar(100) DEFAULT 'administrador',
  `session_token` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`ID_Administrador`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO administrador VALUES("5","A001","Fernando","Guadalupe","Alarcón","7771234567","1990-05-12","administrador","administrador","");
INSERT INTO administrador VALUES("6","Admin123","maria","perez","camacho","5554521984","2000-02-14","qqqq","administrador","");
INSERT INTO administrador VALUES("7","A002","rafael","guadalupe","bahena","2222222222","2000-10-20","ssss","administrador","");





DROP TABLE IF EXISTS `alumno`;

CREATE TABLE `alumno` (
  `ID_Alumno` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `paterno` varchar(60) NOT NULL,
  `materno` varchar(60) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fechaNac` date DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `ID_Programa` int(11) DEFAULT NULL,
  `rol` varchar(100) DEFAULT 'alumno',
  `session_token` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`ID_Alumno`),
  KEY `ID_Programa` (`ID_Programa`),
  CONSTRAINT `fk_alumno_programa` FOREIGN KEY (`ID_Programa`) REFERENCES `programa` (`ID_Programa`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO alumno VALUES("24","Alum8","maria","guadalupe","morales","7772028485","2004-07-16","gbro","8","alumno","");
INSERT INTO alumno VALUES("26","A002","rafael","guadalupe","bahena","7777777777","2000-02-10","aaaaaaaaaa","8","alumno","");





DROP TABLE IF EXISTS `area`;

CREATE TABLE `area` (
  `ID_Area` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `salon` int(11) DEFAULT NULL,
  `laboratorio` int(11) DEFAULT NULL,
  `piso` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Area`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO area VALUES("13","UD1","10","2","2");





DROP TABLE IF EXISTS `aviso`;

CREATE TABLE `aviso` (
  `ID_Aviso` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Objeto` int(11) DEFAULT NULL,
  `ID_Area` int(11) DEFAULT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`ID_Aviso`),
  KEY `ID_Objeto` (`ID_Objeto`),
  KEY `ID_Area` (`ID_Area`),
  CONSTRAINT `fk_aviso_area` FOREIGN KEY (`ID_Area`) REFERENCES `area` (`ID_Area`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_aviso_objeto` FOREIGN KEY (`ID_Objeto`) REFERENCES `objeto` (`ID_Objeto`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO aviso VALUES("7","10","13","Color azul, con funda color negro");
INSERT INTO aviso VALUES("9","10","13","aaaaaa");





DROP TABLE IF EXISTS `coordinador`;

CREATE TABLE `coordinador` (
  `ID_Coordinador` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `paterno` varchar(60) NOT NULL,
  `materno` varchar(60) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fechaNac` date DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `rol` varchar(100) DEFAULT 'coordinador',
  `session_token` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`ID_Coordinador`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO coordinador VALUES("9","A002","rafael","guadalupe","bahena","7779970336","2000-02-10","pppp","coordinador","");
INSERT INTO coordinador VALUES("10","A002","rafael","guadalupe","bahena","7779970336","2000-02-10","aaaa","coordinador","");





DROP TABLE IF EXISTS `objeto`;

CREATE TABLE `objeto` (
  `ID_Objeto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `categoria` varchar(250) DEFAULT NULL,
  `ID_Area` int(11) DEFAULT NULL,
  `recuperado` varchar(250) DEFAULT 'no',
  `caracteristicas` text DEFAULT NULL,
  `marca` varchar(250) DEFAULT 'sin marca',
  `genero` varchar(100) NOT NULL DEFAULT 'indefinido',
  PRIMARY KEY (`ID_Objeto`),
  KEY `ID_Area` (`ID_Area`),
  CONSTRAINT `fk_objeto_area` FOREIGN KEY (`ID_Area`) REFERENCES `area` (`ID_Area`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO objeto VALUES("10","iphone 13","Electronica","13","si","color verde con negro","apple","Hombre");
INSERT INTO objeto VALUES("14","telefono","Electronica","13","no","aa","applessss","M");





DROP TABLE IF EXISTS `programa`;

CREATE TABLE `programa` (
  `ID_Programa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `vigencia` date DEFAULT NULL,
  `certificaciones` varchar(255) DEFAULT NULL,
  `nivel` varchar(50) DEFAULT NULL,
  `ID_Area` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Programa`),
  KEY `ID_Area` (`ID_Area`),
  CONSTRAINT `fk_programa_area` FOREIGN KEY (`ID_Area`) REFERENCES `area` (`ID_Area`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO programa VALUES("8","(IIN)","2020-01-10","EC0772","maestria","13");



