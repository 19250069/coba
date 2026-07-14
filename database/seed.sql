-- ============================================================
--  SEED DATA: db_apotek
--  (import setelah schema.sql)
-- ============================================================

-- ---------------- USERS (1 admin + 10 customer) -------------
INSERT INTO users (id_user, nama, email, password, no_hp, alamat, role, created_at) VALUES
(1,  'Administrator',        'admin@apotek.com',   '$2y$10$3Buaz.yIWtX4xAdA0o6AJOpSJxotottesd34OfWz4kAsWBrk.hOIu', '081234000001', 'Jl. Apotek Sehat No. 1, Jakarta', 'admin',    '2025-01-01 08:00:00'),
(2,  'Budi Santoso',         'budi@gmail.com',     '$2y$10$l/u7HNgOAOyMRD7DRjMHieQVm.kq0WeGcPtfeOPuJNvQ75PlmYl2a', '081234000002', 'Jl. Merdeka No. 12, Bandung',     'customer', '2025-02-03 09:15:00'),
(3,  'Siti Rahayu',          'siti@gmail.com',     '$2y$10$l/u7HNgOAOyMRD7DRjMHieQVm.kq0WeGcPtfeOPuJNvQ75PlmYl2a', '081234000003', 'Jl. Mawar No. 8, Surabaya',       'customer', '2025-02-10 10:00:00'),
(4,  'Ahmad Fauzi',          'ahmad@gmail.com',    '$2y$10$l/u7HNgOAOyMRD7DRjMHieQVm.kq0WeGcPtfeOPuJNvQ75PlmYl2a', '081234000004', 'Jl. Pahlawan No. 45, Yogyakarta', 'customer', '2025-03-01 11:30:00'),
(5,  'Dewi Lestari',         'dewi@gmail.com',     '$2y$10$l/u7HNgOAOyMRD7DRjMHieQVm.kq0WeGcPtfeOPuJNvQ75PlmYl2a', '081234000005', 'Jl. Kenanga No. 3, Semarang',     'customer', '2025-03-12 13:45:00'),
(6,  'Rina Anggraini',       'rina@gmail.com',     '$2y$10$l/u7HNgOAOyMRD7DRjMHieQVm.kq0WeGcPtfeOPuJNvQ75PlmYl2a', '081234000006', 'Jl. Anggrek No. 21, Medan',       'customer', '2025-03-20 08:20:00'),
(7,  'Joko Widodo',          'joko@gmail.com',     '$2y$10$l/u7HNgOAOyMRD7DRjMHieQVm.kq0WeGcPtfeOPuJNvQ75PlmYl2a', '081234000007', 'Jl. Melati No. 7, Makassar',      'customer', '2025-04-02 14:10:00'),
(8,  'Sri Wahyuni',          'sri@gmail.com',      '$2y$10$l/u7HNgOAOyMRD7DRjMHieQVm.kq0WeGcPtfeOPuJNvQ75PlmYl2a', '081234000008', 'Jl. Flamboyan No. 9, Denpasar',   'customer', '2025-04-15 09:50:00'),
(9,  'Eko Prasetyo',         'eko@gmail.com',      '$2y$10$l/u7HNgOAOyMRD7DRjMHieQVm.kq0WeGcPtfeOPuJNvQ75PlmYl2a', '081234000009', 'Jl. Cendana No. 14, Palembang',   'customer', '2025-05-01 16:00:00'),
(10, 'Maya Sari',            'maya@gmail.com',     '$2y$10$l/u7HNgOAOyMRD7DRjMHieQVm.kq0WeGcPtfeOPuJNvQ75PlmYl2a', '081234000010', 'Jl. Dahlia No. 33, Bekasi',       'customer', '2025-05-18 10:30:00'),
(11, 'Bayu Firmansyah',      'bayu@gmail.com',     '$2y$10$l/u7HNgOAOyMRD7DRjMHieQVm.kq0WeGcPtfeOPuJNvQ75PlmYl2a', '081234000011', 'Jl. Teratai No. 5, Depok',        'customer', '2025-06-01 12:00:00');

-- ---------------- KATEGORI OBAT (10) ------------------------
INSERT INTO kategori_obat (id_kategori, nama_kategori, deskripsi) VALUES
(1,  'Analgesik',        'Obat pereda nyeri dan demam'),
(2,  'Antibiotik',       'Obat untuk mengatasi infeksi bakteri'),
(3,  'Vitamin & Suplemen', 'Suplemen penunjang kesehatan tubuh'),
(4,  'Obat Batuk & Flu', 'Obat untuk meredakan batuk dan flu'),
(5,  'Antihistamin',     'Obat alergi dan gatal'),
(6,  'Salep & Kulit',    'Obat oles dan perawatan kulit'),
(7,  'Obat Pencernaan',  'Obat untuk gangguan pencernaan'),
(8,  'Obat Jantung',     'Obat untuk kesehatan jantung dan tekanan darah'),
(9,  'Diabetes',         'Obat dan alat untuk penderita diabetes'),
(10, 'Alat Kesehatan',   'Peralatan dan perlengkapan medis');

