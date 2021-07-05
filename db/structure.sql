-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2020 at 07:08 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sikopimas`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_bidangkerja`
--

CREATE TABLE `master_bidangkerja` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama_bidang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_datacollection`
--

CREATE TABLE `master_datacollection` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `deskripsi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_donor`
--

CREATE TABLE `master_donor` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama_donor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_isu`
--

CREATE TABLE `master_isu` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama_isu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_provinsi`
--

CREATE TABLE `master_provinsi` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `kode_provinsi` int(11) NOT NULL,
  `nama_provinsi` varchar(50) NOT NULL,
  `lati` varchar(50) NOT NULL,
  `longi` varchar(50) NOT NULL,
  `zoom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_kabupatenkota`
--

CREATE TABLE `master_kabupatenkota` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `kode_kabupaten` int(11) NOT NULL,
  `nama_kabupatenkota` varchar(50) NOT NULL,
  `lati` varchar(50) NOT NULL,
  `longi` varchar(50) NOT NULL,
  `zoom` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_mitra`
--

CREATE TABLE `master_mitra` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama_mitra` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_mitralokal`
--

CREATE TABLE `master_mitralokal` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama_mitralokal` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_negara`
--

CREATE TABLE `master_negara` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama_negara` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_statusperizinan`
--

CREATE TABLE `master_statusperizinan` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `deskripsi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_tingkatkerawanan`
--

CREATE TABLE `master_tingkatkerawanan` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `deskripsi` varchar(30) NOT NULL,
  `warna` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `organisasi`
--

CREATE TABLE `organisasi` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bidangkerjaorganisasi`
--

CREATE TABLE `bidangkerjaorganisasi` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_organisasi` int(11) NOT NULL,
  `id_bidangkerja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `donororganisasi`
--

CREATE TABLE `donororganisasi` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_organisasi` int(11) NOT NULL,
  `id_donor` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `isuorganisasi`
--

CREATE TABLE `isuorganisasi` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_organisasi` int(11) NOT NULL,
  `id_isu` int(11) NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lokasiorganisasiprovinsi`
--

CREATE TABLE `lokasiorganisasiprovinsi` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_organisasi` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lokasiorganisasikabupaten`
--

CREATE TABLE `lokasiorganisasikabupaten` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_organisasi` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL,
  `id_kabupaten` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mitralokalorganisasi`
--

CREATE TABLE `mitralokalorganisasi` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_organisasi` int(11) NOT NULL,
  `id_mitralokal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Indexes for table `organisasi`
--
ALTER TABLE `organisasi`
  ADD CONSTRAINT `organisasi_ibfk_1` FOREIGN KEY (`id_negara_asal`) REFERENCES `master_negara` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  ADD CONSTRAINT `organisasi_ibfk_2` FOREIGN KEY (`id_mitra`) REFERENCES `master_mitra` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  ADD CONSTRAINT `organisasi_ibfk_3` FOREIGN KEY (`id_datacollection`) REFERENCES `master_datacollection` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  ADD CONSTRAINT `organisasi_ibfk_4` FOREIGN KEY (`id_statusperizinan`) REFERENCES `master_statusperizinan` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

--
-- Indexes for table `bidangkerjaorganisasi`
--
ALTER TABLE `bidangkerjaorganisasi`
  ADD CONSTRAINT `bidangkerjaorganisasi_ibfk_1` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `bidangkerjaorganisasi_ibfk_2` FOREIGN KEY (`id_bidangkerja`) REFERENCES `master_bidangkerja` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

--
-- Indexes for table `donororganisasi`
--
ALTER TABLE `donororganisasi`
  ADD CONSTRAINT `donororganisasi_ibfk_1` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `donororganisasi_ibfk_2` FOREIGN KEY (`id_donor`) REFERENCES `master_donor` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

--
-- Indexes for table `isuorganisasi`
--
ALTER TABLE `isuorganisasi`
  ADD CONSTRAINT `isuorganisasi_ibfk_1` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `isuorganisasi_ibfk_2` FOREIGN KEY (`id_isu`) REFERENCES `master_isu` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

--
-- Indexes for table `lokasiorganisasiprovinsi`
--
ALTER TABLE `lokasiorganisasiprovinsi`
  ADD CONSTRAINT `lokasiorganisasiprovinsi_ibfk_1` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `lokasiorganisasiprovinsi_ibfk_2` FOREIGN KEY (`id_provinsi`) REFERENCES `master_provinsi` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

--
-- Indexes for table `lokasiorganisasikabupaten`
--
ALTER TABLE `lokasiorganisasikabupaten`
  ADD CONSTRAINT `lokasiorganisasikabupaten_ibfk_1` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `lokasiorganisasikabupaten_ibfk_2` FOREIGN KEY (`id_provinsi`) REFERENCES `master_provinsi` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  ADD CONSTRAINT `lokasiorganisasikabupaten_ibfk_3` FOREIGN KEY (`id_kabupaten`) REFERENCES `master_kabupatenkota` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

