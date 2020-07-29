-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 07, 2020 at 04:24 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ankete_testovi`
--

-- --------------------------------------------------------

--
-- Table structure for table `ankete`
--

DROP TABLE IF EXISTS `ankete`;
CREATE TABLE IF NOT EXISTS `ankete` (
  `idAnkete` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pocetak` date NOT NULL,
  `kraj` date NOT NULL,
  `tip` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'A-anonimna P-personalizovana',
  `kreator` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idAnkete`),
  KEY `ankete_ibfk_1` (`kreator`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ankete`
--

INSERT INTO `ankete` (`idAnkete`, `naziv`, `pocetak`, `kraj`, `tip`, `kreator`) VALUES
(1, 'Ishrana', '2020-02-06', '2020-02-26', 'A', 'bogdan'),
(2, 'Putovanja', '2020-02-01', '2020-03-01', 'P', 'dimi'),
(3, 'Sport', '2020-02-05', '2020-02-25', 'P', 'dimi'),
(4, 'Posao', '2020-01-10', '2020-01-30', 'A', 'viktor');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `username` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `ime` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `prezime` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `datumrodj` date NOT NULL,
  `mestorodj` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jmbg` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `kontakt` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `eposta` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `tip` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'I-ispitanik  K-kreator A-administrator',
  `registrovan` int(11) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`username`, `password`, `ime`, `prezime`, `datumrodj`, `mestorodj`, `jmbg`, `kontakt`, `eposta`, `tip`, `registrovan`) VALUES
('aleks', 'Zkuyig5@', 'Aleksandra', 'Nikolic', '1980-08-08', 'Beograd', '0808980715039', '06434567661', 'aleks81@gmail.com', 'I', 1),
('aurora', 'aurorA93#', 'Aurora', 'Stevanovic', '1993-07-25', 'Leskovac', '2507993909011', '0647803208', 'aurora93@gmail.com', 'I', 1),
('bogdan', 'boki1994#L', 'Bogdan', 'Lazarevic', '1994-03-10', 'Nis', '1003994500107', '060900909', 'boki@gmail.com', 'K', 1),
('dimi', 'dimitrije85#SS', 'Dimitrije', 'Stevanovic', '1985-04-06', 'Sombor', '0604985733006', '060980564', 'dimi85@gmail.com', 'K', 1),
('filip', 'filip96A#S', 'Filip', 'Stojanovic', '1996-02-06', 'Beograd', '0602996800075', '06234080', 'filip96@gmail.com', 'I', 0),
('klaric', 'Klara#6K', 'Klara', 'Peric', '2000-07-15', 'Zrenjanin', '1507000737316', '065342890', 'klara00@gmail.com', 'A', 1),
('laraa', 'lara72#M', 'Lara', 'Milojevic', '1972-12-16', 'Uzice', '1612972796002', '0657845623', 'lara72@gmail.com', 'A', 1),
('maksim', 'mkk4#8A@', 'Maksim', 'Maksimovic', '1986-12-16', 'Beograd', '1612986712009', '0643509988', 'maksim86@gmail.com', 'I', 1),
('tanjica', 'tanjica#97S', 'Tanja', 'Simic', '1997-04-12', 'Kragujevac', '1204997725024', '0657802452', 'tanja97@gmail.com', 'I', 0),
('viktor', 'viktor90#S', 'Viktor', 'Stojanovic', '1990-09-13', 'Beograd', '1309990701053', '063450975', 'viktor90@gmail.com', 'K', 1);

-- --------------------------------------------------------

--
-- Table structure for table `odgovori`
--

DROP TABLE IF EXISTS `odgovori`;
CREATE TABLE IF NOT EXISTS `odgovori` (
  `idOdgovora` int(11) NOT NULL AUTO_INCREMENT,
  `odgovor` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `tacno` int(1) DEFAULT NULL,
  `idPitanja` int(11) NOT NULL,
  `anketa_test` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idOdgovora`),
  KEY `odgovori_ibfk_1` (`idPitanja`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `odgovori`
--

INSERT INTO `odgovori` (`idOdgovora`, `odgovor`, `tacno`, `idPitanja`, `anketa_test`) VALUES
(1, '1-2', NULL, 1, 'Ishrana'),
(2, '3', NULL, 1, 'Ishrana'),
(3, '5', NULL, 1, 'Ishrana'),
(7, 'ne, ne doruckujem', NULL, 2, 'Ishrana'),
(8, 'ponekad', NULL, 2, 'Ishrana'),
(9, 'da, uvek', NULL, 2, 'Ishrana'),
(10, '4h', NULL, 3, 'Ishrana'),
(11, '4-6h', NULL, 3, 'Ishrana'),
(12, '7 ili vise sati', NULL, 3, 'Ishrana'),
(13, 'nisam', NULL, 4, 'Ishrana'),
(14, 'ponekad', NULL, 4, 'Ishrana'),
(15, 'da, redovno', NULL, 4, 'Ishrana'),
(16, 'jedem', NULL, 5, 'Ishrana'),
(17, 'ponekad', NULL, 5, 'Ishrana'),
(18, 'ne, nikako', NULL, 5, 'Ishrana'),
(19, 'ne svaki dan', NULL, 6, 'Ishrana'),
(20, 'najmanje uz jedan obrok dnevno', NULL, 6, 'Ishrana'),
(21, 'kombinujem povrce uz svaki obrok', NULL, 6, 'Ishrana'),
(22, 'ne konzumiram', NULL, 7, 'Ishrana'),
(23, 'retko', NULL, 7, 'Ishrana'),
(24, 'svaki dan', NULL, 7, 'Ishrana'),
(25, 'da', NULL, 8, 'Putovanja'),
(26, 'ne', NULL, 8, 'Putovanja'),
(27, 'da', NULL, 9, 'Putovanja'),
(28, 'ne', NULL, 9, 'Putovanja'),
(54, 'Sa prijateljima', NULL, 12, 'Putovanja'),
(55, 'Sa porodicom', NULL, 12, 'Putovanja'),
(56, 'Sam/Sama', NULL, 12, 'Putovanja'),
(57, 'Ne putujem', NULL, 12, 'Putovanja'),
(58, 'PijaÅ¾e', 1, 13, 'Psihologija'),
(59, 'Spirman', 0, 13, 'Psihologija'),
(60, 'Gilford', 0, 13, 'Psihologija'),
(61, 'psihoanalitiÄke teorije', 1, 14, 'Psihologija'),
(62, 'humanistiÄke teorije', 0, 14, 'Psihologija'),
(63, 'psihosomatske teorije', 0, 14, 'Psihologija'),
(64, 'Zamena cilja', 0, 15, 'Psihologija'),
(65, 'TraÅ¾enje razloga neuspeha', 0, 15, 'Psihologija'),
(66, 'PoveÄ‡ano ulaganje napora', 1, 15, 'Psihologija'),
(67, 'UÄenje', 0, 16, 'Psihologija'),
(68, 'Atribucija', 1, 16, 'Psihologija'),
(69, 'Imitacija', 0, 16, 'Psihologija'),
(70, '2', 1, 17, 'Razno'),
(71, 'Pas', 1, 18, 'Razno'),
(72, 'Sat', 0, 18, 'Razno'),
(73, 'Sveska', 0, 18, 'Razno'),
(74, 'Lav', 1, 18, 'Razno'),
(75, '4', 1, 19, 'Razno'),
(76, 'Beograd', 1, 20, 'Razno'),
(77, 'Nikada', NULL, 21, 'Sport'),
(78, 'Veoma retko ', NULL, 21, 'Sport'),
(79, 'Jednom meseÄno-godiÅ¡nje', NULL, 21, 'Sport'),
(80, 'Jednom nedeljno', NULL, 21, 'Sport'),
(81, 'Svakog dana', NULL, 21, 'Sport'),
(82, 'Da', NULL, 22, 'Sport'),
(83, 'Ne', NULL, 22, 'Sport'),
(84, 'hasovi', 0, 25, 'Istorija'),
(85, 'timari', 1, 25, 'Istorija'),
(86, 'zijameti', 0, 25, 'Istorija'),
(87, 'vakufi', 0, 25, 'Istorija'),
(88, 'Egiptu', 1, 26, 'Istorija'),
(89, '1265', 1, 27, 'Istorija'),
(90, 'Konstantin', 0, 28, 'Istorija'),
(91, 'Justinijan', 1, 28, 'Istorija'),
(92, 'Vasilije I', 0, 28, 'Istorija'),
(95, 'Mala plata, puno posla', NULL, 32, 'Posao'),
(96, 'Previse stresa, stalna tenzija', NULL, 32, 'Posao'),
(97, 'Neslaganje sa sefom', NULL, 32, 'Posao'),
(98, 'Neslaganje sa kolegama', NULL, 32, 'Posao'),
(99, 'Radno vreme', NULL, 32, 'Posao'),
(100, 'Nista od navedenog', NULL, 32, 'Posao'),
(101, 'Da', NULL, 33, 'Posao'),
(102, 'Ne', NULL, 33, 'Posao'),
(103, 'Delimicno', NULL, 33, 'Posao'),
(104, 'Da', NULL, 34, 'Posao'),
(105, 'Ne', NULL, 34, 'Posao'),
(106, 'cela molekula DNK', 0, 36, 'Biologija'),
(107, 'delovi hromozomske DNK', 0, 36, 'Biologija'),
(108, 'delovi RNK i DNK', 1, 36, 'Biologija'),
(109, 'Transkripcijom', 1, 38, 'Biologija'),
(110, 'rakovi', 1, 39, 'Biologija'),
(111, 'stonoge', 1, 39, 'Biologija'),
(112, 'paukoliki zglavkari', 0, 39, 'Biologija'),
(113, 'insekti', 1, 39, 'Biologija'),
(114, 'Povrsne i duboke', 1, 40, 'Biologija');

-- --------------------------------------------------------

--
-- Table structure for table `pitanja`
--

DROP TABLE IF EXISTS `pitanja`;
CREATE TABLE IF NOT EXISTS `pitanja` (
  `idPitanja` int(11) NOT NULL AUTO_INCREMENT,
  `pitanje` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `broj_poena` float DEFAULT NULL,
  `broj_odgovora` int(11) NOT NULL,
  `broj_tacnih` int(11) DEFAULT NULL,
  `tip_odgovora` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `anketa_test` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idPitanja`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pitanja`
--

INSERT INTO `pitanja` (`idPitanja`, `pitanje`, `broj_poena`, `broj_odgovora`, `broj_tacnih`, `tip_odgovora`, `anketa_test`) VALUES
(1, 'Koliko imate obroka u toku dana?', NULL, 3, NULL, '4', 'Ishrana'),
(2, 'Da li doruckujete?', NULL, 3, NULL, '4', 'Ishrana'),
(3, 'Koliko sati spavate dnevno?', NULL, 3, NULL, '4', 'Ishrana'),
(4, 'Da li ste fizicki aktivni?', NULL, 3, NULL, '4', 'Ishrana'),
(5, 'Da li jedete nocu?', NULL, 3, NULL, '4', 'Ishrana'),
(6, 'Koliko cesto konzumirate povrce?', NULL, 3, NULL, '4', 'Ishrana'),
(7, 'Koliko cesto konzumirate voce?', NULL, 3, NULL, '4', 'Ishrana'),
(8, 'Da li volite da putujete?', NULL, 2, NULL, '4', 'Putovanja'),
(9, 'Da li cesto putujete?', NULL, 2, NULL, '4', 'Putovanja'),
(10, 'U koliko zemalja ste do sada bili?', NULL, 1, NULL, '1', 'Putovanja'),
(11, 'Koja je vasa omiljena zemlja u kojoj ste bili?', NULL, 1, NULL, '2', 'Putovanja'),
(12, 'Sa kim najcesce putujete?', NULL, 4, NULL, '5', 'Putovanja'),
(13, 'Faze u razvoju inteligencije kod dece dao je svajcarski psiholog:', 5, 3, 1, '3', 'Psihologija'),
(14, 'Frojdova teorija licnosti spada u:', 5, 3, 1, '3', 'Psihologija'),
(15, 'Najzdraviji i najrealisticniji nacin reagovanja na frustracije je:', 5, 3, 1, '3', 'Psihologija'),
(16, 'Proces zakljucivanja o uzrocima ponasanja osobe koja se opaza naziva se:', 5, 3, 1, '3', 'Psihologija'),
(17, 'Vrednost algebarskog izraza a4+a6-2 za a=-1 je:', 10, 1, 1, '1', 'Razno'),
(18, 'Sta ta sve spada u zivotinje?', 5, 4, 2, '4', 'Razno'),
(19, 'Koliko je 2+2?', 2, 1, 1, '1', 'Razno'),
(20, 'Glavni grad Srbije?', 2, 1, 1, '2', 'Razno'),
(21, 'Koliko cesto odlazite u prirodu?', NULL, 5, NULL, '4', 'Sport'),
(22, 'Bavite li se sportom?', NULL, 2, NULL, '4', 'Sport'),
(23, 'Kojim sportom se bavite?', NULL, 1, NULL, '2', 'Sport'),
(24, 'Da li mislite da bi ljudi trebalo da se bave sportom i zaÅ¡to?', NULL, 1, NULL, '3', 'Sport'),
(25, 'U turskom feudalnom sistemu najmanji feudalni posedi nazivali su se:', 10, 4, 1, '3', 'Istorija'),
(26, 'Ikonoborstvo je pokret nastao u?', 10, 1, 1, '2', 'Istorija'),
(27, 'Koje godine je engleski parlament prvi put sazvan za vreme Edvarda I?', 10, 1, 1, '1', 'Istorija'),
(28, 'Svetu Sofiju sagradio je:', 10, 3, 1, '3', 'Istorija'),
(32, 'Sta Vam na poslu dosta smeta?', NULL, 6, NULL, '5', 'Posao'),
(33, 'Da li mislite da bi samo povecanje plate resilo problem?', NULL, 3, NULL, '4', 'Posao'),
(34, 'Da li ste razmisljali o promeni posla?', NULL, 2, NULL, '4', 'Posao'),
(35, 'Sta biste porucili sefu/poslodavcu da smete?', NULL, 1, NULL, '3', 'Posao'),
(36, 'Geni su:', 10, 3, 1, '3', 'Biologija'),
(37, 'Prema veÄ‡ini savremenih shvatanja, osnovnu jedinicu evolucije predstavlja:', 10, 4, 1, '3', 'Biologija'),
(38, 'Aminokiseline nastaju:', 10, 1, 1, '2', 'Biologija'),
(39, 'Koja od navedenih grupa zglavkara ima antene?', 15, 4, 3, '4', 'Biologija'),
(40, 'Limfni sudovi se dele na:', 10, 1, 1, '2', 'Biologija');

-- --------------------------------------------------------

--
-- Table structure for table `snimi`
--

DROP TABLE IF EXISTS `snimi`;
CREATE TABLE IF NOT EXISTS `snimi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pitanje` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `odgovor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `poeni` float DEFAULT NULL,
  `anketa_test` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `korisnik` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `snimi`
--

INSERT INTO `snimi` (`id`, `pitanje`, `odgovor`, `poeni`, `anketa_test`, `korisnik`) VALUES
(6, 'U turskom feudalnom sistemu najmanji feudalni posedi nazivali su se:', 'timari', NULL, 'Istorija', 'aurora'),
(7, 'Ikonoborstvo je pokret nastao u?', 'Egiptu', NULL, 'Istorija', 'aurora'),
(8, 'Koje godine je engleski parlament prvi put sazvan za vreme Edvarda I?', 'nema odgovora', NULL, 'Istorija', 'aurora'),
(9, 'Svetu Sofiju sagradio je:', 'Justinijan', NULL, 'Istorija', 'aurora');

-- --------------------------------------------------------

--
-- Table structure for table `testovi`
--

DROP TABLE IF EXISTS `testovi`;
CREATE TABLE IF NOT EXISTS `testovi` (
  `idTesta` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pocetak` date NOT NULL,
  `kraj` date NOT NULL,
  `trajanje_sek` int(11) NOT NULL,
  `kreator` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idTesta`),
  KEY `testovi_ibfk_1` (`kreator`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `testovi`
--

INSERT INTO `testovi` (`idTesta`, `naziv`, `pocetak`, `kraj`, `trajanje_sek`, `kreator`) VALUES
(1, 'Psihologija', '2020-02-01', '2020-02-28', 120, 'dimi'),
(2, 'Istorija', '2020-02-01', '2020-05-01', 180, 'viktor'),
(3, 'Biologija', '2020-02-01', '2020-02-15', 150, 'viktor');

-- --------------------------------------------------------

--
-- Table structure for table `testovi_izvestaj`
--

DROP TABLE IF EXISTS `testovi_izvestaj`;
CREATE TABLE IF NOT EXISTS `testovi_izvestaj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `prezime` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `poeni` float NOT NULL,
  `test` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `testovi_izvestaj`
--

INSERT INTO `testovi_izvestaj` (`id`, `ime`, `prezime`, `poeni`, `test`) VALUES
(1, 'Aurora', 'Stevanovic', 30, 'Istorija'),
(2, 'Aleksandra', 'Nikolic', 10, 'Istorija'),
(3, 'Bogdan', 'Lazarevic', 10, 'Istorija'),
(4, 'Dimitrije', 'Stevanovic', 20, 'Istorija'),
(5, 'Viktor', 'Stojanovic', 5, 'Psihologija');

-- --------------------------------------------------------

--
-- Table structure for table `zakljucaj`
--

DROP TABLE IF EXISTS `zakljucaj`;
CREATE TABLE IF NOT EXISTS `zakljucaj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pitanje` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `odgovor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `poeni` float NOT NULL,
  `korisnik` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `anketa_test` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zakljucaj`
--

INSERT INTO `zakljucaj` (`id`, `pitanje`, `odgovor`, `poeni`, `korisnik`, `anketa_test`) VALUES
(1, 'Da li volite da putujete?', 'da', 0, 'aurora', 'Putovanja'),
(2, 'Da li cesto putujete?', 'da', 0, 'aurora', 'Putovanja'),
(3, 'U koliko zemalja ste do sada bili?', '  12', 0, 'aurora', 'Putovanja'),
(4, 'Koja je vasa omiljena zemlja u kojoj ste bili?', '  Spanija', 0, 'aurora', 'Putovanja'),
(5, 'Sa kim najcesce putujete?', ' Sa prijateljima', 0, 'aurora', 'Putovanja'),
(6, 'U turskom feudalnom sistemu najmanji feudalni posedi nazivali su se:', 'timari', 10, 'aurora', 'Istorija'),
(7, 'Ikonoborstvo je pokret nastao u?', 'Egiptu', 10, 'aurora', 'Istorija'),
(8, 'Svetu Sofiju sagradio je:', 'Justinijan', 10, 'aurora', 'Istorija'),
(9, 'Da li volite da putujete?', 'ne', 0, 'viktor', 'Putovanja'),
(10, 'Da li cesto putujete?', 'ne', 0, 'viktor', 'Putovanja'),
(11, 'U koliko zemalja ste do sada bili?', ' 3', 0, 'viktor', 'Putovanja'),
(12, 'Koja je vasa omiljena zemlja u kojoj ste bili?', ' Srbija', 0, 'viktor', 'Putovanja'),
(13, 'Sa kim najcesce putujete?', ' Sa porodicom', 0, 'viktor', 'Putovanja'),
(14, 'U turskom feudalnom sistemu najmanji feudalni posedi nazivali su se:', 'timari', 10, 'aleks', 'Istorija'),
(15, 'Svetu Sofiju sagradio je:', 'Vasilije I', 0, 'aleks', 'Istorija'),
(16, 'Da li volite da putujete?', 'da', 0, 'bogdan', 'Putovanja'),
(17, 'Da li cesto putujete?', 'da', 0, 'bogdan', 'Putovanja'),
(18, 'U koliko zemalja ste do sada bili?', ' 5', 0, 'bogdan', 'Putovanja'),
(19, 'Koja je vasa omiljena zemlja u kojoj ste bili?', ' Nemacka', 0, 'bogdan', 'Putovanja'),
(20, 'Sa kim najcesce putujete?', ' Sa porodicom', 0, 'bogdan', 'Putovanja'),
(21, 'U turskom feudalnom sistemu najmanji feudalni posedi nazivali su se:', 'hasovi', 0, 'bogdan', 'Istorija'),
(22, 'Ikonoborstvo je pokret nastao u?', 'Francuskoj', 0, 'bogdan', 'Istorija'),
(23, 'Koje godine je engleski parlament prvi put sazvan za vreme Edvarda I?', '1250', 0, 'bogdan', 'Istorija'),
(24, 'Svetu Sofiju sagradio je:', 'Justinijan', 10, 'bogdan', 'Istorija'),
(25, 'U turskom feudalnom sistemu najmanji feudalni posedi nazivali su se:', 'zijameti', 0, 'dimi', 'Istorija'),
(26, 'Ikonoborstvo je pokret nastao u?', 'Egiptu', 10, 'dimi', 'Istorija'),
(27, 'Svetu Sofiju sagradio je:', 'Justinijan', 10, 'dimi', 'Istorija'),
(28, 'Faze u razvoju inteligencije kod dece dao je svajcarski psiholog:', 'Spirman', 0, 'viktor', 'Psihologija'),
(29, 'Frojdova teorija licnosti spada u:', 'humanistiÄke teorije', 0, 'viktor', 'Psihologija'),
(30, 'Najzdraviji i najrealisticniji nacin reagovanja na frustracije je:', 'Zamena cilja', 0, 'viktor', 'Psihologija'),
(31, 'Proces zakljucivanja o uzrocima ponasanja osobe koja se opaza naziva se:', 'Atribucija', 5, 'viktor', 'Psihologija'),
(32, 'Da li volite da putujete?', 'da', 0, 'aleks', 'Putovanja'),
(33, 'Da li cesto putujete?', 'da', 0, 'aleks', 'Putovanja'),
(34, 'U koliko zemalja ste do sada bili?', ' 5', 0, 'aleks', 'Putovanja'),
(35, 'Koja je vasa omiljena zemlja u kojoj ste bili?', ' Danska', 0, 'aleks', 'Putovanja'),
(36, 'Sa kim najcesce putujete?', ' Sa porodicom', 0, 'aleks', 'Putovanja');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ankete`
--
ALTER TABLE `ankete`
  ADD CONSTRAINT `ankete_ibfk_1` FOREIGN KEY (`kreator`) REFERENCES `korisnik` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `odgovori`
--
ALTER TABLE `odgovori`
  ADD CONSTRAINT `odgovori_ibfk_1` FOREIGN KEY (`idPitanja`) REFERENCES `pitanja` (`idPitanja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `testovi`
--
ALTER TABLE `testovi`
  ADD CONSTRAINT `testovi_ibfk_1` FOREIGN KEY (`kreator`) REFERENCES `korisnik` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
