-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 22 mai 2025 à 22:10
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `esportify_db`
--
CREATE DATABASE IF NOT EXISTS `esportify_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `esportify_db`;

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE `equipe` (
  `idEquipe` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

DROP TABLE IF EXISTS `evenement`;
CREATE TABLE `evenement` (
  `idEvenement` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `visible` tinyint(1) DEFAULT 1,
  `id_organisateur` int(11) NOT NULL,
  `nb_joueurs_par_equipe` int(11) NOT NULL DEFAULT 2,
  `nb_equipes_max` int(11) NOT NULL DEFAULT 8,
  `est_commence` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `evenement`
--

INSERT INTO `evenement` (`idEvenement`, `titre`, `date_debut`, `date_fin`, `visible`, `id_organisateur`, `nb_joueurs_par_equipe`, `nb_equipes_max`, `est_commence`) VALUES
(1, 'Rocket League Challenge', '2025-05-22 22:00:00', '2025-05-23 12:00:00', 1, 2, 1, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `inscriptionequipe`
--

DROP TABLE IF EXISTS `inscriptionequipe`;
CREATE TABLE `inscriptionequipe` (
  `idInscriptionEquipe` int(11) NOT NULL,
  `id_evenement` int(11) NOT NULL,
  `id_equipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matchequipe`
--

DROP TABLE IF EXISTS `matchequipe`;
CREATE TABLE `matchequipe` (
  `idMatch` int(11) NOT NULL,
  `id_evenement` int(11) NOT NULL,
  `id_equipe1` int(11) NOT NULL,
  `id_equipe2` int(11) NOT NULL,
  `date_heure` datetime DEFAULT NULL,
  `score_equipe1` int(11) DEFAULT 0,
  `score_equipe2` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membreequipe`
--

DROP TABLE IF EXISTS `membreequipe`;
CREATE TABLE `membreequipe` (
  `idUtilisateur` int(11) NOT NULL,
  `idEquipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `idMessage` int(11) NOT NULL,
  `contenu` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_evenement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('joueur','organisateur','admin') NOT NULL,
  `est_valide` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `email`, `mot_de_passe`, `role`, `est_valide`) VALUES
(1, 'Admin', 'Administrateur@gmail.com', '$2y$12$xUXCoAO96x9SNHFq3YiBDezIVIEbDQiXk6XD2HUWVUXqTDdpNfv.a', 'admin', 1),
(2, 'Orga', 'Organisateur@gmail.com', '$2y$12$3UpKtvqQp.EVYVpnHs1tx.yr6yZi5jxwbQ/fXOuy5zk3LJ7i6uRnq', 'organisateur', 1),
(3, 'joueur1', 'JoueurTest@gmail.com', '$2y$12$7nFzUBvBsEnGJDR5zDqTCeKX9kFOzLwykD6ywwAVGt1WNMvLr0Smy', 'joueur', 1),
(4, 'Testjoueur2', 'Testjoueur2@gmail.com', '$2y$12$foAzBmvP1K8Cql/z8I6WCedghYw.NGd6VhrMhOcyeYVY8E9aGKwh6', 'joueur', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`idEquipe`),
  ADD UNIQUE KEY `unique_nom` (`nom`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`idEvenement`),
  ADD KEY `id_organisateur` (`id_organisateur`);

--
-- Index pour la table `inscriptionequipe`
--
ALTER TABLE `inscriptionequipe`
  ADD PRIMARY KEY (`idInscriptionEquipe`),
  ADD KEY `id_evenement` (`id_evenement`),
  ADD KEY `id_equipe` (`id_equipe`);

--
-- Index pour la table `matchequipe`
--
ALTER TABLE `matchequipe`
  ADD PRIMARY KEY (`idMatch`),
  ADD KEY `id_evenement` (`id_evenement`),
  ADD KEY `id_equipe1` (`id_equipe1`),
  ADD KEY `id_equipe2` (`id_equipe2`);

--
-- Index pour la table `membreequipe`
--
ALTER TABLE `membreequipe`
  ADD PRIMARY KEY (`idUtilisateur`,`idEquipe`),
  ADD KEY `idEquipe` (`idEquipe`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`idMessage`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_evenement` (`id_evenement`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `idEquipe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `idEvenement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `inscriptionequipe`
--
ALTER TABLE `inscriptionequipe`
  MODIFY `idInscriptionEquipe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `matchequipe`
--
ALTER TABLE `matchequipe`
  MODIFY `idMatch` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`id_organisateur`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inscriptionequipe`
--
ALTER TABLE `inscriptionequipe`
  ADD CONSTRAINT `inscriptionequipe_ibfk_1` FOREIGN KEY (`id_evenement`) REFERENCES `evenement` (`idEvenement`),
  ADD CONSTRAINT `inscriptionequipe_ibfk_2` FOREIGN KEY (`id_equipe`) REFERENCES `equipe` (`idEquipe`);

--
-- Contraintes pour la table `matchequipe`
--
ALTER TABLE `matchequipe`
  ADD CONSTRAINT `matchequipe_ibfk_1` FOREIGN KEY (`id_evenement`) REFERENCES `evenement` (`idEvenement`),
  ADD CONSTRAINT `matchequipe_ibfk_2` FOREIGN KEY (`id_equipe1`) REFERENCES `equipe` (`idEquipe`),
  ADD CONSTRAINT `matchequipe_ibfk_3` FOREIGN KEY (`id_equipe2`) REFERENCES `equipe` (`idEquipe`);

--
-- Contraintes pour la table `membreequipe`
--
ALTER TABLE `membreequipe`
  ADD CONSTRAINT `membreequipe_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `membreequipe_ibfk_2` FOREIGN KEY (`idEquipe`) REFERENCES `equipe` (`idEquipe`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`id_evenement`) REFERENCES `evenement` (`idEvenement`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
