-- --------------------------------------------------------
-- Host:                         192.168.19.23
-- Server version:               5.7.27 - MySQL Community Server (GPL)
-- Server OS:                    Linux
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for app-air
DROP DATABASE IF EXISTS `app-air`;
CREATE DATABASE IF NOT EXISTS `app-air` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `app-air`;

-- Dumping structure for table app-air.master_agent
DROP TABLE IF EXISTS `master_agent`;
CREATE TABLE IF NOT EXISTS `master_agent` (
  `id_agent` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `nama_agent` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telp` varchar(45) DEFAULT NULL,
  `npwp` varchar(45) DEFAULT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_agent`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.master_agent: ~5 rows (approximately)
/*!40000 ALTER TABLE `master_agent` DISABLE KEYS */;
INSERT INTO `master_agent` (`id_agent`, `nama_agent`, `alamat`, `no_telp`, `npwp`, `issued_by`, `issued_at`, `modified_by`, `modified_at`, `soft_delete`) VALUES
	(1, 'SALAM PACIFIC INDONESIA LINE,PT', 'JL KARAET NO.104 KEATAS BONGKARAN - SURABAYA', '-', '01.135.838.9-631.000', 'frenky', '2017-08-02 09:12:17', 'keuangan', '2017-08-23 14:54:13', 0),
	(2, 'PELAYARAN TEMPURAN EMAS TBK, PT', 'JL. TEMBANG NO. 51 TANJUNG PRIOK JAKARTA UTARA', '-', '01.321.865.6.054.000', 'frenky', '2017-08-02 09:14:19', 'keuangan', '2017-08-23 14:54:07', 0),
	(3, 'MERATUS LINE, PT', 'Jl. Alun - alun Priok No. 27 Perak Barat, Surabaya', '-', '01.108.202.1-631.000', 'frenky', '2017-08-02 09:16:19', 'keuangan', '2017-08-23 14:54:02', 0),
	(4, 'TANTO INTIM LINES,PT', 'JL. INDRAPURA NO.29-33 KEMAYORAN, KREMBANGAN ', '-', '01.108.183.3-631.000', 'frenky', '2017-08-02 10:53:04', 'keuangan', '2017-08-23 14:53:55', 0),
	(5, 'SINAR SURYA, CV', 'KO BALIKPAPAN BARU BLOK C4 NO. 032, DAMAI - BALIKPAPAN', '-', '03.099.671.4-721.000', 'frenky', '2017-08-02 10:55:23', 'keuangan', '2017-08-23 14:53:48', 0);
/*!40000 ALTER TABLE `master_agent` ENABLE KEYS */;

-- Dumping structure for table app-air.master_flowmeter
DROP TABLE IF EXISTS `master_flowmeter`;
CREATE TABLE IF NOT EXISTS `master_flowmeter` (
  `id_flow` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_flowmeter` varchar(255) NOT NULL DEFAULT '',
  `nama_flowmeter` varchar(45) NOT NULL DEFAULT '',
  `flowmeter_awal` double NOT NULL DEFAULT '0',
  `flowmeter_akhir` double NOT NULL DEFAULT '0',
  `flowmeter_akhir_ext` double NOT NULL DEFAULT '0',
  `status_aktif` tinyint(1) DEFAULT '1',
  `id_ref_pompa` int(255) unsigned NOT NULL,
  `kondisi` varchar(45) DEFAULT 'baik',
  `issued_at` datetime DEFAULT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_flow`),
  UNIQUE KEY `id_flowmeter` (`id_flowmeter`),
  KEY `id_ref_pompa` (`id_ref_pompa`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.master_flowmeter: ~13 rows (approximately)
/*!40000 ALTER TABLE `master_flowmeter` DISABLE KEYS */;
INSERT INTO `master_flowmeter` (`id_flow`, `id_flowmeter`, `nama_flowmeter`, `flowmeter_awal`, `flowmeter_akhir`, `flowmeter_akhir_ext`, `status_aktif`, `id_ref_pompa`, `kondisi`, `issued_at`, `issued_by`, `last_modified`, `modified_by`, `soft_delete`) VALUES
	(0, '------', '--------------', 0, 0, 0, 0, 0, 'baik', NULL, NULL, NULL, NULL, 1),
	(1, 'FLOW01', 'Flow Pompa Sumur 01', 8806, 8899, 0, 1, 5, 'baik', '2017-08-21 13:38:40', 'meidi', '2017-08-21 14:55:20', 'wtp', 0),
	(2, 'FLOW02', 'Flow Pompa Sumur 02', 9966, 9986, 0, 1, 6, 'baik', '2017-08-21 13:39:10', 'meidi', '2017-08-21 14:55:34', 'wtp', 0),
	(3, 'FLOW03', 'Flow Pompa Sumur 03', 108809, 109900, 0, 1, 7, 'baik', '2017-08-21 13:39:39', 'meidi', '2017-08-21 14:55:49', 'wtp', 0),
	(4, 'FLOW04', 'Flow Pompa Sumur 04', 2859, 2859, 0, 1, 8, 'baik', '2017-08-21 13:40:50', 'meidi', '2017-08-21 14:56:06', 'wtp', 0),
	(5, 'FLOW05', 'Flow Tanto Lines (RK1)', 0, 109113, 0, 1, 5, 'baik', '2020-02-04 11:08:58', 'admin', NULL, NULL, 0),
	(6, 'FLOW06', 'Flow Bank BNI (RK2)', 360, 370, 0, 1, 5, 'baik', '2020-02-04 11:48:39', 'admin', '2020-02-04 11:58:23', 'Admin', 0),
	(7, 'FLOW07', 'Flow Equiport (RK3)', 0, 309.5, 0, 1, 5, 'baik', '2020-02-04 11:58:55', 'admin', '2020-02-04 12:18:14', 'Admin', 0),
	(8, 'FLOW08', 'Flow Mutiara Mart (RK4)', 41, 51, 0, 1, 5, 'baik', '2020-02-04 11:59:19', 'admin', '2020-02-04 12:18:18', 'Admin', 0),
	(9, 'FLOW09', 'Flow Intan Sejahtera Utama (RK5)', 201, 215, 0, 1, 5, 'baik', '2020-02-04 12:16:26', 'admin', '2020-02-04 12:18:25', 'Admin', 0),
	(10, 'FLOW10', 'Flow Kace Berkah', 100, 2322.73, 0, 1, 5, 'baik', '2020-02-04 12:17:21', 'admin', NULL, NULL, 0),
	(11, 'FLOW11', 'Flow Kantin', 13, 12, 0, 1, 7, 'baik', '2020-02-04 12:17:42', 'admin', NULL, NULL, 0),
	(12, 'FLOW12', 'Flow Ground Tank', 0, 68228, 0, 1, 7, 'baik', '2020-02-04 12:18:51', 'admin', NULL, NULL, 0);
/*!40000 ALTER TABLE `master_flowmeter` ENABLE KEYS */;

-- Dumping structure for table app-air.master_lumpsum
DROP TABLE IF EXISTS `master_lumpsum`;
CREATE TABLE IF NOT EXISTS `master_lumpsum` (
  `id_lumpsum` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `no_perjanjian` varchar(255) DEFAULT NULL,
  `perihal` varchar(45) DEFAULT NULL,
  `waktu_kadaluarsa` date DEFAULT NULL,
  `nominal` float DEFAULT NULL,
  `id_ref_tenant` int(255) unsigned NOT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_lumpsum`),
  KEY `no_perjanjian` (`no_perjanjian`),
  KEY `id_ref_tenant` (`id_ref_tenant`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.master_lumpsum: ~1 rows (approximately)
/*!40000 ALTER TABLE `master_lumpsum` DISABLE KEYS */;
INSERT INTO `master_lumpsum` (`id_lumpsum`, `no_perjanjian`, `perihal`, `waktu_kadaluarsa`, `nominal`, `id_ref_tenant`, `issued_by`, `issued_at`, `modified_by`, `modified_at`, `soft_delete`) VALUES
	(1, '3/HK.301/2/DUT-2017', 'KERJASAMA PEMANFAATAN LAHAN', '2018-05-31', 40000, 4, 'Mega sartika sari', '2017-09-13 10:25:58', NULL, NULL, 0);
/*!40000 ALTER TABLE `master_lumpsum` ENABLE KEYS */;

-- Dumping structure for table app-air.master_mata_uang
DROP TABLE IF EXISTS `master_mata_uang`;
CREATE TABLE IF NOT EXISTS `master_mata_uang` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `nama_mata_uang` varchar(50) DEFAULT '',
  `simbol` varchar(50) DEFAULT NULL,
  `nilai_tukar` float unsigned NOT NULL DEFAULT '0',
  `soft_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `issued_by` varchar(50) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table app-air.master_mata_uang: ~0 rows (approximately)
/*!40000 ALTER TABLE `master_mata_uang` DISABLE KEYS */;
/*!40000 ALTER TABLE `master_mata_uang` ENABLE KEYS */;

-- Dumping structure for table app-air.master_pompa
DROP TABLE IF EXISTS `master_pompa`;
CREATE TABLE IF NOT EXISTS `master_pompa` (
  `id_master_pompa` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_pompa` varchar(45) DEFAULT NULL,
  `nama_pompa` varchar(255) DEFAULT NULL,
  `kondisi` varchar(45) DEFAULT 'baik',
  `status_aktif` tinyint(1) DEFAULT '1',
  `id_ref_sumur` int(255) unsigned NOT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_master_pompa`),
  KEY `id_ref_sumur` (`id_ref_sumur`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.master_pompa: ~5 rows (approximately)
/*!40000 ALTER TABLE `master_pompa` DISABLE KEYS */;
INSERT INTO `master_pompa` (`id_master_pompa`, `id_pompa`, `nama_pompa`, `kondisi`, `status_aktif`, `id_ref_sumur`, `issued_by`, `issued_at`, `modified_by`, `modified_at`, `soft_delete`) VALUES
	(0, '------', '-------------', 'baik', 0, 0, NULL, NULL, NULL, NULL, 1),
	(1, 'PUMP01', 'Pompa Sumur 01', 'baik', 1, 1, 'Meidi Fahrizal', '2017-08-21 13:35:06', 'meidi', '2017-09-05 11:05:19', 0),
	(2, 'PUMP02', 'Pompa Sumur 02', 'baik', 1, 2, 'Meidi Fahrizal', '2017-08-21 13:35:45', 'wtp', '2020-02-21 14:13:07', 0),
	(3, 'PUMP03', 'Pompa Sumur 03', 'baik', 1, 3, 'Meidi Fahrizal', '2017-08-21 13:36:06', 'wtp', '2017-08-21 14:46:53', 0),
	(4, 'PUMP04', 'Pompa Sumur 04', 'baik', 1, 4, 'Meidi Fahrizal', '2017-08-21 13:36:26', 'wtp', '2020-02-21 14:13:36', 0);
/*!40000 ALTER TABLE `master_pompa` ENABLE KEYS */;

-- Dumping structure for table app-air.master_sumur
DROP TABLE IF EXISTS `master_sumur`;
CREATE TABLE IF NOT EXISTS `master_sumur` (
  `id_master_sumur` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_sumur` varchar(255) NOT NULL DEFAULT '',
  `nama_sumur` varchar(45) DEFAULT NULL,
  `lokasi` varchar(45) DEFAULT NULL,
  `debit_air` float DEFAULT NULL,
  `max_debit_pemakaian` int(11) DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT '1',
  `kondisi` enum('baik','kurang_baik','rusak') DEFAULT 'baik',
  `issued_by` varchar(45) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_master_sumur`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.master_sumur: ~5 rows (approximately)
/*!40000 ALTER TABLE `master_sumur` DISABLE KEYS */;
INSERT INTO `master_sumur` (`id_master_sumur`, `id_sumur`, `nama_sumur`, `lokasi`, `debit_air`, `max_debit_pemakaian`, `status_aktif`, `kondisi`, `issued_by`, `issued_at`, `modified_by`, `modified_at`, `soft_delete`) VALUES
	(0, '--------', '--------', '---------', 0, NULL, 0, 'baik', NULL, NULL, NULL, NULL, 1),
	(1, 'DWW-1', 'Deep Water Well 1', 'Samping Ruko', 13, NULL, 1, 'baik', 'wtp', '2017-08-15 17:01:28', 'Fendy', '2020-01-27 12:15:41', 0),
	(2, 'DWW-2', 'Deep Water Well 2', 'Samping Mercusuar', 10, NULL, 1, 'baik', 'wtp', '2017-08-15 17:12:56', NULL, NULL, 0),
	(3, 'DWW-3', 'Deep Water Well 3', 'Depan Kantor KKT', 10, NULL, 1, 'baik', 'wtp', '2017-08-15 17:13:17', NULL, NULL, 0),
	(4, 'DWW-4', 'Deep Water Well 4', 'Samping Danau', 10, NULL, 1, 'baik', 'wtp', '2017-08-15 17:13:30', NULL, NULL, 0);
/*!40000 ALTER TABLE `master_sumur` ENABLE KEYS */;

-- Dumping structure for table app-air.master_tandon
DROP TABLE IF EXISTS `master_tandon`;
CREATE TABLE IF NOT EXISTS `master_tandon` (
  `id` int(24) unsigned NOT NULL AUTO_INCREMENT,
  `nama_tandon` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `created_by` varchar(128) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_by` varchar(128) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `soft_delete` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table app-air.master_tandon: ~3 rows (approximately)
/*!40000 ALTER TABLE `master_tandon` DISABLE KEYS */;
INSERT INTO `master_tandon` (`id`, `nama_tandon`, `lokasi`, `created_by`, `created_at`, `modified_by`, `modified_at`, `soft_delete`) VALUES
	(0, '------', '-----', NULL, NULL, NULL, NULL, 1),
	(1, 'Tandon Masjid 1', 'Masjid KKT', NULL, NULL, NULL, NULL, 0),
	(2, 'PT. Equiport', 'Samping Gate In (Area ICD)', NULL, '2020-02-18 11:12:46', NULL, NULL, 0);
/*!40000 ALTER TABLE `master_tandon` ENABLE KEYS */;

-- Dumping structure for table app-air.master_tenant
DROP TABLE IF EXISTS `master_tenant`;
CREATE TABLE IF NOT EXISTS `master_tenant` (
  `id_tenant` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `nama_tenant` varchar(255) DEFAULT NULL,
  `penanggung_jawab` varchar(45) DEFAULT NULL,
  `lokasi` varchar(45) DEFAULT NULL,
  `no_telp` varchar(45) DEFAULT NULL,
  `status_aktif_tenant` tinyint(1) DEFAULT '1',
  `pengguna_jasa_id` int(255) unsigned NOT NULL,
  `id_ref_flowmeter` int(255) unsigned NOT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tenant`),
  KEY `pengguna_jasa_id` (`pengguna_jasa_id`),
  KEY `id_ref_flowmeter` (`id_ref_flowmeter`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.master_tenant: ~7 rows (approximately)
/*!40000 ALTER TABLE `master_tenant` DISABLE KEYS */;
INSERT INTO `master_tenant` (`id_tenant`, `nama_tenant`, `penanggung_jawab`, `lokasi`, `no_telp`, `status_aktif_tenant`, `pengguna_jasa_id`, `id_ref_flowmeter`, `issued_by`, `issued_at`, `modified_by`, `modified_at`, `soft_delete`) VALUES
	(1, 'BANK BNI', '-', '-', '-', 1, 1, 6, 'Fendy', '2017-09-04 08:47:31', 'Fendy', '2017-09-04 08:48:22', 0),
	(2, 'PT INTIM TANTO LINES', 'IDHAM', 'RUKO KKT', '081342527981', 1, 1, 5, 'Fendy', '2017-09-04 08:47:53', 'admin', '2017-09-13 10:11:36', 0),
	(3, 'MUTIARA MART', '-', '-', '-', 1, 1, 8, 'Fendy', '2017-09-04 08:48:10', 'Fendy', '2017-09-04 08:48:16', 0),
	(4, 'PT EQUIPORT INTI INDONESIA', 'SUGIARTO', 'DI SAMPING CFS', '081252982263', 1, 1, 7, 'admin', '2017-09-13 10:07:21', 'Fendy', '2017-09-13 12:56:57', 0),
	(5, 'KANTIN', 'Kantin', 'Kantin', '', 1, 1, 7, 'Fendy', '2020-01-24 14:08:18', NULL, NULL, 0),
	(6, 'KACE BERKAH', '-', '-', '-', 1, 1, 10, 'Admin', '2020-02-06 09:57:26', NULL, NULL, 0),
	(7, 'PT INTAN SEJAHTERA UTAMA', NULL, 'RUKO KKT', NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 0);
/*!40000 ALTER TABLE `master_tenant` ENABLE KEYS */;

-- Dumping structure for table app-air.pembeli_darat
DROP TABLE IF EXISTS `pembeli_darat`;
CREATE TABLE IF NOT EXISTS `pembeli_darat` (
  `id_pengguna_jasa` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `nama_pengguna_jasa` varchar(45) DEFAULT NULL,
  `alamat` varchar(45) DEFAULT NULL,
  `no_telp` varchar(45) DEFAULT NULL,
  `pengguna_jasa_id_tarif` int(255) unsigned NOT NULL,
  `npwp` varchar(150) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pengguna_jasa`),
  KEY `fk_pembeli_darat_pengguna_jasa_idx` (`pengguna_jasa_id_tarif`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.pembeli_darat: ~8 rows (approximately)
/*!40000 ALTER TABLE `pembeli_darat` DISABLE KEYS */;
INSERT INTO `pembeli_darat` (`id_pengguna_jasa`, `nama_pengguna_jasa`, `alamat`, `no_telp`, `pengguna_jasa_id_tarif`, `npwp`, `issued_at`, `issued_by`, `last_modified`, `modified_by`, `soft_delete`) VALUES
	(1, 'BAPAK YUSUF', 'JL PULAU BALANG KM.13', '08115797109', 2, NULL, '2017-08-02 10:13:09', 'lala', NULL, NULL, 0),
	(2, 'SPIL', 'JL PULAU BALANG KM.13', '-', 4, NULL, '2017-08-05 14:43:08', 'lala', NULL, NULL, 0),
	(3, 'BAPAK BAYU', 'JL PULAU BALANG KM.13', '-', 2, NULL, '2017-09-04 14:23:54', 'lala', NULL, NULL, 0),
	(4, 'BAPAK RUDI', 'JL PULAU BALANG KM.13', '085247546318', 2, NULL, '2017-09-09 13:48:14', 'lala', NULL, NULL, 0),
	(5, 'COTO DAENG', 'JL PULAU BALANG KM.13', '085345305828', 2, NULL, '2017-09-23 15:24:53', 'loket', NULL, NULL, 0),
	(6, 'IBU AYU', 'JL PULAU BALANG KM.13 (WARUNG SIMPANG 3 KCM)', '085348016521', 2, NULL, '2017-10-22 14:13:14', 'lala', NULL, NULL, 0),
	(7, 'PT. MAHALIA', 'JL. PULAU BALANG', '085250756006', 2, NULL, '2020-02-29 09:03:37', 'marni', NULL, NULL, 0),
	(8, 'DEPO SPIL', 'JL. PULAU BALANG', '0542736960', 4, NULL, '2020-03-02 11:44:57', 'marni', NULL, NULL, 0);
/*!40000 ALTER TABLE `pembeli_darat` ENABLE KEYS */;

-- Dumping structure for table app-air.pembeli_laut
DROP TABLE IF EXISTS `pembeli_laut`;
CREATE TABLE IF NOT EXISTS `pembeli_laut` (
  `id_pengguna_jasa` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_vessel` varchar(45) DEFAULT NULL,
  `nama_vessel` varchar(45) DEFAULT NULL,
  `id_agent_master` int(255) unsigned NOT NULL,
  `pengguna_jasa_id_tarif` int(255) unsigned NOT NULL,
  `issued_at` datetime DEFAULT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pengguna_jasa`),
  KEY `fk_pembeli_laut_pengguna_jasa1_idx` (`pengguna_jasa_id_tarif`),
  KEY `id_agent_master` (`id_agent_master`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.pembeli_laut: ~19 rows (approximately)
/*!40000 ALTER TABLE `pembeli_laut` DISABLE KEYS */;
INSERT INTO `pembeli_laut` (`id_pengguna_jasa`, `id_vessel`, `nama_vessel`, `id_agent_master`, `pengguna_jasa_id_tarif`, `issued_at`, `issued_by`, `last_modified`, `modified_by`, `soft_delete`) VALUES
	(1, 'TTAM', 'TANTO AMAN', 4, 8, '2017-08-03 14:32:14', 'eko', '2017-08-03 14:51:40', 'eko', 0),
	(8, 'ARPA', 'ARMADAM PAPUA', 1, 8, '2017-08-03 14:49:03', 'eko', '2017-08-03 14:51:07', 'eko', 0),
	(9, 'SPCI', 'SPIL CITRA', 1, 8, '2017-08-03 14:52:12', 'eko', NULL, NULL, 0),
	(10, 'SPNN', 'SPIL NINGSIH', 1, 8, '2017-08-23 14:40:51', 'perencanaan', '2017-08-24 15:42:50', 'eko', 0),
	(11, 'LCT ANTASENA', 'LCT ANTASENA', 5, 7, '2017-08-23 14:41:43', 'perencanaan', '2017-08-23 16:25:12', 'eko', 0),
	(12, 'PLNG', 'PULAU LAYANG', 1, 8, '2017-08-23 14:45:59', 'eko', NULL, NULL, 0),
	(13, 'TLUS0037', 'TANTO LUAS', 4, 8, '2017-08-26 10:26:20', 'eko', '2017-08-26 10:26:46', 'eko', 0),
	(14, 'PKBR0039', 'PEKAN BERAU', 1, 8, '2017-08-26 11:29:25', 'eko', NULL, NULL, 0),
	(15, 'TNSH', 'TANTO SEHAT', 4, 8, '2017-08-28 13:20:31', 'eko', '2017-08-28 15:50:55', 'eko', 0),
	(16, 'FRTN', 'FORTUNE', 1, 8, '2017-08-28 15:51:12', 'eko', NULL, NULL, 0),
	(17, 'WRMS0025', 'WARIH MAS', 2, 8, '2017-09-02 23:48:58', 'eko', NULL, NULL, 0),
	(18, 'TNMS', 'TANTO MANIS', 4, 8, '2017-09-05 16:48:16', 'eko', NULL, NULL, 0),
	(19, 'PKRU', 'PEKAN RIAU', 1, 8, '2017-09-08 15:07:58', 'eko', NULL, NULL, 0),
	(21, 'WMBL01', 'WIMBUL', 5, 7, '2017-09-18 11:21:23', 'eko', NULL, NULL, 0),
	(22, 'ORGX', 'ORIENTAL GALAXI', 1, 8, '2017-10-10 08:54:40', 'eko', NULL, NULL, 0),
	(23, 'TNHW', 'TANTO HAWARI', 4, 8, '2017-10-11 08:15:52', 'fendy', NULL, NULL, 0),
	(24, 'HJTR0005', 'HIJAU TERANG', 1, 8, '2017-10-31 09:08:58', 'eko', '2017-10-31 09:09:45', 'eko', 0),
	(26, 'KNMS', 'KANAL MAS', 2, 8, '2020-02-29 19:04:02', 'perencanaan', NULL, NULL, 0),
	(27, 'TNTA', 'TANTO ALAM', 4, 8, '2020-03-02 08:39:50', 'perencanaan', NULL, NULL, 0);
/*!40000 ALTER TABLE `pembeli_laut` ENABLE KEYS */;

-- Dumping structure for table app-air.pencatatan_flow
DROP TABLE IF EXISTS `pencatatan_flow`;
CREATE TABLE IF NOT EXISTS `pencatatan_flow` (
  `id_transaksi` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_ref_flowmeter` int(255) unsigned NOT NULL,
  `waktu_perekaman` datetime DEFAULT NULL,
  `flow_hari_ini` double DEFAULT NULL,
  `status_perekaman` tinyint(1) DEFAULT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `flowmeter_tenant` (`id_ref_flowmeter`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.pencatatan_flow: ~0 rows (approximately)
/*!40000 ALTER TABLE `pencatatan_flow` DISABLE KEYS */;
/*!40000 ALTER TABLE `pencatatan_flow` ENABLE KEYS */;

-- Dumping structure for table app-air.pencatatan_sumur
DROP TABLE IF EXISTS `pencatatan_sumur`;
CREATE TABLE IF NOT EXISTS `pencatatan_sumur` (
  `id_pencatatan` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `id_ref_flowmeter` int(255) unsigned NOT NULL,
  `cuaca_awal` varchar(45) DEFAULT NULL,
  `cuaca_akhir` varchar(45) DEFAULT NULL,
  `flow_sumur_awal` double DEFAULT NULL,
  `flow_sumur_akhir` double DEFAULT NULL,
  `debit_air_awal` double DEFAULT NULL,
  `debit_air_akhir` double DEFAULT NULL,
  `waktu_rekam_awal` datetime DEFAULT NULL,
  `waktu_rekam_akhir` datetime DEFAULT NULL,
  `waktu_perekaman` datetime DEFAULT NULL,
  `status_pencatatan` tinyint(1) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_pencatatan`),
  KEY `id_catat_sumur` (`id_ref_flowmeter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.pencatatan_sumur: ~0 rows (approximately)
/*!40000 ALTER TABLE `pencatatan_sumur` DISABLE KEYS */;
/*!40000 ALTER TABLE `pencatatan_sumur` ENABLE KEYS */;

-- Dumping structure for table app-air.pengguna_jasa
DROP TABLE IF EXISTS `pengguna_jasa`;
CREATE TABLE IF NOT EXISTS `pengguna_jasa` (
  `id_tarif` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `tipe_pengguna_jasa` varchar(45) DEFAULT NULL,
  `kawasan` varchar(45) DEFAULT NULL,
  `tipe` varchar(45) DEFAULT NULL,
  `tarif` float unsigned DEFAULT NULL,
  `id_mata_uang` int(255) unsigned NOT NULL DEFAULT '0',
  `status` enum('domestik','internasional') NOT NULL DEFAULT 'domestik',
  `diskon` float unsigned DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tarif`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.pengguna_jasa: ~7 rows (approximately)
/*!40000 ALTER TABLE `pengguna_jasa` DISABLE KEYS */;
INSERT INTO `pengguna_jasa` (`id_tarif`, `tipe_pengguna_jasa`, `kawasan`, `tipe`, `tarif`, `id_mata_uang`, `status`, `diskon`, `last_modified`, `modified_by`, `issued_at`, `issued_by`, `soft_delete`) VALUES
	(1, 'Ruko', '', 'darat', 24000, 0, 'domestik', 10, '2020-01-23 23:21:49', 'fendy', NULL, NULL, 0),
	(2, 'Perorangan (KIK)', 'KIK', 'darat', 40000, 0, 'domestik', NULL, '2017-07-16 00:00:00', 'operasi', NULL, NULL, 0),
	(3, 'Perorangan (NON-KIK)', 'NON-KIK', 'darat', 100000, 0, 'domestik', NULL, '2017-07-16 00:00:00', 'operasi', NULL, NULL, 0),
	(4, 'Perusahaan (KIK)', 'KIK', 'darat', 40000, 0, 'domestik', NULL, '2017-07-16 00:00:00', 'operasi', NULL, NULL, 0),
	(5, 'Perusahaan (NON-KIK)', 'NON-KIK', 'darat', 100000, 0, 'domestik', NULL, NULL, NULL, NULL, NULL, 0),
	(7, 'Tongkang (LCT)', NULL, 'laut', 18000, 0, 'domestik', NULL, NULL, NULL, NULL, NULL, 0),
	(8, 'Kapal Petikemas', '', 'laut', 24000, 0, 'domestik', 10, '2020-01-24 10:58:01', 'fendy', NULL, NULL, 0);
/*!40000 ALTER TABLE `pengguna_jasa` ENABLE KEYS */;

-- Dumping structure for table app-air.realisasi_tenant
DROP TABLE IF EXISTS `realisasi_tenant`;
CREATE TABLE IF NOT EXISTS `realisasi_tenant` (
  `id_realisasi` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `tgl_transaksi` datetime DEFAULT NULL,
  `tgl_awal` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `id_ref_flowmeter` int(255) unsigned NOT NULL DEFAULT '0',
  `flow_awal` double DEFAULT NULL,
  `flow_akhir` double DEFAULT NULL,
  `status_tagihan` int(1) NOT NULL DEFAULT '0',
  `issued_by` varchar(50) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_realisasi`),
  KEY `id_ref_flowmeter` (`id_ref_flowmeter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table app-air.realisasi_tenant: ~0 rows (approximately)
/*!40000 ALTER TABLE `realisasi_tenant` DISABLE KEYS */;
/*!40000 ALTER TABLE `realisasi_tenant` ENABLE KEYS */;

-- Dumping structure for table app-air.realisasi_transaksi_darat
DROP TABLE IF EXISTS `realisasi_transaksi_darat`;
CREATE TABLE IF NOT EXISTS `realisasi_transaksi_darat` (
  `id_realisasi` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `tgl_pembayaran` datetime DEFAULT NULL,
  `no_nota` varchar(45) DEFAULT NULL,
  `no_faktur` varchar(45) DEFAULT NULL,
  `id_ref_transaksi` int(255) unsigned NOT NULL,
  `issued_at` datetime DEFAULT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_realisasi`),
  KEY `id_ref_transaksi` (`id_ref_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.realisasi_transaksi_darat: ~0 rows (approximately)
/*!40000 ALTER TABLE `realisasi_transaksi_darat` DISABLE KEYS */;
/*!40000 ALTER TABLE `realisasi_transaksi_darat` ENABLE KEYS */;

-- Dumping structure for table app-air.realisasi_transaksi_laut
DROP TABLE IF EXISTS `realisasi_transaksi_laut`;
CREATE TABLE IF NOT EXISTS `realisasi_transaksi_laut` (
  `id_realisasi` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `tgl_pembayaran` datetime DEFAULT NULL,
  `no_nota` varchar(45) DEFAULT NULL,
  `no_faktur` varchar(45) DEFAULT NULL,
  `id_ref_transaksi` int(255) unsigned NOT NULL,
  `issued_at` datetime DEFAULT NULL,
  `issued_by` varchar(45) NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_realisasi`),
  KEY `id_ref_transaksi` (`id_ref_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.realisasi_transaksi_laut: ~0 rows (approximately)
/*!40000 ALTER TABLE `realisasi_transaksi_laut` DISABLE KEYS */;
/*!40000 ALTER TABLE `realisasi_transaksi_laut` ENABLE KEYS */;

-- Dumping structure for table app-air.realisasi_transaksi_tenant
DROP TABLE IF EXISTS `realisasi_transaksi_tenant`;
CREATE TABLE IF NOT EXISTS `realisasi_transaksi_tenant` (
  `id_realisasi` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `tgl_pembayaran` datetime DEFAULT NULL,
  `no_nota` varchar(255) DEFAULT NULL,
  `no_faktur` varchar(255) DEFAULT NULL,
  `id_ref_transaksi` int(255) unsigned NOT NULL,
  `issued_by` varchar(45) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_realisasi`),
  KEY `id_ref_transaksi` (`id_ref_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.realisasi_transaksi_tenant: ~0 rows (approximately)
/*!40000 ALTER TABLE `realisasi_transaksi_tenant` DISABLE KEYS */;
/*!40000 ALTER TABLE `realisasi_transaksi_tenant` ENABLE KEYS */;

-- Dumping structure for table app-air.reference
DROP TABLE IF EXISTS `reference`;
CREATE TABLE IF NOT EXISTS `reference` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(45) DEFAULT NULL,
  `stringVal` varchar(255) DEFAULT NULL,
  `intVal` int(255) DEFAULT NULL,
  `dateTimeVal` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nama` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.reference: ~2 rows (approximately)
/*!40000 ALTER TABLE `reference` DISABLE KEYS */;
INSERT INTO `reference` (`id`, `nama`, `stringVal`, `intVal`, `dateTimeVal`) VALUES
	(1, 'no_kwitansi', '', 5, NULL),
	(2, 'no_invoice', '', 1, NULL);
/*!40000 ALTER TABLE `reference` ENABLE KEYS */;

-- Dumping structure for table app-air.role
DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) DEFAULT NULL,
  `nama_role` varchar(255) DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.role: ~8 rows (approximately)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id_role`, `role`, `nama_role`, `soft_delete`) VALUES
	(0, '-----', '------', 1),
	(1, 'admin', 'Admin', 0),
	(2, 'keuangan', 'Keuangan', 0),
	(3, 'operasi', 'Operasi', 0),
	(5, 'loket', 'Loket', 0),
	(7, 'perencanaan', 'Perencanaan', 0),
	(8, 'wtp', 'WTP', 0),
	(9, 'teknik', 'Teknik', 0);
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Dumping structure for table app-air.service_log
DROP TABLE IF EXISTS `service_log`;
CREATE TABLE IF NOT EXISTS `service_log` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `log` varchar(255) DEFAULT '',
  `user` varchar(255) DEFAULT '',
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- Dumping data for table app-air.service_log: ~25 rows (approximately)
/*!40000 ALTER TABLE `service_log` DISABLE KEYS */;
INSERT INTO `service_log` (`id`, `log`, `user`, `time`) VALUES
	(1, 'Insert Permohonan Air Kapal Dengan ID Transaksi 6', 'perencanaan', '2020-02-28 16:32:39'),
	(2, 'Ubah Waktu Pengisian Air Kapal Dengan ID Transaksi 6', 'arifin', '2020-02-28 16:33:13'),
	(3, 'Update Realisasi Pengisian Air Kapal Dengan ID Transaksi 6', 'arifin', '2020-02-28 17:55:49'),
	(4, 'Penginputan Transaksi Darat Dengan ID Transaksi 5', 'marni', '2020-02-29 09:03:37'),
	(5, 'Penginputan Transaksi Darat Dengan ID Transaksi 6', 'marni', '2020-02-29 09:04:32'),
	(6, 'Pembatalan Permohonan Air Darat Dengan ID Transaksi 6', 'marni', '2020-02-29 09:08:57'),
	(7, 'Insert Permohonan Air Kapal Dengan ID Transaksi 7', 'perencanaan', '2020-02-29 10:03:11'),
	(8, 'Ubah Waktu Pengisian Air Kapal Dengan ID Transaksi 7', 'arifin', '2020-02-29 10:04:11'),
	(9, 'Update Realisasi Pengisian Air Kapal Dengan ID Transaksi 7', 'arifin', '2020-02-29 11:48:11'),
	(10, 'Insert Permohonan Air Kapal Dengan ID Transaksi 8', 'perencanaan', '2020-02-29 17:02:52'),
	(11, 'Insert Permohonan Air Kapal Dengan ID Transaksi 9', 'perencanaan', '2020-02-29 19:05:01'),
	(12, 'Ubah Waktu Pengisian Air Kapal Dengan ID Transaksi 9', 'arifin', '2020-02-29 19:05:31'),
	(13, 'Update Realisasi Pengisian Air Kapal Dengan ID Transaksi 9', 'arifin', '2020-02-29 22:10:25'),
	(14, 'Insert Permohonan Air Kapal Dengan ID Transaksi 10', 'perencanaan', '2020-03-02 08:33:27'),
	(15, 'Insert Permohonan Air Kapal Dengan ID Transaksi 11', 'perencanaan', '2020-03-02 08:38:38'),
	(16, 'Cancel Nota Air Kapal Dengan ID Transaksi 10', 'perencanaan', '2020-03-02 08:39:03'),
	(17, 'Insert Permohonan Air Kapal Dengan ID Transaksi 12', 'perencanaan', '2020-03-02 08:40:30'),
	(18, 'Cancel Nota Air Kapal Dengan ID Transaksi 11', 'perencanaan', '2020-03-02 08:40:41'),
	(19, 'Ubah Waktu Pengisian Air Kapal Dengan ID Transaksi 12', 'arifin', '2020-03-02 09:04:58'),
	(20, 'Update Realisasi Pengisian Air Kapal Dengan ID Transaksi 12', 'arifin', '2020-03-02 11:13:58'),
	(21, 'Penginputan Transaksi Darat Dengan ID Transaksi 7', 'marni', '2020-03-02 11:44:57'),
	(22, 'Pengubahan Waktu Pengantaran Air Darat Dengan ID Transaksi 7', 'arifin', '2020-03-02 13:17:14'),
	(23, 'Update Realisasi Air Darat Dengan ID Transaksi 7', 'arifin', '2020-03-02 15:59:47'),
	(24, 'Insert Permohonan Air Kapal Dengan ID Transaksi 13', 'perencanaan', '2020-03-02 17:14:45'),
	(25, 'Cancel Nota Air Kapal Dengan ID Transaksi 8', 'perencanaan', '2020-03-02 17:19:46');
/*!40000 ALTER TABLE `service_log` ENABLE KEYS */;

-- Dumping structure for table app-air.table_menu
DROP TABLE IF EXISTS `table_menu`;
CREATE TABLE IF NOT EXISTS `table_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `icon` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `second_uri` varchar(45) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1',
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

-- Dumping data for table app-air.table_menu: ~51 rows (approximately)
/*!40000 ALTER TABLE `table_menu` DISABLE KEYS */;
INSERT INTO `table_menu` (`id`, `parent_id`, `title`, `icon`, `url`, `second_uri`, `position`, `is_active`, `soft_delete`) VALUES
	(1, 0, 'Master Data', NULL, NULL, NULL, NULL, 1, 0),
	(2, 0, 'Air Darat', NULL, NULL, NULL, NULL, 1, 0),
	(3, 0, 'Air Kapal', NULL, NULL, NULL, NULL, 1, 0),
	(4, 0, 'Air Tenant/Ruko', NULL, NULL, NULL, NULL, 1, 0),
	(5, 0, 'Monitoring', NULL, NULL, NULL, NULL, 1, 0),
	(6, 0, 'Pembayaran', NULL, NULL, NULL, NULL, 1, 0),
	(7, 0, 'Laporan', NULL, NULL, NULL, NULL, 1, 0),
	(8, 2, 'Form Permohonan', NULL, 'darat/input_darat', NULL, 1, 1, 0),
	(9, 3, 'Form Permohonan', NULL, 'kapal/input_laut', NULL, 1, 1, 0),
	(10, 1, 'Master Sumur', NULL, 'master/sumur', '', 1, 1, 0),
	(11, 1, 'Master Pompa', NULL, 'master/pompa', '', 3, 1, 0),
	(12, 1, 'Master Flow Meter', NULL, 'master/flowmeter', '', 2, 1, 0),
	(13, 1, 'Master Pengguna Jasa', NULL, 'master/pengguna_jasa', '', 9, 1, 0),
	(14, 1, 'Master Vessel', NULL, 'master/vessel', '', 7, 1, 0),
	(15, 1, 'Master Agent', NULL, 'master/agent', '', 6, 1, 0),
	(16, 1, 'Master Tenant', NULL, 'master/tenant', '', 4, 1, 0),
	(17, 1, 'Kontrak Lumpsum', NULL, 'master/lumpsum', '', 10, 1, 0),
	(18, 1, 'Penyesuian Tarif', NULL, 'master/tarif', '', 8, 1, 0),
	(19, 6, 'Realisasi Bayar Jasa Air Kapal (Piutang)', NULL, 'pembayaran/pembayaran_kapal_piutang', NULL, NULL, 1, 0),
	(20, 6, 'Realisasi Bayar Air Darat (Piutang)', NULL, 'pembayaran/pembayaran_darat_piutang', NULL, NULL, 1, 0),
	(21, 6, 'Validasi Bayar Air Darat (Cash)', NULL, 'pembayaran/pembayaran_darat_cash', NULL, NULL, 1, 0),
	(22, 6, 'Pembatalan Bayar Air Darat (Cash)', NULL, 'pembayaran/pembatalan_darat_cash', NULL, NULL, 1, 0),
	(23, 6, 'Realisasi Bayar Air Tenant (Piutang)', NULL, 'pembayaran/pembayaran_tenant', NULL, NULL, 1, 0),
	(24, 7, 'Realisasi Pelayanan Air Kapal', NULL, 'report/laporan_transaksi_kapal', NULL, NULL, 1, 0),
	(25, 7, 'Realisasi Pelayanan Air Darat', NULL, 'report/laporan_transaksi_darat', NULL, NULL, 1, 0),
	(26, 7, 'Pencatatan Flow Meter', NULL, 'report/laporan_catat_flow', NULL, NULL, 1, 0),
	(27, 7, 'Pencatatan Sumur', NULL, 'report/laporan_catat_sumur', NULL, NULL, 1, 0),
	(28, 7, 'Realisasi Pelayanan Air Tenant/Ruko', NULL, 'report/laporan_transaksi_tenant', NULL, NULL, 1, 0),
	(29, 2, 'Daftar Permohonan', NULL, 'monitoring/permohonan_air_darat', NULL, 2, 1, 0),
	(31, 3, 'Daftar Permohonan Air Kapal', NULL, 'monitoring/tagihan_air_kapal', NULL, 2, 1, 0),
	(33, 3, 'Daftar Pelayanan Jasa Air Kapal', NULL, 'monitoring/pelayanan_air_kapal', NULL, 3, 1, 0),
	(34, 5, 'Proses Pelayanan Air Darat', NULL, 'monitoring/monitoring_air_darat', NULL, NULL, 1, 0),
	(35, 5, 'Proses Pelayanan Air Kapal', NULL, 'monitoring/monitoring_air_kapal', NULL, NULL, 1, 0),
	(36, 4, 'Pencatatan Flow Meter', NULL, 'tenant/pencatatan_flow_harian', NULL, 2, 1, 0),
	(38, 4, 'Pencatatan Sumur', NULL, 'tenant/pencatatan_sumur_harian', NULL, 3, 1, 0),
	(40, 4, 'Pembuatan Realisasi Penggunaan Air', NULL, 'tenant/realisasi_air_tenant', 'tenant', 4, 1, 0),
	(41, 4, 'Daftar Tagihan Pelayanan', NULL, 'tenant/tagihan_air_tenant', NULL, 7, 1, 0),
	(42, 1, 'Master Menu', NULL, 'master/manage_menu', '', 12, 1, 0),
	(43, 1, 'Master User', NULL, 'master/manage_user', '', 11, 1, 0),
	(44, 1, 'Manajemen Hak Akses', NULL, 'master/manage_access', '', 13, 1, 0),
	(45, 2, 'Daftar Pengantaran Air Darat', NULL, 'monitoring/pengantaran_air_darat', NULL, 3, 1, 0),
	(46, 4, 'Pencatatan Pengisian Tandon', NULL, 'tenant/pencatatan_pengisian_tandon', 'tenant', 1, 1, 0),
	(47, 1, 'Master Tandon', NULL, 'master/tandon', '', 5, 1, 0),
	(48, 7, 'Pencatatan Pengisian Tandon', NULL, 'report/laporan_transaksi_tandon', NULL, NULL, 1, 0),
	(49, 4, 'Daftar Realisasi Penggunaan Air', NULL, 'tenant/daftar_realisasi_air_tenant', NULL, 6, 1, 0),
	(50, 4, 'Pembuatan Tagihan Pelayanan', NULL, 'tenant/penagihan_air_tenant', NULL, 5, 1, 0),
	(51, 7, 'Pembayaran Air Kapal', NULL, 'report/laporan_transaksi_kapal_keuangan', NULL, NULL, 1, 0),
	(52, 7, 'Pembayaran Air Darat', NULL, 'report/laporan_transaksi_darat_keuangan', NULL, NULL, 1, 0),
	(53, 7, 'Pembayaran Air Tenant/Ruko', NULL, 'report/laporan_transaksi_tenant_keuangan', NULL, NULL, 1, 0),
	(54, 7, 'Realisasi Penggunaan Air Tenant', NULL, 'report/laporan_realisasi_pemakaian_air', NULL, NULL, 1, 0),
	(55, 1, 'Master Mata Uang', NULL, 'master/mata_uang', 'master', NULL, 1, 0);
/*!40000 ALTER TABLE `table_menu` ENABLE KEYS */;

-- Dumping structure for table app-air.transaksi_darat
DROP TABLE IF EXISTS `transaksi_darat`;
CREATE TABLE IF NOT EXISTS `transaksi_darat` (
  `id_transaksi` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `pembeli_darat_id_pengguna_jasa` int(255) unsigned NOT NULL,
  `tgl_transaksi` datetime DEFAULT NULL,
  `tgl_perm_pengantaran` datetime DEFAULT NULL,
  `total_permintaan` float DEFAULT NULL,
  `nama_pemohon` varchar(45) DEFAULT NULL,
  `realisasi_pengisian` float DEFAULT NULL,
  `tarif` float DEFAULT NULL,
  `diskon` float DEFAULT NULL,
  `pengantar` varchar(45) DEFAULT NULL,
  `no_kwitansi` varchar(45) DEFAULT NULL,
  `status_pembayaran` tinyint(1) DEFAULT '0',
  `status_invoice` tinyint(1) DEFAULT '0',
  `status_delivery` tinyint(1) DEFAULT '0',
  `waktu_mulai_pengantaran` datetime DEFAULT NULL,
  `waktu_selesai_pengantaran` datetime DEFAULT NULL,
  `waktu_selesai_pembayaran` datetime DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `issued_by` varchar(45) NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) NOT NULL,
  `soft_delete` tinyint(1) DEFAULT '0',
  `batal_nota` tinyint(1) DEFAULT '0',
  `batal_kwitansi` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_transaksi`),
  KEY `fk_transaksi_darat_pembeli_darat1_idx` (`pembeli_darat_id_pengguna_jasa`),
  KEY `no_kwitansi` (`no_kwitansi`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.transaksi_darat: ~4 rows (approximately)
/*!40000 ALTER TABLE `transaksi_darat` DISABLE KEYS */;
INSERT INTO `transaksi_darat` (`id_transaksi`, `pembeli_darat_id_pengguna_jasa`, `tgl_transaksi`, `tgl_perm_pengantaran`, `total_permintaan`, `nama_pemohon`, `realisasi_pengisian`, `tarif`, `diskon`, `pengantar`, `no_kwitansi`, `status_pembayaran`, `status_invoice`, `status_delivery`, `waktu_mulai_pengantaran`, `waktu_selesai_pengantaran`, `waktu_selesai_pembayaran`, `issued_at`, `issued_by`, `last_modified`, `modified_by`, `soft_delete`, `batal_nota`, `batal_kwitansi`) VALUES
	(4, 2, '2020-02-27 10:13:26', '2020-02-27 10:30:00', 5, 'SPIL', 5, 40000, NULL, 'Wahyu & Juned', '200400002', 0, 1, 1, '2020-02-27 10:16:51', '2020-02-27 11:43:22', NULL, '2020-02-27 10:13:26', 'muzdalifah', '2020-02-27 11:43:22', 'arifin', 0, 0, 0),
	(5, 7, '2020-02-29 09:03:37', '2020-02-29 09:03:00', 1, 'BPK ASRIANTO', NULL, 40000, NULL, NULL, '200200003', 0, 0, 0, NULL, NULL, NULL, '2020-02-29 09:03:37', 'marni', NULL, '', 0, 0, 0),
	(6, 7, '2020-02-29 09:04:32', '2020-02-29 09:04:00', 1, 'PT. MAHALIA', NULL, 40000, NULL, NULL, '200200004', 0, 0, 0, NULL, NULL, NULL, '2020-02-29 09:04:32', 'marni', NULL, '', 1, 0, 0),
	(7, 8, '2020-03-02 11:44:57', '2020-03-02 12:00:00', 5, 'DEPO SPIL', 5, 40000, NULL, 'Tomi & Yusran', '200400005', 0, 1, 1, '2020-03-02 13:17:14', '2020-03-02 15:59:47', NULL, '2020-03-02 11:44:57', 'marni', '2020-03-02 15:59:47', 'arifin', 0, 0, 0);
/*!40000 ALTER TABLE `transaksi_darat` ENABLE KEYS */;

-- Dumping structure for table app-air.transaksi_laut
DROP TABLE IF EXISTS `transaksi_laut`;
CREATE TABLE IF NOT EXISTS `transaksi_laut` (
  `id_transaksi` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `pembeli_laut_id_pengguna_jasa` int(255) unsigned NOT NULL,
  `voy_no` varchar(45) DEFAULT NULL,
  `nama_pemohon` varchar(45) DEFAULT NULL,
  `status_kapal` enum('internasional','domestik') NOT NULL DEFAULT 'domestik',
  `tgl_transaksi` datetime DEFAULT NULL,
  `waktu_pelayanan` datetime DEFAULT NULL,
  `tipe_kapal` int(255) DEFAULT NULL,
  `total_permintaan` double DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `tarif` float DEFAULT NULL,
  `tarif_internasional` float DEFAULT NULL,
  `nilai_tukar` float DEFAULT NULL,
  `mata_uang` varchar(50) DEFAULT 'Rupiah',
  `simbol` varchar(50) DEFAULT 'Rp. ',
  `diskon` float DEFAULT NULL,
  `start_work` datetime DEFAULT NULL,
  `end_work` datetime DEFAULT NULL,
  `confirm_permintaan` datetime DEFAULT NULL,
  `flowmeter_awal` double DEFAULT NULL,
  `flowmeter_akhir` double DEFAULT NULL,
  `flowmeter_awal_2` double DEFAULT NULL,
  `flowmeter_akhir_2` double DEFAULT NULL,
  `flowmeter_awal_3` double DEFAULT NULL,
  `flowmeter_akhir_3` double DEFAULT NULL,
  `flowmeter_awal_4` double DEFAULT NULL,
  `flowmeter_akhir_4` double DEFAULT NULL,
  `pengisi` varchar(45) DEFAULT NULL,
  `status_print` tinyint(1) NOT NULL DEFAULT '0',
  `status_pengerjaan` tinyint(1) NOT NULL DEFAULT '0',
  `status_invoice` tinyint(1) NOT NULL DEFAULT '1',
  `issued_at` datetime DEFAULT NULL,
  `issued_by` varchar(45) NOT NULL DEFAULT '',
  `last_modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) NOT NULL,
  `soft_delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_transaksi`),
  KEY `fk_transaksi_laut_pembeli_laut1_idx` (`pembeli_laut_id_pengguna_jasa`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.transaksi_laut: ~11 rows (approximately)
/*!40000 ALTER TABLE `transaksi_laut` DISABLE KEYS */;
INSERT INTO `transaksi_laut` (`id_transaksi`, `pembeli_laut_id_pengguna_jasa`, `voy_no`, `nama_pemohon`, `status_kapal`, `tgl_transaksi`, `waktu_pelayanan`, `tipe_kapal`, `total_permintaan`, `keterangan`, `tarif`, `tarif_internasional`, `nilai_tukar`, `mata_uang`, `simbol`, `diskon`, `start_work`, `end_work`, `confirm_permintaan`, `flowmeter_awal`, `flowmeter_akhir`, `flowmeter_awal_2`, `flowmeter_akhir_2`, `flowmeter_awal_3`, `flowmeter_akhir_3`, `flowmeter_awal_4`, `flowmeter_akhir_4`, `pengisi`, `status_print`, `status_pengerjaan`, `status_invoice`, `issued_at`, `issued_by`, `last_modified`, `modified_by`, `soft_delete`) VALUES
	(3, 1, '251', 'BUDI', 'domestik', '2020-02-25 13:21:27', '2020-02-25 10:45:00', 8, 100, 'isi full ', 24000, NULL, NULL, 'Rupiah', 'Rp. ', 10, '2020-02-25 13:32:14', '2020-02-25 14:48:38', NULL, 26440, 26519, 0, 0, 0, 0, 0, 0, 'TOMI & YUSRAN', 0, 1, 1, '2020-02-25 13:21:27', 'perencanaan', '2020-02-25 14:48:38', 'arifin', 0),
	(4, 11, '-', 'kapten kapal', 'domestik', '2020-02-25 15:34:40', '2020-02-25 15:34:00', 7, 105, '105', 18000, NULL, NULL, 'Rupiah', 'Rp. ', NULL, '2020-02-25 15:50:47', '2020-02-25 17:41:52', NULL, 40175, 40280, 0, 0, 0, 0, 0, 0, 'TOMI & YUSRAN', 0, 1, 1, '2020-02-25 15:34:40', 'perencanaan', '2020-02-25 17:41:52', 'arifin', 0),
	(5, 11, '-', 'kapten kapal', 'domestik', '2020-02-27 10:35:34', '2020-02-27 10:35:00', 7, 50, '', 18000, NULL, NULL, 'Rupiah', 'Rp. ', NULL, '2020-02-27 11:43:46', '2020-02-27 13:20:26', NULL, 40280, 40372, 0, 0, 0, 0, 0, 0, 'junet & wahyu', 0, 1, 1, '2020-02-27 10:35:34', 'perencanaan', '2020-02-27 13:20:26', 'arifin', 0),
	(6, 11, '1420', 'kapten kapal', 'domestik', '2020-02-28 16:32:39', '2020-02-28 16:32:00', 7, 100, '100', 18000, NULL, NULL, 'Rupiah', 'Rp. ', NULL, '2020-02-28 16:33:13', '2020-02-28 17:55:49', NULL, 40372, 40477, 0, 0, 0, 0, 0, 0, 'TOMI & YUSRAN', 0, 1, 1, '2020-02-28 16:32:39', 'perencanaan', '2020-02-28 17:55:49', 'arifin', 0),
	(7, 11, '251', '08115986717', 'domestik', '2020-02-29 10:03:11', '2020-02-29 10:02:00', 7, 100, 'ISI 100 TON', 18000, NULL, NULL, 'Rupiah', 'Rp. ', NULL, '2020-02-29 10:04:11', '2020-02-29 11:48:11', NULL, 40477, 40577, 0, 0, 0, 0, 0, 0, 'APRI & Diyanto', 0, 1, 1, '2020-02-29 10:03:11', 'perencanaan', '2020-02-29 11:48:11', 'arifin', 0),
	(8, 0, '1220', 'RUSLI', 'domestik', '2020-02-29 17:02:52', '2020-02-29 17:02:00', 0, 60, '60', NULL, NULL, NULL, 'Rupiah', 'Rp. ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2020-02-29 17:02:52', 'perencanaan', NULL, '', 1),
	(9, 26, '1220', 'RUSLI', 'domestik', '2020-02-29 19:05:01', '2020-02-29 19:04:00', 8, 60, '', 24000, NULL, NULL, 'Rupiah', 'Rp. ', 10, '2020-02-29 19:05:31', '2020-02-29 22:10:25', NULL, 24491, 24551, 0, 0, 0, 0, 0, 0, 'TOMI & YUSRAN', 0, 1, 1, '2020-02-29 19:05:01', 'perencanaan', '2020-02-29 22:10:25', 'arifin', 0),
	(10, 0, '256', 'BUDI', 'domestik', '2020-03-02 08:33:27', '2020-03-02 09:00:00', 0, 100, 'isi full ', NULL, NULL, NULL, 'Rupiah', 'Rp. ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2020-03-02 08:33:27', 'perencanaan', NULL, '', 1),
	(11, 0, '256', 'BUDI TANTO', 'domestik', '2020-03-02 08:38:38', '2020-03-02 09:00:00', 0, 100, 'isi full ', NULL, NULL, NULL, 'Rupiah', 'Rp. ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2020-03-02 08:38:38', 'perencanaan', NULL, '', 1),
	(12, 27, '256', 'BUDI TANTO', 'domestik', '2020-03-02 08:40:30', '2020-03-02 09:00:00', 8, 100, 'isi full ', 24000, NULL, NULL, 'Rupiah', 'Rp. ', 10, '2020-03-02 09:04:58', '2020-03-02 11:13:58', NULL, 26519, 26571, 0, 0, 0, 0, 0, 0, 'TOMI & YUSRAN', 0, 1, 1, '2020-03-02 08:40:30', 'perencanaan', '2020-03-02 11:13:58', 'arifin', 0),
	(13, 11, '-', 'kapten kapal', 'domestik', '2020-03-02 17:14:45', '2020-03-02 19:00:00', 7, 100, '-', 18000, NULL, NULL, 'Rupiah', 'Rp. ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2020-03-02 17:14:45', 'perencanaan', NULL, '', 0);
/*!40000 ALTER TABLE `transaksi_laut` ENABLE KEYS */;

-- Dumping structure for table app-air.transaksi_tandon
DROP TABLE IF EXISTS `transaksi_tandon`;
CREATE TABLE IF NOT EXISTS `transaksi_tandon` (
  `id_transaksi` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `waktu_perekaman` datetime DEFAULT NULL,
  `id_ref_tandon` int(11) DEFAULT NULL,
  `total_pengisian` float DEFAULT NULL,
  `status_pencatatan` int(1) DEFAULT NULL,
  `issued_by` varchar(150) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `modified_by` varchar(150) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table app-air.transaksi_tandon: ~0 rows (approximately)
/*!40000 ALTER TABLE `transaksi_tandon` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaksi_tandon` ENABLE KEYS */;

-- Dumping structure for table app-air.transaksi_tenant
DROP TABLE IF EXISTS `transaksi_tenant`;
CREATE TABLE IF NOT EXISTS `transaksi_tenant` (
  `id_transaksi` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `tgl_transaksi` datetime DEFAULT NULL,
  `tgl_awal` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `id_ref_flowmeter` int(255) unsigned NOT NULL,
  `id_ref_realisasi` int(255) unsigned NOT NULL DEFAULT '0',
  `total_pakai` double DEFAULT NULL,
  `tarif` float DEFAULT NULL,
  `diskon` float DEFAULT NULL,
  `total_bayar` double DEFAULT NULL,
  `no_invoice` varchar(45) DEFAULT NULL,
  `status_invoice` tinyint(1) DEFAULT '1',
  `status_print` tinyint(1) DEFAULT '0',
  `issued_by` varchar(45) DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_transaksi`),
  KEY `id_ref_tenant` (`id_ref_flowmeter`),
  KEY `id_ref_realisasi` (`id_ref_realisasi`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.transaksi_tenant: ~0 rows (approximately)
/*!40000 ALTER TABLE `transaksi_tenant` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaksi_tenant` ENABLE KEYS */;

-- Dumping structure for table app-air.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT '1',
  `password` varchar(255) NOT NULL DEFAULT '',
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `link` varchar(400) DEFAULT NULL,
  `oauth_id` int(50) unsigned DEFAULT NULL,
  `is_active` int(1) DEFAULT '1',
  `role` int(11) unsigned NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `soft_delete` int(1) NOT NULL DEFAULT '0',
  `date_created` datetime DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`),
  KEY `username` (`username`),
  KEY `role` (`role`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table app-air.users: ~7 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id_user`, `username`, `email`, `email_verified`, `password`, `first_name`, `last_name`, `gender`, `picture`, `link`, `oauth_id`, `is_active`, `role`, `last_login`, `last_modified`, `modified_by`, `soft_delete`, `date_created`, `created_by`) VALUES
	(1, 'admin', 'kwanterpepen@gmail.com', 1, '$2y$10$Z2iGMUZQBa9NuYuggL0HfO9nVkfwKNduvXfLrb.P5.8RNtML07xX6', 'Admin', NULL, NULL, NULL, NULL, NULL, 1, 1, '2020-02-27 10:06:10', '2020-01-23 14:44:24', 'admin', 0, NULL, NULL),
	(2, 'fendy', 'fendy24kwan@gmail.com', 1, '$2y$10$RWXsewK7P9nWHN8qjhuivOoC6Ps6ObhY2t5fNPClqKiPpLwDAw26.', 'Fendy', NULL, NULL, NULL, NULL, NULL, 1, 1, '2020-02-24 16:12:22', '2020-02-24 16:31:50', 'admin', 0, '2020-01-23 15:06:34', 'admin'),
	(3, 'arifin', 'arifin.nst@kariangauterminal.co.id', 1, '$2y$10$7dF9xY2eM5YJW1tQeERopOUWFL4Jjxo42sjkjn0iYcS4eNBJFYxUS', 'Bustanul Arifin', 'Nasution', NULL, NULL, NULL, NULL, 1, 8, '2020-03-02 15:58:09', NULL, NULL, 0, '2020-02-24 16:20:02', 'fendy'),
	(4, 'mario', 'mario@kariangauterminal.co.id', 1, '$2y$10$8wd9av1QmmBr7LTFRTnfmuvw2EJ50JZy1LeH2/4z6mWM02N5hbRFa', 'Febri Mario', 'Aruan', NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, '2020-02-24 16:26:51', 'fendy'),
	(5, 'perencanaan', 'perencanaankkt@kariangauterminal.co.id', 1, '$2y$10$2II9cBbjcrBbMWVDQOQAfeI1vUXXKQZdrtI2sVMBIIKFV8mbg1V/e', 'Perencanaan', '', NULL, NULL, NULL, NULL, 1, 7, '2020-03-02 17:13:44', '2020-02-25 13:18:49', NULL, 0, '2020-02-25 12:23:46', 'fendy'),
	(6, 'muzdalifah', 'muzdalifahzulkarnainn@gmail.com', 1, '$2y$10$ynaQ98Ff00S0jOA2voOgyOrPxwmWuAT43adlGvzAgL.aCNpvvEzuK', 'Muzdalifah', 'Zulkarnain', NULL, NULL, NULL, NULL, 1, 5, '2020-02-27 10:37:49', '2020-02-27 10:37:32', NULL, 0, '2020-02-27 10:07:12', 'admin'),
	(7, 'marni', 'sumarni1902@gmail.com', 1, '$2y$10$/2xRcF01/BTfWKT0rYdtE.PGQ9tzBAbKN4WA2m4IsCbgj/fsuJ9fe', 'Sumarni', '', NULL, NULL, NULL, NULL, 1, 5, '2020-03-02 13:31:19', '2020-02-27 10:55:25', NULL, 0, '2020-02-27 10:10:51', 'admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table app-air.user_access_menu
DROP TABLE IF EXISTS `user_access_menu`;
CREATE TABLE IF NOT EXISTS `user_access_menu` (
  `role_id` int(11) unsigned NOT NULL,
  `menu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table app-air.user_access_menu: ~131 rows (approximately)
/*!40000 ALTER TABLE `user_access_menu` DISABLE KEYS */;
INSERT INTO `user_access_menu` (`role_id`, `menu_id`) VALUES
	(9, 7),
	(9, 28),
	(6, 1),
	(6, 7),
	(6, 4),
	(6, 3),
	(6, 16),
	(6, 17),
	(6, 18),
	(6, 31),
	(6, 41),
	(6, 40),
	(6, 28),
	(6, 24),
	(6, 25),
	(5, 1),
	(5, 7),
	(5, 5),
	(5, 2),
	(5, 13),
	(5, 29),
	(5, 8),
	(5, 34),
	(5, 25),
	(3, 1),
	(3, 7),
	(3, 4),
	(3, 3),
	(3, 17),
	(3, 18),
	(3, 16),
	(3, 31),
	(3, 41),
	(3, 50),
	(3, 24),
	(3, 28),
	(3, 25),
	(7, 1),
	(7, 7),
	(7, 3),
	(7, 14),
	(7, 31),
	(7, 9),
	(7, 35),
	(7, 24),
	(1, 1),
	(1, 7),
	(1, 6),
	(1, 5),
	(1, 4),
	(1, 3),
	(1, 2),
	(1, 17),
	(1, 18),
	(1, 47),
	(1, 44),
	(1, 43),
	(1, 42),
	(1, 16),
	(1, 15),
	(1, 14),
	(1, 11),
	(1, 10),
	(1, 12),
	(1, 13),
	(1, 8),
	(1, 45),
	(1, 29),
	(1, 33),
	(1, 31),
	(1, 9),
	(1, 46),
	(1, 41),
	(1, 49),
	(1, 50),
	(1, 40),
	(1, 36),
	(1, 38),
	(1, 34),
	(1, 35),
	(1, 22),
	(1, 20),
	(1, 19),
	(1, 23),
	(1, 21),
	(1, 53),
	(1, 52),
	(1, 51),
	(1, 48),
	(1, 26),
	(1, 24),
	(1, 25),
	(1, 27),
	(1, 28),
	(1, 54),
	(8, 1),
	(8, 7),
	(8, 5),
	(8, 4),
	(8, 3),
	(8, 2),
	(8, 47),
	(8, 11),
	(8, 12),
	(8, 45),
	(8, 33),
	(8, 46),
	(8, 49),
	(8, 40),
	(8, 36),
	(8, 38),
	(8, 34),
	(8, 35),
	(8, 48),
	(8, 26),
	(8, 24),
	(8, 25),
	(8, 27),
	(8, 54),
	(2, 1),
	(2, 7),
	(2, 6),
	(2, 15),
	(2, 22),
	(2, 20),
	(2, 19),
	(2, 23),
	(2, 21),
	(2, 53),
	(2, 52),
	(2, 51);
/*!40000 ALTER TABLE `user_access_menu` ENABLE KEYS */;

-- Dumping structure for view app-air.view_pencatatan_sumur
DROP VIEW IF EXISTS `view_pencatatan_sumur`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_pencatatan_sumur` (
	`id_pencatatan` INT(255) UNSIGNED NOT NULL,
	`id_sumur` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`nama_sumur` VARCHAR(45) NULL COLLATE 'utf8_general_ci',
	`nama_pompa` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`nama_flowmeter` VARCHAR(45) NULL COLLATE 'utf8_general_ci',
	`id_flow` INT(255) UNSIGNED NULL,
	`waktu_perekaman` DATETIME NULL,
	`waktu_rekam_awal` DATETIME NULL,
	`cuaca_awal` VARCHAR(45) NULL COLLATE 'utf8_general_ci',
	`debit_air_awal` DOUBLE NULL,
	`flow_sumur_awal` DOUBLE NULL,
	`waktu_rekam_akhir` DATETIME NULL,
	`cuaca_akhir` VARCHAR(45) NULL COLLATE 'utf8_general_ci',
	`debit_air_akhir` DOUBLE NULL,
	`flow_sumur_akhir` DOUBLE NULL,
	`issued_by` VARCHAR(45) NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view app-air.vw_menu
DROP VIEW IF EXISTS `vw_menu`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_menu` (
	`id` INT(11) UNSIGNED NOT NULL,
	`parent_id` INT(11) UNSIGNED NOT NULL,
	`title` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`url` VARCHAR(45) NULL COLLATE 'latin1_swedish_ci',
	`second_uri` VARCHAR(45) NULL COLLATE 'latin1_swedish_ci',
	`parent_menu` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`is_active` INT(1) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view app-air.vw_sub_menu
DROP VIEW IF EXISTS `vw_sub_menu`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_sub_menu` (
	`id` INT(11) UNSIGNED NOT NULL,
	`parent_id` INT(11) UNSIGNED NOT NULL,
	`title` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view app-air.vw_transaksi_tandon
DROP VIEW IF EXISTS `vw_transaksi_tandon`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_transaksi_tandon` (
	`id_transaksi` INT(255) UNSIGNED NOT NULL,
	`nama_tandon` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`lokasi` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`waktu_perekaman` DATETIME NULL,
	`total_pengisian` FLOAT NULL,
	`status_pencatatan` INT(1) NULL,
	`issued_by` VARCHAR(150) NULL COLLATE 'latin1_swedish_ci',
	`issued_at` DATETIME NULL,
	`modified_by` VARCHAR(150) NULL COLLATE 'latin1_swedish_ci',
	`modified_at` DATETIME NULL,
	`soft_delete` INT(1) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view app-air.vw_user
DROP VIEW IF EXISTS `vw_user`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_user` (
	`id_user` INT(255) UNSIGNED NOT NULL,
	`username` VARCHAR(45) NOT NULL COLLATE 'utf8_general_ci',
	`first_name` VARCHAR(45) NULL COLLATE 'utf8_general_ci',
	`last_name` VARCHAR(45) NULL COLLATE 'utf8_general_ci',
	`email` VARCHAR(45) NULL COLLATE 'utf8_general_ci',
	`gender` VARCHAR(45) NULL COLLATE 'utf8_general_ci',
	`picture` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`password` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`role` INT(11) UNSIGNED NOT NULL,
	`is_active` INT(1) NULL,
	`nama_role` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`last_login` DATETIME NULL,
	`date_created` DATETIME NULL,
	`created_by` VARCHAR(45) NULL COLLATE 'utf8_general_ci',
	`last_modified` DATETIME NULL,
	`modified_by` VARCHAR(45) NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view app-air.vw_user_access_menu
DROP VIEW IF EXISTS `vw_user_access_menu`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_user_access_menu` (
	`id_role` INT(11) UNSIGNED NOT NULL,
	`role` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`nama_role` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`menu_id` INT(11) UNSIGNED NULL,
	`parent_id` INT(11) UNSIGNED NULL,
	`title` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`icon` VARCHAR(45) NULL COLLATE 'latin1_swedish_ci',
	`url` VARCHAR(45) NULL COLLATE 'latin1_swedish_ci',
	`second_uri` VARCHAR(45) NULL COLLATE 'latin1_swedish_ci',
	`is_active` INT(1) NULL
) ENGINE=MyISAM;

-- Dumping structure for view app-air.view_pencatatan_sumur
DROP VIEW IF EXISTS `view_pencatatan_sumur`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_pencatatan_sumur`;
CREATE ALGORITHM=UNDEFINED DEFINER=`fendy`@`%` SQL SECURITY DEFINER VIEW `view_pencatatan_sumur` AS select `pencatatan_sumur`.`id_pencatatan` AS `id_pencatatan`,`master_sumur`.`id_sumur` AS `id_sumur`,`master_sumur`.`nama_sumur` AS `nama_sumur`,`master_pompa`.`nama_pompa` AS `nama_pompa`,`master_flowmeter`.`nama_flowmeter` AS `nama_flowmeter`,`master_flowmeter`.`id_flow` AS `id_flow`,`pencatatan_sumur`.`waktu_perekaman` AS `waktu_perekaman`,`pencatatan_sumur`.`waktu_rekam_awal` AS `waktu_rekam_awal`,`pencatatan_sumur`.`cuaca_awal` AS `cuaca_awal`,`pencatatan_sumur`.`debit_air_awal` AS `debit_air_awal`,`pencatatan_sumur`.`flow_sumur_awal` AS `flow_sumur_awal`,`pencatatan_sumur`.`waktu_rekam_akhir` AS `waktu_rekam_akhir`,`pencatatan_sumur`.`cuaca_akhir` AS `cuaca_akhir`,`pencatatan_sumur`.`debit_air_akhir` AS `debit_air_akhir`,`pencatatan_sumur`.`flow_sumur_akhir` AS `flow_sumur_akhir`,`pencatatan_sumur`.`issued_by` AS `issued_by` from (((`pencatatan_sumur` left join `master_flowmeter` on((`pencatatan_sumur`.`id_ref_flowmeter` = `master_flowmeter`.`id_flow`))) left join `master_pompa` on((`master_flowmeter`.`id_ref_pompa` = `master_pompa`.`id_master_pompa`))) left join `master_sumur` on((`master_pompa`.`id_ref_sumur` = `master_sumur`.`id_master_sumur`))) where (`pencatatan_sumur`.`status_pencatatan` = '1');

-- Dumping structure for view app-air.vw_menu
DROP VIEW IF EXISTS `vw_menu`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_menu`;
CREATE ALGORITHM=UNDEFINED DEFINER=`fendy`@`%` SQL SECURITY DEFINER VIEW `vw_menu` AS select `tm`.`id` AS `id`,`tm`.`parent_id` AS `parent_id`,`tm`.`title` AS `title`,`tm`.`url` AS `url`,`tm`.`second_uri` AS `second_uri`,`tm2`.`title` AS `parent_menu`,`tm`.`is_active` AS `is_active` from (`table_menu` `tm` left join `vw_sub_menu` `tm2` on((`tm2`.`id` = `tm`.`parent_id`))) where (`tm`.`soft_delete` = '0');

-- Dumping structure for view app-air.vw_sub_menu
DROP VIEW IF EXISTS `vw_sub_menu`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_sub_menu`;
CREATE ALGORITHM=UNDEFINED DEFINER=`fendy`@`%` SQL SECURITY DEFINER VIEW `vw_sub_menu` AS select `table_menu`.`id` AS `id`,`table_menu`.`parent_id` AS `parent_id`,`table_menu`.`title` AS `title` from `table_menu`;

-- Dumping structure for view app-air.vw_transaksi_tandon
DROP VIEW IF EXISTS `vw_transaksi_tandon`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_transaksi_tandon`;
CREATE ALGORITHM=UNDEFINED DEFINER=`fendy`@`%` SQL SECURITY DEFINER VIEW `vw_transaksi_tandon` AS select `transaksi_tandon`.`id_transaksi` AS `id_transaksi`,`master_tandon`.`nama_tandon` AS `nama_tandon`,`master_tandon`.`lokasi` AS `lokasi`,`transaksi_tandon`.`waktu_perekaman` AS `waktu_perekaman`,`transaksi_tandon`.`total_pengisian` AS `total_pengisian`,`transaksi_tandon`.`status_pencatatan` AS `status_pencatatan`,`transaksi_tandon`.`issued_by` AS `issued_by`,`transaksi_tandon`.`issued_at` AS `issued_at`,`transaksi_tandon`.`modified_by` AS `modified_by`,`transaksi_tandon`.`modified_at` AS `modified_at`,`transaksi_tandon`.`soft_delete` AS `soft_delete` from (`transaksi_tandon` left join `master_tandon` on((`transaksi_tandon`.`id_ref_tandon` = `master_tandon`.`id`)));

-- Dumping structure for view app-air.vw_user
DROP VIEW IF EXISTS `vw_user`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`fendy`@`%` SQL SECURITY DEFINER VIEW `vw_user` AS select `users`.`id_user` AS `id_user`,`users`.`username` AS `username`,`users`.`first_name` AS `first_name`,`users`.`last_name` AS `last_name`,`users`.`email` AS `email`,`users`.`gender` AS `gender`,`users`.`picture` AS `picture`,`users`.`password` AS `password`,`users`.`role` AS `role`,`users`.`is_active` AS `is_active`,`role`.`role` AS `nama_role`,`users`.`last_login` AS `last_login`,`users`.`date_created` AS `date_created`,`users`.`created_by` AS `created_by`,`users`.`last_modified` AS `last_modified`,`users`.`modified_by` AS `modified_by` from (`users` join `role` on((`role`.`id_role` = `users`.`role`))) where (`users`.`soft_delete` = 0);

-- Dumping structure for view app-air.vw_user_access_menu
DROP VIEW IF EXISTS `vw_user_access_menu`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_user_access_menu`;
CREATE ALGORITHM=UNDEFINED DEFINER=`fendy`@`%` SQL SECURITY DEFINER VIEW `vw_user_access_menu` AS select `role`.`id_role` AS `id_role`,`role`.`role` AS `role`,`role`.`nama_role` AS `nama_role`,`table_menu`.`id` AS `menu_id`,`table_menu`.`parent_id` AS `parent_id`,`table_menu`.`title` AS `title`,`table_menu`.`icon` AS `icon`,`table_menu`.`url` AS `url`,`table_menu`.`second_uri` AS `second_uri`,`table_menu`.`is_active` AS `is_active` from ((`user_access_menu` left join `table_menu` on((`table_menu`.`id` = `user_access_menu`.`menu_id`))) join `role` on((`role`.`id_role` = `user_access_menu`.`role_id`))) where (`table_menu`.`soft_delete` = '0') order by `role`.`nama_role`,`table_menu`.`parent_id`;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
