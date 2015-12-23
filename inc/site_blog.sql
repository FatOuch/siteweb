-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 17 Décembre 2015 à 00:55
-- Version du serveur :  10.1.8-MariaDB
-- Version de PHP :  5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `site_blog`
--
CREATE DATABASE IF NOT EXISTS `site_blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `site_blog`;

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8_bin NOT NULL,
  `lien_img` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `titre`, `lien_img`, `content`, `date`) VALUES
(1, 'Cas numéro 1', 'http://lorempixel.com/400/200/people/', 'Aujourd''hui, mon mari et son meilleur ami ont conclu très sérieusement un pacte. \r\nEn cas de décès, le survivant s''engage à séduire la veuve, à élever ses enfants et à l''installer chez lui en plus de sa femme actuelle. C''est beau une amitié masculine,mais là je ne sais pas comment le prendre. VDM ', '0000-00-00 00:00:00'),
(2, 'Cas numéro 2', 'http://www.online-image-editor.com//styles/2014/images/example_image.png', 'Aujourd''hui, je suis aphone et prends un covoitureur. \r\n				Je lui explique mon souci et tente malgré tout de communiquer pour rendre le trajet convivial. \r\n				Il me dit de conserver ma voix et me remercie vivement lors de sa dépose. \r\n				l m''a laissé une note "horrible" et en commentaire : "Aucune discussion." VDM', '0000-00-00 00:00:00'),
(3, 'Cas numéro 3', 'http://www.menucool.com/slider/jsImgSlider/images/image-slider-2.jpg', 'Aujourd''hui, très allergique aux fruits de mers, j''ai fait un choc anaphylactique. \r\n				Mon ami a refusé de m''injecter mon EpiPen car il "n''aime pas vraiment ça, les aiguilles." VDM', '0000-00-00 00:00:00'),
(4, 'Cas numéro 4', 'http://a5.mzstatic.com/eu/r30/Purple5/v4/5a/2e/e9/5a2ee9b3-8f0e-4f8b-4043-dd3e3ea29766/icon128-2x.png', 'Aujourd''hui, Zélie, ma fille de 5 ans s''est amusée à se couper les cheveux pour les donner à Manon, qui est "chauve" selon elle. Manon, sa petite soeur de 2 semaines. VDM', '0000-00-00 00:00:00'),
(5, 'Cas numéro 5', 'http://www.keenthemes.com/preview/metronic/theme/assets/global/plugins/jcrop/demos/demo_files/image1.jpg', 'Aujourd''hui, je lance mon affaire en m''associant avec deux amis. \r\n				Enthousiastes, ces derniers ont pioché dans notre cagnotte commune sans me le dire pour acheter \r\n				au cours de la même journée un baby-foot, un billard et une grande télévision murale. Nous ouvrons une boulangerie. VDM', '0000-00-00 00:00:00'),
(11, 'C''est pas jojo...', 'http://referentiel.nouvelobs.com/file/6970896.jpg', 'Alors alors alors alors alors\r\nAlors alors alors alors alors\r\nAlors alors alors alors alorsAlors alors alors alors alors\r\nAlors alors alors alors alors\r\nAlors alors alors alors alors\r\nAlors alors alors alors alors\r\nAlors alors alors alors alors', '2015-12-16 14:03:26'),
(12, 'je sais pas', 'http://www.wanimo.com/veterinaire/cache/multithumb_thumbs/b_250_0_16777215_00_images_articles_poisson_poisson-rouge.jpg', 'hvfhdlslvl sklvslvd lkh', '2015-12-16 16:14:46');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  `id_article` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `id_article`, `date`, `user_id`) VALUES
(17, 'WOow ça c''est du lourd !!\r\nBon courage!!', 1, '2015-12-16 12:54:57', 0),
(18, 'bon bey ok !! Pas malllll!!', 1, '2015-12-16 14:04:49', 0),
(20, 'essai', 1, '2015-12-16 16:16:39', 0),
(21, 'peace and clearness!!!!!\r\n\r\nplease', 1, '2015-12-16 16:30:38', 0),
(28, 'Derniere tentative...', 1, '2015-12-17 00:16:24', 0),
(29, 'hdhlv ;v lshsv', 1, '2015-12-17 00:19:32', 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nickname` varchar(255) COLLATE utf8_bin NOT NULL,
  `date_registered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `nickname`, `date_registered`) VALUES
(6, 'Crazy Squirel', '2015-12-16 12:54:57'),
(7, 'sunlight', '2015-12-16 14:04:49'),
(9, 'test', '2015-12-16 16:16:39'),
(10, 'po woow', '2015-12-16 16:30:38'),
(12, 'boum', '2015-12-16 16:43:32'),
(14, 'testy', '2015-12-16 23:02:28'),
(15, 'tastydu95', '2015-12-16 23:20:33'),
(17, 'bon ba...', '2015-12-17 00:16:24'),
(18, 'mais il ne se passe rien', '2015-12-17 00:19:32');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
