-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2020 at 03:47 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wallets`
--

-- --------------------------------------------------------

--
-- Table structure for table `kushdeep-kush`
--

CREATE TABLE `kushdeep-kush` (
  `S. No.` int(11) NOT NULL,
  `Category` varchar(10) NOT NULL,
  `Amount` int(11) NOT NULL,
  `Sub Category` varchar(20) NOT NULL,
  `Date` date NOT NULL,
  `Description` varchar(70) NOT NULL,
  `Mode` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kushdeep-kush`
--

INSERT INTO `kushdeep-kush` (`S. No.`, `Category`, `Amount`, `Sub Category`, `Date`, `Description`, `Mode`) VALUES
(1, 'Income', 10000, 'Salary', '2020-11-24', '', 'Cash'),
(2, 'Expense', 5000, 'Transportation', '2020-11-24', '', 'Cash'),
(3, 'Expense', 1000, 'Travel', '2020-11-24', '', 'Credit Card'),
(4, 'Expense', 200, 'Travel', '2020-11-24', 'qwertyuiopasdf', 'Cash'),
(5, 'Expense', 10, 'Withdrawal', '2020-11-24', 'ddfdfdffdfdfdfdfdfdfdf', 'Cash'),
(6, 'Expense', 2000, 'Travel', '2020-11-24', 'cccdgdgdgdfsfsfsf', 'Net Banking'),
(7, 'Income', 200, 'Interest Money', '2020-11-24', 'dfdgdgdgdggdgdg', 'Credit Card'),
(8, 'Income', 1000, 'Gifts', '2020-11-24', 'aaaaaaaaaaaaaaa', 'Cash'),
(9, 'Expense', 2990, 'Others', '2020-11-24', '', 'Credit Card'),
(10, 'Income', 20000, 'Gifts', '2020-11-24', '', 'Cash'),
(11, 'Expense', 21000, 'Withdrawal', '2020-11-24', '', 'UPI');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kushdeep-kush`
--
ALTER TABLE `kushdeep-kush`
  ADD PRIMARY KEY (`S. No.`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kushdeep-kush`
--
ALTER TABLE `kushdeep-kush`
  MODIFY `S. No.` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
