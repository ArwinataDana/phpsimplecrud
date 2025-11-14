/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 8.0.30 : Database - db_simplecrud
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_simplecrud` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_simplecrud`;

/*Table structure for table `tb_device` */

DROP TABLE IF EXISTS `tb_device`;

CREATE TABLE `tb_device` (
  `id_device` int NOT NULL AUTO_INCREMENT,
  `nama_device` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_device`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tb_device` */

insert  into `tb_device`(`id_device`,`nama_device`) values 
(1,'AIO'),
(2,'POD'),
(3,'MOD'),
(4,'iqos');

/*Table structure for table `tb_mahasiswa` */

DROP TABLE IF EXISTS `tb_mahasiswa`;

CREATE TABLE `tb_mahasiswa` (
  `id_produk` int NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_brand` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `jenis_device` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_produk` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tb_mahasiswa` */

insert  into `tb_mahasiswa`(`id_produk`,`nama_produk`,`nama_brand`,`jenis_device`,`deskripsi`,`status_produk`) values 
(7,'Centaurus M200','CNT','3','Centaurus M200 adalah mod vape dari Lost Vape yang punya tampilan keren dan terasa kokoh di tangan. Menggunakan dua baterai 18650, mod ini bisa menghasilkan daya hingga 200 watt, jadi cocok buat yang suka asap tebal dan rasa maksimal. Dilengkapi layar berwarna dan tombol yang mudah digunakan oleh pengguna.',1),
(9,'Centaurus B80','CNT','1','Centaurus B80 AIO adalah device vape all-in-one (AIO) dari Lost Vape yang menawarkan performa tinggi dan desain premium dalam ukuran yang ringkas. Menggunakan chipset Quest 2.0 dengan daya hingga 80 watt, device ini mendukung berbagai mode vaping seperti wattage dan bypass.\r\nDitenagai oleh baterai 18650 tunggal (removable), Centaurus B80 AIO memiliki layar warna TFT, sistem airflow yang halus, serta fitur keamanan lengkap. Cocok untuk pengguna yang ingin vape powerful namun tetap praktis dan bergaya.',1),
(10,'Oxva Slim Pro','OXV','2','OXVA Xlim Pro adalah pod system modern yang dirancang untuk memberikan rasa nikmat dan performa stabil. Mengusung baterai 1000mAh dengan daya hingga 30 watt, device ini cocok untuk harian karena tahan lama dan cepat diisi lewat USB Type-C.\r\nDilengkapi layar kecil untuk pengaturan watt, tombol kontrol intuitif, dan pod anti-bocor yang mudah diganti. Desainnya ramping, elegan, dan nyaman digenggam — ideal untuk pengguna baru maupun vaper berpengalaman yang ingin device praktis tapi bertenaga.',1),
(11,'R234','THC','3','R234 adalah mod dual-battery berdaya tinggi yang menggabungkan desain klasik dengan performa kuat. Menggunakan dua baterai 18650, device ini mampu menghasilkan daya hingga 234 watt dengan output stabil dan respons cepat.\r\nDilengkapi tombol pengatur voltase manual, sistem proteksi keamanan lengkap, serta bodi kokoh berbahan metal, R234 cocok untuk vaper yang mencari mod handal, tahan lama, dan bertenaga besar.',1),
(12,'T99','TR','3','T99 adalah mod berdesain unik dan ergonomis yang menggabungkan tampilan elegan dengan performa tinggi. Menggunakan dua baterai 18650, device ini mampu menghasilkan daya besar hingga 230 watt, cocok untuk pengguna yang suka mengejar rasa dan cloud maksimal.\r\nDilengkapi dengan fitur proteksi keamanan lengkap, tombol responsif, serta bodi solid yang nyaman digenggam — menjadikan T99 pilihan ideal bagi pengguna yang ingin mod kuat, stylish, dan bertenaga.',1),
(13,'R99','THC','3','R99 adalah mod vape compact dan bertenaga yang dirancang untuk memberikan performa stabil dan rasa maksimal. Menggunakan dua baterai 18650, R99 mampu menghasilkan output hingga 230 watt dengan respons cepat.\r\nDesainnya ergonomis dan stylish, dilengkapi layar jelas serta fitur keamanan lengkap, membuatnya cocok untuk vaper yang menginginkan mod handal, kuat, dan nyaman digunakan setiap hari.',2),
(14,'R233','THC','3','R233 adalah mod dual-battery legendaris yang terkenal dengan daya besar dan build kokoh. Menggunakan dua baterai 18650, device ini mampu menghasilkan output hingga 233 watt dengan mode voltase manual yang memberi kontrol penuh pada pengguna.\r\nDesainnya sederhana tapi tangguh, dilengkapi chip proteksi keamanan, serta performa stabil untuk menghasilkan rasa dan uap maksimal. Cocok bagi vaper yang suka mod powerful dengan tampilan klasik.',1);

/*Table structure for table `tb_prodi` */

DROP TABLE IF EXISTS `tb_prodi`;

CREATE TABLE `tb_prodi` (
  `kode_brand` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_brand` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`kode_brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tb_prodi` */

insert  into `tb_prodi`(`kode_brand`,`jenis_brand`) values 
('CNT','Lost Vape'),
('DM','DotMod'),
('DVP','Dovpo'),
('IJY','Ijoy'),
('OXV','Oxva'),
('THC','Hotcig'),
('TR','Trml');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
