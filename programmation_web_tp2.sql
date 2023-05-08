-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 08 mai 2023 à 23:05
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `programmation_web_tp2`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `telephone` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `nom`, `adress`, `telephone`, `email`, `password`) VALUES
(1, 'Amendis', 'HMQ6+MWF, Tétouan', 5397987, 'amendis@tetouan.com', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'Amendis 2', 'HMQ6+MWF, Tanger', 5897878, 'amendis@tanger.com', '21232f297a57a5a743894a0e4a801fc3'),
(3, 'Amendis 3', 'HMQ7+MWF, Al Hoceïma\r\nAl Hoceïma', 54776487, 'amendis@alhoceima.com', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

CREATE TABLE `agent` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `telephone` int(11) DEFAULT NULL,
  `nom_zone_geographique_geree` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`id`, `nom`, `prenom`, `email`, `adress`, `telephone`, `nom_zone_geographique_geree`, `password`) VALUES
(1, 'agent1', 'agent1', 'agent1@gmail.com', '2 AV Mohammadia ET .5 AP 11 BLOC C 93000 TETOUAN', 578453218, 'AV Mohammadia', 'b33aed8f3134996703dc39f9a7c95783'),
(2, 'agent2', 'agent2', 'agent2@gmail.com', '8 AV CASABLANCA ET .7 AP 11 BLOC D 93000 TETOUAN', 512875321, 'AV CASABLANCA', 'b33aed8f3134996703dc39f9a7c95783'),
(3, 'agent3', 'agent3', 'agent3@gmail.com', '4 AV Mhannech 2  ET .5 AP 11 93000 TETOUAN', 2147483647, 'AV Mhannech', 'b33aed8f3134996703dc39f9a7c95783'),
(4, 'agent4', 'agent4', 'agent4@gmail.com', '3 AV FAR Res Al Ouma BLOC C N 12', 588665432, 'AV FAR', 'b33aed8f3134996703dc39f9a7c95783');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `telephone` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `id_agent` int(11) DEFAULT NULL,
  `nom_zone_geographique` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `email`, `adress`, `telephone`, `password`, `id_admin`, `id_agent`, `nom_zone_geographique`) VALUES
