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

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `prenoms` varchar(255) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `type_userId` int(11) NOT NULL,
  `paysId` int(11) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `identifiant` varchar(255) DEFAULT NULL,
  `role` smallint(6) NOT NULL DEFAULT '10',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_userId` (`type_userId`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`type_userId`) REFERENCES `type_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`prenoms`,`contact`,`email`,`logo`,`type_userId`,`paysId`,`auth_key`,`password_hash`,`password_reset_token`,`identifiant`,`role`,`status`,`created_at`,`updated_at`) values (9,'well','well','90414158','iwell@live.fr',NULL,8,0,'$2y$13$7sByo','$2y$13$7sByo/QBZdxzRPiHRKtw4uIN2ujBj6AwSiTwwqto.mwQbhzotxuRS','',NULL,10,10,2018,2018),(12,'wells',NULL,'','iwells@live.fr','event1.jpg',8,0,'??f??v?l??O???4z??Ӭ?????T??*>','$2y$13$Bu5idbU.ymRKoVFyVGDQVO9Qggw1u0KHuJbJK0bIqQ/jNrFlohRbC',NULL,NULL,10,10,1524139605,1524139605),(13,'intime',NULL,'','intime@live.fr','nursary_img1.jpg',8,0,'??\'95??^??;?B?)??2?h?????n?%n:','$2y$13$dQ9Ok56sx2Ir4dMpdb4g3OGfSL9b4t5bM7fRErM0xax.VYtV3dAnS',NULL,NULL,10,10,1524157434,1524157434),(14,'moov togo',NULL,'','m@m.tg',NULL,10,0,'??X?IOƌoly?)>(@?|z??T?9m?','$2y$13$NaIF5oiNdFar3Q7Z4VnanOlvj5lmBo9vL3r0NSuY6fo1SBkXsGNT6',NULL,NULL,10,10,1524594064,1524594064);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