-- ---------------- SUPPLIER (5) ------------------------------
INSERT INTO supplier (id_supplier, nama_supplier, alamat, no_hp, email) VALUES
(1, 'PT Kimia Farma',   'Jl. RE Martadinata No. 10, Jakarta',   '021-555001', 'info@kimiafarma.co.id'),
(2, 'PT Indofarma',     'Jl. Sukarno Hatta No. 20, Bandung',    '022-555002', 'cs@indofarma.co.id'),
(3, 'PT Kalbe Farma',   'Jl. Pulo Mas Raya No. 5, Jakarta',     '021-555003', 'support@kalbe.co.id'),
(4, 'PT Sanbe Farma',   'Jl. Cikutra No. 14, Bandung',          '022-555004', 'halo@sanbe.co.id'),
(5, 'PT Dexa Medica',   'Jl. Industri No. 8, Cikarang',         '021-555005', 'kontak@dexa.co.id');
-- ---------------- OBAT (1-25) ---------------------------------
INSERT INTO obat (id_obat, kode_obat, nama_obat, id_kategori, id_supplier, harga, stok, deskripsi, gambar, tanggal_expired, created_at) VALUES
(1,  'OB-00001', 'Paracetamol 500mg',       1, 1, 3500,   120, 'Pereda nyeri dan penurun demam.',            '', '2026-12-31', '2025-06-01 08:00:00'),
(2,  'OB-00002', 'Ibuprofen 400mg',         1, 3, 5200,    90, 'Antiinflamasi untuk nyeri ringan.',          '', '2026-10-15', '2025-06-01 08:05:00'),
(3,  'OB-00003', 'Aspirin 80mg',            1, 4, 4100,    75, 'Mencegah penggumpalan darah.',               '', '2027-03-20', '2025-06-01 08:10:00'),
(4,  'OB-00004', 'Amoxilin 500mg',          2, 2, 8500,    60, 'Antibiotik untuk infeksi saluran napas.',    '', '2026-11-30', '2025-06-01 08:15:00'),
(5,  'OB-00005', 'Ciprofloxacin 500mg',     2, 5, 9200,    50, 'Antibiotik untuk infeksi saluran kemih.',    '', '2027-01-25', '2025-06-01 08:20:00'),
(6,  'OB-00006', 'Azithromycin 500mg',      2, 3, 15000,   40, 'Antibiotik untuk infeksi pernapasan.',       '', '2026-09-18', '2025-06-01 08:25:00'),
(7,  'OB-00007', 'Doxycycline 100mg',       2, 4, 7800,    55, 'Antibiotik broad spectrum.',                 '', '2027-02-10', '2025-06-01 08:30:00'),
(8,  'OB-00008', 'Vitamin C 500mg',         3, 1, 12000,  200, 'Menjaga daya tahan tubuh.',                  '', '2027-05-01', '2025-06-01 08:35:00'),
(9,  'OB-00009', 'Vitamin D3 1000IU',       3, 3, 18000,  150, 'Membantu penyerapan kalsium.',               '', '2027-06-15', '2025-06-01 08:40:00'),
(10, 'OB-00010', 'Multivitamin Hemaviton',  3, 5, 25000,  130, 'Suplemen multivitamin harian.',              '', '2027-04-22', '2025-06-01 08:45:00'),
(11, 'OB-00011', 'Zinc Tablet 20mg',        3, 2, 14000,  100, 'Suplemen zinc untuk imunitas.',              '', '2027-03-30', '2025-06-01 08:50:00'),
(12, 'OB-00012', 'Obat Batuk Hitam',        4, 4, 16000,   80, 'Bebas batuk berdahak.',                      '', '2026-12-05', '2025-06-01 08:55:00'),
(13, 'OB-00013', 'OBH Combi Anak',          4, 3, 13500,   95, 'Obat batuk untuk anak.',                     '', '2027-01-12', '2025-06-01 09:00:00'),
(14, 'OB-00014', 'Dektrizin 25mg',          4, 5, 9000,    70, 'Meredakan flu dan bersin.',                  '', '2027-02-28', '2025-06-01 09:05:00'),
(15, 'OB-00015', 'Panadol Flu & Cold',      4, 1, 11000,   85, 'Redakan gejala flu.',                        '', '2026-10-20', '2025-06-01 09:10:00'),
(16, 'OB-00016', 'Cetirizine 10mg',         5, 2, 4200,   110, 'Obat alergi dan gatal kulit.',               '', '2027-07-10', '2025-06-01 09:15:00'),
(17, 'OB-00017', 'Loratadine 10mg',         5, 4, 6500,    90, 'Antihistamin tanpa kantuk.',                 '', '2027-08-05', '2025-06-01 09:20:00'),
(18, 'OB-00018', 'CTM 4mg',                 5, 5, 3000,   130, 'Redakan alergi ringan.',                     '', '2026-11-11', '2025-06-01 09:25:00'),
(19, 'OB-00019', 'Betadine Solution 60ml',  6, 1, 22000,   60, 'Antiseptik luka luar.',                      '', '2028-01-15', '2025-06-01 09:30:00'),
(20, 'OB-00020', 'Hydrocortisone Cream',    6, 3, 19000,   45, 'Redakan peradangan kulit.',                  '', '2027-09-20', '2025-06-01 09:35:00'),
(21, 'OB-00021', 'Betamethasone Salep',     6, 4, 15000,   50, 'Salep untuk gatal dan ruam.',                '', '2027-05-30', '2025-06-01 09:40:00'),
(22, 'OB-00022', 'Antimo 4mg',              7, 2, 4000,   140, 'Obat mual dan pusing.',                      '', '2027-10-10', '2025-06-01 09:45:00'),
(23, 'OB-00023', 'Antasida Doen',           7, 5, 6000,   120, 'Redakan nyeri lambung.',                     '', '2027-11-25', '2025-06-01 09:50:00'),
(24, 'OB-00024', 'Domperidone 10mg',        7, 3, 9000,    80, 'Obat mual dan muntah.',                      '', '2026-12-22', '2025-06-01 09:55:00'),
(25, 'OB-00025', 'Loperamide 2mg',          7, 4, 5000,   100, 'Redakan diare akut.',                        '', '2027-03-15', '2025-06-01 10:00:00');
-- ---------------- OBAT (26-50) --------------------------------
INSERT INTO obat (id_obat, kode_obat, nama_obat, id_kategori, id_supplier, harga, stok, deskripsi, gambar, tanggal_expired, created_at) VALUES
(26, 'OB-00026', 'Captopril 25mg',          8, 1, 3500,   200, 'Obat darah tinggi.',                          '', '2027-12-01', '2025-06-01 10:05:00'),
(27, 'OB-00027', 'Amlodipine 5mg',          8, 2, 4500,   180, 'Pengendali tekanan darah.',                   '', '2027-08-18', '2025-06-01 10:10:00'),
(28, 'OB-00028', 'Bisoprolol 5mg',          8, 5, 6000,   150, 'Obat untuk gagal jantung.',                   '', '2027-06-30', '2025-06-01 10:15:00'),
(29, 'OB-00029', 'Metformin 500mg',         9, 3, 4000,   220, 'Obat diabetes tipe 2.',                       '', '2027-04-12', '2025-06-01 10:20:00'),
(30, 'OB-00030', 'Glibenclamide 5mg',       9, 4, 5000,   170, 'Menurunkan gula darah.',                      '', '2027-02-20', '2025-06-01 10:25:00'),
(31, 'OB-00031', 'Glimepiride 2mg',         9, 5, 7000,   140, 'Sulfonilurea untuk diabetes.',               '', '2027-09-05', '2025-06-01 10:30:00'),
(32, 'OB-00032', 'Termometer Digital',     10, 1, 35000,   60, 'Ukur suhu tubuh akurat.',                    '', '2030-01-01', '2025-06-01 10:35:00'),
(33, 'OB-00033', 'Masker Medis Box',       10, 2, 45000,  100, 'Perlindungan pernapasan.',                    '', '2028-06-01', '2025-06-01 10:40:00'),
(34, 'OB-00034', 'Tensimeter Digital',     10, 3, 120000,  30, 'Monitor tekanan darah.',                      '', '2030-01-01', '2025-06-01 10:45:00'),
(35, 'OB-00035', 'Handsanitizer Neon Glow',10, 4, 15000,  150, 'Pembersih tangan praktis.',                  '', '2028-03-15', '2025-06-01 10:50:00'),
(36, 'OB-00036', 'Paracetamol Sirup Anak',  1, 5, 28000,   70, 'Demam pada anak.',                            '', '2026-09-30', '2025-06-01 10:55:00'),
(37, 'OB-00037', 'Amoxiclav 625mg',        2, 1, 22000,   50, 'Kombinasi antibiotik kuat.',                  '', '2026-12-18', '2025-06-01 11:00:00'),
(38, 'OB-00038', 'Vitamin B Complex',       3, 2, 11000,  160, 'Suplemen vitamin B.',                         '', '2027-07-22', '2025-06-01 11:05:00'),
(39, 'OB-00039', 'Promag 75mg',            7, 3, 7500,   130, 'Redakan maag.',                                '', '2027-10-30', '2025-06-01 11:10:00'),
(40, 'OB-00040', 'Bisolvon 8mg',           4, 4, 12000,   90, 'Peluruh dahak.',                               '', '2027-01-05', '2025-06-01 11:15:00'),
(41, 'OB-00041', 'Claritin 10mg',          5, 5, 17500,   65, 'Antialergi harian.',                           '', '2027-11-12', '2025-06-01 11:20:00'),
(42, 'OB-00042', 'Caladine Gel',           6, 1, 13000,   85, 'Redakan gatal akibat gigitan.',               '', '2027-08-28', '2025-06-01 11:25:00'),
(43, 'OB-00043', 'Insulin Injeksi',        9, 3, 85000,   25, 'Kontrol gula darah penderita diabetes.',      '', '2026-11-20', '2025-06-01 11:30:00'),
(44, 'OB-00044', 'Atorvastatin 10mg',      8, 2, 9500,   110, 'Penurun kolesterol.',                          '', '2027-05-18', '2025-06-01 11:35:00'),
(45, 'OB-00045', 'Ranitidine 150mg',       7, 5, 5500,    95, 'Obat lambung dan maag.',                       '', '2027-03-08', '2025-06-01 11:40:00'),
(46, 'OB-00046', 'Komet Sirup',            4, 4, 9800,    75, 'Batuk kering dan berdahak.',                  '', '2027-02-14', '2025-06-01 11:45:00'),
(47, 'OB-00047', 'Vitamin E 400iu',        3, 1, 21000,  100, 'Antioksidan untuk kulit.',                    '', '2027-09-12', '2025-06-01 11:50:00'),
(48, 'OB-00048', 'Betadine Cream',         6, 2, 18000,   70, 'Antiseptik dan perawatan luka.',              '', '2027-10-05', '2025-06-01 11:55:00'),
(49, 'OB-00049', 'Neurobion',              3, 3, 16500,  120, 'Vitamin B1 B6 B12 saraf.',                    '', '2027-06-25', '2025-06-01 12:00:00'),
(50, 'OB-00050', 'ORS Orsedia',            7, 5, 6500,   140, 'Cegah dehidrasi.',                             '', '2028-01-20', '2025-06-01 12:05:00');
-- ---------------- PESANAN (20) ---------------------------------
INSERT INTO pesanan (id_pesanan, kode_pesanan, id_user, tanggal, total, status) VALUES
(1,  'PSN-20250605-001', 3,  '2025-06-05 10:12:00', 19000,  'Selesai'),
(2,  'PSN-20250612-002', 4,  '2025-06-12 14:30:00', 15500,  'Selesai'),
(3,  'PSN-20250703-003', 5,  '2025-07-03 09:05:00', 16500,  'Selesai'),
(4,  'PSN-20250715-004', 6,  '2025-07-15 11:45:00', 46000,  'Dikirim'),
(5,  'PSN-20250722-005', 7,  '2025-07-22 15:20:00', 67000,  'Selesai'),
(6,  'PSN-20250802-006', 8,  '2025-08-02 08:40:00', 34400,  'Diproses'),
(7,  'PSN-20250808-007', 9,  '2025-08-08 13:10:00', 41000,  'Dikirim'),
(8,  'PSN-20250814-008', 10, '2025-08-14 16:55:00', 38500,  'Selesai'),
(9,  'PSN-20250819-009', 2,  '2025-08-19 10:00:00', 12000,  'Menunggu Pembayaran'),
(10, 'PSN-20250825-010', 11, '2025-08-25 12:30:00', 165000, 'Dikirim'),
(11, 'PSN-20250901-011', 3,  '2025-09-01 09:15:00', 15700,  'Selesai'),
(12, 'PSN-20250904-012', 4,  '2025-09-04 14:00:00', 32000,  'Diproses'),
(13, 'PSN-20250909-013', 5,  '2025-09-09 11:20:00', 30000,  'Selesai'),
(14, 'PSN-20250912-014', 6,  '2025-09-12 15:40:00', 20500,  'Dikirim'),
(15, 'PSN-20250915-015', 7,  '2025-09-15 08:25:00', 25000,  'Selesai'),
(16, 'PSN-20250918-016', 8,  '2025-09-18 17:05:00', 92000,  'Menunggu Pembayaran'),
(17, 'PSN-20250920-017', 9,  '2025-09-20 10:50:00', 22800,  'Diproses'),
(18, 'PSN-20250922-018', 10, '2025-09-22 13:35:00', 15000,  'Selesai'),
(19, 'PSN-20250925-019', 11, '2025-09-25 09:00:00', 65000,  'Dibatalkan'),
(20, 'PSN-20250928-020', 2,  '2025-09-28 16:10:00', 47000,  'Dikirim');

