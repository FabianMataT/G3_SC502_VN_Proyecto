-- g3_sc502_vn_pproyecto.fide_tab_estado definition

CREATE TABLE `fide_tab_estado` (
  `ID_ESTADO` int NOT NULL AUTO_INCREMENT,
  `ESTADO` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_ESTADO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- g3_sc502_vn_pproyecto.fide_tab_provincia definition

CREATE TABLE `fide_tab_provincia` (
  `COD_PROVINCIA` int NOT NULL AUTO_INCREMENT,
  `PROVINCIA` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`COD_PROVINCIA`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- g3_sc502_vn_pproyecto.fide_tab_rol definition

CREATE TABLE `fide_tab_rol` (
  `ID_ROL` int NOT NULL AUTO_INCREMENT,
  `NOMBRE_ROL` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_ROL`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- g3_sc502_vn_pproyecto.fide_tab_canton definition

CREATE TABLE `fide_tab_canton` (
  `COD_CANTON` int NOT NULL AUTO_INCREMENT,
  `COD_PROVINCIA` int DEFAULT NULL,
  `CANTON` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`COD_CANTON`),
  KEY `FK_COD_PROVINCIA` (`COD_PROVINCIA`),
  CONSTRAINT `fide_tab_canton_ibfk_1` FOREIGN KEY (`COD_PROVINCIA`) REFERENCES `fide_tab_provincia` (`COD_PROVINCIA`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- g3_sc502_vn_pproyecto.fide_tab_distrito definition

CREATE TABLE `fide_tab_distrito` (
  `COD_DISTRITO` int NOT NULL AUTO_INCREMENT,
  `COD_PROVINCIA` int DEFAULT NULL,
  `COD_CANTON` int DEFAULT NULL,
  `DISTRITO` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`COD_DISTRITO`),
  KEY `FK_COD_PROVINCIA` (`COD_PROVINCIA`),
  KEY `FK_COD_CANTON` (`COD_CANTON`),
  CONSTRAINT `fide_tab_distrito_ibfk_1` FOREIGN KEY (`COD_PROVINCIA`) REFERENCES `fide_tab_provincia` (`COD_PROVINCIA`),
  CONSTRAINT `fide_tab_distrito_ibfk_2` FOREIGN KEY (`COD_CANTON`) REFERENCES `fide_tab_canton` (`COD_CANTON`)
) ENGINE=InnoDB AUTO_INCREMENT=488 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- g3_sc502_vn_pproyecto.fide_tab_ubicacion definition

CREATE TABLE `fide_tab_ubicacion` (
  `ID_UBICACION` int NOT NULL AUTO_INCREMENT,
  `COD_PROVINCIA` int DEFAULT NULL,
  `COD_CANTON` int DEFAULT NULL,
  `COD_DISTRITO` int DEFAULT NULL,
  `OTRAS_SENAS` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ID_UBICACION`),
  KEY `FK_COD_PROVINCIA` (`COD_PROVINCIA`),
  KEY `FK_COD_CANTON` (`COD_CANTON`),
  KEY `FK_COD_DISTRITO` (`COD_DISTRITO`),
  CONSTRAINT `fide_tab_ubicacion_ibfk_1` FOREIGN KEY (`COD_PROVINCIA`) REFERENCES `fide_tab_provincia` (`COD_PROVINCIA`),
  CONSTRAINT `fide_tab_ubicacion_ibfk_2` FOREIGN KEY (`COD_CANTON`) REFERENCES `fide_tab_canton` (`COD_CANTON`),
  CONSTRAINT `fide_tab_ubicacion_ibfk_3` FOREIGN KEY (`COD_DISTRITO`) REFERENCES `fide_tab_distrito` (`COD_DISTRITO`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- g3_sc502_vn_pproyecto.fide_tab_usuario definition

CREATE TABLE `fide_tab_usuario` (
  `ID_USUARIO` int NOT NULL AUTO_INCREMENT,
  `ID_ROL` int DEFAULT NULL,
  `NOMBRE_USUARIO` varchar(50) DEFAULT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `APELLIDO1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `APELLIDO2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `TELEFONO` int DEFAULT NULL,
  `CORREO` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `CONTRASENA` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ESTADO` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID_USUARIO`),
  KEY `FK_ID_ROL` (`ID_ROL`),
  CONSTRAINT `fide_tab_usuario_ibfk_1` FOREIGN KEY (`ID_ROL`) REFERENCES `fide_tab_rol` (`ID_ROL`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- g3_sc502_vn_pproyecto.fide_tab_carnet definition

CREATE TABLE `fide_tab_carnet` (
  `ID_CARNET` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int DEFAULT NULL,
  `ID_ESTADO` int DEFAULT NULL,
  `NOMBRE_ANIMAL` varchar(50) DEFAULT NULL,
  `RAZA` varchar(50) DEFAULT NULL,
  `FECHA_RESCATE` date NOT NULL,
  `DESCRIPCION` varchar(800) DEFAULT NULL,
  `IMAGEN` varchar(800) NOT NULL,
  PRIMARY KEY (`ID_CARNET`),
  KEY `fide_tab_carnet_ibfk_2` (`ID_ESTADO`),
  KEY `fide_tab_carnet_ibfk_1` (`ID_USUARIO`),
  CONSTRAINT `fide_tab_carnet_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `fide_tab_usuario` (`ID_USUARIO`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fide_tab_carnet_ibfk_2` FOREIGN KEY (`ID_ESTADO`) REFERENCES `fide_tab_estado` (`ID_ESTADO`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- g3_sc502_vn_pproyecto.fide_tab_donacion definition

CREATE TABLE `fide_tab_donacion` (
  `ID_DONACION` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int DEFAULT NULL,
  `LINK_COMPROBANTE` varchar(800) DEFAULT NULL,
  PRIMARY KEY (`ID_DONACION`),
  KEY `fide_tab_donacion_ibfk_1` (`ID_USUARIO`),
  CONSTRAINT `fide_tab_donacion_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `fide_tab_usuario` (`ID_USUARIO`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- g3_sc502_vn_pproyecto.fide_tab_productos definition

CREATE TABLE `fide_tab_productos` (
  `ID_PRODUCTO` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int DEFAULT NULL,
  `TITULO_PUBLI` varchar(50) DEFAULT NULL,
  `DESCRIPCION` varchar(800) DEFAULT NULL,
  `IMAGEN` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`ID_PRODUCTO`),
  KEY `fide_tab_productos_ibfk_1` (`ID_USUARIO`),
  CONSTRAINT `fide_tab_productos_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `fide_tab_usuario` (`ID_USUARIO`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- g3_sc502_vn_pproyecto.fide_tab_profecional definition

CREATE TABLE `fide_tab_profecional` (
  `ID_PROFECIONAL` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int DEFAULT NULL,
  `ID_UBICACION` int DEFAULT NULL,
  `EMPRESA` varchar(50) DEFAULT NULL,
  `MOTIVO_PERFIL` varchar(700) DEFAULT NULL,
  `COMPROBANTE_SINPE` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`ID_PROFECIONAL`),
  KEY `FK_ID_UBICACION` (`ID_UBICACION`),
  KEY `fide_tab_profecional_ibfk_1` (`ID_USUARIO`),
  CONSTRAINT `fide_tab_profecional_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `fide_tab_usuario` (`ID_USUARIO`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fide_tab_profecional_ibfk_2` FOREIGN KEY (`ID_UBICACION`) REFERENCES `fide_tab_ubicacion` (`ID_UBICACION`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- g3_sc502_vn_pproyecto.fide_tab_adopcion definition

CREATE TABLE `fide_tab_adopcion` (
  `ID_ADOPCION` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int DEFAULT NULL,
  `ID_CARNET` int DEFAULT NULL,
  `NOMBRE_USUARIO` varchar(50) DEFAULT NULL,
  `NUM_TELEFONO` int DEFAULT NULL,
  `CORREO` varchar(30) DEFAULT NULL,
  `MENSAJE` varchar(800) DEFAULT NULL,
  PRIMARY KEY (`ID_ADOPCION`),
  KEY `fide_tab_adopcion_ibfk_1` (`ID_USUARIO`),
  KEY `fide_tab_adopcion_ibfk_2` (`ID_CARNET`),
  CONSTRAINT `fide_tab_adopcion_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `fide_tab_usuario` (`ID_USUARIO`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fide_tab_adopcion_ibfk_2` FOREIGN KEY (`ID_CARNET`) REFERENCES `fide_tab_carnet` (`ID_CARNET`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;