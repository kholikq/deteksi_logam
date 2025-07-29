-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jul 2025 pada 13.10
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_deteksi_logam`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `deteksi`
--

CREATE TABLE `deteksi` (
  `id` bigint(20) NOT NULL,
  `id_produksi` int(11) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `deteksi`
--

INSERT INTO `deteksi` (`id`, `id_produksi`, `waktu`) VALUES
(1, 1, '2025-07-29 03:36:02'),
(2, 1, '2025-07-29 03:36:06'),
(3, 1, '2025-07-29 03:36:11'),
(4, 1, '2025-07-29 03:36:16'),
(5, 1, '2025-07-29 03:36:21'),
(6, 1, '2025-07-29 03:36:26'),
(7, 1, '2025-07-29 03:36:31'),
(8, 1, '2025-07-29 03:36:36'),
(9, 1, '2025-07-29 03:36:41'),
(10, 1, '2025-07-29 03:36:46'),
(11, 1, '2025-07-29 03:36:51'),
(12, 1, '2025-07-29 03:36:56'),
(13, 1, '2025-07-29 03:37:01'),
(14, 1, '2025-07-29 03:37:06'),
(15, 1, '2025-07-29 03:37:11'),
(16, 1, '2025-07-29 03:37:16'),
(17, 1, '2025-07-29 03:37:21'),
(18, 1, '2025-07-29 03:37:26'),
(19, 1, '2025-07-29 03:37:31'),
(20, 1, '2025-07-29 03:37:36'),
(21, 1, '2025-07-29 03:37:41'),
(22, 1, '2025-07-29 03:37:46'),
(23, 1, '2025-07-29 03:37:51'),
(24, 1, '2025-07-29 03:37:56'),
(25, 1, '2025-07-29 03:38:01'),
(26, 1, '2025-07-29 03:38:06'),
(27, 1, '2025-07-29 03:38:11'),
(28, 1, '2025-07-29 03:38:16'),
(29, 1, '2025-07-29 03:38:21'),
(30, 1, '2025-07-29 03:38:26'),
(31, 1, '2025-07-29 03:38:31'),
(32, 1, '2025-07-29 03:38:36'),
(33, 1, '2025-07-29 03:38:41'),
(34, 1, '2025-07-29 03:38:46'),
(35, 2, '2025-07-29 03:40:06'),
(36, 2, '2025-07-29 03:40:12'),
(37, 2, '2025-07-29 03:40:16'),
(38, 2, '2025-07-29 03:40:21'),
(39, 2, '2025-07-29 03:40:26'),
(40, 2, '2025-07-29 03:40:31'),
(41, 2, '2025-07-29 03:40:36'),
(42, 2, '2025-07-29 03:40:41'),
(43, 2, '2025-07-29 03:40:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `peran` enum('admin','operator') NOT NULL DEFAULT 'operator',
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama_lengkap`, `username`, `password`, `peran`, `dibuat_pada`) VALUES
(1, 'Administrator', 'admin', '$2y$10$qg1ZYV7hVN3CdZMF/zuVIOCc7KuLpo3YZLuJ18LWhOaiBt.n58Br.', 'admin', '2025-07-29 10:31:01'),
(2, 'Budi Santoso', 'budi', '$2y$10$byAAVQoMD/Oz080GCSHfpuo65G/.D0XVG6ultyrz4RbIKCg1UiwqS', 'operator', '2025-07-29 10:31:01'),
(3, 'Siti Aminah', 'siti', '$2y$10$9FarHKOMqDeto5kZeT/OQeMR9g.WJm4Ir6cvanSkoVbv9CMviRSmy', 'operator', '2025-07-29 10:31:01'),
(4, 'Eko Prasetyo', 'eko', '$2y$10$8VlIflMEA8YwLHOrq2uOEeMlznDoH6X2eMUFuue8ULyI7T6HWz8hK', 'operator', '2025-07-29 10:31:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produksi`
--

CREATE TABLE `produksi` (
  `id` int(11) NOT NULL,
  `id_varian_roti` int(11) NOT NULL,
  `jumlah_target` int(11) NOT NULL,
  `jumlah_terdeteksi` int(11) NOT NULL DEFAULT 0,
  `id_pengguna_operator` int(11) NOT NULL,
  `waktu_mulai` timestamp NOT NULL DEFAULT current_timestamp(),
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `status` enum('Berjalan','Selesai') NOT NULL DEFAULT 'Berjalan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produksi`
--

INSERT INTO `produksi` (`id`, `id_varian_roti`, `jumlah_target`, `jumlah_terdeteksi`, `id_pengguna_operator`, `waktu_mulai`, `waktu_selesai`, `status`) VALUES
(1, 1, 250, 34, 2, '2025-07-29 10:35:52', '2025-07-29 03:38:49', 'Selesai'),
(2, 2, 20, 9, 2, '2025-07-29 10:40:06', '2025-07-29 03:40:49', 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `varian_roti`
--

CREATE TABLE `varian_roti` (
  `id` int(11) NOT NULL,
  `nama_varian` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `varian_roti`
--

INSERT INTO `varian_roti` (`id`, `nama_varian`) VALUES
(1, 'Roti Tawar Spesial'),
(2, 'Roti Sobek Coklat'),
(3, 'Roti Gandum'),
(4, 'Roti Keju Manis'),
(5, 'Roti Bule Aduhai');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `deteksi`
--
ALTER TABLE `deteksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produksi` (`id_produksi`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `produksi`
--
ALTER TABLE `produksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna_operator` (`id_pengguna_operator`),
  ADD KEY `id_varian_roti` (`id_varian_roti`);

--
-- Indeks untuk tabel `varian_roti`
--
ALTER TABLE `varian_roti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `deteksi`
--
ALTER TABLE `deteksi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `produksi`
--
ALTER TABLE `produksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `varian_roti`
--
ALTER TABLE `varian_roti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `deteksi`
--
ALTER TABLE `deteksi`
  ADD CONSTRAINT `fk_deteksi_produksi` FOREIGN KEY (`id_produksi`) REFERENCES `produksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produksi`
--
ALTER TABLE `produksi`
  ADD CONSTRAINT `fk_produksi_pengguna` FOREIGN KEY (`id_pengguna_operator`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_produksi_varian` FOREIGN KEY (`id_varian_roti`) REFERENCES `varian_roti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
