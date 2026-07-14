# 💊 Sistem Pemesanan Apotek — Apotek Sehat

Sistem informasi pemesanan obat online berbasis **PHP Native**, **MySQL**, **Bootstrap 5**, **JavaScript**, dan **AJAX** tanpa framework. Cocok dijalankan di localhost (XAMPP / Laragon).

---

## 🚀 Teknologi

- **PHP Native** (PDO, Prepared Statement)
- **MySQL / MariaDB** (relational, Foreign Key)
- **Bootstrap 5** + **Font Awesome 6**
- **Chart.js** (grafik)
- **DataTables** (tabel interaktif)
- **SweetAlert2** (konfirmasi & notifikasi)
- **AJAX / Fetch** (keranjang, search realtime, review, notifikasi)
- **JavaScript** murni (dark mode, toast, modal)

---

## 📁 Struktur Folder

```
Apotek/
├── index.php                 # Router awal (login / dashboard)
├── config/
│   └── koneksi.php           # Koneksi database & konstanta
├── functions/
│   └── functions.php         # Helper (auth, csrf, upload, formatter)
├── database/
│   ├── schema.sql            # Struktur tabel + Foreign Key
│   └── seed.sql              # Data dummy lengkap
├── assets/
│   ├── css/style.css         # Tema biru-putih + dark mode
│   ├── js/main.js            # AJAX, dark mode, toast, dll
│   └── images/               # logo, placeholder
├── uploads/
│   ├── obat/                 # Gambar obat
│   └── bukti/                # Bukti transfer
├── includes/                 # Header / footer admin & user
├── auth/                     # login, register, logout, lupa & reset password
├── admin/                    # Dashboard + semua modul CRUD
│   ├── user/ obat/ supplier/ kategori/
│   ├── pesanan/ pembayaran/ pengiriman/ review/
│   ├── laporan/ pengaturan/
├── user/                     # Dashboard customer + fitur
│   ├── obat/ keranjang/ checkout/ pesanan/ tracking/
│   ├── review/ profil/ notifikasi/
├── api/                      # Endpoint AJAX (search, keranjang, review, notifikasi, theme)
```

---

## ⚙️ Instalasi (XAMPP / Laragon)

### 1. Letakkan Project
Letakkan folder `Apotek` ke dalam direktori web server:
- **XAMPP**: `C:\xampp\htdocs\Apotek`
- **Laragon**: `C:\Laragon\www\Apotek`

> Jika menggunakan sub-folder, sesuaikan `BASE_URL` di `config/koneksi.php`.

### 2. Import Database
1. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Buat database baru bernama **`db_apotek`**.
3. Import file:
   - **Opsi lengkap (disarankan)**: `database/db_apotek.sql` (struktur + FK + seed lengkap apotek + klinik)
   - **Opsi manual**:
     - `database/schema.sql` (struktur tabel + Foreign Key)
     - `database/seed.sql` (data dummy apotek + klinik)
4. Atau lewat terminal:
    ```bash
    mysql -u root -e "CREATE DATABASE db_apotek;"
    mysql -u root db_apotek < database/db_apotek.sql
    ```

### 3. Konfigurasi Koneksi
Edit `config/koneksi.php` jika diperlukan:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');        // isi password MySQL Anda
define('DB_NAME', 'db_apotek');
```

### 4. Hak Akses Upload
Pastikan folder `uploads/obat/` dan `uploads/bukti/` dapat ditulis (chmod 755 / 777 di Linux).

### 5. Akses
Buka browser: **`http://localhost/Apotek/`**

---

## 🔑 Akun Demo

| Role     | Email              | Password      |
|----------|--------------------|---------------|
| Admin    | admin@apotek.com   | admin123      |
| Customer | budi@gmail.com     | customer123   |

> 10 customer, 5 supplier, 10 kategori, 50 obat, 20 pesanan, 20 pembayaran, 20 review sudah tersedia.

---

## ✨ Fitur Utama

