-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 02:48 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_futsal`
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_user`, `username`, `password`, `nama`, `phone`, `email`) VALUES
(8, 'admin@admin', '$2y$10$RX/YQcs6fO9HVaT7lBrxiOH4jfNBSyezhKXqpyipgLd8HjyAT16fu', 'Erick', '0895765679876', 'admin@admin');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bayar`
--

INSERT INTO `bayar` (`idbayar`, `idsewa`, `bukti`, `tgl_upload`, `konfirmasi`) VALUES
(56, 125, '652d56583731e.jpg', '2023-10-16', 'Sudah Bayar'),
(57, 126, '652d5e0c52e99.png', '2023-10-16', 'Terkonfirmasi'),
(58, 127, '652e32c2dab35.jpg', '2023-10-17', 'Terkonfirmasi'),
(60, 130, '64522a4de1d9a.png', '2023-05-03', 'Terkonfirmasi'),
(62, 244, '65642e5bcec16.jpg', '2023-11-27', 'Terkonfirmasi'),
(63, 245, '65642e6de6b81.jpg', '2023-11-27', 'Sudah Bayar'),
(65, 246, '6564484580caf.jpg', '2023-11-27', 'Terkonfirmasi'),
(66, 247, '656448b0c50c8.jpg', '2023-11-27', 'Terkonfirmasi'),
(67, 248, '65654096acfe7.jpg', '2023-11-28', 'Terkonfirmasi'),
(68, 249, '656541a8703bb.jpg', '2023-11-28', 'Terkonfirmasi'),
(69, 250, '65654d8a8f4cb.jpg', '2023-11-28', 'Terkonfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `bayarmkn`
--

CREATE TABLE `bayarmkn` (
  `idbayarmkn` int(11) NOT NULL,
  `idpesan` int(11) NOT NULL,
  `bukti` text NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp(),
  `konfirmasi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bayarmkn`
--

INSERT INTO `bayarmkn` (`idbayarmkn`, `idpesan`, `bukti`, `tgl_upload`, `konfirmasi`) VALUES
(1, 1, '6564299fd3102.jpg', '0000-00-00 00:00:00', 'Terkonfirmasi'),
(2, 2, '65642c893d18c.jpg', '2023-11-27 05:43:37', 'Sudah Bayar'),
(3, 3, '656446d605713.jpg', '2023-11-27 07:35:50', 'Sudah Bayar'),
(4, 4, '656446ecab1b5.jpg', '2023-11-27 07:36:12', 'Terkonfirmasi'),
(5, 5, '6564b6daed642.jpg', '2023-11-27 15:33:46', 'Terkonfirmasi'),
(6, 6, '656540f73ce85.jpg', '2023-11-28 01:23:03', 'Terkonfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `idkeranjang` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `gambar` text NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`idkeranjang`, `iduser`, `nama`, `harga`, `gambar`, `jumlah`) VALUES
(142, 128, 'aqua', '10000', '6559b1cc669cb.jpg', 1),
(143, 128, 'coca-cola', '10000', '6558d286c75f0.jpeg', 1),
(155, 127, 'sprite', '10000', '6559b22759f3f.jpg', 3),
(156, 127, 'coca-cola', '10000', '6558d286c75f0.jpeg', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `lapangan`
--

INSERT INTO `lapangan` (`idlap`, `nm`, `ket`, `harga`, `foto`) VALUES
(51, 'Meja Besar 01', '', 25000, '65642d267cb08.jpeg'),
(52, 'Meja Kecil 01', '', 12000, '65642d39be277.jpeg'),
(53, 'Meja Besar 02', '', 25000, '65654cb29f99d.jpeg'),
(54, 'Meja Kecil 02', '', 12000, '65654d1d50200.jpeg'),
(55, 'Meja Kecil 03', '', 12000, '65654d3b9ea0e.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `makanan`
--

CREATE TABLE `makanan` (
  `idmakanan` int(11) NOT NULL,
  `nm` varchar(35) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `makanan`
--

INSERT INTO `makanan` (`idmakanan`, `nm`, `harga`, `foto`) VALUES
(11, 'aqua', '10000', '6559b1cc669cb.jpg'),
(12, 'sprite', '10000', '6565d2df18b6a.jpg'),
(13, 'coca-cola', '10000', '6565d4903e98a.jpeg'),
(14, 'Mie Goreng', '10000', '65629551066e1.jpg'),
(15, 'Mie Telur', '10000', '65642f5846300.jpg'),
(16, 'Snack Usus', '10000', '6562958d25f95.jpg'),
(17, 'Dj Super', '10000', '656295b5304ae.jpg'),
(18, 'King', '10000', '656295ce849a6.jpeg'),
<<<<<<< HEAD
(19, 'Madu Hitam', '10000', '656295e8aa940.jpeg'),
(20, 'L.A Ice', '10000', '6565d4e5501c0.jpeg');

=======
(19, 'Madu Hitam', '10000', '656295e8aa940.jpeg');
>>>>>>> 04ba2ed6fc5193a3f08d3367f260a358d19ab62f
-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `idp` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `pengeluaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `idpesan` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `tgl_pesan` timestamp NOT NULL DEFAULT current_timestamp(),
  `nama` varchar(255) NOT NULL,
  `hp` varchar(255) NOT NULL,
  `meja` varchar(255) NOT NULL,
  `foto` text NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesan`
--

INSERT INTO `pesan` (`idpesan`, `iduser`, `tgl_pesan`, `nama`, `hp`, `meja`, `foto`, `total_products`, `total_price`, `status`) VALUES
(5, 127, '2023-11-27 15:33:46', 'ihya', '0895765679876', 'meja besar 01', '6564b6daed642.jpg', 'sprite (3) , coca-cola (2) ', '50000', 'dikonfirmasi'),
(6, 127, '2023-12-28 01:23:03', 'ihya', '0895765679876', 'meja besar 01', '656540f73ce85.jpg', 'sprite (3) , coca-cola (1) ', '40000', 'dikonfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `sewa`
--

CREATE TABLE `sewa` (
  `idsewa` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idlap` int(11) NOT NULL,
  `tgl_pesan` timestamp NOT NULL DEFAULT current_timestamp(),
  `jmulai` varchar(11) NOT NULL,
  `jhabis` varchar(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `tot` varchar(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sewa`
--

INSERT INTO `sewa` (`idsewa`, `iduser`, `idlap`, `tgl_pesan`, `jmulai`, `jhabis`, `harga`, `tot`, `status`) VALUES
(244, 127, 51, '2023-11-27 05:49:37', '12:00', '14:00', 25000, '50000', 'Dikonfirmasi'),
(248, 127, 52, '2023-12-28 01:21:16', '12:00', '14:00', 12000, '24000', 'Dikonfirmasi'),
(249, 127, 51, '2023-11-28 01:25:47', '16:00', '19:00', 25000, '75000', 'Dikonfirmasi'),
(250, 127, 54, '2023-11-28 02:16:31', '12:00', '14:00', 12000, '24000', 'Dikonfirmasi');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email`, `password`, `hp`, `jenis_kelamin`, `nama_lengkap`, `alamat`, `foto`, `reset_token_hash`, `reset_token_expires_at`, `account_activation_hash`) VALUES
(127, 'ulumuddini585@gmail.com', '$2y$10$cslAn16v0N1571CYOkTj1uzRC8sB8TQby/Gk7YShh1NFD8NJSjJZy', '0895765679876', 'Laki-laki', 'mie goreng spesial', 'tidar', '65643010392d3.jpg', NULL, NULL, NULL),
(128, 'ihyau855@gmail.com', '$2y$10$EKEzMGmmG138UZW0hmDbKeAiPlH8wyPjtj3eCGl0TC0/XuTHBpZtG', '0895765679876', 'Laki-Laki', 'erick', 'tidar', '6559be8d86c23.jpg', NULL, NULL, NULL);

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
  ADD PRIMARY KEY (`idkeranjang`);

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
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`idp`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`idpesan`);

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
  MODIFY `id_user` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bayar`
--
ALTER TABLE `bayar`
  MODIFY `idbayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `bayarmkn`
--
ALTER TABLE `bayarmkn`
  MODIFY `idbayarmkn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `idkeranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `lapangan`
--
ALTER TABLE `lapangan`
  MODIFY `idlap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `makanan`
--
ALTER TABLE `makanan`
  MODIFY `idmakanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `idp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `idpesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sewa`
--
ALTER TABLE `sewa`
  MODIFY `idsewa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