-- ---------------- DETAIL PESANAN -------------------------------
INSERT INTO detail_pesanan (id_pesanan, id_obat, harga, jumlah, subtotal) VALUES
(1, 1, 3500, 2, 7000),
(1, 8, 12000, 1, 12000),
(2, 4, 8500, 1, 8500),
(2, 26, 3500, 2, 7000),
(3, 3, 4100, 1, 4100),
(3, 16, 4200, 2, 8400),
(3, 29, 4000, 1, 4000),
(4, 9, 18000, 1, 18000),
(4, 11, 14000, 2, 28000),
(5, 19, 22000, 1, 22000),
(5, 35, 15000, 3, 45000),
(6, 2, 5200, 2, 10400),
(6, 8, 12000, 2, 24000),
(7, 37, 22000, 1, 22000),
(7, 44, 9500, 2, 19000),
(8, 12, 16000, 1, 16000),
(8, 13, 13500, 1, 13500),
(8, 14, 9000, 1, 9000),
(9, 29, 4000, 3, 12000),
(10, 34, 120000, 1, 120000),
(10, 33, 45000, 1, 45000),
(11, 5, 9200, 1, 9200),
(11, 17, 6500, 1, 6500),
(12, 20, 19000, 1, 19000),
(12, 42, 13000, 1, 13000),
(13, 6, 15000, 2, 30000),
(14, 22, 4000, 2, 8000),
(14, 25, 5000, 1, 5000),
(14, 39, 7500, 1, 7500),
(15, 10, 25000, 1, 25000),
(16, 43, 85000, 1, 85000),
(16, 31, 7000, 1, 7000),
(17, 7, 7800, 1, 7800),
(17, 21, 15000, 1, 15000),
(18, 27, 4500, 2, 9000),
(18, 28, 6000, 1, 6000),
(19, 32, 35000, 1, 35000),
(19, 35, 15000, 2, 30000),
(20, 8, 12000, 3, 36000),
(20, 38, 11000, 1, 11000);
-- ---------------- PEMBAYARAN (20) ------------------------------
INSERT INTO pembayaran (id_pesanan, metode, bukti_transfer, tanggal_bayar, status) VALUES
(1,  'Transfer Bank', 'bukti_001.jpg', '2025-06-05 11:00:00', 'Lunas'),
(2,  'DANA',          'bukti_002.jpg', '2025-06-12 15:00:00', 'Lunas'),
(3,  'OVO',           'bukti_003.jpg', '2025-07-03 10:00:00', 'Lunas'),
(4,  'GoPay',         'bukti_004.jpg', '2025-07-15 12:00:00', 'Lunas'),
(5,  'QRIS',          'bukti_005.jpg', '2025-07-22 16:00:00', 'Lunas'),
(6,  'Transfer Bank', 'bukti_006.jpg', '2025-08-02 09:00:00', 'Lunas'),
(7,  'DANA',          'bukti_007.jpg', '2025-08-08 14:00:00', 'Lunas'),
(8,  'OVO',           'bukti_008.jpg', '2025-08-14 17:00:00', 'Lunas'),
(9,  'Transfer Bank', NULL,            NULL,                  'Menunggu'),
(10, 'GoPay',         'bukti_010.jpg', '2025-08-25 13:00:00', 'Lunas'),
(11, 'QRIS',          'bukti_011.jpg', '2025-09-01 10:00:00', 'Lunas'),
(12, 'Transfer Bank', 'bukti_012.jpg', '2025-09-04 15:00:00', 'Lunas'),
(13, 'DANA',          'bukti_013.jpg', '2025-09-09 12:00:00', 'Lunas'),
(14, 'OVO',           'bukti_014.jpg', '2025-09-12 16:00:00', 'Lunas'),
(15, 'GoPay',         'bukti_015.jpg', '2025-09-15 09:00:00', 'Lunas'),
(16, 'Transfer Bank', NULL,            NULL,                  'Menunggu'),
(17, 'QRIS',          'bukti_017.jpg', '2025-09-20 11:00:00', 'Lunas'),
(18, 'Transfer Bank', 'bukti_018.jpg', '2025-09-22 14:00:00', 'Lunas'),
(19, 'DANA',          'bukti_019.jpg', NULL,                  'Ditolak'),
(20, 'DANA',          'bukti_020.jpg', '2025-09-28 17:00:00', 'Lunas');

