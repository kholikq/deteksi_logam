-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jul 2025 pada 09.41
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
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Aman','Logam Terdeteksi') NOT NULL,
  `varian_roti` varchar(100) NOT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `id_pengguna_operator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Administrator', 'admin', '$2y$10$pJTifL96esflwziWqL4/jeWvnU96ojsiTIj5aGzg0w7CDEUKkVh/C', 'admin', '2025-07-09 07:23:21'),
(2, 'Kholik', 'kholikq@gmail.com', '$2y$10$lfW3tbMPB4L4iLLL.KWtzupou3s6igtlgnanG7T8luT1TQ76xwHc.', 'operator', '2025-07-09 07:28:40');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `deteksi`
--
ALTER TABLE `deteksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna_operator` (`id_pengguna_operator`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `deteksi`
--
ALTER TABLE `deteksi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `deteksi`
--
ALTER TABLE `deteksi`
  ADD CONSTRAINT `fk_pengguna_operator` FOREIGN KEY (`id_pengguna_operator`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
