-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5332
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for master
CREATE DATABASE IF NOT EXISTS `master` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `master`;

-- Dumping structure for table master.t_sales
CREATE TABLE IF NOT EXISTS `t_sales` (
  `id_sales` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` varchar(100) NOT NULL DEFAULT '0',
  `id_customer` int(11) NOT NULL DEFAULT '0',
  `total_price` int(11) NOT NULL DEFAULT '0',
  `discount` int(11) NOT NULL DEFAULT '0',
  `final_price` int(11) NOT NULL DEFAULT '0',
  `cash` int(11) NOT NULL DEFAULT '0',
  `remaining` int(11) NOT NULL DEFAULT '0',
  `note` text NOT NULL,
  `date` date DEFAULT NULL,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `sales_created` timestamp NOT NULL,
  PRIMARY KEY (`id_sales`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table master.t_sales: ~1 rows (approximately)
/*!40000 ALTER TABLE `t_sales` DISABLE KEYS */;
INSERT INTO `t_sales` (`id_sales`, `invoice`, `id_customer`, `total_price`, `discount`, `final_price`, `cash`, `remaining`, `note`, `date`, `id_user`, `sales_created`) VALUES
	(1, 'HA2006180001', 1, 20000, 10, 10000, 10000, 0, 'Tidak ada', '2020-06-18', 1, '2020-06-18 16:42:52');
/*!40000 ALTER TABLE `t_sales` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
