-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2020 at 12:00 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sikopimas`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_GetTingkatKerawanan` (`idorganisasi` INT) RETURNS VARCHAR(20) CHARSET utf8mb4 BEGIN
    DECLARE tingkatkerawanan VARCHAR(20);
    DECLARE bobot INT;
    DECLARE statusperizinan INT;
    DECLARE isu INT;
    DECLARE tahunoperasi INT;
    DECLARE jumlahwilayah INT;
    DECLARE jumlahmitra INT;
    DECLARE datacollection INT;
    DECLARE besaranggaran INT;
    
    SELECT fn_GetTingkatKerawananByStatusPerizinan(id), 
    fn_GetTingkatKerawananByIsu(id),
    fn_GetTingkatKerawananByTahunBeroperasi(id),
    fn_GetTingkatKerawananByJumlahWilayah(id),
    fn_GetTingkatKerawananByJumlahMitra(id),
    fn_GetTingkatKerawananByDataCollection(id),
    fn_GetTingkatKerawananByDataAnggaran(id)
    into statusperizinan, isu, tahunoperasi, jumlahwilayah, jumlahmitra, datacollection, besaranggaran
    FROM organisasi 
    where id = idorganisasi;
    
    SET bobot = statusperizinan + isu + tahunoperasi + jumlahwilayah + jumlahmitra + datacollection + besaranggaran;
    
    IF  bobot >= 7 and bobot <= 10 THEN
		SET tingkatkerawanan = 'AMAN';
    ELSEIF  bobot >= 11 and bobot <= 14 THEN
        SET tingkatkerawanan = 'SEDANG';
    ELSEIF  bobot >= 15 THEN
		SET tingkatkerawanan = 'RAWAN';
    END IF;
    
    
	
	RETURN (tingkatkerawanan);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fn_GetTingkatKerawananByDataAnggaran` (`idorganisasi` INT) RETURNS INT(20) BEGIN
    DECLARE tingkatkerawanan INT;
    DECLARE besaranggaran INT;
    
    SELECT anggaran into besaranggaran
    FROM organisasi where id = idorganisasi;

	IF  besaranggaran < 1000000 THEN
		SET tingkatkerawanan = 1;
    ELSEIF  besaranggaran >= 1000000 and besaranggaran <= 5000000 THEN
        SET tingkatkerawanan = 2;
    ELSEIF  besaranggaran > 5000000 THEN
		SET tingkatkerawanan = 3;
    END IF;
	
	RETURN (tingkatkerawanan);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fn_GetTingkatKerawananByDataCollection` (`idorganisasi` INT) RETURNS INT(20) BEGIN
    DECLARE tingkatkerawanan INT;
    DECLARE datacollection INT;
    
    SELECT id_datacollection into datacollection
    FROM organisasi where id = idorganisasi;

    IF  datacollection = 1 THEN
		SET tingkatkerawanan = 3;
    ELSEIF  datacollection = 2 THEN
        SET tingkatkerawanan = 1;
    END IF;
	
	RETURN (tingkatkerawanan);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fn_GetTingkatKerawananByIsu` (`idorganisasi` INT) RETURNS INT(20) BEGIN
 DECLARE tingkatkerawanan INT;
    DECLARE isu INT;
    
    select count(t.id_isu) INTO isu from (
	SELECT id_isu FROM isuorganisasi 
    where id_organisasi = idorganisasi) t
    where t.id_isu not in (1);
    
    IF isu = 0 THEN		
			SET tingkatkerawanan = 1;
    ELSE
           SET tingkatkerawanan = 3;
    END IF;	
	RETURN (tingkatkerawanan);
    
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fn_GetTingkatKerawananByJumlahMitra` (`idorganisasi` INT) RETURNS INT(20) BEGIN
    DECLARE tingkatkerawanan INT;
    DECLARE jumlahmitra INT;
    
    select count(id_mitralokal) into jumlahmitra
	from mitralokalorganisasi
    where id_organisasi = idorganisasi;

   IF  jumlahmitra >= 0 and jumlahmitra <= 5 THEN
		SET tingkatkerawanan = 1;
    ELSEIF  jumlahmitra >= 6 and jumlahmitra <= 10 THEN
        SET tingkatkerawanan = 2;
    ELSEIF  jumlahmitra > 10 THEN
		SET tingkatkerawanan = 3;
    END IF;
	
	RETURN (tingkatkerawanan);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fn_GetTingkatKerawananByJumlahWilayah` (`idorganisasi` INT) RETURNS INT(20) BEGIN
	DECLARE tingkatkerawanan INT;
    DECLARE jumlahwilayah INT;
    DECLARE wilayahrawan INT;
    
    select count(id_provinsi) into jumlahwilayah
	from lokasiorganisasiprovinsi 
    where id_organisasi = idorganisasi;
    
    select count(id_provinsi) into wilayahrawan 
	from lokasiorganisasiprovinsi 
    where id_provinsi IN (1, 20, 24, 25)
    and id_organisasi = idorganisasi;
    
   IF wilayahrawan > 0 THEN
      SET tingkatkerawanan = 3;
   ELSE
      IF  jumlahwilayah >= 0 and jumlahwilayah <= 10 THEN
	SET tingkatkerawanan = 1;
      ELSEIF  jumlahwilayah >= 11 and jumlahwilayah <= 20 THEN
        SET tingkatkerawanan = 2;
      ELSEIF  jumlahwilayah > 20 THEN
	SET tingkatkerawanan = 3;
      END IF;
   END IF;
        
	RETURN (tingkatkerawanan);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fn_GetTingkatKerawananByStatusPerizinan` (`idorganisasi` INT) RETURNS INT(20) BEGIN
    DECLARE tingkatkerawanan INT;
    DECLARE statusperizinan INT;
    
    SELECT id_statusperizinan into statusperizinan
    FROM organisasi where id = idorganisasi;

    IF statusperizinan = 1 THEN		
			SET tingkatkerawanan = 1;
    ELSEIF statusperizinan = 2 THEN
        SET tingkatkerawanan = 15;
    END IF;
	
	RETURN (tingkatkerawanan);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fn_GetTingkatKerawananByTahunBeroperasi` (`idorganisasi` INT) RETURNS INT(11) BEGIN
    DECLARE tingkatkerawanan INT;
    DECLARE tahunoperasi INT;
    
    SELECT tahun_beroperasi into tahunoperasi
    FROM organisasi where id = idorganisasi;
    
    IF  (year(CURRENT_DATE) - tahunoperasi) <= 6 THEN
			SET tingkatkerawanan = 1;
        ELSEIF (year(CURRENT_DATE) - tahunoperasi) >= 7 and (year(CURRENT_DATE) - tahunoperasi) <= 12 THEN
             SET tingkatkerawanan = 2;
        ELSEIF  (year(CURRENT_DATE) - tahunoperasi > 12) THEN
			SET tingkatkerawanan = 3;
        END IF;
        
	RETURN (tingkatkerawanan);
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bidangkerjaorganisasi`
--