--
-- Indexes for table `mitralokalorganisasi`
--
ALTER TABLE `mitralokalorganisasi`
  ADD CONSTRAINT `mitralokalorganisasi_ibfk_1` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `mitralokalorganisasi_ibfk_2` FOREIGN KEY (`id_mitralokal`) REFERENCES `master_mitralokal` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;

DELIMITER $$

CREATE FUNCTION fn_GetTingkatKerawananByStatusPerizinan(
	idorganisasi INT
) 
RETURNS INT
DETERMINISTIC
BEGIN
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
DELIMITER ;

DELIMITER $$
CREATE FUNCTION fn_GetTingkatKerawananByIsu(
	idorganisasi INT
) 
RETURNS INT
DETERMINISTIC
BEGIN
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
    
END $$
DELIMITER ;

DELIMITER $$
CREATE FUNCTION fn_GetTingkatKerawananByTahunBeroperasi(
	idorganisasi INT
) 
RETURNS INT
DETERMINISTIC
BEGIN
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
    
END $$
DELIMITER ;

DELIMITER $$
CREATE FUNCTION fn_GetTingkatKerawananByJumlahWilayah(
	idorganisasi INT
) 
RETURNS INT
DETERMINISTIC
BEGIN
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
END $$
DELIMITER ;


DELIMITER $$

CREATE FUNCTION fn_GetTingkatKerawananByJumlahMitra(
	idorganisasi INT
) 
RETURNS INT
DETERMINISTIC
BEGIN
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
DELIMITER ;

DELIMITER $$

CREATE FUNCTION fn_GetTingkatKerawananByDataCollection(
	idorganisasi INT
) 
RETURNS INT
DETERMINISTIC
BEGIN
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
DELIMITER ;

DELIMITER $$
CREATE FUNCTION fn_GetTingkatKerawananByDataAnggaran(
	idorganisasi INT
) 
RETURNS INT
DETERMINISTIC
BEGIN
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
DELIMITER ;



DELIMITER $$

CREATE FUNCTION fn_GetTingkatKerawanan(
	idorganisasi INT
) 
RETURNS VARCHAR(20)
DETERMINISTIC
BEGIN    
    DECLARE tingkatkerawanan VARCHAR(20);
	DECLARE bobotkerawanan INT;
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
	
	SET bobotkerawanan = statusperizinan + isu + tahunoperasi + jumlahwilayah + jumlahmitra + datacollection + besaranggaran;
	IF  bobotkerawanan >= 7 and bobotkerawanan <= 10 THEN
		SET tingkatkerawanan = "AMAN";
    ELSEIF  bobotkerawanan >= 11 and bobotkerawanan <= 14 THEN
        SET tingkatkerawanan = "SEDANG";
    ELSEIF  bobotkerawanan > 15 THEN
		SET tingkatkerawanan = "RAWAN";
    END IF;

    
	
	RETURN (tingkatkerawanan);
END$$
DELIMITER ;


create view v_jumlahorganisasibyprovinsi AS
select a.id_provinsi, COUNT(a.id_organisasi) as jumlah_organisasi 
from lokasiorganisasiprovinsi a
GROUP by a.id_provinsi;

create view v_jumlahprovinsibyorganisasi AS
select id_organisasi, count(id_provinsi) AS jumlah_lokasiprovinsi 
from lokasiorganisasiprovinsi 
group by id_organisasi;

create view jumlahorganisasibylokasikabupaten AS
select a.id_kabupaten, COUNT(a.id_organisasi) as jumlah_organisasi 
from lokasiorganisasikabupaten a
GROUP by a.id_kabupaten;



