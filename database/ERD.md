# ERD (Entity Relationship Diagram) — Crow's Foot Notation

Sistem Apotek & Klinik (MediKita)

---

## Entitas

| Entitas | Atribut Utama |
|---------|---------------|
| **users** | id_user (PK), nama, email, password, no_hp, alamat, role, created_at |
| **kota** | id_kota (PK), nama_kota |
| **spesialis** | id_spesialis (PK), nama_spesialis, deskripsi |
| **klinik** | id_klinik (PK), id_kota (FK), nama_klinik, alamat, no_telp, email |
| **dokter** | id_dokter (PK), id_spesialis (FK), nama_dokter, gender, no_hp, email, str_no, biaya_konsultasi, foto |
| **dokter_klinik** | id_dokter (PK,FK), id_klinik (PK,FK) |
| **jadwal_praktik** | id_jadwal (PK), id_dokter (FK), id_klinik (FK), hari, jam_mulai, jam_selesai, kuota |
| **booking** | id_booking (PK), kode_booking, id_user (FK), id_dokter (FK), id_klinik (FK), id_jadwal (FK), tanggal_booking, keluhan, status, created_at |
| **kategori_obat** | id_kategori (PK), nama_kategori, deskripsi |
| **supplier** | id_supplier (PK), nama_supplier, alamat, no_hp, email |
| **obat** | id_obat (PK), kode_obat, nama_obat, id_kategori (FK), id_supplier (FK), harga, stok, deskripsi, gambar, tanggal_expired, created_at |
| **apotek** | id_apotek (PK), nama_apotek, alamat, no_telp, email |
| **harga_stok_apotek** | id_apotek (PK,FK), id_obat (PK,FK), harga, stok |
| **keranjang** | id_keranjang (PK), id_user (FK), id_obat (FK), jumlah |
| **pesanan** | id_pesanan (PK), kode_pesanan, id_user (FK), tanggal, total, status |
| **detail_pesanan** | id_detail (PK), id_pesanan (FK), id_obat (FK), harga, jumlah, subtotal |
| **pembayaran** | id_pembayaran (PK), id_pesanan (FK), id_metode (FK), metode, bukti_transfer, tanggal_bayar, status |
| **pengiriman** | id_pengiriman (PK), id_pesanan (FK), ekspedisi, nomor_resi, status |
| **metode_pembayaran** | id_metode (PK), nama_metode, tipe, nomor, pemilik, aktif |
| **review** | id_review (PK), id_user (FK), id_obat (FK), rating, komentar, tanggal |
| **notifikasi** | id_notifikasi (PK), id_user (FK), judul, isi, status, created_at |

---

## Relasi (Crow's Foot)

```
users 1 ────< booking (1:N)
  |
  ├───< keranjang (1:N)
  |
  ├───< pesanan (1:N)
  |
  ├───< review (1:N)
  |
  └───< notifikasi (1:N)

kota 1 ────< klinik (1:N)

spesialis 1 ────< dokter (1:N)

klinik 1 ────< jadwal_praktik (1:N)
klinik 1 ────< booking (1:N)

dokter 1 ────< jadwal_praktik (1:N)
dokter 1 ────< booking (1:N)

dokter N >───< klinik N  (via dokter_klinik)  ← Junction Table

kategori_obat 1 ────< obat (1:N)
supplier 1 ────< obat (1:N)

apotek N >───< obat N  (via harga_stok_apotek) ← Junction Table (normalisasi)

obat 1 ────< keranjang (1:N)
obat 1 ────< detail_pesanan (1:N)

pesanan 1 ────< detail_pesanan (1:N)
pesanan 1 ────< pembayaran (1:1)
pesanan 1 ────< pengiriman (1:1)
metode_pembayaran 1 ────< pembayaran (1:N)
```

---

## Keterangan Notasi

| Notasi | Arti |
|--------|------|
| `1` | Satu |
| `>` | Banyak (minimal satu) |
| `<` | Banyak (minimal nol / opsional) |
| `N >───< N` | Many-to-Many via junction table |

---

## Cardinality Detail

| Relasi | Jenis | Penjelasan |
|--------|-------|------------|
| users → booking | 1:N | 1 user bisa punya banyak booking |
| users → pesanan | 1:N | 1 user bisa punya banyak pesanan obat |
| dokter → klinik | N:M | via dokter_klinik |
| obat → apotek | N:M | via harga_stok_apotek |
| pesanan → pembayaran | 1:1 | 1 pesanan punya 1 pembayaran |
| pesanan → pengiriman | 1:1 | 1 pesanan punya 1 pengiriman |
| pesanan → detail_pesanan | 1:N | 1 pesanan punya banyak detail |
| metode_pembayaran → pembayaran | 1:N | 1 metode pembayaran bisa dipakai banyak transaksi |

---

*Generated: 2026-07-10*
