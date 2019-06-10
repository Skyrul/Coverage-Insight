CREATE DATABASE  IF NOT EXISTS `agency_thrive_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `agency_thrive_db`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: agency_thrive_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.16-MariaDB

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
-- Table structure for table `tbl_account_setup`
--

DROP TABLE IF EXISTS `tbl_account_setup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_account_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Account ID mapped to all tables',
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(75) NOT NULL,
  `agency_name` varchar(75) NOT NULL,
  `logo` text,
  `timezone` varchar(145) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `smtp_server` varchar(255) DEFAULT NULL,
  `smtp_username` varchar(45) DEFAULT NULL,
  `smtp_password` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(12) DEFAULT NULL,
  `smtp_type` varchar(45) DEFAULT NULL,
  `office_phone_number` varchar(254) DEFAULT NULL,
  `apointment_locations` text,
  `staff` text,
  `colour_scheme_id` int(11) NOT NULL DEFAULT '1',
  `is_activated` tinyint(4) DEFAULT '0',
  `is_Auto_checked` tinyint(4) DEFAULT '1' COMMENT 'Check: tbl_policy_type',
  `is_Home_checked` tinyint(4) DEFAULT '1' COMMENT 'Check: tbl_policy_type',
  `is_Life_checked` tinyint(4) DEFAULT '1',
  `is_Personal_Liability_checked` tinyint(4) DEFAULT '1',
  `is_Disability_checked` tinyint(4) DEFAULT '1',
  `is_Health_checked` tinyint(4) DEFAULT '1',
  `is_Other_checked` tinyint(4) DEFAULT '1',
  `is_Commercial_checked` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_account_setup`
--

LOCK TABLES `tbl_account_setup` WRITE;
/*!40000 ALTER TABLE `tbl_account_setup` DISABLE KEYS */;
INSERT INTO `tbl_account_setup` VALUES (1,'Jim','Campbell','jim.campbell@engagex.com','Engagex','153059837a0878dba3cf4566f499d9be.png','America/Los_Angeles','c92144f2bfc3a21cccf369fbc744a473','2017-09-10 02:27:23',NULL,'mail.engagex.com','joven.barola@engagex.com','Eng@geX123','25','system','1111111111111111','Makati,Ortigas,BGC,Alabang','Joven,Meriam,Kenjie,Kaylie,Jimmy',5,1,1,1,0,0,0,0,0,0),(2,'','','joven.barola@engagex.com','Engagex',NULL,'','914bafe46a39ad5f7b7f96045c645450','2017-08-14 07:12:40',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,1,1,1,0,0,0,0,0,0),(4,'JovenTest','Barola','joven@agencythriveprogram.app','Engagex',NULL,'UTC 08:00','914bafe46a39ad5f7b7f96045c645450','2017-08-16 08:14:36',NULL,'smtp.agencythriveprogram.app','joven@agencythriveprogram.app','Kenji2012',NULL,NULL,'09057214221','Makati,BGC,Ortigas','Joven,Kenjie,Kaylie,Kobie',1,1,1,1,1,1,1,1,1,1),(5,'','','joven+1@agencythriveprogram.app','Engagex',NULL,'','c92144f2bfc3a21cccf369fbc744a473','2017-08-04 17:49:32',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,1,1,1,1,1,1,1,1),(6,'','','test@agencythriveprogram.app','test',NULL,'','cc03e747a6afbbcbf8be7668acfebee5','2017-08-15 18:14:58',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,1,1,1,1,1,1,1,1),(7,'','','joven+14@agencythriveprogram.app','test',NULL,'','cc03e747a6afbbcbf8be7668acfebee5','2017-08-15 18:15:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,1,1,1,1,1,1,1,1),(8,'','','joven+2@agencythriveprogram.app','Eak',NULL,'','c92144f2bfc3a21cccf369fbc744a473','2017-08-15 19:39:30',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,1,1,1,1,1,1,1,1),(9,'','','joven+3@agencythriveprogram.app','Eak',NULL,'','c92144f2bfc3a21cccf369fbc744a473','2017-08-15 19:40:46',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,1,1,1,1,1,1,1,1),(10,'','','joven+4@agencythriveprogram.app','Test',NULL,'','c92144f2bfc3a21cccf369fbc744a473','2017-08-15 20:22:04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,1,1,1,1,1,1,1,1),(11,'','','joven+5@agencythriveprogram.app','Test',NULL,'','c92144f2bfc3a21cccf369fbc744a473','2017-08-15 20:24:54',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,1,1,1,1,1,1,1,1),(12,'Joven','Barola','joven+8@agencythriveprogram.app','Engagex',NULL,'UTC 09:00','c92144f2bfc3a21cccf369fbc744a473','2017-08-16 10:42:30',NULL,NULL,NULL,NULL,NULL,NULL,'09057214221','New York,New Jersey','Jim,Joven',1,1,1,1,1,1,1,1,1,1),(13,'Joven','Barola','joven+20@agencythriveprogram.app','Engagex',NULL,'UTC 10:00','c92144f2bfc3a21cccf369fbc744a473','2017-08-24 02:28:54',NULL,NULL,NULL,NULL,NULL,NULL,'09057214221','New York,New Jersey,California','Mitch,Kim,Laura,Rose',1,1,1,1,1,1,1,1,1,1);
/*!40000 ALTER TABLE `tbl_account_setup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_account_setup_policy`
--

DROP TABLE IF EXISTS `tbl_account_setup_policy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_account_setup_policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_parent_label` varchar(45) DEFAULT NULL COMMENT 'Values are: "Home" and "Auto"',
  `policy_child_label` varchar(45) DEFAULT NULL,
  `policy_child_questions` text,
  `policy_child_values` mediumtext,
  `is_child_checked` tinyint(4) DEFAULT '0',
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_policy_parent` (`policy_parent_label`(1))
) ENGINE=InnoDB AUTO_INCREMENT=729 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_account_setup_policy`
--

LOCK TABLES `tbl_account_setup_policy` WRITE;
/*!40000 ALTER TABLE `tbl_account_setup_policy` DISABLE KEYS */;
INSERT INTO `tbl_account_setup_policy` VALUES (283,'Auto','test1','test1','11111111111111',1,4),(284,'Auto','test2','test2','',1,4),(285,'Home','aaaa','aaaa','11221122',1,4),(286,'Home','bbbb','bbbb','bbbb222bbb222',1,4),(331,'Disability','','','',0,1),(334,'Health','','','',1,1),(335,'Other','','','',1,1),(337,'Commercial','','','',1,1),(517,'Life','','','',1,2),(520,'Personal_Liability','','','',1,2),(523,'Disability','','','',1,2),(526,'Health','','','',1,2),(529,'Other','','','',1,2),(532,'Commercial','','','',1,2),(539,'Home','House Type','House Type','Bungalow,Mansion',1,2),(540,'Home','Liability','Liability','Loan,CA',1,2),(541,'Auto','Model/Make','Model/Make','100/200,200,100,1/20',1,2),(542,'Auto','Liabilty','Liabilty','Loan,CA',1,2),(543,'Home','Type','Type','A,B,C,D',1,1),(544,'Home','Separate Structures','Separate Structures','A,B,C,D',1,1),(545,'Home','Contents','Contents','A,B,C,D',1,1),(546,'Home','Additional Living','Additional Living','A,B,C,D',1,1),(547,'Home','Liability','Liability','A,B,C,D',1,1),(554,'Auto','Make/Model','Make/Model','Honda Vios, Toyota Corolla',1,1),(555,'Auto','Liability','Liability','25/50,40/80,50/100,100/300,250/500',1,1),(556,'Auto','Uninsured Motorist','Uninsured Motorist','A,B,C,D',1,1),(557,'Auto','Medical','Medical','A,B,C,D',1,1),(558,'Auto','Comprehensive/Collision','Comprehensive/Collision','A,B,C,D',1,1),(559,'Auto','Roadside/Tow','Roadside/Tow','A,B,C,D',1,1),(574,'Auto','Make/Model','Make/Model','Toyota,BMW,Rolls Royce,Chevrolet',1,13),(716,'Life','Life 1','Life 1','',1,1),(717,'Life','Life 2','Life 2','',1,1),(718,'Life','Life 3','Life 3','',1,1),(719,'Life','Life 4','Life 4','',1,1),(720,'Life','Life 5','Life 5','',1,1),(721,'Life','Life 6','Life 6','',1,1),(722,'Life','Life 7','Life 7','',1,1),(723,'Life','Life 8','Life 8','',1,1),(724,'Life','Life 9','Life 9','',1,1),(725,'Life','Life 10','Life 10','',1,1),(726,'Personal_Liability','Test1','Test1','A,B,C,D,E',1,1),(727,'Personal_Liability','Test2','Test2','A,B,C,D,E',1,1),(728,'Personal_Liability','Test3','Test3','A,B,C,D,E',1,1);
/*!40000 ALTER TABLE `tbl_account_setup_policy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_action_item`
--

DROP TABLE IF EXISTS `tbl_action_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_action_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT 'FK: tbl_customer',
  `action_type_code` varchar(45) NOT NULL COMMENT 'FK: tbl_action_type',
  `owner` varchar(45) DEFAULT NULL COMMENT 'This is based on the selected staff (Account Setup)',
  `description` text,
  `ci_review_guid` varchar(255) DEFAULT NULL COMMENT 'FK: tbl_ci_review',
  `is_opportunity` tinyint(4) DEFAULT NULL,
  `is_completed` tinyint(4) DEFAULT '0' COMMENT ' Insurance Agent will mark this Action Item if completed',
  `created_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_action_item`
