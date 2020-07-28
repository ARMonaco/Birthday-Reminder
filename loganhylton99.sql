-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 28, 2020 at 04:45 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `loganhylton99`
--

CREATE TABLE `loganhylton99` (
  `Name` varchar(11) NOT NULL,
  `Birthday` date NOT NULL,
  `Email` tinyint(1) NOT NULL DEFAULT 0,
  `SMS` tinyint(1) NOT NULL DEFAULT 0,
  `Desk` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loganhylton99`
--

INSERT INTO `loganhylton99` (`Name`, `Birthday`, `Email`, `SMS`, `Desk`) VALUES
('Shreyas', '2020-07-27', 0, 1, 0),
('Shreyas', '2020-07-27', 0, 1, 0),
('Alexander', '1999-08-01', 0, 0, 0),
('Shrey', '1970-01-01', 0, 0, 0),
('Shrey2', '1999-08-04', 0, 0, 0),
('Shrey3', '1970-01-01', 0, 0, 0),
('S', '1970-01-01', 0, 0, 0),
('S2', '1970-01-01', 0, 0, 0),
('S3', '1970-01-01', 0, 0, 0),
('S4', '1970-01-01', 0, 0, 0),
('Shreyas', '1999-10-03', 0, 0, 0),
('Shreyas12', '1992-10-03', 0, 0, 0),
('Shreyas24', '1999-10-03', 1, 0, 1),
('Shrey12', '1212-12-12', 0, 1, 1),
('Shrey33', '1999-10-03', 1, 1, 0),
('Shrey44', '1999-10-03', 0, 1, 1),
('Shrey42', '1992-10-04', 0, 1, 1),
('hey', '1992-10-04', 0, 0, 0),
('shrey101', '1999-10-03', 0, 0, 0),
('shrey43', '1999-10-03', 0, 0, 0),
('shrey109213', '1999-10-03', 0, 0, 0),
('shrey7', '1999-10-03', 0, 0, 0),
('Tester1', '1998-07-20', 0, 0, 0),
('Tester2', '1986-08-01', 1, 0, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
