/*
SQLyog Community v12.12 (64 bit)
MySQL - 10.1.21-MariaDB : Database - e_ticket
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`e_ticket` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `e_ticket`;

/*Table structure for table `compte` */

DROP TABLE IF EXISTS `compte`;

CREATE TABLE `compte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `niveauId` int(11) NOT NULL,
  `solde` int(11) DEFAULT NULL,
  `numero_compte` varchar(225) NOT NULL,
  `etat` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `compte` */

/*Table structure for table `niveau` */

DROP TABLE IF EXISTS `niveau`;

CREATE TABLE `niveau` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(225) NOT NULL,
  `montant_max` int(11) NOT NULL,
  `nbre_activite` int(11) NOT NULL,
  `etat` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `niveau` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
