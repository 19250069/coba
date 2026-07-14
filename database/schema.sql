-- ============================================================
--  DATABASE: db_apotek
--  Sistem Pemesanan Apotek (PHP Native)
--  Dibuat lengkap beserta Foreign Key & Data Dummy
-- ============================================================

CREATE DATABASE IF NOT EXISTS db_apotek
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;
USE db_apotek;

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
--  TABEL: users
-- ============================================================
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id_user    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  nama       VARCHAR(100) NOT NULL,
  email      VARCHAR(100) NOT NULL,
  password   VARCHAR(255) NOT NULL,
  no_hp      VARCHAR(20)  DEFAULT NULL,
  alamat     TEXT         DEFAULT NULL,
  role       ENUM('admin','customer') NOT NULL DEFAULT 'customer',
  created_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_user),
  UNIQUE KEY unik_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL: kategori_obat
-- ============================================================
DROP TABLE IF EXISTS kategori_obat;
CREATE TABLE kategori_obat (
  id_kategori   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_kategori VARCHAR(100) NOT NULL,
  deskripsi     TEXT DEFAULT NULL,
  PRIMARY KEY (id_kategori)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL: supplier
-- ============================================================
DROP TABLE IF EXISTS supplier;
CREATE TABLE supplier (
  id_supplier    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_supplier  VARCHAR(100) NOT NULL,
  alamat         TEXT DEFAULT NULL,
  no_hp          VARCHAR(20) DEFAULT NULL,
  email          VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (id_supplier)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL: obat
-- ============================================================
DROP TABLE IF EXISTS obat;
CREATE TABLE obat (
  id_obat        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  kode_obat      VARCHAR(20) NOT NULL,
  nama_obat      VARCHAR(150) NOT NULL,
  id_kategori    INT(11) UNSIGNED DEFAULT NULL,
  id_supplier    INT(11) UNSIGNED DEFAULT NULL,
  harga          DECIMAL(12,2) NOT NULL DEFAULT 0,
  stok           INT(11) NOT NULL DEFAULT 0,
  deskripsi      TEXT DEFAULT NULL,
  gambar         VARCHAR(255) DEFAULT NULL,
  tanggal_expired DATE DEFAULT NULL,
  created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_obat),
  UNIQUE KEY unik_kode_obat (kode_obat),
  KEY fk_obat_kategori (id_kategori),
  KEY fk_obat_supplier (id_supplier),
  CONSTRAINT fk_obat_kategori FOREIGN KEY (id_kategori) REFERENCES kategori_obat (id_kategori)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT fk_obat_supplier FOREIGN KEY (id_supplier) REFERENCES supplier (id_supplier)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL: keranjang
-- ============================================================
DROP TABLE IF EXISTS keranjang;
CREATE TABLE keranjang (
  id_keranjang INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_user      INT(11) UNSIGNED NOT NULL,
  id_obat      INT(11) UNSIGNED NOT NULL,
  jumlah       INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (id_keranjang),
  KEY fk_keranjang_user (id_user),
  KEY fk_keranjang_obat (id_obat),
  CONSTRAINT fk_keranjang_user FOREIGN KEY (id_user) REFERENCES users (id_user)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_keranjang_obat FOREIGN KEY (id_obat) REFERENCES obat (id_obat)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL: pesanan
-- ============================================================
DROP TABLE IF EXISTS pesanan;
CREATE TABLE pesanan (
  id_pesanan    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  kode_pesanan  VARCHAR(30) NOT NULL,
  id_user       INT(11) UNSIGNED NOT NULL,
  tanggal       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  total         DECIMAL(12,2) NOT NULL DEFAULT 0,
  status        ENUM('Menunggu Pembayaran','Diproses','Dikirim','Selesai','Dibatalkan') NOT NULL DEFAULT 'Menunggu Pembayaran',
  PRIMARY KEY (id_pesanan),
  UNIQUE KEY unik_kode_pesanan (kode_pesanan),
  KEY fk_pesanan_user (id_user),
  CONSTRAINT fk_pesanan_user FOREIGN KEY (id_user) REFERENCES users (id_user)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL: detail_pesanan
-- ============================================================
DROP TABLE IF EXISTS detail_pesanan;
CREATE TABLE detail_pesanan (
  id_detail  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_pesanan INT(11) UNSIGNED NOT NULL,
  id_obat    INT(11) UNSIGNED NOT NULL,
  harga      DECIMAL(12,2) NOT NULL DEFAULT 0,
  jumlah     INT(11) NOT NULL DEFAULT 1,
  subtotal   DECIMAL(12,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (id_detail),
  KEY fk_detail_pesanan (id_pesanan),
  KEY fk_detail_obat (id_obat),
  CONSTRAINT fk_detail_pesanan FOREIGN KEY (id_pesanan) REFERENCES pesanan (id_pesanan)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_detail_obat FOREIGN KEY (id_obat) REFERENCES obat (id_obat)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL: metode_pembayaran
-- ============================================================
DROP TABLE IF EXISTS metode_pembayaran;
CREATE TABLE metode_pembayaran (
  id_metode    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_metode  VARCHAR(100) NOT NULL,
  tipe         ENUM('bank','ewallet') NOT NULL DEFAULT 'bank',
  nomor        VARCHAR(50) NOT NULL,
  pemilik      VARCHAR(150) NOT NULL,
  aktif        TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id_metode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL: pembayaran
-- ============================================================
DROP TABLE IF EXISTS pembayaran;
CREATE TABLE pembayaran (
  id_pembayaran  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_pesanan     INT(11) UNSIGNED NOT NULL,
  id_metode      INT(11) UNSIGNED DEFAULT NULL,
  metode         VARCHAR(50) DEFAULT NULL,
  bukti_transfer VARCHAR(255) DEFAULT NULL,
  tanggal_bayar  DATETIME DEFAULT NULL,
  status         ENUM('Menunggu','Lunas','Ditolak') NOT NULL DEFAULT 'Menunggu',
  PRIMARY KEY (id_pembayaran),
  KEY fk_pembayaran_pesanan (id_pesanan),
  KEY fk_pembayaran_metode (id_metode),
  CONSTRAINT fk_pembayaran_pesanan FOREIGN KEY (id_pesanan) REFERENCES pesanan (id_pesanan)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_pembayaran_metode FOREIGN KEY (id_metode) REFERENCES metode_pembayaran (id_metode)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL: pengiriman
-- ============================================================
DROP TABLE IF EXISTS pengiriman;
CREATE TABLE pengiriman (
  id_pengiriman INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_pesanan    INT(11) UNSIGNED NOT NULL,
  ekspedisi     VARCHAR(50) DEFAULT NULL,
  nomor_resi    VARCHAR(50) DEFAULT NULL,
  status        ENUM('Dikemas','Dikirim','Diterima','Gagal') NOT NULL DEFAULT 'Dikemas',
  PRIMARY KEY (id_pengiriman),
  KEY fk_pengiriman_pesanan (id_pesanan),
  CONSTRAINT fk_pengiriman_pesanan FOREIGN KEY (id_pesanan) REFERENCES pesanan (id_pesanan)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL: review
-- ============================================================
DROP TABLE IF EXISTS review;
CREATE TABLE review (
  id_review  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_user    INT(11) UNSIGNED NOT NULL,
  id_obat    INT(11) UNSIGNED NOT NULL,
  rating     TINYINT(1) NOT NULL DEFAULT 5,
  komentar   TEXT DEFAULT NULL,
  tanggal    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_review),
  KEY fk_review_user (id_user),
  KEY fk_review_obat (id_obat),
  CONSTRAINT fk_review_user FOREIGN KEY (id_user) REFERENCES users (id_user)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_review_obat FOREIGN KEY (id_obat) REFERENCES obat (id_obat)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL: notifikasi
-- ============================================================
DROP TABLE IF EXISTS notifikasi;
CREATE TABLE notifikasi (
  id_notifikasi INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_user       INT(11) UNSIGNED NOT NULL,
  judul         VARCHAR(150) NOT NULL,
  isi           TEXT DEFAULT NULL,
  status        ENUM('belum dibaca','dibaca') NOT NULL DEFAULT 'belum dibaca',
  created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_notifikasi),
  KEY fk_notifikasi_user (id_user),
  CONSTRAINT fk_notifikasi_user FOREIGN KEY (id_user) REFERENCES users (id_user)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  TABEL KLINIK (MediKita)
-- ============================================================

-- ---------------- KOTA -------------------------------------
DROP TABLE IF EXISTS kota;
CREATE TABLE kota (
  id_kota      INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_kota    VARCHAR(100) NOT NULL,
  PRIMARY KEY (id_kota)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------- SPESIALIS ---------------------------------
DROP TABLE IF EXISTS spesialis;
CREATE TABLE spesialis (
  id_spesialis    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_spesialis  VARCHAR(100) NOT NULL,
  deskripsi       TEXT DEFAULT NULL,
  PRIMARY KEY (id_spesialis)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------- KLINIK ------------------------------------
DROP TABLE IF EXISTS klinik;
CREATE TABLE klinik (
  id_klinik   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_kota     INT(11) UNSIGNED NOT NULL,
  nama_klinik VARCHAR(150) NOT NULL,
  alamat      TEXT DEFAULT NULL,
  no_telp     VARCHAR(20) DEFAULT NULL,
  email       VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (id_klinik),
  KEY fk_klinik_kota (id_kota),
  CONSTRAINT fk_klinik_kota FOREIGN KEY (id_kota) REFERENCES kota (id_kota)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------- DOKTER ------------------------------------
DROP TABLE IF EXISTS dokter;
CREATE TABLE dokter (
  id_dokter         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_spesialis      INT(11) UNSIGNED NOT NULL,
  nama_dokter       VARCHAR(150) NOT NULL,
  gender            ENUM('Laki-laki','Perempuan') NOT NULL DEFAULT 'Laki-laki',
  no_hp             VARCHAR(20) DEFAULT NULL,
  email             VARCHAR(100) DEFAULT NULL,
  str_no            VARCHAR(50) DEFAULT NULL,
  biaya_konsultasi DECIMAL(12,2) NOT NULL DEFAULT 0,
  foto              VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id_dokter),
  KEY fk_dokter_spesialis (id_spesialis),
  CONSTRAINT fk_dokter_spesialis FOREIGN KEY (id_spesialis) REFERENCES spesialis (id_spesialis)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------- DOKTER_KLINIK (junction m:n) ------------
DROP TABLE IF EXISTS dokter_klinik;
CREATE TABLE dokter_klinik (
  id_dokter  INT(11) UNSIGNED NOT NULL,
  id_klinik  INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (id_dokter, id_klinik),
  KEY fk_dk_klinik (id_klinik),
  CONSTRAINT fk_dk_dokter FOREIGN KEY (id_dokter) REFERENCES dokter (id_dokter)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_dk_klinik FOREIGN KEY (id_klinik) REFERENCES klinik (id_klinik)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------- JADWAL_PRAKTIK --------------------------
DROP TABLE IF EXISTS jadwal_praktik;
CREATE TABLE jadwal_praktik (
  id_jadwal   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_dokter   INT(11) UNSIGNED NOT NULL,
  id_klinik   INT(11) UNSIGNED NOT NULL,
  hari        ENUM('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  jam_mulai   TIME NOT NULL,
  jam_selesai TIME NOT NULL,
  kuota       INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (id_jadwal),
  KEY fk_jp_dokter (id_dokter),
  KEY fk_jp_klinik (id_klinik),
  CONSTRAINT fk_jp_dokter FOREIGN KEY (id_dokter) REFERENCES dokter (id_dokter)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_jp_klinik FOREIGN KEY (id_klinik) REFERENCES klinik (id_klinik)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------- BOOKING ----------------------------------
DROP TABLE IF EXISTS booking;
CREATE TABLE booking (
  id_booking      INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  kode_booking    VARCHAR(30) NOT NULL,
  id_user         INT(11) UNSIGNED NOT NULL,
  id_dokter       INT(11) UNSIGNED NOT NULL,
  id_klinik       INT(11) UNSIGNED NOT NULL,
  id_jadwal       INT(11) UNSIGNED DEFAULT NULL,
  tanggal_booking DATE NOT NULL,
  keluhan         TEXT DEFAULT NULL,
  status          ENUM('Menunggu','Selesai','Dibatalkan') NOT NULL DEFAULT 'Menunggu',
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_booking),
  UNIQUE KEY unik_kode_booking (kode_booking),
  KEY fk_booking_user (id_user),
  KEY fk_booking_dokter (id_dokter),
  KEY fk_booking_klinik (id_klinik),
  KEY fk_booking_jadwal (id_jadwal),
  CONSTRAINT fk_booking_user FOREIGN KEY (id_user) REFERENCES users (id_user)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_booking_dokter FOREIGN KEY (id_dokter) REFERENCES dokter (id_dokter)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_booking_klinik FOREIGN KEY (id_klinik) REFERENCES klinik (id_klinik)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_booking_jadwal FOREIGN KEY (id_jadwal) REFERENCES jadwal_praktik (id_jadwal)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------- APOTEK (normalisasi harga & stok per cabang) -----
DROP TABLE IF EXISTS harga_stok_apotek;
DROP TABLE IF EXISTS apotek;
CREATE TABLE apotek (
  id_apotek    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_apotek  VARCHAR(150) NOT NULL,
  alamat       TEXT DEFAULT NULL,
  no_telp      VARCHAR(20) DEFAULT NULL,
  email        VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (id_apotek)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE harga_stok_apotek (
  id_apotek INT(11) UNSIGNED NOT NULL,
  id_obat   INT(11) UNSIGNED NOT NULL,
  harga     DECIMAL(12,2) NOT NULL DEFAULT 0,
  stok      INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id_apotek, id_obat),
  KEY fk_hsa_obat (id_obat),
  CONSTRAINT fk_hsa_apotek FOREIGN KEY (id_apotek) REFERENCES apotek (id_apotek)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_hsa_obat FOREIGN KEY (id_obat) REFERENCES obat (id_obat)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
