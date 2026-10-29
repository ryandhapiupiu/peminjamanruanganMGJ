-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: db_pinjamkelas
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
-- Table structure for table `tb_peminjaman`
--

DROP TABLE IF EXISTS `tb_peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_peminjaman` (
  `id_peminjaman` varchar(10) NOT NULL,
  `peminjam` varchar(25) NOT NULL,
  `ruangan_dipinjam` varchar(50) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `waktu_pengajuan` datetime NOT NULL,
  `waktu_penyetujuan` datetime DEFAULT NULL,
  `waktu_pembatalan` datetime DEFAULT NULL,
  `waktu_pengembalian` datetime DEFAULT NULL,
  `verifikasi_bp` varchar(5) NOT NULL,
  `verifikasi_kabag` varchar(5) NOT NULL,
  `status_pinjam` varchar(15) NOT NULL,
  `tanggal_meeting` date DEFAULT NULL,
  `jam_meeting` time DEFAULT NULL,
  `nama_peminjam` varchar(50) DEFAULT NULL,
  `departemen_peminjam` varchar(50) DEFAULT NULL,
  `telepon_peminjam` varchar(20) DEFAULT NULL,
  `waktu_checkin` datetime DEFAULT NULL,
  PRIMARY KEY (`id_peminjaman`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_peminjaman`
--

LOCK TABLES `tb_peminjaman` WRITE;
/*!40000 ALTER TABLE `tb_peminjaman` DISABLE KEYS */;
INSERT INTO `tb_peminjaman` VALUES ('DPK-00016','Ryan','Pulau Bali','itd','2026-10-26 15:54:10','2026-10-26 15:54:53','0000-00-00 00:00:00','2026-10-27 10:57:22','-','-','Selesai','2026-10-28','14:00:00',NULL,NULL,NULL,NULL),('DPK-00020','nawwal fadhil ','Pulau Jawa','Meeting Uji Coba Check-In Langsung','2026-10-27 09:28:45','2026-10-27 09:28:45','2026-10-27 09:31:46','2026-10-27 10:11:28','OK','OK','Selesai','2026-10-27','09:40:00','Nawwal Fadhil','Marketing','08123456789','2026-10-27 09:43:20'),('DPK-00021','nawwal fadhil ','Board Room','Meeting Uji Auto Run Live [Auto-Cancel: Tidak Check-In >10 menit]','2026-10-27 09:33:33',NULL,'2026-10-27 09:55:10',NULL,'-','-','Dibatalkan','2026-10-27','09:00:00','Nawwal Fadhil','test 2','081234567890',NULL),('DPK-00050','Orang Pertama','Conference','Meeting Evaluasi Bulanan [Auto-Cancel: Tidak Check-In >10 menit]','2026-10-27 09:49:16','2026-10-27 09:49:16','2026-10-27 09:51:19',NULL,'OK','OK','Dibatalkan','2026-10-27','09:00:00','Peminjam A','Finance','0811111111',NULL),('DPK-00051','Ryan','Pulau Jawa','test 3.1 [Auto-Cancel: Tidak Check-In >10 menit]','2026-10-27 09:58:15','2026-10-27 10:00:46','2026-10-27 10:10:04',NULL,'OK','OK','Dibatalkan','2026-10-27','10:00:00','Ryan','test 3','123123123',NULL),('DPK-00088','nawal','Townhall','Presentasi Produk Medis Baru [Auto-Cancel: Tidak Check-In >10 menit]','2026-10-27 10:56:33','2026-10-27 11:02:46','2026-10-27 15:10:00',NULL,'OK','OK','Dibatalkan','2026-10-27','14:00:00','Nawwal Fadhil','Marketing','08123456789',NULL),('DPK-00089','nawwal fadhil ','Pulau Kalimantan','meeting testing [Auto-Cancel: Tidak Check-In >10 menit]','2026-10-27 11:04:58','2026-10-27 11:06:14','2026-10-27 15:10:00',NULL,'OK','OK','Dibatalkan','2026-10-27','14:00:00','nawwal fadhil','test 4','123123123131',NULL),('DPK-00090','nawwal fadhil ','Pulau Jawa','acacac','2026-10-27 13:03:34','2026-10-27 13:04:12',NULL,NULL,'OK','OK','Disetujui','2026-10-27','16:00:00','nawwal fadhil','ajdajd','123123123',NULL);
/*!40000 ALTER TABLE `tb_peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_ruangan`
--

DROP TABLE IF EXISTS `tb_ruangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_ruangan` (
  `id_ruangan` varchar(10) NOT NULL,
  `nama_ruangan` varchar(50) NOT NULL,
  `status` varchar(16) NOT NULL,
  `kapasitas` int unsigned NOT NULL DEFAULT '10',
  `room_qr_key` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_ruangan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_ruangan`
--

LOCK TABLES `tb_ruangan` WRITE;
/*!40000 ALTER TABLE `tb_ruangan` DISABLE KEYS */;
INSERT INTO `tb_ruangan` VALUES ('R001','Pulau Jawa','Tersedia',5,'425df689b3da49a46d8cca03ea61d525'),('R002','Pulau Bali','Tersedia',6,'ac21c50087cad0659cb183baff9aa63e'),('R003','Pulau Papua','Tersedia',20,'e508f4e4b5ae301725c43aa005070b3b'),('R004','Pulau Sumatra','Tersedia',30,'df39d8e0a2144bc7c7b111093bac81fa'),('R005','Pulau Kalimantan','Tersedia',7,'d97cbc1e96b14db386d7d205b813a62f');
/*!40000 ALTER TABLE `tb_ruangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tap`
--

DROP TABLE IF EXISTS `tb_tap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_tap` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kartu` varchar(20) NOT NULL,
  `nama_ruangan` varchar(50) NOT NULL,
  `waktu_akses` datetime NOT NULL,
  `waktu_tutup` datetime NOT NULL,
  `status_akses` varchar(10) NOT NULL DEFAULT 'Dibuka',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tap`
--

LOCK TABLES `tb_tap` WRITE;
/*!40000 ALTER TABLE `tb_tap` DISABLE KEYS */;
INSERT INTO `tb_tap` VALUES (9,'RFID-16950119','Focus Room','2019-02-27 01:26:01','2019-02-27 01:26:14','Ditutup'),(10,'RFID-16950119','Focus Room','2019-02-27 01:26:32','2019-02-27 01:26:48','Ditutup'),(11,'RFID-16950119','Focus Room','2019-02-27 01:27:51','2019-02-27 01:28:03','Ditutup'),(12,'RFID-16950119','Focus Room','2019-02-27 09:52:05','2019-02-27 09:52:34','Ditutup'),(13,'RFID-16950119','Focus Room','2019-02-27 10:12:08','2019-02-27 10:12:16','Ditutup'),(14,'RFID-16950119','Focus Room','2019-02-27 10:14:15','2019-02-27 10:14:31','Ditutup'),(15,'RFID-16950119','Focus Room','2019-02-27 10:17:39','2019-02-27 10:18:10','Ditutup'),(19,'RFID-16950119','Focus Room','2019-02-28 08:58:39','2019-02-28 08:59:02','Ditutup'),(20,'RFID-16950119','Focus Room','2019-03-01 07:39:50','2019-03-01 07:40:43','Ditutup'),(21,'RFID-16950119','Focus Room','2019-03-01 07:52:38','2019-03-01 07:57:25','Ditutup'),(22,'RFID-16950119','Focus Room','2019-03-01 07:56:03','2019-03-01 07:57:25','Ditutup'),(23,'RFID-16950119','Focus Room','2019-03-01 07:57:17','2019-03-01 07:57:25','Ditutup'),(24,'RFID-16950119','Focus Room','2019-03-01 08:02:52','2019-03-01 08:03:07','Ditutup'),(25,'RFID-16950119','Focus Room','2019-03-01 08:06:27','2019-03-01 08:07:25','Ditutup'),(26,'RFID-16950119','Focus Room','2019-03-11 20:07:01','2019-03-11 20:07:29','Ditutup'),(27,'RFID-16950119','Focus Room','2019-03-11 20:16:23','2019-03-11 20:17:04','Ditutup'),(30,'RFID-16950119','Focus Room','2019-03-12 06:25:45','2019-03-12 06:33:22','Ditutup'),(31,'RFID-16950119','Focus Room','2019-03-12 06:32:18','2019-03-12 06:33:22','Ditutup'),(32,'RFID-16950119','Focus Room','2019-03-12 06:36:38','2019-03-12 06:37:15','Ditutup'),(33,'RFID-16950119','Focus Room','2019-03-12 06:38:54','2019-03-12 06:40:12','Ditutup'),(34,'RFID-16950119','Focus Room','2019-03-12 06:45:47','2019-03-12 06:46:33','Ditutup'),(35,'RFID-16950119','Focus Room','2019-03-15 21:37:16','2019-03-15 21:42:09','Ditutup'),(36,'RFID-16950119','Focus Room','2019-03-22 08:53:51','2019-03-22 08:54:30','Ditutup'),(37,'RFID-16950119','Focus Room','2019-03-22 09:04:10','2019-03-22 09:04:34','Ditutup'),(38,'RFID-16950119','Focus Room','2019-03-22 10:17:49','2019-03-22 10:24:22','Ditutup'),(39,'RFID-16950119','Focus Room','2019-03-22 10:24:13','2019-03-22 10:24:22','Ditutup'),(40,'RFID-16950119','Focus Room','2019-06-17 11:28:36','2019-06-17 11:31:42','Ditutup'),(41,'RFID-16950119','Focus Room','2019-06-17 11:31:34','2019-06-17 11:31:42','Ditutup'),(42,'RFID-16950119','Focus Room','2019-06-17 15:06:27','2019-06-17 15:06:58','Ditutup'),(43,'RFID-16950119','Focus Room','2019-06-19 09:55:46','2019-06-19 09:55:53','Ditutup'),(44,'RFID-16950119','Focus Room','2019-06-19 13:17:33','2019-06-19 13:17:56','Ditutup'),(45,'CHECKIN-nawwal fad','Pulau Jawa','2026-10-27 09:43:20','0000-00-00 00:00:00','Dibuka'),(46,'CHECKIN-nawwal fad','Board Room','2026-10-27 09:45:40','0000-00-00 00:00:00','Dibuka');
/*!40000 ALTER TABLE `tb_tap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_user`
--

DROP TABLE IF EXISTS `tb_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_user` (
  `username` varchar(30) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(20) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_user`
--

LOCK TABLES `tb_user` WRITE;
/*!40000 ALTER TABLE `tb_user` DISABLE KEYS */;
INSERT INTO `tb_user` VALUES ('nawal','nawwal fadhil ','$2y$10$Rzn1gkMhhpBjS4n7Tbccruye0TkrigeXFrb74CZL2h58/MHqcUxOa','Pengguna'),('operator','Operator Resepsionis','$2y$10$Rzn1gkMhhpBjS4n7Tbccruye0TkrigeXFrb74CZL2h58/MHqcUxOa','Resepsionis'),('resepsionis','Resepsionis Medquest','$2y$10$Rzn1gkMhhpBjS4n7Tbccruye0TkrigeXFrb74CZL2h58/MHqcUxOa','Resepsionis'),('ryan','Ryan','$2y$10$Rzn1gkMhhpBjS4n7Tbccruye0TkrigeXFrb74CZL2h58/MHqcUxOa','Admin');
/*!40000 ALTER TABLE `tb_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-29 10:18:54
