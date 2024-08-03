-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2024 at 12:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 'Ananta', '0895213121', '2024-07-27 06:25:45', '2024-07-27 06:25:45');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `qty_terjual` int(11) DEFAULT NULL,
  `total_harga_dasar` int(11) DEFAULT NULL,
  `total_harga_jual` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `tanggal`, `produk_id`, `pelanggan_id`, `qty_terjual`, `total_harga_dasar`, `total_harga_jual`, `created_at`, `updated_at`) VALUES
(1, '2024-06-27', 1, 1, 23, 240097, 251597, '2024-07-27 07:27:18', '2024-07-27 08:57:32'),
(2, '2024-07-27', 4, 1, 1, 43962, 44462, '2024-07-27 08:40:26', '2024-07-27 08:40:26'),
(3, '2024-07-27', 8, 1, 5, 25000, 50000, '2024-07-27 09:16:44', '2024-07-27 09:16:44'),
(8, '2024-07-27', 1, 1, 18, 187902, 196902, '2024-07-27 10:50:24', '2024-07-27 10:50:38');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `qty_awal` int(11) DEFAULT NULL,
  `harga_awal` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `qty_awal`, `harga_awal`, `harga_jual`, `created_at`, `updated_at`) VALUES
(1, 'rem', 55, 10439, 10939, '2024-07-27 06:43:25', '2024-07-27 10:50:38'),
(2, 'harum', 85, 55640, 56140, '2024-07-27 06:43:25', '2024-07-27 10:17:54'),
(3, 'velit', 18, 51373, 51873, '2024-07-27 06:43:25', '2024-07-27 10:29:50'),
(4, 'vel', 85, 43962, 44462, '2024-07-27 06:43:26', '2024-07-27 08:40:26'),
(5, 'perferendis', 10, 49844, 50344, '2024-07-27 06:43:26', '2024-07-27 10:26:52'),
(6, 'roti', 25, 500, 1000, '2024-07-27 09:15:19', '2024-07-27 10:46:49'),
(8, 'bensin', 5, 5000, 10000, '2024-07-27 09:15:53', '2024-07-27 09:16:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id_pelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
