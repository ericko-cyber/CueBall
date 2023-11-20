-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2023 at 08:51 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_billiard`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_user` int(3) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_user`, `username`, `password`, `nama`, `phone`, `email`) VALUES
(8, 'admin@admin', '$2y$10$fcZ5k6LK46DqY4LRla.pV.bTHYH/pO7Lk6D.fqkh3PrNPRSmU1lxy', 'Admin Rojak', '089516378624', 'admin@admin');

-- --------------------------------------------------------

--
-- Table structure for table `bayar`
--

CREATE TABLE `bayar` (
  `idbayar` int(11) NOT NULL,
  `idsewa` int(11) NOT NULL,
  `bukti` text NOT NULL,
  `tgl_upload` date NOT NULL DEFAULT current_timestamp(),
  `konfirmasi` varchar(50) NOT NULL DEFAULT 'Belum'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bayar`
--

INSERT INTO `bayar` (`idbayar`, `idsewa`, `bukti`, `tgl_upload`, `konfirmasi`) VALUES
(56, 125, '652d56583731e.jpg', '2023-10-16', 'Sudah Bayar'),
(57, 126, '652d5e0c52e99.png', '2023-10-16', 'Terkonfirmasi'),
(58, 127, '652e32c2dab35.jpg', '2023-10-17', 'Terkonfirmasi'),
(60, 130, '64522a4de1d9a.png', '2023-05-03', 'Terkonfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `bayarmkn`
--

CREATE TABLE `bayarmkn` (
  `idbayarmkn` int(11) NOT NULL,
  `idpesan` int(11) NOT NULL,
  `bukti` text NOT NULL,
  `tgl_upload` date NOT NULL,
  `konfirmasi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `idpesanmkn` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idmakanan` int(11) NOT NULL,
  `tgl_pesan` date NOT NULL,
  `harga` varchar(255) NOT NULL,
  `tot` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`idpesanmkn`, `iduser`, `idmakanan`, `tgl_pesan`, `harga`, `tot`) VALUES
(126, 98, 23, '2023-10-16', '30000', '100000'),
(127, 98, 24, '2023-11-01', '10000', '200000'),
(128, 98, 23, '2023-12-08', '30000', '300000'),
(129, 98, 24, '2023-10-26', '10000', '10000');

-- --------------------------------------------------------

--
-- Table structure for table `lapangan`
--

CREATE TABLE `lapangan` (
  `idlap` int(11) NOT NULL,
  `nm` varchar(35) NOT NULL,
  `ket` text NOT NULL,
  `harga` int(11) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lapangan`
--

INSERT INTO `lapangan` (`idlap`, `nm`, `ket`, `harga`, `foto`) VALUES
(23, 'Meja Kecil 02', 'meja kecil', 10000, '6545b1010840b.png'),
(24, 'Meja Besar 01', 'meja besar', 40000, 'futsal.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `makanan`
--

CREATE TABLE `makanan` (
  `idmakanan` int(11) NOT NULL,
  `nm` varchar(35) NOT NULL,
  `stok` text NOT NULL,
  `harga` int(11) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `makanan`
--

INSERT INTO `makanan` (`idmakanan`, `nm`, `stok`, `harga`, `foto`) VALUES
(11, 'Coba1', '10', 10000, '65531c7ed6c95.png'),
(12, 'Coba1', '', 10000, '65533d81e6672.png');

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan`
--

CREATE TABLE `pemasukan` (
  `idp` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `pemasukan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemasukan`
--

INSERT INTO `pemasukan` (`idp`, `tgl`, `keterangan`, `pemasukan`) VALUES
(3, '2023-11-14 09:23:55', 'meja', '10000\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `idp` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `pengeluaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sewa`
--

CREATE TABLE `sewa` (
  `idsewa` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idlap` int(11) NOT NULL,
  `tgl_pesan` date NOT NULL DEFAULT current_timestamp(),
  `lama` int(11) NOT NULL,
  `jmulai` datetime NOT NULL,
  `jhabis` datetime NOT NULL,
  `harga` int(11) NOT NULL,
  `tot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sewa`
--

INSERT INTO `sewa` (`idsewa`, `iduser`, `idlap`, `tgl_pesan`, `lama`, `jmulai`, `jhabis`, `harga`, `tot`) VALUES
(127, 98, 24, '2023-11-01', 2, '2023-10-17 14:06:00', '2023-10-17 16:06:00', 10000, 20000),
(128, 98, 23, '2023-12-08', 0, '2023-10-26 01:00:00', '2023-10-26 01:00:00', 30000, 30000),
(129, 98, 24, '2023-10-26', 23, '0000-00-00 00:00:00', '1970-01-02 00:00:00', 10000, 10000),
(130, 125, 23, '2023-10-16', 2, '2023-10-16 22:59:00', '2023-10-17 00:59:00', 30000, 60000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `nama_lengkap` varchar(60) NOT NULL,
  `alamat` text NOT NULL,
  `foto` text NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `account_activation_hash` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email`, `password`, `hp`, `jenis_kelamin`, `nama_lengkap`, `alamat`, `foto`, `reset_token_hash`, `reset_token_expires_at`, `account_activation_hash`) VALUES
(127, 'ulumuddini585@gmail.com', '$2y$10$cslAn16v0N1571CYOkTj1uzRC8sB8TQby/Gk7YShh1NFD8NJSjJZy', '0895765679876', 'Laki-Laki', 'p', 'tidar', '65585126add17.jpeg', NULL, NULL, NULL),
(125, 'ulumuddini585@gmail.com', '$2y$10$0Uxp4b5AuHmte6Eh2VCVpublk51.wMHxZTnd23DeBi3JM92RdF/7m', '0895765679876', 'Laki-laki', 'erick', 'tidar', '655703af2a1cf.png', NULL, NULL, NULL),
(126, 'ulumuddini585@gmail.com', '$2y$10$3T2RW7848wNi/XWg.ZlQBuQNN6spA2A9s9EnSLf9NYQ7WVxVqUtSa', '0895765679876', 'Laki-Laki', 'erick', 'tidar', '65584fe2eabec.jpeg', NULL, NULL, '76ab5c032ca8b55b9987d8537521bb9386b40b8bcb59a853be20b55a079fdb87');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `bayar`
--
ALTER TABLE `bayar`
  ADD PRIMARY KEY (`idbayar`);

--
-- Indexes for table `bayarmkn`
--
ALTER TABLE `bayarmkn`
  ADD PRIMARY KEY (`idbayarmkn`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`idpesanmkn`);

--
-- Indexes for table `lapangan`
--
ALTER TABLE `lapangan`
  ADD PRIMARY KEY (`idlap`);

--
-- Indexes for table `makanan`
--
ALTER TABLE `makanan`
  ADD PRIMARY KEY (`idmakanan`);

--
-- Indexes for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`idp`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`idp`);

--
-- Indexes for table `sewa`
--
ALTER TABLE `sewa`
  ADD PRIMARY KEY (`idsewa`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD UNIQUE KEY `account_activation_hash` (`account_activation_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_user` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bayar`
--
ALTER TABLE `bayar`
  MODIFY `idbayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `bayarmkn`
--
ALTER TABLE `bayarmkn`
  MODIFY `idbayarmkn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `idpesanmkn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `lapangan`
--
ALTER TABLE `lapangan`
  MODIFY `idlap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `makanan`
--
ALTER TABLE `makanan`
  MODIFY `idmakanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `idp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `idp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sewa`
--
ALTER TABLE `sewa`
  MODIFY `idsewa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