-- ---------------- PENGIRIMAN (20) ------------------------------
INSERT INTO pengiriman (id_pesanan, ekspedisi, nomor_resi, status) VALUES
(1,  'JNE',            'JNE123456781', 'Diterima'),
(2,  'J&T',            'JNT123456782', 'Diterima'),
(3,  'Sicepat',        'SCP123456783', 'Diterima'),
(4,  'JNE',            'JNE123456784', 'Dikirim'),
(5,  'Pos Indonesia',  'POS123456785', 'Diterima'),
(6,  'J&T',            'JNT123456786', 'Dikemas'),
(7,  'Sicepat',        'SCP123456787', 'Dikirim'),
(8,  'Ninja Express',  'NIN123456788', 'Diterima'),
(9,  'JNE',            NULL,           'Dikemas'),
(10, 'J&T',            'JNT123456790', 'Dikirim'),
(11, 'Sicepat',        'SCP123456791', 'Diterima'),
(12, 'JNE',            NULL,           'Dikemas'),
(13, 'Pos Indonesia',  'POS123456793', 'Diterima'),
(14, 'J&T',            'JNT123456794', 'Dikirim'),
(15, 'Ninja Express',  'NIN123456795', 'Diterima'),
(16, 'JNE',            NULL,           'Dikemas'),
(17, 'Sicepat',        NULL,           'Dikemas'),
(18, 'J&T',            'JNT123456798', 'Diterima'),
(19, 'JNE',            NULL,           'Gagal'),
(20, 'Pos Indonesia',  'POS123456800', 'Dikirim');