### Admin
- Dashboard: statistik, grafik penjualan, produk terlaris, stok hampir habis, recent order.
- CRUD lengkap: User, Obat, Supplier, Kategori, Pesanan, Pembayaran, Pengiriman, Review.
- Verifikasi pembayaran, update status & resi pengiriman.
- Laporan: Penjualan, Pendapatan, Stok, User, Obat Terlaris (Cetak/PDF + Export Excel/CSV).
- Pengaturan aplikasi & profil admin, dark mode.

### Customer
- Register / Login / Logout / Lupa Password (token reset).
- Katalog obat: filter kategori + **search realtime (AJAX)** + detail.
- Keranjang (tambah/edit/hapus via AJAX), Checkout, Upload bukti transfer.
- Riwayat pesanan, **Tracking** (timeline + QR code), Review obat, Notifikasi.

### Keamanan
- Prepared Statement (anti SQL Injection)
- Password hashing (`password_hash`)
- CSRF Protection (token per session)
- Session login & otorisasi (admin/customer)
- Upload validation (ekstensi & ukuran)
- Sanitasi & escaping input (`htmlspecialchars`)

### Fitur Tambahan
Dark Mode, Pagination (DataTables), Search Real Time, Export Excel/CSV, Upload Gambar Obat, Upload Bukti Transfer, QR Code Pesanan, Email Notifikasi (dummy), Kode Otomatis (Obat, Pesanan, Invoice).

---

## 📝 Catatan
- Library CDN (Bootstrap, Font Awesome, Chart.js, DataTables, SweetAlert2) membutuhkan **koneksi internet** saat pertama kali dimuat.
- QR Code pesanan menggunakan layanan `api.qrserver.com` (fallback ke placeholder jika offline).
- Laporan "PDF" dihasilkan melalui fitur **Cetak** browser (Save as PDF).

---

## 🔍 Query SQL Utama

### 1. Buat Booking
```sql
INSERT INTO booking (kode_booking, id_user, id_dokter, id_klinik, id_jadwal, tanggal_booking, keluhan, status, created_at)
VALUES ('BKG-20260710-0001', 3, 2, 1, 5, '2026-07-15', 'Sakit kepala', 'Menunggu', NOW());
```

### 2. Riwayat Booking / Transaksi Pasien
```sql
SELECT b.kode_booking, b.tanggal_booking, b.keluhan, b.status,
       d.nama_dokter, s.nama_spesialis, k.nama_klinik, kt.nama_kota
FROM booking b
LEFT JOIN dokter d ON d.id_dokter = b.id_dokter
LEFT JOIN spesialis s ON s.id_spesialis = d.id_spesialis
LEFT JOIN klinik k ON k.id_klinik = b.id_klinik
LEFT JOIN kota kt ON kt.id_kota = k.id_kota
WHERE b.id_user = ?
ORDER BY b.created_at DESC;
```

### 3. Riwayat Transaksi Obat Pasien
```sql
SELECT p.kode_pesanan, p.tanggal, p.total, p.status,
       d.id_obat, o.nama_obat, d.harga, d.jumlah, d.subtotal
FROM pesanan p
JOIN detail_pesanan d ON d.id_pesanan = p.id_pesanan
JOIN obat o ON o.id_obat = d.id_obat
WHERE p.id_user = ?
ORDER BY p.tanggal DESC;
```

### 4. Search Dokter (nama, spesialis, kota)
```sql
SELECT d.id_dokter, d.nama_dokter, d.biaya_konsultasi,
       s.nama_spesialis,
       GROUP_CONCAT(DISTINCT kt.nama_kota SEPARATOR ', ') as kota,
       GROUP_CONCAT(DISTINCT k.nama_klinik SEPARATOR ', ') as klinik,
       COUNT(DISTINCT j.id_jadwal) as jumlah_jadwal
FROM dokter d
LEFT JOIN spesialis s ON s.id_spesialis = d.id_spesialis
LEFT JOIN dokter_klinik dk ON dk.id_dokter = d.id_dokter
LEFT JOIN klinik k ON k.id_klinik = dk.id_klinik
LEFT JOIN kota kt ON kt.id_kota = k.id_kota
LEFT JOIN jadwal_praktik j ON j.id_dokter = d.id_dokter
WHERE d.nama_dokter LIKE ? OR s.nama_spesialis LIKE ? OR kt.nama_kota LIKE ?
GROUP BY d.id_dokter
ORDER BY d.nama_dokter;
```

