-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 12 Juin 2015 à 15:23
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `mpb`
--

-- --------------------------------------------------------

--
-- Structure de la table `banques`
--

CREATE TABLE IF NOT EXISTS `banques` (
  `bnq_id` int(11) NOT NULL AUTO_INCREMENT,
  `bnq_utlId` int(11) NOT NULL,
  `bnq_intitule` varchar(255) NOT NULL,
  `bnq_numero` decimal(10,0) NOT NULL,
  `bqn_guichet` decimal(10,0) NOT NULL,
  PRIMARY KEY (`bnq_id`),
  KEY `bnq_utlId` (`bnq_utlId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `banques`
--

INSERT INTO `banques` (`bnq_id`, `bnq_utlId`, `bnq_intitule`, `bnq_numero`, `bqn_guichet`) VALUES
(7, 34, 'test', '0', '0'),
(15, 33, 'test34', '0', '0'),
(20, 35, 'Banque Populaire', '45621', '54654');

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE IF NOT EXISTS `comptes` (
  `cpt_id` int(11) NOT NULL AUTO_INCREMENT,
  `cpt_bnqId` int(11) NOT NULL,
  `cpt_intitule` varchar(255) NOT NULL,
  `cpt_type` varchar(255) NOT NULL,
  `cpt_montant` double NOT NULL,
  `cpt_numero` decimal(10,0) NOT NULL,
  PRIMARY KEY (`cpt_id`),
  KEY `cpt_bnqId` (`cpt_bnqId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Contenu de la table `comptes`
--

INSERT INTO `comptes` (`cpt_id`, `cpt_bnqId`, `cpt_intitule`, `cpt_type`, `cpt_montant`, `cpt_numero`) VALUES
(6, 7, 'test', 'test', 2, '0'),
(20, 15, 'test35', 'gdsfgsfg', 0, '0'),
(37, 20, 'Compte Ã©pargne', 'Epargne', 1500, '9999999999');

-- --------------------------------------------------------

--
-- Structure de la table `modes_reglements`
--

CREATE TABLE IF NOT EXISTS `modes_reglements` (
  `rgl_id` int(11) NOT NULL AUTO_INCREMENT,
  `rgl_libelle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rgl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `modes_reglements`
--

INSERT INTO `modes_reglements` (`rgl_id`, `rgl_libelle`) VALUES
(1, 'carteBancaire'),
(2, 'virement'),
(3, 'cheque');

-- --------------------------------------------------------

--
-- Structure de la table `operations`
--

CREATE TABLE IF NOT EXISTS `operations` (
  `op_id` int(11) NOT NULL AUTO_INCREMENT,
  `op_montant` double NOT NULL,
  `op_motif` text NOT NULL,
  `op_tiers` varchar(255) NOT NULL,
  `op_date` date NOT NULL,
  `op_fait` tinyint(1) DEFAULT NULL,
  `op_cptId` int(11) NOT NULL,
  `op_bnqId` int(11) NOT NULL,
  `op_typeOpId` int(11) NOT NULL,
  `op_rglId` int(11) NOT NULL,
  PRIMARY KEY (`op_id`),
  KEY `op_typeOpId` (`op_typeOpId`,`op_rglId`),
  KEY `op_rglId` (`op_rglId`),
  KEY `op_cptId` (`op_cptId`),
  KEY `op_bnqId` (`op_bnqId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `operations`
--

INSERT INTO `operations` (`op_id`, `op_montant`, `op_motif`, `op_tiers`, `op_date`, `op_fait`, `op_cptId`, `op_bnqId`, `op_typeOpId`, `op_rglId`) VALUES
(5, 500, 'Ecole', 'Bissy', '2014-02-02', 1, 37, 20, 2, 2),
(6, 2000, 'Credit', 'Banque', '2013-06-02', 1, 37, 20, 1, 1),
(8, 45, 'Piscine', 'Nerac', '2015-09-02', 0, 37, 20, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `operations_planifiees`
--

CREATE TABLE IF NOT EXISTS `operations_planifiees` (
  `opPlan_id` int(11) NOT NULL AUTO_INCREMENT,
  `opPlan_dateDebut` date NOT NULL,
  `opPlan_dateFin` date NOT NULL,
  `opPlan_typPlnId` int(11) NOT NULL,
  PRIMARY KEY (`opPlan_id`),
  KEY `opPlan_typPlnId` (`opPlan_typPlnId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `types_operations`
--

CREATE TABLE IF NOT EXISTS `types_operations` (
  `typOp_id` int(11) NOT NULL AUTO_INCREMENT,
  `typOp_libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`typOp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `types_operations`
--

INSERT INTO `types_operations` (`typOp_id`, `typOp_libelle`) VALUES
(1, 'entrant'),
(2, 'sortant');

-- --------------------------------------------------------

--
-- Structure de la table `types_planifications`
--

CREATE TABLE IF NOT EXISTS `types_planifications` (
  `typPln_id` int(11) NOT NULL AUTO_INCREMENT,
  `typPln_libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`typPln_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `utl_id` int(11) NOT NULL AUTO_INCREMENT,
  `utl_nom` varchar(255) NOT NULL,
  `utl_prenom` varchar(255) NOT NULL,
  `utl_motDePasse` char(40) NOT NULL,
  `utl_mail` varchar(255) NOT NULL,
  PRIMARY KEY (`utl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`utl_id`, `utl_nom`, `utl_prenom`, `utl_motDePasse`, `utl_mail`) VALUES
(33, 'Wilgenbus', 'Robin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'SenrielW@laposte.net'),
(34, 'test', 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'test'),
(35, 'Wilgenbus', 'Robin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Senriel'),
(36, 'gfdsgfds', 'gsdgfdsfgs', '1216b3c8ab58c2ea0d3dbae18aa694fa2b63fe70', 'gfdsgfdsg');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `banques`
--
ALTER TABLE `banques`
  ADD CONSTRAINT `banques_ibfk_1` FOREIGN KEY (`bnq_utlId`) REFERENCES `utilisateurs` (`utl_id`);

--
-- Contraintes pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD CONSTRAINT `comptes_ibfk_1` FOREIGN KEY (`cpt_bnqId`) REFERENCES `banques` (`bnq_id`);

--
-- Contraintes pour la table `operations`
--
ALTER TABLE `operations`
  ADD CONSTRAINT `operations_ibfk_1` FOREIGN KEY (`op_typeOpId`) REFERENCES `types_operations` (`typOp_id`),
  ADD CONSTRAINT `operations_ibfk_2` FOREIGN KEY (`op_rglId`) REFERENCES `modes_reglements` (`rgl_id`),
  ADD CONSTRAINT `operations_ibfk_3` FOREIGN KEY (`op_cptId`) REFERENCES `comptes` (`cpt_id`),
  ADD CONSTRAINT `operations_ibfk_4` FOREIGN KEY (`op_bnqId`) REFERENCES `banques` (`bnq_id`);

--
-- Contraintes pour la table `operations_planifiees`
--
ALTER TABLE `operations_planifiees`
  ADD CONSTRAINT `operations_planifiees_ibfk_1` FOREIGN KEY (`opPlan_typPlnId`) REFERENCES `types_planifications` (`typPln_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
