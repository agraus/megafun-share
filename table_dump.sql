-- MySQL dump 10.13  Distrib 8.0.12, for Win64 (x86_64)
--
-- Host: localhost    Database: test
-- ------------------------------------------------------
-- Server version	8.0.12

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `megafun`
--

DROP TABLE IF EXISTS `megafun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `megafun` (
  `file_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orig_name` varchar(180) NOT NULL,
  `name` varchar(40) NOT NULL,
  `path` varchar(100) NOT NULL,
  `preview_path` varchar(100) DEFAULT NULL,
  `mime_type` varchar(80) NOT NULL,
  `metadata` json DEFAULT NULL,
  `upload_date` timestamp NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `megafun`
--

LOCK TABLES `megafun` WRITE;
/*!40000 ALTER TABLE `megafun` DISABLE KEYS */;
INSERT INTO `megafun` VALUES (1,'Konachan.com - 222368 sample.jpg','5265658158','C:\\Apache24\\htdocs\\megafun\\src/../uploads/2018/10/06/','C:\\Apache24\\htdocs\\megafun\\src/../public/previews/2018/10/06/','image/jpeg',NULL,'2018-10-06 16:55:26'),(2,'unins000.dat','4131940230','C:\\Apache24\\htdocs\\megafun\\src/../uploads/2018/10/06/',NULL,'application/octet-stream',NULL,'2018-10-06 16:56:09');
/*!40000 ALTER TABLE `megafun` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-06 19:59:31
