CREATE DATABASE  IF NOT EXISTS `agency_thrive_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `agency_thrive_db`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: agency_thrive_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.13-MariaDB

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
  `apointment_locations` text,
  `staff` text,
  `colour_scheme_id` int(11) NOT NULL DEFAULT '1',
  `is_auto_checked` tinyint(4) DEFAULT '1' COMMENT 'Check: tbl_policy_type',
  `is_home_checked` tinyint(4) DEFAULT '1' COMMENT 'Check: tbl_policy_type',
  `is_activated` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_account_setup`
--

LOCK TABLES `tbl_account_setup` WRITE;
/*!40000 ALTER TABLE `tbl_account_setup` DISABLE KEYS */;
INSERT INTO `tbl_account_setup` VALUES (1,'Jim','Campbell','jim.campbell@engagex.com','Engagex','39bb28d08c12c4c98300297262c663d0.png','Africa/Casablanca','d41d8cd98f00b204e9800998ecf8427e','2017-08-03 08:46:10',NULL,'smtp.agencythriveprogram.com','jim.campbell@engagex.com','Letmein12@','Makati,Ortigas,BGC,Alabang','Joven,Meriam,Kenjie,Kaylie,Jimmy',1,1,1,1),(2,'','','joven.barola@engagex.com','Engagex',NULL,'','914bafe46a39ad5f7b7f96045c645450','2017-07-30 08:36:19',NULL,NULL,NULL,NULL,NULL,NULL,0,1,1,1),(4,'Joven','Barola','joven@agencythriveprogram.app','Engagex','f1b0cc217e8175a5beb225abc45f054d.jpg','UTC 08:00','914bafe46a39ad5f7b7f96045c645450','2017-08-08 17:19:31',NULL,'smtp.agencythriveprogram.app','joven@agencythriveprogram.app','Kenji2012','Makati,BGC,Ortigas','Joven,Kenjie,Kaylie,Kobie',5,1,1,1),(5,'','','joven+1@agencythriveprogram.app','Engagex',NULL,'','c92144f2bfc3a21cccf369fbc744a473','2017-08-04 17:49:32',NULL,NULL,NULL,NULL,NULL,NULL,1,1,1,0);
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
  `policy_parent_label` enum('Auto','Home') DEFAULT NULL COMMENT 'Values are: "Home" and "Auto"',
  `policy_child_label` varchar(45) DEFAULT NULL,
  `policy_child_questions` text,
  `policy_child_values` mediumtext,
  `is_child_checked` tinyint(4) DEFAULT '0',
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_policy_parent` (`policy_parent_label`)
) ENGINE=InnoDB AUTO_INCREMENT=288 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_account_setup_policy`
--

LOCK TABLES `tbl_account_setup_policy` WRITE;
/*!40000 ALTER TABLE `tbl_account_setup_policy` DISABLE KEYS */;
INSERT INTO `tbl_account_setup_policy` VALUES (1,'Auto','Honda','43/23,22,22','43/23,22,221',1,1),(283,'Auto','test1','test1','11111111111111',1,4),(284,'Auto','test2','test2','',1,4),(285,'Home','aaaa','aaaa','11221122',1,4),(286,'Home','bbbb','bbbb','bbbb222bbb222',1,4);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_action_item`
--

LOCK TABLES `tbl_action_item` WRITE;
/*!40000 ALTER TABLE `tbl_action_item` DISABLE KEYS */;
INSERT INTO `tbl_action_item` VALUES (1,2,'','Kenjie','Engagex',NULL,1,0,'2017-07-27','2017-07-28',1),(6,53,'','Kenjie','test',NULL,1,1,'2017-08-03','2017-08-03',1),(8,61,'','Jimmy','Wow',NULL,0,0,'2017-08-03','2017-08-03',1),(9,64,'','Joven','Test251111',NULL,1,1,'2017-08-10','2017-08-22',4),(10,65,'','Joven','Test',NULL,0,1,'2017-08-04','2017-08-04',4);
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
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL COMMENT 'This store comma delimited data, to use for referencing on a Transaction',
  `meta_value` text COMMENT 'This store json data, or plain data',
  `account_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_activity_meta`
--

LOCK TABLES `tbl_activity_meta` WRITE;
/*!40000 ALTER TABLE `tbl_activity_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_activity_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_appointment`
--

DROP TABLE IF EXISTS `tbl_appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_appointment` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` varchar(45) NOT NULL,
  `location` varchar(45) NOT NULL COMMENT 'Check: tbl_account_setup',
  `is_completed` tinyint(4) DEFAULT NULL COMMENT 'Flag if steps are now completed',
  `assessment_guid` varchar(255) DEFAULT NULL COMMENT 'Relate: Need Assessment',
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_appointment`
--

LOCK TABLES `tbl_appointment` WRITE;
/*!40000 ALTER TABLE `tbl_appointment` DISABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ci_review`
--