--

LOCK TABLES `tbl_action_item` WRITE;
/*!40000 ALTER TABLE `tbl_action_item` DISABLE KEYS */;
INSERT INTO `tbl_action_item` VALUES (1,61,'','Meriam','Engagex',NULL,1,1,'2017-07-27','2018-12-25',1),(8,58,'','Jimmy','Wow',NULL,0,1,'2017-08-03','2017-08-03',1),(9,64,'','Joven','Test251111',NULL,1,1,'2017-08-10','2017-08-22',4),(10,65,'','Joven','Test',NULL,0,1,'2017-08-04','2017-08-04',4),(11,66,'','Joven','Keep it up joven',NULL,1,0,'2017-08-10','2017-08-10',4),(12,71,'','Jim','Test',NULL,1,1,'2017-08-16','2017-08-16',12),(36,62,'Customer Contact Information','Joven','test2',NULL,1,1,'2017-08-18','1970-01-01',1),(37,62,'Customer Contact Information','Joven','test3',NULL,1,1,'2017-08-18','1970-01-01',1),(38,62,'Secondary Contact Information','Joven','Joven do this and do that',NULL,1,1,'2017-08-18','1970-01-01',1),(39,62,'Appointment','Joven','Test',NULL,1,1,'2017-08-18','1970-01-01',1),(40,62,'Current Coverages','Joven','Testm1',NULL,1,1,'2017-08-18','1970-01-01',1),(41,62,'Current Coverages','Joven','Test2',NULL,1,1,'2017-08-18','1970-01-01',1),(42,72,'Auto Section','--','test22',NULL,0,1,'2017-09-07','2017-08-22',1),(43,72,'Current Coverages','--','test',NULL,1,1,'2017-09-07','1970-01-01',1),(44,61,'Customer Contact Information','--','CIR: Test1',NULL,NULL,0,'2017-08-31','1970-01-01',1),(45,61,'Current Coverages','--','5576767',NULL,NULL,0,'2017-08-31','1970-01-01',1),(47,62,'','Meriam','joven',NULL,1,0,'2017-09-07','2017-09-07',1),(48,62,'','Kaylie','joven',NULL,1,0,'2017-09-07','2017-09-07',1),(49,62,'','Kenjie','joven',NULL,1,0,'2017-09-07','2017-09-07',1),(50,58,'','Kenjie','joven',NULL,0,1,'2017-09-07','2017-09-07',1),(51,2,'','Joven','joven sample',NULL,1,0,'2017-09-07','2017-09-07',1),(52,53,'Test','--','Test',NULL,1,0,'2017-09-09','2017-09-07',1),(53,62,'','Joven','123456',NULL,1,0,'2017-09-07','2017-09-07',1),(54,61,'','Joven','89894',NULL,0,0,'2017-09-07','2017-09-07',1),(56,72,'Customer Contact Information','--','Joven',NULL,NULL,0,'2017-09-07','1970-01-01',1),(57,72,'Customer Contact Information','--','Test',NULL,NULL,0,'2017-09-07','1970-01-01',1),(58,58,'','Joven','Joven Test',NULL,1,0,'2017-09-08','2017-09-08',1),(59,53,'Test','--','Another item for Kaylie',NULL,0,0,'2017-09-09','2017-09-08',1),(60,53,'Customer Contact Information','--','Test Test',NULL,NULL,0,'2017-09-09','1969-12-31',1);
/*!40000 ALTER TABLE `tbl_action_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_action_type`
--

DROP TABLE IF EXISTS `tbl_action_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_action_type` (
  `action_type_code` varchar(45) NOT NULL COMMENT 'Values: Customer Contact, Dependents, Auto, Home, Concerns and Questions',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`action_type_code`),
  UNIQUE KEY `action_type_code_UNIQUE` (`action_type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_action_type`
--

LOCK TABLES `tbl_action_type` WRITE;
/*!40000 ALTER TABLE `tbl_action_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_action_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_activity_meta`
--

DROP TABLE IF EXISTS `tbl_activity_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_activity_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL COMMENT 'This store comma delimited data, to use for referencing on a Transaction',
  `meta_value` text COMMENT 'This store json data, or plain data',
  `account_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_activity_meta`
--

LOCK TABLES `tbl_activity_meta` WRITE;
/*!40000 ALTER TABLE `tbl_activity_meta` DISABLE KEYS */;
INSERT INTO `tbl_activity_meta` VALUES (46,53,'AP:Customer','[{\"id\":\"53\",\"primary_firstname\":\"Kaylie\",\"primary_lastname\":\"Barola\",\"primary_telno\":\"(123)-456-7899\",\"primary_cellphone\":\"\",\"primary_alt_telno\":\"\",\"primary_address\":null,\"primary_email\":\"joven+1@agencythriveprogram.app\",\"primary_emergency_contact\":\"\",\"secondary_firstname\":\"\",\"secondary_lastname\":\"\",\"secondary_telno\":\"\",\"secondary_cellphone\":\"\",\"secondary_alt_telno\":\"\",\"secondary_address\":null,\"secondary_email\":\"\",\"secondary_emergency_contact\":\"\",\"created_at\":\"2017-07-27 13:31:34\",\"updated_at\":\"2017-09-09 23:25:23\",\"account_id\":\"1\"}]',1),(47,53,'AP:Dependent','[{\"id\":\"127\",\"customer_id\":\"53\",\"dependent_name\":\"Dependent 1\",\"dependent_age\":\"10\",\"account_id\":\"1\"}]',1),(48,53,'AP:CurrentCoverage','[{\"id\":\"121\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Make\\/Model\",\"policy_child_selected\":\" Toyota Corolla\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"122\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Liability\",\"policy_child_selected\":\"25\\/50\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"123\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Uninsured Motorist\",\"policy_child_selected\":\"A\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"124\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Medical\",\"policy_child_selected\":\"A\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"125\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Comprehensive\\/Collision\",\"policy_child_selected\":\"A\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"126\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Roadside\\/Tow\",\"policy_child_selected\":\"A\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"127\",\"customer_id\":\"53\",\"policy_parent_code\":\"Home\",\"policy_child_label\":\"Type\",\"policy_child_selected\":\"B\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"128\",\"customer_id\":\"53\",\"policy_parent_code\":\"Home\",\"policy_child_label\":\"Separate Structures\",\"policy_child_selected\":\"B\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"129\",\"customer_id\":\"53\",\"policy_parent_code\":\"Home\",\"policy_child_label\":\"Contents\",\"policy_child_selected\":\"B\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"130\",\"customer_id\":\"53\",\"policy_parent_code\":\"Home\",\"policy_child_label\":\"Additional Living\",\"policy_child_selected\":\"B\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"131\",\"customer_id\":\"53\",\"policy_parent_code\":\"Home\",\"policy_child_label\":\"Liability\",\"policy_child_selected\":\"B\",\"account_id\":\"1\",\"cir_answer\":null}]',1),(49,53,'AP:Appointment','[{\"id\":\"9\",\"customer_id\":\"53\",\"appointment_date\":\"2017-09-21\",\"appointment_time\":\"8:25am\",\"location\":\"Alabang\",\"is_completed\":null,\"assessment_guid\":\"d82c8d1619ad8176d665453cfb2e55f0\",\"account_id\":\"1\",\"created_at\":\"2017-09-09 02:28:39\"}]',1),(50,53,'NA:Customer','[{\"id\":\"53\",\"primary_firstname\":\"Kaylie\",\"primary_lastname\":\"Barola\",\"primary_telno\":\"(123)-456-7899\",\"primary_cellphone\":\"\",\"primary_alt_telno\":\"\",\"primary_address\":null,\"primary_email\":\"joven+1@agencythriveprogram.app\",\"primary_emergency_contact\":\"\",\"secondary_firstname\":\"Kaylie Ligaya\",\"secondary_lastname\":\"Barola\",\"secondary_telno\":\"\",\"secondary_cellphone\":\"\",\"secondary_alt_telno\":\"\",\"secondary_address\":null,\"secondary_email\":\"joven+2@agenycthriveprogram.app\",\"secondary_emergency_contact\":\"Joven Barola\",\"created_at\":\"2017-07-27 13:31:34\",\"updated_at\":\"2017-09-09 23:26:59\",\"account_id\":\"1\"}]',1),(51,53,'NA:Dependent','[{\"id\":\"127\",\"customer_id\":\"53\",\"dependent_name\":\"Dependent 1\",\"dependent_age\":\"10\",\"account_id\":\"1\"},{\"id\":\"130\",\"customer_id\":\"53\",\"dependent_name\":\"Dependent 2\",\"dependent_age\":\"10\",\"account_id\":\"1\"}]',1),(52,53,'NA:CurrentCoverage','[{\"id\":\"121\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Make\\/Model\",\"policy_child_selected\":\" Toyota Corolla\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"122\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Liability\",\"policy_child_selected\":\"25\\/50\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"123\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Uninsured Motorist\",\"policy_child_selected\":\"A\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"124\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Medical\",\"policy_child_selected\":\"A\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"125\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Comprehensive\\/Collision\",\"policy_child_selected\":\"A\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"126\",\"customer_id\":\"53\",\"policy_parent_code\":\"Auto\",\"policy_child_label\":\"Roadside\\/Tow\",\"policy_child_selected\":\"A\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"127\",\"customer_id\":\"53\",\"policy_parent_code\":\"Home\",\"policy_child_label\":\"Type\",\"policy_child_selected\":\"B\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"128\",\"customer_id\":\"53\",\"policy_parent_code\":\"Home\",\"policy_child_label\":\"Separate Structures\",\"policy_child_selected\":\"B\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"129\",\"customer_id\":\"53\",\"policy_parent_code\":\"Home\",\"policy_child_label\":\"Contents\",\"policy_child_selected\":\"B\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"130\",\"customer_id\":\"53\",\"policy_parent_code\":\"Home\",\"policy_child_label\":\"Additional Living\",\"policy_child_selected\":\"B\",\"account_id\":\"1\",\"cir_answer\":null},{\"id\":\"131\",\"customer_id\":\"53\",\"policy_parent_code\":\"Home\",\"policy_child_label\":\"Liability\",\"policy_child_selected\":\"B\",\"account_id\":\"1\",\"cir_answer\":null}]',1),(53,53,'NA:Appointment','[{\"id\":\"9\",\"customer_id\":\"53\",\"appointment_date\":\"2017-09-21\",\"appointment_time\":\"8:25am\",\"location\":\"Alabang\",\"is_completed\":null,\"assessment_guid\":\"d82c8d1619ad8176d665453cfb2e55f0\",\"account_id\":\"1\",\"created_at\":\"2017-09-09 02:28:39\"}]',1);
/*!40000 ALTER TABLE `tbl_activity_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_appointment`
--

DROP TABLE IF EXISTS `tbl_appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` varchar(45) NOT NULL,
  `location` varchar(45) NOT NULL COMMENT 'Check: tbl_account_setup',
  `is_completed` tinyint(4) DEFAULT NULL COMMENT 'Flag if steps are now completed',
  `assessment_guid` varchar(255) DEFAULT NULL COMMENT 'Relate: Need Assessment',
  `account_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_appointment`
--

LOCK TABLES `tbl_appointment` WRITE;
/*!40000 ALTER TABLE `tbl_appointment` DISABLE KEYS */;
INSERT INTO `tbl_appointment` VALUES (1,66,'2017-08-22','12:10am','Ortigas',NULL,'3295c76acbf4caaed33c36b1b5fc2cb1',4,'2017-08-15 21:46:05'),(2,65,'2017-08-22','11:58pm','Makati',NULL,'fc490ca45c00b1249bbe3554a4fdf6fb',4,'2017-08-15 21:58:37'),(3,71,'2017-08-22','12:01pm','New Jersey',NULL,'e2c420d928d4bf8ce0ff2ec19b371514',12,'2017-08-22 07:55:00'),(4,62,'2017-08-22','3:51pm','Ortigas',NULL,'44f683a84163b3523afe57c2e008bc8c',1,'2017-08-16 12:47:13'),(5,72,'2017-09-09','2:44am','Ortigas',NULL,'32bb90e8976aab5298d5da10fe66f21d',1,'2017-08-22 02:01:13'),(6,73,'2017-08-24','2:14am','New Jersey',NULL,'d2ddea18f00665ce8623e36bd4e3c7c5',13,'2017-08-24 00:14:08'),(7,61,'2017-08-29','7:19am','Makati',NULL,'7f39f8317fbdb1988ef4c628eba02591',1,'2017-08-29 05:19:14'),(8,58,'2017-09-09','7:21pm','BGC',NULL,'66f041e16a60928b05a7e228a89c3799',1,'2017-09-08 16:59:13'),(9,53,'2017-09-21','8:25am','Alabang',NULL,'d82c8d1619ad8176d665453cfb2e55f0',1,'2017-09-08 18:28:39'),(10,2,'2017-09-09','12:43am','Alabang',NULL,'c81e728d9d4c2f636f067f89cc14862c',1,'2017-09-08 22:43:07');
/*!40000 ALTER TABLE `tbl_appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ci_review`
--

DROP TABLE IF EXISTS `tbl_ci_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ci_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `ci_review_submitted_to` varchar(255) DEFAULT NULL COMMENT 'Email address of NA receipient',
  `ci_review_guid` varchar(255) DEFAULT NULL,
  `is_completed` tinyint(4) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `ci_review_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ci_review`
--

LOCK TABLES `tbl_ci_review` WRITE;
/*!40000 ALTER TABLE `tbl_ci_review` DISABLE KEYS */;
INSERT INTO `tbl_ci_review` VALUES (1,'44f683a84163b3523afe57c2e008bc8c',72,'joven@engagex.com','44f683a84163b3523afe57c2e008bc8c',1,1,'2017-09-01 16:00:00'),(2,NULL,53,'joven+1@agencythriveprogram.app','6c99cd8918f3c762a12c05de1272d13a',1,1,'2017-09-10 09:50:41'),(3,NULL,58,'joven+1@agencythriveprogram.app','6c99cd8918f3c762a12c05de1272d13a',1,1,'2017-09-10 09:59:21'),(4,NULL,61,'joven+1@agencythriveprogram.app','6c99cd8918f3c762a12c05de1272d13a',1,1,'2017-09-10 09:59:52'),(5,NULL,62,'joven+a1@agencythriveprogram.app','6c99cd8918f3c762a12c05de1272d13a',1,1,'2017-09-10 10:01:42'),(6,NULL,2,'joven@agencythriveprogram.app','6c99cd8918f3c762a12c05de1272d13a',1,1,'2017-09-10 10:18:49');
/*!40000 ALTER TABLE `tbl_ci_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_colour_scheme`
--

DROP TABLE IF EXISTS `tbl_colour_scheme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_colour_scheme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scheme_name` varchar(45) NOT NULL,
  `color_1` varchar(45) NOT NULL,
  `color_2` varchar(45) NOT NULL,
  `color_3` varchar(45) NOT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `scheme_name_UNIQUE` (`scheme_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_colour_scheme`
--

LOCK TABLES `tbl_colour_scheme` WRITE;
/*!40000 ALTER TABLE `tbl_colour_scheme` DISABLE KEYS */;
INSERT INTO `tbl_colour_scheme` VALUES (1,'Default Theme','null','null','null',1),(2,'Theme 1','#f2ab14','#070600','#070800',1),(4,'Theme 2','#C2847A','#280003','#848586',1),(5,'Custom','#3d85c6','#20124d','#fff2cc',1);
/*!40000 ALTER TABLE `tbl_colour_scheme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_current_coverage`
--

DROP TABLE IF EXISTS `tbl_current_coverage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_current_coverage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `policy_parent_code` varchar(45) DEFAULT NULL COMMENT 'Values are: "Auto" or "Home"',
  `policy_child_label` varchar(45) DEFAULT NULL,
  `policy_child_selected` varchar(75) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `cir_answer` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_current_coverage`
--

LOCK TABLES `tbl_current_coverage` WRITE;
/*!40000 ALTER TABLE `tbl_current_coverage` DISABLE KEYS */;
INSERT INTO `tbl_current_coverage` VALUES (1,62,'Auto','Make/Model','Honda Vios',1,'Honda Vios'),(2,62,'Auto','Liability','50/100',1,'50/100'),(3,62,'Auto','Uninsured Motorist','B',1,'B'),(4,62,'Auto','Medical','A',1,'A'),(5,62,'Auto','Comprehensive/Collision','A',1,'A'),(6,62,'Auto','Roadside/Tow','A',1,'A'),(7,62,'Auto','Make/Model',' Toyota Corolla',1,NULL),(8,62,'Auto','Liability','50/100',1,NULL),(9,62,'Auto','Uninsured Motorist','B',1,NULL),(10,62,'Auto','Medical','B',1,NULL),(11,62,'Auto','Comprehensive/Collision','B',1,NULL),(12,62,'Auto','Roadside/Tow','A',1,NULL),(13,62,'Home','Type','B',1,'B'),(14,62,'Home','Separate Structures','B',1,'B'),(15,62,'Home','Contents','B',1,'B'),(16,62,'Home','Additional Living','B',1,'B'),(17,62,'Home','Liability','B',1,'B'),(18,62,'Auto','Make/Model',' Toyota Corolla',1,NULL),(19,62,'Auto','Liability','25/50',1,NULL),(20,62,'Auto','Uninsured Motorist','A',1,NULL),(21,62,'Auto','Medical','D',1,NULL),(22,62,'Auto','Comprehensive/Collision','D',1,NULL),(23,62,'Auto','Roadside/Tow','D',1,NULL),(24,62,'Auto','Make/Model','Honda Vios',1,NULL),(25,62,'Auto','Liability','250/500',1,NULL),(26,62,'Auto','Uninsured Motorist','A',1,NULL),(27,62,'Auto','Medical','A',1,NULL),(28,62,'Auto','Comprehensive/Collision','A',1,NULL),(29,62,'Auto','Roadside/Tow','A',1,NULL),(30,62,'Home','Type','D',1,NULL),(31,62,'Home','Separate Structures','D',1,NULL),(32,62,'Home','Contents','D',1,NULL),(33,62,'Home','Additional Living','D',1,NULL),(34,62,'Home','Liability','D',1,NULL),(35,72,'Auto','Make/Model','Honda Vios',1,NULL),(36,72,'Auto','Liability','100/300',1,NULL),(37,72,'Auto','Uninsured Motorist','C',1,NULL),(38,72,'Auto','Medical','C',1,NULL),(39,72,'Auto','Comprehensive/Collision','C',1,NULL),(40,72,'Auto','Roadside/Tow','C',1,NULL),(41,72,'Home','Type','A',1,NULL),(42,72,'Home','Separate Structures','A',1,NULL),(43,72,'Home','Contents','A',1,NULL),(44,72,'Home','Additional Living','A',1,NULL),(45,72,'Home','Liability','A',1,NULL),(46,72,'Auto','Make/Model','Honda Vios',1,NULL),(47,72,'Auto','Liability','100/300',1,NULL),(48,72,'Auto','Uninsured Motorist','A',1,NULL),(49,72,'Auto','Medical','A',1,NULL),(50,72,'Auto','Comprehensive/Collision','A',1,NULL),(51,72,'Auto','Roadside/Tow','A',1,NULL),(52,72,'Auto','Make/Model',' Toyota Corolla',1,NULL),(53,72,'Auto','Liability','100/300',1,NULL),(54,72,'Auto','Uninsured Motorist','A',1,NULL),(55,72,'Auto','Medical','A',1,NULL),(56,72,'Auto','Comprehensive/Collision','A',1,NULL),(57,72,'Auto','Roadside/Tow','A',1,NULL),(58,72,'Auto','Make/Model',' Toyota Corolla',1,NULL),(59,72,'Auto','Liability','50/100',1,NULL),(60,72,'Auto','Uninsured Motorist','A',1,NULL),(61,72,'Auto','Medical','A',1,NULL),(62,72,'Auto','Comprehensive/Collision','A',1,NULL),(63,72,'Auto','Roadside/Tow','A',1,NULL),(64,72,'Auto','Make/Model',' Toyota Corolla',1,NULL),(65,72,'Auto','Liability','100/300',1,NULL),(66,72,'Auto','Uninsured Motorist','C',1,NULL),(67,72,'Auto','Medical','C',1,NULL),(68,72,'Auto','Comprehensive/Collision','C',1,NULL),(69,72,'Auto','Roadside/Tow','C',1,NULL),(70,72,'Auto','Make/Model','Honda Vios',1,NULL),(71,72,'Auto','Liability','250/500',1,NULL),(72,72,'Auto','Uninsured Motorist','A',1,NULL),(73,72,'Auto','Medical','A',1,NULL),(74,72,'Auto','Comprehensive/Collision','A',1,NULL),(75,72,'Auto','Roadside/Tow','A',1,NULL),(76,72,'Auto','Make/Model',' Toyota Corolla',1,NULL),(77,72,'Auto','Liability','25/50',1,NULL),(78,72,'Auto','Uninsured Motorist','A',1,NULL),(79,72,'Auto','Medical','C',1,NULL),(80,72,'Auto','Comprehensive/Collision','A',1,NULL),(81,72,'Auto','Roadside/Tow','A',1,NULL),(82,61,'Auto','Make/Model','Honda Vios',1,'Honda Vios'),(83,61,'Auto','Liability','25/50',1,'25/50'),(84,61,'Auto','Uninsured Motorist','A',1,'A'),(85,61,'Auto','Medical','A',1,'A'),(86,61,'Auto','Comprehensive/Collision','A',1,'A'),(87,61,'Auto','Roadside/Tow','A',1,'A'),(88,61,'Auto','Make/Model',' Toyota Corolla',1,NULL),(89,61,'Auto','Liability','50/100',1,NULL),(90,61,'Auto','Uninsured Motorist','B',1,NULL),(91,61,'Auto','Medical','B',1,NULL),(92,61,'Auto','Comprehensive/Collision','B',1,NULL),(93,61,'Auto','Roadside/Tow','B',1,NULL),(94,61,'Home','Type','C',1,'C'),(95,61,'Home','Separate Structures','B',1,'B'),(96,61,'Home','Contents','A',1,'A'),(97,61,'Home','Additional Living','B',1,'B'),(98,61,'Home','Liability','A',1,'A'),(99,61,'Home','Type','C',1,NULL),(100,61,'Home','Separate Structures','A',1,NULL),(101,61,'Home','Contents','A',1,NULL),(102,61,'Home','Additional Living','A',1,NULL),(103,61,'Home','Liability','A',1,NULL),(104,72,'Auto','Make/Model',' Toyota Corolla',1,NULL),(105,72,'Auto','Liability','25/50',1,NULL),(106,72,'Auto','Uninsured Motorist','A',1,NULL),(107,72,'Auto','Medical','A',1,NULL),(108,72,'Auto','Comprehensive/Collision','A',1,NULL),(109,72,'Auto','Roadside/Tow','A',1,NULL),(110,72,'Home','Type','B',1,NULL),(111,72,'Home','Separate Structures','A',1,NULL),(112,72,'Home','Contents','A',1,NULL),(113,72,'Home','Additional Living','A',1,NULL),(114,72,'Home','Liability','A',1,NULL),(115,58,'Auto','Make/Model','Honda Vios',1,'Honda Vios'),(116,58,'Auto','Liability','40/80',1,'40/80'),(117,58,'Auto','Uninsured Motorist','A',1,'A'),(118,58,'Auto','Medical','A',1,'A'),(119,58,'Auto','Comprehensive/Collision','A',1,'A'),(120,58,'Auto','Roadside/Tow','A',1,'A'),(121,53,'Auto','Make/Model',' Toyota Corolla',1,'Joven Corolla'),(122,53,'Auto','Liability','25/50',1,'25/50'),(123,53,'Auto','Uninsured Motorist','A',1,'A'),(124,53,'Auto','Medical','A',1,'A'),(125,53,'Auto','Comprehensive/Collision','A',1,'A'),(126,53,'Auto','Roadside/Tow','A',1,'A'),(127,53,'Home','Type','B',1,'Barola'),(128,53,'Home','Separate Structures','B',1,'B'),(129,53,'Home','Contents','B',1,'B'),(130,53,'Home','Additional Living','B',1,'B'),(131,53,'Home','Liability','B',1,'B'),(132,2,'Auto','Make/Model',' Toyota Corolla',1,' Toyota Corolla'),(133,2,'Auto','Liability','40/80',1,'40/80'),(134,2,'Auto','Uninsured Motorist','A',1,'A'),(135,2,'Auto','Medical','A',1,'A'),(136,2,'Auto','Comprehensive/Collision','A',1,'A'),(137,2,'Auto','Roadside/Tow','A',1,'A'),(138,53,'Auto','Make/Model',' Toyota Corolla',1,NULL),(139,53,'Auto','Liability','50/100',1,NULL),(140,53,'Auto','Uninsured Motorist','A',1,NULL),(141,53,'Auto','Medical','A',1,NULL),(142,53,'Auto','Comprehensive/Collision','A',1,NULL),(143,53,'Auto','Roadside/Tow','A',1,NULL);
/*!40000 ALTER TABLE `tbl_current_coverage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer`
--

DROP TABLE IF EXISTS `tbl_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `primary_firstname` varchar(45) NOT NULL,
  `primary_lastname` varchar(45) NOT NULL,
  `primary_telno` varchar(75) DEFAULT NULL,
  `primary_cellphone` varchar(75) DEFAULT NULL,
  `primary_alt_telno` varchar(75) DEFAULT NULL,
  `primary_address` varchar(255) DEFAULT NULL,
  `primary_email` varchar(75) DEFAULT NULL,
  `primary_emergency_contact` varchar(45) DEFAULT NULL,
  `secondary_firstname` varchar(45) DEFAULT NULL,
  `secondary_lastname` varchar(45) DEFAULT NULL,
  `secondary_telno` varchar(75) DEFAULT NULL,
  `secondary_cellphone` varchar(75) DEFAULT NULL,
  `secondary_alt_telno` varchar(75) DEFAULT NULL,
  `secondary_address` varchar(255) DEFAULT NULL,
  `secondary_email` varchar(75) DEFAULT NULL,
  `secondary_emergency_contact` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer`
--

LOCK TABLES `tbl_customer` WRITE;
/*!40000 ALTER TABLE `tbl_customer` DISABLE KEYS */;
INSERT INTO `tbl_customer` VALUES (2,'Jim','Campbell','(123)-456-7899','','',NULL,'joven@agencythriveprogram.app','','Joven','Barola','','','',NULL,'','','2017-07-27 03:55:30','2017-09-10 10:08:07',1),(53,'Kaylie','Barola','(123)-456-7899','','',NULL,'joven+1@agencythriveprogram.app','','Kaylie Ligaya','Barola','','','',NULL,'joven+2@agenycthriveprogram.app','Joven Barola','2017-07-27 05:31:34','2017-09-10 02:31:59',1),(58,'Tom','Jones','(123)-456-7899','','',NULL,'joven+1@agencythriveprogram.app','','Joven','Barola','','','',NULL,'joven+2@agenycthriveprogram.app','','2017-07-28 05:35:11','2017-09-10 09:58:43',1),(61,'Josh','Simpson','(123)-456-7899','','',NULL,'joven+b1@agencythriveprogram.app','','Homer','Simpson','','','',NULL,'homer.simpson@synergy.com','','2017-07-28 07:34:12','2017-09-10 09:59:34',1),(62,'Kenjie','Barola','(012)-345-6789','(123)-456-7899','(798)-982-8223',NULL,'joven+a1@agencythriveprogram.app','Joven Barola','Joven','Barola','(199)-092-8877','(921)-798-2677','(879)-849-7988',NULL,'joven+a2@agenycthriveprogram.app','Kenjie Barola','2017-07-29 04:38:10','2017-09-10 10:00:26',1),(64,'Joven','Barola',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-08-04 18:52:17',NULL,4),(65,'Jim','Campbell','8998989989','','',NULL,'jim.campbell@engagex.com','','','','','','',NULL,'','','2017-08-04 18:52:27','2017-08-15 21:58:28',4),(66,'Joven','Barola','12345678','','',NULL,'joven+12@agencythriveprogram.app','','','','','','',NULL,'','','2017-08-04 21:15:38','2017-08-16 08:04:49',4),(67,'Joven','Barola',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-08-14 05:51:36',NULL,2),(68,'Jim','Campbell',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-08-14 05:51:44',NULL,2),(69,'Jimmy','Bolton',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-08-14 05:51:51',NULL,2),(70,'John','Adams','123456789','','',NULL,'john.adam@gmail.com','','Joshua','Adams','123456999','','',NULL,'josh@test.comm','','2017-08-14 05:52:05','2017-08-14 21:55:58',2),(71,'Joven','Barola','09057214221','111111111111111','22222222222',NULL,'joven+12@agencythriveprogram.app','Joven','Kenjie','Barola','09156133624','','',NULL,'kenjie@agencythriveprogram.app','','2017-08-16 08:24:15','2017-08-16 11:09:10',12),(72,'Lani','Misalucha','(999)-779-7977','(012)-345-6789','(012)-345-6789',NULL,'joven+14@agencythriveprogram.app','(012)-345-6789','joven','joven','(465)-456-5464','','',NULL,'joven.barola@engagex.com','','2017-08-22 01:59:17','2017-09-09 09:43:57',1),(73,'Joven','Barola','(012)-345-6789','','',NULL,'joven+20@agencythriveprogram.app','Joven','Meriam','Home','09156133624','','',NULL,'joven+21@agencythriveprogram.app','','2017-08-24 00:12:10','2017-08-24 02:30:45',13);
/*!40000 ALTER TABLE `tbl_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_dependent`
--

DROP TABLE IF EXISTS `tbl_dependent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_dependent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `dependent_name` varchar(45) DEFAULT NULL,
  `dependent_age` varchar(45) DEFAULT NULL COMMENT 'Ages is in the range of 0-100  (this includes Baby, Kids, Adults)',
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_dependent`
--

LOCK TABLES `tbl_dependent` WRITE;
/*!40000 ALTER TABLE `tbl_dependent` DISABLE KEYS */;
INSERT INTO `tbl_dependent` VALUES (1,62,'Kobie Kumukura','3',1),(5,58,'Roni Jones','10',1),(9,62,'Kaylie Ligaya Kumukura','13',1),(10,70,'Luis Adams','10',2),(11,70,'James Adams','10',2),(12,66,'Romnick','10',4),(13,66,'Jessele','10',4),(14,71,'Kenjie','5',12),(15,71,'Kaylie','4',12),(16,71,'Kobie','1',12),(21,62,'Kenjie Kumukura','14',1),(47,72,'joven','10',1),(55,73,'Kenjie','10',13),(56,73,'Kaylie','10',13),(57,73,'Kobie','9',13),(82,72,'haven','7',1),(87,72,'Test1','0',1),(88,61,'Dependent 1','2',1),(89,61,'Dependent 2','1',1),(122,62,'Joven','10',1),(124,62,'Barola','10',1),(126,58,'Boy Logro','10',1),(127,53,'Dependent 1','10',1),(128,2,'Test1','10',1),(129,2,'Test2','10',1),(130,53,'Dependent 2','10',1);
/*!40000 ALTER TABLE `tbl_dependent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_education`
--

DROP TABLE IF EXISTS `tbl_education`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `policy_parent_label` varchar(45) DEFAULT NULL,
  `policy_child_label` varchar(45) DEFAULT NULL,
  `policy_child_selected` varchar(45) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=273 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_education`
--

LOCK TABLES `tbl_education` WRITE;
/*!40000 ALTER TABLE `tbl_education` DISABLE KEYS */;
INSERT INTO `tbl_education` VALUES (118,72,'Auto','Make/Model','Make/Model',1),(119,72,'Auto','Liability','Liability',1),(120,72,'Auto','Medical','Medical',1),(121,72,'Auto','Comprehensive/Collision','Comprehensive/Collision',1),(122,72,'Auto','Roadside/Tow','Roadside/Tow',1),(123,72,'Home','Type','Type',1),(124,72,'Home','Separate Structures','Separate Structures',1),(125,72,'Home','Additional Living','Additional Living',1),(126,72,'Home','Liability','Liability',1),(141,72,'Life','Life 1','Life 1',1),(142,72,'Life','Life 2','Life 2',1),(143,72,'Life','Life 3','Life 3',1),(144,72,'Life','Life 4','Life 4',1),(145,72,'Life','Life 8','Life 8',1),(146,72,'Life','Life 9','Life 9',1),(147,72,'Life','Life 10','Life 10',1),(162,61,'Life','Life 1','Life 1',1),(163,61,'Life','Life 2','Life 2',1),(164,62,'Life','Life 1','Life 1',1),(165,62,'Life','Life 2','Life 2',1),(166,62,'Life','Life 5','Life 5',1),(167,62,'Life','Life 6','Life 6',1),(258,53,'Auto','Make/Model','Make/Model',1),(259,53,'Auto','Liability','Liability',1),(260,53,'Auto','Uninsured Motorist','Uninsured Motorist',1),(261,53,'Home','Type','Type',1),(262,53,'Home','Separate Structures','Separate Structures',1),(263,61,'Auto','Make/Model','Make/Model',1),(264,61,'Auto','Liability','Liability',1),(265,61,'Auto','Comprehensive/Collision','Comprehensive/Collision',1),(266,61,'Auto','Roadside/Tow','Roadside/Tow',1),(267,61,'Home','Separate Structures','Separate Structures',1),(268,61,'Home','Contents','Contents',1),(269,62,'Auto','Make/Model','Make/Model',1),(270,62,'Auto','Liability','Liability',1),(271,62,'Home','Separate Structures','Separate Structures',1),(272,62,'Home','Additional Living','Additional Living',1);
/*!40000 ALTER TABLE `tbl_education` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_feedback`
--

DROP TABLE IF EXISTS `tbl_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_url` text NOT NULL COMMENT 'URL they have concern about',
  `reporter_name` varchar(45) NOT NULL COMMENT 'Required',
  `reporter_email` varchar(255) NOT NULL COMMENT 'Optional',
  `message` text NOT NULL COMMENT 'Feedback message by the users',
  `status` varchar(45) NOT NULL DEFAULT 'Open' COMMENT 'Status of the reported feedback',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_feedback`
--

LOCK TABLES `tbl_feedback` WRITE;
/*!40000 ALTER TABLE `tbl_feedback` DISABLE KEYS */;
INSERT INTO `tbl_feedback` VALUES (1,'http://tools.agencythriveprogram.app/customer/listing','jim.campbell@engagex.com','jim.campbell@engagex.com','joven','Open','2017-08-27 02:10:05',NULL,1),(2,'http://tools.agencythriveprogram.app/customer/listing','jim.campbell@engagex.com','jim.campbell@engagex.com','86832','Open','2017-08-27 02:12:47',NULL,1),(3,'http://tools.agencythriveprogram.app/customer/listing','jim.campbell@engagex.com','jim.campbell@engagex.com','556789','Open','2017-08-27 02:14:03',NULL,1),(4,'http://tools.agencythriveprogram.app/customer/listing','jim.campbell@engagex.com','jim.campbell@engagex.com','556789','Open','2017-08-27 02:14:03',NULL,1),(5,'http://tools.agencythriveprogram.app/customer/listing','jim.campbell@engagex.com','jim.campbell@engagex.com','est','Open','2017-08-27 02:15:23',NULL,1),(6,'http://tools.agencythriveprogram.app/customer/listing','jim.campbell@engagex.com','jim.campbell@engagex.com','j','Open','2017-08-27 02:19:02',NULL,1),(7,'http://tools.agencythriveprogram.app/customer/listing','jim.campbell@engagex.com','jim.campbell@engagex.com','test','Open','2017-08-27 02:19:47',NULL,1),(8,'http://tools.agencythriveprogram.app/customer/listing','jim.campbell@engagex.com','jim.campbell@engagex.com','jkj','Open','2017-08-27 02:20:09',NULL,1),(9,'http://tools.agencythriveprogram.app/customer/listing','jim.campbell@engagex.com','jim.campbell@engagex.com','lkjdflgf','Open','2017-08-27 02:20:34',NULL,1),(10,'http://tools.agencythriveprogram.app/customer/listing','jim.campbell@engagex.com','jim.campbell@engagex.com','ff','Open','2017-08-27 02:21:02',NULL,1),(11,'http://tools.agencythriveprogram.app/account/action_item?customer_id=72','jim.campbell@engagex.com','jim.campbell@engagex.com','test','Open','2017-08-27 20:50:33',NULL,1),(12,'http://tools.agencythriveprogram.app/account/action_item?customer_id=72','jim.campbell@engagex.com','jim.campbell@engagex.com','kkl','Open','2017-08-27 20:51:19',NULL,1),(13,'http://tools.agencythriveprogram.app/account/action_item','jim.campbell@engagex.com','jim.campbell@engagex.com','this is action item page','Open','2017-08-28 23:38:41',NULL,1),(14,'http://tools.agencythriveprogram.app/account/action_item','jim.campbell@engagex.com','jim.campbell@engagex.com','test\r\n','Open','2017-09-07 06:37:52',NULL,1);
/*!40000 ALTER TABLE `tbl_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_goals_concern`
--

DROP TABLE IF EXISTS `tbl_goals_concern`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_goals_concern` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `ci_review_guid` varchar(255) DEFAULT NULL,
  `action_type` varchar(45) DEFAULT NULL COMMENT 'This only save "Goal" and "Concern"',
  `action_description` varchar(255) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `cir_answer` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_goals_concern`
--

LOCK TABLES `tbl_goals_concern` WRITE;
/*!40000 ALTER TABLE `tbl_goals_concern` DISABLE KEYS */;
INSERT INTO `tbl_goals_concern` VALUES (1,61,NULL,'Concern','Tesggha',1,NULL),(2,61,NULL,'Goal','Joven',1,NULL),(3,61,NULL,'Concern','Testing',1,NULL),(4,61,NULL,'Concern','Yesy',1,NULL),(5,72,NULL,'Goal','Repair my home window',1,NULL),(6,72,NULL,'Goal','Want to be successfull',1,NULL),(7,72,NULL,'Concern','Have some issue with my window',1,NULL),(8,72,NULL,'Concern','Have some issue with my door knob',1,NULL),(9,72,NULL,'Concern','232323',1,NULL),(10,72,NULL,'Concern','12222',1,NULL),(11,61,NULL,'Goal','345435',1,NULL),(12,61,NULL,'Goal','',1,NULL),(13,53,NULL,'Goal','Have Car and Big House',1,NULL);
/*!40000 ALTER TABLE `tbl_goals_concern` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_life_changes`
--

DROP TABLE IF EXISTS `tbl_life_changes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_life_changes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `life_question` varchar(45) DEFAULT NULL,
  `life_answer` varchar(45) DEFAULT NULL,
  `cir_answer` varchar(255) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_life_changes`
--

LOCK TABLES `tbl_life_changes` WRITE;
/*!40000 ALTER TABLE `tbl_life_changes` DISABLE KEYS */;
INSERT INTO `tbl_life_changes` VALUES (9,72,NULL,'Birth/Adoption','Birth/Adoption',NULL,1),(10,72,NULL,'Accident','Accident',NULL,1),(11,72,NULL,'Retired','Retired',NULL,1),(55,61,NULL,'New Driver','New Driver','New Driver, Accident, ',1),(56,61,NULL,'Accident','Accident','New Driver, Accident, ',1),(57,62,'44f683a84163b3523afe57c2e008bc8c','Birth/Adoption','Birth/Adoption','Birth/Adoption, Home Purchase/Sale, Move, Purchase/Sold Vehicle, Retired, ',1),(58,62,'44f683a84163b3523afe57c2e008bc8c','Home Purchase/Sale','Home Purchase/Sale','Birth/Adoption, Home Purchase/Sale, Move, Purchase/Sold Vehicle, Retired, ',1),(59,62,'44f683a84163b3523afe57c2e008bc8c','Move','Move','Birth/Adoption, Home Purchase/Sale, Move, Purchase/Sold Vehicle, Retired, ',1),(60,62,'44f683a84163b3523afe57c2e008bc8c','Purchase/Sold Vehicle','Purchase/Sold Vehicle','Birth/Adoption, Home Purchase/Sale, Move, Purchase/Sold Vehicle, Retired, ',1),(61,62,'44f683a84163b3523afe57c2e008bc8c','Retired','Retired','Birth/Adoption, Home Purchase/Sale, Move, Purchase/Sold Vehicle, Retired, ',1),(62,58,'66f041e16a60928b05a7e228a89c3799','New Driver','New Driver','New Driver, Accident, Acquired Boat/ATV etc., Job Change, ',1),(63,58,'66f041e16a60928b05a7e228a89c3799','Accident','Accident','New Driver, Accident, Acquired Boat/ATV etc., Job Change, ',1),(64,58,'66f041e16a60928b05a7e228a89c3799','Acquired Boat/ATV etc.','Acquired Boat/ATV etc.','New Driver, Accident, Acquired Boat/ATV etc., Job Change, ',1),(65,58,'66f041e16a60928b05a7e228a89c3799','Job Change','Job Change','New Driver, Accident, Acquired Boat/ATV etc., Job Change, ',1),(66,53,'d82c8d1619ad8176d665453cfb2e55f0','New Driver','New Driver','Joven 2',1),(67,53,'d82c8d1619ad8176d665453cfb2e55f0','Acquired Boat/ATV etc.','Acquired Boat/ATV etc.','Joven 2',1),(68,53,'d82c8d1619ad8176d665453cfb2e55f0','Job Change','Job Change','Joven 2',1);
/*!40000 ALTER TABLE `tbl_life_changes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_long_term_goals`
--

DROP TABLE IF EXISTS `tbl_long_term_goals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_long_term_goals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `first_goal` text,
  `second_goal` text,
  `account_id` int(11) NOT NULL,
  `cir_answer` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_long_term_goals`
--

LOCK TABLES `tbl_long_term_goals` WRITE;
/*!40000 ALTER TABLE `tbl_long_term_goals` DISABLE KEYS */;
INSERT INTO `tbl_long_term_goals` VALUES (4,72,NULL,'jkjkkj','hjkhjkhjk',1,NULL),(13,62,'44f683a84163b3523afe57c2e008bc8c','Test','Test',1,NULL),(17,61,NULL,'Im only a test description number 1','Im only a test description number 2',1,NULL),(18,58,'66f041e16a60928b05a7e228a89c3799','This is another note 1','This is another note 2',1,NULL),(19,53,'d82c8d1619ad8176d665453cfb2e55f0','Example Goal #1','Example Goal #2 \' and the other things',1,NULL);
/*!40000 ALTER TABLE `tbl_long_term_goals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_needs_assessment`
--

DROP TABLE IF EXISTS `tbl_needs_assessment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_needs_assessment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `assessment_submitted_to` varchar(255) DEFAULT NULL COMMENT 'Email address of NA receipient',
  `is_steps_completed` tinyint(4) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_needs_assessment`
--

LOCK TABLES `tbl_needs_assessment` WRITE;
/*!40000 ALTER TABLE `tbl_needs_assessment` DISABLE KEYS */;
INSERT INTO `tbl_needs_assessment` VALUES (3,NULL,72,'joven+14@agencythriveprogram.app',1,1),(7,'44f683a84163b3523afe57c2e008bc8c',62,'joven+a1@agencythriveprogram.app',1,1),(13,NULL,61,'joven+b1@agencythriveprogram.app',1,1),(14,'44f683a84163b3523afe57c2e008bc8c',72,'joven@agencythriveprogram.app',1,1),(15,'66f041e16a60928b05a7e228a89c3799',58,'joven+1@agencythriveprogram.app',1,1),(16,'d82c8d1619ad8176d665453cfb2e55f0',53,'joven+1@agencythriveprogram.app',1,1);
/*!40000 ALTER TABLE `tbl_needs_assessment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_note`
--

DROP TABLE IF EXISTS `tbl_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `msg_note` text,
  `dom_element` varchar(45) DEFAULT NULL COMMENT 'DOM element',
  `created_at` timestamp NULL DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_note`
--

LOCK TABLES `tbl_note` WRITE;
/*!40000 ALTER TABLE `tbl_note` DISABLE KEYS */;
INSERT INTO `tbl_note` VALUES (1,62,'http://tools.agencythriveprogram.app/agentprep/step_customer2','This is you notes for this Customer Contact Page - Secondary','.page-note','2017-08-16 16:00:00',1),(4,62,'http://tools.agencythriveprogram.app/agentprep/step_current_coverages','Auto section','.page-note_Home','2017-08-17 16:00:00',1),(5,62,'http://tools.agencythriveprogram.app/agentprep/step_current_coverages','Home section','.page-note_Home','2017-08-17 16:00:00',1),(6,62,'http://tools.agencythriveprogram.app/agentprep/step_current_coverages','This auto section','.page-note_Auto','2017-08-20 16:00:00',1),(8,72,'http://tools.agencythriveprogram.app/agentprep/step_current_coverages','Auto section here you can it by clicking Add Note button again','.page-note_Auto','2017-08-22 16:00:00',1),(11,61,'http://tools.agencythriveprogram.app/agentprep/step_current_coverages','Im auto section here','.page-note_Auto','2017-08-30 16:00:00',1),(13,61,'http://tools.agencythriveprogram.app/agentprep/step_current_coverages','Im a home section','.page-note_Home','2017-08-31 16:00:00',1),(14,72,'http://tools.agencythriveprogram.app/agentprep/step_customer1?customer_id=72','My notes for Customer Information','.page-note','2017-09-06 16:00:00',1);
/*!40000 ALTER TABLE `tbl_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_policies_in_place`
--

DROP TABLE IF EXISTS `tbl_policies_in_place`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_policies_in_place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `policy_parent_label` varchar(45) DEFAULT NULL,
  `policy_child_label` varchar(45) DEFAULT NULL,
  `policy_child_selected` varchar(145) DEFAULT NULL,
  `insurance_company` varchar(255) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_policies_in_place`
--

LOCK TABLES `tbl_policies_in_place` WRITE;
/*!40000 ALTER TABLE `tbl_policies_in_place` DISABLE KEYS */;
INSERT INTO `tbl_policies_in_place` VALUES (23,73,NULL,'Auto','Make/Model','Toyota','656',13),(38,72,NULL,'Auto','Liability','100/300','546546456',1),(40,72,NULL,'Auto','Medical','C','4545454',1),(41,72,NULL,'Auto','Medical','C','4545454',1),(42,72,NULL,'Auto','Medical','C','4545454',1),(43,72,NULL,'Auto','Medical','C','4545454',1),(48,72,NULL,'Auto','Liability','25/50','ohkjhkhkj',1),(49,72,NULL,'Auto','Roadside/Tow','A','asdfghjkl',1),(50,72,NULL,'Auto','Roadside/Tow','A','asdfghjkl',1),(51,72,NULL,'Auto','Liability','25/50','ohkjhkhkj',1),(52,62,'44f683a84163b3523afe57c2e008bc8c','Home','Type','B','Company 1',1),(55,62,'44f683a84163b3523afe57c2e008bc8c','Home','Type','A','Omp',1),(57,62,'44f683a84163b3523afe57c2e008bc8c','Auto','Make/Model',' Toyota Corolla','Best Insurance',1),(58,62,'44f683a84163b3523afe57c2e008bc8c','Auto','Make/Model','Honda Vios','Rolce Insurance',1),(60,61,'7f39f8317fbdb1988ef4c628eba02591','Home','Type','A','Home Depot Insurance',1),(61,61,'7f39f8317fbdb1988ef4c628eba02591','Life','Life 1','','Medical Pract',1),(62,58,'66f041e16a60928b05a7e228a89c3799','Home','Type','B','Insurance 1',1),(63,58,'66f041e16a60928b05a7e228a89c3799','Personal_Liability','Test1','C','Insurance 1',1),(64,53,'d82c8d1619ad8176d665453cfb2e55f0','Home','Type','A','Insurance 1',1);
/*!40000 ALTER TABLE `tbl_policies_in_place` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_policy_line_question`
--

DROP TABLE IF EXISTS `tbl_policy_line_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_policy_line_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `policy_parent_label` varchar(45) DEFAULT NULL,
  `policy_child_label` varchar(45) DEFAULT NULL,
  `policy_child_selected` varchar(45) DEFAULT NULL,
  `cir_answer` varchar(45) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_policy_line_question`
--

LOCK TABLES `tbl_policy_line_question` WRITE;
/*!40000 ALTER TABLE `tbl_policy_line_question` DISABLE KEYS */;
INSERT INTO `tbl_policy_line_question` VALUES (1,72,NULL,'Auto','Auto','Yes',NULL,1),(2,62,NULL,'Auto','Auto','No','No',1),(3,62,NULL,'Home','Home','No','No',1),(4,62,NULL,'Life','Life','Yes',NULL,1),(5,61,NULL,'Auto','Auto','Yes','Yes',1),(6,61,NULL,'Life','Life','Yes',NULL,1),(7,58,NULL,'Auto','Auto','No','No',1),(8,58,NULL,'Home','Home','Yes','Yes',1),(9,58,NULL,'Life','Life','Yes',NULL,1),(10,58,NULL,'Personal_Liability','Personal_Liability','No',NULL,1),(11,53,NULL,'Auto','Auto','No','Joven 1',1),(12,53,NULL,'Home','Home','No','No',1),(13,53,NULL,'Life','Life','Yes',NULL,1),(14,53,NULL,'Personal_Liability','Personal_Liability','Yes',NULL,1);
/*!40000 ALTER TABLE `tbl_policy_line_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_referral`
--

DROP TABLE IF EXISTS `tbl_referral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_referral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refer_name` varchar(145) DEFAULT NULL,
  `refer_email` varchar(145) DEFAULT NULL,
  `refer_phone` varchar(145) DEFAULT NULL,
  `refer_note` varchar(245) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_referral`
--

LOCK TABLES `tbl_referral` WRITE;
/*!40000 ALTER TABLE `tbl_referral` DISABLE KEYS */;
INSERT INTO `tbl_referral` VALUES (1,'Joven','Barola','(324)-324-2342','324324234234234',1,53),(12,'Joven','Barola','','',1,53),(13,'Joven','Barola','','',1,58),(14,'Report','234434','','',1,58);
/*!40000 ALTER TABLE `tbl_referral` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_reporting`
--

DROP TABLE IF EXISTS `tbl_reporting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_reporting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_name` varchar(45) DEFAULT NULL,
  `data1` text,
  `data2` text,
  `data3` text,
  `data4` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_reporting`
--

LOCK TABLES `tbl_reporting` WRITE;
/*!40000 ALTER TABLE `tbl_reporting` DISABLE KEYS */;
INSERT INTO `tbl_reporting` VALUES (58,'action_item','<tr style=\"background-color: #045aa5;color:white;\"><td>Column1</td><td>Column2</td><td>Column3</td><td>Column4</td><td>Column5</td><td>Column6</td><td>Column7</td><td>Column8</td><td>Column9</td><td>Column10</td><td>Column11</td><td>Column12</td></tr>','<tr><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td></tr><tr><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td></tr><tr><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td></tr><tr><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td></tr><tr><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td></tr><tr><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td></tr><tr><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td></tr><tr><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td></tr><tr><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td></tr><tr><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td></tr><tr><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td></tr>','',NULL);
/*!40000 ALTER TABLE `tbl_reporting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_top_concerns`
--

DROP TABLE IF EXISTS `tbl_top_concerns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_top_concerns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `concern_question` varchar(45) DEFAULT NULL,
  `concern_answer` varchar(45) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `cir_answer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_top_concerns`
--

LOCK TABLES `tbl_top_concerns` WRITE;
/*!40000 ALTER TABLE `tbl_top_concerns` DISABLE KEYS */;
INSERT INTO `tbl_top_concerns` VALUES (13,72,NULL,'Critical Illness','Critical Illness',1,NULL),(14,72,NULL,'Protecting Your Home','Protecting Your Home',1,NULL),(15,72,NULL,'Income Protection','Income Protection',1,NULL),(58,61,NULL,'Protecting Vehicles','Protecting Vehicles',1,'on'),(59,61,NULL,'Protecting Your Home','Protecting Your Home',1,'on'),(63,62,'44f683a84163b3523afe57c2e008bc8c','Retirement Planning','Retirement Planning',1,'on'),(64,62,'44f683a84163b3523afe57c2e008bc8c','Savings','Savings',1,'on'),(65,62,'44f683a84163b3523afe57c2e008bc8c','Protecting Your Home','Protecting Your Home',1,'on'),(66,58,'66f041e16a60928b05a7e228a89c3799','Savings','Savings',1,'on'),(67,58,'66f041e16a60928b05a7e228a89c3799','Critical Illness','Critical Illness',1,'on'),(68,58,'66f041e16a60928b05a7e228a89c3799','Long-Term Care','Long-Term Care',1,'on'),(69,53,'d82c8d1619ad8176d665453cfb2e55f0','Long-Term Care','Long-Term Care',1,'on');
/*!40000 ALTER TABLE `tbl_top_concerns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `roles` varchar(45) NOT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (2,'jim.campbell@engagex.com','c92144f2bfc3a21cccf369fbc744a473','jim.campbell@engagex.com','admin',1),(3,'joven.barola@engagex.com','914bafe46a39ad5f7b7f96045c645450','joven.barola@engagex.com','admin',0),(5,'joven@agencythriveprogram.app','914bafe46a39ad5f7b7f96045c645450','joven@agencythriveprogram.app','admin',0),(6,'joven+1@agencythriveprogram.app','c92144f2bfc3a21cccf369fbc744a473','joven+1@agencythriveprogram.app','admin',0),(7,'test@agencythriveprogram.app','cc03e747a6afbbcbf8be7668acfebee5','test@agencythriveprogram.app','admin',0),(8,'joven+14@agencythriveprogram.app','cc03e747a6afbbcbf8be7668acfebee5','joven+14@agencythriveprogram.app','admin',0),(9,'joven+2@agencythriveprogram.app','c92144f2bfc3a21cccf369fbc744a473','joven+2@agencythriveprogram.app','admin',0),(10,'joven+3@agencythriveprogram.app','c92144f2bfc3a21cccf369fbc744a473','joven+3@agencythriveprogram.app','admin',0),(11,'joven+4@agencythriveprogram.app','c92144f2bfc3a21cccf369fbc744a473','joven+4@agencythriveprogram.app','admin',0),(12,'joven+5@agencythriveprogram.app','c92144f2bfc3a21cccf369fbc744a473','joven+5@agencythriveprogram.app','admin',0),(13,'joven+8@agencythriveprogram.app','c92144f2bfc3a21cccf369fbc744a473','joven+8@agencythriveprogram.app','admin',12),(14,'joven+20@agencythriveprogram.app','c92144f2bfc3a21cccf369fbc744a473','joven+20@agencythriveprogram.app','admin',13);
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'agency_thrive_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-12 12:18:20
