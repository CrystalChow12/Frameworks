-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: task_management_system
-- ------------------------------------------------------
-- Server version	8.0.38

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Roles_role_key` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin'),(3,'Employee'),(2,'Manager');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roleuser`
--

DROP TABLE IF EXISTS `roleuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roleuser` (
  `userId` int NOT NULL,
  `roleId` int NOT NULL,
  PRIMARY KEY (`userId`,`roleId`),
  UNIQUE KEY `RoleUser_userId_key` (`userId`),
  KEY `RoleUser_roleId_fkey` (`roleId`),
  CONSTRAINT `RoleUser_roleId_fkey` FOREIGN KEY (`roleId`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `RoleUser_userId_fkey` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roleuser`
--

LOCK TABLES `roleuser` WRITE;
/*!40000 ALTER TABLE `roleuser` DISABLE KEYS */;
INSERT INTO `roleuser` VALUES (1,3),(2,2),(10,2),(11,3),(13,2),(14,3),(15,1);
/*!40000 ALTER TABLE `roleuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Pending','Completed','In_Progress') COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` datetime(3) DEFAULT NULL,
  `comments` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_to` int NOT NULL,
  `created_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Tasks_assigned_to_fkey` (`assigned_to`),
  KEY `Tasks_created_by_fkey` (`created_by`),
  CONSTRAINT `Tasks_assigned_to_fkey` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `Tasks_created_by_fkey` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,'new thing','Pending','2024-12-08 00:00:00.000',NULL,11,13),(7,'create wireframe with the team ','Pending','2024-11-02 00:00:00.000',NULL,1,13),(14,'Meet with the stakeholders. ','Completed','2024-06-08 00:00:00.000','easy task ',14,13),(15,'Send in revised documentation.','In_Progress','2024-11-06 00:00:00.000','',14,13),(16,'Create 2nd prototype. ','Pending','2024-12-02 00:00:00.000',NULL,14,13),(17,'review nist framework ','Pending','2024-10-22 00:00:00.000',NULL,1,13);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Users_username_key` (`username`),
  UNIQUE KEY `Users_email_key` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'crystal.chow','crystal.n.chow12@gmail.com','$2y$10$7pPj8h3/lR5xGAC/QA6F9.X6/pO2a9vrjjFlu0uWOsAm5EvBBeCmy'),(2,'sukuna.heian','vessel@email.com','$2y$10$SHC83Yd.fUl/MUg8c0beQuS4O/wQ/ZhvFUSIDieUfe2e7AxEx.bBS'),(10,'john.doe','johndoe@email.com','$2y$10$F6Q7q9mu5F2wZMpFUQ4X4.DDgBJA/00fZWwS0SvIRvetZrVucGvGC'),(11,'alex.smith','alexsmith@email.com','$2y$10$Uc.jlc5A2XsVuuF7oxxS0uPxEL1PDww95Ic2bwi15xtGNDvTWVdwi'),(13,'dummy.manager','dummy@email.com','$2y$10$tx6Y4c19y190Np2AnisSOeYskb4FWYeZAHZDpNRfKJlgbGgxQ/s2.'),(14,'dummy.employee','dummyEmp@email.com','$2y$10$dx9qPTdcWZ.Dp.rxvhKSIuJnqqz1aqyujmybwRbxWVbyU6egmycVa'),(15,'dummy.admin','dummyAdmin@email.com','$2y$10$CRvaoUqCghF79FEc1LpPOOQk.Rff2Zt1d4fqBNE1uN7D2IhZ18nzG');
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

-- Dump completed on 2024-10-20 22:57:32
