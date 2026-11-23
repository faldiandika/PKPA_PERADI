<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - PKPA Peradi</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?= filemtime(__DIR__ . '/../../../public/css/style.css') ?>">
</head>
<body class="login-page">
<form class="login-box" method="post" action="index.php?c=auth&a=login">
    <img class="logo" src="public/img/" alt="PERADI" onerror="this.style.display='none'">
    <h1>Login</h1>
    <p class="sub">PKPA DPC PERADI Kota Palu</p>
    <?php if ($pesan = flash()): ?><p class="alert <?= e($pesan['tipe']) ?>"><?= e($pesan['pesan']) ?></p><?php endif; ?>
    <?php if ($error): ?><p class="alert err"><?= e($error) ?></p><?php endif; ?>
    <?= csrf_field() ?>
    <label>Email</label>
    <input type="email" name="email" required autofocus>
    <label>Password</label>
    <input type="password" name="password" required>
    <button class="btn" type="submit">Masuk</button>
    <p class="tautan">Belum punya akun? <a href="index.php?c=auth&a=registrasi">Daftar</a></p>
    <p class="tautan"><a href="index.php">&laquo; Kembali ke beranda</a></p>
</form>
</body>
</html>