-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Jun 2026 pada 03.19
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
-- Database: `db_arsip_samsat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen`
--

CREATE TABLE `dokumen` (
  `id_dokumen` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `jenis_dokumen` enum('STNK','Lainnya') NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `tanggal_upload` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dokumen`
--

INSERT INTO `dokumen` (`id_dokumen`, `id_pembayaran`, `jenis_dokumen`, `nama_file`, `tanggal_upload`) VALUES
(13, 8, 'STNK', 'STNK_BP 1234 UA_AhmadFauzi_20260614161059.jpeg', '2026-01-15 09:15:00'),
(14, 9, 'STNK', 'STNK_BP 2345 UB_BudiSantoso_20260614161222.jpeg', '2026-01-18 10:22:00'),
(15, 10, 'STNK', 'STNK_BP 3456 UC_DwiSaputra_20260614162023.jpeg', '2026-01-20 08:45:00'),
(16, 11, 'STNK', 'STNK_BP 4567 UD_EkaPutri_20260614162606.jpeg', '2026-01-22 11:10:00'),
(17, 12, 'STNK', 'STNK_BP 5678 UE_FajarHidayat_20260614162747.jpeg', '2026-01-25 13:25:00'),
(18, 13, 'STNK', 'STNK_BP 6789 UF_IndahPermata_20260614163006.jpeg', '2026-02-01 09:05:00'),
(19, 14, 'STNK', 'STNK_BP 7890 UG_JokoPrasetyo_20260614163214.jpeg', '2026-02-03 14:30:00'),
(20, 15, 'STNK', 'STNK_BP 8901 UH_LinaMarlina_20260614163513.jpeg', '2026-02-05 10:40:00'),
(21, 16, 'STNK', 'STNK_BP 9012 UI_MuhammadRizki_20260614163739.jpeg', '2026-02-08 15:12:00'),
(22, 17, 'STNK', 'STNK_BP 1123 UJ_NandaPratama_20260614163847.jpeg', '2026-02-10 08:20:00'),
(23, 18, 'STNK', 'STNK_BP 2234 UK_PutriAyuningtyas_20260614164023.jpeg', '2026-02-12 09:55:00'),
(24, 19, 'STNK', 'STNK_BP 3345 UL_RahmatHidayat_20260614164114.jpeg', '2026-02-15 11:35:00'),
(25, 20, 'STNK', 'STNK_BP 4456 UM_SitiRahma_20260614164216.jpeg', '2026-02-18 14:05:00'),
(26, 21, 'STNK', 'STNK_BP 5567 UN_TaufikAkbar_20260614164305.jpeg', '2026-02-20 16:18:00'),
(27, 22, 'STNK', 'STNK_BP 6678 UO_VinaAnggraini_20260614164353.jpeg', '2026-02-22 10:15:00'),
(28, 23, 'Lainnya', 'Bukti Pembayaran_BP 7789 UP_WawanSetiawan_20260614164510.jpeg', '2026-03-01 13:40:00'),
(29, 24, 'Lainnya', 'BPKB_BP 8890 UQ_YuniKartika_20260614165406.jpeg', '2026-03-05 09:30:00'),
(30, 25, 'Lainnya', 'Berkas Verifikasi_BP 9901 UR_ZulfikarRamadhan_20260614165609.jpeg', '2026-03-08 15:45:00'),
(31, 26, 'Lainnya', 'Form Permohonan_BP 1012 US_RinaOktaviani_20260614165714.jpeg', '2026-03-10 11:20:00'),
(32, 27, 'Lainnya', 'KTP_BP 2123 UT_AgusSetiawan_20260614165853.jpeg', '3036-03-12 14:50:00'),
(34, 30, 'STNK', 'STNK_BP 3049 WF_fernandowilly_20260615100255.jpeg', '2026-06-15 15:02:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `id_wajib_pajak` int(11) NOT NULL,
  `no_polisi` varchar(15) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `status` enum('Aktif','Rusak','Dijual') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kendaraan`
--

INSERT INTO `kendaraan` (`id_kendaraan`, `id_wajib_pajak`, `no_polisi`, `merk`, `tipe`, `tahun`, `status`) VALUES
(9, 11, 'BP 1234 UA', 'Honda', 'BeAT CBS', '2021', 'Aktif'),
(10, 13, 'BP 2345 UB', 'Yamaha', 'NMAX 155', '2023', 'Aktif'),
(11, 15, 'BP 3456 UC', 'Honda', 'Vario 160', '2022', 'Aktif'),
(12, 17, 'BP 4567 UD', 'Toyota', 'Avanza G', '2020', 'Aktif'),
(13, 19, 'BP 5678 UE', 'Daihatsu', 'Xenia R', '2019', 'Aktif'),
(14, 21, 'BP 6789 UF', 'Honda', 'Scoopy Sporty', '2024', 'Aktif'),
(15, 23, 'BP 7890 UG', 'Suzuki', 'Ertiga GL', '2021', 'Aktif'),
(16, 25, 'BP 8901 UH', 'Honda', 'Brio Satya', '2023', 'Aktif'),
(17, 27, 'BP 9012 UI', 'Yamaha', 'Aerox 155', '2022', 'Aktif'),
(18, 29, 'BP 1123 UJ', 'Mitsubishi', 'Xpander Exceed', '2021', 'Aktif'),
(19, 30, 'BP 2234 UK', 'Honda', 'PCX 160', '2024', 'Aktif'),
(20, 28, 'BP 3345 UL', 'Toyota', 'Rush GR Sport', '2023', 'Aktif'),
(21, 26, 'BP 4456 UM', 'Yamaha', 'Mio M3', '2020', 'Aktif'),
(22, 24, 'BP 5567 UN', 'Honda', 'CRF 150L', '2022', 'Aktif'),
(23, 22, 'BP 6678 UO', 'Daihatsu', 'Sigra R', '2021', 'Aktif'),
(24, 20, 'BP 7789 UP', 'Suzuki', 'Carry Pick Up', '2018', 'Dijual'),
(25, 18, 'BP 8890 UQ', 'Toyota', 'Calya G', '2019', 'Dijual'),
(26, 16, 'BP 9901 UR', 'Honda', 'Supra X 125', '2017', 'Dijual'),
(27, 14, 'BP 1012 US', 'Yamaha', 'Jupiter Z1', '2016', 'Rusak'),
(28, 12, 'BP 2123 UT', 'Suzuki', 'Satria F150', '2018', 'Rusak'),
(31, 36, 'BP 3049 WF', 'Honda', 'BeAT 125', '2023', 'Dijual'),
(32, 37, 'BP 1111 JR', 'YAMAHA', 'X RIDE 125', '2025', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `jenis_pembayaran` enum('QRIS','Transfer','Tunai') NOT NULL,
  `total_bayar` decimal(12,2) NOT NULL,
  `status_pembayaran` enum('Lunas','Menunggak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_kendaraan`, `tanggal_bayar`, `jenis_pembayaran`, `total_bayar`, `status_pembayaran`) VALUES
(8, 9, '2026-01-15', 'QRIS', 350000.00, 'Lunas'),
(9, 10, '2026-01-18', 'Transfer', 420000.00, 'Lunas'),
(10, 11, '2026-01-20', 'Tunai', 385000.00, 'Lunas'),
(11, 12, '2026-01-22', 'Transfer', 1800000.00, 'Lunas'),
(12, 13, '2026-01-25', 'QRIS', 1750000.00, 'Lunas'),
(13, 14, '2026-02-01', 'Tunai', 360000.00, 'Lunas'),
(14, 15, '2026-02-03', 'Transfer', 1950000.00, 'Lunas'),
(15, 16, '2026-02-05', 'QRIS', 1450000.00, 'Lunas'),
(16, 17, '2026-02-08', 'QRIS', 450000.00, 'Lunas'),
(17, 18, '2026-02-10', 'Transfer', 2100000.00, 'Lunas'),
(18, 19, '2026-02-12', 'Tunai', 520000.00, 'Lunas'),
(19, 20, '2026-02-15', 'QRIS', 2300000.00, 'Lunas'),
(20, 21, '2026-02-18', 'Transfer', 310000.00, 'Lunas'),
(21, 22, '2026-02-20', 'Tunai', 470000.00, 'Lunas'),
(22, 23, '2026-02-22', 'QRIS', 1350000.00, 'Lunas'),
(23, 24, '2026-03-01', 'Transfer', 950000.00, 'Menunggak'),
(24, 25, '2026-03-05', 'Tunai', 1200000.00, 'Menunggak'),
(25, 26, '2026-03-08', 'QRIS', 275000.00, 'Menunggak'),
(26, 27, '2026-03-10', 'Transfer', 250000.00, 'Menunggak'),
(27, 28, '2026-03-12', 'Tunai', 32500.00, 'Menunggak'),
(29, 31, '2026-06-15', 'Transfer', 300000.00, 'Lunas'),
(31, 32, '2026-06-17', 'Transfer', 250000.00, 'Lunas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Rifky Anwar', 'admin', 'admin123', 'admin'),
(3, 'Mohammad Robby', 'user1', '1user', ''),
(4, 'Rahayu Putri', 'user2', '2user', ''),
(6, 'Dwi Angeline', 'user3', '3user', ''),
(8, 'Willy Fernando', 'test user', 'willy1', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wajib_pajak`
--

CREATE TABLE `wajib_pajak` (
  `id_wajib_pajak` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_ktp` varchar(16) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `wajib_pajak`
--

INSERT INTO `wajib_pajak` (`id_wajib_pajak`, `nama`, `no_ktp`, `alamat`, `no_hp`) VALUES
(11, 'Ahmad Fauzi', '2171121501900001', 'Perumahan Cipta Asri Blok A1 No. 12, Batam', '081234567801'),
(12, 'Agus Setiawan', '2171121603860020', 'Perumahan Griya Batu Aji Indah Blok B5 No. 13', '081234567820'),
(13, 'Budi Santoso', '2171122202880002', 'Kavling Lama, Batu Aji, Batam', '081234567802'),
(14, 'Rina Oktaviani', '2171120810970019', 'Kavling Tanjung Uncang RT 05 RW 02, Batam', '081234567819'),
(15, 'Dwi Saputra', '2171121103910003', 'Taman Lestari Indah Blok C3 No. 7, Batam', '081234567803'),
(16, 'Zulfikar Ramadhan', '2171122401930018', 'Perumahan Green Garden Residence Blok A7 No. 17', '081234567818'),
(17, 'Eka Putri', '2171120407950004', 'Perumahan Marina Residence Blok B2 No. 15, Batam', '081234567804'),
(18, 'Yuni Kartika', '2171121109020017', 'Kavling Bukit Kemuning RT 01 RW 04, Batam', '081234567817'),
(19, 'Fajar Hidayat', '2171120407950004', 'Perumahan Marina Residence Blok B2 No. 15, Batam', '081234567804'),
(20, 'Wawan Setiawan', '2171121804870016', 'Perumahan Cipta Asri Blok F3 No. 8', '081234567816'),
(21, 'Indah Permata', '2171121208990006', 'Perumahan Taman Cipta Asri Blok D4 No. 21, Batam', '081234567806'),
(22, 'Vina Anggraini', '2171122704010015', 'Kavling Kamboja Batu Aji, Batam', '081234567815'),
(23, 'Joko Prasetyo', '2171122503850007', 'Kavling Bukit Indah Sukajadi, Batam', '081234567807'),
(24, 'Taufik Akbar', '2171120512890014', 'Perumahan Taman Raya Tahap III Blok C2 No. 11', '081234567814'),
(25, 'Lina Marlina', '2171120809970008', 'Perumahan Griya Batu Aji Permai Blok A5 No. 9', '081234567808'),
(26, 'Siti Rahma ', '2171122103000013', 'Kavling Bukit Senyum RT 02 RW 03, Batam', '081234567813'),
(27, 'Muhammad Rizki', '2171121701940009', 'Kavling Lama Tahap II, Batu Aji, Batam', '081234567809'),
(28, 'Rahmat Hidayat', '2171123006910012', 'Perumahan Cipta Garden Blok B1 No. 6', '081234567812'),
(29, 'Nanda Pratama', '2171121405960010', 'Perumahan Putra Jaya Residence Blok E2 No. 14', '081234567810'),
(30, 'Putri Ayuningtyas', '2171120907980011', 'Kavling Sei Temiang RT 04 RW 01, Batam', '081234567811'),
(35, 'Willy Fernando', '3452223334445556', 'Sungai Panas, Batam Kota', '085244611234'),
(36, 'fernando willy', '1112223334412345', 'Sungai Panas, Batam Kota, Kota Batam', '085244612345'),
(37, 'Febriadi', '1111111111111111', 'batu aji batam', '000000000000'),
(38, 'Rifky Anwar', '2171101809030001', 'Perumahan Bunga Raya Blok H No 14', '081270264105');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`id_dokumen`);

--
-- Indeks untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `wajib_pajak`
--
ALTER TABLE `wajib_pajak`
  ADD PRIMARY KEY (`id_wajib_pajak`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `id_dokumen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `wajib_pajak`
--
ALTER TABLE `wajib_pajak`
  MODIFY `id_wajib_pajak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
