-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 29 Octobre 2018 à 10:49
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `e-ticket`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE IF NOT EXISTS `abonnement` (
`id` int(11) NOT NULL,
  `editeurId` int(11) NOT NULL,
  `type_abonnementId` int(11) NOT NULL,
  `date_detut_abonnement` datetime NOT NULL,
  `date_fin_abonnement` datetime NOT NULL,
  `etat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

CREATE TABLE IF NOT EXISTS `achat` (
`id` int(11) NOT NULL,
  `numero_client` varchar(20) NOT NULL,
  `dateAchat` datetime NOT NULL,
  `montant` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `code_facture` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `achat`
--

INSERT INTO `achat` (`id`, `numero_client`, `dateAchat`, `montant`, `etat`, `code_facture`) VALUES
(3, '22891121670', '2018-04-27 03:28:20', '6000', 1, 'A97165'),
(4, '22891121674', '2018-04-27 03:33:26', '25000', 1, 'A17786'),
(5, '22891121670', '2018-04-28 03:09:19', '40000', 1, 'A94844'),
(6, '22891121670', '2018-04-28 03:41:06', '10000', 1, 'A49265'),
(7, '22891121670', '2018-04-28 03:50:09', '50000', 1, 'A70128'),
(8, '22891121670', '2018-04-28 03:51:25', '50000', 1, 'A61635'),
(9, '22891121670', '2018-04-28 03:55:23', '40000', 1, 'A35004'),
(10, '22891121670', '2018-04-28 04:02:42', '30000', 1, 'A28698'),
(11, '22891121670', '2018-04-28 04:03:58', '50000', 1, 'A95275'),
(12, '22891121670', '2018-04-28 04:07:49', '20000', 1, 'A94913'),
(13, '22891121670', '2018-05-02 12:41:50', '40000', 1, 'A86374'),
(14, '22899545407', '2018-05-02 13:16:25', '40000', 1, 'A19080'),
(15, '22890052685', '2018-05-05 02:02:38', '20000', 1, 'A20184'),
(16, '22890414158', '2018-05-07 13:10:41', '10000', 1, 'A68551');

-- --------------------------------------------------------

--
-- Structure de la table `achat_details`
--

CREATE TABLE IF NOT EXISTS `achat_details` (
`id` int(11) NOT NULL,
  `ticketId` int(11) NOT NULL,
  `numero_client` varchar(20) NOT NULL,
  `achatId` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `achat_details`
--

INSERT INTO `achat_details` (`id`, `ticketId`, `numero_client`, `achatId`, `code`, `etat`) VALUES
(1, 2, '22891121670', 3, '166292952368', 1),
(2, 2, '22891121670', 3, '671544529275', 1),
(3, 2, '22891121670', 3, '673293366969', 1),
(4, 4, '22891121674', 4, '771242812847', 1),
(5, 4, '22891121674', 4, '333259571761', 1),
(6, 4, '22891121674', 4, '385253865475', 1),
(7, 4, '22891121674', 4, '619377649868', 1),
(8, 4, '22891121674', 4, '771293666587', 1),
(9, 3, '22891121670', 5, '862918522612', 1),
(10, 3, '22891121670', 5, '284817549962', 1),
(11, 3, '22891121670', 5, '995866412425', 1),
(12, 3, '22891121670', 5, '363792829844', 1),
(28, 3, '22891121670', 10, '452296263676', 1),
(29, 3, '22891121670', 10, '787672731199', 1),
(30, 3, '22891121670', 10, '641242581879', 1),
(31, 3, '22891121670', 11, '345758743949', 1),
(32, 3, '22891121670', 11, '963648498365', 1),
(33, 3, '22891121670', 11, '781549339416', 1),
(34, 3, '22891121670', 11, '192375872468', 1),
(35, 3, '22891121670', 11, '192441248818', 1),
(36, 3, '22891121670', 12, '795445591615', 1),
(37, 3, '22891121670', 12, '429451637534', 1),
(38, 6, '22891121670', 13, '955825284974', 1),
(39, 6, '22891121670', 13, '116857684673', 1),
(40, 6, '22899545407', 14, '931341188727', 1),
(41, 6, '22899545407', 14, '615292513187', 1),
(42, 6, '22890052685', 15, '352728185426', 1),
(43, 4, '22890414158', 16, '533452362749', 1),
(44, 4, '22890414158', 16, '869434618399', 1);

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE IF NOT EXISTS `activite` (
`id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `editeurId` int(11) NOT NULL,
  `categorie_activiteId` int(11) NOT NULL,
  `lieu` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `datedebut` date DEFAULT NULL,
  `heuredebut` time DEFAULT NULL,
  `datefin` date DEFAULT NULL,
  `heurefin` time DEFAULT NULL,
  `reference` varchar(255) CHARACTER SET latin1 NOT NULL,
  `image` varchar(255) CHARACTER SET latin1 NOT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `activite`
--

INSERT INTO `activite` (`id`, `designation`, `description`, `editeurId`, `categorie_activiteId`, `lieu`, `datedebut`, `heuredebut`, `datefin`, `heurefin`, `reference`, `image`, `latitude`, `longitude`, `etat`, `created_by`, `date_create`, `updated_by`, `date_update`) VALUES
(4, 'aeroport', NULL, 3, 1, 'hedrzanawoe', '2018-05-01', '18:16:27', '2019-08-24', '02:42:38', '', '', NULL, NULL, 1, 1, '2018-04-23 18:17:07', NULL, NULL),
(5, 'concert de lindependance', NULL, 3, 1, 'palais', '2018-04-18', '18:16:27', NULL, NULL, '', '', NULL, NULL, 1, 1, '2018-04-23 18:17:07', NULL, NULL),
(6, 'troncon bè - agoe', NULL, 4, 1, '', '2018-04-23', '18:16:27', '2018-08-01', '02:42:25', '', '', NULL, NULL, 1, 1, '2018-04-23 18:17:07', NULL, NULL),
(8, 'activite 3', NULL, 3, 2, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, '2018-04-25 11:52:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categorie_activite`
--

CREATE TABLE IF NOT EXISTS `categorie_activite` (
`id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categorie_activite`
--

INSERT INTO `categorie_activite` (`id`, `designation`, `etat`, `created_by`, `date_create`, `updated_by`, `date_update`) VALUES
(1, 'parking', 1, 1, '0000-00-00 00:00:00', NULL, NULL),
(2, 'spectacle', 1, 1, '0000-00-00 00:00:00', NULL, NULL),
(3, 'transport', 1, 1, '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE IF NOT EXISTS `compte` (
`id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `niveauId` int(11) NOT NULL,
  `solde` int(11) DEFAULT NULL,
  `numero_compte` varchar(225) NOT NULL,
  `etat` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `config_editeur`
--

CREATE TABLE IF NOT EXISTS `config_editeur` (
  `id` int(11) NOT NULL,
  `url_impression_ticket_gratuit` varchar(255) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `etat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `config_facturier`
--

CREATE TABLE IF NOT EXISTS `config_facturier` (
`id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `url_api` varchar(255) DEFAULT NULL,
  `ftp_ip` varchar(255) DEFAULT NULL,
  `ftp_username` varchar(255) DEFAULT NULL,
  `ftp_password` varchar(255) DEFAULT NULL,
  `etat` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `config_facturier`
--

INSERT INTO `config_facturier` (`id`, `userId`, `url_api`, `ftp_ip`, `ftp_username`, `ftp_password`, `etat`) VALUES
(1, 5, 'http://localhost/e_ticket_web/api/web/v1/factures/get?access-token=cRWGhLFOma3G0katiA2Ubs1I9XIDoJO4', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `population` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `country`
--

INSERT INTO `country` (`code`, `country`, `population`) VALUES
('AU', 'Australia', 18886000),
('BR', 'Brazil', 170115000),
('CA', 'Canada', 1147000),
('CN', 'China', 1277558000),
('DE', 'Germany', 82164700),
('FR', 'France', 59225700),
('GB', 'United Kingdom', 59623400),
('IN', 'India', 1013662000),
('RU', 'Russia', 146934000),
('US', 'United States', 278357000);

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE IF NOT EXISTS `factures` (
`id` int(11) NOT NULL,
  `numero_client` varchar(255) NOT NULL,
  `facturierId` int(11) NOT NULL,
  `mois_facture` varchar(255) NOT NULL,
  `response` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `etat` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `factures`
--

INSERT INTO `factures` (`id`, `numero_client`, `facturierId`, `mois_facture`, `response`, `code`, `date`, `etat`) VALUES
(1, '22891121670', 5, 'August 2017', '[{"client":"A5","mois":"August 2017"}]', 'F41909', '2018-04-30 05:57:49', 1),
(2, '22891121677', 5, 'September 2017', '[{"client":"A5","mois":"September 2017"}]', 'F69257', '2018-04-30 05:58:55', 1),
(3, '22891121670', 5, 'April 2018', '[{"client":"A5","mois":"April 2018"}]', 'F68389', '2018-05-02 11:38:07', 1),
(4, '22899545407', 5, 'November 2017', '[{"client":"A5","mois":"November 2017"}]', 'F88686', '2018-05-02 13:17:40', 1),
(5, '22890071688', 5, 'July 2017', '[{"client":"A5","mois":"July 2017"}]', 'F29643', '2018-05-05 02:23:34', 1),
(6, '22890071688', 5, 'June 2017', '[{"client":"A5","mois":"June 2017"}]', 'F60847', '2018-05-05 02:24:10', 1),
(7, '22890071688', 5, 'May 2017', '[{"client":"A5","mois":"May 2017"}]', 'F35716', '2018-05-05 02:24:46', 1),
(8, '22891121670', 5, 'July 2017', '[{"client":"A5","mois":"July 2017"}]', 'F30201', '2018-05-14 14:14:24', 1),
(9, '22899595353', 5, 'February 2018', '[{"client":"A5","mois":"February 2018"}]', 'F76115', '2018-05-14 14:15:44', 1);

-- --------------------------------------------------------

--
-- Structure de la table `immatriculation`
--

CREATE TABLE IF NOT EXISTS `immatriculation` (
`id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `numero_plaque` varchar(255) NOT NULL,
  `cni` varchar(255) NOT NULL,
  `marque_engin` varchar(255) NOT NULL,
  `taxe_active` tinyint(1) NOT NULL,
  `date_update_taxe` datetime DEFAULT NULL,
  `date_expire_taxe` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `immatriculation`
--

INSERT INTO `immatriculation` (`id`, `nom`, `prenom`, `numero_plaque`, `cni`, `marque_engin`, `taxe_active`, `date_update_taxe`, `date_expire_taxe`) VALUES
(1, 'KOUDAM', 'yvon', '3310 BP', '1111-222-333-4444', 'haojue', 1, '2018-08-06 19:31:39', '2018-08-16 19:31:41'),
(2, 'LAWSON', 'Well', '3311 AX', '0000-222-555-9999', 'Toyota', 1, '2018-08-07 10:32:27', '2018-08-07 10:32:27'),
(3, 'ABITOR', 'josue', '1234 AZ', '1223-333-1346', 'toyota', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `menu_ussd`
--

CREATE TABLE IF NOT EXISTS `menu_ussd` (
`id_menu_ussd` int(11) NOT NULL,
  `position_menu_ussd` tinyint(3) NOT NULL,
  `denomination` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_create` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `menu_ussd`
--

INSERT INTO `menu_ussd` (`id_menu_ussd`, `position_menu_ussd`, `denomination`, `description`, `status`, `date_create`) VALUES
(1, 1, 'Réservation', 'Permet de declarer le produit, la quantité disponible et le prix de vente', 1, '2017-03-14 10:16:12'),
(2, 2, 'Impression de factures', 'Permet de récupérer les contacts téléphonique d''un annonceur', 1, '2017-03-14 10:16:12'),
(3, 3, 'Impression des tickets', 'Permet de recevoir des informations sur des spéculations précises', 1, '2017-03-14 10:16:12'),
(4, 4, 'Top évenements', 'Permet de trouver un produit et son producteur sur l’étendue du territoire ', 1, '0000-00-00 00:00:00'),
(14, 5, 'Prevision meteo', 'Permet de recupere les informations meteorologique sur une interval de date donnee.', 2, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1520419089),
('m130524_201442_init', 1520419092),
('m150812_015333_create_country_table', 1520419093),
('m150812_020403_populate_country', 1520419093);

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

CREATE TABLE IF NOT EXISTS `niveau` (
`id` int(11) NOT NULL,
  `designation` varchar(225) NOT NULL,
  `montant_max` int(11) NOT NULL,
  `nbre_activite` int(11) NOT NULL,
  `etat` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
`id` int(11) NOT NULL,
  `code` int(3) NOT NULL,
  `alpha2` varchar(255) NOT NULL,
  `alpha3` varchar(255) NOT NULL,
  `nom_en_gb` varchar(255) NOT NULL,
  `nom_fr_fr` varchar(255) NOT NULL,
  `indicatif` varchar(255) NOT NULL,
  `statut` int(2) NOT NULL DEFAULT '0',
  `centre_latitude` varchar(50) DEFAULT NULL,
  `centre_longitude` varchar(50) DEFAULT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pays`
--

INSERT INTO `pays` (`id`, `code`, `alpha2`, `alpha3`, `nom_en_gb`, `nom_fr_fr`, `indicatif`, `statut`, `centre_latitude`, `centre_longitude`, `prix`) VALUES
(1, 4, 'AF', 'AFG', 'Afghanistan', 'Afganistan', '93', 0, '33.578537', '65.174986', 150),
(2, 8, 'AL', 'ALB', 'Albania', 'Albanie', '355', 0, '41', '125', 0),
(3, 10, 'AQ', 'ATA', 'Antarctica', 'Antarctique', '', 0, NULL, NULL, 0),
(4, 12, 'DZ', 'DZA', 'Algeria', 'Algérie', '213', 0, NULL, NULL, 0),
(5, 16, 'AS', 'ASM', 'American Samoa', 'Samoa Américaines', '', 0, NULL, NULL, 0),
(6, 20, 'AD', 'AND', 'Andorra', 'Andorre', '376', 0, NULL, NULL, 0),
(7, 24, 'AO', 'AGO', 'Angola', 'Angola', '244', 0, NULL, NULL, 0),
(8, 28, 'AG', 'ATG', 'Antigua and Barbuda', 'Antigua-et-Barbuda', '', 0, NULL, NULL, 0),
(9, 31, 'AZ', 'AZE', 'Azerbaijan', 'Azerbaïdjan', '994', 0, NULL, NULL, 0),
(10, 32, 'AR', 'ARG', 'Argentina', 'Argentine', '54', 0, NULL, NULL, 0),
(11, 36, 'AU', 'AUS', 'Australia', 'Australie', '61', 0, NULL, NULL, 0),
(12, 40, 'AT', 'AUT', 'Austria', 'Autriche', '43', 0, NULL, NULL, 0),
(13, 44, 'BS', 'BHS', 'Bahamas', 'Bahamas', '1242', 0, NULL, NULL, 0),
(14, 48, 'BH', 'BHR', 'Bahrain', 'Bahreïn', '973', 0, NULL, NULL, 0),
(15, 50, 'BD', 'BGD', 'Bangladesh', 'Bangladesh', '880', 0, NULL, NULL, 0),
(16, 51, 'AM', 'ARM', 'Armenia', 'Arménie', '374', 0, NULL, NULL, 0),
(17, 52, 'BB', 'BRB', 'Barbados', 'Barbade', '', 0, NULL, NULL, 0),
(18, 56, 'BE', 'BEL', 'Belgium', 'Belgique', '32', 0, NULL, NULL, 0),
(19, 60, 'BM', 'BMU', 'Bermuda', 'Bermudes', '1441', 0, NULL, NULL, 0),
(20, 64, 'BT', 'BTN', 'Bhutan', 'Bhoutan', '975', 0, NULL, NULL, 0),
(21, 68, 'BO', 'BOL', 'Bolivia', 'Bolivie', '591', 0, NULL, NULL, 0),
(22, 70, 'BA', 'BIH', 'Bosnia and Herzegovina', 'Bosnie-Herzégovine', '387', 0, NULL, NULL, 0),
(23, 72, 'BW', 'BWA', 'Botswana', 'Botswana', '267', 0, NULL, NULL, 0),
(24, 74, 'BV', 'BVT', 'Bouvet Island', 'Île Bouvet', '', 0, NULL, NULL, 0),
(25, 76, 'BR', 'BRA', 'Brazil', 'Brésil', '55', 0, NULL, NULL, 0),
(26, 84, 'BZ', 'BLZ', 'Belize', 'Belize', '501', 0, NULL, NULL, 0),
(27, 86, 'IO', 'IOT', 'British Indian Ocean Territory', 'Territoire Britannique de l''Océan Indien', '', 0, NULL, NULL, 0),
(28, 90, 'SB', 'SLB', 'Solomon Islands', 'Îles Salomon', '', 0, NULL, NULL, 0),
(29, 92, 'VG', 'VGB', 'British Virgin Islands', 'Îles Vierges Britanniques', '', 0, NULL, NULL, 0),
(30, 96, 'BN', 'BRN', 'Brunei Darussalam', 'Brunéi Darussalam', '673', 0, NULL, NULL, 0),
(31, 100, 'BG', 'BGR', 'Bulgaria', 'Bulgarie', '359', 0, NULL, NULL, 0),
(32, 104, 'MM', 'MMR', 'Myanmar', 'Myanmar', '95', 0, NULL, NULL, 0),
(33, 108, 'BI', 'BDI', 'Burundi', 'Burundi', '257', 0, NULL, NULL, 0),
(34, 112, 'BY', 'BLR', 'Belarus', 'Bélarus', '375', 0, NULL, NULL, 0),
(35, 116, 'KH', 'KHM', 'Cambodia', 'Cambodge', '855', 0, NULL, NULL, 0),
(36, 120, 'CM', 'CMR', 'Cameroon', 'Cameroun', '237', 0, NULL, NULL, 0),
(37, 124, 'CA', 'CAN', 'Canada', 'Canada', '1', 0, NULL, NULL, 0),
(38, 132, 'CV', 'CPV', 'Cape Verde', 'Cap-vert', '238', 0, NULL, NULL, 0),
(39, 136, 'KY', 'CYM', 'Cayman Islands', 'Îles Caïmanes', '1345', 0, NULL, NULL, 0),
(40, 140, 'CF', 'CAF', 'Central African', 'République Centrafricaine', '236', 0, NULL, NULL, 0),
(41, 144, 'LK', 'LKA', 'Sri Lanka', 'Sri Lanka', '94', 0, NULL, NULL, 0),
(42, 148, 'TD', 'TCD', 'Chad', 'Tchad', '235', 0, NULL, NULL, 0),
(43, 152, 'CL', 'CHL', 'Chile', 'Chili', '56', 0, NULL, NULL, 0),
(44, 156, 'CN', 'CHN', 'China', 'Chine', '86', 0, NULL, NULL, 0),
(45, 158, 'TW', 'TWN', 'Taiwan', 'Taïwan', '886', 0, NULL, NULL, 0),
(46, 162, 'CX', 'CXR', 'Christmas Island', 'Île Christmas', '', 0, NULL, NULL, 0),
(47, 166, 'CC', 'CCK', 'Cocos (Keeling) Islands', 'Îles Cocos (Keeling)', '', 0, NULL, NULL, 0),
(48, 170, 'CO', 'COL', 'Colombia', 'Colombie', '57', 0, NULL, NULL, 0),
(49, 174, 'KM', 'COM', 'Comoros', 'Comores', '269', 0, NULL, NULL, 0),
(50, 175, 'YT', 'MYT', 'Mayotte', 'Mayotte', '', 0, NULL, NULL, 0),
(51, 178, 'CG', 'COG', 'Republic of the Congo', 'République du Congo', '242', 0, NULL, NULL, 0),
(52, 180, 'CD', 'COD', 'The Democratic Republic Of The Congo', 'République Démocratique du Congo', '', 0, NULL, NULL, 0),
(53, 184, 'CK', 'COK', 'Cook Islands', 'Îles Cook', '', 0, NULL, NULL, 0),
(54, 188, 'CR', 'CRI', 'Costa Rica', 'Costa Rica', '506', 0, NULL, NULL, 0),
(55, 191, 'HR', 'HRV', 'Croatia', 'Croatie', '385', 0, NULL, NULL, 0),
(56, 192, 'CU', 'CUB', 'Cuba', 'Cuba', '53', 0, NULL, NULL, 0),
(57, 196, 'CY', 'CYP', 'Cyprus', 'Chypre', '357', 0, NULL, NULL, 0),
(58, 203, 'CZ', 'CZE', 'Czech Republic', 'République Tchèque', '', 0, NULL, NULL, 0),
(59, 204, 'BJ', 'BEN', 'Benin', 'Bénin', '229', 0, '9.054681', '2.153979', 0),
(60, 208, 'DK', 'DNK', 'Denmark', 'Danemark', '45', 0, NULL, NULL, 0),
(61, 212, 'DM', 'DMA', 'Dominica', 'Dominique', '', 0, NULL, NULL, 0),
(62, 214, 'DO', 'DOM', 'Dominican Republic', 'République Dominicaine', '1809', 0, NULL, NULL, 0),
(63, 218, 'EC', 'ECU', 'Ecuador', 'Équateur', '593', 0, NULL, NULL, 0),
(64, 222, 'SV', 'SLV', 'El Salvador', 'El Salvador', '503', 0, NULL, NULL, 0),
(65, 226, 'GQ', 'GNQ', 'Equatorial Guinea', 'Guinée Équatoriale', '240', 0, NULL, NULL, 0),
(66, 231, 'ET', 'ETH', 'Ethiopia', 'Éthiopie', '251', 0, NULL, NULL, 0),
(67, 232, 'ER', 'ERI', 'Eritrea', 'Érythrée', '291', 0, NULL, NULL, 0),
(68, 233, 'EE', 'EST', 'Estonia', 'Estonie', '372', 0, NULL, NULL, 0),
(69, 234, 'FO', 'FRO', 'Faroe Islands', 'Îles Féroé', '298', 0, NULL, NULL, 0),
(70, 238, 'FK', 'FLK', 'Falkland Islands', 'Îles (malvinas) Falkland', '', 0, NULL, NULL, 0),
(71, 239, 'GS', 'SGS', 'South Georgia and the South Sandwich Islands', 'Géorgie du Sud et les Îles Sandwich du Sud', '', 0, NULL, NULL, 0),
(72, 242, 'FJ', 'FJI', 'Fiji', 'Fidji', '679', 0, NULL, NULL, 0),
(73, 246, 'FI', 'FIN', 'Finland', 'Finlande', '358', 0, NULL, NULL, 0),
(74, 248, 'AX', 'ALA', 'Åland Islands', 'Îles Åland', '', 0, NULL, NULL, 0),
(75, 250, 'FR', 'FRA', 'France', 'France', '33', 0, NULL, NULL, 0),
(76, 254, 'GF', 'GUF', 'French Guiana', 'Guyane Française', '', 0, NULL, NULL, 0),
(77, 258, 'PF', 'PYF', 'French Polynesia', 'Polynésie Française', '689', 0, NULL, NULL, 0),
(78, 260, 'TF', 'ATF', 'French Southern Territories', 'Terres Australes Françaises', '', 0, NULL, NULL, 0),
(79, 262, 'DJ', 'DJI', 'Djibouti', 'Djibouti', '253', 0, NULL, NULL, 0),
(80, 266, 'GA', 'GAB', 'Gabon', 'Gabon', '241', 0, NULL, NULL, 0),
(81, 268, 'GE', 'GEO', 'Georgia', 'Géorgie', '995', 0, NULL, NULL, 0),
(82, 270, 'GM', 'GMB', 'Gambia', 'Gambie', '220', 0, NULL, NULL, 0),
(83, 275, 'PS', 'PSE', 'Occupied Palestinian Territory', 'Territoire Palestinien Occupé', '', 0, NULL, NULL, 0),
(84, 276, 'DE', 'DEU', 'Germany', 'Allemagne', '49', 0, NULL, NULL, 0),
(85, 288, 'GH', 'GHA', 'Ghana', 'Ghana', '233', 0, NULL, NULL, 0),
(86, 292, 'GI', 'GIB', 'Gibraltar', 'Gibraltar', '350', 0, NULL, NULL, 0),
(87, 296, 'KI', 'KIR', 'Kiribati', 'Kiribati', '', 0, NULL, NULL, 0),
(88, 300, 'GR', 'GRC', 'Greece', 'Grèce', '30', 0, NULL, NULL, 0),
(89, 304, 'GL', 'GRL', 'Greenland', 'Groenland', '299', 0, NULL, NULL, 0),
(90, 308, 'GD', 'GRD', 'Grenada', 'Grenade', '1473', 0, NULL, NULL, 0),
(91, 312, 'GP', 'GLP', 'Guadeloupe', 'Guadeloupe', '', 0, NULL, NULL, 0),
(92, 316, 'GU', 'GUM', 'Guam', 'Guam', '', 0, NULL, NULL, 0),
(93, 320, 'GT', 'GTM', 'Guatemala', 'Guatemala', '502', 0, NULL, NULL, 0),
(94, 324, 'GN', 'GIN', 'Guinea', 'Guinée', '224', 0, NULL, NULL, 0),
(95, 328, 'GY', 'GUY', 'Guyana', 'Guyana', '592', 0, NULL, NULL, 0),
(96, 332, 'HT', 'HTI', 'Haiti', 'Haïti', '509', 0, NULL, NULL, 0),
(97, 334, 'HM', 'HMD', 'Heard Island and McDonald Islands', 'Îles Heard et Mcdonald', '', 0, NULL, NULL, 0),
(98, 336, 'VA', 'VAT', 'Vatican City State', 'Saint-Siège (état de la Cité du Vatican)', '39', 0, NULL, NULL, 0),
(99, 340, 'HN', 'HND', 'Honduras', 'Honduras', '504', 0, NULL, NULL, 0),
(100, 344, 'HK', 'HKG', 'Hong Kong', 'Hong-Kong', '852', 0, NULL, NULL, 0),
(101, 348, 'HU', 'HUN', 'Hungary', 'Hongrie', '36', 0, NULL, NULL, 0),
(102, 352, 'IS', 'ISL', 'Iceland', 'Islande', '354', 0, NULL, NULL, 0),
(103, 356, 'IN', 'IND', 'India', 'Inde', '91', 0, NULL, NULL, 0),
(104, 360, 'ID', 'IDN', 'Indonesia', 'Indonésie', '62', 0, NULL, NULL, 0),
(105, 364, 'IR', 'IRN', 'Islamic Republic of Iran', 'République Islamique d''Iran', '98', 0, NULL, NULL, 0),
(106, 368, 'IQ', 'IRQ', 'Iraq', 'Iraq', '964', 0, NULL, NULL, 0),
(107, 372, 'IE', 'IRL', 'Ireland', 'Irlande', '353', 0, NULL, NULL, 0),
(108, 376, 'IL', 'ISR', 'Israel', 'Israël', '972', 0, NULL, NULL, 0),
(109, 380, 'IT', 'ITA', 'Italy', 'Italie', '39', 0, NULL, NULL, 0),
(110, 384, 'CI', 'CIV', 'Côte d''Ivoire', 'Côte d''Ivoire', '225', 0, NULL, NULL, 0),
(111, 388, 'JM', 'JAM', 'Jamaica', 'Jamaïque', '1876', 0, NULL, NULL, 0),
(112, 392, 'JP', 'JPN', 'Japan', 'Japon', '81', 0, NULL, NULL, 0),
(113, 398, 'KZ', 'KAZ', 'Kazakhstan', 'Kazakhstan', '381', 0, NULL, NULL, 0),
(114, 400, 'JO', 'JOR', 'Jordan', 'Jordanie', '962', 0, NULL, NULL, 0),
(115, 404, 'KE', 'KEN', 'Kenya', 'Kenya', '254', 0, NULL, NULL, 0),
(116, 408, 'KP', 'PRK', 'Democratic People''s Republic of Korea', 'République Populaire Démocratique de Corée', '850', 0, NULL, NULL, 0),
(117, 410, 'KR', 'KOR', 'Republic of Korea', 'République de Corée', '8262', 0, NULL, NULL, 0),
(118, 414, 'KW', 'KWT', 'Kuwait', 'Koweït', '965', 0, NULL, NULL, 0),
(119, 417, 'KG', 'KGZ', 'Kyrgyzstan', 'Kirghizistan', '996', 0, NULL, NULL, 0),
(120, 418, 'LA', 'LAO', 'Lao People''s Democratic Republic', 'République Démocratique Populaire Lao', '6', 0, NULL, NULL, 0),
(121, 422, 'LB', 'LBN', 'Lebanon', 'Liban', '961', 0, NULL, NULL, 0),
(122, 426, 'LS', 'LSO', 'Lesotho', 'Lesotho', '266', 0, NULL, NULL, 0),
(123, 428, 'LV', 'LVA', 'Latvia', 'Lettonie', '371', 0, NULL, NULL, 0),
(124, 430, 'LR', 'LBR', 'Liberia', 'Libéria', '231', 0, NULL, NULL, 0),
(125, 434, 'LY', 'LBY', 'Libyan Arab Jamahiriya', 'Jamahiriya Arabe Libyenne', '218', 0, NULL, NULL, 0),
(126, 438, 'LI', 'LIE', 'Liechtenstein', 'Liechtenstein', '423', 0, NULL, NULL, 0),
(127, 440, 'LT', 'LTU', 'Lithuania', 'Lituanie', '370', 0, NULL, NULL, 0),
(128, 442, 'LU', 'LUX', 'Luxembourg', 'Luxembourg', '352', 0, NULL, NULL, 0),
(129, 446, 'MO', 'MAC', 'Macao', 'Macao', '853', 0, NULL, NULL, 0),
(130, 450, 'MG', 'MDG', 'Madagascar', 'Madagascar', '261', 0, NULL, NULL, 0),
(131, 454, 'MW', 'MWI', 'Malawi', 'Malawi', '265', 0, NULL, NULL, 0),
(132, 458, 'MY', 'MYS', 'Malaysia', 'Malaisie', '60', 0, NULL, NULL, 0),
(133, 462, 'MV', 'MDV', 'Maldives', 'Maldives', '960', 0, NULL, NULL, 0),
(134, 466, 'ML', 'MLI', 'Mali', 'Mali', '223', 0, NULL, NULL, 0),
(135, 470, 'MT', 'MLT', 'Malta', 'Malte', '356', 0, NULL, NULL, 0),
(136, 474, 'MQ', 'MTQ', 'Martinique', 'Martinique', '', 0, NULL, NULL, 0),
(137, 478, 'MR', 'MRT', 'Mauritania', 'Mauritanie', '269', 0, NULL, NULL, 0),
(138, 480, 'MU', 'MUS', 'Mauritius', 'Maurice', '230', 0, NULL, NULL, 0),
(139, 484, 'MX', 'MEX', 'Mexico', 'Mexique', '52', 0, NULL, NULL, 0),
(140, 492, 'MC', 'MCO', 'Monaco', 'Monaco', '377', 0, NULL, NULL, 0),
(141, 496, 'MN', 'MNG', 'Mongolia', 'Mongolie', '976', 0, NULL, NULL, 0),
(142, 498, 'MD', 'MDA', 'Republic of Moldova', 'République de Moldova', '373', 0, NULL, NULL, 0),
(143, 500, 'MS', 'MSR', 'Montserrat', 'Montserrat', '1664', 0, NULL, NULL, 0),
(144, 504, 'MA', 'MAR', 'Morocco', 'Maroc', '596', 0, NULL, NULL, 0),
(145, 508, 'MZ', 'MOZ', 'Mozambique', 'Mozambique', '258', 0, NULL, NULL, 0),
(146, 512, 'OM', 'OMN', 'Oman', 'Oman', '968', 0, NULL, NULL, 0),
(147, 516, 'NA', 'NAM', 'Namibia', 'Namibie', '264', 0, NULL, NULL, 0),
(148, 520, 'NR', 'NRU', 'Nauru', 'Nauru', '', 0, NULL, NULL, 0),
(149, 524, 'NP', 'NPL', 'Nepal', 'Népal', '977', 0, NULL, NULL, 0),
(150, 528, 'NL', 'NLD', 'Netherlands', 'Pays-Bas', '31', 0, NULL, NULL, 0),
(151, 530, 'AN', 'ANT', 'Netherlands Antilles', 'Antilles Néerlandaises', '', 0, NULL, NULL, 0),
(152, 533, 'AW', 'ABW', 'Aruba', 'Aruba', '', 0, NULL, NULL, 0),
(153, 540, 'NC', 'NCL', 'New Caledonia', 'Nouvelle-Calédonie', '687', 0, NULL, NULL, 0),
(154, 548, 'VU', 'VUT', 'Vanuatu', 'Vanuatu', '', 0, NULL, NULL, 0),
(155, 554, 'NZ', 'NZL', 'New Zealand', 'Nouvelle-Zélande', '64', 0, NULL, NULL, 0),
(156, 558, 'NI', 'NIC', 'Nicaragua', 'Nicaragua', '505', 0, NULL, NULL, 0),
(157, 562, 'NE', 'NER', 'Niger', 'Niger', '227', 0, NULL, NULL, 0),
(158, 566, 'NG', 'NGA', 'Nigeria', 'Nigéria', '234', 0, NULL, NULL, 0),
(159, 570, 'NU', 'NIU', 'Niue', 'Niué', '', 0, NULL, NULL, 0),
(160, 574, 'NF', 'NFK', 'Norfolk Island', 'Île Norfolk', '', 0, NULL, NULL, 0),
(161, 578, 'NO', 'NOR', 'Norway', 'Norvège', '47', 0, NULL, NULL, 0),
(162, 580, 'MP', 'MNP', 'Northern Mariana Islands', 'Îles Mariannes du Nord', '', 0, NULL, NULL, 0),
(163, 581, 'UM', 'UMI', 'United States Minor Outlying Islands', 'Îles Mineures Éloignées des États-Unis', '', 0, NULL, NULL, 0),
(164, 583, 'FM', 'FSM', 'Federated States of Micronesia', 'États Fédérés de Micronésie', '', 0, NULL, NULL, 0),
(165, 584, 'MH', 'MHL', 'Marshall Islands', 'Îles Marshall', '', 0, NULL, NULL, 0),
(166, 585, 'PW', 'PLW', 'Palau', 'Palaos', '', 0, NULL, NULL, 0),
(167, 586, 'PK', 'PAK', 'Pakistan', 'Pakistan', '92', 0, NULL, NULL, 0),
(168, 591, 'PA', 'PAN', 'Panama', 'Panama', '507', 0, NULL, NULL, 0),
(169, 598, 'PG', 'PNG', 'Papua New Guinea', 'Papouasie-Nouvelle-Guinée', '675', 0, NULL, NULL, 0),
(170, 600, 'PY', 'PRY', 'Paraguay', 'Paraguay', '595', 0, NULL, NULL, 0),
(171, 604, 'PE', 'PER', 'Peru', 'Pérou', '51', 0, NULL, NULL, 0),
(172, 608, 'PH', 'PHL', 'Philippines', 'Philippines', '63', 0, NULL, NULL, 0),
(173, 612, 'PN', 'PCN', 'Pitcairn', 'Pitcairn', '', 0, NULL, NULL, 0),
(174, 616, 'PL', 'POL', 'Poland', 'Pologne', '48', 0, NULL, NULL, 0),
(175, 620, 'PT', 'PRT', 'Portugal', 'Portugal', '351', 0, NULL, NULL, 0),
(176, 624, 'GW', 'GNB', 'Guinea-Bissau', 'Guinée-Bissau', '245', 0, NULL, NULL, 0),
(177, 626, 'TL', 'TLS', 'Timor-Leste', 'Timor-Leste', '', 0, NULL, NULL, 0),
(178, 630, 'PR', 'PRI', 'Puerto Rico', 'Porto Rico', '1787', 0, NULL, NULL, 0),
(179, 634, 'QA', 'QAT', 'Qatar', 'Qatar', '974', 0, NULL, NULL, 0),
(180, 638, 'RE', 'REU', 'Réunion', 'Réunion', '262', 0, NULL, NULL, 0),
(181, 642, 'RO', 'ROU', 'Romania', 'Roumanie', '40', 0, NULL, NULL, 0),
(182, 643, 'RU', 'RUS', 'Russian Federation', 'Fédération de Russie', '7', 0, NULL, NULL, 0),
(183, 646, 'RW', 'RWA', 'Rwanda', 'Rwanda', '250', 0, NULL, NULL, 0),
(184, 654, 'SH', 'SHN', 'Saint Helena', 'Sainte-Hélène', '290', 0, NULL, NULL, 0),
(185, 659, 'KN', 'KNA', 'Saint Kitts and Nevis', 'Saint-Kitts-et-Nevis', '', 0, NULL, NULL, 0),
(186, 660, 'AI', 'AIA', 'Anguilla', 'Anguilla', '1264', 0, NULL, NULL, 0),
(187, 662, 'LC', 'LCA', 'Saint Lucia', 'Sainte-Lucie', '1758', 0, NULL, NULL, 0),
(188, 666, 'PM', 'SPM', 'Saint-Pierre and Miquelon', 'Saint-Pierre-et-Miquelon', '', 0, NULL, NULL, 0),
(189, 670, 'VC', 'VCT', 'Saint Vincent and the Grenadines', 'Saint-Vincent-et-les Grenadines', '', 0, NULL, NULL, 0),
(190, 674, 'SM', 'SMR', 'San Marino', 'Saint-Marin', '378', 0, NULL, NULL, 0),
(191, 678, 'ST', 'STP', 'Sao Tome and Principe', 'Sao Tomé-et-Principe', '239', 0, NULL, NULL, 0),
(192, 682, 'SA', 'SAU', 'Saudi Arabia', 'Arabie Saoudite', '966', 0, NULL, NULL, 0),
(193, 686, 'SN', 'SEN', 'Senegal', 'Sénégal', '221', 0, NULL, NULL, 0),
(194, 690, 'SC', 'SYC', 'Seychelles', 'Seychelles', '248', 0, NULL, NULL, 0),
(195, 694, 'SL', 'SLE', 'Sierra Leone', 'Sierra Leone', '232', 0, NULL, NULL, 0),
(196, 702, 'SG', 'SGP', 'Singapore', 'Singapour', '65', 0, NULL, NULL, 0),
(197, 703, 'SK', 'SVK', 'Slovakia', 'Slovaquie', '421', 0, NULL, NULL, 0),
(198, 704, 'VN', 'VNM', 'Vietnam', 'Viet Nam', '', 0, NULL, NULL, 0),
(199, 705, 'SI', 'SVN', 'Slovenia', 'Slovénie', '386', 0, NULL, NULL, 0),
(200, 706, 'SO', 'SOM', 'Somalia', 'Somalie', '252', 0, NULL, NULL, 0),
(201, 710, 'ZA', 'ZAF', 'South Africa', 'Afrique du Sud', '27', 0, NULL, NULL, 0),
(202, 716, 'ZW', 'ZWE', 'Zimbabwe', 'Zimbabwe', '', 0, NULL, NULL, 0),
(203, 724, 'ES', 'ESP', 'Spain', 'Espagne', '34', 0, NULL, NULL, 0),
(204, 732, 'EH', 'ESH', 'Western Sahara', 'Sahara Occidental', '212', 0, NULL, NULL, 0),
(205, 736, 'SD', 'SDN', 'Sudan', 'Soudan', '249', 1, NULL, NULL, 1),
(206, 740, 'SR', 'SUR', 'Suriname', 'Suriname', '597', 0, NULL, NULL, 0),
(207, 744, 'SJ', 'SJM', 'Svalbard and Jan Mayen', 'Svalbard etÎle Jan Mayen', '', 0, NULL, NULL, 0),
(208, 748, 'SZ', 'SWZ', 'Swaziland', 'Swaziland', '268', 0, NULL, NULL, 0),
(209, 752, 'SE', 'SWE', 'Sweden', 'Suède', '46', 0, NULL, NULL, 0),
(210, 756, 'CH', 'CHE', 'Switzerland', 'Suisse', '41', 0, NULL, NULL, 0),
(211, 760, 'SY', 'SYR', 'Syrian Arab Republic', 'République Arabe Syrienne', '963', 0, NULL, NULL, 0),
(212, 762, 'TJ', 'TJK', 'Tajikistan', 'Tadjikistan', '992', 0, NULL, NULL, 0),
(213, 764, 'TH', 'THA', 'Thailand', 'Thaïlande', '66', 0, NULL, NULL, 0),
(214, 768, 'TG', 'TGO', 'Togo', 'Togo', '228', 1, '8.5482949', '1.7027534', 50),
(215, 772, 'TK', 'TKL', 'Tokelau', 'Tokelau', '', 0, NULL, NULL, 0),
(216, 776, 'TO', 'TON', 'Tonga', 'Tonga', '676', 0, NULL, NULL, 0),
(217, 780, 'TT', 'TTO', 'Trinidad and Tobago', 'Trinité-et-Tobago', '1868 ', 0, NULL, NULL, 0),
(218, 784, 'AE', 'ARE', 'United Arab Emirates', 'Émirats Arabes Unis', '971', 0, NULL, NULL, 0),
(219, 788, 'TN', 'TUN', 'Tunisia', 'Tunisie', '216', 0, NULL, NULL, 0),
(220, 792, 'TR', 'TUR', 'Turkey', 'Turquie', '90', 0, NULL, NULL, 0),
(221, 795, 'TM', 'TKM', 'Turkmenistan', 'Turkménistan', '993', 0, NULL, NULL, 0),
(222, 796, 'TC', 'TCA', 'Turks and Caicos Islands', 'Îles Turks et Caïques', '', 0, NULL, NULL, 0),
(223, 798, 'TV', 'TUV', 'Tuvalu', 'Tuvalu', '688', 0, NULL, NULL, 0),
(224, 800, 'UG', 'UGA', 'Uganda', 'Ouganda', '256', 0, NULL, NULL, 0),
(225, 804, 'UA', 'UKR', 'Ukraine', 'Ukraine', '', 0, NULL, NULL, 0),
(226, 807, 'MK', 'MKD', 'The Former Yugoslav Republic of Macedonia', 'L''ex-République Yougoslave de Macédoine', '389', 0, NULL, NULL, 0),
(227, 818, 'EG', 'EGY', 'Egypt', 'Égypte', '20', 0, NULL, NULL, 0),
(228, 826, 'GB', 'GBR', 'United Kingdom', 'Royaume-Uni', '', 0, NULL, NULL, 0),
(229, 833, 'IM', 'IMN', 'Isle of Man', 'Île de Man', '', 0, NULL, NULL, 0),
(230, 834, 'TZ', 'TZA', 'United Republic Of Tanzania', 'République-Unie de Tanzanie', '255', 0, NULL, NULL, 0),
(231, 840, 'US', 'USA', 'United States', 'États-Unis', '1', 0, NULL, NULL, 0),
(232, 850, 'VI', 'VIR', 'U.S. Virgin Islands', 'Îles Vierges des États-Unis', '', 0, NULL, NULL, 0),
(233, 854, 'BF', 'BFA', 'Burkina Faso', 'Burkina Faso', '226', 0, NULL, NULL, 0),
(234, 858, 'UY', 'URY', 'Uruguay', 'Uruguay', '', 0, NULL, NULL, 0),
(235, 860, 'UZ', 'UZB', 'Uzbekistan', 'Ouzbékistan', '998', 0, NULL, NULL, 0),
(236, 862, 'VE', 'VEN', 'Venezuela', 'Venezuela', '', 0, NULL, NULL, 0),
(237, 876, 'WF', 'WLF', 'Wallis and Futuna', 'Wallis et Futuna', '', 0, NULL, NULL, 0),
(238, 882, 'WS', 'WSM', 'Samoa', 'Samoa', '685', 0, NULL, NULL, 0),
(239, 887, 'YE', 'YEM', 'Yemen', 'Yémen', '', 0, NULL, NULL, 0),
(240, 891, 'CS', 'SCG', 'Serbia and Montenegro', 'Serbie-et-Monténégro', '', 0, NULL, NULL, 0),
(241, 894, 'ZM', 'ZMB', 'Zambia', 'Zambie', '', 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
`id` int(11) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `prix` int(25) DEFAULT NULL,
  `nombre_ticket` varchar(255) DEFAULT NULL,
  `type_ticketId` int(11) NOT NULL,
  `activiteId` int(11) NOT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `validiteId` int(11) DEFAULT NULL,
  `duree_validite` int(255) DEFAULT NULL,
  `nombre_validation` int(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ticket`
--

INSERT INTO `ticket` (`id`, `designation`, `prix`, `nombre_ticket`, `type_ticketId`, `activiteId`, `periode`, `validiteId`, `duree_validite`, `nombre_validation`) VALUES
(1, '1000f', 1000, '30', 3, 4, NULL, 1, NULL, 2),
(2, '2000f', 2000, '30', 5, 4, NULL, 3, 20, 3),
(3, '10000f', 10000, '30', 9, 5, NULL, 3, NULL, NULL),
(4, '5000f', 5000, '30', 6, 6, NULL, 4, NULL, NULL),
(6, '20000f', 20000, '30', 7, 6, NULL, 1, NULL, NULL),
(7, '1000f', 1000, '30', 8, 6, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ticket_gratuit`
--

CREATE TABLE IF NOT EXISTS `ticket_gratuit` (
`id` int(11) NOT NULL,
  `ticketId` int(11) NOT NULL,
  `numero_client` int(11) NOT NULL,
  `code_impression` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tmoney`
--

CREATE TABLE IF NOT EXISTS `tmoney` (
`id` int(11) NOT NULL,
  `numero_payeur` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `solde` varchar(20) NOT NULL,
  `langue` varchar(20) NOT NULL,
  `etat` tinyint(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tmoney`
--

INSERT INTO `tmoney` (`id`, `numero_payeur`, `nom`, `prenom`, `solde`, `langue`, `etat`) VALUES
(1, '22891121675', 'bj', 'yvon', '500000', 'francais', 1),
(2, '22891121674', 'giovanni', 'well', '0', 'anglais', 1);

-- --------------------------------------------------------

--
-- Structure de la table `top_evenement`
--

CREATE TABLE IF NOT EXISTS `top_evenement` (
`id` int(11) NOT NULL,
  `activiteId` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_fin` datetime NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `top_evenement`
--

INSERT INTO `top_evenement` (`id`, `activiteId`, `date_create`, `created_by`, `date_update`, `updated_by`, `date_fin`, `etat`, `message`) VALUES
(1, 4, '2018-05-02 14:20:30', 1, NULL, NULL, '2018-06-21 14:20:37', 1, 'test top evenement aeroport'),
(2, 5, '2018-05-02 14:20:50', 1, NULL, NULL, '2018-05-20 14:20:55', 1, 'test top evenement independance'),
(4, 6, '2018-05-02 14:21:06', 1, NULL, NULL, '2018-05-19 14:21:17', 1, 'test top evenement troncon bè - agoe');

-- --------------------------------------------------------

--
-- Structure de la table `transfert`
--

CREATE TABLE IF NOT EXISTS `transfert` (
`id` int(11) NOT NULL,
  `achat_detailsId` int(11) NOT NULL,
  `senderId` int(11) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `date_transfert` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `type_abonnement`
--

CREATE TABLE IF NOT EXISTS `type_abonnement` (
`id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `type_ticket`
--

CREATE TABLE IF NOT EXISTS `type_ticket` (
`id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `editeurId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `type_ticket`
--

INSERT INTO `type_ticket` (`id`, `designation`, `etat`, `created_by`, `date_create`, `updated_by`, `date_update`, `editeurId`) VALUES
(1, 'badge', 1, 1, '0000-00-00 00:00:00', NULL, NULL, 2),
(3, 'impression', 1, 1, '0000-00-00 00:00:00', NULL, NULL, 2),
(4, '1000f', 1, 1, '0000-00-00 00:00:00', NULL, NULL, 3),
(5, '2000f', 1, 1, '0000-00-00 00:00:00', NULL, NULL, 3),
(6, '5000f', 1, 1, '0000-00-00 00:00:00', NULL, NULL, 4),
(7, '20000f', 1, 1, '2018-04-24 13:38:50', NULL, NULL, 4),
(8, '1000f', 1, 1, '2018-04-24 14:17:13', NULL, NULL, 4),
(9, '10000f', 1, 1, '2018-04-24 14:23:05', NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `type_user`
--

CREATE TABLE IF NOT EXISTS `type_user` (
`id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `groupe` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `type_user`
--

INSERT INTO `type_user` (`id`, `designation`, `etat`, `created_by`, `date_create`, `updated_by`, `date_update`, `groupe`) VALUES
(1, 'admin', 1, NULL, NULL, NULL, NULL, 'admin'),
(2, 'client', 1, NULL, NULL, NULL, NULL, 'simple'),
(3, 'editeur', 1, NULL, NULL, NULL, NULL, 'simple'),
(4, 'facturier', 1, NULL, NULL, NULL, NULL, 'simple');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `prenoms` varchar(255) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type_userId` int(11) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `role` smallint(6) DEFAULT '10',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `identifiant` varchar(10) DEFAULT NULL,
  `paysId` int(255) NOT NULL,
  `registrationId` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `prenoms`, `contact`, `email`, `type_userId`, `auth_key`, `password_hash`, `password_reset_token`, `role`, `status`, `created_at`, `updated_at`, `logo`, `identifiant`, `paysId`, `registrationId`) VALUES
(1, 'bj', 'yvon', '22891121674', 'koudamyvon@gmail.com', 2, 'cRWGhLFOma3G0katiA2Ubs1I9XIDoJO4', '$2y$13$EjYEsQGc.FoR2mnCha1m.Og3qH6QwrDfOlVAOiaFXMNBEAFqp7oCi', NULL, 10, 10, 1524051460, NULL, NULL, '00001', 214, NULL),
(2, 'koudamd', 'yvon', '2289112156', NULL, 3, 'UhQzu_iYCzjas5J3QTchbfUD4JdLOXNg', '$2y$13$EjYEsQGc.FoR2mnCha1m.Og3qH6QwrDfOlVAOiaFXMNBEAFqp7oCi', NULL, 10, 10, 1524067519, NULL, NULL, '00002', 214, NULL),
(3, 'koudamh', 'yvon', '2289112157', NULL, 3, 'tduOoc7AAAKC6ztpfA1wy39UK8epD0ex', '$2y$13$EjYEsQGc.FoR2mnCha1m.Og3qH6QwrDfOlVAOiaFXMNBEAFqp7oCi', NULL, 10, 10, 1524070946, NULL, NULL, '00003', 214, NULL),
(4, 'GABIAM', 'Folly Bernard', '22891121689', NULL, 3, '2FHPofsCfgHjPUWMGbqT_INSrfBUGiXj', '$2y$13$EjYEsQGc.FoR2mnCha1m.Og3qH6QwrDfOlVAOiaFXMNBEAFqp7oCi', NULL, 10, 10, 1524072187, NULL, NULL, '00004', 214, NULL),
(5, 'GABIAM', 'Folly Bernard', '22890414158', NULL, 4, 'VNR3kk-ZUWEHP3lk_thslw1HIpA1GzlC', '$2y$13$CYEQalfmfX.SdiTUW8fVOOQTSjd7ObQsxW6MF0ugu5JhqaEMLmz1K', NULL, 10, 10, 1524127496, NULL, NULL, '00005', 214, NULL),
(6, 'well', 'well', '90414158', 'iwell@live.fr', 3, 'NpgJZezq9Pbd7seiZN5qx-TEPTm3pgAt', '$2y$13$7sByo/QBZdxzRPiHRKtw4uIN2ujBj6AwSiTwwqto.mwQbhzotxuRS', '', 10, 10, 2018, 2018, NULL, NULL, 214, NULL),
(7, 'wells', NULL, '', 'iwells@live.fr', 3, 'qTOQhdCjx0-bRfrg4VH6NZOn5VlrwGyi', '$2y$13$Bu5idbU.ymRKoVFyVGDQVO9Qggw1u0KHuJbJK0bIqQ/jNrFlohRbC', NULL, 10, 10, 1524139605, 1524139605, 'event1.jpg', NULL, 214, NULL),
(8, 'intime', NULL, '', 'intime@live.fr', 3, 'NBXNiwgRiduzoinMJ43y5UXKyFOcmlSb', '$2y$13$EjYEsQGc.FoR2mnCha1m.Og3qH6QwrDfOlVAOiaFXMNBEAFqp7oCi', NULL, 10, 10, 1524157434, 1524157434, 'nursary_img1.jpg', NULL, 214, NULL),
(9, 'moov togo', NULL, '', 'm@m.tg', 4, 'VNR3kk-ZUWEHP3lk_thsvc1HIpA1GzlC', '$2y$13$NaIF5oiNdFar3Q7Z4VnanOlvj5lmBo9vL3r0NSuY6fo1SBkXsGNT6', NULL, 10, 10, 1524594064, 1524594064, NULL, NULL, 214, NULL),
(12, 'admin', NULL, '', 'dintiamagazine@gmail.comS', 1, 'vaqVTjU8frMDC3IqW5bEcDMtFYM2Z5ot', '$2y$13$XJAYIswbtBZGQPYb9/CXUuNJ.9g3671RoMpC/7VoUhZcLqJK.0iLG', NULL, 10, 10, 1535366914, 1535366914, NULL, NULL, 214, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ussdtransation`
--

CREATE TABLE IF NOT EXISTS `ussdtransation` (
`id` int(11) NOT NULL,
  `idtransaction` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `menu` varchar(50) NOT NULL,
  `datecreation` datetime NOT NULL,
  `sub_menu` tinyint(2) NOT NULL,
  `page_menu` tinyint(1) NOT NULL,
  `etat_transaction` tinyint(1) NOT NULL,
  `others` text,
  `message` text,
  `message_send` text,
  `reference` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ussdtransation`
--

INSERT INTO `ussdtransation` (`id`, `idtransaction`, `username`, `iduser`, `menu`, `datecreation`, `sub_menu`, `page_menu`, `etat_transaction`, `others`, `message`, `message_send`, `reference`) VALUES
(1, '4330', '22891121670', NULL, '2', '2018-05-02 11:37:35', 4, 2, 1, '"facturierIdentif":"00005","refClient":"A5","mois":"April 2018"', NULL, 'vous pouvez imprimer votre facture via cet adresse: https://www.e-tikets.online/impression/F68389', '121212'),
(2, '2790', '22891121670', NULL, '1', '2018-05-02 11:38:29', 4, 0, 0, '"editeurIdentif":"00003","activiteId":"5","ticketId":"3"', NULL, 'Il ne reste que 1 ticket(s) de 10000 F CFA disponible', '121212'),
(3, '4232', '22891121670', NULL, '-1', '2018-05-02 11:54:38', 0, 0, 0, '', NULL, 'WELCOME_ETICKET\n1. Réservation\n2. Impression de factures\n3. Impression des tickets\n4. Top évenements\n\n0. HELP', '121212'),
(4, '1424', '2289112157', NULL, '-1', '2018-05-02 12:16:57', 0, 0, 0, '', NULL, 'WELCOME_ETICKET\n1. Réservation\n2. Impression de factures\n3. Impression des tickets\n4. Top évenements\n\n0. HELP', '121212'),
(5, '2077', '22891121670', NULL, '1', '2018-05-02 12:31:07', 1, 0, 0, '', NULL, 'Code de l''editeur. MENU PRINCIPAL', '121212'),
(6, '1818', '22891121670', NULL, '1', '2018-05-02 12:39:35', 2, 0, 1, '"editeurIdentif":"00005"', NULL, 'AUCUNE ACTIVITE EN COURS POUR CET EDITEUR', '121212'),
(7, '2768', '22891121670', NULL, '1', '2018-05-02 12:39:56', 4, 0, 0, '"editeurIdentif":"00004","activiteId":"6","ticketId":"4"', NULL, 'Il ne reste que -3 ticket(s) de 5000 F CFA disponible', '121212'),
(8, '5091', '22891121670', NULL, '1', '2018-05-02 12:41:09', 6, 0, 1, '"editeurIdentif":"00004","activiteId":"6","ticketId":"6","nbre":"2","montant":"40000"', '955825284974 .Retrouvez vos tickets sur cet adresse: https://www.e-tikets.online/impression/A86374.116857684673 .Retrouvez vos tickets sur cet adresse: https://www.e-tikets.online/impression/A86374.', 'troncon bè - agoe\n Achat de 2 ticket(s) de 20000 F CFA \n\n1. CONFIRMER\n2. ANNULER', '121212'),
(9, '3351', '22891121670', NULL, '2', '2018-05-02 12:46:06', 1, 0, 0, '', NULL, 'Code du facturier. MENU PRINCIPAL', '121212'),
(10, '1381', '22891121670', NULL, '1', '2018-05-02 13:15:04', 4, 0, 0, '"editeurIdentif":"00004","activiteId":"6","ticketId":"6"', NULL, 'Il ne reste que 1 ticket(s) de 20000 F CFA disponible', '121212'),
(11, '4658', '22899545407', NULL, '1', '2018-05-02 13:15:54', 6, 0, 1, '"editeurIdentif":"00004","activiteId":"6","ticketId":"6","nbre":"2","montant":"40000"', '931341188727 .Retrouvez vos tickets sur cet adresse: https://www.e-tikets.online/impression/A19080.615292513187 .Retrouvez vos tickets sur cet adresse: https://www.e-tikets.online/impression/A19080.', 'troncon bè - agoe\n Achat de 2 ticket(s) de 20000 F CFA \n\n1. CONFIRMER\n2. ANNULER', '121212'),
(12, '2342', '22899545407', NULL, '2', '2018-05-02 13:17:21', 4, 1, 1, '"facturierIdentif":"00005","refClient":"A5","mois":"November 2017"', NULL, 'vous pouvez imprimer votre facture via cet adresse: https://www.e-tikets.online/impression/F88686', '121212'),
(13, '2890', '22899545407', NULL, '3', '2018-05-02 13:36:51', 2, 0, 1, '"codeTicket":"615292513187"', 'DEMANDE IMPRESSION TICKET EFFECTUEE AVEC SUCCEES', 'Vous pouvez imprimer votre facture via cet adresse: https://www.e-tikets.online/impression/615292513187', '121212'),
(14, '2563', '22891121670', NULL, '-1', '2018-05-02 13:44:55', 0, 0, 0, '', NULL, 'BIENVENUE DANS E-TICKET\n1. Réservation\n2. Impression de factures\n3. Impression des tickets\n4. Top évenements\n\n0. AIDE', '121212'),
(15, '2352', '22891121670', NULL, '4', '2018-05-02 14:21:32', 1, 0, 0, '', NULL, 'BIENVENUE DANS E-TICKET\n1. Réservation\n2. Impression de factures\n3. Impression des tickets\n4. Top évenements\n\n0. AIDE', '121212'),
(16, '2680', '22891121670', NULL, '4', '2018-05-02 14:23:15', 1, 0, 0, '', NULL, 'BIENVENUE DANS E-TICKET\n1. Réservation\n2. Impression de factures\n3. Impression des tickets\n4. Top évenements\n\n0. AIDE', '121212'),
(17, '4673', '22891121670', NULL, '4', '2018-05-02 14:23:54', 1, 0, 0, '', NULL, 'BIENVENUE DANS E-TICKET\n1. Réservation\n2. Impression de factures\n3. Impression des tickets\n4. Top évenements\n\n0. AIDE', '121212'),
(18, '5237', '22891121670', NULL, '4', '2018-05-02 14:36:24', 1, 0, 0, '', NULL, 'TOP EVENEMENTS\n1. aeroport\n2. concert de lindependance\n3. troncon bè - agoe', '121212'),
(19, '2103', '22891121670', NULL, '4', '2018-05-02 14:47:46', 1, 0, 0, '', NULL, 'TOP EVENEMENTS\n1. aeroport\n2. concert de lindependance\n3. troncon bè - agoe', '121212'),
(20, '4430', '22891121670', NULL, '4', '2018-05-02 15:42:17', 1, 0, 0, '', NULL, 'TOP EVENEMENTS\n1. aeroport\n2. concert de lindependance\n3. troncon bè - agoe', '121212'),
(21, '4107', '22891121670', NULL, '1', '2018-05-02 22:49:39', 2, 0, 1, '"editeurIdentif":"00005"', NULL, 'AUCUNE ACTIVITE EN COURS POUR CET EDITEUR', '121212'),
(22, '1568', '22890052685', NULL, '1', '2018-05-05 02:00:55', 6, 0, 1, '"editeurIdentif":"00004","activiteId":"6","ticketId":"6","nbre":"1","montant":"20000"', '352728185426 .Retrouvez vos tickets sur cet adresse: https://www.e-tikets.online/impression/A20184.', 'troncon bè - agoe\n Achat de 1 ticket(s) de 20000 F CFA \n\n1. CONFIRMER\n2. ANNULER', '121212'),
(23, '3562', '22890071688', NULL, '2', '2018-05-05 02:03:20', 3, 1, 0, '"facturierIdentif":"00005","refClient":"A5"', NULL, 'SELECTIONER LE MOIS\n1. May 2017\n2. June 2017\n3. July 2017\n4. August 2017\n5. September 2017\n6. October 2017\n7. November 2017\n8. December 2017\n9. January 2018\n10. February 2018\n\n99 SUIVANT', '121212'),
(24, '2996', '22890071688', NULL, '2', '2018-05-05 02:12:57', 4, 1, 1, '"facturierIdentif":"00005","refClient":"A5","mois":"May 2017"', 'Vous pouvez imprimer votre facture via cet adresse: https://www.e-tikets.online/impression/F35716', 'DEMANDE IMPRESSION FACTURE EFFECTUEE AVEC SUCCEES', '121212'),
(25, '3977', '22891121670', NULL, '3', '2018-05-05 02:26:50', 2, 0, 1, '"codeTicket":"352728185426"', '#352728185426#.Vous pouvez imprimer votre facture via cette adresse: https://www.e-tikets.online/impression/352728185426', 'DEMANDE IMPRESSION TICKET EFFECTUEE AVEC SUCCEES', '121212'),
(26, '2402', '22891121670', NULL, '3', '2018-05-05 02:28:48', 2, 0, 1, '"codeTicket":"352728185426"', '#352728185426#.Vous pouvez imprimer votre facture via cette adresse: https://www.e-tikets.online/impression/352728185426', 'DEMANDE IMPRESSION TICKET EFFECTUEE AVEC SUCCEES', '121212'),
(27, '2064', '22891121670', NULL, '4', '2018-05-05 02:29:21', 1, 0, 0, '', NULL, 'TOP EVENEMENTS\n1. aeroport\n2. concert de lindependance\n3. troncon bè - agoe', '121212'),
(28, '4874', '22891121670', NULL, '4', '2018-05-05 02:32:29', 1, 0, 0, '', NULL, 'TOP EVENEMENTS\n1. aeroport\n2. concert de lindependance\n3. troncon bè - agoe', '121212'),
(29, '2208', '22891121670', NULL, '4', '2018-05-05 02:36:57', 2, 0, 1, '"evenementId":"2"', 'test top evenement independance', 'TOP EVENEMENT CONSULTE AVEC SUCCEES', '121212'),
(30, '4951', '22891121670', NULL, '-1', '2018-05-06 02:47:55', 0, 0, 0, '', NULL, 'BIENVENUE DANS E-TICKET\n1. Réservation\n2. Impression de factures\n3. Impression des tickets\n4. Top évenements\n\n0. AIDE', '121212'),
(31, '5172', '22890414158', NULL, '1', '2018-05-07 13:10:12', 6, 0, 1, '"editeurIdentif":"00004","activiteId":"6","ticketId":"4","nbre":"2","montant":"10000"', '533452362749 .Retrouvez vos tickets sur cette adresse: https://www.e-tikets.online/impression/A68551.869434618399 .Retrouvez vos tickets sur cette adresse: https://www.e-tikets.online/impression/A68551.', 'troncon bè - agoe\n Achat de 2 ticket(s) de 5000 F CFA \n\n1. CONFIRMER\n2. ANNULER', '121212'),
(32, '4179', '22891121670', NULL, '2', '2018-05-14 14:14:08', 4, 1, 1, '"facturierIdentif":"00005","refClient":"A5","mois":"July 2017"', '', 'DEMANDE IMPRESSION FACTURE EFFECTUEE AVEC SUCCEES', '121212'),
(33, '2440', '22899595353', NULL, '2', '2018-05-14 14:15:14', 4, 1, 1, '"facturierIdentif":"00005","refClient":"A5","mois":"February 2018"', '', 'DEMANDE IMPRESSION FACTURE EFFECTUEE AVEC SUCCEES', '121212'),
(34, '3535', '22899595353', NULL, '3', '2018-05-14 14:21:36', 2, 0, 1, '"codeTicket":"869434618399"', '#869434618399#.Vous pouvez imprimer votre facture via ce lien: http://bit.ly/2wGRXBS', 'DEMANDE IMPRESSION TICKET EFFECTUEE AVEC SUCCEES', '121212'),
(35, '5040', '22899595353', NULL, '4', '2018-05-14 14:23:16', 2, 0, 1, '"evenementId":"1"', 'test top evenement aeroport', 'TOP EVENEMENT CONSULTE AVEC SUCCEES', '121212'),
(36, '4809', '22891121670', NULL, '-1', '2018-08-06 11:44:40', 0, 0, 0, '', NULL, 'BIENVENUE DANS E-TICKET\n1. Réservation\n2. Impression de factures\n3. Impression des tickets\n4. Top évenements\n\n0. AIDE', '121212'),
(37, '2714', '22891121670', NULL, '-1', '2018-08-27 12:00:43', 0, 0, 0, '', NULL, 'BIENVENUE DANS E-TICKET\n1. Réservation\n2. Impression de factures\n3. Impression des tickets\n4. Top évenements\n\n0. AIDE', '121212');

-- --------------------------------------------------------

--
-- Structure de la table `validation`
--

CREATE TABLE IF NOT EXISTS `validation` (
`id` int(11) NOT NULL,
  `achat_detailsId` int(11) NOT NULL,
  `validated_by` int(11) NOT NULL,
  `date_validation` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `validation`
--

INSERT INTO `validation` (`id`, `achat_detailsId`, `validated_by`, `date_validation`) VALUES
(1, 2, 1, '2018-05-11 19:42:34'),
(2, 2, 2, '2018-05-11 19:42:52'),
(3, 2, 3, '2018-05-11 19:43:12');

-- --------------------------------------------------------

--
-- Structure de la table `validite`
--

CREATE TABLE IF NOT EXISTS `validite` (
`id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `created_by` int(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `mot_cle` varchar(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `validite`
--

INSERT INTO `validite` (`id`, `designation`, `etat`, `created_by`, `date_create`, `updated_by`, `date_update`, `mot_cle`) VALUES
(1, 'usage unique', 1, 1, '0000-00-00 00:00:00', NULL, NULL, 'UU'),
(2, 'usage multiple ', 1, 1, '0000-00-00 00:00:00', NULL, NULL, 'UM'),
(3, 'usage unique avec periode', 1, 1, '0000-00-00 00:00:00', NULL, NULL, 'UUP'),
(4, 'usage multiple avec periode', 1, 1, '0000-00-00 00:00:00', NULL, NULL, 'UMP');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `abonnement`
--
ALTER TABLE `abonnement`
 ADD PRIMARY KEY (`id`), ADD KEY `editeurId` (`editeurId`), ADD KEY `type_abonnementId` (`type_abonnementId`);

--
-- Index pour la table `achat`
--
ALTER TABLE `achat`
 ADD PRIMARY KEY (`id`), ADD KEY `clientId` (`numero_client`);

--
-- Index pour la table `achat_details`
--
ALTER TABLE `achat_details`
 ADD PRIMARY KEY (`id`), ADD KEY `ticketId` (`ticketId`), ADD KEY `clientId` (`numero_client`), ADD KEY `achatId` (`achatId`);

--
-- Index pour la table `activite`
--
ALTER TABLE `activite`
 ADD PRIMARY KEY (`id`), ADD KEY `editeurId` (`editeurId`), ADD KEY `categorie_activiteId` (`categorie_activiteId`), ADD KEY `created_by` (`created_by`), ADD KEY `updated_by` (`updated_by`);

--
-- Index pour la table `categorie_activite`
--
ALTER TABLE `categorie_activite`
 ADD PRIMARY KEY (`id`), ADD KEY `created_by` (`created_by`), ADD KEY `updated_by` (`updated_by`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `config_editeur`
--
ALTER TABLE `config_editeur`
 ADD PRIMARY KEY (`id`), ADD KEY `userId` (`userId`);

--
-- Index pour la table `config_facturier`
--
ALTER TABLE `config_facturier`
 ADD PRIMARY KEY (`id`), ADD KEY `userId` (`userId`);

--
-- Index pour la table `country`
--
ALTER TABLE `country`
 ADD PRIMARY KEY (`code`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
 ADD PRIMARY KEY (`id`), ADD KEY `facturierId` (`facturierId`);

--
-- Index pour la table `immatriculation`
--
ALTER TABLE `immatriculation`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `menu_ussd`
--
ALTER TABLE `menu_ussd`
 ADD PRIMARY KEY (`id_menu_ussd`);

--
-- Index pour la table `migration`
--
ALTER TABLE `migration`
 ADD PRIMARY KEY (`version`);

--
-- Index pour la table `niveau`
--
ALTER TABLE `niveau`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ticket`
--
ALTER TABLE `ticket`
 ADD PRIMARY KEY (`id`), ADD KEY `type_ticketId` (`type_ticketId`), ADD KEY `activiteId` (`activiteId`), ADD KEY `validiteId` (`validiteId`);

--
-- Index pour la table `ticket_gratuit`
--
ALTER TABLE `ticket_gratuit`
 ADD PRIMARY KEY (`id`), ADD KEY `ticketId` (`ticketId`), ADD KEY `clientId` (`numero_client`), ADD KEY `achatId` (`code_impression`);

--
-- Index pour la table `tmoney`
--
ALTER TABLE `tmoney`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `top_evenement`
--
ALTER TABLE `top_evenement`
 ADD PRIMARY KEY (`id`), ADD KEY `activiteId` (`activiteId`), ADD KEY `created_by` (`created_by`), ADD KEY `updated_by` (`updated_by`);

--
-- Index pour la table `transfert`
--
ALTER TABLE `transfert`
 ADD PRIMARY KEY (`id`), ADD KEY `achat_detailsId` (`achat_detailsId`), ADD KEY `senderId` (`senderId`);

--
-- Index pour la table `type_abonnement`
--
ALTER TABLE `type_abonnement`
 ADD PRIMARY KEY (`id`), ADD KEY `created_by` (`created_by`), ADD KEY `updated_by` (`updated_by`);

--
-- Index pour la table `type_ticket`
--
ALTER TABLE `type_ticket`
 ADD PRIMARY KEY (`id`), ADD KEY `created_by` (`created_by`), ADD KEY `updated_by` (`updated_by`), ADD KEY `editeurId` (`editeurId`);

--
-- Index pour la table `type_user`
--
ALTER TABLE `type_user`
 ADD PRIMARY KEY (`id`), ADD KEY `created_by` (`created_by`), ADD KEY `updated_by` (`updated_by`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD KEY `type_userId` (`type_userId`), ADD KEY `paysId` (`paysId`);

--
-- Index pour la table `ussdtransation`
--
ALTER TABLE `ussdtransation`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `validation`
--
ALTER TABLE `validation`
 ADD PRIMARY KEY (`id`), ADD KEY `achat_detailsId` (`achat_detailsId`), ADD KEY `validated_by` (`validated_by`);

--
-- Index pour la table `validite`
--
ALTER TABLE `validite`
 ADD PRIMARY KEY (`id`), ADD KEY `created_by` (`created_by`), ADD KEY `updated_by` (`updated_by`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `abonnement`
--
ALTER TABLE `abonnement`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `achat`
--
ALTER TABLE `achat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `achat_details`
--
ALTER TABLE `achat_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT pour la table `activite`
--
ALTER TABLE `activite`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `categorie_activite`
--
ALTER TABLE `categorie_activite`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `config_facturier`
--
ALTER TABLE `config_facturier`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `immatriculation`
--
ALTER TABLE `immatriculation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `menu_ussd`
--
ALTER TABLE `menu_ussd`
MODIFY `id_menu_ussd` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `niveau`
--
ALTER TABLE `niveau`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `pays`
--
ALTER TABLE `pays`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=242;
--
-- AUTO_INCREMENT pour la table `ticket`
--
ALTER TABLE `ticket`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `ticket_gratuit`
--
ALTER TABLE `ticket_gratuit`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tmoney`
--
ALTER TABLE `tmoney`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `top_evenement`
--
ALTER TABLE `top_evenement`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `transfert`
--
ALTER TABLE `transfert`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `type_abonnement`
--
ALTER TABLE `type_abonnement`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `type_ticket`
--
ALTER TABLE `type_ticket`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `type_user`
--
ALTER TABLE `type_user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `ussdtransation`
--
ALTER TABLE `ussdtransation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT pour la table `validation`
--
ALTER TABLE `validation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `validite`
--
ALTER TABLE `validite`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `abonnement`
--
ALTER TABLE `abonnement`
ADD CONSTRAINT `abonnement_ibfk_1` FOREIGN KEY (`editeurId`) REFERENCES `user` (`id`),
ADD CONSTRAINT `abonnement_ibfk_2` FOREIGN KEY (`type_abonnementId`) REFERENCES `type_abonnement` (`id`);

--
-- Contraintes pour la table `achat_details`
--
ALTER TABLE `achat_details`
ADD CONSTRAINT `achat_details_ibfk_1` FOREIGN KEY (`ticketId`) REFERENCES `ticket` (`id`),
ADD CONSTRAINT `achat_details_ibfk_3` FOREIGN KEY (`achatId`) REFERENCES `achat` (`id`);

--
-- Contraintes pour la table `activite`
--
ALTER TABLE `activite`
ADD CONSTRAINT `activite_ibfk_1` FOREIGN KEY (`editeurId`) REFERENCES `user` (`id`),
ADD CONSTRAINT `activite_ibfk_2` FOREIGN KEY (`categorie_activiteId`) REFERENCES `categorie_activite` (`id`),
ADD CONSTRAINT `activite_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `activite_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `categorie_activite`
--
ALTER TABLE `categorie_activite`
ADD CONSTRAINT `categorie_activite_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `categorie_activite_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `config_editeur`
--
ALTER TABLE `config_editeur`
ADD CONSTRAINT `config_editeur_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `config_facturier`
--
ALTER TABLE `config_facturier`
ADD CONSTRAINT `config_facturier_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
ADD CONSTRAINT `factures_ibfk_1` FOREIGN KEY (`facturierId`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `ticket`
--
ALTER TABLE `ticket`
ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`type_ticketId`) REFERENCES `type_ticket` (`id`),
ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`activiteId`) REFERENCES `activite` (`id`),
ADD CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`validiteId`) REFERENCES `validite` (`id`);

--
-- Contraintes pour la table `ticket_gratuit`
--
ALTER TABLE `ticket_gratuit`
ADD CONSTRAINT `ticket_gratuit_ibfk_1` FOREIGN KEY (`ticketId`) REFERENCES `ticket` (`id`),
ADD CONSTRAINT `ticket_gratuit_ibfk_2` FOREIGN KEY (`numero_client`) REFERENCES `user` (`id`),
ADD CONSTRAINT `ticket_gratuit_ibfk_3` FOREIGN KEY (`code_impression`) REFERENCES `achat` (`id`);

--
-- Contraintes pour la table `top_evenement`
--
ALTER TABLE `top_evenement`
ADD CONSTRAINT `top_evenement_ibfk_1` FOREIGN KEY (`activiteId`) REFERENCES `activite` (`id`),
ADD CONSTRAINT `top_evenement_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `top_evenement_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `transfert`
--
ALTER TABLE `transfert`
ADD CONSTRAINT `transfert_ibfk_1` FOREIGN KEY (`achat_detailsId`) REFERENCES `achat_details` (`id`),
ADD CONSTRAINT `transfert_ibfk_2` FOREIGN KEY (`senderId`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `type_abonnement`
--
ALTER TABLE `type_abonnement`
ADD CONSTRAINT `type_abonnement_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `type_abonnement_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `type_ticket`
--
ALTER TABLE `type_ticket`
ADD CONSTRAINT `type_ticket_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `type_ticket_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `type_ticket_ibfk_3` FOREIGN KEY (`editeurId`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `type_user`
--
ALTER TABLE `type_user`
ADD CONSTRAINT `type_user_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `type_user_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`type_userId`) REFERENCES `type_user` (`id`),
ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`paysId`) REFERENCES `pays` (`id`);

--
-- Contraintes pour la table `validation`
--
ALTER TABLE `validation`
ADD CONSTRAINT `validation_ibfk_1` FOREIGN KEY (`achat_detailsId`) REFERENCES `achat_details` (`id`),
ADD CONSTRAINT `validation_ibfk_2` FOREIGN KEY (`validated_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `validite`
--
ALTER TABLE `validite`
ADD CONSTRAINT `validite_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
ADD CONSTRAINT `validite_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