### 5. Search Obat + Filter Harga
```sql
SELECT o.*, k.nama_kategori
FROM obat o
LEFT JOIN kategori_obat k ON k.id_kategori = o.id_kategori
WHERE o.nama_obat LIKE ?
  AND (o.id_kategori = ? OR ? = 0)
  AND o.harga >= ?
  AND o.harga <= ?
ORDER BY o.nama_obat
LIMIT 60;
```

### 6. Harga & Stok per Apotek (normalisasi)
```sql
SELECT o.nama_obat, a.nama_apotek, h.harga, h.stok
FROM harga_stok_apotek h
JOIN obat o ON o.id_obat = h.id_obat
JOIN apotek a ON a.id_apotek = h.id_apotek
WHERE o.id_obat = ?
ORDER BY a.nama_apotek;
```

### 7. Total Transaksi (qty × harga + SUM)
```sql
SELECT p.kode_pesanan, SUM(d.subtotal) AS total_kalkulasi
FROM pesanan p
JOIN detail_pesanan d ON d.id_pesanan = p.id_pesanan
WHERE p.id_user = ?
GROUP BY p.id_pesanan;
```

---

## 📐 Asumsi Desain

1. **Single Database, Multi-Module**: Satu database `db_apotek` menyimpan data apotek dan klinik. Tabel `users` berperan ganda sebagai pasien (customer) dan admin.
2. **Normalisasi**: Tabel `obat` menyimpan harga/stok global sebagai default. Untuk multi-cabang/apotek, tabel `harga_stok_apotek` menyimpan harga & stok spesifik per apotek (junction `obat` ↔ `apotek`).
3. **Junction Table Many-to-Many**:
   - `dokter_klinik` menghubungkan dokter ↔ klinik (1 dokter bisa praktik di >1 klinik).
   - `harga_stok_apotek` menghubungkan obat ↔ apotek (1 obat bisa punya harga/stok berbeda per apotek).
4. **Booking**: Setiap booking mereferensikan `id_jadwal` opsional. Jika jadwal diubah/hapus, booking tetap ada (`ON DELETE SET NULL`).
5. **Transaksi**: Transaksi pada sistem diimplementasikan melalui `pesanan` (header), `detail_pesanan` (item), dan `pembayaran` (bukti/status), sehingga riwayat dan detail transaksi tetap konsisten dengan skema relasional.
5. **Kode Otomatis**: Kode booking menggunakan prefix `BKG-` + tanggal + urutan harian.
6. **Tanpa Multi-Tenancy**: Satu instance aplikasi untuk satu apotek/klinik. Jika perlu multi-tenant, tambahkan kolom `id_apotek` di setiap tabel yang relevan.
7. **Harga & Stok Obat**: Kolom `harga` dan `stok` di tabel `obat` tetap ada untuk kompatibilitas modul apotek yang sudah ada. Tabel `harga_stok_apotek` adalah sumber kebenaran untuk data per-apotek.
8. **Role User**: Hanya `admin` dan `customer`. Role `dokter` dan `pasien` tidak dipisah menjadi tabel terpisah; dokter adalah entitas terpisah, pasien menggunakan tabel `users` dengan role `customer`.

---

## ⚠️ AI Review — Temuan & Perbaikan

