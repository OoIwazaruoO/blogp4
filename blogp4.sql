-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 20 mai 2020 à 12:34
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
(1, 'new post', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab voluptatem adipisci ullam, sit quibusdam voluptatum delectus veritatis autem nihil. Totam libero ut accusamus soluta in accusantium iusto cum harum voluptatibus! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis quas sequi accusantium voluptatibus alias id, unde numquam voluptatem deleniti ipsa placeat, nam, molestias. Non, quisquam, nulla. Quidem accusantium quod eos. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt accusantium soluta sed perferendis neque fuga eum enim nostrum odit, placeat labore, pariatur, aperiam. Hic autem explicabo tenetur, ratione sed libero!\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:05', '2020-05-15 18:42:05', 'draft', 0, 'wolf.jpg', 1),
(2, 'new post', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab voluptatem adipisci ullam, sit quibusdam voluptatum delectus veritatis autem nihil. Totam libero ut accusamus soluta in accusantium iusto cum harum voluptatibus! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis quas sequi accusantium voluptatibus alias id, unde numquam voluptatem deleniti ipsa placeat, nam, molestias. Non, quisquam, nulla. Quidem accusantium quod eos. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt accusantium soluta sed perferendis neque fuga eum enim nostrum odit, placeat labore, pariatur, aperiam. Hic autem explicabo tenetur, ratione sed libero!\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:05', '2020-05-15 18:42:05', 'draft', 0, 'wolf.jpg', 1),
(3, 'new post', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab voluptatem adipisci ullam, sit quibusdam voluptatum delectus veritatis autem nihil. Totam libero ut accusamus soluta in accusantium iusto cum harum voluptatibus! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis quas sequi accusantium voluptatibus alias id, unde numquam voluptatem deleniti ipsa placeat, nam, molestias. Non, quisquam, nulla. Quidem accusantium quod eos. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt accusantium soluta sed perferendis neque fuga eum enim nostrum odit, placeat labore, pariatur, aperiam. Hic autem explicabo tenetur, ratione sed libero!\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:15', '2020-05-15 18:42:15', 'draft', 0, 'wolf.jpg', 1),
(4, 'new post', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab voluptatem adipisci ullam, sit quibusdam voluptatum delectus veritatis autem nihil. Totam libero ut accusamus soluta in accusantium iusto cum harum voluptatibus! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis quas sequi accusantium voluptatibus alias id, unde numquam voluptatem deleniti ipsa placeat, nam, molestias. Non, quisquam, nulla. Quidem accusantium quod eos. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt accusantium soluta sed perferendis neque fuga eum enim nostrum odit, placeat labore, pariatur, aperiam. Hic autem explicabo tenetur, ratione sed libero!\r\nddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd  ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd ddezddzad azd azd zad azd azd', '2020-05-15 18:42:15', '2020-05-15 18:42:15', 'draft', 0, 'wolf.jpg', 1),
(5, 'new post', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab voluptatem adipisci ullam, sit quibusdam voluptatum delectus veritatis autem nihil. Totam libero ut accusamus soluta in accusantium iusto cum harum voluptatibus! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis quas sequi accusantium voluptatibus alias id, unde numquam voluptatem deleniti ipsa placeat, nam, molestias. Non, quisquam, nulla. Quidem accusantium quod eos. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt accusantium soluta sed perferendis neque fuga eum enim nostrum odit, placeat labore, pariatur, aperiam. Hic autem explicabo tenetur, ratione sed libero!', '2020-05-15 18:42:24', '2020-05-15 18:42:24', 'published', 0, 'wolf.jpg', 1),
(6, 'new post', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab voluptatem adipisci ullam, sit quibusdam voluptatum delectus veritatis autem nihil. Totam libero ut accusamus soluta in accusantium iusto cum harum voluptatibus! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis quas sequi accusantium voluptatibus alias id, unde numquam voluptatem deleniti ipsa placeat, nam, molestias. Non, quisquam, nulla. Quidem accusantium quod eos. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt accusantium soluta sed perferendis neque fuga eum enim nostrum odit, placeat labore, pariatur, aperiam. Hic autem explicabo tenetur, ratione sed libero!', '2020-05-15 18:42:24', '2020-05-15 18:42:24', 'published', 0, 'wolf.jpg', 1),
(7, 'new post', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab voluptatem adipisci ullam, sit quibusdam voluptatum delectus veritatis autem nihil. Totam libero ut accusamus soluta in accusantium iusto cum harum voluptatibus! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis quas sequi accusantium voluptatibus alias id, unde numquam voluptatem deleniti ipsa placeat, nam, molestias. Non, quisquam, nulla. Quidem accusantium quod eos. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt accusantium soluta sed perferendis neque fuga eum enim nostrum odit, placeat labore, pariatur, aperiam. Hic autem explicabo tenetur, ratione sed libero!', '2020-05-15 18:42:36', '2020-05-15 18:42:36', 'published', 0, 'wolf.jpg', 1),
(8, 'new post', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab voluptatem adipisci ullam, sit quibusdam voluptatum delectus veritatis autem nihil. Totam libero ut accusamus soluta in accusantium iusto cum harum voluptatibus! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis quas sequi accusantium voluptatibus alias id, unde numquam voluptatem deleniti ipsa placeat, nam, molestias. Non, quisquam, nulla. Quidem accusantium quod eos. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt accusantium soluta sed perferendis neque fuga eum enim nostrum odit, placeat labore, pariatur, aperiam. Hic autem explicabo tenetur, ratione sed libero!', '2020-05-15 18:42:36', '2020-05-15 18:42:36', 'published', 0, 'wolf.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `inscriptionDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmationToken` varchar(255) NOT NULL,
  `confirmationDate` datetime DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
