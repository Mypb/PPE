-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 30 Avril 2015 à 17:34
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `banques`
--

INSERT INTO `banques` (`bnq_id`, `bnq_utlId`, `bnq_intitule`, `bnq_numero`, `bqn_guichet`) VALUES
(6, 33, 'test', '0', '0'),
(7, 34, 'test', '0', '0'),
(8, 33, 'test', '0', '0'),
(9, 35, 'fds', '0', '0'),
(10, 35, 'sdfg', '0', '0');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `comptes`
--

INSERT INTO `comptes` (`cpt_id`, `cpt_bnqId`, `cpt_intitule`, `cpt_type`, `cpt_montant`, `cpt_numero`) VALUES
(4, 6, 'test', 'test', 2, '0'),
(5, 6, 'test', 'test', 2, '0'),
(6, 7, 'test', 'test', 2, '0'),
(7, 8, 'tes', 'test', 2, '0'),
(8, 9, 'dsf', 'dsg', 132, '0'),
(9, 9, 'fsqdf', 'fqsdf', 2, '456');

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
  `op_typeOpId` int(11) NOT NULL,
  `op_rglId` int(11) NOT NULL,
  PRIMARY KEY (`op_id`),
  KEY `op_typeOpId` (`op_typeOpId`,`op_rglId`),
  KEY `op_rglId` (`op_rglId`),
  KEY `op_cptId` (`op_cptId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `operations`
--

INSERT INTO `operations` (`op_id`, `op_montant`, `op_motif`, `op_tiers`, `op_date`, `op_fait`, `op_cptId`, `op_typeOpId`, `op_rglId`) VALUES
(10, 2, 'testd', 'tes', '1995-02-02', 1, 8, 1, 1),
(11, 7843, 'gfdh', 'dfghdf', '2016-05-02', 1, 8, 1, 1),
(12, 7456879, 'hgfd', 'df', '2019-01-02', 1, 8, 1, 1),
(13, 45645, 'gfsdfg', 'gfdsfgs', '1995-02-02', 1, 9, 1, 1),
(14, 5, 'fd', 'hgfdhg', '0001-01-01', 1, 8, 1, 1),
(15, 1, 'test', 'test', '1995-02-02', 1, 8, 1, 1),
(16, 2, ',jyf', 'kjygk', '2019-02-02', 0, 8, 1, 1),
(17, 2, 'liudfg', 'lkughef', '1995-02-02', 1, 8, 1, 1),
(18, 5, 'fdsq', 'fdsq', '2020-02-02', 0, 8, 1, 1),
(19, 20, 'hgfd', 'hgfd', '0002-02-02', 1, 8, 1, 1),
(20, 100, 'fgds', 'gfds', '0002-02-02', 1, 8, 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`utl_id`, `utl_nom`, `utl_prenom`, `utl_motDePasse`, `utl_mail`) VALUES
(33, 'Wilgenbus', 'Robin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'SenrielW@laposte.net'),
(34, 'test', 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'test'),
(35, 'Wilgenbus', 'Robin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Senriel');

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
  ADD CONSTRAINT `operations_ibfk_3` FOREIGN KEY (`op_cptId`) REFERENCES `comptes` (`cpt_id`),
  ADD CONSTRAINT `operations_ibfk_1` FOREIGN KEY (`op_typeOpId`) REFERENCES `types_operations` (`typOp_id`),
  ADD CONSTRAINT `operations_ibfk_2` FOREIGN KEY (`op_rglId`) REFERENCES `modes_reglements` (`rgl_id`);

--
-- Contraintes pour la table `operations_planifiees`
--
ALTER TABLE `operations_planifiees`
  ADD CONSTRAINT `operations_planifiees_ibfk_1` FOREIGN KEY (`opPlan_typPlnId`) REFERENCES `types_planifications` (`typPln_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