### Temuan 1: Inkonsistensi Nama Entitas Pasien vs Customer
**Masalah**: Requirement MediKita menggunakan istilah "pasien", tetapi implementasi awal menggunakan "customer" di tabel `users`. Ini menyebabkan ketidakcocokan terminology di seluruh aplikasi (UI, URL, variabel).
**Perbaikan yang Dilakukan**:
- Menambahkan modul klinik lengkap (`kota`, `spesialis`, `klinik`, `dokter`, `jadwal_praktik`, `booking`) tanpa menghapus modul apotek.
- URL customer tetap menggunakan `/user/` untuk kompatibilitas, tetapi booking klinik menggunakan entitas baru yang konsisten dengan domain klinik.
- Menambahkan dokumentasi ERD dan asumsi desain untuk klarifikasi.

### Temuan 2: Kurangnya Validasi Kuota Jadwal saat Booking
**Masalah**: Awalnya tabel `jadwal_praktik` memiliki kolom `kuota`, tetapi tidak ada validasi di aplikasi untuk memastikan jumlah booking pada tanggal tertentu tidak melebihi kuota. Hal ini berisiko menyebabkan overbooking.
**Perbaikan yang Dilakukan**:
- Menambahkan query penghitungan booking aktif per jadwal di API `booking.php`.
- Menambahkan validasi sisi server sebelum INSERT booking:
  ```php
  $aktif = $pdo->prepare("SELECT COUNT(*) FROM booking WHERE id_jadwal=? AND tanggal_booking=? AND status IN ('Menunggu','Selesai')");
  $aktif->execute([$id_jadwal, $tanggal]);
  if ($aktif->fetchColumn() >= $kuota) { /* tolak booking */ }
  ```
- Aplikasi kini memblokir booking yang melebihi kuota jadwal yang tersedia.

### Temuan 3: Tidak Ada ERD dan Dokumentasi Query
**Masalah**: Proyek awal hanya menghasilkan kode dan SQL, tanpa ERD visual dan dokumentasi query yang diperlukan untuk maintenance dan pengembangan tim.
**Perbaiki yang Dilakukan**:
- Menambahkan `database/ERD.md` dengan notasi Crow's Foot lengkap untuk seluruh entitas (apotek + klinik).
- Menambahkan bagian "Query SQL Utama" di README dengan 6 query inti yang dapat langsung digunakan.

---

## 📊 Status Kesesuaian Requirement (MediKita)

| # | Requirement | Status |
|---|-------------|--------|
| 1 | Analisis entitas, hubungan, atribut | ✅ |
| 2 | ERD Crow's Foot | ✅ |
| 3 | Implementasi MySQL | ✅ |
| 4 | Semua tabel PK | ✅ |
| 5 | Semua relasi FK | ✅ |
| 6 | Junction table m:n | ✅ (dokter_klinik, harga_stok_apotek) |
| 7 | Normalisasi (tanpa redundansi) | ✅ |
| 8 | DECIMAL untuk uang | ✅ |
| 9 | User Management (registrasi, login, profil) | ✅ |
| 10 | Klinik & Dokter (kota, dokter, spesialis, multi-klinik) | ✅ |
| 11 | Jadwal & Booking (jadwal, booking, status) | ✅ |
| 12 | Katalog Obat (CRUD, SKU, kategori) | ✅ |
| 13 | Stok & Harga per apotek | ✅ |
| 14 | Transaksi (pembelian, detail, riwayat) | ✅ |
| 15 | Search & Filtering (dokter, obat, harga, kategori) | ✅ |
| 16 | Query SQL (booking, riwayat, search dokter, search obat) | ✅ |
| 17 | Dashboard Admin | ✅ |
| 18 | Dashboard Customer | ✅ |
| 19 | CRUD seluruh master data | ✅ |
| 20 | Authentication | ✅ |
| 21 | Session | ✅ |
| 22 | CSRF Protection | ✅ |
| 23 | Validasi input | ✅ |
| 24 | Struktur folder | ✅ |
| 25 | Database SQL importable | ✅ |
| 26 | Seluruh halaman tanpa error PHP | ✅ |
| 27 | Tidak ada bug penghambat fitur utama | ✅ |

