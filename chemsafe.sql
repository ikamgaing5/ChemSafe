-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 22 mars 2025 à 12:56
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chemsafe`
--

-- --------------------------------------------------------

--
-- Structure de la table `atelier`
--

DROP TABLE IF EXISTS `atelier`;
CREATE TABLE IF NOT EXISTS `atelier` (
  `idatelier` smallint NOT NULL,
  `nomatelier` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`idatelier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `atelier`
--

INSERT INTO `atelier` (`idatelier`, `nomatelier`) VALUES
(1, 'BRASSAGE');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

DROP TABLE IF EXISTS `contenir`;
CREATE TABLE IF NOT EXISTS `contenir` (
  `idprod` bigint NOT NULL,
  `idatelier` smallint NOT NULL,
  PRIMARY KEY (`idprod`,`idatelier`),
  KEY `fk_contenir_atelier` (`idatelier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`idprod`, `idatelier`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `historique_acces`
--

DROP TABLE IF EXISTS `historique_acces`;
CREATE TABLE IF NOT EXISTS `historique_acces` (
  `id_acces` bigint NOT NULL,
  `iduser` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_acces`),
  KEY `fk_historique_acces_user` (`iduser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique_modif`
--

DROP TABLE IF EXISTS `historique_modif`;
CREATE TABLE IF NOT EXISTS `historique_modif` (
  `idmodif` bigint NOT NULL,
  `idprod` bigint NOT NULL,
  `iduser` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idmodif`),
  KEY `fk_historique_modif_produit` (`idprod`),
  KEY `fk_historique_modif_user` (`iduser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique_supp`
--

DROP TABLE IF EXISTS `historique_supp`;
CREATE TABLE IF NOT EXISTS `historique_supp` (
  `idsupp` bigint NOT NULL,
  `idatelier` smallint NOT NULL,
  `idprod` bigint NOT NULL,
  `iduser` int NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`idsupp`),
  KEY `fk_historique_supp_atelier` (`idatelier`),
  KEY `fk_historique_supp_produit` (`idprod`),
  KEY `fk_historique_supp_user` (`iduser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `infofds`
--

DROP TABLE IF EXISTS `infofds`;
CREATE TABLE IF NOT EXISTS `infofds` (
  `idinfo` bigint NOT NULL,
  `idprod` bigint NOT NULL,
  `physique` varchar(255) DEFAULT NULL,
  `sante` varchar(255) DEFAULT NULL,
  `ppt` varchar(255) DEFAULT NULL,
  `stabilite` varchar(255) DEFAULT NULL,
  `eviter` varchar(255) DEFAULT NULL,
  `incompatible` varchar(255) DEFAULT NULL,
  `reactivite` varchar(255) DEFAULT NULL,
  `stockage` varchar(255) DEFAULT NULL,
  `secours` varchar(255) DEFAULT NULL,
  `epi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idinfo`),
  KEY `fk_infofds_produit` (`idprod`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `idprod` bigint NOT NULL,
  `nomprod` varchar(255) NOT NULL,
  `type_emballage` varchar(128) DEFAULT NULL,
  `poids` varchar(128) DEFAULT NULL,
  `nature` varchar(128) DEFAULT NULL,
  `utilisation` varchar(128) DEFAULT NULL,
  `fabriquant` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `fds` varchar(255) DEFAULT NULL,
  `danger` varchar(255) DEFAULT NULL,
  `risque` varchar(2550) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`idprod`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`idprod`, `nomprod`, `type_emballage`, `poids`, `nature`, `utilisation`, `fabriquant`, `photo`, `fds`, `danger`, `risque`) VALUES
(1, 'xcxc', 'xcx', 'xcx', 'xcx', 'xcx', 'xcx', 'xcx', 'xcx', 'xcx', 'xcxc');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `iduser` int NOT NULL,
  `nomuser` varchar(128) DEFAULT NULL,
  `prenomuser` varchar(128) DEFAULT NULL,
  `mailuser` varchar(128) DEFAULT NULL,
  `mdp` varchar(128) DEFAULT NULL,
  `role` varchar(128) DEFAULT NULL,
  `supp` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`iduser`, `nomuser`, `prenomuser`, `mailuser`, `mdp`, `role`, `supp`) VALUES
(1, 'IVAN', 'VADES', 'ivankamgaing@gmail.com', 'aqzsedrf', 'admin', 'false');

-- --------------------------------------------------------

--
-- Structure de la table `utilise`
--

DROP TABLE IF EXISTS `utilise`;
CREATE TABLE IF NOT EXISTS `utilise` (
  `idprod` bigint NOT NULL,
  `idatelier` smallint NOT NULL,
  PRIMARY KEY (`idprod`,`idatelier`),
  KEY `fk_asso_1_atelier` (`idatelier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
