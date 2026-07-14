<?php
require_once '../config/koneksi.php';

$page_title = 'Register';
if (is_logged_in()) redirect(BASE_URL . 'user/');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid()) { $error = 'Token keamanan tidak valid.'; }
    else {
        $nama   = clean($_POST['nama']);
        $email  = clean($_POST['email']);
        $hp     = clean($_POST['no_hp']);
        $alamat = clean($_POST['alamat']);
        $pass   = $_POST['password'];
        $pass2  = $_POST['password2'];

        if (strlen($nama) < 3) $error = 'Nama minimal 3 karakter.';
        elseif (!valid_email($email)) $error = 'Format email tidak valid.';
        elseif (strlen($pass) < 6) $error = 'Password minimal 6 karakter.';
        elseif ($pass !== $pass2) $error = 'Konfirmasi password tidak cocok.';
        else {
            $cek = $pdo->prepare("SELECT id_user FROM users WHERE email=?");
            $cek->execute([$email]);
            if ($cek->fetch()) $error = 'Email sudah terdaftar.';
            else {
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (nama,email,password,no_hp,alamat,role,created_at) VALUES (?,?,?,?,?,'customer',NOW())");
                $stmt->execute([$nama, $email, $hash, $hp, $alamat]);
                set_flash('success', 'Pendaftaran berhasil, silakan login.');
                redirect(BASE_URL . 'auth/login.php');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Apotek Sehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="auth-wrap">
    <div class="auth-card">
        <div class="head">
            <img src="<?= BASE_URL ?>assets/images/logo.svg" width="48"><br>
            <h4 class="mt-2 mb-0">Daftar Akun</h4>
            <small>Buat akun customer Apotek Sehat</small>
        </div>
        <div class="body">
            <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
            <form method="post" novalidate>
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required value="<?= e($_POST['nama'] ?? '') ?>" placeholder="Nama lengkap">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required value="<?= e($_POST['email'] ?? '') ?>" placeholder="email@mail.com">
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" class="form-control" value="<?= e($_POST['no_hp'] ?? '') ?>" placeholder="0812...">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="Min 6 karakter">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password2" class="form-control" required placeholder="Ulangi password">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap"><?= e($_POST['alamat'] ?? '') ?></textarea>
                </div>
                <button class="btn btn-primary w-100 py-2"><i class="fas fa-user-plus me-1"></i> Daftar</button>
            </form>
        </div>
        <div class="foot">Sudah punya akun? <a href="<?= BASE_URL ?>auth/login.php">Login di sini</a></div>
    </div>
</div>
</body>
</html>
