-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 17 avr. 2019 à 14:36
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

USE dreamteach;

--
-- Base de données :  `dreamteach`
--

-- --------------------------------------------------------

--
-- Structure de la table `badge`
--

DROP TABLE IF EXISTS `badge`;
CREATE TABLE IF NOT EXISTS `badge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `file_upload`
--

DROP TABLE IF EXISTS `file_upload`;
CREATE TABLE IF NOT EXISTS `file_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_student_id` int(11) NOT NULL,
  `id_session_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AFAAC0A06E1ECFCD` (`id_student_id`),
  KEY `IDX_AFAAC0A0C4B56C08` (`id_session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `friendship_relation`
--

DROP TABLE IF EXISTS `friendship_relation`;
CREATE TABLE IF NOT EXISTS `friendship_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_1_id` int(11) DEFAULT NULL,
  `student_2_id` int(11) DEFAULT NULL,
  `is_accepted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D5634873CFF02722` (`student_1_id`),
  KEY `IDX_D5634873DD4588CC` (`student_2_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `givenrecompenses`
--

DROP TABLE IF EXISTS `givenrecompenses`;
CREATE TABLE IF NOT EXISTS `givenrecompenses` (
  `studentID` int(11) NOT NULL,
  `badgeID` int(11) NOT NULL,
  PRIMARY KEY (`studentID`,`badgeID`),
  KEY `IDX_CDA15877A3D10F50` (`studentID`),
  KEY `IDX_CDA1587796B83874` (`badgeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `grade`
--

DROP TABLE IF EXISTS `grade`;
CREATE TABLE IF NOT EXISTS `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hangman`
--

DROP TABLE IF EXISTS `hangman`;
CREATE TABLE IF NOT EXISTS `hangman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F08D495FCB944F1A` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `liked_profile`
--

DROP TABLE IF EXISTS `liked_profile`;
CREATE TABLE IF NOT EXISTS `liked_profile` (
  `studentID1` int(11) NOT NULL,
  `studentID2` int(11) NOT NULL,
  PRIMARY KEY (`studentID1`,`studentID2`),
  KEY `IDX_FB4FE945E8146F4C` (`studentID1`),
  KEY `IDX_FB4FE945711D3EF6` (`studentID2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `marking_notation`
--

DROP TABLE IF EXISTS `marking_notation`;
CREATE TABLE IF NOT EXISTS `marking_notation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session` int(11) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `marking_efficiency` int(11) NOT NULL,
  `marking_ambience` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8B8D1160D044D5D4` (`session`),
  KEY `IDX_8B8D1160B723AF33` (`student`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `memory`
--

DROP TABLE IF EXISTS `memory`;
CREATE TABLE IF NOT EXISTS `memory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EA6D3435CB944F1A` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_receiver_id` int(11) NOT NULL,
  `id_sender_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FD5412041` (`id_receiver_id`),
  KEY `IDX_B6BD307F76110FBA` (`id_sender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `qcm`
--

DROP TABLE IF EXISTS `qcm`;
CREATE TABLE IF NOT EXISTS `qcm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id_id` int(11) NOT NULL,
  `deadline` datetime DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D7A1FEF469CCBE9A` (`author_id_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `theme` int(11) DEFAULT NULL,
  `content` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6F7494EF675F31B` (`author_id`),
  KEY `theme` (`theme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question_list`
--

DROP TABLE IF EXISTS `question_list`;
CREATE TABLE IF NOT EXISTS `question_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id_id` int(11) NOT NULL,
  `qcm_id_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1A2615F74FAF8F53` (`question_id_id`),
  KEY `IDX_1A2615F7F16A9A2D` (`qcm_id_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quote`
--

DROP TABLE IF EXISTS `quote`;
CREATE TABLE IF NOT EXISTS `quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotecontent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quote`
--

INSERT INTO `quote` (`id`, `quotecontent`, `author`) VALUES
(1, 'De bonnes choses vous attendent sur le chemin. N’arrêtez pas de marcher.', 'Robert Warren Painter Jr'),
(2, 'J’ai appris que le courage n’est pas l’absence de peur, mais la capacité de la vaincre.', 'Nelson Mandela'),
(3, 'Je n’ai pas échoué. J’ai juste utilisé 10 000 méthodes qui n’ont pas marché. ', 'Thomas Edison'),
(4, 'À force de tentatives, on finit toujours par réussir.', 'Hérodote'),
(5, 'La logique vous amènera de A à B. L’imagination vous amènera partout. ', 'Albert Einstein');

-- --------------------------------------------------------

--
-- Structure de la table `response`
--

DROP TABLE IF EXISTS `response`;
CREATE TABLE IF NOT EXISTS `response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id_id` int(11) NOT NULL,
  `content` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rightanswer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3E7B0BFB4FAF8F53` (`question_id_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `result`
--

DROP TABLE IF EXISTS `result`;
CREATE TABLE IF NOT EXISTS `result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qcm_id_id` int(11) NOT NULL,
  `user_id_id` int(11) NOT NULL,
  `result` double NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_136AC113F16A9A2D` (`qcm_id_id`),
  KEY `IDX_136AC1139D86650F` (`user_id_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `school`
--

DROP TABLE IF EXISTS `school`;
CREATE TABLE IF NOT EXISTS `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postalCode` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `school`
--

INSERT INTO `school` (`id`, `name`, `address`, `postalCode`, `city`) VALUES
(1, 'Paul Sabatier', '5 Allée Antonio Machado', '31100', 'Toulouse');

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startingTime` time NOT NULL,
  `endingTime` time NOT NULL,
  `date` date NOT NULL,
  `place` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maxNbParticipant` int(11) NOT NULL,
  `isVirtual` tinyint(1) NOT NULL,
  `vocalSoftware` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organizerID` int(11) DEFAULT NULL,
  `subjectID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subjectID` (`subjectID`),
  KEY `organizerID` (`organizerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessioncomment`
--

DROP TABLE IF EXISTS `sessioncomment`;
CREATE TABLE IF NOT EXISTS `sessioncomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` int(11) NOT NULL,
  `idSession` int(11) DEFAULT NULL,
  `idStudent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CF48C76EA79AC4C1` (`idStudent`),
  KEY `idSession` (`idSession`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessionparticipants`
--

DROP TABLE IF EXISTS `sessionparticipants`;
CREATE TABLE IF NOT EXISTS `sessionparticipants` (
  `sessionID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  PRIMARY KEY (`sessionID`,`studentID`),
  KEY `IDX_D38DDC1B23E953E` (`sessionID`),
  KEY `IDX_D38DDC1BA3D10F50` (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emailAddress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biography` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xpWon` int(11) DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` datetime DEFAULT NULL,
  `reset_password` tinyint(1) DEFAULT NULL,
  `reset_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trainingID` int(11) DEFAULT NULL,
  `gradeId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B723AF33A0F967B0` (`gradeId`),
  KEY `trainingID` (`trainingID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `student`
--

INSERT INTO `student` (`id`, `uuid`, `lastName`, `firstName`, `emailAddress`, `biography`, `password`, `avatar`, `xpWon`, `city`, `birth_date`, `reset_password`, `reset_id`, `trainingID`, `gradeId`) VALUES
(1, 'b8d49d02-1a3d-4ca8-93eb-445f59d8212f', 'georgette', 'georges', 'test@mail.com', 'Aime le tennis de table et les loukoums', '$2y$13$BwmQK6iFbQWbmKR9o0CJzuLlGqpx4gnjiPGJ9xiDRIN3JwyiV54Fi', NULL, 0, NULL, '1998-04-15 00:00:00', NULL, NULL, 1, NULL),
(2, '7ad8f9c8-97f5-411e-8285-a3358463a4f9', 'adel', 'adel', 'adel@mekki.fr', NULL, '$2y$13$o7VlxGnMpUX8apg/8d0PR.xgdJM2dgcONahPI0sujYhUpFvDgf1Qm', NULL, 0, NULL, NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `subjectlevel`
--

DROP TABLE IF EXISTS `subjectlevel`;
CREATE TABLE IF NOT EXISTS `subjectlevel` (
  `subjectLvlID` int(11) NOT NULL AUTO_INCREMENT,
  `mark` int(11) NOT NULL,
  `subjectID` int(11) DEFAULT NULL,
  `studentID` int(11) DEFAULT NULL,
  PRIMARY KEY (`subjectLvlID`),
  KEY `IDX_550538D35621423` (`subjectID`),
  KEY `IDX_550538D3A3D10F50` (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `subject_level`
--

DROP TABLE IF EXISTS `subject_level`;
CREATE TABLE IF NOT EXISTS `subject_level` (
  `studentID` int(11) NOT NULL,
  `subjectID` int(11) NOT NULL,
  PRIMARY KEY (`studentID`,`subjectID`),
  KEY `IDX_8B790DCBA3D10F50` (`studentID`),
  KEY `IDX_8B790DCB5621423` (`subjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

DROP TABLE IF EXISTS `theme`;
CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `training`
--

DROP TABLE IF EXISTS `training`;
CREATE TABLE IF NOT EXISTS `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schoolID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schoolID` (`schoolID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `training`
--

INSERT INTO `training` (`id`, `title`, `duration`, `schoolID`) VALUES
(1, 'Littérature', '1', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_response`
--

DROP TABLE IF EXISTS `user_response`;
CREATE TABLE IF NOT EXISTS `user_response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_id` int(11) NOT NULL,
  `question_list_id_id` int(11) NOT NULL,
  `response_id_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DEF6EFFB9D86650F` (`user_id_id`),
  KEY `IDX_DEF6EFFBC10395DC` (`question_list_id_id`),
  KEY `IDX_DEF6EFFB6F324507` (`response_id_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `word`
--

DROP TABLE IF EXISTS `word`;
CREATE TABLE IF NOT EXISTS `word` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` int(11) DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `definition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C3F175119775E708` (`theme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

INSERT INTO `word` (`id`, `theme`, `content`, `definition`) VALUES
(1, 1, 'Cercle', 'C\'est un truc rond'),
(2, 1, 'Triangle', 'C\'est un truc qui a 3 lignes'),
(3, 1, 'Pythagore', 'C\'est un mec');


INSERT INTO `theme` (`id`, `content`) VALUES
(1, 'maths');
--
-- Contraintes pour la table `file_upload`
--
ALTER TABLE `file_upload`
  ADD CONSTRAINT `FK_AFAAC0A06E1ECFCD` FOREIGN KEY (`id_student_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `FK_AFAAC0A0C4B56C08` FOREIGN KEY (`id_session_id`) REFERENCES `session` (`id`);

--
-- Contraintes pour la table `friendship_relation`
--
ALTER TABLE `friendship_relation`
  ADD CONSTRAINT `FK_D5634873CFF02722` FOREIGN KEY (`student_1_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `FK_D5634873DD4588CC` FOREIGN KEY (`student_2_id`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `givenrecompenses`
--
ALTER TABLE `givenrecompenses`
  ADD CONSTRAINT `FK_CDA1587796B83874` FOREIGN KEY (`badgeID`) REFERENCES `badge` (`id`),
  ADD CONSTRAINT `FK_CDA15877A3D10F50` FOREIGN KEY (`studentID`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `hangman`
--
ALTER TABLE `hangman`
  ADD CONSTRAINT `FK_F08D495FCB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `liked_profile`
--
ALTER TABLE `liked_profile`
  ADD CONSTRAINT `FK_FB4FE945711D3EF6` FOREIGN KEY (`studentID2`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `FK_FB4FE945E8146F4C` FOREIGN KEY (`studentID1`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `marking_notation`
--
ALTER TABLE `marking_notation`
  ADD CONSTRAINT `FK_8B8D1160B723AF33` FOREIGN KEY (`student`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `FK_8B8D1160D044D5D4` FOREIGN KEY (`session`) REFERENCES `session` (`id`);

--
-- Contraintes pour la table `memory`
--
ALTER TABLE `memory`
  ADD CONSTRAINT `FK_EA6D3435CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307F76110FBA` FOREIGN KEY (`id_sender_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `FK_B6BD307FD5412041` FOREIGN KEY (`id_receiver_id`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `qcm`
--
ALTER TABLE `qcm`
  ADD CONSTRAINT `FK_D7A1FEF469CCBE9A` FOREIGN KEY (`author_id_id`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_B6F7494E9775E708` FOREIGN KEY (`theme`) REFERENCES `theme` (`id`),
  ADD CONSTRAINT `FK_B6F7494EF675F31B` FOREIGN KEY (`author_id`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `question_list`
--
ALTER TABLE `question_list`
  ADD CONSTRAINT `FK_1A2615F74FAF8F53` FOREIGN KEY (`question_id_id`) REFERENCES `question` (`id`),
  ADD CONSTRAINT `FK_1A2615F7F16A9A2D` FOREIGN KEY (`qcm_id_id`) REFERENCES `qcm` (`id`);

--
-- Contraintes pour la table `response`
--
ALTER TABLE `response`
  ADD CONSTRAINT `FK_3E7B0BFB4FAF8F53` FOREIGN KEY (`question_id_id`) REFERENCES `question` (`id`);

--
-- Contraintes pour la table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `FK_136AC1139D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `FK_136AC113F16A9A2D` FOREIGN KEY (`qcm_id_id`) REFERENCES `qcm` (`id`);

--
-- Contraintes pour la table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `FK_D044D5D432C39171` FOREIGN KEY (`organizerID`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `FK_D044D5D45621423` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`id`);

--
-- Contraintes pour la table `sessioncomment`
--
ALTER TABLE `sessioncomment`
  ADD CONSTRAINT `FK_CF48C76EA79AC4C1` FOREIGN KEY (`idStudent`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `FK_CF48C76EC0FDBE26` FOREIGN KEY (`idSession`) REFERENCES `session` (`id`);

--
-- Contraintes pour la table `sessionparticipants`
--
ALTER TABLE `sessionparticipants`
  ADD CONSTRAINT `FK_D38DDC1B23E953E` FOREIGN KEY (`sessionID`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `FK_D38DDC1BA3D10F50` FOREIGN KEY (`studentID`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_B723AF33A0A55892` FOREIGN KEY (`trainingID`) REFERENCES `training` (`id`),
  ADD CONSTRAINT `FK_B723AF33A0F967B0` FOREIGN KEY (`gradeId`) REFERENCES `grade` (`id`);

--
-- Contraintes pour la table `subjectlevel`
--
ALTER TABLE `subjectlevel`
  ADD CONSTRAINT `FK_550538D35621423` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`id`),
  ADD CONSTRAINT `FK_550538D3A3D10F50` FOREIGN KEY (`studentID`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `subject_level`
--
ALTER TABLE `subject_level`
  ADD CONSTRAINT `FK_8B790DCB5621423` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`id`),
  ADD CONSTRAINT `FK_8B790DCBA3D10F50` FOREIGN KEY (`studentID`) REFERENCES `student` (`id`);

--
-- Contraintes pour la table `training`
--
ALTER TABLE `training`
  ADD CONSTRAINT `FK_D5128A8F70E4D61D` FOREIGN KEY (`schoolID`) REFERENCES `school` (`id`);

--
-- Contraintes pour la table `user_response`
--
ALTER TABLE `user_response`
  ADD CONSTRAINT `FK_DEF6EFFB6F324507` FOREIGN KEY (`response_id_id`) REFERENCES `response` (`id`),
  ADD CONSTRAINT `FK_DEF6EFFB9D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `FK_DEF6EFFBC10395DC` FOREIGN KEY (`question_list_id_id`) REFERENCES `question_list` (`id`);

--
-- Contraintes pour la table `word`
--
ALTER TABLE `word`
  ADD CONSTRAINT `FK_C3F175119775E708` FOREIGN KEY (`theme`) REFERENCES `theme` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
