-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (i386)
--
-- Host: localhost    Database: Webhost
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assigner` int(11) NOT NULL,
  `assignee` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `due_date` varchar(18) NOT NULL,
  `assigned_date` varchar(18) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `basicinfo`
--

DROP TABLE IF EXISTS `basicinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basicinfo` (
  `birthdate` varchar(10) DEFAULT NULL,
  `pnumber` varchar(12) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `img_filepath` varchar(300) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `runnertype` varchar(50) DEFAULT NULL,
  `biography` varchar(2500) DEFAULT NULL,
  `cryptID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `type` int(11) DEFAULT NULL,
  `posttype` int(11) DEFAULT NULL,
  `postID` int(11) DEFAULT NULL,
  `commentID` int(11) DEFAULT NULL,
  `date` varchar(35) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `text` varchar(500) DEFAULT NULL,
  `img_filepath` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distance`
--

DROP TABLE IF EXISTS `distance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distance` (
  `type` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `public` int(11) DEFAULT NULL,
  `date` varchar(19) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `team` varchar(100) DEFAULT NULL,
  `intensity` int(11) DEFAULT NULL,
  `journal` varchar(2500) DEFAULT NULL,
  `runtime` varchar(8) DEFAULT NULL,
  `pace` varchar(7) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `distance` float DEFAULT NULL,
  `shoe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `formerprofilepics`
--

DROP TABLE IF EXISTS `formerprofilepics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formerprofilepics` (
  `cryptID` int(11) DEFAULT NULL,
  `img_url` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `person1` int(11) DEFAULT NULL,
  `person2` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) DEFAULT NULL,
  `name` varchar(300) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `policy` int(11) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `pagepolicy` int(11) DEFAULT NULL,
  `img_filepath` varchar(500) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invitations`
--

DROP TABLE IF EXISTS `invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invitations` (
  `receiver` int(11) DEFAULT NULL,
  `sender` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `posttype` int(11) DEFAULT NULL,
  `postID` int(11) DEFAULT NULL,
  `posterID` int(11) DEFAULT NULL,
  `likerID` int(11) DEFAULT NULL,
  `date` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `maliciousreports`
--

DROP TABLE IF EXISTS `maliciousreports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maliciousreports` (
  `reporterID` int(11) DEFAULT NULL,
  `violator` int(11) DEFAULT NULL,
  `date` varchar(33) DEFAULT NULL,
  `stalking` int(11) DEFAULT NULL,
  `bullying` int(11) DEFAULT NULL,
  `advertising` int(11) DEFAULT NULL,
  `content` int(11) DEFAULT NULL,
  `comments` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `cryptID` int(11) DEFAULT NULL,
  `groupID` int(11) DEFAULT NULL,
  `permissions` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `sender` int(11) DEFAULT NULL,
  `receiver` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `date` varchar(35) DEFAULT NULL,
  `text` varchar(2000) DEFAULT NULL,
  `img_filepath` varchar(300) DEFAULT NULL,
  `read` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `posttype` int(11) DEFAULT NULL,
  `notifType` int(11) DEFAULT NULL,
  `postID` int(11) DEFAULT NULL,
  `notifier` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `date` varchar(40) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `gID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pageposts`
--

DROP TABLE IF EXISTS `pageposts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pageposts` (
  `type` int(11) DEFAULT NULL,
  `poster` int(11) DEFAULT NULL,
  `postee` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `text` varchar(1500) DEFAULT NULL,
  `img_filepath` varchar(300) DEFAULT NULL,
  `date` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photoalbums`
--

DROP TABLE IF EXISTS `photoalbums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photoalbums` (
  `albumID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `albumname` varchar(150) DEFAULT NULL,
  `description` varchar(1500) DEFAULT NULL,
  `location` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `type` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `date` varchar(35) DEFAULT NULL,
  `text` varchar(1500) DEFAULT NULL,
  `img_filepath` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `group_id` int(11) NOT NULL,
  `start_date` varchar(18) NOT NULL,
  `end_date` varchar(18) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `races`
--

DROP TABLE IF EXISTS `races`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `races` (
  `type` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `date` varchar(19) DEFAULT NULL,
  `distance` float DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `racename` varchar(50) DEFAULT NULL,
  `relay` int(11) DEFAULT NULL,
  `runtime` varchar(8) DEFAULT NULL,
  `pace` varchar(8) DEFAULT NULL,
  `journal` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recovery`
--

DROP TABLE IF EXISTS `recovery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recovery` (
  `email` varchar(150) DEFAULT NULL,
  `resetID` int(11) DEFAULT NULL,
  `expiredate` varchar(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reposts`
--

DROP TABLE IF EXISTS `reposts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reposts` (
  `id` int(11) NOT NULL,
  `reposterID` int(11) NOT NULL,
  `posttype` int(11) NOT NULL,
  `origPostType` int(11) NOT NULL,
  `origPostID` int(11) NOT NULL,
  `date` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shoes`
--

DROP TABLE IF EXISTS `shoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoes` (
  `userID` int(11) DEFAULT NULL,
  `shoeID` int(11) NOT NULL AUTO_INCREMENT,
  `Make` varchar(300) DEFAULT NULL,
  `Model` varchar(300) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  PRIMARY KEY (`shoeID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `speed`
--

DROP TABLE IF EXISTS `speed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `speed` (
  `type` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `location` varchar(300) DEFAULT NULL,
  `date` varchar(33) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `distance` float DEFAULT NULL,
  `team` varchar(300) DEFAULT NULL,
  `journal` varchar(5000) DEFAULT NULL,
  `privacy` int(11) DEFAULT NULL,
  `warmup` float DEFAULT NULL,
  `cooldown` float DEFAULT NULL,
  `workout` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `useraccount`
--

DROP TABLE IF EXISTS `useraccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `useraccount` (
  `username` varchar(150) DEFAULT NULL,
  `cryptID` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `userprefs`
--

DROP TABLE IF EXISTS `userprefs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userprefs` (
  `cryptID` int(11) NOT NULL,
  `distanceLoad` int(11) DEFAULT NULL,
  `distanceEntries` int(11) DEFAULT NULL,
  `speedLoad` int(11) DEFAULT NULL,
  `speedEntries` int(11) DEFAULT NULL,
  `raceLoad` int(11) DEFAULT NULL,
  `raceEntries` int(11) DEFAULT NULL,
  `pagePostLoad` int(11) DEFAULT NULL,
  `pagePostEntries` int(11) DEFAULT NULL,
  `grpPagePostLoad` int(11) DEFAULT NULL,
  `grpPagePostEntries` int(11) DEFAULT NULL,
  `grpPostsLoad` int(11) DEFAULT NULL,
  `grpPostEntries` int(11) DEFAULT NULL,
  `postLoad` int(11) DEFAULT NULL,
  `postEntries` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-14  0:16:54
