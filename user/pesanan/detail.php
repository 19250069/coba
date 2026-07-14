<?php
require_once '../../config/koneksi.php';
require_login();
if (is_admin()) redirect(BASE_URL . 'admin/');
$page_title = 'Detail Pesanan';
$active = 'pesanan';
$uid = $_SESSION['user']['id_user'];

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM pesanan WHERE id_pesanan=? AND id_user=?");
$stmt->execute([$id, $uid]);
$pes = $stmt->fetch();
if (!$pes) { set_flash('error', 'Pesanan tidak ditemukan.'); redirect(BASE_URL . 'user/pesanan/'); }

$items = $pdo->prepare("SELECT d.*, o.nama_obat, o.gambar FROM detail_pesanan d JOIN obat o ON o.id_obat=d.id_obat WHERE d.id_pesanan=?");
$items->execute([$id]);

$pay = $pdo->prepare("SELECT * FROM pembayaran WHERE id_pesanan=?");
$pay->execute([$id]); $pay = $pay->fetch();

$ship = $pdo->prepare("SELECT * FROM pengiriman WHERE id_pesanan=?");
$ship->execute([$id]); $ship = $ship->fetch();

/* Upload bukti */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_bukti'])) {
    if (!csrf_valid()) { set_flash('error', 'Token tidak valid.'); redirect(''); }
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] === UPLOAD_ERR_OK) {
        $up = upload_file($_FILES['bukti'], UPLOAD_BUKTI);
        if ($up['success']) {
            $pdo->prepare("UPDATE pembayaran SET bukti_transfer=?, tanggal_bayar=NOW(), status='Menunggu' WHERE id_pesanan=?")->execute([$up['file'], $id]);
            set_flash('success', 'Bukti transfer diunggah, menunggu verifikasi.');
        } else {
            set_flash('error', $up['msg']);
        }
    } else {
        set_flash('error', 'Pilih file bukti transfer.');
    }
    redirect('');
}

function img_u($g) { return $g ? URL_OBAT . e($g) : BASE_URL . 'assets/images/no-image.svg'; }
$qr = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($pes['kode_pesanan']);
require_once '../../includes/header_user.php';
?>
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between"><span><i class="fas fa-receipt me-2"></i><?= e($pes['kode_pesanan']) ?></span> <?= status_badge($pes['status']) ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>Obat</th><th>Harga</th><th>Jumlah</th><th class="text-end">Subtotal</th></tr></thead>
                        <tbody>
                        <?php foreach ($items as $it): ?>
                            <tr>
                                <td><?= e($it['nama_obat']) ?></td>
                                <td><?= rupiah($it['harga']) ?></td>
                                <td><?= $it['jumlah'] ?></td>
                                <td class="text-end"><?= rupiah($it['subtotal']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot><tr><th colspan="3" class="text-end">Total</th><th class="text-end"><?= rupiah($pes['total']) ?></th></tr></tfoot>
                    </table>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= BASE_URL ?>user/review/?id_pesanan=<?= $pes['id_pesanan'] ?>" class="btn btn-outline-primary btn-sm">Beri Review</a>
                    <?php if ($ship): ?><a href="<?= BASE_URL ?>user/tracking/?kode=<?= e($pes['kode_pesanan']) ?>" class="btn btn-outline-info btn-sm">Tracking</a><?php endif; ?>
                    <?php if ($pes['status'] === 'Menunggu Pembayaran'): ?><button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalBukti"><i class="fas fa-upload me-1"></i> Upload Bukti</button><?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($ship): ?>
        <div class="card">
            <div class="card-header">Info Pengiriman</div>
            <div class="card-body">
                <p>Ekspedisi: <strong><?= e($ship['ekspedisi'] ?? '-') ?></strong></p>
                <p>No. Resi: <strong><?= e($ship['nomor_resi'] ?? '-') ?></strong></p>
                <p>Status: <?= status_badge($ship['status']) ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-4">
        <div class="card text-center sticky-summary">
            <div class="card-header">QR Code Pesanan</div>
            <div class="card-body">
                <img src="<?= $qr ?>" width="160" onerror="this.src='<?= BASE_URL ?>assets/images/no-image.svg'">
                <p class="small text-muted mt-2"><?= e($pes['kode_pesanan']) ?></p>
            </div>
        </div>
        <?php if ($pes['status'] === 'Menunggu Pembayaran'): ?>
        <div class="card border-success">
            <div class="card-header bg-success text-white">Pembayaran</div>
            <div class="card-body">
                <p>Metode: <strong><?= e($pay['metode'] ?? '-') ?></strong></p>
                <p>Status: <?= status_badge($pay['status']) ?></p>
                <?php if (!empty($pay['id_metode'])): ?>
                <?php $dest = $pdo->prepare("SELECT * FROM metode_pembayaran WHERE id_metode=?"); $dest->execute([$pay['id_metode']]); $dest = $dest->fetch(); ?>
                <?php if ($dest): ?>
                <div class="alert alert-warning small mb-2">
                    <strong>Instruksi Pembayaran:</strong><br>
                    <?= e($dest['tipe']==='bank' ? 'Transfer ke rekening Bank ' . e($dest['nama_metode']) : 'Bayar via ' . e($dest['nama_metode'])) ?>:<br>
                    <strong><?= e($dest['nomor']) ?></strong> a.n. <strong><?= e($dest['pemilik']) ?></strong><br>
                    Total yang harus dibayar: <strong><?= rupiah($pes['total']) ?></strong>
                </div>
                <?php endif; ?>
                <?php else: ?>
                <p class="small text-muted">Transfer sesuai metode pembayaran yang dipilih untuk menyelesaikan pesanan.</p>
                <?php endif; ?>
                <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modalBukti"><i class="fas fa-upload me-1"></i> Upload Bukti</button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="modalBukti" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header"><h6 class="modal-title">Upload Bukti Transfer</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-2"><label class="form-label">Pilih Gambar Bukti</label>
                    <input type="file" name="bukti" class="form-control" accept="image/*" required></div>
                <?php if ($pay && $pay['bukti_transfer']): ?>
                <p class="small">Bukti saat ini:</p>
                <img src="<?= URL_BUKTI . e($pay['bukti_transfer']) ?>" class="img-fluid rounded" onerror="this.src='<?= BASE_URL ?>assets/images/no-image.svg'">
                <?php endif; ?>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success" name="upload_bukti"><i class="fas fa-upload me-1"></i> Kirim</button></div>
        </form>
    </div>
</div>
<?php require_once '../../includes/footer_user.php'; ?>