-- ---------------- REVIEW (20) -----------------------------------
INSERT INTO review (id_user, id_obat, rating, komentar, tanggal) VALUES
(3,  1,  5, 'Obatnya manjur, demam langsung turun.',     '2025-06-06 10:00:00'),
(4,  4,  4, 'Sembut embuh setelah minum ini.',           '2025-06-13 09:00:00'),
(5,  3,  5, 'Sangat membantu untuk jantung.',            '2025-07-04 11:00:00'),
(6,  9,  5, 'Vitaminnya bagus dan original.',            '2025-07-16 13:00:00'),
(7,  19, 4, 'Antiseptiknya wangi dan ampuh.',            '2025-07-23 15:00:00'),
(8,  12, 5, 'Anak saya cepat sembuh batuknya.',          '2025-08-15 10:00:00'),
(2,  29, 4, 'Rutin minum gula darah stabil.',            '2025-08-20 12:00:00'),
(11, 34, 5, 'Tensimeter akurat dan mudah dipakai.',      '2025-08-26 14:00:00'),
(3,  8,  5, 'Day tahan tubuh jadi lebih kuat.',          '2025-09-02 09:00:00'),
(4,  20, 3, 'Lumayan, tapi agak lengket.',               '2025-09-05 16:00:00'),
(5,  6,  5, 'Infeksi tenggorokan cepat reda.',           '2025-09-10 10:00:00'),
(6,  22, 4, 'Mual saya langsung hilang.',                '2025-09-13 11:00:00'),
(7,  10, 5, 'Multivitamin nyaman di perut.',             '2025-09-16 08:00:00'),
(8,  43, 5, 'Insulin berkualitas untuk diabetes.',       '2025-09-21 13:00:00'),
(9,  7,  4, 'Efeknya cepat, recommended.',               '2025-09-22 15:00:00'),
(10, 27, 5, 'Tekanan darah jadi normal.',                '2025-09-23 09:00:00'),
(11, 32, 4, 'Termometer praktis dan cepat.',             '2025-09-26 10:00:00'),
(2,  38, 5, 'Badan jadi lebih fit.',                     '2025-09-29 12:00:00'),
(3,  16, 4, 'Alergi kulit saya reda.',                   '2025-06-08 10:00:00'),
(5,  47, 5, 'Kulit jadi lebih sehat.',                   '2025-07-05 14:00:00');