LOCK TABLES `tbl_ci_review` WRITE;
/*!40000 ALTER TABLE `tbl_ci_review` DISABLE KEYS */;
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
INSERT INTO `tbl_colour_scheme` VALUES (1,'Default Theme','null','null','null',1),(2,'Theme 1','#f2ab14','#070600','#070800',1),(4,'Theme 2','#C2847A','#280003','#848586',1),(5,'Custom','#0b5394','#0c343d','#fff2cc',1);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_current_coverage`
--

LOCK TABLES `tbl_current_coverage` WRITE;
/*!40000 ALTER TABLE `tbl_current_coverage` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer`
--

LOCK TABLES `tbl_customer` WRITE;
/*!40000 ALTER TABLE `tbl_customer` DISABLE KEYS */;
INSERT INTO `tbl_customer` VALUES (2,'Jim','Campbell',NULL,NULL,NULL,NULL,NULL,NULL,'Jim',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-07-27 03:55:30',NULL,1),(53,'Kaylie','Barola',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-07-27 05:31:34',NULL,1),(58,'Tom','Jones',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-07-28 05:35:11',NULL,1),(61,'Bart','Simpson',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-07-28 07:34:12',NULL,1),(62,'Kenjie','Kumukura',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-07-29 04:38:10',NULL,1),(64,'Joven','Barola',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-08-04 18:52:17',NULL,4),(65,'Jim','Campbell',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-08-04 18:52:27',NULL,4),(66,'Ligaya','Barola',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-08-04 21:15:38',NULL,4);
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_dependent`
--

LOCK TABLES `tbl_dependent` WRITE;
/*!40000 ALTER TABLE `tbl_dependent` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_education`
--

LOCK TABLES `tbl_education` WRITE;
/*!40000 ALTER TABLE `tbl_education` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_feedback`
--

LOCK TABLES `tbl_feedback` WRITE;
/*!40000 ALTER TABLE `tbl_feedback` DISABLE KEYS */;
INSERT INTO `tbl_feedback` VALUES (1,'https://tools.agencythriveprogram.com/site/index','jim.campbell@engagex.com','jim.campbell@engagex.com','This is looking good ','Open','2017-07-28 04:41:30',NULL,1),(2,'https://tools.agencythriveprogram.com/site/index','jim.campbell@engagex.com','jim.campbell@engagex.com','This is looking good ','Open','2017-07-28 04:41:30',NULL,1),(3,'https://tools.agencythriveprogram.com/account/setup','jim.campbell@engagex.com','jim.campbell@engagex.com','Test','Open','2017-07-31 06:41:30',NULL,1);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_goals_concern`
--

LOCK TABLES `tbl_goals_concern` WRITE;
/*!40000 ALTER TABLE `tbl_goals_concern` DISABLE KEYS */;
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
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_life_changes`
--

LOCK TABLES `tbl_life_changes` WRITE;
/*!40000 ALTER TABLE `tbl_life_changes` DISABLE KEYS */;
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
  `goal_question` varchar(45) DEFAULT NULL,
  `goal_answer` text,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_long_term_goals`
--

LOCK TABLES `tbl_long_term_goals` WRITE;
/*!40000 ALTER TABLE `tbl_long_term_goals` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_needs_assessment`
--

LOCK TABLES `tbl_needs_assessment` WRITE;
/*!40000 ALTER TABLE `tbl_needs_assessment` DISABLE KEYS */;
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
  `created_at` timestamp NULL DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_note`
--

LOCK TABLES `tbl_note` WRITE;
/*!40000 ALTER TABLE `tbl_note` DISABLE KEYS */;
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
  `insurance_company` varchar(255) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_policies_in_place`
