-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for masterdata
CREATE DATABASE IF NOT EXISTS `masterdata` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `masterdata`;

-- Dumping structure for table masterdata.tbl_barang_keluar
CREATE TABLE IF NOT EXISTS `tbl_barang_keluar` (
  `id_bk` int(11) NOT NULL AUTO_INCREMENT,
  `id_sj_bk` varchar(50) DEFAULT NULL,
  `id_transaksi` varchar(50) DEFAULT NULL,
  `kd_barcode_bk` varchar(150) DEFAULT NULL,
  `qty_bk` int(11) DEFAULT NULL,
  `created_bk` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_bk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.tbl_barang_masuk
CREATE TABLE IF NOT EXISTS `tbl_barang_masuk` (
  `id_bm` int(11) NOT NULL AUTO_INCREMENT,
  `id_sj` varchar(50) DEFAULT NULL,
  `kd_barcode_bm` varchar(150) DEFAULT NULL,
  `qty_bm` int(11) DEFAULT NULL,
  `created_bm` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_bm`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.tbl_po
CREATE TABLE IF NOT EXISTS `tbl_po` (
  `id_po` int(11) NOT NULL AUTO_INCREMENT,
  `no_po` varchar(50) DEFAULT NULL,
  `job_ref` varchar(150) DEFAULT NULL,
  `date_delivery` date DEFAULT NULL,
  `recipient` varchar(150) DEFAULT NULL,
  `nama_item` varchar(150) DEFAULT NULL,
  `qty` varchar(150) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_po`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.tbl_saldo_awal
CREATE TABLE IF NOT EXISTS `tbl_saldo_awal` (
  `id_awal` int(11) NOT NULL AUTO_INCREMENT,
  `kd_barcode` varchar(150) DEFAULT NULL,
  `nama_item` varchar(150) DEFAULT NULL,
  `jenis_item` varchar(150) DEFAULT NULL,
  `merk_item` varchar(150) DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `stok_item` int(11) DEFAULT NULL,
  `koleksi` varchar(150) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_awal`)
) ENGINE=InnoDB AUTO_INCREMENT=2274 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_bm
CREATE TABLE IF NOT EXISTS `t_bm` (
  `id_bm` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `merk` int(11) DEFAULT NULL,
  `supplier` int(11) DEFAULT NULL,
  `no_sj` varchar(50) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_bm`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_customer
CREATE TABLE IF NOT EXISTS `t_customer` (
  `id_customer` int(11) NOT NULL AUTO_INCREMENT,
  `name_customer` varchar(50) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_detail_bk
CREATE TABLE IF NOT EXISTS `t_detail_bk` (
  `id_d_bk` int(11) NOT NULL AUTO_INCREMENT,
  `id_bk` int(11) NOT NULL DEFAULT '0',
  `nama_item` varchar(150) NOT NULL DEFAULT '0',
  `qty` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_d_bk`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_detail_bm
CREATE TABLE IF NOT EXISTS `t_detail_bm` (
  `id_d_bm` int(11) NOT NULL AUTO_INCREMENT,
  `id_bm` int(11) DEFAULT NULL,
  `nama_item` varchar(150) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_d_bm`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_item
CREATE TABLE IF NOT EXISTS `t_item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` varchar(100) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `id_jenis` int(11) DEFAULT NULL,
  `id_merk` int(11) DEFAULT NULL,
  `hpp` int(11) DEFAULT NULL,
  `fob` int(11) DEFAULT NULL,
  `id_koleksi` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT '0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id_item`),
  UNIQUE KEY `barcode` (`barcode`)
) ENGINE=InnoDB AUTO_INCREMENT=2282 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_jenis
CREATE TABLE IF NOT EXISTS `t_jenis` (
  `id_jenis` int(11) NOT NULL AUTO_INCREMENT,
  `name_jenis` varchar(150) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_jobref
CREATE TABLE IF NOT EXISTS `t_jobref` (
  `id_jobref` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jobref` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_jobref`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_koleksi
CREATE TABLE IF NOT EXISTS `t_koleksi` (
  `id_koleksi` int(11) NOT NULL AUTO_INCREMENT,
  `name_koleksi` varchar(150) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `id_merk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_koleksi`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_merk
CREATE TABLE IF NOT EXISTS `t_merk` (
  `id_merk` int(11) NOT NULL AUTO_INCREMENT,
  `name_merk` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id_merk`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_stockout
CREATE TABLE IF NOT EXISTS `t_stockout` (
  `id_stockout` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `date_delivery` date DEFAULT NULL,
  `id_merk` int(11) NOT NULL DEFAULT '0',
  `id_customer` int(11) NOT NULL DEFAULT '0',
  `id_jobref` int(11) NOT NULL DEFAULT '0',
  `diskon` int(11) NOT NULL DEFAULT '0',
  `total` int(11) NOT NULL DEFAULT '0',
  `ongkir` int(11) NOT NULL DEFAULT '0',
  `ket` varchar(150) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id_stockout`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_supplier
CREATE TABLE IF NOT EXISTS `t_supplier` (
  `id_supplier` int(11) NOT NULL AUTO_INCREMENT,
  `name_supplier` varchar(150) NOT NULL,
  `address` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table masterdata.t_user
CREATE TABLE IF NOT EXISTS `t_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `level` int(1) NOT NULL COMMENT '1:admin, 2:kasir',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