-- ---------------- NOTIFIKASI ------------------------------------
INSERT INTO notifikasi (id_user, judul, isi, status, created_at) VALUES
(3,  'Pesanan Dikirim',   'Pesanan PSN-20250605-001 telah kami kirim.', 'dibaca',    '2025-06-06 09:00:00'),
(4,  'Pesanan Selesai',   'Terima kasih, pesanan Anda telah selesai.',  'dibaca',    '2025-06-14 09:00:00'),
(6,  'Pesanan Dikirim',   'Pesanan PSN-20250715-004 sedang dikirim.',   'belum dibaca', '2025-07-16 09:00:00'),
(8,  'Pembayaran Diterima', 'Pembayaran pesanan PSN-20250814-008 lunas.','belum dibaca', '2025-08-15 09:00:00'),
(2,  'Menunggu Pembayaran', 'Segera lakukan pembayaran PSN-20250819-009.', 'belum dibaca', '2025-08-19 10:05:00'),
(11, 'Pesanan Dibatalkan', 'Pesanan PSN-20250925-019 dibatalkan.',       'belum dibaca', '2025-09-25 09:05:00'),
(2,  'Pesanan Dikirim',   'Pesanan PSN-20250928-020 sedang dikirim.',    'belum dibaca', '2025-09-29 09:00:00');

