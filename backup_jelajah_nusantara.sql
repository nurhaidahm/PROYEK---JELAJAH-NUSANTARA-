-- MySQL dump 10.13  Distrib 8.0.42, for Linux (x86_64)
--
-- Host: localhost    Database: jelajah_nusantara
-- ------------------------------------------------------
-- Server version	8.0.42-0ubuntu0.20.04.1

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
-- Table structure for table `ulasan`
--

DROP TABLE IF EXISTS `ulasan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ulasan` (
  `id_ulasan` int NOT NULL,
  `id_wisata` int NOT NULL,
  `nama_user` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `komentar_ulasan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rating` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ulasan`
--

LOCK TABLES `ulasan` WRITE;
/*!40000 ALTER TABLE `ulasan` DISABLE KEYS */;
/*!40000 ALTER TABLE `ulasan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `role_users` enum('admin','user') COLLATE utf8mb4_general_ci DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$jXzIg8mP9E.Df9v78Cv/Sew.b/QOkng4.q5DyS5f.mYfgwnxJOYUO','admin','user'),(2,'yunisa1','$2y$10$dpFBt5j4IbPJiBiUkXfIAee3Ow602.dqJDvjyS.PJYF1qtSHtZo7K','user','user'),(4,'syabila','$2y$10$b7dF9IaHcdurYSRjvsXbbumxGrFPxqfX7n6UeulMyNHC/4rpT/tui','user','user'),(8,'yunisa','$2y$10$RZQ4uJHV2/R5rZ/z.RolM.ihKlwkPKfRbMUraNpZ8EHLk..oGcyTq','user','user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wisata`
--

DROP TABLE IF EXISTS `wisata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wisata` (
  `id_wisata` int NOT NULL,
  `nama_wisata` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lokasi_wisata` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gambar_wisata` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi_wisata` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wisata`
--

LOCK TABLES `wisata` WRITE;
/*!40000 ALTER TABLE `wisata` DISABLE KEYS */;
INSERT INTO `wisata` VALUES (11111,'Candi Borobudur','Jalan Badrawati, Kecamatan Borobudur, Kabupaten Magelang, Provinsi Jawa Tengah.','borobudur.jpeg','Candi Borobudur adalah sebuah candi Buddha yang terletak di Borobudur, Magelang, Jawa Tengah, Indonesia. Candi ini dibangun pada sekitar abad ke-8 Masehi dan memiliki ketinggian 42 meter. Selain menjadi simbol spiritual bagi umat Buddha, Candi Borobudur juga merupakan warisan budaya yang penting bagi seluruh dunia.'),(22222,'Candi Prambanan','Jl. Raya Solo – Yogyakarta No.16, Kranggan, Bokoharjo, Prambanan, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55571.','prambanan.jpg','Candi Prambanan adalah kompleks candi Hindu terbesar di Indonesia. Candi ini dibangun pada masa pemerintahan Rakai Pikatan dari Kerajaan Mataram Kuno. Bangunan candi ini dipersembahkan untuk Trimurti atau tiga dewa utama Hindu, yaitu Brahma, Wisnu, dan Siwa. Gaya arsitektur dan ragam hias di kompleks candi ini dibuat dengan sangat indah, sehingga dapat menarik minat wisatawan untuk berkunjung. '),(33333,'Labuan Bajo','Jl. Soekarno-Hatta, No.35 Labuan Bajo. Desa/Kelurahan, : LABUAN BAJO. Kecamatan/Kota (LN), : KEC. KOMODO. Kab.-Kota/Negara (LN), : KAB. MANGGARAI.','labuanbajo..jpg','Labuan Bajo adalah kota nelayan yang terletak di ujung barat pulau besar Flores di provinsi Nusa Tenggara Timur, Indonesia. Letaknya di Kabupaten Komodo. Merupakan ibu kota Kabupaten Manggarai Barat, salah satu dari delapan kabupaten di Flores.'),(44444,'Banda Neira','Kecamatan Banda, Kabupaten Maluku Tengah, Maluku, Indonesia.','banda_neira2.jpg','Banda Neira adalah sebuah pulau di Kepulauan Banda, Maluku Tengah, Indonesia, yang terkenal karena keindahan alamnya, sejarahnya, dan kekayaan bawah lautnya. Pulau ini dulunya merupakan pusat perdagangan pala dan fuli, dan kini menjadi destinasi wisata yang populer.'),(55555,'Pantai Pangandaran','Desa Pangandaran dan Pananjung,Kecamatan Pangandaran, Kabupaten Pangandaran, Provinsi Jawa Barat.','pantai_pangandaran.jpeg','Pantai Pangandaran merupakan pantai yang menghadap ke Samudra Hindia. Pasir putih dan pasir hitam, disertai dengan kondisi alamnya yang masih indah dan alami, ditambah lingkungannya yang bersih dan berombang tenang serta pemandangan matahari terbenam yang spektakuler.'),(66666,'Gunung Tangkuban Perahu','di Jl. Raya Subang, Desa Cicadas, Kec. Sagalaherang, Kabupaten Subang, Jawa Barat.','Gunung_Tangkuban_Perahu.jpeg','Gunung Tangkuban Parahu) adalah salah satu gunung yang terletak di antara Kabupaten Subang dan Kabupaten Bandung Barat dengan rimbun pohon pinus dan hamparan kebun teh di sekitarnya, Gunung Tangkuban Parahu mempunyai ketinggian setinggi 2.086 meter. Berbentuk Stratovolcano dengan pusat erupsi yang berpindah dari timur ke barat. '),(777777,'Pantai Santolo','Kecamatan Cikelet, Kabupaten Garut, Jawa Barat, Indonesia. ','pantai_santolo.jpeg','Panorama pantai dan biota laut,merupakan aktivitas wisata yang dapat dilakukan. Tersedia juga sewaan perahu yang melayani wisatawan untuk menikmati deburan pantai ombak selatan yang cukup menantang. Selain itu kita bisa menikmati hidangan makanan laut yang segar dengan sajian yang sederhana. fasilitas yang dibutuhkan wisatawan cukup tersedia seperti losmen, kios-kios cenderamata dengan harga terjangkau.'),(888888,'Kawah Putih','Desa Alam Endah, Kecamatan Rancabali, Kabupaten Bandung, Jawa Barat','6a12ebbf2fa19.jpg','Kawah putih merupakan sebuah danau yang terbentuk dari letusan Gunung Patuha. Tanah yang bercampur belerang di sekitar kawah ini berwarna putih, lalu warna air yang berada di kawah ini berwarna putih kehijauan, yang unik dari kawah ini adalah airnya kadang berubah warna.'),(99999,'Kebun Raya Cibodas','di Kompleks Hutan Gunung Gede dan Gunung Pangrango, Desa Cimacan, Cipanas, Cianjur, Jawa Barat.','Kebun_Raya_Cibodas.jpeg','Kebun Raya Cibodas merupakan tempat yang nyaman untuk beristirahat sambil menikmati keindahan berbagai jenis tumbuhan yang berasal dari Indonesia dan negara-negara lain.'),(10101,'Gunung Galunggung','Tasikmalaya, Kabupaten Tasikmalaya, Jawa Barat, Indonesiaa','6a12e9884144f.jpg','Gunung Galunggung adalah gunung berapi aktif di Jawa Barat, Indonesia, dengan ketinggian 2.167 meter di atas permukaan laut. Gunung ini memiliki kawah yang dapat diakses dengan menaiki 620 anak tangga kuning. Selain kawah, Gunung Galunggung juga dikenal dengan pemandian air panas dan area camping yang tersedia. '),(12121,'Telaga Biru Cicerem','Jl. Kaduela, Kaduela, Kec. Pasawahan, Kabupaten Kuningan, Jawa Barat ','Telaga_Biru_Cicerem.jpeg','Telaga Biru Cicerem terkenal sebagai destinasi yang sejuk dan cocok untuk menenangkan pikiran. Pepohonan rindang dan jernihnya air telaga membuat biota air didalamnya terlihat begitu jelas.'),(14141,'Gunung Bromo','Area Gn. Bromo, Podokoyo, Kec. Tosari, Pasuruan, Jawa Timur','Gunung_Bromo.jpeg','Gunung Bromo atau dalam bahasa Tengger dieja \"Brama\", juga disebut Kaldera Tengger, adalah sebuah gunung berapi aktif di Jawa Timur, Indonesia. Gunung ini memiliki ketinggian 2.614 meter di atas permukaan laut dan berada dalam empat wilayah kabupaten, yakni Kabupaten Probolinggo, Kabupaten Pasuruan, Kabupaten Lumajang, dan Kabupaten Malang.'),(15151,'Raja Ampat','Desa Pam, Distrik Waigeo Barat Kepulauan, Kabupaten Raja Ampat, Provinsi Papua Barat Daya, Indonesia','Raja_Ampat.jpeg','Raja Ampat dikenali dengan keindahan laut dan pemandangannya. Pulau ini diakui sebagai rumah bagi keanekaragaman hayati terumbu karang terbesar di dunia. Dengan lebih dari 550 varietas karang yang berbeda, 700 jenis moluska, dan 1.427 spesies ikan yang berbeda, wilayah ini merupakan pusat keanekaragaman hayati laut yang signifikan.'),(17171,'Danau Toba','Danau Toba, Kabupaten Samosir, Kabupaten Toba, Kabupaten Humbang Hasundutan, Kabupaten Tapanuli Utara, ','Danau_Toba.jpeg','Danau Toba adalah danau alami berukuran besar di Sumatera Utara, Indonesia yang terletak di kaldera gunung supervulkan. Danau ini memiliki panjang 100 kilometer (62 mil), lebar 30 kilometer (19 mi), dan kedalaman 508 meter (1.667 ft). Danau ini terletak di tengah pulau Sumatra bagian utara dengan ketinggian permukaan sekitar 900 meter (2.953 ft). '),(18181,'Ranu Kumbolo','Desa Ranu Pani, Kecamatan Senduro, Kabupaten Lumajang, Provinsi Jawa Timur, Indonesia.','Ranu_Kumbolo.jpeg','Ranu Kumbolo (bahasa Indonesia: Danau Kumbolo) adalah sebuah danau yang terletak di dalam Taman Nasional Bromo Tengger Semeru, Jawa Timur, Indonesia. Danau ini merupakan bagian dari rute termudah yang berasal dari Ranu Pani menuju puncak Gunung Semeru.'),(19191,'Kawah Ijen','Desa Tamansari, Kecamatan Licin, Kabupaten Banyuwangi, Jawa Timur 68454, Indonesia','Kawah_Ijen.jpeg','Gunung Ijen adalah sebuah gunung berapi yang terletak di perbatasan Kabupaten Banyuwangi dan Kabupaten Bondowoso, Jawa Timur, Indonesia. Gunung ini memiliki ketinggian 2.386 mdpl. Gunung Ijen terakhir meletus pada tahun 1999. Salah satu fenomena alam yang paling terkenal dari Gunung Ijen adalah blue fire (api biru) di dalam kawah yang terletak di puncak gunung tersebut. '),(21212,'Taman Nasional Komodo','Jalan Kasimo, Labuan Bajo, Kabupaten Manggarai Barat, Nusa Tenggara Timur 86754, Indonesia .','Taman_Nasional_Komodo.jpeg','Pada tahun 1980, taman nasional ini didirikan untuk melindungi komodo dan habitatnya. Di taman nasional ini terdapat 277 spesies hewan yang merupakan perpaduan hewan yang berasal dari Asia dan Australia, yang terdiri dari 32 spesies mamalia, 128 spesies burung, dan 37 spesies reptilia. Bersama dengan komodo, setidaknya 25 spesies hewan darat dan burung termasuk hewan yang dilindungi, karena jumlahnya yang terbatas atau terbatasnya penyebaran mereka.'),(31313,'Taman Nasional Lorentz','Jl. SD Percobaan Potikelek, Kotak Pos 176\r\nWamena 99511, Kabupaten Jayawijaya, Provinsi Papua','Taman_Nasional_Lorentz.jpeg','Lorentz merupakan taman nasional terbesar di Asia Tenggara. Taman ini masih belum dipetakan, dijelajahi dan banyak terdapat tanaman asli, hewan dan budaya. Wilayahnya juga terdapat persediaan mineral, dan operasi pertambangan berskala besar juga aktif di sekitar taman nasional ini. Ada juga Proyek Konservasi Taman Nasional Lorentz yang terdiri dari sebuah inisiatif masyarakat untuk konservasi komunal dan ekologi warisan yang berada di sekitar Taman Nasional Loretz ini.');
/*!40000 ALTER TABLE `wisata` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-22 13:33:32
