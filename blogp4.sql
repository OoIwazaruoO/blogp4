-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 16 mai 2020 à 13:15
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blogp4`
--

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` enum('published','draft') NOT NULL DEFAULT 'draft',
  `viewsNumber` int(11) NOT NULL DEFAULT '0',
  `pictureName` varchar(60) NOT NULL,
  `chapterNumber` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `creationDate`, `updateDate`, `type`, `viewsNumber`, `pictureName`, `chapterNumber`) VALUES
(1, 'new post', 'ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd\r\n\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:05', '2020-05-15 18:42:05', 'draft', 0, 'wolf.jpg', 1),
(2, 'new post', 'ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd\r\n\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:05', '2020-05-15 18:42:05', 'draft', 0, 'wolf.jpg', 1),
(3, 'new post', 'ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd\r\n\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:15', '2020-05-15 18:42:15', 'draft', 0, 'wolf.jpg', 1),
(4, 'new post', 'ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd\r\n\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:15', '2020-05-15 18:42:15', 'draft', 0, 'wolf.jpg', 1),
(5, 'new post', 'ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd\r\n\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:24', '2020-05-15 18:42:24', 'draft', 0, 'wolf.jpg', 1),
(6, 'new post', 'ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd\r\n\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:24', '2020-05-15 18:42:24', 'draft', 0, 'wolf.jpg', 1),
(7, 'new post', 'ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd\r\n\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:36', '2020-05-15 18:42:36', 'draft', 0, 'wolf.jpg', 1),
(8, 'new post', 'ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd\r\n\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:36', '2020-05-15 18:42:36', 'draft', 0, 'wolf.jpg', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