(1, 'zaidi', 'mouad', 'mouadzaidi@gmail.com', '7 AV Mohammadia ET .5 AP 17 BLOC C 93000 TETOUAN', 2147483647, '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 'AV Mohammadia'),
(2, 'test', 'saad', 'saad@test.com', '5 AV Mohammadia Res Al Test BLOC D N 8', 2147483647, '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 'AV Mohammadia'),
(3, 'ali', 'test', 'ali@test.com', '17 AV Mohammadia Res Al Ouma BLOC A N 5', 675765765, '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 'AV Mohammadia'),
(4, 'mohamed', 'test', 'mohamedtest@gmail.com', '39 AV CASABLANCA Res Al Test BLOC H N 18', 76765657, '827ccb0eea8a706c4c34a16891f84e7b', 1, 2, 'AV CASABLANCA'),
(5, 'anas', 'mouad', 'anas@test.com', '39 AV CASABLANCA Res Al Test BLOC H N 18', 897897987, '827ccb0eea8a706c4c34a16891f84e7b', 1, 2, 'AV CASABLANCA'),
(6, 'issam', 'test', 'issam@test.com', '29 AV Mhannech Res Al Test BLOC H N 18', 786786786, '827ccb0eea8a706c4c34a16891f84e7b', 2, 3, 'AV Mhannech'),
(7, 'taha', 'test', 'taha@test.com', '19 AV Mhannech Res Al Test BLOC H N 16', 78686786, '827ccb0eea8a706c4c34a16891f84e7b', 2, 3, 'AV Mhannech'),
(8, 'ahmed', 'test', 'ahmed@test.com', '12 AV FAR ET .1 AP 9 BLOC D 93000 TETOUAN', 897897967, '827ccb0eea8a706c4c34a16891f84e7b', 3, 4, 'AV FAR'),
(9, 'ayman', 'saad', 'ayman@test.com', '39 AV FAR Res Al Test BLOC H N 18', 2147483647, '827ccb0eea8a706c4c34a16891f84e7b', 3, 4, 'AV FAR');

-- --------------------------------------------------------

--
-- Structure de la table `consommation_annuelle`
--

CREATE TABLE `consommation_annuelle` (
  `id` int(11) NOT NULL,
  `consommation_annuelle` int(11) DEFAULT NULL,
  `date_saisie` timestamp NULL DEFAULT current_timestamp(),
  `annee` int(11) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `id_agent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `consommation_annuelle`
--

INSERT INTO `consommation_annuelle` (`id`, `consommation_annuelle`, `date_saisie`, `annee`, `id_client`, `id_admin`, `id_agent`) VALUES
(1, 5478, '2023-03-09 23:26:08', 2022, 1, 1, 1),
(2, 4976, '2023-03-09 23:26:08', 2022, 2, 1, 1),
(3, 4427, '2023-03-09 23:26:08', 2022, 3, 1, 1),
(4, 4563, '2023-03-09 23:27:05', 2022, 4, 1, 2),
(5, 3989, '2023-03-09 23:27:05', 2022, 5, 1, 2),
(6, 5654, '2023-03-09 23:27:35', 2022, 6, 2, 3),
(7, 4578, '2023-03-09 23:27:35', 2022, 7, 2, 3),
(8, 5677, '2023-03-09 23:28:02', 2022, 8, 3, 4),
(9, 4989, '2023-03-09 23:28:02', 2022, 9, 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `id` int(11) NOT NULL,
  `HT` decimal(10,2) DEFAULT NULL,
  `TTC` decimal(10,2) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `mois` int(11) NOT NULL,
  `consommation` decimal(10,2) DEFAULT NULL,
  `date_saisie` timestamp NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `statut_de_payment` enum('payee','non payee') DEFAULT 'non payee',
  `id_client` int(11) DEFAULT NULL,
  `statut_de_validation` enum('valide','non valide') DEFAULT 'non valide'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`id`, `HT`, `TTC`, `annee`, `mois`, `consommation`, `date_saisie`, `image`, `statut_de_payment`, `id_client`, `statut_de_validation`) VALUES
(1, '322.23', '355.90', 2022, 12, '5300.00', '2023-03-09 23:40:39', 'compt1.jpg', 'payee', 1, 'valide'),
(2, '222.03', '255.20', 2022, 12, '4976.00', '2023-03-09 23:40:39', 'compt1.jpg', 'payee', 2, 'valide'),
(3, '422.53', '435.45', 2022, 12, '4357.00', '2023-03-09 23:40:39', 'compt1.jpg', 'payee', 3, 'valide'),
(4, '122.22', '195.70', 2022, 12, '4796.00', '2023-03-09 23:40:39', 'compt1.jpg', 'payee', 4, 'valide'),
(5, '262.93', '295.50', 2022, 12, '4017.00', '2023-03-09 23:40:39', 'compt1.jpg', 'payee', 5, 'valide'),
(6, '122.13', '145.90', 2022, 12, '5887.00', '2023-03-09 23:40:39', 'compt1.jpg', 'payee', 6, 'valide'),
(7, '392.23', '405.20', 2022, 12, '4673.00', '2023-03-09 23:40:39', 'compt1.jpg', 'payee', 7, 'valide'),
(8, '272.23', '308.90', 2022, 12, '5609.00', '2023-03-09 23:40:39', 'compt1.jpg', 'payee', 8, 'valide'),
(9, '312.83', '385.90', 2022, 12, '4950.00', '2023-03-09 23:40:39', 'compt1.jpg', 'payee', 9, 'valide'),
(10, '397.60', '453.26', 2023, 1, '177.00', '2023-03-09 23:46:42', 'compt2.jpg', 'payee', 1, 'valide'),
(11, '290.08', '330.69', 2023, 2, '436.00', '2023-03-09 23:48:53', 'compt1.jpg', 'payee', 1, 'valide'),
(12, '396.48', '451.99', 2023, 1, '354.00', '2023-03-09 23:51:27', 'compt2.jpg', 'payee', 3, 'valide'),
(13, '504.00', '574.56', 2023, 2, '804.00', '2023-03-09 23:54:27', 'compt2.jpg', 'non payee', 3, 'valide'),
(14, '153.52', '175.01', 2023, 1, '385.00', '2023-03-10 09:59:02', 'compt2.jpg', 'payee', 4, 'valide'),
(15, '285.60', '325.58', 2023, 2, '640.00', '2023-03-10 10:00:02', 'compt1.jpg', 'non payee', 4, 'valide');

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `id` int(11) NOT NULL,
  `message` longtext DEFAULT NULL,
  `date` date DEFAULT current_timestamp(),
  `reponse` varchar(255) DEFAULT NULL,
  `statut` enum('repondee','non repondee') DEFAULT 'non repondee',
  `id_client` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `Type` enum('Fuite externe','Fuite interne','Facture','Autre') NOT NULL,
  `Autre_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reclamation`
--

INSERT INTO `reclamation` (`id`, `message`, `date`, `reponse`, `statut`, `id_client`, `id_admin`, `Type`, `Autre_type`) VALUES
(1, 'Test Reclamatoion', '2023-03-10', 'test reponse', 'repondee', 1, 1, 'Autre', 'Prix'),
(2, 'test', '2023-03-10', 'simple reponse', 'repondee', 7, 2, 'Fuite interne', ''),
(3, 'client test', '2023-03-10', 'ok', 'repondee', 7, 2, 'Facture', ''),
(4, 'test facture reclamation', '2023-03-10', 'ok reponse', 'repondee', 1, 1, 'Facture', ''),

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Index pour la table `consommation_annuelle`
--
ALTER TABLE `consommation_annuelle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_admin` (`id_admin`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `agent`
--
ALTER TABLE `agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `consommation_annuelle`
--
ALTER TABLE `consommation_annuelle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `client_ibfk_2` FOREIGN KEY (`id_agent`) REFERENCES `agent` (`id`);

--
-- Contraintes pour la table `consommation_annuelle`
--
ALTER TABLE `consommation_annuelle`
  ADD CONSTRAINT `consommation_annuelle_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `consommation_annuelle_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `consommation_annuelle_ibfk_3` FOREIGN KEY (`id_agent`) REFERENCES `agent` (`id`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `reclamation_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `reclamation_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
