-- MySQL dump 10.14  Distrib 5.5.56-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: grad_tracker
-- ------------------------------------------------------
-- Server version	5.5.56-MariaDB

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
-- Table structure for table `advisor`
--

DROP TABLE IF EXISTS `advisor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advisor` (
  `advisor_id` int(15) NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `middle_initial` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `advisor_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`advisor_id`),
  KEY `Advisor ID` (`advisor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advisor`
--

LOCK TABLES `advisor` WRITE;
/*!40000 ALTER TABLE `advisor` DISABLE KEYS */;
INSERT INTO `advisor` VALUES (11111,'Jerry','D','Fails','jfails@boisestate.edu'),(22222,'Ron','D','Campbell','ronaldcampbell@u.boisestate.edu'),(33333333,'Ramzi','R','Korkor','ramzikorkor@u.boisestate.edu'),(44444444,'Connor','B','Nagel','cnagel@u.boisestate.edu'),(55555555,'Huma','A','Aatifi','haatifi@u.boisestate.edu'),(66666666,'Monica','A','Robison','mrobison@u.boisestate.edu');
/*!40000 ALTER TABLE `advisor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `class_id` int(4) NOT NULL AUTO_INCREMENT,
  `recordID` int(4) NOT NULL,
  `class_number` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `class_name` char(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `professor` char(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `term_year` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `grade` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `course_credits` int(2) NOT NULL,
  PRIMARY KEY (`class_id`),
  KEY `recordID` (`recordID`),
  KEY `Class ID` (`class_id`),
  CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`recordID`) REFERENCES `semester` (`recordID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,2,'CS410','Databases','Mike Lynott','Fall 2018','A',4),(2,6,'CS354','Programming Languages','Jim Buffenburger','Spring 2018','B',3),(5,7,'CS361','Theory of Computation','Sherman','Fall 2019','A',3),(8,10,'','','','','',0);
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semester`
--

DROP TABLE IF EXISTS `semester`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `semester` (
  `recordID` int(15) NOT NULL AUTO_INCREMENT,
  `term_year` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `student_id` int(15) NOT NULL,
  `advisorResponse` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `advisor` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `progressReport` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `semester_goals` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `gpa` double(15,2) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordID`),
  KEY `student_id` (`student_id`),
  KEY `Record ID` (`recordID`),
  CONSTRAINT `semester_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semester`
--

LOCK TABLES `semester` WRITE;
/*!40000 ALTER TABLE `semester` DISABLE KEYS */;
INSERT INTO `semester` VALUES (2,'Fall 2018',113138282,'response test','Jerry Fails','progress report test','goals test',3.40,'2018-03-21 03:20:11'),(6,'Spring 2018',1122334455,'advisor response test','Maria Stone','report test','goal test',3.00,'2018-03-21 03:20:58'),(7,'Fall 2019',113138282,'','NULL','I done good','do better',1.00,'2018-03-22 19:54:09'),(10,'',113138282,'','NULL','','',1.00,'2018-03-22 20:21:34');
/*!40000 ALTER TABLE `semester` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `student_id` int(15) NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `middle_initial` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `student_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `grad_gpa` double(15,2) DEFAULT NULL,
  `advisor_id` int(15) NOT NULL,
  PRIMARY KEY (`student_id`),
  KEY `Student ID` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (113138282,'Tina','R','Johnson','tjohnson@u.boisestate.edu',1.80,22222),(1122334455,'Tom','D','Smith','tsmith@u.boisestate.edu',3.10,11111);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-22 14:31:07
