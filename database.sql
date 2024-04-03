-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2024 at 06:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `answer` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `background` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(0, 'Kategorisiz', 'kategorisiz'),
(31, 'Elektronik', 'elektronik'),
(47, 'Enstrüman', 'enstruman'),
(48, 'Müzik Setleri', 'muzik-setleri'),
(49, 'Donanım', 'donanim'),
(50, 'Kulaklıklar', 'kulakliklar');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`) VALUES
(1, 'ADANA'),
(2, 'ADIYAMAN'),
(3, 'AFYON'),
(4, 'AĞRI'),
(5, 'AMASYA'),
(6, 'ANKARA'),
(7, 'ANTALYA'),
(8, 'ARTVİN'),
(9, 'AYDIN'),
(10, 'BALIKESİR'),
(11, 'BİLECİK'),
(12, 'BİNGÖL'),
(13, 'BİTLİS'),
(14, 'BOLU'),
(15, 'BURDUR'),
(16, 'BURSA'),
(17, 'ÇANAKKALE'),
(18, 'ÇANKIRI'),
(19, 'ÇORUM'),
(20, 'DENİZLİ'),
(21, 'DİYARBAKIR'),
(22, 'EDİRNE'),
(23, 'ELAZIĞ'),
(24, 'ERZİNCAN'),
(25, 'ERZURUM'),
(26, 'ESKİŞEHİR'),
(27, 'GAZİANTEP'),
(28, 'GİRESUN'),
(29, 'GÜMÜŞHANE'),
(30, 'HAKKARİ'),
(31, 'HATAY'),
(32, 'ISPARTA'),
(33, 'İÇEL'),
(34, 'İSTANBUL'),
(35, 'İZMİR'),
(36, 'KARS'),
(37, 'KASTAMONU'),
(38, 'KAYSERİ'),
(39, 'KIRKLARELİ'),
(40, 'KIRŞEHİR'),
(41, 'KOCAELİ'),
(42, 'KONYA'),
(43, 'KÜTAHYA'),
(44, 'MALATYA'),
(45, 'MANİSA'),
(46, 'KAHRAMANMARAŞ'),
(47, 'MARDİN'),
(48, 'MUĞLA'),
(49, 'MUŞ'),
(50, 'NEVŞEHİR'),
(51, 'NİĞDE'),
(52, 'ORDU'),
(53, 'RİZE'),
(54, 'SAKARYA'),
(55, 'SAMSUN'),
(56, 'SİİRT'),
(57, 'SİNOP'),
(58, 'SİVAS'),
(59, 'TEKİRDAĞ'),
(60, 'TOKAT'),
(61, 'TRABZON'),
(62, 'TUNCELİ'),
(63, 'ŞANLIURFA'),
(64, 'UŞAK'),
(65, 'VAN'),
(66, 'YOZGAT'),
(67, 'ZONGULDAK'),
(68, 'AKSARAY'),
(69, 'BAYBURT'),
(70, 'KARAMAN'),
(71, 'KIRIKKALE'),
(72, 'BATMAN'),
(73, 'ŞIRNAK'),
(74, 'BARTIN'),
(75, 'ARDAHAN'),
(76, 'IĞDIR'),
(77, 'YALOVA'),
(78, 'KARABÜK'),
(79, 'KİLİS'),
(80, 'OSMANİYE'),
(81, 'DÜZCE');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `city_id`) VALUES
(1, 'ALADAĞ', 1),
(2, 'CEYHAN', 1),
(3, 'ÇUKUROVA', 1),
(4, 'FEKE', 1),
(5, 'İMAMOĞLU', 1),
(6, 'KARAİSALI', 1),
(7, 'KARATAŞ', 1),
(8, 'KOZAN', 1),
(9, 'POZANTI', 1),
(10, 'SAİMBEYLİ', 1),
(11, 'SARIÇAM', 1),
(12, 'SEYHAN', 1),
(13, 'TUFANBEYLİ', 1),
(14, 'YUMURTALIK', 1),
(15, 'YÜREĞİR', 1),
(16, 'BESNİ', 2),
(17, 'ÇELİKHAN', 2),
(18, 'GERGER', 2),
(19, 'GÖLBAŞI', 2),
(20, 'KAHTA', 2),
(21, 'MERKEZ', 2),
(22, 'SAMSAT', 2),
(23, 'SİNCİK', 2),
(24, 'TUT', 2),
(25, 'BAŞMAKÇI', 3),
(26, 'BAYAT', 3),
(27, 'BOLVADİN', 3),
(28, 'ÇAY', 3),
(29, 'ÇOBANLAR', 3),
(30, 'DAZKIRI', 3),
(31, 'DİNAR', 3),
(32, 'EMİRDAĞ', 3),
(33, 'EVCİLER', 3),
(34, 'HOCALAR', 3),
(35, 'İHSANİYE', 3),
(36, 'İSCEHİSAR', 3),
(37, 'KIZILÖREN', 3),
(38, 'MERKEZ', 3),
(39, 'SANDIKLI', 3),
(40, 'SİNANPAŞA', 3),
(41, 'SULTANDAĞI', 3),
(42, 'ŞUHUT', 3),
(43, 'DİYADİN', 4),
(44, 'DOĞUBAYAZIT', 4),
(45, 'ELEŞKİRT', 4),
(46, 'HAMUR', 4),
(47, 'MERKEZ', 4),
(48, 'PATNOS', 4),
(49, 'TAŞLIÇAY', 4),
(50, 'TUTAK', 4),
(51, 'AĞAÇÖREN', 68),
(52, 'ESKİL', 68),
(53, 'GÜLAĞAÇ', 68),
(54, 'GÜZELYURT', 68),
(55, 'MERKEZ', 68),
(56, 'ORTAKÖY', 68),
(57, 'SARIYAHŞİ', 68),
(58, 'SULTANHANI', 68),
(59, 'GÖYNÜCEK', 5),
(60, 'GÜMÜŞHACIKÖY', 5),
(61, 'HAMAMÖZÜ', 5),
(62, 'MERKEZ', 5),
(63, 'MERZİFON', 5),
(64, 'SULUOVA', 5),
(65, 'TAŞOVA', 5),
(66, 'AKYURT', 6),
(67, 'ALTINDAĞ', 6),
(68, 'AYAŞ', 6),
(69, 'BALA', 6),
(70, 'BEYPAZARI', 6),
(71, 'ÇAMLIDERE', 6),
(72, 'ÇANKAYA', 6),
(73, 'ÇUBUK', 6),
(74, 'ELMADAĞ', 6),
(75, 'ETİMESGUT', 6),
(76, 'EVREN', 6),
(77, 'GÖLBAŞI', 6),
(78, 'GÜDÜL', 6),
(79, 'HAYMANA', 6),
(80, 'KAHRAMANKAZAN', 6),
(81, 'KALECİK', 6),
(82, 'KEÇİÖREN', 6),
(83, 'KIZILCAHAMAM', 6),
(84, 'MAMAK', 6),
(85, 'NALLIHAN', 6),
(86, 'POLATLI', 6),
(87, 'PURSAKLAR', 6),
(88, 'SİNCAN', 6),
(89, 'ŞEREFLİKOÇHİSAR', 6),
(90, 'YENİMAHALLE', 6),
(91, 'AKSEKİ', 7),
(92, 'AKSU', 7),
(93, 'ALANYA', 7),
(94, 'DEMRE', 7),
(95, 'DÖŞEMEALTI', 7),
(96, 'ELMALI', 7),
(97, 'FİNİKE', 7),
(98, 'GAZİPAŞA', 7),
(99, 'GÜNDOĞMUŞ', 7),
(100, 'İBRADI', 7),
(101, 'KAŞ', 7),
(102, 'KEMER', 7),
(103, 'KEPEZ', 7),
(104, 'KONYAALTI', 7),
(105, 'KORKUTELİ', 7),
(106, 'KUMLUCA', 7),
(107, 'MANAVGAT', 7),
(108, 'MURATPAŞA', 7),
(109, 'SERİK', 7),
(110, 'ÇILDIR', 75),
(111, 'DAMAL', 75),
(112, 'GÖLE', 75),
(113, 'HANAK', 75),
(114, 'MERKEZ', 75),
(115, 'POSOF', 75),
(116, 'ARDANUÇ', 8),
(117, 'ARHAVİ', 8),
(118, 'BORÇKA', 8),
(119, 'HOPA', 8),
(120, 'KEMALPAŞA', 8),
(121, 'MERKEZ', 8),
(122, 'MURGUL', 8),
(123, 'ŞAVŞAT', 8),
(124, 'YUSUFELİ', 8),
(125, 'BOZDOĞAN', 9),
(126, 'BUHARKENT', 9),
(127, 'ÇİNE', 9),
(128, 'DİDİM', 9),
(129, 'EFELER', 9),
(130, 'GERMENCİK', 9),
(131, 'İNCİRLİOVA', 9),
(132, 'KARACASU', 9),
(133, 'KARPUZLU', 9),
(134, 'KOÇARLI', 9),
(135, 'KÖŞK', 9),
(136, 'KUŞADASI', 9),
(137, 'KUYUCAK', 9),
(138, 'NAZİLLİ', 9),
(139, 'SÖKE', 9),
(140, 'SULTANHİSAR', 9),
(141, 'YENİPAZAR', 9),
(142, 'ALTIEYLÜL', 10),
(143, 'AYVALIK', 10),
(144, 'BALYA', 10),
(145, 'BANDIRMA', 10),
(146, 'BİGADİÇ', 10),
(147, 'BURHANİYE', 10),
(148, 'DURSUNBEY', 10),
(149, 'EDREMİT', 10),
(150, 'ERDEK', 10),
(151, 'GÖMEÇ', 10),
(152, 'GÖNEN', 10),
(153, 'HAVRAN', 10),
(154, 'İVRİNDİ', 10),
(155, 'KARESİ', 10),
(156, 'KEPSUT', 10),
(157, 'MANYAS', 10),
(158, 'MARMARA', 10),
(159, 'SAVAŞTEPE', 10),
(160, 'SINDIRGI', 10),
(161, 'SUSURLUK', 10),
(162, 'AMASRA', 74),
(163, 'KURUCAŞİLE', 74),
(164, 'MERKEZ', 74),
(165, 'ULUS', 74),
(166, 'BEŞİRİ', 72),
(167, 'GERCÜŞ', 72),
(168, 'HASANKEYF', 72),
(169, 'KOZLUK', 72),
(170, 'MERKEZ', 72),
(171, 'SASON', 72),
(172, 'AYDINTEPE', 69),
(173, 'DEMİRÖZÜ', 69),
(174, 'MERKEZ', 69),
(175, 'BOZÜYÜK', 11),
(176, 'GÖLPAZARI', 11),
(177, 'İNHİSAR', 11),
(178, 'MERKEZ', 11),
(179, 'OSMANELİ', 11),
(180, 'PAZARYERİ', 11),
(181, 'SÖĞÜT', 11),
(182, 'YENİPAZAR', 11),
(183, 'ADAKLI', 12),
(184, 'GENÇ', 12),
(185, 'KARLIOVA', 12),
(186, 'KİĞI', 12),
(187, 'MERKEZ', 12),
(188, 'SOLHAN', 12),
(189, 'YAYLADERE', 12),
(190, 'YEDİSU', 12),
(191, 'ADİLCEVAZ', 13),
(192, 'AHLAT', 13),
(193, 'GÜROYMAK', 13),
(194, 'HİZAN', 13),
(195, 'MERKEZ', 13),
(196, 'MUTKİ', 13),
(197, 'TATVAN', 13),
(198, 'DÖRTDİVAN', 14),
(199, 'GEREDE', 14),
(200, 'GÖYNÜK', 14),
(201, 'KIBRISCIK', 14),
(202, 'MENGEN', 14),
(203, 'MERKEZ', 14),
(204, 'MUDURNU', 14),
(205, 'SEBEN', 14),
(206, 'YENİÇAĞA', 14),
(207, 'AĞLASUN', 15),
(208, 'ALTINYAYLA', 15),
(209, 'BUCAK', 15),
(210, 'ÇAVDIR', 15),
(211, 'ÇELTİKÇİ', 15),
(212, 'GÖLHİSAR', 15),
(213, 'KARAMANLI', 15),
(214, 'KEMER', 15),
(215, 'MERKEZ', 15),
(216, 'TEFENNİ', 15),
(217, 'YEŞİLOVA', 15),
(218, 'BÜYÜKORHAN', 16),
(219, 'GEMLİK', 16),
(220, 'GÜRSU', 16),
(221, 'HARMANCIK', 16),
(222, 'İNEGÖL', 16),
(223, 'İZNİK', 16),
(224, 'KARACABEY', 16),
(225, 'KELES', 16),
(226, 'KESTEL', 16),
(227, 'MUDANYA', 16),
(228, 'MUSTAFAKEMALPAŞA', 16),
(229, 'NİLÜFER', 16),
(230, 'ORHANELİ', 16),
(231, 'ORHANGAZİ', 16),
(232, 'OSMANGAZİ', 16),
(233, 'YENİŞEHİR', 16),
(234, 'YILDIRIM', 16),
(235, 'AYVACIK', 17),
(236, 'BAYRAMİÇ', 17),
(237, 'BİGA', 17),
(238, 'BOZCAADA', 17),
(239, 'ÇAN', 17),
(240, 'ECEABAT', 17),
(241, 'EZİNE', 17),
(242, 'GELİBOLU', 17),
(243, 'GÖKÇEADA', 17),
(244, 'LAPSEKİ', 17),
(245, 'MERKEZ', 17),
(246, 'YENİCE', 17),
(247, 'ATKARACALAR', 18),
(248, 'BAYRAMÖREN', 18),
(249, 'ÇERKEŞ', 18),
(250, 'ELDİVAN', 18),
(251, 'ILGAZ', 18),
(252, 'KIZILIRMAK', 18),
(253, 'KORGUN', 18),
(254, 'KURŞUNLU', 18),
(255, 'MERKEZ', 18),
(256, 'ORTA', 18),
(257, 'ŞABANÖZÜ', 18),
(258, 'YAPRAKLI', 18),
(259, 'ALACA', 19),
(260, 'BAYAT', 19),
(261, 'BOĞAZKALE', 19),
(262, 'DODURGA', 19),
(263, 'İSKİLİP', 19),
(264, 'KARGI', 19),
(265, 'LAÇİN', 19),
(266, 'MECİTÖZÜ', 19),
(267, 'MERKEZ', 19),
(268, 'OĞUZLAR', 19),
(269, 'ORTAKÖY', 19),
(270, 'OSMANCIK', 19),
(271, 'SUNGURLU', 19),
(272, 'UĞURLUDAĞ', 19),
(273, 'ACIPAYAM', 20),
(274, 'BABADAĞ', 20),
(275, 'BAKLAN', 20),
(276, 'BEKİLLİ', 20),
(277, 'BEYAĞAÇ', 20),
(278, 'BOZKURT', 20),
(279, 'BULDAN', 20),
(280, 'ÇAL', 20),
(281, 'ÇAMELİ', 20),
(282, 'ÇARDAK', 20),
(283, 'ÇİVRİL', 20),
(284, 'GÜNEY', 20),
(285, 'HONAZ', 20),
(286, 'KALE', 20),
(287, 'MERKEZEFENDİ', 20),
(288, 'PAMUKKALE', 20),
(289, 'SARAYKÖY', 20),
(290, 'SERİNHİSAR', 20),
(291, 'TAVAS', 20),
(292, 'BAĞLAR', 21),
(293, 'BİSMİL', 21),
(294, 'ÇERMİK', 21),
(295, 'ÇINAR', 21),
(296, 'ÇÜNGÜŞ', 21),
(297, 'DİCLE', 21),
(298, 'EĞİL', 21),
(299, 'ERGANİ', 21),
(300, 'HANİ', 21),
(301, 'HAZRO', 21),
(302, 'KAYAPINAR', 21),
(303, 'KOCAKÖY', 21),
(304, 'KULP', 21),
(305, 'LİCE', 21),
(306, 'SİLVAN', 21),
(307, 'SUR', 21),
(308, 'YENİŞEHİR', 21),
(309, 'AKÇAKOCA', 81),
(310, 'CUMAYERİ', 81),
(311, 'ÇİLİMLİ', 81),
(312, 'GÖLYAKA', 81),
(313, 'GÜMÜŞOVA', 81),
(314, 'KAYNAŞLI', 81),
(315, 'MERKEZ', 81),
(316, 'YIĞILCA', 81),
(317, 'ENEZ', 22),
(318, 'HAVSA', 22),
(319, 'İPSALA', 22),
(320, 'KEŞAN', 22),
(321, 'LALAPAŞA', 22),
(322, 'MERİÇ', 22),
(323, 'MERKEZ', 22),
(324, 'SÜLOĞLU', 22),
(325, 'UZUNKÖPRÜ', 22),
(326, 'AĞIN', 23),
(327, 'ALACAKAYA', 23),
(328, 'ARICAK', 23),
(329, 'BASKİL', 23),
(330, 'KARAKOÇAN', 23),
(331, 'KEBAN', 23),
(332, 'KOVANCILAR', 23),
(333, 'MADEN', 23),
(334, 'MERKEZ', 23),
(335, 'PALU', 23),
(336, 'SİVRİCE', 23),
(337, 'ÇAYIRLI', 24),
(338, 'İLİÇ', 24),
(339, 'KEMAH', 24),
(340, 'KEMALİYE', 24),
(341, 'MERKEZ', 24),
(342, 'OTLUKBELİ', 24),
(343, 'REFAHİYE', 24),
(344, 'TERCAN', 24),
(345, 'ÜZÜMLÜ', 24),
(346, 'AŞKALE', 25),
(347, 'AZİZİYE', 25),
(348, 'ÇAT', 25),
(349, 'HINIS', 25),
(350, 'HORASAN', 25),
(351, 'İSPİR', 25),
(352, 'KARAÇOBAN', 25),
(353, 'KARAYAZI', 25),
(354, 'KÖPRÜKÖY', 25),
(355, 'NARMAN', 25),
(356, 'OLTU', 25),
(357, 'OLUR', 25),
(358, 'PALANDÖKEN', 25),
(359, 'PASİNLER', 25),
(360, 'PAZARYOLU', 25),
(361, 'ŞENKAYA', 25),
(362, 'TEKMAN', 25),
(363, 'TORTUM', 25),
(364, 'UZUNDERE', 25),
(365, 'YAKUTİYE', 25),
(366, 'ALPU', 26),
(367, 'BEYLİKOVA', 26),
(368, 'ÇİFTELER', 26),
(369, 'GÜNYÜZÜ', 26),
(370, 'HAN', 26),
(371, 'İNÖNÜ', 26),
(372, 'MAHMUDİYE', 26),
(373, 'MİHALGAZİ', 26),
(374, 'MİHALIÇÇIK', 26),
(375, 'ODUNPAZARI', 26),
(376, 'SARICAKAYA', 26),
(377, 'SEYİTGAZİ', 26),
(378, 'SİVRİHİSAR', 26),
(379, 'TEPEBAŞI', 26),
(380, 'ARABAN', 27),
(381, 'İSLAHİYE', 27),
(382, 'KARKAMIŞ', 27),
(383, 'NİZİP', 27),
(384, 'NURDAĞI', 27),
(385, 'OĞUZELİ', 27),
(386, 'ŞAHİNBEY', 27),
(387, 'ŞEHİTKAMİL', 27),
(388, 'YAVUZELİ', 27),
(389, 'ALUCRA', 28),
(390, 'BULANCAK', 28),
(391, 'ÇAMOLUK', 28),
(392, 'ÇANAKÇI', 28),
(393, 'DERELİ', 28),
(394, 'DOĞANKENT', 28),
(395, 'ESPİYE', 28),
(396, 'EYNESİL', 28),
(397, 'GÖRELE', 28),
(398, 'GÜCE', 28),
(399, 'KEŞAP', 28),
(400, 'MERKEZ', 28),
(401, 'PİRAZİZ', 28),
(402, 'ŞEBİNKARAHİSAR', 28),
(403, 'TİREBOLU', 28),
(404, 'YAĞLIDERE', 28),
(405, 'KELKİT', 29),
(406, 'KÖSE', 29),
(407, 'KÜRTÜN', 29),
(408, 'MERKEZ', 29),
(409, 'ŞİRAN', 29),
(410, 'TORUL', 29),
(411, 'ÇUKURCA', 30),
(412, 'DERECİK', 30),
(413, 'MERKEZ', 30),
(414, 'ŞEMDİNLİ', 30),
(415, 'YÜKSEKOVA', 30),
(416, 'ALTINÖZÜ', 31),
(417, 'ANTAKYA', 31),
(418, 'ARSUZ', 31),
(419, 'BELEN', 31),
(420, 'DEFNE', 31),
(421, 'DÖRTYOL', 31),
(422, 'ERZİN', 31),
(423, 'HASSA', 31),
(424, 'İSKENDERUN', 31),
(425, 'KIRIKHAN', 31),
(426, 'KUMLU', 31),
(427, 'PAYAS', 31),
(428, 'REYHANLI', 31),
(429, 'SAMANDAĞ', 31),
(430, 'YAYLADAĞI', 31),
(431, 'ARALIK', 76),
(432, 'KARAKOYUNLU', 76),
(433, 'MERKEZ', 76),
(434, 'TUZLUCA', 76),
(435, 'AKSU', 32),
(436, 'ATABEY', 32),
(437, 'EĞİRDİR', 32),
(438, 'GELENDOST', 32),
(439, 'GÖNEN', 32),
(440, 'KEÇİBORLU', 32),
(441, 'MERKEZ', 32),
(442, 'SENİRKENT', 32),
(443, 'SÜTÇÜLER', 32),
(444, 'ŞARKİKARAAĞAÇ', 32),
(445, 'ULUBORLU', 32),
(446, 'YALVAÇ', 32),
(447, 'YENİŞARBADEMLİ', 32),
(448, 'ADALAR', 34),
(449, 'ARNAVUTKÖY', 34),
(450, 'ATAŞEHİR', 34),
(451, 'AVCILAR', 34),
(452, 'BAĞCILAR', 34),
(453, 'BAHÇELİEVLER', 34),
(454, 'BAKIRKÖY', 34),
(455, 'BAŞAKŞEHİR', 34),
(456, 'BAYRAMPAŞA', 34),
(457, 'BEŞİKTAŞ', 34),
(458, 'BEYKOZ', 34),
(459, 'BEYLİKDÜZÜ', 34),
(460, 'BEYOĞLU', 34),
(461, 'BÜYÜKÇEKMECE', 34),
(462, 'ÇATALCA', 34),
(463, 'ÇEKMEKÖY', 34),
(464, 'ESENLER', 34),
(465, 'ESENYURT', 34),
(466, 'EYÜPSULTAN', 34),
(467, 'FATİH', 34),
(468, 'GAZİOSMANPAŞA', 34),
(469, 'GÜNGÖREN', 34),
(470, 'KADIKÖY', 34),
(471, 'KAĞITHANE', 34),
(472, 'KARTAL', 34),
(473, 'KÜÇÜKÇEKMECE', 34),
(474, 'MALTEPE', 34),
(475, 'PENDİK', 34),
(476, 'SANCAKTEPE', 34),
(477, 'SARIYER', 34),
(478, 'SİLİVRİ', 34),
(479, 'SULTANBEYLİ', 34),
(480, 'SULTANGAZİ', 34),
(481, 'ŞİLE', 34),
(482, 'ŞİŞLİ', 34),
(483, 'TUZLA', 34),
(484, 'ÜMRANİYE', 34),
(485, 'ÜSKÜDAR', 34),
(486, 'ZEYTİNBURNU', 34),
(487, 'ALİAĞA', 35),
(488, 'BALÇOVA', 35),
(489, 'BAYINDIR', 35),
(490, 'BAYRAKLI', 35),
(491, 'BERGAMA', 35),
(492, 'BEYDAĞ', 35),
(493, 'BORNOVA', 35),
(494, 'BUCA', 35),
(495, 'ÇEŞME', 35),
(496, 'ÇİĞLİ', 35),
(497, 'DİKİLİ', 35),
(498, 'FOÇA', 35),
(499, 'GAZİEMİR', 35),
(500, 'GÜZELBAHÇE', 35),
(501, 'KARABAĞLAR', 35),
(502, 'KARABURUN', 35),
(503, 'KARŞIYAKA', 35),
(504, 'KEMALPAŞA', 35),
(505, 'KINIK', 35),
(506, 'KİRAZ', 35),
(507, 'KONAK', 35),
(508, 'MENDERES', 35),
(509, 'MENEMEN', 35),
(510, 'NARLIDERE', 35),
(511, 'ÖDEMİŞ', 35),
(512, 'SEFERİHİSAR', 35),
(513, 'SELÇUK', 35),
(514, 'TİRE', 35),
(515, 'TORBALI', 35),
(516, 'URLA', 35),
(517, 'AFŞİN', 46),
(518, 'ANDIRIN', 46),
(519, 'ÇAĞLAYANCERİT', 46),
(520, 'DULKADİROĞLU', 46),
(521, 'EKİNÖZÜ', 46),
(522, 'ELBİSTAN', 46),
(523, 'GÖKSUN', 46),
(524, 'NURHAK', 46),
(525, 'ONİKİŞUBAT', 46),
(526, 'PAZARCIK', 46),
(527, 'TÜRKOĞLU', 46),
(528, 'EFLANİ', 78),
(529, 'ESKİPAZAR', 78),
(530, 'MERKEZ', 78),
(531, 'OVACIK', 78),
(532, 'SAFRANBOLU', 78),
(533, 'YENİCE', 78),
(534, 'AYRANCI', 70),
(535, 'BAŞYAYLA', 70),
(536, 'ERMENEK', 70),
(537, 'KAZIMKARABEKİR', 70),
(538, 'MERKEZ', 70),
(539, 'SARIVELİLER', 70),
(540, 'AKYAKA', 36),
(541, 'ARPAÇAY', 36),
(542, 'DİGOR', 36),
(543, 'KAĞIZMAN', 36),
(544, 'MERKEZ', 36),
(545, 'SARIKAMIŞ', 36),
(546, 'SELİM', 36),
(547, 'SUSUZ', 36),
(548, 'ABANA', 37),
(549, 'AĞLI', 37),
(550, 'ARAÇ', 37),
(551, 'AZDAVAY', 37),
(552, 'BOZKURT', 37),
(553, 'CİDE', 37),
(554, 'ÇATALZEYTİN', 37),
(555, 'DADAY', 37),
(556, 'DEVREKANİ', 37),
(557, 'DOĞANYURT', 37),
(558, 'HANÖNÜ', 37),
(559, 'İHSANGAZİ', 37),
(560, 'İNEBOLU', 37),
(561, 'KÜRE', 37),
(562, 'MERKEZ', 37),
(563, 'PINARBAŞI', 37),
(564, 'SEYDİLER', 37),
(565, 'ŞENPAZAR', 37),
(566, 'TAŞKÖPRÜ', 37),
(567, 'TOSYA', 37),
(568, 'AKKIŞLA', 38),
(569, 'BÜNYAN', 38),
(570, 'DEVELİ', 38),
(571, 'FELAHİYE', 38),
(572, 'HACILAR', 38),
(573, 'İNCESU', 38),
(574, 'KOCASİNAN', 38),
(575, 'MELİKGAZİ', 38),
(576, 'ÖZVATAN', 38),
(577, 'PINARBAŞI', 38),
(578, 'SARIOĞLAN', 38),
(579, 'SARIZ', 38),
(580, 'TALAS', 38),
(581, 'TOMARZA', 38),
(582, 'YAHYALI', 38),
(583, 'YEŞİLHİSAR', 38),
(584, 'BAHŞILI', 71),
(585, 'BALIŞEYH', 71),
(586, 'ÇELEBİ', 71),
(587, 'DELİCE', 71),
(588, 'KARAKEÇİLİ', 71),
(589, 'KESKİN', 71),
(590, 'MERKEZ', 71),
(591, 'SULAKYURT', 71),
(592, 'YAHŞİHAN', 71),
(593, 'BABAESKİ', 39),
(594, 'DEMİRKÖY', 39),
(595, 'KOFÇAZ', 39),
(596, 'LÜLEBURGAZ', 39),
(597, 'MERKEZ', 39),
(598, 'PEHLİVANKÖY', 39),
(599, 'PINARHİSAR', 39),
(600, 'VİZE', 39),
(601, 'AKÇAKENT', 40),
(602, 'AKPINAR', 40),
(603, 'BOZTEPE', 40),
(604, 'ÇİÇEKDAĞI', 40),
(605, 'KAMAN', 40),
(606, 'MERKEZ', 40),
(607, 'MUCUR', 40),
(608, 'ELBEYLİ', 79),
(609, 'MERKEZ', 79),
(610, 'MUSABEYLİ', 79),
(611, 'POLATELİ', 79),
(612, 'BAŞİSKELE', 41),
(613, 'ÇAYIROVA', 41),
(614, 'DARICA', 41),
(615, 'DERİNCE', 41),
(616, 'DİLOVASI', 41),
(617, 'GEBZE', 41),
(618, 'GÖLCÜK', 41),
(619, 'İZMİT', 41),
(620, 'KANDIRA', 41),
(621, 'KARAMÜRSEL', 41),
(622, 'KARTEPE', 41),
(623, 'KÖRFEZ', 41),
(624, 'AHIRLI', 42),
(625, 'AKÖREN', 42),
(626, 'AKŞEHİR', 42),
(627, 'ALTINEKİN', 42),
(628, 'BEYŞEHİR', 42),
(629, 'BOZKIR', 42),
(630, 'CİHANBEYLİ', 42),
(631, 'ÇELTİK', 42),
(632, 'ÇUMRA', 42),
(633, 'DERBENT', 42),
(634, 'DEREBUCAK', 42),
(635, 'DOĞANHİSAR', 42),
(636, 'EMİRGAZİ', 42),
(637, 'EREĞLİ', 42),
(638, 'GÜNEYSINIR', 42),
(639, 'HADİM', 42),
(640, 'HALKAPINAR', 42),
(641, 'HÜYÜK', 42),
(642, 'ILGIN', 42),
(643, 'KADINHANI', 42),
(644, 'KARAPINAR', 42),
(645, 'KARATAY', 42),
(646, 'KULU', 42),
(647, 'MERAM', 42),
(648, 'SARAYÖNÜ', 42),
(649, 'SELÇUKLU', 42),
(650, 'SEYDİŞEHİR', 42),
(651, 'TAŞKENT', 42),
(652, 'TUZLUKÇU', 42),
(653, 'YALIHÜYÜK', 42),
(654, 'YUNAK', 42),
(655, 'ALTINTAŞ', 43),
(656, 'ASLANAPA', 43),
(657, 'ÇAVDARHİSAR', 43),
(658, 'DOMANİÇ', 43),
(659, 'DUMLUPINAR', 43),
(660, 'EMET', 43),
(661, 'GEDİZ', 43),
(662, 'HİSARCIK', 43),
(663, 'MERKEZ', 43),
(664, 'PAZARLAR', 43),
(665, 'SİMAV', 43),
(666, 'ŞAPHANE', 43),
(667, 'TAVŞANLI', 43),
(668, 'AKÇADAĞ', 44),
(669, 'ARAPGİR', 44),
(670, 'ARGUVAN', 44),
(671, 'BATTALGAZİ', 44),
(672, 'DARENDE', 44),
(673, 'DOĞANŞEHİR', 44),
(674, 'DOĞANYOL', 44),
(675, 'HEKİMHAN', 44),
(676, 'KALE', 44),
(677, 'KULUNCAK', 44),
(678, 'PÜTÜRGE', 44),
(679, 'YAZIHAN', 44),
(680, 'YEŞİLYURT', 44),
(681, 'AHMETLİ', 45),
(682, 'AKHİSAR', 45),
(683, 'ALAŞEHİR', 45),
(684, 'DEMİRCİ', 45),
(685, 'GÖLMARMARA', 45),
(686, 'GÖRDES', 45),
(687, 'KIRKAĞAÇ', 45),
(688, 'KÖPRÜBAŞI', 45),
(689, 'KULA', 45),
(690, 'SALİHLİ', 45),
(691, 'SARIGÖL', 45),
(692, 'SARUHANLI', 45),
(693, 'SELENDİ', 45),
(694, 'SOMA', 45),
(695, 'ŞEHZADELER', 45),
(696, 'TURGUTLU', 45),
(697, 'YUNUSEMRE', 45),
(698, 'ARTUKLU', 47),
(699, 'DARGEÇİT', 47),
(700, 'DERİK', 47),
(701, 'KIZILTEPE', 47),
(702, 'MAZIDAĞI', 47),
(703, 'MİDYAT', 47),
(704, 'NUSAYBİN', 47),
(705, 'ÖMERLİ', 47),
(706, 'SAVUR', 47),
(707, 'YEŞİLLİ', 47),
(708, 'AKDENİZ', 33),
(709, 'ANAMUR', 33),
(710, 'AYDINCIK', 33),
(711, 'BOZYAZI', 33),
(712, 'ÇAMLIYAYLA', 33),
(713, 'ERDEMLİ', 33),
(714, 'GÜLNAR', 33),
(715, 'MEZİTLİ', 33),
(716, 'MUT', 33),
(717, 'SİLİFKE', 33),
(718, 'TARSUS', 33),
(719, 'TOROSLAR', 33),
(720, 'YENİŞEHİR', 33),
(721, 'BODRUM', 48),
(722, 'DALAMAN', 48),
(723, 'DATÇA', 48),
(724, 'FETHİYE', 48),
(725, 'KAVAKLIDERE', 48),
(726, 'KÖYCEĞİZ', 48),
(727, 'MARMARİS', 48),
(728, 'MENTEŞE', 48),
(729, 'MİLAS', 48),
(730, 'ORTACA', 48),
(731, 'SEYDİKEMER', 48),
(732, 'ULA', 48),
(733, 'YATAĞAN', 48),
(734, 'BULANIK', 49),
(735, 'HASKÖY', 49),
(736, 'KORKUT', 49),
(737, 'MALAZGİRT', 49),
(738, 'MERKEZ', 49),
(739, 'VARTO', 49),
(740, 'ACIGÖL', 50),
(741, 'AVANOS', 50),
(742, 'DERİNKUYU', 50),
(743, 'GÜLŞEHİR', 50),
(744, 'HACIBEKTAŞ', 50),
(745, 'KOZAKLI', 50),
(746, 'MERKEZ', 50),
(747, 'ÜRGÜP', 50),
(748, 'ALTUNHİSAR', 51),
(749, 'BOR', 51),
(750, 'ÇAMARDI', 51),
(751, 'ÇİFTLİK', 51),
(752, 'MERKEZ', 51),
(753, 'ULUKIŞLA', 51),
(754, 'AKKUŞ', 52),
(755, 'ALTINORDU', 52),
(756, 'AYBASTI', 52),
(757, 'ÇAMAŞ', 52),
(758, 'ÇATALPINAR', 52),
(759, 'ÇAYBAŞI', 52),
(760, 'FATSA', 52),
(761, 'GÖLKÖY', 52),
(762, 'GÜLYALI', 52),
(763, 'GÜRGENTEPE', 52),
(764, 'İKİZCE', 52),
(765, 'KABADÜZ', 52),
(766, 'KABATAŞ', 52),
(767, 'KORGAN', 52),
(768, 'KUMRU', 52),
(769, 'MESUDİYE', 52),
(770, 'PERŞEMBE', 52),
(771, 'ULUBEY', 52),
(772, 'ÜNYE', 52),
(773, 'BAHÇE', 80),
(774, 'DÜZİÇİ', 80),
(775, 'HASANBEYLİ', 80),
(776, 'KADİRLİ', 80),
(777, 'MERKEZ', 80),
(778, 'SUMBAS', 80),
(779, 'TOPRAKKALE', 80),
(780, 'ARDEŞEN', 53),
(781, 'ÇAMLIHEMŞİN', 53),
(782, 'ÇAYELİ', 53),
(783, 'DEREPAZARI', 53),
(784, 'FINDIKLI', 53),
(785, 'GÜNEYSU', 53),
(786, 'HEMŞİN', 53),
(787, 'İKİZDERE', 53),
(788, 'İYİDERE', 53),
(789, 'KALKANDERE', 53),
(790, 'MERKEZ', 53),
(791, 'PAZAR', 53),
(792, 'ADAPAZARI', 54),
(793, 'AKYAZI', 54),
(794, 'ARİFİYE', 54),
(795, 'ERENLER', 54),
(796, 'FERİZLİ', 54),
(797, 'GEYVE', 54),
(798, 'HENDEK', 54),
(799, 'KARAPÜRÇEK', 54),
(800, 'KARASU', 54),
(801, 'KAYNARCA', 54),
(802, 'KOCAALİ', 54),
(803, 'PAMUKOVA', 54),
(804, 'SAPANCA', 54),
(805, 'SERDİVAN', 54),
(806, 'SÖĞÜTLÜ', 54),
(807, 'TARAKLI', 54),
(808, '19 MAYIS', 55),
(809, 'ALAÇAM', 55),
(810, 'ASARCIK', 55),
(811, 'ATAKUM', 55),
(812, 'AYVACIK', 55),
(813, 'BAFRA', 55),
(814, 'CANİK', 55),
(815, 'ÇARŞAMBA', 55),
(816, 'HAVZA', 55),
(817, 'İLKADIM', 55),
(818, 'KAVAK', 55),
(819, 'LADİK', 55),
(820, 'SALIPAZARI', 55),
(821, 'TEKKEKÖY', 55),
(822, 'TERME', 55),
(823, 'VEZİRKÖPRÜ', 55),
(824, 'YAKAKENT', 55),
(825, 'BAYKAN', 56),
(826, 'ERUH', 56),
(827, 'KURTALAN', 56),
(828, 'MERKEZ', 56),
(829, 'PERVARİ', 56),
(830, 'ŞİRVAN', 56),
(831, 'TİLLO', 56),
(832, 'AYANCIK', 57),
(833, 'BOYABAT', 57),
(834, 'DİKMEN', 57),
(835, 'DURAĞAN', 57),
(836, 'ERFELEK', 57),
(837, 'GERZE', 57),
(838, 'MERKEZ', 57),
(839, 'SARAYDÜZÜ', 57),
(840, 'TÜRKELİ', 57),
(841, 'AKINCILAR', 58),
(842, 'ALTINYAYLA', 58),
(843, 'DİVRİĞİ', 58),
(844, 'DOĞANŞAR', 58),
(845, 'GEMEREK', 58),
(846, 'GÖLOVA', 58),
(847, 'GÜRÜN', 58),
(848, 'HAFİK', 58),
(849, 'İMRANLI', 58),
(850, 'KANGAL', 58),
(851, 'KOYULHİSAR', 58),
(852, 'MERKEZ', 58),
(853, 'SUŞEHRİ', 58),
(854, 'ŞARKIŞLA', 58),
(855, 'ULAŞ', 58),
(856, 'YILDIZELİ', 58),
(857, 'ZARA', 58),
(858, 'AKÇAKALE', 63),
(859, 'BİRECİK', 63),
(860, 'BOZOVA', 63),
(861, 'CEYLANPINAR', 63),
(862, 'EYYÜBİYE', 63),
(863, 'HALFETİ', 63),
(864, 'HALİLİYE', 63),
(865, 'HARRAN', 63),
(866, 'HİLVAN', 63),
(867, 'KARAKÖPRÜ', 63),
(868, 'SİVEREK', 63),
(869, 'SURUÇ', 63),
(870, 'VİRANŞEHİR', 63),
(871, 'BEYTÜŞŞEBAP', 73),
(872, 'CİZRE', 73),
(873, 'GÜÇLÜKONAK', 73),
(874, 'İDİL', 73),
(875, 'MERKEZ', 73),
(876, 'SİLOPİ', 73),
(877, 'ULUDERE', 73),
(878, 'ÇERKEZKÖY', 59),
(879, 'ÇORLU', 59),
(880, 'ERGENE', 59),
(881, 'HAYRABOLU', 59),
(882, 'KAPAKLI', 59),
(883, 'MALKARA', 59),
(884, 'MARMARAEREĞLİSİ', 59),
(885, 'MURATLI', 59),
(886, 'SARAY', 59),
(887, 'SÜLEYMANPAŞA', 59),
(888, 'ŞARKÖY', 59),
(889, 'ALMUS', 60),
(890, 'ARTOVA', 60),
(891, 'BAŞÇİFTLİK', 60),
(892, 'ERBAA', 60),
(893, 'MERKEZ', 60),
(894, 'NİKSAR', 60),
(895, 'PAZAR', 60),
(896, 'REŞADİYE', 60),
(897, 'SULUSARAY', 60),
(898, 'TURHAL', 60),
(899, 'YEŞİLYURT', 60),
(900, 'ZİLE', 60),
(901, 'AKÇAABAT', 61),
(902, 'ARAKLI', 61),
(903, 'ARSİN', 61),
(904, 'BEŞİKDÜZÜ', 61),
(905, 'ÇARŞIBAŞI', 61),
(906, 'ÇAYKARA', 61),
(907, 'DERNEKPAZARI', 61),
(908, 'DÜZKÖY', 61),
(909, 'HAYRAT', 61),
(910, 'KÖPRÜBAŞI', 61),
(911, 'MAÇKA', 61),
(912, 'OF', 61),
(913, 'ORTAHİSAR', 61),
(914, 'SÜRMENE', 61),
(915, 'ŞALPAZARI', 61),
(916, 'TONYA', 61),
(917, 'VAKFIKEBİR', 61),
(918, 'YOMRA', 61),
(919, 'ÇEMİŞGEZEK', 62),
(920, 'HOZAT', 62),
(921, 'MAZGİRT', 62),
(922, 'MERKEZ', 62),
(923, 'NAZIMİYE', 62),
(924, 'OVACIK', 62),
(925, 'PERTEK', 62),
(926, 'PÜLÜMÜR', 62),
(927, 'BANAZ', 64),
(928, 'EŞME', 64),
(929, 'KARAHALLI', 64),
(930, 'MERKEZ', 64),
(931, 'SİVASLI', 64),
(932, 'ULUBEY', 64),
(933, 'BAHÇESARAY', 65),
(934, 'BAŞKALE', 65),
(935, 'ÇALDIRAN', 65),
(936, 'ÇATAK', 65),
(937, 'EDREMİT', 65),
(938, 'ERCİŞ', 65),
(939, 'GEVAŞ', 65),
(940, 'GÜRPINAR', 65),
(941, 'İPEKYOLU', 65),
(942, 'MURADİYE', 65),
(943, 'ÖZALP', 65),
(944, 'SARAY', 65),
(945, 'TUŞBA', 65),
(946, 'ALTINOVA', 77),
(947, 'ARMUTLU', 77),
(948, 'ÇINARCIK', 77),
(949, 'ÇİFTLİKKÖY', 77),
(950, 'MERKEZ', 77),
(951, 'TERMAL', 77),
(952, 'AKDAĞMADENİ', 66),
(953, 'AYDINCIK', 66),
(954, 'BOĞAZLIYAN', 66),
(955, 'ÇANDIR', 66),
(956, 'ÇAYIRALAN', 66),
(957, 'ÇEKEREK', 66),
(958, 'KADIŞEHRİ', 66),
(959, 'MERKEZ', 66),
(960, 'SARAYKENT', 66),
(961, 'SARIKAYA', 66),
(962, 'SORGUN', 66),
(963, 'ŞEFAATLİ', 66),
(964, 'YENİFAKILI', 66),
(965, 'YERKÖY', 66),
(966, 'ALAPLI', 67),
(967, 'ÇAYCUMA', 67),
(968, 'DEVREK', 67),
(969, 'EREĞLİ', 67),
(970, 'GÖKÇEBEY', 67),
(971, 'KİLİMLİ', 67),
(972, 'KOZLU', 67),
(973, 'MERKEZ', 67);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `uid`, `pid`) VALUES
(140, 11, 11),
(147, 11, 63),
(173, 9, 3),
(174, 9, 71),
(175, 9, 89);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `date` date DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `orderid`, `uid`, `pid`, `date`, `status`) VALUES
(5, '5f38db52-2dea-4056-8066-59b900dd4601', 9, 31, '2024-03-24', 1),
(6, 'daebc757-ae3e-4dd8-9b59-c8c5b6fe586e', 9, 31, '2024-03-24', 0),
(7, 'fe980f7d-7a49-48fe-9630-d30107587d05', 9, 31, '2024-03-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `guid` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `fee_cost` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `root_name` varchar(255) NOT NULL,
  `tags` text NOT NULL,
  `description` text NOT NULL,
  `quality` int(11) NOT NULL DEFAULT 0,
  `shipment` int(11) NOT NULL DEFAULT 0,
  `featured` int(11) NOT NULL DEFAULT 0,
  `category` int(11) NOT NULL DEFAULT 0,
  `subcategory` int(11) NOT NULL DEFAULT 0,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `image4` varchar(255) NOT NULL,
  `image5` varchar(255) NOT NULL,
  `image6` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `guid`, `uid`, `name`, `price`, `shipping_cost`, `fee_cost`, `status`, `root_name`, `tags`, `description`, `quality`, `shipment`, `featured`, `category`, `subcategory`, `image1`, `image2`, `image3`, `image4`, `image5`, `image6`) VALUES
(1, 'acee4eae-823c-46f5-b59b-000a4dda816a', 9, 'Sony Walkman', 200.00, 100.00, 19.92, 1, 'sony_walkman', 'sony walkman music player', 'İlk Sony Walkman modeli TPS-L2, 1979 yılında piyasaya sürüldü ve büyük bir başarıya imza attı.\\r\\n\\r\\nOrijinal Walkman alüminyumdan yapılmıştı ve daha sonraki modeller plastikten üretildi. Şaşırtıcı bir şekilde, Walkman, kaset bandından çok daha büyük değildi! Ve sadece çalıcı değil, kulaklık da küçüktü.', 2, 0, 1, 48, 53, '87761_sony_walkman.jpg', '50117_sony_walkman.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(3, '1d593635-0a8f-4eab-b18a-91141b7d7a97', 9, 'Audio-Technica Turntable', 299.99, 39.99, 17.50, 1, 'audio_technica_turntable', 'audio technica record player', 'The Audio-Technica turntable provides high-fidelity audio and is perfect for vinyl enthusiasts. It features a precision tonearm and a durable construction for long-lasting performance.', 2, 0, 1, 48, 55, '62872_audio_technica_turntable.jpg', '58208_audio_technica_turntable.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(5, '2d134f44-e663-451b-bf64-67117959b048', 9, 'Pioneer DJ Controller', 499.99, 49.99, 25.00, 1, 'pioneer_dj_controller', 'pioneer dj mixing console', 'The Pioneer DJ Controller is a professional-grade mixing console for DJs. It offers precise control and a range of effects to enhance your mixing experience. Perfect for both beginners and seasoned DJs.', 2, 0, 1, 48, 53, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(6, 'bdc9dfee-bf97-495f-9e8e-be64313d278b', 9, 'Fender Stratocaster Guitar', 900.00, 50.00, 30.00, 1, 'fender_stratocaster_guitar', 'fender electric guitar gitar', 'The Fender Stratocaster is an iconic electric guitar known for its versatile sound and sleek design. It\\\'s a favorite among musicians in various genres, from rock to blues to pop.', 0, 1, 1, 47, 66, '98741_fender_stratocaster_guitar.jpg', '93596_fender_stratocaster_guitar.jpg', '89261_fender_stratocaster_guitar.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(7, '34dc04c7-57e2-4840-9acb-76997a632196', 9, 'Yamaha Stage Piano', 799.99, 59.99, 20.00, 1, 'yamaha_stage_piano', 'yamaha digital piano', 'The Yamaha Stage Piano is a high-quality digital piano that emulates the sound and feel of an acoustic piano. It\\\'s ideal for both stage performances and studio recordings, offering a wide range of sounds and features. Walkman', 1, 1, 0, 47, 65, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(8, '3c84e722-6c9d-4f57-9962-571576349b8f', 9, 'Bowers & Wilkins Floorstanding Speaker', 1299.99, 69.99, 40.00, 1, 'bowers_&_wilkins_floorstanding_speaker', 'bowers wilkins floorstanding speaker', 'The Bowers & Wilkins Floorstanding Speaker delivers exceptional audio performance with its premium components and craftsmanship. It\\\'s a perfect choice for audiophiles seeking a truly immersive listening experience.', 0, 0, 1, 48, 54, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(9, '30d910c7-4132-4c47-8403-29e403647697', 9, 'Sony Noise-Canceling Headphones', 349.99, 25.99, 15.00, 1, 'sony_noise_canceling_headphones', 'sony headphones noise-cancellation', 'Immerse yourself in your favorite music with Sony\\\'s Noise-Canceling Headphones. Enjoy crystal-clear sound and block out unwanted noise for a superior listening experience on the go.', 0, 0, 0, 50, 60, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(11, '3d9635c8-3b44-4f62-b970-163223d2171a', 9, 'Samsung 4K Smart TV', 999.99, 79.99, 50.00, 1, 'samsung_4k_smart_tv', 'samsung smart television televizyon', 'Yeni Samsung 4K Akıllı Televizyon ile ev eğlencesine yeni bir boyut kazandırın. Üstün görüntü kalitesi, zengin renkler ve akıllı özelliklerle donatılmış bu TV, size sinema salonu deneyimini evinize getiriyor.\\r\\n\\r\\nBu TV\\\'nin en çarpıcı özelliği kesinlikle 4K Ultra HD çözünürlüğüdür. Her bir pikselde inanılmaz detaylarla dolu, kristal berraklığında bir görüntü sunar. Hangi içeriği izlediğiniz önemli değil, her sahne canlı ve gerçekçi bir şekilde hayat bulur.', 2, 1, 1, 31, 81, '93821_samsung_4k_smart_tv.jpg', '81524_samsung_4k_smart_tv.jpg', '83017_samsung_4k_smart_tv.jpg', '13017_samsung_4k_smart_tv.jpg', '74843_samsung_4k_smart_tv.jpg', '96116_samsung_4k_smart_tv.jpg'),
(12, '44162867-affc-4ba7-89fa-c3bb5e1d847a', 9, 'Canon EOS Rebel T7i DSLR Camera', 699.99, 39.99, 25.00, 1, 'canon_eos_rebel_t7i_dslr_camera', 'canon dslr camera', 'Capture life\\\'s moments in stunning detail with Canon EOS Rebel T7i DSLR Camera. It features a 24.2MP sensor and advanced autofocus for professional-quality photos and videos.', 2, 0, 1, 49, 82, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(13, '89dd2840-cd7c-4a67-905e-483c2bfc255f', 9, 'GoPro Hero 9 Black', 449.99, 29.99, 15.00, 1, 'gopro_hero_9_black', 'gopro action camera', 'Record your adventures in crisp 4K resolution with GoPro Hero 9 Black. This rugged action camera is waterproof and features advanced stabilization for smooth footage.', 1, 1, 0, 49, 82, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(14, 'f694f4b1-e017-4fdd-82f4-f1460fae6ebd', 9, 'DJI Mavic Air 2 Drone', 799.99, 49.99, 30.00, 1, 'dji_mavic_air_2_drone', 'dji drone quadcopter', 'Explore the skies and capture breathtaking aerial footage with DJI Mavic Air 2 Drone. This compact quadcopter boasts intelligent features and a powerful camera for stunning results.', 2, 0, 1, 31, 83, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(15, 'bd947dd0-309e-44c1-9ca4-431c3464f994', 9, 'Nintendo Switch Console', 299.99, 19.99, 10.00, 1, 'nintendo_switch_console', 'nintendo gaming console', 'Enter the world of gaming with Nintendo Switch Console. Play at home or on the go with its versatile design and expansive library of games.', 1, 1, 1, 31, 85, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(16, '756ead38-75a4-408b-8bd3-11baa876c8b0', 9, 'Logitech MX Master 3 Mouse', 99.99, 9.99, 5.00, 1, 'logitech_mx_master_3_mouse', 'logitech wireless mouse', 'Enhance your productivity with Logitech MX Master 3 Mouse. This ergonomic wireless mouse offers precision control and customizable buttons for seamless workflow.', 0, 0, 1, 49, 69, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(17, '2e8728d8-71d8-4c62-9ad3-e01ed224b7f6', 9, 'Microsoft Surface Laptop 4', 1299.99, 59.99, 40.00, 1, 'microsoft_surface_laptop_4', 'microsoft laptop computer', 'Experience performance and style with Microsoft Surface Laptop 4. This sleek laptop boasts powerful internals and a vibrant touchscreen display for all-day productivity.', 2, 1, 1, 31, 74, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(18, 'ab3aa9a7-db1a-4819-ab29-fdf0f6c5aeaf', 9, 'Fitbit Versa 3 Smartwatch', 229.99, 14.99, 8.00, 1, 'fitbit_versa_3_smartwatch', 'fitbit fitness tracker', 'Stay active and connected with Fitbit Versa 3 Smartwatch. Track your workouts, monitor your health, and receive notifications on your wrist with this versatile wearable.', 1, 1, 0, 47, 84, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(19, '9c6e963f-df01-403d-bd81-d5287742df4e', 9, 'Anker PowerCore 20000 Portable Charger', 49.99, 7.99, 4.00, 1, 'anker_powercore_20000_portable_charger', 'anker portable power bank', 'Never run out of battery with Anker PowerCore 20000 Portable Charger. This high-capacity power bank keeps your devices charged on the go, so you can stay connected wherever you are.', 0, 0, 1, 50, 60, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(20, '5cf9dccf-c3af-489e-bd64-7196ac603c58', 9, 'Sony PlayStation 5 Console', 499.99, 29.99, 20.00, 1, 'sony_playstation_5_console', 'sony gaming console', 'Experience the next generation of gaming with Sony PlayStation 5 Console. Enjoy stunning visuals, lightning-fast load times, and immersive gameplay with this powerful gaming console.', 2, 1, 1, 31, 85, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(21, '1c08c92c-60ed-4be1-9b5c-2e6840c38e04', 9, 'Razer BlackWidow Elite Keyboard', 169.99, 14.99, 8.00, 1, 'razer_blackwidow_elite_keyboard', 'razer gaming keyboard', 'Dominate your gaming sessions with Razer BlackWidow Elite Mechanical Keyboard. Featuring Razer\\\'s proprietary switches and customizable RGB lighting, this keyboard offers precision and style.', 1, 1, 1, 49, 68, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(22, '82710d0a-d1db-4600-9981-e0690d7b1b9b', 9, 'Samsung Galaxy Tab S7 Tablet', 849.99, 39.99, 25.00, 1, 'samsung_galaxy_tab_s7_tablet', 'samsung android tablet', 'Unleash your creativity and productivity with Samsung Galaxy Tab S7+ Tablet. With its stunning AMOLED display and S Pen support, this tablet is perfect for work and entertainment.', 2, 0, 1, 31, 75, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(23, '117236a2-e453-40c9-9840-c598d9dc53e8', 9, 'Bose QuietComfort 45 Wireless Headphones', 329.99, 25.99, 15.00, 1, 'bose_quietcomfort_45_wireless_headphones', 'bose headphones noise-cancellation', 'Immerse yourself in your music with Bose QuietComfort 45 Wireless Headphones. Enjoy superior sound quality and active noise cancellation for a truly immersive listening experience.', 0, 0, 0, 50, 80, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(24, '13281918-6fcb-47ae-bd2d-1f2d5263d3af', 9, 'Amazon Echo Show 10 (3rd Gen)', 249.99, 19.99, 10.00, 1, 'amazon_echo_show_10_(3rd_gen)', 'amazon smart display', 'Stay connected and organized with Amazon Echo Show 10 (3rd Gen). With its rotating display and built-in Alexa, this smart display is perfect for managing your day and staying entertained.', 1, 1, 1, 48, 59, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(25, '28a1313a-dcef-42eb-b563-442d1abb723f', 9, 'Garmin Fenix 6 Pro Smartwatch', 699.99, 29.99, 15.00, 1, 'garmin_fenix_6_pro_smartwatch', 'garmin fitness tracker', 'Track your fitness and conquer your goals with Garmin Fenix 6 Pro Smartwatch. With advanced GPS and health monitoring features, this smartwatch is built for adventure.', 2, 0, 1, 47, 84, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(26, '637e04e8-f4f8-4bf3-a97a-1dd2de9e7f1d', 9, 'LG UltraGear 27GN950-B Gaming Monitor', 999.99, 49.99, 30.00, 1, 'lg_ultragear_27gn950_b_gaming_monitor', 'lg gaming monitor', 'Immerse yourself in your favorite games with LG UltraGear 27GN950-B Gaming Monitor. Featuring a 4K Nano IPS display and NVIDIA G-Sync compatibility, this monitor delivers smooth visuals and responsive gameplay.', 2, 1, 1, 49, 73, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(27, '9c29585c-4ae6-4853-adaf-9c9265aa1fd5', 9, 'Apple MacBook Pro (M3, 2024)', 83945.00, 100.00, 40.00, 1, 'apple_macbook_pro_(m3,_2024)', 'apple laptop computer macbook mac', 'MacBook Air akıcı bir şekilde çalışmanız ve oyun oynamanız için ihtiyacınız olan gücü sunuyor. Üstelik M3 çip dünyanın en popüler laptopuna şimdi daha da muhteşem beceriler katıyor. Ve 18 saate kadar pil ömrü1 sayesinde MacBook Air\\\'i dilediğiniz yere götürerek her şeyi hızlı bir şekilde yapabiliyorsunuz.\\r\\n\\r\\nSüper hafif ve inanılmaz ince MacBook Air hayatınızın her anında yanınızda olacak şekilde ve gezegenimiz düşünülerek tasarlandı. M3 çipli MacBook Air modellerinin üretiminde kullanılan geri dönüştürülmüş materyallerin oranı yüzde 50’ye ulaştı. Bu, Apple için bir ilk. Ayrıca tüm MacBook Air laptoplar da geri dönüştürülmüş alüminyumdan üretilen dayanıklı kasalara sahip.\\r\\n\\r\\n8 GB birleşik bellek\\r\\n512 GB SSD depolama\\r\\nTrue Tone özelliğine sahip 15.3 inç Liquid Retina ekran\\r\\n1080p FaceTime HD kamera\\r\\nMagSafe 3 şarj bağlantı noktası\\r\\nİki adet Thunderbolt / USB 4 bağlantı noktası\\r\\n35 W Çift USB‑C Bağlantı Noktalı Güç Adaptörü\\r\\nTouch ID özellikli ve arkadan aydınlatmalı Magic Keyboard - Türkçe Q', 2, 1, 1, 31, 74, '19641_apple_macbook_pro_(m1,_2021).jpg', '63627_apple_macbook_pro_(m1,_2021).jpg', '46214_apple_macbook_pro_(m1,_2021).jpg', '33105_apple_macbook_pro_(m1,_2021).jpg', '41884_apple_macbook_pro_(m1,_2021).jpg', 'noimg.jpg'),
(28, '6dcc4f8a-4df0-4abd-93ac-4ab06e7cf3d2', 9, 'Sony Alpha a7 III Mirrorless Camera', 1999.99, 69.99, 40.00, 1, 'sony_alpha_a7_iii_mirrorless_camera', 'sony mirrorless camera', 'Capture life\\\'s moments with stunning clarity using Sony Alpha a7 III Mirrorless Camera. With its full-frame sensor and advanced autofocus system, this camera delivers professional-quality results.', 2, 1, 1, 49, 82, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(29, '705e7529-9490-4907-b7c0-36728a59f0cb', 9, 'Dell XPS 13 Laptop', 1299.99, 49.99, 30.00, 1, 'dell_xps_13_laptop', 'dell laptop computer', 'Stay productive on the go with Dell XPS 13 Laptop. Featuring a stunning InfinityEdge display and powerful performance, this laptop is perfect for work and entertainment.', 2, 1, 0, 31, 74, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(30, '858fcebb-e61f-43e7-adef-ffb698fda478', 9, 'SteelSeries Arctis 7 Gaming Headset', 149.99, 9.99, 5.00, 1, 'steelseries_arctis_7_gaming_headset', 'steelseries gaming headset', 'Immerse yourself in your favorite games with SteelSeries Arctis 7 Wireless Gaming Headset. Featuring lag-free wireless audio and a retractable microphone, this headset offers comfort and performance for long gaming sessions.', 1, 1, 1, 50, 60, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(31, '4eca7766-face-43e5-90b1-9edf028c81ee', 9, 'Sony WH-1000XM4 Wireless Headphones', 349.99, 25.99, 15.00, 1, 'sony_wh_1000xm4_wireless_headphones', 'sony headphones noise-cancellation', 'Experience premium sound quality and active noise cancellation with Sony WH-1000XM4 Wireless Headphones. Perfect for music lovers and travelers seeking immersive audio.', 0, 1, 1, 50, 80, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(32, 'e733c5ec-d5ce-46a7-b40c-4edb9245c511', 9, 'Logitech G Pro X Wireless Gaming Mouse', 149.99, 9.99, 5.00, 1, 'logitech_g_pro_x_wireless_gaming_mouse', 'logitech gaming mouse', 'Gain a competitive edge with Logitech G Pro X Wireless Gaming Mouse. Featuring advanced sensor technology and customizable buttons, this mouse delivers precision and performance for gamers.', 1, 1, 1, 49, 69, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(33, '63d4f6ff-b90c-4ad6-ad08-d5f03efa5a1e', 9, 'Apple Watch Series 7', 399.99, 19.99, 10.00, 1, 'apple_watch_series_7', 'apple smartwatch', 'Stay connected and active with Apple Watch Series 7. With its advanced health tracking features and vibrant display, this smartwatch is your perfect everyday companion.', 2, 1, 0, 47, 84, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(34, 'cca83d86-04bc-4b6e-8e7b-9227c99230be', 9, 'Microsoft Xbox Series X Console', 599.99, 29.99, 20.00, 1, 'microsoft_xbox_series_x_console', 'microsoft gaming console', 'Immerse yourself in the ultimate gaming experience with Microsoft Xbox Series X Console. With powerful hardware and lightning-fast load times, this console delivers smooth and responsive gameplay.', 2, 1, 1, 31, 85, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(35, '3bea9ed6-d813-4f0a-bf3b-50929e56c98a', 9, 'Samsung Odyssey G7 Gaming Monitor', 699.99, 39.99, 25.00, 1, 'samsung_odyssey_g7_gaming_monitor', 'samsung gaming monitor', 'Elevate your gaming setup with Samsung Odyssey G7 Gaming Monitor. Featuring a curved QLED display and rapid refresh rate, this monitor delivers immersive visuals and smooth gameplay.', 2, 1, 1, 48, 59, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(36, '76b8dd59-3767-488a-b303-21f4e8d3c63d', 9, 'Sony WH-CH710N Wireless Headphones', 199.99, 14.99, 8.00, 1, 'sony_wh_ch710n_wireless_headphones', 'sony wireless headphones', 'Enjoy clear sound and all-day comfort with Sony WH-CH710N Wireless Headphones. With built-in noise cancellation and long battery life, these headphones are perfect for everyday use.', 1, 1, 0, 50, 60, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(37, '7b16638b-6e7e-4dc5-8a8d-3fc43b030c71', 9, 'LG OLED C1 Series 4K TV', 1999.99, 69.99, 40.00, 1, 'lg_oled_c1_series_4k_tv', 'lg oled television', 'Experience breathtaking visuals with LG OLED C1 Series 4K TV. Featuring OLED technology and AI-enhanced picture quality, this TV delivers stunning realism and vibrant colors.', 2, 1, 1, 31, 81, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(38, '7de9d5d7-95d3-4312-800a-29cded05a431', 9, 'Canon EOS R5 Mirrorless Camera', 3899.99, 79.99, 50.00, 1, 'canon_eos_r5_mirrorless_camera', 'canon mirrorless camera', 'Unlock your creative potential with Canon EOS R5 Mirrorless Camera. With its high-resolution sensor and advanced autofocus, this camera delivers professional-quality photos and videos.', 2, 0, 1, 49, 82, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(39, 'e5c5dfd3-ad20-4f9b-96cb-00d0772725d7', 9, 'Nintendo Switch Pro Controller', 69.99, 9.99, 5.00, 1, 'nintendo_switch_pro_controller', 'nintendo gaming controller', 'Enhance your gaming experience with Nintendo Switch Pro Controller. Featuring ergonomic design and motion controls, this controller offers precise and comfortable gameplay.', 1, 1, 1, 31, 85, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(40, 'bdc288c6-a189-48e1-9bd3-5b16d384a382', 9, 'Bose Frames Audio Sunglasses', 249.99, 19.99, 10.00, 1, 'bose_frames_audio_sunglasses', 'bose audio sunglasses', 'Listen to your favorite music in style with Bose Frames Audio Sunglasses. With built-in speakers and premium lenses, these sunglasses deliver immersive sound without compromising on fashion.', 1, 1, 0, 50, 60, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(41, '60f8ad56-5144-4a9d-9b14-580b7b716565', 9, 'GoPro HERO10 Black Action Camera', 499.99, 29.99, 20.00, 1, 'gopro_hero10_black_action_camera', 'gopro action camera', 'Capture stunning action shots with the GoPro HERO10 Black Action Camera. Featuring HyperSmooth stabilization and 5.3K video recording, this camera delivers smooth and high-quality footage.', 2, 1, 1, 49, 82, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(42, '41942901-87ed-40e5-8022-4bf724e7d1eb', 9, 'Anker Soundcore Liberty Air 2 Pro Earbuds', 129.99, 9.99, 5.00, 1, 'anker_soundcore_liberty_air_2_pro_earbuds', 'anker wireless earbuds', 'Immerse yourself in your music with Anker Soundcore Liberty Air 2 Pro Earbuds. Featuring targeted active noise cancellation and personalized sound profiles, these earbuds offer a truly customized listening experience.', 1, 1, 1, 50, 60, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(43, '22d190f2-b8f7-49a4-9dbb-e5dbbf8e90e1', 9, 'DJI Mavic Air 2 Drone', 799.99, 39.99, 25.00, 1, 'dji_mavic_air_2_drone', 'dji drone', 'Explore the skies and capture breathtaking aerial footage with DJI Mavic Air 2 Drone. With intelligent shooting modes and obstacle avoidance technology, this drone is perfect for both beginners and experienced pilots.', 2, 1, 1, 31, 83, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(44, '77718d27-1527-40d0-b058-14a2cdb3bbbe', 9, 'Samsung Galaxy Buds Pro Earbuds', 199.99, 14.99, 8.00, 1, 'samsung_galaxy_buds_pro_earbuds', 'samsung wireless earbuds', 'Enjoy crystal-clear sound and intelligent ANC with Samsung Galaxy Buds Pro Earbuds. With 360 Audio and IPX7 water resistance, these earbuds are perfect for immersive listening anywhere.', 1, 1, 0, 50, 60, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(45, 'd1e06e01-7261-40d3-b18d-419265b0b6e1', 9, 'Sony A8H OLED 4K TV', 2499.99, 69.99, 40.00, 1, 'sony_a8h_oled_4k_tv', 'sony oled television', 'Experience stunning visuals and immersive sound with Sony A8H OLED 4K TV. Featuring Acoustic Surface Audio and Dolby Vision HDR, this TV delivers cinematic entertainment in the comfort of your home.', 2, 1, 1, 31, 81, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(46, '5dcf4631-2ede-4819-929e-37f86eb304ff', 9, 'Corsair K95 RGB Platinum XT Keyboard', 199.99, 14.99, 8.00, 1, 'corsair_k95_rgb_platinum_xt_keyboard', 'corsair gaming keyboard', 'Dominate your gaming sessions with Corsair K95 RGB Platinum XT Mechanical Keyboard. Featuring Cherry MX switches and customizable RGB lighting, this keyboard offers precision and style.', 1, 1, 1, 49, 68, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(47, '8c8236b2-f3e8-4b91-abc7-6fbc744e51e5', 9, 'Apple AirPods Max Wireless Headphones', 549.99, 25.99, 15.00, 1, 'apple_airpods_max_wireless_headphones', 'apple wireless headphones', 'Experience high-fidelity audio and adaptive EQ with Apple AirPods Max Wireless Headphones. With active noise cancellation and spatial audio, these headphones deliver a truly immersive listening experience.', 2, 1, 1, 50, 80, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(48, '5ede4482-6aa9-4682-865b-a62c4d3c18be', 9, 'Microsoft Surface Pro 8 Tablet', 1099.99, 49.99, 30.00, 1, 'microsoft_surface_pro_8_tablet', 'microsoft windows tablet', 'Stay productive on the go with Microsoft Surface Pro 8 Tablet. Featuring a vibrant PixelSense display and powerful performance, this tablet is perfect for work and creativity.', 2, 1, 0, 31, 75, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(49, 'd5031ae7-4a1b-4db0-b585-de2ed10b8930', 9, 'Logitech C920 HD Pro Webcam', 79.99, 9.99, 5.00, 1, 'logitech_c920_hd_pro_webcam', 'logitech webcam', 'Stay connected with crystal-clear video quality using Logitech C920 HD Pro Webcam. With full HD 1080p resolution and autofocus, this webcam delivers professional-quality video calls and streaming.', 1, 1, 0, 49, 82, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(50, '4872603c-92fc-477c-bda6-28882867e4eb', 9, 'JBL Flip 5 Portable Bluetooth Speaker', 119.99, 9.99, 5.00, 1, 'jbl_flip_5_portable_bluetooth_speaker', 'jbl portable speaker', 'Take your music anywhere with JBL Flip 5 Portable Bluetooth Speaker. Featuring powerful bass and IPX7 waterproof rating, this speaker is perfect for outdoor adventures and parties.', 1, 1, 0, 48, 54, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(51, '3285d40e-1b8c-4914-afb2-a2121b86a116', 9, 'Sennheiser HD 660 S Open-Back Headphones', 499.99, 25.99, 15.00, 1, 'sennheiser_hd_660_s_open-back_headphones', 'sennheiser open-back headphones', 'Experience audiophile-grade sound quality with Sennheiser HD 660 S Open-Back Headphones. Featuring high-resolution drivers and open-back design, these headphones deliver natural and spacious sound.', 2, 1, 1, 50, 60, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(52, 'bed20078-82d1-4813-9283-beb2fbb5c9e1', 9, 'Sony Xperia 1 III Smartphone', 1299.99, 29.99, 20.00, 1, 'sony_xperia_1_iii_smartphone', 'sony android smartphone', 'Experience photography and entertainment like never before with Sony Xperia 1 III Smartphone. Featuring a 4K OLED display and professional-grade camera system, this smartphone is perfect for multimedia enthusiasts.', 2, 1, 1, 31, 77, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(53, 'acbf8033-adf3-4042-98e9-7584e1c68213', 9, 'Razer DeathAdder V2 Gaming Mouse', 69.99, 9.99, 5.00, 1, 'razer_deathadder_v2_gaming_mouse', 'razer gaming mouse', 'Dominate your gaming sessions with Razer DeathAdder V2 Gaming Mouse. Featuring Razer Optical Switches and 20K DPI sensor, this mouse offers precision and speed for competitive gaming.', 1, 1, 1, 49, 69, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(54, 'b5edb459-e25d-4b80-acba-bf548a58bf41', 9, 'Bose SoundLink Color Bluetooth Speaker II', 129.99, 9.99, 5.00, 1, 'bose_soundlink_color_bluetooth_speaker_ii', 'bose portable speaker', 'Enjoy your favorite music on the go with Bose SoundLink Color Bluetooth Speaker II. With rugged design and bold sound, this speaker is perfect for outdoor adventures and parties.', 1, 1, 0, 48, 54, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(55, 'd6c3eabb-8394-48be-a4b9-130e5c15c405', 9, 'Apple iPad Air (4th Gen)', 599.99, 19.99, 10.00, 1, 'apple_ipad_air_(4th_gen)', 'apple tablet computer', 'Unlock your creativity and productivity with Apple iPad Air (4th Gen). Featuring a stunning Liquid Retina display and powerful A14 Bionic chip, this tablet is perfect for work and entertainment.', 2, 1, 0, 31, 75, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(56, 'fc0575ea-d4fb-47a2-ad57-d79006410136', 9, 'Logitech G Pro X Gaming Headset', 129.99, 9.99, 5.00, 1, 'logitech_g_pro_x_gaming_headset', 'logitech gaming headset', 'Immerse yourself in your games with Logitech G Pro X Gaming Headset. Featuring Blue VO!CE technology and PRO-G 50mm drivers, this headset delivers professional-grade sound and comfort.', 1, 1, 1, 50, 60, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(57, 'c60066ce-3f1c-4ba8-97eb-203bd2872cab', 9, 'Samsung Galaxy Watch 4 Classic', 349.99, 19.99, 10.00, 1, 'samsung_galaxy_watch_4_classic', 'samsung smartwatch', 'Stay connected and track your fitness with Samsung Galaxy Watch 4 Classic. Featuring advanced health monitoring and stylish design, this smartwatch is your perfect companion for a healthy lifestyle.', 2, 1, 0, 47, 84, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(59, 'ef9ccd81-c11d-401a-beec-33cb49ec7427', 9, 'Google Pixel 6 Pro Smartphone', 899.99, 29.99, 20.00, 1, 'google_pixel_6_pro_smartphone', 'google android smartphone', 'Experience the power of Google Pixel 6 Pro Smartphone. Featuring advanced camera technology and 120Hz display, this smartphone delivers stunning photos and smooth performance.', 0, 1, 1, 31, 77, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(60, '5bc66a66-e248-40dc-b7a8-02f5dbe2e247', 9, 'JBL Quantum 800 Wireless Gaming Headset', 199.99, 14.99, 8.00, 1, 'jbl_quantum_800_wireless_gaming_headset', 'jbl gaming headset', 'Immerse yourself in your games with JBL Quantum 800 Wireless Gaming Headset. Featuring 50mm drivers and active noise cancellation, this headset delivers immersive sound and comfort for long gaming sessions.', 1, 1, 1, 50, 80, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(61, '183ce616-63c0-4ee6-8e02-c90c638c3ab7', 9, 'Sony WH-1000XM4 Wireless Headphones', 349.99, 19.99, 10.00, 1, 'sony_wh_1000xm4_wireless_headphones', 'sony wireless headphones', 'Immerse yourself in your music with Sony WH-1000XM4 Wireless Noise-Canceling Headphones. Featuring industry-leading noise cancellation and high-resolution audio, these headphones offer a premium listening experience.', 2, 1, 1, 50, 80, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(62, '3eef620c-237e-4961-a0e9-9c01ff18a7e2', 9, 'Canon EOS R5 Mirrorless Camera', 3899.99, 49.99, 30.00, 1, 'canon_eos_r5_mirrorless_camera', 'canon mirrorless camera', 'Capture stunning images and 8K videos with the Canon EOS R5 Mirrorless Camera. With advanced autofocus and in-body image stabilization, this camera delivers professional-quality results for both photography and videography.', 2, 1, 1, 48, 54, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(63, '0d84a8f6-1768-433d-a01a-364e3734321a', 9, 'Bose QuietComfort Earbuds', 279.99, 14.99, 8.00, 1, 'bose_quietcomfort_earbuds', 'bose wireless earbuds', 'Enjoy peace and quiet wherever you go with Bose QuietComfort Earbuds. With active noise cancellation and comfortable ear tips, these earbuds let you focus on your music or calls without distractions.', 1, 1, 1, 50, 60, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(64, '0bd5de67-df7f-4d36-9fb9-c781492d8ea3', 9, 'LG OLED C1 4K TV', 1999.99, 69.99, 40.00, 1, 'lg_oled_c1_4k_tv', 'lg oled television', 'Experience cinematic entertainment at home with LG OLED C1 4K TV. Featuring self-lit pixels and Dolby Atmos sound, this TV delivers lifelike visuals and immersive audio for an unparalleled viewing experience.', 2, 1, 1, 31, 81, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(65, 'eff8d8d8-1390-42d0-93e3-fcf9bd29bd9a', 9, 'Razer BlackWidow V3 Gaming Keyboard', 139.99, 14.99, 8.00, 1, 'razer_blackwidow_v3_gaming_keyboard', 'razer gaming keyboard', 'Enhance your gaming setup with Razer BlackWidow V3 Mechanical Gaming Keyboard. Featuring Razer Green switches and customizable Chroma RGB lighting, this keyboard offers tactile feedback and personalization options for immersive gaming experiences.', 1, 1, 1, 49, 68, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(66, 'ed75e5d6-48d2-4b97-b79d-145ba4c27a9e', 9, 'Apple iPad Pro (5th Generation)', 899.99, 49.99, 30.00, 1, 'apple_ipad_pro_(5th_generation)', 'apple ipad', 'Unleash your creativity and productivity with the Apple iPad Pro (5th Generation). Featuring the M1 chip and ProMotion technology, this iPad offers power and versatility for work, entertainment, and creativity.', 2, 1, 1, 31, 75, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(67, '223341a4-c418-428f-a0a5-d76e71d5851d', 9, 'Nikon Z7 II Mirrorless Camera', 2999.99, 39.99, 25.00, 1, 'nikon_z7_ii_mirrorless_camera', 'nikon mirrorless camera', 'Capture every detail with the Nikon Z7 II Mirrorless Camera. Featuring dual EXPEED 6 processors and 45.7MP resolution, this camera delivers exceptional image quality and performance for professional photographers.', 2, 1, 1, 49, 82, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(68, '159f3419-8492-48dc-a25e-e9cf3fbb8153', 9, 'Sennheiser 3 Wireless Headphones', 399.99, 19.99, 10.00, 1, 'sennheiser_3_wireless_headphones', 'sennheiser wireless headphones', 'Experience premium sound quality and active noise cancellation with Sennheiser Momentum 3 Wireless Headphones. With genuine leather ear pads and intuitive controls, these headphones offer comfort and convenience for all-day listening.', 2, 1, 1, 50, 80, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(69, '6c2b2be1-a18a-4f88-a555-7a5d62d16ca5', 9, 'Dell XPS 15 Laptop', 1999.99, 49.99, 30.00, 1, 'dell_xps_15_laptop', 'dell laptop', 'Power through your tasks with the Dell XPS 15 Laptop. Featuring a stunning InfinityEdge display and powerful performance, this laptop is perfect for professionals and content creators.', 2, 1, 1, 31, 74, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(70, '5d028445-489e-43ff-897b-4bfe98198b75', 9, 'Ultimate Ears Boom 3 Bluetooth Speaker', 149.99, 9.99, 5.00, 1, 'ultimate_ears_boom_3_bluetooth_speaker', 'ultimate ears portable speaker', 'Bring the party anywhere with Ultimate Ears Boom 3 Portable Bluetooth Speaker. Featuring 360-degree sound and waterproof construction, this speaker delivers immersive audio and durability for outdoor adventures.', 1, 1, 0, 48, 54, 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg', 'noimg.jpg'),
(71, 'adbebcdf-1c9f-4ce5-9e88-b75eae6780cb', 9, ' GeForce RTX™ 4090 VENTUS 3X E 24G OC', 72189.00, 250.00, 0.00, 1, '_geforce_rtx™_4090_ventus_3x_e_24g_oc', 'msi, gpu, ekran karti, rtx, 4090', 'VENTUS, performans odaklı bir grafik kartı arayan kullanıcılara temelde sağlam bir deneyim sunuyor. TORX FAN 4.0 ve Hava Akışı Kontrolü ile güncellenmiş keskin bir tasarımı olan VENTUS, herhangi bir görevi kolayca halletmesini sağlıyor.\\r\\n\\r\\nDLSS 3 ile güçlendirilmiş yapay zeka destekli grafiklerle performans, verimlilik ve AI\\\'da büyük bir sıçrama sunuyor. Ultra yüksek performanslı oyun deneyimleyin, ışın izleme ile inanılmaz detaylı sanal dünyalar keşfedin, eşi benzeri görülmemiş verimlilik elde edin ve yeni yaratma yolları keşfedin. NVIDIA Ada Lovelace mimarisi tarafından desteklenmektedir ve oyuncular ve yaratıcılar için en üst düzey deneyimi sunmak için 24 GB G6X bellekle birlikte gelir.\\r\\n\\r\\nArtırılmış Saat Hızı / Bellek Hızı\\r\\n2550 MHz / 21 Gbps\\r\\n24GB GDDR6X\\r\\nDisplayPort x 2 (v1.4a)\\r\\nHDMI™ x 2 (4K@120Hz HDR, 8K@60Hz HDR ve HDMI™ 2.1a\\\'da belirtildiği gibi Değişken Yenileme Hızını destekler)\\r\\nÜçlü Fanlı Termal Tasarım\\r\\nTORX Fan 4.0: Ekip çalışmasının bir şaheseri, fan kanatları çiftler halinde çalışarak odaklanmış hava basıncı seviyeleri yaratır.\\r\\nHava Akışı Kontrolü: Endişelenmeyin, Hava Akışı Kontrolü havayı maksimum soğutma için tam olarak ihtiyaç duyulan yere yönlendirir.\\r\\nÇekirdek Borusu: Hassas şekilde işlenmiş ısı boruları GPU ile maksimum teması sağlar ve ısıyı soğutucunun tam uzunluğu boyunca yayılır.\\r\\nSıfır Don: Fanlar sıcaklıklar nispeten düşük olduğunda tamamen durur, böylece tüm gürültüyü ortadan kaldırır.\\r\\nMetal Arka Plaka\\r\\nSağlam akış-through metal arka plakanın altındaki termal pedler soğutma konusunda yardımcı olur.\\r\\nMSI Center\\r\\nÖzel MSI Center yazılımı ile MSI ürünlerini gerçek zamanlı olarak izleyebilir, ayarlayabilir ve optimize edebilirsiniz.', 0, 1, 1, 49, 72, '62839_geforce_rtx™_4090_ventus_3x_e_24g_oc.jpg', '50279_geforce_rtx™_4090_ventus_3x_e_24g_oc.jpg', '54148_geforce_rtx™_4090_ventus_3x_e_24g_oc.jpg', '53915_geforce_rtx™_4090_ventus_3x_e_24g_oc.jpg', '70785_geforce_rtx™_4090_ventus_3x_e_24g_oc.jpg', '54615_geforce_rtx™_4090_ventus_3x_e_24g_oc.jpg'),
(78, '1240ee1d-9b47-45c5-b3bc-7bcc44462938', 9, 'Patriot Viper 16 GB Ram (2x8) 3200 Mhz', 1659.00, 318.00, 0.00, 1, 'patriot_viper_16_gb_ram_(2x8)_3200_mhz', 'ram, bellek, 16gb, 2x8gb, patriot viper', 'Kapasite: 16 GB (2 x 8 GB) DDR4\\r\\nBaz Frekansı: PC4-17000 (2133MHz); XMP 2.0 etkinken PC4-25600\\\'e (3200MHz) kadar\\r\\nTemel Zamanlamalar: 15-15-15-36; XMP 2.0 etkinken hız aşırtma zamanlaması Test Edilen Zamanlamalar: 16-18-18-16\\r\\nUYUMLULUK: En son Intel ve AMD platformlarında test edildi\\r\\nÖzel tasarım ve seri: Elmas kesim engerek logolu ve siyah üst kısmı olan tunç gri kenarlara sahip tüm alüminyum ısı kalkanı', 0, 0, 1, 49, 86, '20115_patriot_viper_steel_series_ddr4_16gb_(2_x_8gb)_3200mhz.jpg', '56484_patriot_viper_steel_series_ddr4_16gb_(2_x_8gb)_3200mhz.jpg', '54893_patriot_viper_steel_series_ddr4_16gb_(2_x_8gb)_3200mhz.jpg', '45007_patriot_viper_steel_series_ddr4_16gb_(2_x_8gb)_3200mhz.jpg', '60483_patriot_viper_steel_series_ddr4_16gb_(2_x_8gb)_3200mhz.jpg', '25831_patriot_viper_steel_series_ddr4_16gb_(2_x_8gb)_3200mhz.jpg'),
(87, '49b3eebf-ddda-44dd-b531-b96021efd9c0', 9, 'Intel Core i9-14900K 24 Çekirdek 6 GHz', 19901.79, 100.00, 0.00, 1, 'intel_core_i9_14900k_24_cekirdek_6_ghz', 'i9 islemci intel core 14900k pc', 'Intel Core i9-14900K (14. Gen) masaüstü işlemci.\\r\\nIntel Thermal Speed Boost, Intel Turbo Boost Max Technology 3.0 ve PCIe 5.0 & 4.0 desteği, DDR5 ve DDR4 desteğine sahiptir.\\r\\nUnlocked 14th Gen Intel Core i9 masaüstü işlemciler hevesli oyuncular ve ciddi yaratıcılar için optimize edilmiştir ve yüksek performans sunmaya yardımcı olur.\\r\\nIntel 700 Serisi ve Intel 600 Serisi Chipset tabanlı anakartlarla uyumludur.\\r\\n125 W işlemci taban gücü.', 0, 1, 1, 49, 78, '76755_intel®_core™_i9_14900k_masaustu_islemci_24_cekirdekli_(8_p_cekirdekli_+_16_e_cekirdek)_6.0_ghz.jpg', '27850_intel®_core™_i9_14900k_masaustu_islemci_24_cekirdekli_(8_p_cekirdekli_+_16_e_cekirdek)_6.0_ghz.jpg', '98440_intel®_core™_i9_14900k_masaustu_islemci_24_cekirdekli_(8_p_cekirdekli_+_16_e_cekirdek)_6.0_ghz.jpg', '92646_intel®_core™_i9_14900k_masaustu_islemci_24_cekirdekli_(8_p_cekirdekli_+_16_e_cekirdek)_6.0_ghz.jpg', 'noimg.jpg', 'noimg.jpg'),
(89, 'abe6b8da-dc91-4a80-be7f-bb84757f4596', 9, 'AirPods Pro (2. nesil) ve MagSafe Şarj Kutusu (USB-C)', 7790.83, 1.00, 0.00, 1, 'airpods_pro_(2._nesil)_ve_magsafe_sarj_kutusu_(usb_c)', 'Kulaklık Kablosuz Bluetooth Gürültü engelleme Aktif Siri Hassasiyet Şarj kutusu Tasarım Su direnci Mikrofon Pil ömrü', 'Değişimin sesi\\r\\nEtrafınızda olup bitenlerle bağlantıda kalmanızı sağlayan Şeffaf mod ve bulunduğunuz ortama göre dinamik olarak gürültü denetimi yapan yepyeni Adaptif Ses özelliğiyle USB‑C özellikli AirPods Pro (2. nesil), önceki nesle¹ kıyasla 2 kat daha fazla Aktif Gürültü Engelleme sunuyor.¹⁶ Sohbet Farkındalığı, dinlediğiniz medyanın sesini kısıp başkalarıyla etkileşime geçtiğinizde karşınızdan gelen sesleri daha net duymanıza imkan tanıyor.¹⁶ Tek şarj, 6 saate kadar pil ömrü sağlıyor.⁷ Dokunmatik denetim, tek bir kaydırma hareketiyle sesi ayarlamanızı sağlıyor. Ve MagSafe Şarj Kutusu; Tam Konum Bulma¹⁵ özelliği, yerleşik hoparlörü ve askısıyla˄ başlı başına muhteşem.\\r\\n\\r\\nÜstün ses kalitesi\\r\\nYeni nesil H2 çip, daha akıllı gürültü engelleme özelliğine ve üç boyutlu seslere güç sağlıyor. Adaptif EQ, müziği gerçek zamanlı olarak kulağınızın şekline göre ayarlayarak yüksek notaları temiz ve net, basları ise derin, zengin ve olağanüstü berraklıkta veriyor.\\r\\n\\r\\nAkıllı ses\\r\\nAktif Gürültü Engelleme özelliği, istenmeyen gürültüleri iki kat daha fazla engelliyor. Bu sayede, işe gidip gelirken ve odaklanmanız gerektiğinde hiçbir şey, dinleme deneyiminizi kesintiye uğratamıyor.¹ Şeffaf mod, gürültü yoğunluğunu saniyede 48.000 kez azaltıp ayarlıyor, böylece etrafınızda olup bitenleri rahatça duyabiliyorsunuz. Şeffaf ve Aktif Gürültü Engelleme modlarını dinamik olarak birleştiren Adaptif Ses¹⁶, bulunduğunuz her ortamda en iyi dinleme deneyimini sunuyor.\\r\\n\\r\\nKişiselleştirilmiş dinleme deneyimi\\r\\nTamamen size özel bir dinleme deneyimi. İdeal bir akustik yalıtım ve kulağınızla mükemmel uyum için dört farklı boydaki (XS, S, M, L) esnek silikon kulaklık uçlarından dilediğinizi seçin. Kişiselleştirilmiş Ses Yüksekliği, zaman içerisindeki dinleme tercihlerinize ve bulunduğunuz farklı ortamlara göre sesi ayarlıyor.¹⁶ Konuşma Farkındalığı, çalan içeriğin ses düzeyini kısıyor, önünüzden gelen sesleri yükseltiyor ve arka plan gürültüsünü azaltıyor.¹⁶ Dinamik kafa izleme özellikli Kişiselleştirilmiş Uzamsal Ses, ses unsurlarını etrafınıza hassas bir şekilde yerleştirerek dinleme deneyimini daha da kişisel hale getiriyor.º Adaptif EQ, müziği kulağınızın şekline göre ayarlayarak sesleri her zaman aynı şekilde, ayrıntılı olarak duymanızı mümkün kılıyor.\\r\\n\\r\\nDaha fazla pil ömrü\\r\\nTek şarjla 6 saate kadar, MagSafe Şarj Kutusu ile toplamda 30 saate kadar dinleme süresinin keyfini çıkarın.¹⁰ MagSafe Şarj Kutusu’nu Apple Watch şarj aygıtıyla veya MagSafe şarj aygıtıyla şarj edin. Dilerseniz bir USB-C konnektörü veya Qi sertifikalı şarj aygıtı da kullanabiliyorsunuz.\\r\\n\\r\\nHer zamankinden daha sihirli\\r\\nAirPods Pro (2. nesil) ve MagSafe Şarj Kutusu (USB-C), ilk modele kıyasla daha da rahat bir deneyim sunuyor. Dokunmatik Denetim sayesinde çalma işlevlerini kulaklığın alt ucundan rahatça kontrol edin ve ses düzeyini parmağınızı hafifçe yukarı veya aşağı kaydırarak ayarlayın. Siri, Bildirimleri Seslendir özelliğini kullanarak önemli mesajları ve uyarıları, geldikleri an size okusun.³ Ses Paylaşımı özelliğiyle iki çift AirPods üzerinden herhangi bir şarkıyı veya TV programını kolayca paylaşın.⁴ Ayrıca her zaman olduğu gibi AirPods Pro, iPhone’unuza veya Apple Watch’unuza sihirli bir şekilde bağlanıyor ve bir Apple aygıtından diğerine geçtiğinizde ses de kusursuz bir şekilde yeni aygıta geçiyor.', 0, 1, 0, 50, 79, '25624_airpods_pro_(2._nesil)_ve_magsafe_sarj_kutusu_(usb_c).jpg', '17983_airpods_pro_(2._nesil)_ve_magsafe_sarj_kutusu_(usb_c).jpg', '77042_airpods_pro_(2._nesil)_ve_magsafe_sarj_kutusu_(usb_c).jpg', '38786_airpods_pro_(2._nesil)_ve_magsafe_sarj_kutusu_(usb_c).jpg', '80656_airpods_pro_(2._nesil)_ve_magsafe_sarj_kutusu_(usb_c).jpg', '29936_airpods_pro_(2._nesil)_ve_magsafe_sarj_kutusu_(usb_c).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `question` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `uid`, `pid`, `question`, `date`, `status`) VALUES
(37, 11, 11, 'Merhaba, bu urunun yaninda kumandasi ve uydusu geliyor mu acaba?', '2024-03-22', 0),
(38, 9, 11, 'Ikinci el mi bu urun', '2024-03-22', 0),
(67, 9, 27, 'Yazilim icin arkadasima hediye almayi dusunuyorum, uygun mudur', '2024-03-23', 0),
(71, 9, 71, 'Mining de kullanilir mi?', '2024-03-24', 0),
(72, 11, 71, 'GTA 5 acar mi abi', '2024-03-27', 0),
(76, 9, 27, 'deneme sorusu', '2024-04-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `site`
--

CREATE TABLE `site` (
  `id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site`
--

INSERT INTO `site` (`id`, `keyword`, `value`) VALUES
(1, 'maintenance', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `subcats`
--

CREATE TABLE `subcats` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcats`
--

