-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 21 Avril 2015 à 15:28
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
  PRIMARY KEY (`bnq_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

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
  PRIMARY KEY (`cpt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `modes_reglements`
--

CREATE TABLE IF NOT EXISTS `modes_reglements` (
  `rgl_id` int(11) NOT NULL AUTO_INCREMENT,
  `rgl_libelle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rgl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `op_cptId` int(11) NOT NULL,
  `op_typeOpId` int(11) NOT NULL,
  `op_rglId` int(11) NOT NULL,
  PRIMARY KEY (`op_id`),
  KEY `op_typeOpId` (`op_typeOpId`,`op_rglId`),
  KEY `op_rglId` (`op_rglId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`utl_id`, `utl_nom`, `utl_prenom`, `utl_motDePasse`, `utl_mail`) VALUES
(1, 'test', 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'test@test.net'),
(2, 'Wilgenbus', 'Robin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'SenrielW@laposte.net');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `operations`
--
ALTER TABLE `operations`
  ADD CONSTRAINT `operations_ibfk_2` FOREIGN KEY (`op_rglId`) REFERENCES `modes_reglements` (`rgl_id`),
  ADD CONSTRAINT `operations_ibfk_1` FOREIGN KEY (`op_typeOpId`) REFERENCES `types_operations` (`typOp_id`);

--
-- Contraintes pour la table `operations_planifiees`
--
ALTER TABLE `operations_planifiees`
  ADD CONSTRAINT `operations_planifiees_ibfk_1` FOREIGN KEY (`opPlan_typPlnId`) REFERENCES `types_planifications` (`typPln_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
