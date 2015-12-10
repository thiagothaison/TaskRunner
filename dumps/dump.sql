CREATE DATABASE  IF NOT EXISTS `task_runner` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `task_runner`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: task_runner
-- ------------------------------------------------------
-- Server version	5.6.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `robo_agenda`
--

DROP TABLE IF EXISTS `robo_agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `robo_agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) DEFAULT NULL,
  `id_servidor_execucao` int(11) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `descricao` text,
  `tipo` tinyint(1) DEFAULT '0' COMMENT '0-FILE, 1-URL',
  `cron` varchar(255) DEFAULT NULL,
  `exec` varchar(1024) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT '1' COMMENT '1-Sim, 0-Não',
  `data_criacao` datetime DEFAULT NULL,
  `ultima_execucao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_robo_grupo_idx` (`id_grupo`),
  KEY `fk_robo_servidor_execucao_idx` (`id_servidor_execucao`),
  CONSTRAINT `fk_robo_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `robo_grupos` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_robo_servidor_execucao` FOREIGN KEY (`id_servidor_execucao`) REFERENCES `robo_server_exec` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `robo_agenda`
--

LOCK TABLES `robo_agenda` WRITE;
/*!40000 ALTER TABLE `robo_agenda` DISABLE KEYS */;
INSERT INTO `robo_agenda` VALUES (3,2,NULL,'Teste','Teste',0,'*/5 * * * * *','notepad.exe',0,'2015-11-06 14:12:59',NULL),(5,8,NULL,'teste','teste',0,'*/10 * * * * *','teste',0,'2015-11-06 13:01:56',NULL),(6,NULL,NULL,'Teste URL','Teste URL',1,'*/5 * * * * *','http://embboa16.bot.emb/portal_sistemas_2.0/logs/inserir?t=4&m=Silvio Santos Vem ai, Olê olê olá',1,'2015-12-10 17:26:48','2015-12-10 17:26:56'),(7,NULL,1,'Teste de Interface','Teste de Interface',0,'*/15 * * * * *','notepad.exe',1,'2015-11-11 12:45:22','2015-11-13 10:08:36');
/*!40000 ALTER TABLE `robo_agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `robo_config`
--

DROP TABLE IF EXISTS `robo_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `robo_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) NOT NULL,
  `port` varchar(5) NOT NULL,
  `path` varchar(255) NOT NULL,
  `file` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `robo_config`
--

LOCK TABLES `robo_config` WRITE;
/*!40000 ALTER TABLE `robo_config` DISABLE KEYS */;
INSERT INTO `robo_config` VALUES (1,'localhost','3001','C:\\Users\\ttpinto\\Documents\\NodeJS','cron.js');
/*!40000 ALTER TABLE `robo_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `robo_grupos`
--

DROP TABLE IF EXISTS `robo_grupos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `robo_grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `observacoes` text,
  `ativo` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0-Não, 1-Sim',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `robo_grupos`
--

LOCK TABLES `robo_grupos` WRITE;
/*!40000 ALTER TABLE `robo_grupos` DISABLE KEYS */;
INSERT INTO `robo_grupos` VALUES (1,'Interfaces','Quisque velit nisi, pretium ut lacinia in, elementum id enim. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Nulla quis lorem ut libero malesuada feugiat. Pellentesque in ipsum id orci porta dapibus. Sed porttitor lectus nibh. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Pellentesque in ipsum id orci porta dapibus.',1),(2,'Aquisi Maq',NULL,1),(8,'Teste','',0);
/*!40000 ALTER TABLE `robo_grupos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `robo_server_exec`
--

DROP TABLE IF EXISTS `robo_server_exec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `robo_server_exec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `host` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `observacoes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `robo_server_exec`
--

LOCK TABLES `robo_server_exec` WRITE;
/*!40000 ALTER TABLE `robo_server_exec` DISABLE KEYS */;
INSERT INTO `robo_server_exec` VALUES (1,'PC02','\\\\pc02','BOTDOMAIN\\Agendamento','AgendInf01','Servidor de Execução de Interfaces');
/*!40000 ALTER TABLE `robo_server_exec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'task_runner'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-10 14:28:03
