<?php
require_once '../../config/koneksi.php';
require_login();
if (is_admin()) redirect(BASE_URL . 'admin/');
$page_title = 'Profil Saya';
$active = 'dashboard';
$uid = $_SESSION['user']['id_user'];

$user = $pdo->prepare("SELECT id_user, nama, email, password, COALESCE(no_hp, '') AS no_hp, COALESCE(alamat, '') AS alamat, role, created_at FROM users WHERE id_user=?");
$user->execute([$uid]); $user = $user->fetch();
if (!$user) {
    set_flash('error', 'Profil pengguna tidak ditemukan.');
    redirect(BASE_URL . 'auth/logout.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid()) { set_flash('error', 'Token tidak valid.'); redirect(''); }
    if (isset($_POST['update_profil'])) {
        $nama = clean($_POST['nama'] ?? '');
        $email = clean($_POST['email'] ?? '');
        $hp = clean($_POST['no_hp'] ?? '');
        $alamat = clean($_POST['alamat'] ?? '');
        if (!valid_email($email)) { set_flash('error', 'Email tidak valid.'); redirect(''); }
        $cek = $pdo->prepare("SELECT id_user FROM users WHERE email=? AND id_user!=?");
        $cek->execute([$email, $uid]);
        if ($cek->fetch()) { set_flash('error', 'Email sudah dipakai.'); redirect(''); }
        $pdo->prepare("UPDATE users SET nama=?, email=?, no_hp=?, alamat=? WHERE id_user=?")->execute([$nama, $email, $hp, $alamat, $uid]);
        $_SESSION['user']['nama'] = $nama;
        $_SESSION['user']['email'] = $email;
        set_flash('success', 'Profil diperbarui.');
    }
    if (isset($_POST['ganti_pass'])) {
        $old = $_POST['old_password'];
        $new = $_POST['new_password'];
        $new2 = $_POST['new_password2'];
        if (!password_verify($old, $user['password'] ?? '')) { set_flash('error', 'Password lama salah.'); redirect(''); }
        if (strlen($new) < 6) { set_flash('error', 'Password baru minimal 6 karakter.'); redirect(''); }
        if ($new !== $new2) { set_flash('error', 'Konfirmasi tidak cocok.'); redirect(''); }
        $pdo->prepare("UPDATE users SET password=? WHERE id_user=?")->execute([password_hash($new, PASSWORD_DEFAULT), $uid]);
        set_flash('success', 'Password diubah.');
    }
    redirect('');
}

require_once '../../includes/header_user.php';
?>
<div class="row g-3">
    <div class="col-lg-5">
        <div class="card text-center">
            <div class="card-body">
                <div class="avatar mx-auto" style="width:80px;height:80px;font-size:32px"><?= strtoupper(substr($user['nama'],0,1)) ?></div>
                <h5 class="mt-2 mb-0"><?= e($user['nama']) ?></h5>
                <span class="badge bg-primary"><?= e($user['role']) ?></span>
                <hr>
                <p class="mb-1 small"><i class="fas fa-envelope me-2"></i><?= e($user['email'] ?? '') ?></p>
                <p class="mb-1 small"><i class="fas fa-phone me-2"></i><?= e($user['no_hp'] ?? '') ?></p>
                <p class="mb-0 small"><i class="fas fa-location-dot me-2"></i><?= e($user['alamat'] ?? '') ?></p>
                <p class="mt-2 small text-muted">Bergabung: <?= tgl_indo($user['created_at'] ?? '') ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">Edit Profil</div>
            <div class="card-body">
                <form method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="nama" class="form-control" value="<?= e($user['nama'] ?? '') ?>" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= e($user['email'] ?? '') ?>" required></div>
                    <div class="mb-3"><label class="form-label">No. HP</label><input type="text" name="no_hp" class="form-control" value="<?= e($user['no_hp'] ?? '') ?>"></div>
                    <div class="mb-3"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control" rows="2"><?= e($user['alamat'] ?? '') ?></textarea></div>
                    <button class="btn btn-primary" name="update_profil">Simpan Profil</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Ganti Password</div>
            <div class="card-body">
                <form method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3"><label class="form-label">Password Lama</label><input type="password" name="old_password" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Password Baru</label><input type="password" name="new_password" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Konfirmasi Password Baru</label><input type="password" name="new_password2" class="form-control" required></div>
                    <button class="btn btn-warning" name="ganti_pass">Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once '../../includes/footer_user.php'; ?>