CREATE TABLE `bidangkerjaorganisasi` (
  `id` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `id_bidangkerja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bidangkerjaorganisasi`
--

INSERT INTO `bidangkerjaorganisasi` (`id`, `id_organisasi`, `id_bidangkerja`) VALUES
(1, 1, 1),
(2, 1, 6),
(3, 1, 16),
(4, 1, 8),
(5, 2, 3),
(6, 2, 7),
(7, 3, 17),
(8, 3, 8),
(9, 3, 16),
(10, 4, 9),
(11, 4, 10),
(12, 5, 11),
(13, 5, 30),
(14, 5, 2),
(15, 6, 5),
(16, 7, 1),
(17, 7, 15),
(18, 7, 16),
(19, 8, 2),
(20, 9, 5),
(21, 9, 4),
(22, 10, 8),
(23, 10, 9),
(24, 10, 12),
(25, 10, 3),
(84, 34, 5);

-- --------------------------------------------------------

--
-- Table structure for table `donororganisasi`
--

CREATE TABLE `donororganisasi` (
  `id` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `id_donor` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donororganisasi`
--

INSERT INTO `donororganisasi` (`id`, `id_organisasi`, `id_donor`, `jumlah`) VALUES
(2, 1, 1, 5000000),
(3, 1, 2, 1500000),
(4, 2, 3, 4000000),
(5, 2, 4, 1000000),
(6, 2, 5, 500000),
(7, 2, 6, 800000),
(8, 3, 6, 2500000),
(9, 3, 7, 1500000),
(10, 3, 3, 1000000),
(11, 3, 8, 200000),
(12, 4, 9, 3000000),
(13, 5, 10, 2000000),
(14, 5, 11, 3000000),
(15, 5, 12, 800000),
(16, 6, 13, 1000000),
(17, 6, 14, 500000),
(18, 6, 15, 500000),
(19, 6, 16, 300000),
(20, 7, 17, 1300000),
(21, 8, 18, 3200000),
(22, 8, 3, 1500000),
(23, 9, 19, 4800000),
(24, 9, 2, 1400000),
(25, 10, 20, 11200000),
(56, 34, 3, 200000),
(57, 34, 2, 90000);

-- --------------------------------------------------------

--
-- Table structure for table `isuorganisasi`
--

CREATE TABLE `isuorganisasi` (
  `id` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `id_isu` int(11) NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `isuorganisasi`
--

INSERT INTO `isuorganisasi` (`id`, `id_organisasi`, `id_isu`, `keterangan`) VALUES
(1, 1, 5, 'Syiah'),
(2, 1, 12, 'Kelapa Sawit'),
(3, 2, 5, 'LGBT'),
(4, 3, 1, ''),
(5, 4, 1, ''),
(6, 5, 2, 'Penyebaran Agama'),
(7, 5, 7, 'Papua Merdeka'),
(8, 6, 1, ''),
(9, 7, 1, ''),
(10, 8, 3, 'Riset Kusta'),
(11, 9, 3, 'Ikan Hiu dan Ikan Pari'),
(12, 10, 17, 'Politik Ikhwanul Muslimin'),
(50, 34, 4, 'ham');

-- --------------------------------------------------------

--
-- Table structure for table `lokasiorganisasikabupaten`
--

CREATE TABLE `lokasiorganisasikabupaten` (
  `id` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL,
  `id_kabupaten` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lokasiorganisasikabupaten`
--

INSERT INTO `lokasiorganisasikabupaten` (`id`, `id_organisasi`, `id_provinsi`, `id_kabupaten`) VALUES
(1, 1, 1, 19),
(2, 1, 1, 22),
(3, 1, 1, 3),
(4, 1, 1, 17),
(5, 1, 34, 516),
(6, 1, 34, 503),
(7, 1, 34, 485),
(8, 1, 26, 372),
(9, 1, 8, 68),
(10, 1, 8, 73),
(11, 1, 33, 481),
(12, 1, 33, 469),
(13, 1, 33, 472),
(14, 1, 33, 470),
(16, 1, 9, 79),
(17, 1, 9, 85),
(18, 1, 9, 90),
(19, 1, 10, 128),
(20, 1, 10, 139),
(21, 1, 10, 110),
(22, 1, 10, 133),
(23, 1, 10, 117),
(24, 1, 10, 126),
(25, 1, 5, 52),
(26, 1, 5, 51),
(27, 1, 5, 53),
(28, 1, 5, 54),
(29, 1, 11, 144),
(33, 1, 22, 287),
(34, 1, 22, 289),
(35, 1, 22, 288),
(36, 1, 23, 299),
(37, 1, 23, 317),
(38, 1, 23, 314),
(39, 1, 23, 309),
(40, 1, 23, 297),
(41, 1, 23, 302),
(42, 1, 28, 400),
(43, 1, 28, 390),
(44, 1, 28, 379),
(45, 1, 28, 382),
(46, 1, 28, 385),
(47, 1, 28, 394),
(48, 1, 28, 384),
(49, 1, 28, 389),
(50, 1, 12, 187),
(51, 1, 12, 183),
(52, 1, 12, 181),
(53, 1, 12, 190),
(54, 2, 34, 511),
(55, 2, 34, 487),
(56, 2, 34, 504),
(57, 2, 34, 486),
(58, 2, 34, 501),
(59, 2, 34, 502),
(60, 2, 34, 506),
(61, 2, 34, 505),
(62, 2, 34, 499),
(63, 2, 32, 461),
(64, 2, 8, 78),
(65, 2, 8, 71),
(66, 2, 8, 73),
(67, 2, 8, 68),
(68, 2, 8, 77),
(69, 2, 8, 75),
(70, 2, 33, 482),
(71, 2, 4, 50),
(72, 2, 19, 262),
(73, 2, 3, 34),
(74, 2, 3, 33),
(75, 2, 9, 82),
(76, 2, 9, 94),
(77, 2, 9, 84),
(78, 2, 9, 88),
(79, 2, 9, 92),
(80, 2, 9, 80),
(81, 2, 9, 93),
(82, 2, 9, 97),
(83, 2, 9, 79),
(84, 2, 9, 86),
(85, 2, 9, 95),
(86, 2, 9, 87),
(87, 2, 9, 85),
(88, 2, 9, 89),
(89, 2, 10, 112),
(90, 2, 10, 131),
(91, 2, 10, 107),
(92, 2, 10, 125),
(93, 2, 10, 123),
(94, 2, 10, 106),
(95, 2, 10, 134),
(97, 2, 10, 132),
(98, 2, 10, 118),
(99, 2, 10, 121),
(100, 2, 10, 137),
(101, 2, 10, 128),
(102, 2, 10, 110),
(103, 2, 10, 119),
(104, 2, 10, 130),
(105, 2, 10, 115),
(106, 2, 10, 114),
(107, 2, 10, 109),
(108, 2, 10, 129),
(109, 2, 10, 116),
(110, 2, 10, 133),
(111, 2, 5, 53),
(112, 2, 5, 51),
(113, 2, 5, 52),
(114, 2, 5, 54),
(115, 2, 5, 55),
(116, 2, 11, 157),
(117, 2, 11, 153),
(118, 2, 11, 161),
(119, 2, 11, 167),
(120, 2, 11, 169),
(121, 2, 11, 143),
(122, 2, 11, 149),
(123, 2, 11, 148),
(124, 2, 11, 150),
(125, 2, 11, 155),
(126, 2, 11, 178),
(127, 2, 11, 170),
(128, 2, 10, 124),
(129, 2, 11, 160),
(130, 2, 11, 151),
(131, 2, 11, 162),
(132, 2, 11, 147),
(133, 2, 11, 142),
(134, 2, 2, 30),
(135, 2, 2, 28),
(136, 2, 2, 26),
(137, 2, 2, 31),
(138, 2, 2, 24),
(139, 2, 2, 27),
(140, 2, 2, 32),
(141, 2, 2, 25),
(142, 2, 2, 29),
(143, 2, 12, 191),
(144, 2, 14, 219),
(145, 2, 12, 180),
(146, 2, 14, 216),
(147, 2, 28, 386),
(148, 2, 28, 382),
(149, 2, 28, 379),
(150, 2, 28, 394),
(151, 2, 28, 384),
(152, 2, 28, 390),
(153, 2, 28, 400),
(155, 2, 28, 380),
(156, 2, 28, 383),
(157, 2, 28, 387),
(158, 2, 28, 389),
(159, 2, 28, 388),
(160, 2, 27, 374),
(161, 2, 27, 375),
(162, 2, 30, 432),
(163, 2, 29, 415),
(164, 2, 29, 408),
(165, 2, 29, 407),
(166, 2, 23, 311),
(167, 2, 23, 310),
(168, 2, 23, 312),
(169, 2, 23, 313),
(170, 2, 23, 299),
(171, 2, 20, 268),
(172, 2, 20, 273),
(173, 3, 32, 454),
(174, 3, 32, 453),
(175, 3, 32, 451),
(176, 3, 32, 464),
(177, 3, 32, 448),
(178, 3, 32, 460),
(179, 3, 32, 459),
(180, 3, 32, 462),
(181, 3, 32, 452),
(182, 3, 32, 463),
(183, 3, 32, 461),
(184, 3, 32, 457),
(185, 3, 32, 466),
(186, 3, 32, 465),
(187, 3, 32, 456),
(188, 3, 32, 449),
(189, 3, 32, 458),
(190, 3, 32, 455),
(191, 3, 32, 450),
(193, 3, 12, 191),
(194, 3, 12, 191),
(195, 3, 12, 183),
(196, 3, 12, 186),
(197, 3, 12, 192),
(198, 3, 12, 179),
(199, 3, 12, 187),
(200, 3, 12, 184),
(201, 3, 12, 181),
(202, 3, 12, 182),
(203, 3, 12, 185),
(204, 3, 12, 188),
(205, 3, 12, 189),
(206, 3, 12, 190),
(207, 3, 12, 180),
(208, 3, 22, 294),
(209, 3, 22, 287),
(210, 3, 22, 288),
(211, 3, 22, 289),
(212, 3, 22, 290),
(213, 3, 22, 292),
(214, 3, 22, 291),
(215, 3, 22, 286),
(216, 3, 22, 285),
(217, 3, 22, 293),
(218, 3, 23, 303),
(219, 3, 23, 305),
(220, 3, 23, 306),
(221, 3, 23, 304),
(222, 3, 23, 302),
(223, 3, 23, 297),
(224, 3, 23, 309),
(225, 3, 23, 298),
(226, 3, 23, 300),
(227, 3, 23, 295),
(228, 3, 23, 311),
(229, 3, 23, 310),
(230, 3, 23, 312),
(231, 3, 23, 313),
(232, 3, 23, 308),
(233, 3, 23, 307),
(234, 3, 23, 316),
(235, 3, 23, 299),
(236, 3, 23, 314),
(237, 3, 23, 315),
(238, 3, 23, 301),
(239, 3, 23, 296),
(240, 3, 28, 386),
(241, 3, 28, 382),
(242, 3, 28, 379),
(243, 3, 28, 394),
(244, 3, 28, 385),
(245, 3, 28, 384),
(246, 3, 28, 396),
(247, 3, 28, 400),
(248, 3, 28, 390),
(250, 3, 28, 380),
(251, 3, 28, 391),
(252, 3, 28, 395),
(253, 3, 28, 402),
(254, 3, 28, 399),
(255, 3, 28, 393),
(256, 3, 28, 392),
(257, 3, 28, 383),
(258, 3, 28, 387),
(259, 3, 28, 398),
(260, 3, 28, 401),
(261, 3, 28, 397),
(262, 3, 28, 389),
(263, 3, 28, 388),
(264, 3, 25, 359),
(265, 3, 25, 357),
(266, 3, 25, 360),
(267, 3, 25, 351),
(268, 3, 25, 348),
(269, 3, 25, 350),
(270, 3, 25, 349),
(271, 3, 25, 354),
(272, 3, 25, 355),
(273, 3, 25, 353),
(274, 3, 25, 358),
(275, 3, 25, 352),
(276, 3, 24, 323),
(277, 3, 24, 334),
(278, 3, 24, 321),
(279, 3, 24, 333),
(280, 3, 24, 336),
(281, 3, 24, 343),
(282, 3, 24, 329),
(283, 3, 24, 340),
(284, 3, 24, 342),
(285, 3, 24, 328),
(286, 3, 24, 339),
(287, 3, 24, 338),
(288, 3, 24, 344),
(289, 3, 24, 335),
(290, 3, 24, 325),
(291, 3, 24, 330),
(292, 3, 24, 347),
(293, 3, 24, 345),
(294, 3, 24, 337),
(295, 3, 24, 324),
(296, 3, 24, 326),
(297, 3, 24, 346),
(298, 3, 24, 320),
(299, 3, 24, 332),
(300, 3, 24, 318),
(301, 3, 24, 331),
(302, 4, 3, 40),
(303, 4, 9, 79),
(304, 4, 9, 88),
(305, 4, 9, 94),
(306, 4, 10, 128),
(307, 4, 11, 155),
(308, 4, 10, 139),
(309, 4, 5, 54),
(310, 4, 11, 178),
(311, 4, 11, 146),
(312, 4, 11, 164),
(313, 4, 2, 32),
(314, 4, 2, 26),
(315, 4, 2, 29),
(316, 5, 9, 95),
(317, 5, 34, 508),
(318, 5, 34, 489),
(319, 5, 34, 497),
(320, 5, 9, 79),
(321, 5, 9, 85),
(322, 5, 10, 128),
(323, 5, 10, 106),
(324, 5, 10, 109),
(325, 5, 5, 54),
(326, 5, 5, 53),
(327, 5, 2, 32),
(328, 5, 2, 26),
(329, 5, 2, 29),
(330, 5, 31, 446),
(331, 5, 31, 440),
(332, 5, 31, 433),
(333, 5, 24, 324),
(334, 5, 24, 325),
(335, 5, 24, 333),
(336, 5, 24, 335),
(337, 6, 26, 362),
(338, 6, 26, 363),
(339, 6, 8, 75),
(340, 6, 8, 76),
(341, 6, 8, 69),
(343, 7, 9, 97),
(344, 7, 10, 138),
(345, 7, 5, 55),
(346, 7, 13, 205),
(347, 8, 1, 3),
(348, 8, 1, 1),
(349, 8, 3, 35),
(350, 8, 9, 93),
(351, 8, 9, 87),
(352, 8, 9, 85),
(353, 8, 10, 111),
(354, 8, 10, 131),
(355, 8, 10, 130),
(356, 8, 10, 126),
(357, 8, 10, 109),
(358, 8, 11, 160),
(359, 8, 11, 163),
(360, 8, 11, 159),
(361, 8, 11, 166),
(362, 8, 20, 273),
(363, 8, 20, 269),
(364, 8, 21, 281),
(365, 8, 21, 283),
(366, 8, 21, 276),
(367, 8, 24, 319),
(368, 8, 24, 346),
(369, 8, 25, 360),
(370, 8, 25, 350),
(371, 8, 28, 385),
(373, 8, 28, 400),
(374, 8, 30, 431),
(375, 8, 30, 416),
(376, 8, 29, 413),
(377, 8, 29, 410),
(378, 8, 7, 64),
(379, 8, 31, 436),
(380, 8, 31, 433),
(381, 8, 31, 441),
(382, 8, 31, 443),
(383, 9, 1, 8),
(384, 9, 34, 505),
(385, 9, 34, 494),
(386, 9, 18, 244),
(387, 9, 9, 94),
(388, 9, 3, 34),
(389, 9, 2, 29),
(390, 9, 25, 350),
(391, 9, 25, 349),
(392, 9, 25, 354),
(393, 9, 24, 329),
(394, 10, 1, 11),
(395, 10, 1, 21),
(396, 10, 1, 13),
(397, 10, 1, 16),
(398, 10, 1, 20),
(399, 10, 1, 3),
(400, 10, 1, 19),
(401, 10, 1, 7),
(402, 10, 3, 34),
(403, 10, 3, 33),
(404, 10, 3, 35),
(405, 10, 3, 36),
(406, 10, 3, 39),
(407, 10, 3, 40),
(409, 10, 9, 99),
(410, 10, 9, 81),
(411, 10, 9, 82),
(412, 10, 9, 100),
(413, 10, 9, 88),
(414, 10, 9, 92),
(415, 10, 9, 93),
(416, 10, 9, 90),
(417, 10, 9, 79),
(418, 10, 9, 97),
(419, 10, 9, 86),
(420, 10, 9, 96),
(421, 10, 9, 83),
(422, 10, 9, 85),
(423, 10, 9, 91),
(424, 10, 10, 124),
(425, 10, 11, 161),
(426, 10, 11, 146),
(428, 10, 11, 174),
(429, 10, 11, 178),
(430, 10, 5, 53),
(431, 10, 5, 54),
(432, 10, 5, 51),
(433, 10, 5, 55),
(434, 10, 5, 52),
(435, 10, 22, 290),
(436, 10, 22, 289),
(437, 10, 22, 288),
(438, 10, 22, 287),
(439, 10, 22, 294),
(440, 1, 2, 28),
(441, 1, 2, 24),
(442, 1, 2, 26),
(445, 10, 11, 154),
(446, 1, 6, 58),
(447, 3, 6, 59),
(448, 7, 6, 59),
(449, 10, 6, 59),
(544, 33, 4, 43),
(545, 33, 12, 187),
(552, 34, 5, 53),
(553, 34, 2, 28),
(554, 34, 6, 59),
(569, 39, 5, 53);

-- --------------------------------------------------------

--
-- Table structure for table `lokasiorganisasiprovinsi`
--

CREATE TABLE `lokasiorganisasiprovinsi` (
  `id` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasiorganisasiprovinsi`
--

INSERT INTO `lokasiorganisasiprovinsi` (`id`, `id_organisasi`, `id_provinsi`) VALUES
(1, 1, 1),
(2, 1, 34),
(3, 1, 26),
(4, 1, 8),
(5, 1, 33),
(6, 1, 6),
(7, 1, 9),
(8, 1, 10),
(9, 1, 5),
(10, 1, 11),
(12, 1, 22),
(13, 1, 23),
(14, 1, 28),
(15, 1, 12),
(16, 2, 9),
(17, 2, 10),
(20, 2, 23),
(21, 2, 28),
(23, 3, 6),
(29, 3, 22),
(30, 3, 23),
(31, 3, 28),
(32, 4, 3),
(33, 4, 9),
(34, 4, 10),
(35, 4, 5),
(36, 4, 11),
(37, 4, 2),
(38, 5, 34),
(39, 5, 9),
(40, 5, 10),
(41, 5, 5),
(42, 5, 2),
(43, 5, 31),
(44, 5, 24),
(45, 6, 26),
(46, 6, 8),
(47, 7, 6),
(48, 7, 9),
(49, 7, 10),
(50, 7, 5),
(51, 7, 13),
(52, 8, 1),
(53, 8, 3),
(54, 8, 9),
(55, 8, 10),
(56, 8, 11),
(57, 8, 20),
(58, 8, 21),
(59, 8, 24),
(60, 8, 25),
(61, 8, 28),
(62, 8, 30),
(63, 8, 31),
(64, 9, 1),
(65, 9, 34),
(66, 9, 18),
(67, 9, 9),
(68, 9, 3),
(69, 9, 2),
(70, 9, 25),
(71, 9, 24),
(72, 10, 1),
(73, 10, 3),
(74, 10, 9),
(75, 10, 10),
(76, 10, 11),
(77, 10, 5),
(78, 10, 22),
(79, 2, 34),
(80, 2, 32),
(81, 2, 8),
(82, 2, 33),
(83, 2, 4),
(85, 2, 3),
(86, 2, 5),
(87, 2, 2),
(88, 2, 11),
(89, 2, 12),
(90, 2, 14),
(91, 2, 27),
(92, 2, 29),
(93, 2, 20),
(94, 3, 32),
(95, 3, 12),
(96, 3, 24),
(97, 3, 25),
(98, 8, 29),
(99, 8, 7),
(100, 10, 6),
(101, 1, 2),
(102, 2, 30),
(208, 33, 4),
(209, 33, 12),
(216, 34, 5),
(217, 34, 2),
(218, 34, 6),
(227, 39, 5);

-- --------------------------------------------------------

--
-- Table structure for table `master_bidangkerja`
--

CREATE TABLE `master_bidangkerja` (
  `id` int(11) NOT NULL,
  `nama_bidang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_bidangkerja`
--

INSERT INTO `master_bidangkerja` (`id`, `nama_bidang`) VALUES
(1, 'Tata Kelola Pemerintahan '),
(2, 'Kesehatan '),
(3, 'Kesejahteraan Sosial '),
(4, 'Konservasi Laut '),
(5, 'Konservasi Hutan'),
(6, 'Seni dan Budaya'),
(7, 'Energi dan Sumber Daya Mineral'),
(8, 'Pemberdayaan Ekonomi'),
(9, 'Air Bersih dan Sanitasi'),
(10, 'Infrastruktur'),
(11, 'Pertanian dan Perkebunan '),
(12, 'Kebencanaan'),
(13, 'Pendidikan'),
(14, 'Perubahan Iklim'),
(15, 'Demokrasi dan HAM Umum'),
(16, 'Kesetaraan Gender'),
(17, 'Kepemudaan Ibu dan Anak'),
(18, 'Disabilitas'),
(19, 'Hukum dan perundangan'),
(20, 'Keluarga Berencana'),
(21, 'Parawisata'),
(22, 'Peternakan'),
(23, 'Koperasi dan UMKM'),
(24, 'Komunikasi dan Informasi'),
(25, 'Ketenagakerjaan'),
(26, 'Perikanan'),
(27, 'Agraria dan Tata Ruang'),
(28, 'Perhubungan'),
(29, 'Kearsipan'),
(30, 'Advokasi Lahan');

-- --------------------------------------------------------

--
-- Table structure for table `master_datacollection`
--

CREATE TABLE `master_datacollection` (
  `id` int(11) NOT NULL,
  `deskripsi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_datacollection`
--

INSERT INTO `master_datacollection` (`id`, `deskripsi`) VALUES
(1, 'Pengumpulan data primer'),
(2, 'Pengumpulan data sekunder');

-- --------------------------------------------------------

--
-- Table structure for table `master_donor`
--

CREATE TABLE `master_donor` (
  `id` int(11) NOT NULL,
  `nama_donor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_donor`
--

INSERT INTO `master_donor` (`id`, `nama_donor`) VALUES
(1, 'Ford Foundation'),
(2, 'USAID'),
(3, 'Pemerintah Belanda'),
(4, 'Global Fund'),
(5, 'Open Society Foundation'),
(6, 'Uni Eropa'),
(7, 'DFAT Australia'),
(8, 'Pemerintah Kanada'),
(9, 'BMZ'),
(10, 'Pemerintah Jerman'),
(11, 'Gereja Evengelis Jerman'),
(12, 'Dana Publik Jerman'),
(13, 'Franfurt Zoological Society'),
(14, 'Ther Orangutan Project'),
(15, 'US Fish & Wildlife Service'),
(16, 'Perth Zoo'),
(17, 'SIDA'),
(18, 'Netherlands Leprosy Relief'),
(19, 'Gordon and Betty More Foundation'),
(20, 'Pemerintah Qatar');

-- --------------------------------------------------------

--
-- Table structure for table `master_isu`
--

CREATE TABLE `master_isu` (
  `id` int(11) NOT NULL,
  `nama_isu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_isu`
--

INSERT INTO `master_isu` (`id`, `nama_isu`) VALUES
(1, 'None '),
(2, 'Misi Agama'),
(3, 'Penelitian dan Profiling'),
(4, 'Penegakan Hukum, Keamanan dan Pertahanan'),
(5, 'Minoritas'),
(6, 'LGBT'),
(7, 'Separatis'),
(8, 'Radikalisme'),
(9, 'Pembuatan Database'),
(10, 'Investigasi'),
(11, 'Advokasi Buruh'),
(12, 'Advokasi Lingkungan'),
(13, 'Feminisme'),
(14, 'Intervensi Kebijakan dan UU'),
(15, 'Jurnalistik'),
(16, 'Konflik'),
(17, 'Ideologi Politik'),
(18, 'Kejahatan Transnasional'),
(19, 'Vaksin dan Virologi');

-- --------------------------------------------------------

--
-- Table structure for table `master_kabupatenkota`
--

CREATE TABLE `master_kabupatenkota` (
  `id` int(11) NOT NULL,
  `kode_kabupaten` int(11) NOT NULL,
  `nama_kabupatenkota` varchar(50) NOT NULL,
  `lati` varchar(50) NOT NULL,
  `longi` varchar(50) NOT NULL,
  `zoom` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_kabupatenkota`
--

INSERT INTO `master_kabupatenkota` (`id`, `kode_kabupaten`, `nama_kabupatenkota`, `lati`, `longi`, `zoom`, `id_provinsi`) VALUES
(1, 0, 'Kabupaten Aceh Barat', '4.4422520500000005', '96.19298304718677', 10, 1),
(2, 0, 'Kabupaten Aceh Barat Daya', '3.8339449500000002', '96.85148499463963', 10, 1),
(3, 0, 'Kabupaten Aceh Besar', '5.35429985', '95.49613583342777', 10, 1),
(4, 0, 'Kabupaten Aceh Jaya', '4.81056095', '95.70123197892161', 10, 1),
(5, 0, 'Kabupaten Aceh Selatan', '3.0671775', '97.46919659783279', 9, 1),
(6, 0, 'Kabupaten Aceh Singkil', '2.3771104999999997', '97.92348171932068', 10, 1),
(7, 0, 'Kabupaten Aceh Tamiang', '4.212262450000001', '97.91471113604223', 10, 1),
(8, 0, 'Kabupaten Aceh Tengah', '4.564266999999999', '96.96189262635659', 10, 1),
(9, 0, 'Kabupaten Aceh Tenggara', '3.4896807', '97.8105118', 10, 1),
(10, 0, 'Kabupaten Aceh Timur', '4.70166295', '97.64503901995158', 9, 1),
(11, 0, 'Kabupaten Aceh Utara', '4.99119405', '97.1587368058996', 10, 1),
(12, 0, 'Kabupaten Bener Meriah', '4.77387985', '96.97800363035068', 11, 1),
(13, 0, 'Kabupaten Bireuen', '5.0827404', '96.5921211980314', 10, 1),
(14, 0, 'Kabupaten Gayo Lues', '3.97759925', '97.33206765898427', 10, 1),
(15, 0, 'Kabupaten Nagan Raya', '4.181243', '96.52577259266292', 10, 1),
(16, 0, 'Kabupaten Pidie', '5.1143002', '95.94128340121603', 10, 1),
(17, 0, 'Kabupaten Pidie Jaya', '5.10477095', '96.21166763608278', 11, 1),
(18, 0, 'Kabupaten Simeulue', '2.6291001', '96.02269314785323', 10, 1),
(19, 0, 'Kota Banda Aceh', '5.5528455', '95.3192908', 13, 1),
(20, 0, 'Kota Langsa', '4.4730892', '97.9681841', 13, 1),
(21, 0, 'Kota Lhokseumawe', '5.1789659', '97.1480544', 13, 1),
(22, 0, 'Kota Sabang', '5.8394406', '95.33748474423653', 12, 1),
(23, 0, 'Kota Subulussalam', '2.7537089999999997', '97.92816878850363', 10, 1),
(24, 0, 'Kabupaten Badung', '-8.6240702', '115.44346444653527', 10, 2),
(25, 0, 'Kabupaten Bangli', '-8.4603116', '115.3535198', 11, 2),
(26, 0, 'Kabupaten Buleleng', '-8.1118271', '115.0909707', 10, 2),
(27, 0, 'Kabupaten Gianyar', '-8.5482357', '115.32605401537212', 11, 2),
(28, 0, 'Kabupaten Jembrana', '-8.3621279', '114.64879069145596', 11, 2),
(29, 0, 'Kabupaten Karangasem', '-8.4464252', '115.6135572', 11, 2),
(30, 0, 'Kabupaten Klungkung', '-8.5350173', '115.4032763', 11, 2),
(31, 0, 'Kabupaten Tabanan', '-8.5392306', '115.1265683', 11, 2),
(32, 0, 'Kota Denpasar', '-8.6524973', '115.2191175', 12, 2),
(33, 0, 'Kabupaten Lebak', '-6.6432601', '106.18727177777018', 10, 3),
(34, 0, 'Kabupaten Pandeglang', '-6.3097661', '106.1067474', 10, 3),
(35, 0, 'Kabupaten Serang', '-6.10565025', '105.98773335759398', 11, 3),
(36, 0, 'Kabupaten Tangerang', '-6.1902326', '106.64108465161493', 11, 3),
(37, 0, 'Kota Cilegon', '-6.017389', '106.0537688', 12, 3),
(38, 0, 'Kota Serang', '-6.10565025', '105.98773335759398', 14, 3),
(39, 0, 'Kota Tangerang', '-6.1760311', '106.6384468', 12, 3),
(40, 0, 'Kota Tangerang Selatan', '-6.2955404', '106.7085494', 12, 3),
(41, 0, 'Kabupaten Bengkulu Selatan', '-4.358928', '102.904351', 11, 4),
(42, 0, 'Kabupaten Bengkulu Tengah', '-3.7853726', '102.3702776', 11, 4),
(43, 0, 'Kabupaten Bengkulu Utara', '-4.1147615', '100.8770404', 8, 4),
(44, 0, 'Kabupaten Kaur', '-4.8677289', '103.4927773', 9, 4),
(45, 0, 'Kabupaten Kepahiang', '-3.6453585', '102.5789112', 11, 4),
(46, 0, 'Kabupaten Lebong', '-3.1130453', '102.1872742', 10, 4),
(47, 0, 'Kabupaten Mukomuko', '-2.553112', '101.1037813', 10, 4),
(48, 0, 'Kabupaten Rejang Lebong', '-3.4381507', '102.543014', 11, 4),
(49, 0, 'Kabupaten Seluma', '-4.1388142', '102.5192417', 10, 4),
(50, 0, 'Kota Bengkulu', '-3.9973651500000003', '101.83539437682936', 12, 4),
(51, 0, 'Kabupaten Bantul', '-7.89825435', '110.38555335898621', 11, 5),
(52, 0, 'Kabupaten Gunungkidul', '-7.9930377', '110.55793090404615', 11, 5),
(53, 0, 'Kabupaten Kulon Progo', '-7.8123076000000005', '110.14798278891979', 11, 5),
(54, 0, 'Kabupaten Sleman', '-7.6952864000000005', '110.34462923977276', 11, 5),
(55, 0, 'Kota Yogyakarta', '-7.8011945', '110.364917', 13, 5),
(56, 0, 'Kabupaten Administrasi Kepulauan Seribu', '-5.6350469499999996', '106.58035406613533', 10, 6),
(57, 0, 'Kota Administrasi Jakarta Barat', '-6.16156235', '106.74389124027667', 12, 6),
(58, 0, 'Kota Administrasi Jakarta Pusat', '-6.18233995', '106.84287153600738', 13, 6),
(59, 0, 'Kota Administrasi Jakarta Selatan', '-6.28381815', '106.80486349194814', 12, 6),
(60, 0, 'Kota Administrasi Jakarta Timur', '-6.26289085', '106.88222894692834', 12, 6),
(61, 0, 'Kota Administrasi Jakarta Utara', '-6.136197', '106.90069022428446', 12, 6),
(62, 0, 'Kabupaten Boalemo', '0.5292768', '122.3476412156231', 10, 7),
(63, 0, 'Kabupaten Bone Bolango', '0.5570412499999999', '123.1452961616409', 10, 7),
(64, 0, 'Kabupaten Gorontalo', '0.6497852', '122.27903172017321', 10, 7),
(65, 0, 'Kabupaten Gorontalo Utara', '0.8650372', '122.3482624', 10, 7),
(66, 0, 'Kabupaten Pohuwato', '0.4492', '121.939', 10, 7),
(67, 0, 'Kota Gorontalo', '0.5384433', '123.0594971', 13, 7),
(68, 0, 'Kabupaten Batanghari', '-1.6981542', '103.3357809', 9, 8),
(69, 0, 'Kabupaten Bungo', '-1.4925717', '102.0977256', 10, 8),
(70, 0, 'Kabupaten Kerinci', '-1.3253326', '102.0145983', 10, 8),
(71, 0, 'Kabupaten Merangin', '-2.1811376', '101.637826', 10, 8),
(72, 0, 'Kabupaten Muaro Jambi', '-1.4781958', '103.6669021', 10, 8),
(73, 0, 'Kabupaten Sarolangun', '-2.3051268', '102.7175331', 10, 8),
(74, 0, 'Kabupaten Tanjung Jabung Barat', '-1.0939494', '102.8299394', 10, 8),
(75, 0, 'Kabupaten Tanjung Jabung Timur', '-1.257656', '103.6216531', 10, 8),
(76, 0, 'Kabupaten Tebo', '-1.2383438', '102.238276', 9, 8),
(77, 0, 'Kota Jambi', '-1.6454854', '102.93517597904014', 13, 8),
(78, 0, 'Kota Sungaipenuh', '-2.0637828', '101.3950143', 13, 8),
(79, 0, 'Kabupaten Bandung', '-7.0633889', '107.3109748', 10, 9),
(80, 0, 'Kabupaten Bandung Barat', '-6.9052436', '107.3141471', 11, 9),
(81, 0, 'Kabupaten Bekasi', '-6.1403326', '107.1778148', 10, 9),
(82, 0, 'Kabupaten Bogor', '-6.545286', '106.5339018', 10, 9),
(83, 0, 'Kabupaten Ciamis', '-7.3266611', '108.3530952', 10, 9),
(84, 0, 'Kabupaten Cianjur', '-6.824096', '107.1374006', 10, 9),
(85, 0, 'Kabupaten Cirebon', '-6.7612835', '108.4415592', 11, 9),
(86, 0, 'Kabupaten Garut', '-7.2162543', '107.9014912', 10, 9),
(87, 0, 'Kabupaten Indramayu', '-6.326433', '108.3229169', 11, 9),
(88, 0, 'Kabupaten Karawang', '-6.3042012', '107.307897', 10, 9),
(89, 0, 'Kabupaten Kuningan', '-6.9827227', '108.4765024', 11, 9),
(90, 0, 'Kabupaten Majalengka', '-6.80771955', '108.27896705121316', 10, 9),
(91, 0, 'Kabupaten Pangandaran', '-7.6872621', '108.6531455', 11, 9),
(92, 0, 'Kabupaten Purwakarta', '-6.5607313', '107.4439799', 11, 9),
(93, 0, 'Kabupaten Subang', '-6.5689807', '107.7587397', 10, 9),
(94, 0, 'Kabupaten Sukabumi', '-6.8494057', '106.9202854', 13, 9),
(95, 0, 'Kabupaten Sumedang', '-6.8592431', '107.9206982', 11, 9),
(96, 0, 'Kabupaten Tasikmalaya', '-7.4277812', '107.8932619', 10, 9),
(97, 0, 'Kota Bandung', '-6.9344694', '107.6049539', 12, 9),
(98, 0, 'Kota Banjar', '-7.3695648', '108.5415225', 13, 9),
(99, 0, 'Kota Bekasi', '-6.2349858', '106.9945444', 12, 9),
(100, 0, 'Kota Bogor', '-6.5962986', '106.7972421', 12, 9),
(101, 0, 'Kota Cimahi', '-6.8731527', '107.5423099', 14, 9),
(102, 0, 'Kota Cirebon', '-6.7137044', '108.5608483', 13, 9),
(103, 0, 'Kota Depok', '-6.4074657', '106.8138131', 12, 9),
(104, 0, 'Kota Sukabumi', '-6.9199289', '106.9265095', 13, 9),
(105, 0, 'Kota Tasikmalaya', '-7.3262484', '108.2201154', 12, 9),
(106, 0, 'Kabupaten Banjarnegara', '-7.355873300000001', '109.66007275599358', 11, 10),
(107, 0, 'Kabupaten Banyumas', '-7.45507165', '109.11674648495966', 11, 10),
(108, 0, 'Kabupaten Batang', '-7.031803350000001', '109.86813118839709', 11, 10),
(109, 0, 'Kabupaten Blora', '-7.11054465', '111.42035148693856', 10, 10),
(110, 0, 'Kabupaten Boyolali', '-7.5344079', '110.6041944', 10, 10),
(111, 0, 'Kabupaten Brebes', '-7.053619299999999', '108.88799436568738', 10, 10),
(112, 0, 'Kabupaten Cilacap', '-7.46202885', '108.8047621916933', 10, 10),
(113, 0, 'Kabupaten Demak', '-6.923095200000001', '110.63164333679211', 11, 10),
(114, 0, 'Kabupaten Grobogan', '-7.09809465', '110.89667670375852', 11, 10),
(115, 0, 'Kabupaten Jepara', '-6.5906502', '110.6673202', 9, 10),
(116, 0, 'Kabupaten Karanganyar', '-7.6196965', '111.06980026754411', 11, 10),
(117, 0, 'Kabupaten Kebumen', '-7.6444810499999996', '109.60780695011951', 11, 10),
(118, 0, 'Kabupaten Kendal', '-7.0191819', '110.137484003698', 11, 10),
(119, 0, 'Kabupaten Klaten', '-7.6749203999999995', '110.6272787097259', 11, 10),
(120, 0, 'Kabupaten Kudus', '-6.797849449999999', '110.86791094762401', 11, 10),
(121, 0, 'Kabupaten Magelang', '-7.5136132', '110.21433030848786', 11, 10),
(122, 0, 'Kabupaten Pati', '-6.70695115', '111.0868496234177', 10, 10),
(123, 0, 'Kabupaten Pekalongan', '-7.0422206', '109.61973085835143', 11, 10),
(124, 0, 'Kabupaten Pemalang', '-7.01032635', '109.39217127616115', 11, 10),
(125, 0, 'Kabupaten Purbalingga', '-7.32733005', '109.39989874266684', 11, 10),
(126, 0, 'Kabupaten Purworejo', '-7.7073021', '109.96651169154023', 11, 10),
(127, 0, 'Kabupaten Rembang', '-6.7697243', '111.45569865582277', 11, 10),
(128, 0, 'Kabupaten Semarang', '-7.28765615', '110.40194273525398', 11, 10),
(129, 0, 'Kabupaten Sragen', '-7.3924563', '110.95302317792749', 11, 10),
(130, 0, 'Kabupaten Sukoharjo', '-7.681572900000001', '110.86761323046875', 11, 10),
(131, 0, 'Kabupaten Tegal', '-7.05571835', '109.1326480414001', 14, 10),
(132, 0, 'Kabupaten Temanggung', '-7.2397576', '110.12166479843259', 11, 10),
(133, 0, 'Kabupaten Wonogiri', '-7.9620507', '110.95757325155418', 10, 10),
(134, 0, 'Kabupaten Wonosobo', '-7.39979995', '109.92096446847731', 11, 10),
(135, 0, 'Kota Magelang', '-7.4770747', '110.2182164', 13, 10),
(136, 0, 'Kota Pekalongan', '-6.8939623', '109.6731758', 13, 10),
(137, 0, 'Kota Salatiga', '-7.3302642', '110.4995353', 13, 10),
(138, 0, 'Kota Semarang', '-6.9903988', '110.4229104', 12, 10),
(139, 0, 'Kota Surakarta', '-7.5692462', '110.828448', 13, 10),
(140, 0, 'Kota Tegal', '-6.8673767', '109.1378833', 14, 10),
(141, 0, 'Kabupaten Bangkalan', '-7.04636075', '112.89621220000001', 11, 11),
(142, 0, 'Kabupaten Banyuwangi', '-8.2094973', '114.3737201', 10, 11),
(143, 0, 'Kabupaten Blitar', '-8.0959629', '112.16622889772486', 11, 11),
(144, 0, 'Kabupaten Bojonegoro', '-7.22787145', '111.81462004686449', 10, 11),
(145, 0, 'Kabupaten Bondowoso', '-7.9134402', '113.8222709', 11, 11),
(146, 0, 'Kabupaten Gresik', '-5.79334655', '112.6598223201143', 9, 11),
(147, 0, 'Kabupaten Jember', '-8.1688563', '113.7021772', 10, 11),
(148, 0, 'Kabupaten Jombang', '-7.5419994', '112.22662739779243', 11, 11),
(149, 0, 'Kabupaten Kediri', '-7.8057219', '112.16852174866582', 11, 11),
(150, 0, 'Kabupaten Lamongan', '-7.1229125', '112.32821642481363', 10, 11),
(151, 0, 'Kabupaten Lumajang', '-8.135205', '113.2244162', 11, 11),
(152, 0, 'Kabupaten Madiun', '-7.61188765', '111.67319262808837', 11, 11),
(153, 0, 'Kabupaten Magetan', '-7.6542489', '111.33605653488618', 11, 11),
(154, 0, 'Kabupaten Malang', '-8.10479815', '112.68798721390587', 10, 11),
(155, 0, 'Kabupaten Mojokerto', '-7.54104285', '112.50966915498462', 11, 11),
(156, 0, 'Kabupaten Nganjuk', '-7.61501615', '111.94648226995534', 11, 11),
(157, 0, 'Kabupaten Ngawi', '-7.4039881', '111.4452353', 11, 11),
(158, 0, 'Kabupaten Pacitan', '-8.101787550000001', '111.14464661886814', 11, 11),
(159, 0, 'Kabupaten Pamekasan', '-7.07081335', '113.5003938989593', 11, 11),
(160, 0, 'Kabupaten Pasuruan', '-7.65216805', '112.90804090986751', 11, 11),
(161, 0, 'Kabupaten Ponorogo', '-7.97122665', '111.49889293326967', 11, 11),
(162, 0, 'Kabupaten Probolinggo', '-7.8625016500000005', '113.3051361158501', 10, 11),
(163, 0, 'Kabupaten Sampang', '-7.05781575', '113.25405409767842', 11, 11),
(164, 0, 'Kabupaten Sidoarjo', '-7.4559622', '112.66022171549456', 11, 11),
(165, 0, 'Kabupaten Situbondo', '-7.79855175', '114.26461700861759', 10, 11),
(166, 0, 'Kabupaten Sumenep', '-7.006745', '113.8598666', 8, 11),
(167, 0, 'Kabupaten Trenggalek', '-8.13593475', '111.64019829777817', 10, 11),
(168, 0, 'Kabupaten Tuban', '-6.95940655', '111.89295482591268', 11, 11),
(169, 0, 'Kabupaten Tulungagung', '-8.07290355', '111.89964078880708', 11, 11),
(170, 0, 'Kota Batu', '-7.8711667', '112.5269482', 14, 11),
(171, 0, 'Kota Blitar', '-8.0982442', '112.1650769', 13, 11),
(172, 0, 'Kota Kediri', '-7.8230296', '111.9828778', 13, 11),
(173, 0, 'Kota Madiun', '-7.6290837', '111.5168819', 13, 11),
(174, 0, 'Kota Malang', '-7.9771206', '112.6340291', 12, 11),
(175, 0, 'Kota Mojokerto', '-7.4631537', '112.4319852', 14, 11),
(176, 0, 'Kota Pasuruan', '-7.6419894', '112.906694', 14, 11),
(177, 0, 'Kota Probolinggo', '-7.7441461', '113.2158401', 13, 11),
(178, 0, 'Kota Surabaya', '-7.2459717', '112.7378266', 12, 11),
(179, 0, 'Kabupaten Bengkayang', '1.0157755', '109.7080333243031', 9, 12),
(180, 0, 'Kabupaten Kapuas Hulu', '0.8274259500000001', '112.79654118259097', 9, 12),
(181, 0, 'Kabupaten Kayong Utara', '-1.04349785', '110.05989188182988', 9, 12),
(182, 0, 'Kabupaten Ketapang', '-1.68316725', '110.46418713446013', 8, 12),
(183, 0, 'Kabupaten Kubu Raya', '-0.36948415', '109.5121891456613', 9, 12),
(184, 0, 'Kabupaten Landak', '0.504635', '109.707038346171', 9, 12),
(185, 0, 'Kabupaten Melawi', '-0.7240127000000001', '111.65594047106211', 9, 12),
(186, 0, 'Kabupaten Mempawah', '0.3439129', '109.10682142686656', 10, 12),
(187, 0, 'Kabupaten Sambas', '1.5218292500000001', '109.41402044321927', 9, 12),
(188, 0, 'Kabupaten Sanggau', '0.3502299', '110.54704242825211', 9, 12),
(189, 0, 'Kabupaten Sekadau', '0.0171923', '110.9290041681134', 9, 12),
(190, 0, 'Kabupaten Sintang', '0.1927001', '111.55981182271624', 9, 12),
(191, 0, 'Kota Pontianak', '-0.0226903', '109.3447488', 12, 12),
(192, 0, 'Kota Singkawang', '0.9069861', '108.9889657', 12, 12),
(193, 0, 'Kabupaten Balangan', '-2.2892882', '115.3038795', 10, 13),
(194, 0, 'Kabupaten Banjar', '-3.2765344', '114.7747151', 10, 13),
(195, 0, 'Kabupaten Barito Kuala', '-2.9786333000000003', '114.76580315687343', 9, 13),
(196, 0, 'Kabupaten Hulu Sungai Selatan', '-2.718209', '114.952724', 10, 13),
(197, 0, 'Kabupaten Hulu Sungai Tengah', '-2.6115628', '115.2449065', 10, 13),
(198, 0, 'Kabupaten Hulu Sungai Utara', '-2.4250247', '114.992121', 11, 13),
(199, 0, 'Kabupaten Kotabaru', '-3.2405866', '116.2260644', 8, 13),
(200, 0, 'Kabupaten Tabalong', '-2.1737814999999996', '115.39841146329718', 9, 13),
(201, 0, 'Kabupaten Tanah Bumbu', '-3.4835729', '115.94678643642558', 10, 13),
(202, 0, 'Kabupaten Tanah Laut', '-3.8108699', '114.71805981264072', 10, 13),
(203, 0, 'Kabupaten Tapin', '-2.93099265', '115.15540233352736', 10, 13),
(204, 0, 'Kota Banjarbaru', '-2.6365907', '115.114494', 12, 13),
(205, 0, 'Kota Banjarmasin', '-3.3187496', '114.5925828', 13, 13),
(206, 0, 'Kabupaten Barito Selatan', '-1.7195432', '114.84528123582548', 9, 14),
(207, 0, 'Kabupaten Barito Timur', '-2.08721235', '115.14370054034853', 10, 14),
(208, 0, 'Kabupaten Barito Utara', '-0.95440455', '114.8980045108355', 9, 14),
(209, 0, 'Kabupaten Gunung Mas', '-1.1148383', '113.8322849', 9, 14),
(210, 0, 'Kabupaten Kapuas', '-1.9160557', '113.1004816', 8, 14),
(211, 0, 'Kabupaten Katingan', '-2.2019912', '113.9143771', 8, 14),
(212, 0, 'Kabupaten Kotawaringin Barat', '-2.6865269', '111.629247', 9, 14),
(213, 0, 'Kabupaten Kotawaringin Timur', '-2.5376421000000002', '112.9402385334703', 8, 14),
(214, 0, 'Kabupaten Lamandau', '-2.1648897', '111.42865329022845', 9, 14),
(215, 0, 'Kabupaten Murung Raya', '-0.0366853', '113.6110744', 9, 14),
(216, 0, 'Kabupaten Pulang Pisau', '-2.746171', '114.2622421', 9, 14),
(217, 0, 'Kabupaten Sukamara', '-2.7105638', '111.1714146', 9, 14),
(218, 0, 'Kabupaten Seruyan', '-3.2613363', '112.4858472', 8, 14),
(219, 0, 'Kota Palangka Raya', '-2.2072919', '113.9164372', 13, 14),
(220, 0, 'Kabupaten Berau', '2.1488862', '117.4534366', 8, 15),
(221, 0, 'Kabupaten Kutai Barat', '-0.22330060000000002', '115.70484995181539', 9, 15),
(222, 0, 'Kabupaten Kutai Kartanegara', '-0.43912305', '116.99644747012239', 8, 15),
(223, 0, 'Kabupaten Kutai Timur', '0.51849005', '117.60497826718037', 8, 15),
(224, 0, 'Kabupaten Mahakam Ulu', '0.6645973', '114.2680845', 9, 15),
(225, 0, 'Kabupaten Paser', '-1.8975521', '116.1972106', 9, 15),
(226, 0, 'Kabupaten Penajam Paser Utara', '-1.3059180499999998', '116.73477110023177', 10, 15),
(227, 0, 'Kota Balikpapan', '-1.2398711', '116.8593379', 12, 15),
(228, 0, 'Kota Bontang', '0.1236548', '117.471708', 12, 15),
(229, 0, 'Kota Samarinda', '-0.5017804', '117.1393089', 13, 15),
(230, 0, 'Kabupaten Bulungan', '2.7637659', '117.07428879394345', 9, 16),
(231, 0, 'Kabupaten Malinau', '2.6185545', '115.69049695186618', 8, 16),
(232, 0, 'Kabupaten Nunukan', '3.9074565000000003', '117.04292557222513', 9, 16),
(233, 0, 'Kabupaten Tana Tidung', '3.55533265', '117.04494266875702', 10, 16),
(234, 0, 'Kota Tarakan', '3.3000169', '117.6330159', 12, 16),
(235, 0, 'Kabupaten Bangka', '-1.9250896', '105.93652078561858', 10, 17),
(236, 0, 'Kabupaten Bangka Barat', '-1.8412375', '105.55187121706234', 10, 17),
(237, 0, 'Kabupaten Bangka Selatan', '-2.77689755', '106.29395838150067', 10, 17),
(238, 0, 'Kabupaten Bangka Tengah', '-2.43051555', '106.1001552655625', 10, 17),
(239, 0, 'Kabupaten Belitung', '-2.88428125', '107.6631595873786', 10, 17),
(240, 0, 'Kabupaten Belitung Timur', '-2.9164574', '108.00372175752332', 10, 17),
(241, 0, 'Kota Pangkalpinang', '-2.1206733', '106.1134604', 13, 17),
(242, 0, 'Kabupaten Bintan', '1.01973625', '104.56996247536998', 8, 18),
(243, 0, 'Kabupaten Karimun', '0.7643587000000001', '103.42968306531975', 10, 18),
(244, 0, 'Kabupaten Kepulauan Anambas', '2.93890105', '105.76025801074812', 13, 18),
(245, 0, 'Kabupaten Lingga', '-0.50938725', '104.4145076355', 9, 18),
(246, 0, 'Kabupaten Natuna', '3.9305323000000003', '108.19011958059816', 8, 18),
(247, 0, 'Kota Batam', '1.1061034', '104.0378246', 10, 18),
(248, 0, 'Kota Tanjungpinang', '0.9236915', '104.446094', 13, 18),
(249, 0, 'Kabupaten Lampung Barat', '-5.111704', '104.3057866714262', 9, 19),
(250, 0, 'Kabupaten Lampung Selatan', '-5.5414382', '105.51085426468484', 9, 19),
(251, 0, 'Kabupaten Lampung Tengah', '-4.8728473', '105.32601289261834', 10, 19),
(252, 0, 'Kabupaten Lampung Timur', '-5.1194029', '105.59582454194882', 9, 19),
(253, 0, 'Kabupaten Lampung Utara', '-4.8086085', '104.8628814822757', 10, 19),
(254, 0, 'Kabupaten Mesuji', '-3.97541905', '105.37494356303489', 10, 19),
(255, 0, 'Kabupaten Pesawaran', '-5.4559573', '105.08469101016075', 10, 19),
(256, 0, 'Kabupaten Pesisir Barat', '-5.3669442499999995', '104.18664171357318', 10, 19),
(257, 0, 'Kabupaten Pringsewu', '-5.36668925', '104.97221206481078', 10, 19),
(258, 0, 'Kabupaten Tanggamus', '-5.5136105', '104.77677449829665', 10, 19),
(259, 0, 'Kabupaten Tulang Bawang', '-4.3897631', '105.55088901041721', 10, 19),
(260, 0, 'Kabupaten Tulang Bawang Barat', '-4.43242555', '105.16826426180435', 10, 19),
(261, 0, 'Kabupaten Way Kanan', '-4.56694035', '104.51616024455134', 10, 19),
(262, 0, 'Kota Bandar Lampung', '-5.4460713', '105.2643742', 12, 19),
(263, 0, 'Kota Metro', '-5.1078839', '105.3078642', 13, 19),
(264, 0, 'Kabupaten Buru', '-3.3448211', '126.4106975', 10, 20),
(265, 0, 'Kabupaten Buru Selatan', '-3.5704214', '126.407548', 10, 20),
(266, 0, 'Kabupaten Kepulauan Aru', '-6', '134.5', 9, 20),
(267, 0, 'Kabupaten Maluku Barat Daya', '-8.14794805', '127.80158804748226', 8, 20),
(268, 0, 'Kabupaten Maluku Tengah', '-3.3079212', '128.9558448', 9, 20),
(269, 0, 'Kabupaten Maluku Tenggara', '-5.8902838', '132.7254009', 10, 20),
(270, 0, 'Kabupaten Kepulauan Tanimbar', '-6.013475850000001', '132.4380275954527', 9, 20),
(271, 0, 'Kabupaten Seram Bagian Barat', '-2.4355225', '127.0822825', 8, 20),
(272, 0, 'Kabupaten Seram Bagian Timur', '-3.8782259', '128.0323966', 8, 20),
(273, 0, 'Kota Ambon', '-3.6959434', '128.178785', 12, 20),
(274, 0, 'Kota Tual', '-5.6443094', '132.7416819', 10, 20),
(275, 0, 'Kabupaten Halmahera Barat', '1.0775917', '127.4777743', 9, 21),
(276, 0, 'Kabupaten Halmahera Tengah', '0.3285646', '127.8723998', 9, 21),
(277, 0, 'Kabupaten Halmahera Timur', '0.6897174500000001', '128.29217464614769', 9, 21),
(278, 0, 'Kabupaten Halmahera Selatan', '-0.6273054', '127.4804496', 8, 21),
(279, 0, 'Kabupaten Halmahera Utara', '1.5594309', '127.2744096', 9, 21),
(280, 0, 'Kabupaten Kepulauan Sula', '-1.8314383', '124.82986211229519', 10, 21),
(281, 0, 'Kabupaten Pulau Morotai', '2.3158558', '128.4471652', 10, 21),
(282, 0, 'Kabupaten Pulau Taliabu', '-1.7886947', '124.8027711', 10, 21),
(283, 0, 'Kota Ternate', '0.7852331', '127.3831973', 10, 21),
(284, 0, 'Kota Tidore Kepulauan', '0.6786796', '127.4483156', 10, 21),
(285, 0, 'Kabupaten Bima', '-8.5637593', '118.6719665', 9, 22),
(286, 0, 'Kabupaten Dompu', '-8.5355857', '118.4621733', 10, 22),
(287, 0, 'Kabupaten Lombok Barat', '-8.6718889', '116.122048', 10, 22),
(288, 0, 'Kabupaten Lombok Tengah', '-8.703071', '116.2899373', 10, 22),
(289, 0, 'Kabupaten Lombok Timur', '-8.6330934', '116.5587704', 10, 22),
(290, 0, 'Kabupaten Lombok Utara', '-8.3572425', '116.1609208', 11, 22),
(291, 0, 'Kabupaten Sumbawa', '-8.594687', '117.25874161857084', 9, 22),
(292, 0, 'Kabupaten Sumbawa Barat', '-8.658515', '116.9161845', 10, 22),
(293, 0, 'Kota Bima', '-8.4535168', '118.7276222', 14, 22),
(294, 0, 'Kota Mataram', '-8.5837726', '116.10685', 13, 22),
(295, 0, 'Kabupaten Alor', '-8.29102645', '124.77875134003433', 10, 23),
(296, 0, 'Kabupaten Belu', '-9.176141000000001', '124.91626841454732', 11, 23),
(297, 0, 'Kabupaten Ende', '-8.672867499999999', '121.69291732410474', 11, 23),
(298, 0, 'Kabupaten Flores Timur', '-8.3187084', '123.1656867685976', 10, 23),
(299, 0, 'Kabupaten Kupang', '-10.1632209', '123.6017755', 9, 23),
(300, 0, 'Kabupaten Lembata', '-8.378112999999999', '123.54456885527264', 10, 23),
(301, 0, 'Kabupaten Malaka', '-9.54595915', '124.86358170302012', 10, 23),
(302, 0, 'Kabupaten Manggarai', '-8.5480146', '120.43898618548442', 10, 23),
(303, 0, 'Kabupaten Manggarai Barat', '-8.573199800000001', '120.06157204381154', 10, 23),
(304, 0, 'Kabupaten Manggarai Timur', '-8.57382735', '120.6863591076901', 10, 23),
(305, 0, 'Kabupaten Nagekeo', '-8.6753111', '121.2703967692735', 11, 23),
(306, 0, 'Kabupaten Ngada', '-8.65009555', '120.98673001699343', 10, 23),
(307, 0, 'Kabupaten Rote Ndao', '-10.68702915', '123.20839823893458', 10, 23),
(308, 0, 'Kabupaten Sabu Raijua', '-10.52223145', '121.88845836848473', 10, 23),
(309, 0, 'Kabupaten Sikka', '-8.5946841', '121.9009915', 10, 23),
(310, 0, 'Kabupaten Sumba Barat', '-9.58570915', '119.44394260619363', 11, 23),
(311, 0, 'Kabupaten Sumba Barat Daya', '-9.537821000000001', '119.16231258971519', 11, 23),
(312, 0, 'Kabupaten Sumba Tengah', '-9.5935839', '119.66627706284194', 10, 23),
(313, 0, 'Kabupaten Sumba Timur', '-9.8342576', '120.2094194', 9, 23),
(314, 0, 'Kabupaten Timor Tengah Selatan', '-9.823091000000002', '124.4357334733578', 10, 23),
(315, 0, 'Kabupaten Timor Tengah Utara', '-9.340513000000001', '124.61066614859645', 10, 23),
(316, 0, 'Kota Kupang', '-10.1632209', '123.6017755', 13, 23),
(317, 0, 'Kota Waingapu', '-9.652179', '120.2636908', 13, 23),
(318, 0, 'Kabupaten Asmat', '-5.58400015', '138.6207640795481', 9, 24),
(319, 0, 'Kabupaten Biak Numfor', '-0.94260305', '135.94141931810083', 9, 24),
(320, 0, 'Kabupaten Boven Digoel', '-5.95417775', '140.399225125', 8, 24),
(321, 0, 'Kabupaten Deiyai', '-4.0952689499999995', '136.63261578272633', 10, 24),
(322, 0, 'Kabupaten Dogiyai', '-4.00097085', '135.6469818217036', 10, 24),
(323, 0, 'Kabupaten Intan Jaya', '-3.4060711', '136.6597435709678', 9, 24),
(324, 0, 'Kabupaten Jayapura', '-2.6490556', '140.81262497328123', 9, 24),
(325, 0, 'Kabupaten Jayawijaya', '-4.1152786500000005', '138.9650305928116', 10, 24),
(326, 0, 'Kabupaten Keerom', '-3.2228294', '141.0119998', 9, 24),
(327, 0, 'Kabupaten Kepulauan Yapen', '-1.7564788', '136.3676607823068', 9, 24),
(328, 0, 'Kabupaten Lanny Jaya', '-3.9755732999999998', '138.30192949892472', 10, 24),
(329, 0, 'Kabupaten Mamberamo Raya', '-2.4438847', '137.88213294138217', 9, 24),
(330, 0, 'Kabupaten Mamberamo Tengah', '-3.62066835', '139.06772627653672', 10, 24),
(331, 0, 'Kabupaten Mappi', '-6.248283150000001', '139.37614745563457', 8, 24),
(332, 0, 'Kabupaten Merauke', '-8.4902766', '140.395582', 8, 24),
(333, 0, 'Kabupaten Mimika', '-4.5834512499999995', '136.8270682654405', 8, 24),
(334, 0, 'Kabupaten Nabire', '-3.2048097', '135.97549434733827', 9, 24),
(335, 0, 'Kabupaten Nduga', '-4.43569965', '138.1342176870242', 10, 24),
(336, 0, 'Kabupaten Paniai', '-3.7626846499999997', '136.3724924193569', 10, 24),
(337, 0, 'Kabupaten Pegunungan Bintang', '-4.49910135', '140.488116475', 9, 24),
(338, 0, 'Kabupaten Puncak', '-3.5604522000000003', '137.31857191345932', 9, 24),
(339, 0, 'Kabupaten Puncak Jaya', '-3.48827665', '137.1586126', 10, 24),
(340, 0, 'Kabupaten Sarmi', '-2.54693695', '139.0552597279646', 9, 24),
(341, 0, 'Kabupaten Supiori', '-0.7537058', '135.63486291915163', 10, 24),
(342, 0, 'Kabupaten Tolikara', '-3.4879768', '138.40028166235481', 10, 24),
(343, 0, 'Kabupaten Waropen', '-2.7291479', '136.64559409328393', 9, 24),
(344, 0, 'Kabupaten Yahukimo', '-4.3859774', '139.40798652197418', 9, 24),
(345, 0, 'Kabupaten Yalimo', '-3.78919155', '139.46563759285343', 10, 24),
(346, 0, 'Kota Jayapura', '-2.5387539', '140.7037389', 12, 24),
(347, 0, 'Kota Wamena', '-4.0943705', '138.9466574', 12, 24),
(348, 0, 'Kabupaten Fakfak', '-2.9298174', '132.2961612', 9, 25),
(349, 0, 'Kabupaten Kaimana', '-3.6642872', '133.7619247', 9, 25),
(350, 0, 'Kabupaten Manokwari', '-0.8614456', '134.0767324', 13, 25),
(351, 0, 'Kabupaten Manokwari Selatan', '-1.50643065', '134.1687124', 10, 25),
(352, 0, 'Kabupaten Maybrat', '-1.42418', '132.087792', 10, 25),
(353, 0, 'Kabupaten Pegunungan Arfak', '-1.2315111', '134.08753103724572', 10, 25),
(354, 0, 'Kabupaten Raja Ampat', '-0.5872875', '129.198805', 8, 25),
(355, 0, 'Kabupaten Sorong', '-1.0522182', '130.832303', 9, 25),
(356, 0, 'Kabupaten Sorong Selatan', '-1.6674677', '131.5579206', 9, 25),
(357, 0, 'Kabupaten Tambrauw', '-0.7858105', '132.4177316', 10, 25),
(358, 0, 'Kabupaten Teluk Bintuni', '-2.0869357', '132.7619131', 9, 25),
(359, 0, 'Kabupaten Teluk Wondama', '-2.6501606', '134.42741271113243', 9, 25),
(360, 0, 'Kota Sorong', '-0.8634105', '131.2544805', 13, 25),
(361, 0, 'Kabupaten Bengkalis', '1.76972265', '101.91243842805495', 9, 26),
(362, 0, 'Kabupaten Indragiri Hilir', '-0.27088504999999996', '103.32845658847006', 9, 26),
(363, 0, 'Kabupaten Indragiri Hulu', '-0.49228384999999997', '102.30082544534002', 9, 26),
(364, 0, 'Kabupaten Kampar', '0.3203257', '100.5008735', 9, 26),
(365, 0, 'Kabupaten Kepulauan Meranti', '1.0613049', '102.7019636364293', 10, 26),
(366, 0, 'Kabupaten Kuantan Singingi', '-0.49417425', '101.49011355902836', 10, 26),
(367, 0, 'Kabupaten Pelalawan', '0.3944965', '101.96933', 9, 26),
(368, 0, 'Kabupaten Rokan Hilir', '0.9751078', '117.5295601', 9, 26),
(369, 0, 'Kabupaten Rokan Hulu', '0.8919457', '100.46651555651417', 9, 26),
(370, 0, 'Kabupaten Siak', '0.8275337', '101.84619364844389', 9, 26),
(371, 0, 'Kota Dumai', '1.6318056', '101.4424177', 13, 26),
(372, 0, 'Kota Pekanbaru', '0.5262455', '101.4515727', 12, 26),
(373, 0, 'Kabupaten Majene', '-3.5459286', '118.9607438', 10, 27),
(374, 0, 'Kabupaten Mamasa', '-2.9427309', '119.3761919', 10, 27),
(375, 0, 'Kabupaten Mamuju', '-2.6756302', '118.8847947', 10, 27),
(376, 0, 'Kabupaten Mamuju Tengah', '-2.0209398', '119.2216415', 10, 27),
(377, 0, 'Kabupaten Pasangkayu', '-1.1754171', '119.3638372', 10, 27),
(378, 0, 'Kabupaten Polewali Mandar', '-3.40764725', '119.31092350293238', 11, 27),
(379, 0, 'Kabupaten Bantaeng', '-5.5428215', '119.932609', 12, 28),
(380, 0, 'Kabupaten Barru', '-4.4136665', '119.6194705', 10, 28),
(381, 0, 'Kabupaten Bone', '-5.2933829', '119.416009', 10, 28),
(382, 0, 'Kabupaten Bulukumba', '-5.5518642', '120.1923864', 11, 28),
(383, 0, 'Kabupaten Enrekang', '-3.4880125', '119.8658463', 10, 28),
(384, 0, 'Kabupaten Gowa', '-5.200563', '119.48873', 11, 28),
(385, 0, 'Kabupaten Jeneponto', '-5.4931474', '119.5771474', 11, 28),
(386, 0, 'Kabupaten Kepulauan Selayar', '-7.3014876', '120.9626595', 9, 28),
(387, 0, 'Kabupaten Luwu', '-3.1664873', '119.5855578', 9, 28),
(388, 0, 'Kabupaten Luwu Timur', '-2.516425', '120.8171774', 10, 28),
(389, 0, 'Kabupaten Luwu Utara', '-2.5951257', '120.2562544', 9, 28),
(390, 0, 'Kabupaten Maros', '-4.9233446999999995', '119.55391756004477', 10, 28),
(391, 0, 'Kabupaten Pangkajene dan Kepulauan', '-4.834493', '119.5471569', 8, 28),
(392, 0, 'Kabupaten Pinrang', '-3.7932568', '119.6528692', 10, 28),
(393, 0, 'Kabupaten Sidenreng Rappang', '-3.8080481', '119.7176949', 10, 28),
(394, 0, 'Kabupaten Sinjai', '-5.2514674', '120.16324283403677', 11, 28),
(395, 0, 'Kabupaten Soppeng', '-4.269139', '119.6341799', 11, 28),
(396, 0, 'Kabupaten Takalar', '-5.4683616', '119.4080649', 11, 28),
(397, 0, 'Kabupaten Tana Toraja', '-3.1169403', '119.6937644', 10, 28),
(398, 0, 'Kabupaten Toraja Utara', '-2.9694952', '119.9013306', 10, 28),
(399, 0, 'Kabupaten Wajo', '-4.0938145', '120.024645', 10, 28),
(400, 0, 'Kota Makassar', '-5.1342962', '119.4124282', 12, 28),
(401, 0, 'Kota Palopo', '-2.9996306', '120.1920679', 12, 28),
(402, 0, 'Kota Parepare', '-4.0057055', '119.6236101', 13, 28),
(403, 0, 'Kabupaten Banggai', '-1.588821', '123.5008494', 9, 29),
(404, 0, 'Kabupaten Banggai Kepulauan', '-1.3518454', '123.1808567', 10, 29),
(405, 0, 'Kabupaten Banggai Laut', '-1.8428484', '123.1024115569098', 10, 29),
(406, 0, 'Kabupaten Buol', '1.0123735', '121.3120524', 10, 29),
(407, 0, 'Kabupaten Donggala', '-1.04261765', '119.67446926506551', 8, 29),
(408, 0, 'Kabupaten Morowali', '-2.7234062000000003', '121.88734129422215', 9, 29),
(409, 0, 'Kabupaten Morowali Utara', '-1.8418842', '121.07716959122936', 9, 29),
(410, 0, 'Kabupaten Parigi Moutong', '-0.23836055', '119.95993110540971', 9, 29),
(411, 0, 'Kabupaten Poso', '-1.6568513', '120.5421575', 9, 29),
(412, 0, 'Kabupaten Sigi', '-1.3211588', '119.9987265', 9, 29),
(413, 0, 'Kabupaten Tojo Una-Una', '-0.32275895', '122.11292434665145', 9, 29),
(414, 0, 'Kabupaten Tolitoli', '0.9702058', '120.87564686830812', 10, 29),
(415, 0, 'Kota Palu', '-0.9051548', '119.8722373', 11, 29),
(416, 0, 'Kabupaten Bombana', '-4.7748135', '122.0497468', 9, 30),
(417, 0, 'Kabupaten Buton', '-5.0347675', '122.886341915647', 9, 30),
(418, 0, 'Kabupaten Buton Selatan', '-6.2017118', '122.7017835', 9, 30),
(419, 0, 'Kabupaten Buton Tengah', '-5.31646095', '122.53190444027867', 10, 30),
(420, 0, 'Kabupaten Buton Utara', '-4.804624', '123.1752067', 10, 30),
(421, 0, 'Kabupaten Kolaka', '-4.059702', '121.605559', 10, 30),
(422, 0, 'Kabupaten Kolaka Timur', '-3.8202432', '121.0067885', 9, 30),
(423, 0, 'Kabupaten Kolaka Utara', '-3.50075395', '120.87572985570839', 10, 30),
(424, 0, 'Kabupaten Konawe', '-4.7253761', '122.6337725', 9, 30),
(425, 0, 'Kabupaten Konawe Kepulauan', '-4.1193402', '122.9572076', 11, 30),
(426, 0, 'Kabupaten Konawe Selatan', '-4.3088585', '122.4481311', 10, 30),
(427, 0, 'Kabupaten Konawe Utara', '-3.51231405', '122.11070972786558', 9, 30),
(428, 0, 'Kabupaten Muna', '-5.0260438', '122.53255382153739', 10, 30),
(429, 0, 'Kabupaten Muna Barat', '-4.872141', '122.2681972', 10, 30),
(430, 0, 'Kabupaten Wakatobi', '-5.6701971', '123.2334567', 9, 30),
(431, 0, 'Kota Bau-Bau', '-5.4578127', '122.59847622680101', 12, 30),
(432, 0, 'Kota Kendari', '-3.9918068', '122.5180066', 12, 30),
(433, 0, 'Kabupaten Bolaang Mongondow', '0.87039265', '124.024471', 10, 31),
(434, 0, 'Kabupaten Bolaang Mongondow Selatan', '0.3825211', '124.04995021448846', 10, 31),
(435, 0, 'Kabupaten Bolaang Mongondow Timur', '0.76828165', '124.61315939989817', 11, 31),
(436, 0, 'Kabupaten Bolaang Mongondow Utara', '0.9049153999999999', '123.2602387477032', 11, 31),
(437, 0, 'Kabupaten Kepulauan Sangihe', '2.35', '125.42024618131421', 9, 31),
(438, 0, 'Kabupaten Kepulauan Siau Tagulandang Biaro', '2.4406748', '125.0492489', 10, 31),
(439, 0, 'Kabupaten Kepulauan Talaud', '4.2695451', '126.81356391468105', 8, 31),
(440, 0, 'Kabupaten Minahasa', '1.2411678', '124.673663', 11, 31),
(441, 0, 'Kabupaten Minahasa Selatan', '1.2028973', '124.6248196', 10, 31),
(442, 0, 'Kabupaten Minahasa Tenggara', '0.982506', '124.610312', 11, 31),
(443, 0, 'Kabupaten Minahasa Utara', '1.7915', '125.155', 10, 31),
(444, 0, 'Kota Bitung', '1.44344', '125.1940836', 12, 31),
(445, 0, 'Kota Kotamobagu', '0.7352231', '124.3154057', 13, 31),
(446, 0, 'Kota Manado', '1.4900578', '124.8408708', 12, 31),
(447, 0, 'Kota Tomohon', '1.3255914', '124.838605', 13, 31),
(448, 0, 'Kabupaten Agam', '-0.2634005', '100.17201627524973', 10, 32),
(449, 0, 'Kabupaten Dharmasraya', '-1.0585388500000001', '101.64402551163604', 10, 32),
(450, 0, 'Kabupaten Kepulauan Mentawai', '-1.3592423', '98.89517895383435', 8, 32),
(451, 0, 'Kabupaten Lima Puluh Kota', '-0.0041436', '100.55927144934107', 10, 32),
(452, 0, 'Kabupaten Padang Pariaman', '-2.96446', '119.3122747', 10, 32),
(453, 0, 'Kabupaten Pasaman', '0.3949695', '100.19155726006841', 9, 32),
(454, 0, 'Kabupaten Pasaman Barat', '0.1875976', '99.68987375527963', 10, 32),
(455, 0, 'Kabupaten Pesisir Selatan', '-1.3486632', '100.5742238', 9, 32),
(456, 0, 'Kabupaten Sijunjung', '-0.6664603', '100.9448719', 10, 32),
(457, 0, 'Kabupaten Solok', '-0.9275229', '100.5576869', 10, 32),
(458, 0, 'Kabupaten Solok Selatan', '-1.5690427', '101.2509637', 10, 32),
(459, 0, 'Kabupaten Tanah Datar', '-0.4698171', '100.4427065', 11, 32),
(460, 0, 'Kota Bukittinggi', '-0.3051954', '100.3694921', 14, 32),
(461, 0, 'Kota Padang', '-0.9247587', '100.3632561', 11, 32),
(462, 0, 'Kota Padangpanjang', '-0.4654636', '100.3932441', 14, 32),
(463, 0, 'Kota Pariaman', '-0.6263889', '100.1177778', 13, 32),
(464, 0, 'Kota Payakumbuh', '-0.2249721', '100.6318259', 13, 32),
(465, 0, 'Kota Sawahlunto', '-0.6818141', '100.778552', 12, 32),
(466, 0, 'Kota Solok', '-0.7922164', '100.6573316', 14, 32),
(467, 0, 'Kabupaten Banyuasin', '-2.3939715', '104.7615778473609', 9, 33),
(468, 0, 'Kabupaten Empat Lawang', '-3.7154833', '102.93247238633131', 10, 33),
(469, 0, 'Kabupaten Lahat', '-3.87934575', '103.41408633497844', 10, 33),
(470, 0, 'Kabupaten Muara Enim', '-3.6500887', '103.7719601', 9, 33),
(471, 0, 'Kabupaten Musi Banyuasin', '-2.4960205', '103.70585414434265', 9, 33),
(472, 0, 'Kabupaten Musi Rawas', '-3.17575595', '103.25001093605792', 10, 33),
(473, 0, 'Kabupaten Musi Rawas Utara', '-2.7076641500000003', '102.91281815752576', 10, 33),
(474, 0, 'Kabupaten Ogan Ilir', '-3.39816945', '104.65249983252004', 10, 33),
(475, 0, 'Kabupaten Ogan Komering Ilir', '-3.3284617', '105.39907619749494', 9, 33),
(476, 0, 'Kabupaten Ogan Komering Ulu', '-4.1101012', '104.00828376734528', 10, 33),
(477, 0, 'Kabupaten Ogan Komering Ulu Selatan', '-4.5702304', '103.92495365763118', 10, 33),
(478, 0, 'Kabupaten Ogan Komering Ulu Timur', '-4.11600925', '104.55848109942238', 10, 33),
(479, 0, 'Kabupaten Penukal Abab Lematang Ilir', '-3.21399505', '104.0076940890376', 11, 33),
(480, 0, 'Kota Lubuklinggau', '-3.2919136', '102.8715732', 13, 33),
(481, 0, 'Kota Pagar Alam', '-4.0209526', '103.2501603', 13, 33),
(482, 0, 'Kota Palembang', '-2.9888297', '104.756857', 12, 33),
(483, 0, 'Kota Prabumulih', '-3.4382688', '104.2310181', 14, 33),
(484, 0, 'Kabupaten Asahan', '3.0963433', '99.8905262468976', 10, 34),
(485, 0, 'Kabupaten Batu Bara', '3.5564885999999998', '99.62844660427132', 11, 34),
(486, 0, 'Kabupaten Dairi', '2.83535', '97.9753284', 10, 34),
(487, 0, 'Kabupaten Deli Serdang', '3.6947182', '98.83100147255647', 10, 34),
(488, 0, 'Kabupaten Humbang Hasundutan', '2.2475810000000003', '98.60101988220362', 10, 34),
(489, 0, 'Kabupaten Karo', '3.09987505', '98.33697063830981', 10, 34),
(490, 0, 'Kabupaten Labuhanbatu', '2.5506029999999997', '100.19990174869335', 10, 34),
(491, 0, 'Kabupaten Labuhanbatu Selatan', '1.83365285', '100.06837229666323', 10, 34),
(492, 0, 'Kabupaten Labuhanbatu Utara', '2.4634731', '99.72287582407526', 10, 34),
(493, 0, 'Kabupaten Langkat', '3.8290501', '98.24827397454335', 9, 34),
(494, 0, 'Kabupaten Mandailing Natal', '0.7450915', '99.2187861559504', 9, 34),
(495, 0, 'Kabupaten Nias', '1.16667915', '97.96929227407506', 11, 34),
(496, 0, 'Kabupaten Nias Barat', '0.8964868', '97.34333753010097', 11, 34),
(497, 0, 'Kabupaten Nias Selatan', '0.0680552', '98.26223886860505', 9, 34),
(498, 0, 'Kabupaten Nias Utara', '1.37475605', '97.14456926033733', 11, 34),
(499, 0, 'Kabupaten Padang Lawas', '1.1565902000000001', '99.81080407051435', 10, 34),
(500, 0, 'Kabupaten Padang Lawas Utara', '1.6364047', '99.69103752459654', 10, 34),
(501, 0, 'Kabupaten Pakpak Bharat', '2.52988165', '98.26785829127267', 10, 34),
(502, 0, 'Kabupaten Samosir', '2.5447288500000003', '98.57113620961772', 11, 34),
(503, 0, 'Kabupaten Serdang Bedagai', '3.593005', '99.1581740765854', 10, 34),
(504, 0, 'Kabupaten Simalungun', '2.9505160999999998', '98.78353062383172', 10, 34),
(505, 0, 'Kabupaten Tapanuli Selatan', '1.3870258500000001', '99.27384672596114', 9, 34),
(506, 0, 'Kabupaten Tapanuli Tengah', '1.82312845', '98.27976773073217', 10, 34),
(507, 0, 'Kabupaten Tapanuli Utara', '1.9980604', '99.06476586250317', 10, 34),
(508, 0, 'Kabupaten Toba', '2.385554', '98.9681804', 10, 34),
(509, 0, 'Kota Binjai', '3.6063964', '98.4899865', 13, 34),
(510, 0, 'Kota Gunungsitoli', '1.2900569', '97.6150768', 13, 34),
(511, 0, 'Kota Medan', '3.5896654', '98.6738261', 11, 34),
(512, 0, 'Kota Padangsidempuan', '1.3765441', '99.27188284974116', 12, 34),
(513, 0, 'Kota Pematangsiantar', '3.0410509', '99.0878448', 12, 34),
(514, 0, 'Kota Sibolga', '1.736957', '98.78461', 14, 34),
(515, 0, 'Kota Tanjungbalai', '2.9672569', '99.7529882', 13, 34),
(516, 0, 'Kota Tebing Tinggi', '3.3273686', '99.1623025', 13, 34);

-- --------------------------------------------------------

--
-- Table structure for table `master_mitra`
--

CREATE TABLE `master_mitra` (
  `id` int(11) NOT NULL,
  `nama_mitra` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_mitra`
--

INSERT INTO `master_mitra` (`id`, `nama_mitra`) VALUES
(1, 'Kementerian Dalam Negeri '),
(2, 'Kementerian Lingkungan Hidup dan Kehutanan'),
(3, 'Kementerian Sosial '),
(4, 'Kementerian Kelautan dan Perikanan'),
(5, 'Kementerian Agama'),
(6, 'Kementerian PUPR'),
(7, 'Kementerian Hukum dan HAM'),
(8, 'Kementerian Kesehatan'),
(9, 'Kementerian Pertanian'),
(10, 'Kementerian Koperasi dan UMKM'),
(11, 'Badan Nasional Penanggulangan Bencana'),
(12, 'Bappenas'),
(13, 'Kementerian Pendidikan dan Kebudayaan'),
(14, 'Kementerian Tenaga Kerja'),
(15, 'Kementerian Energi dan Sumber Daya Mineral'),
(16, 'Kementerian Koordinator Bidang Pembangunan Manusia dan Kebudayaan'),
(17, 'Kementerian Komunikasi dan Informasi'),
(18, 'Kementerian Parawisata'),
(19, 'Kementerian Perhubungan'),
(20, 'Kementerian Pemuda dan Olahraga'),
(21, 'Kementerian Koordinator Bidang Kemaritiman'),
(22, 'Kementerian Keuangan'),
(23, 'Kementerian Agraria dan Tata Ruang'),
(24, 'Kementerian Desa, Pembangunan Daerah Tertinggal dan Transmigrasi'),
(25, 'Arsip Nasional RI'),
(26, 'Badan Informasi Geospasial'),
(27, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `master_mitralokal`
--

CREATE TABLE `master_mitralokal` (
  `id` int(11) NOT NULL,
  `nama_mitralokal` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_mitralokal`
--

INSERT INTO `master_mitralokal` (`id`, `nama_mitralokal`) VALUES
(1, 'AKATIGA'),
(2, 'AKSANSI (Asosiasi KSM Sanitasi Seluruh Indonesia).'),
(3, 'Aliansi Desa Sejahtera'),
(4, 'Aliansi Jurnalis Independen (AJI)'),
(5, 'Aliansi Masyarakat Adat Nusantara (AMAN)'),
(6, 'Aliansi Perempuan Marangin '),
(7, 'Angel Investment Network Indonesia (ANGIN)'),
(8, 'APINDO (Asosiasi Pengusaha Indonesia)'),
(9, 'Article 33 Indonesia'),
(10, 'Arus Pelangi'),
(11, 'Asosiasi Pendamping Perempuan Usaha Kecil (ASPPUK)'),
(12, 'Badan Registrasi Wilayah Adat (BRWA)'),
(13, 'Bengkel APPEK'),
(14, 'Besse Kajuara (BESKAR) Bone'),
(15, 'BEST (Bina Ekonomi Sosial Terpadu).'),
(16, 'BITRA Indonesia'),
(17, 'Bojonegoro Institute'),
(18, 'CD Bathesda'),
(19, 'Center for Indonesia\'s Strategic Development  Initiatives (CISDI)'),
(20, 'Centre for Innovation Policy and Governance (CIPG)'),
(21, 'Ciliwung Merdeka'),
(22, 'Combine Resources Institution'),
(23, 'Communication for Change'),
(24, 'Compassion'),
(25, 'Dena Upakara'),
(26, 'Dewan Kesenian Jakarta'),
(27, 'Difabel Slawi Mandiri'),
(28, 'Djokosoetono Research Center Universitas Indonesia'),
(29, 'Dompet Dhuafa'),
(30, 'Elpagar'),
(31, 'ELSHAM Papua'),
(32, 'Forum Indonesia untuk Transparansi Anggaran (FITRA)'),
(33, 'Forum Komunikasi Difabel Cirebon '),
(34, 'Forum Komunikasi Kelapa Sawit Berkelanjutan'),
(35, 'Forum Lenteng'),
(36, 'Forum Zakat'),
(37, 'Gaya Nusantara'),
(38, 'Gema Alam (Gerakan Masyarakat Cinta Alam)'),
(39, 'Gerakan Peduli Disabilitas Dan Lepra Indonesia (GPDLI)'),
(40, 'GWL-INA'),
(41, 'Himpunan Serikat Perempuan Indonesia (HAPSARI)'),
(42, 'Himpunan Wanita Disabilitas Indonesia (HWDI)'),
(43, 'Humanitarian Forum Indonesia (HFI)'),
(44, 'Hutan Kita Institute '),
(45, 'Ide dan Analitika Indonesia (IDEA)'),
(46, 'Ikatan Petani Pengendalian Hama Terpadu Indonesia (IPPTHI) Jabar'),
(47, 'Indonesia AIDS Coalition'),
(48, 'Indonesia Business Link '),
(49, 'Indonesia Center for Environmental Law (ICEL)'),
(50, 'Indonesia Corruption Watch (ICW)'),
(51, 'Indonesia Information and Communication Technology Partner Association (ICT Watch)'),
(52, 'Indonesian Consortium for Religious Studies (ICRS)'),
(53, 'Indonesian Visual Art Archive'),
(54, 'Infest Yogyakarta'),
(55, 'Inspire NGO Consulting'),
(56, 'Institut Ungu'),
(57, 'Institute for Essential Services Reform (IESR)'),
(58, 'Institute Pluralisme Indonesia (IPI)'),
(59, 'International Conference on Religion and Peace (ICRP)'),
(60, 'International NGO Forum on Indonesian Development (INFID)'),
(61, 'Jaringan Kerja Lembaga Pelayanan Kristen (JKLPK) '),
(62, 'Jaringan Kerja Pemataan Partisipatif (JKPP)'),
(63, 'Jaringan Kerja Penyelamat Hutan Riau (Jikalahari)'),
(64, 'Jaringan Kerja Rakyat (JERAT) Papua'),
(65, 'Jaringan Nasional Perempuan Mahardika'),
(66, 'Jejaring Mitra Kemanusiaan (JMK)'),
(67, 'Jemari Sekato'),
(68, 'JUBI Papua'),
(69, 'Karya Bakti'),
(70, 'Kelompok Studi dan Pengembangan Prakarsa Masyarakat (KSPPM) Sumatera Utara'),
(71, 'Kemitraan bagi Pembaruan Tata Pemerintahan'),
(72, 'Kipas Makassar'),
(73, 'Koalisi Perempuan Indonesia (KPI)'),
(74, 'Koalisi Rakyat untuk Kedaulatan Pangan (KRKP)'),
(75, 'Koalisi untuk Pemberdayaan Masyarakat Sipil (KUPAS)'),
(76, 'Komisi Penyiaran Indonesia (KPI)'),
(77, 'Komite Kemanusiaan Indonesia'),
(78, 'Komunitas Konservasi Indonesia (KKI)'),
(79, 'KONSEPSI (Konsorsium untuk Studi dan Pembangunan Partisipasi)'),
(80, 'Konsil LSM'),
(81, 'Konsorsium Pembaruan Agraria (KPA)'),
(82, 'KOSLATA (Kelompok Study Lingkungan dan Pariwisata)'),
(83, 'KPKC GKI (Keadilan Perdamaian Dan Keutuhan Ciptaan - Gereja Kristen Injil Di Tanah Papua)'),
(84, 'LBH Apik (Asosiasi Perempuan Indonesia untuk Keadilan).'),
(85, 'LBH Forum Adil Sejahtera'),
(86, 'Legal Resources Center- Untuk Keadilan Jender Dan Hak Asasi Manusia (LRC-KJHAM)'),
(87, 'Lembaga Gemawan'),
(88, 'Lembaga Maritim Nusantara (LEMSA)'),
(89, 'Lembaga Penelitian dan Pengembangan Sumber Daya dan Lingkungan Hidup (LPPSLH)'),
(90, 'Lembaga Pengembangan Partisipasi Demokrasi dan Ekonomi Rakyat (LP2DER)'),
(91, 'Lentera Rakyat'),
(92, 'Lingkar Temu Kabupaten Lestari'),
(93, 'LINK-AR (Lingkaran Advokasi dan Riset) Borneo'),
(94, 'LPTP (Lembaga Pengembangan Teknologi Pedesaan).'),
(95, 'Masyarakat Mitra Konservasi'),
(96, 'Masyarakat Penanggulangan Bencana Indonesia (MBPI)'),
(97, 'Media Link'),
(98, 'Migrant Care'),
(99, 'Muda Berdaya Berkarya '),
(100, 'Non-Timber Forest Products (NTFP)'),
(101, 'Oikumene HKBP'),
(102, 'Pattiro '),
(103, 'Pencerah Nusantara'),
(104, 'Perempuan Kepala Keluarga (PEKKA)'),
(105, 'Perhimpunan Bantuan Hukum dan Advokasi Rakyat Sumatera Utara (BAKUMSU)'),
(106, 'Perhimpunan Filantropi Indonesia'),
(107, 'Perhimpunan Mandiri Kusta (PERMATA)'),
(108, 'Perhimpunan untuk Studi dan Pengembangan Ekonomi dan Sosial (PERSEPSI)'),
(109, 'Perhimpungan Pengembangan Media Nusantara (PPMN)'),
(110, 'Perkumpulan Forest Watch Indonesia'),
(111, 'Perkumpulan Gerakan Digital Bangsa'),
(112, 'Perkumpulan Inisiatif'),
(113, 'Perkumpulan Keluarga Berencana Indonesia (PKBI)'),
(114, 'Perkumpulan Komiter Kemitraan Indonesia untuk Penanggulangan Kemiskinan (KKIPK)'),
(115, 'Perkumpulan Kultura'),
(116, 'Perkumpulan Lingkaran Pendidikan Alternatif untuk Perempuan (KAPAL Perempuan)'),
(117, 'Perkumpulan Masyarakat SETARA'),
(118, 'Perkumpulan Organisasi Harapan Nusantara (OHANA)'),
(119, 'Perkumpulan Pamflet Generasi'),
(120, 'Perkumpulan Partisipasi Indonesia'),
(121, 'Perkumpulan Perempuan Lintas Batas (Peretas)'),
(122, 'Perkumpulan PIKUL'),
(123, 'Perkumpulan Prakarsa '),
(124, 'Perkumpulan Relawan CIS Timor'),
(125, 'Perkumpulan Sasana Inklusi dan Gerakan Advokasi Difabel (SIGAB)'),
(126, 'Perkumpulan untuk Pembaharuan Hukum Berbasis Masyarakat dan Ekologis (HUMA)'),
(127, 'Perkumpulan Untuk Peningkatan Usaha Kecil (PUPUK)'),
(128, 'Persekutuan Daikonia Pelangi Kasih (PDPK)'),
(129, 'Pertanian Selaras Alam (PETRASA) Sumut'),
(130, 'PIRAC (Public Interest Research and Advocacy Public)'),
(131, 'Plan C Institute'),
(132, 'PP Salimah'),
(133, 'PT. Alam Bukit Tigapuluh '),
(134, 'PT. Core Nusa Perkasa'),
(135, 'PT. Daya Teknologi Strategi Indonesia'),
(136, 'PT. Katadata Indonesia'),
(137, 'PT. Koko Smart'),
(138, 'PT. Serasi Kelola Alam'),
(139, 'PT. Setoko Jaya Mandiri'),
(140, 'PT. Talamedia'),
(141, 'PUPUK'),
(142, 'PUSAD Paramadina'),
(143, 'Pusat Kajian dan Perlindungan Anak (PKPA)'),
(144, 'Pusat Pemilihan Umum Disabilitas'),
(145, 'Pusat Rehabilitasi Yakkum'),
(146, 'Pusat Studi Hukum Energi dan Pembangunan (PUSHEP)'),
(147, 'Pusat Studi Kependudukan dan Kebijakan UGM'),
(148, 'Puska Gender dan Seksualitas FISIP UI'),
(149, 'Puskapol FISIP UI'),
(150, 'Rahima'),
(151, 'Samdhana Institute'),
(152, 'Sanggar Suara Perempuan'),
(153, 'Sanggar Suara Perempuan (SSP) Soe'),
(154, 'SANTAI (Yayasan Tunas Alam Indonesia)'),
(155, 'Sekolahdesa'),
(156, 'Sentra Advokasi Perempuan Difabel dan Anak (SAPDA)'),
(157, 'Serikat Petani Indonesia'),
(158, 'So Rehab Bali'),
(159, 'Solidaritas Perempuan untuk Kemanusiaan dan Hak Asasi Manusia (SPEK-HAM) Solo'),
(160, 'Somasi NTB'),
(161, 'Sulawesi Community Foundation'),
(162, 'Tanoker Jember'),
(163, 'Teater Satu Lampung'),
(164, 'The Conversation Indonesia'),
(165, 'The Indonesia Business Council for Sustainable Development (IBCSD)'),
(166, 'The Prakarsa'),
(167, 'Totalitas Padang'),
(168, 'Transparency International (TI) Indonesia'),
(169, 'Trend Asia'),
(170, 'Ubud Writer and Readers Festival'),
(171, 'UCP Roda untuk Kemanusiaan'),
(172, 'UGM'),
(173, 'Unit Pelayanan Informasi Perempuan dan Anak (UPIPA) Wonosobo'),
(174, 'Universitas Airlangga'),
(175, 'Universitas Bina Nusantara'),
(176, 'Universitas Diponogoro'),
(177, 'Universitas Gajah Mada'),
(178, 'Universitas Gajah Mada'),
(179, 'Universitas HKBP Nommensen'),
(180, 'Universitas Indonesia'),
(181, 'Universitas Islam Negeri Sunan Kalijaga'),
(182, 'Universitas Islam Negeri Syarif Hidayatullah'),
(183, 'Universitas Kristen Duta Wacana'),
(184, 'Universitas Nasional'),
(185, 'Universitas Parahyangan'),
(186, 'Universitas Paramadina'),
(187, 'Universitas Trisakti'),
(188, 'UNLTD Indonesia'),
(189, 'Violet Grey Aceh'),
(190, 'Woman Crisis Center (WCC) Palembang'),
(191, 'WWF Indonesia'),
(192, 'YAKOMA PGI'),
(193, 'Yapensa'),
(194, 'Yappika'),
(195, 'Yayasan Air Putih'),
(196, 'Yayasan Amnaut Bife \'Kuan\''),
(197, 'Yayasan Anak Dusun Papua (YADUPA)'),
(198, 'Yayasan Ate Keleng '),
(199, 'Yayasan Auriga Nusantara'),
(200, 'Yayasan Bani Abdurrahman Wahid'),
(201, 'Yayasan Bina Integrasi Edukasi'),
(202, 'Yayasan Cipta Cara Padu'),
(203, 'Yayasan Desantara'),
(204, 'Yayasan Ekosistem Lestari (YEL)'),
(205, 'Yayasan Fahmina'),
(206, 'Yayasan Jerami'),
(207, 'Yayasan Kajian Pemberdayaan Masyarakat (YKPM)'),
(208, 'Yayasan Kalyana Shira'),
(209, 'Yayasan Kalyanamitra'),
(210, 'Yayasan Kampung Halaman'),
(211, 'Yayasan Karina'),
(212, 'Yayasan Katalis'),
(213, 'Yayasan KEHATI'),
(214, 'Yayasan Kehutanan Masyarakat Lestari (YKML)'),
(215, 'Yayasan Komunitas Berdaya Indonesia'),
(216, 'Yayasan Konservasi Alam Nusantara'),
(217, 'Yayasan Konservasi Laut (YKL)'),
(218, 'Yayasan Konservasi Satwa Liar Indonesia (YKSLI)'),
(219, 'Yayasan Kopernik'),
(220, 'Yayasan Kota Kita Surakarta'),
(221, 'Yayasan Kristen Untuk Kesehatan Umum (YAKKUM)'),
(222, 'Yayasan Lembaga Konsumen Indonesia'),
(223, 'Yayasan Lembaga Pengembangan Ekonomi dan Keuangan (INDEF)'),
(224, 'Yayasan Maha Bhoga Marga '),
(225, 'Yayasan Mandiri Kreatif Indonesia (Yamakindo)'),
(226, 'Yayasan Masyarakat Mandiri Film Indonesia (In-Docs)'),
(227, 'Yayasan Mitra Tani Mandiri NTT'),
(228, 'Yayasan Orang Tua Peduli'),
(229, 'Yayasan Pecinta Budaya Bebali'),
(230, 'Yayasan Pembangunan Kesehatan Masyarakat Desa (PMKD) Serukam '),
(231, 'Yayasan Penabalu'),
(232, 'Yayasan Pendidikan Internasional Indonesia'),
(233, 'Yayasan Pengembangan Kesehatan Masyarakat (YPKM) Papua'),
(234, 'Yayasan Pengkajian dan Pengembangan Sosial (YPPS)'),
(235, 'Yayasan Perspektif Baru'),
(236, 'Yayasan Pijer Podi (YAPIDI) Sumut'),
(237, 'Yayasan PULIH'),
(238, 'Yayasan Pusat Film Indonesia'),
(239, 'Yayasan Rekam Jejak Alam Nusantara'),
(240, 'Yayasan Ruang Rupa'),
(241, 'Yayasan Rujak Center for Urban Studies'),
(242, 'Yayasan Rumah Energi'),
(243, 'Yayasan Rumah Kita Bersama'),
(244, 'Yayasan Satu Dunia'),
(245, 'Yayasan Satunama'),
(246, 'Yayasan SHEEP Indonesia'),
(247, 'Yayasan SMERU'),
(248, 'Yayasan Swadaya Dian Khatulistiwa'),
(249, 'Yayasan Traction Energy Asia'),
(250, 'Yayasan Tranformasi Lepra Indonesia'),
(251, 'Yayasan Transparansi Sumber Daya Ekstraktif (PWYP Indonesia)'),
(252, 'Yayasan Umar Kayam'),
(253, 'Yayasan Wakaf Paramadina'),
(254, 'Yayasan Wali Ati'),
(255, 'Yayasan ZAD Indonesia'),
(256, 'YKP (Yayasan Kesehatan Perempuan)');

-- --------------------------------------------------------

--
-- Table structure for table `master_negara`
--

CREATE TABLE `master_negara` (
  `id` int(11) NOT NULL,
  `nama_negara` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_negara`
--

INSERT INTO `master_negara` (`id`, `nama_negara`) VALUES
(1, 'Amerika Serikat'),
(2, 'Arab Saudi'),
(3, 'Australia'),
(4, 'Belanda'),
(5, 'Belgia'),
(6, 'Inggris'),
(7, 'Jepang'),
(8, 'Jerman'),
(9, 'Kanada'),
(10, 'Perancis'),
(11, 'Qatar'),
(12, 'Singapura'),
(13, 'Swedia'),
(14, 'Swiss'),
(15, 'Turki'),
(16, 'Antah');

-- --------------------------------------------------------

--
-- Table structure for table `master_provinsi`
--

CREATE TABLE `master_provinsi` (
  `id` int(11) NOT NULL,
  `kode_provinsi` int(11) NOT NULL,
  `nama_provinsi` varchar(50) NOT NULL,
  `lati` varchar(50) NOT NULL,
  `longi` varchar(50) NOT NULL,
  `zoom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_provinsi`
--

INSERT INTO `master_provinsi` (`id`, `kode_provinsi`, `nama_provinsi`, `lati`, `longi`, `zoom`) VALUES
(1, 11, 'ACEH', '4.695135', '96.74939930000005', 7),
(2, 51, 'BALI', '-8.4095178', '115.18891600000006', 10),
(3, 36, 'BANTEN', '-6.4058172', '106.06401789999995', 9),
(4, 17, 'BENGKULU', '-3.5778471', '102.34638749999999', 8),
(5, 34, 'DAERAH ISTIMEWA YOGYAKARTA', '-7.875384899999999', '110.42620880000004', 10),
(6, 31, 'DKI JAKARTA', '-6.17511', '106.86503949999997', 9),
(7, 75, 'GORONTALO', '0.6999371999999999', '122.44672379999997', 9),
(8, 15, 'JAMBI', '-1.6101229', '103.61312029999999', 13),
(9, 32, 'JAWA BARAT', '-7.090910999999999', '107.66888700000004', 9),
(10, 33, 'JAWA TENGAH', '-7.150975', '110.14025939999999', 8),
(11, 35, 'JAWA TIMUR', '-7.5360639', '112.23840169999994', 8),
(12, 61, 'KALIMANTAN BARAT', '-0.2787808', '111.47528510000006', 7),
(13, 63, 'KALIMANTAN SELATAN', '-3.0926415', '115.28375849999998', 8),
(14, 62, 'KALIMANTAN TENGAH', '-1.6814878', '113.38235450000002', 7),
(15, 64, 'KALIMANTAN TIMUR', '0.5386586', '116.41938900000002', 7),
(16, 65, 'KALIMANTAN UTARA', '3.0730929', '116.04138890000002', 7),
(17, 19, 'KEPULAUAN BANGKA BELITUNG', '-2.7410513', '106.44058719999998', 8),
(18, 21, 'KEPULAUAN RIAU', '3.9456514', '108.14286689999994', 7),
(19, 18, 'LAMPUNG', '-4.5585849', '105.40680789999999', 8),
(20, 81, 'MALUKU', '-3.2384616', '130.14527339999995', 7),
(21, 82, 'MALUKU UTARA', '1.5709993', '127.8087693', 7),
(22, 52, 'NUSA TENGGARA BARAT', '-8.6529334', '117.36164759999997', 8),
(23, 53, 'NUSA TENGGARA TIMUR', '-8.657381899999999', '121.07937049999998', 8),
(24, 91, 'PAPUA', '-4.0454139', '137.23475311', 6),
(25, 92, 'PAPUA BARAT', '-1.3361154', '133.17471620000003', 7),
(26, 14, 'RIAU', '0.2933469', '101.70682940000006', 7),
(27, 76, 'SULAWESI BARAT', '-2.8441371', '119.23207839999998', 8),
(28, 73, 'SULAWESI SELATAN', '-3.6687994', '119.9740534', 7),
(29, 72, 'SULAWESI TENGAH', '-1.4300254', '121.4456179', 7),
(30, 74, 'SULAWESI TENGGARA', '-4.144909999999999', '122.17460499999993', 8),
(31, 71, 'SULAWESI UTARA', '0.6246932', '123.97500179999997', 7),
(32, 13, 'SUMATERA BARAT', '-0.7399397', '100.80000510000002', 7),
(33, 16, 'SUMATERA SELATAN', '-3.3194374', '103.914399', 8),
(34, 12, 'SUMATERA UTARA', '2.1153547', '99.54509740000003', 7);

-- --------------------------------------------------------

--
-- Table structure for table `master_statusperizinan`
--

CREATE TABLE `master_statusperizinan` (
  `id` int(11) NOT NULL,
  `deskripsi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_statusperizinan`
--

INSERT INTO `master_statusperizinan` (`id`, `deskripsi`) VALUES
(1, 'Teregistrasi'),
(2, 'Tidak Teregistrasi');

-- --------------------------------------------------------

--
-- Table structure for table `master_tingkatkerawanan`
--

CREATE TABLE `master_tingkatkerawanan` (
  `id` int(11) NOT NULL,
  `deskripsi` varchar(30) NOT NULL,
  `warna` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_tingkatkerawanan`
--

INSERT INTO `master_tingkatkerawanan` (`id`, `deskripsi`, `warna`) VALUES
(1, 'Aman', 'hijau'),
(2, 'Sedang', 'kuning'),
(3, 'Rawan', 'merah');

-- --------------------------------------------------------

--
-- Table structure for table `mitralokalorganisasi`
--

CREATE TABLE `mitralokalorganisasi` (
  `id` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `id_mitralokal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mitralokalorganisasi`
--

INSERT INTO `mitralokalorganisasi` (`id`, `id_organisasi`, `id_mitralokal`) VALUES
(1, 1, 5),
(2, 1, 7),
(3, 1, 9),
(4, 1, 12),
(5, 1, 21),
(6, 1, 23),
(7, 1, 28),
(8, 1, 30),
(9, 1, 32),
(10, 1, 35),
(11, 1, 36),
(12, 1, 41),
(13, 1, 42),
(14, 1, 44),
(15, 1, 45),
(16, 1, 49),
(17, 1, 50),
(18, 1, 51),
(19, 1, 52),
(20, 1, 53),
(21, 1, 58),
(22, 1, 59),
(23, 1, 60),
(24, 1, 63),
(25, 1, 71),
(26, 1, 75),
(27, 1, 78),
(28, 1, 80),
(29, 1, 81),
(30, 1, 87),
(31, 1, 89),
(32, 1, 92),
(33, 1, 97),
(34, 1, 106),
(35, 1, 109),
(36, 1, 110),
(37, 1, 111),
(38, 1, 112),
(39, 1, 114),
(40, 1, 115),
(41, 1, 117),
(42, 1, 118),
(43, 1, 120),
(44, 1, 121),
(45, 1, 123),
(46, 1, 126),
(47, 1, 131),
(48, 1, 134),
(49, 1, 135),
(50, 1, 136),
(51, 1, 137),
(52, 1, 138),
(53, 1, 140),
(54, 1, 141),
(55, 1, 144),
(56, 1, 145),
(57, 1, 146),
(58, 1, 151),
(59, 1, 161),
(60, 1, 164),
(61, 1, 165),
(62, 1, 169),
(63, 1, 171),
(64, 1, 175),
(65, 1, 177),
(66, 1, 178),
(67, 1, 181),
(68, 1, 182),
(69, 1, 186),
(70, 1, 187),
(71, 1, 193),
(72, 1, 199),
(73, 1, 200),
(74, 1, 201),
(75, 1, 203),
(76, 1, 205),
(77, 1, 206),
(78, 1, 208),
(79, 1, 210),
(80, 1, 211),
(81, 1, 213),
(82, 1, 214),
(83, 1, 215),
(84, 1, 219),
(85, 1, 220),
(86, 1, 223),
(87, 1, 224),
(88, 1, 226),
(89, 1, 228),
(90, 1, 229),
(91, 1, 231),
(92, 1, 232),
(93, 1, 235),
(94, 1, 237),
(95, 1, 238),
(96, 1, 239),
(97, 1, 240),
(98, 1, 241),
(99, 1, 242),
(100, 1, 243),
(101, 1, 247),
(102, 1, 249),
(103, 1, 251),
(104, 1, 252),
(105, 1, 253),
(128, 2, 1),
(129, 2, 4),
(130, 2, 6),
(131, 2, 9),
(132, 2, 10),
(133, 2, 11),
(134, 2, 17),
(135, 2, 20),
(136, 2, 22),
(137, 2, 26),
(138, 2, 37),
(139, 2, 40),
(140, 2, 45),
(141, 2, 47),
(142, 2, 50),
(143, 2, 54),
(144, 2, 56),
(145, 2, 57),
(146, 2, 72),
(147, 2, 73),
(148, 2, 77),
(149, 2, 86),
(150, 2, 89),
(151, 2, 98),
(152, 2, 102),
(153, 2, 103),
(154, 2, 104),
(155, 2, 108),
(156, 2, 113),
(157, 2, 116),
(158, 2, 119),
(159, 2, 125),
(160, 2, 127),
(161, 2, 139),
(162, 2, 142),
(163, 2, 147),
(164, 2, 148),
(165, 2, 149),
(166, 2, 150),
(167, 2, 155),
(168, 2, 156),
(169, 2, 157),
(170, 2, 160),
(171, 2, 162),
(172, 2, 163),
(173, 2, 166),
(174, 2, 168),
(175, 2, 170),
(176, 2, 189),
(177, 2, 190),
(178, 2, 191),
(179, 2, 193),
(180, 2, 195),
(181, 2, 202),
(182, 2, 222),
(183, 2, 227),
(184, 2, 231),
(185, 2, 242),
(186, 2, 244),
(187, 2, 251),
(188, 2, 254),
(191, 3, 3),
(192, 3, 8),
(193, 3, 13),
(194, 3, 38),
(195, 3, 43),
(196, 3, 48),
(197, 3, 60),
(198, 3, 62),
(199, 3, 66),
(200, 3, 67),
(201, 3, 73),
(202, 3, 74),
(203, 3, 76),
(204, 3, 79),
(205, 3, 82),
(206, 3, 84),
(207, 3, 88),
(208, 3, 89),
(209, 3, 90),
(210, 3, 93),
(211, 3, 96),
(212, 3, 99),
(213, 3, 113),
(214, 3, 116),
(215, 3, 122),
(216, 3, 130),
(217, 3, 143),
(218, 3, 152),
(219, 3, 154),
(220, 3, 156),
(221, 3, 167),
(222, 3, 188),
(223, 3, 194),
(224, 3, 196),
(225, 3, 207),
(226, 3, 209),
(227, 3, 212),
(228, 3, 217),
(229, 3, 234),
(230, 3, 245),
(231, 3, 256),
(254, 3, 66),
(255, 4, 2),
(256, 4, 15),
(257, 4, 94),
(258, 5, 16),
(259, 5, 18),
(260, 5, 31),
(261, 5, 46),
(262, 5, 55),
(263, 5, 61),
(264, 5, 64),
(265, 5, 68),
(266, 5, 70),
(267, 5, 83),
(268, 5, 85),
(269, 5, 91),
(270, 5, 101),
(271, 5, 105),
(272, 5, 128),
(273, 5, 129),
(274, 5, 153),
(275, 5, 166),
(276, 5, 179),
(277, 5, 183),
(278, 5, 192),
(279, 5, 197),
(280, 5, 198),
(281, 5, 209),
(282, 5, 221),
(283, 5, 230),
(284, 5, 233),
(285, 5, 236),
(286, 5, 246),
(287, 5, 248),
(289, 6, 95),
(290, 6, 133),
(291, 6, 177),
(292, 6, 178),
(293, 6, 184),
(294, 6, 191),
(295, 6, 204),
(296, 6, 218),
(304, 7, 172),
(305, 7, 180),
(306, 7, 185),
(307, 8, 14),
(308, 8, 24),
(309, 8, 25),
(310, 8, 27),
(311, 8, 33),
(312, 8, 39),
(313, 8, 69),
(314, 8, 107),
(315, 8, 158),
(316, 8, 174),
(317, 8, 225),
(318, 8, 250),
(322, 8, 176),
(323, 9, 34),
(324, 9, 191),
(325, 9, 213),
(326, 9, 216),
(330, 10, 29),
(331, 10, 132),
(332, 10, 255),
(333, 2, 19),
(334, 2, 65),
(335, 2, 100),
(336, 2, 124),
(337, 2, 159),
(338, 2, 173),
(419, 34, 5),
(420, 34, 8),
(421, 34, 195);

-- --------------------------------------------------------

--
-- Table structure for table `organisasi`
--

CREATE TABLE `organisasi` (
  `id` int(11) NOT NULL,
  `nama_organisasi` varchar(200) NOT NULL,
  `id_negara_asal` int(11) NOT NULL,
  `representasi` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `id_mitra` int(11) NOT NULL,
  `id_datacollection` int(11) NOT NULL,
  `tahun_berdiri` int(11) NOT NULL,
  `tahun_beroperasi` int(11) NOT NULL,
  `id_statusperizinan` int(11) NOT NULL,
  `anggaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organisasi`
--

INSERT INTO `organisasi` (`id`, `nama_organisasi`, `id_negara_asal`, `representasi`, `alamat`, `id_mitra`, `id_datacollection`, `tahun_berdiri`, `tahun_beroperasi`, `id_statusperizinan`, `anggaran`) VALUES
(1, 'Ford Foundation', 1, 'Alexander Irwan', 'Sequis Center Lt. 11, Jl. Jend Sudirman 71, Jakarta 12190', 1, 1, 1936, 1953, 1, 6500000),
(2, 'Humanistisch Instituut voor Ontwikkelings \nSamenwerking (Hivos)', 4, 'Biranchi Upadhaya (WN India)', 'Jl. Kemang Selatan XII No. 1, Jakarta 12560', 3, 1, 1968, 2004, 1, 6300000),
(3, 'Oxford Committee for Famine Relief (OXFAM)', 6, 'Maria Lauranti', 'Jl. Taman Margasatwa 26, Jakarta 12550', 3, 1, 1942, 1957, 1, 5200000),
(4, 'Bremen Overseas Research And Development Association (BORDA)', 8, 'Frank Fladerer (WN Jerman)', 'Kayen No. 176, Jl. Kaliurang Km 6,6 Yogyakarta 55582', 6, 2, 1977, 1988, 1, 3000000),
(5, 'Brot Fur Die Weld (BFDW)', 8, 'Ulla Krog (WN Jerman)', 'Jl. Selamet Ketaran 100, Sumatera Utara 20223', 27, 1, 1959, 2008, 2, 5800000),
(6, 'Frankfurt Zoological Society (FZS)', 8, 'Christof Schenck (WN Jerman)', 'Jalan A. Chatib No. 60 RT. 14, Pematang Sulur, Jambi 36124', 2, 2, 1858, 1998, 1, 2800000),
(7, 'The Raoul Wallenberg Institute Of Human Rights And Humanitarian Law (RWI)', 13, 'Morten Kjaerum (WN Swedia)', 'Wisma PMI Lantai 1, Jalan Wijaya I no. 63, Jakarta  12160', 7, 2, 1984, 1999, 1, 1300000),
(8, 'Netherlands Leprosy Relief (NLR)', 4, 'Dianne Van Oosterhaut (WN Belanda)', 'Jl. Sungai Sambas VI, No. 12, Jakarta 12130', 8, 1, 1967, 1967, 1, 4700000),
(9, 'Conservation International (CI)', 1, 'Ketut Sarjana Putra', 'Jl. Pejaten Barat No 16, Jakarta 12510', 2, 1, 1987, 1994, 1, 6200000),
(10, 'Qatar Charities', 11, 'Karem Z. Aley (WN Qatar)', 'Gedung Grand Duren Tiga lantai 3, Jl. Duren Tiga Raya No. 9, Jakarta 12760', 5, 2, 1992, 2008, 1, 11200000),
(33, 'Organisasi Masyarakat Ibukota', 2, 'Ibu Nona', 'Kampung Melayu Kecil', 4, 1, 2017, 2017, 1, 90000),
(34, 'Gotong Royong Society', 4, 'Saya nama', 'Jakarta raya', 4, 1, 2017, 2018, 2, 900000),
(39, '1', 1, '1', 'a', 1, 1, 2012, 2012, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'User Level 1'),
(3, 'User Level 2');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `role_id`) VALUES
(1, 'Administrator', 'administrator@sikopimas.com', '$2y$12$OFa1Ap.deqOV0G.Plv9GSONQnDZIxaEQKVD.YwPIeNj4Me66xM6y2', 1),
(2, 'User Level 1', 'user1@sikopimas.com', '$2y$12$OFa1Ap.deqOV0G.Plv9GSONQnDZIxaEQKVD.YwPIeNj4Me66xM6y2', 2),
(3, 'User Level 2', 'user2@sikopimas.com', '$2y$12$OFa1Ap.deqOV0G.Plv9GSONQnDZIxaEQKVD.YwPIeNj4Me66xM6y2', 3),
(6, 'Ahlijati Nuraminah', 'ahlijati.nuraminah@esqbs.ac.id', '$2y$10$2jGOzC0bzgSeiC8CEUe/JOivCd0CrB5NgzdWBOH6dEefrL6v.179S', 3);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_jumlahorganisasibyprovinsi`
-- (See below for the actual view)
--
CREATE TABLE `v_jumlahorganisasibyprovinsi` (
`id_provinsi` int(11)
,`jumlah_organisasi` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_jumlahprovinsibyorganisasi`
-- (See below for the actual view)
--
CREATE TABLE `v_jumlahprovinsibyorganisasi` (
`id_organisasi` int(11)
,`jumlah_lokasiprovinsi` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_organisasi`
-- (See below for the actual view)
--
CREATE TABLE `v_organisasi` (
`id` int(11)
,`nama_organisasi` varchar(200)
,`id_negara_asal` int(11)
,`representasi` varchar(100)
,`alamat` varchar(200)
,`id_mitra` int(11)
,`id_datacollection` int(11)
,`tahun_berdiri` int(11)
,`tahun_beroperasi` int(11)
,`id_statusperizinan` int(11)
,`anggaran` int(11)
,`nama_negara` varchar(50)
,`nama_mitra` varchar(100)
,`tingkat_kerawanan` varchar(20)
,`statusisu` int(20)
,`statusizin` int(20)
,`statustahunoperasi` int(11)
,`statuswilayah` int(20)
,`statusmitra` int(20)
,`statusdatacollection` int(20)
,`statusanggaran` int(20)
,`status_perizinan` varchar(50)
,`data_collection` varchar(50)
,`jumlah_wilayah` bigint(21)
,`jumlah_mitralokal` bigint(21)
,`id_isu` mediumtext
,`isu_organisasi` mediumtext
,`id_mitralokal` mediumtext
,`mitralokal_organisasi` mediumtext
,`id_donor` mediumtext
,`donor_organisasi` mediumtext
,`id_bidang_kerja` mediumtext
,`bidang_kerja` mediumtext
,`id_provinsi` mediumtext
,`lokasi_kerja_provinsi` mediumtext
,`id_kabupaten` mediumtext
,`lokasi_kerja_kabupaten` mediumtext
,`lokasiprovinsikabupaten` mediumtext
);

-- --------------------------------------------------------

--
-- Structure for view `v_jumlahorganisasibyprovinsi`
--
DROP TABLE IF EXISTS `v_jumlahorganisasibyprovinsi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jumlahorganisasibyprovinsi`  AS  select `a`.`id_provinsi` AS `id_provinsi`,count(`a`.`id_organisasi`) AS `jumlah_organisasi` from `lokasiorganisasiprovinsi` `a` group by `a`.`id_provinsi` ;

-- --------------------------------------------------------

--
-- Structure for view `v_jumlahprovinsibyorganisasi`
--
DROP TABLE IF EXISTS `v_jumlahprovinsibyorganisasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jumlahprovinsibyorganisasi`  AS  select `lokasiorganisasiprovinsi`.`id_organisasi` AS `id_organisasi`,count(`lokasiorganisasiprovinsi`.`id_provinsi`) AS `jumlah_lokasiprovinsi` from `lokasiorganisasiprovinsi` group by `lokasiorganisasiprovinsi`.`id_organisasi` ;

-- --------------------------------------------------------

--
-- Structure for view `v_organisasi`
--
DROP TABLE IF EXISTS `v_organisasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_organisasi`  AS  select `o`.`id` AS `id`,`o`.`nama_organisasi` AS `nama_organisasi`,`o`.`id_negara_asal` AS `id_negara_asal`,`o`.`representasi` AS `representasi`,`o`.`alamat` AS `alamat`,`o`.`id_mitra` AS `id_mitra`,`o`.`id_datacollection` AS `id_datacollection`,`o`.`tahun_berdiri` AS `tahun_berdiri`,`o`.`tahun_beroperasi` AS `tahun_beroperasi`,`o`.`id_statusperizinan` AS `id_statusperizinan`,`o`.`anggaran` AS `anggaran`,`mn`.`nama_negara` AS `nama_negara`,`mm`.`nama_mitra` AS `nama_mitra`,`fn_GetTingkatKerawanan`(`o`.`id`) AS `tingkat_kerawanan`,`fn_GetTingkatKerawananByIsu`(`o`.`id`) AS `statusisu`,`fn_GetTingkatKerawananByStatusPerizinan`(`o`.`id`) AS `statusizin`,`fn_GetTingkatKerawananByTahunBeroperasi`(`o`.`id`) AS `statustahunoperasi`,`fn_GetTingkatKerawananByJumlahWilayah`(`o`.`id`) AS `statuswilayah`,`fn_GetTingkatKerawananByJumlahMitra`(`o`.`id`) AS `statusmitra`,`fn_GetTingkatKerawananByDataCollection`(`o`.`id`) AS `statusdatacollection`,`fn_GetTingkatKerawananByDataAnggaran`(`o`.`id`) AS `statusanggaran`,`ms`.`deskripsi` AS `status_perizinan`,`md`.`deskripsi` AS `data_collection`,(select count(`lop`.`id_provinsi`) from `lokasiorganisasiprovinsi` `lop` where `lop`.`id_organisasi` = `o`.`id`) AS `jumlah_wilayah`,(select count(`mlo`.`id_mitralokal`) from `mitralokalorganisasi` `mlo` where `mlo`.`id_organisasi` = `o`.`id`) AS `jumlah_mitralokal`,(select group_concat(concat('(',`a`.`id_isu`,')') separator ' ') from `isuorganisasi` `a` where `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `id_isu`,(select concat('<ul>',group_concat(concat('<li>',`b`.`nama_isu`,' : ',`a`.`keterangan`,'</li>') separator ''),'</ul>') from (`isuorganisasi` `a` join `master_isu` `b`) where `a`.`id_isu` = `b`.`id` and `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `isu_organisasi`,(select group_concat(concat('(',`a`.`id_mitralokal`,')') separator ' ') from `mitralokalorganisasi` `a` where `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `id_mitralokal`,(select concat('<ol>',group_concat(concat('<li>',`b`.`nama_mitralokal`,'</li>') order by `b`.`nama_mitralokal` ASC separator ''),'</ol>') from (`mitralokalorganisasi` `a` join `master_mitralokal` `b`) where `a`.`id_mitralokal` = `b`.`id` and `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `mitralokal_organisasi`,(select group_concat(concat('(',`a`.`id_donor`,')') separator ' ') from `donororganisasi` `a` where `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `id_donor`,(select concat('<ol>',group_concat(concat('<li>',`b`.`nama_donor`,' : ',`a`.`jumlah`,'</li>') separator ''),'</ol>') from (`donororganisasi` `a` join `master_donor` `b`) where `a`.`id_donor` = `b`.`id` and `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `donor_organisasi`,(select group_concat(concat('(',`a`.`id_bidangkerja`,')') separator ' ') from `bidangkerjaorganisasi` `a` where `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `id_bidang_kerja`,(select concat('<ol>',group_concat(concat('<li>',`b`.`nama_bidang`,'</li>') separator ''),'</ol>') from (`bidangkerjaorganisasi` `a` join `master_bidangkerja` `b`) where `a`.`id_bidangkerja` = `b`.`id` and `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `bidang_kerja`,(select group_concat(concat('(',`a`.`id_provinsi`,')') separator ' ') from `lokasiorganisasiprovinsi` `a` where `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `id_provinsi`,(select concat('<ol>',group_concat(concat('<li>',`b`.`nama_provinsi`,'</li>') order by `b`.`kode_provinsi` ASC separator ''),'</ol>') from (`lokasiorganisasiprovinsi` `a` join `master_provinsi` `b`) where `a`.`id_provinsi` = `b`.`id` and `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `lokasi_kerja_provinsi`,(select group_concat(concat('(',`a`.`id_kabupaten`,')') separator ' ') from `lokasiorganisasikabupaten` `a` where `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `id_kabupaten`,(select concat('<ol>',group_concat(concat('<li>',`b`.`nama_kabupatenkota`,'</li>') separator ''),'</ol>') from (`lokasiorganisasikabupaten` `a` join `master_kabupatenkota` `b`) where `a`.`id_kabupaten` = `b`.`id` and `a`.`id_organisasi` = `o`.`id` group by `a`.`id_organisasi`) AS `lokasi_kerja_kabupaten`,(select concat('<ol>',group_concat(concat('<li><b>',`mp`.`nama_provinsi`,'</b> (',`t`.`lokasikabupaten`,')','</li>') order by `mp`.`kode_provinsi` ASC separator ''),'</ol>') from ((select `lok`.`id_organisasi` AS `id_organisasi`,`lok`.`id_provinsi` AS `id_provinsi`,group_concat(distinct `mk`.`nama_kabupatenkota` separator ', ') AS `lokasikabupaten` from (`lokasiorganisasikabupaten` `lok` join `master_kabupatenkota` `mk` on(`lok`.`id_kabupaten` = `mk`.`id`)) group by `lok`.`id_organisasi`,`lok`.`id_provinsi`) `t` join `master_provinsi` `mp` on(`t`.`id_provinsi` = `mp`.`id`)) where `t`.`id_organisasi` = `o`.`id`) AS `lokasiprovinsikabupaten` from ((((`organisasi` `o` join `master_negara` `mn` on(`o`.`id_negara_asal` = `mn`.`id`)) join `master_mitra` `mm` on(`o`.`id_mitra` = `mm`.`id`)) join `master_statusperizinan` `ms` on(`o`.`id_statusperizinan` = `ms`.`id`)) join `master_datacollection` `md` on(`o`.`id_datacollection` = `md`.`id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidangkerjaorganisasi`
--
ALTER TABLE `bidangkerjaorganisasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bidangkerja` (`id_bidangkerja`),
  ADD KEY `id_organisasi` (`id_organisasi`);

--
-- Indexes for table `donororganisasi`
--
ALTER TABLE `donororganisasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_donor` (`id_donor`),
  ADD KEY `id_organisasi` (`id_organisasi`);

--
-- Indexes for table `isuorganisasi`
--
ALTER TABLE `isuorganisasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_isu` (`id_isu`),
  ADD KEY `id_organisasi` (`id_organisasi`);

--
-- Indexes for table `lokasiorganisasikabupaten`
--
ALTER TABLE `lokasiorganisasikabupaten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_organisasi` (`id_organisasi`),
  ADD KEY `id_kabupaten` (`id_kabupaten`),
  ADD KEY `id_provinsi` (`id_provinsi`);

--
-- Indexes for table `lokasiorganisasiprovinsi`
--
ALTER TABLE `lokasiorganisasiprovinsi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_organisasi` (`id_organisasi`),
  ADD KEY `id_provinsi` (`id_provinsi`);

--
-- Indexes for table `master_bidangkerja`
--
ALTER TABLE `master_bidangkerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_datacollection`
--
ALTER TABLE `master_datacollection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_donor`
--
ALTER TABLE `master_donor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_isu`
--
ALTER TABLE `master_isu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_kabupatenkota`
--
ALTER TABLE `master_kabupatenkota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_provinsi` (`id_provinsi`);

--
-- Indexes for table `master_mitra`
--
ALTER TABLE `master_mitra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_mitralokal`
--
ALTER TABLE `master_mitralokal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_negara`
--
ALTER TABLE `master_negara`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_provinsi`
--
ALTER TABLE `master_provinsi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_statusperizinan`
--
ALTER TABLE `master_statusperizinan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_tingkatkerawanan`
--
ALTER TABLE `master_tingkatkerawanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mitralokalorganisasi`
--
ALTER TABLE `mitralokalorganisasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mitralokal` (`id_mitralokal`),
  ADD KEY `id_organisasi` (`id_organisasi`);

--
-- Indexes for table `organisasi`
--
ALTER TABLE `organisasi`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_datacollection` (`id_datacollection`),
  ADD KEY `id_negara_asal` (`id_negara_asal`),
  ADD KEY `id_statusperizinan` (`id_statusperizinan`),
  ADD KEY `id_mitra` (`id_mitra`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidangkerjaorganisasi`
--
ALTER TABLE `bidangkerjaorganisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `donororganisasi`
--
ALTER TABLE `donororganisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `isuorganisasi`
--
ALTER TABLE `isuorganisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `lokasiorganisasikabupaten`
--
ALTER TABLE `lokasiorganisasikabupaten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=570;

--
-- AUTO_INCREMENT for table `lokasiorganisasiprovinsi`
--
ALTER TABLE `lokasiorganisasiprovinsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT for table `master_bidangkerja`
--
ALTER TABLE `master_bidangkerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `master_datacollection`
--
ALTER TABLE `master_datacollection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_donor`
--
ALTER TABLE `master_donor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `master_isu`
--
ALTER TABLE `master_isu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `master_kabupatenkota`
--
ALTER TABLE `master_kabupatenkota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=523;

--
-- AUTO_INCREMENT for table `master_mitra`
--
ALTER TABLE `master_mitra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `master_mitralokal`
--
ALTER TABLE `master_mitralokal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `master_negara`
--
ALTER TABLE `master_negara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `master_provinsi`
--
ALTER TABLE `master_provinsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `master_statusperizinan`
--
ALTER TABLE `master_statusperizinan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_tingkatkerawanan`
--
ALTER TABLE `master_tingkatkerawanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mitralokalorganisasi`
--
ALTER TABLE `mitralokalorganisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;

--
-- AUTO_INCREMENT for table `organisasi`
--
ALTER TABLE `organisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bidangkerjaorganisasi`
--
ALTER TABLE `bidangkerjaorganisasi`
  ADD CONSTRAINT `bidangkerjaorganisasi_ibfk_1` FOREIGN KEY (`id_bidangkerja`) REFERENCES `master_bidangkerja` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bidangkerjaorganisasi_ibfk_2` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donororganisasi`
--
ALTER TABLE `donororganisasi`
  ADD CONSTRAINT `donororganisasi_ibfk_1` FOREIGN KEY (`id_donor`) REFERENCES `master_donor` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `donororganisasi_ibfk_2` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `isuorganisasi`
--
ALTER TABLE `isuorganisasi`
  ADD CONSTRAINT `isuorganisasi_ibfk_1` FOREIGN KEY (`id_isu`) REFERENCES `master_isu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `isuorganisasi_ibfk_2` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lokasiorganisasikabupaten`
--
ALTER TABLE `lokasiorganisasikabupaten`
  ADD CONSTRAINT `lokasiorganisasikabupaten_ibfk_1` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lokasiorganisasikabupaten_ibfk_2` FOREIGN KEY (`id_kabupaten`) REFERENCES `master_kabupatenkota` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `lokasiorganisasikabupaten_ibfk_3` FOREIGN KEY (`id_provinsi`) REFERENCES `master_provinsi` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `lokasiorganisasiprovinsi`
--
ALTER TABLE `lokasiorganisasiprovinsi`
  ADD CONSTRAINT `lokasiorganisasiprovinsi_ibfk_1` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lokasiorganisasiprovinsi_ibfk_2` FOREIGN KEY (`id_provinsi`) REFERENCES `master_provinsi` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `master_kabupatenkota`
--
ALTER TABLE `master_kabupatenkota`
  ADD CONSTRAINT `master_kabupatenkota_ibfk_1` FOREIGN KEY (`id_provinsi`) REFERENCES `master_provinsi` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `mitralokalorganisasi`
--
ALTER TABLE `mitralokalorganisasi`
  ADD CONSTRAINT `mitralokalorganisasi_ibfk_1` FOREIGN KEY (`id_mitralokal`) REFERENCES `master_mitralokal` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mitralokalorganisasi_ibfk_2` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `organisasi`
--
ALTER TABLE `organisasi`
  ADD CONSTRAINT `organisasi_ibfk_1` FOREIGN KEY (`id_datacollection`) REFERENCES `master_datacollection` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `organisasi_ibfk_2` FOREIGN KEY (`id_negara_asal`) REFERENCES `master_negara` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `organisasi_ibfk_4` FOREIGN KEY (`id_statusperizinan`) REFERENCES `master_statusperizinan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `organisasi_ibfk_5` FOREIGN KEY (`id_mitra`) REFERENCES `master_mitra` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