create view v_organisasi AS
select o.*, 
       mn.nama_negara, 
	   mm.nama_mitra, 
	   fn_GetTingkatKerawanan(o.id) as tingkat_kerawanan, 
	   fn_GetTingkatKerawananByIsu(o.id) as statusisu, 
	   fn_GetTingkatKerawananByStatusPerizinan(o.id) as statusizin, 
	   fn_GetTingkatKerawananByTahunBeroperasi(o.id) as statustahunoperasi, 
	   fn_GetTingkatKerawananByJumlahWilayah(o.id) as statuswilayah,
	   fn_GetTingkatKerawananByJumlahMitra(o.id) as statusmitra,
	   fn_GetTingkatKerawananByDataCollection(o.id) as statusdatacollection,
	   fn_GetTingkatKerawananByDataAnggaran(o.id) as statusanggaran,
	   ms.deskripsi as status_perizinan, 
	   md.deskripsi as data_collection,
	  ( select count(lop.id_provinsi) 
		from lokasiorganisasiprovinsi lop 
		where lop.id_organisasi = o.id) as jumlah_wilayah,
       ( select count(mlo.id_mitralokal) 
		from mitralokalorganisasi mlo 
		where mlo.id_organisasi = o.id) as jumlah_mitralokal,                
	  ( select group_concat(concat('(', a.id_isu, ')') separator ' ')
   	    FROM isuorganisasi a
		WHERE a.id_organisasi = o.id
		GROUP BY a.id_organisasi) id_isu,
	  ( select concat('<ul>', group_concat(concat('<li>', b.nama_isu, ' : ' , a.keterangan, '</li>') separator ''), '</ul>')
		FROM isuorganisasi a, master_isu b
		where a.id_isu = b.id
		and a.id_organisasi = o.id
		GROUP BY a.id_organisasi) isu_organisasi,
	  ( select group_concat(concat('(', a.id_mitralokal, ')') separator ' ')
   	    FROM mitralokalorganisasi a
		WHERE a.id_organisasi = o.id
		GROUP BY a.id_organisasi) id_mitralokal,
	  ( select concat('<ol>', group_concat(concat('<li>', b.nama_mitralokal, '</li>') order by b.nama_mitralokal separator ''), '</ol>')
		FROM mitralokalorganisasi a, master_mitralokal b
		where a.id_mitralokal = b.id
		and a.id_organisasi = o.id
		GROUP BY a.id_organisasi) mitralokal_organisasi,
	  ( select group_concat(concat('(', a.id_donor, ')') separator ' ')
   	    FROM donororganisasi a
		WHERE a.id_organisasi = o.id
		GROUP BY a.id_organisasi) id_donor,
	  ( select concat('<ol>', group_concat(concat('<li>', b.nama_donor, ' : ' , a.jumlah, '</li>') separator ''), '</ol>')
		FROM donororganisasi a, master_donor b
		where a.id_donor = b.id
		and a.id_organisasi = o.id
		GROUP BY a.id_organisasi) donor_organisasi,
	  ( select group_concat(concat('(', a.id_bidangkerja, ')') separator ' ')
		FROM bidangkerjaorganisasi a
		WHERE a.id_organisasi = o.id
		GROUP BY a.id_organisasi) id_bidang_kerja,
	  ( select concat('<ol>', group_concat(concat('<li>', b.nama_bidang, '</li>') separator ''), '</ol>')
		FROM bidangkerjaorganisasi a, master_bidangkerja b
		where a.id_bidangkerja = b.id
		and a.id_organisasi = o.id
		GROUP BY a.id_organisasi) bidang_kerja,
	  ( select group_concat(concat('(', a.id_provinsi, ')') separator ' ')
		FROM lokasiorganisasiprovinsi a
		where a.id_organisasi = o.id
		GROUP BY a.id_organisasi) id_provinsi,
	  ( select concat('<ol>', group_concat(concat('<li>', b.nama_provinsi, '</li>') ORDER BY b.kode_provinsi separator ''), '</ol>')
		FROM lokasiorganisasiprovinsi a, master_provinsi b
		where a.id_provinsi = b.id
		and a.id_organisasi = o.id
		GROUP BY a.id_organisasi
		) lokasi_kerja_provinsi,
	  ( select group_concat(concat('(', a.id_kabupaten, ')') separator ' ')
		FROM lokasiorganisasikabupaten a
		WHERE a.id_organisasi = o.id
		GROUP BY a.id_organisasi) id_kabupaten,		
		( select concat('<ol>', group_concat(concat('<li>', b.nama_kabupatenkota, '</li>') separator ''), '</ol>')
		FROM lokasiorganisasikabupaten a, master_kabupatenkota b
		where a.id_kabupaten = b.id
		and a.id_organisasi = o.id
		GROUP BY a.id_organisasi) lokasi_kerja_kabupaten,		
		(select 
			concat('<ol>', group_concat(concat('<li><b>', mp.nama_provinsi, '</b> (' , t.lokasikabupaten, ')', '</li>') order by mp.kode_provinsi separator ''), '</ol>')
			from
			(select lok.id_organisasi, lok.id_provinsi, group_concat(DISTINCT mk.nama_kabupatenkota separator ', ') as lokasikabupaten
			from lokasiorganisasikabupaten lok
			join master_kabupatenkota mk
			on lok.id_kabupaten = mk.id
			group by lok.id_organisasi, lok.id_provinsi) t
			JOIN master_provinsi mp
			on t.id_provinsi = mp.id
			where t.id_organisasi = o.id) as lokasiprovinsikabupaten
from organisasi o
join master_negara mn
on o.id_negara_asal = mn.id
JOIN master_mitra mm
on o.id_mitra = mm.id
JOIN master_statusperizinan ms
on o.id_statusperizinan = ms.id
JOIN master_datacollection md
on o.id_datacollection = md.id;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
