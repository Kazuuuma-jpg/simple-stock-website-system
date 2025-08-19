-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2025 at 05:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `penerima` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `idbarang`, `tanggal`, `penerima`, `qty`) VALUES
(0, 5, '2025-08-07 18:40:10', 'pembeli', 50),
(0, 6, '2025-08-08 10:27:00', 'pembeli', 200),
(0, 7, '2025-08-08 10:29:19', 'pembeli', 20),
(0, 8, '2025-08-08 10:33:33', 'pembeli', 50),
(0, 10, '2025-08-08 11:29:24', 'yayan', 5),
(0, 11, '2025-08-08 11:31:50', 'a', 50),
(0, 13, '2025-08-16 21:27:26', 'pembeli', 6);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `tanggal`, `keterangan`, `qty`) VALUES
(10, 11, '2025-08-08 11:31:36', 'b', 100),
(11, 13, '2025-08-16 21:27:04', 'samsung suplier', 6),
(12, 15, '2025-08-17 11:35:30', 'samsung suplier', 10),
(13, 16, '2025-08-19 14:36:09', 'Supplier Google', 10),
(14, 17, '2025-08-19 14:36:24', 'Supplier Xiaomi', 10),
(15, 18, '2025-08-19 14:36:40', 'Supplier Samsung', 10),
(16, 19, '2025-08-19 14:37:02', 'Supplier Apple', 10),
(17, 20, '2025-08-19 14:37:16', 'Supplier Huawei', 10),
(18, 21, '2025-08-19 14:37:28', 'Supplier Oppo', 10),
(19, 22, '2025-08-19 14:37:42', 'Supplier Vivo', 10),
(20, 23, '2025-08-19 14:38:12', 'Supplier OnePlus', 10),
(21, 24, '2025-08-19 14:38:25', 'Supplier Realme', 10),
(22, 25, '2025-08-19 14:38:37', 'Supplier Motorola', 10),
(23, 26, '2025-08-19 14:38:50', 'Supplier Nokia', 10);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`idbarang`, `namabarang`, `deskripsi`, `stock`) VALUES
(16, 'Google', 'New', 10),
(17, 'Xiaomi', 'New', 10),
(18, 'Samsung', 'New', 10),
(19, 'Apple', 'New', 10),
(20, 'Huawei', 'New', 10),
(21, 'Oppo', 'New', 10),
(22, 'Vivo', 'New', 10),
(23, 'OnePlus', 'New', 10),
(24, 'Realme', 'New', 10),
(25, 'Motorola', 'New', 10),
(26, 'Nokia', 'New', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
