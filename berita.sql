-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2024 at 01:03 PM
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
-- Database: `berita`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `kategori` enum('Technology','Lifestyle') NOT NULL,
  `author` varchar(100) NOT NULL,
  `tanggal_publikasi` date NOT NULL,
  `images` varchar(255) NOT NULL,
  `view` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `kategori` enum('Technology','Lifestyle') NOT NULL,
  `author` varchar(100) NOT NULL,
  `tanggal_publikasi` date NOT NULL,
  `images` varchar(255) NOT NULL,
  `view` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `judul`, `isi`, `kategori`, `author`, `tanggal_publikasi`, `images`, `view`) VALUES
(2, 'Ancaman Limbah Elektronik dari AI ', 'Dampak lingkungan dari limbah teknologi semakin meningkat, terutama akibat konsumsi energi yang tinggi oleh kecerdasan buatan (AI)', 'Technology', 'Teknologi.id', '2024-10-05', 'Ancaman Limbah Elektronik dari AI.jpg', 3),
(3, 'Rekomendasi iPad untuk Pelajar', 'Membahas seri iPad yang cocok untuk kegiatan belajar sehari-hari.', 'Technology', 'Teknologi.id', '2024-10-05', 'Rekomendasi iPad untuk Pelajar.jpg', 3),
(4, 'Inovasi Battery Swapping untuk Motor Listrik', 'Solusi pengisian daya cepat bagi motor listrik dengan metode ganti baterai.', 'Technology', 'Tekno Tempo', '2024-10-08', 'Inovasi Battery Swapping untuk Motor Listrik.jpg', 0),
(5, 'Limbah Plastik Jadi Bahan Bakar', 'Teknologi terbaru untuk mengolah sampah plastik menjadi bahan bakar di Semarang.', 'Technology', 'Tekno Tempo', '2024-10-08', 'Limbah Plastik Jadi Bahan Bakar.jpg', 1),
(6, 'Membangun Kebiasaan Sehat untuk Tidur', 'Tips meningkatkan kualitas tidur untuk kesehatan jangka panjang.', 'Lifestyle', 'Raycal Pranata', '2024-10-31', 'Membangun Kebiasaan Sehat untuk Tidur.jpg', 26),
(8, 'Panduan Memilih Produk Kecantikan Berkelanjutan', 'Cara memilih produk ramah lingkungan yang mendukung gaya hidup berkelanjutan.', 'Lifestyle', 'androkit.com', '2024-10-31', 'Panduan Memilih Produk Kecantikan Berkelanjutan.jpg', 17),
(9, 'Self-Care untuk Kesehatan Mental', 'Praktik perawatan diri yang bisa mendukung kesehatan mental.', 'Lifestyle', 'aiderayvelines.org', '2024-10-31', 'Self-Care untuk Kesehatan Mental.jpg', 0),
(10, 'Olahraga Rutin di Rumah', 'Cara-cara efektif untuk tetap aktif tanpa harus ke pusat kebugaran.', 'Lifestyle', 'narmadi.com', '2024-10-31', 'Olahraga Rutin di Rumah.jpg', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
