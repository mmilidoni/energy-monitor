-- MySQL dump 10.13  Distrib 5.1.73, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: c1zenit_energy
-- ------------------------------------------------------
-- Server version	5.1.73-0ubuntu0.10.04.1

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
-- Table structure for table `etichette`
--

DROP TABLE IF EXISTS `etichette`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etichette` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codice` varchar(32) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `posizione` int(11) NOT NULL DEFAULT '0',
  `aggregazione` varchar(10) NOT NULL DEFAULT 'SUM',
  `unita_misura` varchar(255) NOT NULL,
  `descrizione` text NOT NULL,
  `moltiplicatore` double NOT NULL DEFAULT '1',
  `storico` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `etichette_impianto`
--

DROP TABLE IF EXISTS `etichette_impianto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etichette_impianto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tabella` tinyint(1) NOT NULL DEFAULT '1',
  `grafico` tinyint(1) NOT NULL,
  `impianto_id` int(11) NOT NULL,
  `etichetta_id` int(11) NOT NULL,
  `nome_gruppo` varchar(16) NOT NULL DEFAULT 'Gruppo',
  `tabella_homepage` int(11) NOT NULL DEFAULT '1',
  `grafico_homepage` int(11) NOT NULL DEFAULT '0',
  `calcolo_inizio_giornata` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `impianto_id` (`impianto_id`),
  KEY `etichetta_id` (`etichetta_id`),
  CONSTRAINT `etichette_impianto_ibfk_1` FOREIGN KEY (`impianto_id`) REFERENCES `impianti` (`id`),
  CONSTRAINT `etichette_impianto_ibfk_2` FOREIGN KEY (`etichetta_id`) REFERENCES `etichette` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `impianti`
--

DROP TABLE IF EXISTS `impianti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `impianti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `citta` varchar(255) NOT NULL,
  `provincia` varchar(2) NOT NULL,
  `titolare` varchar(255) NOT NULL,
  `admin` int(11) NOT NULL,
  `produzione_presunta` float NOT NULL DEFAULT '0',
  `manutenzione_ragione_sociale` varchar(255) NOT NULL,
  `manutenzione_telefono` varchar(255) NOT NULL,
  `manutenzione_email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `valori`
--

DROP TABLE IF EXISTS `valori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valori` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `data_ora` datetime NOT NULL,
  `valore` float NOT NULL,
  `etichetta_impianto_id` int(11) NOT NULL,
  `gruppo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `etichetta_impianto_id` (`etichetta_impianto_id`),
  CONSTRAINT `valori_ibfk_1` FOREIGN KEY (`etichetta_impianto_id`) REFERENCES `etichette_impianto` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32757 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-19 15:41:32