-- ============================================================
--  SEED KLINIK (MediKita)
-- ============================================================

-- ---------------- KOTA (5) ----------------------------------
INSERT INTO kota (id_kota, nama_kota) VALUES
(1, 'Jakarta'), (2, 'Bandung'), (3, 'Surabaya'), (4, 'Yogyakarta'), (5, 'Medan');

-- ---------------- SPESIALIS (6) -----------------------------
INSERT INTO spesialis (id_spesialis, nama_spesialis, deskripsi) VALUES
(1, 'Umum',             'Dokter umum untuk konsultasi umum'),
(2, 'Anak',             'Spesialis kesehatan anak'),
(3, 'Penyakit Dalam',   'Spesialis penyakit dalam'),
(4, 'Gigi',             'Spesialis gigi dan mulut'),
(5, 'Kulit & Kelamin',  'Spesialis kulit'),
(6, 'Mata',             'Spesialis mata');

-- ---------------- KLINIK (6) --------------------------------
INSERT INTO klinik (id_klinik, id_kota, nama_klinik, alamat, no_telp, email) VALUES
(1, 1, 'Klinik Sehat Menteng',   'Jl. MH Thamrin No. 10, Jakarta',   '021-111001', 'menteng@mydkita.com'),
(2, 2, 'Klinik Sehat Dago',      'Jl. Dago No. 25, Bandung',         '022-111002', 'dago@mydkita.com'),
(3, 3, 'Klinik Bunda Puspa',     'Jl. Pemuda No. 8, Surabaya',       '031-111003', 'puspa@mydkita.com'),
(4, 4, 'Klinik Medika Jogja',    'Jl. Malioboro No. 12, Yogyakarta', '0274-111004','jogja@mydkita.com'),
(5, 5, 'Klinik Prima Medan',     'Jl. Sudirman No. 30, Medan',       '061-111005', 'medan@mydkita.com'),
(6, 1, 'Klinik Sehat Cilandak',  'Jl. Cilandak Raya No. 5, Jakarta', '021-111006', 'cilandak@mydkita.com');

-- ---------------- DOKTER (10) -------------------------------
INSERT INTO dokter (id_dokter, id_spesialis, nama_dokter, gender, no_hp, email, str_no, biaya_konsultasi, foto) VALUES
(1,  1, 'Dr. Andi Wijaya',      'Laki-laki',   '081200000001', 'andi@mydkita.com',     'STR001', 50000,  ''),
(2,  2, 'Dr. Sinta Dewi',       'Perempuan',   '081200000002', 'sinta@mydkita.com',    'STR002', 75000,  ''),
(3,  3, 'Dr. Budi Santoso',     'Laki-laki',   '081200000003', 'budi@mydkita.com',     'STR003', 100000, ''),
(4,  4, 'Dr. Rina Marlina',     'Perempuan',   '081200000004', 'rina@mydkita.com',     'STR004', 120000, ''),
(5,  5, 'Dr. Eko Prasetyo',     'Laki-laki',   '081200000005', 'eko@mydkita.com',      'STR005', 90000,  ''),
(6,  6, 'Dr. Maya Sari',        'Perempuan',   '081200000006', 'maya@mydkita.com',     'STR006', 110000, ''),
(7,  1, 'Dr. Joko Susilo',      'Laki-laki',   '081200000007', 'joko@mydkita.com',     'STR007', 55000,  ''),
(8,  3, 'Dr. Dewi Anggraini',   'Perempuan',   '081200000008', 'dewi@mydkita.com',     'STR008', 105000, ''),
(9,  4, 'Dr. Farid Nur',        'Laki-laki',   '081200000009', 'farid@mydkita.com',    'STR009', 115000, ''),
(10, 2, 'Dr. Hana Putri',       'Perempuan',   '081200000010', 'hana@mydkita.com',     'STR010', 80000,  '');

