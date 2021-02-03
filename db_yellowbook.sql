-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 03, 2021 at 04:36 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_yellowbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `cash_register`
--

DROP TABLE IF EXISTS `cash_register`;
CREATE TABLE IF NOT EXISTS `cash_register` (
  `cash_reg_id` int(11) NOT NULL AUTO_INCREMENT,
  `cash_rcvd_date` date NOT NULL,
  `cash_in_amount` float DEFAULT NULL,
  `cash_out_amount` float DEFAULT NULL,
  `cash_in_hand` double DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `credit_id` int(11) DEFAULT NULL,
  `cheq_id` int(11) DEFAULT NULL,
  `cash_out_description` varchar(200) DEFAULT NULL,
  `cash_in_description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`cash_reg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash_register`
--

INSERT INTO `cash_register` (`cash_reg_id`, `cash_rcvd_date`, `cash_in_amount`, `cash_out_amount`, `cash_in_hand`, `sale_id`, `purchase_id`, `credit_id`, `cheq_id`, `cash_out_description`, `cash_in_description`) VALUES
(22, '2020-11-10', 255000, NULL, 255000, NULL, NULL, 25, NULL, NULL, NULL),
(4, '2020-12-28', 650, NULL, 255650, 129, NULL, NULL, NULL, NULL, NULL),
(8, '2020-12-30', 150, NULL, 255850, NULL, NULL, 24, NULL, NULL, NULL),
(23, '2020-12-29', 50, NULL, 255700, NULL, NULL, 25, NULL, NULL, NULL),
(31, '2021-01-14', NULL, 42, 255787, NULL, NULL, NULL, NULL, 'dfdfsdfsdf', NULL),
(32, '2021-01-16', NULL, 35, 255752, NULL, NULL, NULL, NULL, 'dfdsfdsfsfsdfdf', NULL),
(33, '2021-01-20', NULL, 3, 257803, NULL, NULL, NULL, NULL, 'dfsdfsdfsdf', NULL),
(35, '2021-01-16', NULL, 24, 255728, NULL, NULL, NULL, NULL, 'dfsdfsdfsdfsdf dfsdfsdfsdf', NULL),
(43, '2021-01-17', NULL, 425, 255677, NULL, NULL, NULL, NULL, 'deposit', NULL),
(42, '2021-01-17', 575, NULL, 256102, NULL, NULL, NULL, NULL, NULL, 'gku'),
(41, '2021-01-17', NULL, 201, 255527, NULL, NULL, NULL, NULL, 'deposit', NULL),
(44, '2021-01-17', 5451, NULL, 261128, NULL, NULL, NULL, NULL, NULL, 'sgdgdg'),
(45, '2021-01-17', NULL, 1, 261127, NULL, NULL, NULL, NULL, 'rrr tttt', NULL),
(46, '2021-01-17', NULL, 32, 261095, NULL, NULL, NULL, NULL, 'sdd sd sd', NULL),
(48, '2021-01-17', NULL, 32, 261063, NULL, NULL, NULL, NULL, 'sasdsd ssadf', NULL),
(49, '2021-01-17', NULL, 23, 261040, NULL, NULL, NULL, NULL, 'dsfdf', NULL),
(50, '2021-01-13', NULL, 21, 255829, NULL, NULL, NULL, NULL, 'csdcd', NULL),
(61, '2021-01-19', NULL, 3234, 257806, NULL, NULL, NULL, NULL, 'dfsdfdf', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cheques_issued`
--

DROP TABLE IF EXISTS `cheques_issued`;
CREATE TABLE IF NOT EXISTS `cheques_issued` (
  `purchase_id` int(11) NOT NULL,
  `company` varchar(20) NOT NULL,
  `cheque_no` int(11) NOT NULL,
  `cheque_date` date NOT NULL,
  `cheque_value` float NOT NULL,
  PRIMARY KEY (`purchase_id`,`cheque_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cheques_received`
--

DROP TABLE IF EXISTS `cheques_received`;
CREATE TABLE IF NOT EXISTS `cheques_received` (
  `chq_id` int(11) NOT NULL AUTO_INCREMENT,
  `chq_rcvd_date` date NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `credit_id` int(11) DEFAULT NULL,
  `chq_no` int(11) NOT NULL,
  `chq_bank` varchar(20) NOT NULL,
  `chq_bank_branch` varchar(20) NOT NULL,
  `chq_date` date NOT NULL,
  `chq_value` float NOT NULL,
  `chq_status` varchar(15) NOT NULL,
  PRIMARY KEY (`chq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cheques_received`
--

INSERT INTO `cheques_received` (`chq_id`, `chq_rcvd_date`, `sale_id`, `credit_id`, `chq_no`, `chq_bank`, `chq_bank_branch`, `chq_date`, `chq_value`, `chq_status`) VALUES
(63, '2021-01-13', 149, NULL, 123, 'NSB', 'Jaffna', '2021-01-31', 556, 'in-hand'),
(64, '2021-01-14', 131, 27, 23123, 'NTB', 'Ja Ela', '2021-01-31', 500, 'in-hand'),
(45, '2020-12-31', 126, 25, 987654, 'Pan Asia', 'Ja Ela', '2021-01-21', 250, 'in-hand'),
(39, '2020-12-30', 125, 24, 12345, 'HNB', 'Colombo 10', '2021-01-31', 50, 'in-hand'),
(51, '2020-12-28', 125, NULL, 222, 'NDB', 'Wattala', '2020-12-30', 250, 'deposited'),
(50, '2020-12-28', 125, NULL, 1111, 'HNB', 'Kandana', '2020-12-31', 502, 'deposited'),
(35, '2020-12-29', 126, 25, 1234, 'HNB', 'WATTALA', '2020-12-31', 20, 'realised'),
(36, '2020-12-31', 126, 25, 321, 'HSBC', 'Wattala', '2020-12-31', 30, 'deposited'),
(52, '2021-01-09', 126, 25, 98877445, 'NDB', 'Kandana', '2021-01-11', 50, 'in-hand'),
(53, '2021-01-11', 126, 25, 654654, 'Sampath', 'Negombo', '2021-01-12', 99, 'in-hand');

-- --------------------------------------------------------

--
-- Table structure for table `credit_sales`
--

DROP TABLE IF EXISTS `credit_sales`;
CREATE TABLE IF NOT EXISTS `credit_sales` (
  `credit_sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `credit_amount` float NOT NULL,
  `credit_date` date NOT NULL,
  `credit_status` int(1) NOT NULL,
  PRIMARY KEY (`credit_sale_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credit_sales`
--

INSERT INTO `credit_sales` (`credit_sale_id`, `sale_id`, `credit_amount`, `credit_date`, `credit_status`) VALUES
(27, 131, 500, '2021-03-13', 0),
(26, 130, 25500, '2021-01-31', 0),
(25, 126, 1500, '2020-12-30', 0),
(24, 125, 200, '2020-12-30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `credit_statuses`
--

DROP TABLE IF EXISTS `credit_statuses`;
CREATE TABLE IF NOT EXISTS `credit_statuses` (
  `credit_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `credit_status_name` varchar(10) NOT NULL,
  PRIMARY KEY (`credit_status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credit_statuses`
--

INSERT INTO `credit_statuses` (`credit_status_id`, `credit_status_name`) VALUES
(1, 'Paid'),
(0, 'Unpaid'),
(2, 'Overdue');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_address` varchar(500) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `customer_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_address`, `customer_phone`, `customer_flag`) VALUES
(46, 'Homaga Stores', 'fsfsdf sdfsdfsdf', '65884452', NULL),
(45, 'Test Cus', '320 Uxbridge Road', '+442088960362', NULL),
(44, 'K P C S DE SILVA', '83A Balasuriya Mawatha', '0777597697', NULL),
(43, 'ZZZZ', 'sdasdasd', 'sadasdasd', NULL),
(42, 'Lakshitha', 'Kandaan', '9203449', NULL),
(41, 'Ruwan de Silva', '83A Balasuriya Mawatha', '+94777597697', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `debtor_payments`
--

DROP TABLE IF EXISTS `debtor_payments`;
CREATE TABLE IF NOT EXISTS `debtor_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `cash` double DEFAULT NULL,
  `cheque` double DEFAULT NULL,
  `chq_bounced` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE IF NOT EXISTS `purchases` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_date` date NOT NULL,
  `invoice_voucher_no` varchar(10) NOT NULL,
  `company` varchar(20) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `invoice_value` float NOT NULL,
  `cash_value` float DEFAULT NULL,
  `cheque_value` int(11) DEFAULT NULL,
  `credit_value` float DEFAULT NULL,
  `credit_date` date DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `sales_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_date` date NOT NULL,
  `sale_by` varchar(20) NOT NULL,
  `inv_no` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `cash_sale` float DEFAULT NULL,
  `chq_sale` float DEFAULT NULL,
  `credit_sale` float DEFAULT NULL,
  PRIMARY KEY (`sales_id`)
) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `sale_date`, `sale_by`, `inv_no`, `customer_id`, `cash_sale`, `chq_sale`, `credit_sale`) VALUES
(149, '2021-01-13', '2', '123456', 44, 0, 556, 0),
(131, '2021-01-13', '3', '98651', 46, 0, 0, 500),
(130, '2021-01-01', '3', '96587', 44, 0, 0, 25500),
(129, '2020-12-28', '3', '789', 45, 650, 0, 0),
(126, '2020-12-28', '4', '654', 43, 0, 0, 1500),
(125, '2020-12-28', '2', '12345', 42, 8, 752, 200);

-- --------------------------------------------------------

--
-- Table structure for table `sale_by`
--

DROP TABLE IF EXISTS `sale_by`;
CREATE TABLE IF NOT EXISTS `sale_by` (
  `sale_by_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_by_name` varchar(20) NOT NULL,
  PRIMARY KEY (`sale_by_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_by`
--

INSERT INTO `sale_by` (`sale_by_id`, `sale_by_name`) VALUES
(1, 'Cargills'),
(2, 'Keels'),
(3, 'Laugfs'),
(4, 'Ex-Fac'),
(5, 'Wholesale'),
(6, 'Export'),
(7, 'Jayantha'),
(8, 'Lakshitha');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(20) NOT NULL,
  `supplier_address` varchar(40) NOT NULL,
  `supplier_phone` int(20) NOT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
