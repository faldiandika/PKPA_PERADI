-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: db_pkpa_peradi
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dokumen_peserta`
--

DROP TABLE IF EXISTS `dokumen_peserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dokumen_peserta` (
  `id_dokumen` int NOT NULL AUTO_INCREMENT,
  `id_pendaftaran` int NOT NULL,
  `jenis_dokumen` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_upload` datetime DEFAULT CURRENT_TIMESTAMP,
  `status_verifikasi` enum('menunggu','lengkap','revisi','ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu',
  `catatan` text COLLATE utf8mb4_general_ci,
  `verified_by` int DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dokumen`),
  KEY `fk_dokumen_pendaftaran` (`id_pendaftaran`),
  KEY `fk_dokumen_verifikator` (`verified_by`),
  CONSTRAINT `fk_dokumen_pendaftaran` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_dokumen_verifikator` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dokumen_peserta`
--

LOCK TABLES `dokumen_peserta` WRITE;
/*!40000 ALTER TABLE `dokumen_peserta` DISABLE KEYS */;
INSERT INTO `dokumen_peserta` VALUES (1,1,'Ijazah Sarjana Hukum','ijazah_ahmad.pdf','uploads/dokumen/ijazah_ahmad.pdf','2026-11-22 20:25:54','menunggu','Dokumen menunggu proses verifikasi.',NULL,NULL),(2,1,'KTP','ktp_ahmad.pdf','uploads/dokumen/ktp_ahmad.pdf','2026-11-22 20:25:54','menunggu','Dokumen menunggu proses verifikasi.',2,'2026-11-23 04:46:41'),(9,3,'Ijazah Sarjana Hukum','Hasil Audit Laporan Kelompok 1[Kelompok 8].pdf','uploads/dokumen/41145b06c4045209.pdf','2026-11-24 02:06:57','lengkap','',2,'2026-11-24 02:31:00'),(10,3,'KTP','Hasil Audit Laporan Kelompok 1[Kelompok 8].pdf','uploads/dokumen/ea6f6d2cd1b60ae3.pdf','2026-11-24 02:08:51','lengkap','',2,'2026-11-24 02:31:05'),(11,3,'Kartu Keluarga','Hasil Audit Laporan Kelompok 1[Kelompok 8].pdf','uploads/dokumen/b8690f24cc6263ee.pdf','2026-11-24 02:09:00','lengkap','',2,'2026-11-24 02:31:11'),(12,3,'Transkrip Nilai','P14_Kelompok_8_Laporan_Lanjutan.pdf','uploads/dokumen/f01db146d4def0a5.pdf','2026-11-24 02:09:08','lengkap','',2,'2026-11-24 02:31:17');
/*!40000 ALTER TABLE `dokumen_peserta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dokumen_sumpah`
--

DROP TABLE IF EXISTS `dokumen_sumpah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dokumen_sumpah` (
  `id_dokumen_sumpah` int NOT NULL AUTO_INCREMENT,
  `id_pengajuan_sumpah` int NOT NULL,
  `jenis_dokumen` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_upload` datetime DEFAULT CURRENT_TIMESTAMP,
  `status_verifikasi` enum('menunggu','lengkap','revisi','ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu',
  `catatan` text COLLATE utf8mb4_general_ci,
  `verified_by` int DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dokumen_sumpah`),
  KEY `fk_dokumen_sumpah_pengajuan` (`id_pengajuan_sumpah`),
  KEY `fk_dokumen_sumpah_verifikator` (`verified_by`),
  CONSTRAINT `fk_dokumen_sumpah_pengajuan` FOREIGN KEY (`id_pengajuan_sumpah`) REFERENCES `pengajuan_sumpah` (`id_pengajuan_sumpah`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_dokumen_sumpah_verifikator` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dokumen_sumpah`
--

LOCK TABLES `dokumen_sumpah` WRITE;
/*!40000 ALTER TABLE `dokumen_sumpah` DISABLE KEYS */;
INSERT INTO `dokumen_sumpah` VALUES (1,1,'KTP','ktp_sumpah_ahmad.pdf','uploads/dokumen_sumpah/ktp_sumpah_ahmad.pdf','2026-11-22 21:31:11','menunggu','Dokumen menunggu verifikasi.',NULL,NULL),(2,1,'KK','kk_ahmad.pdf','uploads/dokumen_sumpah/kk_ahmad.pdf','2026-11-22 21:31:11','menunggu','Dokumen menunggu verifikasi.',NULL,NULL),(3,1,'Sertifikat PKPA','sertifikat_pkpa_ahmad.pdf','uploads/dokumen_sumpah/sertifikat_pkpa_ahmad.pdf','2026-11-22 21:31:11','menunggu','Dokumen menunggu verifikasi.',NULL,NULL),(4,1,'Sertifikat UPA','sertifikat_upa_ahmad.pdf','uploads/dokumen_sumpah/sertifikat_upa_ahmad.pdf','2026-11-22 21:31:11','menunggu','Dokumen menunggu verifikasi.',NULL,NULL),(5,1,'Surat Keterangan Magang','surat_magang_ahmad.pdf','uploads/dokumen_sumpah/surat_magang_ahmad.pdf','2026-11-22 21:31:11','menunggu','Dokumen menunggu verifikasi.',NULL,NULL),(13,6,'KTP','Getting started with OneDrive.pdf','uploads/dokumen_sumpah/b615bd9c8cbccdef.pdf','2026-11-24 02:32:09','lengkap',NULL,NULL,'2026-11-24 02:33:24'),(14,6,'KK','Getting started with OneDrive.pdf','uploads/dokumen_sumpah/113c5ac0c7b2ca2e.pdf','2026-11-24 02:32:21','lengkap',NULL,NULL,'2026-11-24 02:33:20'),(15,6,'Sertifikat PKPA','Getting started with OneDrive.pdf','uploads/dokumen_sumpah/c44d426e90521245.pdf','2026-11-24 02:32:30','lengkap',NULL,NULL,'2026-11-24 02:33:13'),(16,6,'Sertifikat UPA','P14_Kelompok_8_Laporan_Lanjutan.pdf','uploads/dokumen_sumpah/dbde40d18cb36410.pdf','2026-11-24 02:32:37','lengkap',NULL,NULL,'2026-11-24 02:33:16'),(17,6,'Surat Keterangan Magang','P14_Kelompok_8_Laporan_Lanjutan.pdf','uploads/dokumen_sumpah/647b4ac7530cc6c5.pdf','2026-11-24 02:32:45','lengkap',NULL,NULL,'2026-11-24 02:33:11');
/*!40000 ALTER TABLE `dokumen_sumpah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jadwal_sumpah`
--

DROP TABLE IF EXISTS `jadwal_sumpah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jadwal_sumpah` (
  `id_jadwal_sumpah` int NOT NULL AUTO_INCREMENT,
  `id_pengajuan_sumpah` int NOT NULL,
  `tanggal_sumpah` date NOT NULL,
  `waktu_sumpah` time NOT NULL,
  `tempat_sumpah` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id_jadwal_sumpah`),
  KEY `fk_jadwal_sumpah_pengajuan` (`id_pengajuan_sumpah`),
  CONSTRAINT `fk_jadwal_sumpah_pengajuan` FOREIGN KEY (`id_pengajuan_sumpah`) REFERENCES `pengajuan_sumpah` (`id_pengajuan_sumpah`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal_sumpah`
--

LOCK TABLES `jadwal_sumpah` WRITE;
/*!40000 ALTER TABLE `jadwal_sumpah` DISABLE KEYS */;
INSERT INTO `jadwal_sumpah` VALUES (1,1,'2026-12-15','09:00:00','Pengadilan Tinggi Sulawesi Tengah','Jadwal sumpah berdasarkan informasi dari Pengadilan Tinggi.'),(2,6,'2026-11-24','03:38:00','Kantor','Silahkan datang ke tempat sesuai jadwal');
/*!40000 ALTER TABLE `jadwal_sumpah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL AUTO_INCREMENT,
  `id_pendaftaran` int NOT NULL,
  `tanggal_bayar` datetime DEFAULT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `metode_pembayaran` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_pembayaran` enum('menunggu','diverifikasi','ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu',
  `verified_by` int DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id_pembayaran`),
  KEY `fk_pembayaran_pendaftaran` (`id_pendaftaran`),
  KEY `fk_pembayaran_verifikator` (`verified_by`),
  CONSTRAINT `fk_pembayaran_pendaftaran` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pembayaran_verifikator` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran`
--

LOCK TABLES `pembayaran` WRITE;
/*!40000 ALTER TABLE `pembayaran` DISABLE KEYS */;
INSERT INTO `pembayaran` VALUES (1,1,'2026-11-22 10:00:00',250000.00,'Transfer Bank','bukti_bayar_ahmad.jpg','diverifikasi',3,'2026-11-23 04:37:40',''),(3,3,'2026-11-24 02:14:49',250000.00,'Transfer Bank','cb21ba95ac1dba76.jpeg','diverifikasi',3,'2026-11-24 02:16:26','');
/*!40000 ALTER TABLE `pembayaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pendaftaran`
--

DROP TABLE IF EXISTS `pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int NOT NULL AUTO_INCREMENT,
  `id_peserta` int NOT NULL,
  `tanggal_daftar` datetime DEFAULT CURRENT_TIMESTAMP,
  `periode` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_pendaftaran` enum('menunggu','diterima','revisi','ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu',
  `catatan` text COLLATE utf8mb4_general_ci,
  `verified_by` int DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pendaftaran`),
  UNIQUE KEY `uq_pendaftaran_peserta_periode` (`id_peserta`,`periode`),
  KEY `fk_pendaftaran_peserta` (`id_peserta`),
  KEY `fk_pendaftaran_verifikator` (`verified_by`),
  CONSTRAINT `fk_pendaftaran_peserta` FOREIGN KEY (`id_peserta`) REFERENCES `peserta` (`id_peserta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pendaftaran_verifikator` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendaftaran`
--

LOCK TABLES `pendaftaran` WRITE;
/*!40000 ALTER TABLE `pendaftaran` DISABLE KEYS */;
INSERT INTO `pendaftaran` VALUES (1,1,'2026-11-22 20:25:15','PKPA 2026','menunggu','Pendaftaran menunggu proses verifikasi admin.',NULL,NULL),(3,3,'2026-11-24 00:52:49','PKPA 2026','diterima','Silahkan lanjutkan pengisian dokumen sumpah',2,'2026-11-24 02:31:52');
/*!40000 ALTER TABLE `pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengajuan_sumpah`
--

DROP TABLE IF EXISTS `pengajuan_sumpah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengajuan_sumpah` (
  `id_pengajuan_sumpah` int NOT NULL AUTO_INCREMENT,
  `id_peserta` int NOT NULL,
  `tanggal_pengajuan` datetime DEFAULT CURRENT_TIMESTAMP,
  `status_pemberkasan` enum('menunggu','diperiksa','perbaikan','dikirim','diterima','ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu',
  `catatan` text COLLATE utf8mb4_general_ci,
  `verified_by` int DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan_sumpah`),
  KEY `fk_pengajuan_sumpah_peserta` (`id_peserta`),
  KEY `fk_pengajuan_sumpah_verifikator` (`verified_by`),
  CONSTRAINT `fk_pengajuan_sumpah_peserta` FOREIGN KEY (`id_peserta`) REFERENCES `peserta` (`id_peserta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pengajuan_sumpah_verifikator` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengajuan_sumpah`
--

LOCK TABLES `pengajuan_sumpah` WRITE;
/*!40000 ALTER TABLE `pengajuan_sumpah` DISABLE KEYS */;
INSERT INTO `pengajuan_sumpah` VALUES (1,1,'2026-11-22 21:30:49','menunggu','Pengajuan sumpah menunggu pemeriksaan berkas oleh admin.',NULL,NULL),(6,3,'2026-11-24 02:31:59','diterima','',NULL,NULL);
/*!40000 ALTER TABLE `pengajuan_sumpah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peserta`
--

DROP TABLE IF EXISTS `peserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peserta` (
  `id_peserta` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `nama_lengkap` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `no_telepon` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `perguruan_tinggi` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_ijazah` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pas_foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_peserta`),
  UNIQUE KEY `uq_peserta_user` (`id_user`),
  UNIQUE KEY `uq_peserta_nik` (`nik`),
  CONSTRAINT `fk_peserta_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peserta`
--

LOCK TABLES `peserta` WRITE;
/*!40000 ALTER TABLE `peserta` DISABLE KEYS */;
INSERT INTO `peserta` VALUES (1,1,'Ahmad Fauzan','7271011505980001','Palu','1998-05-15','Jl. Tanjung Dako, Kota Palu','081234567890','peserta@gmail.com','Universitas Tadulako','IJZ-UNTAD-2019-001','ahmad_fauzan.jpg','2026-11-22 20:24:46'),(3,6,'Rusfaldi Andika','1234567890123456','Uekuli','2006-12-09','Jln Kayu Filo, Kec. Mantikulore, Prov. Sulawesi Tengah','082197472906','andika@gmail.com','Universitas Tadulako','16092006','b71fd60162d084b5.png','2026-11-24 00:51:05');
/*!40000 ALTER TABLE `peserta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('peserta','admin','bendahara','ketua') COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aktif',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ahmad Fauzan','peserta@gmail.com','$2y$10$31v54zpmTdTheDarYGukweOWdGpDisXt/Cv6ZbXjMrRBpUO0ZnfQ2','peserta','aktif','2026-11-22 20:24:03'),(2,'Admin PKPA','admin@pkpa.com','$2y$10$78uZ64YRvRSem9Usze8/rOB3WS/cdjCoHvGT4RCYYI/0PEslCOlZ6','admin','aktif','2026-11-22 20:24:03'),(3,'Bendahara DPC','bendahara@pkpa.com','$2y$10$RQN.H2PpwU8FsAgpnHofL.3CdevLgIqjfNyyscYMWHWsx1oa80/rC','bendahara','aktif','2026-11-22 20:24:03'),(4,'Ketua DPC','ketua@pkpa.com','$2y$10$KAP.q7/wUlP2zH8K1eaHAeP4Vj.Msw6b.bYb2OINWwAdn.bzKMvES','ketua','aktif','2026-11-22 20:24:03'),(6,'andika','andika@gmail.com','$2y$10$KqXIiVUfuT6rQ.5NYggx9OYdkpXQUYzINf9EcQyjMvYS89QZQQDNC','peserta','aktif','2026-11-24 00:46:40');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-24  3:47:55
