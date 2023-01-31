-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 31 jan. 2023 à 19:10
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog_opcr`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `content` text NOT NULL,
  `isValid` tinyint(1) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`userId`),
  KEY `post_id` (`postId`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `postId`, `userId`, `content`, `isValid`, `createdAt`, `updatedAt`) VALUES
(1, 1, 1, 'Premier commentaire\r\n\r\nPremier commentaire', 1, '2022-11-02 11:41:28', '2022-11-02 11:41:28'),
(2, 16, 1, 'Premier comment en dur', 1, '2022-11-12 09:12:46', '2022-11-12 09:12:46'),
(3, 1, 1, 'Un commentaire intéressant', 1, '2022-11-12 12:53:10', '2022-11-12 12:53:10'),
(5, 25, 1, 'C\'est pas mal du tout !', 1, '2022-12-16 11:40:03', '2022-12-16 11:40:03'),
(6, 25, 8, 'Je suis Lola, on je ne suis plus valide', 0, '2022-12-19 11:04:22', '2022-12-19 11:04:22'),
(7, 25, 8, 'Encore Lola !!!', 1, '2022-12-19 11:05:42', '2022-12-19 11:05:42'),
(8, 23, 8, 'Test', 0, '2022-12-19 11:10:23', '2022-12-19 11:10:23'),
(9, 23, 1, 'Valider !', 1, '2022-12-20 10:13:38', '2022-12-20 10:13:38'),
(11, 25, 1, 'Encore test', 1, '2022-12-20 10:28:24', '2022-12-20 10:28:24'),
(12, 25, 1, 'Pas validé, puis oui', 1, '2022-12-20 10:32:50', '2022-12-20 10:32:50'),
(16, 23, 8, 'Refactoring !', 0, '2022-12-21 10:14:39', '2022-12-21 10:14:39'),
(17, 26, 1, 'Mon comment', 1, '2023-01-06 12:09:48', '2023-01-06 12:09:48'),
(18, 27, 10, 'Commentaire de Mariam', 1, '2023-01-13 08:53:04', '2023-01-13 08:53:04'),
(19, 27, 1, 'Mon commentaire test !', 1, '2023-01-13 09:05:34', '2023-01-13 09:05:34'),
(20, 29, 1, 'Admin comment', 1, '2023-01-15 03:20:11', '2023-01-15 03:20:11'),
(21, 13, 1, 'Un petit commentaire de l\'admin', 1, '2023-01-28 08:13:53', '2023-01-28 08:13:53');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `label` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `isAnswered` tinyint(1) NOT NULL,
  `answeredAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `firstname`, `lastname`, `email`, `label`, `message`, `createdAt`, `isAnswered`, `answeredAt`) VALUES
