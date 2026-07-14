<?php
require_once '../../config/koneksi.php';
require_login();
if (is_admin()) redirect(BASE_URL . 'admin/');
$page_title = 'Daftar Obat';
$active = 'obat';

$kats = $pdo->query("SELECT * FROM kategori_obat ORDER BY nama_kategori")->fetchAll();
$produk = $pdo->query("SELECT o.*, k.nama_kategori FROM obat o LEFT JOIN kategori_obat k ON k.id_kategori=o.id_kategori ORDER BY o.nama_obat")->fetchAll();

function img_u($g) { return $g ? URL_OBAT . e($g) : BASE_URL . 'assets/images/no-image.svg'; }
require_once '../../includes/header_user.php';
?>
<div class="row mb-3">
    <div class="col-md-3 mb-2">
        <select id="filterKategori" class="form-select">
            <option value="">Semua Kategori</option>
            <?php foreach ($kats as $k): ?><option value="<?= $k['id_kategori'] ?>"><?= e($k['nama_kategori']) ?></option><?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3 mb-2">
        <input type="number" id="filterHargaMin" class="form-control" placeholder="Harga min (Rp)" min="0">
    </div>
    <div class="col-md-3 mb-2">
        <input type="number" id="filterHargaMax" class="form-control" placeholder="Harga max (Rp)" min="0">
    </div>
    <div class="col-md-3 mb-2">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="liveSearch" class="form-control" placeholder="Cari nama obat...">
        </div>
    </div>
</div>
<div class="product-grid" id="produkGrid">
    <?php foreach ($produk as $o): ?>
    <div class="product-card">
        <div class="img"><img src="<?= img_u($o['gambar']) ?>" onerror="this.src='<?= BASE_URL ?>assets/images/no-image.svg'" alt=""></div>
        <div class="body">
            <div class="name"><?= e($o['nama_obat']) ?></div>
            <div class="cat"><?= e($o['nama_kategori']) ?></div>
            <div class="price"><?= rupiah($o['harga']) ?></div>
            <div class="foot">
                <a href="<?= BASE_URL ?>user/obat/detail.php?id=<?= $o['id_obat'] ?>" class="btn btn-sm btn-outline-primary flex-grow-1">Detail</a>
                <?php if ($o['stok'] > 0): ?>
                <button class="btn btn-sm btn-primary" onclick="addToCart(<?= $o['id_obat'] ?>)"><i class="fas fa-cart-plus"></i></button>
                <?php else: ?><span class="btn btn-sm btn-secondary disabled">Habis</span><?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php require_once '../../includes/footer_user.php'; ?>
