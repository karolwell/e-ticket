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

/*Table structure for table `abonnement` */

DROP TABLE IF EXISTS `abonnement`;

CREATE TABLE `abonnement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editeurId` int(11) NOT NULL,
  `type_abonnementId` int(11) NOT NULL,
  `date_detut_abonnement` datetime NOT NULL,
  `date_fin_abonnement` datetime NOT NULL,
  `etat` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `editeurId` (`editeurId`),
  KEY `type_abonnementId` (`type_abonnementId`),
  CONSTRAINT `abonnement_ibfk_1` FOREIGN KEY (`editeurId`) REFERENCES `user` (`id`),
  CONSTRAINT `abonnement_ibfk_2` FOREIGN KEY (`type_abonnementId`) REFERENCES `type_abonnement` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `abonnement` */

insert  into `abonnement`(`id`,`editeurId`,`type_abonnementId`,`date_detut_abonnement`,`date_fin_abonnement`,`etat`) values (1,9,1,'2018-04-16 00:00:00','2018-05-31 00:00:00',1),(2,9,2,'2018-04-21 00:00:00','2018-08-01 00:00:00',1),(3,9,3,'2018-04-21 00:00:00','2018-12-28 00:00:00',1);

/*Table structure for table `achat` */

DROP TABLE IF EXISTS `achat`;

CREATE TABLE `achat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientId` int(255) NOT NULL,
  `dateAchat` datetime NOT NULL,
  `montant` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clientId` (`clientId`),
  CONSTRAINT `achat_ibfk_1` FOREIGN KEY (`clientId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `achat` */

/*Table structure for table `achat_details` */

DROP TABLE IF EXISTS `achat_details`;

CREATE TABLE `achat_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticketId` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `achatId` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ticketId` (`ticketId`),
  KEY `clientId` (`clientId`),
  KEY `achatId` (`achatId`),
  CONSTRAINT `achat_details_ibfk_1` FOREIGN KEY (`ticketId`) REFERENCES `ticket` (`id`),
  CONSTRAINT `achat_details_ibfk_2` FOREIGN KEY (`clientId`) REFERENCES `user` (`id`),
  CONSTRAINT `achat_details_ibfk_3` FOREIGN KEY (`achatId`) REFERENCES `achat` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `achat_details` */

/*Table structure for table `activite` */

DROP TABLE IF EXISTS `activite`;

CREATE TABLE `activite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) NOT NULL,
  `description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `editeurId` int(11) NOT NULL,
  `categorie_activiteId` int(11) NOT NULL,
  `lieu` varchar(255) CHARACTER SET latin1 NOT NULL,
  `datedebut` date NOT NULL,
  `heuredebut` time NOT NULL,
  `datefin` date NOT NULL,
  `heurefin` time NOT NULL,
  `reference` varchar(255) CHARACTER SET latin1 NOT NULL,
  `image` varchar(255) CHARACTER SET latin1 NOT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `editeurId` (`editeurId`),
  KEY `categorie_activiteId` (`categorie_activiteId`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `activite_ibfk_1` FOREIGN KEY (`editeurId`) REFERENCES `user` (`id`),
  CONSTRAINT `activite_ibfk_2` FOREIGN KEY (`categorie_activiteId`) REFERENCES `categorie_activite` (`id`),
  CONSTRAINT `activite_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `activite_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `activite` */

insert  into `activite`(`id`,`designation`,`description`,`editeurId`,`categorie_activiteId`,`lieu`,`datedebut`,`heuredebut`,`datefin`,`heurefin`,`reference`,`image`,`latitude`,`longitude`,`etat`,`created_by`,`date_create`,`updated_by`,`date_update`) values (1,'Parking Radison blue','Gestion de parking de Radison blue dans le cadre ...',9,4,'Radison blue','2018-04-23','17:00:00','2018-04-23','21:30:00','myHtd90YKJ1B41J-','03.jpg',NULL,NULL,1,9,'2018-04-23 12:21:13',NULL,NULL),(2,'Concert indépendance','Concert de l\'indépendance du Togo ...',9,5,'Palais','2018-04-27','19:00:00','2018-04-27','22:00:00','HbhfX_S0PuUV8H5Z','02.jpg',NULL,NULL,1,9,'2018-04-23 16:19:09',NULL,NULL);

/*Table structure for table `categorie_activite` */

DROP TABLE IF EXISTS `categorie_activite`;

CREATE TABLE `categorie_activite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `categorie_activite_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `categorie_activite_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `categorie_activite` */

insert  into `categorie_activite`(`id`,`designation`,`etat`,`created_by`,`date_create`,`updated_by`,`date_update`) values (3,'Transport',1,9,'2018-04-23 08:14:36',NULL,NULL),(4,'parking',1,9,'2018-04-23 08:15:37',NULL,NULL),(5,'evenement',1,9,'2018-04-23 08:16:49',NULL,NULL);

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

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `population` int(11) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `country` */