(1, 'Ambrose', 'Sara', 'uizji@free.com', 'information', 'My message test', '2022-10-21 00:00:00', 1, '2022-11-08 18:12:45'),
(2, 'Ambrose', 'Sara', 'uizji@free.com', 'information', 'My second message', '2022-10-21 00:00:00', 0, '2022-12-14 13:26:59'),
(4, 'Monki', 'Pasmal', 'bdgfyed@sfr.com', 'information', 'Mon super message', '2022-10-21 01:50:47', 1, '2022-11-21 13:13:20'),
(5, 'Jeffrey', 'Kekbel', 'kekbel@gmail.com', 'information', 'Demande d\'information', '2022-11-01 03:38:22', 0, '2022-12-22 11:39:14'),
(6, 'Axel', 'Matio', 'labrosse@gmail.com', 'information', 'Un nouveau message', '2022-11-01 05:02:33', 0, '2022-12-22 00:00:00'),
(7, 'Noa', 'Now', 'now@free.com', 'information', 'Je contacte maintenant par message', '2022-11-01 05:03:07', 1, '2022-12-23 11:39:40'),
(9, 'Valérie', 'Roman', 'roman@gmail.com', 'question', 'Un message, une question ?', '2022-11-02 08:37:59', 0, '2022-12-23 00:00:00'),
(10, 'Miquel', 'Ivank', 'monique@gmail.com', 'question', 'Je peux poser une question ?', '2022-11-02 08:40:18', 0, '2022-12-23 11:39:40'),
(11, 'Lucas', 'Fanon', 'fanon@jbfjs.co', 'information', 'Je voudrais avoir quelques informations.', '2022-11-02 08:40:58', 1, '2022-12-25 11:39:40'),
(12, 'Valérie', 'Roman', 'roman@gmail.com', 'information', 'Je ne suis pas user', '2022-12-26 04:48:50', 0, '2022-12-26 11:39:40'),
(13, 'Lola', 'Andypola', 'lola@hotmail.com', 'information', 'Je suis connectée', '2022-12-26 04:49:56', 0, '2022-12-28 10:29:40'),
(14, 'Valérie', 'Roman', 'roman@gmail.com', 'information', 'Je ne suis pas connecté', '2022-12-26 04:52:59', 0, '2022-12-30 11:11:20'),
(15, 'Lola', 'Andypola', 'lola@hotmail.com', 'information', 'Encore moi et connectée !', '2022-12-26 05:14:58', 0, '2023-01-10 09:09:13'),
(16, 'Lola', 'Andypola', 'lola@hotmail.com', 'information', 'Un petit test', '2022-12-26 05:16:38', 0, '2023-01-11 09:09:13'),
(17, 'Valérie', 'Roman', 'roman@gmail.com', 'information', 'Message test', '2022-12-26 06:08:30', 1, '2023-01-12 15:36:29'),
(18, 'Valérie', 'Roman', 'roman@gmail.com', 'question', 'Je ne suis pas connecté', '2022-12-26 06:11:32', 0, '2023-01-13 09:09:13'),
(19, 'Adminy', 'Level', 'kadance@hotmail.com', 'information', 'Vérification par moi même', '2022-12-27 12:28:08', 0, '2023-01-13 12:43:22'),
(20, 'Adminy', 'Level', 'kadance@hotmail.com', 'question', 'Ma demande d\'information après changement de contact id !', '2023-01-13 09:09:13', 0, '2023-01-13 09:09:13'),
(21, 'Adminy', 'Level', 'kadance@hotmail.com', 'information', 'Je test', '2023-01-29 10:38:26', 0, '2023-01-29 10:38:26');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `isPublished` tinyint(1) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `userId`, `title`, `slug`, `image`, `content`, `isPublished`, `createdAt`, `updatedAt`) VALUES
(1, 1, 'Mon premier article titre', 'Mon premier article slug', '', 'Mon premier article description\r\n\r\nMon premier article description\r\n\r\nMon premier article description\r\n\r\nMon premier article description', 1, '2022-09-23 06:03:07', '2022-09-23 06:03:07'),
(2, 1, 'Mon second article titre', 'Mon second article slug', '', 'Mon second article description\r\n\r\nMon second article description\r\n\r\nMon second article description\r\n\r\nMon second article description', 1, '2022-09-25 06:03:07', '2022-09-25 06:03:07'),
(3, 1, 'Mon troisième article titre', 'Mon troisième article slug', '', 'Mon troisième article description\r\n\r\nMon troisième article description\r\n\r\nMon troisième article description\r\n\r\nMon troisième article description', 1, '2022-09-28 06:03:07', '2022-09-28 06:03:07'),
(5, 1, 'Mon second article par formulaire', 'Mon second slug par formulaire', '', 'Mon second contenu par formulaire.\r\nMon second article par formulaire.', 1, '2022-10-21 04:34:56', '2022-10-21 04:34:56'),
(8, 1, 'Mon quatrième article', 'Article 4', '', 'Nouvel article quatre modifié le 06 Janvier 2023', 1, '2022-11-02 07:25:45', '2023-01-06 10:58:44'),
(9, 1, 'Mon cinquième article', 'Cinquième', '', 'Nec piget dicere avide magis hanc insulam populum Romanum invasisse quam iuste. Ptolomaeo enim rege foederato nobis et socio ob aerarii nostri angustias iusso sine ulla culpa proscribi ideoque hausto veneno voluntaria morte deleto et tributaria facta est et velut hostiles eius exuviae classi inpositae in urbem advectae sunt per Catonem, nunc repetetur ordo gestorum.', 1, '2022-11-02 07:27:26', '2023-01-28 08:08:13'),
(12, 1, 'Un bon article', 'Article slug', NULL, 'Paphius quin etiam et Cornelius senatores, ambo venenorum artibus pravis se polluisse confessi, eodem pronuntiante Maximino sunt interfecti. pari sorte etiam procurator monetae extinctus est. Sericum enim et Asbolium supra dictos, quoniam cum hortaretur passim nominare, quos vellent, adiecta religione firmarat, nullum igni vel ferro se puniri iussurum, plumbi validis ictibus interemit. et post hoe flammis Campensem aruspicem dedit, in negotio eius nullo sacramento constrictus.', 0, '2022-11-02 12:11:47', '2022-11-02 12:11:47'),
(13, 1, 'Un sixième article', 'Sixième dans la gamme', '', 'Mon article, histoire de test !', 0, '2022-11-02 12:30:29', '2023-01-28 08:30:43'),
(15, 1, 'Sétième art', 'Article test', NULL, 'Nec piget dicere avide magis hanc insulam populum Romanum invasisse quam iuste. Ptolomaeo enim rege foederato nobis et socio ob aerarii nostri angustias iusso sine ulla culpa proscribi ideoque hausto veneno voluntaria morte deleto et tributaria facta est et velut hostiles eius exuviae classi inpositae in urbem advectae sunt per Catonem, nunc repetetur ordo gestorum.', 0, '2022-11-02 12:41:01', '2022-11-02 12:41:01'),
(16, 1, 'Un nouveau test', 'Dragon', '', 'Sed ut tum ad senem senex de senectute, sic hoc libro ad amicum amicissimus scripsi de amicitia. Tum est Cato locutus, quo erat nemo fere senior temporibus illis, nemo prudentior; nunc Laelius et sapiens (sic enim est habitus) et amicitiae gloria excellens de amicitia loquetur. Tu velim a me animum parumper avertas, Laelium loqui ipsum putes. C. Fannius et Q. Mucius ad socerum veniunt post mortem Africani; ab his sermo oritur, respondet Laelius, cuius tota disputatio est de amicitia, quam legens te ipse cognosces.', 1, '2022-11-12 08:40:55', '2023-01-28 08:10:14'),
(17, 1, 'Les petites difficultés', 'Comment gérer les conditions', NULL, 'Nec piget dicere avide magis hanc insulam populum Romanum invasisse quam iuste. Ptolomaeo enim rege foederato nobis et socio ob aerarii nostri angustias iusso sine ulla culpa proscribi ideoque hausto veneno voluntaria morte deleto et tributaria facta est et velut hostiles eius exuviae classi inpositae in urbem advectae sunt per Catonem, nunc repetetur ordo gestorum.', 0, '2022-11-12 08:12:16', '2022-11-12 08:12:16'),
(18, 1, 'Changer le titre', 'Un nouveau titre', '63d4d8bd25463.jpg', 'Paphius quin etiam et Cornelius senatores, ambo venenorum artibus pravis se polluisse confessi, eodem pronuntiante Maximino sunt interfecti. pari sorte etiam procurator monetae extinctus est. Sericum enim et Asbolium supra dictos, quoniam cum hortaretur passim nominare, quos vellent, adiecta religione firmarat, nullum igni vel ferro se puniri iussurum, plumbi validis ictibus interemit. et post hoe flammis Campensem aruspicem dedit, in negotio eius nullo sacramento constrictus.', 1, '2022-11-13 10:03:42', '2023-01-28 08:11:41'),
(22, 1, 'Un nouvel article', 'Mon nouvel article avec image', '6370e06747fbf.jpg', 'Nec piget dicere avide magis hanc insulam populum Romanum invasisse quam iuste. Ptolomaeo enim rege foederato nobis et socio ob aerarii nostri angustias iusso sine ulla culpa proscribi ideoque hausto veneno voluntaria morte deleto et tributaria facta est et velut hostiles eius exuviae classi inpositae in urbem advectae sunt per Catonem, nunc repetetur ordo gestorum.', 1, '2022-11-13 12:17:43', '2022-11-13 12:17:43'),
(23, 1, 'Je suis à nouveau oui', 'encore un article', '638cbfcaad9b7.jpg', 'Mon contenu d\'aujourd\'hui', 1, '2022-12-02 09:26:07', '2022-12-04 03:42:02'),
(24, 1, 'Le développement', 'Dans quelques années', NULL, 'Un peu de contenu pour un article test.', 0, '2022-12-02 01:57:42', '2022-12-02 01:57:42'),
(25, 1, 'Je viens d\'être modifié', 'New ajout', '639c4d9239926.jpg', 'Paphius quin etiam et Cornelius senatores, ambo venenorum artibus pravis se polluisse confessi, eodem pronuntiante Maximino sunt interfecti. pari sorte etiam procurator monetae extinctus est. Sericum enim et Asbolium supra dictos, quoniam cum hortaretur passim nominare, quos vellent, adiecta religione firmarat, nullum igni vel ferro se puniri iussurum, plumbi validis ictibus interemit. et post hoe flammis Campensem aruspicem dedit, in negotio eius nullo sacramento constrictus.', 1, '2022-12-09 11:43:13', '2022-12-16 10:50:58'),
(26, 1, 'Aujourd\'hui Vendredi 06', 'Bonne année', '63aaddab432ed.jpg', 'C\'est une nouvelle année et hop un nouvel article.', 1, '2022-12-27 11:57:31', '2023-01-06 10:44:14'),
(27, 1, 'Article render', 'Render', '63b82bee5c647.jpg', 'Article article render', 1, '2023-01-06 02:10:54', '2023-01-06 02:10:54'),
(28, 1, 'Dimanche 15 Janvier', 'Mon article du dimanche 15 Janvier', '63b82bee5c647.jpg', 'Un nouvel article test sans photo !', 1, '2023-01-15 02:58:46', '2023-01-15 02:58:46'),
(29, 1, 'Second article du 15 modifié', 'Encore un test', '', 'Mon test sans photo !', 1, '2023-01-15 03:04:40', '2023-01-15 03:20:35');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `isAdmin`, `email`, `password`, `createdAt`, `updatedAt`) VALUES
(1, 'Adminy', 'Level', 1, 'admin@hotmail.com', '$2y$10$e5pa7dkjjvGpM5g.c0l1ru0tqWi2yH/018lCYCVPG6H8Kohn1Y9wy', '2022-09-23 05:53:03', '2023-01-28 09:35:32'),
(5, 'Helène', 'Horizon', 0, 'helen@gmail.com', '$2y$10$/oJS6FhracWE28GzBZVE.OM9OEIN1FlvwfmGO/D3iqjfBEimxyEK6', '2022-11-12 06:06:04', '2022-11-12 06:06:04'),
(6, 'Lois', 'Polisson', 0, 'polison@gmail.com', '$2y$10$hsV9pboSZZzUVVMCcEM1TeYcplDCSN3K/t4Xgxr0gpz9bxfIJ4v0C', '2022-11-13 01:53:34', '2022-11-13 01:53:34'),
(7, 'Julien', 'Juju', 0, 'juju@sfr.com', '$2y$10$5KjbzyysG.fpTxyHy99XwOkCIvMzgQDGH/EGHYXDZ8BEaCoRdFC5y', '2022-11-13 03:31:48', '2022-11-13 03:31:48'),
(8, 'Lola', 'Andypola Del Reyes', 0, 'lola@hotmail.com', '$2y$10$u.XofiPXYA7VtasxwRN//OuS7FdJ1ECxa6j/edYr5nGKSebYKT7bS', '2022-11-25 11:41:07', '2023-01-28 09:37:22'),
(9, 'Salim', 'Malika', 0, 'salim@hotmail.com', '$2y$10$YWHrtoo7tQIaXBNbXtq/C.bghjIUUKhB/1alFLXE/4x5/PGu7w/xy', '2022-12-27 01:41:20', '2022-12-27 01:41:20'),
(10, 'Mariam', 'vfsdush', 0, 'maria@free.fr', '$2y$10$nzjV/k1xychUpFhXWLY1/.GlOBDsREl3dnCBq5NlLdEHJgMzYBkGe', '2022-12-27 01:42:51', '2022-12-27 01:42:51');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`postId`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
