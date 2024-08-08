-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 12 juil. 2024 à 12:23
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `systeme_vh`
--

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `CODE_CL` varchar(10) NOT NULL,
  `LIBELLE` varchar(255) DEFAULT NULL,
  `niveau` int DEFAULT NULL,
  `CODE_FIL` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`CODE_CL`),
  KEY `CODE_FIL` (`CODE_FIL`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
  `code_depart` int NOT NULL AUTO_INCREMENT,
  `nom_depart` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`code_depart`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`code_depart`, `nom_depart`) VALUES
(1, 'Informatique'),
(2, 'biologie');

-- --------------------------------------------------------

--
-- Structure de la table `dispense`
--

DROP TABLE IF EXISTS `dispense`;
CREATE TABLE IF NOT EXISTS `dispense` (
  `MATRICULE` varchar(10) NOT NULL,
  `CODE_UE` varchar(10) NOT NULL,
  `CODE_CL` varchar(10) NOT NULL,
  `HEURE_DEBUT` time DEFAULT NULL,
  `HEURE_FIN` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `statut` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`MATRICULE`,`CODE_UE`,`CODE_CL`),
  KEY `CODE_UE` (`CODE_UE`),
  KEY `CODE_CL` (`CODE_CL`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

DROP TABLE IF EXISTS `enseignant`;
CREATE TABLE IF NOT EXISTS `enseignant` (
  `MATRICULE` varchar(10) NOT NULL,
  `nom_ensg` varchar(255) DEFAULT NULL,
  `date_naiss` date DEFAULT NULL,
  `sexe` char(1) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `diplome` varchar(255) DEFAULT NULL,
  `CODE_DEPART` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`MATRICULE`),
  KEY `CODE_DEPART` (`CODE_DEPART`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

DROP TABLE IF EXISTS `filiere`;
CREATE TABLE IF NOT EXISTS `filiere` (
  `CODE_FIL` varchar(10) NOT NULL,
  `nom_fil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CODE_FIL`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `ID_PROFIL` int NOT NULL AUTO_INCREMENT,
  `ID_IDENTIFIANT` int NOT NULL,
  `num_tel` int DEFAULT NULL,
  `genre` char(10) DEFAULT NULL,
  `photo_profil` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`ID_PROFIL`),
  KEY `ID_IDENTIFIANT` (`ID_IDENTIFIANT`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `securite`
--

DROP TABLE IF EXISTS `securite`;
CREATE TABLE IF NOT EXISTS `securite` (
  `ID_SECURITE` int NOT NULL AUTO_INCREMENT,
  `ID_IDENTIFIANT` int NOT NULL,
  `dern_connex` date DEFAULT NULL,
  `nbre_tenta` int DEFAULT NULL,
  `quest_securite` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`ID_SECURITE`),
  KEY `ID_IDENTIFIANT` (`ID_IDENTIFIANT`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `securite`
--

INSERT INTO `securite` (`ID_SECURITE`, `ID_IDENTIFIANT`, `dern_connex`, `nbre_tenta`, `quest_securite`) VALUES
(5, 7, NULL, NULL, 'Animal préféré: chien; Ami d\'enfance: jonas; Pays préféré: cameroun'),
(4, 6, NULL, NULL, 'Animal préféré: chien; Ami d\'enfance: jonas; Pays préféré: cameroun'),
(6, 8, NULL, NULL, 'Animal préféré: chat; Ami d\'enfance: alex; Pays préféré: canada');

-- --------------------------------------------------------

--
-- Structure de la table `semestre`
--

DROP TABLE IF EXISTS `semestre`;
CREATE TABLE IF NOT EXISTS `semestre` (
  `NSEMESTRE` int NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  PRIMARY KEY (`NSEMESTRE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ue`
--

DROP TABLE IF EXISTS `ue`;
CREATE TABLE IF NOT EXISTS `ue` (
  `CODE_UE` varchar(10) NOT NULL,
  `nom_ue` varchar(50) DEFAULT NULL,
  `vh` int DEFAULT NULL,
  `statut` tinyint(1) DEFAULT NULL,
  `CODE_DEPART` varchar(10) DEFAULT NULL,
  `NSEMESTRE` int DEFAULT NULL,
  PRIMARY KEY (`CODE_UE`),
  KEY `CODE_DEPART` (`CODE_DEPART`),
  KEY `NSEMESTRE` (`NSEMESTRE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `ID_IDENTIFIANT` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(1024) DEFAULT NULL,
  `date_creation_compte` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `statut_compte` tinyint(1) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_IDENTIFIANT`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID_IDENTIFIANT`, `nom`, `prenom`, `email`, `mot_de_passe`, `date_creation_compte`, `statut_compte`, `role`, `token`) VALUES
(6, 'kamwa tachim', 'jonas', 'jonastachim0@gmail.com', '$2y$10$LuCGcTosF2Y0GjtrRsPAhO4ZOboR7txLStTueU2Z8YdKDU3lZSk4y', '2024-07-11 20:33:00', 1, 'utilisateur', NULL),
(7, 'kwinou', 'romane', 'romanekwinou04@gmail.com', '$2y$10$iy05zauKhS6ag8M4kzQPWu7LE0LVXLz75qquOFBlnqKh33mRTxaOC', '2024-07-12 06:11:11', 1, 'utilisateur', NULL),
(8, 'Nonga', 'felix', 'nongafelix@gmail.com', '$2y$10$E/J4U8GekTeQsqArRcnPUO.Cm./FmimZqaggXMezqT9n6BI0w9jTG', '2024-07-12 12:15:12', 1, 'utilisateur', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
