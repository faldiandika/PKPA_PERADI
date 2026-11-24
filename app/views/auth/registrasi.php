<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi - PKPA Peradi</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?= filemtime(__DIR__ . '/../../../public/css/style.css') ?>">
</head>
<body class="login-page registrasi-page">
<div class="auth-wrap">

    <aside class="auth-panel">
        <div class="auth-ikon">⚖️</div>
        <h2>Pendaftaran PKPA Online</h2>
        <p>Pendidikan Khusus Profesi Advokat<br>DPC PERADI FBI Kota Palu</p>
        <ul>
            <li>Buat akun, lalu lengkapi biodata dan pas foto</li>
            <li>Ajukan pendaftaran pada periode yang dibuka</li>
            <li>Pantau status verifikasi dari akun Anda</li>
        </ul>
    </aside>

    <form class="login-box" method="post" action="index.php?c=auth&a=registrasi">
        <h1>Registrasi Peserta</h1>
        <p class="sub">PKPA DPC PERADI FBI Kota Palu</p>
        <?php if ($error): ?><p class="alert err"><?= e($error) ?></p><?php endif; ?>
        <?= csrf_field() ?>
        <label>Nama</label>
        <input type="text" name="nama" value="<?= e($nama) ?>" required autofocus>
        <label>Email</label>
        <input type="email" name="email" value="<?= e($email) ?>" required>
        <label>Password</label>
        <div class="pw">
            <input type="password" name="password" id="pw1" required>
            <button type="button" class="pw-toggle" onclick="var i=document.getElementById('pw1');var s=i.type==='password';i.type=s?'text':'password';this.textContent=s?'Sembunyikan':'Tampilkan';">Tampilkan</button>
        </div>
        <label>Konfirmasi Password</label>
        <div class="pw">
            <input type="password" name="konfirmasi" id="pw2" required>
            <button type="button" class="pw-toggle" onclick="var i=document.getElementById('pw2');var s=i.type==='password';i.type=s?'text':'password';this.textContent=s?'Sembunyikan':'Tampilkan';">Tampilkan</button>
        </div>
        <button class="btn" type="submit">Daftar</button>
        <p class="tautan">Sudah punya akun? <a href="index.php?c=auth&a=login">Login</a></p>
        <p class="tautan"><a href="index.php">&laquo; Kembali ke beranda</a></p>
    </form>

</div>
</body>
</html>