-- ---------------- DOKTER_KLINIK (m:n) ----------------------
INSERT INTO dokter_klinik (id_dokter, id_klinik) VALUES
(1,1),(1,6),(2,2),(3,3),(3,1),(4,4),(5,5),(6,1),(6,6),(7,6),(8,3),(8,1),(9,4),(9,5),(10,2),(10,6);

-- ---------------- JADWAL_PRAKTIK ---------------------------
INSERT INTO jadwal_praktik (id_dokter, id_klinik, hari, jam_mulai, jam_selesai, kuota) VALUES
(1,1,'Senin','08:00:00','12:00:00',10),
(1,6,'Rabu','13:00:00','17:00:00',10),
(2,2,'Selasa','09:00:00','13:00:00',8),
(3,3,'Senin','08:00:00','14:00:00',12),
(3,1,'Kamis','15:00:00','19:00:00',10),
(4,4,'Rabu','10:00:00','15:00:00',6),
(5,5,'Jumat','08:00:00','12:00:00',8),
(6,1,'Selasa','13:00:00','17:00:00',8),
(6,6,'Sabtu','09:00:00','12:00:00',5),
(7,6,'Senin','08:00:00','12:00:00',10),
(8,3,'Rabu','09:00:00','13:00:00',8),
(9,4,'Kamis','13:00:00','17:00:00',6),
(10,2,'Jumat','09:00:00','14:00:00',8),
(10,6,'Sabtu','13:00:00','16:00:00',6);

-- ---------------- BOOKING (12) -----------------------------
INSERT INTO booking (kode_booking, id_user, id_dokter, id_klinik, id_jadwal, tanggal_booking, keluhan, status, created_at) VALUES
('BK-20250805-001', 3,  1, 1, 1, '2025-08-05', 'Demam dan batuk',                 'Selesai',    '2025-08-04 09:00:00'),
('BK-20250812-002', 4,  2, 2, 3, '2025-08-12', 'Anak sering batuk pilek',         'Selesai',    '2025-08-11 10:00:00'),
('BK-20250820-003', 5,  3, 3, 4, '2025-08-20', 'Nyeri ulu hati',                  'Selesai',    '2025-08-19 11:00:00'),
('BK-20250901-004', 6,  4, 4, 6, '2025-09-01', 'Gigi berlubang',                  'Selesai',    '2025-08-31 08:00:00'),
('BK-20250905-005', 7,  5, 5, 7, '2025-09-05', 'Ruam di kulit',                   'Selesai',    '2025-09-04 09:00:00'),
('BK-20250910-006', 8,  6, 1, 8, '2025-09-10', 'Mata berkunang-kunang',           'Selesai',    '2025-09-09 10:00:00'),
('BK-20250915-007', 9,  7, 6, 10,'2025-09-15', 'Kontrol rutin',                   'Menunggu',  '2025-09-14 08:00:00'),
('BK-20250918-008', 10, 8, 3, 11,'2025-09-18', 'Tensi tinggi',                    'Menunggu',  '2025-09-17 09:00:00'),
('BK-20250922-009', 2,  9, 4, 12,'2025-09-22', 'Pemeriksaan gigi',                'Menunggu',  '2025-09-21 10:00:00'),
('BK-20250925-010', 11,10, 2, 13,'2025-09-25', 'Imunisasi anak',                  'Dibatalkan', '2025-09-24 08:00:00'),
('BK-20250928-011', 3,  1, 6, 2, '2025-09-28', 'Konsultasi umum',                 'Menunggu',  '2025-09-27 09:00:00'),
('BK-20250930-012', 5,  3, 1, 5, '2025-09-30', 'Cek kolesterol',                  'Menunggu',  '2025-09-29 10:00:00');

-- ============================================================
--  SEED APOTEK (Apotek Sehat)
-- ============================================================

INSERT INTO apotek (id_apotek, nama_apotek, alamat, no_telp, email) VALUES
(1, 'Apotek Sehat Cabang Utama',   'Jl. Sudirman No. 10, Jakarta',  '021-555100', 'cabang1@apoteksehat.id'),
(2, 'Apotek Sehat Cabang Bandung', 'Jl. Dago No. 25, Bandung',      '022-555200', 'cabang2@apoteksehat.id');

INSERT INTO harga_stok_apotek (id_apotek, id_obat, harga, stok) VALUES
(1, 1, 3500,  120), (2, 1, 3600,   80),
(1, 2, 5200,   90), (2, 2, 5300,   60),
(1, 4, 8500,   60), (2, 4, 8600,   40);
