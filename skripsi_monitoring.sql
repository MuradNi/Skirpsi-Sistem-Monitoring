-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 22, 2026 at 01:32 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi_monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` int NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wali_kelas_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama`, `tingkat`, `tahun_ajaran`, `wali_kelas_id`, `created_at`, `updated_at`) VALUES
(1, '6A', 6, '2024/2025', 4, '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(2, '6B', 6, '2024/2025', 3, '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(3, '5A', 5, '2024/2025', 2, '2026-06-07 09:36:26', '2026-06-07 09:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajarans`
--

CREATE TABLE `mata_pelajarans` (
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kkm` int NOT NULL DEFAULT '70',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mata_pelajarans`
--

INSERT INTO `mata_pelajarans` (`id`, `kode`, `nama`, `kkm`, `created_at`, `updated_at`) VALUES
(1, 'MTK', 'Matematika', 75, '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(2, 'BIN', 'Bahasa Indonesia', 70, '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(3, 'IPA', 'Ilmu Pengetahuan Alam', 70, '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(4, 'IPS', 'Ilmu Pengetahuan Sosial', 70, '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(5, 'ING', 'Bahasa Inggris', 75, '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(6, 'AG', 'Pendidikan Agama', 80, '2026-06-07 09:36:26', '2026-06-07 09:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2026_05_28_160001_create_kelas_table', 1),
(3, '2026_05_28_160002_create_siswas_table', 1),
(4, '2026_05_28_160003_create_mata_pelajarans_table', 1),
(5, '2026_05_28_160004_create_nilais_table', 1),
(6, '2026_05_28_160005_create_raports_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nilais`
--

CREATE TABLE `nilais` (
  `id` bigint UNSIGNED NOT NULL,
  `siswa_id` bigint UNSIGNED NOT NULL,
  `mata_pelajaran_id` bigint UNSIGNED NOT NULL,
  `guru_id` bigint UNSIGNED NOT NULL,
  `jenis` enum('uh1','uts','uh2','uas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` int NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilais`
--

INSERT INTO `nilais` (`id`, `siswa_id`, `mata_pelajaran_id`, `guru_id`, `jenis`, `semester`, `tahun_ajaran`, `nilai`, `keterangan`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'uh1', 2, '2024/2025', 85.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(2, 1, 1, 2, 'uts', 2, '2024/2025', 78.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(3, 1, 1, 2, 'uh2', 2, '2024/2025', 82.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(4, 1, 1, 2, 'uas', 2, '2024/2025', 80.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(5, 1, 2, 2, 'uh1', 2, '2024/2025', 90.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(6, 1, 2, 2, 'uts', 2, '2024/2025', 85.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(7, 1, 2, 2, 'uh2', 2, '2024/2025', 87.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(8, 1, 2, 2, 'uas', 2, '2024/2025', 88.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(9, 1, 3, 3, 'uh1', 2, '2024/2025', 78.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(10, 1, 3, 3, 'uts', 2, '2024/2025', 72.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(11, 1, 3, 3, 'uh2', 2, '2024/2025', 76.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(12, 1, 3, 3, 'uas', 2, '2024/2025', 75.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(13, 1, 4, 3, 'uh1', 2, '2024/2025', 82.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(14, 1, 4, 3, 'uts', 2, '2024/2025', 80.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(15, 1, 4, 3, 'uh2', 2, '2024/2025', 81.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(16, 1, 4, 3, 'uas', 2, '2024/2025', 84.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(17, 1, 5, 2, 'uh1', 2, '2024/2025', 88.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(18, 1, 5, 2, 'uts', 2, '2024/2025', 86.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(19, 1, 5, 2, 'uh2', 2, '2024/2025', 89.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(20, 1, 5, 2, 'uas', 2, '2024/2025', 90.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(21, 1, 6, 3, 'uh1', 2, '2024/2025', 95.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(22, 1, 6, 3, 'uts', 2, '2024/2025', 92.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(23, 1, 6, 3, 'uh2', 2, '2024/2025', 93.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(24, 1, 6, 3, 'uas', 2, '2024/2025', 94.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(25, 2, 1, 2, 'uh1', 2, '2024/2025', 92.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(26, 2, 1, 2, 'uts', 2, '2024/2025', 90.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:43:23'),
(27, 2, 1, 2, 'uh2', 2, '2024/2025', 93.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(28, 2, 1, 2, 'uas', 2, '2024/2025', 94.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(29, 2, 2, 2, 'uh1', 2, '2024/2025', 88.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(30, 2, 2, 2, 'uts', 2, '2024/2025', 82.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(31, 2, 2, 2, 'uh2', 2, '2024/2025', 84.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(32, 2, 2, 2, 'uas', 2, '2024/2025', 85.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(33, 2, 3, 3, 'uh1', 2, '2024/2025', 89.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(34, 2, 3, 3, 'uts', 2, '2024/2025', 92.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(35, 2, 3, 3, 'uh2', 2, '2024/2025', 91.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(36, 2, 3, 3, 'uas', 2, '2024/2025', 90.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(37, 2, 4, 3, 'uh1', 2, '2024/2025', 78.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(38, 2, 4, 3, 'uts', 2, '2024/2025', 75.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(39, 2, 4, 3, 'uh2', 2, '2024/2025', 79.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(40, 2, 4, 3, 'uas', 2, '2024/2025', 80.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(41, 2, 5, 2, 'uh1', 2, '2024/2025', 95.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(42, 2, 5, 2, 'uts', 2, '2024/2025', 90.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(43, 2, 5, 2, 'uh2', 2, '2024/2025', 93.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(44, 2, 5, 2, 'uas', 2, '2024/2025', 96.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(45, 2, 6, 3, 'uh1', 2, '2024/2025', 90.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(46, 2, 6, 3, 'uts', 2, '2024/2025', 88.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(47, 2, 6, 3, 'uh2', 2, '2024/2025', 89.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(48, 2, 6, 3, 'uas', 2, '2024/2025', 92.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(49, 3, 1, 2, 'uh1', 2, '2024/2025', 68.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(50, 3, 1, 2, 'uts', 2, '2024/2025', 62.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(51, 3, 1, 2, 'uh2', 2, '2024/2025', 64.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(52, 3, 1, 2, 'uas', 2, '2024/2025', 65.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(53, 3, 2, 2, 'uh1', 2, '2024/2025', 72.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(54, 3, 2, 2, 'uts', 2, '2024/2025', 70.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(55, 3, 2, 2, 'uh2', 2, '2024/2025', 73.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(56, 3, 2, 2, 'uas', 2, '2024/2025', 74.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(57, 3, 3, 3, 'uh1', 2, '2024/2025', 65.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(58, 3, 3, 3, 'uts', 2, '2024/2025', 58.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(59, 3, 3, 3, 'uh2', 2, '2024/2025', 60.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(60, 3, 3, 3, 'uas', 2, '2024/2025', 62.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(61, 3, 4, 3, 'uh1', 2, '2024/2025', 74.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(62, 3, 4, 3, 'uts', 2, '2024/2025', 71.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(63, 3, 4, 3, 'uh2', 2, '2024/2025', 73.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(64, 3, 4, 3, 'uas', 2, '2024/2025', 72.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(65, 3, 5, 2, 'uh1', 2, '2024/2025', 69.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(66, 3, 5, 2, 'uts', 2, '2024/2025', 65.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(67, 3, 5, 2, 'uh2', 2, '2024/2025', 68.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(68, 3, 5, 2, 'uas', 2, '2024/2025', 70.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(69, 3, 6, 3, 'uh1', 2, '2024/2025', 80.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(70, 3, 6, 3, 'uts', 2, '2024/2025', 82.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(71, 3, 6, 3, 'uh2', 2, '2024/2025', 84.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(72, 3, 6, 3, 'uas', 2, '2024/2025', 85.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(73, 4, 1, 2, 'uh1', 2, '2024/2025', 80.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(74, 4, 1, 2, 'uts', 2, '2024/2025', 78.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(75, 4, 1, 2, 'uh2', 2, '2024/2025', 81.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(76, 4, 1, 2, 'uas', 2, '2024/2025', 82.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(77, 4, 2, 2, 'uh1', 2, '2024/2025', 85.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(78, 4, 2, 2, 'uts', 2, '2024/2025', 80.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(79, 4, 2, 2, 'uh2', 2, '2024/2025', 82.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(80, 4, 2, 2, 'uas', 2, '2024/2025', 83.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(81, 4, 3, 3, 'uh1', 2, '2024/2025', 82.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(82, 4, 3, 3, 'uts', 2, '2024/2025', 84.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(83, 4, 3, 3, 'uh2', 2, '2024/2025', 81.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(84, 4, 3, 3, 'uas', 2, '2024/2025', 80.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(85, 4, 4, 3, 'uh1', 2, '2024/2025', 90.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(86, 4, 4, 3, 'uts', 2, '2024/2025', 88.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(87, 4, 4, 3, 'uh2', 2, '2024/2025', 89.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(88, 4, 4, 3, 'uas', 2, '2024/2025', 91.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(89, 4, 5, 2, 'uh1', 2, '2024/2025', 76.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(90, 4, 5, 2, 'uts', 2, '2024/2025', 78.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(91, 4, 5, 2, 'uh2', 2, '2024/2025', 77.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(92, 4, 5, 2, 'uas', 2, '2024/2025', 75.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(93, 4, 6, 3, 'uh1', 2, '2024/2025', 88.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(94, 4, 6, 3, 'uts', 2, '2024/2025', 85.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(95, 4, 6, 3, 'uh2', 2, '2024/2025', 87.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(96, 4, 6, 3, 'uas', 2, '2024/2025', 89.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(97, 5, 1, 2, 'uh1', 2, '2024/2025', 60.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(98, 5, 1, 2, 'uts', 2, '2024/2025', 58.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(99, 5, 1, 2, 'uh2', 2, '2024/2025', 61.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(100, 5, 1, 2, 'uas', 2, '2024/2025', 62.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(101, 5, 2, 2, 'uh1', 2, '2024/2025', 72.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(102, 5, 2, 2, 'uts', 2, '2024/2025', 68.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(103, 5, 2, 2, 'uh2', 2, '2024/2025', 69.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(104, 5, 2, 2, 'uas', 2, '2024/2025', 70.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(105, 5, 3, 3, 'uh1', 2, '2024/2025', 68.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(106, 5, 3, 3, 'uts', 2, '2024/2025', 62.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(107, 5, 3, 3, 'uh2', 2, '2024/2025', 64.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(108, 5, 3, 3, 'uas', 2, '2024/2025', 65.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(109, 5, 4, 3, 'uh1', 2, '2024/2025', 80.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(110, 5, 4, 3, 'uts', 2, '2024/2025', 78.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(111, 5, 4, 3, 'uh2', 2, '2024/2025', 81.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(112, 5, 4, 3, 'uas', 2, '2024/2025', 82.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(113, 5, 5, 2, 'uh1', 2, '2024/2025', 62.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(114, 5, 5, 2, 'uts', 2, '2024/2025', 60.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(115, 5, 5, 2, 'uh2', 2, '2024/2025', 64.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(116, 5, 5, 2, 'uas', 2, '2024/2025', 65.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(117, 5, 6, 3, 'uh1', 2, '2024/2025', 82.00, 'Nilai UH1', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(118, 5, 6, 3, 'uts', 2, '2024/2025', 80.00, 'Nilai UTS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(119, 5, 6, 3, 'uh2', 2, '2024/2025', 81.00, 'Nilai UH2', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(120, 5, 6, 3, 'uas', 2, '2024/2025', 83.00, 'Nilai UAS', '2026-06-07', '2026-06-07 09:36:27', '2026-06-07 09:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `raports`
--

CREATE TABLE `raports` (
  `id` bigint UNSIGNED NOT NULL,
  `siswa_id` bigint UNSIGNED NOT NULL,
  `mata_pelajaran_id` bigint UNSIGNED NOT NULL,
  `semester` int NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_uh1` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_uts` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_uh2` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_uas` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_akhir` decimal(5,2) NOT NULL DEFAULT '0.00',
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tuntas` tinyint(1) NOT NULL DEFAULT '0',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raports`
--

INSERT INTO `raports` (`id`, `siswa_id`, `mata_pelajaran_id`, `semester`, `tahun_ajaran`, `nilai_uh1`, `nilai_uts`, `nilai_uh2`, `nilai_uas`, `nilai_akhir`, `grade`, `tuntas`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '2024/2025', 85.00, 78.00, 82.00, 80.00, 80.80, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(2, 1, 2, 2, '2024/2025', 90.00, 85.00, 87.00, 88.00, 87.30, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(3, 1, 3, 2, '2024/2025', 78.00, 72.00, 76.00, 75.00, 74.90, 'C', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(4, 1, 4, 2, '2024/2025', 82.00, 80.00, 81.00, 84.00, 81.80, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(5, 1, 5, 2, '2024/2025', 88.00, 86.00, 89.00, 90.00, 88.20, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(6, 1, 6, 2, '2024/2025', 95.00, 92.00, 93.00, 94.00, 93.40, 'A', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(7, 2, 1, 2, '2024/2025', 92.00, 90.00, 93.00, 94.00, 92.20, 'A', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:43:23'),
(8, 2, 2, 2, '2024/2025', 88.00, 82.00, 84.00, 85.00, 84.50, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(9, 2, 3, 2, '2024/2025', 89.00, 92.00, 91.00, 90.00, 90.60, 'A', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(10, 2, 4, 2, '2024/2025', 78.00, 75.00, 79.00, 80.00, 77.90, 'C', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(11, 2, 5, 2, '2024/2025', 95.00, 90.00, 93.00, 96.00, 93.40, 'A', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(12, 2, 6, 2, '2024/2025', 90.00, 88.00, 89.00, 92.00, 89.80, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(13, 3, 1, 2, '2024/2025', 68.00, 62.00, 64.00, 65.00, 64.50, 'D', 0, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(14, 3, 2, 2, '2024/2025', 72.00, 70.00, 73.00, 74.00, 72.20, 'C', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(15, 3, 3, 2, '2024/2025', 65.00, 58.00, 60.00, 62.00, 61.00, 'D', 0, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(16, 3, 4, 2, '2024/2025', 74.00, 71.00, 73.00, 72.00, 72.30, 'C', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(17, 3, 5, 2, '2024/2025', 69.00, 65.00, 68.00, 70.00, 67.90, 'D', 0, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(18, 3, 6, 2, '2024/2025', 80.00, 82.00, 84.00, 85.00, 82.90, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(19, 4, 1, 2, '2024/2025', 80.00, 78.00, 81.00, 82.00, 80.20, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(20, 4, 2, 2, '2024/2025', 85.00, 80.00, 82.00, 83.00, 82.30, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(21, 4, 3, 2, '2024/2025', 82.00, 84.00, 81.00, 80.00, 81.80, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:26', '2026-06-07 09:36:27'),
(22, 4, 4, 2, '2024/2025', 90.00, 88.00, 89.00, 91.00, 89.50, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(23, 4, 5, 2, '2024/2025', 76.00, 78.00, 77.00, 75.00, 76.50, 'C', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(24, 4, 6, 2, '2024/2025', 88.00, 85.00, 87.00, 89.00, 87.20, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(25, 5, 1, 2, '2024/2025', 60.00, 58.00, 61.00, 62.00, 60.20, 'D', 0, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(26, 5, 2, 2, '2024/2025', 72.00, 68.00, 69.00, 70.00, 69.60, 'D', 0, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(27, 5, 3, 2, '2024/2025', 68.00, 62.00, 64.00, 65.00, 64.50, 'D', 0, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(28, 5, 4, 2, '2024/2025', 80.00, 78.00, 81.00, 82.00, 80.20, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(29, 5, 5, 2, '2024/2025', 62.00, 60.00, 64.00, 65.00, 62.70, 'D', 0, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:27', '2026-06-07 09:36:27'),
(30, 5, 6, 2, '2024/2025', 82.00, 80.00, 81.00, 83.00, 81.50, 'B', 1, 'Sikap belajar terpantau konsisten.', '2026-06-07 09:36:27', '2026-06-07 09:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `siswas`
--

CREATE TABLE `siswas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `parent_user_id` bigint UNSIGNED DEFAULT NULL,
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswas`
--

INSERT INTO `siswas` (`id`, `user_id`, `parent_user_id`, `nis`, `nama_lengkap`, `kelas_id`, `jenis_kelamin`, `tanggal_lahir`, `foto`, `created_at`, `updated_at`) VALUES
(1, 5, 5, '20240001', 'Rian Hermawan', 1, 'Laki-laki', '2013-05-12', 'https://api.dicebear.com/7.x/adventurer/svg?seed=student', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(2, NULL, NULL, '20240002', 'Alya Putri', 1, 'Perempuan', '2013-08-20', 'https://api.dicebear.com/7.x/adventurer/svg?seed=Alya', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(3, NULL, NULL, '20240003', 'Dafa Alamsyah', 1, 'Laki-laki', '2013-03-05', 'https://api.dicebear.com/7.x/adventurer/svg?seed=Dafa', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(4, NULL, NULL, '20240004', 'Siti Amelia', 2, 'Perempuan', '2013-11-15', 'https://api.dicebear.com/7.x/adventurer/svg?seed=Amelia', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(5, NULL, NULL, '20240005', 'Budi Prakoso', 2, 'Laki-laki', '2013-01-22', 'https://api.dicebear.com/7.x/adventurer/svg?seed=Budi', '2026-06-07 09:36:26', '2026-06-07 09:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_wa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','guru','wali_kelas','orang_tua','siswa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `no_wa`, `password`, `role`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso, S.Kom', 'admin@buddhi.sch.id', NULL, '$2y$12$T5gUS05G0yigLar64EFs9uenSsX4YtcCaftuU8zfnjnpi87wvH5iy', 'admin', 'https://api.dicebear.com/7.x/adventurer/svg?seed=admin', '2026-06-07 09:36:25', '2026-06-07 09:36:25'),
(2, 'Siti Rahma, S.Pd', 'guru1@buddhi.sch.id', NULL, '$2y$12$z0pnO2uN0q3.k6TWnQFIguPscatw18XgSXHSHsLV5qBlE5r2ig7.i', 'guru', 'https://api.dicebear.com/7.x/adventurer/svg?seed=teacher1', '2026-06-07 09:36:25', '2026-06-07 09:36:25'),
(3, 'Hendra Wijaya, S.Pd', 'guru2@buddhi.sch.id', NULL, '$2y$12$OGlGgBQL03s0cgCCn.sY8uDqI9qtHPa0ADwO18/AIUkqqoQudEwQW', 'guru', 'https://api.dicebear.com/7.x/adventurer/svg?seed=teacher2', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(4, 'Dewi Lestari, M.Pd', 'wali6a@buddhi.sch.id', NULL, '$2y$12$7r4bH2ofAu36GcWXR2Xcr.uRh4BcDszv9uUIA4zMrCoMe/uzjQ75a', 'guru', 'https://api.dicebear.com/7.x/adventurer/svg?seed=wali', '2026-06-07 09:36:26', '2026-06-07 09:36:26'),
(5, 'Rudi Hermawan', 'orangtua@buddhi.sch.id', '081234567890', '$2y$12$t0YnhsVp23AVVCBw1T/FQOQaMme9KbtwME4g7IeN1ps5ISIc4CyVy', 'orang_tua', 'https://api.dicebear.com/7.x/adventurer/svg?seed=parent', '2026-06-07 09:36:26', '2026-06-07 09:36:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_wali_kelas_id_foreign` (`wali_kelas_id`);

--
-- Indexes for table `mata_pelajarans`
--
ALTER TABLE `mata_pelajarans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mata_pelajarans_kode_unique` (`kode`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilais`
--
ALTER TABLE `nilais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilais_siswa_id_foreign` (`siswa_id`),
  ADD KEY `nilais_mata_pelajaran_id_foreign` (`mata_pelajaran_id`),
  ADD KEY `nilais_guru_id_foreign` (`guru_id`);

--
-- Indexes for table `raports`
--
ALTER TABLE `raports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raports_siswa_id_foreign` (`siswa_id`),
  ADD KEY `raports_mata_pelajaran_id_foreign` (`mata_pelajaran_id`);

--
-- Indexes for table `siswas`
--
ALTER TABLE `siswas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswas_nis_unique` (`nis`),
  ADD KEY `siswas_user_id_foreign` (`user_id`),
  ADD KEY `siswas_parent_user_id_foreign` (`parent_user_id`),
  ADD KEY `siswas_kelas_id_foreign` (`kelas_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mata_pelajarans`
--
ALTER TABLE `mata_pelajarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nilais`
--
ALTER TABLE `nilais`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `raports`
--
ALTER TABLE `raports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `siswas`
--
ALTER TABLE `siswas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_wali_kelas_id_foreign` FOREIGN KEY (`wali_kelas_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `nilais`
--
ALTER TABLE `nilais`
  ADD CONSTRAINT `nilais_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilais_mata_pelajaran_id_foreign` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajarans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilais_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `raports`
--
ALTER TABLE `raports`
  ADD CONSTRAINT `raports_mata_pelajaran_id_foreign` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajarans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `raports_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswas`
--
ALTER TABLE `siswas`
  ADD CONSTRAINT `siswas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `siswas_parent_user_id_foreign` FOREIGN KEY (`parent_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `siswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