insert  into `country`(`code`,`country`,`population`) values ('AU','Australia',18886000),('BR','Brazil',170115000),('CA','Canada',1147000),('CN','China',1277558000),('DE','Germany',82164700),('FR','France',59225700),('GB','United Kingdom',59623400),('IN','India',1013662000),('RU','Russia',146934000),('US','United States',278357000);

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values ('m000000_000000_base',1520419089),('m130524_201442_init',1520419092),('m150812_015333_create_country_table',1520419093),('m150812_020403_populate_country',1520419093);

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

/*Table structure for table `protocole_facturier` */

DROP TABLE IF EXISTS `protocole_facturier`;

CREATE TABLE `protocole_facturier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `ftp_ip` varchar(255) DEFAULT NULL,
  `ftp_username` varchar(255) DEFAULT NULL,
  `ftp_password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `protocole_facturier_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `protocole_facturier` */

/*Table structure for table `ticket` */

DROP TABLE IF EXISTS `ticket`;

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) DEFAULT NULL,
  `prix` varchar(255) NOT NULL,
  `nombre_ticket` varchar(255) DEFAULT NULL,
  `type_ticketId` int(11) NOT NULL,
  `activiteId` int(11) NOT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `validiteId` int(11) DEFAULT NULL,
  `duree_validite` int(255) DEFAULT NULL,
  `nombre_validation` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_ticketId` (`type_ticketId`),
  KEY `activiteId` (`activiteId`),
  KEY `validiteId` (`validiteId`),
  CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`type_ticketId`) REFERENCES `type_ticket` (`id`),
  CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`activiteId`) REFERENCES `activite` (`id`),
  CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`validiteId`) REFERENCES `validite` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ticket` */

/*Table structure for table `tmoney` */

DROP TABLE IF EXISTS `tmoney`;

CREATE TABLE `tmoney` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_payeur` varchar(255) NOT NULL,
  `nom` int(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `solde` datetime NOT NULL,
  `langue` int(3) NOT NULL,
  `etat` tinyint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tmoney` */

/*Table structure for table `transfert` */

DROP TABLE IF EXISTS `transfert`;

CREATE TABLE `transfert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `achat_detailsId` int(11) NOT NULL,
  `senderId` int(11) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `date_transfert` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `achat_detailsId` (`achat_detailsId`),
  KEY `senderId` (`senderId`),
  CONSTRAINT `transfert_ibfk_1` FOREIGN KEY (`achat_detailsId`) REFERENCES `achat_details` (`id`),
  CONSTRAINT `transfert_ibfk_2` FOREIGN KEY (`senderId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `transfert` */

/*Table structure for table `type_abonnement` */

DROP TABLE IF EXISTS `type_abonnement`;

CREATE TABLE `type_abonnement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `type_abonnement_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `type_abonnement_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `type_abonnement` */

insert  into `type_abonnement`(`id`,`designation`,`prix`,`etat`,`created_by`,`date_create`,`updated_by`,`date_update`) values (1,'Sylver','50000',1,9,'2018-03-26 14:52:19',NULL,NULL),(2,'Gold','200000',1,9,'2018-03-26 14:53:16',NULL,NULL),(3,'Diamond','300000',1,9,'2018-03-26 14:54:00',NULL,NULL);

/*Table structure for table `type_ticket` */

DROP TABLE IF EXISTS `type_ticket`;

CREATE TABLE `type_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `type_ticket_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `type_ticket_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `type_ticket` */

/*Table structure for table `type_user` */

DROP TABLE IF EXISTS `type_user`;

CREATE TABLE `type_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `type_user_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `type_user_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `type_user` */

insert  into `type_user`(`id`,`designation`,`etat`,`created_by`,`date_create`,`updated_by`,`date_update`) values (8,'editeur',1,9,'2018-03-26 13:42:36',NULL,NULL),(9,'client',1,9,'2018-03-26 13:42:36',NULL,NULL),(10,'facturier',1,9,'2018-04-24 14:34:04',NULL,NULL);

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

/*Table structure for table `validation` */

DROP TABLE IF EXISTS `validation`;

CREATE TABLE `validation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `achat_detailsId` int(11) NOT NULL,
  `validated_by` int(11) NOT NULL,
  `date_validation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `achat_detailsId` (`achat_detailsId`),
  KEY `validated_by` (`validated_by`),
  CONSTRAINT `validation_ibfk_1` FOREIGN KEY (`achat_detailsId`) REFERENCES `achat_details` (`id`),
  CONSTRAINT `validation_ibfk_2` FOREIGN KEY (`validated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `validation` */

/*Table structure for table `validite` */

DROP TABLE IF EXISTS `validite`;

CREATE TABLE `validite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `validite_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `validite_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `validite` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
