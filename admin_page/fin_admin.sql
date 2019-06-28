CREATE DATABASE  IF NOT EXISTS `nulovepoplatky_cz_poplatky` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci */;
USE `nulovepoplatky_cz_poplatky`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: poplatky
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `banky`
--

DROP TABLE IF EXISTS `banky`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banky` (
  `kod_banky` char(4) COLLATE utf8_czech_ci NOT NULL,
  `nazev_banky` varchar(55) COLLATE utf8_czech_ci DEFAULT NULL,
  `klientu` int(10) unsigned DEFAULT NULL,
  `klientu_datum` date DEFAULT NULL,
  `bankomaty` int(10) unsigned DEFAULT NULL,
  `bankomaty_datum` date DEFAULT NULL,
  `bankomaty_pozn` text COLLATE utf8_czech_ci,
  PRIMARY KEY (`kod_banky`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banky`
--

LOCK TABLES `banky` WRITE;
/*!40000 ALTER TABLE `banky` DISABLE KEYS */;
INSERT INTO `banky` VALUES ('0100','Komerční banka',1600000,'2011-12-31',699,'2012-11-21',NULL),('0300','ČSOB / Poštovní spořitelna',3100000,'2012-05-22',855,'2012-11-21',NULL),('0600','GE Money Bank',1051000,'2012-06-30',695,'2012-11-21',NULL),('0800','Česká spořitelna',5217326,'2012-03-01',1440,'2012-11-21',NULL),('2010','Fio banka',250000,'2013-03-12',117,'2012-11-21',NULL),('2230','AXA Bank Europe',0,NULL,0,'2012-11-21',NULL),('2310','Zuno bank',100000,'2012-06-20',0,'2012-11-21','+vyuziva bankomaty Raiffeisen bank'),('2600','Citibank Europe',16000,'2010-06-16',144,'2012-11-21',NULL),('2700','UniCredit Bank',200000,'2010-09-30',147,'2012-11-21',NULL),('3030','Air bank',100000,'2013-02-26',18,'2012-11-21',NULL),('3500','ING Bank',0,NULL,0,'2012-11-21',NULL),('4000','LBBW Bank',10000,NULL,0,'2010-01-28',NULL),('5500','Raiffeisenbank',500000,'2011-11-02',128,'2012-11-21',NULL),('6100','Equa bank',30000,'2012-12-14',0,'2012-11-21',NULL),('6210','BRE Bank (mBank)',400000,'2012-07-17',0,'2012-11-21',NULL),('6800','Sperbank',63000,'2010-12-31',27,'2012-11-21',NULL),('7940','Waldviertler Sparkasse Bank AG',30000,'2007-12-19',7,'2012-11-21','+vyuziva bankomaty CSOB'),('8040','Oberbank',334000,'2010-12-31',13,'2012-11-21',NULL);
/*!40000 ALTER TABLE `banky` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ceny_banking`
--

DROP TABLE IF EXISTS `ceny_banking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ceny_banking` (
  `ID` int(11) NOT NULL,
  `ib_Zrizeni` decimal(10,2) DEFAULT NULL,
  `ib_Vedeni` decimal(10,2) DEFAULT NULL,
  `ib_Odchozi1` decimal(10,2) DEFAULT NULL,
  `ib_Odchozi2` decimal(10,2) DEFAULT NULL,
  `ib_ZrizeniTP` decimal(10,2) DEFAULT NULL,
  `mb_Zrizeni` decimal(10,2) DEFAULT NULL,
  `mb_Vedeni` decimal(10,2) DEFAULT NULL,
  `mb_Odchozi1` decimal(10,2) DEFAULT NULL,
  `mb_Odchozi2` decimal(10,2) DEFAULT NULL,
  `mb_ZrizeniTP` decimal(10,2) DEFAULT NULL,
  `tb_Zrizeni` decimal(10,2) DEFAULT NULL,
  `tb_Vedeni` decimal(10,2) DEFAULT NULL,
  `tb_Odchozi1` decimal(10,2) DEFAULT NULL,
  `tb_Odchozi2` decimal(10,2) DEFAULT NULL,
  `tb_ZrizeniTP` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ceny_banking`
--

LOCK TABLES `ceny_banking` WRITE;
/*!40000 ALTER TABLE `ceny_banking` DISABLE KEYS */;
INSERT INTO `ceny_banking` VALUES (6,7.00,2.00,2.00,10.00,6.00,10.00,9.00,10.00,0.00,2.00,0.00,5.00,8.00,2.00,5.00),(7,18.00,1.00,3.00,4.00,9.00,10.00,24.00,3.00,9.00,9.00,16.00,44.00,6.00,8.00,1.00),(8,17.00,41.00,0.00,2.00,2.00,13.00,18.00,7.00,0.00,8.00,1.00,55.00,5.00,4.00,9.00),(10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,20.00,36.00,9.00,4.00,9.00,16.00,14.00,5.00,0.00,1.00,12.00,47.00,2.00,0.00,1.00),(12,10.00,39.00,1.00,8.00,1.00,15.00,31.00,8.00,9.00,1.00,16.00,14.00,3.00,1.00,5.00),(13,40.00,37.00,9.00,1.00,10.00,3.00,31.00,8.00,8.00,8.00,9.00,15.00,5.00,6.00,8.00),(14,12.00,23.00,0.00,0.00,2.00,4.00,40.00,10.00,9.00,1.00,1.00,34.00,1.00,5.00,1.00),(15,50.00,33.00,2.00,2.00,1.00,2.00,28.00,5.00,6.00,1.00,13.00,16.00,10.00,8.00,2.00),(16,5.00,50.00,10.00,5.00,9.00,14.00,13.00,2.00,8.00,1.00,5.00,33.00,7.00,10.00,8.00),(17,2.00,30.00,6.00,6.00,2.00,3.00,13.00,8.00,7.00,1.00,1.00,10.00,1.00,1.00,6.00),(18,12.00,5.00,6.00,4.00,3.00,5.00,19.00,3.00,1.00,6.00,4.00,18.00,7.00,9.00,0.00),(19,7.00,1.00,10.00,8.00,9.00,19.00,46.00,4.00,10.00,3.00,14.00,39.00,9.00,9.00,5.00),(20,8.00,18.00,7.00,9.00,6.00,3.00,32.00,3.00,7.00,1.00,12.00,42.00,9.00,3.00,3.00),(21,10.00,12.00,10.00,10.00,0.00,5.00,36.00,3.00,2.00,2.00,11.00,23.00,0.00,4.00,2.00),(22,12.00,23.00,4.00,10.00,8.00,0.00,34.00,8.00,7.00,0.00,8.00,35.00,5.00,2.00,1.00),(23,1.00,11.00,6.00,2.00,0.00,2.00,20.00,10.00,3.00,9.00,18.00,8.00,0.00,10.00,5.00),(24,14.00,44.00,4.00,4.00,16.00,5.00,19.00,10.00,9.00,7.00,11.00,20.00,5.00,2.00,5.00),(25,5.00,26.00,10.00,7.00,5.00,12.00,23.00,2.00,6.00,6.00,18.00,31.00,6.00,9.00,5.00),(26,16.00,23.00,7.00,5.00,3.00,0.00,44.00,4.00,5.00,7.00,0.00,38.00,5.00,1.00,10.00),(27,3.00,22.00,8.00,10.00,9.00,10.00,6.00,10.00,3.00,4.00,6.00,22.00,2.00,3.00,5.00),(28,13.00,0.00,8.00,7.00,6.00,19.00,0.00,1.00,10.00,2.00,16.00,23.00,6.00,5.00,4.00),(29,2.00,33.00,2.00,5.00,5.00,20.00,15.00,1.00,5.00,1.00,3.00,20.00,4.00,4.00,7.00),(30,0.00,25.00,5.00,7.00,0.00,0.00,25.00,5.00,7.00,0.00,0.00,25.00,20.00,22.00,0.00);
/*!40000 ALTER TABLE `ceny_banking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ceny_karty`
--

DROP TABLE IF EXISTS `ceny_karty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ceny_karty` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `karta_cena_id` int(11) NOT NULL,
  `karta_ID` int(11) NOT NULL,
  `karta_nazev` varchar(55) COLLATE utf8_czech_ci NOT NULL,
  `karta_typ` tinyint(4) NOT NULL,
  `kartaH_vedeni` decimal(10,2) DEFAULT NULL,
  `kartaH_vyber1` decimal(10,2) DEFAULT NULL,
  `kartaH_vyber2` decimal(10,2) DEFAULT NULL,
  `kartaH_vyber3` decimal(10,2) DEFAULT NULL,
  `kartaH_cashback` decimal(10,2) DEFAULT NULL,
  `kartaH_vklad` decimal(10,2) DEFAULT NULL,
  `kartaD_vedeni` decimal(10,2) DEFAULT NULL,
  `kartaD_vyber1` decimal(10,2) DEFAULT NULL,
  `kartaD_vyber2` decimal(10,2) DEFAULT NULL,
  `kartaD_vyber3` decimal(10,2) DEFAULT NULL,
  `kartaD_cashback` decimal(10,2) DEFAULT NULL,
  `kartaD_vklad` decimal(10,2) DEFAULT NULL,
  `kartaH_koment` text COLLATE utf8_czech_ci,
  `kartaD_koment` text COLLATE utf8_czech_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ceny_karty`
--

LOCK TABLES `ceny_karty` WRITE;
/*!40000 ALTER TABLE `ceny_karty` DISABLE KEYS */;
INSERT INTO `ceny_karty` VALUES (2,6,1,'Maestro',1,30.00,10.00,15.00,20.00,0.00,5.00,30.00,40.00,55.00,60.00,10.00,20.00,'',''),(5,6,2,'Visa',2,150.00,10.00,15.00,20.00,0.00,5.00,NULL,NULL,NULL,NULL,NULL,NULL,'bez dodatkové',NULL),(7,6,3,'Paypass',2,30.00,10.00,20.00,30.00,40.00,50.00,50.00,1.00,200.00,300.00,6.00,500.00,'',''),(8,18,1,'Maestro',1,60.00,10.00,15.00,20.00,0.00,5.00,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL),(9,18,2,'Visa',2,50.00,10.00,5.00,6.00,1.00,5.00,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL),(10,18,3,'Paypass',2,50.00,10.00,20.00,30.00,40.00,5.00,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL),(11,24,1,'MC',1,20.00,4.00,6.00,6.00,8.00,2.00,NULL,NULL,NULL,NULL,NULL,NULL,'blabla',NULL),(12,24,2,'electro',2,6.00,9.00,9.00,8.00,7.00,4.00,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL),(13,26,1,'wave',2,30.00,3.00,2.00,56.00,4.00,98.00,50.00,5.00,3.00,45.00,6.00,98.00,'','awte'),(14,26,2,'wave2',1,34.00,46.00,646.00,45.00,42.00,576.00,NULL,NULL,NULL,NULL,NULL,NULL,'no comment',NULL),(15,30,1,'Visa Classic',1,0.00,NULL,NULL,NULL,NULL,NULL,0.00,NULL,NULL,NULL,NULL,NULL,'no comment','no comment');
/*!40000 ALTER TABLE `ceny_karty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ucty`
--

DROP TABLE IF EXISTS `ucty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ucty` (
  `ucet_ID` int(3) NOT NULL AUTO_INCREMENT,
  `ucet_kod_banky` char(4) COLLATE utf8_czech_ci NOT NULL,
  `ucet_nazev` varchar(55) COLLATE utf8_czech_ci NOT NULL,
  `ucet_typ` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `ucet_mena` char(3) COLLATE utf8_czech_ci NOT NULL,
  `ucet_min_limit` decimal(10,2) unsigned DEFAULT NULL,
  `ucet_urok` decimal(3,2) unsigned DEFAULT NULL,
  `ucet_vek_od` int(3) unsigned DEFAULT NULL,
  `ucet_vek_do` int(3) unsigned DEFAULT NULL,
  `ucet_www` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL,
  `ucet_koment` text COLLATE utf8_czech_ci,
  PRIMARY KEY (`ucet_ID`),
  UNIQUE KEY `iducty_UNIQUE` (`ucet_ID`),
  UNIQUE KEY `ucet_nazev_UNIQUE` (`ucet_nazev`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ucty`
--

LOCK TABLES `ucty` WRITE;
/*!40000 ALTER TABLE `ucty` DISABLE KEYS */;
INSERT INTO `ucty` VALUES (30,'0100','Běžný účet KB - test','bezny-stu','CZK',100.00,0.01,18,99,'kb.cz','test'),(31,'6100','equa student','bezny-stu','CZK',0.00,0.00,15,28,NULL,'test'),(32,'6100','equa bezny','bezny','CZK',500.00,2.00,18,50,NULL,'test'),(33,'0800','Osobní Účet ČS test','bezny','CZK',100.00,0.00,18,99,'http://','test'),(34,'0800','dfgds','bezny-stu','CZK',100.00,0.00,18,99,'http://sgd','test'),(35,'0800','Osobní Účet ČS II','bezny','CZK',100.00,0.01,0,99,'http://www.csas.cz/banka/nav/osobni-finance/osobni-ucet-cs-ii/o-produktu-d00022392','Podmínky různé dle věkových kategorií.\r\nMin limit vložit do 14 dní od založení účtu. Neplatí v případě sjednaného kontokorentu.');
/*!40000 ALTER TABLE `ucty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ucty_ceny`
--

DROP TABLE IF EXISTS `ucty_ceny`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ucty_ceny` (
  `cena_id` int(4) NOT NULL AUTO_INCREMENT,
  `cena_ucet_id` int(3) NOT NULL,
  `cena_platnost_od` date NOT NULL,
  `cena_zrizeni` decimal(10,2) DEFAULT '0.00',
  `cena_zruseni` decimal(10,2) DEFAULT '0.00',
  `cena_vedeni` decimal(10,2) DEFAULT NULL,
  `cena_vedeni_podm` tinyint(4) DEFAULT '0',
  `cena_vypis_e` decimal(10,2) DEFAULT NULL,
  `cena_vypis_p` decimal(10,2) DEFAULT NULL,
  `cena_prichozi1` decimal(10,2) DEFAULT NULL,
  `cena_prichozi2` decimal(10,2) DEFAULT NULL,
  `cena_odchozi_tp1` decimal(10,2) DEFAULT NULL,
  `cena_odchozi_tp2` decimal(10,2) DEFAULT NULL,
  `cena_odchozi_online1` decimal(10,2) DEFAULT NULL,
  `cena_odchozi_online2` decimal(10,2) DEFAULT NULL,
  `cena_trans_bal` decimal(10,2) DEFAULT NULL,
  `cena_trans_bal_typ` tinyint(4) DEFAULT NULL,
  `cena_koment_JP` text COLLATE utf8_czech_ci,
  `cena_koment_PP` text COLLATE utf8_czech_ci,
  `cena_koment_trans` text COLLATE utf8_czech_ci,
  PRIMARY KEY (`cena_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ucty_ceny`
--

LOCK TABLES `ucty_ceny` WRITE;
/*!40000 ALTER TABLE `ucty_ceny` DISABLE KEYS */;
INSERT INTO `ucty_ceny` VALUES (6,30,'2014-10-01',15.00,0.00,67.00,0,12.00,16.00,1.00,5.00,9.00,5.00,1.00,5.00,10.00,4,'','',''),(7,30,'2015-10-01',15.00,0.00,67.00,0,12.00,16.00,1.00,5.00,9.00,5.00,1.00,5.00,10.00,4,'','',''),(8,30,'2016-10-01',32.00,0.00,234.00,0,20.00,28.00,4.00,5.00,6.00,0.00,0.00,8.00,25.00,3,'','',''),(9,30,'2018-10-01',28.00,0.00,48.00,1,16.00,25.00,0.00,19.00,0.00,18.00,4.00,3.00,87.00,3,'','',''),(10,30,'2014-10-01',33.00,0.00,391.00,0,7.00,28.00,6.00,15.00,6.00,17.00,4.00,4.00,31.00,4,'','',''),(11,30,'2019-10-01',29.00,0.00,473.00,0,8.00,11.00,3.00,0.00,1.00,5.00,0.00,0.00,75.00,4,'','',''),(12,30,'2014-10-01',48.00,0.00,218.00,0,14.00,37.00,1.00,3.00,5.00,16.00,4.00,4.00,87.00,2,'','',''),(13,30,'2024-10-01',21.00,0.00,392.00,1,0.00,30.00,0.00,13.00,8.00,2.00,1.00,4.00,45.00,4,'','',''),(14,30,'2014-10-01',23.00,0.00,397.00,0,6.00,19.00,4.00,17.00,2.00,13.00,4.00,7.00,33.00,1,'','',''),(15,30,'2044-10-01',38.00,0.00,219.00,0,0.00,20.00,3.00,20.00,1.00,1.00,4.00,7.00,32.00,4,'asfd','dfh','n,m'),(16,30,'2014-10-01',40.00,0.00,329.00,1,10.00,16.00,1.00,11.00,4.00,8.00,0.00,1.00,43.00,3,'','',''),(17,30,'2014-10-01',30.00,0.00,261.00,1,18.00,13.00,4.00,11.00,0.00,9.00,0.00,5.00,10.00,2,'','',''),(18,30,'2034-10-01',12.00,0.00,220.00,0,16.00,32.00,1.00,15.00,4.00,5.00,3.00,10.00,0.00,3,'','',''),(22,30,'2094-10-01',7.00,0.00,449.00,0,5.00,18.00,10.00,0.00,5.00,10.00,5.00,10.00,5.00,1,'no comment\r\níá','no comment','no comment'),(23,30,'2014-10-01',14.00,0.00,253.00,0,7.00,35.00,2.00,14.00,6.00,6.00,1.00,6.00,62.00,1,'no comment','no comment','no comment'),(24,30,'2014-10-01',9.00,0.00,172.00,0,9.00,41.00,9.00,1.00,4.00,19.00,1.00,3.00,18.00,1,'no comment','no comment','no comment'),(25,32,'2013-10-01',21.00,0.00,40.00,1,12.00,48.00,9.00,5.00,0.00,15.00,0.00,9.00,1.00,3,'no comment','no comment','no comment'),(26,32,'2013-11-01',15.00,0.00,470.00,1,15.00,35.00,8.00,17.00,8.00,10.00,4.00,9.00,25.00,1,'no comment','no comment','no comment'),(27,33,'2014-10-01',38.00,0.00,453.00,0,12.00,43.00,8.00,6.00,5.00,13.00,0.00,0.00,80.00,3,'no comment','no comment','no comment'),(28,33,'2014-11-01',29.00,0.00,182.00,0,17.00,46.00,0.00,6.00,3.00,8.00,4.00,5.00,68.00,3,'no comment','no comment','no comment'),(29,34,'2014-10-01',NULL,NULL,431.00,1,2.00,21.00,2.00,6.00,9.00,12.00,1.00,0.00,49.00,1,'no comment','no comment','no comment'),(30,35,'2014-10-20',0.00,0.00,69.00,1,0.00,25.00,0.00,2.00,5.00,7.00,5.00,NULL,29.00,2,'Zřízení TP je zřejmě jednotné pro všechny typy bankingu','Vedení účtu je podmíněno věkem. \r\n- Senioři (po předložení příslušného dokladu o pobírání starobního nebo plně invalidního důchodu z důchodového pojištění.) 59 Kč\r\n- Fresh účet pro mladé zdarma (0-21 všichni, 21-30 pouze studenti)\r\n- při splnění věrnostních podmínek zdarma, tj.měsíční příjem >= 7000 Kc + jedna z těchto:\r\n – řádné splácení úvěru,\r\n – řádné splácení hypotéky,\r\n – používání kreditní karty,\r\n – pravidelné investování,\r\n – řádné hrazení životního pojištění FLEXI,\r\n – kapitálová hodnota životního pojištění FLEXI nebo hodnota zainvestovaných prostředků alespoň 100 000 Kč,\r\n – využívání Podnikatelského konta Maxi\r\n\r\nVedení bankingu - 25 Kč zahrnuje IB,MB i TB v jednom (tzv. Servis 24)','Balíček transakcí - Díky této službě budete mít zdarma všechny odchozí elektronické platby v Kč v rámci České republiky, včetně trvalých plateb, souhlasů\r\ns inkasem a SIPO. Elektronické platby jsou jednorázové platby, které si zadáte sami bez naší pomoci, tedy přes internetbanking, mobilní banku, GSM banking, automatickou hlasovou službu, bankomat a platbomat. Nebudete platit nic navíc ani za platbu v internetovém obchodě\r\nprostřednictvím naší služby Platba 24 ani za dobití mobilního telefonu přes internetbanking nebo bankomat.\r\n\r\nOdchozí přes TB platí při obsluze bankéřem, přes automat jen 5 (7) Kč');
/*!40000 ALTER TABLE `ucty_ceny` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-04 15:15:06