--

LOCK TABLES `tbl_policies_in_place` WRITE;
/*!40000 ALTER TABLE `tbl_policies_in_place` DISABLE KEYS */;
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
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_policy_line_question`
--

LOCK TABLES `tbl_policy_line_question` WRITE;
/*!40000 ALTER TABLE `tbl_policy_line_question` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_policy_line_question` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_reporting`
--

LOCK TABLES `tbl_reporting` WRITE;
/*!40000 ALTER TABLE `tbl_reporting` DISABLE KEYS */;
INSERT INTO `tbl_reporting` VALUES (43,'action_item','<tr style=\"background-color: #045aa5;color:white;\"><td>Column1</td><td>Column2</td><td>Column3</td><td>Column4</td><td>Column5</td><td>Column6</td><td>Column7</td><td>Column8</td><td>Column9</td><td>Column10</td><td>Column11</td><td>Column12</td></tr>','<tr><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td></tr><tr><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td></tr><tr><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td></tr><tr><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td></tr><tr><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td></tr><tr><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td></tr><tr><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td></tr><tr><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td></tr><tr><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td></tr><tr><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td></tr><tr><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td></tr>','',NULL);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_top_concerns`
--

LOCK TABLES `tbl_top_concerns` WRITE;
/*!40000 ALTER TABLE `tbl_top_concerns` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (2,'jim.campbell@engagex.com','c92144f2bfc3a21cccf369fbc744a473','jim.campbell@engagex.com','admin',1),(3,'joven.barola@engagex.com','914bafe46a39ad5f7b7f96045c645450','joven.barola@engagex.com','admin',0),(5,'joven@agencythriveprogram.app','914bafe46a39ad5f7b7f96045c645450','joven@agencythriveprogram.app','admin',0),(6,'joven+1@agencythriveprogram.app','c92144f2bfc3a21cccf369fbc744a473','joven+1@agencythriveprogram.app','admin',0);
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vw_action_item`
--

DROP TABLE IF EXISTS `vw_action_item`;
/*!50001 DROP VIEW IF EXISTS `vw_action_item`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vw_action_item` AS SELECT 
 1 AS `primary_firstname`,
 1 AS `primary_lastname`,
 1 AS `primary_telno`,
 1 AS `primary_email`,
 1 AS `primary_emergency_contact`,
 1 AS `secondary_firstname`,
 1 AS `secondary_lastname`,
 1 AS `secondary_telno`,
 1 AS `secondary_email`,
 1 AS `secondary_emergency_contact`,
 1 AS `id`,
 1 AS `customer_id`,
 1 AS `action_type_code`,
 1 AS `owner`,
 1 AS `description`,
 1 AS `ci_review_guid`,
 1 AS `is_opportunity`,
 1 AS `is_completed`,
 1 AS `created_date`,
 1 AS `due_date`,
 1 AS `account_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vw_action_item`
--

/*!50001 DROP VIEW IF EXISTS `vw_action_item`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_action_item` AS select `c`.`primary_firstname` AS `primary_firstname`,`c`.`primary_lastname` AS `primary_lastname`,`c`.`primary_telno` AS `primary_telno`,`c`.`primary_email` AS `primary_email`,`c`.`primary_emergency_contact` AS `primary_emergency_contact`,`c`.`secondary_firstname` AS `secondary_firstname`,`c`.`secondary_lastname` AS `secondary_lastname`,`c`.`secondary_telno` AS `secondary_telno`,`c`.`secondary_email` AS `secondary_email`,`c`.`secondary_emergency_contact` AS `secondary_emergency_contact`,`a`.`id` AS `id`,`a`.`customer_id` AS `customer_id`,`a`.`action_type_code` AS `action_type_code`,`a`.`owner` AS `owner`,`a`.`description` AS `description`,`a`.`ci_review_guid` AS `ci_review_guid`,`a`.`is_opportunity` AS `is_opportunity`,`a`.`is_completed` AS `is_completed`,`a`.`created_date` AS `created_date`,`a`.`due_date` AS `due_date`,`a`.`account_id` AS `account_id` from (`tbl_action_item` `a` left join `tbl_customer` `c` on((`a`.`customer_id` = `c`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-09  7:39:10
