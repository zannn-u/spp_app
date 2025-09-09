-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2025 at 05:04 PM
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
-- Database: db_spp
--

-- --------------------------------------------------------

--
-- Table structure for table kelas
--

CREATE TABLE kelas (
  id_kelas int(11) NOT NULL,
  nama_kelas varchar(10) DEFAULT NULL,
  kompetensi_keahlian varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table kelas
--

INSERT INTO kelas (id_kelas, nama_kelas, kompetensi_keahlian) VALUES
(1, 'XI RPL 1', 'Rekayasa Perangkat Lunak'),
(2, 'XI TKJ 1', 'Teknik Komputer dan Jaringan'),
(3, 'XI MM 1', 'Multimedia'),
(4, 'XI APH', 'Perhotelan');

-- --------------------------------------------------------

--
-- Table structure for table pembayaran
--

CREATE TABLE pembayaran (
  id_pembayaran int(11) NOT NULL,
  id_petugas int(11) DEFAULT NULL,
  nisn char(10) DEFAULT NULL,
  tgl_bayar date DEFAULT NULL,
  bulan_dibayar varchar(8) DEFAULT NULL,
  tahun_dibayar varchar(4) DEFAULT NULL,
  id_spp int(11) DEFAULT NULL,
  jumlah_bayar int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table pembayaran
--

INSERT INTO pembayaran (id_pembayaran, id_petugas, nisn, tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar) VALUES
(9, 4, '1234567891', '2025-08-05', 'Agustus', '2025', 2, 600000),
(10, 3, '1234567892', '2025-08-10', 'Agustus', '2025', 1, 500000),
(11, 4, '1234567890', '2025-09-02', 'Septembe', '2025', 1, 500000),
(12, 3, '1234567891', '2025-09-03', 'Septembe', '2025', 2, 600000),
(14, 8, '1234567893', '2025-08-28', 'Agustus', '2025', 3, 100000),
(15, 9, '1234567899', '2025-09-12', 'Oktober', '2025', 3, 150000),
(16, 8, '1234567899', '2025-09-05', 'Septembe', '2025', 3, 90000);

-- --------------------------------------------------------

--
-- Table structure for table petugas
--

CREATE TABLE petugas (
  id_petugas int(11) NOT NULL,
  username varchar(25) DEFAULT NULL,
  password varchar(255) DEFAULT NULL,
  nama_petugas varchar(35) DEFAULT NULL,
  level enum('admin','petugas') DEFAULT NULL,
  aktif tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table petugas
--

INSERT INTO petugas (id_petugas, username, password, nama_petugas, level, aktif) VALUES
(3, 'petugas1', '$2y$10$HhLPu4cYjEjZk0HxS47vO.dThJQQFf2OcjNimoxh3dFIfMndy4TkS', 'Budi Santoso', 'petugas', 0),
(4, 'petugas2', '$2y$10$HhLPu4cYjEjZk0HxS47vO.dThJQQFf2OcjNimoxh3dFIfMndy4TkS', 'Siti Aminah', 'petugas', 0),
(5, 'admin', '$2y$10$EixZaYVK1fsbw1ZfbX3OXePaWxn96p36pY4A6d6mYjFJ9XcM6UfOa', 'Administrator', 'admin', 0),
(6, 'admin', '$2y$10$hDYAsVfBeHsLapqHZQjDvuVs6YUsvSwMc3lYhdyhy7SidnzbFKs5y', 'Administrator', 'admin', 0),
(7, 'ojantzyy', '$2y$10$ajBaIYkl7eKYExDuunx42.nNTlobMHEUdF.yciCiNR9LLHempHfoG', 'oojan', 'admin', 0),
(8, 'zannn', '$2y$10$g8L.eOapcs2EfVUFGwOPHu7Args0ukl.NQ7GfBhe4AKePNkizSd0.', 'OJAN', 'admin', 1),
(9, 'saya', '$2y$10$jQLcpTnplLz86kWX8AlcnOMoajTea5LJEeaSRRhTIZYt1s6kcAX1y', 'Ligma', 'petugas', 1);

-- --------------------------------------------------------

--
-- Table structure for table siswa
--

CREATE TABLE siswa (
  nisn char(10) NOT NULL,
  nis char(8) DEFAULT NULL,
  nama varchar(35) DEFAULT NULL,
  id_kelas int(11) DEFAULT NULL,
  alamat text DEFAULT NULL,
  no_telp varchar(13) DEFAULT NULL,
  id_spp int(11) DEFAULT NULL,
  password varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table siswa
--

INSERT INTO siswa (nisn, nis, nama, id_kelas, alamat, no_telp, id_spp, password) VALUES
('1234567890', '20240001', 'Fauzan Al Bani', 1, 'Jl. Pondok Cabe No. 1', '081234567890', 1, ''),
('1234567891', '20240002', 'Siti Aminah', 2, 'Jl. Merpati No. 2', '081234567891', 2, ''),
('1234567892', '20240003', 'Budi Santoso', 3, 'Jl. Anggrek No. 3', '081234567892', 1, ''),
('1234567893', '20240004', 'ojane', 1, 'Jl. Ngawi No. 2', '089587646758', 2, ''),
('1234567899', '45435437', 'sigma', 2, 'Jl. Ngawi No. 4', '089587646750', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table spp
--

CREATE TABLE spp (
  id_spp int(11) NOT NULL,
  tahun int(11) DEFAULT NULL,
  nominal int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table spp
--

INSERT INTO spp (id_spp, tahun, nominal) VALUES
(1, 2024, 500000),
(2, 2025, 600000),
(3, 2025, 100000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table kelas
--
ALTER TABLE kelas
  ADD PRIMARY KEY (id_kelas);

--
-- Indexes for table pembayaran
--
ALTER TABLE pembayaran
  ADD PRIMARY KEY (id_pembayaran),
  ADD KEY id_petugas (id_petugas),
  ADD KEY nisn (nisn),
  ADD KEY id_spp (id_spp);

--
-- Indexes for table petugas
--
ALTER TABLE petugas
  ADD PRIMARY KEY (id_petugas);

--
-- Indexes for table siswa
--
ALTER TABLE siswa
  ADD PRIMARY KEY (nisn),
  ADD KEY id_kelas (id_kelas),
  ADD KEY id_spp (id_spp);

--
-- Indexes for table spp
--
ALTER TABLE spp
  ADD PRIMARY KEY (id_spp);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table kelas
--
ALTER TABLE kelas
  MODIFY id_kelas int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table pembayaran
--
ALTER TABLE pembayaran
  MODIFY id_pembayaran int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table petugas
--
ALTER TABLE petugas
  MODIFY id_petugas int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table spp
--
ALTER TABLE spp
  MODIFY id_spp int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table pembayaran
--
ALTER TABLE pembayaran
  ADD CONSTRAINT pembayaran_ibfk_1 FOREIGN KEY (id_petugas) REFERENCES petugas (id_petugas),
  ADD CONSTRAINT pembayaran_ibfk_2 FOREIGN KEY (nisn) REFERENCES siswa (nisn),
  ADD CONSTRAINT pembayaran_ibfk_3 FOREIGN KEY (id_spp) REFERENCES spp (id_spp);

--
-- Constraints for table siswa
--
ALTER TABLE siswa
  ADD CONSTRAINT siswa_ibfk_1 FOREIGN KEY (id_kelas) REFERENCES kelas (id_kelas),
  ADD CONSTRAINT siswa_ibfk_2 FOREIGN KEY (id_spp) REFERENCES spp (id_spp);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Penambahan Kolom keterangan di tabel siswa
--
ALTER TABLE siswa ADD keterangan VARCHAR(50) NOT NULL DEFAULT 'Belum Lunas';

-- --------------------------------------------------------
-- Stored Procedure for inserting pembayaran (dengan validasi)
-- --------------------------------------------------------
DELIMITER //
DROP PROCEDURE IF EXISTS tambah_pembayaran//
CREATE PROCEDURE tambah_pembayaran(
    IN p_id_petugas INT,
    IN p_nisn CHAR(10),
    IN p_tgl_bayar DATE,
    IN p_bulan_dibayar VARCHAR(10),
    IN p_tahun_dibayar VARCHAR(4),
    IN p_id_spp INT,
    IN p_jumlah_bayar INT,
    OUT p_pesan VARCHAR(255)
)
BEGIN
    DECLARE v_petugas_exists INT;
    DECLARE v_siswa_exists INT;
    DECLARE v_spp_exists INT;
    DECLARE v_pembayaran_exists INT;

    -- Validasi ID Petugas
    SELECT COUNT(*) INTO v_petugas_exists FROM petugas WHERE id_petugas = p_id_petugas;
    IF v_petugas_exists = 0 THEN
        SET p_pesan = 'Error: ID Petugas tidak ditemukan.';
        LEAVE LABEL_AKHIR;
    END IF;

    -- Validasi NISN Siswa
    SELECT COUNT(*) INTO v_siswa_exists FROM siswa WHERE nisn = p_nisn;
    IF v_siswa_exists = 0 THEN
        SET p_pesan = 'Error: NISN Siswa tidak ditemukan.';
        LEAVE LABEL_AKHIR;
    END IF;
    
    -- Validasi ID SPP
    SELECT COUNT(*) INTO v_spp_exists FROM spp WHERE id_spp = p_id_spp;
    IF v_spp_exists = 0 THEN
        SET p_pesan = 'Error: ID SPP tidak ditemukan.';
        LEAVE LABEL_AKHIR;
    END IF;

    -- Cek duplikasi pembayaran (bulan dan tahun untuk NISN yang sama)
    SELECT COUNT(*) INTO v_pembayaran_exists
    FROM pembayaran
    WHERE nisn = p_nisn AND bulan_dibayar = p_bulan_dibayar AND tahun_dibayar = p_tahun_dibayar;

    IF v_pembayaran_exists > 0 THEN
        SET p_pesan = 'Error: Pembayaran untuk bulan dan tahun ini sudah ada.';
        LEAVE LABEL_AKHIR;
    END IF;
    
    -- Jika semua validasi lolos, lakukan INSERT
    INSERT INTO pembayaran (id_petugas, nisn, tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar)
    VALUES (p_id_petugas, p_nisn, p_tgl_bayar, p_bulan_dibayar, p_tahun_dibayar, p_id_spp, p_jumlah_bayar);

    SET p_pesan = 'Success: Pembayaran berhasil ditambahkan.';

    LABEL_AKHIR:;
END //
DELIMITER ;


-- --------------------------------------------------------
-- Triggers for updating siswa status after payment changes
-- --------------------------------------------------------
DELIMITER //

DROP TRIGGER IF EXISTS after_insert_pembayaran//
CREATE TRIGGER after_insert_pembayaran
AFTER INSERT ON pembayaran
FOR EACH ROW
BEGIN
    DECLARE total_bayar_siswa INT;
    DECLARE nominal_spp INT;

    SELECT nominal INTO nominal_spp
    FROM spp
    WHERE id_spp = NEW.id_spp;
    
    SELECT SUM(jumlah_bayar) INTO total_bayar_siswa
    FROM pembayaran
    WHERE nisn = NEW.nisn AND tahun_dibayar = NEW.tahun_dibayar;

    IF total_bayar_siswa >= nominal_spp THEN
        UPDATE siswa SET keterangan = CONCAT('Lunas ', NEW.tahun_dibayar) WHERE nisn = NEW.nisn;
    ELSE
        UPDATE siswa SET keterangan = CONCAT('Belum Lunas ', NEW.tahun_dibayar) WHERE nisn = NEW.nisn;
    END IF;
END //

DROP TRIGGER IF EXISTS after_update_pembayaran//
CREATE TRIGGER after_update_pembayaran
AFTER UPDATE ON pembayaran
FOR EACH ROW
BEGIN
    DECLARE total_bayar_siswa INT;
    DECLARE nominal_spp INT;

    -- Update untuk data baru
    SELECT nominal INTO nominal_spp FROM spp WHERE id_spp = NEW.id_spp;
    SELECT SUM(jumlah_bayar) INTO total_bayar_siswa FROM pembayaran WHERE nisn = NEW.nisn AND tahun_dibayar = NEW.tahun_dibayar;
    IF total_bayar_siswa >= nominal_spp THEN
        UPDATE siswa SET keterangan = CONCAT('Lunas ', NEW.tahun_dibayar) WHERE nisn = NEW.nisn;
    ELSE
        UPDATE siswa SET keterangan = CONCAT('Belum Lunas ', NEW.tahun_dibayar) WHERE nisn = NEW.nisn;
    END IF;

    -- Update untuk data lama jika NISN atau tahun berubah
    IF OLD.nisn <> NEW.nisn OR OLD.tahun_dibayar <> NEW.tahun_dibayar THEN
        SELECT nominal INTO nominal_spp FROM spp WHERE id_spp = OLD.id_spp;
        SELECT SUM(jumlah_bayar) INTO total_bayar_siswa FROM pembayaran WHERE nisn = OLD.nisn AND tahun_dibayar = OLD.tahun_dibayar;
        IF total_bayar_siswa >= nominal_spp THEN
            UPDATE siswa SET keterangan = CONCAT('Lunas ', OLD.tahun_dibayar) WHERE nisn = OLD.nisn;
        ELSE
            UPDATE siswa SET keterangan = CONCAT('Belum Lunas ', OLD.tahun_dibayar) WHERE nisn = OLD.nisn;
        END IF;
    END IF;
END //

DROP TRIGGER IF EXISTS after_delete_pembayaran//
CREATE TRIGGER after_delete_pembayaran
AFTER DELETE ON pembayaran
FOR EACH ROW
BEGIN
    DECLARE total_bayar_siswa INT;
    DECLARE nominal_spp INT;

    SELECT nominal INTO nominal_spp FROM spp WHERE id_spp = OLD.id_spp;
    SELECT SUM(jumlah_bayar) INTO total_bayar_siswa FROM pembayaran WHERE nisn = OLD.nisn AND tahun_dibayar = OLD.tahun_dibayar;
    
    IF total_bayar_siswa >= nominal_spp THEN
        UPDATE siswa SET keterangan = CONCAT('Lunas ', OLD.tahun_dibayar) WHERE nisn = OLD.nisn;
    ELSE
        UPDATE siswa SET keterangan = CONCAT('Belum Lunas ', OLD.tahun_dibayar) WHERE nisn = OLD.nisn;
    END IF;
END //
DELIMITER ;