INSERT INTO `subcats` (`id`, `cid`, `name`, `slug`) VALUES
(0, 0, 'Kategorisiz', 'kategorisiz'),
(53, 48, 'Müzik Çalar', 'muzik-calar'),
(54, 48, 'Hoparlör', 'hoparlor'),
(55, 48, 'Pikap & Plak Çalar', 'pikap-%2526-plak-calar'),
(59, 48, 'Tam Müzik Seti', 'tam-muzik-seti'),
(60, 50, 'Kablolu Kulaklık', 'kablolu-kulaklik'),
(65, 47, 'Piyano', 'piyano'),
(66, 47, 'Gitar', 'gitar'),
(68, 49, 'Klavye', 'klavye'),
(69, 49, 'Fare', 'fare'),
(70, 47, 'Org', 'org'),
(72, 49, 'Ekran Kartı', 'ekran-karti'),
(73, 49, 'Monitor', 'monitor'),
(74, 31, 'Laptop', 'laptop'),
(75, 31, 'Tablet', 'tablet'),
(76, 31, 'Bilgisayar', 'bilgisayar'),
(77, 31, 'Telefon', 'telefon'),
(78, 49, 'İşlemci', 'islemci'),
(79, 50, 'Bluetooth Kulaklık', 'bluetooth-kulaklik'),
(80, 50, 'Kablosuz Kulaklık', 'kablosuz-kulaklik'),
(81, 31, 'Televizyon', 'televizyon'),
(82, 49, 'Kamera', 'kamera'),
(83, 31, 'Drone', 'drone'),
(84, 47, 'Akıllı Saat', 'akilli-saat'),
(85, 31, 'Konsol', 'konsol'),
(86, 49, 'Bellek (Ram)', 'bellek-%2528ram%2529'),
(87, 49, 'SSD', 'ssd'),
(88, 49, 'Harddisk', 'harddisk'),
(89, 49, 'Anakart', 'anakart'),
(91, 47, 'Bateri', 'bateri');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `verified` int(11) NOT NULL DEFAULT 0,
  `membership` int(11) NOT NULL DEFAULT 0,
  `token` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL DEFAULT 'nopp.png',
  `last_submission` int(11) NOT NULL,
  `submissions` int(11) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` int(11) NOT NULL,
  `district` int(11) NOT NULL,
  `apartment` varchar(255) NOT NULL,
  `floor` int(11) NOT NULL,
  `door` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `verified`, `membership`, `token`, `password`, `profile_image`, `last_submission`, `submissions`, `telephone`, `address`, `city`, `district`, `apartment`, `floor`, `door`) VALUES
(9, 'Eren', 'Aydın', 'therenaydin@gmail.com', 1, 1, 'f73fa97b8e0ddb0676c064f0f9b118185ea35440f138555972ef998525e622a9d5d11ba857cd76854c009b6a086c67605074', '$2y$10$04ZqHvqzooQV3EQj0XIvM.jtAAMGH8EKI614LuzashMJDpG/4n952', 'eren_aydin_avatar_xlorvt2vbd.jpg', 1712115609, 1, '5377670403', 'topcu', 17, 237, '21', 2, 12),
(11, 'Harun', 'Aydın', 'haydin9876@gmail.com', 1, 0, '8638e50507553552f10ce761a04c1df101a2758456922cff5f75dd36d6b923294bc449a4228d93ba1915ce6577e4e75bdca9', '$2y$10$QRoERl0HStZtCQ2ZU85nxuFlSe6asGcjIdnDJIHVYbYP2A5fKOxX6', 'nopp.png', 1711493051, 1, '5054696240', '66', 16, 233, '32', 0, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qid` (`qid`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orderid` (`orderid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcats`
--
ALTER TABLE `subcats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=974;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `site`
--
ALTER TABLE `site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subcats`
--
ALTER TABLE `subcats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`qid`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcats`
--
ALTER TABLE `subcats`
  ADD CONSTRAINT `subcats_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
