-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: localhost    Database: invef_bd
-- ------------------------------------------------------
-- Server version	8.0.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `almacen`
--

DROP TABLE IF EXISTS `almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `almacen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `almacen`
--

LOCK TABLES `almacen` WRITE;
/*!40000 ALTER TABLE `almacen` DISABLE KEYS */;
INSERT INTO `almacen` VALUES (1,'Almacen Principal','Jr. Sebastian de Aliste 209',NULL,NULL,'1');
/*!40000 ALTER TABLE `almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `casillero`
--

DROP TABLE IF EXISTS `casillero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `casillero` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `detalle` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Stand_id` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_casillero_Stand1_idx` (`Stand_id`),
  CONSTRAINT `fk_casillero_Stand1` FOREIGN KEY (`Stand_id`) REFERENCES `stand` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `casillero`
--

LOCK TABLES `casillero` WRITE;
/*!40000 ALTER TABLE `casillero` DISABLE KEYS */;
INSERT INTO `casillero` VALUES (1,'C1','Casillero 01',NULL,'2019-11-13 05:35:22',1,'0'),(2,'C2','Casillero 02',NULL,'2019-11-14 11:41:02',1,'0'),(3,'C3','Casillero 03',NULL,'2019-11-14 11:50:02',1,'0'),(4,'C4','Casillero 04',NULL,'2019-11-14 12:16:00',1,'0'),(5,'C5','Casillero 05',NULL,'2019-11-14 12:19:34',1,'0'),(6,'C6','Casillero 06',NULL,'2019-11-15 12:17:01',1,'0'),(7,'C1','Casillero 01',NULL,NULL,2,'1'),(8,'C2','Casillero 02',NULL,NULL,2,'1'),(9,'C3','Casillero 03',NULL,NULL,2,'1'),(10,'C4','Casillero 04',NULL,NULL,2,'1'),(11,'C1','Casillero 01',NULL,NULL,3,'1'),(12,'C2','Casillero 02',NULL,NULL,3,'1');
/*!40000 ALTER TABLE `casillero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `dni` char(11) NOT NULL,
  `correo` varchar(250) DEFAULT NULL,
  `direccion` varchar(450) DEFAULT NULL,
  `fecnacimiento` date DEFAULT NULL,
  `edad` varchar(45) DEFAULT NULL,
  `genero` varchar(45) DEFAULT NULL,
  `foto` varchar(450) DEFAULT NULL,
  `facebook` varchar(450) DEFAULT NULL,
  `ingmax` varchar(450) DEFAULT NULL,
  `ingmin` varchar(450) DEFAULT NULL,
  `gasmax` varchar(450) DEFAULT NULL,
  `gasmin` varchar(450) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ocupacion_id` int(11) NOT NULL,
  `recomendacion_id` int(11) NOT NULL,
  `evaluacion` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `whatsapp` varchar(45) DEFAULT NULL,
  `telfreferencia` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_ocupacion1_idx` (`ocupacion_id`),
  KEY `fk_cliente_recomendacion1_idx` (`recomendacion_id`),
  CONSTRAINT `fk_cliente_ocupacion1` FOREIGN KEY (`ocupacion_id`) REFERENCES `ocupacion` (`id`),
  CONSTRAINT `fk_cliente_recomendacion1` FOREIGN KEY (`recomendacion_id`) REFERENCES `recomendacion` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (13,'Maria','Rosales Maguiña','11111111','maria@gmail.com','Hz','1980-12-12','38',NULL,'storage/cliente/11111111/T2A0f6mMXEKormDiK475NPwmKqzMNMY7HRhYd4Xf.png','https://www.facebook.com/','Max.','Min','Max.','Min',1,'2019-11-12 15:07:30','2019-11-12 15:07:30',9,6,'100','944646618','944646618',NULL);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente_telefono`
--

DROP TABLE IF EXISTS `cliente_telefono`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `cliente_telefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `telefono_id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_telefono_telefono1_idx` (`telefono_id`),
  KEY `fk_cliente_telefono_cliente1_idx` (`cliente_id`),
  CONSTRAINT `fk_cliente_telefono_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  CONSTRAINT `fk_cliente_telefono_telefono1` FOREIGN KEY (`telefono_id`) REFERENCES `telefono` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente_telefono`
--

LOCK TABLES `cliente_telefono` WRITE;
/*!40000 ALTER TABLE `cliente_telefono` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente_telefono` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente_user`
--

DROP TABLE IF EXISTS `cliente_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `cliente_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `tipousuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_user_cliente1_idx` (`cliente_id`),
  KEY `fk_cliente_user_users1_idx` (`users_id`),
  KEY `fk_cliente_user_tipousuario1_idx` (`tipousuario_id`),
  CONSTRAINT `fk_cliente_user_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  CONSTRAINT `fk_cliente_user_tipousuario1` FOREIGN KEY (`tipousuario_id`) REFERENCES `tipousuario` (`id`),
  CONSTRAINT `fk_cliente_user_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente_user`
--

LOCK TABLES `cliente_user` WRITE;
/*!40000 ALTER TABLE `cliente_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizacion`
--

DROP TABLE IF EXISTS `cotizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `cotizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `garantia_id` int(11) NOT NULL,
  `max` varchar(45) NOT NULL,
  `min` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado` tinyint(4) NOT NULL,
  `tipoprestamo_id` int(11) NOT NULL,
  `precio` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cotizacion_cliente1_idx` (`cliente_id`),
  KEY `fk_cotizacion_empleado1_idx` (`empleado_id`),
  KEY `fk_cotizacion_garantia1_idx` (`garantia_id`),
  KEY `fk_cotizacion_tipoprestamo1_idx` (`tipoprestamo_id`),
  CONSTRAINT `fk_cotizacion_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  CONSTRAINT `fk_cotizacion_empleado1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id`),
  CONSTRAINT `fk_cotizacion_garantia1` FOREIGN KEY (`garantia_id`) REFERENCES `garantia` (`id`),
  CONSTRAINT `fk_cotizacion_tipoprestamo1` FOREIGN KEY (`tipoprestamo_id`) REFERENCES `tipoprestamo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizacion`
--

LOCK TABLES `cotizacion` WRITE;
/*!40000 ALTER TABLE `cotizacion` DISABLE KEYS */;
INSERT INTO `cotizacion` VALUES (9,13,1,14,'360','100','2019-11-13 05:10:41','2019-11-13 05:35:22',0,1,NULL),(10,13,1,15,'750','100','2019-11-14 11:40:26','2019-11-14 11:41:02',0,1,NULL),(11,13,1,16,'450','100','2019-11-14 11:49:31','2019-11-14 11:50:02',0,1,NULL),(12,13,1,17,'1050','100','2019-11-14 12:15:04','2019-11-14 12:16:00',0,1,NULL),(13,13,1,18,'450','100','2019-11-14 12:19:09','2019-11-14 12:19:34',0,1,NULL);
/*!40000 ALTER TABLE `cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `empleado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `apellido` varchar(250) NOT NULL,
  `dni` char(11) NOT NULL,
  `direccion` varchar(450) DEFAULT NULL,
  `fecnacimiento` date DEFAULT NULL,
  `edad` varchar(45) DEFAULT NULL,
  `genero` varchar(45) DEFAULT NULL,
  `foto` varchar(450) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ocupacion_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empleado_ocupacion1_idx` (`ocupacion_id`),
  CONSTRAINT `fk_empleado_ocupacion1` FOREIGN KEY (`ocupacion_id`) REFERENCES `ocupacion` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado`
--

LOCK TABLES `empleado` WRITE;
/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` VALUES (1,'Pedro','Diaz Siccha','72690062','Psj. Las Dalias 149','1991-05-15','28','Masculino',NULL,1,NULL,NULL,1);
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado_telefono`
--

DROP TABLE IF EXISTS `empleado_telefono`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `empleado_telefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `telefono_id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empleado_telefono_telefono1_idx` (`telefono_id`),
  KEY `fk_empleado_telefono_empleado1_idx` (`empleado_id`),
  CONSTRAINT `fk_empleado_telefono_empleado1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id`),
  CONSTRAINT `fk_empleado_telefono_telefono1` FOREIGN KEY (`telefono_id`) REFERENCES `telefono` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado_telefono`
--

LOCK TABLES `empleado_telefono` WRITE;
/*!40000 ALTER TABLE `empleado_telefono` DISABLE KEYS */;
/*!40000 ALTER TABLE `empleado_telefono` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado_user`
--

DROP TABLE IF EXISTS `empleado_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `empleado_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `tipousuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empleado_user_users1_idx` (`users_id`),
  KEY `fk_empleado_user_empleado1_idx` (`empleado_id`),
  KEY `fk_empleado_user_tipousuario1_idx` (`tipousuario_id`),
  CONSTRAINT `fk_empleado_user_empleado1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id`),
  CONSTRAINT `fk_empleado_user_tipousuario1` FOREIGN KEY (`tipousuario_id`) REFERENCES `tipousuario` (`id`),
  CONSTRAINT `fk_empleado_user_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado_user`
--

LOCK TABLES `empleado_user` WRITE;
/*!40000 ALTER TABLE `empleado_user` DISABLE KEYS */;
INSERT INTO `empleado_user` VALUES (1,1,NULL,NULL,1,1,1);
/*!40000 ALTER TABLE `empleado_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `garantia`
--

DROP TABLE IF EXISTS `garantia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `garantia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `detalle` varchar(450) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipogarantia_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_garantia_tipogarantia1_idx` (`tipogarantia_id`),
  CONSTRAINT `fk_garantia_tipogarantia1` FOREIGN KEY (`tipogarantia_id`) REFERENCES `tipogarantia` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `garantia`
--

LOCK TABLES `garantia` WRITE;
/*!40000 ALTER TABLE `garantia` DISABLE KEYS */;
INSERT INTO `garantia` VALUES (14,'Compac C24','Con Cargador y un pequeño golpe al costado derecho',1,'2019-11-13 05:10:41','2019-11-13 05:10:41',1),(15,'HP 245','Nueva en Caja',1,'2019-11-14 11:40:26','2019-11-14 11:40:26',1),(16,'jjjjj','hjv',1,'2019-11-14 11:49:31','2019-11-14 11:49:31',1),(17,'Asus','bien',1,'2019-11-14 12:15:04','2019-11-14 12:15:04',1),(18,'asda','Bine',1,'2019-11-14 12:19:09','2019-11-14 12:19:09',1);
/*!40000 ALTER TABLE `garantia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interes`
--

DROP TABLE IF EXISTS `interes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `interes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `porcentaje` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interes`
--

LOCK TABLES `interes` WRITE;
/*!40000 ALTER TABLE `interes` DISABLE KEYS */;
INSERT INTO `interes` VALUES (1,'7',NULL,NULL),(2,'10',NULL,NULL),(3,'15',NULL,NULL),(4,'20',NULL,NULL);
/*!40000 ALTER TABLE `interes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mora`
--

DROP TABLE IF EXISTS `mora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `mora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mora`
--

LOCK TABLES `mora` WRITE;
/*!40000 ALTER TABLE `mora` DISABLE KEYS */;
INSERT INTO `mora` VALUES (1,'1',NULL,NULL),(2,'1.5',NULL,NULL),(3,'2',NULL,NULL),(4,'2.5',NULL,NULL);
/*!40000 ALTER TABLE `mora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ocupacion`
--

DROP TABLE IF EXISTS `ocupacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `ocupacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(450) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ocupacion`
--

LOCK TABLES `ocupacion` WRITE;
/*!40000 ALTER TABLE `ocupacion` DISABLE KEYS */;
INSERT INTO `ocupacion` VALUES (1,'Ing. Sistemas e Informática',NULL,NULL),(9,'Ama de casa','2019-11-12 15:07:23','2019-11-12 15:07:23');
/*!40000 ALTER TABLE `ocupacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago`
--

DROP TABLE IF EXISTS `pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monto` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `serie` varchar(45) DEFAULT NULL,
  `prestamo_id` int(11) NOT NULL,
  `tipopago_id` int(11) NOT NULL,
  `tipocomprobante_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pago_prestamo1_idx` (`prestamo_id`),
  KEY `fk_pago_tipopago1_idx` (`tipopago_id`),
  KEY `fk_pago_tipocomprobante1_idx` (`tipocomprobante_id`),
  CONSTRAINT `fk_pago_prestamo1` FOREIGN KEY (`prestamo_id`) REFERENCES `prestamo` (`id`),
  CONSTRAINT `fk_pago_tipocomprobante1` FOREIGN KEY (`tipocomprobante_id`) REFERENCES `tipocomprobante` (`id`),
  CONSTRAINT `fk_pago_tipopago1` FOREIGN KEY (`tipopago_id`) REFERENCES `tipopago` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago`
--

LOCK TABLES `pago` WRITE;
/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
INSERT INTO `pago` VALUES (1,'214','2019-11-14','2019-11-14 11:38:13','2019-11-14 11:38:13','000','000',9,1,1),(2,'600','2019-11-14','2019-11-14 11:44:30','2019-11-14 11:44:30','000','000',10,1,1),(3,'44.94','2019-11-14','2019-11-14 11:45:15','2019-11-14 11:45:15','000','000',10,1,1),(4,'200','2019-11-14','2019-11-14 11:50:30','2019-11-14 11:50:30','000','000',11,1,1),(5,'243.96','2019-11-14','2019-11-14 11:50:58','2019-11-14 11:50:58','000','000',11,1,1),(6,'535','2019-11-14','2019-11-14 12:22:23','2019-11-14 12:22:23','000','000',12,1,1),(7,'28','2019-11-14','2019-11-14 21:16:29','2019-11-14 21:16:29','000','000',13,1,1),(8,'28','2019-11-14','2019-11-14 21:21:38','2019-11-14 21:21:38','000','000',13,1,1),(9,'28','2019-11-14','2019-11-14 21:25:18','2019-11-14 21:25:18','000','000',13,1,1),(10,'1475564','2019-11-14','2019-11-14 21:38:22','2019-11-14 21:38:22','000','000',16,1,1),(11,'1475564','2019-11-14','2019-11-14 21:38:44','2019-11-14 21:38:44','000','000',17,1,1);
/*!40000 ALTER TABLE `pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `precio`
--

DROP TABLE IF EXISTS `precio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `precio` (
  `idprecio` int(11) NOT NULL AUTO_INCREMENT,
  `valor` varchar(45) NOT NULL,
  `detalle` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idprecio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `precio`
--

LOCK TABLES `precio` WRITE;
/*!40000 ALTER TABLE `precio` DISABLE KEYS */;
/*!40000 ALTER TABLE `precio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamo`
--

DROP TABLE IF EXISTS `prestamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `prestamo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monto` varchar(45) NOT NULL,
  `fecinicio` date NOT NULL,
  `fecfin` date NOT NULL,
  `total` varchar(45) NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cotizacion_id` int(11) NOT NULL,
  `casillero_id` int(11) NOT NULL,
  `interes_id` int(11) NOT NULL,
  `mora_id` int(11) NOT NULL,
  `macro` varchar(45) DEFAULT NULL,
  `intpagar` varchar(45) DEFAULT NULL,
  `morapagar` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prestamo_cotizacion1_idx` (`cotizacion_id`),
  KEY `fk_prestamo_casillero1_idx` (`casillero_id`),
  KEY `fk_prestamo_interes1_idx` (`interes_id`),
  KEY `fk_prestamo_mora1_idx` (`mora_id`),
  CONSTRAINT `fk_prestamo_casillero1` FOREIGN KEY (`casillero_id`) REFERENCES `casillero` (`id`),
  CONSTRAINT `fk_prestamo_cotizacion1` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizacion` (`id`),
  CONSTRAINT `fk_prestamo_interes1` FOREIGN KEY (`interes_id`) REFERENCES `interes` (`id`),
  CONSTRAINT `fk_prestamo_mora1` FOREIGN KEY (`mora_id`) REFERENCES `mora` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamo`
--

LOCK TABLES `prestamo` WRITE;
/*!40000 ALTER TABLE `prestamo` DISABLE KEYS */;
INSERT INTO `prestamo` VALUES (9,'200','2019-11-12','2019-12-12','214',0,'2019-11-13 05:35:21','2019-11-14 11:38:12',9,1,4,3,NULL,'14.000000000000002','0'),(10,'42','2019-11-14','2019-12-14','44.94',0,'2019-11-14 11:41:02','2019-11-14 11:45:14',10,2,4,3,NULL,'2.9400000000000004','0'),(11,'228','2019-11-14','2019-12-14','243.96',0,'2019-11-14 11:50:02','2019-11-14 11:50:58',11,3,4,3,NULL,'15.96','0'),(12,'500','2019-11-14','2019-12-14','535',0,'2019-11-14 12:16:00','2019-11-14 12:22:23',12,4,4,3,NULL,'35','0'),(13,'400','2019-11-14','2019-12-14','480',0,'2019-11-14 12:19:34','2019-11-14 21:25:18',13,5,4,3,NULL,NULL,NULL),(14,'400','0000-00-00','0000-00-00','480',0,'2019-11-14 21:16:29','2019-11-14 21:16:29',13,5,4,3,NULL,NULL,NULL),(15,'400','0000-00-00','0000-00-00','480',0,'2019-11-14 21:21:38','2019-11-14 21:21:38',13,5,4,3,NULL,NULL,NULL),(16,'400','0000-00-00','0000-00-00','480',0,'2019-11-14 21:25:18','2019-11-14 21:38:21',13,5,4,3,NULL,NULL,NULL),(17,'400','0000-00-00','0000-00-00','480',0,'2019-11-14 21:38:22','2019-11-14 21:38:44',13,5,4,3,NULL,NULL,NULL),(18,'400','0000-00-00','0000-00-00','480',1,'2019-11-14 21:38:44','2019-11-14 21:38:44',13,5,4,3,NULL,NULL,NULL),(19,'400','2019-11-15','2019-12-15','480',1,'2019-11-15 12:17:00','2019-11-15 12:17:00',13,6,4,3,NULL,NULL,NULL);
/*!40000 ALTER TABLE `prestamo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recomendacion`
--

DROP TABLE IF EXISTS `recomendacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `recomendacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(450) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recomendacion`
--

LOCK TABLES `recomendacion` WRITE;
/*!40000 ALTER TABLE `recomendacion` DISABLE KEYS */;
INSERT INTO `recomendacion` VALUES (6,'Amigos','2019-11-12 15:07:11','2019-11-12 15:07:11');
/*!40000 ALTER TABLE `recomendacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requisitos`
--

DROP TABLE IF EXISTS `requisitos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `requisitos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `detalle` varchar(450) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requisitos`
--

LOCK TABLES `requisitos` WRITE;
/*!40000 ALTER TABLE `requisitos` DISABLE KEYS */;
/*!40000 ALTER TABLE `requisitos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stand`
--

DROP TABLE IF EXISTS `stand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `stand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `detalle` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Almacen_id` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Stand_Almacen1_idx` (`Almacen_id`),
  CONSTRAINT `fk_Stand_Almacen1` FOREIGN KEY (`Almacen_id`) REFERENCES `almacen` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stand`
--

LOCK TABLES `stand` WRITE;
/*!40000 ALTER TABLE `stand` DISABLE KEYS */;
INSERT INTO `stand` VALUES (1,'Stand 1','Articulos Pequeños',NULL,NULL,1,'1'),(2,'Stand 2','Articulos Medianos',NULL,NULL,1,'1'),(3,'Stand 3','Articulos Grandes',NULL,NULL,1,'1');
/*!40000 ALTER TABLE `stand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefono`
--

DROP TABLE IF EXISTS `telefono`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `telefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefono`
--

LOCK TABLES `telefono` WRITE;
/*!40000 ALTER TABLE `telefono` DISABLE KEYS */;
/*!40000 ALTER TABLE `telefono` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipocomprobante`
--

DROP TABLE IF EXISTS `tipocomprobante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tipocomprobante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipocomprobante` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipocomprobante`
--

LOCK TABLES `tipocomprobante` WRITE;
/*!40000 ALTER TABLE `tipocomprobante` DISABLE KEYS */;
INSERT INTO `tipocomprobante` VALUES (1,'Boleta',NULL,NULL);
/*!40000 ALTER TABLE `tipocomprobante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipogarantia`
--

DROP TABLE IF EXISTS `tipogarantia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tipogarantia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `precMax` varchar(45) DEFAULT NULL,
  `precMin` varchar(45) DEFAULT NULL,
  `detalle` varchar(450) DEFAULT NULL,
  `pureza` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipogarantia`
--

LOCK TABLES `tipogarantia` WRITE;
/*!40000 ALTER TABLE `tipogarantia` DISABLE KEYS */;
INSERT INTO `tipogarantia` VALUES (1,'Laptop',NULL,NULL,'1500','100','tp',NULL),(2,'Celular',NULL,NULL,'1000','100','tp',NULL),(3,'Televisor',NULL,NULL,'1200','100','tp',NULL),(4,'Equipo de Sonido',NULL,NULL,'1000','100','tp',NULL),(5,'Oro',NULL,NULL,'159.04','158.54','tj','24K'),(6,'Oro',NULL,NULL,'146.32','145.86','tj','22K'),(7,'Oro',NULL,NULL,'143.09','142.69','tj','21.6K'),(8,'Oro',NULL,NULL,'119.24','118.91','tj','18K'),(9,'Oro',NULL,NULL,'92.21','91.95','tj','14K'),(10,'Oro',NULL,NULL,'79.53','79.27','tj','12K'),(11,'Oro',NULL,NULL,'66.80','66.59','tj','10K'),(12,'Oro',NULL,NULL,'60.44','60.25','tj','9K'),(13,'Oro',NULL,NULL,'52.49','52.32','tj','8K'),(14,'Plata',NULL,NULL,'1.82',NULL,'tj','99,9K'),(15,'Plata',NULL,NULL,'1.74',NULL,'tj','95,8K'),(16,'Plata',NULL,NULL,'1.68',NULL,'tj','92,5K'),(17,'Plata',NULL,NULL,'1.64',NULL,'tj','90K'),(18,'Plata',NULL,NULL,'1.46',NULL,'tj','80K');
/*!40000 ALTER TABLE `tipogarantia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipopago`
--

DROP TABLE IF EXISTS `tipopago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tipopago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipopago` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipopago`
--

LOCK TABLES `tipopago` WRITE;
/*!40000 ALTER TABLE `tipopago` DISABLE KEYS */;
INSERT INTO `tipopago` VALUES (1,'Cancelar',NULL,NULL),(2,'Amortizar',NULL,NULL),(3,'Renovar',NULL,NULL);
/*!40000 ALTER TABLE `tipopago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoprest_requisito`
--

DROP TABLE IF EXISTS `tipoprest_requisito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tipoprest_requisito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `requisitos_id` int(11) NOT NULL,
  `tipoprestamo_id` int(11) NOT NULL,
  `detalle` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tipoprest_requisito_requisitos1_idx` (`requisitos_id`),
  KEY `fk_tipoprest_requisito_tipoprestamo1_idx` (`tipoprestamo_id`),
  CONSTRAINT `fk_tipoprest_requisito_requisitos1` FOREIGN KEY (`requisitos_id`) REFERENCES `requisitos` (`id`),
  CONSTRAINT `fk_tipoprest_requisito_tipoprestamo1` FOREIGN KEY (`tipoprestamo_id`) REFERENCES `tipoprestamo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoprest_requisito`
--

LOCK TABLES `tipoprest_requisito` WRITE;
/*!40000 ALTER TABLE `tipoprest_requisito` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipoprest_requisito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoprestamo`
--

DROP TABLE IF EXISTS `tipoprestamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tipoprestamo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `detalle` varchar(450) DEFAULT NULL,
  `imagen` varchar(450) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoprestamo`
--

LOCK TABLES `tipoprestamo` WRITE;
/*!40000 ALTER TABLE `tipoprestamo` DISABLE KEYS */;
INSERT INTO `tipoprestamo` VALUES (1,'Credito Prendario',NULL,NULL,NULL,NULL),(2,'Credito Joyas',NULL,NULL,NULL,NULL),(3,'Credito Universitario',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tipoprestamo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipotelefono`
--

DROP TABLE IF EXISTS `tipotelefono`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tipotelefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(450) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `telefono_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tipotelefono_telefono1_idx` (`telefono_id`),
  CONSTRAINT `fk_tipotelefono_telefono1` FOREIGN KEY (`telefono_id`) REFERENCES `telefono` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipotelefono`
--

LOCK TABLES `tipotelefono` WRITE;
/*!40000 ALTER TABLE `tipotelefono` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipotelefono` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tipousuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `nivel` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipousuario`
--

LOCK TABLES `tipousuario` WRITE;
/*!40000 ALTER TABLE `tipousuario` DISABLE KEYS */;
INSERT INTO `tipousuario` VALUES (1,'Administrador','1',NULL,NULL);
/*!40000 ALTER TABLE `tipousuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(450) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$2S5CsDnTpb7KJRGlnrxVI.MPOEt3jv.qbMqHIycYqKx9bDdFUpudu','admin@invef.com',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-15  7:51:23
