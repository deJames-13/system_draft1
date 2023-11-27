CREATE DATABASE  IF NOT EXISTS `DEHTech_EspinosaLacaoLim_IMSPROJECT` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `DEHTech_EspinosaLacaoLim_IMSPROJECT`;
-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: DEHTech_EspinosaLacaoLim_IMSPROJECT
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

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
-- Table structure for table `benefits`
--

DROP TABLE IF EXISTS `benefits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `benefits` (
  `id` int(11) NOT NULL,
  `philHealth` decimal(10,2) DEFAULT NULL,
  `sss` decimal(10,2) DEFAULT NULL,
  `pagIbig` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `benefits`
--

LOCK TABLES `benefits` WRITE;
/*!40000 ALTER TABLE `benefits` DISABLE KEYS */;
INSERT INTO `benefits` VALUES (2,2000.00,2250.00,1000.00),(3,190.44,214.25,95.22),(4,190.44,214.25,95.22),(5,1904.40,2142.45,952.20),(6,1904.40,2142.45,952.20),(7,1904.40,2142.45,952.20),(8,1904.40,2142.45,952.20),(14,816.00,918.00,408.00),(18,605.16,680.81,302.58);
/*!40000 ALTER TABLE `benefits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`customer_id`,`product_id`),
  KEY `fk_cart_product1_idx` (`product_id`),
  KEY `fk_cart_customer1_idx` (`customer_id`),
  CONSTRAINT `fk_cart_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_cart_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=288 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (147,6,49,1),(151,7,33,1),(175,21,20,1),(192,1002,47,1),(230,1002,2,1),(287,1011,2,1);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` longtext NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` varchar(45) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `image_dir` longtext DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`,`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `user_name_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1012 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (2,'ncamlin1','Nikolai','Colebourn','Camlin','ncamlin1@cloudflare.com','$2y$10$THUcRlcCd88jGKxG9zkJFezRHlAzIKhcmhxz5zcnUTcoPkYLwI9je','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1990-10-23',32,NULL,'2023-08-06'),(5,'jamesTheCreator','James','Espinosa','Monton','de.james013@gmail.com','$2y$10$hve7duJe54YxGohXm2sJ..leZW7v5NPq9GSvPBqbL8DyPbqD2ZifC','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2004-03-13',19,NULL,'2023-08-06'),(6,'potter5','Paxton','Kauble','Otter','potter5@prnewswire.com','$2y$10$isNBvV9h6olU7hlMttj9VuHl91KJFKKFxK/E98s5cwn.JHEeCH7UG','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1990-08-22',32,NULL,'2023-08-06'),(7,'vdemkowicz6','Valentino','Cleugher','Demkowicz','vdemkowicz6@hhs.gov','$2y$10$PMeh4pz/HbDPwtfnDg25qeIo.mqnzbhbi2rUKqb5sCyyoUtmi8Ley','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2005-01-23',18,'./images/customer/customer_7.jpg','2023-08-06'),(8,'enorthing7','Elisabetta','Reilinger','Northing','enorthing7@fc2.com','$2y$10$fhCOX8zHKzxkxLRtMDU0zOB5zqqn5cRm.d9qI6czM48EoZ3DbdDIO','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1989-04-04',34,'./images/customer/customer_8.jpg','2023-08-06'),(9,'utunny8','Urbain','Gorham','Tunny','utunny8@ucla.edu','$2y$10$EtJESWKGsj7aeUwh9jLVu.Tibxy9Mon0DV3NAtQIpvoB/zkC4hLTW','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2005-09-18',17,NULL,'2023-08-06'),(10,'adiplock9','Ashia','O\'Shields','Diplock','adiplock9@reverbnation.com','$2y$10$qKwBGfyVk0UePOr7X6CbyuoKBEEniovWtdm9jPBGgwGPuz/sSZPS6','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1989-10-14',33,NULL,'2023-08-06'),(11,'fbaala','Fredrick','Jirieck','Baal','fbaala@bravesites.com','$2y$10$WNBDMrIlUYO9/DgWwCSOJeHVKg6FscRrN9Wz/o4TdN1yw/EUmmYdq','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2006-02-15',17,NULL,'2023-08-06'),(12,'mrixb','Maddi','Gerauld','Rix','mrixb@usda.gov','$2y$10$bnUZ9PxE0zp9V1cWCBEZhOcGFQJqhTvnLa7hM1BCycQ6dkRW3flB2','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2004-09-01',18,NULL,'2023-08-06'),(13,'sdoodc','Scott','Browncey','Dood','sdoodc@ucoz.com','$2y$10$EyuNvuDsfx3Gragf.CpM5OmDlgZycrQCbJRILP.iRoGINRRRbggb2','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2007-09-09',15,NULL,'2023-08-06'),(14,'fnilesd','Fanni','Physic','Niles','fnilesd@wordpress.com','$2y$10$DgmRuBKRs/QFlJmM7z0UkuV41upLYWfSR1jG8b3tqBRH.jITYZ4ii','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1997-08-21',25,NULL,'2023-08-06'),(15,'gcobbolde','Gladys','Woolaston','Cobbold','gcobbolde@fc2.com','$2y$10$Ie36oNnTtr9SLau/eK2p3O7ICnnRjP5ppzSWufim5kVW/4VbR4eKW','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2008-08-17',14,NULL,'2023-08-06'),(16,'bparlourf','Brittani','McComb','Parlour','bparlourf@gizmodo.com','$2y$10$HbJmOLLFnOiAGE9Yt9KlReaIeUWI79cH6LN7LTCMVOpkt3VyXMJHK','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(17,'skunathg','Skelly','Keel','Kunath','skunathg@cargocollective.com','$2y$10$Aoqikh7bMuAkrrhtGhEpKufTnMHOURFikXEjrNY4DjkHysA/7yitW','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2001-02-06',22,NULL,'2023-08-06'),(18,'nasserh','Natalie','Vearncomb','Asser','nasserh@sohu.com','$2y$10$hHyNvtNpH7TEx1QkEpiGfeT6JcwSbKFGQI57IzmiIrUQm950J9R9O','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(19,'roldfieldi','Ruth','Klainer','Oldfield','roldfieldi@woothemes.com','$2y$10$43F9TUHbnpjs0mr6EfhyeuMulbeoTQw/VajVZNA4KkfJmPFVXJTgi','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1988-10-18',34,NULL,'2023-08-06'),(20,'rlohrensenj','Romonda','Jellett','Lohrensen','rlohrensenj@cmu.edu','$2y$10$6FTT01xrimC.KMUeXl3FkuyJooWlNrIqfdRmZOqwJu6bVQlRlkPOu','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2003-10-10',19,NULL,'2023-08-06'),(21,'aconnark','Amitie','Dulling','Connar','aconnark@google.fr','$2y$10$0rab72YcO2hv1jiFoQ6OUenG6rGOj48bRUfP.HNsCQo99ZRFWEfWy','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',31,'./images/customer/customer_21.jpg','2023-08-06'),(22,'apedronl','Anne-corinne','Aldhous','Pedron','apedronl@sun.com','$2y$10$Z2JGUSRhPF.5KBKsbEX./uPM6HPIM.BiIK1mVYEOhuF.ga9mn3nTu','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1994-03-31',29,NULL,'2023-08-06'),(23,'tclemmittm','Teressa','Amner','Clemmitt','tclemmittm@huffingtonpost.com','$2y$10$h0APZ1HM7NQirVMv9JtteuMqWLTY5HyPN21uj.TN1sDOxmObwKXPW','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1981-04-12',42,NULL,'2023-08-06'),(24,'dtolann','Dyna','MacCafferky','Tolan','dtolann@hud.gov','$2y$10$uUI2LpuSOh4Y/zsdkecZWeSMgG5f7Kr.6i7sdGW0.TzCclQBHOoeu','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2009-08-08',13,NULL,'2023-08-06'),(25,'ccubbono','Clemmy','Gilstoun','Cubbon','ccubbono@dailymail.co.uk','$2y$10$0R.mV/QkRqs.n4HUeBWFzuxM1O9nW14dVNp3NDDTxazxMZPqXivDG','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(26,'kgierokp','Kathy','Maciak','Gierok','kgierokp@census.gov','$2y$10$yQpoLWafiOmAAG7yQgLa1.18rJBO4pSy2N39Zbp2a3eUasPijRtX.','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1989-09-25',33,NULL,'2023-08-06'),(27,'achristofeq','Allyn','Adnams','Christofe','achristofeq@microsoft.com','$2y$10$xU887OdGJIi1qHdLlAmPVubTUaplC3QU8/.Z2goFCUbmpnaoibJmi','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2002-11-01',20,NULL,'2023-08-06'),(28,'dizodr','Donny','Lawlan','Izod','dizodr@gmpg.org','$2y$10$JDbAknGDxctggyVRyiXgduIgoFuf5cbYR6ZSHIsiL5b9XoFytnIXK','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2000-12-16',22,NULL,'2023-08-06'),(29,'kpenninos','Keven','Macro','Pennino','kpenninos@sitemeter.com','$2y$10$NT7b1zMne8GF.YtxulYRaesBkUIi8FzTdNCC77pS5ZAcWKY4/XeSC','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2000-04-17',23,NULL,'2023-08-06'),(30,'nlowndsbrought','Noble','Meenan','Lowndsbrough','nlowndsbrought@usda.gov','$2y$10$tgp7iLzSJtElGxN7TOB23ubgNvCn36lwH9Ywjyb.nblXD14AXeIVq','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1986-03-23',37,NULL,'2023-08-06'),(31,'rbaudinsu','Rhodie','Bittlestone','Baudins','rbaudinsu@cpanel.net','$2y$10$TLulsyHJ0KNJBIAw/Jc.7OEzpejKKYIalZCdG36iTjWnwmHFj6uDy','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2004-11-06',18,NULL,'2023-08-06'),(32,'anussv','Allison','Cron','Nuss','anussv@fda.gov','$2y$10$QFzhQI4LIf8uUFw7/Z40bOCUGawzS1q4WeOWwQ2mrdhboRXUezWbm','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1989-08-07',33,NULL,'2023-08-06'),(33,'dseakingw','Deeann','Sanchis','Seaking','dseakingw@bing.com','$2y$10$oAqWTedOc0Dhg99az7uQfOhtOh4bWu/LE6q5y258lDft6pPapBmVe','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2004-08-13',18,NULL,'2023-08-06'),(34,'dprysx','Drusilla','Noddles','Prys','dprysx@woothemes.com','$2y$10$4T/Qtop//ZGD2svukb8MQuXiEtFF.2U1c/2IDlQLzZOMhlE5zHDIS','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1995-06-23',28,NULL,'2023-08-06'),(35,'dogleasaney','Donall','Hayles','O\'Gleasane','dogleasaney@upenn.edu','$2y$10$oQ7/c.B7aM/Wn4dxANHNH.ixH5/faJd8LY2YLCf3IsF0hqTyF4FrS','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(36,'vtempestz','Virginie','Skellon','Tempest','vtempestz@virginia.edu','$2y$10$Gve7HRr0yf6f3hc.wxrrw.qI3RaFmn9mKSP/H30qFyaB6o1zPayA.','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1994-10-28',28,NULL,'2023-08-06'),(37,'scondy10','Shelbi','Barr','Condy','scondy10@redcross.org','$2y$10$Ref5FOgBH5YVdVpIY3DLtu2xXd5E9q2844DM6UbCteuWd5XDgeNKS','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1983-03-13',40,NULL,'2023-08-06'),(38,'mblackburn11','Mano','Toretta','Blackburn','mblackburn11@kickstarter.com','$2y$10$vq2i8iTVHFmvXEbmDR6zvOlFDpwuGlwujN3h/7hhBA9p66ccIy7yu','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(39,'kjoselevitch12','Karine','Peasegood','Joselevitch','kjoselevitch12@spiegel.de','$2y$10$Vg3AFxZW9wR65nGLxB4J0.4d04ozjekic8kIoBwzMfitvUQZg4YKu','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1994-12-06',28,NULL,'2023-08-06'),(40,'tkinchington13','Teodoor','Ronan','Kinchington','tkinchington13@usatoday.com','$2y$10$25bQVWSEJIBonZ3a8Blv8emiF1tAZmoT136s5WEfwL4Jv6EESPMo.','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2008-09-21',14,NULL,'2023-08-06'),(41,'apay14','Angela','Steckings','Pay','apay14@xrea.com','$2y$10$vn1wYQZMSf5LhQ0UDc28weUFXyupAtAUgwdfYxHPCGT9NjGZjUfUy','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1985-09-15',37,NULL,'2023-08-06'),(42,'hdanton15','Harley','Nelissen','Danton','hdanton15@japanpost.jp','$2y$10$CtPZOpsGHtADJIU6y0luvOMOLTf34/SFfN/QuD4212cDEM61o6z0G','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1982-10-15',40,NULL,'2023-08-06'),(43,'dheiss16','Danette','Baudry','Heiss','dheiss16@wsj.com','$2y$10$pYY/DeGwQT0tp.BFiLBU9OSB3A79MEYxk4YSL9mog1fYwVN/VTR9K','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2007-10-25',15,NULL,'2023-08-06'),(44,'atrevain17','Aldous','Puleston','Trevain','atrevain17@about.me','$2y$10$LaM2FiZK7Ty84xdLIHwQg.AP8JiwoYa6f.9nxiofwqARW5VAj6H3a','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2004-04-27',19,NULL,'2023-08-06'),(45,'jcuniam18','Joey','Swafford','Cuniam','jcuniam18@bluehost.com','$2y$10$HWKXTSEHgpALBDAxLPQFyObtxb1VN/cnx3fUtabx.FQg0dVtn0kO2','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1995-11-02',27,NULL,'2023-08-06'),(46,'bforstall19','Bartolomeo','Hallen','Forstall','bforstall19@webs.com','$2y$10$.vBpmdpH43Sqd2hiUIvQLuhlZS3siIHc4SheFq45qWydqBwdXHTzK','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1985-12-18',37,NULL,'2023-08-06'),(47,'bforstall1a','Bank','Knapman','Forstall','bforstall1a@paypal.com','$2y$10$eP.7yowA2oQ48VKsTT.d7utxfC3ZA5AW5kwh1wRBEeqaMxICA0mYu','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1980-09-09',42,NULL,'2023-08-06'),(48,'mechalier1b','Marian','Pedgrift','Echalier','mechalier1b@forbes.com','$2y$10$I1KSc3aCIti.MtWPDynR4etagXgzOgn1qFSu8773NaOWnBc8h8ezO','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(49,'xmckiernan1c','Xena','Champney','McKiernan','xmckiernan1c@tumblr.com','$2y$10$RR9nwETarKRNWDWTsqyUGeXrlh3bdWWuOKB8hekM5CgbC7ZcNnctK','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1981-11-27',41,NULL,'2023-08-06'),(50,'gdunguy1d','Gerrilee','Denniss','Dunguy','gdunguy1d@ezinearticles.com','$2y$10$gDAMmpD4HmUby6u/hMDqRON0gqazKHqE31SszqXqgC0PKnoIaxFBW','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-01-21',31,NULL,'2023-08-06'),(51,'dsybe1e','Doloritas','Leadbeater','Sybe','dsybe1e@nbcnews.com','$2y$10$1YEfm9iUsvoNvdVLSQEBMunZvhax7wRpODEdFQJlrpNTAe9yzptLu','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1981-07-10',42,NULL,'2023-08-06'),(52,'ckneaphsey1f','Corabel','Beharrell','Kneaphsey','ckneaphsey1f@blogs.com','$2y$10$ZYjCEnFvtZIAFfZLUPwRj.7mYNMHUVy5/t08BxUxG7uoJTc62A6Cy','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2000-03-12',23,NULL,'2023-08-06'),(53,'yhuddles1g','Yoshi','Ayce','Huddles','yhuddles1g@prweb.com','$2y$10$/XjZPrTRr6Y/acctOkpvGe2e8zQt/fS02i7E4lYVEQoxvtyRhnFiy','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2009-06-12',14,NULL,'2023-08-06'),(54,'kdobbie1h','Kellina','MacKee','Dobbie','kdobbie1h@joomla.org','$2y$10$knVcPmc/0ZQeFLEbUz5jBe4oVjdSHY9zgYvA5x8YCeRS0CkJJPntW','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(55,'posant1i','Pet','Stealey','Osant','posant1i@amazon.co.jp','$2y$10$GOkMC1LriajmvD7RPybCh.0iEGPG60uk/V45za5nezHaYsi1wzmxS','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2002-04-29',21,NULL,'2023-08-06'),(56,'vzoppo1j','Vassily','Cowe','Zoppo','vzoppo1j@weibo.com','$2y$10$oLl40eQniveBIsN5EeoM/eiPzFhhU64L5MMLI.yWUtqQPr1N8Nt4W','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1995-09-23',27,NULL,'2023-08-06'),(57,'ludden1k','Lu','Abdy','Udden','ludden1k@homestead.com','$2y$10$ntVLMIqhUN.ubgZ5uRB0IO.9r1BQjzmfiSau5AfL5TEehFU06wxPe','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(58,'ckairns1l','Candy','Petchell','Kairns','ckairns1l@chronoengine.com','$2y$10$isf.rFr3TiAoWPV35TnISO5G8DSN0VgwsT.z7LkNZUF2bA4EB8ZnC','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2007-11-05',15,NULL,'2023-08-06'),(59,'aoxbrow1m','Andreana','Rodenburg','Oxbrow','aoxbrow1m@upenn.edu','$2y$10$W3CWt9.0PbC0nqMpMtxw8Oa/GQSM72DRfjnF2nOP6Ah3vUQkCyeBS','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2009-01-27',14,NULL,'2023-08-06'),(60,'lmenauteau1n','Lusa','Pimlock','Menauteau','lmenauteau1n@163.com','$2y$10$ysf2fT1B4AvPZ4LzX28.9ueqW0BhlYZj5NqcqdzDgDQ3lDUA4adqm','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1980-12-07',42,NULL,'2023-08-06'),(61,'hsmorthit1o','Henrieta','Allcorn','Smorthit','hsmorthit1o@360.cn','$2y$10$9r6x9StlFLsn2mAcv6zzx.5GMkwnWYbb/JwXgkcg782fk9al1ScVC','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1990-08-04',33,NULL,'2023-08-06'),(62,'wduke1p','Warren','Ruperti','Duke','wduke1p@sogou.com','$2y$10$g01rgHdJ/xeazQRN90b4a.JP/Dfyam.nO1Cu8HKNBftIMSkxVMEC.','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(63,'ebarthod1q','Elenore','Chantillon','Barthod','ebarthod1q@google.com','$2y$10$83xksebqfnfNgzQk3SQh4OFJsIDaro98AocbOep9YN9xCK4IAqVK2','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(64,'adaborn1r','Alene','Keates','Daborn','adaborn1r@purevolume.com','$2y$10$BWoLMlqL7hYHGWyUV84hKOHyXOpNP4FurgdsCdJRqBuwCwelJFAbu','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1997-01-12',26,NULL,'2023-08-06'),(65,'hsergean1s','Herschel','Bartholat','Sergean','hsergean1s@dmoz.org','$2y$10$SkihOcJ2OFpERNzUvagD6.TuZSxwAKLIw50jGJCTmp7jEz4pa9yGy','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(66,'wgoodlet1t','Wanda','Baytrop','Goodlet','wgoodlet1t@weibo.com','$2y$10$PeFj1dbLAF9EcIKCiewCsOuj1r4lqJVzk4MH./NcOopvc2D.6zRdy','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1983-06-13',40,NULL,'2023-08-06'),(67,'bmacadam1u','Blair','Nern','MacAdam','bmacadam1u@nhs.uk','$2y$10$MwKJxls.48L9B43FQ5h26eaOYtcUIVfIOhtKGec50Vn6OVjm13i9y','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1987-04-07',36,NULL,'2023-08-06'),(68,'tivashnikov1v','Trace','Wrightson','Ivashnikov','tivashnikov1v@last.fm','$2y$10$EIK3exv1gkxGUydJOMUTwOb1nxx7APp5oeVyDkTFdLUpWOTlLWNaG','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1981-03-25',42,NULL,'2023-08-06'),(69,'jlaverenz1w','Jordanna','Bayles','Laverenz','jlaverenz1w@imdb.com','$2y$10$VYGIiyso3xaAsvSOFuBtVuXWjdHCxDXjGd.FFVC7l3zO8ech1r3Pi','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2003-03-24',20,NULL,'2023-08-06'),(70,'hgemnett1x','Helenelizabeth','Yanshinov','Gemnett','hgemnett1x@furl.net','$2y$10$tTw/ybmYzBQGh6n5FgAw0.ju7Acw0DSd7kSsMsyu2FiPSxbIVEUs2','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1992-08-18',30,NULL,'2023-08-06'),(71,'stomaskunas1y','Selestina','Hundey','Tomaskunas','stomaskunas1y@gravatar.com','$2y$10$B.NkgGper7SXK7zL3P3uCei6RCcLmJJDmvxsEPgmV7q7pUIgoEYtq','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2000-01-28',23,NULL,'2023-08-06'),(72,'cdelacey1z','Carla','Makin','De Lacey','cdelacey1z@ask.com','$2y$10$4eshY0ZRILOUV7ksqKMNAul/RFdIHChgLletkoQCmbMKe0Wb6IRPW','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2007-01-24',16,NULL,'2023-08-06'),(73,'wteers20','Waite','Worssam','Teers','wteers20@samsung.com','$2y$10$qcI6bHcs30xdy9CEbEzG0ep.yE9eAikmL6jZ0PkA8tCDvjF96tPtO','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2001-01-20',22,NULL,'2023-08-06'),(74,'bmeers21','Bessie','Whate','Meers','bmeers21@newsvine.com','$2y$10$uHlLJ.x.oXae6sIVm/qJH.HAmoQjOOlGRhG3QKKwUppS3jcEnYlnS','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1999-03-24',24,NULL,'2023-08-06'),(75,'mcullivan22','Marietta','Emeney','Cullivan','mcullivan22@ezinearticles.com','$2y$10$jHitGoBft1PRtmU.JUT6teZ88/Fl4mmx7ujpJKm43ISBbiIRbQ.X6','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1991-03-03',32,NULL,'2023-08-06'),(76,'mlippini23','Mauricio','Pudsall','Lippini','mlippini23@ed.gov','$2y$10$pIagMbNcMh/bh8DvbySkFepRuJbJS4XM/2BICmBTHpj.YDpxjQMIi','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1996-02-13',27,NULL,'2023-08-06'),(77,'clempel24','Cary','Mougel','Lempel','clempel24@linkedin.com','$2y$10$JBPRJ5L4UUX.SI73xChdoeV0m94ako8XuWb5JgfQkqb/Mm4Bgy0uG','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2002-11-12',20,NULL,'2023-08-06'),(78,'caingell25','Chas','Thoms','Aingell','caingell25@jugem.jp','$2y$10$t/lhSZmCzn2QrAZIKIDIgeTotp.fwmT60Q6UzKru3Jd8QRHYV1jAi','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2007-03-23',16,NULL,'2023-08-06'),(79,'kgodly26','Katalin','Burthom','Godly','kgodly26@irs.gov','$2y$10$sxZN3tC6F/hEWn7z3BcTC.z0hRXP.NlqFckUbbxpV/E4K8P0LE54C','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2007-12-21',15,NULL,'2023-08-06'),(80,'flippiett27','Felicio','Castles','Lippiett','flippiett27@parallels.com','$2y$10$HZzu2FrDYHTwtcaSSZPE1./lhtG68I.VIwuuKWxKOlIbh6nqGYCBC','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1998-07-20',25,NULL,'2023-08-06'),(81,'aredmire28','Aurlie','Gregan','Redmire','aredmire28@chicagotribune.com','$2y$10$CYDwaHm83sx0IZdtZmaBR.DoCDIZwhSRQyHb26Vu4Z5I7og1QkBDe','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2003-10-21',19,NULL,'2023-08-06'),(82,'palten29','Pooh','Glasgow','Alten','palten29@cbslocal.com','$2y$10$hFRMgAQeQBXmVvSWy2YTJ.YOA007jO1NorUlAGfY0BlNApNb67a.u','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2000-05-28',23,NULL,'2023-08-06'),(83,'ehearnes2a','Erny','Jakubowsky','Hearnes','ehearnes2a@imgur.com','$2y$10$U0PD3WPRq1a1YNcXWsBijuKvh7fg6m1.ONTtObHelZfFfh/o.ledy','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2004-05-26',19,NULL,'2023-08-06'),(84,'mclilverd2b','Mickey','Le Fevre','Clilverd','mclilverd2b@mozilla.org','$2y$10$0EKmO3226JyGcOW9Tzt58O6Lz6RNfYTHykQPp2bRhV3YIzceqaCUK','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2001-09-05',21,NULL,'2023-08-06'),(85,'ssiegertsz2c','Sollie','Bagnell','Siegertsz','ssiegertsz2c@goo.ne.jp','$2y$10$xDO.xh/nq.0sRKqg1Mos1eEMdTuvbR/talV8OE7opUwRufVM4C40W','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1983-03-08',40,NULL,'2023-08-06'),(86,'gbeardwood2d','Garvin','Rosenau','Beardwood','gbeardwood2d@apache.org','$2y$10$spasD0Br/hjlC9uPSbsRBOQp4U2/UmYHAV2uCeG3tNL9nNYXD.2OW','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1986-07-18',37,NULL,'2023-08-06'),(87,'icornhill2e','Iormina','Alldread','Cornhill','icornhill2e@seattletimes.com','$2y$10$vUy2iCitjB4DraawCkQ/hekzFisllFVa02P4nF7wO5HeosGTCdYzy','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1983-11-14',39,NULL,'2023-08-06'),(88,'spauleit2f','Skipper','Wandrich','Pauleit','spauleit2f@seesaa.net','$2y$10$9ou9ZBVtEnya.ZQohRUOEu3ZHM6bCoRP6Mow4poba8iUduU3ULz.y','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1996-02-12',27,NULL,'2023-08-06'),(89,'sgiddens2g','Selia','Eadington','Giddens','sgiddens2g@abc.net.au','$2y$10$HwNa5iS/Y2cw7my/Vvk1OO6dpdRX5uyQwwTO0kslXF0d41I7ZJVIG','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2005-01-30',18,NULL,'2023-08-06'),(90,'cmaccarlich2h','Caria','Mottershaw','MacCarlich','cmaccarlich2h@uiuc.edu','$2y$10$sQZVunfJ20mJMAIVv1Idl.b.P44MjZ.jNSKfj7Aukw9eYY4DlPDHS','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2002-03-13',21,NULL,'2023-08-06'),(91,'mpiatti2i','Minne','Dives','Piatti','mpiatti2i@simplemachines.org','$2y$10$lgRWAgrnhJTKpbdiANeQg.sDdI4.KBlVYkUjq86XyFSZeY.mbzbi2','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2005-04-14',18,NULL,'2023-08-06'),(92,'bvertigan2j','Brett','Doag','Vertigan','bvertigan2j@europa.eu','$2y$10$o6eN4YMIu8PzvKimCTrZhuY2SApgVQrWAHljDkPKwv3io78Tay.2S','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1980-12-30',42,NULL,'2023-08-06'),(93,'wkuzma2k','Winni','Pursehouse','Kuzma','wkuzma2k@flickr.com','$2y$10$QkuT98r.WOm8TZUbp.ofvegBaobrcr3VDLyfCeukHU5pboPrv42kC','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1996-12-31',26,NULL,'2023-08-06'),(94,'afatscher2l','Ade','Beard','Fatscher','afatscher2l@ow.ly','$2y$10$2Z7s8GucRpV4UmuIxvelDOBdYQrbj1NGb6JjLtlx6c7YbLcA2kKcy','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2008-04-28',15,NULL,'2023-08-06'),(95,'hblades2m','Hamel','Itzhaki','Blades','hblades2m@networkadvertising.org','$2y$10$1u8nDnVOsaV.1n9B6.tWv.1.m4xfi5DyvOzsFxqK5MsFefyfED1xe','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1996-11-01',26,NULL,'2023-08-06'),(96,'tpalay2n','Tessa','Henri','Palay','tpalay2n@constantcontact.com','$2y$10$xcbJFbvZHK/4thaOgZtqhuobm2x.UyLuqcMOvLr5kEw7I3bJR7IVG','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1996-02-01',27,NULL,'2023-08-06'),(97,'lspellsworth2o','Levi','Proschke','Spellsworth','lspellsworth2o@zdnet.com','$2y$10$Vw2quxttHzAS7BLHN3qGk.QKszzJTWeNUjxQRtrJ3Bp4xHJFChI/G','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1984-10-17',38,NULL,'2023-08-06'),(98,'dvanini2p','Dael','Fernihough','Vanini','dvanini2p@amazon.de','$2y$10$lltjUBjOGBPl4.JRAK0t.uz7k/NqlCWMoCVWMNbCA6pn8fj/Kda3y','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1997-06-26',26,NULL,'2023-08-06'),(99,'kbailess2q','Koren','Hawtrey','Bailess','kbailess2q@google.fr','$2y$10$Dz73a8YccMGE4De5TX6sleMqzhZ2La3rH1wxcADZ8ExK.XCOLChjG','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','2001-05-23',22,NULL,'2023-08-06'),(100,'anoel2r','Aristotle','Haddrell','Noel','anoel2r@trellian.com','$2y$10$9xKigKutREPXHE8AEiQ0bekpAIO81nkr3POaU/kKZMqUPoUeJj7zC','123 Street Address, City, Region, Philippines, 0000','09xxxxxxxxx','1981-02-22',42,NULL,'2023-08-06'),(1001,'Miraie','Rizza','Lazaro','Saldo','rizzalazaro23@gmail.com','$2y$10$.aqPl6/K0hqjot3F0Sg26uQbleRhiJlAiWYB5mt7u39cuRKcAYTxC','15 Durian St. North Signal, Taguig City, Metro Manila, Philippines, 1630','09158242300','2003-09-23',20,'../img/customer/customer_1001.jpeg','2023-08-07'),(1002,'dev','Derick','James','Espinosa','dev@gmail.com','$2y$10$PQ3oKS2hxMrh8i/AWBrSleANfkwgTrIZc0Me5ruRTO0ettqGFwPQC','123 Landayan, San Pedro, Laguna, Philippines, 4023','09123456789','2004-03-13',19,'../img/customer/customer_1002.jpg','2023-08-12'),(1003,'derickTheMaze','derick','maze','the','dtm@gmail.com','$2y$10$lNkpzxnY6.fTDuLNpCzAOuG6hCf.iPGLl7NMEzkG2pNkcEN4RvlYO','123 landayan san pedro,    laguna,    ph,   1234',NULL,'1970-01-01',19,NULL,'2023-11-12'),(1009,'derick-J03','derick','m','james','derickjames13@gmail.com','$2y$10$4iks8Tcb5GnCHN7tqQ5WS.JmUJbhGkq3BtQXF1qQOCoyYauGXaloy','123 Lane San Pedro City,     Laguna,     Philippines,     4023','09999999','2004-03-12',19,NULL,'2023-11-25'),(1010,'derickj03','Derick','M','James ','derickj03@gmail.com','$2y$10$rbXYqytsYDimXzPR5gG8U.uHhlMV78845qlDpxIN94QByJ5b/QFtm','123 Lane San Pedro City,     Laguna,     Philippines,     4023','09999999','2004-04-16',19,'[{\"name\":\"1700921174_6561ff5634cca_hutaoqt.jpeg\",\"path\":\"..\\/img\\/customer\\/1700921174_6561ff5634cca_hutaoqt.jpeg\"},{\"name\":\"1700921174_6561ff5634fdf_me.jpg\",\"path\":\"..\\/img\\/customer\\/1700921174_6561ff5634fdf_me.jpg\"},{\"name\":\"1700921174_6561ff56362cd_XIAO_kewl.jpg\",\"path\":\"..\\/img\\/customer\\/1700921174_6561ff56362cd_XIAO_kewl.jpg\"},{\"name\":\"1700921907_656202332ef4c_hozier-wasteland-baby1.jpg\",\"path\":\"..\\/img\\/customer\\/1700921907_656202332ef4c_hozier-wasteland-baby1.jpg\"}]','2023-11-25'),(1011,'phpdev','derick','m','james','jam13@gmail.com','$2y$10$xsAM8QL4f4OL4U3lo2uPs.1UzuAAZzFbikODijvZCKMlJlh1hpd2m','123 Lane San Pedro City,   Laguna,   Philippines,   4023','09999999','2002-02-27',21,'[{\"name\":\"1700933448_65622f48e5772_hutaoqt.jpeg\",\"path\":\"..\\/img\\/customer\\/1700933448_65622f48e5772_hutaoqt.jpeg\"},{\"name\":\"1700933448_65622f48e5c4d_XIAO_kewl.jpg\",\"path\":\"..\\/img\\/customer\\/1700933448_65622f48e5c4d_XIAO_kewl.jpg\"}]','2023-11-26');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'Sales'),(2,'Service'),(3,'Maintenance'),(4,'Developer');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` longtext NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_login_user1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (34,'dev','$2y$10$Oysy4S/7t7bjhpQk3hTVuuNHd544SXlGNgGvbK.DsyVxSgH.lQPjq'),(39,'jack01','$2y$10$K.NeagS.ILV/kae/silrjOy8MDoeO7BrvgQtF2JwayUus.oQkpXKC'),(40,'johndoe13','$2y$10$K.NeagS.ILV/kae/silrjOy8MDoeO7BrvgQtF2JwayUus.oQkpXKC'),(50,'derickj03','$2y$10$eQ5u5nfE2ue1w7JbqijkXeHPRp4L5PsRvMvY0K8ipoz5/Mnq5TsXu');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `shipping_type` varchar(45) DEFAULT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'Pending',
  `ship_date` date DEFAULT (current_timestamp() + interval 3 day),
  `create_date` date DEFAULT current_timestamp(),
  PRIMARY KEY (`id`,`customer_id`),
  KEY `fk_order_customer1_idx` (`customer_id`),
  KEY `fj_shipping_type1_idx` (`shipping_type`),
  CONSTRAINT `fj_shipping_type1` FOREIGN KEY (`shipping_type`) REFERENCES `shipping_info` (`type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (95,52,'Standard','Pending','2023-08-13','2023-08-06'),(96,52,'standard','Pending','2023-08-13','2023-08-06'),(99,6,'Standard','Pending','2023-08-13','2023-08-06'),(100,7,'Priority','Pending','2023-08-08','2023-08-06'),(109,2,'Standard','Pending','2023-07-07','2023-08-06'),(111,6,'standard','Pending','2023-07-07','2023-08-06'),(112,6,'Standard','Pending','2023-07-07','2023-08-06'),(113,7,'Express','Pending','2023-07-07','2023-08-06'),(114,8,'Priority','Pending','2023-07-07','2023-08-06'),(115,8,'standard','Pending','2023-07-07','2023-08-06'),(118,21,'Standard','Pending','2023-07-07','2023-08-06'),(119,21,'Priority','Pending','2023-07-07','2023-08-06'),(120,21,'standard','Pending','2023-07-07','2023-08-06'),(121,21,'Priority','shipping','2023-07-07','2023-08-06'),(122,21,'standard','Pending','2023-07-07','2023-08-06'),(123,1001,'standard','Pending','2023-07-07','2023-08-07'),(127,1002,'Standard','Pending','2023-07-07','2023-08-12'),(128,1002,'Priority','delivered','2023-07-07','2023-08-12'),(129,1002,'standard','delivered','2023-07-07','2023-08-12'),(161,1002,'Standard','Pending','2023-11-12','2023-11-09'),(162,1002,'Standard','Pending','2023-11-12','2023-11-09'),(163,1002,'Standard','Pending','2023-11-12','2023-11-09'),(164,1002,'Standard','Pending','2023-11-12','2023-11-09'),(218,1011,'Standard','Pending','2023-11-29','2023-11-26');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_has_product`
--

DROP TABLE IF EXISTS `order_has_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_has_product` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(4,4) NOT NULL DEFAULT 0.1200,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `fk_order_has_product_order1_idx` (`order_id`),
  KEY `fk_order_has_product_product1_idx` (`product_id`),
  CONSTRAINT `fk_order_has_product_order1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_has_product_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_has_product`
--

LOCK TABLES `order_has_product` WRITE;
/*!40000 ALTER TABLE `order_has_product` DISABLE KEYS */;
INSERT INTO `order_has_product` VALUES (95,36,1,100800.00,0.1200),(96,47,1,89600.00,0.1200),(96,49,1,44800.00,0.1200),(99,2,1,2800.00,0.1200),(109,49,1,44800.00,0.1200),(111,13,1,8960.00,0.1200),(111,15,1,20160.00,0.1200),(112,13,1,8960.00,0.1200),(113,29,1,11536.00,0.1200),(114,18,1,90160.00,0.1200),(115,13,1,8960.00,0.1200),(115,49,1,44800.00,0.1200),(118,3,1,896.00,0.1200),(119,17,1,22400.00,0.1200),(120,48,1,28000.00,0.1200),(121,2,1,2800.00,0.1200),(121,15,1,20160.00,0.1200),(122,11,1,61600.00,0.1200),(122,13,1,8960.00,0.1200),(123,15,1,20160.00,0.1200),(123,48,1,28000.00,0.1200),(128,2,2,5600.00,0.1200),(129,47,1,89600.00,0.1200),(129,48,1,28000.00,0.1200),(218,2,1,2950.00,0.1200);
/*!40000 ALTER TABLE `order_has_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `description` longtext DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `image_dir` longtext DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(45) DEFAULT '"developer"',
  `last_modified_at` date NOT NULL DEFAULT current_timestamp(),
  `last_modified_by` varchar(45) DEFAULT '"developer"',
  PRIMARY KEY (`id`),
  KEY `fk_supplier_id_idx` (`supplier_id`),
  CONSTRAINT `fk_supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (2,'Xiaomi Smartwatch',2500,58,'Smartwatch offering various features like health tracking and notifications, manufactured by Xiaomi.','Xiaomi','Smartwatch',1,'../img/product/product_2.jpg','2023-07-22','dev_database','2023-08-13','dev'),(3,'Xiaomi Power Bank',800,99,'Portable power bank designed by Xiaomi to charge electronic devices on the go.','Xiaomi','Power Bank',19,'../img/product/product_3.jpg','2023-07-22','dev_database','2023-08-13','dev'),(4,'Xiaomi Mi 11',30000,20,'Xiaomi\'s flagship smartphone, featuring high-end specifications and advanced camera capabilities.','Xiaomi','Smartphone',19,'../img/product/product_4.jpg','2023-07-22','dev_database','2023-08-04','dev'),(5,'Xiaomi Redmi Note 10',12000,60,'Xiaomi\'s mid-range smartphone offering with a focus on a balance of performance and affordability.','Xiaomi','Smartphone',1,'../img/product/product_5.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(6,'Samsung Galaxy S21',32000,10,'Premium Samsung smartphone series with cutting-edge features and powerful performance.','Samsung','Smartphone',1,'../img/product/product_6.jpg','2023-07-22','dev_database','2023-08-06','dev'),(7,'Samsung 55-inch Smart TV',45000,20,'Samsung Smart TV with a 55-inch display, offering a range of entertainment and streaming options.','Samsung','Smart TV',1,'../img/product/product_7.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(8,'Samsung Washing Machine',18000,40,'Top-load or front-load washing machine manufactured by Samsung, known for its reliability and efficiency.','Samsung','Washing Machine',1,'../img/product/product_8.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(9,'Samsung Galaxy Tab S7',28000,15,'Samsung\'s high-performance tablet with a large display and compatibility with the S Pen stylus.','Samsung','Tablet',1,'../img/product/product_9.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(10,'Samsung Refrigerator',25000,30,'Samsung\'s refrigeration appliance with advanced features for efficient food storage and organization.','Samsung','Refrigerator',1,'../img/product/product_10.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(11,'iPhone 13',55000,15,'The latest iteration of Apple\'s flagship iPhone series, featuring an enhanced camera and powerful processor.','Apple','Smartphone',1,'../img/product/product_11.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(12,'iPad Pro',35000,25,'Apple\'s high-end tablet with advanced features suitable for productivity and creative tasks.','Apple','Tablet',1,'../img/product/product_12.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(13,'Apple AirPods Pro',8000,60,'Premium wireless earbuds with noise cancellation and seamless integration with Apple devices.','Apple','Earbuds',1,'../img/product/product_13.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(14,'MacBook Air',60000,30,'Apple\'s thin and lightweight laptop, ideal for everyday tasks and portable computing.','Apple','Laptop',1,'../img/product/product_14.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(15,'Apple Watch Series 7',18000,43,'Apple\'s latest smartwatch model with health and fitness tracking features, customizable bands, and design.','Apple','Smartwatch',1,'../img/product/product_15.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(16,'Sony PlayStation 5',28000,5,'Next-gen gaming console by Sony, offering immersive gaming experiences and top-tier graphics.','Sony','Gaming Console',1,'../img/product/product_16.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(17,'Sony WH-1000XM4 Headphones',20000,25,'High-quality noise-cancelling headphones by Sony, designed for audiophiles and travelers.','Sony','Headphones',1,'../img/product/product_17.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(18,'Sony A7 III',80000,10,'Advanced mirrorless camera by Sony, known for its exceptional image quality and versatility.','Sony','Mirrorless Camera',1,'../img/product/product_18.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(19,'Sony 65-inch 4K Smart TV',50000,15,'Sony Smart TV with a 65-inch 4K UHD display, providing an immersive viewing experience.','Sony','Smart TV',1,'../img/product/product_19.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(20,'Sony Cyber-shot RX100 VII',30000,20,'Compact digital camera with professional features and high-performance imaging, part of the RX series.','Sony','Digital Camera',1,'../img/product/product_20.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(21,'LG OLED CX 55-inch TV',55000,10,'LG Smart TV with a 55-inch OLED display, offering vibrant colors and deep black levels.','LG','Smart TV',1,'../img/product/product_21.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(22,'LG Gram 17 Laptop',70000,20,'Lightweight and portable laptop from LG, suitable for users on the go.','LG','Laptop',1,'../img/product/product_22.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(23,'LG Refrigerator',35000,30,'LG\'s refrigeration appliance with innovative features for food preservation and organization.','LG','Refrigerator',1,'../img/product/product_23.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(24,'LG UltraGear 27-inch Monitor',18000,25,'High-performance gaming monitor with a 27-inch display, designed for smooth gameplay.','LG','Monitor',1,'../img/product/product_24.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(25,'LG Washing Machine',25000,40,'Top-load or front-load washing machine manufactured by LG, known for its efficiency and convenience.','LG','Washing Machine',1,'../img/product/product_25.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(26,'HP Spectre x360 Laptop',60000,20,'Premium convertible laptop by HP, featuring a 360-degree hinge for versatile use as a laptop or tablet.','HP','Laptop',1,'../img/product/product_26.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(27,'HP Envy 27-inch Monitor',20000,30,'High-resolution monitor by HP, designed for content creation and multimedia tasks.','HP','Monitor',1,'../img/product/product_27.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(28,'HP Pavilion Gaming Desktop',45000,15,'HP\'s gaming-focused desktop computer with powerful hardware and customizable features.','HP','Desktop Computer',1,'../img/product/product_28.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(29,'HP LaserJet Pro MFP M281fdw',10000,40,'Multifunction color laser printer by HP, designed for small office or home office use.','HP','Multifunction Printer',1,'../img/product/product_29.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(30,'HP DeskJet Ink Advantage 3777',5000,50,'Compact all-in-one inkjet printer suitable for basic printing needs.','HP','Inkjet Printer',1,'../img/product/product_30.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(31,'Dell XPS 13 Laptop',65000,10,'Dell\'s premium ultrabook, known for its sleek design and powerful performance.','Dell','Laptop',1,'../img/product/product_31.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(32,'Dell Inspiron 15 3000',35000,30,'Dell\'s mid-range laptop series, offering a balance of performance and affordability.','Dell','Laptop',1,'../img/product/product_32.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(33,'Dell UltraSharp 24 Monitor',12000,20,'High-quality monitor by Dell, suitable for professional tasks and color accuracy.','Dell','Monitor',1,'../img/product/product_33.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(34,'Dell Alienware m15 R6',90000,5,'Gaming laptop from Dell\'s Alienware brand, featuring high-end gaming hardware.','Dell','Gaming Laptop',1,'../img/product/product_34.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(36,'ASUS ROG Strix Scar 15',90000,10,'High-performance gaming laptop from ASUS, part of the Republic of Gamers (ROG) series.','ASUS','Gaming Laptop',1,'../img/product/product_36.png','2023-07-22','dev_database','2023-08-06','dev'),(37,'ASUS ZenBook 14',60000,15,'ASUS\'s thin and light ultrabook, designed for portability and productivity.','ASUS','Laptop',1,'../img/product/product_37.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(38,'ASUS TUF Gaming VG279QM Monitor',18000,25,'High-refresh-rate gaming monitor with a 27-inch display, offering smooth gameplay.','ASUS','Monitor',1,'../img/product/product_38.jpg','2023-07-22','dev_database','2023-08-06','dev'),(39,'ASUS ROG Zephyrus G14',80000,20,'ASUS\'s powerful gaming laptop with an emphasis on portability and performance.','ASUS','Gaming Laptop',1,'../img/product/product_39.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(40,'ASUS VivoBook S14',35000,30,'Stylish and compact laptop from ASUS\'s VivoBook series, suitable for everyday use.','ASUS','Laptop',1,'../img/product/product_40.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(42,'Lenovo Yoga C940',60000,15,'Versatile 2-in-1 laptop from Lenovo, featuring a flexible hinge and touch display.','Lenovo','Laptop',1,'../img/product/product_42.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(43,'Lenovo Legion 5 Gaming Laptop',55000,25,'Lenovo\'s gaming-focused laptop series, offering a balance of performance and affordability.','Lenovo','Gaming Laptop',1,'../img/product/product_43.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(44,'Lenovo Tab P11 Pro',25000,20,'High-end Android tablet by Lenovo, suitable for entertainment and productivity.','Lenovo','Tablet',1,'../img/product/product_44.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(45,'Lenovo IdeaPad Slim 5i',35000,30,'Stylish and lightweight laptop from Lenovo\'s IdeaPad series, designed for everyday use.','Lenovo','Laptop',1,'../img/product/product_45.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(46,'Acer Swift 5',70000,10,'Ultrabook from Acer, known for its lightweight design and portability.','Acer','Laptop',1,'../img/product/product_46.jpg','2023-07-22','dev_database','2023-07-22','dev_database'),(47,'Acer Predator Helios 300',80000,8,'Acer\'s gaming laptop with a focus on performance and gaming capabilities.','Acer','Gaming Laptop',1,'../img/product/product_47.jpg','2023-07-22','dev_database','2023-08-02','dev'),(48,'Acer Chromebook 14',25000,13,'Chromebook from Acer, featuring Google\'s Chrome OS and cloud-based computing.','Acer','Chromebook',1,'../img/product/product_48.jpg','2023-07-22','dev_database','2023-08-13','dev'),(49,'Acer Aspire 5',40000,25,'Mid-range laptop from Acer\'s Aspire series, offering a balance of features and affordability.','Acer','Laptop',1,'[{\"name\":\"1700985176_6562f958f2f7e_A1NX.A68EK.002_2_12417814_Supersize.jpg\",\"path\":\"..\\/..\\/img\\/product\\/1700985176_6562f958f2f7e_A1NX.A68EK.002_2_12417814_Supersize.jpg\"},{\"name\":\"1700985176_6562f958f3b72_Aspire-5-15inch-left.jpg\",\"path\":\"..\\/..\\/img\\/product\\/1700985176_6562f958f3b72_Aspire-5-15inch-left.jpg\"}]','2023-07-22','dev_database','2023-08-02','dev');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Main Admin','Has control of overall service of shop'),(4,'Employee','The role of an Employee varies depending on t'),(5,'Developer','Has control of all database model and applica');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary`
--

DROP TABLE IF EXISTS `salary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `net_amount` decimal(10,2) DEFAULT NULL,
  `hoursWorked` int(11) NOT NULL,
  `gross_amount` decimal(10,2) DEFAULT NULL,
  `benefits_id` int(11) DEFAULT NULL,
  `tax_percentage` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_benefits_id_1_idx` (`benefits_id`),
  CONSTRAINT `fk_benefits_id_1` FOREIGN KEY (`benefits_id`) REFERENCES `benefits` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary`
--

LOCK TABLES `salary` WRITE;
/*!40000 ALTER TABLE `salary` DISABLE KEYS */;
INSERT INTO `salary` VALUES (2,37250.00,50,50000.00,2,0.15),(3,4261.09,69,4761.00,3,0.00),(4,4261.09,69,4761.00,4,0.00),(5,42610.95,690,47610.00,5,0.00),(6,42610.95,690,47610.00,6,0.00),(7,42610.95,690,47610.00,7,0.00),(8,42610.95,690,47610.00,8,0.00),(14,18258.00,240,20400.00,14,0.00),(18,11271.10,123,15129.00,18,0.15);
/*!40000 ALTER TABLE `salary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_info`
--

DROP TABLE IF EXISTS `schedule_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_info` (
  `id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `schedule_time` time NOT NULL,
  `shift_type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_info`
--

LOCK TABLES `schedule_info` WRITE;
/*!40000 ALTER TABLE `schedule_info` DISABLE KEYS */;
INSERT INTO `schedule_info` VALUES (1,'2023-08-22','13:00:00','Afternoon'),(2,'2023-08-22','11:11:00','Morning'),(3,'2023-08-22','12:22:00','Afternoon'),(4,'2023-08-22','11:11:00','Morning'),(5,'2023-08-22','13:00:00','Afternoon'),(6,'2023-08-22','11:11:00','Morning'),(7,'2023-08-09','12:00:00','Afternoon'),(8,'2023-08-09','13:00:00','Afternoon'),(9,'2023-08-20','11:11:00','Morning'),(10,'2023-08-29','11:11:00','Morning'),(11,'2023-08-10','11:11:00','Morning'),(12,'2023-08-08','12:00:00','Afternoon');
/*!40000 ALTER TABLE `schedule_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_info`
--

DROP TABLE IF EXISTS `shipping_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_info` (
  `type` varchar(64) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `shipping_interval` int(11) DEFAULT 3,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_info`
--

LOCK TABLES `shipping_info` WRITE;
/*!40000 ALTER TABLE `shipping_info` DISABLE KEYS */;
INSERT INTO `shipping_info` VALUES ('Express',300.00,2),('Priority',500.00,2),('Standard',150.00,3);
/*!40000 ALTER TABLE `shipping_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES (1,'TechCo','techco@example.com','123-456-7890'),(2,'GadgetZone','gadgetzone@example.com','987-654-3210'),(3,'MegaElectronics','mega@example.com','555-123-4567'),(4,'SmartTech','smarttech@example.com','777-888-9999'),(5,'FutureGadgets','future@example.com','444-555-6666'),(6,'GlobalTech','globaltech@example.com','111-222-3333'),(7,'SuperGizmos','supergizmos@example.com','888-999-0000'),(8,'MegaTech','megatech@example.com','333-444-5555'),(9,'InnovativeTech','innovative@example.com','666-777-8888'),(10,'UltimateGadget','ultimate@example.com','222-333-4444'),(11,'HyperElectronics','hyper@example.com','555-777-9999'),(12,'TechMasters','techmasters@example.com','777-555-9999'),(13,'GizmoTech','gizmo@example.com','444-777-2222'),(14,'FutureTech','futuretech@example.com','111-888-4444'),(15,'DigitalGadgets','digital@example.com','666-999-5555'),(16,'SmartElectronics','smart@example.com','333-444-5555'),(17,'E-Tech','etech@example.com','777-888-9999'),(18,'InnovativeGizmos','innovativegizmos@example.com','111-222-3333'),(19,'MasterGadgets','mastergadgets@example.com','444-555-6666'),(20,'TechWizards','techwizards@example.com','888-999-0000');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `phone_number` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `address` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `image_dir` longtext DEFAULT NULL,
  `created_at` date DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_role_id_1_idx` (`role_id`),
  KEY `fk_department_id_1_idx` (`department_id`),
  CONSTRAINT `fk_department_id_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_id_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (34,'dev','James','theDev','M','0999999999','dejames@gmail.com','123 lane, San Pedro, Laguna, 4023, Philippines','2004-03-12',19,5,1,'[{\"name\":\"1700932428_65622b4c2e91e_5 - Copy.jpg\",\"path\":\"..\\/..\\/img\\/user\\/1700932428_65622b4c2e91e_5 - Copy.jpg\"},{\"name\":\"1700986239_6562fd7fc447e_hutaoqt.jpeg\",\"path\":\"..\\/..\\/img\\/user\\/1700986239_6562fd7fc447e_hutaoqt.jpeg\"},{\"name\":\"1700986239_6562fd7fc4898_me.jpg\",\"path\":\"..\\/..\\/img\\/user\\/1700986239_6562fd7fc4898_me.jpg\"},{\"name\":\"1700986239_6562fd7fc4c30_XIAO_kewl.jpg\",\"path\":\"..\\/..\\/img\\/user\\/1700986239_6562fd7fc4c30_XIAO_kewl.jpg\"}]','2023-07-29'),(39,'jack01','Jack','Reaper','TheEmlpoyee','0999999999','jack01@gmail.com','123 Lane, Taguigs, Manila, 4023, Philippines','2023-08-02',0,1,1,'[{\"name\":\"1700931673_65622859bcc70_5.jpg\",\"path\":\"..\\/..\\/img\\/user\\/1700931673_65622859bcc70_5.jpg\"},{\"name\":\"1700931688_656228682eaad_7.jpg\",\"path\":\"..\\/..\\/img\\/user\\/1700931688_656228682eaad_7.jpg\"}]','2023-08-02'),(40,'johndoe13','John','Doe','John','09xxxxxxx','johndoe13@gmail.com','addr, addr, addr, 1234, addr','2023-08-07',19,1,1,'[{\"name\":\"1700931430_6562276675a59_1 - Copy.jpg\",\"path\":\"..\\/..\\/img\\/user\\/1700931430_6562276675a59_1 - Copy.jpg\"},{\"name\":\"1700931430_6562276675dfc_5.jpg\",\"path\":\"..\\/..\\/img\\/user\\/1700931430_6562276675dfc_5.jpg\"}]','2023-08-07'),(50,'derickj03','Derick','James','Monton',NULL,'dj013th@gmail.com','the most awesome developer',NULL,NULL,5,4,'[{\"name\":\"1701071039_656448bfae24d_hozier-wasteland-baby-copy.jpg\",\"path\":\"..\\/..\\/img\\/user\\/1701071039_656448bfae24d_hozier-wasteland-baby-copy.jpg\"},{\"name\":\"1701071039_656448bfae590_hutaoqt.jpeg\",\"path\":\"..\\/..\\/img\\/user\\/1701071039_656448bfae590_hutaoqt.jpeg\"},{\"name\":\"1701071039_656448bfaea63_me.jpg\",\"path\":\"..\\/..\\/img\\/user\\/1701071039_656448bfaea63_me.jpg\"},{\"name\":\"1701071039_656448bfafbe3_XIAO_kewl.jpg\",\"path\":\"..\\/..\\/img\\/user\\/1701071039_656448bfafbe3_XIAO_kewl.jpg\"}]','2023-11-27');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_has_salary`
--

DROP TABLE IF EXISTS `user_has_salary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_has_salary` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_id` int(11) NOT NULL,
  `payGrade` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`user_id`,`salary_id`),
  KEY `fk_user_has_salary_salary1_idx` (`salary_id`),
  KEY `fk_user_has_salary_user1_idx` (`user_id`),
  CONSTRAINT `fk_user_has_salary_salary1` FOREIGN KEY (`salary_id`) REFERENCES `salary` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_salary_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_has_salary`
--

LOCK TABLES `user_has_salary` WRITE;
/*!40000 ALTER TABLE `user_has_salary` DISABLE KEYS */;
INSERT INTO `user_has_salary` VALUES (39,3,69.00,'2023-08-05'),(39,4,69.00,'2023-08-05'),(39,5,69.00,'2023-08-05'),(39,6,69.00,'2023-08-05'),(39,7,69.00,'2023-08-05'),(39,8,69.00,'2023-08-05'),(40,18,123.00,'2023-11-25');
/*!40000 ALTER TABLE `user_has_salary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_has_schedules`
--

DROP TABLE IF EXISTS `user_has_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_has_schedules` (
  `user_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `created_at` date DEFAULT current_timestamp(),
  `created_by` varchar(45) DEFAULT 'admin',
  PRIMARY KEY (`user_id`,`schedule_id`),
  KEY `fk_schedule_id_1_idx` (`schedule_id`),
  CONSTRAINT `fk_schedule_id_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedule_info` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_id_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_has_schedules`
--

LOCK TABLES `user_has_schedules` WRITE;
/*!40000 ALTER TABLE `user_has_schedules` DISABLE KEYS */;
INSERT INTO `user_has_schedules` VALUES (34,5,'2023-08-05','dev'),(34,6,'2023-08-05','dev'),(34,7,'2023-08-05','dev'),(34,8,'2023-08-05','dev'),(34,9,'2023-08-05','dev'),(34,11,'2023-08-07','dev'),(39,2,'2023-08-05','dev'),(39,4,'2023-08-05','dev'),(39,12,'2023-08-07','dev');
/*!40000 ALTER TABLE `user_has_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_manages_order`
--

DROP TABLE IF EXISTS `user_manages_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_manages_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `action_type` varchar(45) DEFAULT NULL,
  `managed_date` date DEFAULT current_timestamp(),
  PRIMARY KEY (`id`,`order_id`,`user_id`),
  KEY `fk_user_id_1_idx` (`user_id`),
  KEY `fk_product_id_1_idx` (`product_id`),
  KEY `fk_order_id_1_idx` (`order_id`),
  CONSTRAINT `fk_manage_by_user_anong_duplicate_id_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_id_1` FOREIGN KEY (`order_id`) REFERENCES `order_has_product` (`order_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_id_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_manages_order`
--

LOCK TABLES `user_manages_order` WRITE;
/*!40000 ALTER TABLE `user_manages_order` DISABLE KEYS */;
INSERT INTO `user_manages_order` VALUES (1,95,34,36,'shipped_order','2023-08-06'),(2,95,34,36,'shipped_order','2023-08-06'),(3,96,34,47,'cancelled_order','2023-08-06'),(5,99,34,2,'cancelled_order','2023-08-06');
/*!40000 ALTER TABLE `user_manages_order` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-27 16:29:03
