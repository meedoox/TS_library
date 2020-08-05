# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.4.12-MariaDB)
# Database: ts_library
# Generation Time: 2020-08-05 13:51:40 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table author
# ------------------------------------------------------------

DROP TABLE IF EXISTS `author`;

CREATE TABLE `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;

INSERT INTO `author` (`id`, `lastname`)
VALUES
	(1,'Karel Čapek'),
	(6,'Alena Mornštajnová'),
	(7,'Matyáš Herman');

/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table book
# ------------------------------------------------------------

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CBE5A331F675F31B` (`author_id`),
  CONSTRAINT `FK_CBE5A331F675F31B` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;

INSERT INTO `book` (`id`, `name`, `description`, `year`, `number_of_pages`, `created_at`, `author_id`)
VALUES
	(1,'Bílá nemoc','Popudem k napsání tohoto dramatu z r. 1937 byl podle autorových slov \"konflikt ideálů demokracie s ideály neomezených a ctižádostivých diktatur\". Jistou zemi napadla epidemie bílé nemoci. Lékař Galén proti ní vynalezl účinný lék. Lék vydá jen tehdy, když se vlády zaváží, že již nikdy nebudou válčit. Hlava státu, v němž bílá nemoc vypukla - výbojný maršál - chce dobývat svět a před ničím se nezastavuje. Bílou nemocí je napaden hlavní zbrojař země baron Krüg. Galén jej odmítá léčit, dokud nebudou splněny jeho podmínky…',1948,122,'2020-08-05 11:01:11',1),
	(4,'R.U.R','Čapkovo utopistické drama, v němž se světu poprvé představilo slovo robot. Vypráví o továrně, v níž vznikají roboti, kteří pracují za lidi a umožňují tak vzniku jakéhosi ráje. Jenomže nic netrvá věčně a i roboti můžou začít myslet na sebe…',1937,102,'2020-08-05 10:01:11',1),
	(6,'Matka','Čapkovo protiválečné drama o třech dějstvích (myšlenku napsat tuto hru vnukla Čapkovi jeho manželka, herečka Olga Scheinpflugová) patří dodnes k vrcholům české dramatické tvorby.',1938,86,'2015-01-01 00:00:00',1),
	(10,'Slepá mapa','\"Anna, Alžběta, Anežka. Tři ženy, tři generace, jedna rodina a mnoho životních zvratů, traumat a tajemství.\r\n\r\nPříběh začíná před první světovou válkou, kdy Anna, vypravěččina babička, odjíždí přes odpor svých rodičů s vyvoleným Antonínem do pohraničního městečka na severu Čech. Jako by počáteční písmeno jejich jmen vyjadřovalo naději, že právě tady spolu mohou začít nový život. Jméno však současně symbolizuje i to, co si vybrat nemůžeme, co je nám dáno jako rodinné dědictví, které si přese všechno odhodlání ke změně vždy neseme s sebou. Anebo také osud, na jehož zkoušky máme jen pramalý vliv.\r\n\r\nNový začátek se tak záhy mění v boj o přežití, když je Antonín na frontě raněn a u Anny propuká tuberkulóza. O čtvrt století později pak čeká jiný nový začátek i jejich dceru Alžbětu, která musí prchat před německou armádou zabírající pohraničí, a po dalším půlstoletí změní dramatický zásah osudu — tentokrát v podobě důstojníka StB — i život vypravěčky příběhu Anežky.\"',2013,396,'2020-08-05 13:24:19',6),
	(11,'Hotýlek','Některé věci jakoby existovaly mimo čas. Zůstávají stejné navzdory dějinám, válkám, totalitním režimům i počasí. Takový je i hotel pana Leopolda, vlastně spíše hodinový hotýlek, založený v dobách první republiky a nabízející potěšení a rozkoš pánům za protektorátu a dokonce i poté, co ho znárodnili komunisté. Oč více přímočaré lásky ale nabízely hotelové pokoje, o to osudovější a dramatičtější vztahy se odehrávaly v rodině majitele a posléze správce.',2015,319,'2020-08-05 13:26:33',6);

/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table book_genre
# ------------------------------------------------------------

DROP TABLE IF EXISTS `book_genre`;

CREATE TABLE `book_genre` (
  `book_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  PRIMARY KEY (`book_id`,`genre_id`),
  KEY `IDX_8D92268116A2B381` (`book_id`),
  KEY `IDX_8D9226814296D31F` (`genre_id`),
  CONSTRAINT `FK_8D92268116A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_8D9226814296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `book_genre` WRITE;
/*!40000 ALTER TABLE `book_genre` DISABLE KEYS */;

INSERT INTO `book_genre` (`book_id`, `genre_id`)
VALUES
	(1,1),
	(1,3),
	(6,1),
	(6,3),
	(10,3),
	(10,6),
	(10,7),
	(11,3),
	(11,6);

/*!40000 ALTER TABLE `book_genre` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table doctrine_migration_versions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `doctrine_migration_versions`;

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`)
VALUES
	('DoctrineMigrations\\Version20200805075157','2020-08-05 08:57:52',82),
	('DoctrineMigrations\\Version20200805085313','2020-08-05 08:57:53',69),
	('DoctrineMigrations\\Version20200805090647','2020-08-05 09:06:53',148);

/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table genre
# ------------------------------------------------------------

DROP TABLE IF EXISTS `genre`;

CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;

INSERT INTO `genre` (`id`, `name`)
VALUES
	(1,'Divadelní hry'),
	(3,'Literatura česká'),
	(5,'Sci-fi'),
	(6,'Romány'),
	(7,'Pro ženy');

/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
